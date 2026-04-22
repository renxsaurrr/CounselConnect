<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionRecord extends Model
{
    use HasFactory;

    protected $table = 'session_records';

    protected $fillable = [
        'appointment_id',
        'counselor_id',
        'student_id',
        'session_notes',
        'intervention',
        'follow_up_needed',
        'next_session_date',
    ];

    protected function casts(): array
    {
        return [
            'follow_up_needed'  => 'boolean',
            'next_session_date' => 'date',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // ─── Scopes ──────────────────────────────────────────────────
    public function scopeNeedsFollowUp($query)
    {
        return $query->where('follow_up_needed', true);
    }
}