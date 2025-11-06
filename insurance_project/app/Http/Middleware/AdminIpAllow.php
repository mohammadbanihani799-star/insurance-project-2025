<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminIpAllow
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
        $allowedIps = config('admin.allow_ips', []);
        
        // If no IPs are configured, allow all (disabled)
        if (empty($allowedIps)) {
            return $next($request);
        }

        $requestIp = $request->ip();

        // Check if request IP is in allowed list
        if (!in_array($requestIp, $allowedIps)) {
            abort(403, 'Unauthorized access from IP: ' . $requestIp);
        }

        return $next($request);
    }
}
