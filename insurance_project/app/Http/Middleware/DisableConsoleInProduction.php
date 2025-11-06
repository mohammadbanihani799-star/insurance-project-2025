<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DisableConsoleInProduction
{
    /**
     * Disable browser console and prevent code inspection in production.
     * Adds JavaScript to detect and disable DevTools.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only inject console protection for HTML responses
        if ($this->shouldInjectProtection($response)) {
            $content = $response->getContent();
            
            // Inject console protection script before </body>
            $protectionScript = $this->getConsoleProtectionScript();
            $content = str_replace('</body>', $protectionScript . '</body>', $content);
            
            $response->setContent($content);
        }

        return $response;
    }

    /**
     * Check if we should inject protection into this response
     */
    private function shouldInjectProtection(Response $response): bool
    {
        // Only for production and HTML responses
        if (! app()->environment('production')) {
            return false;
        }

        $contentType = $response->headers->get('Content-Type', '');
        
        return str_contains($contentType, 'text/html');
    }

    /**
     * Get the console protection JavaScript
     */
    private function getConsoleProtectionScript(): string
    {
        return <<<'HTML'
<script>
    // حماية Console من السرقة والتجسس
    (function() {
        'use strict';
        
        // 1. تعطيل النقر بالزر الأيمن
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            return false;
        });
        
        // 2. تعطيل اختصارات لوحة المفاتيح الخاصة بـ DevTools
        document.addEventListener('keydown', function(e) {
            // F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U, Ctrl+Shift+C
            if (
                e.keyCode === 123 || // F12
                (e.ctrlKey && e.shiftKey && e.keyCode === 73) || // Ctrl+Shift+I
                (e.ctrlKey && e.shiftKey && e.keyCode === 74) || // Ctrl+Shift+J
                (e.ctrlKey && e.keyCode === 85) || // Ctrl+U
                (e.ctrlKey && e.shiftKey && e.keyCode === 67) // Ctrl+Shift+C
            ) {
                e.preventDefault();
                return false;
            }
        });
        
        // 3. كشف فتح DevTools عن طريق قياس الوقت
        let devtoolsOpen = false;
        const threshold = 160;
        
        setInterval(function() {
            const widthThreshold = window.outerWidth - window.innerWidth > threshold;
            const heightThreshold = window.outerHeight - window.innerHeight > threshold;
            
            if (widthThreshold || heightThreshold) {
                if (!devtoolsOpen) {
                    devtoolsOpen = true;
                    // إعادة توجيه أو إخفاء المحتوى
                    document.body.innerHTML = '<h1 style="text-align:center;padding-top:100px;">⚠️ الوصول غير مصرح به</h1>';
                }
            } else {
                devtoolsOpen = false;
            }
        }, 500);
        
        // 4. تعطيل console methods
        const noop = function() {};
        const methods = ['log', 'debug', 'info', 'warn', 'error', 'table', 'trace', 'dir', 'dirxml', 'group', 'groupCollapsed', 'groupEnd', 'clear', 'count', 'countReset', 'assert', 'profile', 'profileEnd', 'time', 'timeLog', 'timeEnd', 'timeStamp'];
        
        if (window.console) {
            methods.forEach(function(method) {
                if (typeof window.console[method] === 'function') {
                    window.console[method] = noop;
                }
            });
        }
        
        // 5. حماية من debugger
        setInterval(function() {
            (function() {
                return false;
            })['constructor']('debugger')();
        }, 50);
        
        // 6. منع تحديد النص (اختياري)
        document.addEventListener('selectstart', function(e) {
            if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') {
                e.preventDefault();
                return false;
            }
        });
        
        // 7. منع النسخ (اختياري)
        document.addEventListener('copy', function(e) {
            e.preventDefault();
            return false;
        });
        
    })();
</script>
HTML;
    }
}
