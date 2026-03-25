<!-- TERMS MODAL -->
<dialog id="termsModal">
    <div class="terms-header">
        <div class="terms-header-icon"><i class="fa-solid fa-file-shield"></i></div>
        <div>
            <h2>Terms and Conditions</h2>
            <p>Please read and accept before continuing</p>
        </div>
    </div>
    <div class="terms-body">
        <p>
            By clicking <strong>"I Agree"</strong>, you consent to the collection, use, and
            processing of your personal data for legitimate purposes related to this service.
        </p>
        <p style="margin-bottom:0;">
            Your information will be handled in accordance with our <strong>Privacy Policy</strong>
            and in compliance with the <strong>Data Privacy Act of 2012</strong>.
        </p>
        <div class="terms-divider"></div>
        <label class="terms-checkbox-row">
            <input type="checkbox" id="termsCheckbox">
            <span>I have read and agree to the Terms and Conditions</span>
        </label>
        <div class="terms-actions">
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="terms-cancel-btn">Cancel</button>
            </form>
            <button id="termsContinueBtn" class="terms-continue-btn" disabled onclick="acceptTerms()">
                <i class="fa-solid fa-check" style="font-size:.75rem; margin-right:5px;"></i> Continue
            </button>
        </div>
    </div>
</dialog>

<!-- TOAST -->
<div id="toastContainer" role="region" aria-live="polite"></div>

<!-- ════════ HEADER ════════ -->
<header class="header">
    <div class="header-left">
        <button id="mobileMenuBtn" aria-label="Open menu"><i class="fa-solid fa-bars"></i></button>
        <img src="{{ asset('images/PUP.png') }}" class="header-logo" alt="PUP">
        <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="header-logo" alt="DMS">
        <div class="header-divider"></div>
        <span class="header-title">PUP Taguig Dental Clinic</span>
    </div>
    <div class="header-right">
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
                            style="display:block;padding:.65rem 1rem;font-size:.76rem;color:#333;text-decoration:none;border-bottom:1px solid #fdf5f5;transition:background .1s;"
                            onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background=''">
                            <div style="font-weight:700;">{{ $n['title'] ?? 'Notification' }}</div>
                            @if (!empty($n['message']))
                                <div style="color:#aaa;margin-top:2px;font-size:.7rem;">{{ $n['message'] }}
                                </div>
                            @endif
                        </a>
                    @empty
                        <div style="padding:2.5rem 1rem;text-align:center;color:#bbb;font-size:.76rem;">
                            <i class="fa-regular fa-bell-slash"
                                style="font-size:1.5rem;display:block;margin-bottom:.5rem;"></i>
                            You're all caught up.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Palitan ng system settings na route --}}
        <a href="{{ route('admin.system_settings') }}" class="hdr-icon-btn" aria-label="Settings">
            <i class="fa-solid fa-gear"></i>
        </a>

        <div id="userDropdown">
            <div class="header-user-btn" id="userBtn">
                <img src="https://i.pravatar.cc/40" class="header-avatar" alt="Avatar">
                <div class="header-user-text">
                    <div class="header-name">Admin</div>
                    <div class="header-role">Administrator</div>
                </div>
                <i class="fa-solid fa-chevron-down"
                    style="color:rgba(255,255,255,.5);font-size:.6rem;margin-left:.25rem;"></i>
            </div>
            <div id="userMenu">
                <div class="user-menu-header">
                    <img src="https://i.pravatar.cc/40" class="user-menu-avatar" alt="Avatar">
                    <div>
                        <div class="user-menu-name">Admin</div>
                        <div class="user-menu-role">Administrator</div>
                    </div>
                </div>
                <!-- Dark mode toggle inside dropdown -->
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
                    <button type="submit" class="user-menu-item danger">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Log out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
