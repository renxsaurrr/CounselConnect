<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounselorProfile extends Model
{
    use HasFactory;

    protected $table = 'counselor_profiles';

    protected $fillable = [
        'user_id',
        'specialization',
        'office_location',
        'contact_number',
        'bio',
        'profile_picture',
    ];

    // ─── Relationships ───────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}