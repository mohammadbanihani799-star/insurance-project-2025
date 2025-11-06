<?php

namespace App\Http\Middleware;

use App\Models\UserDevice;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;

class TrackDevice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // Get or generate device ID
            $deviceId = $request->cookie('x_device');
            
            if (!$deviceId) {
                $deviceId = Str::random(40);
            }

            // Store device ID in request for later use (before any DB operations)
            $request->attributes->set('device_id', $deviceId);

            // Detect device details using Agent
            $agent = new Agent();
            $agent->setUserAgent($request->userAgent() ?? '');

            // Get platform and browser
            $platform = $agent->platform();
            $browser = $agent->browser();
            
            // Get or create device record
            $device = UserDevice::where('device_id', $deviceId)->first();
            
            if (!$device) {
                // Create new device
                $device = new UserDevice();
                $device->device_id = $deviceId;
                $device->first_seen_at = now();
            }
            
            // Update device information
            $device->ip = $request->ip();
            $device->user_agent = $request->userAgent() ?? 'Unknown';
            $device->platform = $platform ?? 'Unknown';
            $device->browser = $browser ?? 'Unknown';
            $device->status = 'active';
            $device->last_seen_at = now();
            
            // Associate with authenticated user if logged in
            if (auth()->check()) {
                $device->owner_type = get_class(auth()->user());
                $device->owner_id = auth()->id();
            }
            
            $device->save();

        } catch (\Exception $e) {
            // Log error but don't break the request
            \Log::error('TrackDevice middleware error: ' . $e->getMessage());
        }

        // Create response and attach cookie
        $response = $next($request);
        
        // Set long-lived cookie (1 year)
        return $response->cookie(
            'x_device',
            $deviceId ?? Str::random(40),
            60 * 24 * 365, // 1 year in minutes
            '/',
            null,
            false, // secure: false for local development
            true, // httpOnly
            false,
            'Lax' // SameSite: Lax for better compatibility
        );
    }
}
