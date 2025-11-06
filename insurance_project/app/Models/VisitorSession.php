<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'ip',
        'user_agent',
        'current_route',
        'current_url',
        'last_seen_at',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
        'user_id' => 'integer',
    ];

    public function scopeActive($query, int $seconds = 120)
    {
        return $query->where('last_seen_at', '>=', now()->subSeconds($seconds));
    }

    public function scopeInactive($query, int $seconds = 120)
    {
        return $query->where('last_seen_at', '<', now()->subSeconds($seconds));
    }
}
