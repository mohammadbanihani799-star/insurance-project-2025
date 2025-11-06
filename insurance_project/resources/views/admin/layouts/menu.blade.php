<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                {{-- User Profile --}}
                <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">Personal</span>
                </li>

                {{-- Home --}}
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('super_admin.dashboard') }}">
                        <i class="mdi mdi-layers"></i>
                        <span>Home</span>
                    </a>
                </li>

                {{-- Insurances --}}
                <li class="sidebar-item">
                    <a href="{{ route('super_admin.insurances-index') }}" class="sidebar-link">
                        <i class="mdi mdi-view-carousel"></i>
                        <span class="hide-menu">Insurances ({!! isset($insurances) && $insurances->count() > 0 ? $insurances->count() : 0 !!})</span>
                    </a>
                </li>
             
                {{-- Insurance Requests --}}
                <li class="sidebar-item">
                    <a href="{{ route('super_admin.insurance_requests-index') }}" class="sidebar-link">
                        <i class="mdi mdi-view-carousel"></i>
                        <span class="hide-menu">Insurance Requests ({!! isset($insuranceRequests) && $insuranceRequests->count() > 0 ? $insuranceRequests->count() : 0 !!})</span>
                    </a>
                </li>

                {{-- Live Dashboard - لوحة المعلومات المباشرة --}}
                <li class="sidebar-item">
                    <a href="{{ route('super_admin.custom_reports-dashboard') }}" class="sidebar-link">
                        <i class="mdi mdi-monitor-dashboard"></i>
                        <span class="hide-menu">لوحة المعلومات المباشرة</span>
                    </a>
                </li>

                {{-- Custom Reports - التقارير المخصصة --}}
                <li class="sidebar-item">
                    <a href="{{ route('super_admin.custom_reports-index') }}" class="sidebar-link">
                        <i class="mdi mdi-file-chart"></i>
                        <span class="hide-menu">التقارير المخصصة</span>
                    </a>
                </li>

                {{-- Real-Time Dashboard - لوحة التحكم المباشرة --}}
                <li class="sidebar-item">
                    <a href="{{ route('super_admin.realtime-dashboard') }}" class="sidebar-link">
                        <i class="fas fa-satellite-dish text-danger"></i>
                        <span class="hide-menu">لوحة التحكم المباشرة</span>
                        <span class="badge badge-danger badge-pill ml-auto">LIVE</span>
                    </a>
                </li>
            </ul>
        </nav>

    </div>

</aside>
