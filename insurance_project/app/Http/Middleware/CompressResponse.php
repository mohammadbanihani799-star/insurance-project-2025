<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompressResponse
{
    /**
     * Handle an incoming request and compress the response if possible
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if client accepts gzip
        $acceptEncoding = $request->header('Accept-Encoding', '');
        if (stripos($acceptEncoding, 'gzip') === false) {
            return $next($request);
        }

        // Start output buffering with gzip compression
        if (!ob_start('ob_gzhandler')) {
            // If ob_gzhandler fails, proceed without compression
            return $next($request);
        }

        $response = $next($request);

        // End output buffering and get compressed content
        if (ob_get_level() > 0) {
            ob_end_flush();
        }

        return $response;
    }

    /**
     * Determine if the response should be compressed
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @return bool
     */
    private function shouldCompress(Request $request, Response $response): bool
    {
        // Check if client accepts gzip
        $acceptEncoding = $request->header('Accept-Encoding', '');
        if (stripos($acceptEncoding, 'gzip') === false) {
            return false;
        }

        // Check if response is successful
        if (!$response->isSuccessful()) {
            return false;
        }

        // Check if already compressed
        if ($response->headers->has('Content-Encoding')) {
            return false;
        }

        // Check if content type is compressible
        $contentType = $response->headers->get('Content-Type', '');
        $compressibleTypes = [
            'text/html',
            'text/css',
            'text/javascript',
            'text/plain',
            'text/xml',
            'application/javascript',
            'application/x-javascript',
            'application/json',
            'application/xml',
            'application/xhtml+xml',
            'image/svg+xml',
        ];

        foreach ($compressibleTypes as $type) {
            if (stripos($contentType, $type) !== false) {
                return true;
            }
        }

        return false;
    }
}
