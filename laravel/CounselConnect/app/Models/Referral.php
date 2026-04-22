<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $table = 'referrals';

    protected $fillable = [
        'referred_by',
        'referred_to',
        'student_id',
        'reason',
        'type',
        'status',
    ];

    // ─── Relationships ───────────────────────────────────────────
    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function referredTo()
    {
        return $this->belongsTo(User::class, 'referred_to');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // ─── Scopes ──────────────────────────────────────────────────
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAcknowledged($query)
    {
        return $query->where('status', 'acknowledged');
    }

    public function scopeInternal($query)
    {
        return $query->where('type', 'internal');
    }

    public function scopeExternal($query)
    {
        return $query->where('type', 'external');
    }

    // ─── Status Helpers ──────────────────────────────────────────
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isAcknowledged(): bool
    {
        return $this->status === 'acknowledged';
    }
}