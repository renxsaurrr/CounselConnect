<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use App\Models\SessionRecord;
use App\Models\Referral;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students'     => User::where('role', 'student')->count(),
            'total_counselors'   => User::where('role', 'counselor')->count(),
            'total_appointments' => Appointment::count(),
            'pending_appointments' => Appointment::pending()->count(),
            'completed_sessions' => SessionRecord::count(),
            'pending_referrals'  => Referral::pending()->count(),
        ];

        $recentAppointments = Appointment::with(['student', 'counselor'])
            ->latest()
            ->take(10)
            ->get();
            
        $recentReferrals = Referral::with(['referredBy', 'referredTo', 'student'])
            ->latest()
            ->take(5)
            ->get();

        return view('CounselConnect.admin.dashboard', compact('stats', 'recentAppointments', 'recentReferrals'));
    }
}