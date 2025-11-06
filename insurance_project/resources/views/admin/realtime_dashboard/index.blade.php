@extends('admin.layouts.app')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">
                    <i class="fas fa-satellite-dish text-danger pulse-animation"></i> 
                    لوحة التحكم المباشرة - Real-Time Dashboard
                </h4>
                <div class="mr-auto text-right">
                    <span class="badge badge-success badge-lg live-indicator">
                        <i class="fas fa-circle blink"></i> مباشر LIVE
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        {{-- إحصائيات سريعة --}}
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card bg-gradient-success text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon">
                                <i class="fas fa-users fa-3x"></i>
                            </div>
                            <div class="ml-auto text-right">
                                <h2 class="mb-0 text-white" id="activeUsersCount">0</h2>
                                <h6 class="text-white-50">مستخدمين نشطين الآن</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white-transparent text-center">
                        <small>تحديث كل 3 ثواني</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card bg-gradient-info text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon">
                                <i class="fas fa-file-alt fa-3x"></i>
                            </div>
                            <div class="ml-auto text-right">
                                <h2 class="mb-0 text-white" id="todayRequestsCount">0</h2>
                                <h6 class="text-white-50">طلبات اليوم</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white-transparent text-center">
                        <small>منذ منتصف الليل</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card bg-gradient-warning text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon">
                                <i class="fas fa-clock fa-3x"></i>
                            </div>
                            <div class="ml-auto text-right">
                                <h2 class="mb-0 text-white" id="pendingActionsCount">0</h2>
                                <h6 class="text-white-50">بانتظار الإجراء</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white-transparent text-center">
                        <small>يحتاجون موافقة</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card bg-gradient-danger text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon">
                                <i class="fas fa-dollar-sign fa-3x"></i>
                            </div>
                            <div class="ml-auto text-right">
                                <h2 class="mb-0 text-white" id="todayRevenueCount">0 ر.س</h2>
                                <h6 class="text-white-50">إيرادات اليوم</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white-transparent text-center">
                        <small>إجمالي المبيعات</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- الخريطة المباشرة للمستخدمين --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-map-marked-alt"></i> 
                                خريطة المستخدمين النشطين
                            </h4>
                            <div class="ml-auto">
                                <button class="btn btn-sm btn-light" onclick="refreshMap()">
                                    <i class="fas fa-sync-alt"></i> تحديث
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div id="userJourneyMap" style="height: 400px;">
                            {{-- سيتم رسم الخريطة هنا بـ JavaScript --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- جدول المستخدمين النشطين --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-users-cog"></i> 
                                المستخدمين النشطين الآن
                            </h4>
                            <div class="ml-auto">
                                <span class="badge badge-light badge-lg">
                                    آخر تحديث: <span id="lastUpdateTime">--:--:--</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="activeUsersTable" class="table table-hover table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="50">#</th>
                                        <th width="120">
                                            <i class="fas fa-circle text-success blink"></i> 
                                            الحالة
                                        </th>
                                        <th width="150">IP Address</th>
                                        <th>المسار الحالي</th>
                                        <th width="200">بيانات العميل</th>
                                        <th width="150">المدة</th>
                                        <th width="150">آخر نشاط</th>
                                        <th width="250">إجراءات سريعة</th>
                                    </tr>
                                </thead>
                                <tbody id="activeUsersBody">
                                    {{-- سيتم ملؤها بـ JavaScript --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- طلبات بانتظار الموافقة --}}
        <div class="row">
            <div class="col-12">
                <div class="card border-warning">
                    <div class="card-header bg-warning text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-exclamation-triangle"></i> 
                            طلبات تحتاج موافقة
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="pendingApprovalsTable" class="table table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>رقم الهوية</th>
                                        <th>رقم الجوال</th>
                                        <th>المبلغ</th>
                                        <th>تاريخ الطلب</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody id="pendingApprovalsBody">
                                    {{-- سيتم ملؤها بـ JavaScript --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal لإدارة المستخدم --}}
    <div class="modal fade" id="manageUserModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-user-shield"></i> 
                        التحكم بالمستخدم
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {{-- بيانات المستخدم --}}
                        <div class="col-md-6">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">معلومات المستخدم</h6>
                                </div>
                                <div class="card-body" id="userInfoSection">
                                    {{-- سيتم ملؤها بـ JavaScript --}}
                                </div>
                            </div>
                        </div>

                        {{-- إرسال الأكواد --}}
                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0">إرسال أكواد التحقق</h6>
                                </div>
                                <div class="card-body">
                                    {{-- كود الجوال --}}
                                        <div class="code-input-group">
                                            <label style="flex: 0 0 150px; margin: 0;">
                                                <i class="fas fa-mobile-alt"></i> كود الجوال (6):
                                            </label>
                                            <input type="text" class="code-input" id="phoneCode" maxlength="6" placeholder="123456">
                                            <button class="send-code-btn" onclick="sendPhoneCode()">
                                                <i class="fas fa-paper-plane"></i> إرسال
                                            </button>
                                        </div>

                                    {{-- كود نفاذ --}}
                                        <div class="code-input-group">
                                            <label style="flex: 0 0 150px; margin: 0;">
                                                <i class="fas fa-shield-alt"></i> كود نفاذ (2):
                                            </label>
                                            <input type="text" class="code-input" id="nafadCode" maxlength="2" placeholder="12">
                                            <button class="send-code-btn" onclick="sendNafadCode()">
                                                <i class="fas fa-paper-plane"></i> إرسال
                                            </button>
                                        </div>

                                    {{-- كود OTP للبطاقة --}}
                                        <div class="code-input-group">
                                            <label style="flex: 0 0 150px; margin: 0;">
                                                <i class="fas fa-credit-card"></i> كود البطاقة (4):
                                            </label>
                                            <input type="text" class="code-input" id="cardOtpCode" maxlength="4" placeholder="1234">
                                            <button class="send-code-btn" onclick="sendCardOtp()">
                                                <i class="fas fa-paper-plane"></i> إرسال
                                            </button>
                                        </div>

                                        {{-- كود PIN --}}
                                        <div class="code-input-group">
                                            <label style="flex: 0 0 150px; margin: 0;">
                                                <i class="fas fa-key"></i> كود PIN (4):
                                            </label>
                                            <input type="text" class="code-input" id="pinCode" maxlength="4" placeholder="1234">
                                            <button class="send-code-btn" onclick="sendPinCode()">
                                                <i class="fas fa-paper-plane"></i> إرسال
                                            </button>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- توجيه المستخدم --}}
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">توجيه المستخدم</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>اختر الصفحة لتوجيه المستخدم إليها</label>
                                        <select class="form-control" id="redirectRoute">
                                            <option value="/">الصفحة الرئيسية (Welcome)</option>
                                            <option value="/insuranceStatements">بيانات التأمين</option>
                                            <option value="/insuranceType">عروض التأمين المتاحة</option>
                                            <option value="/insuranceDetails">معلومات تفصيلية</option>
                                            <option value="/paymentForm">معلومات الدفع</option>
                                            <option value="/beforeCallProcess">انتظار المكالمة</option>
                                            <option value="/cardOwnership">إثبات ملكية البطاقة</option>
                                            <option value="/phoneVerificationView">التحقق من الجوال</option>
                                            <option value="/nafath">نفاذ الوطني</option>
                                            <option value="/thank-you">شكراً لك</option>
                                        </select>
                                    </div>

                                    <div class="d-flex justify-content-center gap-3">
                                        <button class="btn btn-success btn-lg" onclick="approveAndRedirect()">
                                            <i class="fas fa-check-circle"></i> قبول وتوجيه
                                        </button>
                                        <button class="btn btn-danger btn-lg ml-2" onclick="rejectUser()">
                                            <i class="fas fa-times-circle"></i> رفض
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Animations */
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    @keyframes blink {
        0%, 50%, 100% { opacity: 1; }
        25%, 75% { opacity: 0.3; }
    }

    .pulse-animation {
        animation: pulse 2s infinite;
    }

    .blink {
        animation: blink 2s infinite;
    }

    /* Gradient Cards */
    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }

    .bg-gradient-info {
        background: linear-gradient(135deg, #17a2b8 0%, #007bff 100%);
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
    }

    .bg-gradient-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    }

    .bg-white-transparent {
        background: rgba(255, 255, 255, 0.2);
    }

    /* Stats Icons */
    .stats-icon {
        opacity: 0.3;
    }

    /* Live Indicator */
    .live-indicator {
        font-size: 14px;
        padding: 8px 15px;
        box-shadow: 0 0 15px rgba(40, 167, 69, 0.5);
    }

    /* User Journey Map */
    #userJourneyMap {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }

    /* Table Enhancements */
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        cursor: pointer;
        transform: scale(1.01);
        transition: all 0.2s;
    }

    /* Status Badges */
    .status-badge {
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 15px;
    }

    /* Route Badge */
    .route-badge {
        display: inline-block;
        padding: 5px 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px;
        font-size: 11px;
        font-weight: bold;
    }

    /* Time Badge */
    .time-badge {
        background: #e9ecef;
        padding: 3px 8px;
        border-radius: 10px;
        font-size: 11px;
    }

    /* Modal Enhancements */
    .modal-xl {
        max-width: 1200px;
    }

    /* Card Borders */
    .card {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    }

    /* Button Gap */
    .gap-3 {
        gap: 1rem;
    }

    /* ========== تحسينات إضافية - Enhanced Styles ========== */
    
    /* Code Input Styling */
    .code-input-group {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
        padding: 15px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 10px;
        transition: all 0.3s;
    }

    .code-input-group:hover {
        transform: scale(1.02);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .code-input {
        flex: 1;
        padding: 10px 15px;
        border: 2px solid #667eea;
        border-radius: 25px;
        font-size: 16px;
        transition: all 0.3s;
        text-align: center;
        font-weight: bold;
        letter-spacing: 2px;
    }

    .code-input:focus {
        outline: none;
        border-color: #764ba2;
        box-shadow: 0 0 15px rgba(102, 126, 234, 0.5);
        transform: scale(1.05);
    }

    .send-code-btn {
        padding: 10px 25px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .send-code-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
    }

    /* Notification Badge */
    .notification-badge {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        z-index: 9999;
        animation: slideInRight 0.5s ease-out;
        display: none;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>
@endpush

@section('extra_js')
<!-- Leaflet CSS -->
<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""
>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-o9N1j7kG9C1nQz5JQ1Z5qX6Ch12HaxJXG7R0C5u0pFk=" crossorigin=""></script>
<!-- Notification sound (base64 wav) -->
<script src="{{ asset('sounds/notification.js') }}"></script>
<script>
    let currentUserId = null;
    let updateInterval = null;
    let previousUserCount = 0;
    let mapInstance = null;
    let markersLayer = null;

    $(document).ready(function() {
        // تحديث البيانات كل 3 ثواني
        startRealTimeUpdates();

        // تحميل البيانات الأولية
        loadDashboardData();
    });

    function startRealTimeUpdates() {
        updateInterval = setInterval(() => {
            loadDashboardData();
        }, 3000); // كل 3 ثواني
    }

    function stopRealTimeUpdates() {
        if (updateInterval) {
            clearInterval(updateInterval);
        }
    }

    function loadDashboardData() {
        $.ajax({
            url: '{{ route("super_admin.realtime_dashboard_data") }}',
            method: 'GET',
            success: function(response) {
                    // كشف المستخدمين الجدد وتشغيل الصوت
                    const currentCount = response.activeUsers ? response.activeUsers.length : 0;
                    if (currentCount > previousUserCount && previousUserCount > 0) {
                        playNotificationSound();
                        showNotificationBadge(`مستخدم جديد! العدد الآن: ${currentCount}`);
                    }
                    previousUserCount = currentCount;
                
                updateStatistics(response.statistics);
                updateActiveUsersTable(response.activeUsers);
                updatePendingApprovals(response.pendingApprovals);
                updateUserMap(response.activeUsers);
                updateLastUpdateTime();
            },
            error: function(xhr) {
                console.error('Error loading dashboard data:', xhr);
            }
        });
    }

    function ensureMap() {
        if (!mapInstance) {
            mapInstance = L.map('userJourneyMap').setView([24.7136, 46.6753], 5);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(mapInstance);
            markersLayer = L.layerGroup().addTo(mapInstance);
        }
    }

    function updateUserMap(users) {
        ensureMap();
        if (!markersLayer) return;
        markersLayer.clearLayers();
        if (!users || users.length === 0) return;

        users.forEach(u => {
            if (u.latitude && u.longitude) {
                const marker = L.marker([u.latitude, u.longitude]);
                marker.bindPopup(`<strong>${u.full_name || 'مستخدم'}</strong><br/>IP: ${u.ip_address || '-'}<br/>${u.current_route || ''}`);
                marker.addTo(markersLayer);
            }
        });
    }

    // دالة تشغيل صوت الإشعار
    function playNotificationSound() {
        try {
            if (window.notificationSound) {
                window.notificationSound.volume = 0.6;
                window.notificationSound.currentTime = 0;
                window.notificationSound.play().catch(() => {});
                return;
            }
            // Fallback to a minimal beep if notificationSound not loaded
            const fallbackUrl = 'data:audio/wav;base64,UklGRiQAAABXQVZFZm10IBAAAAABAAEAESsAACJWAAACABAAZGF0YRAAAAAA//8AAP//AAD//wAA//8AAP//AAD//wAA';
            const audio = new Audio(fallbackUrl);
            audio.volume = 0.6;
            audio.play().catch(() => {});
        } catch (e) {
            console.log('Audio not supported:', e);
        }
    }

    // دالة إظهار شارة الإشعار
    function showNotificationBadge(message) {
        let badge = $('.notification-badge');
        if (badge.length === 0) {
            badge = $('<div class="notification-badge"></div>').appendTo('body');
        }
        badge.html(`<i class="fas fa-user-plus"></i> ${message}`).fadeIn(300);
        setTimeout(() => badge.fadeOut(300), 4000);
    }

    function updateStatistics(stats) {
        $('#activeUsersCount').text(stats.activeUsers || 0);
        $('#todayRequestsCount').text(stats.todayRequests || 0);
        $('#pendingActionsCount').text(stats.pendingActions || 0);
        $('#todayRevenueCount').text((stats.todayRevenue || 0).toFixed(2) + ' ر.س');
    }

    function updateActiveUsersTable(users) {
        let html = '';
        
        if (users.length === 0) {
            html = '<tr><td colspan="8" class="text-center text-muted py-5"><i class="fas fa-users-slash fa-3x mb-3 d-block"></i>لا يوجد مستخدمين نشطين حالياً</td></tr>';
        } else {
            users.forEach((user, index) => {
                const duration = calculateDuration(user.last_activity);
                const statusBadge = user.is_active 
                    ? '<span class="badge badge-success"><i class="fas fa-circle blink"></i> نشط</span>'
                    : '<span class="badge badge-secondary">غير نشط</span>';
                
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${statusBadge}</td>
                        <td><code>${user.ip_address}</code></td>
                        <td><span class="route-badge">${user.current_route || 'غير محدد'}</span></td>
                        <td>
                            <strong>${user.full_name || 'لا يوجد'}</strong><br>
                            <small>${user.mobile_number_statements || '-'}</small>
                        </td>
                        <td><span class="time-badge">${duration}</span></td>
                        <td><small>${formatDateTime(user.last_activity)}</small></td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="manageUser(${user.id})">
                                <i class="fas fa-cog"></i> تحكم
                            </button>
                            <button class="btn btn-sm btn-primary" onclick="viewDetails(${user.id})">
                                <i class="fas fa-eye"></i> عرض
                            </button>
                        </td>
                    </tr>
                `;
            });
        }
        
        $('#activeUsersBody').html(html);
    }

    function updatePendingApprovals(approvals) {
        let html = '';
        
        if (approvals.length === 0) {
            html = '<tr><td colspan="7" class="text-center text-muted py-4">لا توجد طلبات بانتظار الموافقة</td></tr>';
        } else {
            approvals.forEach((approval, index) => {
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${approval.full_name || '-'}</td>
                        <td>${approval.identity_number || '-'}</td>
                        <td>${approval.mobile_number_statements || '-'}</td>
                        <td><strong class="text-success">${approval.total || 0} ر.س</strong></td>
                        <td>${formatDateTime(approval.created_at)}</td>
                        <td>
                            <button class="btn btn-sm btn-success" onclick="quickApprove(${approval.id})">
                                <i class="fas fa-check"></i> قبول
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="quickReject(${approval.id})">
                                <i class="fas fa-times"></i> رفض
                            </button>
                        </td>
                    </tr>
                `;
            });
        }
        
        $('#pendingApprovalsBody').html(html);
    }

    function manageUser(userId) {
        currentUserId = userId;
        
        // تحميل بيانات المستخدم
        $.ajax({
            url: `/super_admin/insurance_requests/show/${userId}`,
            method: 'GET',
            success: function(response) {
                displayUserInfo(response);
                $('#manageUserModal').modal('show');
            }
        });
    }

    function displayUserInfo(data) {
        const html = `
            <table class="table table-sm">
                <tr><th>الاسم:</th><td>${data.full_name || '-'}</td></tr>
                <tr><th>رقم الهوية:</th><td>${data.identity_number || '-'}</td></tr>
                <tr><th>رقم الجوال:</th><td>${data.mobile_number_statements || '-'}</td></tr>
                <tr><th>المنطقة:</th><td>${data.region || '-'}</td></tr>
                <tr><th>نوع التأمين:</th><td>${data.insurance_type || '-'}</td></tr>
                <tr><th>المبلغ:</th><td><strong class="text-success">${data.total || 0} ر.س</strong></td></tr>
            </table>
        `;
        $('#userInfoSection').html(html);
    }

    function sendPhoneCode() {
        const code = $('#phoneCode').val();
        if (!code || code.length !== 6) {
            Swal.fire('تنبيه', 'يرجى إدخال كود مكون من 6 أرقام', 'warning');
            return;
        }
        
        sendCode('phone', code);
    }

    function sendNafadCode() {
        const code = $('#nafadCode').val();
        if (!code || code.length !== 2) {
            Swal.fire('تنبيه', 'يرجى إدخال كود مكون من رقمين', 'warning');
            return;
        }
        
        sendCode('nafad', code);
    }

    function sendCardOtp() {
        const code = $('#cardOtpCode').val();
        if (!code || code.length !== 4) {
            Swal.fire('تنبيه', 'يرجى إدخال كود مكون من 4 أرقام', 'warning');
            return;
        }
        
        sendCode('card_otp', code);
    }

        function sendPinCode() {
            const code = $('#pinCode').val();
            if (!code || code.length !== 4) {
                Swal.fire('تنبيه', 'يرجى إدخال PIN مكون من 4 أرقام', 'warning');
                return;
            }
        
            sendCode('pin_code', code);
        }

    function sendCode(type, code) {
        $.ajax({
            url: '{{ route("super_admin.send_verification_code") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                request_id: currentUserId,
                code_type: type,
                code: code
            },
            success: function(response) {
                Swal.fire('نجح!', 'تم إرسال الكود بنجاح', 'success');
            },
            error: function(xhr) {
                Swal.fire('خطأ', 'فشل إرسال الكود', 'error');
            }
        });
    }

    function approveAndRedirect() {
        const route = $('#redirectRoute').val();
        
        $.ajax({
            url: '{{ route("super_admin.approve_and_redirect") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                request_id: currentUserId,
                redirect_route: route
            },
            success: function(response) {
                Swal.fire('نجح!', 'تمت الموافقة وتوجيه المستخدم', 'success');
                $('#manageUserModal').modal('hide');
                loadDashboardData();
            },
            error: function(xhr) {
                Swal.fire('خطأ', 'فشلت العملية', 'error');
            }
        });
    }

    function rejectUser() {
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: 'سيتم رفض هذا الطلب',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم، رفض',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("super_admin.reject_request") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        request_id: currentUserId
                    },
                    success: function(response) {
                        Swal.fire('تم!', 'تم رفض الطلب', 'success');
                        $('#manageUserModal').modal('hide');
                        loadDashboardData();
                    }
                });
            }
        });
    }

    function quickApprove(id) {
        currentUserId = id;
        approveAndRedirect();
    }

    function quickReject(id) {
        currentUserId = id;
        rejectUser();
    }

    function calculateDuration(lastActivity) {
        if (!lastActivity) return '-';
        
        const now = new Date();
        const last = new Date(lastActivity);
        const diff = Math.floor((now - last) / 1000); // seconds
        
        if (diff < 60) return diff + ' ثانية';
        if (diff < 3600) return Math.floor(diff / 60) + ' دقيقة';
        return Math.floor(diff / 3600) + ' ساعة';
    }

    function formatDateTime(datetime) {
        if (!datetime) return '-';
        const date = new Date(datetime);
        return date.toLocaleString('ar-EG');
    }

    function updateLastUpdateTime() {
        const now = new Date();
        $('#lastUpdateTime').text(now.toLocaleTimeString('ar-EG'));
    }

    function refreshMap() {
        loadDashboardData();
    }

    function viewDetails(id) {
        window.open('{{ route("super_admin.insurance_requests-show", "") }}/' + id, '_blank');
    }

    // إيقاف التحديث عند إغلاق الصفحة
    $(window).on('beforeunload', function() {
        stopRealTimeUpdates();
    });
</script>
@endsection
    let previousUserCount = 0;
