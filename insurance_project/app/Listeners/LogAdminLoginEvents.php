<?php

namespace App\Listeners;

use App\Models\AdminLoginEvent;
use App\Models\UserDevice;
use App\Notifications\AdminLoginSuccess;
use App\Notifications\AdminLoginFailed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Notification;
use Jenssegers\Agent\Agent;

class LogAdminLoginEvents
{
    /**
     * Handle successful login events.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handleLogin(Login $event)
    {
        $request = request();
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());

        $deviceId = $request->attributes->get('device_id') ?? $request->cookie('x_device');

        // Log the event
        $loginEvent = AdminLoginEvent::create([
            'admin_id' => $event->user->getAuthIdentifier(),
            'event' => 'login_success',
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device_id' => $deviceId,
            'note' => 'تسجيل دخول ناجح'
        ]);

        // Update device record if exists
        if ($deviceId) {
            $device = UserDevice::where('device_id', $deviceId)->first();
            if ($device) {
                $device->owner_type = get_class($event->user);
                $device->owner_id = $event->user->getAuthIdentifier();
                $device->last_seen_at = now();
                $device->save();
            }
        }

        // Send notification to owner
        $ownerEmail = config('admin.owner_email');
        if ($ownerEmail) {
            Notification::route('mail', $ownerEmail)
                ->notify(new AdminLoginSuccess([
                    'admin_name' => $event->user->name ?? 'مدير',
                    'ip' => $request->ip(),
                    'platform' => $agent->platform() ?? 'Unknown',
                    'browser' => $agent->browser() ?? 'Unknown',
                    'device_id' => $deviceId ?? 'غير معروف',
                    'time' => now()->format('Y-m-d H:i:s')
                ]));
        }
    }

    /**
     * Handle failed login events.
     *
     * @param  \Illuminate\Auth\Events\Failed  $event
     * @return void
     */
    public function handleFailed(Failed $event)
    {
        $request = request();
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());

        $deviceId = $request->attributes->get('device_id') ?? $request->cookie('x_device');
        $email = $event->credentials['email'] ?? 'غير متوفر';

        // Log the event
        AdminLoginEvent::create([
            'admin_id' => null, // No admin ID for failed attempts
            'event' => 'login_failed',
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device_id' => $deviceId,
            'note' => 'محاولة فاشلة - البريد: ' . $email
        ]);

        // Send notification to owner
        $ownerEmail = config('admin.owner_email');
        if ($ownerEmail) {
            Notification::route('mail', $ownerEmail)
                ->notify(new AdminLoginFailed([
                    'email' => $email,
                    'ip' => $request->ip(),
                    'platform' => $agent->platform() ?? 'Unknown',
                    'browser' => $agent->browser() ?? 'Unknown',
                    'device_id' => $deviceId ?? 'غير معروف',
                    'time' => now()->format('Y-m-d H:i:s'),
                    'note' => 'بيانات دخول خاطئة'
                ]));
        }
    }

    /**
     * Handle logout events.
     *
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handleLogout(Logout $event)
    {
        $request = request();
        $deviceId = $request->attributes->get('device_id') ?? $request->cookie('x_device');

        // Log the event
        AdminLoginEvent::create([
            'admin_id' => $event->user ? $event->user->getAuthIdentifier() : null,
            'event' => 'logout',
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device_id' => $deviceId,
            'note' => 'تسجيل خروج'
        ]);
    }
}
