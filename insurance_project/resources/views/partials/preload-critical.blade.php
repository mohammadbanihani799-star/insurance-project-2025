{{--
    ======================================================================
    BCare Performance Optimization - Preload Critical Resources
    ======================================================================
    يتم تضمين هذا الملف في <head> لتحميل الموارد الحرجة مبكراً
    - الخطوط العربية (woff2)
    - BC CSS Bundle المدمج
    ======================================================================
--}}

{{-- Preload Critical Fonts: DISABLED - Using Google Fonts CDN instead --}}
{{--
Note: Local font files are missing/corrupted causing "OTS parsing error: invalid sfntVersion"
Google Fonts CDN is used in bc.fonts.css: @import url('https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;600&display=swap');

<link rel="preload" href="{{ asset('style_files/frontend/fonts/NotoKufiArabic-Regular.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ asset('style_files/frontend/fonts/NotoKufiArabic-SemiBold.woff2') }}" as="font" type="font/woff2" crossorigin>
--}}

{{-- Preload BC Bundle --}}
<link rel="preload" href="{{ asset('style_files/frontend/css/bc.bundle.min.css') }}?v={{ config('app.asset_version', '20251104') }}" as="style">

{{-- Load BC Bundle (Critical CSS) --}}
<link rel="stylesheet" href="{{ asset('style_files/frontend/css/bc.bundle.min.css') }}?v={{ config('app.asset_version', '20251104') }}" media="all">
