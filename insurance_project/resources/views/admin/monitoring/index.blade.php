@extends('admin.layouts.app')

@section('content')
{{-- =========================================================== --}}
{{-- =================== Page Header Section =================== --}}
{{-- =========================================================== --}}
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center">
            <h3 class="page-title">
                لوحة المراقبة المباشرة
                <small class="text-muted" style="font-size: 12px; display: block; margin-top: 5px;">
                    <span id="live-indicator">🟢</span> التحديث التلقائي كل 3 ثوانٍ
                    <span id="last-sync" style="margin-right: 10px;"></span>
                </small>
            </h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Live Monitoring</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
            <div class="d-flex">
                <div class="me-2">
                    <span class="badge bg-primary" id="active-devices-count">{{ $activeDevices->count() }}</span>
                    <span class="text-muted">أجهزة نشطة</span>
                </div>
                <div class="me-2">
                    <span class="badge bg-success" id="recent-visits-count">{{ $recentVisits->count() }}</span>
                    <span class="text-muted">زيارات حديثة</span>
                </div>
                <div>
                    <span class="badge bg-warning" id="recent-events-count">{{ $recentLoginEvents->count() }}</span>
                    <span class="text-muted">أحداث دخول</span>
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
        {{-- Active Devices Section --}}
        <div class="col-lg-7 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">الأجهزة النشطة (آخر 5 دقائق)</h4>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm" id="active-devices-table">
                            <thead class="table-light">
                                <tr>
                                    <th>معرف الجهاز</th>
                                    <th>IP</th>
                                    <th>المنصة</th>
                                    <th>المتصفح</th>
                                    <th>آخر ظهور</th>
                                    <th>المالك</th>
                                </tr>
                            </thead>
                            <tbody id="active-devices-tbody">
                                @forelse($activeDevices as $device)
                                <tr>
                                    <td><code>{{ substr($device->device_id, 0, 8) }}...</code></td>
                                    <td>{{ $device->ip }}</td>
                                    <td>{{ $device->platform }}</td>
                                    <td>{{ $device->browser }}</td>
                                    <td class="text-muted">{{ $device->last_seen_at->diffForHumans() }}</td>
                                    <td>{{ $device->owner ? ($device->owner->name ?? 'Unknown') : 'Guest' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">لا توجد أجهزة نشطة حالياً</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Admin Login Events Section --}}
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">أحداث تسجيل الدخول الإداري (آخر 24 ساعة)</h4>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm" id="login-events-table">
                            <thead class="table-light">
                                <tr>
                                    <th>الحدث</th>
                                    <th>المستخدم</th>
                                    <th>IP</th>
                                    <th>الجهاز</th>
                                    <th>الوقت</th>
                                    <th>ملاحظة</th>
                                </tr>
                            </thead>
                            <tbody id="login-events-tbody">
                                @forelse($recentLoginEvents as $event)
                                <tr>
                                    <td>
                                        @if($event->event == 'login_success')
                                            <span class="badge bg-success">✓ نجح</span>
                                        @elseif($event->event == 'login_failed')
                                            <span class="badge bg-danger">✗ فشل</span>
                                        @else
                                            <span class="badge bg-secondary">⟲ خروج</span>
                                        @endif
                                    </td>
                                    <td>{{ $event->admin ? $event->admin->name : 'Unknown' }}</td>
                                    <td>{{ $event->ip }}</td>
                                    <td><code>{{ substr($event->device_id ?? '', 0, 8) }}...</code></td>
                                    <td class="text-muted">{{ $event->created_at->diffForHumans() }}</td>
                                    <td class="text-muted small">{{ $event->note }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">لا توجد أحداث حديثة</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Visits Sidebar --}}
        <div class="col-lg-5 col-md-12">
            <div class="card" style="height: calc(100vh - 200px);">
                <div class="card-body">
                    <h4 class="card-title">الزيارات الحديثة (آخر ساعة)</h4>
                    <div style="height: calc(100% - 50px); overflow-y: auto;" id="recent-visits-container">
                        @forelse($recentVisits as $visit)
                        <div class="border-bottom py-2 visit-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div><code class="small">{{ substr($visit->device_id, 0, 8) }}...</code></div>
                                    <div class="text-primary">{{ $visit->path }}</div>
                                    @if($visit->step_key)
                                    <div><span class="badge badge-info">{{ $visit->step_key }}</span></div>
                                    @endif
                                </div>
                                <div class="text-muted small">{{ $visit->visited_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted py-5">لا توجد زيارات حديثة</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Custom CSS --}}
<style>
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

#live-indicator {
    display: inline-block;
    animation: pulse 2s ease-in-out infinite;
}

#live-indicator.inactive {
    animation: none;
    opacity: 0.3;
}

.visit-item {
    transition: background-color 0.2s;
}

.visit-item:hover {
    background-color: #f8f9fa;
}

.new-row-highlight {
    animation: highlightRow 2s ease-in-out;
}

@keyframes highlightRow {
    0% { background-color: #fff3cd; }
    100% { background-color: transparent; }
}
</style>

{{-- Custom JavaScript --}}
<script>
let refreshInterval;
const REFRESH_RATE = {{ config('admin.monitoring.poll_interval', 3000) }}; // milliseconds

document.addEventListener('DOMContentLoaded', function() {
    // Start polling for updates
    startPolling();

    // Handle visibility change (battery saving)
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            stopPolling();
            document.getElementById('live-indicator').textContent = '🔴';
            document.getElementById('live-indicator').classList.add('inactive');
        } else {
            startPolling();
            document.getElementById('live-indicator').textContent = '🟢';
            document.getElementById('live-indicator').classList.remove('inactive');
        }
    });
});

function startPolling() {
    // Initial fetch
    fetchUpdates();
    
    // Set interval
    refreshInterval = setInterval(fetchUpdates, REFRESH_RATE);
}

function stopPolling() {
    if (refreshInterval) {
        clearInterval(refreshInterval);
        refreshInterval = null;
    }
}

function fetchUpdates() {
    fetch('{{ route('admin.monitoring.poll') }}', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateActiveDevices(data.active_devices);
            updateRecentVisits(data.recent_visits);
            updateLoginEvents(data.recent_login_events);
            updateCounts(data);
            updateLastSync(data.timestamp);
        }
    })
    .catch(error => {
        console.error('Poll error:', error);
    });
}

function updateActiveDevices(devices) {
    const tbody = document.getElementById('active-devices-tbody');
    if (devices.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">لا توجد أجهزة نشطة حالياً</td></tr>';
        return;
    }

    let html = '';
    devices.forEach(device => {
        html += `
            <tr class="new-row-highlight">
                <td><code>${device.device_id}</code></td>
                <td>${device.ip}</td>
                <td>${device.platform}</td>
                <td>${device.browser}</td>
                <td class="text-muted">${device.last_seen}</td>
                <td>${device.owner}</td>
            </tr>
        `;
    });
    tbody.innerHTML = html;
}

function updateRecentVisits(visits) {
    const container = document.getElementById('recent-visits-container');
    if (visits.length === 0) {
        container.innerHTML = '<div class="text-center text-muted py-5">لا توجد زيارات حديثة</div>';
        return;
    }

    let html = '';
    visits.forEach(visit => {
        html += `
            <div class="border-bottom py-2 visit-item new-row-highlight">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div><code class="small">${visit.device_id}</code></div>
                        <div class="text-primary">${visit.path}</div>
                        ${visit.step_key ? `<div><span class="badge badge-info">${visit.step_key}</span></div>` : ''}
                    </div>
                    <div class="text-muted small">${visit.visited_at}</div>
                </div>
            </div>
        `;
    });
    container.innerHTML = html;
}

function updateLoginEvents(events) {
    const tbody = document.getElementById('login-events-tbody');
    if (events.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">لا توجد أحداث حديثة</td></tr>';
        return;
    }

    let html = '';
    events.forEach(event => {
        let badge = '';
        if (event.event === 'login_success') {
            badge = '<span class="badge bg-success">✓ نجح</span>';
        } else if (event.event === 'login_failed') {
            badge = '<span class="badge bg-danger">✗ فشل</span>';
        } else {
            badge = '<span class="badge bg-secondary">⟲ خروج</span>';
        }

        html += `
            <tr class="new-row-highlight">
                <td>${badge}</td>
                <td>${event.admin}</td>
                <td>${event.ip}</td>
                <td><code>${event.device_id}</code></td>
                <td class="text-muted">${event.created_at}</td>
                <td class="text-muted small">${event.note || ''}</td>
            </tr>
        `;
    });
    tbody.innerHTML = html;
}

function updateCounts(data) {
    document.getElementById('active-devices-count').textContent = data.active_devices_count;
    document.getElementById('recent-visits-count').textContent = data.recent_visits_count;
    document.getElementById('recent-events-count').textContent = data.recent_login_events_count;
}

function updateLastSync(timestamp) {
    const date = new Date(timestamp);
    const now = new Date();
    const diff = Math.floor((now - date) / 1000); // seconds
    
    let timeAgo = '';
    if (diff < 60) {
        timeAgo = 'منذ ' + diff + ' ثانية';
    } else {
        const minutes = Math.floor(diff / 60);
        timeAgo = 'منذ ' + minutes + ' دقيقة';
    }
    
    document.getElementById('last-sync').textContent = 'آخر تحديث: ' + timeAgo;
}
</script>
@endsection
