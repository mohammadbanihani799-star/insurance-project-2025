<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminLoginController extends Controller
{

    public function showLoginForm()
    {
        if (Auth::guard('super_admin')->check()) {
            return redirect()->intended(route('super_admin.dashboard'));
        } elseif (Auth::guard('user')->check()) {
            return redirect()->intended(route('super_admin.dashboard')); // نفس الوجهة حسب كودك
        }

        return view('admin.auth.login');
    }


    public function loginFormSubmit(Request $request)
    {
        // 1) التحقق من المدخلات (يزيل تحذير Intelephense)
        $validated = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
            'remember' => ['nullable'],
        ]);

        // 2) تجهيز الـ credentials و خيار التذكّر
        $credentials = [
            'email'    => $validated['email'],
            'password' => $validated['password'],
        ];
        $remember = $request->boolean('remember');

        // 3) محاولة الدخول عبر الحراس بالترتيب
        foreach (['super_admin', 'user'] as $guard) {
            if (Auth::guard($guard)->attempt($credentials, $remember)) {
                // تأمين الجلسة
                $request->session()->regenerate();
                // ملاحظة: حسب كودك الوجهة نفسها
                return redirect()->intended(route('super_admin.dashboard'));
            }
        }

        // 4) فشل تسجيل الدخول
        return back()
            ->withErrors(['email' => __('auth.invalid_credentials')])
            ->onlyInput('email');
    }


    public function logout()
    {
        if (Auth::guard('super_admin')->check()) {
            Auth::guard('super_admin')->logout();
        } elseif (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
        }

        // إنهاء الجلسة الحالية وحمايتها
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}
