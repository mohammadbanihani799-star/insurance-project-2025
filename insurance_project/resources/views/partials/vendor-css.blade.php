{{--
    ======================================================================
    Vendor CSS - Page Scoped Loading
    ======================================================================
    تحميل ملفات CSS الخارجية فقط في الصفحات التي تحتاجها

    الاستخدام:
    @include('partials.vendor-css', ['vendors' => ['slick', 'fancybox']])
    ======================================================================
--}}

@php
    $loadedVendors = $vendors ?? [];
    $vendorFiles = [
        'slick' => 'style_files/frontend/css/slick.css',
        'fancybox' => 'style_files/frontend/css/jquery.fancybox.min.css',
        'lightslider' => 'style_files/frontend/css/lightSlider.min.css',
        'uimodal' => 'style_files/frontend/css/uiModal.min.css',
        'datepicker' => 'style_files/frontend/css/bootstrap-datepicker.min.css',
    ];
@endphp

@foreach($loadedVendors as $vendor)
    @if(isset($vendorFiles[$vendor]))
        <link rel="stylesheet" href="{{ asset($vendorFiles[$vendor]) }}" media="print" onload="this.media='all'">
    @endif
@endforeach
