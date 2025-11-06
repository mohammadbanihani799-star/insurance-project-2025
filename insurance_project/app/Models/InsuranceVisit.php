<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'session_id',
        'path',
        'step_key',
        'meta',
        'visited_at'
    ];

    protected $casts = [
        'meta' => 'array',
        'visited_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get device associated with this visit
     */
    public function device()
    {
        return $this->belongsTo(UserDevice::class, 'device_id', 'device_id');
    }

    /**
     * Scope for specific device
     */
    public function scopeForDevice($query, $deviceId)
    {
        return $query->where('device_id', $deviceId);
    }

    /**
     * Scope for specific step
     */
    public function scopeForStep($query, $stepKey)
    {
        return $query->where('step_key', $stepKey);
    }

    /**
     * Scope for recent visits
     */
    public function scopeRecent($query, $minutes = 60)
    {
        return $query->where('visited_at', '>=', now()->subMinutes($minutes));
    }

    /**
     * Scope for today's visits
     */
    public function scopeToday($query)
    {
        return $query->whereDate('visited_at', today());
    }
}
