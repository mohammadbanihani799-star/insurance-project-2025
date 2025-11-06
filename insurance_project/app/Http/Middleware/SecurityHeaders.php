<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    private array $excludedPaths = [
        'build/*',
        'storage/*',
        'vite/*',
        '@vite/*',
        'hot',
    ];

    private array $excludedExtensions = [
        '.js', '.css', '.map', '.json',
        '.woff', '.woff2', '.ttf', '.eot',
        '.svg', '.jpg', '.jpeg', '.png', '.gif', '.webp', '.ico',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // تخطي الملفات الثابتة
        if ($this->shouldSkip($request)) {
            return $response;
        }

        $contentType = $response->headers->get('Content-Type', '');

        // فقط للـ HTML
        if (str_contains($contentType, 'text/html')) {
            // لا تمنع الـ cache في development
            if (!app()->environment('local')) {
                $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
                $response->headers->set('Pragma', 'no-cache');
                $response->headers->set('Expires', '0');
            }

            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        }

        $response->headers->remove('X-Powered-By');

        return $response;
    }

    private function shouldSkip(Request $request): bool
    {
        foreach ($this->excludedPaths as $pattern) {
            if ($request->is($pattern)) {
                return true;
            }
        }

        $path = $request->path();
        foreach ($this->excludedExtensions as $ext) {
            if (str_ends_with($path, $ext)) {
                return true;
            }
        }

        return false;
    }
}
