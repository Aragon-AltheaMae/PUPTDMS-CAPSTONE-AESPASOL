<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>System Settings | {{ setting('clinic_name', 'PUP Taguig Dental Clinic') }}</title>  
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

  <script>
    tailwind.config = { daisyui: { themes: false } }
  </script>

  <style>
    :root {
      --crimson: #8B0000;
      --crimson-dark: #6b0000;
      --crimson-light: #fef2f2;
      --header-h: 64px;
    }

    body {
      font-family: 'Inter', sans-serif;
      overflow-x: hidden;
    }

    .scrollbar-thin::-webkit-scrollbar { width: 6px; }
    .scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
    .scrollbar-thin::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }

    /* ── HEADER ── */
    .header {
      position: fixed; top: 0; left: 0; right: 0; z-index: 50;
      height: var(--header-h);
      background: linear-gradient(135deg, var(--crimson-dark) 0%, var(--crimson) 100%);
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 1.5rem;
      box-shadow: 0 1px 0 rgba(255, 255, 255, .08), 0 4px 24px rgba(139, 0, 0, .3);
    }
    .header-left { display: flex; align-items: center; gap: .75rem; }
    .header-logo { width: 34px; height: 34px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0, 0, 0, .2)); }
    .header-divider { width: 1px; height: 28px; background: rgba(255, 255, 255, .2); margin: 0 .25rem; }
    .header-title { font-size: .85rem; font-weight: 700; color: #fff; letter-spacing: .02em; text-transform: uppercase; }
    .header-right { display: flex; align-items: center; gap: .75rem; }
    .hdr-icon-btn {
      width: 38px; height: 38px; border-radius: 10px;
      background: rgba(255, 255, 255, .1); border: 1px solid rgba(255, 255, 255, .12);
      color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center;
      font-size: .9rem; transition: background .15s, transform .15s; position: relative; text-decoration: none;
    }
    .hdr-icon-btn:hover { background: rgba(255, 255, 255, .2); transform: translateY(-1px); }
    .notif-badge {
      position: absolute; top: -4px; right: -4px;
      background: #ff4757; color: #fff; font-size: .58rem; font-weight: 800;
      width: 17px; height: 17px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      border: 2px solid var(--crimson); box-shadow: 0 2px 6px rgba(255, 71, 87, .5);
    }
    .header-user-btn {
      display: flex; align-items: center; gap: .6rem;
      padding: .35rem .75rem .35rem .35rem;
      background: rgba(255, 255, 255, .1); border: 1px solid rgba(255, 255, 255, .12);
      border-radius: 40px; cursor: pointer; transition: background .15s;
    }
    .header-user-btn:hover { background: rgba(255, 255, 255, .18); }
    .header-avatar { width: 30px; height: 30px; border-radius: 50%; border: 2px solid rgba(255, 255, 255, .4); object-fit: cover; }
    .header-user-text { line-height: 1; }
    .header-name { font-size: .78rem; font-weight: 700; color: #fff; }
    .header-role { font-size: .64rem; color: rgba(255, 255, 255, .65); margin-top: 2px; }

    /* Notification dropdown */
    #notifDropdown { position: relative; }
    #notifMenu {
      position: absolute; right: 0; top: calc(100% + 10px);
      width: 320px; background: #fff; border-radius: 16px;
      box-shadow: 0 12px 40px rgba(0, 0, 0, .15), 0 0 0 1px rgba(0, 0, 0, .06);
      opacity: 0; transform: scale(.95) translateY(-8px);
      pointer-events: none; transition: all .2s cubic-bezier(.4, 0, .2, 1);
      transform-origin: top right; z-index: 100; overflow: hidden;
    }
    #notifMenu.open { opacity: 1; transform: scale(1) translateY(0); pointer-events: auto; }
    .notif-header {
      padding: .85rem 1.1rem .7rem; font-weight: 800; color: var(--crimson);
      font-size: .8rem; border-bottom: 1px solid #fce8e8;
      display: flex; align-items: center; gap: .5rem;
    }

    /* User dropdown */
    #userDropdown { position: relative; }
    #userMenu {
      position: absolute; right: 0; top: calc(100% + 10px);
      width: 210px; background: #fff; border-radius: 14px;
      box-shadow: 0 12px 40px rgba(0, 0, 0, .15), 0 0 0 1px rgba(0, 0, 0, .06);
      opacity: 0; transform: scale(.95) translateY(-8px);
      pointer-events: none; transition: all .2s cubic-bezier(.4, 0, .2, 1);
      transform-origin: top right; z-index: 100; overflow: hidden;
    }
    #userMenu.open { opacity: 1; transform: scale(1) translateY(0); pointer-events: auto; }
    .user-menu-header { padding: .85rem 1rem .7rem; border-bottom: 1px solid #f3f4f6; display: flex; align-items: center; gap: .6rem; }
    .user-menu-avatar { width: 32px; height: 32px; border-radius: 50%; border: 2px solid #e5e7eb; object-fit: cover; flex-shrink: 0; }
    .user-menu-name { font-size: .78rem; font-weight: 800; color: #1a202c; }
    .user-menu-role { font-size: .65rem; color: #9ca3af; }
    .user-menu-item {
      display: flex; align-items: center; gap: .65rem; padding: .65rem 1rem;
      font-size: .76rem; font-weight: 600; color: #374151; text-decoration: none; cursor: pointer;
      transition: background .12s; border: none; background: none; width: 100%; text-align: left;
      font-family: 'Inter', sans-serif;
    }
    .user-menu-item:hover { background: #f9fafb; }
    .user-menu-item i { width: 14px; text-align: center; color: #9ca3af; font-size: 12px; }
    .user-menu-item.danger { color: #ef4444; }
    .user-menu-item.danger i { color: #ef4444; }
    .user-menu-item.danger:hover { background: #fef2f2; }
    .user-menu-sep { height: 1px; background: #f3f4f6; margin: 3px 0; }

    /* Dark mode user menu */
    [data-theme="dark"] #userMenu { background: #161b22; box-shadow: 0 12px 40px rgba(0, 0, 0, .4), 0 0 0 1px rgba(255, 255, 255, .06); }
    [data-theme="dark"] .user-menu-header { border-color: #21262d; }
    [data-theme="dark"] .user-menu-name { color: #f3f4f6; }
    [data-theme="dark"] .user-menu-item { color: #d1d5db; }
    [data-theme="dark"] .user-menu-item:hover { background: #1c2128; }
    [data-theme="dark"] .user-menu-item.danger { color: #f87171; }
    [data-theme="dark"] .user-menu-item.danger:hover { background: rgba(239, 68, 68, .1); }
    [data-theme="dark"] .user-menu-sep { background: #21262d; }

    /* ── SIDEBAR ── */
    #sidebar {
      position: fixed; left: 0; top: var(--header-h);
      width: var(--sidebar-w); height: calc(100vh - var(--header-h));
      background: #fff; border-right: 1px solid #eff0f2;
      box-shadow: 4px 0 24px rgba(0, 0, 0, .04); z-index: 40;
      display: flex; flex-direction: column; overflow: hidden;
    }
    .sidebar-inner { flex: 1; overflow-y: auto; overflow-x: hidden; padding: 16px 10px 8px; }
    .nav-section-label { font-size: .6rem; font-weight: 800; color: #b0b7c3; text-transform: uppercase; letter-spacing: .1em; padding: 0 8px 6px; margin-top: 4px; }
    .nav-group { margin-bottom: 2px; }
    .group-trigger { display: flex; align-items: center; gap: 10px; padding: 8px 10px; border-radius: 10px; cursor: default; }
    .group-icon-wrap { width: 32px; height: 32px; border-radius: 8px; background: var(--crimson-light); display: flex; align-items: center; justify-content: center; font-size: 13px; color: var(--crimson); flex-shrink: 0; transition: all .2s; }
    .active-group .group-icon-wrap { background: var(--crimson); color: #fff; box-shadow: 0 4px 12px rgba(139, 0, 0, .3); }
    .group-text { flex: 1; overflow: hidden; }
    .group-label { font-size: .7rem; font-weight: 800; color: var(--crimson); display: block; text-transform: uppercase; letter-spacing: .06em; white-space: nowrap; }
    .group-sublabel { font-size: .62rem; color: #adb5bd; display: block; margin-top: 1px; white-space: nowrap; }
    .group-body { padding: 2px 0 6px; }
    .nav-link { display: flex; align-items: center; gap: 9px; padding: 7px 10px 7px 42px; border-radius: 9px; margin: 1px 2px; font-size: .76rem; font-weight: 500; color: #4a5568; text-decoration: none; transition: all .15s; white-space: nowrap; }
    .nav-link:hover { background: var(--crimson-light); color: var(--crimson); }
    .nav-link.active { background: linear-gradient(135deg, var(--crimson) 0%, var(--crimson-dark) 100%); color: #fff; box-shadow: 0 3px 10px rgba(139, 0, 0, .25); font-weight: 600; }
    .nav-link.active:hover { padding-left: 14px; background: #8B0000; }
    .nav-link i { width: 14px; text-align: center; font-size: 11px; flex-shrink: 0; }
    .nav-sep { height: 1px; background: #f3f4f6; margin: 10px 6px; }
    .sidebar-bottom { padding: 10px 10px 14px; border-top: 1px solid #f3f4f6; flex-shrink: 0; }
    .theme-toggle-container { position: relative; display: flex; align-items: center; width: 100%; height: 36px; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 40px; padding: 3px; }
    .theme-option { position: relative; z-index: 2; flex: 1; height: 100%; display: flex; align-items: center; justify-content: center; background: transparent; border: none; cursor: pointer; color: #9ca3af; transition: color .2s; border-radius: 40px; font-size: 13px; }
    .theme-option.active { color: #374151; }
    .theme-indicator { position: absolute; background: #fff; border-radius: 40px; box-shadow: 0 2px 8px rgba(0, 0, 0, .1); transition: all .3s cubic-bezier(.4, 0, .2, 1); pointer-events: none; width: calc(50% - 3px); height: calc(100% - 6px); left: 3px; top: 3px; }
    .theme-indicator.dark-mode { transform: translateX(calc(100% + 0px)); }
    .logout-btn { display: flex; align-items: center; gap: 10px; width: 100%; padding: 8px 10px; border-radius: 10px; border: none; background: none; cursor: pointer; color: #ef4444; font-size: .76rem; font-weight: 600; transition: background .15s; margin-top: 6px; font-family: 'Inter', sans-serif; }
    .logout-btn:hover { background: #fef2f2; }
    .logout-icon { width: 28px; height: 28px; background: #fef2f2; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 11px; }

    /* ── FOOTER ── */
    #siteFooter { background: var(--crimson); color: rgba(255, 255, 255, .8); padding: 1.25rem 2rem; }
    .footer-inner { max-width: 1280px; margin: 0 auto; display: flex; align-items: center; justify-content: center; gap: 1.5rem; flex-wrap: wrap; font-size: .74rem; }
    .footer-inner a { color: rgba(255, 255, 255, .7); text-decoration: none; transition: color .15s; }
    .footer-inner a:hover { color: #fff; }
    .footer-dot { color: rgba(255, 255, 255, .3); }

    #mainContent, #siteFooter { margin-left: 240px; }

    body, main, footer { transition: background-color .3s ease, color .3s ease; }

    /* ── MOBILE DRAWER ── */
    #mobileMenuBtn { display: none; background: rgba(255, 255, 255, .12); border: none; color: #fff; width: 36px; height: 36px; border-radius: 9px; cursor: pointer; align-items: center; justify-content: center; font-size: 16px; transition: background .15s; flex-shrink: 0; }
    #mobileMenuBtn:hover { background: rgba(255, 255, 255, .22); }
    #mobileDrawerOverlay { display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, .45); z-index: 998; backdrop-filter: blur(2px); opacity: 0; transition: opacity .25s; }
    #mobileDrawerOverlay.open { opacity: 1; }
    #mobileDrawer { position: fixed; top: 0; left: 0; width: 280px; height: 100vh; background: #fff; z-index: 999; display: flex; flex-direction: column; transform: translateX(-100%); transition: transform .3s cubic-bezier(.4, 0, .2, 1); box-shadow: 4px 0 32px rgba(0, 0, 0, .15); overflow: hidden; }
    #mobileDrawer.open { transform: translateX(0); }
    .drawer-header { background: linear-gradient(135deg, #6b0000 0%, #8B0000 100%); padding: 20px 18px 16px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
    .drawer-header-left { display: flex; align-items: center; gap: 10px; }
    .drawer-logo { width: 30px; height: 30px; object-fit: contain; }
    .drawer-title { font-size: .82rem; font-weight: 800; color: #fff; letter-spacing: .01em; line-height: 1.2; }
    .drawer-subtitle { font-size: .75rem; color: #F4F4F4; font-weight: 600; }
    .drawer-close { width: 32px; height: 32px; border-radius: 8px; background: rgba(255, 255, 255, .15); border: none; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 14px; transition: background .15s; }
    .drawer-close:hover { background: rgba(255, 255, 255, .28); }
    .drawer-user { padding: 14px 18px; border-bottom: 1px solid #f3f4f6; display: flex; align-items: center; gap: 10px; background: #fdf9f9; flex-shrink: 0; }
    .drawer-avatar { width: 38px; height: 38px; border-radius: 50%; border: 2px solid #e5e7eb; object-fit: cover; flex-shrink: 0; }
    .drawer-user-name { font-size: .82rem; font-weight: 700; color: #1f2937; }
    .drawer-user-role { font-size: .68rem; color: #9ca3af; font-style: italic; }
    .drawer-inner { flex: 1; overflow-y: auto; padding: 10px 0 6px; }
    .drawer-inner::-webkit-scrollbar { width: 4px; }
    .drawer-inner::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 4px; }
    .drawer-group { margin: 0 8px 2px; }
    .drawer-group-header { display: flex; align-items: center; padding: 6px 8px 4px; color: #6b7280; }
    .drawer-group-icon { width: 30px; height: 30px; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: 13px; color: #8B0000; flex-shrink: 0; }
    .drawer-group-label { font-size: .68rem; font-weight: 700; color: #8B0000; text-transform: uppercase; letter-spacing: .07em; margin-left: 8px; }
    .drawer-link { display: flex; align-items: center; gap: 10px; padding: 8px 10px 8px 40px; border-radius: 8px; margin: 1px 4px; font-size: .78rem; font-weight: 500; color: #374151; text-decoration: none; transition: all .15s; }
    .drawer-link:hover { background: #fef2f2; color: #8B0000; padding-left: 44px; }
    .drawer-link.active { background: #8B0000; color: #fff; box-shadow: 0 2px 8px rgba(139, 0, 0, .2); }
    .drawer-link.active:hover { padding-left: 40px; }
    .drawer-link i { width: 15px; text-align: center; font-size: 11px; }
    .drawer-sep { height: 1px; background: #f3f4f6; margin: 6px 12px; }
    .drawer-bottom { padding: 10px 12px 14px; border-top: 1px solid #f3f4f6; flex-shrink: 0; }

    /* dark mode drawer */
    [data-theme="dark"] #mobileDrawer { background: #0d1117; }
    [data-theme="dark"] .drawer-user { background: #161b22; border-color: #21262d; }
    [data-theme="dark"] .drawer-user-name { color: #e5e7eb; }
    [data-theme="dark"] .drawer-link { color: #d1d5db; }
    [data-theme="dark"] .drawer-link:hover { background: rgba(139, 0, 0, .2); color: #fff; }
    [data-theme="dark"] .drawer-sep { background: #21262d; }
    [data-theme="dark"] .drawer-bottom { border-color: #21262d; }
    [data-theme="dark"] .drawer-group-label { color: #6b7280; }
    [data-theme="dark"] body { background-color: #000D1A; color: #E5E7EB; }
    [data-theme="dark"] #sidebar { background-color: #0d1117; border-right: 1px solid #21262d; }
    [data-theme="dark"] .bg-white { background-color: #161b22 !important; }
    [data-theme="dark"] .text-\[\#333333\] { color: #E5E7EB !important; }
    [data-theme="dark"] .nav-link:hover { background: rgba(139, 0, 0, .2); }
    [data-theme="dark"] .theme-toggle-container { background: #1F1F1F; border-color: #2A2A2A; }
    [data-theme="dark"] .theme-option { color: #6B7280; }
    [data-theme="dark"] .theme-option.active { color: #F3F4F6; }
    [data-theme="dark"] .theme-indicator { background: #2A2A2A; box-shadow: 0 2px 8px rgba(0, 0, 0, .3); }
    [data-theme="dark"] .nav-sep, [data-theme="dark"] .sidebar-bottom { border-color: #21262d; }
    [data-theme="dark"] .group-label { color: #6b7280; }

    @media (max-width:767px) {
      #sidebar { display: none !important; }
      #mainContent { margin-left: 0 !important; padding-bottom: 86px !important; }
      #siteFooter { margin-left: 0 !important; }
      #mobileMenuBtn { display: flex; }
      #mainContent { padding-bottom: 2rem !important; }
      .header { padding: 0 1rem; }
      .header-title { display: none; }
    }

    /* TOAST */
    #toastContainer { position: fixed !important; top: 20px !important; right: 20px !important; z-index: 99999; display: flex; flex-direction: column; gap: 10px; pointer-events: none; }
    #toastContainer .toast { min-width: 300px; max-width: 360px; background: white !important; border-radius: 14px !important; box-shadow: 0 10px 40px rgba(0, 0, 0, .18) !important; padding: 14px 18px 14px 16px !important; display: flex !important; align-items: center !important; gap: 12px; opacity: 0; transform: translateX(340px); transition: all .35s cubic-bezier(.68, -.55, .265, 1.55); position: relative; overflow: hidden; pointer-events: all; flex-direction: row !important; }
    #toastContainer .toast::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px; }
    #toastContainer .toast.error::before { background: #8B0000 !important; }
    #toastContainer .toast.success::before { background: #15803d !important; }
    #toastContainer .toast.show { opacity: 1 !important; transform: translateX(0) !important; }
    #toastContainer .toast.hide { opacity: 0 !important; transform: translateX(340px) !important; }
    #toastContainer .toast-icon-wrap { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    #toastContainer .toast.error .toast-icon-wrap { background: rgba(139, 0, 0, .08); }
    #toastContainer .toast.success .toast-icon-wrap { background: rgba(21, 128, 61, .08); }
    #toastContainer .toast-icon { font-size: 17px; }
    #toastContainer .toast.error .toast-icon { color: #8B0000 !important; }
    #toastContainer .toast.success .toast-icon { color: #15803d !important; }
    #toastContainer .toast-body { flex: 1; min-width: 0; }
    #toastContainer .toast-title { font-size: 13px; font-weight: 700; color: #1A0A0A !important; }
    #toastContainer .toast-msg { font-size: 12px; color: #888 !important; margin-top: 2px; line-height: 1.4; }
    #toastContainer .toast-close { background: none !important; border: none; cursor: pointer; color: #CCC; font-size: 13px; flex-shrink: 0; padding: 2px 4px; }

    /* ── PAGE SPECIFIC ── */
    .stat-mini { transition: transform .2s ease, box-shadow .2s ease; }
    .stat-mini:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0, 0, 0, .1); }

    .settings-nav-item {
      display: flex; align-items: center; gap: 10px; padding: 9px 12px;
      border-radius: 10px; cursor: pointer; transition: all .15s;
      font-size: .78rem; font-weight: 500; color: #4a5568; text-decoration: none; margin-bottom: 2px;
    }
    .settings-nav-item:hover { background: var(--crimson-light); color: var(--crimson); }
    .settings-nav-item.active { background: linear-gradient(135deg, var(--crimson) 0%, var(--crimson-dark) 100%); color: #fff; box-shadow: 0 3px 10px rgba(139, 0, 0, .25); font-weight: 600; }
    .settings-nav-item i { width: 16px; text-align: center; font-size: 12px; flex-shrink: 0; }
    .settings-nav-item .badge { padding: 1px 6px; border-radius: 999px; font-size: .58rem; font-weight: 700; margin-left: auto; }
    .settings-nav-item.active .badge { background: rgba(255, 255, 255, .25); color: #fff; }
    .settings-nav-item:not(.active) .badge { background: #f0f0f0; color: #888; }

    .settings-section { display: none; }
    .settings-section.active { display: block; }

    .form-label { font-size: .72rem; font-weight: 700; color: #5c5550; text-transform: uppercase; letter-spacing: .06em; margin-bottom: .4rem; display: block; }
    .form-ctrl { width: 100%; border: 1.5px solid #e8e2dd; border-radius: 10px; padding: 8px 12px; font-size: .82rem; color: #1a1410; background: #fff; outline: none; transition: border-color .15s, box-shadow .15s; font-family: 'Inter', sans-serif; }
    .form-ctrl:focus { border-color: #8B0000; box-shadow: 0 0 0 3px rgba(139, 0, 0, .08); }
    .form-sel { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; background-size: 16px; padding-right: 32px; }

    .setting-row { display: flex; align-items: center; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid #f8f4f4; }
    .setting-row:last-child { border-bottom: none; }
    .setting-row-info { flex: 1; min-width: 0; padding-right: 1rem; }
    .setting-row-label { font-size: .82rem; font-weight: 700; color: #1a1410; }
    .setting-row-desc { font-size: .72rem; color: #9ca3af; margin-top: 2px; }

    .toggle-wrap { position: relative; display: inline-flex; align-items: center; cursor: pointer; }
    .toggle-wrap input { opacity: 0; width: 0; height: 0; position: absolute; }
    .toggle-slider { width: 42px; height: 24px; background: #e5e7eb; border-radius: 999px; transition: background .2s; position: relative; display: block; }
    .toggle-slider::after { content: ''; position: absolute; top: 3px; left: 3px; width: 18px; height: 18px; background: #fff; border-radius: 50%; transition: transform .2s; box-shadow: 0 1px 4px rgba(0, 0, 0, .2); }
    .toggle-wrap input:checked + .toggle-slider { background: #8B0000; }
    .toggle-wrap input:checked + .toggle-slider::after { transform: translateX(18px); }

    .permission-chip { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 8px; font-size: .68rem; font-weight: 600; background: #fef2f2; color: var(--crimson); border: 1px solid #fce8e8; cursor: pointer; transition: all .15s; user-select: none; }
    .permission-chip:hover, .permission-chip.active { background: var(--crimson); color: #fff; border-color: var(--crimson); }

    .section-card { background: #fff; border-radius: 16px; border: 1px solid #f0eaea; box-shadow: 0 2px 12px rgba(139, 0, 0, .04); overflow: hidden; margin-bottom: 1.25rem; }
    .section-card-hdr { padding: 14px 20px; border-bottom: 1px solid #f8f4f4; background: #fafafa; display: flex; align-items: center; justify-content: space-between; }
    .section-card-hdr-left { display: flex; align-items: center; gap: 8px; }
    .section-card-body { padding: 20px; }

    .badge-online { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; padding: 2px 10px; border-radius: 999px; font-size: .68rem; font-weight: 700; }
    .badge-offline { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; padding: 2px 10px; border-radius: 999px; font-size: .68rem; font-weight: 700; }

    /* Dark mode page-specific */
    [data-theme="dark"] .section-card { background: #161b22; border-color: #21262d; }
    [data-theme="dark"] .section-card-hdr { background: #0d1117; border-color: #21262d; }
    [data-theme="dark"] .setting-row { border-color: #21262d; }
    [data-theme="dark"] .setting-row-label { color: #e5e7eb; }
    [data-theme="dark"] .form-ctrl { background: #0d1117; border-color: #30363d; color: #e6edf3; }
    [data-theme="dark"] .settings-nav-item { color: #d1d5db; }
    [data-theme="dark"] .settings-nav-item:hover { background: rgba(139, 0, 0, .2); color: #fff; }
  </style>
</head>

<body class="bg-[#F4F4F4] text-[#333333]">

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
      @php $notifications = collect($notifications ?? []); $notifCount = $notifications->count(); @endphp
      <div id="notifDropdown">
        <button class="hdr-icon-btn" id="notifBtn" aria-label="Notifications">
          <i class="fa-regular fa-bell"></i>
          @if($notifCount > 0)<span class="notif-badge">{{ $notifCount }}</span>@endif
        </button>
        <div id="notifMenu">
          <div class="notif-header"><i class="fa-solid fa-bell text-xs"></i> Notifications</div>
          <div style="max-height:260px;overflow-y:auto;">
            @forelse($notifications as $n)
            <a href="{{ $n['url'] ?? '#' }}"
              style="display:block;padding:.65rem 1rem;font-size:.76rem;color:#333;text-decoration:none;border-bottom:1px solid #fdf5f5;transition:background .1s;"
              onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background=''">
              <div style="font-weight:700;">{{ $n['title'] ?? 'Notification' }}</div>
              @if(!empty($n['message']))<div style="color:#aaa;margin-top:2px;font-size:.7rem;">{{
                $n['message'] }}
              </div>@endif
            </a>
            @empty
            <div style="padding:2.5rem 1rem;text-align:center;color:#bbb;font-size:.76rem;">
              <i class="fa-regular fa-bell-slash" style="font-size:1.5rem;display:block;margin-bottom:.5rem;"></i>
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
              <button type="button" class="theme-option" data-theme="dark"><i class="fa-regular fa-moon"></i></button>
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
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-calendar-check"></i>
            Appointments</a>
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-tooth"></i>
            Dental Records</a>
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-file-circle-check"></i>
            Document Request</a>
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-file"></i>
            Reports</a>
        </div>
      </div>

      <div class="nav-sep"></div>
      <div class="nav-section-label">Maintenance</div>
      <div class="nav-group">
        <div
          class="group-trigger {{ request()->routeIs('admin.user_management*','admin.role_permissions','admin.academic_periods*','admin.clinic_schedule*') ? 'active-group' : '' }}">
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
            Document Templates</a>
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-boxes-stacked"></i>
            Inventory</a>
        </div>
      </div>

      <div class="nav-sep"></div>
      <div class="nav-section-label">System</div>
      <div class="nav-group">
        <div class="group-trigger {{ request()->routeIs('admin.system_logs','admin.system_settings*') ? 'active-group' : '' }}">
          <div class="group-icon-wrap"><i class="fa-solid fa-server"></i></div>
          <div class="group-text">
            <span class="group-label">System</span>
            <span class="group-sublabel">Admin & configuration</span>
          </div>
        </div>
        <div class="group-body">
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-database"></i>
            Data Backup</a>
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
        <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-calendar-check"></i>
          Appointments</a>
        <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-tooth"></i>
          Dental Records</a>
        <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-file-circle-check"></i>
          Document Request</a>
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
          Document Templates</a>
        <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-boxes-stacked"></i>
          Inventory</a>
      </div>
      <div class="drawer-sep"></div>
      <div class="drawer-group">
        <div class="drawer-group-header"><i class="drawer-group-icon fa-solid fa-server"></i><span
            class="drawer-group-label">System</span></div>
        <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-database"></i>
          Data Backup</a>
        <a href="{{ route('admin.system_logs') }}"
          class="drawer-link {{ request()->routeIs('admin.system_logs') ? 'active' : '' }}"><i
            class="fa-solid fa-clipboard-list"></i> System Logs</a>
        <a href="{{ route('admin.system_settings') }}"
          class="drawer-link {{ request()->routeIs('admin.system_settings*') ? 'active' : '' }}"><i
            class="fa-solid fa-sliders"></i> System Settings</a>
      </div>
    </div>
    <div class="drawer-bottom">
      <div class="theme-toggle-container" id="drawerThemeToggle" style="margin-bottom:10px;">
        <button type="button" class="theme-option active" data-theme="light"><i class="fa-solid fa-sun"></i></button>
        <button type="button" class="theme-option" data-theme="dark"><i class="fa-regular fa-moon"></i></button>
        <div class="theme-indicator" aria-hidden="true"></div>
      </div>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn"><span class="logout-icon"><i class="fa-solid fa-right-from-bracket"
              style="color:#ef4444;"></i></span><span>Log
            out</span></button>
      </form>
    </div>
  </div>

  {{-- MAIN CONTENT --}}
  <main id="mainContent"
    style="padding-top:82px;padding-bottom:2rem;padding-left:1.5rem;padding-right:1.5rem;min-height:100vh;">
    <div style="max-width:1280px;margin:0 auto;">

      @if(session('success'))
      <script>document.addEventListener('DOMContentLoaded', () => showToast('Success', '{{ addslashes(session('success')) }}', 'success'));</script>
      @endif
      @if($errors->any())
      <script>document.addEventListener('DOMContentLoaded', () => showToast('Error', '{{ addslashes($errors->first()) }}', 'error'));</script>
      @endif

      {{-- Title row --}}
      <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
          <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-[#8B0000]">System Settings</h1>
            <p class="text-sm text-gray-500 mt-1">Configure clinic system preferences, notifications, and security.</p>
          </div>
          <div class="flex items-center gap-3">
            <<button type="button" onclick="document.getElementById('settingsForm').submit();"
            class="flex items-center gap-2 bg-[#8B0000] hover:bg-[#760000] text-white px-4 py-2.5 rounded-xl font-semibold text-sm shadow transition-all">
            <i class="fa-solid fa-floppy-disk"></i> Save Changes
            </button>
          </div>
        </div>
      </div>

      {{-- Stat mini cards --}}
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        @php
        $miniCards = [
          ['icon'=>'fa-circle-check','color'=>'from-green-500 to-green-600','val'=>'Online','label'=>'System Status','sub'=>'All services running'],
          ['icon'=>'fa-shield-halved','color'=>'from-[#8B0000] to-[#6B0000]','val'=>'v2.4.1','label'=>'App Version','sub'=>'Last updated today'],
          ['icon'=>'fa-database','color'=>'from-blue-500 to-blue-600','val'=>'98%','label'=>'Storage Used','sub'=>'7.8 GB of 8 GB'],
          ['icon'=>'fa-clock-rotate-left','color'=>'from-amber-500 to-amber-600','val'=>'2h ago','label'=>'Last Backup','sub'=>'Auto backup enabled'],
        ];
        @endphp
        @foreach($miniCards as $card)
        <div class="stat-mini bg-white rounded-xl p-4 shadow border border-gray-100 overflow-hidden relative">
          <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-gray-100 to-transparent rounded-full -mr-10 -mt-10"></div>
          <div class="relative">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $card['color'] }} flex items-center justify-center shadow mb-3">
              <i class="fa-solid {{ $card['icon'] }} text-white text-sm"></i>
            </div>
            <p class="text-[10px] uppercase tracking-wide text-gray-500 font-semibold mb-0.5">{{ $card['label'] }}</p>
            <p class="text-xl font-extrabold text-gray-800">{{ $card['val'] }}</p>
            <p class="text-[10px] text-gray-400 mt-0.5">{{ $card['sub'] }}</p>
          </div>
        </div>
        @endforeach
      </div>

      {{-- Two-column layout --}}
      <form id="settingsForm" action="{{ route('admin.system_settings.update') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

          {{-- LEFT: Settings Navigation --}}
          <div class="settings-sidebar-col lg:col-span-1">
            <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden sticky top-[82px]">
              <div class="px-4 py-3 border-b bg-gray-50">
                <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold">Settings Menu</p>
              </div>
              <div class="p-2">
                <a href="#" class="settings-nav-item active" onclick="switchTab('general', this); return false;"><i class="fa-solid fa-sliders"></i> General</a>
                <a href="#" class="settings-nav-item" onclick="switchTab('clinic', this); return false;"><i class="fa-solid fa-hospital"></i> Clinic Info</a>
                <a href="#" class="settings-nav-item" onclick="switchTab('notifications', this); return false;"><i class="fa-solid fa-bell"></i> Notifications</a>
                <a href="#" class="settings-nav-item" onclick="switchTab('security', this); return false;"><i class="fa-solid fa-shield-halved"></i> Security</a>
                <a href="#" class="settings-nav-item" onclick="switchTab('email', this); return false;"><i class="fa-solid fa-envelope"></i> Email / SMTP</a>
                <a href="#" class="settings-nav-item" onclick="switchTab('backup', this); return false;"><i class="fa-solid fa-database"></i> Backup & Data</a>
                <a href="#" class="settings-nav-item" onclick="switchTab('integrations', this); return false;"><i class="fa-solid fa-plug"></i> Integrations</a>
              </div>
            </div>
          </div>

          {{-- RIGHT: Settings Content --}}
          <div class="lg:col-span-3 space-y-0">

            {{-- ── GENERAL ── --}}
            <div id="tab-general" class="settings-section active">
              <div class="section-card">
                <div class="section-card-hdr">
                  <div class="section-card-hdr-left">
                    <i class="fa-solid fa-sliders text-[#8B0000]"></i>
                    <h2 class="font-bold text-gray-800 text-sm">General Preferences</h2>
                  </div>
                </div>
                <div class="section-card-body">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                      <label class="form-label">System Language</label>
                      <select name="language" class="form-ctrl form-sel">
                        @foreach(['English (US)', 'Filipino'] as $opt)
                          <option {{ old('language', $settings['language']->value ?? 'English (US)') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div>
                      <label class="form-label">Timezone</label>
                      <select name="timezone" class="form-ctrl form-sel">
                        @foreach(['Asia/Manila (UTC+8)', 'UTC'] as $opt)
                          <option {{ old('timezone', $settings['timezone']->value ?? 'Asia/Manila (UTC+8)') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div>
                      <label class="form-label">Date Format</label>
                      <select name="date_format" class="form-ctrl form-sel">
                        @foreach(['MM/DD/YYYY', 'DD/MM/YYYY', 'YYYY-MM-DD'] as $opt)
                          <option {{ old('date_format', $settings['date_format']->value ?? 'MM/DD/YYYY') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div>
                      <label class="form-label">Time Format</label>
                      <select name="time_format" class="form-ctrl form-sel">
                        @foreach(['12-hour (AM/PM)', '24-hour'] as $opt)
                          <option {{ old('time_format', $settings['time_format']->value ?? '12-hour (AM/PM)') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="setting-row">
                    <div class="setting-row-info">
                      <div class="setting-row-label">Maintenance Mode</div>
                      <div class="setting-row-desc">Temporarily disable patient-facing booking portal</div>
                    </div>
                    <label class="toggle-wrap">
                      <input type="checkbox" name="maintenance_mode" value="1"
                        {{ old('maintenance_mode', $settings['maintenance_mode']->value ?? '0') === '1' ? 'checked' : '' }}>
                      <span class="toggle-slider"></span>
                    </label>
                  </div>
                  <div class="setting-row">
                    <div class="setting-row-info">
                      <div class="setting-row-label">Debug Mode</div>
                      <div class="setting-row-desc">Enable detailed error logging for developers</div>
                    </div>
                    <label class="toggle-wrap">
                      <input type="checkbox" name="debug_mode" value="1"
                        {{ old('debug_mode', $settings['debug_mode']->value ?? '0') === '1' ? 'checked' : '' }}>
                      <span class="toggle-slider"></span>
                    </label>
                  </div>
                  <div class="setting-row">
                    <div class="setting-row-info">
                      <div class="setting-row-label">Show Appointment Counter on Dashboard</div>
                      <div class="setting-row-desc">Display real-time booking stats on admin home</div>
                    </div>
                    <label class="toggle-wrap">
                      <input type="checkbox" name="show_appt_counter" value="1"
                        {{ old('show_appt_counter', $settings['show_appt_counter']->value ?? '1') === '1' ? 'checked' : '' }}>
                      <span class="toggle-slider"></span>
                    </label>
                  </div>
                </div>
              </div>
            </div>

            {{-- ── CLINIC INFO ── --}}
            <div id="tab-clinic" class="settings-section">
              <div class="section-card">
                <div class="section-card-hdr">
                  <div class="section-card-hdr-left">
                    <i class="fa-solid fa-hospital text-[#8B0000]"></i>
                    <h2 class="font-bold text-gray-800 text-sm">Clinic Information</h2>
                  </div>
                </div>
                <div class="section-card-body">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="md:col-span-2">
                      <label class="form-label">Clinic Name</label>
                      <input type="text" name="clinic_name" class="form-ctrl" placeholder="Clinic name"
                        value="{{ old('clinic_name', $settings['clinic_name']->value ?? 'PUP Taguig Dental Clinic') }}">
                    </div>
                    <div>
                      <label class="form-label">Contact Number</label>
                      <input type="text" name="contact_number" class="form-ctrl" placeholder="+63 ..."
                        value="{{ old('contact_number', $settings['contact_number']->value ?? '') }}">
                    </div>
                    <div>
                      <label class="form-label">Email Address</label>
                      <input type="email" name="email_address" class="form-ctrl" placeholder="email@example.com"
                        value="{{ old('email_address', $settings['email_address']->value ?? '') }}">
                    </div>
                    <div class="md:col-span-2">
                      <label class="form-label">Address</label>
                      <input type="text" name="address" class="form-ctrl" placeholder="Full address"
                        value="{{ old('address', $settings['address']->value ?? '') }}">
                    </div>
                    <div>
                      <label class="form-label">Operating Since</label>
                      <input type="text" name="operating_since" class="form-ctrl" placeholder="Year"
                        value="{{ old('operating_since', $settings['operating_since']->value ?? '1998') }}">
                    </div>
                    <div>
                      <label class="form-label">Accreditation No.</label>
                      <input type="text" name="accreditation_no" class="form-ctrl" placeholder="License / accreditation number"
                        value="{{ old('accreditation_no', $settings['accreditation_no']->value ?? '') }}">
                    </div>
                  </div>
                  <div>
                    <label class="form-label">Clinic Description</label>
                    <textarea name="description" class="form-ctrl resize-none" rows="3"
                      placeholder="Short description shown on patient portal…">{{ old('description', $settings['description']->value ?? 'The PUP Taguig Dental Clinic provides free dental services to PUP students, faculty, and staff.') }}</textarea>
                  </div>
                </div>
              </div>
            </div>

            {{-- ── NOTIFICATIONS ── --}}
            <div id="tab-notifications" class="settings-section">
              <div class="section-card">
                <div class="section-card-hdr">
                  <div class="section-card-hdr-left">
                    <i class="fa-solid fa-bell text-[#8B0000]"></i>
                    <h2 class="font-bold text-gray-800 text-sm">Notification Preferences</h2>
                  </div>
                </div>
                <div class="section-card-body">
                  <p class="text-xs text-gray-400 mb-4 font-medium uppercase tracking-wide">Admin Alerts</p>
                  <div class="setting-row">
                    <div class="setting-row-info">
                      <div class="setting-row-label">New Appointment Booked</div>
                      <div class="setting-row-desc">Notify admin when a patient books an appointment</div>
                    </div>
                    <label class="toggle-wrap">
                      <input type="checkbox" name="notif_new_appointment" value="1"
                        {{ old('notif_new_appointment', $settings['notif_new_appointment']->value ?? '1') === '1' ? 'checked' : '' }}>
                      <span class="toggle-slider"></span>
                    </label>
                  </div>
                  <div class="setting-row">
                    <div class="setting-row-info">
                      <div class="setting-row-label">Appointment Cancellation</div>
                      <div class="setting-row-desc">Notify when a patient cancels or no-shows</div>
                    </div>
                    <label class="toggle-wrap">
                      <input type="checkbox" name="notif_cancellation" value="1"
                        {{ old('notif_cancellation', $settings['notif_cancellation']->value ?? '1') === '1' ? 'checked' : '' }}>
                      <span class="toggle-slider"></span>
                    </label>
                  </div>
                  <div class="setting-row">
                    <div class="setting-row-info">
                      <div class="setting-row-label">Document Request Submitted</div>
                      <div class="setting-row-desc">Alert when a patient requests a dental certificate</div>
                    </div>
                    <label class="toggle-wrap">
                      <input type="checkbox" name="notif_document_request" value="1"
                        {{ old('notif_document_request', $settings['notif_document_request']->value ?? '1') === '1' ? 'checked' : '' }}>
                      <span class="toggle-slider"></span>
                    </label>
                  </div>
                  <div class="mt-5 mb-4 pt-4 border-t border-gray-50">
                    <p class="text-xs text-gray-400 mb-4 font-medium uppercase tracking-wide">Patient Reminders</p>
                    <div class="setting-row">
                      <div class="setting-row-info">
                        <div class="setting-row-label">Appointment Reminder (24h before)</div>
                        <div class="setting-row-desc">Send an email/SMS to patient 24 hours before their slot</div>
                      </div>
                      <label class="toggle-wrap">
                        <input type="checkbox" name="notif_reminder_24h" value="1"
                          {{ old('notif_reminder_24h', $settings['notif_reminder_24h']->value ?? '1') === '1' ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                      </label>
                    </div>
                    <div class="setting-row">
                      <div class="setting-row-info">
                        <div class="setting-row-label">Appointment Confirmation</div>
                        <div class="setting-row-desc">Send confirmation email immediately after booking</div>
                      </div>
                      <label class="toggle-wrap">
                        <input type="checkbox" name="notif_confirmation" value="1"
                          {{ old('notif_confirmation', $settings['notif_confirmation']->value ?? '1') === '1' ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                      </label>
                    </div>
                    <div class="setting-row">
                      <div class="setting-row-info">
                        <div class="setting-row-label">Follow-up Reminder</div>
                        <div class="setting-row-desc">Remind patients of recommended follow-up schedule</div>
                      </div>
                      <label class="toggle-wrap">
                        <input type="checkbox" name="notif_followup" value="1"
                          {{ old('notif_followup', $settings['notif_followup']->value ?? '0') === '1' ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                      </label>
                    </div>
                  </div>
                  <div class="mt-4">
                    <label class="form-label">Notification Channels</label>
                    <p class="text-xs text-gray-400 mb-2">Click to toggle. Selected channels will be saved.</p>
                    @php $savedChannels = old('notif_channels', $settings['notif_channels']->value ?? 'Email,SMS'); @endphp
                    <div class="flex flex-wrap gap-2 mt-1">
                      @foreach(['Email','SMS','WhatsApp','In-App'] as $channel)
                      <label class="permission-chip {{ str_contains($savedChannels, $channel) ? 'active' : '' }}">
                        <input type="checkbox" name="notif_channels[]" value="{{ $channel }}" class="hidden"
                          {{ str_contains($savedChannels, $channel) ? 'checked' : '' }}
                          onchange="this.closest('label').classList.toggle('active', this.checked)">
                        @if($channel === 'Email') <i class="fa-solid fa-envelope text-[10px]"></i>
                        @elseif($channel === 'SMS') <i class="fa-solid fa-mobile-screen text-[10px]"></i>
                        @elseif($channel === 'WhatsApp') <i class="fa-brands fa-whatsapp text-[10px]"></i>
                        @else <i class="fa-solid fa-bell text-[10px]"></i>
                        @endif
                        {{ $channel }}
                      </label>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- ── SECURITY ── --}}
            <div id="tab-security" class="settings-section">
              <div class="section-card">
                <div class="section-card-hdr">
                  <div class="section-card-hdr-left">
                    <i class="fa-solid fa-shield-halved text-[#8B0000]"></i>
                    <h2 class="font-bold text-gray-800 text-sm">Security Settings</h2>
                  </div>
                </div>
                <div class="section-card-body">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                      <label class="form-label">Session Timeout (minutes)</label>
                      <input type="number" name="session_timeout" class="form-ctrl" min="5" max="480"
                        value="{{ old('session_timeout', $settings['session_timeout']->value ?? 60) }}">
                    </div>
                    <div>
                      <label class="form-label">Max Login Attempts</label>
                      <input type="number" name="max_login_attempts" class="form-ctrl" min="1" max="20"
                        value="{{ old('max_login_attempts', $settings['max_login_attempts']->value ?? 5) }}">
                    </div>
                    <div>
                      <label class="form-label">Lockout Duration (minutes)</label>
                      <input type="number" name="lockout_duration" class="form-ctrl" min="1" max="60"
                        value="{{ old('lockout_duration', $settings['lockout_duration']->value ?? 15) }}">
                    </div>
                    <div>
                      <label class="form-label">Min Password Length</label>
                      <input type="number" name="min_password_length" class="form-ctrl" min="6" max="32"
                        value="{{ old('min_password_length', $settings['min_password_length']->value ?? 8) }}">
                    </div>
                  </div>
                  <div class="setting-row">
                    <div class="setting-row-info">
                      <div class="setting-row-label">Two-Factor Authentication (2FA)</div>
                      <div class="setting-row-desc">Require OTP for admin login via email or authenticator app</div>
                    </div>
                    <label class="toggle-wrap">
                      <input type="checkbox" name="two_factor_auth" value="1"
                        {{ old('two_factor_auth', $settings['two_factor_auth']->value ?? '0') === '1' ? 'checked' : '' }}>
                      <span class="toggle-slider"></span>
                    </label>
                  </div>
                  <div class="setting-row">
                    <div class="setting-row-info">
                      <div class="setting-row-label">Force HTTPS</div>
                      <div class="setting-row-desc">Redirect all HTTP traffic to HTTPS</div>
                    </div>
                    <label class="toggle-wrap">
                      <input type="checkbox" name="force_https" value="1"
                        {{ old('force_https', $settings['force_https']->value ?? '1') === '1' ? 'checked' : '' }}>
                      <span class="toggle-slider"></span>
                    </label>
                  </div>
                  <div class="setting-row">
                    <div class="setting-row-info">
                      <div class="setting-row-label">Log Failed Login Attempts</div>
                      <div class="setting-row-desc">Record failed logins to system audit log</div>
                    </div>
                    <label class="toggle-wrap">
                      <input type="checkbox" name="log_failed_logins" value="1"
                        {{ old('log_failed_logins', $settings['log_failed_logins']->value ?? '1') === '1' ? 'checked' : '' }}>
                      <span class="toggle-slider"></span>
                    </label>
                  </div>
                  <div class="setting-row">
                    <div class="setting-row-info">
                      <div class="setting-row-label">Require Password Change Every 90 Days</div>
                      <div class="setting-row-desc">Prompt users to update password periodically</div>
                    </div>
                    <label class="toggle-wrap">
                      <input type="checkbox" name="force_password_change" value="1"
                        {{ old('force_password_change', $settings['force_password_change']->value ?? '0') === '1' ? 'checked' : '' }}>
                      <span class="toggle-slider"></span>
                    </label>
                  </div>
                  <div class="mt-5 pt-4 border-t border-gray-50">
                    <label class="form-label">Password Requirements</label>
                    @php $savedReqs = old('password_requirements', $settings['password_requirements']->value ?? 'Uppercase,Numbers,Symbols'); @endphp
                    <div class="flex flex-wrap gap-2 mt-2">
                      @foreach(['Uppercase','Numbers','Symbols','No Dictionary Words'] as $req)
                      <label class="permission-chip {{ str_contains($savedReqs, $req) ? 'active' : '' }}">
                        <input type="checkbox" name="password_requirements[]" value="{{ $req }}" class="hidden"
                          {{ str_contains($savedReqs, $req) ? 'checked' : '' }}
                          onchange="this.closest('label').classList.toggle('active', this.checked)">
                        {{ $req }}
                      </label>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- ── EMAIL / SMTP ── --}}
            <div id="tab-email" class="settings-section">
              <div class="section-card">
                <div class="section-card-hdr">
                  <div class="section-card-hdr-left">
                    <i class="fa-solid fa-envelope text-[#8B0000]"></i>
                    <h2 class="font-bold text-gray-800 text-sm">Email / SMTP Configuration</h2>
                  </div>
                  <span class="badge-online">Connected</span>
                </div>
                <div class="section-card-body">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                      <label class="form-label">SMTP Host</label>
                      <input type="text" name="smtp_host" class="form-ctrl" placeholder="smtp.host.com"
                        value="{{ old('smtp_host', $settings['smtp_host']->value ?? 'smtp.gmail.com') }}">
                    </div>
                    <div>
                      <label class="form-label">SMTP Port</label>
                      <input type="number" name="smtp_port" class="form-ctrl" placeholder="587"
                        value="{{ old('smtp_port', $settings['smtp_port']->value ?? 587) }}">
                    </div>
                    <div>
                      <label class="form-label">Encryption</label>
                      <select name="smtp_encryption" class="form-ctrl form-sel">
                        @foreach(['TLS','SSL','None'] as $opt)
                          <option {{ old('smtp_encryption', $settings['smtp_encryption']->value ?? 'TLS') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div>
                      <label class="form-label">SMTP Username</label>
                      <input type="text" name="smtp_username" class="form-ctrl" placeholder="user@domain.com"
                        value="{{ old('smtp_username', $settings['smtp_username']->value ?? '') }}">
                    </div>
                    <div>
                      <label class="form-label">SMTP Password</label>
                      <input type="password" name="smtp_password" class="form-ctrl" placeholder="App password"
                        value="{{ old('smtp_password', $settings['smtp_password']->value ?? '') }}">
                    </div>
                    <div>
                      <label class="form-label">From Name</label>
                      <input type="text" name="mail_from_name" class="form-ctrl" placeholder="Sender name"
                        value="{{ old('mail_from_name', $settings['mail_from_name']->value ?? 'PUP Taguig Dental Clinic') }}">
                    </div>
                    <div>
                      <label class="form-label">From Email</label>
                      <input type="email" name="mail_from_address" class="form-ctrl" placeholder="noreply@domain.com"
                        value="{{ old('mail_from_address', $settings['mail_from_address']->value ?? '') }}">
                    </div>
                  </div>
                  <div class="mt-5 flex items-center gap-3">
                    <button type="button"
                      onclick="showToast('Email Test', 'Test email sent to admin@puptaguig.edu.ph', 'success')"
                      class="flex items-center gap-2 text-sm font-semibold text-[#8B0000] bg-red-50 border border-red-200 px-4 py-2 rounded-xl hover:bg-red-100 transition-all">
                      <i class="fa-solid fa-paper-plane text-xs"></i> Send Test Email
                    </button>
                  </div>
                </div>
              </div>
            </div>

            {{-- ── BACKUP & DATA ── --}}
            <div id="tab-backup" class="settings-section">
              <div class="section-card">
                <div class="section-card-hdr">
                  <div class="section-card-hdr-left">
                    <i class="fa-solid fa-database text-[#8B0000]"></i>
                    <h2 class="font-bold text-gray-800 text-sm">Backup & Data Management</h2>
                  </div>
                </div>
                <div class="section-card-body">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                      <label class="form-label">Auto Backup Frequency</label>
                      <select name="backup_frequency" class="form-ctrl form-sel">
                        @foreach(['Every 6 hours','Daily','Weekly','Monthly'] as $opt)
                          <option {{ old('backup_frequency', $settings['backup_frequency']->value ?? 'Daily') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div>
                      <label class="form-label">Backup Retention (days)</label>
                      <input type="number" name="backup_retention_days" class="form-ctrl" min="7" max="365"
                        value="{{ old('backup_retention_days', $settings['backup_retention_days']->value ?? 30) }}">
                    </div>
                    <div>
                      <label class="form-label">Backup Storage Location</label>
                      <select name="backup_storage" class="form-ctrl form-sel">
                        @foreach(['Local Server','Google Drive','AWS S3'] as $opt)
                          <option {{ old('backup_storage', $settings['backup_storage']->value ?? 'Google Drive') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div>
                      <label class="form-label">Backup Time</label>
                      <input type="time" name="backup_time" class="form-ctrl"
                        value="{{ old('backup_time', $settings['backup_time']->value ?? '02:00') }}">
                    </div>
                  </div>
                  <div class="setting-row">
                    <div class="setting-row-info">
                      <div class="setting-row-label">Auto Backup Enabled</div>
                      <div class="setting-row-desc">Automatically backup database on the schedule above</div>
                    </div>
                    <label class="toggle-wrap">
                      <input type="checkbox" name="auto_backup_enabled" value="1"
                        {{ old('auto_backup_enabled', $settings['auto_backup_enabled']->value ?? '1') === '1' ? 'checked' : '' }}>
                      <span class="toggle-slider"></span>
                    </label>
                  </div>
                  <div class="setting-row">
                    <div class="setting-row-info">
                      <div class="setting-row-label">Include File Attachments</div>
                      <div class="setting-row-desc">Include uploaded documents and images in the backup</div>
                    </div>
                    <label class="toggle-wrap">
                      <input type="checkbox" name="backup_include_files" value="1"
                        {{ old('backup_include_files', $settings['backup_include_files']->value ?? '1') === '1' ? 'checked' : '' }}>
                      <span class="toggle-slider"></span>
                    </label>
                  </div>
                  <div class="setting-row">
                    <div class="setting-row-info">
                      <div class="setting-row-label">Encrypt Backups</div>
                      <div class="setting-row-desc">Use AES-256 encryption on all backup files</div>
                    </div>
                    <label class="toggle-wrap">
                      <input type="checkbox" name="backup_encrypt" value="1"
                        {{ old('backup_encrypt', $settings['backup_encrypt']->value ?? '1') === '1' ? 'checked' : '' }}>
                      <span class="toggle-slider"></span>
                    </label>
                  </div>
                  <div class="mt-5 pt-4 border-t border-gray-50 flex flex-wrap items-center gap-3">
                    <button type="button"
                      onclick="showToast('Backup Started', 'Manual backup is running in the background.', 'success')"
                      class="flex items-center gap-2 text-sm font-semibold text-[#8B0000] bg-red-50 border border-red-200 px-4 py-2 rounded-xl hover:bg-red-100 transition-all">
                      <i class="fa-solid fa-database text-xs"></i> Run Backup Now
                    </button>
                    <button type="button"
                      onclick="showToast('Download', 'Preparing latest backup for download…', 'success')"
                      class="flex items-center gap-2 text-sm font-semibold text-gray-600 bg-gray-50 border border-gray-200 px-4 py-2 rounded-xl hover:bg-gray-100 transition-all">
                      <i class="fa-solid fa-download text-xs"></i> Download Latest Backup
                    </button>
                  </div>
                </div>
              </div>
            </div>

            {{-- ── INTEGRATIONS ── --}}
            <div id="tab-integrations" class="settings-section">
              <div class="section-card">
                <div class="section-card-hdr">
                  <div class="section-card-hdr-left">
                    <i class="fa-solid fa-plug text-[#8B0000]"></i>
                    <h2 class="font-bold text-gray-800 text-sm">Third-Party Integrations</h2>
                  </div>
                </div>
                <div class="section-card-body">
                  @php
                  $integrations = [
                    ['icon'=>'fa-brands fa-google','name'=>'Google Calendar','desc'=>'Sync appointments with Google Calendar for staff','color'=>'text-red-500','status'=>'connected'],
                    ['icon'=>'fa-brands fa-google-drive','name'=>'Google Drive','desc'=>'Store backup files and documents in Google Drive','color'=>'text-yellow-500','status'=>'connected'],
                    ['icon'=>'fa-solid fa-message-sms','name'=>'Semaphore SMS','desc'=>'Send SMS reminders to patients via Semaphore','color'=>'text-blue-500','status'=>'disconnected'],
                    ['icon'=>'fa-brands fa-facebook-messenger','name'=>'Facebook Page','desc'=>'Connect clinic Facebook page for announcements','color'=>'text-blue-600','status'=>'disconnected'],
                    ['icon'=>'fa-solid fa-chart-bar','name'=>'Google Analytics','desc'=>'Track portal usage and patient behavior','color'=>'text-orange-500','status'=>'disconnected'],
                  ];
                  @endphp
                  @foreach($integrations as $integ)
                  <div class="setting-row {{ $loop->last ? '!border-b-0' : '' }}">
                    <div class="flex items-center gap-3 flex-1 min-w-0 pr-3">
                      <div class="w-9 h-9 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center flex-shrink-0">
                        <i class="{{ $integ['icon'] }} {{ $integ['color'] }} text-sm"></i>
                      </div>
                      <div class="min-w-0">
                        <div class="setting-row-label">{{ $integ['name'] }}</div>
                        <div class="setting-row-desc">{{ $integ['desc'] }}</div>
                      </div>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                      @if($integ['status'] === 'connected')
                        <span class="badge-online">Connected</span>
                        <button type="button"
                          onclick="showToast('Disconnected', '{{ $integ['name'] }} has been disconnected.', 'error')"
                          class="text-xs text-gray-400 hover:text-red-500 font-semibold transition-colors">Disconnect</button>
                      @else
                        <span class="badge-offline">Not Connected</span>
                        <button type="button"
                          onclick="showToast('Integration', 'Redirecting to {{ $integ['name'] }} authorization…', 'success')"
                          class="text-xs text-[#8B0000] font-semibold hover:underline transition-colors">Connect</button>
                      @endif
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>

            {{-- Save bar --}}
            <div class="bg-white rounded-xl shadow border border-gray-100 px-5 py-4 flex items-center justify-between mt-4">
              <p class="text-xs text-gray-400">Changes are saved per section. Remember to click <strong class="text-gray-600">Save Changes</strong> before navigating away.</p>
              <div class="flex items-center gap-3">
                <button type="button"
                  onclick="showToast('Reset', 'Settings have been reset to defaults.', 'error')"
                  class="text-sm font-semibold text-gray-500 hover:text-gray-700 px-4 py-2 rounded-xl border border-gray-200 hover:bg-gray-50 transition-all">
                  Reset to Defaults
                </button>
                <button type="button" onclick="document.getElementById('settingsForm').submit();"
                    class="flex items-center gap-2 bg-[#8B0000] hover:bg-[#760000] text-white px-5 py-2 rounded-xl font-semibold text-sm shadow transition-all">
                    <i class="fa-solid fa-floppy-disk"></i> Save Changes
                </button>
              </div>
            </div>

          </div>
        </div>
      </form>

    </div>
  </main>

  <!-- FOOTER -->
  <footer id="siteFooter">
    <div class="footer-inner">
      <span style="color:rgba(255,255,255,.5);">© 1998–2026</span>
      <span style="font-weight:700;color:#fff;">Polytechnic University of the Philippines</span>
      <span class="footer-dot">·</span>
      <a href="https://www.pup.edu.ph/terms/">Terms of Use</a>
      <span class="footer-dot">·</span>
      <a href="https://www.pup.edu.ph/privacy/">Privacy Statement</a>
    </div>
  </footer>

  <script>
    // Toast
    function showToast(title, message, type = 'error') {
      const c = document.getElementById('toastContainer');
      const t = document.createElement('div');
      t.className = 'toast ' + type;
      const icon = type === 'error'
        ? '<i class="fa-solid fa-circle-exclamation toast-icon"></i>'
        : '<i class="fa-solid fa-circle-check toast-icon"></i>';
      t.innerHTML = `<div class="toast-icon-wrap">${icon}</div>
        <div class="toast-body"><div class="toast-title">${title}</div>
        <div class="toast-msg">${message}</div></div>
        <button class="toast-close" onclick="this.closest('.toast').classList.add('hide')"><i class="fa-solid fa-xmark"></i></button>`;
      c.appendChild(t);
      requestAnimationFrame(() => requestAnimationFrame(() => t.classList.add('show')));
      setTimeout(() => { t.classList.remove('show'); t.classList.add('hide'); setTimeout(() => t.remove(), 400); }, 4500);
    }

    // Notifications
    document.getElementById('notifBtn').addEventListener('click', e => {
      e.stopPropagation();
      document.getElementById('notifMenu').classList.toggle('open');
    });
    document.addEventListener('click', () => document.getElementById('notifMenu').classList.remove('open'));

    // User dropdown
    document.getElementById('userBtn').addEventListener('click', e => {
      e.stopPropagation();
      document.getElementById('userMenu').classList.toggle('open');
    });
    document.addEventListener('click', () => document.getElementById('userMenu').classList.remove('open'));

    // Mobile drawer
    function openDrawer() {
      const drawer = document.getElementById('mobileDrawer');
      const overlay = document.getElementById('mobileDrawerOverlay');
      overlay.style.display = 'block';
      requestAnimationFrame(() => { overlay.classList.add('open'); drawer.classList.add('open'); });
      document.body.style.overflow = 'hidden';
    }
    function closeDrawer() {
      const drawer = document.getElementById('mobileDrawer');
      const overlay = document.getElementById('mobileDrawerOverlay');
      drawer.classList.remove('open'); overlay.classList.remove('open');
      setTimeout(() => { overlay.style.display = 'none'; }, 250);
      document.body.style.overflow = '';
    }
    document.getElementById('mobileMenuBtn')?.addEventListener('click', e => { e.stopPropagation(); openDrawer(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDrawer(); });

    /* Sync drawer theme toggles with main theme */
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('#drawerThemeToggle .theme-option').forEach(o =>
        o.addEventListener('click', e => {
          e.stopPropagation();
          applyTheme(o.getAttribute('data-theme'));
          const ind = document.querySelector('#drawerThemeToggle .theme-indicator');
          if (ind) ind.classList.toggle('dark-mode', o.getAttribute('data-theme') === 'dark');
        })
      );
    });

    // Theme
    const html = document.documentElement;
    function applyTheme(theme) {
      html.setAttribute('data-theme', theme); localStorage.setItem('theme', theme);
      document.querySelectorAll('.theme-option').forEach(o => o.getAttribute('data-theme') === theme ? o.classList.add('active') : o.classList.remove('active'));
      const ind = document.querySelector('.theme-indicator'); if (ind) ind.classList.toggle('dark-mode', theme === 'dark');
    }
    document.addEventListener('DOMContentLoaded', () => {
      applyTheme(localStorage.getItem('theme') || 'light');
      document.querySelectorAll('.theme-option').forEach(o => o.addEventListener('click', e => { e.stopPropagation(); applyTheme(o.getAttribute('data-theme')); }));
    });

    // Settings tab switching
    function switchTab(tabId, el) {
      document.querySelectorAll('.settings-section').forEach(s => s.classList.remove('active'));
      document.querySelectorAll('.settings-nav-item').forEach(n => n.classList.remove('active'));
      const section = document.getElementById('tab-' + tabId);
      if (section) section.classList.add('active');
      if (el) el.classList.add('active');
    }
  </script>
</body>

</html>