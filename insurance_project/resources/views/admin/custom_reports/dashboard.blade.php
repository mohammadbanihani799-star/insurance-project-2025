@extends('admin.layouts.app')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">لوحة المعلومات المباشرة</h4>
                <div class="mr-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">لوحة المعلومات</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        {{-- إحصائيات سريعة --}}
        <div class="row">
            <div class="col-md-4">
                <div class="card border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <h2 class="text-success mb-1 font-weight-medium" id="usersOnlineCount">0</h2>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">المستخدمين المتصلين الآن</h6>
                            </div>
                            <div class="mr-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-success"><i data-feather="users" style="width: 48px; height: 48px;"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <h2 class="text-info mb-1 font-weight-medium" id="insurancesCount">{{ $insurances->count() }}</h2>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">عروض التأمين المتاحة</h6>
                            </div>
                            <div class="mr-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-info"><i data-feather="shield" style="width: 48px; height: 48px;"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <h2 class="text-primary mb-1 font-weight-medium" id="requestsCount">{{ $insuranceRequests->count() }}</h2>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">طلبات التأمين الجديدة</h6>
                            </div>
                            <div class="mr-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-primary"><i data-feather="file-text" style="width: 48px; height: 48px;"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- الجداول الثلاثة في صف واحد --}}
        <div class="row">
            {{-- Users Online --}}
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-circle live-indicator"></i>
                            المستخدمين المتصلين الآن
                        </h4>
                    </div>
                    <div class="card-body" style="height: 400px; overflow-y: auto;">
                        <div class="table-responsive">
                            <table id="usersOnlineTable" class="table table-hover table-sm">
                                <thead class="bg-light">
                                    <tr>
                                        <th>الجهاز</th>
                                        <th>الموقع</th>
                                        <th>آخر نشاط</th>
                                    </tr>
                                </thead>
                                <tbody id="usersOnlineBody">
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            <i class="fas fa-spinner fa-spin fa-2x mb-2"></i>
                                            <p>جاري التحميل...</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Insurances --}}
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-shield-alt"></i>
                            عروض التأمين
                        </h4>
                    </div>
                    <div class="card-body" style="height: 400px; overflow-y: auto;">
                        <div class="table-responsive">
                            <table id="insurancesTable" class="table table-hover table-sm">
                                <thead class="bg-light">
                                    <tr>
                                        <th>اسم التأمين</th>
                                        <th>السعر</th>
                                        <th>الحالة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($insurances as $insurance)
                                        <tr>
                                            <td>
                                                <strong>{{ $insurance->insurance_name }}</strong>
                                            </td>
                                            <td>
                                                <span class="text-success">{{ number_format($insurance->price ?? 0, 2) }} ر.س</span>
                                            </td>
                                            <td>
                                                @if($insurance->status == 'active')
                                                    <span class="badge badge-success">نشط</span>
                                                @else
                                                    <span class="badge badge-secondary">معطل</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">لا توجد عروض</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Insurance Requests Count --}}
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-file-alt"></i>
                            آخر الطلبات
                        </h4>
                    </div>
                    <div class="card-body" style="height: 400px; overflow-y: auto;">
                        <div class="table-responsive">
                            <table id="requestsTableSmall" class="table table-hover table-sm">
                                <thead class="bg-light">
                                    <tr>
                                        <th>الاسم</th>
                                        <th>الجوال</th>
                                        <th>الوقت</th>
                                    </tr>
                                </thead>
                                <tbody id="requestsBodySmall">
                                    @forelse($insuranceRequests->take(10) as $request)
                                        <tr class="request-row" data-id="{{ $request->id }}">
                                            <td>
                                                <strong>{{ Str::limit($request->full_name ?? 'غير محدد', 15) }}</strong>
                                            </td>
                                            <td>
                                                <small>{{ $request->mobile_number_statements ?? '-' }}</small>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $request->created_at ? $request->created_at->diffForHumans() : '-' }}</small>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">لا توجد طلبات</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- جدول طلبات التأمين الكامل - عرض الشاشة الكامل --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-gradient-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-table"></i>
                            طلبات التأمين - عرض تفصيلي شامل
                            <span class="badge badge-light text-primary mr-2" id="totalRequestsBadge">{{ $insuranceRequests->count() }}</span>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="requestsTableFull" class="table table-striped table-bordered table-hover" style="width:100%">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم الكامل</th>
                                        <th>رقم الهوية</th>
                                        <th>رقم الجوال</th>
                                        <th>المنطقة</th>
                                        <th>المدينة</th>
                                        <th>نوع المركبة</th>
                                        <th>موديل المركبة</th>
                                        <th>سنة الصنع</th>
                                        <th>نوع التأمين</th>
                                        <th>المبلغ الإجمالي</th>
                                        <th>تاريخ البدء</th>
                                        <th>تاريخ الطلب</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody id="requestsBodyFull">
                                    @forelse($insuranceRequests as $index => $request)
                                        <tr class="request-row-full" data-id="{{ $request->id }}">
                                            <td><strong>{{ $index + 1 }}</strong></td>
                                            <td>
                                                <strong class="text-primary">{{ $request->full_name ?? 'غير محدد' }}</strong>
                                            </td>
                                            <td>{{ $request->identity_number ?? '-' }}</td>
                                            <td>
                                                <a href="tel:{{ $request->mobile_number_statements }}" class="text-success">
                                                    <i class="fas fa-phone"></i>
                                                    {{ $request->mobile_number_statements ?? '-' }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $request->region ?? '-' }}</span>
                                            </td>
                                            <td>{{ $request->city ?? '-' }}</td>
                                            <td>
                                                <i class="fas fa-car"></i>
                                                {{ $request->vehicle_type ?? '-' }}
                                            </td>
                                            <td>{{ $request->vehicle_model ?? '-' }}</td>
                                            <td>
                                                <span class="badge badge-secondary">{{ $request->manufacturing_year ?? '-' }}</span>
                                            </td>
                                            <td>
                                                @if($request->insurance)
                                                    <span class="badge badge-success">{{ $request->insurance->insurance_name }}</span>
                                                @else
                                                    <span class="badge badge-warning">غير محدد</span>
                                                @endif
                                            </td>
                                            <td>
                                                <strong class="text-danger">{{ number_format($request->total ?? 0, 2) }} ر.س</strong>
                                            </td>
                                            <td>
                                                <small>{{ $request->policy_start_date ?? '-' }}</small>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $request->created_at ? $request->created_at->format('Y-m-d H:i') : '-' }}
                                                </small>
                                            </td>
                                            <td>
                                                <a href="{{ route('super_admin.custom_reports-show', $request->id) }}" 
                                                   class="btn btn-sm btn-info btn-view-details"
                                                   title="عرض التفاصيل">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="14" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                                لا توجد طلبات متاحة حالياً
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

@push('styles')
<style>
    .live-indicator {
        display: inline-block;
        width: 10px;
        height: 10px;
        background-color: #fff;
        border-radius: 50%;
        margin-left: 8px;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.5;
            transform: scale(1.2);
        }
    }

    .request-row,
    .request-row-full {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .request-row:hover,
    .request-row-full:hover {
        background-color: #f8f9fa !important;
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .card-body {
        padding: 15px;
    }

    .table-sm th,
    .table-sm td {
        padding: 8px;
        font-size: 13px;
    }

    .new-item-highlight {
        animation: highlightRow 2s ease-in-out;
        background-color: #d4edda !important;
    }
    
    @keyframes highlightRow {
        0% {
            background-color: #d4edda;
        }
        100% {
            background-color: transparent;
        }
    }

    /* تنسيق الجدول الكامل */
    #requestsTableFull {
        font-size: 13px;
    }

    #requestsTableFull th {
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        padding: 12px 8px;
        text-align: center;
    }

    #requestsTableFull td {
        padding: 10px 8px;
        vertical-align: middle;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }

    .badge {
        padding: 5px 10px;
        font-size: 11px;
        font-weight: 600;
    }

    /* DataTables customization */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 5px 10px;
        margin: 2px;
    }

    .dataTables_wrapper .dataTables_info {
        padding-top: 15px;
        font-size: 13px;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px 10px;
    }

    /* تحسين عرض البطاقات على الشاشات الصغيرة */
    @media (max-width: 768px) {
        .card-body {
            height: auto !important;
        }
        
        #requestsTableFull {
            font-size: 11px;
        }
        
        #requestsTableFull th,
        #requestsTableFull td {
            padding: 6px 4px;
        }
    }
</style>
@endpush

@section('extra_js')
<script>
    $(document).ready(function() {
        let lastRequestId = {{ $insuranceRequests->max('id') ?? 0 }};
        const REFRESH_INTERVAL = 3000; // 3 seconds

        // Fetch users online
        function fetchUsersOnline() {
            $.ajax({
                url: '{{ route("super_admin.visitors.summary") }}',
                method: 'GET',
                success: function(response) {
                    if (response.active_visitors) {
                        updateUsersOnline(response.active_visitors);
                        $('#usersOnlineCount').text(response.active_visitors.length);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching users online:', error);
                }
            });
        }

        // Update users online table
        function updateUsersOnline(visitors) {
            const tbody = $('#usersOnlineBody');
            tbody.empty();

            if (visitors.length === 0) {
                tbody.html(`
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">
                            <i class="fas fa-user-slash fa-2x mb-2"></i>
                            <p>لا يوجد مستخدمين متصلين حالياً</p>
                        </td>
                    </tr>
                `);
                return;
            }

            visitors.forEach(function(visitor) {
                const row = `
                    <tr>
                        <td>
                            <i class="fas fa-${getDeviceIcon(visitor.device_type)}"></i>
                            <small>${visitor.device_type || 'Unknown'}</small>
                        </td>
                        <td>
                            <small>${visitor.current_path || '/'}</small>
                        </td>
                        <td>
                            <small class="text-muted">${getTimeAgo(visitor.last_seen_at)}</small>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        // Get device icon
        function getDeviceIcon(deviceType) {
            if (!deviceType) return 'laptop';
            deviceType = deviceType.toLowerCase();
            if (deviceType.includes('mobile')) return 'mobile-alt';
            if (deviceType.includes('tablet')) return 'tablet-alt';
            return 'laptop';
        }

        // Get time ago
        function getTimeAgo(timestamp) {
            if (!timestamp) return 'الآن';
            const now = new Date();
            const date = new Date(timestamp);
            const seconds = Math.floor((now - date) / 1000);
            
            if (seconds < 60) return 'الآن';
            if (seconds < 3600) return Math.floor(seconds / 60) + ' دقيقة';
            if (seconds < 86400) return Math.floor(seconds / 3600) + ' ساعة';
            return Math.floor(seconds / 86400) + ' يوم';
        }

        // Fetch new insurance requests
        function fetchNewRequests() {
            $.ajax({
                url: '{{ route("super_admin.insurance_requests-getNewRequests") }}',
                method: 'GET',
                data: {
                    last_id: lastRequestId
                },
                success: function(response) {
                    if (response.success && response.count > 0) {
                        response.data.forEach(function(request) {
                            addNewRequest(request);
                        });
                        
                        lastRequestId = response.latest_id;
                        $('#requestsCount').text(parseInt($('#requestsCount').text()) + response.count);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching new requests:', error);
                }
            });
        }

        // Add new request to table
        function addNewRequest(request) {
            const newRow = `
                <tr class="request-row new-item-highlight" data-id="${request.id}">
                    <td>
                        <strong>${truncateString(request.full_name || 'غير محدد', 15)}</strong>
                    </td>
                    <td>
                        <small>${request.mobile_number_statements || '-'}</small>
                    </td>
                    <td>
                        <small class="text-muted">الآن</small>
                    </td>
                </tr>
            `;
            
            $('#requestsBody').prepend(newRow);
            
            // Keep only last 20 rows
            $('#requestsBody tr').slice(20).remove();
            
            // Remove highlight after animation
            setTimeout(function() {
                $(`tr[data-id="${request.id}"]`).removeClass('new-item-highlight');
            }, 2000);
        }

        // Truncate string
        function truncateString(str, length) {
            if (!str) return '';
            return str.length > length ? str.substring(0, length) + '...' : str;
        }

        // Click on request row (small tables)
        $(document).on('click', '.request-row', function() {
            const requestId = $(this).data('id');
            if (requestId) {
                window.location.href = "{{ route('super_admin.custom_reports-show', '') }}/" + requestId;
            }
        });

        // Click on request row (full table) - except buttons
        $(document).on('click', '.request-row-full', function(e) {
            // إذا لم يكن الضغط على زر الإجراءات
            if (!$(e.target).closest('.btn-view-details').length) {
                const requestId = $(this).data('id');
                if (requestId) {
                    window.location.href = "{{ route('super_admin.custom_reports-show', '') }}/" + requestId;
                }
            }
        });

        // Initialize DataTables for full requests table
        const requestsTableFull = $('#requestsTableFull').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json'
            },
            pageLength: 25,
            order: [[12, 'desc']], // ترتيب حسب تاريخ الطلب
            columnDefs: [
                { orderable: false, targets: [13] }, // عمود الإجراءات غير قابل للترتيب
                { className: 'text-center', targets: [0, 4, 8, 9, 10, 13] } // محاذاة للوسط
            ],
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> تصدير Excel',
                    className: 'btn btn-success btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i> تصدير PDF',
                    className: 'btn btn-danger btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> طباعة',
                    className: 'btn btn-info btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                    }
                },
                {
                    extend: 'copy',
                    text: '<i class="fas fa-copy"></i> نسخ',
                    className: 'btn btn-secondary btn-sm'
                }
            ],
            drawCallback: function() {
                // إضافة تأثير hover للصفوف بعد كل رسم
                $('.request-row-full').hover(
                    function() {
                        $(this).css('cursor', 'pointer');
                    }
                );
            }
        });

        // تحديث عدد الطلبات في الجدول الكامل عند إضافة طلب جديد
        function updateFullTableCount() {
            const info = requestsTableFull.page.info();
            $('#totalRequestsBadge').text(info.recordsTotal);
        }

        // تحديث الجدول الكامل عند إضافة طلب جديد
        function addRequestToFullTable(request) {
            // إضافة صف جديد للجدول
            requestsTableFull.row.add([
                requestsTableFull.data().count() + 1,
                `<strong class="text-primary">${request.full_name || 'غير محدد'}</strong>`,
                request.identity_number || '-',
                `<a href="tel:${request.mobile_number_statements}" class="text-success">
                    <i class="fas fa-phone"></i> ${request.mobile_number_statements || '-'}
                </a>`,
                `<span class="badge badge-info">${request.region || '-'}</span>`,
                request.city || '-',
                `<i class="fas fa-car"></i> ${request.vehicle_type || '-'}`,
                request.vehicle_model || '-',
                `<span class="badge badge-secondary">${request.manufacturing_year || '-'}</span>`,
                '<span class="badge badge-warning">غير محدد</span>',
                `<strong class="text-danger">${parseFloat(request.total || 0).toFixed(2)} ر.س</strong>`,
                request.policy_start_date || '-',
                `<small class="text-muted">الآن</small>`,
                `<a href="/super_admin/custom_reports/show/${request.id}" 
                   class="btn btn-sm btn-info btn-view-details" title="عرض التفاصيل">
                    <i class="fas fa-eye"></i>
                </a>`
            ]).draw(false);

            // تحديث العدد
            updateFullTableCount();
            
            // إضافة تأثير highlight للصف الجديد
            setTimeout(function() {
                const newRow = requestsTableFull.row(':last').node();
                $(newRow).addClass('new-item-highlight');
                setTimeout(function() {
                    $(newRow).removeClass('new-item-highlight');
                }, 2000);
            }, 100);
        }

        // تعديل fetchNewRequests لإضافة للجدول الكامل
        const originalFetchNewRequests = fetchNewRequests;
        fetchNewRequests = function() {
            $.ajax({
                url: '{{ route("super_admin.insurance_requests-getNewRequests") }}',
                method: 'GET',
                data: {
                    last_id: lastRequestId
                },
                success: function(response) {
                    if (response.success && response.count > 0) {
                        response.data.forEach(function(request) {
                            addNewRequest(request);
                            addRequestToFullTable(request);
                        });
                        
                        lastRequestId = response.latest_id;
                        $('#requestsCount').text(parseInt($('#requestsCount').text()) + response.count);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching new requests:', error);
                }
            });
        };

        // Initialize
        fetchUsersOnline();
        updateFullTableCount();
        
        // Start intervals
        setInterval(fetchUsersOnline, REFRESH_INTERVAL);
        setInterval(fetchNewRequests, REFRESH_INTERVAL);
        
        // Fetch immediately after 1 second
        setTimeout(fetchNewRequests, 1000);
    });
</script>
@endsection
