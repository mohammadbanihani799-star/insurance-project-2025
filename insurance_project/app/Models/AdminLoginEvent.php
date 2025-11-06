<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLoginEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'event',
        'ip',
        'user_agent',
        'device_id',
        'note'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the admin user
     */
    public function admin()
    {
        return $this->belongsTo(\App\Models\User::class, 'admin_id');
    }

    /**
     * Scope for success events
     */
    public function scopeSuccess($query)
    {
        return $query->where('event', 'login_success');
    }

    /**
     * Scope for failed events
     */
    public function scopeFailed($query)
    {
        return $query->where('event', 'login_failed');
    }

    /**
     * Scope for recent events
     */
    public function scopeRecent($query, $hours = 24)
    {
        return $query->where('created_at', '>=', now()->subHours($hours));
    }
}
