<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\CounselorSchedule;
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

    // ─── Show Single Appointment ─────────────────────────────────
    public function show(Appointment $appointment)
    {
        $this->authorizeAppointment($appointment);

        $appointment->load(['student.studentProfile', 'schedule', 'sessionRecord']);

        // Build available slots for the "Propose Different Time" picker
        $scheduleSlots = CounselorSchedule::where('counselor_id', Auth::id())
            ->where('is_active', true)
            ->orderByRaw("FIELD(day_of_week,'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')")
            ->orderBy('start_time')
            ->get();

        // Check if the student's preferred date+time falls within any of the counselor's slots
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
    // Handles two modes:
    //   mode = "accept"  → use the student's preferred_date + preferred_time
    //   mode = "propose" → counselor picks a date + time constrained to their own slots
    public function approve(Request $request, Appointment $appointment)
    {
        $this->authorizeAppointment($appointment);

        abort_if(! $appointment->isPending(), 422, 'Only pending appointments can be approved.');

        $request->validate(['mode' => ['required', 'in:accept,propose']]);

        if ($request->mode === 'accept') {
            // ── Accept as Requested ──────────────────────────────
            // Re-verify the preferred time still falls within an active slot
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
            // ── Propose a Different Time ─────────────────────────
            $data = $request->validate([
                'proposed_date' => ['required', 'date', 'after_or_equal:today'],
                'proposed_time' => ['required', 'date_format:H:i'],
            ]);

            $proposedDate = Carbon::parse($data['proposed_date']);
            $proposedTime = Carbon::createFromFormat('H:i', $data['proposed_time']);

            // Must fall within one of the counselor's own active schedule slots
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

            // Enforce slot boundary alignment if applicable
            if ($validSlot->slot_duration_mins > 0) {
                $slotStart       = Carbon::createFromFormat('H:i:s', $validSlot->start_time);
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

    // These are not applicable for counselors — students book appointments
    public function create() { abort(404); }
    public function store()  { abort(404); }
    public function edit()   { abort(404); }
    public function update() { abort(404); }
    public function destroy(){ abort(404); }

    // ─── Guard: Only Own Appointments ────────────────────────────
    private function authorizeAppointment(Appointment $appointment): void
    {
        abort_if($appointment->counselor_id !== Auth::id(), 403);
    }
}