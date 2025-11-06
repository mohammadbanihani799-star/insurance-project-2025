<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Throwable;
use Exception;

class Handler extends ExceptionHandler
{
    protected $levels = [
        // ...
    ];

    protected $dontReport = [
        // ...
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
        // حساسة إضافية:
        'nafath_code',
        'otp',
        'token',
        'secret',
    ];

    public function register(): void
    {
        // مثال: لو حاب تستخدم reportable لـ Sentry لاحقاً
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        // ============ CSRF (419) ============
        if ($exception instanceof TokenMismatchException) {
            if ($this->wantsJson($request)) {
                return response()->json([
                    'ok' => false,
                    'code' => 'CSRF_TOKEN_MISMATCH',
                    'message' => __('انتهت صلاحية الجلسة. من فضلك أعد المحاولة.')
                ], 422);
            }

            // منطقة الأدمن → لصفحة الدخول
            if ($request->is('super_admin/*') || $request->routeIs('super_admin.*')) {
                // حاول super_admin.loginUser ثم fallback إلى super_admin.login إن موجود
                $loginRoute = null;
                if ($this->routeExists('super_admin.loginUser')) {
                    $loginRoute = 'super_admin.loginUser';
                } elseif ($this->routeExists('super_admin.login')) {
                    $loginRoute = 'super_admin.login';
                }

                if ($loginRoute) {
                    return redirect()->route($loginRoute)
                        ->with('error', __('انتهت الجلسة لأسباب أمنية. يرجى تسجيل الدخول والمحاولة مجددًا.'));
                }

                // fallback آمن
                return redirect('/')->with('error', __('انتهت الجلسة. يرجى تسجيل الدخول.'));
            }

            // عام: رجوع للصفحة السابقة بدون التوكن
            return redirect()->back()
                ->withInput($request->except('_token'))
                ->with('error', __('انتهت الجلسة. يرجى إعادة المحاولة.'));
        }

        // ============ Validation (422) ============
        if ($exception instanceof ValidationException) {
            if ($this->wantsJson($request)) {
                return response()->json([
                    'ok' => false,
                    'code' => 'VALIDATION_ERROR',
                    'message' => __('هناك بيانات غير صحيحة، من فضلك راجع الحقول.'),
                    'errors' => $exception->errors(),
                ], 422);
            }
            // السلوك الافتراضي: redirect back مع errors
        }

        // ============ Throttle (429) ============
        if ($exception instanceof ThrottleRequestsException) {
            $retryAfter = (int) ($exception->getHeaders()['Retry-After'] ?? 60);
            if ($this->wantsJson($request)) {
                return response()->json([
                    'ok' => false,
                    'code' => 'TOO_MANY_REQUESTS',
                    'message' => __('محاولات كثيرة. الرجاء المحاولة لاحقًا.'),
                    'retry_after' => $retryAfter,
                ], 429);
            }
            return response()->view('errors.429', [
                'message' => __('محاولات كثيرة. الرجاء المحاولة لاحقًا.'),
                'retry_after' => $retryAfter,
            ], 429);
        }

        // ============ HTTP Exceptions ============
        if ($exception instanceof HttpExceptionInterface) {
            $status = $exception->getStatusCode();

            // 404
            if ($status === 404 || $exception instanceof NotFoundHttpException || $exception instanceof ModelNotFoundException) {
                if ($this->wantsJson($request)) {
                    return response()->json([
                        'ok' => false,
                        'code' => 'NOT_FOUND',
                        'message' => __('العنصر المطلوب غير موجود.')
                    ], 404);
                }

                // إن أردت “تلطيف” في الأدمن: أرسل المستخدم للداشبورد بشرط تجنب Loop
                if (($request->is('super_admin/*') || $request->routeIs('super_admin.*'))
                    && (Auth::guard('super_admin')->check() || Auth::guard('user')->check())
                ) {
                    $dashboardRoute = $this->routeExists('super_admin.dashboard') ? route('super_admin.dashboard') : '/';
                    if ($request->fullUrlIs($dashboardRoute.'*')) {
                        // لا تعيد توجيه لنفسه
                        return response()->view('errors.404', ['message' => __('العنصر المطلوب غير موجود.')], 404);
                    }
                    return redirect()->intended($dashboardRoute);
                }

                // صفحة 404 نظيفة
                return response()->view('errors.404', [
                    'message' => __('العنصر المطلوب غير موجود.')
                ], 404);
            }

            // 405
            if ($exception instanceof MethodNotAllowedHttpException) {
                if ($this->wantsJson($request)) {
                    return response()->json([
                        'ok' => false,
                        'code' => 'METHOD_NOT_ALLOWED',
                        'message' => __('طريقة الطلب غير مسموح بها لهذا المسار.')
                    ], 405);
                }
                return response()->view('errors.405', [
                    'message' => __('طريقة الطلب غير مسموح بها لهذا المسار.')
                ], 405);
            }
        }

        return parent::render($request, $exception);
    }

    /**
     * هل الطلب يتوقع JSON؟
     */
    protected function wantsJson(Request $request): bool
    {
        return $request->expectsJson() || $request->wantsJson() || $request->is('api/*');
    }

    /**
     * فحص وجود route بالاسم لتفادي 500 إن الاسم غير موجود.
     */
    protected function routeExists(string $name): bool
    {
        try {
            return app('router')->has($name);
        } catch (Exception $e) {
            return false;
        }
    }
}
