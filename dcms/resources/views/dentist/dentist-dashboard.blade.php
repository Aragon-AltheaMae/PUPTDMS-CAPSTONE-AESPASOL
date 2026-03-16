<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dentist Dashboard | PUP Taguig Dental Clinic</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

  <script>
    tailwind.config = {
      daisyui: {
        themes: false
      }
    }
  </script>

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
      font-family: 'Inter';
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(6px)
      }

      to {
        opacity: 1;
        transform: translateY(0)
      }
    }

    .fade-in {
      animation: fadeIn .6s ease-out forwards;
    }

    @keyframes wave {
      0% {
        transform: rotate(0deg)
      }

      20% {
        transform: rotate(14deg)
      }

      40% {
        transform: rotate(-8deg)
      }

      60% {
        transform: rotate(14deg)
      }

      80% {
        transform: rotate(-4deg)
      }

      100% {
        transform: rotate(0deg)
      }
    }

    .wave-hand {
      transform-origin: 70% 70%;
      animation: wave 2.5s ease-in-out infinite;
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

    [data-theme="dark"] .text-\[\#333333\] {
      color: #E5E7EB !important;
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

    /* ── TOAST ── */
    #toastContainer {
      position: fixed !important;
      top: 20px !important;
      right: 20px !important;
      bottom: unset !important;
      left: unset !important;
      z-index: 99999;
      display: flex;
      flex-direction: column;
      gap: 10px;
      pointer-events: none;
      width: auto !important;
      padding: 0 !important;
    }

    #toastContainer .toast {
      min-width: 300px;
      max-width: 360px;
      background: white !important;
      border-radius: 14px !important;
      box-shadow: 0 10px 40px rgba(0, 0, 0, .18) !important;
      padding: 14px 18px 14px 16px !important;
      display: flex !important;
      align-items: center !important;
      gap: 12px;
      opacity: 0;
      transform: translateX(340px);
      transition: all .35s cubic-bezier(.68, -.55, .265, 1.55);
      position: relative;
      overflow: hidden;
      pointer-events: all;
      flex-direction: row !important;
    }

    #toastContainer .toast::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 4px;
      background: none;
    }

    #toastContainer .toast.error::before {
      background: #8B0000 !important;
    }

    #toastContainer .toast.success::before {
      background: #15803d !important;
    }

    #toastContainer .toast.show {
      opacity: 1 !important;
      transform: translateX(0) !important;
    }

    #toastContainer .toast.hide {
      opacity: 0 !important;
      transform: translateX(340px) !important;
    }

    #toastContainer .toast-icon-wrap {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    #toastContainer .toast.error .toast-icon-wrap {
      background: rgba(139, 0, 0, .08);
    }

    #toastContainer .toast.success .toast-icon-wrap {
      background: rgba(21, 128, 61, .08);
    }

    #toastContainer .toast-icon {
      font-size: 17px;
    }

    #toastContainer .toast.error .toast-icon {
      color: #8B0000 !important;
    }

    #toastContainer .toast.success .toast-icon {
      color: #15803d !important;
    }

    #toastContainer .toast-body {
      flex: 1;
      min-width: 0;
    }

    #toastContainer .toast-title {
      font-size: 13px;
      font-weight: 700;
      color: #1A0A0A !important;
    }

    #toastContainer .toast-msg {
      font-size: 12px;
      color: #888 !important;
      margin-top: 2px;
      line-height: 1.4;
    }

    #toastContainer .toast-close {
      background: none !important;
      border: none;
      cursor: pointer;
      color: #CCC;
      font-size: 13px;
      flex-shrink: 0;
      padding: 2px 4px;
      transition: color .2s;
    }

    #toastContainer .toast-close:hover {
      color: #888;
    }

    /* ── TERMS MODAL ── */
    #termsModal {
      border: none;
      padding: 0;
      border-radius: 16px;
      width: min(94vw, 650px);
      box-shadow: 0 20px 60px rgba(0, 0, 0, .22), 0 0 0 1px rgba(139, 0, 0, .08);
      overflow: hidden;
    }

    #termsModal::backdrop {
      background: rgba(0, 0, 0, .55);
      backdrop-filter: blur(4px);
    }

    .terms-header {
      background: linear-gradient(135deg, #6b0000 0%, #8B0000 100%);
      padding: 20px 24px 18px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .terms-header-icon {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      background: rgba(255, 255, 255, .15);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .terms-header-icon i {
      font-size: 16px;
      color: rgba(255, 255, 255, .9);
    }

    .terms-header h2 {
      color: white;
      font-size: 1.05rem;
      font-weight: 800;
      margin: 0;
      letter-spacing: -.01em;
    }

    .terms-header p {
      color: rgba(255, 255, 255, .65);
      font-size: .72rem;
      margin: 2px 0 0;
    }

    .terms-body {
      padding: 22px 24px 20px;
    }

    .terms-body p {
      font-size: .85rem;
      color: #4B5563;
      line-height: 1.75;
      margin-bottom: 12px;
    }

    .terms-body strong {
      color: #1f2937;
      font-weight: 700;
    }

    .terms-divider {
      height: 1px;
      background: #f0e8e8;
      margin: 4px 0 16px;
    }

    .terms-checkbox-row {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      background: #fdf5f5;
      border: 1px solid #fce8e8;
      border-radius: 10px;
      padding: 12px 14px;
      margin-bottom: 20px;
      cursor: pointer;
    }

    .terms-checkbox-row input[type="checkbox"] {
      margin-top: 2px;
      cursor: pointer;
      accent-color: #8B0000;
      width: 15px;
      height: 15px;
      flex-shrink: 0;
    }

    .terms-checkbox-row span {
      font-size: .82rem;
      font-weight: 600;
      color: #374151;
      line-height: 1.5;
    }

    .terms-actions {
      display: flex;
      justify-content: flex-end;
      gap: 8px;
    }

    .terms-cancel-btn {
      padding: 9px 20px;
      border-radius: 9px;
      border: 1px solid #e5e7eb;
      background: #f9fafb;
      color: #6b7280;
      font-weight: 600;
      font-size: .82rem;
      cursor: pointer;
      transition: all .15s;
      font-family: 'Inter', sans-serif;
    }

    .terms-cancel-btn:hover {
      background: #f3f4f6;
      border-color: #d1d5db;
      color: #374151;
    }

    .terms-continue-btn {
      padding: 9px 22px;
      border-radius: 9px;
      border: none;
      background: #9CA3AF;
      color: white;
      font-weight: 700;
      font-size: .82rem;
      cursor: not-allowed;
      transition: all .2s;
      font-family: 'Inter', sans-serif;
    }

    .terms-continue-btn:not(:disabled) {
      background: #8B0000;
      cursor: pointer;
      box-shadow: 0 2px 10px rgba(139, 0, 0, .3);
    }

    .terms-continue-btn:not(:disabled):hover {
      background: #700000;
      box-shadow: 0 4px 14px rgba(139, 0, 0, .4);
    }

    [data-theme="dark"] #termsModal {
      background: #161b22;
    }

    [data-theme="dark"] .terms-body p {
      color: #9ca3af;
    }

    [data-theme="dark"] .terms-body strong {
      color: #e5e7eb;
    }

    [data-theme="dark"] .terms-divider {
      background: #21262d;
    }

    [data-theme="dark"] .terms-checkbox-row {
      background: #1c1c1c;
      border-color: #2d1a1a;
    }

    [data-theme="dark"] .terms-checkbox-row span {
      color: #d1d5db;
    }

    [data-theme="dark"] .terms-cancel-btn {
      background: #1f2937;
      border-color: #374151;
      color: #9ca3af;
    }

    [data-theme="dark"] .terms-cancel-btn:hover {
      background: #374151;
      color: #e5e7eb;
    }

    @media(max-width:640px) {
      #toastContainer {
        left: 12px !important;
        right: 12px !important;
        top: 72px !important;
        bottom: unset !important;
        width: auto !important;
      }

      #toastContainer .toast {
        min-width: unset !important;
        width: 100% !important;
        transform: translateY(-120px) !important;
        border-radius: 12px !important;
      }

      #toastContainer .toast.show {
        transform: translateY(0) !important;
        opacity: 1 !important;
      }

      #toastContainer .toast.hide {
        transform: translateY(-120px) !important;
        opacity: 0 !important;
      }
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

    /* ════════════════════════════════
       GREETING ROW — REDESIGNED
    ════════════════════════════════ */
    .greeting-row {
      display: flex;
      flex-direction: row;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      margin-bottom: 1.5rem;
      flex-wrap: nowrap;
    }

    .greeting-title {
      font-size: clamp(1.25rem, 3.5vw, 2.1rem);
      line-height: 1.2;
      margin-bottom: 0 !important;
    }

    .greeting-title span {
      display: inline;
      word-break: break-word;
    }

    /* Status pill card */
    .status-card {
      display: flex;
      align-items: center;
      gap: 12px;
      background: #fff;
      border: 1px solid #f0e8e8;
      box-shadow: 0 2px 12px rgba(139, 0, 0, .06);
      border-radius: 16px;
      padding: 10px 16px;
      flex-shrink: 0;
    }

    .status-card-labels {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 2px;
    }

    .status-card-eyebrow {
      font-size: 9px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: .1em;
      color: #b0b7c3;
    }

    .status-card-text {
      font-size: 11px;
      font-weight: 600;
      color: #757575;
      white-space: nowrap;
    }

    @media (max-width: 480px) {
      .greeting-row {
        flex-wrap: wrap;
        align-items: flex-start;
      }

      .status-card {
        width: 100%;
        justify-content: space-between;
      }

      .status-card-labels {
        align-items: flex-start;
      }
    }

    /* ════════════════════════════════
       KPI GRID
    ════════════════════════════════ */
    .kpi-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1rem;
      margin-bottom: 2rem;
    }

    @media (min-width: 640px) {
      .kpi-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    @media (min-width: 1024px) {
      .kpi-grid {
        grid-template-columns: repeat(5, 1fr);
      }
    }

    .kpi-grid>*:nth-child(5) {
      grid-column: 1 / -1;
    }

    @media (min-width: 640px) {
      .kpi-grid>*:nth-child(5) {
        grid-column: auto;
      }
    }

    /* ════════════════════════════════
       ROW GRIDS
    ════════════════════════════════ */
    .row2-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1.5rem;
      margin-bottom: 1.5rem;
    }

    @media (min-width: 1024px) {
      .row2-grid {
        grid-template-columns: 7fr 5fr;
        align-items: stretch;
      }
    }

    .row3-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1.5rem;
    }

    @media (min-width: 1024px) {
      .row3-grid {
        grid-template-columns: 7fr 5fr;
      }
    }

    @media (max-width: 639px) {
      #mainContent {
        padding-left: 0.75rem !important;
        padding-right: 0.75rem !important;
      }
    }

    #statusBtn {
      white-space: nowrap;
      flex-shrink: 0;
    }

    @media (max-width: 1023px) {
      #dentistCalendarContainer {
        min-height: 360px !important;
      }

      .inventory-scroll-wrap {
        position: relative;
      }

      .inventory-scroll-wrap::after {
        content: '';
        position: sticky;
        bottom: 0;
        display: block;
        height: 24px;
        background: linear-gradient(to bottom, transparent, rgba(255, 255, 255, .9));
        pointer-events: none;
        margin-top: -24px;
      }
    }
  </style>
</head>

@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();

$dentalCasesThisMonth = $dentalCasesThisMonth ?? 0;
$totalApptsThisMonth = $totalApptsThisMonth ?? 0;

$dentalCasesDelta = $dentalCasesDelta ?? null;
$totalApptsDelta = $totalApptsDelta ?? null;

$gadLabels = $gadLabels ?? ['Student', 'Administrative', 'Faculty', 'Dependent'];
$gadFemale = $gadFemale ?? [0, 0, 0, 0];
$gadMale = $gadMale ?? [0, 0, 0, 0];

$appointmentCountsPerDay = $appointmentCountsPerDay ?? [];
$unavailableDates = $unavailableDates ?? [];
$philippineHolidays = $philippineHolidays ?? [];
$todayAppointments = $todayAppointments ?? collect();

$medicalSupplies = $medicalSupplies ?? collect();
$medicineSupplies = $medicineSupplies ?? collect();

$calendarAppointmentCounts = $appointmentCountsPerDay;

if (empty($calendarAppointmentCounts) && $todayAppointments->count() > 0) {
$calendarAppointmentCounts = [
\Carbon\Carbon::today()->format('Y-m-d') => $todayAppointments->count(),
];
}
@endphp

<body class="bg-white text-[#333333] font-normal">

  <div id="toastContainer" role="region" aria-live="polite" style="position:fixed!important;top:20px!important;right:20px!important;
           bottom:unset!important;left:unset!important;z-index:99999;
           display:flex;flex-direction:column;gap:10px;pointer-events:none;">
  </div>

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
              <i class="fa-solid fa-right-from-bracket"></i> Log out
            </button>
          </form>
        </div>
      </div>
    </div>
  </header>

  <!-- SIDEBAR -->
  <aside id="sidebar" style="width:220px;">
    <div class="sidebar-inner">
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
      <button class="drawer-close-btn" onclick="closeDrawer()"><i class="fa-solid fa-xmark"></i></button>
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

  <!-- CONTENT -->
  <main id="mainContent" class="pt-[100px] px-6 py-6 fade-up min-h-screen">
    <div class="max-w-7xl mx-auto fade-in">

      @if(session('impersonated_role') && session('impersonator_role') === 'super_admin')
      <div
        style="background:#DBEAFE;border:1px solid #93C5FD;color:#1E40AF;padding:14px 18px;margin-bottom:16px;border-radius:12px;display:flex;justify-content:space-between;align-items:center;gap:12px;">
        <div>
          <strong>You are viewing as {{ ucfirst(session('impersonated_role')) }}</strong><br>
          <span style="font-size:13px;">Super Admin impersonation mode is active.</span>
        </div>
        <form method="POST" action="{{ route('admin.stop_impersonation') }}">
          @csrf
          <button type="submit"
            style="background:#8B0000;color:#fff;border:none;padding:10px 16px;border-radius:8px;font-weight:700;cursor:pointer;">
            Return to Admin
          </button>
        </form>
      </div>
      @endif

      <!-- ════════ GREETING — REDESIGNED ════════ -->
      <div class="greeting-row">

        <!-- Left: greeting text + date -->
        <div class="min-w-0 flex-1">
          <h1 class="greeting-title font-extrabold fade-in">
            <span class="bg-gradient-to-r from-[#660000] to-[#FFD700] bg-clip-text text-transparent">
              Good Morning, <span id="dentistName"></span>
              <i class="fa-solid fa-hand text-[#FFD700] wave-hand"></i>
            </span>
          </h1>
          <p class="text-xs text-[#9CA3AF] font-medium mt-1" id="greetingDate"></p>
        </div>

        <!-- Right: status pill card -->
        <div class="status-card">
          <div class="status-card-labels">
            <span class="status-card-eyebrow">Clinic Status</span>
            <span class="status-card-text">The Dentist is currently</span>
          </div>
          <button id="statusBtn" onclick="openStatusModal()"
            class="btn btn-success rounded-full px-5 font-bold shadow transition-all duration-300">
            <span id="statusLabel" class="flex items-center gap-2">
              <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span> IN
            </span>
          </button>
        </div>

      </div>
      <!-- ════════ END GREETING ════════ -->

      <!-- KPI CARDS -->
      <div class="kpi-grid">

        {{-- KPI 1: Dental Cases --}}
        <div class="relative overflow-hidden rounded-2xl p-5 text-white"
          style="background:linear-gradient(135deg,#8B0000 0%,#5a0000 100%);box-shadow:0 4px 20px rgba(139,0,0,.35);">
          <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
              style="background:rgba(255,255,255,.15);">
              <i class="fa-solid fa-tooth text-yellow-300 text-lg"></i>
            </div>
            @if(!is_null($dentalCasesDelta))
            <span class="text-[10px] font-bold px-2 py-1 rounded-full" style="background:rgba(255,255,255,.15);">
              {{ $dentalCasesDelta >= 0 ? '+' : '' }}{{ $dentalCasesDelta }}%
            </span>
            @endif
          </div>
          <p class="text-4xl font-extrabold leading-none tracking-tight">{{ $dentalCasesThisMonth }}</p>
          <p class="text-xs font-semibold mt-1 uppercase tracking-widest" style="opacity:.65;">Dental Cases</p>
          <p class="text-xs mt-0.5" style="opacity:.45;">{{ now()->format('F Y') }}</p>
          <div class="absolute -bottom-5 -right-5 w-24 h-24 rounded-full" style="background:rgba(255,255,255,.05);">
          </div>
        </div>

        {{-- KPI 2: Total Appointments --}}
        <div class="relative overflow-hidden rounded-2xl p-5 bg-white"
          style="border:1.5px solid #fce8e8;box-shadow:0 2px 12px rgba(139,0,0,.08);">
          <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
              <i class="fa-regular fa-calendar-check text-[#8B0000] text-lg"></i>
            </div>
            @if(!is_null($totalApptsDelta))
            <span
              class="text-[10px] font-bold px-2 py-1 rounded-full {{ $totalApptsDelta >= 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
              {{ $totalApptsDelta >= 0 ? '+' : '' }}{{ $totalApptsDelta }}%
            </span>
            @endif
          </div>
          <p class="text-4xl font-extrabold leading-none tracking-tight text-[#8B0000]">{{ $totalApptsThisMonth }}</p>
          <p class="text-xs font-semibold mt-1 uppercase tracking-widest text-[#8B0000]/50">Total Appointments</p>
          <p class="text-xs text-gray-400 mt-0.5">{{ now()->format('F Y') }}</p>
          <div class="absolute -bottom-5 -right-5 w-24 h-24 rounded-full bg-red-50/40"></div>
        </div>

        {{-- KPI 3: Today's Patients --}}
        <div class="relative overflow-hidden rounded-2xl p-5 bg-white"
          style="border:1.5px solid #fce8e8;box-shadow:0 2px 12px rgba(139,0,0,.08);">
          <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-red-50 flex-shrink-0"
              style="display:flex;align-items:center;justify-content:center;">
              <i class="fa-solid fa-user-clock text-[#8B0000] text-lg"></i>
            </div>
            <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-green-50 text-green-700">Today</span>
          </div>
          <p class="text-4xl font-extrabold leading-none tracking-tight text-[#8B0000]">{{ $todayAppointments->count()
            }}</p>
          <p class="text-xs font-semibold mt-1 uppercase tracking-widest text-[#8B0000]/50">Today's Patients</p>
          <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
            <span class="text-green-500 font-semibold">{{ $todayAppointments->where('status','confirmed')->count() }}
              confirmed</span>
            <span class="text-gray-300">·</span>
            <span class="text-yellow-500 font-semibold">{{ $todayAppointments->where('status','pending')->count() }}
              pending</span>
          </p>
          <div class="absolute -bottom-5 -right-5 w-24 h-24 rounded-full bg-red-50/40"></div>
        </div>

        {{-- KPI 4: Live Clock --}}
        <div class="relative overflow-hidden rounded-2xl p-5"
          style="background:linear-gradient(135deg,#7b0c0c 0%,#4a0606 100%);box-shadow:0 4px 20px rgba(100,0,0,.3);">
          <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
              <i id="kpi-clock-icon" class="fa-solid fa-sun text-yellow-300 text-lg"></i>
            </div>
            <span class="text-[10px] font-bold px-2 py-1 rounded-full text-white"
              style="background:rgba(255,255,255,.15);">
              <span class="inline-block w-1.5 h-1.5 rounded-full bg-red-400 animate-pulse mr-1"
                style="vertical-align:middle;"></span>Live
            </span>
          </div>
          <p class="leading-none text-white">
            <span id="kpi-clock-hhmm" class="text-3xl font-extrabold tracking-tight"
              style="font-variant-numeric:tabular-nums;">00:00</span><span id="kpi-clock-ss"
              class="text-xl font-semibold opacity-50" style="font-variant-numeric:tabular-nums;">:00</span><span
              id="kpi-clock-ampm" class="text-xs font-bold opacity-60 ml-1 align-super">AM</span>
          </p>
          <p class="text-xs font-semibold mt-1 uppercase tracking-widest text-white" style="opacity:.55;">Live Time</p>
          <p class="text-xs mt-0.5 text-white flex items-center gap-1.5" style="opacity:.45;">
            <i id="kpi-clock-dayicon" class="fa-solid fa-sun text-xs flex-shrink-0" style="color:#fde68a;"></i>
            <span id="kpi-clock-date"></span>
          </p>
          <div class="absolute -bottom-5 -right-5 w-24 h-24 rounded-full" style="background:rgba(255,255,255,.04);">
          </div>
        </div>

        {{-- KPI 5: Clinic Status --}}
        <div class="relative overflow-hidden rounded-2xl p-5 bg-white"
          style="border:1.5px solid #d1fae5;box-shadow:0 2px 12px rgba(16,185,129,.08);">
          <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-green-50 flex-shrink-0"
              style="display:flex;align-items:center;justify-content:center;">
              <i id="statusKpiIcon" class="fa-solid fa-door-open text-green-600 text-lg"></i>
            </div>
            <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-green-50 text-green-700">Live</span>
          </div>
          <p id="statusKpiLabel" class="text-2xl font-extrabold leading-none tracking-tight text-green-600">Open</p>
          <p class="text-xs font-semibold mt-1 uppercase tracking-widest text-[#8B0000]/50">Clinic Status</p>
          <button onclick="openStatusModal()"
            class="mt-2 text-xs font-semibold text-[#8B0000] hover:underline flex items-center gap-1">
            Change <i class="fa-solid fa-arrow-right text-[10px]"></i>
          </button>
          <div class="absolute -bottom-5 -right-5 w-24 h-24 rounded-full bg-green-50/50"></div>
        </div>

      </div>

      <!-- ROW 2: CALENDAR + SCHEDULE -->
      <div class="row2-grid">
        <div>
          <div id="dentistCalendarContainer" class="bg-white border shadow rounded-2xl p-6 w-full min-h-[420px] h-full">
            <div class="animate-pulse space-y-4">
              <div class="h-6 w-40 bg-gray-200 rounded mx-auto"></div>
              <div class="grid grid-cols-7 gap-2">
                @for($i = 0; $i < 35; $i++) <div class="h-9 bg-gray-200 rounded-lg">
              </div>
              @endfor
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="card bg-gradient-to-b from-[#8B0000] to-[#660000] text-white shadow h-full">
          <div class="card-body flex flex-col">
            <div class="flex items-center justify-between mb-3">
              <h2 class="text-base font-bold flex items-center gap-2">
                <i class="fa-regular fa-clock text-yellow-300"></i> Scheduled Today
              </h2>
              <span class="badge bg-yellow-400 text-[#660000] font-bold border-none px-3">
                {{ $todayAppointments->count() }} {{ \Illuminate\Support\Str::plural('patient',
                $todayAppointments->count()) }}
              </span>
            </div>
            <div class="space-y-2 flex-1 overflow-y-auto pr-1">
              @forelse($todayAppointments as $appointment)
              @php
              $name = $appointment->patient->name ?? 'Unknown Patient';
              $time = \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A');
              $service = $appointment->service_type === 'others'
              ? ($appointment->other_services ?? 'Other Service')
              : $appointment->service_type;
              $isConfirmed = $appointment->status === 'confirmed';
              @endphp
              <a href="{{ route('dentist.dentist.appointments') }}"
                class="flex items-center gap-3 bg-white/10 hover:bg-white/20 border border-white/20 p-3 rounded-xl w-full transition duration-200 hover:scale-[1.01]">
                <div
                  class="rounded-full w-9 h-9 border-2 border-yellow-300 bg-white/20 flex items-center justify-center font-bold text-sm flex-shrink-0">
                  {{ strtoupper(substr($name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                  <p class="font-semibold text-sm truncate">{{ $name }}</p>
                  <p class="text-xs opacity-70 truncate flex items-center gap-1">
                    <i class="fa-solid fa-stethoscope text-yellow-300 flex-shrink-0 text-[10px]"></i>
                    {{ ucwords($service) }} · {{ $time }}
                  </p>
                </div>
                @if($isConfirmed)
                <span class="badge badge-sm bg-green-400 text-white border-none flex-shrink-0 text-[10px]">✓</span>
                @else
                <span class="badge badge-sm bg-yellow-400 text-[#660000] border-none flex-shrink-0 text-[10px]">!</span>
                @endif
              </a>
              @empty
              <div class="flex flex-col items-center justify-center py-10 opacity-60">
                <i class="fa-regular fa-calendar-xmark text-4xl mb-3 text-yellow-300"></i>
                <p class="text-sm font-semibold">No appointments today</p>
                <p class="text-xs opacity-70 mt-1">Enjoy your free day, Doctor!</p>
              </div>
              @endforelse
            </div>
            <a href="{{ route('dentist.dentist.appointments') }}"
              class="mt-4 flex items-center justify-center gap-2 text-xs font-semibold text-yellow-300 hover:text-yellow-200 transition border-t border-white/10 pt-3">
              View all appointments <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- ROW 3: GAD CHART + INVENTORY -->
    <div class="row3-grid">

      <!-- GAD ANALYTICS -->
      <div class="card bg-white shadow rounded-2xl">
        <div class="card-body p-5">
          <div class="flex items-center justify-between mb-4">
            <div>
              <h3 class="text-base font-bold text-[#8B0000]">
                <i class="fa-solid fa-chart-column mr-1.5 opacity-70"></i>GAD Analytics
              </h3>
              <p class="text-xs text-gray-400 mt-0.5">Patient cases by category and sex — {{ now()->format('F Y') }}</p>
            </div>
            <div class="flex items-center gap-4 text-xs font-semibold">
              <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full inline-block"
                  style="background:#FFC0CB"></span>Female</span>
              <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full inline-block"
                  style="background:#89CFF0"></span>Male</span>
            </div>
          </div>
          <div style="height:300px; width:100%;"><canvas id="gadChart"></canvas></div>
        </div>
      </div>

      <!-- INVENTORY COLUMN -->
      <div class="flex flex-col gap-4">

        <!-- MEDICAL SUPPLIES -->
        <div class="relative rounded-2xl p-[2px]" style="background:linear-gradient(135deg,#660000,#FFD700);">
          <div class="card bg-white rounded-2xl">
            <div class="card-body p-4">
              <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-[#8B0000] flex items-center gap-2 text-sm">
                  <i class="fa-solid fa-boxes"></i> Medical Supplies
                </h3>
                <a href="{{ route('dentist.dentist.inventory') }}"
                  class="text-xs text-[#8B0000] hover:underline font-semibold flex items-center gap-1">
                  View all <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
              </div>
              @if($medicalSupplies->count() > 0)
              <div class="overflow-y-auto inventory-scroll-wrap" style="max-height:180px;">
                <table class="table table-xs w-full">
                  <thead class="sticky top-0 bg-white z-10">
                    <tr class="text-[#8B0000] text-[11px]">
                      <th>Item</th>
                      <th class="text-center">Qty</th>
                      <th class="text-center">Used</th>
                      <th class="text-center">Balance</th>
                    </tr>
                  </thead>
                  <tbody class="text-xs text-[#333]">
                    @foreach($medicalSupplies as $item)
                    @php
                    $balance = $item->qty - $item->used;
                    $pct = $item->qty > 0 ? ($balance / $item->qty) * 100 : 100;
                    $isLow = $pct <= 30; $badgeCls=$isLow ? 'bg-red-100 text-red-700 animate-pulse'
                      : 'bg-green-100 text-green-700' ; @endphp <tr>
                      <td class="max-w-[140px] truncate">{{ $item->name }}</td>
                      <td class="text-center">{{ $item->qty }}</td>
                      <td class="text-center">{{ $item->used }}</td>
                      <td class="text-center">
                        <span class="badge badge-xs border-none font-semibold {{ $badgeCls }}">
                          {{ $balance }}{{ $isLow ? ' ⚠' : '' }}
                        </span>
                      </td>
                      </tr>
                      @endforeach
                  </tbody>
                </table>
              </div>
              @else
              <div class="flex flex-col items-center justify-center py-5 text-center opacity-50">
                <i class="fa-solid fa-box-open text-2xl mb-2 text-[#8B0000]"></i>
                <p class="text-xs font-semibold text-gray-500">No supply items yet</p>
              </div>
              @endif
            </div>
          </div>
        </div>

        <!-- MEDICINE SUPPLIES -->
        <div class="relative rounded-2xl p-[2px]" style="background:linear-gradient(135deg,#660000,#FFD700);">
          <div class="card bg-white rounded-2xl">
            <div class="card-body p-4">
              <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-[#8B0000] flex items-center gap-2 text-sm">
                  <i class="fa-solid fa-pills"></i> Medicine Supplies
                </h3>
                <a href="{{ route('dentist.dentist.inventory') }}"
                  class="text-xs text-[#8B0000] hover:underline font-semibold flex items-center gap-1">
                  View all <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
              </div>
              @if($medicineSupplies->count() > 0)
              <div class="overflow-y-auto inventory-scroll-wrap" style="max-height:180px;">
                <table class="table table-xs w-full">
                  <thead class="sticky top-0 bg-white z-10">
                    <tr class="text-[#8B0000] text-[11px]">
                      <th>Medicine</th>
                      <th class="text-center">Form</th>
                      <th class="text-center">Qty</th>
                      <th class="text-center">Balance</th>
                    </tr>
                  </thead>
                  <tbody class="text-xs text-[#333]">
                    @foreach($medicineSupplies as $item)
                    @php
                    $balance = $item->qty - $item->used;
                    $pct = $item->qty > 0 ? ($balance / $item->qty) * 100 : 100;
                    $isLow = $pct <= 30; $badgeCls=$isLow ? 'bg-red-100 text-red-700 animate-pulse'
                      : 'bg-green-100 text-green-700' ; @endphp <tr>
                      <td class="max-w-[120px] truncate">{{ $item->name }}</td>
                      <td class="text-center">{{ $item->form ?? '—' }}</td>
                      <td class="text-center">{{ $item->qty }}</td>
                      <td class="text-center">
                        <span class="badge badge-xs border-none font-semibold {{ $badgeCls }}">
                          {{ $balance }}{{ $isLow ? ' ⚠' : '' }}
                        </span>
                      </td>
                      </tr>
                      @endforeach
                  </tbody>
                </table>
              </div>
              @else
              <div class="flex flex-col items-center justify-center py-5 text-center opacity-50">
                <i class="fa-solid fa-pills text-2xl mb-2 text-[#8B0000]"></i>
                <p class="text-xs font-semibold text-gray-500">No medicine items yet</p>
              </div>
              @endif
            </div>
          </div>
        </div>

      </div>
    </div>

    </div>
  </main>

  <!-- STATUS MODAL -->
  <div id="statusModal"
    class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
    <div id="statusModalBox"
      class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 p-0 overflow-hidden scale-90 transition-all duration-300">
      <div id="modalBanner" class="bg-gradient-to-r from-[#660000] to-[#8B0000] px-6 pt-6 pb-4 text-white text-center">
        <div id="modalIcon"
          class="w-16 h-16 rounded-full mx-auto mb-3 flex items-center justify-center text-2xl bg-white/20">
          <i class="fa-solid fa-door-closed"></i>
        </div>
        <h2 id="modalTitle" class="text-xl font-extrabold">Close the Clinic?</h2>
        <p id="modalSubtitle" class="text-sm opacity-80 mt-1">You are about to mark yourself as <strong>OUT</strong></p>
      </div>
      <div class="px-6 py-5">
        <p id="modalBody" class="text-sm text-[#555] text-center leading-relaxed">
          This will indicate that the clinic is <span class="font-semibold text-red-700">currently closed</span>.
          Patients will not be able to book new appointments while you are out.
        </p>
        <div class="flex gap-3 mt-5">
          <button onclick="closeStatusModal()"
            class="flex-1 btn btn-ghost border border-gray-200 rounded-xl font-semibold text-gray-600 hover:bg-gray-100">Cancel</button>
          <button id="confirmStatusBtn" onclick="confirmStatus()"
            class="flex-1 btn rounded-xl font-bold text-white bg-[#8B0000] hover:bg-[#660000] border-none shadow">Confirm</button>
        </div>
      </div>
    </div>
  </div>

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

  @if(session('activeAppointmentModal'))
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var modal = document.getElementById("activeAppointmentModal");
      var closeBtn = document.getElementById("closeActiveApptModalBtn");
      if (!modal) return;
      modal.showModal();
      modal.addEventListener('click', function (e) {
        var box = modal.querySelector('.modal-box');
        if (box && !box.contains(e.target)) e.preventDefault();
      });
      modal.addEventListener('cancel', function (e) { e.preventDefault(); });
      if (closeBtn) closeBtn.addEventListener("click", function () { modal.close(); });
    });
  </script>
  @endif

  @if(session('login_as'))
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      showToast('Login Successful', 'Logged in successfully as <strong>{{ session("login_as") }}</strong>', 'success');
    });
  </script>
  @endif

  <script>
    // ── Mobile Drawer ─────────────────────────────────────────────
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

    /* USER DROPDOWN */
    document.getElementById('userBtn').addEventListener('click', e => {
      e.stopPropagation();
      document.getElementById('notifMenu').classList.remove('open');
      document.getElementById('userMenu').classList.toggle('open');
    });
    document.addEventListener('click', () => document.getElementById('userMenu').classList.remove('open'));

    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('#userMenuThemeToggle .theme-option').forEach(o =>
        o.addEventListener('click', e => { e.stopPropagation(); applyTheme(o.getAttribute('data-theme')); })
      );
    });

    /* ── THEME ── */
    function applyTheme(theme) {
      document.documentElement.setAttribute("data-theme", theme);
      localStorage.setItem("theme", theme);
      document.querySelectorAll(".theme-option").forEach(o =>
        o.getAttribute("data-theme") === theme ? o.classList.add("active") : o.classList.remove("active")
      );
      const ind = document.querySelector(".theme-indicator");
      if (ind) ind.classList.toggle("dark-mode", theme === "dark");
    }

    /* ── SIDEBAR ── */
    function applyLayout(w) {
      const sidebar = document.getElementById('sidebar');
      const main = document.getElementById('mainContent');
      if (sidebar) sidebar.style.width = w;
      if (main) main.style.marginLeft = w;
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

    /* ── TERMS ── */
    document.addEventListener('DOMContentLoaded', function () {
      const termsModal = document.getElementById('termsModal');
      const termsCheckbox = document.getElementById('termsCheckbox');
      const termsContinueBtn = document.getElementById('termsContinueBtn');

      if (termsCheckbox && termsContinueBtn) {
        termsCheckbox.checked = false;
        termsContinueBtn.disabled = true;
        termsCheckbox.addEventListener('change', function () {
          termsContinueBtn.disabled = !this.checked;
        });
      }

      @if (session('show_terms_modal'))
        if (termsModal) termsModal.showModal();
      @endif
    });

    function acceptTerms() {
      const termsModal = document.getElementById('termsModal');
      if (termsModal) termsModal.close();
    }

    /* ── TOAST ── */
    function showToast(title, message, type) {
      type = type || 'error';
      var container = document.getElementById('toastContainer');
      var t = document.createElement('div');
      t.className = 'toast ' + type;
      var icon = type === 'error'
        ? '<i class="fa-solid fa-circle-exclamation toast-icon"></i>'
        : '<i class="fa-solid fa-circle-check toast-icon"></i>';
      t.innerHTML = '<div class="toast-icon-wrap">' + icon + '</div>'
        + '<div class="toast-body"><div class="toast-title">' + title + '</div>'
        + '<div class="toast-msg">' + message + '</div></div>'
        + '<button class="toast-close" onclick="this.closest(\'.toast\').classList.add(\'hide\')">'
        + '<i class="fa-solid fa-xmark"></i></button>';
      container.appendChild(t);
      requestAnimationFrame(() => requestAnimationFrame(() => t.classList.add('show')));
      setTimeout(() => {
        t.classList.remove('show'); t.classList.add('hide');
        setTimeout(() => t.remove(), 400);
      }, 4500);
    }

    const dashboardData = {
      gadLabels: @json($gadLabels),
      gadFemale: @json($gadFemale),
      gadMale: @json($gadMale),
      apptCounts: @json($calendarAppointmentCounts),
      unavailableDates: @json($unavailableDates),
      holidays: @json($philippineHolidays),
    };

    const GAD_LABELS = dashboardData.gadLabels;
    const GAD_FEMALE = dashboardData.gadFemale;
    const GAD_MALE = dashboardData.gadMale;

    /* ── LIVE CLOCK ── */
    (function () {
      const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
      const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      function tickClock() {
        const now = new Date();
        let h = now.getHours(), m = now.getMinutes(), s = now.getSeconds();
        const ampm = h >= 12 ? 'PM' : 'AM';
        const isDaytime = h >= 6 && h < 18;
        const displayHour = h % 12 || 12;

        document.getElementById('kpi-clock-hhmm').textContent = String(displayHour).padStart(2, '0') + ':' + String(m).padStart(2, '0');
        document.getElementById('kpi-clock-ss').textContent = ':' + String(s).padStart(2, '0');
        document.getElementById('kpi-clock-ampm').textContent = ampm;
        document.getElementById('kpi-clock-date').textContent = days[now.getDay()] + ', ' + months[now.getMonth()] + ' ' + now.getDate();

        const dayicon = document.getElementById('kpi-clock-dayicon');
        const bigicon = document.getElementById('kpi-clock-icon');
        dayicon.className = isDaytime ? 'fa-solid fa-sun text-xs flex-shrink-0' : 'fa-solid fa-moon text-xs flex-shrink-0';
        dayicon.style.color = isDaytime ? '#fde68a' : '#bfdbfe';
        bigicon.className = isDaytime ? 'fa-solid fa-sun text-lg' : 'fa-solid fa-moon text-lg';
        bigicon.style.color = isDaytime ? '#fde68a' : '#bfdbfe';
      }
      tickClock();
      setInterval(tickClock, 1000);
    })();

    /* ── GREETING ── */
    document.getElementById("dentistName").textContent = "Dr. Nelson!";

    // Set greeting date subtitle
    document.getElementById("greetingDate").textContent = new Date().toLocaleDateString("en-US", {
      weekday: "long", year: "numeric", month: "long", day: "numeric"
    });

    // Dynamic good morning/afternoon/evening
    (function () {
      const h = new Date().getHours();
      const greeting = h < 12 ? 'Good Morning,' : h < 18 ? 'Good Afternoon,' : 'Good Evening,';
      const greetEl = document.querySelector('.bg-gradient-to-r.from-\\[\\#660000\\].to-\\[\\#FFD700\\].bg-clip-text');
      if (greetEl) {
        const fn = greetEl.childNodes[0];
        if (fn && fn.nodeType === Node.TEXT_NODE) fn.textContent = greeting + ' ';
      }
    })();

    /* ── STATUS MODAL ── */
    let dentistIsIn = true;

    function openStatusModal() {
      const modal = document.getElementById('statusModal');
      const box = document.getElementById('statusModalBox');
      const banner = document.getElementById('modalBanner');
      const icon = document.getElementById('modalIcon');
      const title = document.getElementById('modalTitle');
      const sub = document.getElementById('modalSubtitle');
      const body = document.getElementById('modalBody');

      if (dentistIsIn) {
        banner.className = 'bg-gradient-to-r from-[#660000] to-[#8B0000] px-6 pt-6 pb-4 text-white text-center';
        icon.innerHTML = '<i class="fa-solid fa-door-closed"></i>';
        title.textContent = 'Close the Clinic?';
        sub.innerHTML = 'You are about to mark yourself as <strong>OUT</strong>';
        body.innerHTML = 'This will indicate that the clinic is <span class="font-semibold text-red-700">currently closed</span>. Patients will not be able to book new appointments while you are out.';
      } else {
        banner.className = 'bg-gradient-to-r from-green-600 to-green-700 px-6 pt-6 pb-4 text-white text-center';
        icon.innerHTML = '<i class="fa-solid fa-door-open"></i>';
        title.textContent = 'Open the Clinic?';
        sub.innerHTML = 'You are about to mark yourself as <strong>IN</strong>';
        body.innerHTML = 'This will indicate that the clinic is <span class="font-semibold text-green-700">now open</span>. Patients will be able to see your availability and book appointments.';
      }

      modal.classList.remove('opacity-0', 'pointer-events-none');
      modal.classList.add('opacity-100');
      setTimeout(() => box.classList.replace('scale-90', 'scale-100'), 10);
    }

    function closeStatusModal() {
      const modal = document.getElementById('statusModal');
      const box = document.getElementById('statusModalBox');
      box.classList.replace('scale-100', 'scale-90');
      setTimeout(() => {
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.classList.remove('opacity-100');
      }, 150);
    }

    function confirmStatus() {
      const btn = document.getElementById('statusBtn');
      const label = document.getElementById('statusLabel');
      const kpiLabel = document.getElementById('statusKpiLabel');
      const kpiIcon = document.getElementById('statusKpiIcon');
      dentistIsIn = !dentistIsIn;
      if (dentistIsIn) {
        btn.classList.replace('btn-error', 'btn-success');
        label.innerHTML = '<span class="w-2 h-2 bg-white rounded-full animate-pulse"></span> IN';
        if (kpiLabel) { kpiLabel.textContent = 'Open'; kpiLabel.className = 'text-2xl font-extrabold tracking-tight text-green-600 leading-none mt-1'; }
        if (kpiIcon) kpiIcon.className = 'fa-solid fa-door-open text-green-600 text-lg';
      } else {
        btn.classList.replace('btn-success', 'btn-error');
        label.innerHTML = '<span class="w-2 h-2 bg-white rounded-full"></span> OUT';
        if (kpiLabel) { kpiLabel.textContent = 'Closed'; kpiLabel.className = 'text-2xl font-extrabold tracking-tight text-red-600 leading-none mt-1'; }
        if (kpiIcon) kpiIcon.className = 'fa-solid fa-door-closed text-red-600 text-lg';
      }
      closeStatusModal();
    }

    document.getElementById('statusModal').addEventListener('click', function (e) {
      if (e.target === this) closeStatusModal();
    });

    /* ── DOM READY ── */
    document.addEventListener("DOMContentLoaded", () => {
      applyLayout('220px');
      applyTheme(localStorage.getItem("theme") || "light");
      document.querySelectorAll(".theme-option").forEach(o =>
        o.addEventListener("click", () => applyTheme(o.getAttribute("data-theme")))
      );

      document.getElementById("notifBtn").addEventListener("click", e => {
        e.stopPropagation();
        document.getElementById("notifMenu").classList.toggle("open");
      });
      document.addEventListener("click", () => document.getElementById("notifMenu").classList.remove("open"));

      /* GAD Chart */
      setTimeout(() => {
        const ctx = document.getElementById('gadChart');
        if (!ctx) return;
        const hasData = [...GAD_FEMALE, ...GAD_MALE].some(v => v > 0);
        if (!hasData) {
          const c = ctx.getContext('2d');
          ctx.height = 300;
          c.font = '14px Inter';
          c.fillStyle = '#707070';
          c.textAlign = 'center';
          c.fillText('No treatment records this month', ctx.parentElement.offsetWidth / 2, 150);
          return;
        }
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: GAD_LABELS,
            datasets: [
              { label: 'Female', data: GAD_FEMALE, backgroundColor: 'rgba(255,192,203,0.85)', borderColor: '#FFB6C1', borderWidth: 1, borderRadius: 6 },
              { label: 'Male', data: GAD_MALE, backgroundColor: 'rgba(137,207,240,0.85)', borderColor: '#7EC8E3', borderWidth: 1, borderRadius: 6 },
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: { display: false },
              tooltip: { callbacks: { label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y} cases` } }
            },
            scales: {
              x: {
                grid: { display: false },
                ticks: { font: { family: 'Inter', size: 12 }, color: '#555' },
                title: { display: true, text: 'Patient Category', font: { family: 'Inter', size: 12 }, color: '#888' }
              },
              y: {
                beginAtZero: true,
                grid: { borderDash: [4, 4], color: '#f0f0f0' },
                ticks: { precision: 0, font: { family: 'Inter', size: 12 }, color: '#555' },
                title: { display: true, text: 'Number of Cases', font: { family: 'Inter', size: 12 }, color: '#888' }
              }
            }
          }
        });
      }, 150);

      loadDentistCalendar();
    });

    /* ── CALENDAR ── */
    function loadDentistCalendar() {
      const MAX_PER_DAY = 5;
      const apptCounts = @json($calendarAppointmentCounts);
      const unavailableDates = @json($unavailableDates);
      const allHolidays = @json($philippineHolidays);

      const today = new Date();
      let currentYear = today.getFullYear(), currentMonth = today.getMonth();

      function pad(n) { return String(n).padStart(2, '0'); }
      function isWeekend(y, m, d) { const dow = new Date(y, m, d).getDay(); return dow === 0 || dow === 6; }

      function getHolidaysForMonth(year, month) {
        const out = {};
        Object.keys(allHolidays).forEach(ds => {
          const [y, m] = ds.split('-').map(Number);
          if (y === year && m === month + 1) out[ds] = allHolidays[ds];
        });
        return out;
      }

      function renderDentistCalendar(year, month) {
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        const dayLabels = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        const firstDow = new Date(year, month, 1).getDay();
        const totalDays = new Date(year, month + 1, 0).getDate();
        const holidays = getHolidaysForMonth(year, month);

        const headerHtml = dayLabels.map((l, i) =>
          `<div class="text-center text-[10px] font-bold ${(i === 0 || i === 6) ? 'text-[#8B0000]/40' : 'text-[#555]'} uppercase tracking-widest">${l}</div>`
        ).join('');

        let cells = '';
        for (let i = 0; i < firstDow; i++) cells += `<div></div>`;

        for (let d = 1; d <= totalDays; d++) {
          const dateStr = `${year}-${pad(month + 1)}-${pad(d)}`;
          const isToday = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
          const weekend = isWeekend(year, month, d);
          const holiday = holidays[dateStr] || null;
          const count = apptCounts[dateStr] || 0;
          const isFull = count >= MAX_PER_DAY;
          const isUnavail = unavailableDates.includes(dateStr) || weekend;
          const hasAppts = count > 0;

          let dotHtml = '', badgeHtml = '', tooltipTxt = '';

          if (holiday) {
            dotHtml = `<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-blue-400"></span>`;
            tooltipTxt = `<i class="fa-solid fa-star mr-1 text-blue-300"></i>${holiday}`;
          }

          if (hasAppts && !isUnavail) {
            if (isFull) {
              dotHtml = `<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-red-500"></span>`;
              tooltipTxt = `<i class="fa-solid fa-circle-xmark mr-1 text-red-400"></i>Fully booked — ${count} patients`;
            } else {
              dotHtml = `<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full ${isToday ? 'bg-white' : 'bg-[#8B0000]'}"></span>`;
              tooltipTxt = `<i class="fa-solid fa-user-clock mr-1 text-yellow-300"></i>${count} patient${count > 1 ? 's' : ''} scheduled`;
            }
            const pillColor = isFull ? 'bg-red-500 text-white' : (isToday ? 'bg-white text-[#8B0000]' : 'bg-[#8B0000] text-white');
            badgeHtml = `<span class="absolute -top-1.5 -right-1.5 text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center ${pillColor} shadow">${count}</span>`;
          }

          if (isUnavail && !holiday && !hasAppts) {
            tooltipTxt = weekend
              ? `<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Clinic closed`
              : `<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Not available`;
          }

          let bgClass = '', textClass = 'text-[#333]', ringClass = '', cursor = 'cursor-default';

          if (isToday) { bgClass = 'bg-[#8B0000]'; textClass = 'text-white font-extrabold'; ringClass = 'ring-2 ring-[#8B0000]/30 ring-offset-1'; }
          else if (holiday) { bgClass = 'bg-blue-50 hover:bg-blue-100'; textClass = 'text-blue-700 font-semibold'; }
          else if (isFull) { bgClass = 'bg-red-50 hover:bg-red-100'; textClass = 'text-red-600 font-semibold'; cursor = 'cursor-pointer'; }
          else if (hasAppts) { bgClass = 'bg-[#FFF5F5] hover:bg-[#FFE8E8]'; textClass = 'text-[#8B0000] font-semibold'; cursor = 'cursor-pointer'; }
          else if (isUnavail) { textClass = 'text-gray-300'; }
          else { bgClass = 'hover:bg-gray-100'; }

          const tooltipHtml = tooltipTxt
            ? `<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 z-50 bg-[#1a1a1a] text-white text-[11px] font-medium px-3 py-1.5 rounded-lg whitespace-nowrap shadow-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200">${tooltipTxt}<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-[#1a1a1a]"></div></div>`
            : '';

          cells += `
            <div class="relative group flex items-center justify-center">
              ${tooltipHtml}
              <div class="relative w-9 h-9 flex items-center justify-center text-sm rounded-full transition-all duration-150 ${bgClass} ${textClass} ${ringClass} ${cursor}">
                ${d}${dotHtml}${badgeHtml}
              </div>
            </div>`;
        }

        document.getElementById('dentistCalendarContainer').innerHTML = `
          <div class="h-full flex flex-col select-none">
            <div class="flex items-center justify-center gap-2 mb-3">
              <i class="fa-regular fa-calendar-check text-[#8B0000] text-xl"></i>
              <h2 class="text-lg font-extrabold text-[#333]">Clinic Appointment Schedule</h2>
            </div>
            <hr class="border-t border-gray-200 mb-2">
            <div class="flex items-center justify-between my-4">
              <button onclick="changeDentistMonth(-1)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-[#FFF0F0] text-[#8B0000] transition-colors">
                <i class="fa-solid fa-chevron-left text-xs"></i>
              </button>
              <div class="text-center">
                <p class="text-lg font-extrabold text-[#8B0000]">${monthNames[month]}</p>
                <p class="text-xs text-[#9CA3AF] font-semibold tracking-widest">${year}</p>
              </div>
              <button onclick="changeDentistMonth(1)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-[#FFF0F0] text-[#8B0000] transition-colors">
                <i class="fa-solid fa-chevron-right text-xs"></i>
              </button>
            </div>
            <div class="grid grid-cols-7 gap-2 mb-2">${headerHtml}</div>
            <div class="grid grid-cols-7 gap-2" style="row-gap:1.2rem;">${cells}</div>
            <div class="mt-5 pt-3 border-t border-gray-200 flex flex-wrap items-center justify-center gap-x-4 gap-y-1.5">
              <div class="flex items-center gap-1.5"><span class="w-4 h-4 rounded-full bg-[#8B0000] flex-shrink-0"></span><span class="text-[11px] text-[#555]">Today</span></div>
              <div class="flex items-center gap-1.5"><span class="w-4 h-4 rounded-full bg-[#FFF5F5] border border-[#8B0000] flex-shrink-0"></span><span class="text-[11px] text-[#555]">Has Patients</span></div>
              <div class="flex items-center gap-1.5"><span class="w-4 h-4 rounded-full bg-red-50 border border-red-400 flex-shrink-0"></span><span class="text-[11px] text-[#555]">Fully Booked</span></div>
              <div class="flex items-center gap-1.5"><span class="w-4 h-4 rounded-full bg-blue-50 border border-blue-400 flex-shrink-0"></span><span class="text-[11px] text-[#555]">Holiday</span></div>
              <div class="flex items-center gap-1.5"><span class="text-gray-300 text-base font-bold leading-none">–</span><span class="text-[11px] text-[#555]">Unavailable</span></div>
            </div>
          </div>`;
      }

      window.changeDentistMonth = function (dir) {
        currentMonth += dir;
        if (currentMonth > 11) { currentMonth = 0; currentYear++; }
        if (currentMonth < 0) { currentMonth = 11; currentYear--; }
        renderDentistCalendar(currentYear, currentMonth);
      };

      renderDentistCalendar(currentYear, currentMonth);
    }
  </script>
</body>

</html>