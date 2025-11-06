<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ActiveDevice;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class TrackActiveDevice
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // تتبع الجهاز فقط للمستخدمين المسجلين
        if (Auth::check()) {
            $this->trackDevice($request);
        }

        return $next($request);
    }

    /**
     * تتبع الجهاز النشط
     */
    protected function trackDevice(Request $request)
    {
        try {
            $agent = new Agent();
            $agent->setUserAgent($request->userAgent());

            $sessionId = session()->getId();
            
            // البحث عن الجهاز الحالي أو إنشاء جديد
            $device = ActiveDevice::firstOrNew(['session_id' => $sessionId]);
            
            // تحديث بيانات الجهاز
            $device->fill([
                'user_id' => Auth::id(),
                'device_type' => $this->getDeviceType($agent),
                'browser' => $agent->browser(),
                'browser_version' => $agent->version($agent->browser()),
                'platform' => $agent->platform(),
                'platform_version' => $agent->version($agent->platform()),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'last_activity' => now(),
                'is_admin' => Auth::user()->hasRole('super_admin'),
            ]);

            // تعيين login_at فقط للأجهزة الجديدة
            if (!$device->exists) {
                $device->login_at = now();
                
                // الحصول على معلومات الموقع (اختياري)
                $locationData = $this->getLocationData($request->ip());
                $device->country = $locationData['country'] ?? null;
                $device->city = $locationData['city'] ?? null;
            }

            $device->save();

            // تنظيف الأجهزة غير النشطة
            $this->cleanupInactiveDevices();

        } catch (\Exception $e) {
            // تسجيل الخطأ بصمت دون تعطيل التطبيق
            \Log::error('TrackActiveDevice Error: ' . $e->getMessage());
        }
    }

    /**
     * الحصول على نوع الجهاز
     */
    protected function getDeviceType(Agent $agent): string
    {
        if ($agent->isMobile()) {
            return 'mobile';
        } elseif ($agent->isTablet()) {
            return 'tablet';
        } else {
            return 'desktop';
        }
    }

    /**
     * الحصول على معلومات الموقع من IP
     */
    protected function getLocationData($ip)
    {
        // تجاهل IPs المحلية
        if (in_array($ip, ['127.0.0.1', '::1', 'localhost'])) {
            return ['country' => 'Local', 'city' => 'localhost'];
        }

        try {
            // يمكن استخدام خدمة مثل ipapi.co أو geoip2
            // هنا مثال بسيط باستخدام ipapi.co (مجاني لـ 1000 طلب/يوم)
            $response = @file_get_contents("https://ipapi.co/{$ip}/json/");
            
            if ($response) {
                $data = json_decode($response, true);
                return [
                    'country' => $data['country_name'] ?? null,
                    'city' => $data['city'] ?? null,
                ];
            }
        } catch (\Exception $e) {
            \Log::warning('Location data fetch failed: ' . $e->getMessage());
        }

        return ['country' => null, 'city' => null];
    }

    /**
     * تنظيف الأجهزة غير النشطة
     */
    protected function cleanupInactiveDevices()
    {
        // حذف الأجهزة التي لم تكن نشطة منذ أكثر من ساعة
        ActiveDevice::where('last_activity', '<', now()->subHour())->delete();
    }
}
