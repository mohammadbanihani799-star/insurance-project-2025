{{-- ========== تحميل الأصول عبر Vite أولاً (jQuery، Slick، AOS، Fancybox) ========== --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])

{{-- ========== مكتبات إضافية تحتاج jQuery (بعد Vite) ========== --}}
<script>
// انتظار تحميل Vite قبل تحميل المكتبات التي تحتاج jQuery
document.addEventListener('DOMContentLoaded', function() {
    // تحميل Bootstrap Datepicker بعد jQuery
    if (window.jQuery) {
        const datepickerScript = document.createElement('script');
        datepickerScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js';
        datepickerScript.onload = function() {
            // تهيئة Datepicker بعد التحميل
            window.jQuery('.date-own').datepicker({ 
                minViewMode: 2, 
                format: 'yyyy' 
            });
            console.log('✅ Bootstrap Datepicker loaded and initialized');
        };
        document.head.appendChild(datepickerScript);
        
        // تحميل main.js بعد jQuery
        const mainScript = document.createElement('script');
        mainScript.src = '{{ asset("style_files/frontend/js/main.js") }}';
        mainScript.onload = function() {
            console.log('✅ Main.js loaded successfully');
        };
        document.head.appendChild(mainScript);
    } else {
        console.error('❌ jQuery not available for additional scripts');
    }
});
</script>

{{-- ========== مكتبات لا تحتاج jQuery ========== --}}
<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>

<!-- Three.js (لا يحتاج jQuery) -->
<script src="{{ asset('style_files/frontend/js/three.min.js') }}"></script>

{{-- ========== تهيئة إضافية بعد تحميل Vite ========== --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Vite loaded with jQuery:', window.jQuery ? window.jQuery.fn.jquery : 'غير موجود');
    
    // تهيئة Datepicker (لأنه ليس في Vite)
    if (window.jQuery && window.jQuery.fn.datepicker) {
        window.jQuery('.date-own').datepicker({ 
            minViewMode: 2, 
            format: 'yyyy' 
        });
        console.log('✅ Bootstrap Datepicker جاهز');
    }
    
    // أي سكربتات إضافية خاصة بالصفحة
    console.log('🎉 جميع المكتبات محملة عبر Vite + CDN!');
});
</script>
