{{--
    ======================================================================
    Vendor JS - Page Scoped Loading with Defer
    ======================================================================
    تحميل ملفات JavaScript الخارجية مع defer لعدم حجب الرسم

    الاستخدام:
    @include('partials.vendor-js', ['vendors' => ['slick', 'fancybox']])
    ======================================================================
--}}

@php
    $loadedVendors = $vendors ?? [];
    $vendorFiles = [
        'slick' => 'style_files/frontend/js/slick.min.js',
        'fancybox' => 'style_files/frontend/js/jquery.fancybox.min.js',
        'lightslider' => 'style_files/frontend/js/lightslider.min.js',
        'datepicker' => 'style_files/frontend/js/bootstrap-datepicker.min.js',
        'sweetalert' => 'style_files/frontend/js/sweetalert2.all.min.js',
    ];
@endphp

@foreach($loadedVendors as $vendor)
    @if(isset($vendorFiles[$vendor]))
        <script src="{{ asset($vendorFiles[$vendor]) }}" defer></script>
    @endif
@endforeach
