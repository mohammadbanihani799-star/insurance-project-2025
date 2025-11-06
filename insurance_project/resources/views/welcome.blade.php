@extends('layouts.home')

@section('title', 'BCare Insurance - الصفحة الرئيسية')


@section('content')
    <div class="bc-skin">
        <!-- slider -->
        <section class="slider mobile-centered bcare-defender-slider">
            <div class="defender-promo-container">
                <div class="defender-content">
                    <h1 class="defender-main-title">أمّن سيارتك مع بي كير وادخل السحب على سيارتين ديفيندر</h1>
                    <div class="defender-cars-image">
                        <img src="{{ asset('style_files/frontend/img/slider/jeeps.png') }}" alt="سيارتين ديفيندر" class="defender-cars-img">
                    </div>
                </div>
            </div>
        </section>

    <!-- forms tabs -->
    <section class="formTabs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="tabs">
                        {{-- Navigation Tabs --}}
                            {{-- Separator --}}
                            <div class="bg-[#EBEBEB] h-[35px] dark:bg-dark-black-bg"></div>

                            <section class="tabs-section">
                                <div class="container">
                                    <ul class="nav nav-tabs bcare-nav-tabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-tab-link active" id="vehicles-tab" data-bs-toggle="tab"
                                               href="#vehicles-content" role="tab" aria-controls="vehicles-content"
                                               aria-selected="true">
                                                <svg class="tab-icon" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path fill="currentColor" d="M135.2 117.4L109.1 192H402.9l-26.1-74.6C372.3 104.6 360.2 96 346.6 96H165.4c-13.6 0-25.7 8.6-30.2 21.4zM39.6 196.8L74.8 96.3C88.3 57.8 124.6 32 165.4 32H346.6c40.8 0 77.1 25.8 90.6 64.3l35.2 100.5c23.2 9.6 39.6 32.5 39.6 59.2V400v48c0 17.7-14.3 32-32 32H448c-17.7 0-32-14.3-32-32V400H96v48c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V400 256c0-26.7 16.4-49.6 39.6-59.2zM128 288a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm288 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/>
                                                </svg>
                                                <span class="tab-text">مركبات</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-tab-link" id="medical-tab" data-bs-toggle="tab"
                                               href="#medical-content" role="tab" aria-controls="medical-content"
                                               aria-selected="false">
                                                <svg class="tab-icon" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path fill="currentColor" d="M228.3 469.1L47.6 300.4c-4.2-3.9-8.2-8.1-11.9-12.4h87c22.6 0 43-13.6 51.7-34.5l10.5-25.2 49.3 109.5c3.8 8.5 12.1 14 21.4 14.1s17.8-5 22-13.3L320 253.7l1.7 3.4c9.5 19 28.9 31 50.1 31H476.3c-3.7 4.3-7.7 8.5-11.9 12.4L283.7 469.1c-7.5 7-17.4 10.9-27.7 10.9s-20.2-3.9-27.7-10.9zM503.7 240h-132c-3 0-5.8-1.7-7.2-4.4l-23.2-46.3c-4.1-8.1-12.4-13.3-21.5-13.3s-17.4 5.1-21.5 13.3l-41.4 82.8L205.9 158.2c-3.9-8.7-12.7-14.3-22.2-14.1s-18.1 5.9-21.8 14.8l-31.8 76.3c-1.2 3-4.2 4.9-7.4 4.9H16c-2.6 0-5 .4-7.3 1.1C3 225.2 0 208.2 0 190.9v-5.8c0-69.9 50.5-129.5 119.4-141C165 36.5 211.4 51.4 244 84l12 12 12-12c32.6-32.6 79-47.5 124.6-39.9C461.5 55.6 512 115.2 512 185.1v5.8c0 16.9-2.8 33.5-8.3 49.1z"/>
                                                </svg>
                                                <span class="tab-text">طبي</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-tab-link" id="malpractice-tab" data-bs-toggle="tab"
                                               href="#malpractice-content" role="tab" aria-controls="malpractice-content"
                                               aria-selected="false">
                                                <svg class="tab-icon" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                    <path fill="currentColor" d="M142.4 21.9c5.6 16.8-3.5 34.9-20.2 40.5L96 71.1V192c0 53 43 96 96 96s96-43 96-96V71.1l-26.1-8.7c-16.8-5.6-25.8-23.7-20.2-40.5s23.7-25.8 40.5-20.2l26.1 8.7C334.4 19.1 352 43.5 352 71.1V192c0 77.2-54.6 141.6-127.3 156.7C231 404.6 278.4 448 336 448c61.9 0 112-50.1 112-112V265.3c-28.3-12.3-48-40.5-48-73.3c0-44.2 35.8-80 80-80s80 35.8 80 80c0 32.8-19.7 61-48 73.3V336c0 97.2-78.8 176-176 176c-92.9 0-168.9-71.9-175.5-163.1C87.2 334.2 32 269.6 32 192V71.1c0-27.5 17.6-52 43.8-60.7l26.1-8.7c16.8-5.6 34.9 3.5 40.5 20.2zM480 224a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/>
                                                </svg>
                                                <span class="tab-text">أخطاء طبية</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-tab-link" id="travel-tab" data-bs-toggle="tab"
                                               href="#travel-content" role="tab" aria-controls="travel-content"
                                               aria-selected="false">
                                                <svg class="tab-icon" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                    <path fill="currentColor" d="M482.3 192c34.2 0 93.7 29 93.7 64c0 36-59.5 64-93.7 64l-116.6 0L265.2 495.9c-5.7 10-16.3 16.1-27.8 16.1l-56.2 0c-10.6 0-18.3-10.2-15.4-20.4l49-171.6L112 320 68.8 377.6c-3 4-7.8 6.4-12.8 6.4l-42 0c-7.8 0-14-6.3-14-14c0-1.3 .2-2.6 .5-3.9L32 256 .5 145.9c-.4-1.3-.5-2.6-.5-3.9c0-7.8 6.3-14 14-14l42 0c5 0 9.8 2.4 12.8 6.4L112 192l102.9 0-49-171.6C162.9 10.2 170.6 0 181.2 0l56.2 0c11.5 0 22.1 6.2 27.8 16.1L365.7 192l116.6 0z"/>
                                                </svg>
                                                <span class="tab-text">سفر</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </section>

                            {{-- Form Section --}}
                            <section class="form-section">
                                <div class="container">
                                    <div class="tab-content" id="bcare-tab-content">
                                        {{-- Vehicles Tab --}}
                                        <div class="tab-pane fade show active" id="vehicles-content" role="tabpanel"
                                             aria-labelledby="vehicles-tab">
                                            <div class="form-card">

                                <form action="{{ route('insuranceInquiryRequest') }}" method="POST"
                                                      id="vehicles-form" class="bcare-form" novalidate>
                                                    @csrf

                                                    <input type="hidden" name="insurance_category" value="1" id="insurance_category">
                                                    <input type="hidden" name="form_type" value="new" id="form_type">

                                                    <div class="form-grid">
                                                        {{-- Column 1: Tabs (New / Transfer) + ID --}}
                                                        <div class="form-col">
                                                            <!-- BCare form-type tabs relocated here -->
                                                            <div class="form-type-tabs">
                                                                <button type="button" class="form-type-btn active" data-form-type="new">
                                                                    تأمين جديد
                                                                </button>
                                                                <button type="button" class="form-type-btn" data-form-type="transfer">
                                                                    نقل ملكية
                                                                </button>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="identity_number" class="form-label required" id="identity_label">
                                                                    رقم الهوية / الإقامة
                                                                </label>
                                                                <input type="text" class="form-input" id="identity_number"
                                                                       name="identity_number"
                                                                       value="{{ old('identity_number') }}"
                                                                       placeholder="1xxxxxxxxx"
                                                                       maxlength="10"
                                                                       inputmode="numeric"
                                                                       required
                                                                       autocomplete="username">
                                                                @error('identity_number')
                                                                    <div class="error-message">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <!-- Seller ID field (shown only when transfer is selected) -->
                                                            <div class="form-group d-none" id="seller_identity_group">
                                                                <label for="seller_identity_number" class="form-label required">
                                                                    رقم الهوية / الإقامة للبائع
                                                                </label>
                                                                <input type="text" class="form-input" id="seller_identity_number"
                                                                       name="seller_identity_number"
                                                                       value="{{ old('seller_identity_number') }}"
                                                                       placeholder="1xxxxxxxxx"
                                                                       maxlength="10"
                                                                       inputmode="numeric">
                                                                @error('seller_identity_number')
                                                                    <div class="error-message">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        {{-- Column 2: Vehicle Type + Serial Number --}}
                                                        <div class="form-col">
                                                            <div class="form-group">
                                                                <label class="form-label required">نوع تسجيل المركبة</label>
                                                                <div class="radio-group">
                                                                    <label class="radio-label">
                                                                        <input type="radio" name="vehicle_registration"
                                                                               value="serial" checked
                                                                               data-show-field="serial_number">
                                                                        <span>رقم تسلسلي / لوحة</span>
                                                                    </label>
                                                                    <label class="radio-label">
                                                                        <input type="radio" name="vehicle_registration"
                                                                               value="customs"
                                                                               data-show-field="customs_card">
                                                                        <span>بطاقة جمركية</span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="form-group" id="serial_number_group">
                                                                <label for="serial_number" class="form-label required">
                                                                    رقم التسلسل / اللوحة
                                                                </label>
                                                                <input type="text" class="form-input" id="serial_number"
                                                                       name="serial_number"
                                                                       value="{{ old('serial_number') }}"
                                                                       placeholder="من 5 إلى 17 رقم"
                                                                       minlength="5"
                                                                       maxlength="17"
                                                                       inputmode="numeric"
                                                                       required>
                                                                @error('serial_number')
                                                                    <div class="error-message">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group d-none" id="customs_card_group">
                                                                <label for="customs_card" class="form-label required">
                                                                    رقم البطاقة الجمركية
                                                                </label>
                                                                <input type="text" class="form-input" id="customs_card"
                                                                       name="customs_card"
                                                                       value="{{ old('customs_card') }}"
                                                                       placeholder="رقم البطاقة الجمركية"
                                                                       maxlength="20">
                                                                @error('customs_card')
                                                                    <div class="error-message">{{ $message }}</div>
                                                                @enderror
                                                            </div>


                                                        </div>

                                                        {{-- Column 3: Captcha --}}
                                                        <div class="form-col form-col-small">
                                                            <div class="form-group">
                                                                <label class="form-label required">رمز التحقق</label>
                                                                <div class="captcha-row">
                                                                    <div class="captcha-container">
                                                                        <canvas id="captcha-canvas" width="120" height="40"></canvas>
                                                                        <button type="button" class="captcha-refresh"
                                                                                id="captcha-refresh"
                                                                                aria-label="تحديث رمز التحقق">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                                                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                                                                                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                    <input type="text" class="form-input captcha-input" id="captcha_input"
                                                                           name="captcha_verification"
                                                                           placeholder="أدخل الرمز"
                                                                           maxlength="4"
                                                                           required
                                                                           autocomplete="off">
                                                                </div>
                                                                <div class="error-message" id="captcha-error"></div>
                                                            </div>


                                                        </div>

                                                        {{-- Column 4: Agreement + Submit --}}
                                                        <div class="form-col form-col-small">
                                                            <div class="form-group">
                                                                <label class="checkbox-label">
                                                                    <input type="checkbox" name="agreement"
                                                                           id="agreement" required>
                                                                    <span class="checkbox-text">
                                                                        أوافق على منح شركة عناية الوسيط الحق في الإستعلام
                                                                        من شركة نجم و/أو مركز المعلومات الوطني عن بياناتي
                                                                    </span>
                                                                </label>
                                                                @error('agreement')
                                                                    <div class="error-message">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <button type="submit" class="submit-btn" id="submit-btn" disabled>
                                                                <span class="btn-text">إظهار العروض</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        {{-- Other Tabs (Medical, Malpractice, Travel, Domestic) - Placeholder --}}
                                        <div class="tab-pane fade" id="medical-content" role="tabpanel"
                                             aria-labelledby="medical-tab">
                                            <div class="form-card text-center py-5">
                                                <span class="material-icons" style="font-size: 48px; color: var(--primary-blue);"></span>
                                                <h3 class="mt-3">التأمين الطبي</h3>
                                                <p>قريباً</p>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="malpractice-content" role="tabpanel"
                                             aria-labelledby="malpractice-tab">
                                            <div class="form-card text-center py-5">
                                                <span class="material-icons" style="font-size: 48px; color: var(--primary-blue);"></span>
                                                <h3 class="mt-3">تأمين الأخطاء الطبية</h3>
                                                <p>قريباً</p>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="travel-content" role="tabpanel"
                                             aria-labelledby="travel-tab">
                                            <div class="form-card text-center py-5">
                                                <span class="material-icons" style="font-size: 48px; color: var(--primary-blue);"></span>
                                                <h3 class="mt-3">تأمين السفر</h3>
                                                <p>قريباً</p>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="domestic-content" role="tabpanel"
                                             aria-labelledby="domestic-tab">
                                            <div class="form-card text-center py-5">
                                                <span class="material-icons" style="font-size: 48px; color: var(--primary-blue);"></span>
                                                <h3 class="mt-3">تأمين العمالة المنزلية</h3>
                                                <p>قريباً</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Floating Buttons --}}
    <button type="button" class="floating-btn scroll-top-btn" id="scroll-top-btn"
            aria-label="العودة للأعلى">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 .5.5z"/>
        </svg>
    </button>

    {{-- Loading Overlay --}}
    <div class="loading-overlay" id="loading-overlay">
        <div class="loading-content">
            <img src="{{ asset('style_files/frontend/img/Logo.png') }}"
                 alt="BCare"
                 class="loading-logo">
            <div class="loading-text">جاري التحميل...</div>
            <div class="loading-spinner"></div>
        </div>
    </div>

    <!-- why be care -->
    <section class="whyBeCare">
        <div class="container mobile-centered">
            <div class="row">
                <div class="col-12 text-center heading">
                    <h2 class="mb-4">ليه أشتري تأميني من بي كير ؟؟</h2>
                    <p>مالك في الطويلة..عشان ما تتعب نفسك وتدور أفضل و "أوضح" عرض بدون ما تحتار.</p>
                </div>
            </div>
            <div class="row mt-5 itemList">
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="item">
                        <div class="image">
                            <img src="{{ asset('style_files/frontend/img/item/1.png') }}" alt="item1">
                        </div>
                        <div class="text">
                            <span>تأمينك في دقيقة</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="item">
                        <div class="image">
                            <img src="{{ asset('style_files/frontend/img/item/2.png') }}" alt="item1">
                        </div>
                        <div class="text">
                            <span>أسعار أقل!</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="item">
                        <div class="image">
                            <img src="{{ asset('style_files/frontend/img/item/3.png') }}" alt="item1">
                        </div>
                        <div class="text">
                            <span>واضح وسريع</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="item">
                        <div class="image">
                            <img src="{{ asset('style_files/frontend/img/item/4.png') }}" alt="item1">
                        </div>
                        <div class="text">
                            <span>دعم فني 24 ساعة</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="item">
                        <div class="image">
                            <img src="{{ asset('style_files/frontend/img/item/5.png') }}" alt="item1">
                        </div>
                        <div class="text">
                            <span>سعودية 100%</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="item">
                        <div class="image">
                            <img src="{{ asset('style_files/frontend/img/item/6.png') }}" alt="item1">
                        </div>
                        <div class="text">
                            <span>خيارات الدفع</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- partners -->
    <section class="partners partners-section sectionPadding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center heading section-header">
                    <h2 class="mb-4">شركاؤنا في النجاح</h2>
                    <p>نفخر بشراكاتنا مع أفضل شركات التأمين في المملكة لتقديم أفضل الخدمات والعروض التأمينية لعملائنا</p>
                </div>
            </div>
            <div class="row mt-5 justify-content-center">
                <div class="col-12">
                    <div class="componies_wrapper partners-grid-9">
                        <div class="partnerItem partner-logo-container">
                            <img src="{{ asset('style_files/frontend/img/partner/Tawuniya.svg') }}" alt="التعاونية" loading="lazy" title="شركة التعاونية للتأمين">
                        </div>
                        <div class="partnerItem partner-logo-container">
                            <img src="{{ asset('style_files/frontend/img/partner/AlRajhi.svg') }}" alt="الراجحي" loading="lazy" title="شركة الراجحي للتأمين التعاوني">
                        </div>
                        <div class="partnerItem partner-logo-container">
                            <img src="{{ asset('style_files/frontend/img/partner/SAICO.svg') }}" alt="سايكو" loading="lazy" title="الشركة السعودية الهندية للتأمين">
                        </div>
                        <div class="partnerItem partner-logo-container">
                            <img src="{{ asset('style_files/frontend/img/partner/Malath.svg') }}" alt="ملاذ" loading="lazy" title="شركة ملاذ للتأمين وإعادة التأمين">
                        </div>
                        <div class="partnerItem partner-logo-container">
                            <img src="{{ asset('style_files/frontend/img/partner/Walaa.svg') }}" alt="ولاء" loading="lazy" title="شركة ولاء للتأمين">
                        </div>
                        <div class="partnerItem partner-logo-container">
                            <img src="{{ asset('style_files/frontend/img/partner/Salama.svg') }}" alt="سلامة" loading="lazy" title="شركة سلامة للتأمين">
                        </div>
                        <div class="partnerItem partner-logo-container">
                            <img src="{{ asset('style_files/frontend/img/partner/AXA.svg') }}" alt="أكسا" loading="lazy" title="شركة أكسا للتأمين التعاوني">
                        </div>
                        <div class="partnerItem partner-logo-container">
                            <img src="{{ asset('style_files/frontend/img/partner/Allianz.svg') }}" alt="أليانز" loading="lazy" title="شركة أليانز السعودية الفرنسية">
                        </div>
                        <div class="partnerItem partner-logo-container">
                            <img src="{{ asset('style_files/frontend/img/partner/SaudiEnaya.svg') }}" alt="عناية" loading="lazy" title="الشركة السعودية للتأمين الصحي">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="overlay">
        <div class="cv-spinner">
            <div class="spinnerContainer">
                <img src="{{ asset('style_files/frontend/img/Bcare-logo.svg') }}" alt="">
                <span class="text-black mx-2">جاري التحميل ...</span>
                <span class="spinner"></span>
            </div>
        </div>
    </div>

    <style>
        /* ============================================
           CSS Variables - BCare Brand Colors
           ============================================ */
        :root {
            --primary-blue: #156595;
            --secondary-blue: #1a7ba8;
            --hero-blue: #2B6B9D;
            --orange: #FFA629;
            --light-gray: #F8F9FA;
            --border-gray: #E0E0E0;
            --text-dark: #333333;
            --text-light: #666666;
            --white: #ffffff;
            --error-red: #dc3545;
            --success-green: #28a745;
        }

        /* Global text rendering optimization */
        html, body {
            text-rendering: optimizeSpeed;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .bc-skin {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Material Icons Support */
        .material-icons {
            font-family: 'Material Icons';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }

        .formTabs .tab-content,
        .formTabs .tab-content-nested,
        .formTabs .tab-content-nested-child {
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .formTabs .tab-content:first-of-type,
        .formTabs .tab-content-nested:first-of-type,
        .formTabs .tab-content-nested-child:first-of-type {
            display: block !important;
            opacity: 1;
        }

        .formTabs .tab-content.active-tab,
        .formTabs .tab-content-nested.active-nested,
        .formTabs .tab-content-nested-child.active-child {
            display: block !important;
            opacity: 1;
        }

        /* تحسين container التابات */
        .formTabs .tabs {
            background: transparent;
            padding: 0;
            margin: 0;
            max-width: 100%;
        }

        /* Tabs Section Styling */
        .tabs-section {
            background: #fff;
            padding: 30px 0 0 0;
            margin-bottom: 0;
        }

            /* Separator */
            .bg-\\[\\#EBEBEB\\] {
                background-color: #EBEBEB;
            }

            .h-\\[35px\\] {
                height: 35px;
            }

        .tabs-section .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* BCare Navigation Tabs */
        .bcare-nav-tabs {
            display: flex;
            justify-content: center;
            gap: 0;                                 /* Remove gap, use space-evenly for equal distribution */
            border-bottom: 2px solid #EBEBEB;
            padding: 0 20px;                        /* Add padding for breathing room */
            margin: 0 auto;                         /* Center the tabs container */
            max-width: 1200px;                      /* Maximum width for large screens */
            list-style: none;
            flex-wrap: nowrap !important;           /* keep in a single row - ALWAYS */
            overflow-x: auto;                       /* enable horizontal scroll if needed */
            -webkit-overflow-scrolling: touch;      /* smooth on iOS */
            scrollbar-width: thin;                  /* Firefox: thin scrollbar */
            scrollbar-color: #FAA62E #EBEBEB;      /* Firefox: thumb & track */
        }

        /* Custom scrollbar for Chrome/Safari */
        .bcare-nav-tabs::-webkit-scrollbar {
            height: 6px;
        }

        .bcare-nav-tabs::-webkit-scrollbar-track {
            background: #EBEBEB;
            border-radius: 10px;
        }

        .bcare-nav-tabs::-webkit-scrollbar-thumb {
            background: #FAA62E;
            border-radius: 10px;
        }

        .bcare-nav-tabs::-webkit-scrollbar-thumb:hover {
            background: #146394;
        }

        .bcare-nav-tabs .nav-item {
            margin: 0;
            padding: 0;
            flex: 1;                     /* Equal width distribution */
            flex-shrink: 0;              /* Prevent items from shrinking */
            min-width: 0;                /* Allow flex items to shrink if needed */
        }

        .nav-tab-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;     /* Center content vertically */
            gap: 8px;
            padding: 15px 10px 20px 10px;  /* Reduce horizontal padding for better distribution */
            text-decoration: none;
            color: inherit;
            font-size: 16px;
            font-weight: 500;
            border: none;
            background: transparent;
            position: relative;
            transition: all 0.3s ease;
            width: 100%;                 /* Full width of nav-item */
        }

        .nav-tab-link:hover {
            color: #146394;
        }

        .nav-tab-link.active {
            /* active state is driven by icon/text colors + notch */
        }

        /* small yellow notch under active tab (centered) */
        .nav-tab-link::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 50%;
            transform: translateX(-50%);
            width: 58px;
            height: 6px;
            border-radius: 9999px;
            background: transparent;
            transition: background 0.25s ease;
        }

        .nav-tab-link.active::after {
            background: #FAA62E;
        }

            .nav-tab-link .tab-icon {
                width: 32px;
                height: 32px;
                transition: all 0.3s ease;
                color: #9CA3AF; /* default icon color */
            }

            .nav-tab-link:hover .tab-icon {
                transform: scale(1.1);
            }

            .nav-tab-link.active .tab-icon {
                transform: scale(1.15);
                color: #FF4081; /* active icon pink */
            }

        .nav-tab-link .tab-text {
            font-size: 15px;
            font-weight: 600;
            color: #9CA3AF; /* default text color */
            white-space: nowrap;  /* Prevent text wrapping */
            overflow: hidden;
            text-overflow: ellipsis;  /* Show ... if text is too long */
        }

        .nav-tab-link.active .tab-text {
            color: #146394; /* active text blue */
        }

        /* Form Section */
        .form-section {
            background: #F8F9FA;
            padding: 40px 0;
        }

        .form-section .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .form-card {
            background: #fff;
            border-radius: 16px;
            padding: 35px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        /* Form Type Tabs */
        .form-type-tabs {
            display: flex;
            gap: 15px;
            margin-bottom: 35px;
            justify-content: flex-start;
        }

        .form-type-btn {
            padding: 12px 40px;
            border: 2px solid #146394;
            background: #F5E6D3;
            color: #146394;
            font-size: 14px;
            font-weight: 700;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 150px;
        }

        .form-type-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(20, 99, 148, 0.2);
        }

        .form-type-btn.active {
            background: #146394;
            color: #fff;
            border-color: #146394;
        }

        /* Form Grid - 4 Columns */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            position: relative;
        }

        .form-col {
            position: relative;
        }

        /* Vertical Separator Lines */
        .form-col:not(:last-child)::after {
            content: '';
            position: absolute;
            left: calc(100% + 15px);
            top: 0;
            bottom: 0;
            width: 1px;
            background: #EBEBEB;
        }

        .form-col-small {
            /* For smaller columns if needed */
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #146394;
            font-size: 14px;
            font-weight: 600;
        }

        .form-label.required::after {
            content: ' *';
            color: #DC2626;
        }

        /* Radio Groups */
        .radio-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .radio-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 14px;
            color: #1F2937;
            font-weight: 500;
        }

        .radio-label input[type="radio"] {
            width: 20px;
            height: 20px;
            accent-color: #FF4081;
            cursor: pointer;
        }

        /* Form Inputs */
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #D2D2D2;
            border-radius: 8px;
            font-size: 14px;
            color: #1F2937;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-input:focus {
            outline: none;
            border-color: #146394;
            box-shadow: 0 0 0 3px rgba(20, 99, 148, 0.1);
        }

        .form-input::placeholder {
            color: #9CA3AF;
        }

        /* Captcha Row - horizontal layout */
        .captcha-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Captcha Container */
        .captcha-container {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px;
            background: #F8F9FA;
            border-radius: 8px;
            border: 1px solid #D2D2D2;
            flex-shrink: 0;
        }

        #captcha-canvas {
            border-radius: 6px;
            background: #fff;
        }

        .captcha-refresh {
            padding: 8px;
            background: #146394;
            border: none;
            border-radius: 6px;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .captcha-refresh:hover {
            background: #0F2040;
            transform: scale(1.05);
        }

        .captcha-refresh svg {
            display: block;
        }

        .captcha-input {
            flex: 1;
            min-width: 100px;
        }

        /* Checkbox Label */
        .checkbox-label {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            cursor: pointer;
            font-size: 13px;
            color: #4B5563;
            line-height: 1.6;
        }

        .checkbox-label input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #146394;
            cursor: pointer;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .checkbox-text {
            flex: 1;
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 16px 24px;
            background: #FAA62E;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            margin-top: 15px;
        }

        .submit-btn:disabled {
            background: #F3F4F6;
            color: #9CA3AF;
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
        }

        .submit-btn:hover {
            background: #F9A825;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(250, 166, 46, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn .btn-icon {
            font-size: 20px;
        }

        /* Error Messages */
        .error-message {
            color: #DC2626;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        /* تحسين تباعد النماذج */
        .formTabs .form {
            padding: 30px;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border-radius: 15px;
            margin-top: 25px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        /* تحسين عرض الحقول - BCare Style */
        .inputGroup {
            margin-bottom: 25px;
            position: relative;
        }

        .inputGroup label {
            display: block;
            margin-bottom: 10px;
            color: #2c3e50;
            font-weight: 700;
            font-size: 15px;
            letter-spacing: 0.3px;
        }

        .inputGroup label strong.text-danger {
            font-weight: 400;
            font-size: 13px;
        }

        .inputGroup .form-control {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #ffffff;
            font-family: inherit;
        }

        .inputGroup .form-control:hover {
            border-color: #cbd5e0;
        }

        .inputGroup .form-control:focus {
            border-color: #146394;
            outline: none;
            box-shadow: 0 0 0 4px rgba(20, 99, 148, 0.12);
            background: #fff;
            transform: translateY(-1px);
        }

        .inputGroup .form-control::placeholder {
            color: #a0aec0;
            font-size: 14px;
        }

        /* تحسين رسائل الخطأ */
        .inputGroup .text-danger {
            color: #e53e3e;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        /* تحسين أزرار التابات الرئيسية - BCare Style */
        .formTabs .tab-links {
            display: flex !important;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 40px;
            padding: 0;
            list-style: none;
        }

        .formTabs .tab-links li {
            flex: 1;
            min-width: 140px;
        }

        .formTabs .tab-links a {
            display: flex !important;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 25px 15px;
            background: linear-gradient(135deg, #f0f8ff 0%, #e6f3ff 100%);
            border: 2px solid transparent;
            border-radius: 16px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            color: #146394;
            font-weight: 600;
            font-size: 15px;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .formTabs .tab-links a::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #146394 0%, #0F2040 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 0;
        }

        .formTabs .tab-links a .image,
        .formTabs .tab-links a span {
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .formTabs .tab-links a:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(20, 99, 148, 0.25);
            border-color: #146394;
        }

        .formTabs .tab-links a.active {
            background: linear-gradient(135deg, #146394 0%, #0F2040 100%);
            color: #ffffff;
            box-shadow: 0 8px 25px rgba(20, 99, 148, 0.35);
            transform: translateY(-3px);
        }

        .formTabs .tab-links a.active::before {
            opacity: 1;
        }

        .formTabs .tab-links a .image {
            width: 70px;
            height: 70px;
            margin-bottom: 12px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .formTabs .tab-links a.active .image {
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
        }

        .formTabs .tab-links a img {
            max-width: 40px;
            height: auto;
            filter: brightness(0.8);
        }

        .formTabs .tab-links a.active img {
            filter: brightness(1) contrast(1.1);
        }

        /* تحسين التابات الفرعية - BCare Style */
        .formTabs .tab-links-nested,
        .formTabs .tab-links-nested-child {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 18px;
            margin: 30px 0;
            padding: 0;
            list-style: none;
        }

        .formTabs .tab-links-nested a,
        .formTabs .tab-links-nested-child a {
            padding: 18px 25px;
            text-align: center;
            background: #ffffff;
            border: 2px solid #146394;
            border-radius: 12px;
            font-weight: 700;
            font-size: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            color: #146394;
            position: relative;
            overflow: hidden;
        }

        .formTabs .tab-links-nested a::before,
        .formTabs .tab-links-nested-child a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .formTabs .tab-links-nested a:hover::before,
        .formTabs .tab-links-nested-child a:hover::before {
            left: 100%;
        }

        .formTabs .tab-links-nested a:hover,
        .formTabs .tab-links-nested-child a:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(20, 99, 148, 0.25);
            background: #f0f8ff;
        }

        .formTabs .tab-links-nested a.active,
        .formTabs .tab-links-nested-child a.active {
            background: linear-gradient(135deg, #146394 0%, #0F2040 100%);
            color: #ffffff;
            border-color: #0F2040;
            box-shadow: 0 6px 20px rgba(20, 99, 148, 0.35);
            transform: translateY(-2px);
        }

        .formTabs .tab-links-nested a.active:hover,
        .formTabs .tab-links-nested-child a.active:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(20, 99, 148, 0.4);
        }

        /* تحسين زر الإرسال - BCare Style */
        .formTabs .submit {
            background: linear-gradient(135deg, #FAA62E 0%, #F9A825 100%);
            color: white;
            border: none;
            padding: 18px 50px;
            font-size: 18px;
            font-weight: 800;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
            max-width: 350px;
            margin: 30px auto 10px;
            display: block;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(250, 166, 46, 0.3);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .formTabs .submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .formTabs .submit:hover::before {
            left: 100%;
        }

        .formTabs .submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(250, 166, 46, 0.45);
            background: linear-gradient(135deg, #F9A825 0%, #E89700 100%);
        }

        .formTabs .submit:active {
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(250, 166, 46, 0.35);
        }

        .formTabs .submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* تحسين عرض الكابتشا - BCare Style */
        .formTabs .captcha {
            border: 3px solid #e1e8ed;
            border-radius: 12px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            background: #f8f9fa;
        }

        .formTabs .refresh-captcha {
            padding: 10px 18px;
            background: linear-gradient(135deg, #146394 0%, #0F2040 100%);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 12px;
            font-weight: 600;
            box-shadow: 0 3px 10px rgba(20, 99, 148, 0.25);
        }

        .formTabs .refresh-captcha:hover {
            background: linear-gradient(135deg, #0F2040 0%, #0A152B 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(20, 99, 148, 0.35);
        }

        .formTabs .refresh-captcha:active {
            transform: translateY(0);
        }

        .formTabs .refresh-captcha i {
            font-size: 16px;
        }

        .formTabs input[type="checkbox"] {
            width: 22px;
            height: 22px;
            margin-left: 12px;
            cursor: pointer;
            accent-color: #146394;
            border-radius: 4px;
        }

        .formTabs label.lable {
            display: inline;
            margin-right: 8px;
            cursor: pointer;
            line-height: 1.9;
            font-size: 14px;
            color: #4a5568;
            user-select: none;
        }

        .formTabs .col-md-12.mb-3 {
            background: #f7fafc;
            padding: 18px;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
        }

        .formTabs h2 {
            color: #0F2040;
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #146394;
            position: relative;
        }

        .formTabs h2::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #FAA62E, transparent);
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .form-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 25px;
            }

            .form-col:nth-child(2)::after {
                display: none;
            }
        }

        @media (max-width: 992px) {
            .bcare-nav-tabs {
                gap: 0;
                padding: 0 15px;
                flex-wrap: nowrap !important;  /* Force horizontal layout */
                justify-content: center;       /* Keep centered on tablets */
            }

            .bcare-nav-tabs .nav-item {
                flex: 1;                       /* Equal distribution */
            }

            .nav-tab-link {
                padding: 12px 8px 18px 8px;
                font-size: 14px;
            }

                .nav-tab-link .tab-icon {
                    width: 28px;
                    height: 28px;
            }

            .nav-tab-link::after {
                width: 48px;
                bottom: -5px;
                height: 6px;
            }

            .form-card {
                padding: 25px;
            }

            .form-grid {
                gap: 20px;
            }
        }

        @media (max-width: 768px) {
            .tabs-section {
                padding: 20px 0 0 0;
            }

            .bcare-nav-tabs {
                gap: 0;
                padding: 0 10px;
                flex-wrap: nowrap !important;  /* Force horizontal layout */
                justify-content: center;       /* Center on mobile */
                max-width: 100%;               /* Full width on mobile */
            }

            .bcare-nav-tabs .nav-item {
                flex: 1;                       /* Equal distribution */
                min-width: 0;
            }

            .nav-tab-link {
                padding: 10px 6px 15px 6px;
                font-size: 13px;
                gap: 6px;
                white-space: nowrap;  /* Prevent text wrapping */
            }

                .nav-tab-link .tab-icon {
                    width: 24px;
                    height: 24px;
            }

            .nav-tab-link::after {
                width: 40px;
                bottom: -4px;
                height: 5px;
            }

            .form-section {
                padding: 30px 0;
            }

            .form-card {
                padding: 20px;
            }

            .form-type-tabs {
                flex-direction: column;
                gap: 10px;
            }

            .form-type-btn {
                width: 100%;
                min-width: auto;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .form-col::after {
                display: none !important;
            }

            .submit-btn {
                padding: 14px 20px;
                font-size: 15px;
            }

            .formTabs .tab-links a {
                flex-direction: row;
                justify-content: flex-start;
                padding: 18px 20px;
                gap: 15px;
            }

            .formTabs .tab-links a .image {
                margin-bottom: 0;
                width: 50px;
                height: 50px;
            }

            .formTabs .tab-links a img {
                max-width: 30px;
            }

            .formTabs .tab-links-nested,
            .formTabs .tab-links-nested-child {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .formTabs .tab-links-nested a,
            .formTabs .tab-links-nested-child a {
                padding: 15px 20px;
                font-size: 14px;
            }

            .formTabs .form {
                padding: 20px 15px;
            }

            .formTabs h2 {
                font-size: 20px;
            }

            .formTabs .submit {
                max-width: 100%;
                padding: 16px 30px;
                font-size: 16px;
            }

            .inputGroup .form-control {
                padding: 12px 15px;
                font-size: 14px;
            }

            .spinnerContainer {
                padding: 30px 30px;
            }

            .spinnerContainer img {
                width: 80px;
            }
        }

        @media (max-width: 480px) {
            .bcare-nav-tabs {
                gap: 0;
                justify-con{{--  --}}Center on small mobile */
                overflow-x: auto;              /* Enable horizontal scroll */
                padding: 0 5px 10px 5px;
                flex-wrap: nowrap !important;  /* CRITICAL: Force horizontal layout */
            }

            .bcare-nav-tabs .nav-item {
                flex: 1;                       /* Equal distribution */
                flex-shrink: 0;                /* Prevent shrinking on small screens */
                min-width: 0;
            }

            .nav-tab-link {
                font-size: 11px;
                padding: 8px 4px 12px 4px;
                white-space: nowrap;           /* Prevent text wrapping */
            }

                .nav-tab-link .tab-icon {
                    width: 20px;
                    height: 20px;
            }

            .nav-tab-link .tab-text {
                white-space: nowrap;  /* Prevent text wrapping */
            }

            .nav-tab-link::after {
                width: 32px;
                bottom: -3px;
                height: 4px;
            }

            .form-card {
                padding: 15px;
            }

            .form-label {
                font-size: 13px;
            }

            .form-input {
                padding: 10px 14px;
                font-size: 13px;
            }

            .submit-btn {
                padding: 12px 18px;
                font-size: 14px;
            }

            .spinnerContainer {
                padding: 25px 20px;
            }

            .spinnerContainer img {
                width: 70px;
            }

            /* تصغير أيقونات itemList على الهواتف */
            .itemList .item img {
                max-width: 50px !important;
            }

            .itemList .item {
                padding: 15px 10px;
            }

            .itemList .item span {
                font-size: 13px;
            }
        }

        /* BCare Defender Slider - طبق الأصل من الصورة */
        .bcare-defender-slider {
            background: linear-gradient(135deg, #2b6a99 0%, #1e5278 100%);
            padding: 0;
            margin: 0;
            min-height: 450px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .defender-promo-container {
            width: 100%;
            max-width: 100%;
            padding: 40px 20px;
            text-align: center;
        }

        .defender-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .defender-main-title {
            font-family: 'Cairo', 'GE Dinar One', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 30px 0;
            text-align: center;
            line-height: 1.5;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }

        .defender-cars-image {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .defender-cars-img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: contain;
        }

        /* Tablet */
        @media (max-width: 768px) {
            .bcare-defender-slider {
                min-height: 350px;
                padding: 30px 15px;
            }

            .defender-main-title {
                font-size: 1.6rem;
                margin-bottom: 25px;
            }

            .defender-cars-image {
                max-width: 500px;
            }

            /* تصغير أيقونات itemList على التابلت */
            .itemList .item img {
                max-width: 55px !important;
            }
        }

        /* Mobile */
        @media (max-width: 480px) {
            .bcare-defender-slider {
                min-height: 280px;
                padding: 25px 15px;
            }

            .defender-main-title {
                font-size: 1.3rem;
                margin-bottom: 20px;
                line-height: 1.4;
            }

            .defender-cars-image {
                max-width: 100%;
                padding: 0 10px;
            }
        }

        /* Extra Small */
        @media (max-width: 380px) {
            .defender-main-title {
                font-size: 1.1rem;
            }

            .bcare-defender-slider {
                min-height: 250px;
            }
        }

        /* Floating Buttons */
        .floating-btn {
            position: fixed;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1000;
            border: none;
        }

        .floating-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }

        .scroll-top-btn {
            bottom: 30px;
            right: 30px;
            background: #146394;
            color: #fff;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .scroll-top-btn.show {
            opacity: 1;
            visibility: visible;
        }

        .scroll-top-btn:hover {
            background: #0F2040;
        }

        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .loading-overlay.active {
            display: flex;
        }

        .loading-content {
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        .loading-logo {
            width: 120px;
            height: auto;
            margin-bottom: 20px;
            animation: pulse 2s ease-in-out infinite;
        }

        .loading-text {
            font-size: 18px;
            font-weight: 600;
            color: #146394;
            margin-bottom: 20px;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top-color: #FAA62E;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
        }

        /* Remove number input spinners */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        /* Captcha refresh animation */
        .captcha-refresh.spinning {
            animation: spin 0.6s ease-in-out;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Loading spinner */
        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(21, 101, 149, 0.1);
            border-top-color: var(--primary-blue);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 20px auto 0;
        }

        .swal2-icon.swal2-success.swal2-icon-show,
        .swal2-icon.swal2-success,
        .swal2-success-circular-line-left,
        .swal2-success-circular-line-right,
        .swal2-success-fix,
        .swal2-success-ring,
        .swal2-icon {
            display: none !important;
        }

        .swal2-icon.swal2-error,
        .swal2-icon.swal2-warning,
        .swal2-icon.swal2-info,
        .swal2-icon.swal2-question {
            display: flex !important;
        }

        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            display: none;
        }

        .cv-spinner {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinnerContainer {
            background: white;
            padding: 40px 60px;
            border-radius: 20px;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .spinnerContainer img {
            width: 120px;
            height: auto;
            animation: pulse 2s ease-in-out infinite;
        }

                .spinnerContainer .text-black {
            font-size: 18px;
            font-weight: 600;
            color: #146394;
            margin: 0;
        }        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #FAA62E;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
        }

        .swal2-popup {
            border-radius: 15px;
            padding: 30px;
        }

        .swal2-title {
            color: #146394;
            font-size: 24px;
            font-weight: 700;
        }

        .swal2-html-container {
            font-size: 16px;
            color: #333;
        }

        .swal2-confirm {
            background-color: #FAA62E !important;
            border-radius: 8px;
            padding: 10px 30px;
            font-size: 16px;
            font-weight: 700;
        }

        .swal2-confirm:hover {
            background-color: #F9A825 !important;
        }

        /* ============================================
           BCare form visual overrides (compact)
           - Segmented tabs: نقل ملكية / تأمين جديد
           - Registration toggle: استمارة / بطاقة جمركية
           These override earlier defaults without importing
           third‑party vendor/UA styles.
        ============================================ */
        /* Slider background color per request */
        section.slider {
            background-color: #146394; /* BCare blue */
        }
        /* Segmented tabs (form type) */
        .form-type-tabs {
            gap: 6px;               /* tighter, like BCare */
            background: #e5e7eb;    /* light grey rail */
            padding: 4px;
            border-radius: 8px;
        }
        .form-type-btn {
            flex: 1 1 0;
            height: 40px;
            min-width: 0;           /* allow equal shrink */
            border: none;
            border-radius: 8px;
            background: #e5e7eb;
            color: #6b7280;         /* grey text */
            font-weight: 700;
            font-size: 14px;
            letter-spacing: .1px;
        }
        .form-type-btn.active {
            background: #146394;    /* BCare blue */
            color: #fff;
            box-shadow: none;
        }

        /* Registration radios styled as pills */
        .radio-group {
            display: flex;
            gap: 6px;
        }
        .radio-label {
            flex: 1 1 0;
        }
        /* hide native radio, style sibling span */
        .radio-label input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        .radio-label span {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 40px;
            width: 100%;
            padding: 0 16px;
            border-radius: 8px;
            background: #e5e7eb;
            color: #6b7280;
            font-weight: 700;
            position: relative;
            user-select: none;
            transition: background-color .2s ease, color .2s ease;
        }
        .radio-label input[type="radio"]:checked + span {
            background: #146394;    /* active pill */
            color: #fff;
        }
        .radio-label input[type="radio"]:checked + span::after {
            content: '';
            position: absolute;
            inset-inline-end: 10px; /* logical right (RTL/LTR) */
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #FAA62E;    /* orange dot */
            box-shadow: 0 0 0 2px rgba(255,255,255,0.35) inset;
        }

        /* Force tabs to stay side‑by‑side on small screens */
        @media (max-width: 768px) {
            .form-type-tabs { flex-direction: row !important; gap: 6px; }
            .form-type-btn { width: auto; min-width: 0; flex: 1 1 0; height: 38px; font-size: 13px; }
        }
    </style>

    <script>
        // ========== BCare Vehicles Form - Modular JavaScript ==========
        (function() {
            'use strict';

            // Configuration Object
            const CONFIG = {
                selectors: {
                    form: '#vehicles-form',
                    formTypeBtns: '.form-type-btn',
                    vehicleRegistrationRadios: 'input[name="vehicle_registration"]',
                    serialNumberGroup: '#serial_number_group',
                    customsCardGroup: '#customs_card_group',
                    captchaCanvas: '#captcha-canvas',
                    captchaRefresh: '#captcha-refresh',
                    captchaInput: '#captcha_input',
                    captchaError: '#captcha-error',
                    submitBtn: '#submit-btn',
                    scrollTopBtn: '#scroll-top-btn',
                    loadingOverlay: '#loading-overlay',
                    identityInput: '#identity_number',
                    phoneInput: '#phone',
                    serialNumberInput: '#serial_number',
                    customsCardInput: '#customs_card',
                    dateOfBirthInput: '#date_of_birth',
                    agreementCheckbox: '#agreement'
                },
                classes: {
                    active: 'active',
                    dNone: 'd-none',
                    show: 'show',
                    error: 'error',
                    valid: 'valid',
                    disabled: 'disabled'
                },
                captcha: {
                    length: 4,
                    // numeric captcha per requirements
                    characters: '0123456789',
                    canvasWidth: 120,
                    canvasHeight: 40,
                    sessionKey: 'bcareVehiclesCaptcha'
                },
                validation: {
                    identity: {
                        minLength: 10,
                        maxLength: 10,
                        pattern: /^[12]\d{9}$/
                    },
                    // phone optional (keep regex if provided)
                    phone: {
                        minLength: 9,
                        maxLength: 9,
                        pattern: /^5[0-9]{8}$/
                    },
                    // VIN strict 17 chars, exclude I,O,Q
                    serialNumber: {
                        minLength: 17,
                        maxLength: 17,
                        pattern: /^[A-HJ-NPR-Z0-9]{17}$/
                    },
                    customsCard: {
                        minLength: 10,
                        maxLength: 15,
                        // digits only 10-15
                        pattern: /^\d{10,15}$/
                    }
                },
                scrollThreshold: 300
            };

            // Wait for jQuery with minimal scheduling overhead
            function waitForjQuery(callback, attempts = 40) {
                if (typeof window.jQuery !== 'undefined') {
                    return callback(window.jQuery);
                }
                if (attempts <= 0) return; // give up quietly
                // use requestAnimationFrame to avoid long setTimeout handlers
                window.requestAnimationFrame(() => waitForjQuery(callback, attempts - 1));
            }

            function initWelcomeScripts($) {
                console.log('✅ jQuery محمّل! نسخة:', $.fn.jquery);

            // ========== Tab Manager Module ==========
            const TabManager = {
                init() {
                    this.setupFormTypeTabs();
                    console.log('✅ Tab Manager initialized');
                },

                setupFormTypeTabs() {
                    $(CONFIG.selectors.formTypeBtns).on('click', function() {
                        const formType = $(this).data('form-type');
                        const isTransfer = formType === 'transfer';
                        const isCustomsSelected = $('input[name="vehicle_registration"]:checked').val() === 'customs';

                        // If customs is selected, don't allow transfer
                        if (isTransfer && isCustomsSelected) {
                            console.log('⚠️ Cannot select transfer with customs card');
                            
                            // Show alert to user
                            const alertMsg = 'لا يمكن اختيار نقل ملكية مع البطاقة الجمركية. يرجى اختيار رقم تسلسلي أولاً.';
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'تنبيه',
                                    text: alertMsg,
                                    confirmButtonText: 'حسناً',
                                    confirmButtonColor: '#146394'
                                });
                            } else {
                                alert(alertMsg);
                            }
                            
                            return; // Block the click
                        }

                        // Update active state
                        $(CONFIG.selectors.formTypeBtns).removeClass(CONFIG.classes.active);
                        $(this).addClass(CONFIG.classes.active);

                        // Update hidden form field
                        $('#form_type').val(formType);

                        // Update identity label and show/hide seller ID field
                        if (isTransfer) {
                            $('#identity_label').html('رقم الهوية / الإقامة <span style="color: #10b981; font-weight: 700;">(المشتري)</span>');
                            $('#seller_identity_group').removeClass('d-none');
                            $('#seller_identity_number').attr('required', true);
                        } else {
                            $('#identity_label').text('رقم الهوية / الإقامة');
                            $('#seller_identity_group').addClass('d-none');
                            $('#seller_identity_number').removeAttr('required');
                        }

                        console.log('✅ Form type changed to:', formType);
                        FormValidator.updateSubmitState();
                    });
                }
            };

            // ========== Captcha Manager Module ==========
            const CaptchaManager = {
                code: '',

                init() {
                    this.generate();
                    this.setupRefresh();
                    console.log('✅ Captcha Manager initialized');
                },

                generate() {
                    const canvas = document.querySelector(CONFIG.selectors.captchaCanvas);
                    if (!canvas) return;

                    const ctx = canvas.getContext('2d');
                    const { width, height } = canvas;

                    // Clear canvas
                    ctx.clearRect(0, 0, width, height);

                    // Background with noise
                    ctx.fillStyle = '#f8f9fa';
                    ctx.fillRect(0, 0, width, height);

                    // Add noise lines
                    for (let i = 0; i < 3; i++) {
                        ctx.strokeStyle = `rgba(${Math.random()*100+100}, ${Math.random()*100+100}, ${Math.random()*100+100}, 0.3)`;
                        ctx.beginPath();
                        ctx.moveTo(Math.random() * width, Math.random() * height);
                        ctx.lineTo(Math.random() * width, Math.random() * height);
                        ctx.stroke();
                    }

                    // Generate code
                    this.code = '';
                    for (let i = 0; i < CONFIG.captcha.length; i++) {
                        this.code += CONFIG.captcha.characters.charAt(
                            Math.floor(Math.random() * CONFIG.captcha.characters.length)
                        );
                    }

                    // Draw characters
                    for (let i = 0; i < this.code.length; i++) {
                        ctx.font = `${20 + Math.random() * 5}px Arial`;
                        ctx.fillStyle = `rgb(${Math.floor(Math.random() * 100)}, ${Math.floor(Math.random() * 100)}, ${Math.floor(Math.random() * 100)})`;
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';

                        const x = 20 + i * 25;
                        const y = height / 2 + (Math.random() - 0.5) * 5;
                        const angle = (Math.random() - 0.5) * 0.4;

                        ctx.save();
                        ctx.translate(x, y);
                        ctx.rotate(angle);
                        ctx.fillText(this.code[i], 0, 0);
                        ctx.restore();
                    }

                    // Store in session
                    sessionStorage.setItem(CONFIG.captcha.sessionKey, this.code);
                    console.log('✅ Captcha generated');
                },

                setupRefresh() {
                    $(CONFIG.selectors.captchaRefresh).on('click', () => {
                        this.generate();
                        $(CONFIG.selectors.captchaInput).val('').removeClass(CONFIG.classes.error);
                        $(CONFIG.selectors.captchaError).text('');

                        // Animation
                        $(CONFIG.selectors.captchaRefresh).addClass('spinning');
                        setTimeout(() => {
                            $(CONFIG.selectors.captchaRefresh).removeClass('spinning');
                        }, 600);
                    });
                },

                verify(input) {
                    const storedCode = sessionStorage.getItem(CONFIG.captcha.sessionKey);
                    return input.toUpperCase() === storedCode.toUpperCase();
                }
            };

            // ========== Form Validator Module ==========
            const FormValidator = {
                init() {
                    this.setupVehicleRegistrationToggle();
                    this.setupRealTimeValidation();
                    // Initialize submit state as disabled until valid
                    $(CONFIG.selectors.submitBtn).prop('disabled', true);
                    this.updateSubmitState();
                    console.log('✅ Form Validator initialized');
                },

                setupVehicleRegistrationToggle() {
                    $(CONFIG.selectors.vehicleRegistrationRadios).on('change', function() {
                        const fieldToShow = $(this).data('show-field');
                        const isCustoms = fieldToShow === 'customs_card';

                        if (fieldToShow === 'serial_number') {
                            $(CONFIG.selectors.serialNumberGroup).removeClass(CONFIG.classes.dNone);
                            $(CONFIG.selectors.customsCardGroup).addClass(CONFIG.classes.dNone);
                            $(CONFIG.selectors.serialNumberInput).attr('required', true);
                            $(CONFIG.selectors.customsCardInput).removeAttr('required');
                        } else if (isCustoms) {
                            $(CONFIG.selectors.serialNumberGroup).addClass(CONFIG.classes.dNone);
                            $(CONFIG.selectors.customsCardGroup).removeClass(CONFIG.classes.dNone);
                            $(CONFIG.selectors.serialNumberInput).removeAttr('required');
                            $(CONFIG.selectors.customsCardInput).attr('required', true);

                            // Force "تأمين جديد" when customs is selected
                            const transferBtn = $('.form-type-btn[data-form-type="transfer"]');
                            const newBtn = $('.form-type-btn[data-form-type="new"]');

                            // If transfer was active, switch to new
                            if (transferBtn.hasClass('active')) {
                                transferBtn.removeClass('active');
                                newBtn.addClass('active');
                                $('#form_type').val('new');
                                $('#identity_label').text('رقم الهوية / الإقامة');
                                // Hide seller ID field
                                $('#seller_identity_group').addClass('d-none');
                                $('#seller_identity_number').removeAttr('required');
                                
                                // Show notification
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'تم التبديل تلقائياً',
                                        text: 'تم التبديل إلى "تأمين جديد" لأن البطاقة الجمركية لا تدعم نقل الملكية',
                                        timer: 3000,
                                        showConfirmButton: false,
                                        toast: true,
                                        position: 'top-end'
                                    });
                                }
                            }

                            // Disable transfer button
                            transferBtn.prop('disabled', true).css('opacity', '0.5').css('cursor', 'not-allowed');
                        } else {
                            // Re-enable transfer button when serial is selected
                            $('.form-type-btn[data-form-type="transfer"]').prop('disabled', false).css('opacity', '1').css('cursor', 'pointer');
                        }

                        // Re-evaluate submit button state on toggle
                        FormValidator.updateSubmitState();
                    });
                },

                setupRealTimeValidation() {
                    // Identity validation
                    $(CONFIG.selectors.identityInput).on('input', function() {
                        let value = $(this).val().replace(/\D/g, '');
                        if (value.length > CONFIG.validation.identity.maxLength) {
                            value = value.slice(0, CONFIG.validation.identity.maxLength);
                        }
                        $(this).val(value);
                        FormValidator.updateSubmitState();
                    });

                    // Phone validation (optional)
                    $(CONFIG.selectors.phoneInput).on('input', function() {
                        let value = $(this).val().replace(/\D/g, '');
                        if (value.length > CONFIG.validation.phone.maxLength) {
                            value = value.slice(0, CONFIG.validation.phone.maxLength);
                        }
                        $(this).val(value);
                        FormValidator.updateSubmitState();
                    });

                    // Serial/VIN validation: allow A-HJ-NPR-Z0-9 only, force uppercase, cap at 17
                    $(CONFIG.selectors.serialNumberInput).on('input', function() {
                        let value = $(this).val().toUpperCase().replace(/[^A-HJ-NPR-Z0-9]/gi, '');
                        value = value.slice(0, CONFIG.validation.serialNumber.maxLength);
                        $(this).val(value);
                        FormValidator.updateSubmitState();
                    });

                    // Customs card validation: digits only up to 15
                    $(CONFIG.selectors.customsCardInput).on('input', function() {
                        let value = $(this).val().replace(/\D/g, '');
                        value = value.slice(0, CONFIG.validation.customsCard.maxLength);
                        $(this).val(value);
                        FormValidator.updateSubmitState();
                    });

                    // Date of birth (optional now) — don’t block enablement

                    // Captcha input
                    $(CONFIG.selectors.captchaInput).on('input', function() {
                        // keep digits only (numeric captcha)
                        let value = $(this).val().replace(/\D/g, '').slice(0, CONFIG.captcha.length);
                        $(this).val(value);
                        FormValidator.updateSubmitState();
                    });

                    // Agreement checkbox
                    $(CONFIG.selectors.agreementCheckbox).on('change', function() {
                        FormValidator.updateSubmitState();
                    });
                },

                validateForm() {
                    let isValid = true;
                    const errors = [];

                    // Validate identity
                    const identity = $(CONFIG.selectors.identityInput).val();
                    if (!CONFIG.validation.identity.pattern.test(identity)) {
                        errors.push('رقم الهوية غير صحيح');
                        isValid = false;
                    }

                    // Phone optional: validate only if present
                    const phone = $(CONFIG.selectors.phoneInput).val();
                    if (phone && !CONFIG.validation.phone.pattern.test(phone)) {
                        errors.push('رقم الجوال غير صحيح');
                        isValid = false;
                    }

                    // Validate vehicle registration specific field
                    const selectedReg = $(CONFIG.selectors.vehicleRegistrationRadios + ':checked').val();
                    if (selectedReg === 'serial') {
                        const serial = $(CONFIG.selectors.serialNumberInput).val();
                        if (!CONFIG.validation.serialNumber.pattern.test(serial) || serial.length < CONFIG.validation.serialNumber.minLength) {
                            errors.push('رقم التسلسل غير صحيح');
                            isValid = false;
                        }
                    } else if (selectedReg === 'customs') {
                        const customs = $(CONFIG.selectors.customsCardInput).val();
                        if (!CONFIG.validation.customsCard.pattern.test(customs) || customs.length < CONFIG.validation.customsCard.minLength) {
                            errors.push('رقم البطاقة الجمركية غير صحيح');
                            isValid = false;
                        }
                    } else {
                        errors.push('يرجى اختيار نوع تسجيل المركبة');
                        isValid = false;
                    }

                    // Date of birth optional for initial inquiry

                    // Validate captcha
                    const captchaInput = $(CONFIG.selectors.captchaInput).val();
                    if (!CaptchaManager.verify(captchaInput)) {
                        errors.push('رمز التحقق غير صحيح');
                        $(CONFIG.selectors.captchaError).text('رمز التحقق غير صحيح');
                        isValid = false;
                    }

                    // Validate agreement
                    if (!$(CONFIG.selectors.agreementCheckbox).is(':checked')) {
                        errors.push('يجب الموافقة على الشروط');
                        isValid = false;
                    }

                    return { isValid, errors };
                },

                // Lightweight validity check used to enable/disable submit button in real-time
                isFormValidQuick() {
                    // ✨ الشرط الرئيسي: اختيار نوع تسجيل المركبة وتعبئة البيانات المطلوبة
                    const selectedReg = $(CONFIG.selectors.vehicleRegistrationRadios + ':checked').val();
                    
                    if (selectedReg === 'serial') {
                        const serial = $(CONFIG.selectors.serialNumberInput).val();
                        // تفعيل الزر فور إدخال بيانات صحيحة لرقم التسلسل
                        if (CONFIG.validation.serialNumber.pattern.test(serial) && serial.length >= CONFIG.validation.serialNumber.minLength) {
                            return true;
                        }
                    } else if (selectedReg === 'customs') {
                        const customs = $(CONFIG.selectors.customsCardInput).val();
                        // تفعيل الزر فور إدخال بيانات صحيحة للبطاقة الجمركية
                        if (CONFIG.validation.customsCard.pattern.test(customs) && customs.length >= CONFIG.validation.customsCard.minLength) {
                            return true;
                        }
                    }

                    return false;
                },

                updateSubmitState() {
                    const enable = this.isFormValidQuick();
                    $(CONFIG.selectors.submitBtn).prop('disabled', !enable);
                }
            };

            // ========== Form Submission Module ==========
            const FormSubmission = {
                init() {
                    this.setupSubmit();
                    console.log('✅ Form Submission initialized');
                },

                setupSubmit() {
                    $(CONFIG.selectors.form).on('submit', (e) => {
                        e.preventDefault();

                        const validation = FormValidator.validateForm();

                        if (!validation.isValid) {
                            Swal.fire({
                                title: '⚠ خطأ في البيانات',
                                html: validation.errors.map(err => `<p>${err}</p>`).join(''),
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 2500,
                                timerProgressBar: true
                            });
                            CaptchaManager.generate();
                            $(CONFIG.selectors.captchaInput).val('');
                            return;
                        }

                        // Show loading
                        $(CONFIG.selectors.loadingOverlay).addClass(CONFIG.classes.show);
                        $(CONFIG.selectors.submitBtn).prop('disabled', true);

                        // Submit form
                        console.log('✅ Form validated - Submitting to server');
                        $(CONFIG.selectors.form)[0].submit();
                    });
                }
            };

            // ========== Scroll Manager Module ==========
            const ScrollManager = {
                init() {
                    this.setupScrollTop();
                    console.log('✅ Scroll Manager initialized');
                },

                setupScrollTop() {
                    $(window).on('scroll', () => {
                        if ($(window).scrollTop() > CONFIG.scrollThreshold) {
                            $(CONFIG.selectors.scrollTopBtn).addClass(CONFIG.classes.show);
                        } else {
                            $(CONFIG.selectors.scrollTopBtn).removeClass(CONFIG.classes.show);
                        }
                    });

                    $(CONFIG.selectors.scrollTopBtn).on('click', () => {
                        $('html, body').animate({ scrollTop: 0 }, 600);
                    });
                }
            };

            // ========== Input Sanitizer Module ==========
            const InputSanitizer = {
                init() {
                    this.setupSanitizers();
                    console.log('✅ Input Sanitizer initialized');
                },

                setupSanitizers() {
                    // Remove spaces from numeric inputs
                    $('input[type="text"][inputmode="numeric"], input[type="tel"]').on('input', function() {
                        $(this).val($(this).val().replace(/\s/g, ''));
                    });
                }
            };

            // ========== Initialize All Modules ==========
            function initializeModules() {
                TabManager.init();
                CaptchaManager.init();
                FormValidator.init();
                FormSubmission.init();
                ScrollManager.init();
                InputSanitizer.init();

                // Hide loading overlay after page load
                setTimeout(() => {
                    $(CONFIG.selectors.loadingOverlay).removeClass(CONFIG.classes.show);
                }, 500);

                console.log('✅ All BCare modules initialized successfully!');
            }

            // Initialize all modules
            initializeModules();
        }

        // Start initialization
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => waitForjQuery(initWelcomeScripts));
        } else {
            waitForjQuery(initWelcomeScripts);
        }

        // Expose API
        window.bcareVehiclesForm = {
            regenerateCaptcha: () => {
                waitForjQuery(($) => {
                    if (window.bcareVehiclesForm._captchaManager) {
                        window.bcareVehiclesForm._captchaManager.generate();
                    }
                });
            }
        };

        })(); // End IIFE
    </script>

</div>
@endsection
