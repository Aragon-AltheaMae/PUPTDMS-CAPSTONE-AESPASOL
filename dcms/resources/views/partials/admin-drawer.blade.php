<style>
    #mobileMenuBtn {
        display: none;
        background: rgba(255, 255, 255, .12);
        border: none;
        color: #fff;
        width: 36px;
        height: 36px;
        border-radius: 9px;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: background .15s;
        flex-shrink: 0;
    }

    #mobileMenuBtn:hover {
        background: rgba(255, 255, 255, .22);
    }

    #mobileDrawerOverlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .45);
        z-index: 998;
        backdrop-filter: blur(2px);
        opacity: 0;
        transition: opacity .25s;
    }

    #mobileDrawerOverlay.open {
        opacity: 1;
    }

    #mobileDrawer {
        position: fixed;
        top: 0;
        left: 0;
        width: 280px;
        height: 100vh;
        background: #fff;
        z-index: 999;
        display: flex;
        flex-direction: column;
        transform: translateX(-100%);
        transition: transform .3s cubic-bezier(.4, 0, .2, 1);
        box-shadow: 4px 0 32px rgba(0, 0, 0, .15);
        overflow: hidden;
    }

    #mobileDrawer.open {
        transform: translateX(0);
    }

    .drawer-header {
        background: linear-gradient(135deg, #6b0000 0%, #8B0000 100%);
        padding: 20px 18px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
    }

    .drawer-header-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .drawer-logo {
        width: 30px;
        height: 30px;
        object-fit: contain;
    }

    .drawer-title {
        font-size: .82rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: .01em;
        line-height: 1.2;
    }

    .drawer-subtitle {
        font-size: .68rem;
        color: rgba(255, 255, 255, .6);
        font-style: italic;
    }

    .drawer-close {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(255, 255, 255, .15);
        border: none;
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: background .15s;
    }

    .drawer-close:hover {
        background: rgba(255, 255, 255, .28);
    }

    .drawer-user {
        padding: 14px 18px;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fdf9f9;
        flex-shrink: 0;
    }

    .drawer-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: 2px solid #e5e7eb;
        object-fit: cover;
        flex-shrink: 0;
    }

    .drawer-user-name {
        font-size: .82rem;
        font-weight: 700;
        color: #1f2937;
    }

    .drawer-user-role {
        font-size: .68rem;
        color: #9ca3af;
        font-style: italic;
    }

    .drawer-inner {
        flex: 1;
        overflow-y: auto;
        padding: 10px 0 6px;
    }

    .drawer-inner::-webkit-scrollbar {
        width: 4px;
    }

    .drawer-inner::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 4px;
    }

    .drawer-group {
        margin: 0 8px 2px;
    }

    .drawer-group-header {
        display: flex;
        align-items: center;
        padding: 6px 8px 4px;
        color: #6b7280;
    }

    .drawer-group-icon {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        color: #8B0000;
        flex-shrink: 0;
    }

    .drawer-group-label {
        font-size: .68rem;
        font-weight: 700;
        color: #8B0000;
        text-transform: uppercase;
        letter-spacing: .07em;
        margin-left: 8px;
    }

    .drawer-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 10px 8px 40px;
        border-radius: 8px;
        margin: 1px 4px;
        font-size: .78rem;
        font-weight: 500;
        color: #374151;
        text-decoration: none;
        transition: all .15s;
    }

    .drawer-link:hover {
        background: #fef2f2;
        color: #8B0000;
        padding-left: 44px;
    }

    .drawer-link.active {
        background: #8B0000;
        color: #fff;
        box-shadow: 0 2px 8px rgba(139, 0, 0, .2);
    }

    .drawer-link.active:hover {
        padding-left: 40px;
    }

    .drawer-link i {
        width: 15px;
        text-align: center;
        font-size: 11px;
    }

    .drawer-sep {
        height: 1px;
        background: #f3f4f6;
        margin: 6px 12px;
    }

    .drawer-bottom {
        padding: 10px 12px 14px;
        border-top: 1px solid #f3f4f6;
        flex-shrink: 0;
    }

    [data-theme="dark"] #mobileDrawer {
        background: #0d1117;
    }

    [data-theme="dark"] .drawer-user {
        background: #161b22;
        border-color: #21262d;
    }

    [data-theme="dark"] .drawer-user-name {
        color: #e5e7eb;
    }

    [data-theme="dark"] .drawer-link {
        color: #d1d5db;
    }

    [data-theme="dark"] .drawer-link:hover {
        background: rgba(139, 0, 0, .2);
        color: #fff;
    }

    [data-theme="dark"] .drawer-sep {
        background: #21262d;
    }

    [data-theme="dark"] .drawer-bottom {
        border-color: #21262d;
    }

    [data-theme="dark"] .drawer-group-label {
        color: #6b7280;
    }

    @media (max-width: 767px) {
        #mobileMenuBtn {
            display: flex;
        }
    }

    @media (min-width: 768px) {

        #mobileDrawerOverlay,
        #mobileDrawer {
            display: none !important;
        }
    }
</style>

<!-- Mobile drawer overlay -->
<div id="mobileDrawerOverlay" onclick="closeDrawer()"></div>

<!-- Mobile drawer -->
<div id="mobileDrawer">
    <div class="drawer-header">
        <div class="drawer-header-left">
            <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="drawer-logo" alt="DMS">
            <div>
                <div class="drawer-title">PUP TAGUIG</div>
                <div class="drawer-subtitle">Dental Clinic</div>
            </div>
        </div>
        <button class="drawer-close" onclick="closeDrawer()"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="drawer-user">
        <img src="https://i.pravatar.cc/40" class="drawer-avatar" alt="Avatar">
        <div>
            <div class="drawer-user-name">Admin</div>
            <div class="drawer-user-role">Administrator</div>
        </div>
    </div>
    <div class="drawer-inner">
        <div class="drawer-group">
            <div class="drawer-group-header"><i class="drawer-group-icon fa-solid fa-hospital"></i><span
                    class="drawer-group-label">Clinic Management</span></div>
            <a href="{{ route('admin.admin.dashboard') }}"
                class="drawer-link {{ request()->routeIs('admin.admin.dashboard') ? 'active' : '' }}"><i
                    class="fa-solid fa-chart-line"></i> Dashboard</a>
            <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-users"></i>
                Patients</a>
            <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i
                    class="fa-solid fa-calendar-check"></i>
                Appointments</a>
            <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-tooth"></i> Dental
                Records</a>
            <a href="{{ route('admin.document-requests.index') }}"
                class="drawer-link {{ request()->routeIs('admin.document-requests*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-circle-check"></i> Document Request
            </a>
            <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-file"></i>
                Reports</a>
        </div>
        <div class="drawer-sep"></div>
        <div class="drawer-group">
            <div class="drawer-group-header"><i class="drawer-group-icon fa-solid fa-screwdriver-wrench"></i><span
                    class="drawer-group-label">Maintenance</span></div>
            <a href="{{ route('admin.user_management') }}"
                class="drawer-link {{ request()->routeIs('admin.user_management*') ? 'active' : '' }}"><i
                    class="fa-solid fa-user-gear"></i> User Management</a>
            <a href="{{ route('admin.role_permissions') }}"
                class="drawer-link {{ request()->routeIs('admin.role_permissions') ? 'active' : '' }}"><i
                    class="fa-solid fa-user-shield"></i> Roles & Permissions</a>
            <a href="{{ route('admin.academic_periods') }}"
                class="drawer-link {{ request()->routeIs('admin.academic_periods*') ? 'active' : '' }}"><i
                    class="fa-solid fa-school"></i> Academic Periods</a>
            <a href="{{ route('admin.clinic_schedule') }}"
                class="drawer-link {{ request()->routeIs('admin.clinic_schedule*') ? 'active' : '' }}"><i
                    class="fa-solid fa-calendar-days"></i> Clinic Schedule</a>
            <a href="{{ route('admin.service-types') }}"
                class="drawer-link {{ request()->routeIs('admin.service-types*') ? 'active' : '' }}"><i
                    class="fa-solid fa-list-check"></i> Service Types</a>
            <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-file-pen"></i>
                Document
                Templates</a>
            <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i
                    class="fa-solid fa-boxes-stacked"></i>
                Inventory</a>
        </div>
        <div class="drawer-sep"></div>
        <div class="drawer-group">
            <div class="drawer-group-header"><i class="drawer-group-icon fa-solid fa-server"></i><span
                    class="drawer-group-label">System</span></div>
            <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-database"></i>
                Data
                Backup</a>
            <a href="{{ route('admin.system_logs') }}"
                class="drawer-link {{ request()->routeIs('admin.system_logs') ? 'active' : '' }}"><i
                    class="fa-solid fa-clipboard-list"></i> System Logs</a>
            <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-sliders"></i>
                System
                Settings</a>
        </div>
    </div>
    <div class="drawer-bottom">
        <div class="theme-toggle-container" id="drawerThemeToggle" style="margin-bottom:10px;">
            <button type="button" class="theme-option active" data-theme="light"><i
                    class="fa-solid fa-sun"></i></button>
            <button type="button" class="theme-option" data-theme="dark"><i class="fa-regular fa-moon"></i></button>
            <div class="theme-indicator" aria-hidden="true"></div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn"><span class="logout-icon"><i
                        class="fa-solid fa-right-from-bracket" style="color:#ef4444;"></i></span><span>Log
                    out</span></button>
        </form>
    </div>
</div>
