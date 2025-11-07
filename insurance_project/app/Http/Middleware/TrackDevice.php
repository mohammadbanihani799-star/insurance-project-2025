<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserDevice;
use Symfony\Component\HttpFoundation\Response;

class TrackDevice
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get device information
        $userAgent = $request->userAgent();
        $ipAddress = $request->ip();
        $fingerprint = md5($userAgent . $ipAddress);

        // Find or create device record
        $device = UserDevice::firstOrCreate(
            ['fingerprint' => $fingerprint],
            [
                'user_agent' => $userAgent,
                'ip_address' => $ipAddress,
                'last_seen' => now(),
            ]
        );

        // Update last seen
        $device->update(['last_seen' => now()]);

        // Store device_id in request for later use
        $request->merge(['device_id' => $device->id]);

        return $next($request);
    }
}
