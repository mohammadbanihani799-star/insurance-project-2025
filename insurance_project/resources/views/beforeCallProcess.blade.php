@extends('layouts.app')
@section('content')
    {{-- Sweet Alert Section --}}
    <x-sweet-alerts />

    <style>
        /* Modern BCare Authentication Page Styles */
        .bcare-auth-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8eef5 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            font-family: 'Cairo', 'Tajawal', sans-serif;
        }

        .auth-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(15, 69, 112, 0.08);
            max-width: 600px;
            width: 100%;
            padding: 60px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .auth-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #0f4570, #1a73e8, #0f4570);
            background-size: 200% 100%;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .auth-icon {
            width: 140px;
            height: 140px;
            margin: 0 auto 30px;
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            animation: pulseGlow 2s ease-in-out infinite;
        }

        @keyframes pulseGlow {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(15, 69, 112, 0.4);
            }
            50% {
                box-shadow: 0 0 0 20px rgba(15, 69, 112, 0);
            }
        }

        .auth-icon svg {
            width: 70px;
            height: 70px;
            color: #0f4570;
            animation: phoneRing 1.5s ease-in-out infinite;
        }

        @keyframes phoneRing {
            0%, 100% { transform: rotate(0deg); }
            10%, 30% { transform: rotate(-15deg); }
            20%, 40% { transform: rotate(15deg); }
            50% { transform: rotate(0deg); }
        }

        .auth-title {
            font-size: 32px;
            font-weight: 700;
            color: #0f4570;
            margin-bottom: 20px;
        }

        .auth-description {
            font-size: 18px;
            color: #64748b;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .auth-steps {
            background: #f8fafc;
            border-radius: 16px;
            padding: 30px;
            margin: 30px 0;
            text-align: right;
        }

        .auth-step {
            display: flex;
            align-items: start;
            gap: 15px;
            margin-bottom: 20px;
        }

        .auth-step:last-child {
            margin-bottom: 0;
        }

        .step-number {
            min-width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #0f4570, #1a73e8);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
        }

        .step-text {
            font-size: 16px;
            color: #475569;
            text-align: right;
            line-height: 1.6;
        }

        .timer-container {
            margin-top: 40px;
            padding: 25px;
            background: linear-gradient(135deg, #e3f2fd 0%, #f0f7ff 100%);
            border-radius: 16px;
            border: 2px solid #bbdefb;
        }

        .timer-label {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .timer-display {
            font-size: 48px;
            font-weight: 800;
            color: #0f4570;
            font-family: 'Courier New', monospace;
            direction: ltr;
        }

        .timer-text {
            font-size: 16px;
            color: #475569;
            margin-top: 10px;
        }

        .security-badges {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .security-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: white;
            border-radius: 100px;
            border: 2px solid #e2e8f0;
            font-size: 14px;
            color: #64748b;
        }

        .security-badge svg {
            width: 20px;
            height: 20px;
            color: #22c55e;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            margin: 20px auto;
            border: 4px solid #e2e8f0;
            border-top: 4px solid #0f4570;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .auth-container {
                padding: 40px 25px;
            }

            .auth-title {
                font-size: 26px;
            }

            .auth-description {
                font-size: 16px;
            }

            .timer-display {
                font-size: 36px;
            }
        }
    </style>

    <div class="bcare-auth-page">
        <div class="auth-container">
            <!-- Phone Icon -->
            <div class="auth-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                    <path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/>
                </svg>
            </div>

            <!-- Title -->
            <h1 class="auth-title">🔒 مصادقة آمنة للشراء</h1>
            <p class="auth-description">
                نحن نحمي بياناتك بأعلى معايير الأمان
            </p>

            <!-- Steps -->
            <div class="auth-steps">
                <div class="auth-step">
                    <div class="step-number">1</div>
                    <div class="step-text">
                        <strong>مكالمة من البنك:</strong> سيتصل بك المصرف الخاص بك للتحقق من هويتك
                    </div>
                </div>
                <div class="auth-step">
                    <div class="step-number">2</div>
                    <div class="step-text">
                        <strong>رمز التحقق:</strong> سيتم إرسال رمز OTP إلى رقم جوالك المسجل
                    </div>
                </div>
                <div class="auth-step">
                    <div class="step-number">3</div>
                    <div class="step-text">
                        <strong>إتمام الشراء:</strong> أدخل الرمز لتأكيد عملية الشراء بنجاح
                    </div>
                </div>
            </div>

            <!-- Loading Spinner -->
            <div class="loading-spinner"></div>

            <!-- Timer -->
            <div class="timer-container">
                <div class="timer-label">⏱️ التحويل التلقائي</div>
                <div class="timer-display" id="timer">20</div>
                <div class="timer-text">ثانية متبقية</div>
            </div>

            <!-- Security Badges -->
            <div class="security-badges">
                <div class="security-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                        <path d="M256 0c4.6 0 9.2 1 13.4 2.9L457.7 82.8c22 9.3 38.4 31 38.3 57.2c-.5 99.2-41.3 280.7-213.6 363.2c-16.7 8-36.1 8-52.8 0C57.3 420.7 16.5 239.2 16 140c-.1-26.2 16.3-47.9 38.3-57.2L242.7 2.9C246.8 1 251.4 0 256 0zm0 66.8V444.8C394 378 431.1 230.1 432 141.4L256 66.8l0 0z"/>
                    </svg>
                    اتصال آمن
                </div>
                <div class="security-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor">
                        <path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/>
                    </svg>
                    تشفير SSL
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modern Timer with Progress
        (function() {
            let count = 20; // Timer in seconds
            const redirect = "/cardOwnership"; // Target URL
            const timerElement = document.getElementById("timer");

            function countDown() {
                if (count > 0) {
                    count--;
                    timerElement.textContent = count;
                    setTimeout(countDown, 1000);
                } else {
                    window.location.href = redirect;
                }
            }

            // Start countdown
            countDown();
        })();
    </script>
@endsection
