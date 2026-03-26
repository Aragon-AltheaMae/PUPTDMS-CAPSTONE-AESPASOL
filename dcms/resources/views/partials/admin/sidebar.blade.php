<!-- ════════ SIDEBAR ════════ -->
<aside id="sidebar">
    <div class="sidebar-inner">

        <div class="nav-section-label">Clinic Management</div>
        <div class="nav-group">
            <div class="group-trigger {{ request()->routeIs('admin.admin.dashboard') ? 'active-group' : '' }}">
                <div class="group-icon-wrap"><i class="fa-solid fa-hospital"></i></div>
                <div class="group-text">
                    <span class="group-label">Clinic</span>
                    <span class="group-sublabel">Core clinical modules</span>
                </div>
            </div>
            <div class="group-body">
                <a href="{{ route('admin.admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs('admin.admin.dashboard') ? 'active' : '' }}"><i
                        class="fa-solid fa-chart-line"></i> Dashboard</a>
                <a href="{{ route('admin.patient_directory') }}"
                    class="nav-link {{ request()->routeIs('admin.patient_directory') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i> Patients
                </a>
                <a href="{{ route('admin.admin.appointments') }}"
                    class="nav-link {{ request()->routeIs('admin.admin.appointments') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-check"></i> Appointments
                </a>
                <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-tooth"></i> Dental
                    Records</a>
                <a href="{{ route('admin.document-requests.index') }}"
                    class="nav-link {{ request()->routeIs('admin.document-requests*') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-circle-check"></i> Document Request
                </a>
                <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-file"></i>
                    Reports</a>
            </div>
        </div>

        <div class="nav-sep"></div>
        <div class="nav-section-label">Maintenance</div>
        <div class="nav-group">
            <div
                class="group-trigger {{ request()->routeIs('admin.user_management*', 'admin.role_permissions', 'admin.academic_periods*', 'admin.clinic_schedule*') ? 'active-group' : '' }}">
                <div class="group-icon-wrap"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                <div class="group-text">
                    <span class="group-label">Configuration</span>
                    <span class="group-sublabel">Settings & scheduling</span>
                </div>
            </div>
            <div class="group-body">
                <a href="{{ route('admin.user_management') }}"
                    class="nav-link {{ request()->routeIs('admin.user_management*') ? 'active' : '' }}"><i
                        class="fa-solid fa-user-gear"></i> User Management</a>
                <a href="{{ route('admin.role_permissions') }}"
                    class="nav-link {{ request()->routeIs('admin.role_permissions') ? 'active' : '' }}"><i
                        class="fa-solid fa-user-shield"></i> Roles & Permissions</a>
                <a href="{{ route('admin.academic_periods') }}"
                    class="nav-link {{ request()->routeIs('admin.academic_periods*') ? 'active' : '' }}"><i
                        class="fa-solid fa-school"></i> Academic Periods</a>
                <a href="{{ route('admin.clinic_schedule') }}"
                    class="nav-link {{ request()->routeIs('admin.clinic_schedule*') ? 'active' : '' }}"><i
                        class="fa-solid fa-calendar-days"></i> Clinic Schedule</a>
                <a href="{{ route('admin.service-types') }}"
                    class="nav-link {{ request()->routeIs('admin.service-types*') ? 'active' : '' }}"><i
                        class="fa-solid fa-list-check"></i> Service Types</a>
                <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-file-pen"></i>
                    Document
                    Templates</a>
                <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i
                        class="fa-solid fa-boxes-stacked"></i>
                    Inventory</a>
            </div>
        </div>

        <div class="nav-sep"></div>
        <div class="nav-section-label">System</div>
        <div class="nav-group">
            <div class="group-trigger {{ request()->routeIs('admin.system_logs') ? 'active-group' : '' }}">
                <div class="group-icon-wrap"><i class="fa-solid fa-server"></i></div>
                <div class="group-text">
                    <span class="group-label">System</span>
                    <span class="group-sublabel">Admin & configuration</span>
                </div>
            </div>
            <div class="group-body">
                <a href="{{ route('admin.data_backup') }}"
                    class="nav-link {{ request()->routeIs('admin.data_backup') ? 'active' : '' }}"><i
                        class="fa-solid fa-sliders"></i> Data Backup</a>
                <a href="{{ route('admin.system_logs') }}"
                    class="nav-link {{ request()->routeIs('admin.system_logs') ? 'active' : '' }}"><i
                        class="fa-solid fa-clipboard-list"></i> System Logs</a>
                <a href="{{ route('admin.system_settings') }}"
                    class="nav-link {{ request()->routeIs('admin.system_settings*') ? 'active' : '' }}"><i
                        class="fa-solid fa-sliders"></i> System Settings</a>
            </div>
        </div>

    </div>
</aside>
