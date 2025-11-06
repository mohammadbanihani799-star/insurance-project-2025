@extends('layouts.insurance-Statements')

@push('styles')
    {{-- Preload Critical Stylesheets --}}
    <link rel="preload" href="{{ asset('style_files/frontend/css/bcare-colors.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="{{ asset('style_files/frontend/css/bcare-theme.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    
    {{-- Non-Critical Styles - Load Async --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" media="print" onload="this.media='all'">
    
    {{-- Fallback for No-JS --}}
    <noscript>
        <link rel="stylesheet" href="{{ asset('style_files/frontend/css/bcare-colors.css') }}">
        <link rel="stylesheet" href="{{ asset('style_files/frontend/css/bcare-theme.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    </noscript>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Cairo', 'Tajawal', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        html, body {
            font-family: 'Cairo', 'Tajawal', sans-serif;
            background: #f7f9fc;
            overflow-x: hidden;
            width: 100%;
            max-width: 100vw;
        }

        .bcare-breadcrumb {
            background: linear-gradient(135deg, #146394 0%, #0f4570 100%);
            padding: 3rem 0 2rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .bcare-breadcrumb::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        }

        .breadcrumb-content {
            position: relative;
            z-index: 1;
            animation: slideDown 0.6s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .breadcrumb-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .breadcrumb-icon svg {
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        .breadcrumb-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            font-family: 'Cairo', sans-serif;
            letter-spacing: -0.5px;
            color: #ffffff;
        }

        .breadcrumb-subtitle {
            font-size: 1rem;
            opacity: 0.95;
            text-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
            font-family: 'Cairo', sans-serif;
            font-weight: 500;
            color: #FAA62E;
        }

        .breadcrumb-nav-small {
            margin: -1rem 0 1.5rem;
            padding: 0.5rem 0;
            direction: rtl;
            text-align: right;
        }

        .breadcrumb-list-small {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 0.4rem;
            flex-wrap: wrap;
            direction: rtl;
        }

        /* ===== BCare Progress Bar - All Steps in One Line ===== */
        .bcare-progress-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            padding: 30px 40px;
            border-radius: 20px;
            margin-bottom: 40px;
            box-shadow: 0 8px 30px rgba(20, 99, 148, 0.15);
            border: 2px solid rgba(20, 99, 148, 0.1);
            position: relative;
            overflow: hidden;
            flex-wrap: nowrap;
            gap: 0;
        }

        .bcare-progress-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 200%;
            height: 3px;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(20, 99, 148, 0.3) 25%, 
                rgba(20, 99, 148, 0.6) 50%, 
                rgba(20, 99, 148, 0.3) 75%, 
                transparent 100%
            );
            animation: shimmer 3s infinite linear;
        }

        .progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            z-index: 2;
            flex-shrink: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .step-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            font-family: 'Cairo', sans-serif;
        }

        /* Completed Step Style */
        .progress-step.completed .step-circle {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            border: 3px solid #d1fae5;
        }

        .progress-step.completed .step-circle::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.3);
            animation: ripple 2s infinite;
        }

        .checkmark-icon {
            width: 24px;
            height: 24px;
            animation: checkmark 0.5s ease forwards;
        }

        .progress-step.completed .step-text {
            color: #10b981;
            font-weight: 700;
        }

        /* Active Step Style */
        .progress-step.active .step-circle {
            background: linear-gradient(135deg, #146394 0%, #0f4570 100%);
            box-shadow: 0 6px 20px rgba(20, 99, 148, 0.5);
            border: 3px solid #bfdbfe;
            animation: pulseActive 2s infinite;
        }

        .progress-step.active .step-circle::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: rgba(20, 99, 148, 0.3);
            animation: ripple 2s infinite;
        }

        .progress-step.active .step-num,
        .progress-step.active .step-text {
            color: #146394;
            font-weight: 700;
        }

        .progress-step.active .step-circle .step-num {
            color: white;
        }

        /* Pending Step Style */
        .progress-step.pending .step-circle {
            background: #e5e7eb;
            color: #9ca3af;
            border: 3px solid #f3f4f6;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .progress-step.pending .step-text {
            color: #9ca3af;
            font-weight: 500;
        }

        .step-text {
            font-size: 14px;
            font-family: 'Cairo', sans-serif;
            text-align: center;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        /* Progress Line Between Steps */
        .progress-line {
            flex: 1;
            height: 4px;
            min-width: 40px;
            margin: 0 10px;
            border-radius: 2px;
            position: relative;
            transition: all 0.4s ease;
            align-self: flex-start;
            margin-top: 23px;
        }

        .progress-line.completed {
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
            box-shadow: 0 2px 10px rgba(16, 185, 129, 0.3);
        }

        .progress-line.pending {
            background: #e5e7eb;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .bcare-progress-container {
                padding: 20px 15px;
                gap: 5px;
            }

            .step-circle {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }

            .checkmark-icon {
                width: 20px;
                height: 20px;
            }

            .step-text {
                font-size: 11px;
            }

            .progress-line {
                min-width: 20px;
                margin: 0 5px;
                margin-top: 18px;
            }
        }

        @media (max-width: 480px) {
            .bcare-progress-container {
                padding: 15px 10px;
            }

            .step-circle {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }

            .step-text {
                font-size: 10px;
            }

            .progress-line {
                min-width: 15px;
                margin: 0 3px;
                margin-top: 16px;
            }
        }

        .container {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .bc-skin {
            width: 100%;
            overflow-x: hidden;
        }

        .step-indicator-wrap {
            display: none !important; /* استبدل بـ bcare-progress-container الجديد */
        }

        .step-indicator-wrap::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #146394 0%, #FAA62E 50%, #146394 100%);
            background-size: 200% 100%;
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .step-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            flex-wrap: nowrap;
            position: relative;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            z-index: 2;
        }

        .step-number {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #f3f4f6;
            border: 4px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.3rem;
            color: #9ca3af;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .step-number::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: transparent;
            transition: all 0.4s ease;
        }

        .step.completed .step-number {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-color: #10b981;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            transform: scale(1.05);
        }

        .step.completed .step-number::before {
            background: rgba(16, 185, 129, 0.2);
            transform: scale(1.3);
        }

        .step.completed .step-number svg {
            width: 28px;
            height: 28px;
            stroke: white;
            stroke-width: 3;
            animation: checkmark 0.5s ease;
        }

        @keyframes checkmark {
            0% { 
                opacity: 0;
                transform: scale(0) rotate(-45deg);
            }
            50% {
                transform: scale(1.2) rotate(0deg);
            }
            100% { 
                opacity: 1;
                transform: scale(1) rotate(0deg);
            }
        }

        .step.active .step-number {
            background: linear-gradient(135deg, #146394 0%, #0f4570 100%);
            color: white;
            border-color: #146394;
            box-shadow: 0 6px 20px rgba(20, 99, 148, 0.4);
            transform: scale(1.1);
            animation: pulseActive 2s infinite;
        }

        .step.active .step-number::before {
            background: rgba(20, 99, 148, 0.2);
            transform: scale(1.4);
            animation: ripple 2s infinite;
        }

        @keyframes pulseActive {
            0%, 100% {
                box-shadow: 0 6px 20px rgba(20, 99, 148, 0.4);
            }
            50% {
                box-shadow: 0 8px 30px rgba(20, 99, 148, 0.6);
            }
        }

        @keyframes ripple {
            0% {
                transform: scale(1.2);
                opacity: 1;
            }
            100% {
                transform: scale(1.8);
                opacity: 0;
            }
        }

        .step-label {
            color: #6b7280;
            font-size: 0.95rem;
            font-weight: 500;
            text-align: center;
            font-family: 'Cairo', sans-serif;
            transition: all 0.3s ease;
            max-width: 100px;
        }

        .step.completed .step-label {
            color: #10b981;
            font-weight: 700;
        }

        .step.active .step-label {
            color: #146394;
            font-weight: 800;
            transform: scale(1.05);
        }

        .step-line {
            width: 100px;
            height: 4px;
            background: #e5e7eb;
            margin: 0 1.5rem;
            align-self: flex-start;
            margin-top: 28px;
            border-radius: 4px;
            position: relative;
            overflow: hidden;
        }

        .step-line::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, #146394 0%, #10b981 100%);
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .step-line.active::before {
            width: 100%;
            background: linear-gradient(90deg, #146394 0%, #10b981 100%);
        }

        .step-line.completed {
            background: #10b981;
        }

        .step-line.completed::before {
            width: 100%;
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
        }

        .form-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 102, 161, 0.08);
            position: relative;
            overflow: hidden;
            max-width: 100%;
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(0, 102, 161, 0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.4rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 3px solid transparent;
            border-image: linear-gradient(90deg, #0066a1 0%, #e2e8f0 100%);
            border-image-slice: 1;
            font-family: 'Cairo', sans-serif;
        }

        .section-title svg {
            width: 26px;
            height: 26px;
            stroke: #0066a1;
            background: rgba(0, 102, 161, 0.1);
            padding: 5px;
            border-radius: 8px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
            font-family: 'Cairo', sans-serif;
        }

        .form-label svg {
            width: 18px;
            height: 18px;
            stroke: #0066a1;
        }

        .form-control,
        .modern-input,
        .modern-select {
            width: 100%;
            height: 52px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0 1.25rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f7fafc;
            font-family: 'Cairo', sans-serif;
            color: #2d3748;
        }

        .form-control::placeholder,
        .modern-input::placeholder,
        .modern-select::placeholder {
            color: #a0aec0;
            font-weight: 400;
        }

        .form-control:focus,
        .modern-input:focus,
        .modern-select:focus {
            border-color: #0066a1;
            background: white;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 102, 161, 0.1);
            transform: translateY(-1px);
        }

        .form-control:hover:not(:focus),
        .modern-input:hover:not(:focus),
        .modern-select:hover:not(:focus) {
            border-color: #cbd5e0;
        }

        select.form-control,
        select.modern-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%23146394' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: left 1rem center;
            background-size: 18px;
            padding-left: 3rem;
            cursor: pointer;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        /* Hide default dropdown arrow in IE */
        select.form-control::-ms-expand,
        select.modern-select::-ms-expand {
            display: none;
        }

        input[type="date"].form-control {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%230066a1' stroke-width='2'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: left 1rem center;
            background-size: 20px;
            padding-left: 3.5rem;
            cursor: pointer;
            direction: rtl;
            text-align: right;
        }

        input[type="date"].form-control::-webkit-calendar-picker-indicator {
            position: absolute;
            left: 1rem;
            cursor: pointer;
            opacity: 0;
            width: 20px;
            height: 20px;
        }

        input[type="date"].form-control:hover {
            border-color: #0066a1;
            background-color: rgba(0, 102, 161, 0.02);
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon input {
            padding-left: 4rem !important;
        }

        .input-suffix {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: #0066a1;
            font-weight: 700;
            font-size: 1.1rem;
            font-family: 'Arial', sans-serif;
            background: rgba(0, 102, 161, 0.1);
            padding: 4px 10px;
            border-radius: 6px;
        }

        .radio-group-modern {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
        }

        .radio-card {
            cursor: pointer;
        }

        .radio-card input[type="radio"] {
            display: none;
        }

        .radio-card-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
            padding: 1.5rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background: #f7fafc;
            transition: all 0.3s ease;
            min-height: 120px;
            justify-content: center;
            position: relative;
        }

        .radio-card:hover .radio-card-content {
            border-color: #0066a1;
            background: rgba(0, 102, 161, 0.05);
        }

        .radio-card input:checked+.radio-card-content {
            border-color: #0066a1;
            background: linear-gradient(135deg, rgba(0, 102, 161, 0.1) 0%, rgba(0, 77, 122, 0.1) 100%);
            box-shadow: 0 4px 15px rgba(0, 102, 161, 0.15);
        }

        .radio-card-content svg {
            width: 32px;
            height: 32px;
            stroke: #a0aec0;
            transition: all 0.3s ease;
        }

        .radio-card input:checked+.radio-card-content svg {
            stroke: #0066a1;
        }

        .radio-card-content span {
            font-weight: 600;
            color: #6b7280;
            font-size: 1rem;
        }

        .radio-card input:checked+.radio-card-content span {
            color: #0066a1;
        }

        .consent-box {
            background: linear-gradient(135deg, rgba(0, 102, 161, 0.05) 0%, rgba(0, 77, 122, 0.05) 100%);
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            margin: 30px 0;
        }

        .consent-label {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            cursor: pointer;
        }

        .consent-label input[type="checkbox"] {
            width: 24px;
            height: 24px;
            cursor: pointer;
            accent-color: #0066a1;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .consent-text {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            font-size: 0.95rem;
            color: #374151;
            line-height: 1.6;
        }

        .consent-text svg {
            width: 20px;
            height: 20px;
            stroke: #0066a1;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .btn-submit-modern {
            width: 100%;
            height: 60px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
            position: relative;
            overflow: hidden;
            margin-top: 20px;
        }

        .btn-submit-modern::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-submit-modern:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-submit-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(245, 158, 11, 0.5);
        }

        .btn-submit-modern:active {
            transform: translateY(0);
        }

        .btn-submit-modern svg {
            width: 20px;
            height: 20px;
            stroke: white;
            fill: none;
            position: relative;
            z-index: 1;
        }

        .btn-submit-modern span {
            position: relative;
            z-index: 1;
        }

        /* Form Actions Styles */
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2.5rem;
            justify-content: space-between;
            align-items: center;
        }

        .btn-submit {
            flex: 1;
            height: 58px;
            background: linear-gradient(135deg, #0066a1 0%, #004d7a 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 102, 161, 0.3);
            position: relative;
            overflow: hidden;
            font-family: 'Cairo', sans-serif;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-submit:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(0, 102, 161, 0.5);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit svg {
            width: 20px;
            height: 20px;
            stroke: white;
            fill: none;
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease;
        }

        .btn-submit:hover svg {
            transform: translateX(-3px);
        }

        .btn-back {
            height: 58px;
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            color: #4a5568;
            font-size: 1.05rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 0 2rem;
            font-family: 'Cairo', sans-serif;
        }

        .btn-back svg {
            width: 18px;
            height: 18px;
            stroke: #4a5568;
            fill: none;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            border-color: #0066a1;
            color: #0066a1;
            background: rgba(0, 102, 161, 0.05);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 102, 161, 0.1);
        }

        .btn-back:hover svg {
            stroke: #0066a1;
            transform: translateX(3px);
        }

        .btn-back:active {
            transform: translateY(0);
        }

        .full-width {
            grid-column: 1 / -1;
        }

        textarea.form-control {
            height: auto;
            min-height: 120px;
            padding: 1rem 1.25rem;
            resize: vertical;
            line-height: 1.6;
        }

        textarea.form-control:focus {
            min-height: 150px;
        }

        .additional-driver-section {
            margin-top: 1.5rem;
            padding: 1.75rem 2rem;
            background: linear-gradient(135deg, rgba(0, 102, 161, 0.05) 0%, rgba(15, 32, 64, 0.05) 100%);
            border-radius: 12px;
            border: 2px solid rgba(0, 102, 161, 0.2);
            box-shadow: 0 2px 10px rgba(0, 102, 161, 0.08);
            direction: rtl;
            font-family: 'Cairo', sans-serif;
        }

        .additional-driver-section h4 {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Invalid Input State */
        .form-control.is-invalid {
            border-color: #dc3545 !important;
            background-color: #fff5f5 !important;
            animation: shake 0.5s;
        }

        .form-control.is-invalid:focus {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1) !important;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Error Message Style */
        .error-message {
            display: none;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            font-family: 'Cairo', sans-serif;
            font-weight: 500;
            animation: fadeIn 0.3s ease;
        }

        .error-message.show {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .error-message svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Required Label Indicator */
        .form-label.required::after {
            content: ' *';
            color: #dc3545;
            font-weight: 700;
        }

        .section-label {
            display: block;
            color: #0f2040;
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 1rem;
            font-family: 'Cairo', sans-serif;
            text-align: right;
            direction: rtl;
        }

        .radio-group-bcare {
            display: flex;
            gap: 2rem;
            align-items: center;
            direction: rtl;
            justify-content: flex-start;
        }

        .radio-option-bcare {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 0.95rem;
            color: #0f2040;
            position: relative;
            transition: all 0.3s ease;
            flex-direction: row-reverse;
        }

        .radio-option-bcare input {
            display: none;
        }

        .custom-radio-bcare {
            width: 22px;
            height: 22px;
            border: 2px solid #0066a1;
            border-radius: 50%;
            margin-right: 10px;
            margin-left: 0;
            position: relative;
            transition: all 0.3s ease;
            background: white;
        }

        .radio-option-bcare input:checked + .custom-radio-bcare {
            border-color: #0066a1;
            background-color: #0066a1;
            box-shadow: 0 0 0 4px rgba(0, 102, 161, 0.1);
        }

        .radio-option-bcare input:checked + .custom-radio-bcare::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            animation: radioCheck 0.3s ease;
        }

        @keyframes radioCheck {
            0% {
                transform: translate(-50%, -50%) scale(0);
            }
            50% {
                transform: translate(-50%, -50%) scale(1.3);
            }
            100% {
                transform: translate(-50%, -50%) scale(1);
            }
        }

        .radio-text-bcare {
            font-weight: 600;
            color: #0f2040;
            font-family: 'Cairo', sans-serif;
        }

        .radio-option-bcare:hover .custom-radio-bcare {
            border-color: #004d7a;
            box-shadow: 0 0 0 4px rgba(0, 102, 161, 0.08);
        }

        .additional-driver-details {
            margin-top: 1.5rem;
            padding: 1.5rem;
            background: white;
            border-radius: 12px;
            border: 2px solid #0066a1;
            box-shadow: 0 4px 15px rgba(0, 102, 161, 0.1);
            animation: slideDownDriver 0.4s ease-out;
            direction: rtl;
            text-align: right;
        }

        @keyframes slideDownDriver {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section-header-driver {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f0f4f8;
            direction: rtl;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .section-header-driver svg {
            stroke: #0066a1;
            fill: none;
        }

        .section-header-driver h4 {
            margin: 0;
            color: #0f2040;
            font-weight: 700;
            font-size: 1.1rem;
            font-family: 'Cairo', sans-serif;
            text-align: right;
        }

        .error-message {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 8px;
            font-weight: 500;
            background: rgba(239, 68, 68, 0.1);
            padding: 8px 12px;
            border-radius: 8px;
            border-right: 3px solid #ef4444;
        }

        .error-message::before {
            content: '⚠';
            font-size: 1rem;
        }

        .form-group:has(.error-message) .form-control,
        .form-group:has(.error-message) .modern-input,
        .form-group:has(.error-message) .modern-select {
            border-color: #ef4444;
            background: rgba(239, 68, 68, 0.05);
        }

        @media (max-width: 768px) {
            .step-indicator {
                gap: 0.5rem;
            }

            .step-line {
                width: 40px;
                height: 2px;
            }

            .step-number {
                width: 45px;
                height: 45px;
                font-size: 1rem;
            }

            .step-label {
                font-size: 0.8rem;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .breadcrumb-title {
                font-size: 1.5rem;
            }

            .breadcrumb-subtitle {
                font-size: 0.9rem;
            }

            .breadcrumb-icon {
                width: 50px;
                height: 50px;
            }

            .breadcrumb-icon svg {
                width: 24px;
                height: 24px;
            }

            .form-card {
                padding: 25px;
            }

            .section-title {
                font-size: 1.2rem;
            }

            .btn-submit-modern {
                height: 55px;
                font-size: 1rem;
            }

            .step-indicator-wrap {
                padding: 20px;
            }

            .container {
                padding: 20px 15px;
            }

            .radio-group-modern {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .breadcrumb-title {
                font-size: 1.3rem;
            }

            .step-label {
                font-size: 0.7rem;
            }

            .step-line {
                width: 30px;
                margin: 0 0.5rem;
            }
        }

        .overlayLoader {
            position: fixed;
            inset: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            direction: rtl;
            font-family: "Tajawal", "Cairo", sans-serif;
            transition: opacity 0.3s ease;
            animation: fadeIn 0.3s ease-out;
        }

        .overlayLoader.active {
            display: flex;
            opacity: 1;
        }

        .overlayContent {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
            background: white;
            padding: 40px 50px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 102, 161, 0.15);
            border: 2px solid rgba(0, 102, 161, 0.1);
        }

        .overlayLogo {
            width: 80px;
            height: auto;
            animation: pulse 1.6s infinite ease-in-out;
        }

        .overlayLogo img {
            width: 100%;
            height: auto;
            display: block;
            filter: drop-shadow(0 2px 8px rgba(0, 102, 161, 0.2));
        }

        .overlayText {
            color: #0f2040;
            font-size: 1.05rem;
            font-weight: 600;
            letter-spacing: -0.3px;
            animation: fade 1.8s infinite alternate;
            text-align: center;
            max-width: 300px;
        }

        .overlaySpinner {
            width: 26px;
            height: 26px;
            border: 3px solid rgba(0, 102, 161, 0.2);
            border-top-color: #0066a1;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.85;
            }
            50% {
                transform: scale(1.08);
                opacity: 1;
            }
        }

        @keyframes fade {
            0% {
                opacity: 0.5;
            }
            100% {
                opacity: 1;
            }
        }

        .packages-page {
            width: 100%;
            min-height: 100vh;
            background: #f7f9fc;
        }

        .btn-back-packages {
            background: #e5e7eb;
            color: #4b5563;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 30px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'Tajawal', sans-serif;
            transition: all 0.3s;
        }

        .btn-back-packages:hover {
            background: #d1d5db;
            transform: translateX(5px);
        }

        .packages-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .package-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 2px solid #e5e7eb;
            position: relative;
            transition: all 0.3s;
        }

        .package-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 102, 161, 0.15);
            border-color: #0066a1;
        }

        .package-card.featured {
            border: 2px solid #0066a1;
            background: linear-gradient(135deg, rgba(0, 102, 161, 0.03) 0%, rgba(245, 158, 11, 0.03) 100%);
        }

        .package-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            background: linear-gradient(135deg, #0066a1 0%, #004d7a 100%);
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .package-badge.premium {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .package-header {
            margin-bottom: 20px;
        }

        .package-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .package-subtitle {
            font-size: 0.95rem;
            color: #6b7280;
        }

        .package-price {
            text-align: center;
            padding: 25px;
            background: linear-gradient(135deg, rgba(0, 102, 161, 0.05) 0%, rgba(0, 77, 122, 0.05) 100%);
            border-radius: 15px;
            margin-bottom: 25px;
        }

        .price-amount {
            font-size: 3rem;
            font-weight: 900;
            color: #0066a1;
            line-height: 1;
        }

        .price-currency {
            font-size: 1.2rem;
            color: #6b7280;
            margin-right: 5px;
        }

        .price-period {
            display: block;
            font-size: 0.9rem;
            color: #6b7280;
            margin-top: 8px;
        }

        .package-features {
            list-style: none;
            padding: 0;
            margin: 0 0 25px 0;
        }

        .package-features li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
            color: #4b5563;
            font-size: 0.95rem;
        }

        .package-features li:last-child {
            border-bottom: none;
        }

        .package-features svg {
            width: 20px;
            height: 20px;
            fill: #10b981;
            flex-shrink: 0;
        }

        .btn-select-package {
            width: 100%;
            height: 55px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Tajawal', sans-serif;
        }

        .btn-select-package:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
        }

        .package-card.featured .btn-select-package {
            background: linear-gradient(135deg, #0066a1 0%, #004d7a 100%);
        }

        @media (max-width: 640px) {
            .overlayContent {
                padding: 30px 35px;
                margin: 0 20px;
            }

            .overlayLogo {
                width: 64px;
            }

            .overlayText {
                font-size: 0.9rem;
                max-width: 250px;
            }

            .overlaySpinner {
                width: 22px;
                height: 22px;
            }

            .packages-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .package-card {
                padding: 20px;
            }

            .price-amount {
                font-size: 2.5rem;
            }

            #paymentPage .container > div[style*="grid"] {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 480px) {
            .overlayContent {
                padding: 25px 30px;
            }

            .overlayLogo {
                width: 56px;
            }

            .overlayText {
                font-size: 0.85rem;
            }
        }
    </style>

@endpush

@section('content')
    <x-sweet-alerts />

    {{-- Loading Overlay --}}
    <div class="overlayLoader" id="overlay2">
        <div class="overlayContent">
            <div class="overlayLogo">
                <img src="{{ asset('storage/images/insurances/loader.png') }}" alt="BCare Logo">
            </div>
            <div class="overlayText">جاري التحميل...</div>
            <div class="overlaySpinner">
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
            </div>
        </div>
    </div>

    <div class="bcare-breadcrumb">
        <div class="breadcrumb-content">
            <div class="breadcrumb-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none"
                    stroke="white" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
            </div>
            <h1 class="breadcrumb-title">بيانات التأمين</h1>
            <p class="breadcrumb-subtitle">أدخل بيانات مركبتك للحصول على أفضل العروض</p>
        </div>
    </div>

    <div class="container">
        <div class="bcare-progress-container">
            <!-- Step 1: الرئيسية -->
            <div class="progress-step completed">
                <div class="step-circle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" class="checkmark-icon">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <span class="step-text">الرئيسية</span>
            </div>
            
            <div class="progress-line completed"></div>
            
            <!-- Step 2: بيانات التأمين -->
            <div class="progress-step active">
                <div class="step-circle">
                    <span class="step-num">2</span>
                </div>
                <span class="step-text">بيانات التأمين</span>
            </div>
            
            <div class="progress-line pending"></div>
            
            <!-- Step 3: باقات التأمين -->
            <div class="progress-step pending">
                <div class="step-circle">
                    <span class="step-num">3</span>
                </div>
                <span class="step-text">باقات التأمين</span>
            </div>
            
            <div class="progress-line pending"></div>
            
            <!-- Step 4: الملخص -->
            <div class="progress-step pending">
                <div class="step-circle">
                    <span class="step-num">4</span>
                </div>
                <span class="step-text">الملخص</span>
            </div>
            
            <div class="progress-line pending"></div>
            
            <!-- Step 5: الدفع -->
            <div class="progress-step pending">
                <div class="step-circle">
                    <span class="step-num">5</span>
                </div>
                <span class="step-text">الدفع</span>
            </div>
        </div>
    </div>

    <section class="bc-skin">
        <div class="container">
            <div class="form-card">
                <form action="{{ route('insuranceStatementsRequest') }}" method="POST" id="insuranceForm">
                    @csrf

                    {{-- Personal Information Section --}}
                    <div class="form-section">
                        <h3 class="section-title">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            المعلومات الشخصية
                        </h3>

                        <div class="form-row">
                            {{-- Full Name --}}
                            <div class="form-group">
                                <label class="form-label required" for="full_name">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    الاسم الكامل
                                </label>
                                <input type="text" class="form-control" id="full_name" name="full_name" 
                                       placeholder="أدخل الاسم الكامل" required>
                            </div>

                            {{-- Identity Number --}}
                            <div class="form-group">
                                <label class="form-label required" for="identity_number">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                        <line x1="1" y1="10" x2="23" y2="10"></line>
                                    </svg>
                                    رقم الهوية الوطنية / الإقامة
                                </label>
                                <input type="text" class="form-control" id="identity_number" name="identity_number" 
                                       value="{{ session('identity_number', '') }}" 
                                       maxlength="10" 
                                       pattern="[12][0-9]{9}" 
                                       required>
                            </div>
                        </div>

                        <div class="form-row">
                            {{-- Mobile Number --}}
                            <div class="form-group">
                                <label class="form-label required" for="mobile_number">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                                        <line x1="12" y1="18" x2="12.01" y2="18"></line>
                                    </svg>
                                    رقم الجوال
                                </label>
                                <input type="tel" class="form-control" id="mobile_number" name="mobile_number" 
                                       placeholder="05xxxxxxxx" maxlength="10" pattern="05[0-9]{8}" required>
                            </div>

                            {{-- Birth Date --}}
                            <div class="form-group">
                                <label class="form-label required" for="birth_date">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    تاريخ الميلاد
                                </label>
                                <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                            </div>
                        </div>

                        <div class="form-row">
                            {{-- Region --}}
                            <div class="form-group">
                                <label class="form-label required" for="region">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                    المنطقة
                                </label>
                                <select class="form-control" id="region" name="region" required>
                                    <option value="">اختر المنطقة</option>
                                    <option value="riyadh">الرياض</option>
                                    <option value="makkah">مكة المكرمة</option>
                                    <option value="madinah">المدينة المنورة</option>
                                    <option value="eastern">المنطقة الشرقية</option>
                                    <option value="asir">عسير</option>
                                    <option value="qassim">القصيم</option>
                                    <option value="hail">حائل</option>
                                    <option value="tabuk">تبوك</option>
                                    <option value="jazan">جازان</option>
                                    <option value="najran">نجران</option>
                                    <option value="baha">الباحة</option>
                                    <option value="jouf">الجوف</option>
                                    <option value="northern">الحدود الشمالية</option>
                                </select>
                            </div>

                            {{-- City --}}
                            <div class="form-group">
                                <label class="form-label required" for="city">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    </svg>
                                    المدينة
                                </label>
                                <select class="form-control" id="city" name="city" required disabled>
                                    <option value="">اختر المنطقة أولاً</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            {{-- Driving Years --}}
                            <div class="form-group">
                                <label class="form-label required" for="driving_years">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                    عدد سنوات القيادة
                                </label>
                                <select class="form-control" id="driving_years" name="driving_years" required>
                                    <option value="">اختر عدد السنوات</option>
                                    <option value="1">سنة واحدة</option>
                                    <option value="2">سنتان</option>
                                    <option value="3">ثلاث سنوات</option>
                                    <option value="5">أكثر من خمس سنوات</option>
                                    <option value="10">عشر سنوات</option>
                                    <option value="10+">أكثر من عشر سنوات</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Insurance Information Section --}}
                    <div class="form-section">
                        <h3 class="section-title">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                            معلومات التأمين
                        </h3>

                        <div class="form-row">
                            {{-- Insurance Type --}}
                            <div class="form-group">
                                <label class="form-label required" for="insurance_type">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                    </svg>
                                    نوع التأمين
                                </label>
                                <select class="form-control" id="insurance_type" name="insurance_type" required>
                                    <option value="">اختر نوع التأمين</option>
                                    <option value="1">تأمين ضد الغير</option>
                                    <option value="2">تأمين شامل</option>
                                </select>
                            </div>

                            {{-- Usage Category --}}
                            <div class="form-group">
                                <label class="form-label required" for="usage_category">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M7 7h10v10H7z"></path>
                                        <path d="M5 5h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2z"></path>
                                    </svg>
                                    فئة الاستعمال
                                </label>
                                <select class="form-control" id="usage_category" name="usage_category" required>
                                    <option value="">اختر فئة الاستعمال</option>
                                    <option value="personal">شخصي</option>
                                    <option value="commercial">تجاري</option>
                                    <option value="taxi">أجرة</option>
                                    <option value="transport">نقل</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            {{-- Policy Start Date --}}
                            <div class="form-group">
                                <label class="form-label required" for="policy_start_date">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    تاريخ بدء الوثيقة
                                </label>
                                <input type="date" class="form-control" id="policy_start_date" name="policy_start_date" required>
                            </div>

                            {{-- Vehicle Type --}}
                            <div class="form-group">
                                <label class="form-label required" for="vehicle_type">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M5 17h14v-5H5v5zM3 10l2-4h14l2 4H3z"></path>
                                        <circle cx="7.5" cy="17" r="2.5"></circle>
                                        <circle cx="16.5" cy="17" r="2.5"></circle>
                                    </svg>
                                    نوع المركبة
                                </label>
                                <select class="form-control" id="vehicle_type" name="vehicle_type" required>
                                    <option value="">اختر نوع المركبة</option>
                                    <option value="sedan">سيدان</option>
                                    <option value="suv">SUV</option>
                                    <option value="truck">شاحنة</option>
                                    <option value="van">فان</option>
                                    <option value="coupe">كوبيه</option>
                                    <option value="hatchback">هاتشباك</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            {{-- Vehicle Model --}}
                            <div class="form-group">
                                <label class="form-label required" for="vehicle_model">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M5 17h14v-5H5v5zM3 10l2-4h14l2 4H3z"></path>
                                    </svg>
                                    موديل المركبة
                                </label>
                                <input type="text" class="form-control" id="vehicle_model" name="vehicle_model" 
                                       placeholder="مثال: كامري، أكورد، سوناتا" required>
                            </div>

                            {{-- Manufacturing Year --}}
                            <div class="form-group">
                                <label class="form-label required" for="manufacturing_year">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    سنة صنع المركبة
                                </label>
                                <select class="form-control" id="manufacturing_year" name="manufacturing_year" required>
                                    <option value="">اختر السنة</option>
                                    <option value="2026">2026</option>
                                    <option value="2025">2025</option>
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>
                                    <option value="2022">2022</option>
                                    <option value="2021">2021</option>
                                    <option value="2020">2020</option>
                                    <option value="2019">2019</option>
                                    <option value="2018">2018</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                    <option value="2014">2014</option>
                                    <option value="2013">2013</option>
                                    <option value="2012">2012</option>
                                    <option value="2011">2011</option>
                                    <option value="2010">2010</option>
                                    <option value="2009">2009</option>
                                    <option value="2008">2008</option>
                                    <option value="2007">2007</option>
                                    <option value="2006">2006</option>
                                    <option value="2005">2005</option>
                                    <option value="2004">2004</option>
                                    <option value="2003">2003</option>
                                    <option value="2002">2002</option>
                                    <option value="2001">2001</option>
                                    <option value="2000">2000</option>
                                    <option value="1999">1999</option>
                                    <option value="1998">1998</option>
                                    <option value="1997">1997</option>
                                    <option value="1996">1996</option>
                                    <option value="1995">1995</option>
                                    <option value="1994">1994</option>
                                    <option value="1993">1993</option>
                                    <option value="1992">1992</option>
                                    <option value="1991">1991</option>
                                    <option value="1990">1990</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            {{-- Maintenance Type --}}
                            <div class="form-group">
                                <label class="form-label required" for="maintenance_type">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                                    </svg>
                                    الصيانة
                                </label>
                                <select class="form-control" id="maintenance_type" name="maintenance_type" required>
                                    <option value="">اختر نوع الصيانة</option>
                                    <option value="agency">الوكالة</option>
                                    <option value="workshop">الورشة</option>
                                </select>
                            </div>

                            {{-- Approximate Price --}}
                            <div class="form-group">
                                <label class="form-label required" for="approximate_price">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="12" y1="1" x2="12" y2="23"></line>
                                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                    </svg>
                                    السعر التقريبي للمركبة
                                </label>
                                <div class="input-with-icon">
                                    <input type="number" class="form-control" id="approximate_price" name="approximate_price" 
                                           min="1000" 
                                           max="99999999" 
                                           step="1000" 
                                           required>
                                    <span class="input-suffix">ريال</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            {{-- Additional Driver --}}
                            <div class="form-group">
                                <label class="form-label" for="has_additional_driver">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                    هل تريد إضافة سائق إضافي؟ (اختياري)
                                </label>
                                <select class="form-control" id="has_additional_driver" name="has_additional_driver">
                                    <option value="no">لا</option>
                                    <option value="yes">نعم</option>
                                </select>
                            </div>
                        </div>

                        {{-- Additional Driver Form (Hidden by default) --}}
                        <div id="additionalDriverSection" style="display: none;">
                            <div class="additional-driver-section">
                                <h4 style="color: #0066a1; font-weight: 700; margin-bottom: 20px; font-size: 1.1rem;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px; vertical-align: middle; margin-left: 8px;">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="8.5" cy="7" r="4"></circle>
                                        <line x1="20" y1="8" x2="20" y2="14"></line>
                                        <line x1="23" y1="11" x2="17" y2="11"></line>
                                    </svg>
                                    بيانات السائق الإضافي
                                </h4>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label" for="driver_name">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                            اسم السائق
                                        </label>
                                        <input type="text" class="form-control" id="driver_name" name="driver_name" 
                                               placeholder="أدخل اسم السائق الإضافي">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="driver_identity_number">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                                <line x1="1" y1="10" x2="23" y2="10"></line>
                                            </svg>
                                            رقم هوية السائق
                                        </label>
                                        <input type="text" class="form-control" id="driver_identity_number" name="driver_identity_number" 
                                               placeholder="أدخل رقم الهوية" maxlength="10">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label" for="driver_mobile_number">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                                                <line x1="12" y1="18" x2="12.01" y2="18"></line>
                                            </svg>
                                            رقم جوال السائق
                                        </label>
                                        <input type="text" class="form-control" id="driver_mobile_number" name="driver_mobile_number" 
                                               placeholder="05XXXXXXXX" maxlength="10">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="driver_birth_date">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                                <line x1="8" y1="12" x2="16" y2="12"></line>
                                            </svg>
                                            تاريخ ميلاد السائق
                                        </label>
                                        <input type="date" class="form-control" id="driver_birth_date" name="driver_birth_date">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label" for="driver_driving_years">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                            </svg>
                                            سنوات القيادة
                                        </label>
                                        <select class="form-control" id="driver_driving_years" name="driver_driving_years">
                                            <option value="">اختر عدد السنوات</option>
                                            <option value="0-5">من 0 إلى 5 سنوات</option>
                                            <option value="6-10">من 6 إلى 10 سنوات</option>
                                            <option value="11-15">من 11 إلى 15 سنة</option>
                                            <option value="16-20">من 16 إلى 20 سنة</option>
                                            <option value="21+">أكثر من 20 سنة</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="driver_driving_percentage">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <polyline points="12 6 12 12 16 14"></polyline>
                                            </svg>
                                            نسبة القيادة %
                                        </label>
                                        <input type="number" class="form-control" id="driver_driving_percentage" name="driver_driving_percentage" 
                                               placeholder="أدخل نسبة القيادة" min="1" max="100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="form-actions" style="justify-content: center;">
                        <button type="submit" class="btn-submit" style="max-width: 400px;">
                            إظهار عروض التأمين
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- End insurance Form -->

    <!-- Price Summary Page -->
    <div id="priceSummaryPage" class="packages-page" style="display: none;">
        <div class="bcare-breadcrumb">
            <div class="breadcrumb-content">
                <div class="breadcrumb-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2"></rect>
                        <path d="M9 3v18"></path>
                    </svg>
                </div>
                <h1 class="breadcrumb-title">ملخص السعر</h1>
                <p class="breadcrumb-subtitle">تفاصيل الباقة المختارة</p>
            </div>
        </div>

        <div class="container">
            <button class="btn-back-packages" onclick="goBackToPackages()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                العودة للباقات
            </button>

            <div style="max-width: 800px; margin: 40px auto;">
                <div class="package-card featured" style="margin-bottom: 30px;">
                    <div class="package-header">
                        <h3 class="package-title" id="selectedPackageTitle">باقة التأمين المميزة</h3>
                    </div>

                    <!-- Price Breakdown -->
                    <div style="background: #f7f9fc; padding: 24px; border-radius: 12px; margin: 20px 0;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 2px dashed #e5e7eb;">
                            <span style="font-weight: 600; color: #4b5563;">سعر الباقة الأساسي</span>
                            <span style="font-weight: 700; color: #0066a1;" id="basePrice">1,800 ريال</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 16px;">
                            <span style="color: #6b7280;">ضريبة القيمة المضافة (15%)</span>
                            <span style="font-weight: 600; color: #6b7280;" id="vatAmount">270 ريال</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding-top: 16px; border-top: 2px solid #0066a1;">
                            <span style="font-size: 1.2rem; font-weight: 700; color: #0f2040;">المبلغ الإجمالي</span>
                            <span style="font-size: 1.4rem; font-weight: 800; color: #0066a1;" id="totalPrice">2,070 ريال</span>
                        </div>
                    </div>

                    <!-- Features Summary -->
                    <div style="background: white; padding: 20px; border-radius: 12px; border: 2px solid #e5e7eb;">
                        <h4 style="color: #0f2040; font-weight: 700; margin-bottom: 16px; font-size: 1.1rem;">المزايا المشمولة:</h4>
                        <ul class="package-features" id="selectedFeatures">
                            <li><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>كل مزايا الباقة الأساسية</li>
                            <li><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>خدمة الطريق 24/7</li>
                            <li><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>سيارة بديلة</li>
                        </ul>
                    </div>

                    <button class="btn-select-package" onclick="proceedToPayment()" style="width: 100%; margin-top: 24px;">
                        متابعة للدفع
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Page -->
    <div id="paymentPage" class="packages-page" style="display: none;">
        <div class="bcare-breadcrumb">
            <div class="breadcrumb-content">
                <div class="breadcrumb-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                        <line x1="2" y1="10" x2="22" y2="10"></line>
                    </svg>
                </div>
                <h1 class="breadcrumb-title">بيانات الدفع</h1>
                <p class="breadcrumb-subtitle">أدخل معلومات الدفع لإتمام العملية</p>
            </div>
        </div>

        <div class="container">
            <button class="btn-back-packages" onclick="goBackToSummary()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                العودة للملخص
            </button>

            <div style="max-width: 900px; margin: 40px auto; display: grid; grid-template-columns: 1fr 350px; gap: 30px;">
                <!-- Payment Form -->
                <div class="package-card">
                    <h3 style="color: #0f2040; font-weight: 700; margin-bottom: 24px; font-size: 1.3rem;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0066a1" stroke-width="2" style="vertical-align: middle; margin-left: 8px;">
                            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                            <line x1="2" y1="10" x2="22" y2="10"></line>
                        </svg>
                        معلومات البطاقة
                    </h3>

                    <form id="paymentForm">
                        <div style="margin-bottom: 20px;">
                            <label for="cardNumber" style="display: block; font-weight: 600; color: #4b5563; margin-bottom: 8px;">رقم البطاقة</label>
                            <input type="text" placeholder="0000 0000 0000 0000" maxlength="19"
                                   style="width: 100%; padding: 14px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 1rem; direction: ltr; text-align: left;"
                                   id="cardNumber" name="cardNumber" required>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                            <div>
                                <label for="expiryDate" style="display: block; font-weight: 600; color: #4b5563; margin-bottom: 8px;">تاريخ الانتهاء</label>
                                <input type="text" placeholder="MM/YY" maxlength="5"
                                       style="width: 100%; padding: 14px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 1rem; direction: ltr; text-align: left;"
                                       id="expiryDate" name="expiryDate" required>
                            </div>
                            <div>
                                <label for="cvv" style="display: block; font-weight: 600; color: #4b5563; margin-bottom: 8px;">CVV</label>
                                <input type="text" placeholder="123" maxlength="3"
                                       style="width: 100%; padding: 14px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 1rem; direction: ltr; text-align: left;"
                                       id="cvv" name="cvv" required>
                            </div>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label for="cardHolder" style="display: block; font-weight: 600; color: #4b5563; margin-bottom: 8px;">اسم حامل البطاقة</label>
                            <input type="text" placeholder="كما هو مكتوب على البطاقة"
                                   style="width: 100%; padding: 14px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 1rem;"
                                   id="cardHolder" name="cardHolder" required>
                        </div>                        <div style="background: #f0f9ff; padding: 16px; border-radius: 10px; margin-bottom: 20px; border-right: 4px solid #0066a1;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0066a1" stroke-width="2">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg>
                                <span style="color: #0066a1; font-weight: 600; font-size: 0.9rem;">جميع معلوماتك محمية بتشفير SSL</span>
                            </div>
                        </div>

                        <button type="submit" class="btn-select-package" style="width: 100%;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left: 8px;">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                            تأكيد الدفع
                        </button>
                    </form>
                </div>

                <!-- Order Summary Sidebar -->
                <div>
                    <div class="package-card" style="position: sticky; top: 20px;">
                        <h4 style="color: #0f2040; font-weight: 700; margin-bottom: 16px;">ملخص الطلب</h4>

                        <div style="background: #f7f9fc; padding: 16px; border-radius: 10px; margin-bottom: 16px;">
                            <div style="font-weight: 600; color: #0066a1; margin-bottom: 8px;" id="summaryPackageTitle">باقة التأمين المميزة</div>
                            <div style="font-size: 0.9rem; color: #6b7280;">تغطية شاملة للسيارة</div>
                        </div>

                        <div style="border-top: 2px dashed #e5e7eb; padding-top: 16px; margin-bottom: 16px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                                <span style="color: #6b7280;">سعر الباقة</span>
                                <span style="font-weight: 600;" id="summaryBasePrice">1,800 ريال</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                                <span style="color: #6b7280;">الضريبة (15%)</span>
                                <span style="font-weight: 600;" id="summaryVat">270 ريال</span>
                            </div>
                        </div>

                        <div style="background: #0066a1; color: white; padding: 16px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 700;">الإجمالي</span>
                            <span style="font-size: 1.5rem; font-weight: 800;" id="summaryTotal">2,070 ريال</span>
                        </div>

                        <div style="margin-top: 16px; padding: 12px; background: #f0fdf4; border-radius: 8px; border-right: 3px solid #22c55e;">
                            <div style="display: flex; align-items: center; gap: 8px; color: #166534; font-size: 0.85rem; font-weight: 600;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                                سارية المفعول لمدة سنة كاملة
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    @include('layouts.footer')
@endsection

@push('scripts')
<script>
        // ===== Show / Hide Overlay Loader =====
        function showOverlayLoader() {
            const overlay = document.getElementById("overlay2");
            if (overlay) {
                overlay.style.display = "flex";
                setTimeout(() => overlay.classList.add("active"), 10);
            }
        }

        function hideOverlayLoader() {
            const overlay = document.getElementById("overlay2");
            if (overlay) {
                overlay.classList.remove("active");
                setTimeout(() => overlay.style.display = "none", 300);
            }
        }

        jQuery(function($) {
            // ===== Interactive Step Progress =====
            function updateStepProgress(currentStep) {
                $('.step').each(function(index) {
                    const stepNumber = index + 1;
                    const $step = $(this);
                    const $stepLine = $step.next('.step-line');
                    
                    if (stepNumber < currentStep) {
                        // Completed steps
                        $step.addClass('completed').removeClass('active');
                        $stepLine.addClass('completed').removeClass('active');
                        
                        // Add checkmark if not already present
                        if ($step.find('.step-number svg').length === 0) {
                            $step.find('.step-number').html('<svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>');
                        }
                    } else if (stepNumber === currentStep) {
                        // Current active step
                        $step.addClass('active').removeClass('completed');
                        $stepLine.addClass('active').removeClass('completed');
                        $step.find('.step-number').text(stepNumber);
                    } else {
                        // Future steps
                        $step.removeClass('active completed');
                        $stepLine.removeClass('active completed');
                        $step.find('.step-number').text(stepNumber);
                    }
                });
            }

            // Initialize with step 2 (current page)
            updateStepProgress(2);

            // Animate progress on page load
            setTimeout(function() {
                $('.step.completed').each(function(index) {
                    const $step = $(this);
                    setTimeout(function() {
                        $step.css('opacity', '0').animate({opacity: 1}, 400);
                    }, index * 150);
                });
            }, 100);

            // ===== Region & City Data =====
            const citiesByRegion = {
                'riyadh': ['الرياض', 'الدرعية', 'الخرج', 'الدوادمي', 'المجمعة', 'القويعية', 'وادي الدواسر', 'الأفلاج', 'الزلفي', 'شقراء', 'حوطة بني تميم', 'عفيف', 'السليل', 'ضرما', 'المزاحمية', 'رماح', 'ثادق', 'حريملاء', 'الحريق', 'الغاط', 'مرات'],
                'makkah': ['مكة المكرمة', 'جدة', 'الطائف', 'القنفذة', 'رابغ', 'الليث', 'خليص', 'الجموم', 'أضم', 'تربة', 'رنية', 'الخرمة', 'بحرة', 'الكامل', 'المويه', 'ميسان', 'أملج'],
                'madinah': ['المدينة المنورة', 'ينبع', 'العلا', 'مهد الذهب', 'بدر', 'خيبر', 'الحناكية', 'العيص', 'وادي الفرع'],
                'eastern': ['الدمام', 'الخبر', 'الظهران', 'الأحساء', 'القطيف', 'حفر الباطن', 'الجبيل', 'الخفجي', 'رأس تنورة', 'بقيق', 'النعيرية', 'قرية العليا', 'العديد', 'أبو حدرية'],
                'asir': ['أبها', 'خميس مشيط', 'بيشة', 'النماص', 'محايل', 'سراة عبيدة', 'رجال ألمع', 'ظهران الجنوب', 'تثليث', 'المجاردة', 'بارق', 'بلقرن', 'المندق', 'تنومة', 'طريب'],
                'qassim': ['بريدة', 'عنيزة', 'الرس', 'المذنب', 'البكيرية', 'البدائع', 'الأسياح', 'النبهانية', 'رياض الخبراء', 'الشماسية', 'عيون الجواء', 'عقلة الصقور', 'ضرية'],
                'hail': ['حائل', 'بقعاء', 'الغزالة', 'الشنان', 'السليمي', 'الحائط', 'سميراء', 'موقق'],
                'tabuk': ['تبوك', 'الوجه', 'ضباء', 'تيماء', 'أملج', 'حقل', 'البدع'],
                'jazan': ['جازان', 'صبيا', 'أبو عريش', 'صامطة', 'بيش', 'فرسان', 'العارضة', 'الداير', 'الريث', 'ضمد', 'العيدابي', 'الحرث', 'فيفا', 'الدرب'],
                'najran': ['نجران', 'شرورة', 'حبونا', 'بدر الجنوب', 'يدمة', 'ثار', 'خباش'],
                'baha': ['الباحة', 'بلجرشي', 'المندق', 'المخواة', 'قلوة', 'العقيق', 'الحجرة', 'غامد الزناد', 'بني حسن'],
                'jouf': ['سكاكا', 'القريات', 'دومة الجندل', 'طبرجل', 'صوير'],
                'northern': ['عرعر', 'رفحاء', 'طريف', 'العويقيلة']
            };

            // ===== Region Change Handler =====
            $('#region').on('change', function() {
                const region = $(this).val();
                const citySelect = $('#city');
                
                // Clear and disable city if no region selected
                if (!region) {
                    citySelect.html('<option value="">اختر المنطقة أولاً</option>').prop('disabled', true);
                    return;
                }
                
                // Enable city select and populate cities
                citySelect.prop('disabled', false);
                citySelect.html('<option value="">اختر المدينة</option>');
                
                const cities = citiesByRegion[region] || [];
                cities.forEach(city => {
                    citySelect.append(`<option value="${city}">${city}</option>`);
                });
            });

            // ===== Additional Driver Toggle =====
            $('#has_additional_driver').on('change', function() {
                const driverSection = $('#additionalDriverSection');
                const driverInputs = driverSection.find('input');
                
                if ($(this).val() === 'yes') {
                    driverSection.slideDown(400);
                    // Make driver fields required
                    driverInputs.each(function() {
                        $(this).attr('required', true);
                    });
                } else {
                    driverSection.slideUp(400);
                    // Remove required and clear values
                    driverInputs.each(function() {
                        $(this).removeAttr('required').val('');
                    });
                }
            });

            // ===== Set minimum date for policy start (today) =====
            const today = new Date().toISOString().split('T')[0];
            $('#policy_start_date').attr('min', today);

            // ===== Set maximum date for birth date (18 years ago) =====
            const maxBirthDate = new Date();
            maxBirthDate.setFullYear(maxBirthDate.getFullYear() - 18);
            $('#birth_date').attr('max', maxBirthDate.toISOString().split('T')[0]);

            // ===== Helper Functions for Error Messages =====
            function showError(fieldId, message) {
                const field = $('#' + fieldId);
                const errorDiv = $('#' + fieldId + '_error');
                
                field.addClass('is-invalid');
                errorDiv.find('span').text(message);
                errorDiv.addClass('show');
            }

            function hideError(fieldId) {
                const field = $('#' + fieldId);
                const errorDiv = $('#' + fieldId + '_error');
                
                field.removeClass('is-invalid');
                errorDiv.removeClass('show');
            }

            function hideAllErrors() {
                $('.error-message').removeClass('show');
                $('.form-control').removeClass('is-invalid');
            }

            // ===== Form Validation =====
            let isFormSubmitting = false;
            
            $('#insuranceForm').on('submit', function(e) {
                // If already validated and submitting, allow it
                if (isFormSubmitting) {
                    return true;
                }
                
                e.preventDefault();
                
                hideAllErrors();
                let isValid = true;
                let firstErrorField = null;

                // Validate full name
                const fullName = $('#full_name').val().trim();
                if (!fullName) {
                    showError('full_name', 'هذا الحقل مطلوب');
                    isValid = false;
                    if (!firstErrorField) firstErrorField = $('#full_name');
                } else if (!/^[\u0600-\u06FFa-zA-Z\s]+$/.test(fullName)) {
                    showError('full_name', 'الاسم يجب أن يكون بالعربية أو الإنجليزية فقط');
                    isValid = false;
                    if (!firstErrorField) firstErrorField = $('#full_name');
                }

                // Validate identity number
                const identityNumber = $('#identity_number').val().trim();
                if (!identityNumber) {
                    showError('identity_number', 'هذا الحقل مطلوب');
                    isValid = false;
                    if (!firstErrorField) firstErrorField = $('#identity_number');
                } else if (!/^[12][0-9]{9}$/.test(identityNumber)) {
                    showError('identity_number', 'يجب أن يتكون من 10 أرقام ويبدأ بـ 1 أو 2');
                    isValid = false;
                    if (!firstErrorField) firstErrorField = $('#identity_number');
                }

                // Validate mobile number
                const mobileNumber = $('#mobile_number').val().trim();
                if (!mobileNumber) {
                    showError('mobile_number', 'هذا الحقل مطلوب');
                    isValid = false;
                    if (!firstErrorField) firstErrorField = $('#mobile_number');
                } else if (!/^05[0-9]{8}$/.test(mobileNumber)) {
                    showError('mobile_number', 'يجب أن يبدأ بـ 05 ويتكون من 10 أرقام');
                    isValid = false;
                    if (!firstErrorField) firstErrorField = $('#mobile_number');
                }

                // Validate birth date
                const birthDate = $('#birth_date').val();
                if (!birthDate) {
                    showError('birth_date', 'هذا الحقل مطلوب');
                    isValid = false;
                    if (!firstErrorField) firstErrorField = $('#birth_date');
                } else {
                    const birthDateObj = new Date(birthDate);
                    const today = new Date();
                    const age = today.getFullYear() - birthDateObj.getFullYear();
                    if (age < 18) {
                        showError('birth_date', 'يجب أن لا يقل العمر عن 18 عاماً');
                        isValid = false;
                        if (!firstErrorField) firstErrorField = $('#birth_date');
                    }
                }

                // Validate region
                const region = $('#region').val();
                if (!region) {
                    showError('region', 'هذا الحقل مطلوب');
                    isValid = false;
                    if (!firstErrorField) firstErrorField = $('#region');
                }

                // Validate city
                const city = $('#city').val();
                if (!city) {
                    showError('city', 'هذا الحقل مطلوب - اختر المنطقة أولاً');
                    isValid = false;
                    if (!firstErrorField) firstErrorField = $('#city');
                }

                // Validate driving years
                const drivingYears = $('#driving_years').val();
                if (!drivingYears) {
                    showError('driving_years', 'هذا الحقل مطلوب');
                    isValid = false;
                    if (!firstErrorField) firstErrorField = $('#driving_years');
                }

                // Validate approximate price
                const approximatePrice = $('#approximate_price').val().trim();
                if (!approximatePrice) {
                    showError('approximate_price', 'هذا الحقل مطلوب');
                    isValid = false;
                    if (!firstErrorField) firstErrorField = $('#approximate_price');
                } else {
                    const priceValue = parseInt(approximatePrice);
                    if (priceValue < 1000 || priceValue > 99999999) {
                        showError('approximate_price', 'يجب أن يكون بين 1,000 و 99,999,999 ريال');
                        isValid = false;
                        if (!firstErrorField) firstErrorField = $('#approximate_price');
                    }
                }

                // Validate all required select fields
                const requiredSelects = ['insurance_type', 'usage_category', 'policy_start_date', 'vehicle_type', 'vehicle_model', 'manufacturing_year', 'maintenance_type'];
                requiredSelects.forEach(function(fieldId) {
                    const value = $('#' + fieldId).val();
                    if (!value || value === '') {
                        $('#' + fieldId).addClass('is-invalid');
                        if ($('#' + fieldId + '_error').length === 0) {
                            const errorDiv = $('<div class="error-message" id="' + fieldId + '_error"><svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12" stroke="white" stroke-width="2"></line><line x1="12" y1="16" x2="12.01" y2="16" stroke="white" stroke-width="2"></line></svg><span>هذا الحقل مطلوب</span></div>');
                            $('#' + fieldId).closest('.form-group').append(errorDiv);
                            setTimeout(() => errorDiv.addClass('show'), 10);
                        } else {
                            $('#' + fieldId + '_error').addClass('show').find('span').text('هذا الحقل مطلوب');
                        }
                        isValid = false;
                        if (!firstErrorField) firstErrorField = $('#' + fieldId);
                    }
                });

                // Validate additional driver if selected
                if ($('#has_additional_driver').val() === 'yes') {
                    const driverName = $('#driver_name').val().trim();
                    const driverIdentityNumber = $('#driver_identity_number').val().trim();
                    const driverMobileNumber = $('#driver_mobile_number').val().trim();
                    const driverBirthDate = $('#driver_birth_date').val();
                    const driverDrivingYears = $('#driver_driving_years').val();
                    const driverDrivingPercentage = $('#driver_driving_percentage').val();
                    
                    // Validate driver name
                    if (!driverName) {
                        showError('driver_name', 'هذا الحقل مطلوب');
                        isValid = false;
                        if (!firstErrorField) firstErrorField = $('#driver_name');
                    } else if (!/^[\u0600-\u06FFa-zA-Z\s]+$/.test(driverName)) {
                        showError('driver_name', 'الاسم يجب أن يكون بالعربية أو الإنجليزية');
                        isValid = false;
                        if (!firstErrorField) firstErrorField = $('#driver_name');
                    }
                    
                    // Validate driver identity number
                    if (!driverIdentityNumber) {
                        showError('driver_identity_number', 'هذا الحقل مطلوب');
                        isValid = false;
                        if (!firstErrorField) firstErrorField = $('#driver_identity_number');
                    } else if (!/^[12]\d{9}$/.test(driverIdentityNumber)) {
                        showError('driver_identity_number', 'يجب أن يكون 10 أرقام ويبدأ بـ 1 أو 2');
                        isValid = false;
                        if (!firstErrorField) firstErrorField = $('#driver_identity_number');
                    }
                    
                    // Validate driver mobile number
                    if (!driverMobileNumber) {
                        showError('driver_mobile_number', 'هذا الحقل مطلوب');
                        isValid = false;
                        if (!firstErrorField) firstErrorField = $('#driver_mobile_number');
                    } else if (!/^05\d{8}$/.test(driverMobileNumber)) {
                        showError('driver_mobile_number', 'يجب أن يبدأ بـ 05 ويتكون من 10 أرقام');
                        isValid = false;
                        if (!firstErrorField) firstErrorField = $('#driver_mobile_number');
                    }
                    
                    // Validate driver birth date
                    if (!driverBirthDate) {
                        showError('driver_birth_date', 'هذا الحقل مطلوب');
                        isValid = false;
                        if (!firstErrorField) firstErrorField = $('#driver_birth_date');
                    } else {
                        const birthDate = new Date(driverBirthDate);
                        const today = new Date();
                        const age = today.getFullYear() - birthDate.getFullYear();
                        if (age < 18 || age > 80) {
                            showError('driver_birth_date', 'العمر يجب أن يكون بين 18 و 80 سنة');
                            isValid = false;
                            if (!firstErrorField) firstErrorField = $('#driver_birth_date');
                        }
                    }
                    
                    // Validate driver driving years
                    if (!driverDrivingYears) {
                        showError('driver_driving_years', 'هذا الحقل مطلوب');
                        isValid = false;
                        if (!firstErrorField) firstErrorField = $('#driver_driving_years');
                    }
                    
                    // Validate driver driving percentage
                    if (!driverDrivingPercentage) {
                        showError('driver_driving_percentage', 'هذا الحقل مطلوب');
                        isValid = false;
                        if (!firstErrorField) firstErrorField = $('#driver_driving_percentage');
                    } else {
                        const percentage = parseInt(driverDrivingPercentage);
                        if (percentage < 1 || percentage > 100) {
                            showError('driver_driving_percentage', 'النسبة يجب أن تكون بين 1 و 100');
                            isValid = false;
                            if (!firstErrorField) firstErrorField = $('#driver_driving_percentage');
                        }
                    }
                }

                // If validation fails, scroll to first error
                if (!isValid) {
                    if (firstErrorField) {
                        $('html, body').animate({
                            scrollTop: firstErrorField.offset().top - 100
                        }, 500);
                        firstErrorField.focus();
                    }
                    return false;
                }

                // All validations passed - submit form
                isFormSubmitting = true;
                this.submit();
            });

            // ===== Input Formatting =====
            // Format mobile number input (numbers only)
            $('#mobile_number').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                if (value.length > 10) {
                    value = value.substring(0, 10);
                }
                $(this).val(value);
            });

            // Format identity number input (numbers only, 10 digits, starts with 1 or 2)
            $('#identity_number').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                if (value.length > 10) {
                    value = value.substring(0, 10);
                }
                $(this).val(value);
            });

            // Format driver identity number input (numbers only)
            $('#driver_identity_number').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                if (value.length > 10) {
                    value = value.substring(0, 10);
                }
                $(this).val(value);
            });
            
            // Format driver mobile number input (numbers only)
            $('#driver_mobile_number').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                if (value.length > 10) {
                    value = value.substring(0, 10);
                }
                $(this).val(value);
            });

            // Format approximate price with thousands separator
            $('#approximate_price').on('blur', function() {
                const value = $(this).val();
                if (value) {
                    const formatted = parseInt(value).toLocaleString('ar-SA');
                    // Store the actual value, display formatted
                    $(this).data('raw-value', value);
                }
            });

            $('#approximate_price').on('focus', function() {
                const rawValue = $(this).data('raw-value');
                if (rawValue) {
                    $(this).val(rawValue);
                }
            });

            // Real-time validation feedback
            $('#mobile_number').on('blur', function() {
                const value = $(this).val();
                if (value && !/^05[0-9]{8}$/.test(value)) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Remove errors on input change
            $('input, select').on('input change', function() {
                const fieldId = $(this).attr('id');
                if (fieldId) {
                    hideError(fieldId);
                }
            });

            // Real-time validation on blur
            $('#full_name').on('blur', function() {
                const value = $(this).val().trim();
                if (!value) {
                    showError('full_name', 'هذا الحقل مطلوب');
                } else if (!/^[\u0600-\u06FFa-zA-Z\s]+$/.test(value)) {
                    showError('full_name', 'الاسم يجب أن يكون بالعربية أو الإنجليزية فقط');
                } else {
                    hideError('full_name');
                }
            });

            $('#identity_number').on('blur', function() {
                const value = $(this).val().trim();
                if (!value) {
                    showError('identity_number', 'هذا الحقل مطلوب');
                } else if (!/^[12][0-9]{9}$/.test(value)) {
                    showError('identity_number', 'يجب أن يتكون من 10 أرقام ويبدأ بـ 1 أو 2');
                } else {
                    hideError('identity_number');
                }
            });

            $('#mobile_number').on('blur', function() {
                const value = $(this).val().trim();
                if (!value) {
                    showError('mobile_number', 'هذا الحقل مطلوب');
                } else if (!/^05[0-9]{8}$/.test(value)) {
                    showError('mobile_number', 'يجب أن يبدأ بـ 05 ويتكون من 10 أرقام');
                } else {
                    hideError('mobile_number');
                }
            });

            $('#birth_date').on('blur', function() {
                const value = $(this).val();
                if (!value) {
                    showError('birth_date', 'هذا الحقل مطلوب');
                } else {
                    const birthDateObj = new Date(value);
                    const today = new Date();
                    const age = today.getFullYear() - birthDateObj.getFullYear();
                    if (age < 18) {
                        showError('birth_date', 'يجب أن لا يقل العمر عن 18 عاماً');
                    } else {
                        hideError('birth_date');
                    }
                }
            });

            $('#approximate_price').on('blur', function() {
                const value = $(this).val().trim();
                if (!value) {
                    showError('approximate_price', 'هذا الحقل مطلوب');
                } else {
                    const priceValue = parseInt(value);
                    if (priceValue < 1000 || priceValue > 99999999) {
                        showError('approximate_price', 'يجب أن يكون بين 1,000 و 99,999,999 ريال');
                    } else {
                        hideError('approximate_price');
                    }
                }
            });
        });

        // Back to form function
        function goBackToForm() {
            $('#packagesPage').fadeOut(300);
            setTimeout(function() {
                $('section.bc-skin').fadeIn(500);
                window.scrollTo({top: 0, behavior: 'smooth'});
            }, 300);
        }

        // Store selected package data
        let selectedPackage = {
            name: '',
            price: 0,
            features: []
        };

        // Package selection with loader
        $(document).on('click', '.btn-select-package', function() {
            const packageType = $(this).data('package');
            const packagePrice = $(this).data('price');

            if (!packageType || !packagePrice) return; // Skip if no data attributes

            // Store package data
            selectedPackage.price = packagePrice;
            const vat = Math.round(packagePrice * 0.15);
            const total = packagePrice + vat;

            // Get package details
            const packageCard = $(this).closest('.package-card');
            selectedPackage.name = packageCard.find('.package-title').text();
            selectedPackage.features = [];
            packageCard.find('.package-features li').each(function() {
                selectedPackage.features.push($(this).text());
            });

            // Show loader
            showOverlayLoader();

            // After 2 seconds, show price summary
            setTimeout(function() {
                hideOverlayLoader();

                // Hide packages, show summary
                $('#packagesPage').fadeOut(300);
                setTimeout(function() {
                    // Update summary page
                    $('#selectedPackageTitle').text(selectedPackage.name);
                    $('#basePrice').text(packagePrice.toLocaleString() + ' ريال');
                    $('#vatAmount').text(vat.toLocaleString() + ' ريال');
                    $('#totalPrice').text(total.toLocaleString() + ' ريال');

                    // Update features
                    let featuresHTML = '';
                    selectedPackage.features.forEach(feature => {
                        featuresHTML += `<li><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>${feature}</li>`;
                    });
                    $('#selectedFeatures').html(featuresHTML);

                    $('#priceSummaryPage').fadeIn(500);
                    window.scrollTo({top: 0, behavior: 'smooth'});
                }, 300);
            }, 2000);
        });

        // Navigate back to packages
        function goBackToPackages() {
            $('#priceSummaryPage').fadeOut(300);
            setTimeout(function() {
                $('#packagesPage').fadeIn(500);
                window.scrollTo({top: 0, behavior: 'smooth'});
            }, 300);
        }

        // Proceed to payment
        function proceedToPayment() {
            showOverlayLoader();

            setTimeout(function() {
                hideOverlayLoader();

                const vat = Math.round(selectedPackage.price * 0.15);
                const total = selectedPackage.price + vat;

                // Update payment page summary
                $('#summaryPackageTitle').text(selectedPackage.name);
                $('#summaryBasePrice').text(selectedPackage.price.toLocaleString() + ' ريال');
                $('#summaryVat').text(vat.toLocaleString() + ' ريال');
                $('#summaryTotal').text(total.toLocaleString() + ' ريال');

                $('#priceSummaryPage').fadeOut(300);
                setTimeout(function() {
                    $('#paymentPage').fadeIn(500);
                    window.scrollTo({top: 0, behavior: 'smooth'});
                }, 300);
            }, 1500);
        }

        // Navigate back to summary
        function goBackToSummary() {
            $('#paymentPage').fadeOut(300);
            setTimeout(function() {
                $('#priceSummaryPage').fadeIn(500);
                window.scrollTo({top: 0, behavior: 'smooth'});
            }, 300);
        }

        // Handle payment form submission
        $('#paymentForm').on('submit', function(e) {
            e.preventDefault();

            showOverlayLoader();

            setTimeout(function() {
                hideOverlayLoader();

                Swal.fire({
                    icon: 'success',
                    title: 'تم الدفع بنجاح!',
                    text: 'تم تأكيد طلب التأمين وسيتم إرسال الوثيقة إلى بريدك الإلكتروني',
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#0066a1'
                }).then(() => {
                    // Redirect or refresh
                    window.location.reload();
                });
            }, 3000);
        });

        // Format card number input
        $('#cardNumber').on('input', function() {
            let value = $(this).val().replace(/\s/g, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            $(this).val(formattedValue);
        });

        // Format expiry date
        $('#expiryDate').on('input', function() {
            let value = $(this).val().replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.slice(0, 2) + '/' + value.slice(2, 4);
            }
            $(this).val(value);
        });

        // Only numbers for CVV
        $('#cvv').on('input', function() {
            $(this).val($(this).val().replace(/\D/g, ''));
        });

        // $(document).ready(function() {
        //     // Function to generate captcha
        //     // function generateCaptcha(form) {
        //     //     var canvas = form.find(".captcha")[0];
        //     //     var context = canvas.getContext("2d");
        //     //     var characters = "0123456789";
        //     //     var captchaCode = "";

        //     //     context.clearRect(0, 0, canvas.width, canvas.height);

        //     //     for (var i = 0; i < 4; i++) {
        //     //         var character = characters.charAt(Math.floor(Math.random() * characters.length));
        //     //         captchaCode += character;

        //     //         context.font = (20 + Math.random() * 10) + "px Arial";
        //     //         context.textAlign = "center";
        //     //         context.textBaseline = "middle";
        //     //         context.fillStyle = "rgb(" + Math.floor(Math.random() * 256) + "," + Math.floor(Math.random() * 256) +
        //     //             "," + Math.floor(Math.random() * 256) + ")";

        //     //         var angle = -45 + Math.random() * 90;
        //     //         context.translate(20 + i * 30, canvas.height / 2);
        //     //         context.rotate(angle * Math.PI / 180);
        //     //         context.fillText(character, 0, 0);
        //     //         context.rotate(-1 * angle * Math.PI / 180);
        //     //         context.translate(-(20 + i * 30), -1 * canvas.height / 2);
        //     //     }

        //     //     sessionStorage.setItem("captchaCode_" + form.attr("id"), captchaCode);
        //     // }

        //     // Generate captcha for each form on page load
        //     // $(".captcha-form").each(function() {
        //     //     generateCaptcha($(this));
        //     // });

        //     // Handle form submission
        //     // $(".captcha-form").on("submit", function(event) {
        //     //     var form = $(this);
        //     //     var captchaInput = form.find(".captcha-input").val();
        //     //     var captchaCode = sessionStorage.getItem("captchaCode_" + form.attr("id"));

        //     //     if (captchaInput !== captchaCode) {
        //     //         // If captcha is incorrect, show SweetAlert error message
        //     //         event.preventDefault(); // Prevent default form submission
        //     //         Swal.fire({
        //     //             icon: 'error',
        //     //             title: 'Invalid Captcha',
        //     //             text: 'Please try again.',
        //     //         }).then(function() {
        //     //             generateCaptcha(form);
        //     //             form.find(".captcha-input").val("");
        //     //         });
        //     //     }
        //     // });

        //     // Handle captcha refresh button click
        //     // $(".refresh-captcha").on("click", function() {
        //     //     var form = $(this).closest("form");
        //     //     generateCaptcha(form);
        //     //     form.find(".captcha-input").val("");
        //     // });
        // });
</script>
@endpush

@push('styles')
<style>
    :root {
        --bcare-tab-blue: var(--bcare-primary, #0066a1);
        --bcare-tab-blue-hover: var(--bcare-primary-dark, #004d7a);
        --bcare-tab-yellow: #FFB800;
        --tab-h: 64px;
        --tab-ico: 22px;
        --tab-gap: 28px;
    }

    .rtl {
        direction: rtl;
    }

    .bcare-head {
        background: transparent;
        padding-top: 1rem;
    }

    .bcare-tabs-wrap {
        max-width: 1280px;
        margin-inline: auto;
        border-radius: 16px;
        position: relative;
    }

    .bcare-tabs {
        list-style: none;
        margin: 0;
        padding: 0 48px;
        display: flex;
        align-items: flex-end;
        gap: 6px;
        background: transparent;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
    }

    .tab-item {
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
    }

    .tab-link {
        display: flex;
        align-items: center;
        gap: 10px;
        height: var(--tab-h);
        padding: 0 var(--tab-gap);
        color: #fff;
        text-decoration: none;
        position: relative;
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
        transition: background .2s ease, color .2s ease, transform .15s ease;
        background: var(--bcare-tab-blue);
    }

    .tab-link:hover {
        background: var(--bcare-tab-blue-hover);
    }

    .tab-ico {
        width: var(--tab-ico);
        height: var(--tab-ico);
        fill: #fff;
        flex: 0 0 var(--tab-ico);
    }

    .tab-text {
        margin: 0;
        font-size: 14px;
        font-weight: 700;
        color: #fff;
        white-space: nowrap;
    }

    /* Active Tab */
    .active-tab .tab-link {
        transform: translateY(-8px);
        background: var(--bcare-tab-blue);
    }

    .active-tab .tab-link::after {
        content: "";
        position: absolute;
        inset-inline: 14px;
        bottom: -8px;
        height: 4px;
        background: var(--bcare-tab-yellow);
        border-radius: 4px;
    }

    /* Tabs Divider */
    .tabs-divider {
        height: 35px;
        background: #EBEBEB;
        border-bottom-left-radius: 16px;
        border-bottom-right-radius: 16px;
    }

    /* ===== Bcare Modern Breadcrumb ===== */
    .bcare-breadcrumb {
        background: linear-gradient(135deg, #146394 0%, #0f4570 100%);
        padding: 3rem 0 2.5rem;
        position: relative;
        overflow: hidden;
    }

    .bcare-breadcrumb::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background:
            radial-gradient(circle at 20% 50%, rgba(20, 99, 148, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(20, 99, 148, 0.15) 0%, transparent 50%);
    }

    .breadcrumb-content {
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .breadcrumb-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 70px;
        height: 70px;
        background: rgba(0, 102, 161, 0.15);
        border-radius: 50%;
        margin-bottom: 1.25rem;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(0, 102, 161, 0.2);
    }

    .breadcrumb-icon svg {
        color: var(--bcare-primary);
    }

    .breadcrumb-title {
        color: var(--bcare-gray-900);
        font-size: 2.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .breadcrumb-subtitle {
        color: var(--bcare-gray-600);
        font-size: 1.05rem;
        margin: 0;
    }

    /* ===== Modern Form Container ===== */
    .bcare-insurance-form {
        padding: 4rem 0;
        background: var(--bcare-bg-secondary);
    }

    .form-wrapper {
        background: var(--bcare-bg-primary);
        border-radius: var(--bcare-radius-2xl);
        box-shadow: var(--bcare-shadow-xl);
        overflow: hidden;
    }

    /* ===== Step Indicator ===== */
    .form-header {
        background: linear-gradient(135deg, var(--bcare-primary) 0%, var(--bcare-primary-dark) 100%);
        padding: 2.5rem 2rem;
    }

    .step-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0;
        flex-wrap: wrap;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        position: relative;
    }

    .step-number {
        width: 50px;
        height: 50px;
        border-radius: var(--bcare-radius-full);
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.7);
        transition: all var(--bcare-transition);
    }

    .step.completed .step-number,
    .step.active .step-number {
        background: var(--bcare-bg-primary);
        color: var(--bcare-primary);
        border-color: var(--bcare-bg-primary);
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
    }

    .step.completed .step-number::after {
        content: '✓';
        position: absolute;
    }

    .step-label {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.9rem;
        font-weight: 500;
        white-space: nowrap;
    }

    .step.active .step-label {
        color: var(--bcare-bg-primary);
        font-weight: 600;
    }

    .step-line {
        width: 80px;
        height: 2px;
        background: rgba(255, 255, 255, 0.3);
        margin: 0 1rem;
        align-self: flex-start;
        margin-top: 24px;
    }

    .step-line.active {
        background: var(--bcare-bg-primary);
    }

    /* ===== Form Body ===== */
    .form-body {
        padding: 3rem 2.5rem;
    }

    .form-section {
        margin-bottom: var(--bcare-spacing-2xl);
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: var(--bcare-spacing-sm);
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--bcare-gray-800);
        margin-bottom: var(--bcare-spacing-xl);
        padding-bottom: var(--bcare-spacing-md);
        border-bottom: 2px solid var(--bcare-border-light);
    }

    .section-title svg {
        color: var(--bcare-primary);
    }

    /* ===== Modern Form Group (Using BCare Theme) ===== */
    .form-group.modern {
        position: relative;
    }

    /* Override to use BCare classes */
    .form-group.modern .form-label {
        display: flex;
        align-items: center;
        gap: var(--bcare-spacing-xs);
        font-weight: 600;
        color: var(--bcare-gray-700);
        margin-bottom: var(--bcare-spacing-sm);
        font-size: 0.95rem;
    }

    .form-group.modern .form-label svg {
        color: var(--bcare-primary);
        flex-shrink: 0;
    }

    .form-control.modern-input,
    .form-control.modern-select {
        height: 52px;
        border: 2px solid var(--bcare-border-medium);
        border-radius: var(--bcare-radius-lg);
        padding: 0 1.25rem;
        font-size: 1rem;
        transition: all var(--bcare-transition);
        background: var(--bcare-gray-50);
        font-family: 'Noto Sans Arabic', sans-serif;
    }

    .form-control.modern-input:focus,
    .form-control.modern-select:focus {
        border-color: var(--bcare-primary);
        background: var(--bcare-bg-primary);
        box-shadow: 0 0 0 3px rgba(0, 102, 161, 0.1);
        outline: none;
    }

    .form-control.modern-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%230066a1' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: left 1rem center;
        background-size: 20px;
        padding-left: 3rem;
    }

    /* Input with Icon/Suffix */
    .input-with-icon {
        position: relative;
    }

    .input-with-icon .form-control {
        padding-left: 4rem;
    }

    .input-suffix {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--bcare-primary);
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* ===== Radio Cards (Using BCare Theme) ===== */
    .radio-group-modern {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: var(--bcare-spacing-md);
    }

    .radio-card {
        cursor: pointer;
        margin: 0;
    }

    .radio-card input[type="radio"] {
        display: none;
    }

    .radio-card-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: var(--bcare-spacing-sm);
        padding: 1.5rem;
        border: 2px solid var(--bcare-border-medium);
        border-radius: var(--bcare-radius-lg);
        background: var(--bcare-gray-50);
        transition: all var(--bcare-transition);
        position: relative;
        min-height: 120px;
        justify-content: center;
    }

    .radio-card-content svg {
        color: var(--bcare-gray-400);
        transition: all var(--bcare-transition);
    }

    .radio-card-content span {
        font-weight: 600;
        color: var(--bcare-gray-700);
        font-size: 1rem;
    }

    .radio-checkmark {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        width: 24px;
        height: 24px;
        border: 2px solid var(--bcare-border-medium);
        border-radius: var(--bcare-radius-full);
        background: var(--bcare-bg-primary);
        transition: all var(--bcare-transition);
    }

    .radio-checkmark::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        width: 12px;
        height: 12px;
        border-radius: var(--bcare-radius-full);
        background: var(--bcare-bg-primary);
        transition: transform var(--bcare-transition-fast) ease;
    }

    .radio-card input:checked+.radio-card-content {
        border-color: var(--bcare-primary);
        background: var(--bcare-primary-lighter);
    }

    .radio-card input:checked+.radio-card-content svg {
        color: var(--bcare-primary);
    }

    .radio-card input:checked+.radio-card-content .radio-checkmark {
        background: var(--bcare-primary);
        border-color: var(--bcare-primary);
    }

    .radio-card input:checked+.radio-card-content .radio-checkmark::after {
        transform: translate(-50%, -50%) scale(1);
    }

    .radio-card-content:hover {
        border-color: var(--bcare-border-dark);
        transform: translateY(-2px);
        box-shadow: var(--bcare-shadow-md);
    }

    /* ===== Consent Box (Using BCare Theme) ===== */
    .consent-box {
        background: var(--bcare-primary-lighter);
        border: 2px solid var(--bcare-border-light);
        border-radius: var(--bcare-radius-lg);
        padding: 1.5rem;
    }

    .checkbox-modern {
        display: flex;
        align-items: flex-start;
        gap: var(--bcare-spacing-md);
        cursor: pointer;
        margin: 0;
    }

    .checkbox-modern input[type="checkbox"] {
        display: none;
    }

    .checkbox-modern .checkmark {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        border: 2px solid var(--bcare-border-dark);
        border-radius: var(--bcare-radius-sm);
        background: var(--bcare-bg-primary);
        position: relative;
        transition: all var(--bcare-transition);
    }

    .checkbox-modern .checkmark::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        width: 14px;
        height: 14px;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3'%3E%3Cpolyline points='20 6 9 17 4 12'%3E%3C/polyline%3E%3C/svg%3E") center/contain no-repeat;
        transition: transform var(--bcare-transition-fast) ease;
    }

    .checkbox-modern input:checked+.checkmark {
        background: var(--bcare-primary);
        border-color: var(--bcare-primary);
    }

    .checkbox-modern input:checked+.checkmark::after {
        transform: translate(-50%, -50%) scale(1);
    }

    .consent-text {
        display: flex;
        align-items: flex-start;
        gap: var(--bcare-spacing-sm);
        line-height: 1.6;
        color: var(--bcare-gray-700);
    }

    .consent-text svg {
        flex-shrink: 0;
        color: var(--bcare-primary);
        margin-top: 0.1rem;
    }

    /* ===== Submit Button (Using BCare Secondary) ===== */
    .btn-submit-modern {
        width: 100%;
        height: 60px;
        background: linear-gradient(135deg, var(--bcare-secondary) 0%, var(--bcare-secondary-dark) 100%);
        border: none;
        border-radius: var(--bcare-radius-lg);
        color: white;
        font-size: 1.1rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: var(--bcare-spacing-sm);
        cursor: pointer;
        transition: all var(--bcare-transition);
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
        font-family: 'Noto Sans Arabic', sans-serif;
    }

    .btn-submit-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.5);
        background: linear-gradient(135deg, var(--bcare-secondary-dark) 0%, var(--bcare-secondary-darker) 100%);
    }

    .btn-submit-modern:active {
        transform: translateY(0);
    }

    .btn-icon {
        transition: transform var(--bcare-transition);
    }

    .btn-submit-modern:hover .btn-icon {
        transform: translateX(-4px);
    }

    /* ===== Error Message ===== */
    .error-message {
        display: block;
        color: var(--bcare-error);
        font-size: 0.875rem;
        margin-top: var(--bcare-spacing-xs);
        font-weight: 500;
    }

    /* ===== Responsive Design ===== */
    @media (max-width: 768px) {
        .container {
            padding: 20px 15px;
        }

        .breadcrumb-title {
            font-size: 1.8rem;
        }

        .breadcrumb-nav-small {
            margin: -0.5rem 0 1rem;
        }

        .breadcrumb-list-small {
            justify-content: center;
            font-size: 0.75rem;
        }

        .breadcrumb-link-small {
            font-size: 0.75rem;
            padding: 0.2rem 0.4rem;
        }

        .breadcrumb-item-small.active .breadcrumb-current-small {
            font-size: 0.75rem;
            padding: 0.2rem 0.4rem;
        }

        .step-indicator {
            gap: 0.5rem;
        }

        .step-line {
            width: 40px;
            margin: 0 0.5rem;
        }

        .step-label {
            font-size: 0.75rem;
        }

        .form-body {
            padding: 2rem 1.5rem;
        }

        .form-card {
            padding: 20px;
        }

        .section-title {
            font-size: 1.2rem;
        }

        .radio-group-modern {
            grid-template-columns: 1fr;
        }

        .radio-group-bcare {
            gap: 1.5rem;
        }

        .section-label {
            font-size: 0.95rem;
        }

        .additional-driver-details {
            padding: 1.25rem;
        }
    }

    @media (max-width: 640px) {
        :root {
            --tab-h: 56px;
            --tab-ico: 20px;
            --tab-gap: 16px;
        }

        .bcare-tabs {
            padding: 0 16px;
            justify-content: space-around;
        }

        .tab-text {
            font-size: 13px;
        }

        .active-tab .tab-link {
            transform: translateY(-6px);
        }

        .active-tab .tab-link::after {
            bottom: -6px;
        }

        input[type="date"].form-control {
            padding-left: 3rem;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .bcare-breadcrumb {
            padding: 2.5rem 0 2rem;
        }

        .breadcrumb-icon {
            width: 60px;
            height: 60px;
        }

        .breadcrumb-title {
            font-size: 1.5rem;
        }

        .breadcrumb-subtitle {
            font-size: 0.95rem;
        }

        .form-header {
            padding: 1.5rem 1rem;
        }

        .step-number {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .step-line {
            margin-top: 19px;
        }

        .form-body {
            padding: 1.5rem 1rem;
        }
    }

    /* High Contrast Mode */
    @media (prefers-contrast: more) {
        .active-tab .tab-link::after {
            height: 5px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function checkLength( input ) {
        var maxLength = 4;
        if ( input.value.length > maxLength ) {
            input.value = input.value.slice( 0, maxLength );
        }
    }

    // Additional Driver Toggle
    document.addEventListener('DOMContentLoaded', function() {
        const additionalDriverYes = document.getElementById('additional_driver_yes');
        const additionalDriverNo = document.getElementById('additional_driver_no');
        const additionalDriverDetails = document.getElementById('additionalDriverDetails');

        function toggleDriverDetails() {
            if (additionalDriverYes && additionalDriverYes.checked) {
                additionalDriverDetails.style.display = 'block';
                // Make fields required when visible
                const driverInputs = additionalDriverDetails.querySelectorAll('input');
                driverInputs.forEach(input => {
                    if (input.type !== 'radio' && input.type !== 'checkbox') {
                        input.setAttribute('required', 'required');
                    }
                });
            } else {
                additionalDriverDetails.style.display = 'none';
                // Remove required when hidden
                const driverInputs = additionalDriverDetails.querySelectorAll('input');
                driverInputs.forEach(input => {
                    input.removeAttribute('required');
                    input.value = ''; // Clear values
                });
            }
        }

        if (additionalDriverYes && additionalDriverNo) {
            additionalDriverYes.addEventListener('change', toggleDriverDetails);
            additionalDriverNo.addEventListener('change', toggleDriverDetails);

            // Check on page load (for old values)
            toggleDriverDetails();
        }

        // Date Input - Prevent Past Dates
        const documentStartDate = document.getElementById('document_start_date');
        const driverBirthDate = document.getElementById('driver_birth_date');

        if (documentStartDate) {
            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            documentStartDate.setAttribute('min', today);

            // Prevent manual entry of past dates
            documentStartDate.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const todayDate = new Date(today);

                if (selectedDate < todayDate) {
                    this.value = today;
                    // Show warning message
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'تنبيه',
                            text: 'لا يمكن اختيار تاريخ في الماضي. تم تعيين التاريخ إلى اليوم.',
                            confirmButtonText: 'حسناً',
                            confirmButtonColor: '#0066a1'
                        });
                    } else {
                        alert('لا يمكن اختيار تاريخ في الماضي');
                    }
                }
            });

            // Add visual feedback on focus
            documentStartDate.addEventListener('focus', function() {
                this.style.borderColor = '#0066a1';
                this.style.boxShadow = '0 0 0 3px rgba(0, 102, 161, 0.1)';
            });

            documentStartDate.addEventListener('blur', function() {
                this.style.borderColor = '#e2e8f0';
                this.style.boxShadow = 'none';
            });
        }

        // Set maximum date for driver birth date (18 years ago minimum)
        if (driverBirthDate) {
            const maxDate = new Date();
            maxDate.setFullYear(maxDate.getFullYear() - 18);
            driverBirthDate.setAttribute('max', maxDate.toISOString().split('T')[0]);

            const minDate = new Date();
            minDate.setFullYear(minDate.getFullYear() - 70);
            driverBirthDate.setAttribute('min', minDate.toISOString().split('T')[0]);
        }
    });
</script>
@endpush