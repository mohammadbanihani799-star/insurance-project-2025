    {{-- ⚡ Load scripts in optimal order --}}
    @vite(['resources/js/app.js'])

    {{-- 📦 Defer heavy libraries to improve FCP/LCP --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" defer></script>

    {{-- 🎯 Main.js after Vite bundle --}}
    <script src="{{ asset('style_files/frontend/js/main.js') }}" defer></script>

    {{-- 📱 Mobile Layout Fixer - High Priority --}}
    <script src="{{ asset('js/mobile-layout-fixer.js') }}"></script>

    {{-- three.min.js (558 KB) removed - not used in the application --}}

    @stack('page-vendors-js')

    <script>
    // ⚠️ DISABLE SERVICE WORKER - Clear all caches and unregister
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.getRegistrations().then(function(registrations) {
            for(let registration of registrations) {
                registration.unregister();
                console.log('✅ Service Worker unregistered:', registration.scope);
            }
        });
    }
    
    if ('caches' in window) {
        caches.keys().then(keys => {
            keys.forEach(key => {
                caches.delete(key);
                console.log('✅ Cache cleared:', key);
            });
        });
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        if (window.jQuery) {
            const datepickerScript = document.createElement('script');
            datepickerScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js';
            datepickerScript.onload = function() {
                window.jQuery('.date-own').datepicker({
                    minViewMode: 2,
                    format: 'yyyy'
                });
                console.log('✅ Bootstrap Datepicker initialized');
            };
            document.head.appendChild(datepickerScript);
        }

        console.log('jQuery:', window.jQuery ? window.jQuery.fn.jquery : '❌ Not loaded');
        console.log('Bootstrap:', typeof window.bootstrap !== 'undefined' ? '✅ Loaded' : '❌ Not loaded');
        console.log('Slick:', window.jQuery && window.jQuery.fn.slick ? '✅ Loaded' : '❌ Not loaded');
    });
    </script>

    @include('partials.overflow-detector')

</body>
</html>
