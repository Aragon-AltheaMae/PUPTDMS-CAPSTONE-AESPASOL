@php
    $authUser = auth()->user();

    $role = $role ?? (optional(optional($authUser)->role)->slug ?? (session('role') ?? 'patient'));

    $notifications = collect($notifications ?? []);
    $notifCount = $notifications->count();

    $showMobileMenu = $showMobileMenu ?? in_array($role, ['admin', 'super_admin', 'dentist']);
    $showSettings = $showSettings ?? in_array($role, ['admin', 'super_admin']);

    $clinicTitle = $clinicTitle ?? 'PUP TAGUIG DENTAL CLINIC';

    if ($role === 'patient') {
        $displayName = ucwords(strtolower(optional($patient)->name ?? ($authUser->name ?? 'Patient User')));
        $displayRole = 'Patient';
        $patientImage = optional($patient)->profile_image ?? null;
        $userImage = $authUser->profile_image ?? null;

        if (!empty($patientImage)) {
            $avatarUrl = asset('storage/' . $patientImage);
        } elseif (!empty($userImage)) {
            $avatarUrl = asset('storage/' . $userImage);
        } else {
            $avatarUrl =
                'https://ui-avatars.com/api/?name=' .
                urlencode($displayName) .
                '&background=8B0000&color=ffffff&bold=true';
        }
    } else {
        $displayName = $authUser->name ?? 'User';

        if ($role === 'super_admin') {
            $displayRole = 'Super Administrator';
        } elseif ($role === 'admin') {
            $displayRole = 'Administrator';
        } elseif ($role === 'dentist') {
            $displayRole = 'Dentist';
        } else {
            $displayRole = ucwords(str_replace('_', ' ', $role));
        }

        if (!empty($authUser->profile_image)) {
            $avatarUrl = asset('storage/' . $authUser->profile_image);
        } else {
            $avatarUrl =
                'https://ui-avatars.com/api/?name=' .
                urlencode($displayName) .
                '&background=8B0000&color=ffffff&bold=true';
        }
    }

    $logoutRoute = route('logout');
    $settingsRoute = $settingsRoute ?? (Route::has('admin.system_settings') ? route('admin.system_settings') : '#');
@endphp

<header class="header">
    <div class="header-left">
        @if ($showMobileMenu)
            <button id="mobileMenuBtn" class="hdr-icon-btn" type="button"
                @if ($role === 'dentist') onclick="openDrawer()" @endif>
                <i class="fa-solid fa-bars"></i>
            </button>
        @endif

        <img src="{{ asset('images/PUP.png') }}" class="header-logo" alt="PUP Logo">
        <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="header-logo" alt="Clinic Logo">
        <div class="header-divider"></div>
        <span class="header-title">{{ $clinicTitle }}</span>
    </div>

    <div class="header-right">
        <div id="notifDropdown">
            <button class="hdr-icon-btn" id="notifBtn" type="button" aria-label="Notifications">
                <i class="fa-regular fa-bell"></i>
                @if ($notifCount > 0)
                    <span class="notif-badge">{{ $notifCount }}</span>
                @endif
            </button>

            <div id="notifMenu" class="header-dropdown-menu header-notif-menu">
                <div class="header-notif-head">
                    <i class="fa-solid fa-bell"></i>
                    <span>Notifications</span>
                </div>

                <div class="header-notif-body">
                    @forelse($notifications as $n)
                        <a href="{{ $n['url'] ?? '#' }}" class="header-notif-item">
                            <div class="header-notif-item-title">{{ $n['title'] ?? 'Notification' }}</div>
                            @if (!empty($n['message']))
                                <div class="header-notif-item-message">{{ $n['message'] }}</div>
                            @endif
                        </a>
                    @empty
                        <div class="header-notif-empty">
                            <i class="fa-solid fa-bell-slash"></i>
                            <span>You're all caught up.</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        @if ($showSettings)
            <a href="{{ $settingsRoute }}" class="hdr-icon-btn" aria-label="System Settings">
                <i class="fa-solid fa-gear"></i>
            </a>
        @endif

        <div id="userDropdown">
            <button class="header-user-btn" id="userBtn" type="button">
                <div class="avatar-wrapper">
                    <img src="{{ $avatarUrl }}" class="header-avatar" alt="Profile avatar">
                    <div class="mobile-chevron-badge">
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                </div>

                <div class="header-user-info">
                    <div class="header-name">{{ $displayName }}</div>
                    <div class="header-role">{{ $displayRole }}</div>
                </div>

                <i class="fa-solid fa-chevron-down desktop-chevron"
                    style="font-size:.65rem; opacity:.75; margin-left:4px;"></i>
            </button>

            <div id="userMenu" class="header-dropdown-menu header-user-menu">

                <div class="dropdown-profile-card">
                    <img src="{{ $avatarUrl }}" class="dropdown-avatar" alt="Profile large avatar">
                    <div class="dropdown-user-details">
                        <div class="dropdown-name">{{ $displayName }}</div>
                        <div class="dropdown-role">{{ $displayRole }}</div>
                    </div>
                </div>

                <div class="dropdown-divider"></div>

                <div class="dropdown-menu-list">
                    <label class="dropdown-menu-item" id="darkModeToggleItem">
                        <div class="dropdown-item-content">
                            <i class="fa-regular fa-sun text-gray-400 text-base" id="themeIcon"></i>
                            <span class="dropdown-item-text">Dark Mode</span>
                        </div>
                        <div class="modern-switch">
                            <input type="checkbox" id="themeSwitchCheckbox" class="theme-switch-input"
                                aria-label="Toggle Dark Mode">
                            <span class="switch-slider"></span>
                        </div>
                    </label>

                    <form method="POST" action="{{ $logoutRoute }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="dropdown-menu-item dropdown-logout-item">
                            <div class="dropdown-item-content">
                                <i class="fa-solid fa-right-from-bracket text-red-500 text-base"></i>
                                <span class="dropdown-item-text text-red-600">Log out</span>
                            </div>
                            <i class="fa-solid fa-chevron-right text-gray-300 text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
