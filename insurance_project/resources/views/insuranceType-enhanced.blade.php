@extends('layouts.app')
@section('content')
    {{-- Sweet Alert Section --}}
    <x-sweet-alerts />

    <style>
        .insurance-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 0;
            color: white;
            margin-bottom: 40px;
        }

        .insurance-card-enhanced {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
            border: 2px solid transparent;
        }

        .insurance-card-enhanced:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
            border-color: #667eea;
        }

        .insurance-card-enhanced.best-seller::before {
            content: "الأكثر مبيعاً";
            position: absolute;
            top: 20px;
            right: -30px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 8px 40px;
            font-weight: bold;
            font-size: 0.85rem;
            transform: rotate(45deg);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            z-index: 10;
        }

        .insurance-card-enhanced.recommended::before {
            content: "موصى به ⭐";
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .company-logo-enhanced {
            width: 100%;
            height: 140px;
            object-fit: contain;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .company-logo-enhanced img {
            max-width: 90%;
            max-height: 100px;
            object-fit: contain;
        }

        .price-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            margin: 20px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .price-badge .amount {
            font-size: 2.5rem;
            font-weight: bold;
            display: block;
            line-height: 1;
        }

        .price-badge .currency {
            font-size: 1rem;
            opacity: 0.9;
        }

        .benefits-section {
            padding: 0 20px 20px;
        }

        .benefit-item {
            padding: 12px 15px;
            margin: 8px 0;
            background: #f8f9fa;
            border-radius: 10px;
            display: flex;
            align-items: flex-start;
            transition: all 0.3s ease;
            border-right: 4px solid #4CAF50;
        }

        .benefit-item:hover {
            background: #e8f5e9;
            transform: translateX(-5px);
        }

        .benefit-item i {
            color: #4CAF50;
            margin-left: 12px;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .benefit-item.checkbox-benefit {
            cursor: pointer;
            border-right-color: #667eea;
        }

        .benefit-item.checkbox-benefit:hover {
            background: #e3f2fd;
        }

        .benefit-item input[type="checkbox"] {
            margin-left: 10px;
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .rating-display {
            text-align: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            margin: 0 20px;
        }

        .rating-display .stars {
            color: #ffd700;
            font-size: 1.3rem;
            letter-spacing: 3px;
        }

        .rating-display .reviews {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .btn-choose-plan {
            width: calc(100% - 40px);
            margin: 20px;
            padding: 18px;
            font-size: 1.2rem;
            font-weight: bold;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-choose-plan:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        .btn-choose-plan:active {
            transform: translateY(0);
        }

        .terms-link {
            text-align: center;
            padding: 10px 20px;
            font-size: 0.9rem;
        }

        .terms-link a {
            color: #667eea;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .terms-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .tab-navigation {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 40px 0;
            flex-wrap: wrap;
        }

        .tab-btn {
            padding: 15px 40px;
            border: 2px solid #667eea;
            background: white;
            color: #667eea;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tab-btn i {
            font-size: 1.3rem;
        }

        .tab-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .tab-btn:hover:not(.active) {
            background: #f5f7fa;
            transform: scale(1.03);
        }

        .insurance-grid {
            display: none;
        }

        .insurance-grid.active {
            display: block;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .empty-state i {
            font-size: 5rem;
            color: #bdc3c7;
            margin-bottom: 20px;
        }

        .comparison-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 5;
        }

        .comparison-badge:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .comparison-badge input[type="checkbox"] {
            display: none;
        }

        .comparison-badge i {
            color: #95a5a6;
            font-size: 1.2rem;
        }

        .comparison-badge input:checked + i {
            color: #667eea;
        }
    </style>

    <!-- Hero Section -->
    <div class="insurance-hero">
        <div class="container">
            <div class="text-center">
                <h1 class="mb-3">
                    <i class="fas fa-shield-alt me-3"></i>
                    اختر باقة التأمين المناسبة لك
                </h1>
                <p class="lead mb-0">قارن واختر من بين أفضل عروض التأمين من كبرى الشركات في المملكة</p>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Tab Navigation -->
        <div class="tab-navigation">
            <button class="tab-btn active" onclick="switchTab('third-party')" id="btn-third-party">
                <i class="fas fa-car"></i>
                <span>التأمين ضد الغير</span>
                <span class="badge bg-light text-dark ms-2">{{ isset($thirdPartyInsurances) ? $thirdPartyInsurances->count() : 0 }}</span>
            </button>
            <button class="tab-btn" onclick="switchTab('full-coverage')" id="btn-full-coverage">
                <i class="fas fa-shield-check"></i>
                <span>التأمين الشامل</span>
                <span class="badge bg-light text-dark ms-2">{{ isset($fullInsurances) ? $fullInsurances->count() : 0 }}</span>
            </button>
        </div>

        <!-- Third Party Insurance Grid -->
        <div class="insurance-grid active" id="grid-third-party">
            @if (isset($thirdPartyInsurances) && $thirdPartyInsurances->count() > 0)
                <div class="row g-4">
                    @foreach ($thirdPartyInsurances as $index => $insurance)
                        <div class="col-lg-4 col-md-6">
                            <div class="insurance-card-enhanced {{ $index == 1 ? 'best-seller' : '' }}">
                                <!-- Comparison Checkbox -->
                                <label class="comparison-badge">
                                    <input type="checkbox" class="compare-checkbox" value="{{ $insurance->id }}">
                                    <i class="fas fa-balance-scale"></i>
                                </label>

                                <!-- Company Logo -->
                                <div class="company-logo-enhanced">
                                    @php
                                        $img = $insurance->image ?? null;
                                        $imgPath = $img ? public_path($img) : null;
                                    @endphp
                                    @if ($img && $imgPath && file_exists($imgPath))
                                        <img src="{{ asset($img) }}" alt="شعار الشركة">
                                    @else
                                        <i class="fas fa-building fa-4x" style="color: #bdc3c7;"></i>
                                    @endif
                                </div>

                                <!-- Rating -->
                                <div class="rating-display">
                                    <div class="stars">
                                        @for($i = 0; $i < 5; $i++)
                                            @if($i < 4)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="fas fa-star-half-alt"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <div class="reviews">({{ rand(150, 500) }} تقييم)</div>
                                </div>

                                <!-- Price -->
                                <div class="price-badge">
                                    <span class="amount">{{ number_format($insurance->price, 0) }}</span>
                                    <span class="currency">ريال / سنوياً</span>
                                </div>

                                <!-- Benefits -->
                                <div class="benefits-section">
                                    <form action="{{ route('insuranceTypeRequest') }}" method="POST" class="insuranceTypeForm">
                                        @csrf
                                        <input type="hidden" name="insurance_id" value="{{ $insurance->id }}">

                                        @if (!empty($insurance->insuranceBenefits) && $insurance->insuranceBenefits->count() > 0)
                                            @foreach ($insurance->insuranceBenefits as $benefit)
                                                @php $checkboxId = 'tp_'.$insurance->id.'_benefit_'.$loop->index; @endphp
                                                <label class="benefit-item checkbox-benefit" for="{{ $checkboxId }}">
                                                    <input type="checkbox" id="{{ $checkboxId }}" name="benefit[]" value="{{ $benefit->id }}">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>{{ $benefit->benefit_title }}</span>
                                                </label>
                                            @endforeach
                                        @endif

                                        <button type="submit" class="btn-choose-plan insuranceTypeFormSubmit">
                                            <i class="fas fa-shopping-cart me-2"></i>
                                            اشتري الآن
                                        </button>
                                    </form>
                                </div>

                                <!-- Terms Link -->
                                <div class="terms-link">
                                    <a href="#" target="_blank">
                                        <i class="fas fa-file-contract me-1"></i>
                                        الشروط والأحكام
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>لا توجد باقات تأمين ضد الغير متاحة حالياً</h3>
                    <p class="text-muted">يرجى المحاولة لاحقاً أو التواصل مع خدمة العملاء</p>
                </div>
            @endif
        </div>

        <!-- Full Coverage Insurance Grid -->
        <div class="insurance-grid" id="grid-full-coverage">
            @if (isset($fullInsurances) && $fullInsurances->count() > 0)
                <div class="row g-4">
                    @foreach ($fullInsurances as $index => $insurance)
                        <div class="col-lg-4 col-md-6">
                            <div class="insurance-card-enhanced {{ $index == 0 ? 'recommended' : '' }}">
                                <!-- Comparison Checkbox -->
                                <label class="comparison-badge">
                                    <input type="checkbox" class="compare-checkbox" value="{{ $insurance->id }}">
                                    <i class="fas fa-balance-scale"></i>
                                </label>

                                <!-- Company Logo -->
                                <div class="company-logo-enhanced">
                                    @php
                                        $img = $insurance->image ?? null;
                                        $imgPath = $img ? public_path($img) : null;
                                    @endphp
                                    @if ($img && $imgPath && file_exists($imgPath))
                                        <img src="{{ asset($img) }}" alt="شعار الشركة">
                                    @else
                                        <i class="fas fa-shield-alt fa-4x" style="color: #bdc3c7;"></i>
                                    @endif
                                </div>

                                <!-- Rating -->
                                <div class="rating-display">
                                    <div class="stars">
                                        @for($i = 0; $i < 5; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                    </div>
                                    <div class="reviews">({{ rand(200, 600) }} تقييم)</div>
                                </div>

                                <!-- Price -->
                                <div class="price-badge">
                                    <span class="amount">{{ number_format($insurance->price, 0) }}</span>
                                    <span class="currency">ريال / سنوياً</span>
                                </div>

                                <!-- Benefits -->
                                <div class="benefits-section">
                                    <form action="{{ route('insuranceTypeRequest') }}" method="POST" class="insuranceTypeForm">
                                        @csrf
                                        <input type="hidden" name="insurance_id" value="{{ $insurance->id }}">

                                        @if (!empty($insurance->insuranceBenefits) && $insurance->insuranceBenefits->count() > 0)
                                            @foreach ($insurance->insuranceBenefits as $benefit)
                                                @php $checkboxId = 'full_'.$insurance->id.'_benefit_'.$loop->index; @endphp
                                                <label class="benefit-item checkbox-benefit" for="{{ $checkboxId }}">
                                                    <input type="checkbox" id="{{ $checkboxId }}" name="benefit[]" value="{{ $benefit->id }}">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>{{ $benefit->benefit_title }}</span>
                                                </label>
                                            @endforeach
                                        @endif

                                        <button type="submit" class="btn-choose-plan insuranceTypeFormSubmit">
                                            <i class="fas fa-shopping-cart me-2"></i>
                                            اشتري الآن
                                        </button>
                                    </form>
                                </div>

                                <!-- Terms Link -->
                                <div class="terms-link">
                                    <a href="#" target="_blank">
                                        <i class="fas fa-file-contract me-1"></i>
                                        الشروط والأحكام
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>لا توجد باقات تأمين شامل متاحة حالياً</h3>
                    <p class="text-muted">يرجى المحاولة لاحقاً أو التواصل مع خدمة العملاء</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="overlay">
        <div class="cv-spinner">
            <div class="spinnerContainer">
                <img src="{{ asset('style_files/frontend/img/logoInsurance.svg') }}" alt="Loading">
                <span class="text-black mx-2">جاري التحميل ...</span>
                <span class="spinner"></span>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Update buttons
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.getElementById('btn-' + tabName).classList.add('active');

            // Update grids
            document.querySelectorAll('.insurance-grid').forEach(grid => grid.classList.remove('active'));
            document.getElementById('grid-' + tabName).classList.add('active');
        }

        function initInsuranceTypePage() {
            jQuery(function($){
                // Show overlay on form submit
                $(document).on('submit', '.insuranceTypeForm', function(){
                    $("#overlay").fadeIn(200);
                    $(this).find('.insuranceTypeFormSubmit').prop('disabled', true);
                });

                // Hide overlay on load/pageshow
                $(window).on('load pageshow', function(){
                    $("#overlay").fadeOut(0);
                    $('.insuranceTypeFormSubmit').prop('disabled', false);
                });

                // Handle comparison checkboxes
                $('.compare-checkbox').on('change', function() {
                    const checkedCount = $('.compare-checkbox:checked').length;
                    if (checkedCount > 3) {
                        this.checked = false;
                        if (typeof Swal !== 'undefined' && Swal.fire) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'تنبيه',
                                text: 'يمكنك مقارنة 3 باقات كحد أقصى',
                                confirmButtonText: 'حسناً'
                            });
                        }
                    }
                });
            });
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function(){
            if (window.jQuery) {
                initInsuranceTypePage();
            }
        });

        // jQuery fallback
        (function ensureJQuery(){
            if (window.jQuery) return;
            var s = document.createElement('script');
            s.src = 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js';
            s.defer = true;
            s.onload = function(){
                window.$ = window.jQuery;
                console.log('jQuery fallback loaded');
                initInsuranceTypePage();
            };
            document.head.appendChild(s);
        })();

        // SweetAlert2 fallback
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
