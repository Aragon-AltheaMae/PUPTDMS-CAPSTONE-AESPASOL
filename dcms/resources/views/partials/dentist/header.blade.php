<header class="header">
    <div class="flex items-center gap-3">
        <button id="mobileMenuBtn" onclick="openDrawer()" aria-label="Open menu">
            <i class="fa-solid fa-bars"></i>
        </button>
        <img src="{{ asset('images/PUP.png') }}" class="header-logo" alt="PUP">
        <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="header-logo" alt="DMS">
        <div class="header-divider"></div>
        <span class="header-title">PUP Taguig Dental Clinic</span>
    </div>
    <div class="flex items-center gap-2 sm:gap-3">
        @php
            $notifications = collect($notifications ?? []);
            $notifCount = $notifications->count();
        @endphp
        <div id="notifDropdown">
            <button class="hdr-icon-btn" id="notifBtn" aria-label="Notifications">
                <i class="fa-regular fa-bell"></i>
                @if ($notifCount > 0)
                    <span class="notif-badge">{{ $notifCount }}</span>
                @endif
            </button>
            <div id="notifMenu">
                <div class="notif-header"><i class="fa-solid fa-bell text-xs"></i> Notifications</div>
                <div style="max-height:260px;overflow-y:auto;">
                    @forelse($notifications as $n)
                        <a href="{{ $n['url'] ?? '#' }}"
                            style="display:block;padding:.65rem 1rem;font-size:.76rem;color:#333;text-decoration:none;border-bottom:1px solid #fdf5f5;"
                            onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background=''">
                            <div style="font-weight:700;">{{ $n['title'] ?? 'Notification' }}</div>
                            @if (!empty($n['message']))
                                <div style="color:#aaa;margin-top:2px;font-size:.7rem;">{{ $n['message'] }}</div>
                            @endif
                        </a>
                    @empty
                        <div style="padding:2.5rem 1rem;text-align:center;color:#bbb;font-size:.76rem;">
                            <i class="fa-regular fa-bell-slash"
                                style="font-size:1.5rem;display:block;margin-bottom:.5rem;"></i>You're all caught up.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <div id="userDropdown">
            <div class="header-user-btn" id="userBtn">
                <img src="{{ asset('images/Nelson-Angeles.jpg') }}" alt="Dr. Nelson P. Angeles" class="header-avatar"
                    onerror="this.src='https://ui-avatars.com/api/?name=Nelson+Angeles&background=660000&color=FFFFFF&size=88'">
                <div class="hidden sm:block" style="line-height:1;">
                    <div class="header-name">Dr. Nelson P. Angeles</div>
                    <div class="header-role">Dentist</div>
                </div>
                <i class="fa-solid fa-chevron-down"
                    style="color:rgba(255,255,255,.5);font-size:.6rem;margin-left:.25rem;"></i>
            </div>
            <div id="userMenu">
                <div class="user-menu-header">
                    <img src="{{ asset('images/Nelson-Angeles.jpg') }}" alt="Dr. Nelson P. Angeles"
                        class="header-avatar"
                        onerror="this.src='https://ui-avatars.com/api/?name=Nelson+Angeles&background=660000&color=FFFFFF&size=88'">
                    <div>
                        <div class="user-menu-name">Dr. Nelson P. Angeles</div>
                        <div class="user-menu-role">Dentist</div>
                    </div>
                </div>
                <div style="padding:.5rem .75rem; border-bottom:1px solid #f3f4f6;">
                    <div
                        style="font-size:.6rem;font-weight:800;letter-spacing:.08em;color:#b0b7c3;text-transform:uppercase;margin-bottom:6px;">
                        Appearance</div>
                    <div class="theme-toggle-container" id="userMenuThemeToggle">
                        <button type="button" class="theme-option active" data-theme="light"><i
                                class="fa-solid fa-sun"></i></button>
                        <button type="button" class="theme-option" data-theme="dark"><i
                                class="fa-regular fa-moon"></i></button>
                        <div class="theme-indicator" aria-hidden="true"></div>
                    </div>
                </div>
                <div class="user-menu-sep"></div>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="user-menu-item danger"><i
                            class="fa-solid fa-right-from-bracket"></i>Log out</button>
                </form>
            </div>
        </div>
    </div>
</header>
