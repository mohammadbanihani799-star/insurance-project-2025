<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Failed;
use App\Models\LoginAttempt;
use App\Models\SecurityNotification;
use Illuminate\Support\Facades\Request;

class LogLoginAttempt
{
    /**
     * Handle successful login
     */
    public function handleLogin(Login $event)
    {
        $user = $event->user;
        $request = Request::instance();
        
        // تسجيل محاولة تسجيل دخول ناجحة
        $attempt = $this->createLoginAttempt($request, $user, true);
        
        // Get user identifier (name, username, or email)
        $userName = $user->name ?? $user->username ?? $user->email ?? 'مستخدم غير معروف';
        
        // إنشاء إشعار أمني
        $this->createSecurityNotification(
            'login_success',
            "تم تسجيل دخول ناجح للمستخدم {$userName} من {$attempt->ip_address}",
            $attempt
        );
    }

    /**
     * Handle failed login
     */
    public function handleFailed(Failed $event)
    {
        $request = Request::instance();
        
        // تسجيل محاولة تسجيل دخول فاشلة
        $attempt = $this->createLoginAttempt($request, $event->user, false, 'Invalid credentials');
        
        // التحقق من النشاط المشبوه
        if ($attempt->isSuspicious()) {
            $this->createSecurityNotification(
                'suspicious_activity',
                "نشاط مشبوه: محاولات متعددة فاشلة من {$attempt->ip_address}",
                $attempt,
                true
            );
        } else {
            $this->createSecurityNotification(
                'login_failed',
                "محاولة تسجيل دخول فاشلة من {$attempt->ip_address}",
                $attempt
            );
        }
    }

    /**
     * إنشاء سجل محاولة تسجيل الدخول
     */
    protected function createLoginAttempt($request, $user = null, $successful = false, $failureReason = null)
    {
        $userAgent = $request->userAgent();
        
        // استخراج معلومات من User Agent بشكل بسيط
        $deviceInfo = $this->parseUserAgent($userAgent);
        
        return LoginAttempt::create([
            'user_id' => $user?->id,
            'email' => $request->input('email'),
            'ip_address' => $request->ip(),
            'device_type' => $deviceInfo['device_type'],
            'browser' => $deviceInfo['browser'],
            'platform' => $deviceInfo['platform'],
            'user_agent' => $userAgent,
            'successful' => $successful,
            'failure_reason' => $failureReason,
            'is_admin_attempt' => $this->isAdminRoute($request),
        ]);
    }

    /**
     * إنشاء إشعار أمني
     */
    protected function createSecurityNotification($type, $message, $attempt, $critical = false)
    {
        SecurityNotification::create([
            'type' => $type,
            'message' => $message,
            'data' => [
                'ip' => $attempt->ip_address,
                'browser' => $attempt->browser,
                'platform' => $attempt->platform,
                'device' => $attempt->device_type,
                'critical' => $critical,
            ],
            'ip_address' => $attempt->ip_address,
            'user_agent' => $attempt->user_agent,
        ]);
    }

    /**
     * استخراج معلومات من User Agent
     */
    protected function parseUserAgent($userAgent)
    {
        $deviceType = 'desktop';
        $browser = 'Unknown';
        $platform = 'Unknown';

        if (empty($userAgent)) {
            return compact('device_type', 'browser', 'platform');
        }

        // Device Type
        if (preg_match('/Mobile|Android|iPhone|iPad|iPod/i', $userAgent)) {
            $deviceType = 'mobile';
        } elseif (preg_match('/Tablet|iPad/i', $userAgent)) {
            $deviceType = 'tablet';
        }

        // Browser
        if (preg_match('/Chrome/i', $userAgent)) $browser = 'Chrome';
        elseif (preg_match('/Firefox/i', $userAgent)) $browser = 'Firefox';
        elseif (preg_match('/Safari/i', $userAgent) && !preg_match('/Chrome/i', $userAgent)) $browser = 'Safari';
        elseif (preg_match('/Edge/i', $userAgent)) $browser = 'Edge';
        elseif (preg_match('/Opera|OPR/i', $userAgent)) $browser = 'Opera';

        // Platform
        if (preg_match('/Windows/i', $userAgent)) $platform = 'Windows';
        elseif (preg_match('/Mac|Macintosh/i', $userAgent)) $platform = 'macOS';
        elseif (preg_match('/Linux/i', $userAgent)) $platform = 'Linux';
        elseif (preg_match('/Android/i', $userAgent)) $platform = 'Android';
        elseif (preg_match('/iOS|iPhone|iPad/i', $userAgent)) $platform = 'iOS';

        return compact('deviceType', 'browser', 'platform');
    }

    /**
     * التحقق من محاولة الدخول لمسار المسؤولين
     */
    protected function isAdminRoute($request): bool
    {
        return str_contains($request->path(), 'super_admin') || 
               str_contains($request->path(), 'admin');
    }
}
