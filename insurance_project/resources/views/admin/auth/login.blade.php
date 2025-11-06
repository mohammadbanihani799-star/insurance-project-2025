<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" data-theme="light">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex, nofollow">
        <meta name="theme-color" content="#6366f1">
        <meta name="format-detection" content="telephone=no">

        <!-- SEO Meta Tags -->
        <meta name="description" content="{{ __('auth.login_description') }}">
        <meta name="keywords" content="تسجيل دخول, لوحة تحكم, إدارة, تأمين">
        <meta name="author" content="{{ config('app.name') }}">
        <meta property="og:title" content="{{ __('auth.login_title') }} - {{ config('app.name') }}">
        <meta property="og:description" content="{{ __('auth.login_description') }}">
        <meta property="og:type" content="website">
        <meta property="og:locale" content="{{ app()->getLocale() == 'ar' ? 'ar_SA' : 'en_US' }}">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="{{ __('auth.login_title') }} - {{ config('app.name') }}">
        <meta name="twitter:description" content="{{ __('auth.login_description') }}">

        <title>{{ __('auth.login_title') }} - {{ config('app.name', 'Insurance System') }}</title>

        <!-- Preconnect for Performance -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="preconnect" href="https://cdn.jsdelivr.net">

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="alternate icon" href="{{ asset('favicon.ico') }}">

        <!-- Modern CSS Framework - Defer non-critical CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" media="print" onload="this.media='all'">
        <noscript><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></noscript>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">
        <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>

        <!-- Multi-language Font Support - Optimized with display=swap -->
        <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Tajawal:wght@300;400;500;700&display=swap">
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Tajawal:wght@300;400;500;700&display=swap"
            rel="stylesheet" media="print" onload="this.media='all'">
        <noscript><link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet"></noscript>

        <!-- Advanced Styles -->
        <style>
            :root {
                
                --primary-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
                --secondary-gradient: linear-gradient(135deg, #3b82f6 0%, #06b6d4 100%);
                --bg-primary: #ffffff;
                --bg-secondary: #f8fafc;
                --text-primary: #1e293b;
                --text-secondary: #64748b;
                --border-color: #e2e8f0;
                --input-bg: #f1f5f9;
                --input-focus-bg: #ffffff;
                --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
                --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
                --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
                --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
                --error-color: #ef4444;
                --success-color: #10b981;
                --warning-color: #f59e0b;
                --info-color: #3b82f6;

                
                --animation-fast: 150ms;
                --animation-base: 250ms;
                --animation-slow: 500ms;

               
                --font-latin: 'Inter', system-ui, -apple-system, sans-serif;
                --font-arabic: 'Tajawal', 'Inter', sans-serif;
            }

            
            [data-theme="dark"] {
                --primary-gradient: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);
                --secondary-gradient: linear-gradient(135deg, #60a5fa 0%, #34d399 100%);
                --bg-primary: #0f172a;
                --bg-secondary: #1e293b;
                --text-primary: #f1f5f9;
                --text-secondary: #cbd5e1;
                --border-color: #334155;
                --input-bg: #1e293b;
                --input-focus-bg: #334155;
                --error-color: #f87171;
                --success-color: #34d399;
                --warning-color: #fbbf24;
                --info-color: #60a5fa;
            }

            
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            html {
                font-size: 16px;
                scroll-behavior: smooth;
            }

            body {
                font-family: var(--font-latin);
                background: var(--bg-secondary);
                color: var(--text-primary);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1rem;
                transition: all var(--animation-base) ease;
                position: relative;
                overflow-x: hidden;
            }

            
            [dir="rtl"] body {
                font-family: var(--font-arabic);
            }

            
            .animated-bg {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: -1;
                background: var(--primary-gradient);
                opacity: 0.05;
            }

            .animated-bg::before,
            .animated-bg::after {
                content: '';
                position: absolute;
                border-radius: 50%;
                filter: blur(80px);
                opacity: 0.6;
            }

            .animated-bg::before {
                width: 500px;
                height: 500px;
                background: var(--primary-gradient);
                top: -200px;
                right: -200px;
                animation: float 20s ease-in-out infinite;
            }

            .animated-bg::after {
                width: 400px;
                height: 400px;
                background: var(--secondary-gradient);
                bottom: -150px;
                left: -150px;
                animation: float 15s ease-in-out infinite reverse;
            }

            @keyframes float {

                0%,
                100% {
                    transform: translate(0, 0) rotate(0deg);
                }

                33% {
                    transform: translate(30px, -30px) rotate(120deg);
                }

                66% {
                    transform: translate(-20px, 20px) rotate(240deg);
                }
            }

            
            .login-container {
                width: 100%;
                max-width: 480px;
                margin: 0 auto;
            }

            .login-card {
                background: var(--bg-primary);
                border-radius: 24px;
                box-shadow: var(--shadow-xl);
                overflow: hidden;
                position: relative;
                backdrop-filter: blur(10px);
                border: 1px solid var(--border-color);
            }

            .login-header {
                background: var(--primary-gradient);
                padding: 3rem 2rem 2rem;
                text-align: center;
                position: relative;
            }

            .logo-container {
                width: 90px;
                height: 90px;
                margin: 0 auto 1.5rem;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                backdrop-filter: blur(10px);
                border: 2px solid rgba(255, 255, 255, 0.3);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
                animation: pulse 2s ease-in-out infinite;
            }

            @keyframes pulse {
                0% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.05);
                }

                100% {
                    transform: scale(1);
                }
            }

            .logo-icon {
                font-size: 2.5rem;
                color: white;
            }

            .login-title {
                color: white;
                font-size: 1.75rem;
                font-weight: 600;
                margin-bottom: 0.5rem;
                letter-spacing: -0.5px;
            }

            .login-subtitle {
                color: rgba(255, 255, 255, 0.9);
                font-size: 0.95rem;
                font-weight: 400;
            }

            
            .controls-container {
                position: absolute;
                top: 1rem;
                inset-inline-end: 1rem;
                display: flex;
                gap: 0.5rem;
                z-index: 10;
            }

            .control-btn {
                width: 40px;
                height: 40px;
                border-radius: 12px;
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all var(--animation-fast) ease;
            }

            .control-btn:hover {
                background: rgba(255, 255, 255, 0.2);
                transform: translateY(-2px);
            }

            
            .login-body {
                padding: 2.5rem;
            }

            
            .alert-custom {
                padding: 1rem;
                border-radius: 12px;
                margin-bottom: 1.5rem;
                display: flex;
                align-items: flex-start;
                gap: 0.75rem;
                animation: slideDown var(--animation-slow) ease;
                border: 1px solid;
            }

           
            .alert-fadeout {
                opacity: 0;
                transition: opacity 400ms ease;
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .alert-error {
                background: rgba(239, 68, 68, 0.1);
                color: var(--error-color);
                border-color: rgba(239, 68, 68, 0.2);
            }

            .alert-success {
                background: rgba(16, 185, 129, 0.1);
                color: var(--success-color);
                border-color: rgba(16, 185, 129, 0.2);
            }

            .alert-warning {
                background: rgba(245, 158, 11, 0.1);
                color: var(--warning-color);
                border-color: rgba(245, 158, 11, 0.2);
            }

            .alert-info {
                background: rgba(59, 130, 246, 0.1);
                color: var(--info-color);
                border-color: rgba(59, 130, 246, 0.2);
            }

            
            .form-group {
                margin-bottom: 1.5rem;
                position: relative;
            }

            .form-label {
                display: block;
                margin-bottom: 0.5rem;
                font-size: 0.875rem;
                font-weight: 500;
                color: var(--text-secondary);
                transition: all var(--animation-fast) ease;
            }

            .form-input-wrapper {
                position: relative;
            }

            .form-input-icon {
                position: absolute;
                inset-inline-start: 1rem;
                top: 50%;
                transform: translateY(-50%);
                color: var(--text-secondary);
                font-size: 1.125rem;
                pointer-events: none;
                transition: all var(--animation-fast) ease;
            }

            .form-input {
                width: 100%;
                padding: 0.875rem 1rem 0.875rem 3rem;
                background: var(--input-bg);
                border: 2px solid transparent;
                border-radius: 12px;
                font-size: 1rem;
                color: var(--text-primary);
                transition: all var(--animation-fast) ease;
            }

            [dir="rtl"] .form-input {
                padding: 0.875rem 3rem 0.875rem 1rem;
            }

            .form-input:focus {
                outline: none;
                background: var(--input-focus-bg);
                border-color: #6366f1;
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            }

            .form-input:focus~.form-input-icon {
                color: #6366f1;
            }

            .form-input::placeholder {
                color: var(--text-secondary);
                opacity: 0.6;
            }

           
            .password-toggle {
                position: absolute;
                inset-inline-end: 1rem;
                top: 50%;
                transform: translateY(-50%);
                background: transparent;
                border: none;
                color: var(--text-secondary);
                cursor: pointer;
                padding: 0.25rem;
                font-size: 1.125rem;
                transition: all var(--animation-fast) ease;
            }

            .password-toggle:hover {
                color: #6366f1;
            }

            
            .form-input.is-invalid {
                border-color: var(--error-color);
                background: rgba(239, 68, 68, 0.05);
            }

            .form-input.is-invalid:focus {
                box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
            }

            .form-input.is-valid {
                border-color: var(--success-color);
                background: rgba(16, 185, 129, 0.05);
            }

            .form-input.is-valid:focus {
                box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            }

            .invalid-feedback {
                display: none;
                margin-top: 0.5rem;
                font-size: 0.875rem;
                color: var(--error-color);
            }

            .form-input.is-invalid~.invalid-feedback {
                display: block;
            }

            
            .form-options {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1.5rem;
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .form-check {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .form-check-input {
                width: 1.125rem;
                height: 1.125rem;
                background: var(--input-bg);
                border: 2px solid var(--border-color);
                border-radius: 4px;
                cursor: pointer;
                transition: all var(--animation-fast) ease;
                position: relative;
                appearance: none;
            }

            .form-check-input:checked {
                background: var(--primary-gradient);
                border-color: transparent;
            }

            .form-check-input:checked::after {
                content: '✓';
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                color: white;
                font-size: 0.75rem;
                font-weight: 600;
            }

            .form-check-label {
                font-size: 0.875rem;
                color: var(--text-secondary);
                cursor: pointer;
                user-select: none;
            }

            
            .btn-submit {
                width: 100%;
                padding: 0.875rem 2rem;
                background: var(--primary-gradient);
                color: white;
                border: none;
                border-radius: 12px;
                font-size: 1rem;
                font-weight: 600;
                cursor: pointer;
                transition: all var(--animation-fast) ease;
                position: relative;
                overflow: hidden;
            }

            .btn-submit:hover:not(:disabled) {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
            }

            .btn-submit:active:not(:disabled) {
                transform: translateY(0);
            }

            .btn-submit:disabled {
                opacity: 0.6;
                cursor: not-allowed;
            }

            .btn-submit-text {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .spinner {
                width: 1rem;
                height: 1rem;
                border: 2px solid rgba(255, 255, 255, 0.3);
                border-top-color: white;
                border-radius: 50%;
                animation: spin 0.6s linear infinite;
            }

            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }

           
            .login-footer {
                padding: 1.5rem 2.5rem;
                background: var(--bg-secondary);
                text-align: center;
                border-top: 1px solid var(--border-color);
            }

            .footer-text {
                font-size: 0.875rem;
                color: var(--text-secondary);
            }

            .footer-link {
                color: #6366f1;
                text-decoration: none;
                font-weight: 500;
                transition: all var(--animation-fast) ease;
            }

            .footer-link:hover {
                color: #8b5cf6;
                text-decoration: underline;
            }

            
            .divider {
                display: flex;
                align-items: center;
                margin: 1.5rem 0;
                gap: 1rem;
            }

            .divider-line {
                flex: 1;
                height: 1px;
                background: var(--border-color);
            }

            .divider-text {
                font-size: 0.875rem;
                color: var(--text-secondary);
                font-weight: 500;
            }

            .biometric-options {
                display: flex;
                gap: 1rem;
                justify-content: center;
            }

            .biometric-btn {
                width: 50px;
                height: 50px;
                border-radius: 12px;
                background: var(--input-bg);
                border: 2px solid var(--border-color);
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all var(--animation-fast) ease;
                font-size: 1.25rem;
                color: var(--text-secondary);
            }

            .biometric-btn:hover {
                background: var(--primary-gradient);
                border-color: transparent;
                color: white;
                transform: translateY(-2px);
            }

            
            .password-strength {
                display: flex;
                gap: 0.25rem;
                margin-top: 0.5rem;
                height: 4px;
            }

            .strength-bar {
                flex: 1;
                background: var(--border-color);
                border-radius: 2px;
                transition: all var(--animation-fast) ease;
            }

            .strength-weak .strength-bar:nth-child(1) {
                background: var(--error-color);
            }

            .strength-medium .strength-bar:nth-child(1),
            .strength-medium .strength-bar:nth-child(2) {
                background: var(--warning-color);
            }

            .strength-strong .strength-bar:nth-child(1),
            .strength-strong .strength-bar:nth-child(2),
            .strength-strong .strength-bar:nth-child(3) {
                background: var(--success-color);
            }

            
            .loading-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(5px);
                display: none;
                align-items: center;
                justify-content: center;
                z-index: 9999;
            }

            .loading-overlay.active {
                display: flex;
            }

            .loading-spinner {
                width: 50px;
                height: 50px;
                border: 4px solid rgba(255, 255, 255, 0.3);
                border-top-color: white;
                border-radius: 50%;
                animation: spin 0.8s linear infinite;
            }

            
            @media (max-width: 640px) {
                .login-body {
                    padding: 1.5rem;
                }

                .login-header {
                    padding: 2rem 1.5rem 1.5rem;
                }
            }

            
            .visually-hidden {
                position: absolute;
                width: 1px;
                height: 1px;
                padding: 0;
                margin: -1px;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
                white-space: nowrap;
                border: 0;
            }

            /* Focus Visible */
            *:focus-visible {
                outline: 2px solid #6366f1;
                outline-offset: 2px;
            }

            /* Reduced Motion */
            @media (prefers-reduced-motion: reduce) {

                *,
                *::before,
                *::after {
                    animation-duration: 0.01ms !important;
                    animation-iteration-count: 1 !important;
                    transition-duration: 0.01ms !important;
                    scroll-behavior: auto !important;
                }
            }

            /* Print Styles */
            @media print {
                body {
                    display: none;
                }
            }
        </style>
    </head>

    <body>
        <!-- Skip to main content for accessibility -->
        <a href="#loginForm" class="visually-hidden">تخطي إلى المحتوى الرئيسي</a>

        <!-- Animated Background -->
        <div class="animated-bg" aria-hidden="true"></div>

        <!-- Loading Overlay -->
        <div class="loading-overlay" id="loadingOverlay" role="status" aria-live="polite" aria-label="جاري التحميل">
            <div class="loading-spinner"></div>
        </div>

        <!-- Login Container -->
        <div class="login-container">
            <div class="login-card" role="main">
                <!-- Login Header -->
                <div class="login-header">
                    <!-- Language & Theme Controls -->
                    <div class="controls-container">
                        <button class="control-btn" onclick="toggleLanguage()" title="{{ __('auth.switch_language') }}" aria-label="تغيير اللغة">
                            <i class="fas fa-language" aria-hidden="true"></i>
                        </button>
                        <button class="control-btn" onclick="toggleTheme()" title="{{ __('auth.switch_theme') }}" aria-label="تغيير الوضع">
                            <i class="fas fa-moon" id="themeIcon" aria-hidden="true"></i>
                        </button>
                    </div>

                    <!-- Logo -->
                    <div class="logo-container">
                        <i class="fas fa-shield-alt logo-icon"></i>
                    </div>

                    <!-- Title -->
                    <h1 class="login-title">{{ __('auth.admin_panel') }}</h1>
                </div>

                <!-- Login Body -->
                <div class="login-body">
                    <!-- Alert Messages -->
                    @if ($errors->any())
                        <div class="alert-custom alert-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <div>
                                <strong>{{ __('auth.errors_found') }}</strong>
                                <ul style="margin: 0.5rem 0 0; padding-left: 1.25rem;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert-custom alert-success">
                            <i class="fas fa-check-circle"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="alert-custom alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div>{{ session('warning') }}</div>
                        </div>
                    @endif

                    @if (session('info'))
                        <div class="alert-custom alert-info">
                            <i class="fas fa-info-circle"></i>
                            <div>{{ session('info') }}</div>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('super_admin.loginFormSubmit') }}" id="loginForm"
                        autocomplete="on" novalidate aria-label="نموذج تسجيل الدخول">
                        @csrf

                        <!-- Email Field -->
                        <div class="form-group">
                            <label for="email" class="form-label">{{ __('auth.email') }}</label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-envelope form-input-icon" aria-hidden="true"></i>
                                <input type="email" id="email" name="email"
                                    class="form-input @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    placeholder="{{ __('auth.email_placeholder') }}" required autocomplete="email"
                                    aria-label="{{ __('auth.email') }}" aria-describedby="emailHelp" aria-required="true"
                                    aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                                    tabindex="1">
                                <div class="invalid-feedback" role="alert">
                                    {{ __('auth.email_invalid') }}
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="form-group">
                            <label for="password" class="form-label">{{ __('auth.password_label') }}</label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-lock form-input-icon" aria-hidden="true"></i>
                                <input type="password" id="password" name="password"
                                    class="form-input @error('password') is-invalid @enderror"
                                    placeholder="{{ __('auth.password_placeholder') }}" required
                                    autocomplete="current-password" aria-label="{{ __('auth.password_label') }}"
                                    aria-describedby="passwordHelp" aria-required="true"
                                    aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                                    tabindex="2">
                                <button type="button" class="password-toggle" onclick="togglePassword()" tabindex="-1" aria-label="إظهار/إخفاء كلمة المرور">
                                    <i class="far fa-eye" id="toggleIcon" aria-hidden="true"></i>
                                </button>
                                <div class="invalid-feedback" role="alert">
                                    {{ __('auth.password_invalid') }}
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="password-strength" id="passwordStrength" style="display: none;">
                                <div class="strength-bar"></div>
                                <div class="strength-bar"></div>
                                <div class="strength-bar"></div>
                            </div>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="form-options">
                            <div class="form-check">
                                <input type="checkbox" id="remember" name="remember" class="form-check-input"
                                    {{ old('remember') ? 'checked' : '' }} tabindex="3">
                                <label for="remember" class="form-check-label">
                                    {{ __('auth.remember_me') }}
                                </label>
                            </div>
                        </div>

                        <!-- reCAPTCHA (if enabled) -->
                        @if(config('services.recaptcha.enabled'))
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                            </div>
                        @endif

                        <!-- Submit Button -->
                        <button type="submit" class="btn-submit" id="loginBtn" tabindex="5">
                            <span class="btn-submit-text" id="loginText">
                                <i class="fas fa-sign-in-alt"></i>
                                {{ __('auth.login_button') }}
                            </span>
                            <span class="btn-submit-text" id="loginSpinner" style="display: none;">
                                <span class="spinner"></span>
                                {{ __('auth.logging_in') }}
                            </span>
                        </button>
                    </form>

                    <!-- Biometric Login Options -->
                    <div class="biometric-options">
                        @if(config('auth.biometric.fingerprint'))
                            <button class="biometric-btn" onclick="biometricLogin('fingerprint')"
                                title="{{ __('auth.fingerprint_login') }}">
                                <i class="fas fa-fingerprint"></i>
                            </button>
                        @endif

                        @if(config('auth.biometric.face'))
                            <button class="biometric-btn" onclick="biometricLogin('face')"
                                title="{{ __('auth.face_login') }}">
                                <i class="fas fa-camera"></i>
                            </button>
                        @endif

                        @if(config('auth.social.google'))
                            <button class="biometric-btn" onclick="socialLogin('google')"
                                title="{{ __('auth.google_login') }}">
                                <i class="fab fa-google"></i>
                            </button>
                        @endif

                        @if(config('auth.social.microsoft'))
                            <button class="biometric-btn" onclick="socialLogin('microsoft')"
                                title="{{ __('auth.microsoft_login') }}">
                                <i class="fab fa-microsoft"></i>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Login Footer -->
                <div class="login-footer">
                    <p class="footer-text">
                        {{ __('auth.footer_copyright') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Structured Data for SEO -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "name": "{{ __('auth.login_title') }}",
            "description": "{{ __('auth.login_description') }}",
            "url": "{{ url()->current() }}",
            "inLanguage": "{{ app()->getLocale() }}",
            "isPartOf": {
                "@type": "WebSite",
                "name": "{{ config('app.name') }}",
                "url": "{{ url('/') }}"
            }
        }
        </script>

        <!-- Scripts - Defer for better performance -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>

        <!-- reCAPTCHA -->
        @if(config('services.recaptcha.enabled'))
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        @endif

        <!-- WebAuthn for Biometric -->
        @if(config('auth.biometric.enabled'))
            <script src="https://cdn.jsdelivr.net/npm/@simplewebauthn/browser@7.0.1/dist/bundle/index.min.js" defer></script>
        @endif

        <script>
            // Configuration
            const config = {
                passwordMinLength: 8,
                enableBiometric: {{ config('auth.biometric.enabled', false) ? 'true' : 'false' }},
                sessionTimeout: {{ config('session.lifetime', 120) }} * 60 * 1000, // Convert to milliseconds
                maxLoginAttempts: {{ config('auth.max_attempts', 5) }},
                lockoutTime: {{ config('auth.lockout_time', 15) }},
                csrfToken: '{{ csrf_token() }}',
                locale: '{{ app()->getLocale() }}',
                translations: {
                    passwordWeak: '{{ __("auth.password_weak") }}',
                    passwordMedium: '{{ __("auth.password_medium") }}',
                    passwordStrong: '{{ __("auth.password_strong") }}',
                    emailRequired: '{{ __("auth.email_required") }}',
                    passwordRequired: '{{ __("auth.password_required") }}',
                    invalidCredentials: '{{ __("auth.invalid_credentials") }}',
                    sessionExpired: '{{ __("auth.session_expired") }}',
                    networkError: '{{ __("auth.network_error") }}',
                }
            };

            // Theme Management
            const themeManager = {
                init() {
                    const savedTheme = localStorage.getItem( 'theme' ) || 'light';
                    this.setTheme( savedTheme );
                },

                setTheme( theme ) {
                    document.documentElement.setAttribute( 'data-theme', theme );
                    localStorage.setItem( 'theme', theme );
                    const icon = document.getElementById( 'themeIcon' );
                    if ( icon ) {
                        icon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
                    }
                },

                toggle() {
                    const currentTheme = document.documentElement.getAttribute( 'data-theme' );
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    this.setTheme( newTheme );
                }
            };

            // Language Management
            const languageManager = {
                toggle() {
                    const currentLang = config.locale;
                    const newLang = currentLang === 'ar' ? 'en' : 'ar';
                    // In production, this would make an API call to change language
                    window.location.href = `/lang/${ newLang }`;
                }
            };

            // Password Management
            const passwordManager = {
                toggle() {
                    const field = document.getElementById( 'password' );
                    const icon = document.getElementById( 'toggleIcon' );

                    if ( field.type === 'password' ) {
                        field.type = 'text';
                        icon.className = 'far fa-eye-slash';
                    } else {
                        field.type = 'password';
                        icon.className = 'far fa-eye';
                    }
                },

                checkStrength( password ) {
                    let strength = 0;

                    if ( password.length >= config.passwordMinLength ) strength++;
                    if ( password.match( /[a-z]+/ ) ) strength++;
                    if ( password.match( /[A-Z]+/ ) ) strength++;
                    if ( password.match( /[0-9]+/ ) ) strength++;
                    if ( password.match( /[$@#&!]+/ ) ) strength++;

                    const strengthBar = document.getElementById( 'passwordStrength' );
                    if ( strengthBar ) {
                        strengthBar.style.display = password.length > 0 ? 'flex' : 'none';
                        strengthBar.className = 'password-strength';

                        if ( password.length > 0 ) {
                            if ( strength <= 2 ) {
                                strengthBar.classList.add( 'strength-weak' );
                            } else if ( strength <= 3 ) {
                                strengthBar.classList.add( 'strength-medium' );
                            } else {
                                strengthBar.classList.add( 'strength-strong' );
                            }
                        }
                    }

                    return strength;
                }
            };

            // Form Validation
            const formValidator = {
                validateEmail( email ) {
                    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return pattern.test( email );
                },

                validatePassword( password ) {
                    return password.length >= 6;
                },

                validateForm() {
                    const email = document.getElementById( 'email' );
                    const password = document.getElementById( 'password' );
                    let isValid = true;

                    // Email validation
                    if ( !email.value || !this.validateEmail( email.value ) ) {
                        email.classList.add( 'is-invalid' );
                        email.classList.remove( 'is-valid' );
                        isValid = false;
                    } else {
                        email.classList.remove( 'is-invalid' );
                        email.classList.add( 'is-valid' );
                    }

                    // Password validation
                    if ( !password.value || !this.validatePassword( password.value ) ) {
                        password.classList.add( 'is-invalid' );
                        password.classList.remove( 'is-valid' );
                        isValid = false;
                    } else {
                        password.classList.remove( 'is-invalid' );
                        password.classList.add( 'is-valid' );
                    }

                    return isValid;
                }
            };

            // Biometric Authentication
            const biometricAuth = {
                async login( type ) {
                    if ( !config.enableBiometric ) {
                        alert( config.translations.biometricNotEnabled );
                        return;
                    }

                    // Show loading
                    document.getElementById( 'loadingOverlay' ).classList.add( 'active' );

                    try {
                        if ( type === 'fingerprint' || type === 'face' ) {
                            // WebAuthn implementation
                            if ( !window.PublicKeyCredential ) {
                                throw new Error( 'WebAuthn not supported' );
                            }

                            // In production, this would make an API call
                            console.log( `Initiating ${ type } authentication...` );
                        }
                    } catch ( error ) {
                        console.error( 'Biometric authentication failed:', error );
                        alert( config.translations.biometricFailed );
                    } finally {
                        document.getElementById( 'loadingOverlay' ).classList.remove( 'active' );
                    }
                }
            };

            // Social Login
            const socialAuth = {
                login( provider ) {
                    window.location.href = `/auth/${ provider }`;
                }
            };

            // Main Application
            const app = {
                init() {
                    // Initialize theme
                    themeManager.init();

                    // Setup event listeners
                    this.setupEventListeners();

                    // Auto-focus
                    document.getElementById( 'email' ).focus();

                    // Setup session timeout warning
                    this.setupSessionTimeout();

                    // Check for browser compatibility
                    this.checkCompatibility();
                },

                setupEventListeners() {
                    // Form submission
                    const form = document.getElementById( 'loginForm' );
                    if ( form ) {
                        form.addEventListener( 'submit', ( e ) => {
                            if ( !formValidator.validateForm() ) {
                                e.preventDefault();
                                return false;
                            }

                            // Show loading state
                            const btn = document.getElementById( 'loginBtn' );
                            const text = document.getElementById( 'loginText' );
                            const spinner = document.getElementById( 'loginSpinner' );

                            btn.disabled = true;
                            text.style.display = 'none';
                            spinner.style.display = 'inline-flex';
                        } );
                    }

                    // Email input
                    const emailInput = document.getElementById( 'email' );
                    if ( emailInput ) {
                        emailInput.addEventListener( 'input', function () {
                            this.classList.remove( 'is-invalid', 'is-valid' );
                        } );

                        emailInput.addEventListener( 'keypress', ( e ) => {
                            if ( e.key === 'Enter' ) {
                                e.preventDefault();
                                document.getElementById( 'password' ).focus();
                            }
                        } );
                    }

                    // Password input
                    const passwordInput = document.getElementById( 'password' );
                    if ( passwordInput ) {
                        passwordInput.addEventListener( 'input', function () {
                            this.classList.remove( 'is-invalid', 'is-valid' );
                            passwordManager.checkStrength( this.value );
                        } );
                    }

                    // Keyboard navigation
                    document.addEventListener( 'keydown', ( e ) => {
                        if ( e.key === 'Escape' ) {
                            // Clear any modals or overlays
                            document.getElementById( 'loadingOverlay' ).classList.remove( 'active' );
                        }
                    } );
                },

                setupSessionTimeout() {
                    let timeoutWarning;
                    let timeoutLogout;

                    const resetTimeout = () => {
                        clearTimeout( timeoutWarning );
                        clearTimeout( timeoutLogout );

                        // Warning after 90% of session time
                        timeoutWarning = setTimeout( () => {
                            if ( confirm( config.translations.sessionExpiring ) ) {
                                // Refresh session
                                fetch( '/api/refresh-session', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': config.csrfToken
                                    }
                                } );
                                resetTimeout();
                            }
                        }, config.sessionTimeout * 0.9 );

                        // Auto logout after full session time
                        timeoutLogout = setTimeout( () => {
                            window.location.href = '/logout';
                        }, config.sessionTimeout );
                    };

                    // Reset on user activity
                    [ 'mousedown', 'keypress', 'scroll', 'touchstart' ].forEach( event => {
                        document.addEventListener( event, resetTimeout );
                    } );

                    resetTimeout();
                },

                checkCompatibility() {
                    const features = {
                        'WebAuthn': window.PublicKeyCredential,
                        'LocalStorage': window.localStorage,
                        'Fetch API': window.fetch,
                    };

                    const unsupported = Object.entries( features )
                        .filter( ( [ feature, support ] ) => !support )
                        .map( ( [ feature ] ) => feature );

                    if ( unsupported.length > 0 ) {
                        console.warn( 'Unsupported features:', unsupported );
                    }
                }
            };

            // Global Functions
            window.toggleTheme = () => themeManager.toggle();
            window.toggleLanguage = () => languageManager.toggle();
            window.togglePassword = () => passwordManager.toggle();
            window.biometricLogin = ( type ) => biometricAuth.login( type );
            window.socialLogin = ( provider ) => socialAuth.login( provider );

            // Initialize on DOM ready
            document.addEventListener( 'DOMContentLoaded', () => {
                app.init();
                
                // Set focus on email field after page load (avoiding autofocus attribute)
                setTimeout(() => {
                    const emailField = document.getElementById('email');
                    if (emailField && !emailField.value) {
                        emailField.focus();
                    }
                }, 100);
            });

            // Auto-dismiss alerts after a short delay
            document.addEventListener('DOMContentLoaded', () => {
                const alerts = document.querySelectorAll('.alert-custom');
                alerts.forEach((el) => {
                    // Dismiss after 4 seconds
                    setTimeout(() => {
                        el.classList.add('alert-fadeout');
                        // Remove from DOM after transition
                        setTimeout(() => el.remove(), 450);
                    }, 4000);
                });
            });

            // Service Worker for PWA - TEMPORARILY DISABLED
            if ( 'serviceWorker' in navigator ) {
                // Unregister existing service workers
                navigator.serviceWorker.getRegistrations().then(function(registrations) {
                    for(let registration of registrations) {
                        registration.unregister();
                        console.log('✅ Service Worker unregistered');
                    }
                });
                
                // Clear all caches
                if ('caches' in window) {
                    caches.keys().then(keys => {
                        keys.forEach(key => caches.delete(key));
                        console.log('✅ All caches cleared');
                    });
                }
            }
        </script>
    </body>

</html>
