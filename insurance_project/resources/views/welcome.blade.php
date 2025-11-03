@extends('layouts.app')

@section('content')
<!-- slider -->
<section class="slider">
    <ul class="heroSlider">
        {{-- <li>
            <div class="slideImage">
                <img src="{{ asset('style_files/frontend/img/slider/1.webp') }}" alt="slide1">
            </div>
            <div class="slideText">
                <h2 class="slideTitle">تأمين المنازل</h2>
                <p>هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل
                    الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها
                    تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي، هنا يوجد محتوى نصي</p>
                <a href="#">
                    <i class="bi bi-arrow-left"></i>
                    اقرأ المزيد
                </a>
            </div>
        </li> --}}
        <li>
            <div class="slideImage">
                <img src="{{ asset('/style_files/frontend/img/slider/slider_end.png') }}" alt="slide2">
            </div> 
            <div class="slideText">
                {{-- <h2 class="slideTitle">تأمين المركبات</h2> --}}
                {{-- <p>هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل
                    الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها
                    تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي، هنا يوجد محتوى نصي</p>
                <a href="#">
                    <i class="bi bi-arrow-left"></i>
                    اقرأ المزيد
                </a> --}}
            </div>
        </li>
        {{-- <li>
            <div class="slideImage">
                <img src="{{ asset('style_files/frontend/img/slider/3.webp') }}" alt="slide3">
            </div>
            <div class="slideText">
                <h2 class="slideTitle">التأمين الطبي</h2>
                <p>هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل
                    الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها
                    تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي، هنا يوجد محتوى نصي</p>
                <a href="#">
                    <i class="bi bi-arrow-left"></i>
                    اقرأ المزيد
                </a>
            </div>
        </li> --}}
    </ul>
</section>

<!-- forms tabs -->
<section class="formTabs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tabs">
                    <ul class="tab-links">
                        <li>
                            <a href="#tab1" class="tab-a-link active">
                                <div class="image">
                                    <img src="{{ asset('style_files/frontend/img/tabs/1.png') }}" alt="tab1">
                                </div>
                                <span>مركبات</span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <div class="image">
                                    <img src="{{ asset('style_files/frontend/img/tabs/2.png') }}" alt="tab2">
                                </div>
                                <span>طبي</span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <div class="image">
                                    <img src="{{ asset('style_files/frontend/img/tabs/3.png') }}" alt="tab3">
                                </div>
                                <span>سفر</span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <div class="image">
                                    <img src="{{ asset('style_files/frontend/img/tabs/4.png') }}" alt="tab4">
                                </div>
                                <span>أخطاء طبية</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="tab1">
                        <div class="nested-tabs">
                            <ul class="tab-links-nested">
                                <li><a href="#subtab1" class="active">تأمين جديد</a></li>
                                <li><a href="#subtab2">نقل ملكية</a></li>
                            </ul>
                            <div class="tab-content-nested" id="subtab1">
                                <div class="nested-tabs">
                                    <ul class="tab-links-nested-child">
                                        <li><a href="#subtab-child1" class="active">الرقم التسلسلي</a></li>
                                        <li><a href="#subtab-child2">بطاقة جمركية [استيراد]</a></li>
                                    </ul>

                                    {{-- تأمين جديد (الرقم التسلسلي) --}}
                                    <div class="tab-content-nested-child" id="subtab-child1">
                                        <form action="{{ route('insuranceRequest') }}" method="POST" id="captcha-form-1"
                                            class="form captcha-form">
                                            @csrf

                                            <input type="hidden" name="insurance_category" value="1">
                                            {{-- تأمين جديد --}}
                                            <input type="hidden" name="new_insurance_category" value="1">
                                            {{-- الرقم التسلسلي --}}

                                            <div class="row mt-3">
                                                <div class="col-12 mb-3">
                                                    <h2>تأمين جديد (الرقم التسلسلي)</h2>
                                                </div>

                                                {{-- identity_number --}}
                                                <div class="col-md-6 mb-3">
                                                    <div class="inputGroup">
                                                        <label for="idNumber">رقم الهوية
                                                            <strong class="text-danger">
                                                                @error('identity_number')
                                                                ( {{ $message }} )
                                                                @enderror
                                                            </strong>
                                                        </label>

                                                        <input type="number" class="form-control" id="idNumber"
                                                            name="identity_number" value="{{ old('identity_number') }}"
                                                            placeholder="رقم الهوية الوطنية أو الإقامة أو الشركة"
                                                            required  maxlength="11" oninput="checkLength(this)">
                                                    </div>
                                                </div>

                                                {{-- applicant_name --}}
                                                <div class="col-md-6 mb-3">
                                                    <div class="inputGroup">
                                                        <label for="name">إسم مقدم الطلب
                                                            <strong class="text-danger">
                                                                @error('applicant_name')
                                                                ( {{ $message }} )
                                                                @enderror
                                                            </strong>
                                                        </label>
                                                        <input type="text" class="form-control" id="name"
                                                            value="{{ old('applicant_name') }}" name="applicant_name"
                                                            placeholder="إسم مقدم الطلب" required>
                                                    </div>
                                                </div>

                                                {{-- phone --}}
                                                <div class="col-md-6 mb-3">
                                                    <div class="inputGroup">
                                                        <label for="text">رقم الهاتف
                                                            <strong class="text-danger">
                                                                @error('phone')
                                                                ( {{ $message }} )
                                                                @enderror
                                                            </strong>
                                                        </label>
                                                        <input type="tel" class="form-control text-right" id="phone"
                                                            name="phone" value="{{ old('phone') }}"
                                                            placeholder="5xxxxxxxx" required max="10" maxlength="10">
                                                    </div>
                                                </div>

                                                {{-- date_of_birth --}}
                                                <div class="col-md-6 mb-3">
                                                    <div class="inputGroup">
                                                        <label for="bDate">تاريخ الميلاد
                                                            <strong class="text-danger">
                                                                @error('date_of_birth')
                                                                ( {{ $message }} )
                                                                @enderror
                                                            </strong>
                                                        </label>
                                                        <input type="date" class="form-control text-right" id="bDate"
                                                            name="date_of_birth" value="{{ old('date_of_birth') }}"
                                                            required>
                                                    </div>
                                                </div>

                                                {{-- captcha --}}
                                                <div class="col-md-6 mb-3">
                                                    <div class="inputGroup">
                                                        <div class=" d-flex align-items-center">
                                                            <canvas class="captcha" width="200" height="80"></canvas>
                                                            <button type="button"
                                                                class="btn btn-secondary refresh-captcha">
                                                                <i class="fa fa-refresh"></i>
                                                            </button>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="captcha-input-1" class="form-label">
                                                                رمز التحقق
                                                            </label>
                                                            <input type="text" maxlength="4" class="form-control captcha-input"
                                                                id="captcha-input-1" placeholder="ادخل رمز التحقق"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <input type="checkbox" id="accept2" name="accept2"
                                                        value="{{ old('accept') }}" required>
                                                    <label for="accept2" class="lable">أوافق على منح شركة عناية
                                                        الوسيط الحق في الإستعلام من شركة نجم و/أو مركز المعلومات الوطني
                                                        عن بياناتي</label>
                                                </div>

                                                {{-- Button --}}
                                                <div class="col-md-12">
                                                    <input type="submit" id="submit" class="submit"
                                                        value="إظهار العروض">
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- تأمين جديد (بطاقة جمركية [استيراد]) --}}
                                    <div class="tab-content-nested-child" id="subtab-child2">
                                        <form action="#" class="form captcha-form">
                                            {{-- @csrf --}}
                                            <div class="row mt-3">
                                                <div class="col-12 mb-3">
                                                    <h2>تأمين جديد (بطاقة جمركية [استيراد])</h2>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="inputGroup">
                                                        <label for="idNumber">رقم الهوية</label>
                                                        <input type="text" class="form-control" id="idNumber"
                                                            name="idNumber"
                                                            placeholder="رقم الهوية الوطنية أو الإقامة أو الشركة">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="inputGroup">
                                                        <label for="name">إسم مقدم الطلب</label>
                                                        <input type="text" class="form-control" id="name" name="name"
                                                            placeholder="إسم مقدم الطلب">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="inputGroup">
                                                        <label for="phone">رقم الهاتف</label>
                                                        <input type="tel" class="form-control text-right" id="phone"
                                                            name="phone" placeholder="5xxxxxxxx">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="inputGroup">
                                                        <label for="bDate">تاريخ الميلاد</label>
                                                        <input type="date" class="form-control text-right" id="bDate"
                                                            name="bDate" placeholder="5xxxxxxxx">
                                                    </div>
                                                </div>
                                                {{-- captcha --}}
                                                <div class="col-md-6 mb-3">
                                                    <div class="inputGroup">
                                                        <div class=" d-flex align-items-center">
                                                            <canvas class="captcha" width="200" height="80"></canvas>
                                                            <button type="button"
                                                                class="btn btn-secondary refresh-captcha">
                                                                <i class="fa fa-refresh"></i>
                                                            </button>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="captcha-input-2" class="form-label">
                                                                رمز التحقق
                                                            </label>
                                                            <input type="text" maxlength="4" class="form-control captcha-input"
                                                                id="captcha-input-2" placeholder="ادخل رمز التحقق"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <input type="checkbox" id="accept3" name="accept3" required>
                                                    <label for="accept3" class="lable">أوافق على منح شركة عناية
                                                        الوسيط الحق في الإستعلام من شركة نجم و/أو مركز المعلومات الوطني
                                                        عن بياناتي</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <input type="submit" id="submit" class="submit"
                                                        value="إظهار العروض">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- نقل ملكية --}}
                            <div class="tab-content-nested" id="subtab2">
                                <form action="{{ route('insuranceRequest') }}" method="POST" id="captcha-form-1"
                                class="form captcha-form">
                                @csrf

                                <input type="hidden" name="insurance_category" value="1">
                                {{-- تأمين جديد --}}
                                <input type="hidden" name="new_insurance_category" value="1">
                                {{-- الرقم التسلسلي --}}

                                <div class="row mt-3">
                                    <div class="col-12 mb-3">
                                        <h2>تأمين جديد (الرقم التسلسلي)</h2>
                                    </div>

                                    {{-- identity_number --}}
                                    <div class="col-md-6 mb-3">
                                        <div class="inputGroup">
                                            <label for="idNumber">رقم الهوية
                                                <strong class="text-danger">
                                                    @error('identity_number')
                                                    ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>

                                            <input type="number" class="form-control" id="idNumber"
                                                name="identity_number" value="{{ old('identity_number') }}"
                                                placeholder="رقم الهوية الوطنية أو الإقامة أو الشركة"
                                                required  maxlength="11" oninput="checkLength(this)">
                                        </div>
                                    </div>

                                    {{-- applicant_name --}}
                                    <div class="col-md-6 mb-3">
                                        <div class="inputGroup">
                                            <label for="name">إسم مقدم الطلب
                                                <strong class="text-danger">
                                                    @error('applicant_name')
                                                    ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                            <input type="text" class="form-control" id="name"
                                                value="{{ old('applicant_name') }}" name="applicant_name"
                                                placeholder="إسم مقدم الطلب" required>
                                        </div>
                                    </div>

                                    {{-- phone --}}
                                    <div class="col-md-6 mb-3">
                                        <div class="inputGroup">
                                            <label for="text">رقم الهاتف
                                                <strong class="text-danger">
                                                    @error('phone')
                                                    ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                            <input type="tel" class="form-control text-right" id="phone"
                                                name="phone" value="{{ old('phone') }}"
                                                placeholder="5xxxxxxxx" required max="10" maxlength="10">
                                        </div>
                                    </div>

                                    {{-- date_of_birth --}}
                                    <div class="col-md-6 mb-3">
                                        <div class="inputGroup">
                                            <label for="bDate">تاريخ الميلاد
                                                <strong class="text-danger">
                                                    @error('date_of_birth')
                                                    ( {{ $message }} )
                                                    @enderror
                                                </strong>
                                            </label>
                                            <input type="date" class="form-control text-right" id="bDate"
                                                name="date_of_birth" value="{{ old('date_of_birth') }}"
                                                required>
                                        </div>
                                    </div>

                                    {{-- captcha --}}
                                    <div class="col-md-6 mb-3">
                                        <div class="inputGroup">
                                            <div class=" d-flex align-items-center">
                                                <canvas class="captcha" width="200" height="80"></canvas>
                                                <button type="button"
                                                    class="btn btn-secondary refresh-captcha">
                                                    <i class="fa fa-refresh"></i>
                                                </button>
                                            </div>

                                            <div class="mb-3">
                                                <label for="captcha-input-1" class="form-label">
                                                    رمز التحقق
                                                </label>
                                                <input type="text" maxlength="4" class="form-control captcha-input"
                                                    id="captcha-input-1"  placeholder="ادخل رمز التحقق"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <input type="checkbox" id="accept2" name="accept2"
                                            value="{{ old('accept') }}" required>
                                        <label for="accept2" class="lable">أوافق على منح شركة عناية
                                            الوسيط الحق في الإستعلام من شركة نجم و/أو مركز المعلومات الوطني
                                            عن بياناتي</label>
                                    </div>

                                    {{-- Button --}}
                                    <div class="col-md-12">
                                        <input type="submit" id="submit" class="submit"
                                            value="إظهار العروض">
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content" id="tab2">
                        <h2>قريبا...</h2>
                    </div>
                    <div class="tab-content" id="tab3">
                        <h2>قريبا...</h2>
                    </div>
                    <div class="tab-content" id="tab4">
                        <h2>قريبا...</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- why be care -->
<section class="whyBeCare">
    <div class="container">
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
<section class="partners sectionPadding">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center heading">
                <h2 class="mb-4">شركاؤنا</h2>
                <p>نحن نؤمن بأهمية تعزيز العلاقات القوية التي تعود بالنفع على كلا الطرفين، مما يؤدي إلى الابتكار والنجاح
                    المتبادل.</p>
            </div>
        </div>
        <div class="row mt-5">
            <ul class="partnersSlider">
                <li>
                    <div class="partnerItem">
                        <img src="{{ asset('style_files/frontend/img/partner/1.png') }}" alt="partner1">
                    </div>
                </li>
                <li>
                    <div class="partnerItem">
                        <img src="{{ asset('style_files/frontend/img/partner/1.png') }}" alt="partner1">
                    </div>
                </li>
                <li>
                    <div class="partnerItem">
                        <img src="{{ asset('style_files/frontend/img/partner/1.png') }}" alt="partner1">
                    </div>
                </li>
                <li>
                    <div class="partnerItem">
                        <img src="{{ asset('style_files/frontend/img/partner/1.png') }}" alt="partner1">
                    </div>
                </li>
                <li>
                    <div class="partnerItem">
                        <img src="{{ asset('style_files/frontend/img/partner/1.png') }}" alt="partner1">
                    </div>
                </li>
                <li>
                    <div class="partnerItem">
                        <img src="{{ asset('style_files/frontend/img/partner/1.png') }}" alt="partner1">
                    </div>
                </li>
                <li>
                    <div class="partnerItem">
                        <img src="{{ asset('style_files/frontend/img/partner/1.png') }}" alt="partner1">
                    </div>
                </li>
                <li>
                    <div class="partnerItem">
                        <img src="{{ asset('style_files/frontend/img/partner/1.png') }}" alt="partner1">
                    </div>
                </li>
            </ul>
        </div>
    </div>
</section>

<!-- after form submit overlay -->
<div id="overlay">
    <div class="cv-spinner">
        <div class="spinnerContainer">
            <img src="{{ asset('style_files/frontend/img/logoInsurance.jpeg') }}" alt="">
            <span class="text-black mx-2">جاري التحميل ...</span>
            <span class="spinner"></span>
        </div>
    </div>
</div>

{{-- ========== All JavaScript handled by Vite in app.js ========== --}}
{{-- No inline scripts needed - everything is managed in resources/js/app.js --}}

<script>
    // صفحة مخصصة للـ welcome فقط - يتم تشغيلها بعد تحميل Vite
    document.addEventListener('DOMContentLoaded', function() {
        // تأكد من وجود jQuery قبل الاستخدام
        if (typeof window.jQuery === 'undefined') {
            console.error('jQuery غير محمّل! تحقق من app.js');
            return;
        }
        
        const $ = window.jQuery;
        
        // تهيئة التابات الرئيسية
        $(".tab-content:first").show();
        $(".tab-links .tab-a-link").click(function() {
            var tabId = $(this).attr("href");
            $(".tab-content").hide();
            $(".tab-links .tab-a-link").removeClass("active");
            $(this).addClass("active");
            $(tabId).show();
            return false;
        });

        // تهيئة التابات الفرعية
        $(".tab-content-nested:first").show();
        $(".tab-links-nested a").click(function() {
            var tabId = $(this).attr("href");
            $(".tab-content-nested").hide();
            $(".tab-links-nested a").removeClass("active");
            $(this).addClass("active");
            $(tabId).show();
            return false;
        });

        // تهيئة التابات الفرعية المتداخلة
        $(".tab-content-nested-child:first").show();
        $(".tab-links-nested-child a").click(function() {
            var tabId = $(this).attr("href");
            $(".tab-content-nested-child").hide();
            $(".tab-links-nested-child a").removeClass("active");
            $(this).addClass("active");
            $(tabId).show();
            return false;
        });

        // تهيئة الكابتشا
        function generateCaptcha(form) {
            var canvas = form.find(".captcha")[0];
            if (!canvas) return;
            
            var context = canvas.getContext("2d");
            var characters = "0123456789";
            var captchaCode = "";

            context.clearRect(0, 0, canvas.width, canvas.height);

            for (var i = 0; i < 4; i++) {
                var character = characters.charAt(Math.floor(Math.random() * characters.length));
                captchaCode += character;

                context.font = (20 + Math.random() * 10) + "px Arial";
                context.textAlign = "center";
                context.textBaseline = "middle";
                context.fillStyle = "rgb(" + Math.floor(Math.random() * 256) + "," + Math.floor(Math.random() * 256) + "," + Math.floor(Math.random() * 256) + ")";

                var angle = -45 + Math.random() * 90;
                context.translate(20 + i * 30, canvas.height / 2);
                context.rotate(angle * Math.PI / 180);
                context.fillText(character, 0, 0);
                context.rotate(-1 * angle * Math.PI / 180);
                context.translate(-(20 + i * 30), -1 * canvas.height / 2);
            }

            sessionStorage.setItem("captchaCode_" + form.attr("id"), captchaCode);
        }

        // تهيئة الكابتشا لكل النماذج
        $(".captcha-form").each(function() {
            generateCaptcha($(this));
        });

        // معالجة إرسال النماذج
        $(".captcha-form").on("submit", function(event) {
            // منطق التحقق من الكابتشا معطل مؤقتاً
        });

        // معالجة تحديث الكابتشا
        $(".refresh-captcha").on("click", function() {
            var form = $(this).closest("form");
            generateCaptcha(form);
            form.find(".captcha-input").val("");
        });

        // معالجة overlay التحميل
        $("#overlay").fadeIn(400).fadeOut(400);
        
        $(document).ajaxSend(function() {
            $("#overlay").fadeIn(300);
        });

        $('.submit').click(function() {
            $.ajax({
                type: 'GET',
                success: function(data) {
                    console.log(data);
                }
            }).done(function() {
                setTimeout(function() {
                    $("#overlay").fadeOut(300);
                }, 800);
            });
        });

        console.log('✅ Welcome page scripts initialized successfully!');
    });

    // دالة فحص طول النص
    function checkLength(input) {
        var maxLength = 10;
        if (input.value.length > maxLength) {
            input.value = input.value.slice(0, maxLength);
        }
    }
</script>


@endsection