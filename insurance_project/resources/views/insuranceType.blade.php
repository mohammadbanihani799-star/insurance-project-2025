@extends('layouts.home')

@section('title', 'باقات التأمين - BCare')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
@endpush

@section('content')
    <x-sweet-alerts />

    <!-- BREADCRUMB AREA START -->
    <div class="bc-skin">
        <div class="bcare-breadcrumb-insurance">
            <div class="container">
                <div class="breadcrumb-content">
                    <div class="breadcrumb-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>
                    </div>
                    <h1 class="breadcrumb-title">عروض التأمين المتاحة</h1>
                    <p class="breadcrumb-subtitle">قارن واختر الباقة الأنسب لك من أفضل شركات التأمين</p>
                </div>
            </div>
        </div>
        <!-- BREADCRUMB AREA END -->

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
            <div class="progress-step active">
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

    <section class="bcare-insurance-offers">
        <div class="container">

            <div class="insurance-tabs">
                <div class="tabs-navigation">
                    <button class="tab-btn active" data-tab="tab1">
                        <div class="tab-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                        </div>
                        <div class="tab-content-text">
                            <span class="tab-title">تأمين ضد الغير</span>
                            <span class="tab-subtitle">الحماية الأساسية</span>
                        </div>
                    </button>
                    <button class="tab-btn" data-tab="tab2">
                        <div class="tab-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                        </div>
                        <div class="tab-content-text">
                            <span class="tab-title">تأمين شامل</span>
                            <span class="tab-subtitle">الحماية الكاملة</span>
                        </div>
                    </button>
                </div>

                 <div class="tab-panel active" id="tab1">
                    @if (isset($thirdPartyInsurances) && $thirdPartyInsurances->count() > 0)
                        <div class="insurance-cards-grid">
                            @foreach ($thirdPartyInsurances as $thirdPartyInsurance)

                            <div class="insurance-card" data-insurance-id="{{ $thirdPartyInsurance->id }}">
                                    <div class="card-badge">ضد الغير</div>

                                    @php

                                        $ratings = [4.2, 4.3, 4.5, 4.6, 4.7, 4.8, 4.4, 4.9];
                                        $rating = $ratings[$loop->index % count($ratings)];
                                    @endphp

                                    <div class="rating-top">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#fbbf24" stroke="#fbbf24" stroke-width="2">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                        </svg>
                                        <span>{{ number_format($rating, 1) }}</span>
                                    </div>

                                    {{-- Company Logo Center --}}
                                    <div class="company-logo-center">
                                        @php
                                            $img = $thirdPartyInsurance->image ?? null;
                                            $imgPath = $img ? public_path($img) : null;
                                        @endphp
                                        @if ($img && $imgPath && file_exists($imgPath))
                                            <img src="{{ asset($img) }}" alt="شركة التأمين">
                                        @else
                                            <img src="{{ asset('style_files/shared/images_default/default.jpg') }}" alt="شركة التأمين">
                                        @endif
                                    </div>

                                    <div class="card-price">
                                        <div class="price-label">السعر الأساسي</div>
                                        <div class="price-value">
                                            <span class="amount">{{ isset($thirdPartyInsurance->price) ? number_format($thirdPartyInsurance->price, 2) : '----' }}</span>
                                            <span class="currency">ريال</span>
                                        </div>
                                        <div class="price-period">سنويًا</div>
                                    </div>

                                    <div class="card-features">
                                        <h4 class="features-title">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                            </svg>
                                            ما يشمله التأمين
                                        </h4>
                                        <ul class="features-list">
                                            <li>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                                <span>تغطية الأضرار للطرف الثالث</span>
                                            </li>
                                            <li>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                                <span>تعويضات الإصابات الجسدية</span>
                                            </li>
                                            <li>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                                <span>الأضرار الممتلكات للغير</span>
                                            </li>
                                            <li>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                                <span>تغطية داخل المملكة</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <form action="{{ route('insuranceTypeRequest') }}" method="POST" class="insurance-form">
                                        @csrf
                                        <input type="hidden" name="insurance_id" value="{{ $thirdPartyInsurance->id ?? '' }}">

                                        @if (!empty($thirdPartyInsurance->insuranceBenefits) && $thirdPartyInsurance->insuranceBenefits->count() > 0)
                                            <div class="card-addons">
                                                <h4 class="addons-title">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <line x1="12" y1="8" x2="12" y2="12"></line>
                                                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                                    </svg>
                                                    خدمات إضافية اختيارية
                                                </h4>
                                                <div class="addons-list">
                                                    @foreach ($thirdPartyInsurance->insuranceBenefits as $insuranceBenefit)
                                                        @php
                                                            $id = 'tp_'.$thirdPartyInsurance->id.'_benefit_'.$loop->index;
                                                            $realPrices = [
                                                                'مساعدة على الطريق' => 250,
                                                                'تغطية السائق' => 450,
                                                                'تغطية الركاب' => 380,
                                                                'سيارة بديلة' => 550,
                                                                'حوادث شخصية' => 320,
                                                                'تمديد التغطية الجغرافية' => 420,
                                                                'حماية من الحوادث الطبيعية' => 290,
                                                                'تغطية الزجاج' => 180,
                                                            ];

                                                            $benefitTitle = $insuranceBenefit->benefit_title ?? '----';
                                                            $price = $realPrices[$benefitTitle] ?? ($insuranceBenefit->price ?? 200);
                                                        @endphp
                                                        <label class="addon-item">
                                                            <input type="checkbox" name="benefit[]" value="{{ $insuranceBenefit->id }}" data-price="{{ $price }}" class="addon-checkbox">
                                                            <div class="addon-content">
                                                                <div class="addon-info">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                                                        <path d="m9 12 2 2 4-4"></path>
                                                                    </svg>
                                                                    <span class="addon-name">{{ $insuranceBenefit->benefit_title ?? '----' }}</span>
                                                                </div>
                                                                <span class="addon-price">+{{ number_format($price, 2) }} ريال</span>
                                                            </div>
                                                            <div class="addon-checkmark"></div>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <div class="card-footer">
                                            <div class="total-section">
                                                <span class="total-label">الإجمالي</span>
                                                <span class="total-price" data-base-price="{{ $thirdPartyInsurance->price ?? 0 }}">
                                                    {{ number_format($thirdPartyInsurance->price ?? 0, 2) }} ريال
                                                </span>
                                            </div>
                                            <button type="submit" class="btn-purchase">
                                                <span>اشتري الآن</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                                    <polyline points="12 5 19 12 12 19"></polyline>
                                                </svg>
                                            </button>
                                        </div>
                                        <a href="#" class="terms-link">الشروط والأحكام</a>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="no-results">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            <h3>لا توجد عروض متاحة</h3>
                            <p>لم نتمكن من العثور على عروض تأمين مناسبة لبحثك</p>
                        </div>
                    @endif
                </div>

                <div class="tab-panel" id="tab2">
                    @if (isset($fullInsurances) && $fullInsurances->count() > 0)
                        <div class="insurance-cards-grid">
                            @foreach ($fullInsurances as $fullInsurance)
                                <div class="insurance-card featured" data-insurance-id="{{ $fullInsurance->id }}">
                                    <div class="card-badge premium">شامل</div>

                                    @php
                                        $ratingsFullInsurance = [4.5, 4.6, 4.7, 4.8, 4.9, 4.7, 4.8, 4.9];
                                        $ratingFull = $ratingsFullInsurance[$loop->index % count($ratingsFullInsurance)];
                                    @endphp

                                    <div class="rating-top">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#fbbf24" stroke="#fbbf24" stroke-width="2">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                        </svg>
                                        <span>{{ number_format($ratingFull, 1) }}</span>
                                    </div>

                                    <div class="company-logo-center">
                                        @php
                                            $img = $fullInsurance->image ?? null;
                                            $imgPath = $img ? public_path($img) : null;
                                        @endphp
                                        @if ($img && $imgPath && file_exists($imgPath))
                                            <img src="{{ asset($img) }}" alt="شركة التأمين">
                                        @else
                                            <img src="{{ asset('style_files/shared/images_default/default.jpg') }}" alt="شركة التأمين">
                                        @endif
                                    </div>

                                    <div class="card-price">
                                        <div class="price-label">السعر الأساسي</div>
                                        <div class="price-value">
                                            <span class="amount">{{ isset($fullInsurance->price) ? number_format($fullInsurance->price, 2) : '----' }}</span>
                                            <span class="currency">ريال</span>
                                        </div>
                                        <div class="price-period">سنويًا</div>
                                    </div>

                                    <div class="card-features">
                                        <h4 class="features-title">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                            </svg>
                                            ما يشمله التأمين
                                        </h4>
                                        <ul class="features-list">
                                            <li>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                                <span>تغطية شاملة للمركبة</span>
                                            </li>
                                            <li>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                                <span>أضرار الطرف الثالث</span>
                                            </li>
                                            <li>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                                <span>الحوادث والسرقة</span>
                                            </li>
                                            <li>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                                <span>الكوارث الطبيعية</span>
                                            </li>
                                            <li>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                                <span>تغطية داخل وخارج المملكة</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <form action="{{ route('insuranceTypeRequest') }}" method="POST" class="insurance-form">
                                        @csrf
                                        <input type="hidden" name="insurance_id" value="{{ $fullInsurance->id ?? '' }}">

                                        @if (!empty($fullInsurance->insuranceBenefits) && $fullInsurance->insuranceBenefits->count() > 0)
                                            <div class="card-addons">
                                                <h4 class="addons-title">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <line x1="12" y1="8" x2="12" y2="12"></line>
                                                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                                    </svg>
                                                    خدمات إضافية اختيارية
                                                </h4>
                                                <div class="addons-list">
                                                    @foreach ($fullInsurance->insuranceBenefits as $insuranceBenefit)
                                                        @php
                                                            $id = 'full_'.$fullInsurance->id.'_benefit_'.$loop->index;
                                                            // أسعار حقيقية للخدمات الإضافية بالريال السعودي
                                                            $realPrices = [
                                                                'مساعدة على الطريق' => 250,
                                                                'تغطية السائق' => 450,
                                                                'تغطية الركاب' => 380,
                                                                'سيارة بديلة' => 550,
                                                                'حوادث شخصية' => 320,
                                                                'تمديد التغطية الجغرافية' => 420,
                                                                'حماية من الحوادث الطبيعية' => 290,
                                                                'تغطية الزجاج' => 180,
                                                            ];

                                                            $benefitTitle = $insuranceBenefit->benefit_title ?? '----';
                                                            $price = $realPrices[$benefitTitle] ?? ($insuranceBenefit->price ?? 200);
                                                        @endphp
                                                        <label class="addon-item">
                                                            <input type="checkbox" name="benefit[]" value="{{ $insuranceBenefit->id }}" data-price="{{ $price }}" class="addon-checkbox">
                                                            <div class="addon-content">
                                                                <div class="addon-info">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                                                        <path d="m9 12 2 2 4-4"></path>
                                                                    </svg>
                                                                    <span class="addon-name">{{ $insuranceBenefit->benefit_title ?? '----' }}</span>
                                                                </div>
                                                                <span class="addon-price">+{{ number_format($price, 2) }} ريال</span>
                                                            </div>
                                                            <div class="addon-checkmark"></div>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Card Footer --}}
                                        <div class="card-footer">
                                            <div class="total-section">
                                                <span class="total-label">الإجمالي</span>
                                                <span class="total-price" data-base-price="{{ $fullInsurance->price ?? 0 }}">
                                                    {{ number_format($fullInsurance->price ?? 0, 2) }} ريال
                                                </span>
                                            </div>
                                            <button type="submit" class="btn-purchase">
                                                <span>اشتري الآن</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                                    <polyline points="12 5 19 12 12 19"></polyline>
                                                </svg>
                                            </button>
                                        </div>
                                        <a href="#" class="terms-link">الشروط والأحكام</a>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="no-results">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            <h3>لا توجد عروض متاحة</h3>
                            <p>لم نتمكن من العثور على عروض تأمين شامل مناسبة لبحثك</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div id="overlay">
        <div class="cv-spinner">
            <div class="spinnerContainer">
                <img src="{{ asset('style_files/frontend/img/logoInsurance.svg') }}" alt="">
                <span class="text-black mx-2">جاري التحميل ...</span>
                <span class="spinner"></span>
            </div>
        </div>
    </div>
    </div>

    <script>
      function initInsuranceTypePage() {

        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabPanels = document.querySelectorAll('.tab-panel');

        tabBtns.forEach(btn => {
          btn.addEventListener('click', () => {
            const targetTab = btn.dataset.tab;


            tabBtns.forEach(b => b.classList.remove('active'));
            tabPanels.forEach(p => p.classList.remove('active'));

            btn.classList.add('active');
            document.getElementById(targetTab).classList.add('active');
          });
        });


        const insuranceForms = document.querySelectorAll('.insurance-form');

        insuranceForms.forEach(form => {
          const checkboxes = form.querySelectorAll('.addon-checkbox');
          const totalPriceEl = form.querySelector('.total-price');
          const basePrice = parseFloat(totalPriceEl.dataset.basePrice) || 0;

          checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
              let total = basePrice;

              form.querySelectorAll('.addon-checkbox:checked').forEach(checked => {
                const addonPrice = parseFloat(checked.dataset.price) || 0;
                total += addonPrice;
              });

              totalPriceEl.textContent = total.toFixed(2) + ' ريال';
            });
          });


          form.addEventListener('submit', function() {
            document.getElementById('overlay').style.display = 'flex';
            form.querySelector('.btn-purchase').disabled = true;
          });
        });


        window.addEventListener('load', () => {
          document.getElementById('overlay').style.display = 'none';
          document.querySelectorAll('.btn-purchase').forEach(btn => btn.disabled = false);
        });


        const observerOptions = {
          threshold: 0.1,
          rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.style.opacity = '1';
              entry.target.style.transform = 'translateY(0)';
            }
          });
        }, observerOptions);

        document.querySelectorAll('.insurance-card').forEach(card => {
          card.style.opacity = '0';
          card.style.transform = 'translateY(30px)';
          card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
          observer.observe(card);
        });
      }


      document.addEventListener('DOMContentLoaded', initInsuranceTypePage);
    </script>


    <script>
      (function ensureSwal() {
        if (typeof window.Swal?.fire === 'function') return;
        const s = document.createElement('script');
        s.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
        s.defer = true;
        s.onload = function() {
          console.log('SweetAlert2 fallback loaded');
        };
        document.head.appendChild(s);
      })();
    </script>
@endsection

<style>



* {
    font-family: 'Cairo', 'Tajawal', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

.bc-skin {
    font-family: 'Cairo', 'Tajawal', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}


.bcare-breadcrumb-insurance {
    background: linear-gradient(135deg, #146394 0%, #0f4570 100%);
    padding: 3rem 0 2rem;
    text-align: center;
    color: white;
    position: relative;
    overflow: hidden;
}

.bcare-breadcrumb-insurance::before {
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
    color: white;
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

@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

@keyframes checkmark {
    0% {
        opacity: 0;
        transform: scale(0) rotate(-45deg);
    }
    100% {
        opacity: 1;
        transform: scale(1) rotate(0deg);
    }
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

/* Insurance Offers Section */
.bcare-insurance-offers {
    padding: 4rem 0;
    background: linear-gradient(to bottom, #f7f9fc 0%, #ffffff 100%);
    min-height: 100vh;
}

/* Modern Tabs */
.insurance-tabs {
    margin-bottom: 3rem;
}

.tabs-navigation {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    margin-bottom: 3rem;
    flex-wrap: wrap;
}

.tab-btn {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem 2.5rem;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    min-width: 200px;
}

.tab-btn:hover {
    border-color: #146394;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(20, 99, 148, 0.2);
}

.tab-btn.active {
    background: linear-gradient(135deg, #146394 0%, #0f4570 100%);
    border-color: #146394;
    box-shadow: 0 6px 20px rgba(20, 99, 148, 0.4);
}

.tab-icon {
    flex-shrink: 0;
}

.tab-icon svg {
    color: #146394;
    transition: color 0.3s ease;
}

.tab-btn.active .tab-icon svg {
    color: white;
}

.tab-content-text {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    text-align: right;
}

.tab-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2d3748;
    transition: color 0.3s ease;
    font-family: 'Cairo', sans-serif;
}

.tab-subtitle {
    font-size: 0.85rem;
    color: #718096;
    transition: color 0.3s ease;
}

.tab-btn.active .tab-title,
.tab-btn.active .tab-subtitle {
    color: white;
}

/* Tab Panels */
.tab-panel {
    display: none;
}

.tab-panel.active {
    display: block;
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Insurance Cards Grid */
.insurance-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 3rem;
    padding: 0.5rem;
}

/* Insurance Card */
.insurance-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.12);
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
    border: 3px solid #e2e8f0;
}

.insurance-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 48px rgba(20, 99, 148, 0.25);
    border-color: #146394;
    border-width: 3px;
}

.insurance-card.featured {
    border: 3px solid #146394;
    box-shadow: 0 8px 32px rgba(20, 99, 148, 0.2);
}

.insurance-card.featured::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #146394 0%, #0f4570 100%);
}

/* Card Badge */
.card-badge {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    background: rgba(20, 99, 148, 0.9);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    z-index: 10;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.card-badge.premium {
    background: linear-gradient(135deg, #FAA62E 0%, #f59e0b 100%);
}

/* Rating Top */
.rating-top {
    position: absolute;
    top: 1.5rem;
    left: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: #fef3c7;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    z-index: 10;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.rating-top span {
    font-weight: 700;
    color: #92400e;
    font-family: 'Cairo', sans-serif;
    font-size: 0.9rem;
}

/* Company Logo Center */
.company-logo-center {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem 2rem 2rem;
    margin-top: 2rem;
}

.company-logo-center img {
    width: 100%;
    max-width: 180px;
    height: auto;
    max-height: 100px;
    object-fit: contain;
    object-position: center;
    filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.1));
}

/* Price Section */
.card-price {
    text-align: center;
    padding: 2rem;
    background: linear-gradient(135deg, rgba(20, 99, 148, 0.05) 0%, rgba(15, 69, 112, 0.05) 100%);
    border-top: 1px solid #e2e8f0;
    border-bottom: 1px solid #e2e8f0;
}

.price-label {
    font-size: 1rem;
    color: #718096;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.price-value {
    display: flex;
    align-items: baseline;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 0.25rem;
}

.amount {
    font-size: 2.75rem;
    font-weight: 800;
    color: #146394;
    line-height: 1.2;
    font-family: 'Cairo', sans-serif;
}

.currency {
    font-size: 1.3rem;
    color: #4a5568;
    font-weight: 600;
}

.price-period {
    font-size: 0.9rem;
    color: #a0aec0;
    font-weight: 500;
}

/* Features Section */
.card-features {
    padding: 2rem;
}

.features-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.15rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 1.25rem;
    font-family: 'Cairo', sans-serif;
}

.features-title svg {
    color: #146394;
    flex-shrink: 0;
}

.features-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.features-list li {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #4a5568;
    font-size: 1rem;
    line-height: 1.6;
}

.features-list li svg {
    flex-shrink: 0;
}

/* Addons Section */
.card-addons {
    padding: 0 2rem 2rem;
}

.addons-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.15rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 1.25rem;
    font-family: 'Cairo', sans-serif;
}

.addons-title svg {
    color: #FAA62E;
    flex-shrink: 0;
}

.addons-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.addon-item {
    display: block;
    cursor: pointer;
    margin: 0;
}

.addon-item input[type="checkbox"] {
    display: none;
}

.addon-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
    background: #f7fafc;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    transition: all 0.3s ease;
    position: relative;
}

.addon-item:hover .addon-content {
    border-color: #cbd5e0;
    background: #edf2f7;
}

.addon-item input:checked + .addon-content {
    border-color: #146394;
    background: linear-gradient(135deg, rgba(20, 99, 148, 0.1) 0%, rgba(15, 69, 112, 0.1) 100%);
}

.addon-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.addon-info svg {
    color: #a0aec0;
    flex-shrink: 0;
    transition: color 0.3s ease;
}

.addon-item input:checked + .addon-content .addon-info svg {
    color: #146394;
}

.addon-name {
    font-weight: 600;
    color: #2d3748;
    font-size: 1rem;
    line-height: 1.5;
}

.addon-price {
    font-weight: 700;
    color: #146394;
    font-size: 1.05rem;
    white-space: nowrap;
}

.addon-checkmark {
    position: absolute;
    top: 0.75rem;
    left: 0.75rem;
    width: 20px;
    height: 20px;
    border: 2px solid #cbd5e0;
    border-radius: 50%;
    background: white;
    transition: all 0.3s ease;
}

.addon-checkmark::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0);
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: white;
    transition: transform 0.2s ease;
}

.addon-item input:checked + .addon-content .addon-checkmark {
    background: #146394;
    border-color: #146394;
}

.addon-item input:checked + .addon-content .addon-checkmark::after {
    transform: translate(-50%, -50%) scale(1);
}

/* Card Footer */
.card-footer {
    padding: 2rem;
    background: #f7fafc;
    border-top: 1px solid #e2e8f0;
}

.total-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding: 1.25rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.total-label {
    font-size: 1.1rem;
    font-weight: 600;
    color: #4a5568;
}

.total-price {
    font-size: 1.8rem;
    font-weight: 700;
    color: #146394;
}

.btn-purchase {
    width: 100%;
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

.btn-purchase:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(20, 99, 148, 0.5);
    background: linear-gradient(135deg, #0f4570 0%, #146394 100%);
}

.btn-purchase:active {
    transform: translateY(0);
}

.btn-purchase:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-purchase svg {
    transition: transform 0.3s ease;
}

.btn-purchase:hover svg {
    transform: translateX(-4px);
}

.terms-link {
    display: block;
    text-align: center;
    margin-top: 1rem;
    color: #146394;
    font-size: 0.9rem;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.terms-link:hover {
    color: #0f4570;
    text-decoration: underline;
}

/* No Results */
.no-results {
    text-align: center;
    padding: 4rem 2rem;
}

.no-results svg {
    color: #cbd5e0;
    margin-bottom: 1.5rem;
}

.no-results h3 {
    font-size: 1.5rem;
    color: #2d3748;
    margin-bottom: 0.75rem;
}

.no-results p {
    color: #718096;
    font-size: 1.1rem;
}

/* Overlay */
#overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    z-index: 9999;
    align-items: center;
    justify-content: center;
}

.cv-spinner {
    display: flex;
    align-items: center;
    justify-content: center;
}

.spinnerContainer {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.5rem;
    background: white;
    padding: 3rem;
    border-radius: 20px;
}

.spinnerContainer img {
    width: 80px;
    height: auto;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.7;
        transform: scale(0.95);
    }
}

.spinner {
    width: 50px;
    height: 50px;
    border: 4px solid #e2e8f0;
    border-top-color: #146394;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* Responsive Design */
@media (max-width: 1200px) {
    .insurance-cards-grid {
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 2.5rem;
    }

    .amount {
        font-size: 2.5rem;
    }
}

@media (max-width: 768px) {
    .breadcrumb-title {
        font-size: 2rem;
    }

    .breadcrumb-subtitle {
        font-size: 1rem;
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

    .tabs-navigation {
        flex-direction: column;
        gap: 1rem;
    }

    .tab-btn {
        width: 100%;
        justify-content: center;
        font-size: 1.05rem;
        padding: 1rem 1.5rem;
    }

    .insurance-cards-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .amount {
        font-size: 2.25rem;
    }

    .currency {
        font-size: 1.15rem;
    }

    .company-logo-center img {
        max-width: 150px;
        max-height: 90px;
    }

    .features-list li {
        font-size: 0.95rem;
    }

    .addon-name {
        font-size: 0.95rem;
    }

    .addon-price {
        font-size: 1rem;
    }
}

@media (max-width: 576px) {
    .bcare-breadcrumb-insurance {
        padding: 3rem 0 2rem;
    }

    .breadcrumb-icon {
        width: 70px;
        height: 70px;
    }

    .breadcrumb-title {
        font-size: 1.75rem;
    }

    .breadcrumb-subtitle {
        font-size: 0.95rem;
    }

    .card-badge {
        top: 1rem;
        right: 1rem;
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
    }

    .rating-top {
        top: 1rem;
        left: 1rem;
        padding: 0.4rem 0.8rem;
    }

    .rating-top span {
        font-size: 0.85rem;
    }

    .company-logo-center {
        padding: 2.5rem 1.5rem 1.5rem;
    }

    .company-logo-center img {
        max-width: 160px;
        max-height: 85px;
    }

    .amount {
        font-size: 2rem;
    }

    .currency {
        font-size: 1.1rem;
    }

    .price-label {
        font-size: 0.95rem;
    }

    .price-period {
        font-size: 0.85rem;
    }

    .card-features,
    .card-addons {
        padding: 1.5rem;
    }

    .features-title,
    .addons-title {
        font-size: 1.05rem;
    }

    .features-list li {
        font-size: 0.9rem;
    }

    .card-footer {
        padding: 1.5rem;
    }

    .total-section {
        flex-direction: column;
        gap: 0.5rem;
        text-align: center;
    }

    .total-label {
        font-size: 0.95rem;
    }

    .total-price {
        font-size: 1.25rem;
    }

    .addon-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 1rem;
    }

    .addon-name {
        font-size: 0.9rem;
    }

    .addon-price {
        font-size: 0.95rem;
    }

    .btn-purchase {
        font-size: 1rem;
        padding: 1rem 2rem;
    }
}
</style>
