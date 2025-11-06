<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ActiveDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'device_type',
        'browser',
        'browser_version',
        'platform',
        'platform_version',
        'ip_address',
        'country',
        'city',
        'user_agent',
        'last_activity',
        'login_at',
        'is_admin',
    ];

    protected $casts = [
        'last_activity' => 'datetime',
        'login_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    /**
     * العلاقة مع المستخدم
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope للأجهزة النشطة (آخر 5 دقائق)
     */
    public function scopeActive($query)
    {
        return $query->where('last_activity', '>=', Carbon::now()->subMinutes(5));
    }

    /**
     * Scope لأجهزة المسؤولين
     */
    public function scopeAdmins($query)
    {
        return $query->where('is_admin', true);
    }

    /**
     * Scope لأجهزة المستخدمين العاديين
     */
    public function scopeUsers($query)
    {
        return $query->where('is_admin', false);
    }

    /**
     * تحديث آخر نشاط
     */
    public function updateActivity()
    {
        $this->last_activity = now();
        $this->save();
    }

    /**
     * التحقق من نشاط الجهاز
     */
    public function isActive(): bool
    {
        return $this->last_activity >= Carbon::now()->subMinutes(5);
    }

    /**
     * الحصول على أيقونة الجهاز
     */
    public function getDeviceIcon(): string
    {
        return match($this->device_type) {
            'mobile' => 'fas fa-mobile-alt',
            'tablet' => 'fas fa-tablet-alt',
            default => 'fas fa-desktop',
        };
    }

    /**
     * الحصول على أيقونة المتصفح
     */
    public function getBrowserIcon(): string
    {
        $browser = strtolower($this->browser ?? '');
        
        if (str_contains($browser, 'chrome')) return 'fab fa-chrome';
        if (str_contains($browser, 'firefox')) return 'fab fa-firefox';
        if (str_contains($browser, 'safari')) return 'fab fa-safari';
        if (str_contains($browser, 'edge')) return 'fab fa-edge';
        if (str_contains($browser, 'opera')) return 'fab fa-opera';
        
        return 'fas fa-globe';
    }

    /**
     * الحصول على أيقونة النظام
     */
    public function getPlatformIcon(): string
    {
        $platform = strtolower($this->platform ?? '');
        
        if (str_contains($platform, 'windows')) return 'fab fa-windows';
        if (str_contains($platform, 'mac') || str_contains($platform, 'ios')) return 'fab fa-apple';
        if (str_contains($platform, 'linux')) return 'fab fa-linux';
        if (str_contains($platform, 'android')) return 'fab fa-android';
        
        return 'fas fa-desktop';
    }

    /**
     * تنظيف الأجهزة غير النشطة (أكثر من 30 دقيقة)
     */
    public static function cleanupInactive()
    {
        return static::where('last_activity', '<', Carbon::now()->subMinutes(30))->delete();
    }
}
