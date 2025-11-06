@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body text-center p-5">
                        {{-- أيقونة الانتظار --}}
                        <div class="mb-4">
                            <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
                                <span class="sr-only">جاري المعالجة...</span>
                            </div>
                        </div>

                        {{-- العنوان --}}
                        <h2 class="text-primary mb-4">
                            <i class="fas fa-clock"></i> طلبك قيد المراجعة
                        </h2>

                        {{-- الرسالة --}}
                        <div class="alert alert-info mb-4">
                            <h5 class="mb-3">شكراً لك على إتمام عملية الدفع!</h5>
                            <p class="mb-2">تم استلام طلبك بنجاح وهو الآن قيد المراجعة من قبل فريقنا.</p>
                            <p class="mb-0">سيتم الموافقة على طلبك وإتمام العملية في أقرب وقت ممكن.</p>
                        </div>

                        {{-- معلومات الطلب --}}
                        <div class="row text-start mb-4">
                            <div class="col-md-6">
                                <div class="info-box p-3 mb-3 bg-light rounded">
                                    <h6 class="text-muted mb-2">
                                        <i class="fas fa-user"></i> اسم العميل
                                    </h6>
                                    <p class="mb-0 fw-bold">{{ $allFormData['full_name'] ?? 'غير محدد' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box p-3 mb-3 bg-light rounded">
                                    <h6 class="text-muted mb-2">
                                        <i class="fas fa-phone"></i> رقم الجوال
                                    </h6>
                                    <p class="mb-0 fw-bold">{{ $allFormData['mobile_number_statements'] ?? 'غير محدد' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box p-3 mb-3 bg-light rounded">
                                    <h6 class="text-muted mb-2">
                                        <i class="fas fa-shield-alt"></i> نوع التأمين
                                    </h6>
                                    <p class="mb-0 fw-bold">{{ $insurance->insurance_name ?? 'غير محدد' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box p-3 mb-3 bg-light rounded">
                                    <h6 class="text-muted mb-2">
                                        <i class="fas fa-money-bill-wave"></i> المبلغ الإجمالي
                                    </h6>
                                    <p class="mb-0 fw-bold text-success">{{ number_format($allFormData['total'] ?? 0, 2) }} ريال</p>
                                </div>
                            </div>
                        </div>

                        {{-- رقم الطلب --}}
                        <div class="alert alert-secondary">
                            <strong>رقم الطلب:</strong> #{{ $allFormData['id'] ?? 'N/A' }}
                        </div>

                        {{-- خطوات المعالجة --}}
                        <div class="process-steps mt-5">
                            <h5 class="mb-4">خطوات معالجة طلبك</h5>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="step-box p-3 bg-success text-white rounded">
                                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                                        <h6>1. تم استلام الطلب</h6>
                                        <small>تم بنجاح ✓</small>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="step-box p-3 bg-warning text-white rounded">
                                        <i class="fas fa-hourglass-half fa-2x mb-2"></i>
                                        <h6>2. قيد المراجعة</h6>
                                        <small>جاري المعالجة...</small>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="step-box p-3 bg-secondary text-white rounded">
                                        <i class="fas fa-clipboard-check fa-2x mb-2"></i>
                                        <h6>3. الموافقة النهائية</h6>
                                        <small>قريباً...</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ملاحظة --}}
                        <div class="mt-4">
                            <p class="text-muted">
                                <i class="fas fa-info-circle"></i> 
                                ستصلك رسالة نصية وبريد إلكتروني فور الموافقة على طلبك
                            </p>
                        </div>

                        {{-- زر التحديث --}}
                        <button type="button" class="btn btn-primary btn-lg mt-3" onclick="location.reload()">
                            <i class="fas fa-sync-alt"></i> تحديث الحالة
                        </button>

                        {{-- زر العودة للرئيسية --}}
                        <a href="{{ route('welcome') }}" class="btn btn-outline-secondary btn-lg mt-2">
                            <i class="fas fa-home"></i> العودة للصفحة الرئيسية
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .info-box {
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .info-box:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .step-box {
            min-height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: all 0.3s ease;
        }

        .step-box:hover {
            transform: scale(1.05);
        }

        .spinner-border {
            animation: spinner-border 0.75s linear infinite;
        }

        @keyframes spinner-border {
            to { transform: rotate(360deg); }
        }

        .card {
            border-radius: 15px;
        }
    </style>

    <script>
        // تحديث الصفحة تلقائياً كل 30 ثانية للتحقق من الموافقة
        setTimeout(function() {
            checkApprovalStatus();
        }, 30000);

        function checkApprovalStatus() {
            // يمكنك إضافة AJAX هنا للتحقق من حالة الموافقة
            fetch('{{ route("check-approval-status", $allFormData["id"] ?? 0) }}')
                .then(response => response.json())
                .then(data => {
                    if (data.approved) {
                        // إعادة التوجيه للصفحة المطلوبة
                        window.location.href = data.redirect_url;
                    } else {
                        // إعادة التحقق بعد 30 ثانية
                        setTimeout(checkApprovalStatus, 30000);
                    }
                })
                .catch(error => {
                    console.log('Error checking status:', error);
                    setTimeout(checkApprovalStatus, 30000);
                });
        }
    </script>
@endsection
