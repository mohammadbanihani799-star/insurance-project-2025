<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'ip_address',
        'country',
        'city',
        'device_type',
        'browser',
        'platform',
        'user_agent',
        'successful',
        'failure_reason',
        'is_admin_attempt',
    ];

    protected $casts = [
        'successful' => 'boolean',
        'is_admin_attempt' => 'boolean',
    ];

    /**
     * العلاقة مع المستخدم
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope للمحاولات الناجحة
     */
    public function scopeSuccessful($query)
    {
        return $query->where('successful', true);
    }

    /**
     * Scope للمحاولات الفاشلة
     */
    public function scopeFailed($query)
    {
        return $query->where('successful', false);
    }

    /**
     * Scope لمحاولات المسؤولين
     */
    public function scopeAdminAttempts($query)
    {
        return $query->where('is_admin_attempt', true);
    }

    /**
     * Scope للمحاولات الأخيرة
     */
    public function scopeRecent($query, $minutes = 60)
    {
        return $query->where('created_at', '>=', now()->subMinutes($minutes));
    }

    /**
     * الحصول على عدد المحاولات الفاشلة من IP معين
     */
    public static function getFailedAttemptsFromIp($ip, $minutes = 30)
    {
        return static::where('ip_address', $ip)
            ->where('successful', false)
            ->where('created_at', '>=', now()->subMinutes($minutes))
            ->count();
    }

    /**
     * التحقق من نشاط مشبوه
     */
    public function isSuspicious(): bool
    {
        $failedAttempts = static::where('ip_address', $this->ip_address)
            ->where('successful', false)
            ->where('created_at', '>=', now()->subMinutes(30))
            ->count();
        
        return $failedAttempts >= 3;
    }
}
