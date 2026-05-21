<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\CounselorSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class CounselorAppointmentController extends Controller
{
    // ─── List Appointments ───────────────────────────────────────
    public function index(Request $request)
    {
        $appointments = Appointment::where('counselor_id', Auth::id())
            ->with('student.studentProfile')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->orderBy('preferred_date')
            ->orderBy('preferred_time')
            ->paginate(15);

        return view('CounselConnect.counselor.appointments.index', compact('appointments'));
    }

    // ─── Show Invite Form ────────────────────────────────────────
    // Counselor picks a student, date, time, and concern type
    public function create()
    {
        // Load all active students
        $students = User::where('role', 'student')
            ->where('is_active', true)
            ->with('studentProfile')
            ->orderBy('name')
            ->get();

        // Load this counselor's active schedule slots
        $scheduleSlots = CounselorSchedule::where('counselor_id', Auth::id())
            ->where('is_active', true)
            ->orderByRaw("FIELD(day_of_week,'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')")
            ->orderBy('start_time')
            ->get();

        return view('CounselConnect.counselor.appointments.invite', compact('students', 'scheduleSlots'));
    }

    // ─── Store Counselor-Initiated Invite ────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id'     => ['required', 'exists:users,id'],
            'concern_type'   => ['required', 'in:Academic,Personal,Career,Mental Health,Other'],
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
            'preferred_time' => ['required', 'date_format:H:i'],
            'notes'          => ['nullable', 'string', 'max:1000'],
        ]);

        $date      = Carbon::parse($data['preferred_date']);
        $dayOfWeek = $date->format('l');
        $time      = Carbon::createFromFormat('H:i', $data['preferred_time']);

        // ── Must fall within counselor's own active schedule slot ──
        $schedule = CounselorSchedule::where('counselor_id', Auth::id())
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->get()
            ->first(function ($slot) use ($time) {
                $start = Carbon::createFromFormat('H:i:s', $slot->start_time);
                $end   = Carbon::createFromFormat('H:i:s', $slot->end_time);
                return $time->gte($start) && $time->lt($end);
            });

        if (! $schedule) {
            throw ValidationException::withMessages([
                'preferred_time' => 'The selected date & time does not fall within any of your active schedule slots.',
            ]);
        }

        // ── Check counselor slot isn't already booked ──
        $slotTaken = Appointment::where('counselor_id', Auth::id())
            ->where('preferred_date', $data['preferred_date'])
            ->where('preferred_time', $data['preferred_time'])
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($slotTaken) {
            throw ValidationException::withMessages([
                'preferred_time' => 'You already have an appointment booked at this time slot.',
            ]);
        }

        // ── Prevent duplicate active appointment with same student ──
        $existing = Appointment::where('counselor_id', Auth::id())
            ->where('student_id', $data['student_id'])
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($existing) {
            throw ValidationException::withMessages([
                'student_id' => 'This student already has an active appointment with you.',
            ]);
        }

        Appointment::create([
            'student_id'     => $data['student_id'],
            'counselor_id'   => Auth::id(),
            'schedule_id'    => $schedule->id,
            'concern_type'   => $data['concern_type'],
            'preferred_date' => $data['preferred_date'],
            'preferred_time' => $data['preferred_time'],
            'notes'          => $data['notes'] ?? null,
            'status'         => 'pending',
            'initiated_by'   => 'counselor',
            'invite_status'  => 'pending',
        ]);

        return redirect()->route('counselor.appointments.index')
            ->with('success', 'Invitation sent to student. Awaiting their response.');
    }

    // ─── Show Single Appointment ─────────────────────────────────
    public function show(Appointment $appointment)
    {
        $this->authorizeAppointment($appointment);

        $appointment->load(['student.studentProfile', 'schedule', 'sessionRecord']);

        $scheduleSlots = CounselorSchedule::where('counselor_id', Auth::id())
            ->where('is_active', true)
            ->orderByRaw("FIELD(day_of_week,'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')")
            ->orderBy('start_time')
            ->get();

        $preferredDate = Carbon::parse($appointment->preferred_date);
        $preferredTime = Carbon::parse($appointment->preferred_time);

        $canAcceptAsRequested = $scheduleSlots->contains(function ($slot) use ($preferredDate, $preferredTime) {
            if (strcasecmp($slot->day_of_week, $preferredDate->format('l')) !== 0) {
                return false;
            }
            $slotStart = Carbon::createFromFormat('H:i:s', $slot->start_time);
            $slotEnd   = Carbon::createFromFormat('H:i:s', $slot->end_time);
            return $preferredTime->gte($slotStart) && $preferredTime->lt($slotEnd);
        });

        return view('CounselConnect.counselor.appointments.show', compact(
            'appointment',
            'scheduleSlots',
            'canAcceptAsRequested'
        ));
    }

    // ─── Approve Appointment ─────────────────────────────────────
    public function approve(Request $request, Appointment $appointment)
    {
        $this->authorizeAppointment($appointment);

        abort_if(! $appointment->isPending(), 422, 'Only pending appointments can be approved.');

        // Counselor-initiated invites must be accepted by the student first
        abort_if(
            $appointment->isCounselorInitiated() && $appointment->invite_status !== 'accepted',
            422,
            'This invite has not been accepted by the student yet.'
        );

        $request->validate(['mode' => ['required', 'in:accept,propose']]);

        if ($request->mode === 'accept') {
            $preferredDate = Carbon::parse($appointment->preferred_date);
            $preferredTime = Carbon::parse($appointment->preferred_time);

            $validSlot = CounselorSchedule::where('counselor_id', Auth::id())
                ->where('is_active', true)
                ->get()
                ->first(function ($slot) use ($preferredDate, $preferredTime) {
                    if (strcasecmp($slot->day_of_week, $preferredDate->format('l')) !== 0) {
                        return false;
                    }
                    $slotStart = Carbon::createFromFormat('H:i:s', $slot->start_time);
                    $slotEnd   = Carbon::createFromFormat('H:i:s', $slot->end_time);
                    return $preferredTime->gte($slotStart) && $preferredTime->lt($slotEnd);
                });

            if (! $validSlot) {
                throw ValidationException::withMessages([
                    'mode' => "The student's preferred time no longer falls within your active schedule slots.",
                ]);
            }

            $scheduledAt = Carbon::parse(
                Carbon::parse($appointment->preferred_date)->format('Y-m-d') . ' ' .
                Carbon::parse($appointment->preferred_time)->format('H:i:s')
            );
        } else {
            $data = $request->validate([
                'proposed_date' => ['required', 'date', 'after_or_equal:today'],
                'proposed_time' => ['required', 'date_format:H:i'],
            ]);

            $proposedDate = Carbon::parse($data['proposed_date']);
            $proposedTime = Carbon::createFromFormat('H:i', $data['proposed_time']);

            $validSlot = CounselorSchedule::where('counselor_id', Auth::id())
                ->where('is_active', true)
                ->get()
                ->first(function ($slot) use ($proposedDate, $proposedTime) {
                    if (strcasecmp($slot->day_of_week, $proposedDate->format('l')) !== 0) {
                        return false;
                    }
                    $slotStart = Carbon::createFromFormat('H:i:s', $slot->start_time);
                    $slotEnd   = Carbon::createFromFormat('H:i:s', $slot->end_time);
                    return $proposedTime->gte($slotStart) && $proposedTime->lt($slotEnd);
                });

            if (! $validSlot) {
                throw ValidationException::withMessages([
                    'proposed_date' => 'The proposed date & time does not fall within any of your active schedule slots.',
                ]);
            }

            if ($validSlot->slot_duration_mins > 0) {
                $slotStart        = Carbon::createFromFormat('H:i:s', $validSlot->start_time);
                $minutesFromStart = $slotStart->diffInMinutes($proposedTime);
                if ($minutesFromStart % $validSlot->slot_duration_mins !== 0) {
                    throw ValidationException::withMessages([
                        'proposed_time' => "The time must align to a {$validSlot->slot_duration_mins}-minute boundary starting from {$slotStart->format('g:i A')}.",
                    ]);
                }
            }

            $scheduledAt = Carbon::parse($data['proposed_date'] . ' ' . $data['proposed_time']);
        }

        $appointment->update([
            'status'       => 'approved',
            'scheduled_at' => $scheduledAt,
        ]);

        return redirect()->route('counselor.appointments.show', $appointment)
            ->with('success', 'Appointment approved and scheduled for ' . $scheduledAt->format('F d, Y \a\t g:i A') . '.');
    }

    // ─── Reject Appointment ──────────────────────────────────────
    public function reject(Request $request, Appointment $appointment)
    {
        $this->authorizeAppointment($appointment);

        abort_if(! $appointment->isPending(), 422, 'Only pending appointments can be rejected.');

        $data = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ]);

        $appointment->update([
            'status'           => 'rejected',
            'rejection_reason' => $data['rejection_reason'],
        ]);

        return redirect()->route('counselor.appointments.show', $appointment)
            ->with('success', 'Appointment rejected.');
    }

    // ─── Mark as Completed ───────────────────────────────────────
    public function complete(Appointment $appointment)
    {
        $this->authorizeAppointment($appointment);

        abort_if(! $appointment->isApproved(), 422, 'Only approved appointments can be completed.');

        $appointment->update(['status' => 'completed']);

        return redirect()->route('counselor.sessions.create', ['appointment' => $appointment->id])
            ->with('success', 'Appointment marked as completed. Please fill in the session record.');
    }

    // ─── Guard: Only Own Appointments ────────────────────────────
    private function authorizeAppointment(Appointment $appointment): void
    {
        abort_if($appointment->counselor_id !== Auth::id(), 403);
    }
}