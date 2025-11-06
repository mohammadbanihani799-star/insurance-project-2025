{{-- 
    Sweet Alert Component - يحل مشكلة تحميل Swal قبل تهيئته
    الاستخدام: <x-sweet-alerts />
--}}

@if (session()->has('success'))
    <script>
        // انتظار تحميل Swal ثم عرض رسالة النجاح
        (function showSuccessAlert() {
            if (typeof window.Swal?.fire === 'function') {
                Swal.fire('نجاح', '{!! session('success') !!}', 'success');
            } else {
                setTimeout(showSuccessAlert, 100);
            }
        })();
    </script>
@endif

@if (session()->has('danger'))
    <script>
        // انتظار تحميل Swal ثم عرض رسالة الخطأ
        (function showDangerAlert() {
            if (typeof window.Swal?.fire === 'function') {
                Swal.fire('تنبيه', '{!! session('danger') !!}', 'error');
            } else {
                setTimeout(showDangerAlert, 100);
            }
        })();
    </script>
@endif

@if (session()->has('warning'))
    <script>
        // انتظار تحميل Swal ثم عرض رسالة التحذير
        (function showWarningAlert() {
            if (typeof window.Swal?.fire === 'function') {
                Swal.fire('تحذير', '{!! session('warning') !!}', 'warning');
            } else {
                setTimeout(showWarningAlert, 100);
            }
        })();
    </script>
@endif

@if (session()->has('info'))
    <script>
        // انتظار تحميل Swal ثم عرض رسالة المعلومات
        (function showInfoAlert() {
            if (typeof window.Swal?.fire === 'function') {
                Swal.fire('معلومة', '{!! session('info') !!}', 'info');
            } else {
                setTimeout(showInfoAlert, 100);
            }
        })();
    </script>
@endif
