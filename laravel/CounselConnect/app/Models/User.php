<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\StudentProfile;
use App\Models\CounselorProfile;
use App\Models\AdminProfile;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'google_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    // ─── Role Helpers ────────────────────────────────────────────
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function isCounselor(): bool
    {
        return $this->role === 'counselor';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // ─── Profile Relationships ───────────────────────────────────
    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function counselorProfile()
    {
        return $this->hasOne(CounselorProfile::class);
    }

    public function adminProfile()
    {
        return $this->hasOne(AdminProfile::class);
    }

    // ─── Appointments ────────────────────────────────────────────
    public function appointmentsAsStudent()
    {
        return $this->hasMany(Appointment::class, 'student_id');
    }

    public function appointmentsAsCounselor()
    {
        return $this->hasMany(Appointment::class, 'counselor_id');
    }

    // ─── Counselor Schedules ─────────────────────────────────────
    public function schedules()
    {
        return $this->hasMany(CounselorSchedule::class, 'counselor_id');
    }

    // ─── Session Records ─────────────────────────────────────────
    public function sessionRecordsAsStudent()
    {
        return $this->hasMany(SessionRecord::class, 'student_id');
    }

    public function sessionRecordsAsCounselor()
    {
        return $this->hasMany(SessionRecord::class, 'counselor_id');
    }

    // ─── Referrals ───────────────────────────────────────────────
    public function referralsMade()
    {
        return $this->hasMany(Referral::class, 'referred_by');
    }

    public function referralsReceived()
    {
        return $this->hasMany(Referral::class, 'referred_to');
    }

    public function referralsAsStudent()
    {
        return $this->hasMany(Referral::class, 'student_id');
    }

    // ─── Announcements ───────────────────────────────────────────
    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'posted_by');
    }
}