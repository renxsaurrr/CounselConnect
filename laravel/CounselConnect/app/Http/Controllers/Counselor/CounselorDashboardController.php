<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\SessionRecord;
use App\Models\Referral;
use Illuminate\Support\Facades\Auth;

class CounselorDashboardController extends Controller
{
    public function index()
    {
        $counselor = Auth::user();

        $stats = [
            'pending_appointments'   => Appointment::where('counselor_id', $counselor->id)->pending()->count(),
            'approved_appointments'  => Appointment::where('counselor_id', $counselor->id)->approved()->count(),
            'completed_sessions'     => Appointment::where('counselor_id', $counselor->id)->completed()->count(),
            'follow_ups_needed'      => SessionRecord::where('counselor_id', $counselor->id)->needsFollowUp()->count(),
            'pending_referrals'      => Referral::where('referred_to', $counselor->id)->pending()->count(),
        ];

        $upcomingAppointments = Appointment::where('counselor_id', $counselor->id)
            ->approved()
            ->with('student.studentProfile')
            ->orderBy('preferred_date')
            ->orderBy('preferred_time')
            ->take(5)
            ->get();

        $pendingAppointments = Appointment::where('counselor_id', $counselor->id)
            ->pending()
            ->with('student.studentProfile')
            ->latest()
            ->take(5)
            ->get();

        return view('CounselConnect.counselor.dashboard', compact(
            'stats',
            'upcomingAppointments',
            'pendingAppointments'
        ));
    }
}