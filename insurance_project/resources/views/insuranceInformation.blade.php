@extends('layouts.home')

@section('title', 'ملخص التأمين - BCare')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
@endpush

@section('content')
    <x-sweet-alerts />

    <!-- Loading Screen -->
    <div id="loading-screen" class="loading-screen">
        <div class="loading-content">
            <div class="loading-logo">
                <img src="{{ asset('build/assets/favicon.jpg') }}" alt="BCare Logo">
            </div>
            <div class="loading-text">
                <h3>جاري تحضير ملخص التأمين</h3>
                <p>يرجى الانتظار لحظات...</p>
            </div>
            <div class="loading-spinner">
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
            </div>
        </div>
    </div>

    <!-- BREADCRUMB AREA START -->
    <div class="bc-skin">
        <div class="bcare-breadcrumb">
            <div class="container">
                <div class="breadcrumb-content">
                    <div class="breadcrumb-icon">
                        <img src="{{ asset('build/assets/favicon.jpg') }}" alt="BCare" class="breadcrumb-logo">
                    </div>
                    <h1 class="breadcrumb-title">ملخص التأمين</h1>
                    <p class="breadcrumb-subtitle">مراجعة جميع التفاصيل قبل المتابعة للدفع</p>
                </div>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB AREA END -->


    <!-- Progress Bar -->
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
            <div class="progress-step completed">
                <div class="step-circle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" class="checkmark-icon">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <span class="step-text">بيانات التأمين</span>
            </div>
            
            <div class="progress-line completed"></div>
            
            <!-- Step 3: باقات التأمين -->
            <div class="progress-step completed">
                <div class="step-circle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" class="checkmark-icon">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <span class="step-text">باقات التأمين</span>
            </div>
            
            <div class="progress-line completed"></div>
            
            <!-- Step 4: الملخص -->
            <div class="progress-step active">
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

    <!-- Main Content -->
    <section class="bcare-summary-section">
        <div class="container">
            <div class="summary-grid">
                <!-- Right Column: User Data Review -->
                <div class="summary-column">
                    <div class="summary-card">
                        <div class="card-header">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <h3>البيانات الشخصية</h3>
                        </div>
                        <div class="card-body">
                            @php
                                $allFormData = session('allFormData', []);
                            @endphp
                            
                            <div class="data-row">
                                <span class="data-label">الاسم الكامل</span>
                                <span class="data-value">{{ $allFormData['full_name'] ?? 'غير محدد' }}</span>
                            </div>
                            <div class="data-row">
                                <span class="data-label">رقم الهوية</span>
                                <span class="data-value">{{ $allFormData['identity_number'] ?? 'غير محدد' }}</span>
                            </div>
                            <div class="data-row">
                                <span class="data-label">رقم الجوال</span>
                                <span class="data-value">{{ $allFormData['mobile_number_statements'] ?? 'غير محدد' }}</span>
                            </div>
                            <div class="data-row">
                                <span class="data-label">تاريخ الميلاد</span>
                                <span class="data-value">{{ $allFormData['birth_date_statements'] ?? 'غير محدد' }}</span>
                            </div>
                            <div class="data-row">
                                <span class="data-label">المنطقة</span>
                                <span class="data-value">{{ $allFormData['region'] ?? 'غير محدد' }}</span>
                            </div>
                            <div class="data-row">
                                <span class="data-label">المدينة</span>
                                <span class="data-value">{{ $allFormData['city'] ?? 'غير محدد' }}</span>
                            </div>
                            <div class="data-row">
                                <span class="data-label">سنوات القيادة</span>
                                <span class="data-value">{{ $allFormData['driving_years'] ?? 'غير محدد' }} سنة</span>
                            </div>
                        </div>
                    </div>

                    <div class="summary-card">
                        <div class="card-header">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="3" width="15" height="13"></rect>
                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
                            <h3>بيانات المركبة</h3>
                        </div>
                        <div class="card-body">
                            <div class="data-row">
                                <span class="data-label">نوع المركبة</span>
                                <span class="data-value">{{ $allFormData['vehicle_type'] ?? 'غير محدد' }}</span>
                            </div>
                            <div class="data-row">
                                <span class="data-label">موديل المركبة</span>
                                <span class="data-value">{{ $allFormData['vehicle_model'] ?? 'غير محدد' }}</span>
                            </div>
                            <div class="data-row">
                                <span class="data-label">سنة الصنع</span>
                                <span class="data-value">{{ $allFormData['manufacturing_year'] ?? 'غير محدد' }}</span>
                            </div>
                            <div class="data-row">
                                <span class="data-label">نوع الصيانة</span>
                                <span class="data-value">{{ $allFormData['maintenance_type'] ?? 'غير محدد' }}</span>
                            </div>
                            <div class="data-row">
                                <span class="data-label">السعر التقريبي</span>
                                <span class="data-value">{{ isset($allFormData['approximate_price']) ? number_format($allFormData['approximate_price'], 2) : 'غير محدد' }} ريال</span>
                            </div>
                            <div class="data-row">
                                <span class="data-label">فئة الاستعمال</span>
                                <span class="data-value">{{ $allFormData['usage_category'] ?? 'غير محدد' }}</span>
                            </div>
                        </div>
                    </div>

                    @if(isset($allFormData['has_additional_driver']) && $allFormData['has_additional_driver'] == 'yes')
                    <div class="summary-card">
                        <div class="card-header">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <h3>بيانات السائق الإضافي</h3>
                        </div>
                        <div class="card-body">
                            <div class="data-row">
                                <span class="data-label">اسم السائق</span>
                                <span class="data-value">{{ $allFormData['driver_name'] ?? 'غير محدد' }}</span>
                            </div>
                            <div class="data-row">
                                <span class="data-label">رقم الهوية</span>
                                <span class="data-value">{{ $allFormData['driver_identity_number'] ?? 'غير محدد' }}</span>
                            </div>
                            <div class="data-row">
                                <span class="data-label">رقم الجوال</span>
                                <span class="data-value">{{ $allFormData['driver_mobile_number'] ?? 'غير محدد' }}</span>
                            </div>
                            <div class="data-row">
                                <span class="data-label">تاريخ الميلاد</span>
                                <span class="data-value">{{ $allFormData['driver_birth_date'] ?? 'غير محدد' }}</span>
                            </div>
                            <div class="data-row">
                                <span class="data-label">سنوات القيادة</span>
                                <span class="data-value">{{ $allFormData['driver_driving_years'] ?? 'غير محدد' }} سنة</span>
                            </div>
                            <div class="data-row">
                                <span class="data-label">نسبة القيادة</span>
                                <span class="data-value">{{ $allFormData['driver_driving_percentage'] ?? 'غير محدد' }}%</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Left Column: Insurance Details & Payment -->
                <div class="summary-column">
                    <div class="insurance-summary-card">
                        <div class="insurance-badge">
                            @if (isset($insurance->insurance_type) && $insurance->insurance_type == 1)
                                <span class="badge-third-party">تأمين ضد الغير</span>
                            @else
                                <span class="badge-comprehensive">تأمين شامل</span>
                            @endif
                        </div>
                        
                        <div class="company-logo-section">
                            @if (isset($insurance->image) && $insurance->image && file_exists(public_path($insurance->image)))
                                <img src="{{ asset($insurance->image) }}" alt="شركة التأمين" class="company-logo">
                            @else
                                <img src="{{ asset('style_files/shared/images_default/default.jpg') }}" alt="شركة التأمين" class="company-logo">
                            @endif
                        </div>

                        <div class="insurance-rating">
                            <div class="stars">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#fbbf24">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#fbbf24">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#fbbf24">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#fbbf24">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#d1d5db">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </div>
                            <span class="rating-text">تقييم ممتاز</span>
                        </div>

                        @php
                            $basePrice = $insurance->price ?? 0;
                            $discount = $basePrice * 0.50; // خصم 50%
                            $subtotal = $basePrice - $discount;
                            $vat = $subtotal * 0.15; // ضريبة 15%
                            $total = $subtotal + $vat;
                        @endphp

                        <div class="price-breakdown">
                            <div class="price-item">
                                <span class="price-label">سعر الوثيقة الأساسي</span>
                                <span class="price-value">{{ number_format($basePrice, 2) }} ريال</span>
                            </div>
                            <div class="price-item discount">
                                <span class="price-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <polyline points="19 12 12 19 5 12"></polyline>
                                    </svg>
                                    خصم عدم وجود مطالبات
                                </span>
                                <span class="price-value">-{{ number_format($discount, 2) }} ريال</span>
                            </div>
                            <div class="price-divider"></div>
                            <div class="price-item">
                                <span class="price-label">المجموع الجزئي</span>
                                <span class="price-value">{{ number_format($subtotal, 2) }} ريال</span>
                            </div>
                            <div class="price-item tax">
                                <span class="price-label">ضريبة القيمة المضافة (15%)</span>
                                <span class="price-value">{{ number_format($vat, 2) }} ريال</span>
                            </div>
                        </div>

                        <div class="total-price-section">
                            <span class="total-label">المجموع الإجمالي</span>
                            <span class="total-amount">{{ number_format($total, 2) }} <span class="currency">ريال</span></span>
                        </div>

                        <form action="{{ route('insuranceInformationRequest') }}" method="POST" id="payment-form">
                            @csrf
                            <input type="hidden" name="total" value="{{ number_format($total, 2) }}">
                            
                            <button type="submit" class="btn-proceed-payment">
                                <span>المتابعة للدفع</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </button>
                        </form>

                        <div class="security-notice">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <span>جميع معلوماتك محمية ومشفرة</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Payment Processing Overlay -->
    <div id="payment-overlay" class="payment-overlay">
        <div class="overlay-content">
            <div class="overlay-logo">
                <img src="{{ asset('build/assets/favicon.jpg') }}" alt="BCare Logo">
            </div>
            <div class="overlay-text">
                <h3>جاري تحضير صفحة الدفع</h3>
                <p>يرجى عدم إغلاق الصفحة...</p>
            </div>
            <div class="overlay-spinner">
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
            </div>
        </div>
    </div>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Cairo', 'Tajawal', sans-serif;
}

html, body {
    background: #f7f9fc;
    overflow-x: hidden;
}

/* Loading Screen Styles */
.loading-screen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #146394 0%, #0f4570 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    transition: opacity 0.5s ease, visibility 0.5s ease;
}

.loading-screen.hidden {
    opacity: 0;
    visibility: hidden;
}

.loading-content {
    text-align: center;
    color: white;
}

.loading-logo {
    width: 120px;
    height: 120px;
    margin: 0 auto 2rem;
    background: white;
    border-radius: 50%;
    padding: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    animation: logoFloat 3s ease-in-out infinite;
}

.loading-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

@keyframes logoFloat {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-20px);
    }
}

.loading-text h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: white;
}

.loading-text p {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 2rem;
}

.loading-spinner {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
}

.spinner-ring {
    width: 15px;
    height: 15px;
    border-radius: 50%;
    background: white;
    animation: spinnerPulse 1.4s infinite ease-in-out both;
}

.spinner-ring:nth-child(1) {
    animation-delay: -0.32s;
}

.spinner-ring:nth-child(2) {
    animation-delay: -0.16s;
}

@keyframes spinnerPulse {
    0%, 80%, 100% {
        transform: scale(0.6);
        opacity: 0.5;
    }
    40% {
        transform: scale(1);
        opacity: 1;
    }
}

/* Breadcrumb Styles */
.bc-skin {
    font-family: 'Cairo', sans-serif;
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
    width: 80px;
    height: 80px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    padding: 15px;
}

.breadcrumb-logo {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.breadcrumb-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    color: #ffffff;
}

.breadcrumb-subtitle {
    font-size: 1rem;
    opacity: 0.95;
    text-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
    font-weight: 500;
    color: #FAA62E;
}

/* Progress Bar Styles */
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

.progress-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    z-index: 2;
    flex-shrink: 0;
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
    transition: all 0.4s ease;
    position: relative;
}

.progress-step.completed .step-circle {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    border: 3px solid #d1fae5;
}

.checkmark-icon {
    width: 24px;
    height: 24px;
}

.progress-step.completed .step-text {
    color: #10b981;
    font-weight: 700;
}

.progress-step.active .step-circle {
    background: linear-gradient(135deg, #146394 0%, #0f4570 100%);
    box-shadow: 0 6px 20px rgba(20, 99, 148, 0.5);
    border: 3px solid #bfdbfe;
    animation: pulseActive 2s infinite;
}

@keyframes pulseActive {
    0%, 100% {
        box-shadow: 0 6px 20px rgba(20, 99, 148, 0.4);
        transform: scale(1);
    }
    50% {
        box-shadow: 0 8px 30px rgba(20, 99, 148, 0.6);
        transform: scale(1.05);
    }
}

.progress-step.active .step-num,
.progress-step.active .step-text {
    color: #146394;
    font-weight: 700;
}

.progress-step.active .step-circle .step-num {
    color: white;
}

.progress-step.pending .step-circle {
    background: #e5e7eb;
    color: #9ca3af;
    border: 3px solid #f3f4f6;
}

.progress-step.pending .step-text {
    color: #9ca3af;
    font-weight: 500;
}

.step-text {
    font-size: 14px;
    text-align: center;
    white-space: nowrap;
}

.progress-line {
    flex: 1;
    height: 4px;
    min-width: 40px;
    margin: 0 10px;
    border-radius: 2px;
    align-self: flex-start;
    margin-top: 23px;
}

.progress-line.completed {
    background: linear-gradient(90deg, #10b981 0%, #059669 100%);
}

.progress-line.pending {
    background: #e5e7eb;
}

/* Summary Section */
.bcare-summary-section {
    padding: 0 0 4rem;
    background: #f7f9fc;
}

.summary-grid {
    display: grid;
    grid-template-columns: 1fr 450px;
    gap: 2rem;
}

.summary-column {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Data Cards */
.summary-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.summary-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(20, 99, 148, 0.15);
}

.card-header {
    background: linear-gradient(135deg, #146394 0%, #0f4570 100%);
    color: white;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-header svg {
    color: white;
}

.card-header h3 {
    font-size: 1.1rem;
    font-weight: 700;
    margin: 0;
    color: white;
}

.card-body {
    padding: 1.5rem;
}

.data-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.875rem 0;
    border-bottom: 1px solid #e5e7eb;
}

.data-row:last-child {
    border-bottom: none;
}

.data-label {
    font-size: 0.95rem;
    color: #6b7280;
    font-weight: 500;
}

.data-value {
    font-size: 0.95rem;
    color: #1f2937;
    font-weight: 600;
    text-align: left;
}

/* Insurance Summary Card */
.insurance-summary-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    overflow: hidden;
    position: sticky;
    top: 20px;
}

.insurance-badge {
    background: linear-gradient(135deg, #146394 0%, #0f4570 100%);
    padding: 1rem;
    text-align: center;
}

.badge-third-party {
    background: rgba(255, 255, 255, 0.95);
    color: #146394;
    padding: 0.5rem 1.5rem;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.95rem;
    display: inline-block;
}

.badge-comprehensive {
    background: linear-gradient(135deg, #FAA62E 0%, #f59e0b 100%);
    color: white;
    padding: 0.5rem 1.5rem;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.95rem;
    display: inline-block;
}

.company-logo-section {
    padding: 2rem;
    text-align: center;
    background: #f8fafc;
}

.company-logo {
    max-width: 180px;
    height: auto;
    max-height: 100px;
    object-fit: contain;
}

.insurance-rating {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 0 2rem 1.5rem;
}

.stars {
    display: flex;
    gap: 0.25rem;
}

.rating-text {
    font-size: 0.9rem;
    color: #6b7280;
    font-weight: 600;
}

.price-breakdown {
    padding: 0 2rem 1.5rem;
}

.price-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.875rem 0;
    border-bottom: 1px solid #f3f4f6;
}

.price-item.discount {
    color: #10b981;
}

.price-item.discount .price-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #10b981;
}

.price-item.tax .price-label {
    color: #6b7280;
}

.price-label {
    font-size: 0.95rem;
    color: #4b5563;
    font-weight: 500;
}

.price-value {
    font-size: 0.95rem;
    font-weight: 700;
    color: #1f2937;
}

.price-divider {
    height: 1px;
    background: #e5e7eb;
    margin: 0.5rem 0;
}

.total-price-section {
    background: linear-gradient(135deg, rgba(20, 99, 148, 0.05) 0%, rgba(15, 69, 112, 0.05) 100%);
    padding: 1.5rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 2px solid #e5e7eb;
    border-bottom: 2px solid #e5e7eb;
}

.total-label {
    font-size: 1.1rem;
    font-weight: 700;
    color: #374151;
}

.total-amount {
    font-size: 2rem;
    font-weight: 800;
    color: #146394;
}

.currency {
    font-size: 1.2rem;
    font-weight: 600;
    color: #6b7280;
}

.btn-proceed-payment {
    width: calc(100% - 4rem);
    margin: 2rem;
    height: 56px;
    background: linear-gradient(135deg, #146394 0%, #0f4570 100%);
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
    box-shadow: 0 4px 15px rgba(20, 99, 148, 0.4);
}

.btn-proceed-payment:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(20, 99, 148, 0.5);
    background: linear-gradient(135deg, #0f4570 0%, #146394 100%);
}

.btn-proceed-payment svg {
    transition: transform 0.3s ease;
}

.btn-proceed-payment:hover svg {
    transform: translateX(-4px);
}

.security-notice {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0 2rem 2rem;
    color: #6b7280;
    font-size: 0.9rem;
}

.security-notice svg {
    color: #10b981;
}

/* Payment Overlay */
.payment-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.85);
    z-index: 9998;
    align-items: center;
    justify-content: center;
}

.payment-overlay.active {
    display: flex;
}

.overlay-content {
    text-align: center;
    color: white;
}

.overlay-logo {
    width: 100px;
    height: 100px;
    margin: 0 auto 1.5rem;
    background: white;
    border-radius: 50%;
    padding: 15px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    animation: logoFloat 3s ease-in-out infinite;
}

.overlay-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.overlay-text h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.overlay-text p {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 2rem;
}

.overlay-spinner {
    display: flex;
    justify-content: center;
    gap: 10px;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .summary-grid {
        grid-template-columns: 1fr;
    }
    
    .insurance-summary-card {
        position: static;
    }
}

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
    
    .step-text {
        font-size: 12px;
    }
    
    .progress-line {
        min-width: 20px;
        margin: 0 5px;
        margin-top: 18px;
    }
    
    .breadcrumb-title {
        font-size: 1.5rem;
    }
    
    .total-amount {
        font-size: 1.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hide loading screen after 10 seconds
    const loadingScreen = document.getElementById('loading-screen');
    
    setTimeout(function() {
        loadingScreen.classList.add('hidden');
    }, 10000);
    
    // Show payment overlay on form submit
    const paymentForm = document.getElementById('payment-form');
    const paymentOverlay = document.getElementById('payment-overlay');
    
    paymentForm.addEventListener('submit', function() {
        paymentOverlay.classList.add('active');
    });
});
</script>

@endsection
