@extends('admin.layouts.app')

@section('content')
    {{-- ============================================================== --}}
    {{-- Bread crumb and right sidebar toggle --}}
    {{-- ============================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h3 class="page-title">Dashboard</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-7 justify-content-end align-self-center d-none d-md-flex">
                <div class="d-flex">
                    <div class="btn btn-secondary">
                        {{ date('F j, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ============================================================== --}}
    {{-- End Bread crumb and right sidebar toggle --}}
    {{-- ============================================================== --}}

    {{-- ============================================================== --}}
    {{-- Container fluid --}}
    {{-- ============================================================== --}}
    <div class="container-fluid">
        {{-- ============================================================== --}}
        {{-- Counters Section --}}
        {{-- ============================================================== --}}
        <div class="row">
            {{-- Insurances --}}
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><a href="{{ route('super_admin.insurances-index') }}"
                                class="fw-light mb-0 text-danger">Insurances</a></h4>
                        <div class="text-end">
                            <h2 class="fw-light mb-0 text-danger">
                                <a href="{{ route('super_admin.insurances-index') }}">
                                    <i class="ti-arrow-up text-danger"></i>
                                    <span style="color: red"> {!! isset($insurances) && $insurances->count() > 0 ? $insurances->count() : 0 !!}</span>
                                </a>
                            </h2>
                            <a href="{{ route('super_admin.insurances-index') }}">
                                <span class="text-muted">Insurances</span>
                            </a>
                        </div>
                        <div class="progress mt-3">
                            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 50%;"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Insurance Requests --}}
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><a href="{{ route('super_admin.insurance_requests-index') }}"
                                class="fw-light mb-0 text-success">Insurance Requests</a></h4>
                        <div class="text-end">
                            <h2 class="fw-light mb-0 text-success">
                                <a href="{{ route('super_admin.insurance_requests-index') }}">
                                    <i class="ti-arrow-up text-success"></i>
                                    <span style="color:green ">
                                        {!! isset($insuranceRequests) && $insuranceRequests->count() > 0 ? $insuranceRequests->count() : 0 !!}
                                    </span>
                                </a>
                            </h2>
                            <a href="{{ route('super_admin.insurance_requests-index') }}">
                                <span class="text-muted">Insurance Requests</span>
                            </a>
                        </div>
                        <div class="progress mt-3">
                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 60%;"
                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================== --}}
        {{-- Live Visitors (Active / Inactive + Current Page) --}}
        {{-- ============================================================== --}}
        <div class="row mt-3">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Active Visitors (last 2 min)</h4>
                        <div class="text-end">
                            <h2 class="fw-light mb-0 text-primary"><span id="visitors-active">0</span></h2>
                            <span class="text-muted">users online</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Inactive Visitors</h4>
                        <div class="text-end">
                            <h2 class="fw-light mb-0 text-secondary"><span id="visitors-inactive">0</span></h2>
                            <span class="text-muted">idle</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title d-flex justify-content-between align-items-center">
                            <span>Recent Visitors (last 50)</span>
                            <small class="text-muted" id="visitors-generated-at"></small>
                        </h4>
                        <div class="table-responsive" style="max-height: 320px; overflow:auto;">
                            <table class="table table-bordered table-sm align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Session</th>
                                        <th>IP</th>
                                        <th>Route</th>
                                        <th>When</th>
                                    </tr>
                                </thead>
                                <tbody id="visitors-table-body">
                                    <tr><td colspan="4" class="text-center text-muted">Loading...</td></tr>
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
            $('#toggleTasksTab').on('click', function(e) {
                e.preventDefault();
                $('#tab_body_1').toggle();
            });

            // ===== Audio Notifications System =====
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            let lastInsuranceRequestsCount = {{ $insuranceRequests->count() ?? 0 }};
            let lastInsurancesCount = {{ $insurances->count() ?? 0 }};
            let lastVisitorsCount = 0;
            
            // Create different sounds for different events
            function playNewRequestSound() {
                // Sound for new insurance request (beep - 800Hz)
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                oscillator.frequency.value = 800;
                oscillator.type = 'sine';
                
                gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.5);
            }
            
            function playPaymentSound() {
                // Sound for payment/bank card data (different tone - 1200Hz)
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                oscillator.frequency.value = 1200;
                oscillator.type = 'square';
                
                gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.3);
                
                // Double beep for payment
                setTimeout(() => {
                    const osc2 = audioContext.createOscillator();
                    const gain2 = audioContext.createGain();
                    osc2.connect(gain2);
                    gain2.connect(audioContext.destination);
                    osc2.frequency.value = 1200;
                    osc2.type = 'square';
                    gain2.gain.setValueAtTime(0.3, audioContext.currentTime);
                    gain2.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);
                    osc2.start(audioContext.currentTime);
                    osc2.stop(audioContext.currentTime + 0.3);
                }, 200);
            }
            
            function playNewVisitorSound() {
                // Sound for new visitor (soft tone - 600Hz)
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                oscillator.frequency.value = 600;
                oscillator.type = 'sine';
                
                gainNode.gain.setValueAtTime(0.2, audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.4);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.4);
            }
            
            function showNotification(title, message, type = 'info') {
                // Create toast notification
                const colors = {
                    'success': '#28a745',
                    'payment': '#ffc107',
                    'visitor': '#17a2b8'
                };
                
                const toast = $(`
                    <div class="alert alert-dismissible fade show" 
                         style="position: fixed; top: 80px; right: 20px; z-index: 9999; 
                                min-width: 300px; background: ${colors[type] || '#007bff'}; 
                                color: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        <strong>${title}</strong><br>
                        ${message}
                        <button type="button" class="close" data-dismiss="alert" style="color: white;">
                            <span>&times;</span>
                        </button>
                    </div>
                `);
                
                $('body').append(toast);
                setTimeout(() => toast.fadeOut(() => toast.remove()), 5000);
            }

            // Live Insurance Requests counter with notifications
            function refreshInsuranceRequests(){
                $.get("{{ route('super_admin.insurance_requests-summary') }}", function(data){
                    const currentCount = data.total || 0;
                    
                    // Check for new requests
                    if (currentCount > lastInsuranceRequestsCount) {
                        const newRequests = currentCount - lastInsuranceRequestsCount;
                        playNewRequestSound();
                        showNotification(
                            '🔔 New Insurance Request!',
                            `${newRequests} new insurance request(s) received`,
                            'success'
                        );
                        
                        // Update the counter in the card
                        $('span[style*="color: green"], span[style*="color:green"]').text(currentCount);
                    }
                    
                    // Check if it's a payment (check if request has payment data)
                    if (data.has_payment && data.has_payment > 0) {
                        playPaymentSound();
                        showNotification(
                            '💳 Payment Detected!',
                            'New payment/bank card data submitted',
                            'payment'
                        );
                    }
                    
                    lastInsuranceRequestsCount = currentCount;
                }).always(function(){ setTimeout(refreshInsuranceRequests, 5000); });
            }
            setTimeout(refreshInsuranceRequests, 3000);

            // Live Visitors with new visitor notifications
            function refreshVisitors(){
                $.get("{{ route('super_admin.visitors.summary') }}", function(resp){
                    const currentActive = resp.active ?? 0;
                    
                    // Check for new visitors
                    if (currentActive > lastVisitorsCount && lastVisitorsCount > 0) {
                        playNewVisitorSound();
                        showNotification(
                            '👤 New Visitor!',
                            'A new visitor just arrived on the site',
                            'visitor'
                        );
                    }
                    
                    lastVisitorsCount = currentActive;
                    
                    $('#visitors-active').text(currentActive);
                    $('#visitors-inactive').text(resp.inactive ?? 0);
                    $('#visitors-generated-at').text(resp.generated_at || '');

                    var rows = '';
                    (resp.recent || []).forEach(function(v){
                        rows += '<tr>'+
                            '<td class="text-truncate" style="max-width:160px">'+ (v.session_id || '') +'</td>'+
                            '<td>'+(v.ip||'')+'</td>'+
                            '<td class="text-truncate" style="max-width:260px">'+ (v.current_route || v.current_url || '') +'</td>'+
                            '<td>'+(v.last_seen_at || '')+'</td>'+
                        '</tr>';
                    });
                    if (!rows) rows = '<tr><td colspan="4" class="text-center text-muted">No data</td></tr>';
                    $('#visitors-table-body').html(rows);
                }).always(function(){ setTimeout(refreshVisitors, 5000); });
            }
            refreshVisitors();
            
            // Initialize audio context on user interaction (required by browsers)
            $(document).one('click', function() {
                if (audioContext.state === 'suspended') {
                    audioContext.resume();
                }
            });
        });
    </script>
@endsection
