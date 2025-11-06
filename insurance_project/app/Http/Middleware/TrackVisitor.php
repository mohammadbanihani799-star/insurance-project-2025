<?php

namespace App\Http\Middleware;

use App\Models\VisitorSession;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Track visitor activity with optimized performance for high traffic.
     * Uses cache to prevent database overload (100+ visitors/second).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        try {
            // Skip tracking for admin assets, API calls, and monitoring tools
            $path = $request->path();
            if ($this->shouldSkipTracking($path)) {
                return $response;
            }

            $sessionId = $request->session()->getId();
            
            // Throttle DB writes: update max once per 5 seconds per session
            $cacheKey = "visitor_tracked_{$sessionId}";
            
            if (! Cache::has($cacheKey)) {
                $this->trackVisitor($request, $sessionId);
                
                // Cache for 5 seconds to reduce DB load dramatically
                Cache::put($cacheKey, true, 5);
            }
            
        } catch (\Throwable $e) {
            // Never break the request - tracking is non-critical
            \Log::debug('Visitor tracking skipped: ' . $e->getMessage());
        }

        return $response;
    }

    /**
     * Determine if we should skip tracking for this path
     */
    private function shouldSkipTracking(string $path): bool
    {
        $skipPatterns = ['telescope', 'horizon', '_debugbar', 'livewire', 'build/assets'];
        
        foreach ($skipPatterns as $pattern) {
            if (str_starts_with($path, $pattern)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Record visitor session to database
     */
    private function trackVisitor(Request $request, string $sessionId): void
    {
        $userId = optional($request->user())->id;
        $ip = $request->ip();
        $ua = substr((string) $request->userAgent(), 0, 500);
        $routeName = optional($request->route())->getName() ?? 'unknown';
        $currentUrl = substr($request->fullUrl(), 0, 2048);

        VisitorSession::updateOrCreate(
            ['session_id' => $sessionId],
            [
                'user_id' => $userId,
                'ip' => $ip,
                'user_agent' => $ua,
                'current_route' => $routeName,
                'current_url' => $currentUrl,
                'last_seen_at' => now(),
            ]
        );
    }
}
