<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\CounselorSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class AdminAppointmentController extends Controller
{
    // ─── List All Appointments ───────────────────────────────────
    public function index(Request $request)
    {
        $query = Appointment::with([
                'student.studentProfile',   // ← loads profile_picture for students
                'counselor.counselorProfile', // ← loads profile_picture for counselors
                'schedule',
            ])
            ->latest('preferred_date');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', fn ($q) => $q->where('name', 'like', "%{$search}%"));
        }

        $appointments = $query->paginate(15)->withQueryString();

        $stats = [
            'total'     => Appointment::count(),
            'pending'   => Appointment::where('status', 'pending')->count(),
            'approved'  => Appointment::where('status', 'approved')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
        ];

        return view('CounselConnect.admin.appointments.index', compact('appointments', 'stats'));
    }

    // ─── Show Single Appointment ─────────────────────────────────
    public function show(Appointment $appointment)
    {
        $appointment->load(['student.studentProfile', 'counselor.counselorProfile', 'schedule', 'sessionRecord']);

        return view('CounselConnect.admin.appointments.show', compact('appointment'));
    }

    // ─── Manual Booking — Show Form ──────────────────────────────
    public function create()
    {
        $students   = User::where('role', 'student')->where('is_active', true)->orderBy('name')->get();
        $counselors = User::where('role', 'counselor')->where('is_active', true)->orderBy('name')->get();

        return view('CounselConnect.admin.appointments.create', compact('students', 'counselors'));
    }

    // ─── Manual Booking — Store ──────────────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id'     => ['required', 'exists:users,id'],
            'counselor_id'   => ['required', 'exists:users,id'],
            'schedule_id'    => ['required', 'exists:counselor_schedules,id'],
            'concern_type'   => ['required', 'in:Academic,Personal,Career,Mental Health,Other'],
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
            'preferred_time' => ['required', 'date_format:H:i'],
            'notes'          => ['nullable', 'string', 'max:1000'],
        ]);

        // ── Schedule alignment validation ────────────────────────
        $schedule = CounselorSchedule::where('id', $data['schedule_id'])
            ->where('counselor_id', $data['counselor_id'])
            ->where('is_active', true)
            ->first();

        if (! $schedule) {
            throw ValidationException::withMessages([
                'schedule_id' => 'The selected schedule slot does not belong to the chosen counselor or is no longer active.',
            ]);
        }

        // Check the preferred_date falls on the correct day of the week
        $preferredDate    = Carbon::parse($data['preferred_date']);
        $expectedDayName  = $preferredDate->format('l'); // e.g. "Monday"

        if (strcasecmp($expectedDayName, $schedule->day_of_week) !== 0) {
            throw ValidationException::withMessages([
                'preferred_date' => "The selected date ({$preferredDate->format('F d, Y')}) falls on a {$expectedDayName}, but the chosen schedule slot is for {$schedule->day_of_week}s.",
            ]);
        }

        // Check the preferred_time falls within the schedule window
        // Times are stored as H:i or H:i:s strings — normalise to Carbon for comparison
        $preferredTime = Carbon::createFromFormat('H:i', $data['preferred_time']);
        $slotStart     = Carbon::createFromFormat('H:i:s', $schedule->start_time);
        $slotEnd       = Carbon::createFromFormat('H:i:s', $schedule->end_time);

        // The appointment must start at or after slot start and strictly before slot end
        if ($preferredTime->lt($slotStart) || $preferredTime->gte($slotEnd)) {
            throw ValidationException::withMessages([
                'preferred_time' => "The preferred time ({$preferredTime->format('g:i A')}) must be within the schedule window: {$slotStart->format('g:i A')} – {$slotEnd->format('g:i A')}.",
            ]);
        }

        // ── Check time aligns to a slot boundary (optional but recommended) ─
        // e.g. if slots are 30 mins starting at 08:00, valid times are 08:00, 08:30, 09:00 …
        if ($schedule->slot_duration_mins > 0) {
            $minutesFromStart = $slotStart->diffInMinutes($preferredTime);
            if ($minutesFromStart % $schedule->slot_duration_mins !== 0) {
                throw ValidationException::withMessages([
                    'preferred_time' => "The preferred time must align to a {$schedule->slot_duration_mins}-minute slot boundary starting from {$slotStart->format('g:i A')}.",
                ]);
            }
        }

        Appointment::create([
            'student_id'     => $data['student_id'],
            'counselor_id'   => $data['counselor_id'],
            'schedule_id'    => $data['schedule_id'],
            'concern_type'   => $data['concern_type'],
            'preferred_date' => $data['preferred_date'],
            'preferred_time' => $data['preferred_time'],
            'notes'          => $data['notes'] ?? null,
            'status'         => 'approved', // Admin-booked appointments are auto-approved
            'scheduled_at'   => now(),
        ]);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment booked successfully.');
    }

    // ─── JSON: Active Slots for a Counselor (AJAX, used by create form) ─
    public function slots(Request $request)
    {
        $request->validate(['counselor_id' => ['required', 'exists:users,id']]);

        $slots = CounselorSchedule::where('counselor_id', $request->counselor_id)
            ->where('is_active', true)
            ->orderByRaw("FIELD(day_of_week,'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')")
            ->orderBy('start_time')
            ->get(['id', 'day_of_week', 'start_time', 'end_time', 'slot_duration_mins']);

        return response()->json($slots);
    }

    // ─── Approve ─────────────────────────────────────────────────
    public function approve(Appointment $appointment)
    {
        $appointment->update(['status' => 'approved', 'scheduled_at' => now()]);

        return back()->with('success', 'Appointment approved.');
    }

    // ─── Reject ──────────────────────────────────────────────────
    public function reject(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ]);

        $appointment->update([
            'status'           => 'rejected',
            'rejection_reason' => $data['rejection_reason'],
        ]);

        return back()->with('success', 'Appointment rejected.');
    }

    // ─── Complete ────────────────────────────────────────────────
    public function complete(Appointment $appointment)
    {
        $appointment->update(['status' => 'completed']);

        return back()->with('success', 'Appointment marked as completed.');
    }

    // ─── Cancel ──────────────────────────────────────────────────
    public function cancel(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelled']);

        return back()->with('success', 'Appointment cancelled.');
    }
}