<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SupportTicket;
use Illuminate\Routing\Route;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request, Route $route)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            $credentials = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];

            if (Auth::guard('super_admin')->attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                return redirect()->intended(route('super_admin.dashboard'));
            }

            return back()->withErrors([
                'email' => 'بيانات الاعتماد غير صحيحة.',
            ])->withInput($request->only('email'));

        } catch (\Throwable $th) {
            return $this->handleException($th, $route);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('super_admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('super_admin.login');
    }

    private function handleException(\Throwable $th, Route $route)
    {
        $function_name = $route->getActionName();
        
        $check_old_errors = SupportTicket::where([
            'error_location' => $th->getFile(),
            'error_description' => $th->getMessage(),
            'function_name' => $function_name,
            'error_line' => $th->getLine(),
        ])->first();

        if (!$check_old_errors) {
            $end_error_ticket = SupportTicket::create([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ]);
        } else {
            $end_error_ticket = $check_old_errors;
        }
        
        return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
    }
}
