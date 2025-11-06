<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'message',
        'data',
        'ip_address',
        'user_agent',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Scope للإشعارات غير المقروءة
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope للإشعارات المقروءة
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope حسب النوع
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * تحديد كمقروء
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * الحصول على أيقونة حسب النوع
     */
    public function getIcon(): string
    {
        return match($this->type) {
            'login_success' => 'fas fa-check-circle text-success',
            'login_failed' => 'fas fa-times-circle text-danger',
            'suspicious_activity' => 'fas fa-exclamation-triangle text-warning',
            'new_device' => 'fas fa-mobile-alt text-info',
            default => 'fas fa-bell text-primary',
        };
    }

    /**
     * الحصول على لون الإشعار
     */
    public function getColor(): string
    {
        return match($this->type) {
            'login_success' => 'success',
            'login_failed' => 'danger',
            'suspicious_activity' => 'warning',
            'new_device' => 'info',
            default => 'primary',
        };
    }
}
