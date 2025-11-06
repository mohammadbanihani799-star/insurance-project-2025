<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="استعرض واطبع كشوفات التأمين الخاصة بك بسهولة وسرعة. خدمة آمنة وموثوقة لمراجعة مطالباتك ووثائقك.">
    <title>{{ config('app.name') }} - بيانات التأمين</title>

    {{-- DNS Prefetch للموارد الخارجية --}}
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Critical CSS Inline (Above-the-fold) --}}
    <style>
        /* Critical CSS - يُحمّل فورًا */
        *{margin:0;padding:0;box-sizing:border-box}
        html,body{font-family:'Cairo','Tajawal',sans-serif;background:#f7f9fc;overflow-x:hidden}
        .bcare-breadcrumb{background:linear-gradient(135deg,#146394 0%,#0f4570 100%);padding:3rem 0 2rem;text-align:center;color:#fff}
    </style>

    {{-- Preload Critical Fonts (WOFF2 فقط) --}}
    <link rel="preload" href="https://fonts.gstatic.com/s/cairo/v28/SLXgc1nY6HkvalIhTp2mxdt0UX8.woff2" as="font" type="font/woff2" crossorigin>
    
    {{-- Google Fonts with font-display: swap --}}
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"></noscript>

    {{-- Bootstrap & Core Styles - Preload --}}
    <link rel="preload" href="{{ asset('front_end_style/css/bootstrap.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('front_end_style/css/bootstrap.min.css') }}"></noscript>

    {{-- Page Specific Styles --}}
    @stack('styles')
</head>
<body>
    {{-- Sweet Alerts --}}
    <x-sweet-alerts />

    {{-- Main Content --}}
    @yield('content')

    {{-- Core Scripts - Deferred for better performance --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
    <script src="{{ asset('front_end_style/js/popper.min.js') }}" defer></script>
    <script src="{{ asset('front_end_style/js/bootstrap.min.js') }}" defer></script>

    {{-- Page Specific Scripts --}}
    @stack('scripts')
</body>
</html>
