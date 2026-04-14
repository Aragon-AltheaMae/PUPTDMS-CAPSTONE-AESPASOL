<aside id="sidebar" class="flex flex-col">
    <div class="sidebar-inner">
        <div class="toggle-row flex justify-end mb-3">
            <button type="button" id="desktopSidebarToggle" class="sidebar-toggle-btn">
                <i id="sidebarToggleIcon" class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="nav-section-label mt-2">Navigation</div>

        <div class="nav-group mt-2">
            <a href="{{ route('homepage') }}"
                class="nav-link {{ request()->routeIs('homepage') || request()->is('patient/dashboard') ? 'active' : '' }}">
                <span class="nav-icon-wrap"><i class="fa-solid fa-house"></i></span>
                <span class="menu-text">Home</span>
                <span class="sidebar-tooltip">Home</span>
            </a>

            <a href="{{ route('patient.appointment.index') }}"
                class="nav-link {{ request()->routeIs('patient.appointment.*') || request()->is('patient/appointment*') ? 'active' : '' }}">
                <span class="nav-icon-wrap"><i class="fa-solid fa-calendar-check"></i></span>
                <span class="menu-text">Appointments</span>
                <span class="sidebar-tooltip">Appointments</span>
            </a>

            <a href="{{ route('patient.record') }}"
                class="nav-link {{ request()->routeIs('patient.record') || request()->is('patient/record*') ? 'active' : '' }}">
                <span class="nav-icon-wrap"><i class="fa-solid fa-folder-open"></i></span>
                <span class="menu-text">Dental Records</span>
                <span class="sidebar-tooltip">Dental Records</span>
            </a>

            <a href="{{ route('patient.about.us') }}"
                class="nav-link {{ request()->routeIs('patient.about.us') || request()->is('patient/about*') ? 'active' : '' }}">
                <span class="nav-icon-wrap"><i class="fa-solid fa-circle-info"></i></span>
                <span class="menu-text">About Us</span>
                <span class="sidebar-tooltip">About Us</span>
            </a>
        </div>
    </div>

    <div class="sidebar-bottom">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <div class="logout-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                <span class="menu-text">Log Out</span>
                <span class="sidebar-tooltip">Log Out</span>
            </button>
        </form>
    </div>
</aside>
