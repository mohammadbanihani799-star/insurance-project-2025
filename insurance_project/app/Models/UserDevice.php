<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDevice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'owner_type',
        'owner_id',
        'device_id',
        'ip',
        'user_agent',
        'platform',
        'browser',
        'location',
        'status',
        'first_seen_at',
        'last_seen_at'
    ];

    protected $casts = [
        'first_seen_at' => 'datetime',
        'last_seen_at'  => 'datetime',
    ];

    /**
     * Get the owner (User, Admin, etc.)
     */
    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * Scope for active devices in last X minutes
     */
    public function scopeActive($query, $minutes = 5)
    {
        return $query->where('last_seen_at', '>=', now()->subMinutes($minutes))
                     ->where('status', 'active');
    }

    /**
     * Scope for specific owner
     */
    public function scopeForOwner($query, $ownerType, $ownerId)
    {
        return $query->where('owner_type', $ownerType)
                     ->where('owner_id', $ownerId);
    }
}
