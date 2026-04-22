<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\SessionRecord;
use Illuminate\Support\Facades\Auth;

class StudentSessionController extends Controller
{
    // ─── List Sessions ────────────────────────────────────────────
    public function index()
    {
        $user = Auth::user();

        $sessions = $user->sessionRecordsAsStudent()
            ->with(['appointment.counselor.counselorProfile'])
            ->latest()
            ->paginate(10);

        // Count unique months the student has had sessions
        $totalMonths = $user->sessionRecordsAsStudent()
            ->with('appointment')
            ->get()
            ->map(function ($s) {
                $date = $s->appointment?->scheduled_at ?? $s->appointment?->preferred_date;
                return $date ? \Carbon\Carbon::parse($date)->format('Y-m') : null;
            })
            ->filter()
            ->unique()
            ->count();

        // Next upcoming follow-up date
        $nextSession = $user->sessionRecordsAsStudent()
            ->whereNotNull('next_session_date')
            ->where('next_session_date', '>=', now()->toDateString())
            ->orderBy('next_session_date')
            ->value('next_session_date');

        return view('CounselConnect.student.sessions.index', [
            'sessions'      => $sessions,
            'totalSessions' => $sessions->total(),
            'totalMonths'   => $totalMonths,
            'nextSession'   => $nextSession,
        ]);
    }

    // ─── Show Single Session ──────────────────────────────────────
    public function show(SessionRecord $session)
    {
        // Ensure this session belongs to the authenticated student
        abort_if($session->student_id !== Auth::id(), 403);

        $session->load(['appointment.counselor.counselorProfile', 'appointment.schedule']);

        return view('CounselConnect.student.sessions.show', compact('session'));
    }
}