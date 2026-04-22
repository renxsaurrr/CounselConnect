<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounselorStudentController extends Controller
{
    // ─── List Students ────────────────────────────────────────────
    // Only shows students who have had at least one appointment
    // with this counselor (scoped — no cross-counselor data leak).
    public function index(Request $request)
    {
        $studentIds = Appointment::where('counselor_id', Auth::id())
            ->distinct()
            ->pluck('student_id');

        $students = User::whereIn('id', $studentIds)
            ->where('role', 'student')
            ->with('studentProfile')
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%')
                      ->orWhereHas('studentProfile', function ($q) use ($request) {
                          $q->where('department', 'like', '%' . $request->search . '%')
                            ->orWhere('student_id', 'like', '%' . $request->search . '%');
                      });
                });
            })
            ->when($request->department, function ($q) use ($request) {
                $q->whereHas('studentProfile', fn($q) =>
                    $q->where('department', $request->department)
                );
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        // Departments for filter dropdown (from this counselor's students only)
        // REPLACE lines 44-51 (the $departments query) with this:
            $departments = User::whereIn('id', $studentIds)
            ->where('role', 'student')
            ->with('studentProfile')
            ->get()
            ->pluck('studentProfile.department')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('CounselConnect.counselor.students.index', compact('students', 'departments'));
    }

    // ─── Show Student Profile ─────────────────────────────────────
    // Shows the student's profile + their appointment/session history
    // with this counselor only.
    public function show(User $student)
    {
        // Ensure this counselor has actually interacted with this student
        $hasAppointment = Appointment::where('counselor_id', Auth::id())
            ->where('student_id', $student->id)
            ->exists();

        abort_if(! $hasAppointment, 403, 'You do not have access to this student\'s records.');

        $student->load('studentProfile');

        $appointments = Appointment::where('counselor_id', Auth::id())
            ->where('student_id', $student->id)
            ->orderByDesc('preferred_date')
            ->get();

        $sessionRecords = \App\Models\SessionRecord::where('counselor_id', Auth::id())
            ->where('student_id', $student->id)
            ->with('appointment')
            ->latest()
            ->get();

        return view('CounselConnect.counselor.students.show', compact(
            'student',
            'appointments',
            'sessionRecords'
        ));
    }
}