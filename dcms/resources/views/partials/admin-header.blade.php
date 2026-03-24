<style>
    :root {
        --crimson: #8B0000;
        --crimson-dark: #6b0000;
        --crimson-light: #fef2f2;
        --header-h: 64px;
    }

    .header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 50;
        height: var(--header-h);
        background: linear-gradient(135deg, var(--crimson-dark) 0%, var(--crimson) 100%);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 1.5rem;
        box-shadow: 0 1px 0 rgba(255, 255, 255, .08), 0 4px 24px rgba(139, 0, 0, .3);
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .header-logo {
        width: 34px;
        height: 34px;
        object-fit: contain;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, .2));
    }

    .header-divider {
        width: 1px;
        height: 28px;
        background: rgba(255, 255, 255, .2);
        margin: 0 .25rem;
    }

    .header-title {
        font-size: .85rem;
        font-weight: 700;
        color: #fff;
        letter-spacing: .02em;
        text-transform: uppercase;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .hdr-icon-btn {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(255, 255, 255, .12);
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
        transition: background .15s, transform .15s;
        position: relative;
        text-decoration: none;
    }

    .hdr-icon-btn:hover {
        background: rgba(255, 255, 255, .2);
        transform: translateY(-1px);
    }

    .notif-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        background: #ff4757;
        color: #fff;
        font-size: .58rem;
        font-weight: 800;
        width: 17px;
        height: 17px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid var(--crimson);
        box-shadow: 0 2px 6px rgba(255, 71, 87, .5);
    }

    .header-user-btn {
        display: flex;
        align-items: center;
        gap: .6rem;
        padding: .35rem .75rem .35rem .35rem;
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(255, 255, 255, .12);
        border-radius: 40px;
        cursor: pointer;
        transition: background .15s;
    }

    .header-user-btn:hover {
        background: rgba(255, 255, 255, .18);
    }

    .header-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, .4);
        object-fit: cover;
    }

    .header-user-text {
        line-height: 1;
    }

    .header-name {
        font-size: .78rem;
        font-weight: 700;
        color: #fff;
    }

    .header-role {
        font-size: .64rem;
        color: rgba(255, 255, 255, .65);
        margin-top: 2px;
    }

    #notifDropdown,
    #userDropdown {
        position: relative;
    }

    #notifMenu,
    #userMenu {
        position: absolute;
        right: 0;
        top: calc(100% + 10px);
        background: #fff;
        opacity: 0;
        transform: scale(.95) translateY(-8px);
        pointer-events: none;
        transition: all .2s cubic-bezier(.4, 0, .2, 1);
        transform-origin: top right;
        z-index: 100;
        overflow: hidden;
    }

    #notifMenu {
        width: 320px;
        border-radius: 16px;
        box-shadow: 0 12px 40px rgba(0, 0, 0, .15), 0 0 0 1px rgba(0, 0, 0, .06);
    }

    #userMenu {
        width: 210px;
        border-radius: 14px;
        box-shadow: 0 12px 40px rgba(0, 0, 0, .15), 0 0 0 1px rgba(0, 0, 0, .06);
    }

    #notifMenu.open,
    #userMenu.open {
        opacity: 1;
        transform: scale(1) translateY(0);
        pointer-events: auto;
    }

    .notif-header {
        padding: .85rem 1.1rem .7rem;
        font-weight: 800;
        color: var(--crimson);
        font-size: .8rem;
        border-bottom: 1px solid #fce8e8;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .user-menu-header {
        padding: .85rem 1rem .7rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: .6rem;
    }

    .user-menu-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 2px solid #e5e7eb;
        object-fit: cover;
        flex-shrink: 0;
    }

    .user-menu-name {
        font-size: .78rem;
        font-weight: 800;
        color: #1a202c;
    }

    .user-menu-role {
        font-size: .65rem;
        color: #9ca3af;
    }

    .user-menu-item {
        display: flex;
        align-items: center;
        gap: .65rem;
        padding: .65rem 1rem;
        font-size: .76rem;
        font-weight: 600;
        color: #374151;
        text-decoration: none;
        cursor: pointer;
        transition: background .12s;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        font-family: 'Inter', sans-serif;
    }

    .user-menu-item:hover {
        background: #f9fafb;
    }

    .user-menu-item i {
        width: 14px;
        text-align: center;
        color: #9ca3af;
        font-size: 12px;
    }

    .user-menu-item.danger,
    .user-menu-item.danger i {
        color: #ef4444;
    }

    .user-menu-item.danger:hover {
        background: #fef2f2;
    }

    .user-menu-sep {
        height: 1px;
        background: #f3f4f6;
        margin: 3px 0;
    }

    [data-theme="dark"] #userMenu {
        background: #161b22;
        box-shadow: 0 12px 40px rgba(0, 0, 0, .4), 0 0 0 1px rgba(255, 255, 255, .06);
    }

    [data-theme="dark"] .user-menu-header {
        border-color: #21262d;
    }

    [data-theme="dark"] .user-menu-name {
        color: #f3f4f6;
    }

    [data-theme="dark"] .user-menu-item {
        color: #d1d5db;
    }

    [data-theme="dark"] .user-menu-item:hover {
        background: #1c2128;
    }

    [data-theme="dark"] .user-menu-item.danger {
        color: #f87171;
    }

    [data-theme="dark"] .user-menu-item.danger:hover {
        background: rgba(239, 68, 68, .1);
    }

    [data-theme="dark"] .user-menu-sep {
        background: #21262d;
    }

    @media (max-width: 767px) {
        .header {
            padding: 0 1rem;
        }

        .header-title {
            display: none;
        }
    }
</style>

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
