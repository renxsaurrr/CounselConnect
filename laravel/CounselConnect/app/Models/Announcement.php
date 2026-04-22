<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $table = 'announcements';

    protected $fillable = [
        'posted_by',
        'title',
        'body',
        'audience',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────
    public function author()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    // ─── Scopes ──────────────────────────────────────────────────
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeForAudience($query, string $audience)
    {
        return $query->where(function ($q) use ($audience) {
            $q->where('audience', 'all')
              ->orWhere('audience', $audience);
        });
    }

    // ─── Helpers ─────────────────────────────────────────────────
    public function isPublished(): bool
    {
        return $this->is_published;
    }
}