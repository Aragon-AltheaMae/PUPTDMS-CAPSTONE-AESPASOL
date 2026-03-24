<style>
    :root {
        --sidebar-w: 240px;
    }

    #sidebar {
        position: fixed;
        left: 0;
        top: var(--header-h);
        width: var(--sidebar-w, 240px);
        height: calc(100vh - var(--header-h));
        background: #fff;
        border-right: 1px solid #eff0f2;
        box-shadow: 4px 0 24px rgba(0, 0, 0, .04);
        z-index: 40;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .sidebar-inner {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 16px 10px 8px;
    }

    .nav-section-label {
        font-size: .6rem;
        font-weight: 800;
        color: #b0b7c3;
        text-transform: uppercase;
        letter-spacing: .1em;
        padding: 0 8px 6px;
        margin-top: 4px;
    }

    .nav-group {
        margin-bottom: 2px;
    }

    .group-trigger {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 10px;
        border-radius: 10px;
        cursor: default;
    }

    .group-icon-wrap {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: var(--crimson-light);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        color: var(--crimson);
        flex-shrink: 0;
        transition: all .2s;
    }

    .active-group .group-icon-wrap {
        background: var(--crimson);
        color: #fff;
        box-shadow: 0 4px 12px rgba(139, 0, 0, .3);
    }

    .group-text {
        flex: 1;
        overflow: hidden;
    }

    .group-label {
        font-size: .7rem;
        font-weight: 800;
        color: var(--crimson);
        display: block;
        text-transform: uppercase;
        letter-spacing: .06em;
        white-space: nowrap;
    }

    .group-sublabel {
        font-size: .62rem;
        color: #adb5bd;
        display: block;
        margin-top: 1px;
        white-space: nowrap;
    }

    .group-body {
        padding: 2px 0 6px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 7px 10px 7px 42px;
        border-radius: 9px;
        margin: 1px 2px;
        font-size: .76rem;
        font-weight: 500;
        color: #4a5568;
        text-decoration: none;
        transition: all .15s;
        white-space: nowrap;
    }

    .nav-link:hover {
        background: var(--crimson-light);
        color: var(--crimson);
    }

    .nav-link.active {
        background: linear-gradient(135deg, var(--crimson) 0%, var(--crimson-dark) 100%);
        color: #fff;
        box-shadow: 0 3px 10px rgba(139, 0, 0, .25);
        font-weight: 600;
    }

    .nav-link.active:hover {
        padding-left: 14px;
        background: #8B0000;
    }

    .nav-link i {
        width: 14px;
        text-align: center;
        font-size: 11px;
        flex-shrink: 0;
    }

    .nav-sep {
        height: 1px;
        background: #f3f4f6;
        margin: 10px 6px;
    }

    .sidebar-bottom {
        padding: 10px 10px 14px;
        border-top: 1px solid #f3f4f6;
        flex-shrink: 0;
    }

    .theme-toggle-container {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
        height: 36px;
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        border-radius: 40px;
        padding: 3px;
    }

    .theme-option {
        position: relative;
        z-index: 2;
        flex: 1;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: none;
        cursor: pointer;
        color: #9ca3af;
        transition: color .2s;
        border-radius: 40px;
        font-size: 13px;
    }

    .theme-option.active {
        color: #374151;
    }

    .theme-indicator {
        position: absolute;
        background: #fff;
        border-radius: 40px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
        transition: all .3s cubic-bezier(.4, 0, .2, 1);
        pointer-events: none;
        width: calc(50% - 3px);
        height: calc(100% - 6px);
        left: 3px;
        top: 3px;
    }

    .theme-indicator.dark-mode {
        transform: translateX(calc(100% + 0px));
    }

    .logout-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 8px 10px;
        border-radius: 10px;
        border: none;
        background: none;
        cursor: pointer;
        color: #ef4444;
        font-size: .76rem;
        font-weight: 600;
        transition: background .15s;
        margin-top: 6px;
        font-family: 'Inter', sans-serif;
    }

    .logout-btn:hover {
        background: #fef2f2;
    }

    .logout-icon {
        width: 28px;
        height: 28px;
        background: #fef2f2;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 11px;
    }

    [data-theme="dark"] #sidebar {
        background-color: #0d1117;
        border-right: 1px solid #21262d;
    }

    [data-theme="dark"] .nav-link:hover {
        background: rgba(139, 0, 0, .2);
    }

    [data-theme="dark"] .theme-toggle-container {
        background: #1F1F1F;
        border-color: #2A2A2A;
    }

    [data-theme="dark"] .theme-option {
        color: #6B7280;
    }

    [data-theme="dark"] .theme-option.active {
        color: #F3F4F6;
    }

    [data-theme="dark"] .theme-indicator {
        background: #2A2A2A;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .3);
    }

    [data-theme="dark"] .nav-sep,
    [data-theme="dark"] .sidebar-bottom {
        border-color: #21262d;
    }

    [data-theme="dark"] .group-label {
        color: #6b7280;
    }

    #mainContent {
        margin-left: var(--sidebar-w);
    }

    @media (max-width: 767px) {
        #sidebar {
            display: none !important;
        }

        #mainContent {
            margin-left: 0 !important;
        }
    }
</style>

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
                <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-users"></i>
                    Patients</a>
                <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i
                        class="fa-solid fa-calendar-check"></i>
                    Appointments</a>
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
