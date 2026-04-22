<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        $stats = [
            'pending_appointments'   => Appointment::where('student_id', $student->id)->pending()->count(),
            'approved_appointments'  => Appointment::where('student_id', $student->id)->approved()->count(),
            'completed_appointments' => Appointment::where('student_id', $student->id)->completed()->count(),
        ];

        $recentAppointments = Appointment::where('student_id', $student->id)
            ->with('counselor.counselorProfile')
            ->latest()
            ->take(5)
            ->get();

        $announcements = Announcement::published()
            ->forAudience('students')
            ->latest()
            ->take(5)
            ->get();

        return view('CounselConnect.student.dashboard', compact('stats', 'recentAppointments', 'announcements'));
    }
}