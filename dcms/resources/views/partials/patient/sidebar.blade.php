<aside id="sidebar" class="hidden md:flex">
    <div class="sidebar-inner">
        <div class="nav-section-label mt-2">Navigation</div>

        <div class="nav-group mt-2">
            <a href="{{ route('patient.dashboard') }}" class="nav-link {{ request()->routeIs('patient.dashboard') || request()->is('patient/dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i> Home
            </a>
            
            <a href="{{ route('patient.appointment.index') }}" class="nav-link {{ request()->routeIs('patient.appointment.*') || request()->is('patient/appointment*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check"></i> Appointments
            </a>
            
            <a href="{{ route('patient.record') }}" class="nav-link {{ request()->routeIs('patient.record') || request()->is('patient/record*') ? 'active' : '' }}">
                <i class="fa-solid fa-folder-open"></i> Dental Records
            </a>
            
            <a href="{{ route('patient.about.us') }}" class="nav-link {{ request()->routeIs('patient.about.us') || request()->is('patient/about*') ? 'active' : '' }}">
                <i class="fa-solid fa-circle-info"></i> About Us
            </a>
        </div>
    </div>

    <div class="sidebar-bottom">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <div class="logout-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                <span>Log Out</span>
            </button>
        </form>
    </div>
</aside>