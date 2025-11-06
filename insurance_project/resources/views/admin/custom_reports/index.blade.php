@extends('admin.layouts.app')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">التقارير المخصصة</h4>
                <div class="mr-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">التقارير المخصصة</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        {{-- إحصائيات سريعة --}}
        <div class="row">
            <div class="col-md-3">
                <div class="card border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{ $statistics['total_requests'] ?? 0 }}</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">إجمالي الطلبات</h6>
                            </div>
                            <div class="mr-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i data-feather="file-text"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <h2 class="text-warning mb-1 font-weight-medium">{{ $statistics['pending_requests'] ?? 0 }}</h2>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">طلبات قيد الانتظار</h6>
                            </div>
                            <div class="mr-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i data-feather="clock"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <h2 class="text-success mb-1 font-weight-medium">{{ $statistics['completed_requests'] ?? 0 }}</h2>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">طلبات مكتملة</h6>
                            </div>
                            <div class="mr-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i data-feather="check-circle"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <h2 class="text-info mb-1 font-weight-medium">{{ number_format($statistics['total_revenue'] ?? 0, 2) }}</h2>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">إجمالي الإيرادات (ريال)</h6>
                            </div>
                            <div class="mr-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i data-feather="dollar-sign"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- الجدول الرئيسي --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info">
                        <h4 class="mb-0 text-white">جميع الطلبات - عرض تفصيلي</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="customReportsTable" class="table table-striped table-bordered table-hover nowrap" style="width:100%">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم الكامل</th>
                                        <th>رقم الهوية</th>
                                        <th>تاريخ الميلاد</th>
                                        <th>رقم الجوال</th>
                                        <th>المنطقة</th>
                                        <th>تفاصيل الدفع</th>
                                        <th>نوع التأمين</th>
                                        <th>فئة الاستخدام</th>
                                        <th>المبلغ الإجمالي</th>
                                        <th>الحالة</th>
                                        <th>اسم حامل البطاقة</th>
                                        <th>تاريخ الطلب</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($reports as $index => $report)
                                        <tr class="report-row" data-id="{{ $report->id }}">
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <strong>{{ $report->full_name ?? 'غير محدد' }}</strong>
                                            </td>
                                            <td>{{ $report->identity_number ?? '-' }}</td>
                                            <td>{{ $report->birth_date_statements ?? '-' }}</td>
                                            <td>
                                                <a href="tel:{{ $report->mobile_number_statements }}">
                                                    {{ $report->mobile_number_statements ?? '-' }}
                                                </a>
                                            </td>
                                            <td>{{ $report->region ?? '-' }}</td>
                                            <td>
                                                <div class="payment-info">
                                                    <strong>{{ $report->name_on_card ?? '-' }}</strong><br>
                                                    <small>البطاقة: **** {{ isset($report->card_number) ? substr($report->card_number, -4) : '****' }}</small><br>
                                                    <small class="text-muted">الانتهاء: {{ $report->expiry_date ?? '-' }}</small><br>
                                                    <small class="text-success">المبلغ: {{ number_format($report->total ?? 0, 2) }} ر.س</small>
                                                </div>
                                            </td>
                                            <td>
                                                @if($report->insurance)
                                                    <span class="badge badge-info">{{ $report->insurance->insurance_name }}</span>
                                                @else
                                                    <span class="badge badge-secondary">غير محدد</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-warning">{{ $report->usage_category ?? '-' }}</span>
                                            </td>
                                            <td>
                                                <strong class="text-success">{{ number_format($report->total ?? 0, 2) }} ر.س</strong>
                                            </td>
                                            <td>
                                                <div class="status-badge" data-user-id="{{ $report->id }}" data-device-id="{{ $report->device_id ?? '' }}">
                                                    <span class="badge badge-secondary status-text">
                                                        <i class="fas fa-circle pulse-dot"></i> جاري التحقق...
                                                    </span>
                                                    <small class="d-block mt-1 last-seen-text text-muted" style="font-size: 10px;"></small>
                                                </div>
                                            </td>
                                            <td>{{ $report->name_on_card ?? '-' }}</td>
                                            <td>
                                                <small>{{ $report->created_at ? $report->created_at->format('Y-m-d H:i') : '-' }}</small>
                                            </td>
                                            <td>
                                                <a href="{{ route('super_admin.custom_reports-show', $report->id) }}" 
                                                   class="btn btn-sm btn-info btn-view-details"
                                                   title="عرض التفاصيل">
                                                    <i class="fas fa-eye"></i> عرض
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="14" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                                لا توجد تقارير متاحة حالياً
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
        // تفعيل DataTables مع الإعدادات العربية
        $('#customReportsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json'
            },
            pageLength: 25,
            order: [[12, 'desc']], // ترتيب حسب تاريخ الطلب (العمود 13)
            columnDefs: [
                { orderable: false, targets: [6, 13] }, // عمود تفاصيل الدفع والإجراءات غير قابل للترتيب
                { width: '180px', targets: [6] } // عرض عمود تفاصيل الدفع
            ],
            scrollX: true, // تمكين التمرير الأفقي
            scrollY: '600px', // ارتفاع الجدول
            scrollCollapse: true,
            fixedColumns: {
                leftColumns: 2 // تثبيت أول عمودين
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> تصدير Excel',
                    className: 'btn btn-success btn-sm',
                    exportOptions: {
                        columns: ':not(:last-child)' // جميع الأعمدة ماعدا الأخير
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i> تصدير PDF',
                    className: 'btn btn-danger btn-sm',
                    orientation: 'landscape',
                    pageSize: 'A3',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> طباعة',
                    className: 'btn btn-info btn-sm',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'colvis',
                    text: '<i class="fas fa-columns"></i> إظهار/إخفاء الأعمدة',
                    className: 'btn btn-secondary btn-sm'
                }
            ]
        });

        // عند الضغط على أي صف (باستثناء زر الإجراءات)
        $('#customReportsTable tbody').on('click', 'tr.report-row', function(e) {
            // إذا لم يكن الضغط على زر الإجراءات
            if (!$(e.target).closest('.btn-view-details').length) {
                const reportId = $(this).data('id');
                if (reportId) {
                    window.location.href = "{{ route('super_admin.custom_reports-show', '') }}/" + reportId;
                }
            }
        });

        // إضافة تأثير hover للصفوف
        $('#customReportsTable tbody tr.report-row').hover(
            function() {
                $(this).css('cursor', 'pointer');
                $(this).addClass('table-active');
            },
            function() {
                $(this).removeClass('table-active');
            }
        );

        // تحديث الإحصائيات كل دقيقة
        setInterval(function() {
            $.ajax({
                url: "{{ route('super_admin.custom_reports-summary') }}",
                method: 'GET',
                success: function(data) {
                    console.log('Statistics updated:', data);
                    // يمكن تحديث الإحصائيات بدون إعادة تحميل الصفحة
                },
                error: function(xhr, status, error) {
                    console.error('Error updating statistics:', error);
                }
            });
        }, 60000); // كل دقيقة

        // تحديث حالة المستخدمين في الوقت الفعلي
        function updateUserStatuses() {
            $('.status-badge').each(function() {
                const $badge = $(this);
                const userId = $badge.data('user-id');
                const deviceId = $badge.data('device-id');
                
                // محاكاة التحقق من حالة المستخدم
                // في الواقع، ستكون هذه مكالمة AJAX لـ API
                const isOnline = Math.random() > 0.7; // 30% احتمال أن يكون نشط
                const lastSeen = new Date(Date.now() - Math.random() * 3600000); // آخر ظهور خلال الساعة الماضية
                
                const $statusText = $badge.find('.status-text');
                const $lastSeenText = $badge.find('.last-seen-text');
                
                if (isOnline) {
                    $statusText.removeClass('badge-secondary badge-danger')
                              .addClass('badge-success')
                              .html('<i class="fas fa-circle pulse-dot"></i> نشط الآن');
                    $lastSeenText.text('متصل').removeClass('text-muted').addClass('text-success');
                } else {
                    const minutesAgo = Math.floor((Date.now() - lastSeen) / 60000);
                    if (minutesAgo < 5) {
                        $statusText.removeClass('badge-secondary badge-danger')
                                  .addClass('badge-warning')
                                  .html('<i class="fas fa-circle"></i> كان نشطاً');
                        $lastSeenText.text('منذ ' + minutesAgo + ' دقائق').removeClass('text-success').addClass('text-warning');
                    } else {
                        $statusText.removeClass('badge-secondary badge-warning')
                                  .addClass('badge-danger')
                                  .html('<i class="fas fa-circle"></i> غير نشط');
                        $lastSeenText.text('آخر ظهور: منذ ' + minutesAgo + ' دقيقة').removeClass('text-success text-warning').addClass('text-muted');
                    }
                }
            });
        }

        // تحديث الحالات عند تحميل الصفحة
        setTimeout(updateUserStatuses, 1000);
        
        // تحديث الحالات كل 10 ثواني
        setInterval(updateUserStatuses, 10000);
    });
</script>
@endsection

@push('styles')
<style>
    .report-row:hover {
        background-color: #f8f9fa !important;
        transition: background-color 0.2s ease;
    }

    .card-header.bg-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }

    .badge {
        padding: 5px 10px;
        font-size: 12px;
    }

    /* أزرار DataTables */
    .dt-buttons {
        margin-bottom: 15px;
    }

    .dt-button {
        margin-left: 5px !important;
    }

    /* جدول بعرض كامل */
    #customReportsTable {
        font-size: 14px;
        white-space: nowrap;
        table-layout: fixed;
        width: 100% !important;
    }

    #customReportsTable th,
    #customReportsTable td {
        padding: 12px 15px;
        vertical-align: middle;
    }

    /* تعريض الأعمدة */
    #customReportsTable th:nth-child(1) { width: 50px; }  /* # */
    #customReportsTable th:nth-child(2) { width: 180px; } /* الاسم */
    #customReportsTable th:nth-child(3) { width: 120px; } /* الهوية */
    #customReportsTable th:nth-child(4) { width: 110px; } /* الميلاد */
    #customReportsTable th:nth-child(5) { width: 120px; } /* الجوال */
    #customReportsTable th:nth-child(6) { width: 100px; } /* المنطقة */
    #customReportsTable th:nth-child(7) { width: 120px; } /* المدينة */
    #customReportsTable th:nth-child(8) { width: 100px; } /* نوع المركبة */
    #customReportsTable th:nth-child(9) { width: 120px; } /* موديل */
    #customReportsTable th:nth-child(10) { width: 90px; } /* سنة الصنع */
    #customReportsTable th:nth-child(11) { width: 140px; } /* نوع التأمين */
    #customReportsTable th:nth-child(12) { width: 110px; } /* فئة الاستخدام */
    #customReportsTable th:nth-child(13) { width: 130px; } /* المبلغ */
    #customReportsTable th:nth-child(14) { width: 110px; } /* تاريخ البدء */
    #customReportsTable th:nth-child(15) { width: 150px; } /* حامل البطاقة */
    #customReportsTable th:nth-child(16) { width: 140px; } /* تاريخ الطلب */
    #customReportsTable th:nth-child(17) { width: 100px; } /* الإجراءات */

    /* تحسين عرض الجدول */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* تثبيت رأس الجدول عند التمرير */
    .dataTables_scrollHead {
        overflow: visible !important;
    }

    /* تحسين عرض الأعمدة المثبتة */
    .DTFC_LeftBodyLiner {
        overflow: visible !important;
    }

    /* رابط الجوال */
    a[href^="tel:"] {
        color: #007bff;
        text-decoration: none;
    }

    a[href^="tel:"]:hover {
        text-decoration: underline;
    }

    /* عمود تفاصيل الدفع */
    .payment-info {
        line-height: 1.6;
        min-width: 180px;
    }

    .payment-info strong {
        color: #2c3e50;
        font-size: 13px;
    }

    .payment-info small {
        display: block;
        font-size: 11px;
        margin-top: 2px;
    }

    .payment-info .text-muted {
        color: #6c757d !important;
    }

    .payment-info .text-success {
        color: #28a745 !important;
        font-weight: 600;
    }

    /* حالة المستخدم */
    .status-badge {
        text-align: center;
    }

    .status-badge .badge {
        font-size: 11px;
        padding: 6px 10px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-badge .badge-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
    }

    .status-badge .badge-warning {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        box-shadow: 0 2px 4px rgba(255, 193, 7, 0.3);
    }

    .status-badge .badge-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
    }

    /* نقطة النبض للمستخدمين النشطين */
    .pulse-dot {
        animation: pulse 1.5s infinite;
        font-size: 8px;
        margin-left: 3px;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }

    .last-seen-text {
        font-size: 10px;
        margin-top: 4px;
        display: block;
    }

    .text-warning {
        color: #ffc107 !important;
    }
</style>
@endpush
