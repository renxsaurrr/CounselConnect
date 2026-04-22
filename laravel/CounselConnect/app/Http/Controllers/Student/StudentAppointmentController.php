<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\CounselorSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StudentAppointmentController extends Controller
{
    // ─── List Appointments ───────────────────────────────────────
    public function index(Request $request)
    {
        $appointments = Appointment::where('student_id', Auth::id())
            ->with('counselor.counselorProfile')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10);

        return view('CounselConnect.student.appointments.index', compact('appointments'));
    }

    // ─── Show Booking Form ───────────────────────────────────────
    public function create()
    {
        $counselors = User::where('role', 'counselor')
            ->where('is_active', true)
            ->with(['counselorProfile', 'schedules' => fn($q) => $q->active()])
            ->get();

        return view('CounselConnect.student.appointments.create', compact('counselors'));
    }

    // ─── Fetch Available Slots (AJAX) ────────────────────────────
    // Called when student selects a counselor + date on the booking form
    // Returns available time slots as JSON
    public function availableSlots(Request $request)
    {
        $request->validate([
            'counselor_id' => ['required', 'exists:users,id'],
            'date'         => ['required', 'date', 'after:today'],
        ]);

        $date      = Carbon::parse($request->date);
        $dayOfWeek = $date->format('l'); // e.g. "Monday"

        // Get counselor's schedule for that day
        $schedule = CounselorSchedule::where('counselor_id', $request->counselor_id)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->first();

        if (!$schedule) {
            return response()->json([
                'slots' => [],
                'message' => 'Counselor is not available on this day.',
            ]);
        }

        // Generate all possible slots for the day
        $slots = $this->generateSlots(
            $schedule->start_time,
            $schedule->end_time,
            $schedule->slot_duration_mins
        );

        // Get already booked times for that counselor on that date
        // (pending or approved — both block the slot)
        $counselorBookedTimes = Appointment::where('counselor_id', $request->counselor_id)
            ->where('preferred_date', $date->toDateString())
            ->whereIn('status', ['pending', 'approved'])
            ->pluck('preferred_time')
            ->map(fn($t) => Carbon::parse($t)->format('H:i'))
            ->toArray();

        // Also block times the current student already has booked on this date (any counselor)
        $studentBookedTimes = Appointment::where('student_id', Auth::id())
            ->where('preferred_date', $date->toDateString())
            ->whereIn('status', ['pending', 'approved'])
            ->pluck('preferred_time')
            ->map(fn($t) => Carbon::parse($t)->format('H:i'))
            ->toArray();

        $allBlockedTimes = array_unique(array_merge($counselorBookedTimes, $studentBookedTimes));

        // Filter out booked slots
        $availableSlots = array_filter($slots, fn($slot) => !in_array($slot, $allBlockedTimes));

        return response()->json([
            'slots'       => array_values($availableSlots),
            'schedule_id' => $schedule->id,
        ]);
    }

    // ─── Book Appointment ────────────────────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'counselor_id'   => ['required', 'exists:users,id'],
            'schedule_id'    => ['nullable', 'exists:counselor_schedules,id'],
            'concern_type'   => ['required', 'in:Academic,Personal,Career,Mental Health,Other'],
            'preferred_date' => ['required', 'date', 'after:today'],
            'preferred_time' => ['required', 'date_format:H:i'],
            'notes'          => ['nullable', 'string', 'max:1000'],
        ]);

        // ── Double-check slot is still available at submission time ──
        // (guards against race condition where two students submit simultaneously)
        $slotTaken = Appointment::where('counselor_id', $data['counselor_id'])
            ->where('preferred_date', $data['preferred_date'])
            ->where('preferred_time', $data['preferred_time'])
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($slotTaken) {
            return back()->withErrors([
                'preferred_time' => 'Sorry, this time slot was just taken. Please choose another.',
            ])->withInput();
        }

        // ── Prevent student from booking the same date & time with any counselor ──
        $studentAlreadyBookedSameSlot = Appointment::where('student_id', Auth::id())
            ->where('preferred_date', $data['preferred_date'])
            ->where('preferred_time', $data['preferred_time'])
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($studentAlreadyBookedSameSlot) {
            return back()->withErrors([
                'preferred_time' => 'You already have an appointment booked at this date and time.',
            ])->withInput();
        }

        // ── Validate the chosen slot actually exists in counselor's schedule ──
        $date      = Carbon::parse($data['preferred_date']);
        $dayOfWeek = $date->format('l');

        $schedule = CounselorSchedule::where('counselor_id', $data['counselor_id'])
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->first();

        if (!$schedule) {
            return back()->withErrors([
                'preferred_date' => 'Counselor is not available on this day.',
            ])->withInput();
        }

        $validSlots = $this->generateSlots(
            $schedule->start_time,
            $schedule->end_time,
            $schedule->slot_duration_mins
        );

        if (!in_array($data['preferred_time'], $validSlots)) {
            return back()->withErrors([
                'preferred_time' => 'The selected time is not a valid slot for this counselor.',
            ])->withInput();
        }

        // ── Prevent duplicate active appointments with same counselor ──
        $existing = Appointment::where('student_id', Auth::id())
            ->where('counselor_id', $data['counselor_id'])
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($existing) {
            return back()->withErrors([
                'counselor_id' => 'You already have an active appointment with this counselor.',
            ])->withInput();
        }

        Appointment::create([
            ...$data,
            'schedule_id' => $schedule->id,
            'student_id'  => Auth::id(),
            'status'      => 'pending',
        ]);

        return redirect()->route('student.appointments.index')
            ->with('success', 'Appointment request submitted. Please wait for approval.');
    }

    // ─── Show Single Appointment ─────────────────────────────────
    public function show(Appointment $appointment)
    {
        $this->authorizeAppointment($appointment);
        $appointment->load(['counselor.counselorProfile', 'schedule', 'sessionRecord']);
        return view('CounselConnect.student.appointments.show', compact('appointment'));
    }

    // ─── Cancel Appointment ──────────────────────────────────────
    public function destroy(Appointment $appointment)
    {
        $this->authorizeAppointment($appointment);

        abort_if(
            !in_array($appointment->status, ['pending', 'approved']),
            422,
            'This appointment can no longer be cancelled.'
        );

        $appointment->update(['status' => 'cancelled']);

        return redirect()->route('student.appointments.index')
            ->with('success', 'Appointment cancelled.');
    }

    // Students cannot edit appointments directly
    public function edit(Appointment $appointment)  { abort(404); }
    public function update(Appointment $appointment){ abort(404); }

    // ─── Guard: Only Own Appointments ────────────────────────────
    private function authorizeAppointment(Appointment $appointment): void
    {
        abort_if($appointment->student_id !== Auth::id(), 403);
    }

    // ─── Slot Generator ──────────────────────────────────────────
    // Breaks a time range into slots of a given duration
    // e.g. 08:00 - 12:00 with 60 mins → ['08:00', '09:00', '10:00', '11:00']
    private function generateSlots(string $startTime, string $endTime, int $durationMins): array
    {
        $slots   = [];
        $current = Carbon::parse($startTime);
        $end     = Carbon::parse($endTime);

        while ($current->copy()->addMinutes($durationMins)->lte($end)) {
            $slots[] = $current->format('H:i');
            $current->addMinutes($durationMins);
        }

        return $slots;
    }
}