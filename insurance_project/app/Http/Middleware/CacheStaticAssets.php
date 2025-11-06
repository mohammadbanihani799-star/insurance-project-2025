<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheStaticAssets
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // طبّق كاش قوي على ملفات build فقط (365 يوم)
        if (str_starts_with($request->getPathInfo(), '/build/')) {
            $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
            
            // إضافة ETag للتحقق من التغييرات
            $etag = md5($response->getContent());
            $response->headers->set('ETag', $etag);
            
            // التحقق من If-None-Match
            if ($request->header('If-None-Match') === $etag) {
                return response('', 304);
            }
        }

        return $response;
    }
}
