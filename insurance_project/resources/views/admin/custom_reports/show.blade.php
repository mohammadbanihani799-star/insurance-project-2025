@extends('admin.layouts.app')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">تفاصيل الطلب</h4>
                <div class="mr-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">الرئيسية</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.custom_reports-index') }}">التقارير المخصصة</a></li>
                            <li class="breadcrumb-item active" aria-current="page">تفاصيل الطلب #{{ $report->id }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            {{-- معلومات العميل --}}
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-user"></i> معلومات العميل</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th width="40%">الاسم الكامل:</th>
                                    <td><strong>{{ $report->full_name ?? 'غير محدد' }}</strong></td>
                                </tr>
                                <tr>
                                    <th>رقم الهوية:</th>
                                    <td>{{ $report->identity_number ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>رقم الجوال:</th>
                                    <td>
                                        <a href="tel:{{ $report->mobile_number_statements }}">
                                            {{ $report->mobile_number_statements ?? '-' }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>تاريخ الميلاد:</th>
                                    <td>{{ $report->birth_date_statements ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>المنطقة:</th>
                                    <td>{{ $report->region ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>المدينة:</th>
                                    <td>{{ $report->city ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>سنوات القيادة:</th>
                                    <td>{{ $report->driving_years ?? '-' }} سنة</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- معلومات المركبة --}}
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="fas fa-car"></i> معلومات المركبة</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th width="40%">نوع المركبة:</th>
                                    <td>{{ $report->vehicle_type ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>موديل المركبة:</th>
                                    <td>{{ $report->vehicle_model ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>سنة الصنع:</th>
                                    <td>{{ $report->manufacturing_year ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>نوع الصيانة:</th>
                                    <td>{{ $report->maintenance_type ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>القيمة التقريبية:</th>
                                    <td><strong>{{ number_format($report->approximate_price ?? 0) }} ريال</strong></td>
                                </tr>
                                <tr>
                                    <th>فئة الاستخدام:</th>
                                    <td>{{ $report->usage_category ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- معلومات التأمين --}}
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0"><i class="fas fa-shield-alt"></i> معلومات التأمين</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th width="40%">نوع التأمين:</th>
                                    <td>
                                        @if($report->insurance)
                                            <span class="badge badge-info badge-lg">{{ $report->insurance->insurance_name }}</span>
                                        @else
                                            <span class="badge badge-secondary">غير محدد</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>فئة التأمين:</th>
                                    <td>{{ $report->insurance_category ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>نوع التأمين المطلوب:</th>
                                    <td>{{ $report->insurance_type ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>تاريخ بدء الوثيقة:</th>
                                    <td><strong>{{ $report->policy_start_date ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <th>المبلغ الإجمالي:</th>
                                    <td>
                                        <h3 class="text-success mb-0">{{ number_format($report->total ?? 0, 2) }} ريال</h3>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- معلومات الدفع --}}
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h4 class="mb-0"><i class="fas fa-credit-card"></i> معلومات الدفع</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th width="40%">اسم حامل البطاقة:</th>
                                    <td>{{ $report->name_on_card ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>رقم البطاقة:</th>
                                    <td>
                                        @if($report->card_number)
                                            **** **** **** {{ substr($report->card_number, -4) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>تاريخ الانتهاء:</th>
                                    <td>{{ $report->expiry_date ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- معلومات السائق الإضافي --}}
            @if($report->has_additional_driver === 'yes')
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="mb-0"><i class="fas fa-user-plus"></i> معلومات السائق الإضافي</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>اسم السائق:</strong><br>
                                {{ $report->driver_name ?? '-' }}
                            </div>
                            <div class="col-md-3">
                                <strong>رقم الهوية:</strong><br>
                                {{ $report->driver_identity_number ?? '-' }}
                            </div>
                            <div class="col-md-3">
                                <strong>رقم الجوال:</strong><br>
                                {{ $report->driver_mobile_number ?? '-' }}
                            </div>
                            <div class="col-md-3">
                                <strong>تاريخ الميلاد:</strong><br>
                                {{ $report->driver_birth_date ?? '-' }}
                            </div>
                            <div class="col-md-6 mt-3">
                                <strong>سنوات القيادة:</strong><br>
                                {{ $report->driver_driving_years ?? '-' }}
                            </div>
                            <div class="col-md-6 mt-3">
                                <strong>نسبة القيادة:</strong><br>
                                {{ $report->driver_driving_percentage ?? '-' }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- معلومات إضافية --}}
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0"><i class="fas fa-info-circle"></i> معلومات إضافية</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <strong>رقم الطلب:</strong><br>
                                <span class="badge badge-primary badge-lg">#{{ $report->id }}</span>
                            </div>
                            <div class="col-md-4">
                                <strong>تاريخ الإنشاء:</strong><br>
                                {{ $report->created_at ? $report->created_at->format('Y-m-d H:i:s') : '-' }}
                            </div>
                            <div class="col-md-4">
                                <strong>آخر تحديث:</strong><br>
                                {{ $report->updated_at ? $report->updated_at->format('Y-m-d H:i:s') : '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- أزرار الإجراءات --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{ route('super_admin.custom_reports-index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-right"></i> العودة للقائمة
                        </a>
                        <button onclick="window.print()" class="btn btn-info btn-lg">
                            <i class="fas fa-print"></i> طباعة
                        </button>
                        <button onclick="exportToPDF()" class="btn btn-danger btn-lg">
                            <i class="fas fa-file-pdf"></i> تصدير PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .badge-lg {
        font-size: 14px;
        padding: 8px 12px;
    }
    
    .card-header h4 {
        font-size: 18px;
    }
    
    .table th {
        font-weight: 600;
        color: #666;
    }
    
    @media print {
        .page-breadcrumb,
        .card:last-child {
            display: none !important;
        }
    }
</style>
@endpush

@section('extra_js')
<script>
    function exportToPDF() {
        alert('ميزة تصدير PDF قيد التطوير');
        // يمكن تطبيق تصدير PDF باستخدام مكتبة jsPDF أو من الخادم
    }
</script>
@endsection
