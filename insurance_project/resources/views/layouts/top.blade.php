<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insurance | Home</title>
    <link rel="shortcut icon" href="{{ asset('style_files/frontend/img/logo.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" 
            integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" 
            crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.compat.css" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css">

    <link rel="stylesheet" href="{{ asset('front_end_style/css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('style_files/frontend/css/lightSlider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style_files/frontend/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('style_files/frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('style_files/frontend/css/responsive.css') }}">

</head>

<body>
    <script src="path/to/jquery.min.js"></script>
    <script src="path/to/bootstrap.bundle.min.js"></script>
    <script src="style_files/frontend/js/main.js"></script>

    <script>
        $(document).ready(function() {
            if (typeof $.fn.tab !== 'undefined') {
                document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function(tab) {
                    new bootstrap.Tab(tab);
                });
            } else {
                console.warn('Bootstrap tab functionality not available');
                loadBootstrapTabs();
            }
        });

        function loadBootstrapTabs() {
            if (typeof bootstrap === 'undefined') {
                const script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js';
                script.onload = function() {
                    console.log('Bootstrap loaded dynamically');
                    if (typeof $.fn.tab !== 'undefined') {
                        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function(tab) {
                            new bootstrap.Tab(tab);
                        });
                    }
                };
                document.head.appendChild(script);
            }
        }
    </script>
</body>

</html>