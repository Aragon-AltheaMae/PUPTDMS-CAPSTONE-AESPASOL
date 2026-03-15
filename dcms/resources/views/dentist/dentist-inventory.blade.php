<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Inventory | PUP Taguig Dental Clinic</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <style>
    :root {
      --crimson: #8B0000;
      --crimson-dark: #6b0000;
      --crimson-light: #fef2f2;
      --crimson-mid: #fce8e8;
      --sidebar-w: 256px;
      --header-h: 64px;
    }

    body {
      font-family: 'Inter', sans-serif;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(6px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-in {
      animation: fadeIn 0.6s ease-out forwards;
    }

    /* ── TOAST ── */
    #toastContainer {
      position: fixed;
      bottom: 28px;
      right: 28px;
      z-index: 9999;
      display: flex;
      flex-direction: column;
      gap: 10px;
      pointer-events: none;
    }

    .toast-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 13px 18px;
      border-radius: 12px;
      font-size: 13px;
      font-weight: 600;
      color: #fff;
      box-shadow: 0 6px 24px rgba(0, 0, 0, .18);
      pointer-events: auto;
      animation: toastIn .3s cubic-bezier(.4, 0, .2, 1) forwards;
      min-width: 220px;
    }

    .toast-item.success {
      background: #1A6B34;
    }

    .toast-item.error {
      background: #C0392B;
    }

    @keyframes toastIn {
      from {
        opacity: 0;
        transform: translateY(14px) scale(.96);
      }

      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    @keyframes toastOut {
      from {
        opacity: 1;
        transform: translateY(0) scale(1);
      }

      to {
        opacity: 0;
        transform: translateY(14px) scale(.96);
      }
    }

    .toast-item.leaving {
      animation: toastOut .25s ease forwards;
    }

    /* ════════════════════════════════
       HEADER
    ════════════════════════════════ */
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
    }

        .hdr-icon-btn i,
    .hdr-icon-btn svg {
      display: block;
      line-height: 1;
      margin: 0;
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

    /* Notification dropdown */
    #notifDropdown {
      position: relative;
    }

    #notifMenu {
      position: absolute;
      right: 0;
      top: calc(100% + 10px);
      width: 320px;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 12px 40px rgba(0, 0, 0, .15), 0 0 0 1px rgba(0, 0, 0, .06);
      opacity: 0;
      transform: scale(.95) translateY(-8px);
      pointer-events: none;
      transition: all .2s cubic-bezier(.4, 0, .2, 1);
      transform-origin: top right;
      z-index: 100;
      overflow: hidden;
    }

    #notifMenu.open {
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

    #mainContent {
      margin-left: 220px;
      transition: margin-left .25s cubic-bezier(.4, 0, .2, 1);
    }

    @media (max-width: 767px) {
      #mainContent {
        margin-left: 0 !important;
      }
    }

    /* ════════════════════════════════
       SIDEBAR
    ════════════════════════════════ */
    #sidebar {
      position: fixed;
      left: 0;
      top: var(--header-h);
      width: 220px;
      width: var(--sidebar-w);
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

    /* ── Sidebar nav items ── */
    .sidebar-nav-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 9px 10px;
      border-radius: 10px;
      text-decoration: none;
      color: #4a5568;
      font-size: .78rem;
      font-weight: 600;
      transition: all .15s ease;
      white-space: nowrap;
      overflow: hidden;
      position: relative;
    }

    .sidebar-nav-item:hover {
      background: #fef2f2;
      color: #8B0000;
    }

    .sidebar-nav-item.active {
      background: linear-gradient(135deg, #8B0000, #6b0000);
      color: #fff;
      box-shadow: 0 3px 10px rgba(139, 0, 0, .25);
    }

    .sidebar-nav-icon {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      background: rgba(139, 0, 0, .07);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      flex-shrink: 0;
      color: #8B0000;
      transition: background .15s;
    }

    .sidebar-nav-item.active .sidebar-nav-icon {
      background: rgba(255, 255, 255, .2);
      color: #fff;
    }

    .sidebar-nav-text {
      flex: 1;
      overflow: hidden;
      transition: opacity .2s, max-width .25s;
      max-width: 160px;
      opacity: 1;
    }

    /* Collapsed state */
    #sidebar.collapsed {
      width: 64px !important;
    }

    #sidebar.collapsed .sidebar-nav-text {
      display: none;
    }

    #sidebar.collapsed .nav-section-label,
    #sidebar.collapsed #sidebarNavLabel {
      display: none;
    }

    #sidebar.collapsed .sidebar-nav-item {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 8px;
      width: 48px;
      gap: 0;
    }

    #sidebar.collapsed .theme-option {
      width: 100%;
      padding: 6px 0;
    }

    #sidebar.collapsed .sidebar-inner {
      padding: 16px 0 8px;
    }

    #sidebar.collapsed nav {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 2px;
      width: 100%;
    }

    #sidebar.collapsed .sidebar-nav-icon {
      margin: 0;
      flex-shrink: 0;
    }

    #sidebar.collapsed #sidebarToggleBtn {
      margin: 0 auto;
    }

    #sidebar.collapsed>.sidebar-inner>div:first-child {
      display: flex;
      justify-content: center;
      padding: 0;
      margin-bottom: 12px;
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

    body,
    #sidebar,
    main,
    .card,
    .modal-box {
      transition: background-color .3s ease, color .3s ease;
    }

    /* ════════════════════════════════
       FOOTER
    ════════════════════════════════ */
    #siteFooter {
      background: var(--crimson);
      color: rgba(255, 255, 255, .8);
      padding: 1.25rem 2rem;
    }

    .footer-inner {
      max-width: 1280px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 1.5rem;
      flex-wrap: wrap;
      font-size: .74rem;
    }

    .footer-inner a {
      color: rgba(255, 255, 255, .7);
      text-decoration: none;
      transition: color .15s;
    }

    .footer-inner a:hover {
      color: #fff;
    }

    .footer-dot {
      color: rgba(255, 255, 255, .3);
    }

    /* ── LAYOUT ── */
    #mainContent,
    #siteFooter {
      margin-left: 256px;
    }

    /* ════════════════════════════════
       MOBILE DRAWER
    ════════════════════════════════ */
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
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .45);
      z-index: 998;
      backdrop-filter: blur(2px);
      opacity: 0;
      pointer-events: none;
      transition: opacity .25s;
    }

    #mobileDrawerOverlay.open {
      opacity: 1;
      pointer-events: auto;
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
      background: linear-gradient(135deg, var(--crimson-dark) 0%, var(--crimson) 100%);
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
      line-height: 1.2;
    }

    .drawer-subtitle {
      font-size: .7rem;
      color: rgba(255, 255, 255, .7);
    }

    .drawer-close {
      width: 30px;
      height: 30px;
      border-radius: 8px;
      background: rgba(255, 255, 255, .15);
      border: none;
      color: #fff;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      transition: background .15s;
    }

    .drawer-close:hover {
      background: rgba(255, 255, 255, .28);
    }

    .drawer-user {
      padding: 12px 16px;
      border-bottom: 1px solid #f3f4f6;
      display: flex;
      align-items: center;
      gap: 10px;
      background: #fdf9f9;
      flex-shrink: 0;
    }

    .drawer-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      border: 2px solid #e5e7eb;
      object-fit: cover;
    }

    .drawer-user-name {
      font-size: .8rem;
      font-weight: 700;
      color: #1f2937;
    }

    .drawer-user-role {
      font-size: .66rem;
      color: #9ca3af;
    }

    .drawer-inner {
      flex: 1;
      overflow-y: auto;
      padding: 10px 8px 6px;
    }

    .drawer-group {
      margin-bottom: 2px;
    }

    .drawer-group-header {
      display: flex;
      align-items: center;
      padding: 6px 8px 4px;
      gap: 8px;
    }

    .drawer-group-icon {
      color: var(--crimson);
      font-size: 12px;
    }

    .drawer-group-label {
      font-size: .65rem;
      font-weight: 800;
      color: var(--crimson);
      text-transform: uppercase;
      letter-spacing: .07em;
    }

    .drawer-link {
      display: flex;
      align-items: center;
      gap: 9px;
      padding: 7px 10px 7px 28px;
      border-radius: 8px;
      margin: 1px 2px;
      font-size: .76rem;
      font-weight: 500;
      color: #374151;
      text-decoration: none;
      transition: all .15s;
    }

    .drawer-link:hover {
      background: var(--crimson-light);
      color: var(--crimson);
    }

    .drawer-link.active {
      background: var(--crimson);
      color: #fff;
      box-shadow: 0 2px 8px rgba(139, 0, 0, .2);
    }

    .drawer-link i {
      width: 14px;
      text-align: center;
      font-size: 11px;
    }

    .drawer-sep {
      height: 1px;
      background: #f3f4f6;
      margin: 8px 10px;
    }

    .drawer-bottom {
      padding: 10px 10px 14px;
      border-top: 1px solid #f3f4f6;
      flex-shrink: 0;
    }

    .drawer-brand {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .drawer-brand-text {
      font-size: .75rem;
      font-weight: 800;
      color: #fff;
      letter-spacing: .03em;
      line-height: 1.25;
      text-transform: uppercase;
    }

    .drawer-nav {
      flex: 1;
      overflow-y: auto;
      padding: 10px 10px 6px;
    }

    .drawer-section-label {
      font-size: .6rem;
      font-weight: 800;
      color: #b0b7c3;
      text-transform: uppercase;
      letter-spacing: .1em;
      padding: 6px 8px 8px;
    }

    .drawer-nav-link {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 9px 12px;
      border-radius: 10px;
      text-decoration: none;
      color: #4a5568;
      font-size: .8rem;
      font-weight: 600;
      transition: all .15s ease;
      margin-bottom: 3px;
    }

    .drawer-nav-link:hover {
      background: #fef2f2;
      color: #8B0000;
      transform: translateX(3px);
    }

    .drawer-nav-link.active {
      background: linear-gradient(135deg, #8B0000, #6b0000);
      color: #fff;
      box-shadow: 0 3px 12px rgba(139, 0, 0, .25);
    }

    .dnav-icon {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      background: rgba(139, 0, 0, .08);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      flex-shrink: 0;
      transition: background .15s;
      color: #8B0000;
    }

    .drawer-nav-link.active .dnav-icon {
      background: rgba(255, 255, 255, .2);
      color: #fff;
    }

    .drawer-nav-link:hover:not(.active) .dnav-icon {
      background: #fce8e8;
    }

    .drawer-footer {
      padding: 10px 12px 16px;
      border-top: 1px solid #f3f4f6;
      flex-shrink: 0;
    }

    .drawer-avatar {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      border: 2px solid #e5c8c8;
      object-fit: cover;
      flex-shrink: 0;
    }

    .drawer-user-name {
      font-size: .82rem;
      font-weight: 800;
      color: #1f2937;
    }

    .drawer-user-role {
      font-size: .67rem;
      color: #9ca3af;
      margin-top: 1px;
    }

    .drawer-close-btn {
      width: 30px;
      height: 30px;
      border-radius: 8px;
      background: rgba(255, 255, 255, .15);
      border: none;
      color: #fff;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      transition: background .15s;
      flex-shrink: 0;
    }

    .drawer-close-btn:hover {
      background: rgba(255, 255, 255, .28);
    }

    /* User dropdown */
    #userDropdown {
      position: relative;
    }

    #userMenu {
      position: absolute;
      right: 0;
      top: calc(100% + 10px);
      width: 200px;
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 12px 40px rgba(0, 0, 0, .15), 0 0 0 1px rgba(0, 0, 0, .06);
      opacity: 0;
      transform: scale(.95) translateY(-8px);
      pointer-events: none;
      transition: all .2s cubic-bezier(.4, 0, .2, 1);
      transform-origin: top right;
      z-index: 100;
      overflow: hidden;
    }

    #userMenu.open {
      opacity: 1;
      transform: scale(1) translateY(0);
      pointer-events: auto;
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

    .user-menu-item.danger {
      color: #ef4444;
    }

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

    /* Dark mode user menu */
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

    /* Dark mode */
    [data-theme="dark"] body {
      background-color: #000D1A;
      color: #E5E7EB;
    }

    [data-theme="dark"] #sidebar {
      background-color: #000D1A;
    }

    [data-theme="dark"] .bg-white {
      background-color: #000D1A !important;
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

    /* ── STAT CARDS ── */
    .stat-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 24px;
    }

    .stat-card {
      background: #fff;
      border-radius: 16px;
      padding: 20px 22px;
      border: 1px solid #E8E4DE;
      box-shadow: 0 1px 3px rgba(0, 0, 0, .06);
      position: relative;
      overflow: hidden;
      transition: transform .2s, box-shadow .2s;
    }

    .stat-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, .09);
    }

    .stat-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
    }

    .stat-card.s-total::before {
      background: linear-gradient(90deg, #660000, #8B0000);
    }

    .stat-card.s-medicine::before {
      background: linear-gradient(90deg, #1565C0, #42A5F5);
    }

    .stat-card.s-supplies::before {
      background: linear-gradient(90deg, #2E7D32, #66BB6A);
    }

    .stat-card.s-low::before {
      background: linear-gradient(90deg, #E65100, #FFA726);
    }

    .stat-label {
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .09em;
      color: #9A9490;
      margin-bottom: 10px;
    }

    .stat-value {
      font-size: 34px;
      font-weight: 800;
      line-height: 1;
    }

    .stat-card.s-total .stat-value {
      color: #8B0000;
    }

    .stat-card.s-medicine .stat-value {
      color: #1565C0;
    }

    .stat-card.s-supplies .stat-value {
      color: #2E7D32;
    }

    .stat-card.s-low .stat-value {
      color: #E65100;
    }

    .stat-footer {
      font-size: 11px;
      color: #ADA9A5;
      margin-top: 8px;
    }

    .stat-icon {
      position: absolute;
      right: 18px;
      top: 50%;
      transform: translateY(-50%);
      width: 42px;
      height: 42px;
      border-radius: 11px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
    }

    .stat-card.s-total .stat-icon {
      background: #FFF0F0;
      color: #8B0000;
    }

    .stat-card.s-medicine .stat-icon {
      background: #E3F2FD;
      color: #1565C0;
    }

    .stat-card.s-supplies .stat-icon {
      background: #E8F5E9;
      color: #2E7D32;
    }

    .stat-card.s-low .stat-icon {
      background: #FFF3E0;
      color: #E65100;
    }

    /* ── SEARCH ── */
    .search-wrap {
      display: flex;
      align-items: center;
      gap: 10px;
      background: #FAFAF9;
      border: 1.5px solid #E0DDD8;
      border-radius: 12px;
      padding: 0 16px;
      height: 40px;
      transition: border-color .2s, box-shadow .2s;
      width: 288px;
    }

    .search-wrap:focus-within {
      border-color: #8B0000;
      box-shadow: 0 0 0 3px rgba(139, 0, 0, .1);
    }

    .search-wrap i {
      color: #8B0000;
      font-size: 13px;
      flex-shrink: 0;
    }

    .search-wrap input {
      border: none;
      background: none;
      outline: none;
      font-size: 13px;
      color: #333;
      width: 100%;
    }

    .search-wrap input::placeholder {
      color: #B0ABA6;
    }

    .search-clear-btn {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      border: none;
      background: #E0DDD8;
      color: #7A7370;
      font-size: 10px;
      cursor: pointer;
      display: none;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      transition: all .2s;
      padding: 0;
    }

    .search-clear-btn:hover {
      background: #8b000076;
      color: #fff;
    }

    .search-clear-btn.visible {
      display: flex;
    }

    /* ── TABS ── */
    .tab-group {
      display: flex;
      background: #F5F2EE;
      border: 1px solid #E8E4DE;
      border-radius: 10px;
      padding: 3px;
      gap: 2px;
    }

    .tab-btn {
      padding: 6px 16px;
      border-radius: 7px;
      border: none;
      background: none;
      cursor: pointer;
      font-size: 12px;
      font-weight: 600;
      color: #9A9490;
      transition: all .2s;
      white-space: nowrap;
    }

    .tab-btn.active {
      background: #8B0000;
      color: #fff;
      box-shadow: 0 2px 8px rgba(139, 0, 0, .3);
    }

    /* ── FILTER BTN ── */
    .btn-filter {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      height: 40px;
      padding: 0 16px;
      border-radius: 10px;
      border: 1.5px solid #E0DDD8;
      background: #fff;
      font-size: 13px;
      font-weight: 600;
      color: #6B6661;
      cursor: pointer;
      transition: all .2s;
    }

    .btn-filter:hover {
      border-color: #8B0000;
      color: #8B0000;
      background: #FFF8F8;
    }

    /* ── ADD BTN ── */
    .btn-add {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      height: 40px;
      padding: 0 18px;
      border-radius: 10px;
      border: none;
      background: #8B0000;
      color: #fff;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: all .2s;
      box-shadow: 0 3px 10px rgba(139, 0, 0, .3);
    }

    .btn-add:hover {
      background: #660000;
      box-shadow: 0 4px 14px rgba(139, 0, 0, .4);
      transform: translateY(-1px);
    }

    .btn-add .add-icon {
      width: 20px;
      height: 20px;
      border-radius: 5px;
      background: rgba(255, 255, 255, .2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
    }

    /* ── TABLE ── */
    .inv-table {
      width: 100%;
      border-collapse: collapse;
    }

    .inv-table thead tr {
      background: #FAFAF9;
      border-bottom: 2px solid #EDE9E4;
    }

    .inv-table th {
      padding: 12px 16px;
      text-align: left;
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .1em;
      color: #8B0000;
      white-space: nowrap;
    }

    .inv-table th:last-child {
      text-align: center;
    }

    .inv-table tbody tr {
      border-bottom: 1px solid #F0ECE8;
      transition: background .15s;
    }

    .inv-table tbody tr:last-child {
      border-bottom: none;
    }

    .inv-table tbody tr:hover {
      background: #FFF8F8;
    }

    .inv-table td {
      padding: 14px 16px;
      font-size: 13px;
      color: #333;
      vertical-align: middle;
    }

    .inv-table td:last-child {
      text-align: center;
    }

    .stock-no {
      font-size: 12px;
      font-weight: 500;
      background: #F5F2EE;
      border: 1px solid #E8E4DE;
      padding: 3px 8px;
      border-radius: 6px;
      color: #7A7370;
      display: inline-block;
    }

    .supply-name {
      font-weight: 600;
      color: #1A1614;
    }

    .supply-cat {
      display: inline-block;
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .06em;
      padding: 2px 8px;
      border-radius: 5px;
      margin-top: 3px;
    }

    .supply-cat.medicine {
      background: #E3F2FD;
      color: #1565C0;
    }

    .supply-cat.supplies {
      background: #E8F5E9;
      color: #2E7D32;
    }

    .bal-chip {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 4px 10px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 600;
    }

    .bal-chip::before {
      content: '';
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: currentColor;
    }

    .bal-chip.ok {
      background: #D4EDDA;
      color: #1A6B34;
    }

    .bal-chip.low {
      background: #FFF3CD;
      color: #92600A;
    }

    .bal-chip.critical {
      background: #FFE5E5;
      color: #C0392B;
    }

    .act-btn {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      font-size: 12px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      transition: all .2s;
    }

    .act-btn.edit {
      background: #FFF0F0;
      color: #8B0000;
    }

    .act-btn.edit:hover {
      background: #8B0000;
      color: #fff;
      transform: scale(1.05);
    }

    .act-btn.delete {
      background: #FFF0F0;
      color: #C0392B;
    }

    .act-btn.delete:hover {
      background: #C0392B;
      color: #fff;
      transform: scale(1.05);
    }

    .row-count {
      font-size: 12px;
      color: #9A9490;
    }

    .table-footer-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 16px;
      border-top: 1px solid #EDE9E4;
      background: #FAFAF9;
      border-radius: 0 0 12px 12px;
    }

    /* ── FILTER PANEL ── */
    .filter-overlay {
      display: none;
      position: fixed;
      inset: 0;
      z-index: 190;
      background: rgba(0, 0, 0, .35);
      backdrop-filter: blur(2px);
    }

    .filter-overlay.open {
      display: block;
    }

    .filter-panel {
      position: fixed;
      right: -360px;
      top: 0;
      bottom: 0;
      width: 340px;
      z-index: 200;
      background: #fff;
      border-left: 1px solid #E8E4DE;
      box-shadow: -4px 0 24px rgba(0, 0, 0, .1);
      display: flex;
      flex-direction: column;
      transition: right .3s cubic-bezier(.4, 0, .2, 1);
    }

    .filter-panel.open {
      right: 0;
    }

    .fp-header {
      padding: 18px 24px;
      border-bottom: 1px solid #EDE9E4;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .fp-title {
      font-size: 16px;
      font-weight: 700;
      color: #8B0000;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .fp-close-btn {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      border: 1.5px solid #E8E4DE;
      background: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #9A9490;
      font-size: 14px;
      transition: all .2s;
    }

    .fp-close-btn:hover {
      border-color: #8B0000;
      color: #8B0000;
      background: #FFF8F8;
    }

    .fp-body {
      flex: 1;
      overflow-y: auto;
      padding: 20px 24px;
    }

    .fp-section {
      margin-bottom: 22px;
    }

    .fp-section-title {
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .1em;
      color: #9A9490;
      margin-bottom: 10px;
    }

    .fp-radio-item {
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
      padding: 8px 12px;
      border-radius: 8px;
      transition: background .15s;
      margin-bottom: 2px;
    }

    .fp-radio-item:hover {
      background: #FFF5F5;
    }

    .fp-radio-item input[type="radio"] {
      accent-color: #8B0000;
      width: 16px;
      height: 16px;
    }

    .fp-radio-item label {
      font-size: 13px;
      color: #333;
      cursor: pointer;
    }

    .fp-date-row {
      display: flex;
      gap: 10px;
      margin-bottom: 10px;
    }

    .fp-date-group {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .fp-date-label {
      font-size: 11px;
      color: #9A9490;
      font-weight: 600;
    }

    .fp-date-input {
      height: 38px;
      padding: 0 12px;
      border: 1.5px solid #E0DDD8;
      border-radius: 8px;
      font-size: 12px;
      outline: none;
      transition: border-color .2s;
      background: #FAFAF9;
      color: #333;
    }

    .fp-date-input:focus {
      border-color: #8B0000;
      box-shadow: 0 0 0 3px rgba(139, 0, 0, .08);
    }

    .fp-footer {
      padding: 14px 24px;
      border-top: 1px solid #EDE9E4;
      display: flex;
      gap: 10px;
    }

    .fp-btn-clear {
      flex: 1;
      height: 40px;
      border-radius: 10px;
      border: 1.5px solid #E0DDD8;
      background: #fff;
      font-size: 13px;
      font-weight: 600;
      color: #8B0000;
      cursor: pointer;
      transition: all .2s;
    }

    .fp-btn-clear:hover {
      background: #FFF8F8;
    }

    .fp-btn-apply {
      flex: 2;
      height: 40px;
      border-radius: 10px;
      border: none;
      background: #8B0000;
      color: #fff;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: all .2s;
      box-shadow: 0 3px 10px rgba(139, 0, 0, .3);
    }

    .fp-btn-apply:hover {
      background: #660000;
    }

    /* ── MODALS ── */
    .modal-box-custom {
      background: #fff;
      border-radius: 18px;
      padding: 28px;
      width: 500px;
      max-width: 95vw;
      box-shadow: 0 20px 60px rgba(0, 0, 0, .15);
    }

    .modal-header-custom {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 24px;
    }

    .modal-icon-custom {
      width: 42px;
      height: 42px;
      border-radius: 11px;
      background: linear-gradient(135deg, #660000, #8B0000);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 17px;
      color: #fff;
    }

    .modal-title-custom {
      font-size: 18px;
      font-weight: 700;
      color: #660000;
    }

    .modal-sub-custom {
      font-size: 12px;
      color: #9A9490;
      margin-top: 1px;
    }

    .form-grid-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    .form-group-custom {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }

    .form-group-custom.full {
      grid-column: 1 / -1;
    }

    .form-label-custom {
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .08em;
      color: #8B0000;
    }

    .form-input-custom,
    .form-select-custom {
      height: 40px;
      padding: 0 13px;
      border-radius: 9px;
      border: 1.5px solid #E0DDD8;
      background: #FAFAF9;
      font-size: 13px;
      color: #333;
      outline: none;
      transition: border-color .2s, box-shadow .2s;
    }

    .form-input-custom:focus,
    .form-select-custom:focus {
      border-color: #8B0000;
      box-shadow: 0 0 0 3px rgba(139, 0, 0, .1);
    }

    .form-input-custom[readonly] {
      background: #F2F0EC;
      color: #9A9490;
      cursor: not-allowed;
    }

    .modal-footer-custom {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      margin-top: 24px;
    }

    .btn-modal-cancel {
      height: 40px;
      padding: 0 20px;
      border-radius: 9px;
      border: 1.5px solid #E0DDD8;
      background: #F5F2EE;
      font-size: 13px;
      font-weight: 600;
      color: #6B6661;
      cursor: pointer;
      transition: all .2s;
    }

    .btn-modal-cancel:hover {
      background: #EDE9E4;
    }

    .btn-modal-save {
      height: 40px;
      padding: 0 22px;
      border-radius: 9px;
      border: none;
      background: #8B0000;
      color: #fff;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: all .2s;
      box-shadow: 0 3px 10px rgba(139, 0, 0, .3);
      display: inline-flex;
      align-items: center;
      gap: 7px;
    }

    .btn-modal-save:hover {
      background: #660000;
    }

    /* ── VALIDATION ── */
    .form-input-custom.is-invalid,
    .form-select-custom.is-invalid {
      border-color: #C0392B !important;
      box-shadow: 0 0 0 3px rgba(192, 57, 43, .12) !important;
      background: #FFF8F7 !important;
    }

    .form-input-custom.is-valid,
    .form-select-custom.is-valid {
      border-color: #2E7D32 !important;
      box-shadow: 0 0 0 3px rgba(46, 125, 50, .1) !important;
    }

    .field-error {
      font-size: 10px;
      font-weight: 600;
      color: #C0392B;
      margin-top: 3px;
      display: flex;
      align-items: center;
      gap: 4px;
      min-height: 14px;
      animation: errorSlide .15s ease-out;
    }

    @keyframes errorSlide {
      from {
        opacity: 0;
        transform: translateY(-3px)
      }

      to {
        opacity: 1;
        transform: translateY(0)
      }
    }

    .char-counter {
      font-size: 10px;
      color: #B0ABA6;
      text-align: right;
      margin-top: 3px;
      transition: color .2s;
    }

    .char-counter.warn {
      color: #E65100;
    }

    .char-counter.over {
      color: #C0392B;
      font-weight: 700;
    }

    @media (max-width: 767px) {
      #sidebar {
        display: none !important;
      }

      #mainContent,
      #siteFooter {
        margin-left: 0 !important;
      }

      #mobileMenuBtn {
        display: flex;
      }

      .header {
        padding: 0 1rem;
      }

      .header-title {
        display: none;
      }
    }
  </style>
</head>

@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

<body class="bg-[#F4F4F4] min-h-screen flex flex-col">

  <!-- TOAST CONTAINER -->
  <div id="toastContainer"></div>

  <!-- ════════ HEADER ════════ -->
  <header class="header">
    <div class="header-left">
      <button id="mobileMenuBtn" onclick="openDrawer()" aria-label="Open menu">
        <i class="fa-solid fa-bars"></i>
      </button>
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
              @if(!empty($n['message']))<div style="color:#aaa;margin-top:2px;font-size:.7rem;">{{ $n['message'] }}
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

      <div id="userDropdown">
        <div class="header-user-btn" id="userBtn">
          <img src="{{ asset('images/Nelson-Angeles.jpg') }}" alt="Dr. Nelson P. Angeles" class="header-avatar"
            onerror="this.src='https://ui-avatars.com/api/?name=Nelson+Angeles&background=660000&color=FFFFFF&size=88'">
          <div class="header-user-text">
            <div class="header-name">Dr. Nelson P. Angeles</div>
            <div class="header-role">Dentist</div>
          </div>
          <i class="fa-solid fa-chevron-down"
            style="color:rgba(255,255,255,.5);font-size:.6rem;margin-left:.25rem;"></i>
        </div>
        <div id="userMenu">
          <div class="user-menu-header">
            <img src="{{ asset('images/Nelson-Angeles.jpg') }}" alt="Dr. Nelson P. Angeles" class="header-avatar"
              onerror="this.src='https://ui-avatars.com/api/?name=Nelson+Angeles&background=660000&color=FFFFFF&size=88'">
            <div>
              <div class="user-menu-name">Dr. Nelson P. Angeles</div>
              <div class="user-menu-role">Dentist</div>
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

  <!-- SIDEBAR -->
  <aside id="sidebar" style="width:220px;">
    <div class="sidebar-inner">
      <!-- Toggle button -->
      <div style="display:flex;justify-content:flex-end;margin-bottom:12px;">
        <button onclick="toggleSidebar()" id="sidebarToggleBtn"
          style="width:30px;height:30px;border-radius:8px;border:none;background:#fef2f2;color:#8B0000;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:13px;transition:background .15s;"
          onmouseover="this.style.background='#fce8e8'" onmouseout="this.style.background='#fef2f2'">
          <i id="sidebarIcon" class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <div class="nav-section-label" id="sidebarNavLabel">Navigation</div>

      <nav style="display:flex;flex-direction:column;gap:2px;">
        @foreach([
        ['route'=>'dentist.dentist.dashboard', 'icon'=>'fa-chart-line', 'label'=>'Dashboard'],
        ['route'=>'dentist.dentist.patients', 'icon'=>'fa-users', 'label'=>'Patients'],
        ['route'=>'dentist.dentist.appointments', 'icon'=>'fa-calendar-check', 'label'=>'Appointments'],
        ['route'=>'dentist.dentist.documentrequests', 'icon'=>'fa-file-circle-check', 'label'=>'Document Requests'],
        ['route'=>'dentist.dentist.inventory', 'icon'=>'fa-box', 'label'=>'Inventory'],
        ['route'=>'dentist.dentist.report', 'icon'=>'fa-file', 'label'=>'Reports'],
        ] as $nav)
        <a href="{{ route($nav['route']) }}" title="{{ $nav['label'] }}"
          class="sidebar-nav-item {{ request()->routeIs($nav['route']) ? 'active' : '' }}">
          <span class="sidebar-nav-icon"><i class="fa-solid {{ $nav['icon'] }}"></i></span>
          <span class="sidebar-nav-text">{{ $nav['label'] }}</span>
        </a>
        @endforeach
      </nav>
    </div>
  </aside>

  <!-- MOBILE DRAWER OVERLAY -->
  <div id="mobileDrawerOverlay" onclick="closeDrawer()"></div>

  <!-- MOBILE DRAWER -->
  <div id="mobileDrawer">
    <div class="drawer-header">
      <div class="drawer-brand">
        <img src="{{ asset('images/PUP.png') }}"
          style="width:26px;height:26px;object-fit:contain;filter:drop-shadow(0 1px 3px rgba(0,0,0,.3));" alt="PUP">
        <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" style="width:24px;height:24px;object-fit:contain;" alt="DMS">
        <span class="drawer-brand-text">PUP Taguig<br>Dental Clinic</span>
      </div>
      <button class="drawer-close-btn" onclick="closeDrawer()">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <nav class="drawer-nav">
      <div class="drawer-section-label">Navigation</div>
      @foreach([
      ['route'=>'dentist.dentist.dashboard', 'icon'=>'fa-chart-line', 'label'=>'Dashboard'],
      ['route'=>'dentist.dentist.patients', 'icon'=>'fa-users', 'label'=>'Patients'],
      ['route'=>'dentist.dentist.appointments', 'icon'=>'fa-calendar-check', 'label'=>'Appointments'],
      ['route'=>'dentist.dentist.documentrequests', 'icon'=>'fa-file-circle-check', 'label'=>'Document Requests'],
      ['route'=>'dentist.dentist.inventory', 'icon'=>'fa-box', 'label'=>'Inventory'],
      ['route'=>'dentist.dentist.report', 'icon'=>'fa-file', 'label'=>'Reports'],
      ] as $nav)
      <a href="{{ route($nav['route']) }}"
        class="drawer-nav-link {{ request()->routeIs($nav['route']) ? 'active' : '' }}">
        <span class="dnav-icon"><i class="fa-solid {{ $nav['icon'] }}"></i></span>
        {{ $nav['label'] }}
      </a>
      @endforeach
    </nav>

    <div class="drawer-footer">
      <form method="POST" action="{{ route('logout') }}" style="margin:0;">
        @csrf
        <button type="submit"
          style="width:100%;display:flex;align-items:center;gap:.6rem;padding:.6rem .75rem;border-radius:10px;border:1px solid #fce8e8;background:#fdf5f5;color:#8B0000;font-size:.8rem;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;transition:background .15s;">
          <i class="fa-solid fa-right-from-bracket"></i> Log out
        </button>
      </form>
    </div>
  </div>

  <!-- MAIN -->
  <main id="mainContent" class="pt-[88px] px-6 pb-6 min-h-screen fade-in">
    <div class="max-w-7xl mt-4 mx-auto">

      <div class="mb-6">
        <p class="text-[10px] font-bold uppercase tracking-widest text-[#C9A84C] mb-1">
          <i class="fa-solid fa-box mr-1"></i> Stock Management
        </p>
        <h1 class="text-2xl font-extrabold text-[#660000] leading-tight">Inventory</h1>
        <p class="text-sm text-gray-400 mt-1">Track and manage dental supplies &amp; medicines</p>
      </div>

      <!-- STAT CARDS -->
      <div class="stat-grid">
        <div class="stat-card s-total">
          <div class="stat-label">Total Items</div>
          <div class="stat-value" id="statTotal">—</div>
          <div class="stat-footer">across all categories</div>
          <div class="stat-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
        </div>
        <div class="stat-card s-medicine">
          <div class="stat-label">Medicines</div>
          <div class="stat-value" id="statMedicine">—</div>
          <div class="stat-footer">pharmaceutical items</div>
          <div class="stat-icon"><i class="fa-solid fa-pills"></i></div>
        </div>
        <div class="stat-card s-supplies">
          <div class="stat-label">Dental Supplies</div>
          <div class="stat-value" id="statSupplies">—</div>
          <div class="stat-footer">consumable supplies</div>
          <div class="stat-icon"><i class="fa-solid fa-syringe"></i></div>
        </div>
        <div class="stat-card s-low">
          <div class="stat-label">Low Stock</div>
          <div class="stat-value" id="statLow">—</div>
          <div class="stat-footer">need restocking soon</div>
          <div class="stat-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
        </div>
      </div>

      <!-- TABLE CARD -->
      <div class="bg-white rounded-xl shadow-sm border border-[#EDE9E4] overflow-hidden">

        <!-- TOOLBAR -->
        <div class="flex justify-between items-center px-5 py-4 border-b border-[#EDE9E4] flex-wrap gap-3">
          <div class="flex items-center gap-3 flex-wrap">
            <div class="search-wrap">
              <i class="fa fa-search"></i>
              <input id="searchInput" placeholder="Search Stock No., Name…"
                oninput="renderTable(); toggleSearchClear(this)" />
              <button type="button" id="searchClearBtn" class="search-clear-btn" onclick="clearSearch()"
                title="Clear search">
                <i class="fa-solid fa-xmark"></i>
              </button>
            </div>
            <div class="tab-group">
              <button class="tab-btn active" onclick="setTab('all',this)">All</button>
              <button class="tab-btn" onclick="setTab('medicine',this)">Medicine</button>
              <button class="tab-btn" onclick="setTab('supplies',this)">Supplies</button>
            </div>
          </div>
          <div class="flex items-center gap-2">
            <span class="row-count" id="rowCount"></span>
            <button type="button" onclick="openFilterPanel()" class="btn-filter">
              <i class="fa-solid fa-sliders"></i> Filter
            </button>
            <button onclick="resetAddForm(); document.getElementById('addModal').showModal()" class="btn-add">
              <span class="add-icon"><i class="fa-solid fa-plus"></i></span>
              Add Item
            </button>
          </div>
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto">
          <table class="inv-table">
            <thead>
              <tr>
                <th>Date</th>
                <th>Stock No.</th>
                <th>Supply / Medicine</th>
                <th>Unit</th>
                <th>Qty</th>
                <th>Used</th>
                <th>Balance</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="tableBody"></tbody>
          </table>
        </div>

        <div id="emptyState" style="display:none;"></div>

        <div class="table-footer-bar">
          <span class="text-xs text-gray-400" id="pageInfo"></span>
          <div></div>
        </div>
      </div>
    </div>
  </main>

  <!-- FOOTER -->
  <footer id="siteFooter">
    <div class="footer-inner">
      <span style="color:rgba(255,255,255,.5);">© 1998–2026</span>
      <span style="font-weight:700;color:#fff;">Polytechnic University of the Philippines</span>
      <span class="footer-dot">|</span>
      <a href="https://www.pup.edu.ph/terms/">Terms of Use</a>
      <span class="footer-dot">|</span>
      <a href="https://www.pup.edu.ph/privacy/">Privacy Statement</a>
    </div>
  </footer>

  <!-- FILTER PANEL -->
  <div class="filter-overlay" id="filterOverlay" onclick="closeFilterPanel()"></div>
  <div class="filter-panel" id="filterPanel">
    <div class="fp-header">
      <span class="fp-title"><i class="fa-solid fa-sliders"></i> Filter</span>
      <button class="fp-close-btn" onclick="closeFilterPanel()"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="fp-body">
      <div class="fp-section">
        <div class="fp-section-title">Sort by Name</div>
        <label class="fp-radio-item"><input type="radio" name="fp_sort" value="az"><label>A → Z</label></label>
        <label class="fp-radio-item"><input type="radio" name="fp_sort" value="za"><label>Z → A</label></label>
      </div>
      <div class="fp-section">
        <div class="fp-section-title">Date Received</div>
        <div class="fp-date-row">
          <div class="fp-date-group">
            <span class="fp-date-label">From</span>
            <input id="fp_dateFrom" type="date" class="fp-date-input">
          </div>
          <div class="fp-date-group">
            <span class="fp-date-label">To</span>
            <input id="fp_dateTo" type="date" class="fp-date-input">
          </div>
        </div>
        <label class="fp-radio-item"><input type="radio" name="fp_dateOrder"
            value="asc"><label>Ascending</label></label>
        <label class="fp-radio-item"><input type="radio" name="fp_dateOrder"
            value="desc"><label>Descending</label></label>
      </div>
      <div class="fp-section">
        <div class="fp-section-title">Stock Level</div>
        <label class="fp-radio-item"><input type="radio" name="fp_stock" value="low-high"><label>Lowest →
            Highest</label></label>
        <label class="fp-radio-item"><input type="radio" name="fp_stock" value="high-low"><label>Highest →
            Lowest</label></label>
      </div>
    </div>
    <div class="fp-footer">
      <button class="fp-btn-clear" onclick="clearFilterPanel()">Clear All</button>
      <button class="fp-btn-apply" onclick="saveFilterPanel()"><i class="fa-solid fa-check mr-1"></i> Apply</button>
    </div>
  </div>

  <!-- ════════════════════════════
       ADD MODAL
       Each submission ALWAYS creates a NEW row — never updates existing items.
  ════════════════════════════ -->
  <dialog id="addModal" class="modal backdrop-blur-sm">
    <div class="modal-box-custom">
      <div class="modal-header-custom">
        <div class="modal-icon-custom"><i class="fa-solid fa-plus"></i></div>
        <div>
          <div class="modal-title-custom">Add Inventory Item</div>
          <div class="modal-sub-custom">A new row will be appended every time you save</div>
        </div>
      </div>

      <div class="form-grid-2">
        <div class="form-group-custom">
          <div class="form-label-custom">Category <span style="color:#C0392B">*</span></div>
          <select id="addCategory" class="form-select-custom" onchange="validateAddField('addCategory')">
            <option disabled selected value="">Select…</option>
            <option value="Medicine">Medicine</option>
            <option value="Supplies">Supplies</option>
          </select>
          <div class="field-error" id="err-addCategory"></div>
        </div>

        <div class="form-group-custom">
          <div class="form-label-custom">Date Received <span style="color:#C0392B">*</span></div>
          <input id="addDate" type="date" class="form-input-custom" onchange="validateAddField('addDate')">
          <div class="field-error" id="err-addDate"></div>
        </div>

        <div class="form-group-custom">
          <div class="form-label-custom">Stock Number <span style="color:#C0392B">*</span></div>
          <input id="addStock" class="form-input-custom" placeholder="00-000" maxlength="6"
            oninput="formatStockNo(this); validateAddField('addStock')" style="letter-spacing:0.15em">
          <div class="field-error" id="err-addStock"></div>
        </div>

        <div class="form-group-custom">
          <div class="form-label-custom">Unit <span style="color:#C0392B">*</span></div>
          <input id="addUnit" class="form-input-custom" placeholder="Box / Bottle / Pack" maxlength="30"
            oninput="validateAddField('addUnit')">
          <div class="field-error" id="err-addUnit"></div>
        </div>

        <div class="form-group-custom full">
          <div style="display:flex;justify-content:space-between;align-items:center;">
            <div class="form-label-custom">Supply / Medicine Name <span style="color:#C0392B">*</span></div>
            <div class="char-counter" id="charCounter-addName">0 / 100</div>
          </div>
          <input id="addName" class="form-input-custom" placeholder="e.g. Nitrile Gloves Large" maxlength="100"
            oninput="updateCharCounter('addName',100); validateAddField('addName')">
          <div class="field-error" id="err-addName"></div>
        </div>

        <div class="form-group-custom">
          <div class="form-label-custom">Quantity <span style="color:#C0392B">*</span></div>
          <input id="addQty" type="number" class="form-input-custom" placeholder="0" min="0" max="99999"
            oninput="computeAddBalance(); validateAddField('addQty'); validateAddField('addUsed')">
          <div class="field-error" id="err-addQty"></div>
        </div>

        <div class="form-group-custom">
          <div class="form-label-custom">Consumed</div>
          <input id="addUsed" type="number" class="form-input-custom" placeholder="0" min="0" max="99999"
            oninput="computeAddBalance(); validateAddField('addUsed')">
          <div class="field-error" id="err-addUsed"></div>
        </div>

        <div class="form-group-custom full">
          <div class="form-label-custom">Balance (auto-calculated)</div>
          <input id="addBalance" class="form-input-custom" readonly placeholder="—">
        </div>
      </div>

      <div class="modal-footer-custom">
        <button class="btn-modal-cancel" onclick="document.getElementById('addModal').close()">Cancel</button>
        <button id="btnSaveAdd" class="btn-modal-save" onclick="addItem()">
          <i class="fa-solid fa-floppy-disk"></i> Save Item
        </button>
      </div>
    </div>
  </dialog>

  <!-- EDIT MODAL -->
  <dialog id="editModal" class="modal">
    <div class="modal-box-custom">
      <div class="modal-header-custom">
        <div class="modal-icon-custom" style="background:linear-gradient(135deg,#1a4a8a,#2563EB);">
          <i class="fa-solid fa-pen"></i>
        </div>
        <div>
          <div class="modal-title-custom">Edit Inventory Item</div>
          <div class="modal-sub-custom">Update the details for this item</div>
        </div>
      </div>
      <div class="form-grid-2">
        <div class="form-group-custom">
          <div class="form-label-custom">Category</div>
          <select id="editCategory" class="form-select-custom">
            <option value="Medicine">Medicine</option>
            <option value="Supplies">Supplies</option>
          </select>
        </div>
        <div class="form-group-custom">
          <div class="form-label-custom">Date Received</div>
          <input id="editDate" type="date" class="form-input-custom">
        </div>
        <div class="form-group-custom">
          <div class="form-label-custom">Stock Number</div>
          <input id="editStock" class="form-input-custom">
        </div>
        <div class="form-group-custom">
          <div class="form-label-custom">Unit</div>
          <input id="editUnit" class="form-input-custom" placeholder="Box / Bottle / Pack">
        </div>
        <div class="form-group-custom full">
          <div class="form-label-custom">Supply / Medicine Name</div>
          <input id="editName" class="form-input-custom">
        </div>
        <div class="form-group-custom">
          <div class="form-label-custom">Quantity</div>
          <input id="editQty" type="number" class="form-input-custom" oninput="computeEditBalance()">
        </div>
        <div class="form-group-custom">
          <div class="form-label-custom">Consumed</div>
          <input id="editUsed" type="number" class="form-input-custom" oninput="computeEditBalance()">
        </div>
        <div class="form-group-custom full">
          <div class="form-label-custom">Balance (auto-calculated)</div>
          <input id="editBalance" class="form-input-custom" readonly>
        </div>
      </div>
      <div class="modal-footer-custom">
        <button class="btn-modal-cancel" onclick="document.getElementById('editModal').close()">Cancel</button>
        <button class="btn-modal-save" onclick="saveEdit()"><i class="fa-solid fa-floppy-disk"></i> Save
          Changes</button>
      </div>
    </div>
  </dialog>

  <!-- DELETE MODAL -->
  <dialog id="deleteModal" class="modal">
    <div class="modal-box-custom" style="max-width:400px;text-align:center;">
      <div style="width:60px;height:60px;border-radius:16px;background:linear-gradient(135deg,#FFE5E5,#FFCDD2);
                  display:flex;align-items:center;justify-content:center;font-size:26px;
                  color:#C0392B;margin:0 auto 14px;">
        <i class="fa-solid fa-trash"></i>
      </div>
      <div style="font-size:18px;font-weight:700;color:#1A1614;margin-bottom:8px;">Delete Item?</div>
      <div style="font-size:13px;color:#9A9490;margin-bottom:24px;">
        This action cannot be undone. The item will be permanently removed from your inventory.
      </div>
      <div class="modal-footer-custom" style="justify-content:center;">
        <button class="btn-modal-cancel" onclick="document.getElementById('deleteModal').close()">Cancel</button>
        <button id="confirmDeleteBtn" class="btn-modal-save"
          style="background:#C0392B;box-shadow:0 3px 10px rgba(192,57,43,.3);">
          <i class="fa-solid fa-trash"></i> Delete
        </button>
      </div>
    </div>
  </dialog>

  <script>
    // TOAST HELPER
    function showToast(type, message, duration = 3000) {
      const container = document.getElementById('toastContainer');
      const toast = document.createElement('div');
      toast.className = `toast-item ${type}`;
      const icon = type === 'success' ?
        '<i class="fa-solid fa-circle-check"></i>' :
        '<i class="fa-solid fa-circle-exclamation"></i>';
      toast.innerHTML = `${icon} ${message}`;
      container.appendChild(toast);

      setTimeout(() => {
        toast.classList.add('leaving');
        toast.addEventListener('animationend', () => toast.remove());
      }, duration);
    }

    // ── Mobile Drawer ────────────────────────────────────────────
    function openDrawer() {
      document.getElementById('mobileDrawer').classList.add('open');
      document.getElementById('mobileDrawerOverlay').classList.add('open');
      document.body.style.overflow = 'hidden';
    }
    function closeDrawer() {
      document.getElementById('mobileDrawer').classList.remove('open');
      document.getElementById('mobileDrawerOverlay').classList.remove('open');
      document.body.style.overflow = '';
    }

    /* NOTIF */
    document.getElementById('notifBtn').addEventListener('click', e => {
      e.stopPropagation();
      document.getElementById('notifMenu').classList.toggle('open');
    });
    document.addEventListener('click', () => document.getElementById('notifMenu').classList.remove('open'));

    /* USER DROPDOWN */
    document.getElementById('userBtn').addEventListener('click', e => {
      e.stopPropagation();
      document.getElementById('notifMenu').classList.remove('open'); // close notif if open
      document.getElementById('userMenu').classList.toggle('open');
    });
    document.addEventListener('click', () => document.getElementById('userMenu').classList.remove('open'));

    /* Sync user menu theme toggle */
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('#userMenuThemeToggle .theme-option').forEach(o =>
        o.addEventListener('click', e => { e.stopPropagation(); applyTheme(o.getAttribute('data-theme')); })
      );
    });

    /* ── THEME TOGGLE ── */
    const html = document.documentElement;
    const themeToggleContainer = document.getElementById("themeToggle");
    const themeIndicator = themeToggleContainer.querySelector(".theme-indicator");
    const themeOptions = themeToggleContainer.querySelectorAll(".theme-option");

    function applyTheme(theme) {
      html.setAttribute("data-theme", theme);
      localStorage.setItem("theme", theme);
      themeOptions.forEach(o => o.classList.toggle("active", o.getAttribute("data-theme") === theme));
      themeIndicator.classList.toggle("dark-mode", theme === "dark");
    }
    applyTheme(localStorage.getItem("theme") || "light");
    themeOptions.forEach(o => o.addEventListener("click", () => applyTheme(o.getAttribute("data-theme"))));

    /* ── SIDEBAR TOGGLE ── */
    let sidebarOpen = true;

    function applyLayout(w) {
      document.getElementById('sidebar').style.width = w;
      document.getElementById('mainContent').style.marginLeft = w;
    }

    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const icon = document.getElementById('sidebarIcon');
      const isCollapsed = sidebar.classList.contains('collapsed');

      if (isCollapsed) {
        sidebar.classList.remove('collapsed');
        sidebar.style.width = '220px';
        document.getElementById('mainContent').style.marginLeft = '220px';
        icon.className = 'fa-solid fa-xmark';
      } else {
        sidebar.classList.add('collapsed');
        sidebar.style.width = '64px';
        document.getElementById('mainContent').style.marginLeft = '64px';
        icon.className = 'fa-solid fa-bars';
      }
    }

    function applyLayout(w) {
      const sidebar = document.getElementById('sidebar');
      const main = document.getElementById('mainContent');
      if (sidebar) sidebar.style.width = w;
      if (main) main.style.marginLeft = w;
    }

    /* ════════════════════════════
       INVENTORY DATA LOAD
    ════════════════════════════ */
    let inventory = [];
    let activeTab = 'all';

    async function loadInventory() {
      const res = await fetch('/dentist/inventory/data', {
        cache: 'no-store'
      });
      const ct = res.headers.get("content-type") || "";
      if (!ct.includes("application/json")) {
        console.error("Inventory data is not JSON.");
        return;
      }
      inventory = await res.json();
      renderTable();
    }
    loadInventory();

    /* ── STAT CARDS ── */
    function updateStats() {
      document.getElementById('statTotal').textContent = inventory.length;
      document.getElementById('statMedicine').textContent = inventory.filter(i => i.category === 'Medicine').length;
      document.getElementById('statSupplies').textContent = inventory.filter(i => i.category === 'Supplies').length;
      document.getElementById('statLow').textContent = inventory.filter(i => (Number(i.qty) - Number(i.used)) <= 5).length;
    }

    /* ── CATEGORY TABS ── */
    function setTab(tab, btn) {
      activeTab = tab;
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      renderTable();
    }

    /* ════════════════════════════
       FILTER STATE
    ════════════════════════════ */
    const activeFilters = {
      sort: "",
      dateFrom: "",
      dateTo: "",
      dateOrder: "",
      stock: ""
    };

    function openFilterPanel() {
      setRadio("fp_sort", activeFilters.sort);
      setRadio("fp_dateOrder", activeFilters.dateOrder);
      setRadio("fp_stock", activeFilters.stock);
      document.getElementById("fp_dateFrom").value = activeFilters.dateFrom || "";
      document.getElementById("fp_dateTo").value = activeFilters.dateTo || "";
      document.getElementById('filterPanel').classList.add('open');
      document.getElementById('filterOverlay').classList.add('open');
    }

    function closeFilterPanel() {
      document.getElementById('filterPanel').classList.remove('open');
      document.getElementById('filterOverlay').classList.remove('open');
    }

    function setRadio(name, val) {
      document.querySelectorAll(`input[name="${name}"]`).forEach(r => r.checked = (val && r.value === val));
    }

    function getRadio(name) {
      const el = document.querySelector(`input[name="${name}"]:checked`);
      return el ? el.value : "";
    }

    function clearFilterPanel() {
      ['fp_sort', 'fp_dateOrder', 'fp_stock'].forEach(n => setRadio(n, ""));
      document.getElementById("fp_dateFrom").value = "";
      document.getElementById("fp_dateTo").value = "";
      Object.keys(activeFilters).forEach(k => activeFilters[k] = "");
      closeFilterPanel();
      renderTable();
    }

    function saveFilterPanel() {
      activeFilters.sort = getRadio("fp_sort");
      activeFilters.dateOrder = getRadio("fp_dateOrder");
      activeFilters.stock = getRadio("fp_stock");
      activeFilters.dateFrom = document.getElementById("fp_dateFrom").value || "";
      activeFilters.dateTo = document.getElementById("fp_dateTo").value || "";
      closeFilterPanel();
      renderTable();
    }

    /* ════════════════════════════
       TABLE RENDER
    ════════════════════════════ */
    function renderTable() {
      const tbody = document.getElementById("tableBody");
      tbody.innerHTML = "";
      let data = [...inventory];

      if (activeTab === 'medicine') data = data.filter(i => i.category === 'Medicine');
      if (activeTab === 'supplies') data = data.filter(i => i.category === 'Supplies');

      const q = (document.getElementById('searchInput').value || '').toLowerCase();
      if (q) data = data.filter(i =>
        String(i.stock_no || "").toLowerCase().includes(q) ||
        String(i.name || "").toLowerCase().includes(q)
      );

      const from = activeFilters.dateFrom ? new Date(activeFilters.dateFrom) : null;
      const to = activeFilters.dateTo ? new Date(activeFilters.dateTo) : null;
      if (from) {
        from.setHours(0, 0, 0, 0);
        data = data.filter(i => i.date_received && new Date(i.date_received) >= from);
      }
      if (to) {
        to.setHours(23, 59, 59, 999);
        data = data.filter(i => i.date_received && new Date(i.date_received) <= to);
      }

      const n = v => {
        const x = Number(v);
        return isFinite(x) ? x : 0;
      };
      const dt = v => {
        if (!v) return 0;
        const t = new Date(v).getTime();
        return isFinite(t) ? t : 0;
      };

      if (activeFilters.stock === "low-high") data.sort((a, b) => (n(a.qty) - n(a.used)) - (n(b.qty) - n(b.used)));
      else if (activeFilters.stock === "high-low") data.sort((a, b) => (n(b.qty) - n(b.used)) - (n(a.qty) - n(a.used)));
      else if (activeFilters.sort === "az") data.sort((a, b) => String(a.name || "").localeCompare(String(b.name || "")));
      else if (activeFilters.sort === "za") data.sort((a, b) => String(b.name || "").localeCompare(String(a.name || "")));
      else if (activeFilters.dateOrder === "asc") data.sort((a, b) => dt(a.date_received) - dt(b.date_received));
      else if (activeFilters.dateOrder === "desc") data.sort((a, b) => dt(b.date_received) - dt(a.date_received));

      updateStats();
      document.getElementById('rowCount').textContent = `${data.length} item${data.length !== 1 ? 's' : ''}`;
      document.getElementById('pageInfo').textContent = `Showing ${data.length} of ${inventory.length} items`;

      const emptyState = document.getElementById("emptyState");
      if (!data.length) {
        emptyState.style.display = 'block';
        const isSearching = q.length > 0;
        const hasFilters = Object.values(activeFilters).some(Boolean);
        const emptyMessages = {
          all: {
            icon: 'fa-box-open',
            title: 'No items in the inventory',
            sub: 'Add your first item using the "Add Item" button above.'
          },
          medicine: {
            icon: 'fa-pills',
            title: 'No medicines in the inventory',
            sub: 'Add a medicine item using the "Add Item" button above.'
          },
          supplies: {
            icon: 'fa-syringe',
            title: 'No dental supplies in the inventory',
            sub: 'Add a supply item using the "Add Item" button above.'
          },
        };
        let icon, title, sub, extraHtml = "";
        if (isSearching) {
          icon = "fa-magnifying-glass";
          title = `No results for "${q}"`;
          sub = "Try a different stock number or supply name.";
          extraHtml = `<button onclick="clearSearch()" class="mt-3 px-4 py-2 rounded-xl border border-dashed border-gray-300 text-sm text-gray-400 hover:border-[#8B0000] hover:text-[#8B0000] hover:bg-[#8B0000]/5 transition-all duration-200"><i class="fa-solid fa-xmark mr-1.5 text-xs"></i> Clear search</button>`;
        } else if (hasFilters) {
          icon = "fa-sliders";
          title = "No matches for your filters";
          sub = "Try removing or adjusting your filter criteria.";
          extraHtml = `<button onclick="clearFilterPanel()" class="mt-3 px-4 py-2 rounded-xl border border-dashed border-gray-300 text-sm text-gray-400 hover:border-[#8B0000] hover:text-[#8B0000] hover:bg-[#8B0000]/5 transition-all duration-200"><i class="fa-solid fa-xmark mr-1.5 text-xs"></i> Clear filters</button>`;
        } else {
          const msg = emptyMessages[activeTab] || emptyMessages.all;
          icon = msg.icon;
          title = msg.title;
          sub = msg.sub;
        }
        emptyState.innerHTML = `
          <div class="flex flex-col items-center justify-center py-20 text-center gap-2">
            <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-3">
              <i class="fa-solid ${icon} text-3xl text-gray-300"></i>
            </div>
            <p class="text-base font-semibold text-gray-500">${title}</p>
            <p class="text-sm text-gray-400 max-w-xs">${sub}</p>
            ${extraHtml}
          </div>`;
        return;
      }
      emptyState.style.display = 'none';

      data.forEach(item => {
        const balance = n(item.qty) - n(item.used);
        const balClass = balance <= 0 ? 'critical' : balance <= 5 ? 'low' : 'ok';
        const balLabel = balance <= 0 ? 'Out of stock' : balance <= 5 ? 'Low stock' : 'In stock';
        const catClass = item.category === 'Medicine' ? 'medicine' : 'supplies';
        tbody.innerHTML += `
          <tr>
            <td style="color:#9A9490;font-size:12px;white-space:nowrap;">${item.formatted_date ?? ''}</td>
            <td><span class="stock-no">${item.stock_no ?? ''}</span></td>
            <td>
              <div class="supply-name">${item.name ?? ''}</div>
              <span class="supply-cat ${catClass}">${item.category ?? ''}</span>
            </td>
            <td style="color:#9A9490;">${item.unit ?? ''}</td>
            <td style="font-weight:700;">${item.qty ?? 0}</td>
            <td style="color:#9A9490;">${item.used ?? 0}</td>
            <td><span class="bal-chip ${balClass}">${balance} <span style="font-weight:400;font-size:10px;">${balLabel}</span></span></td>
            <td>
              <div style="display:flex;justify-content:center;gap:6px;">
                <button class="act-btn edit"   title="Edit"   onclick="openEdit(${item.id})"><i class="fa fa-pen"></i></button>
                <button class="act-btn delete" title="Delete" onclick="deleteItem(${item.id})"><i class="fa fa-trash"></i></button>
              </div>
            </td>
          </tr>`;
      });
    }

    /* ── SEARCH CLEAR ── */
    function toggleSearchClear(input) {
      document.getElementById('searchClearBtn').classList.toggle('visible', input.value.length > 0);
    }

    function clearSearch() {
      const input = document.getElementById('searchInput');
      input.value = '';
      document.getElementById('searchClearBtn').classList.remove('visible');
      renderTable();
      input.focus();
    }

    /* ════════════════════════════
       ADD — VALIDATION HELPERS
    ════════════════════════════ */

    /** Format stock number as NN-NNN */
    function formatStockNo(input) {
      let digits = input.value.replace(/\D/g, '');
      if (digits.length > 5) digits = digits.slice(0, 5);
      input.value = digits.length <= 2 ? digits : digits.slice(0, 2) + '-' + digits.slice(2);
    }

    function updateCharCounter(fieldId, max) {
      const len = document.getElementById(fieldId).value.length;
      const counter = document.getElementById(`charCounter-${fieldId}`);
      if (!counter) return;
      counter.textContent = `${len} / ${max}`;
      counter.className = 'char-counter' + (len >= max ? ' over' : len >= max * 0.85 ? ' warn' : '');
    }

    function setFieldState(id, errorMsg) {
      const el = document.getElementById(id);
      const errEl = document.getElementById(`err-${id}`);
      if (!el) return;
      if (errorMsg) {
        el.classList.add('is-invalid');
        el.classList.remove('is-valid');
        if (errEl) errEl.innerHTML = `<i class="fa-solid fa-circle-exclamation" style="font-size:9px;"></i> ${errorMsg}`;
      } else {
        el.classList.remove('is-invalid');
        el.classList.add('is-valid');
        if (errEl) errEl.innerHTML = '';
      }
    }

    function validateAddField(id) {
      const el = document.getElementById(id);
      if (!el) return true;
      const val = el.value.trim();
      const today = new Date();
      today.setHours(23, 59, 59, 999);

      switch (id) {
        case 'addCategory':
          if (!val) {
            setFieldState(id, 'Please select a category');
            return false;
          }
          break;
        case 'addDate': {
          if (!val) {
            setFieldState(id, 'Date is required');
            return false;
          }
          const picked = new Date(val);
          if (isNaN(picked.getTime())) {
            setFieldState(id, 'Invalid date');
            return false;
          }
          if (picked > today) {
            setFieldState(id, 'Date cannot be in the future');
            return false;
          }
          break;
        }
        case 'addStock':
          if (!val) {
            setFieldState(id, 'Stock number is required');
            return false;
          }
          if (!/^\d{2}-\d{3}$/.test(val)) {
            setFieldState(id, 'Must be in format 00-000');
            return false;
          }
          break;
        case 'addUnit':
          if (!val) {
            setFieldState(id, 'Unit is required');
            return false;
          }
          break;
        case 'addName':
          if (!val) {
            setFieldState(id, 'Name is required');
            return false;
          }
          if (val.length < 2) {
            setFieldState(id, 'Minimum 2 characters');
            return false;
          }
          break;
        case 'addQty': {
          const raw = el.value;
          if (raw === '' || raw === null) {
            setFieldState(id, 'Quantity is required');
            return false;
          }
          const qn = Number(raw);
          if (!Number.isInteger(qn) || qn < 0) {
            setFieldState(id, 'Must be a whole number ≥ 0');
            return false;
          }
          if (qn > 99999) {
            setFieldState(id, 'Maximum quantity is 99,999');
            return false;
          }
          break;
        }
        case 'addUsed': {
          const raw = el.value;
          const un = Number(raw || 0);
          const qn = Number(document.getElementById('addQty').value || 0);
          if (raw !== '' && (!Number.isInteger(un) || un < 0)) {
            setFieldState(id, 'Must be a whole number ≥ 0');
            return false;
          }
          if (un > qn) {
            setFieldState(id, 'Consumed cannot exceed quantity');
            return false;
          }
          break;
        }
      }
      setFieldState(id, '');
      return true;
    }

    function validateAllAddFields() {
      return ['addCategory', 'addDate', 'addStock', 'addUnit', 'addName', 'addQty', 'addUsed']
        .map(id => validateAddField(id)).every(Boolean);
    }

    /* ── RESET ADD FORM ── */
    function resetAddForm() {
      document.getElementById('addCategory').value = '';
      ['addDate', 'addStock', 'addName', 'addUnit', 'addQty', 'addUsed', 'addBalance']
        .forEach(id => document.getElementById(id).value = '');
      ['addCategory', 'addDate', 'addStock', 'addUnit', 'addName', 'addQty', 'addUsed'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.classList.remove('is-invalid', 'is-valid');
        const err = document.getElementById(`err-${id}`);
        if (err) err.innerHTML = '';
      });
      const counter = document.getElementById('charCounter-addName');
      if (counter) {
        counter.textContent = '0 / 100';
        counter.className = 'char-counter';
      }
    }

    /* ════════════════════════════
       ADD ITEM — always stacks a brand-new row, never updates existing items.
       Every click on "Save Item" sends a fresh POST /dentist/inventory
       which the Laravel store() method handles as an INSERT.
    ════════════════════════════ */
    async function addItem() {
      // 1. Validate all fields first
      if (!validateAllAddFields()) {
        const firstInvalid = document.querySelector('#addModal .is-invalid');
        if (firstInvalid) firstInvalid.scrollIntoView({
          behavior: 'smooth',
          block: 'center'
        });
        return;
      }

      // 2. Show loading state on the button
      const btnSave = document.getElementById('btnSaveAdd');
      btnSave.disabled = true;
      btnSave.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving…';

      // 3. Always POST — this calls store() on the backend, always INSERTs a new record.
      //    The same stock_no can appear multiple times (different deliveries / batches).
      const res = await fetch('/dentist/inventory', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json' // tells Laravel to return JSON errors, not HTML redirects
        },
        body: JSON.stringify({
          category: document.getElementById('addCategory').value,
          date_received: document.getElementById('addDate').value,
          stock_no: document.getElementById('addStock').value.trim(),
          name: document.getElementById('addName').value.trim(),
          unit: document.getElementById('addUnit').value.trim(),
          qty: Number(document.getElementById('addQty').value),
          used: Number(document.getElementById('addUsed').value || 0)
        })
      });

      // 4. Re-enable the button
      btnSave.disabled = false;
      btnSave.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Save Item';

      if (!res.ok) {
        // Map any Laravel validation errors back to their fields
        const err = await res.json().catch(() => ({}));
        if (err.errors) {
          const map = {
            category: 'addCategory',
            date_received: 'addDate',
            stock_no: 'addStock',
            name: 'addName',
            unit: 'addUnit',
            qty: 'addQty',
            used: 'addUsed'
          };
          Object.entries(err.errors).forEach(([k, v]) => {
            if (map[k]) setFieldState(map[k], Array.isArray(v) ? v[0] : v);
          });
        } else {
          showToast('error', 'Could not save item. Please try again.');
        }
        return;
      }

      // 5. Success — close modal, clear form, reload table (new row appears at bottom)
      document.getElementById('addModal').close();
      resetAddForm();
      await loadInventory();
      showToast('success', 'Item added and stacked successfully!');
    }

    /* ════════════════════════════
       DELETE
    ════════════════════════════ */
    let deleteId = null;

    function deleteItem(id) {
      deleteId = id;
      document.getElementById('deleteModal').showModal();
    }

    document.getElementById("confirmDeleteBtn").onclick = async () => {
      if (!deleteId) return;
      await fetch(`/dentist/inventory/${deleteId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      });
      document.getElementById('deleteModal').close();
      deleteId = null;
      await loadInventory();
      showToast('success', 'Item deleted.');
    };

    /* ════════════════════════════
       EDIT
    ════════════════════════════ */
    let editId = null;

    function openEdit(id) {
      editId = id;
      const i = inventory.find(item => item.id === id);
      if (!i) return;
      document.getElementById('editCategory').value = i.category;
      document.getElementById('editStock').value = i.stock_no;
      document.getElementById('editName').value = i.name;
      document.getElementById('editUnit').value = i.unit;
      document.getElementById('editQty').value = i.qty;
      document.getElementById('editUsed').value = i.used;
      document.getElementById('editDate').value = i.date_received?.slice(0, 10);
      computeEditBalance();
      document.getElementById('editModal').showModal();
    }

    async function saveEdit() {
      if (!editId) return;
      const res = await fetch(`/dentist/inventory/${editId}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
          category: document.getElementById('editCategory').value,
          date_received: document.getElementById('editDate').value,
          stock_no: document.getElementById('editStock').value,
          name: document.getElementById('editName').value,
          unit: document.getElementById('editUnit').value,
          qty: Number(document.getElementById('editQty').value),
          used: Number(document.getElementById('editUsed').value)
        })
      });
      if (!res.ok) {
        showToast('error', 'Edit failed — please try again.');
        return;
      }
      document.getElementById('editModal').close();
      editId = null;
      await loadInventory();
      showToast('success', 'Item updated successfully!');
    }

    /* ── BALANCE HELPERS ── */
    function computeAddBalance() {
      const q = Number(document.getElementById('addQty').value || 0);
      const u = Number(document.getElementById('addUsed').value || 0);
      document.getElementById('addBalance').value = q - u;
    }

    function computeEditBalance() {
      const q = Number(document.getElementById('editQty').value || 0);
      const u = Number(document.getElementById('editUsed').value || 0);
      document.getElementById('editBalance').value = q - u;
    }
  </script>

</body>

</html>