<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="description" content="BCare Insurance - تأمين المركبات، المنازل، الطبي - الوسيط المعتمد في المملكة العربية السعودية">
    <title>BCare Insurance | تأمين المركبات والمنازل</title>
    <link rel="shortcut icon" href="{{ asset('style_files/frontend/img/logo.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('style_files/frontend/img/logo.png') }}" type="image/png">
    {{-- <link rel="manifest" href="{{ asset('manifest.webmanifest') }}"> --}}
    
    {{-- 🔥 FORCE DISABLE SERVICE WORKER - Emergency Fix --}}
    <script>
        // This runs IMMEDIATELY before anything else
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.getRegistrations().then(function(registrations) {
                for(let registration of registrations) {
                    registration.unregister();
                }
            });
        }
        if ('caches' in window) {
            caches.keys().then(function(names) {
                for (let name of names) caches.delete(name);
            });
        }
    </script>

    {{-- 🚀 Performance: Preconnect to external domains --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">

    @stack('head-critical')

    {{-- 🎨 Critical CSS only - defer non-critical --}}
    {{-- Vite: All CSS & JS bundled with cache-busting --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- 📱 Mobile Organization CSS - Critical for responsive design --}}
    <link rel="stylesheet" href="{{ asset('css/mobile-organization.css') }}">

    {{-- ⚡ Defer non-critical CSS with async loading --}}
    <link rel="preload" href="{{ asset('style_files/frontend/css/normalize.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('style_files/frontend/css/normalize.css') }}"></noscript>

    <link rel="preload" href="{{ asset('style_files/frontend/css/bc.fonts.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('style_files/frontend/css/bc.fonts.css') }}"></noscript>

    {{-- 🔤 Defer icon fonts (not critical for FCP/LCP) --}}
    <link rel="preload" href="https://fonts.googleapis.com/icon?family=Material+Icons" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"></noscript>

    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"></noscript>

    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.compat.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.compat.css"></noscript>

    {{-- Styles pushed from partials (e.g., homeHeader) --}}
    @stack('styles')

    @stack('page-vendors-css')

    @stack('page-css')

    {{-- ⚡ Defer utility CSS --}}
    <link rel="preload" href="{{ asset('style_files/frontend/css/tailwind.css') }}?v={{ config('app.asset_version', '20251104') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('style_files/frontend/css/tailwind.css') }}?v={{ config('app.asset_version', '20251104') }}"></noscript>

    <link rel="preload" href="{{ asset('style_files/frontend/css/responsive.css') }}?v={{ config('app.asset_version', '20251104') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('style_files/frontend/css/responsive.css') }}?v={{ config('app.asset_version', '20251104') }}"></noscript>
</head>

<body>
