<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Document Requests</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

  <style>
    *,
    *::before,
    *::after {
      box-sizing: border-box;
    }

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
      background: #f4f4f4;
      overflow-x: hidden;
    }

    .fade-up {
      animation: fadeUp .45s ease both;
    }

    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
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
        gap: 10px;
        background: rgba(255,255,255,0.1);
        padding: 6px 12px;
        border-radius: 999px;
        cursor: pointer;
    }

    .header-user-btn img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
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

    /* ════════════════════════════════
       SIDEBAR
    ════════════════════════════════ */
    #sidebar {
      position: fixed;
      left: 0;
      top: var(--header-h);
      width: 220px;
      height: calc(100vh - var(--header-h));
      background: #fff;
      border-right: 1px solid #eff0f2;
      box-shadow: 4px 0 24px rgba(0, 0, 0, .04);
      z-index: 40;
      display: flex;
      flex-direction: column;
      overflow: hidden;
      transition: width .25s cubic-bezier(.4, 0, .2, 1);
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

    #sidebar.collapsed .sidebar-nav-text,
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

    /* Theme toggle */
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
      color: #8B0000;
    }

    .drawer-nav-link.active .dnav-icon {
      background: rgba(255, 255, 255, .2);
      color: #fff;
    }

    .drawer-footer {
      padding: 10px 12px 16px;
      border-top: 1px solid #f3f4f6;
      flex-shrink: 0;
    }

    /* ════════════════════════════════
       LAYOUT
    ════════════════════════════════ */
    #mainContent,
    #siteFooter {
      margin-left: 220px;
      transition: margin-left .25s cubic-bezier(.4, 0, .2, 1);
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

    /* ════════════════════════════════
       STAT CARDS
    ════════════════════════════════ */
    .stat-card {
      background: #8B0000;
      border-radius: 16px;
      padding: 1.35rem 1.5rem;
      color: #fff;
      cursor: pointer;
      position: relative;
      overflow: hidden;
      transition: transform .18s, box-shadow .18s, background .18s;
      text-decoration: none;
      display: block;
      border: 2px solid transparent;
    }

    .stat-card::before {
      content: '';
      position: absolute;
      right: -16px;
      top: -16px;
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .07);
    }

    .stat-card::after {
      content: '';
      position: absolute;
      right: 12px;
      bottom: -20px;
      width: 55px;
      height: 55px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .05);
    }

    .stat-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(139, 0, 0, .3);
    }

    .stat-card.stat-active {
      background: #6b0000;
      border-color: rgba(255, 255, 255, .2);
      box-shadow: 0 6px 20px rgba(139, 0, 0, .45);
    }

    .stat-num {
      font-size: 2.5rem;
      line-height: 1;
    }

    .stat-label {
      font-size: .75rem;
      font-weight: 700;
      opacity: .8;
      margin-top: .3rem;
      letter-spacing: .04em;
      text-transform: uppercase;
    }

    .stat-icon {
      position: absolute;
      right: 1.1rem;
      top: 50%;
      transform: translateY(-50%);
      font-size: 1.7rem;
      opacity: .15;
    }

    /* ════════════════════════════════
       SEARCH
    ════════════════════════════════ */
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

    .search-wrap i.search-icon {
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
      background: rgba(139, 0, 0, .47);
      color: #fff;
    }

    .search-clear-btn.visible {
      display: flex;
    }

    .row-count {
      font-size: 12px;
      color: #9A9490;
    }

    /* ════════════════════════════════
       TABLE CARD
    ════════════════════════════════ */
    .table-card {
      background: #fff;
      border-radius: 14px;
      border: 1px solid #EDE9E4;
      box-shadow: 0 1px 4px rgba(0, 0, 0, .05);
      overflow: hidden;
    }

    .toolbar-wrap {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 14px 20px;
      border-bottom: 1px solid #EDE9E4;
      background: #FAFAF9;
      flex-wrap: wrap;
      gap: .75rem;
    }

    /* ════════════════════════════════
       REQUEST ROWS
    ════════════════════════════════ */
    .req-row {
      position: relative;
      background: #fff;
      border-bottom: 1px solid #F0ECE8;
      overflow: hidden;
      transition: background .15s;
    }

    .req-row:hover {
      background: #FFF8F8;
    }

    .req-row:last-child {
      border-bottom: none;
    }

    .accent-bar {
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 4px;
    }

    .req-inner {
      padding: 1rem 1.3rem 1rem 1.5rem;
    }

    /* ════════════════════════════════
       STATUS BADGE
    ════════════════════════════════ */
    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: .3rem;
      padding: .22rem .7rem;
      border-radius: 999px;
      font-size: .7rem;
      font-weight: 700;
      letter-spacing: .04em;
      text-transform: uppercase;
    }

    .status-badge::before {
      content: '';
      width: 5px;
      height: 5px;
      border-radius: 50%;
      background: currentColor;
      opacity: .7;
    }

    .badge-approved {
      background: #dcfce7;
      color: #15803d;
    }

    .badge-pending {
      background: #fff7ed;
      color: #c2410c;
    }

    .badge-rejected {
      background: #fee2e2;
      color: #b91c1c;
    }

    /* ════════════════════════════════
       DETAIL PANEL — smooth collapse
    ════════════════════════════════ */
    .detail-panel {
      border-top: 1px solid #f3f3f3;
      background: #fafafa;
      overflow: hidden;
      max-height: 0;
      transition: max-height .35s cubic-bezier(.4, 0, .2, 1), padding .3s ease, opacity .3s ease;
      padding: 0 1.5rem;
      opacity: 0;
    }

    .detail-panel.open {
      max-height: 600px;
      padding: 1.2rem 1.5rem;
      opacity: 1;
    }

    .dl {
      font-size: .67rem;
      font-weight: 700;
      color: #8B0000;
      text-transform: uppercase;
      letter-spacing: .07em;
      margin-bottom: .2rem;
    }

    .dv {
      font-size: .88rem;
      font-weight: 600;
      color: #222;
    }

    /* ════════════════════════════════
       BUTTONS
    ════════════════════════════════ */
    .btn-approve {
      background: #15803d;
      color: #fff;
      border: none;
      cursor: pointer;
      border-radius: 9px;
      padding: .5rem 1.2rem;
      font-weight: 700;
      font-size: .8rem;
      display: flex;
      align-items: center;
      gap: .35rem;
      transition: background .15s, transform .1s;
    }

    .btn-approve:hover {
      background: #166534;
      transform: scale(1.02);
    }

    .btn-reject {
      background: #fff;
      color: #b91c1c;
      border: 2px solid #fca5a5;
      cursor: pointer;
      border-radius: 9px;
      padding: .5rem 1.2rem;
      font-weight: 700;
      font-size: .8rem;
      display: flex;
      align-items: center;
      gap: .35rem;
      transition: all .15s;
    }

    .btn-reject:hover {
      background: #b91c1c;
      color: #fff;
      border-color: #b91c1c;
    }

    .btn-view {
      background: #8B0000;
      color: #fff;
      border: none;
      cursor: pointer;
      border-radius: 9px;
      padding: .45rem 1.1rem;
      font-weight: 700;
      font-size: .78rem;
      display: flex;
      align-items: center;
      gap: .35rem;
      transition: background .15s;
      white-space: nowrap;
    }

    .btn-view:hover {
      background: #6b0000;
    }

    .btn-close-detail {
      background: #f3f3f3;
      color: #666;
      border: none;
      cursor: pointer;
      border-radius: 9px;
      padding: .45rem .9rem;
      font-weight: 600;
      font-size: .78rem;
      transition: background .15s;
    }

    .btn-close-detail:hover {
      background: #e8e8e8;
    }

    /* ════════════════════════════════
       FILTER BUTTON
    ════════════════════════════════ */
    .btn-filter-open {
      display: flex;
      align-items: center;
      gap: .45rem;
      padding: .42rem 1rem;
      background: #fff;
      border: 2px solid #e8e0e0;
      border-radius: 10px;
      font-size: .8rem;
      font-weight: 700;
      color: #555;
      cursor: pointer;
      transition: all .18s;
      position: relative;
    }

    .btn-filter-open:hover {
      border-color: #8B0000;
      color: #8B0000;
      background: #fff8f8;
    }

    .btn-filter-open.has-filters {
      border-color: #8B0000;
      color: #8B0000;
      background: #fff1f1;
    }

    .filter-badge {
      min-width: 18px;
      height: 18px;
      border-radius: 999px;
      background: #8B0000;
      color: #fff;
      font-size: .65rem;
      font-weight: 800;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0 4px;
      margin-left: .1rem;
    }

    /* ════════════════════════════════
       FILTER TAGS
    ════════════════════════════════ */
    .ftag {
      display: inline-flex;
      align-items: center;
      gap: .35rem;
      padding: .38rem .9rem;
      border-radius: 999px;
      border: 2px solid #e8e0e0;
      background: #fafafa;
      color: #666;
      font-size: .78rem;
      font-weight: 600;
      cursor: pointer;
      transition: all .15s;
      white-space: nowrap;
    }

    .ftag:hover {
      border-color: #8B0000;
      color: #8B0000;
      background: #fff8f8;
    }

    .ftag.ftag-active {
      background: #8B0000;
      border-color: #8B0000;
      color: #fff;
    }

    .ftag-dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      flex-shrink: 0;
    }

    .ftag.ftag-active .ftag-dot {
      background: rgba(255, 255, 255, .8) !important;
    }

    /* ════════════════════════════════
       EMPTY STATE
    ════════════════════════════════ */
    .state-box {
      text-align: center;
      padding: 4rem 2rem;
      color: #ccc;
    }

    .state-box i {
      font-size: 2.5rem;
      margin-bottom: .75rem;
      display: block;
    }

    .state-box strong {
      display: block;
      font-size: .95rem;
      font-weight: 700;
      color: #bbb;
      margin-bottom: .3rem;
    }

    .state-box span {
      font-size: .8rem;
    }

    .btn-clear-filter {
      display: inline-flex;
      align-items: center;
      gap: .4rem;
      margin-top: 1.1rem;
      padding: .5rem 1.3rem;
      background: #fff;
      color: #8B0000;
      border: 2px solid #f3c6c6;
      border-radius: 999px;
      font-size: .78rem;
      font-weight: 700;
      cursor: pointer;
      transition: all .2s;
      letter-spacing: .02em;
    }

    .btn-clear-filter:hover {
      background: #8B0000;
      color: #fff;
      border-color: #8B0000;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(139, 0, 0, .2);
    }

    .btn-clear-filter i {
      font-size: .72rem;
      display: inline !important;
      margin: 0 !important;
    }

    /* Tfoot bar */
    .tfoot-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 20px;
      border-top: 1px solid #EDE9E4;
      background: #FAFAF9;
    }

    .pag-btn {
      padding: .38rem .8rem;
      border-radius: 8px;
      font-weight: 600;
      font-size: .8rem;
      border: none;
      cursor: pointer;
      transition: all .15s;
      background: transparent;
      color: #888;
    }

    .pag-btn:disabled {
      color: #ddd;
      cursor: not-allowed;
    }

    .pag-btn.pag-active {
      background: #8B0000;
      color: #fff;
    }

    .pag-btn:not(.pag-active):not(:disabled):hover {
      background: #f3e8e8;
      color: #8B0000;
    }

    /* ════════════════════════════════
       MODALS
    ════════════════════════════════ */
    .modal-overlay {
      position: fixed;
      inset: 0;
      z-index: 999;
      background: rgba(0, 0, 0, .5);
      backdrop-filter: blur(2px);
      display: none;
      align-items: center;
      justify-content: center;
      padding: 1rem;
    }

    .modal-overlay.open {
      display: flex;
    }

    .modal-box-inner {
      width: 100%;
      max-width: 500px;
      background: #fff;
      border-radius: 20px;
      overflow: hidden;
      position: relative;
      box-shadow: 0 24px 64px rgba(0, 0, 0, .2);
      animation: popIn .25s cubic-bezier(.34, 1.56, .64, 1) both;
    }

    @keyframes popIn {
      from {
        opacity: 0;
        transform: scale(.9)
      }

      to {
        opacity: 1;
        transform: scale(1)
      }
    }

    .modal-hd {
      padding: 1.3rem 1.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .modal-bd {
      padding: 1.1rem 1.5rem;
    }

    .modal-ft {
      padding: .75rem 1.5rem 1.3rem;
      display: flex;
      justify-content: flex-end;
      gap: .65rem;
      background: #fafafa;
      border-top: 1px solid #f0f0f0;
    }

    .modal-title {
      font-size: 1.2rem;
    }

    .modal-x {
      background: none;
      border: none;
      cursor: pointer;
      color: #bbb;
      font-size: .95rem;
      padding: .25rem;
      border-radius: 6px;
      transition: color .15s;
    }

    .modal-x:hover {
      color: #333;
    }

    .form-label {
      display: block;
      font-size: .75rem;
      font-weight: 700;
      color: #555;
      margin-bottom: .3rem;
      letter-spacing: .03em;
    }

    .form-input {
      width: 100%;
      border: 2px solid #ebebeb;
      border-radius: 9px;
      padding: .58rem .9rem;
      font-size: .87rem;
      outline: none;
      transition: border-color .2s;
      background: #fff;
    }

    .form-input:focus {
      border-color: #8B0000;
    }

    .btn-close-modal {
      background: #f3f3f3;
      color: #555;
      border: none;
      cursor: pointer;
      border-radius: 9px;
      padding: .55rem 1.2rem;
      font-weight: 600;
      font-size: .82rem;
      transition: background .15s;
    }

    .btn-close-modal:hover {
      background: #e8e8e8;
    }

    /* Approve modal */
    .approve-hero {
      background: linear-gradient(145deg, #052e16 0%, #14532d 40%, #166534 100%);
      padding: 2.2rem 1.75rem 1.8rem;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .approve-hero::before {
      content: '';
      position: absolute;
      top: -40px;
      right: -40px;
      width: 130px;
      height: 130px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .04);
    }

    .approve-hero::after {
      content: '';
      position: absolute;
      bottom: -30px;
      left: -20px;
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .03);
    }

    .approve-icon-ring {
      width: 68px;
      height: 68px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .1);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem;
      position: relative;
      z-index: 1;
      border: 2px solid rgba(255, 255, 255, .15);
    }

    .approve-icon-inner {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .15);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .approve-icon-inner i {
      font-size: 1.3rem;
      color: #86efac;
    }

    .approve-hero-title {
      font-size: 1.4rem;
      font-weight: 800;
      color: #fff;
      margin-bottom: .3rem;
      position: relative;
      z-index: 1;
    }

    .approve-hero-sub {
      font-size: .75rem;
      color: rgba(255, 255, 255, .55);
      position: relative;
      z-index: 1;
    }

    .approve-patient-card {
      display: flex;
      align-items: center;
      gap: 1rem;
      background: #f0fdf4;
      border: 1.5px solid #bbf7d0;
      border-radius: 14px;
      padding: .9rem 1.1rem;
    }

    .approve-patient-avatar {
      width: 42px;
      height: 42px;
      border-radius: 12px;
      background: #dcfce7;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .approve-patient-avatar i {
      color: #15803d;
      font-size: 1rem;
    }

    .approve-info-row {
      display: flex;
      align-items: flex-start;
      gap: .55rem;
      background: #f0fdf4;
      border-radius: 10px;
      padding: .65rem .85rem;
      margin-top: .85rem;
      font-size: .75rem;
      color: #166534;
      line-height: 1.5;
    }

    .approve-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1.25rem 1.75rem 1.5rem;
      margin-top: 1.25rem;
      border-top: 1px solid #f0f0f0;
      background: #fafaf9;
    }

    /* Reject modal */
    .reject-hero {
      background: linear-gradient(145deg, #450a0a 0%, #7f1d1d 40%, #991b1b 100%);
      padding: 2.2rem 1.75rem 1.8rem;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .reject-hero::before {
      content: '';
      position: absolute;
      top: -40px;
      right: -40px;
      width: 130px;
      height: 130px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .04);
    }

    .reject-hero::after {
      content: '';
      position: absolute;
      bottom: -30px;
      left: -20px;
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .03);
    }

    .reject-icon-ring {
      width: 68px;
      height: 68px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .1);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem;
      position: relative;
      z-index: 1;
      border: 2px solid rgba(255, 255, 255, .15);
    }

    .reject-icon-inner {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .15);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .reject-icon-inner i {
      font-size: 1.3rem;
      color: #fca5a5;
    }

    .reject-hero-title {
      font-size: 1.4rem;
      font-weight: 800;
      color: #fff;
      margin-bottom: .3rem;
      position: relative;
      z-index: 1;
    }

    .reject-hero-sub {
      font-size: .75rem;
      color: rgba(255, 255, 255, .5);
      position: relative;
      z-index: 1;
    }

    .reject-patient-card {
      display: flex;
      align-items: center;
      gap: 1rem;
      background: #fff5f5;
      border: 1.5px solid #fecaca;
      border-radius: 14px;
      padding: .9rem 1.1rem;
    }

    .reject-patient-avatar {
      width: 42px;
      height: 42px;
      border-radius: 12px;
      background: #fee2e2;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .reject-patient-avatar i {
      color: #b91c1c;
      font-size: 1rem;
    }

    .reject-field-label {
      display: block;
      font-size: .72rem;
      font-weight: 700;
      color: #6b2020;
      letter-spacing: .04em;
      text-transform: uppercase;
      margin-bottom: .45rem;
    }

    .reject-textarea {
      width: 100%;
      border: 2px solid #fecaca;
      border-radius: 12px;
      padding: .7rem .9rem;
      font-size: .85rem;
      font-family: inherit;
      outline: none;
      resize: none;
      background: #fff5f5;
      color: #450a0a;
      transition: border-color .2s, box-shadow .2s;
      line-height: 1.5;
    }

    .reject-textarea::placeholder {
      color: #d1a3a3;
    }

    .reject-textarea:focus {
      border-color: #b91c1c;
      box-shadow: 0 0 0 3px rgba(185, 28, 28, .1);
      background: #fff;
    }

    .reject-warning-row {
      display: flex;
      align-items: flex-start;
      gap: .55rem;
      background: #fff5f5;
      border-radius: 10px;
      padding: .65rem .85rem;
      margin-top: .85rem;
      font-size: .75rem;
      color: #991b1b;
      line-height: 1.5;
    }

    .reject-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1.25rem 1.75rem 1.5rem;
      margin-top: 1.25rem;
      border-top: 1px solid #fef2f2;
      background: #fffafa;
    }

    /* Shared modal buttons */
    .modal-float-x {
      position: absolute;
      top: 1rem;
      right: 1rem;
      z-index: 10;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .15);
      border: 1px solid rgba(255, 255, 255, .2);
      color: rgba(255, 255, 255, .7);
      font-size: .8rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all .15s;
    }

    .modal-float-x:hover {
      background: rgba(255, 255, 255, .28);
      color: #fff;
    }

    .modal-btn-ghost {
      display: flex;
      align-items: center;
      gap: .4rem;
      background: transparent;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      color: #777;
      font-size: .8rem;
      font-weight: 700;
      padding: .55rem 1.1rem;
      cursor: pointer;
      transition: all .15s;
      font-family: inherit;
    }

    .modal-btn-ghost:hover {
      border-color: #aaa;
      color: #444;
    }

    .modal-btn-ghost--red {
      border-color: #fecaca;
      color: #b91c1c;
    }

    .modal-btn-ghost--red:hover {
      border-color: #b91c1c;
      background: #fff5f5;
    }

    .modal-btn-confirm-approve {
      display: flex;
      align-items: center;
      gap: .6rem;
      background: linear-gradient(135deg, #15803d, #16a34a);
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: .6rem 1.4rem;
      font-size: .85rem;
      font-weight: 800;
      cursor: pointer;
      font-family: inherit;
      transition: all .18s;
      box-shadow: 0 4px 14px rgba(21, 128, 61, .3);
    }

    .modal-btn-confirm-approve:hover {
      background: linear-gradient(135deg, #166534, #15803d);
      transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(21, 128, 61, .4);
    }

    .modal-btn-confirm-approve:disabled {
      opacity: .6;
      cursor: not-allowed;
      transform: none;
    }

    .modal-btn-confirm-reject {
      display: flex;
      align-items: center;
      gap: .6rem;
      background: linear-gradient(135deg, #991b1b, #b91c1c);
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: .6rem 1.4rem;
      font-size: .85rem;
      font-weight: 800;
      cursor: pointer;
      font-family: inherit;
      transition: all .18s;
      box-shadow: 0 4px 14px rgba(185, 28, 28, .3);
    }

    .modal-btn-confirm-reject:hover {
      background: linear-gradient(135deg, #7f1d1d, #991b1b);
      transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(185, 28, 28, .4);
    }

    .modal-btn-confirm-reject:disabled {
      opacity: .6;
      cursor: not-allowed;
      transform: none;
    }

    .btn-confirm-icon {
      width: 24px;
      height: 24px;
      border-radius: 6px;
      background: rgba(255, 255, 255, .2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .75rem;
      flex-shrink: 0;
    }

    /* ════════════════════════════════
       SKELETON
    ════════════════════════════════ */
    @keyframes shimmer {
      0% {
        background-position: -468px 0
      }

      100% {
        background-position: 468px 0
      }
    }

    .skeleton {
      background: linear-gradient(90deg, #f0f0f0 25%, #e8e8e8 50%, #f0f0f0 75%);
      background-size: 936px 100%;
      animation: shimmer 1.2s infinite;
      border-radius: 6px;
    }

    /* ════════════════════════════════
       DARK MODE
    ════════════════════════════════ */
    body,
    #sidebar,
    main,
    .card,
    .modal-box {
      transition: background-color .3s ease, color .3s ease;
    }

    [data-theme="dark"] body {
      background-color: #000D1A;
      color: #E5E7EB;
    }

    [data-theme="dark"] #sidebar {
      background-color: #111827;
    }

    [data-theme="dark"] .bg-white {
      background-color: #111827 !important;
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

    [data-theme="dark"] .table-card {
      background: #111827 !important;
      border-color: #2a3244 !important;
    }

    [data-theme="dark"] .toolbar-wrap {
      background: #1a2234 !important;
      border-color: #2a3244 !important;
    }

    [data-theme="dark"] .req-row {
      background: #111827;
      border-bottom-color: #2a3244 !important;
    }

    [data-theme="dark"] .req-row:hover {
      background: #1e2535 !important;
    }

    [data-theme="dark"] .detail-panel {
      background: #161e2e !important;
      border-top-color: #2a3244 !important;
    }

    [data-theme="dark"] .search-wrap {
      background: #1e2535;
      border-color: #2a3244;
    }

    [data-theme="dark"] .search-wrap input {
      color: #e5e7eb;
      background: transparent;
    }

    [data-theme="dark"] .modal-box-inner {
      background: #1e2535;
    }

    [data-theme="dark"] .form-input {
      background: #161e2e;
      border-color: #2a3244;
      color: #e5e7eb;
    }

    [data-theme="dark"] .btn-close-modal {
      background: #2a3244;
      color: #aaa;
    }

    [data-theme="dark"] .tfoot-bar {
      background: #1a2234 !important;
      border-color: #2a3244 !important;
    }

    [data-theme="dark"] .dv {
      color: #e5e7eb;
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

    [data-theme="dark"] .ftag {
      background: #1e2535;
      border-color: #2a3244;
      color: #aaa;
    }

    [data-theme="dark"] .ftag:hover {
      border-color: #8B0000;
      color: #fca5a5;
    }

    [data-theme="dark"] .btn-filter-open {
      background: #1e2535;
      border-color: #2a3244;
      color: #aaa;
    }

    [data-theme="dark"] .btn-filter-open:hover,
    [data-theme="dark"] .btn-filter-open.has-filters {
      border-color: #8B0000;
      color: #fca5a5;
      background: #1e2535;
    }

    [data-theme="dark"] .approve-patient-card {
      background: #0f2d1a;
      border-color: #166534;
    }

    [data-theme="dark"] .approve-info-row {
      background: #0f2d1a;
      color: #86efac;
    }

    [data-theme="dark"] .approve-footer {
      background: #161e2e;
      border-color: #2a3244;
    }

    [data-theme="dark"] .reject-patient-card {
      background: #2d0f0f;
      border-color: #7f1d1d;
    }

    [data-theme="dark"] .reject-textarea {
      background: #2d0f0f;
      border-color: #7f1d1d;
      color: #fecaca;
    }

    [data-theme="dark"] .reject-textarea:focus {
      background: #1a0808;
    }

    [data-theme="dark"] .reject-warning-row {
      background: #2d0f0f;
      color: #fca5a5;
    }

    [data-theme="dark"] .reject-footer {
      background: #161e2e;
      border-color: #2a3244;
    }

    [data-theme="dark"] .modal-btn-ghost {
      border-color: #2a3244;
      color: #aaa;
    }

    [data-theme="dark"] .modal-btn-ghost:hover {
      border-color: #666;
      color: #ddd;
    }

    [data-theme="dark"] .mobile-req-card {
      background: #111827 !important;
      border-color: #2a3244 !important;
    }

    [data-theme="dark"] .mobile-req-card:hover {
      background: #1e2535 !important;
    }

    [data-theme="dark"] .mobile-detail-panel {
      background: #161e2e !important;
    }

    [data-theme="dark"] .mobile-meta-label {
      color: #6b7280 !important;
    }

    [data-theme="dark"] .mobile-meta-value {
      color: #e5e7eb !important;
    }

    [data-theme="dark"] .mobile-patient-name {
      color: #f3f4f6 !important;
    }

    [data-theme="dark"] .mobile-card-purpose {
      color: #9ca3af !important;
    }

    /* ════════════════════════════════
       MOBILE CARD STYLES
    ════════════════════════════════ */
    .mobile-req-card {
      background: #fff;
      border-bottom: 1px solid #F0ECE8;
      position: relative;
      overflow: hidden;
      transition: background .15s;
    }

    .mobile-req-card:hover {
      background: #FFF8F8;
    }

    .mobile-req-card:last-child {
      border-bottom: none;
    }

    .mobile-card-inner {
      padding: 1rem 1rem 1rem 1.25rem;
    }

    .mobile-card-header {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: .75rem;
      margin-bottom: .75rem;
    }

    .mobile-patient-info {
      display: flex;
      align-items: center;
      gap: .65rem;
      flex: 1;
      min-width: 0;
    }

    .mobile-avatar {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      font-size: .85rem;
    }

    .mobile-patient-name {
      font-weight: 700;
      font-size: .9rem;
      color: #1a1a1a;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .mobile-sub-label {
      font-size: .71rem;
      color: #aaa;
      margin-top: 1px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .mobile-card-meta {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: .55rem .75rem;
      margin-bottom: .85rem;
    }

    .mobile-meta-label {
      font-size: .62rem;
      font-weight: 700;
      color: #bbb;
      text-transform: uppercase;
      letter-spacing: .05em;
      margin-bottom: .12rem;
    }

    .mobile-meta-value {
      font-size: .82rem;
      font-weight: 600;
      color: #333;
      line-height: 1.3;
    }

    .mobile-card-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: .5rem;
      flex-wrap: wrap;
    }

    /* Smooth detail collapse for mobile */
    .mobile-detail-panel {
      overflow: hidden;
      max-height: 0;
      transition: max-height .35s cubic-bezier(.4, 0, .2, 1), padding .3s ease, opacity .3s ease;
      padding: 0 1rem;
      opacity: 0;
      background: #fafafa;
      border-top: 0px solid #f3f3f3;
    }

    .mobile-detail-panel.open {
      max-height: 700px;
      padding: 1rem;
      opacity: 1;
      border-top: 1px solid #f3f3f3;
    }

    .mobile-action-btns {
      display: flex;
      flex-wrap: wrap;
      gap: .5rem;
      margin-top: .85rem;
      padding-top: .85rem;
      border-top: 1px solid #f0f0f0;
    }

    .mobile-action-btns .btn-approve,
    .mobile-action-btns .btn-reject,
    .mobile-action-btns .btn-close-detail {
      flex: 1;
      min-width: 80px;
      justify-content: center;
    }

    /* View button toggle animation */
    .btn-view .btn-view-text {
      transition: opacity .2s ease;
    }

    .btn-view.loading {
      opacity: .7;
      pointer-events: none;
    }

    /* ════════════════════════════════
       RESPONSIVE BREAKPOINTS
    ════════════════════════════════ */

    /* Tablet: 768px – 1023px */
    @media (max-width:1023px) and (min-width:768px) {

      #mainContent,
      #siteFooter {
        margin-left: 220px;
      }

      /* Stack stat cards 2×2 */
      #statCards {
        grid-template-columns: repeat(2, 1fr) !important;
      }

      .stat-num {
        font-size: 2rem;
      }

      /* Simplify row layout to 2-col on tablet */
      .req-inner {
        grid-template-columns: 1fr auto !important;
        row-gap: .5rem;
      }

      .req-date-col,
      .req-doc-col {
        display: none;
      }

      .req-purpose-col {
        display: none;
      }

      .search-wrap {
        width: 220px;
      }
    }

    /* Mobile: <768px */
    @media (max-width:767px) {
      #sidebar {
        display: none !important;
      }

      #mainContent,
      #siteFooter {
        margin-left: 0 !important;
      }

      #siteFooter {
        padding: 1rem;
      }

      .footer-inner {
        gap: .75rem;
        font-size: .7rem;
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

      .header-divider {
        display: none;
      }

      /* Main content top padding on mobile */
      #mainContent {
        padding-top: 80px !important;
        padding-left: .85rem !important;
        padding-right: .85rem !important;
        padding-bottom: 1rem !important;
      }

      /* Stat cards: 2-col grid on mobile */
      #statCards {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: .65rem !important;
        margin-bottom: 1.25rem !important;
      }

      .stat-card {
        padding: 1rem 1.1rem;
        border-radius: 13px;
      }

      .stat-num {
        font-size: 1.8rem;
      }

      .stat-label {
        font-size: .68rem;
      }

      .stat-icon {
        font-size: 1.4rem;
      }

      /* Toolbar: stack on mobile */
      .toolbar-wrap {
        flex-direction: column;
        align-items: stretch !important;
        gap: .6rem !important;
        padding: 12px 14px !important;
      }

      .search-wrap {
        width: 100% !important;
      }

      .toolbar-right-group {
        display: flex;
        align-items: center;
        justify-content: space-between;
      }

      /* Hide desktop table rows, show mobile cards */
      .desktop-req-row {
        display: none !important;
      }

      .mobile-req-card {
        display: block !important;
      }

      /* Tfoot */
      .tfoot-bar {
        flex-direction: column;
        gap: .6rem;
        padding: 10px 14px !important;
        align-items: flex-start;
      }

      #pagControls {
        flex-wrap: wrap;
        gap: .3rem;
      }

      .pag-btn {
        padding: .3rem .6rem;
        font-size: .75rem;
      }

      /* Modals full-screen on mobile */
      .modal-overlay {
        padding: .5rem;
        align-items: flex-end;
      }

      .modal-box-inner {
        border-radius: 20px 20px 14px 14px;
        max-width: 100% !important;
      }

      .approve-hero,
      .reject-hero {
        padding: 1.6rem 1.25rem 1.4rem;
      }

      .approve-footer,
      .reject-footer {
        padding: 1rem 1.25rem 1.2rem;
        flex-wrap: wrap;
        gap: .5rem;
      }

      .modal-btn-confirm-approve,
      .modal-btn-confirm-reject {
        flex: 1;
        justify-content: center;
      }

      .modal-btn-ghost {
        flex: 1;
        justify-content: center;
      }

      /* Filter modal */
      #filterModal .modal-box-inner {
        border-radius: 20px 20px 14px 14px;
      }

      .modal-ft {
        flex-wrap: wrap;
        gap: .5rem;
      }

      .modal-ft>div {
        flex: 1;
      }

      #filterApplyBtn {
        flex: 1;
        justify-content: center;
      }

      /* Page heading */
      #mainContent h1 {
        font-size: 1.4rem !important;
      }

      #mainContent>div>div:first-child {
        margin-bottom: 1.2rem !important;
      }

    }

    /* Very small phones */
    @media (max-width:380px) {
      #statCards {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: .5rem !important;
      }

      .stat-card {
        padding: .85rem .9rem;
      }

      .stat-num {
        font-size: 1.5rem;
      }

      .stat-label {
        font-size: .62rem;
      }

      .mobile-card-meta {
        grid-template-columns: 1fr;
      }
    }

    /* ════════════════════════════════
       HIDE/SHOW HELPERS
    ════════════════════════════════ */
    .mobile-req-card {
      display: none;
    }
  </style>
</head>

@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

<body class="bg-[#F4F4F4] text-[#333333] font-normal min-h-screen flex flex-col">

  <!-- ════════ HEADER ════════ -->
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
              style="display:block;padding:.65rem 1rem;font-size:.76rem;color:#333;text-decoration:none;border-bottom:1px solid #fdf5f5;"
              onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background=''">
              <div style="font-weight:700;">{{ $n['title'] ?? 'Notification' }}</div>
              @if(!empty($n['message']))<div style="color:#aaa;margin-top:2px;font-size:.7rem;">{{ $n['message'] }}
              </div>@endif
            </a>
            @empty
            <div style="padding:2.5rem 1rem;text-align:center;color:#bbb;font-size:.76rem;">
              <i class="fa-regular fa-bell-slash" style="font-size:1.5rem;display:block;margin-bottom:.5rem;"></i>You're
              all caught up.
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
            <button type="submit" class="user-menu-item danger"><i class="fa-solid fa-right-from-bracket"></i>Log
              out</button>
          </form>
        </div>
      </div>
    </div>
  </header>

  <!-- SIDEBAR (desktop) -->
  <aside id="sidebar" style="width:220px;">
    <div class="sidebar-inner">
      <div class="toggle-row flex justify-end mb-3">
        <button onclick="toggleSidebar()" id="sidebarToggleBtn"
          style="width:30px;height:30px;border-radius:8px;border:none;background:#fef2f2;color:#8B0000;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:13px;"
          onmouseover="this.style.background='#fce8e8'" onmouseout="this.style.background='#fef2f2'">
          <i id="sidebarIcon" class="fa-solid fa-xmark"></i>
        </button>
      </div>
      <div class="nav-section-label">Navigation</div>
      <nav style="display:flex;flex-direction:column;gap:2px;">
        @foreach([
        ['route'=>'dentist.dentist.dashboard','icon'=>'fa-chart-line','label'=>'Dashboard'],
        ['route'=>'dentist.dentist.patients','icon'=>'fa-users','label'=>'Patients'],
        ['route'=>'dentist.dentist.appointments','icon'=>'fa-calendar-check','label'=>'Appointments'],
        ['route'=>'dentist.dentist.documentrequests','icon'=>'fa-file-circle-check','label'=>'Document Requests'],
        ['route'=>'dentist.dentist.inventory','icon'=>'fa-box','label'=>'Inventory'],
        ['route'=>'dentist.dentist.report','icon'=>'fa-file','label'=>'Reports'],
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

  <!-- MOBILE DRAWER -->
  <div id="mobileDrawerOverlay" onclick="closeDrawer()"></div>
  <div id="mobileDrawer">
    <div class="drawer-header">
      <div class="drawer-brand">
        <img src="{{ asset('images/PUP.png') }}" style="width:26px;height:26px;object-fit:contain;" alt="PUP">
        <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" style="width:24px;height:24px;object-fit:contain;" alt="DMS">
        <span class="drawer-brand-text">PUP Taguig<br>Dental Clinic</span>
      </div>
      <button class="drawer-close-btn" onclick="closeDrawer()"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <nav class="drawer-nav">
      <div class="drawer-section-label">Navigation</div>
      @foreach([
      ['route'=>'dentist.dentist.dashboard','icon'=>'fa-chart-line','label'=>'Dashboard'],
      ['route'=>'dentist.dentist.patients','icon'=>'fa-users','label'=>'Patients'],
      ['route'=>'dentist.dentist.appointments','icon'=>'fa-calendar-check','label'=>'Appointments'],
      ['route'=>'dentist.dentist.documentrequests','icon'=>'fa-file-circle-check','label'=>'Document Requests'],
      ['route'=>'dentist.dentist.inventory','icon'=>'fa-box','label'=>'Inventory'],
      ['route'=>'dentist.dentist.report','icon'=>'fa-file','label'=>'Reports'],
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
          style="width:100%;display:flex;align-items:center;gap:.6rem;padding:.6rem .75rem;border-radius:10px;border:1px solid #fce8e8;background:#fdf5f5;color:#8B0000;font-size:.8rem;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;">
          <i class="fa-solid fa-right-from-bracket"></i> Log out
        </button>
      </form>
    </div>
  </div>

  {{-- ══════════════ MAIN ══════════════ --}}
  <main id="mainContent" class="pt-[100px] px-3 md:px-6 py-6 fade-in min-h-screen flex-1">
    <div class="max-w-7xl mx-auto">

      {{-- Page heading --}}
      <div style="margin-bottom:1.75rem;">
        <h1 style="font-size:1.9rem;font-weight:800;color:#8B0000;line-height:1.1;margin:0;">Document Requests</h1>
        <p style="color:#999;font-size:.83rem;margin:.3rem 0 0;">Review, approve or reject patient document requests</p>
      </div>

      {{-- Stat cards --}}
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:.9rem;margin-bottom:1.75rem;" id="statCards">
        <button class="stat-card stat-active" data-filter="all" onclick="setFilter('all')">
          <div class="stat-num" id="statAll">0</div>
          <div class="stat-label">All Requests</div>
          <i class="fa-solid fa-layer-group stat-icon"></i>
        </button>
        <button class="stat-card" data-filter="pending" onclick="setFilter('pending')">
          <div class="stat-num" id="statPending">0</div>
          <div class="stat-label">Pending</div>
          <i class="fa-solid fa-hourglass-half stat-icon"></i>
        </button>
        <button class="stat-card" data-filter="approved" onclick="setFilter('approved')">
          <div class="stat-num" id="statApproved">0</div>
          <div class="stat-label">Approved</div>
          <i class="fa-solid fa-circle-check stat-icon"></i>
        </button>
        <button class="stat-card" data-filter="rejected" onclick="setFilter('rejected')">
          <div class="stat-num" id="statRejected">0</div>
          <div class="stat-label">Rejected</div>
          <i class="fa-solid fa-circle-xmark stat-icon"></i>
        </button>
      </div>

      {{-- Table card --}}
      <div class="table-card">

        {{-- Toolbar --}}
        <div class="toolbar-wrap">
          <div class="search-wrap">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input id="searchInput" type="text" placeholder="Search by patient name…" oninput="onSearch(this)" />
            <button type="button" id="searchClearBtn" class="search-clear-btn" onclick="clearSearch()" title="Clear">
              <i class="fa-solid fa-xmark"></i>
            </button>
          </div>
          <div class="toolbar-right-group" style="display:flex;align-items:center;gap:.75rem;">
            <span class="row-count" id="rowCount"></span>
            <button id="filterBtn" onclick="openFilterModal()" class="btn-filter-open">
              <i class="fa-solid fa-sliders"></i>
              <span>Filter</span>
              <span id="filterBadge" class="filter-badge" style="display:none;"></span>
            </button>
          </div>
        </div>

        {{-- Request list --}}
        <div id="requestContainer"></div>

        {{-- Footer / pagination --}}
        <div class="tfoot-bar">
          <span style="font-size:12px;color:#9A9490;" id="pageInfo"></span>
          <div style="display:flex;align-items:center;gap:.4rem;flex-wrap:wrap;" id="pagControls"></div>
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

  {{-- ══════════ FILTER MODAL ══════════ --}}
  <div id="filterModal" class="modal-overlay">
    <div class="modal-box-inner" style="max-width:480px;">
      <div class="modal-hd" style="background:linear-gradient(135deg,#6b0000,#8B0000);border-bottom:none;">
        <div>
          <div class="modal-title" style="color:#fff;font-weight:800;">
            <i class="fa-solid fa-sliders" style="margin-right:.45rem;font-size:1rem;"></i>Filter Requests
          </div>
          <div style="font-size:.74rem;color:rgba(255,255,255,.65);margin-top:.18rem;">Narrow down the list by applying
            filters below</div>
        </div>
        <button class="modal-x" id="filterCloseBtn" style="color:rgba(255,255,255,.6);"
          onmouseenter="this.style.color='#fff'" onmouseleave="this.style.color='rgba(255,255,255,.6)'">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      <div class="modal-bd" style="padding:1.4rem 1.5rem;display:flex;flex-direction:column;gap:1.25rem;">
        <div>
          <label class="form-label" style="margin-bottom:.55rem;">Status</label>
          <div style="display:flex;gap:.5rem;flex-wrap:wrap;" id="fStatusGroup">
            <button class="ftag ftag-active" data-val="all">All</button>
            <button class="ftag" data-val="pending"><span class="ftag-dot" style="background:#c2410c;"></span>
              Pending</button>
            <button class="ftag" data-val="approved"><span class="ftag-dot" style="background:#15803d;"></span>
              Approved</button>
            <button class="ftag" data-val="rejected"><span class="ftag-dot" style="background:#b91c1c;"></span>
              Rejected</button>
          </div>
        </div>
        <div>
          <label class="form-label" style="margin-bottom:.55rem;">Document Type</label>
          <div style="position:relative;">
            <i class="fa-solid fa-file-lines"
              style="position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#8B0000;font-size:12px;pointer-events:none;"></i>
            <select id="fDocType" class="form-input"
              style="padding-left:2rem;appearance:none;cursor:pointer;background-image:url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2212%22 height=%2212%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%238B0000%22 stroke-width=%222.5%22%3E%3Cpath d=%22M6 9l6 6 6-6%22/%3E%3C/svg%3E');background-repeat:no-repeat;background-position:right 12px center;">
              <option value="">All Document Types</option>
              <option>Dental Clearance</option>
              <option>Dental Health Record</option>
              <option>Annual Dental Clearance</option>
              <option>Medical Certificate</option>
              <option>Other</option>
            </select>
          </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
          <div>
            <label class="form-label">Date From</label>
            <div style="position:relative;">
              <i class="fa-regular fa-calendar"
                style="position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#8B0000;font-size:12px;pointer-events:none;"></i>
              <input id="fDateFrom" type="date" class="form-input" style="padding-left:2rem;cursor:pointer;">
            </div>
          </div>
          <div>
            <label class="form-label">Date To</label>
            <div style="position:relative;">
              <i class="fa-regular fa-calendar"
                style="position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#8B0000;font-size:12px;pointer-events:none;"></i>
              <input id="fDateTo" type="date" class="form-input" style="padding-left:2rem;cursor:pointer;">
            </div>
          </div>
        </div>
        <div>
          <label class="form-label" style="margin-bottom:.55rem;">Sort By</label>
          <div style="display:flex;gap:.5rem;flex-wrap:wrap;" id="fSortGroup">
            <button class="ftag ftag-active" data-val="newest"><i class="fa-solid fa-arrow-down-short-wide"
                style="font-size:.7rem;"></i> Newest First</button>
            <button class="ftag" data-val="oldest"><i class="fa-solid fa-arrow-up-short-wide"
                style="font-size:.7rem;"></i> Oldest First</button>
            <button class="ftag" data-val="name_asc"><i class="fa-solid fa-arrow-down-a-z" style="font-size:.7rem;"></i>
              Name A–Z</button>
            <button class="ftag" data-val="name_desc"><i class="fa-solid fa-arrow-up-a-z" style="font-size:.7rem;"></i>
              Name Z–A</button>
          </div>
        </div>
      </div>
      <div class="modal-ft" style="justify-content:space-between;">
        <button id="filterResetBtn" class="btn-close-modal" style="display:flex;align-items:center;gap:.4rem;">
          <i class="fa-solid fa-rotate-left" style="font-size:.75rem;"></i> Reset All
        </button>
        <div style="display:flex;gap:.6rem;">
          <button class="btn-close-modal" id="filterCancelBtn">Cancel</button>
          <button id="filterApplyBtn" class="btn-approve" style="padding:.55rem 1.6rem;">
            <i class="fa-solid fa-check"></i> Apply Filters
          </button>
        </div>
      </div>
    </div>
  </div>

  {{-- ══════════ APPROVE MODAL ══════════ --}}
  <div id="approveModal" class="modal-overlay">
    <div class="modal-box-inner" style="max-width:440px;border-radius:24px;overflow:hidden;">
      <button class="modal-float-x" id="approveCancelBtn"><i class="fa-solid fa-xmark"></i></button>
      <div class="approve-hero">
        <div class="approve-icon-ring">
          <div class="approve-icon-inner"><i class="fa-solid fa-file-circle-check"></i></div>
        </div>
        <div class="approve-hero-title">Approve Request</div>
        <div class="approve-hero-sub">The patient will be notified once approved</div>
      </div>
      <div style="padding:1.5rem 1.75rem 0;">
        <div class="approve-patient-card">
          <div class="approve-patient-avatar"><i class="fa-solid fa-user"></i></div>
          <div>
            <div
              style="font-size:.68rem;font-weight:700;color:#15803d;text-transform:uppercase;letter-spacing:.07em;margin-bottom:.2rem;">
              Patient</div>
            <div id="approvePatientName" style="font-size:1.05rem;font-weight:800;color:#14532d;line-height:1.2;">—
            </div>
          </div>
        </div>
        <div class="approve-info-row">
          <i class="fa-solid fa-circle-info" style="color:#86efac;font-size:.8rem;flex-shrink:0;margin-top:1px;"></i>
          <span>The document will be queued for printing and signing. This action <strong>cannot be
              undone.</strong></span>
        </div>
      </div>
      <div class="approve-footer">
        <button class="modal-btn-ghost" id="approveCancelBtn2"><i class="fa-solid fa-arrow-left"
            style="font-size:.72rem;"></i> Cancel</button>
        <button class="modal-btn-confirm-approve" id="approveConfirmBtn">
          <span class="btn-confirm-icon"><i class="fa-solid fa-check"></i></span>
          Confirm Approval
        </button>
      </div>
    </div>
  </div>
  <input type="hidden" id="approveRequestId">

  {{-- ══════════ REJECT MODAL ══════════ --}}
  <div id="rejectModal" class="modal-overlay">
    <div class="modal-box-inner" style="max-width:440px;border-radius:24px;overflow:hidden;">
      <button class="modal-float-x modal-float-x--red" id="rejectCancelBtn"><i class="fa-solid fa-xmark"></i></button>
      <div class="reject-hero">
        <div class="reject-icon-ring">
          <div class="reject-icon-inner"><i class="fa-solid fa-file-circle-xmark"></i></div>
        </div>
        <div class="reject-hero-title">Reject Request</div>
        <div class="reject-hero-sub">This action is permanent and cannot be undone</div>
      </div>
      <div style="padding:1.5rem 1.75rem 0;">
        <div class="reject-patient-card">
          <div class="reject-patient-avatar"><i class="fa-solid fa-user"></i></div>
          <div>
            <div
              style="font-size:.68rem;font-weight:700;color:#b91c1c;text-transform:uppercase;letter-spacing:.07em;margin-bottom:.2rem;">
              Patient</div>
            <div id="rejectPatientName" style="font-size:1.05rem;font-weight:800;color:#7f1d1d;line-height:1.2;">—</div>
          </div>
        </div>
        <div style="margin-top:1.1rem;">
          <label class="reject-field-label">Reason for rejection <span
              style="font-weight:400;color:#d1a3a3;margin-left:.3rem;">(optional)</span></label>
          <textarea id="rejectNotes" class="reject-textarea" rows="3"
            placeholder="Provide a reason so the patient understands the decision…"></textarea>
        </div>
        <div class="reject-warning-row">
          <i class="fa-solid fa-triangle-exclamation"
            style="color:#fca5a5;font-size:.8rem;flex-shrink:0;margin-top:1px;"></i>
          <span>The patient will be notified of this rejection. Make sure you've reviewed the request carefully.</span>
        </div>
      </div>
      <div class="reject-footer">
        <button class="modal-btn-ghost modal-btn-ghost--red" id="rejectCancelBtn2"><i class="fa-solid fa-arrow-left"
            style="font-size:.72rem;"></i> Cancel</button>
        <button class="modal-btn-confirm-reject" id="rejectConfirmBtn">
          <span class="btn-confirm-icon"><i class="fa-solid fa-ban"></i></span>
          Confirm Rejection
        </button>
      </div>
    </div>
  </div>
  <input type="hidden" id="rejectRequestId">

  {{-- ══════════ APPROVED RESULT ══════════ --}}
  <div id="approvedResultModal" class="modal-overlay">
    <div class="modal-box-inner">
      <div style="background:linear-gradient(135deg,#15803d,#16a34a);padding:2.5rem 2rem;text-align:center;color:#fff;">
        <div
          style="width:58px;height:58px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto .9rem;">
          <i class="fa-solid fa-circle-check" style="font-size:1.7rem;"></i>
        </div>
        <div style="font-size:1.55rem;margin-bottom:.5rem;">Request Approved!</div>
        <p style="font-size:.82rem;opacity:.85;line-height:1.6;">The document has been approved and will be<br>prepared
          for printing. The patient will be notified.</p>
        <button id="approvedResultClose"
          style="margin-top:1.4rem;background:rgba(255,255,255,.2);color:#fff;border:2px solid rgba(255,255,255,.35);border-radius:9px;padding:.5rem 1.5rem;font-weight:700;cursor:pointer;font-size:.83rem;">
          Done
        </button>
      </div>
    </div>
  </div>

  {{-- ══════════ REJECTED RESULT ══════════ --}}
  <div id="rejectedResultModal" class="modal-overlay">
    <div class="modal-box-inner">
      <div style="background:linear-gradient(135deg,#991b1b,#b91c1c);padding:2.5rem 2rem;text-align:center;color:#fff;">
        <div
          style="width:58px;height:58px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto .9rem;">
          <i class="fa-solid fa-circle-xmark" style="font-size:1.7rem;"></i>
        </div>
        <div style="font-size:1.55rem;margin-bottom:.5rem;">Request Rejected</div>
        <p style="font-size:.82rem;opacity:.85;line-height:1.6;">The request has been rejected. The patient<br>will be
          notified of the decision.</p>
        <button id="rejectedResultClose"
          style="margin-top:1.4rem;background:rgba(255,255,255,.2);color:#fff;border:2px solid rgba(255,255,255,.35);border-radius:9px;padding:.5rem 1.5rem;font-weight:700;cursor:pointer;font-size:.83rem;">
          Done
        </button>
      </div>
    </div>
  </div>

  <script>
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;
    const isMobile = () => window.innerWidth < 768;

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

    /* USER DROPDOWN */
    document.getElementById('userBtn').addEventListener('click', e => {
      e.stopPropagation();
      document.getElementById('notifMenu').classList.remove('open');
      document.getElementById('userMenu').classList.toggle('open');
    });
    document.addEventListener('click', () => document.getElementById('userMenu').classList.remove('open'));

    /* THEME */
    function applyTheme(theme) {
      document.documentElement.setAttribute("data-theme", theme);
      localStorage.setItem("theme", theme);
      document.querySelectorAll(".theme-option").forEach(o =>
        o.getAttribute("data-theme") === theme ? o.classList.add("active") : o.classList.remove("active"));
      const ind = document.querySelector(".theme-indicator");
      if (ind) ind.classList.toggle("dark-mode", theme === "dark");
    }

    /* SIDEBAR */
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const icon = document.getElementById('sidebarIcon');
      const isCollapsed = sidebar.classList.contains('collapsed');
      if (isCollapsed) {
        sidebar.classList.remove('collapsed');
        sidebar.style.width = '220px';
        document.getElementById('mainContent').style.marginLeft = '220px';
        document.getElementById('siteFooter').style.marginLeft = '220px';
        icon.className = 'fa-solid fa-xmark';
      } else {
        sidebar.classList.add('collapsed');
        sidebar.style.width = '64px';
        document.getElementById('mainContent').style.marginLeft = '64px';
        document.getElementById('siteFooter').style.marginLeft = '64px';
        icon.className = 'fa-solid fa-bars';
      }
    }

    function applyLayout(w) {
      if (window.innerWidth < 768) return;
      const sidebar = document.getElementById('sidebar');
      const main = document.getElementById('mainContent');
      const footer = document.getElementById('siteFooter');
      if (sidebar) sidebar.style.width = w;
      if (main) main.style.marginLeft = w;
      if (footer) footer.style.marginLeft = w;
    }

    /* ════════════════════════════════════
       DATA + RENDER ENGINE
    ════════════════════════════════════ */
    let allRequests = [];
    let activeFilter = 'all';
    let searchQuery = '';
    const PER_PAGE = 8;
    let currentPage = 1;
    let filterStatus = 'all';
    let filterDocType = '';
    let filterDateFrom = '';
    let filterDateTo = '';
    let filterSort = 'newest';

    async function loadData() {
      showSkeleton();
      try {
        const res = await fetch('/dentist/document-requests/data', { cache: 'no-store' });
        const json = await res.json();
        allRequests = json.requests || [];
        updateStats(json.stats || {});
        renderList();
      } catch (e) {
        document.getElementById('requestContainer').innerHTML = `
          <div class="state-box">
            <i class="fa-solid fa-circle-exclamation" style="color:#fca5a5;"></i>
            <strong>Failed to load</strong>
            <span>Could not fetch requests. Please refresh.</span>
          </div>`;
      }
    }

    function showSkeleton() {
      let html = '';
      for (let i = 0; i < 4; i++) {
        if (isMobile()) {
          html += `<div class="mobile-req-card">
            <div class="mobile-card-inner">
              <div style="display:flex;align-items:center;gap:.65rem;margin-bottom:.75rem;">
                <div class="skeleton" style="width:38px;height:38px;border-radius:10px;flex-shrink:0;"></div>
                <div style="flex:1;">
                  <div class="skeleton" style="height:13px;width:130px;margin-bottom:5px;"></div>
                  <div class="skeleton" style="height:10px;width:80px;"></div>
                </div>
                <div class="skeleton" style="height:28px;width:60px;border-radius:9px;"></div>
              </div>
              <div style="display:grid;grid-template-columns:1fr 1fr;gap:.55rem;">
                <div><div class="skeleton" style="height:9px;width:60px;margin-bottom:4px;"></div><div class="skeleton" style="height:12px;width:80px;"></div></div>
                <div><div class="skeleton" style="height:9px;width:50px;margin-bottom:4px;"></div><div class="skeleton" style="height:12px;width:90px;"></div></div>
              </div>
            </div>
          </div>`;
        } else {
          html += `<div class="req-row desktop-req-row">
            <div class="req-inner" style="display:grid;grid-template-columns:1fr 1fr 1.4fr auto;align-items:center;gap:1rem;">
              <div style="display:flex;align-items:center;gap:.8rem;">
                <div class="skeleton" style="width:40px;height:40px;border-radius:11px;flex-shrink:0;"></div>
                <div><div class="skeleton" style="height:13px;width:110px;margin-bottom:6px;"></div><div class="skeleton" style="height:10px;width:70px;"></div></div>
              </div>
              <div><div class="skeleton" style="height:10px;width:60px;margin-bottom:5px;"></div><div class="skeleton" style="height:13px;width:80px;"></div></div>
              <div><div class="skeleton" style="height:10px;width:55px;margin-bottom:5px;"></div><div class="skeleton" style="height:13px;width:120px;margin-bottom:6px;"></div><div class="skeleton" style="height:18px;width:60px;border-radius:999px;"></div></div>
              <div class="skeleton" style="height:32px;width:70px;border-radius:9px;"></div>
            </div>
          </div>`;
        }
      }
      document.getElementById('requestContainer').innerHTML = html;
      document.getElementById('rowCount').textContent = '';
      document.getElementById('pageInfo').textContent = '';
      document.getElementById('pagControls').innerHTML = '';
    }

    function updateStats(stats) {
      stats = stats || {};
      document.getElementById('statAll').textContent = stats.all ?? 0;
      document.getElementById('statPending').textContent = stats.pending ?? 0;
      document.getElementById('statApproved').textContent = stats.approved ?? 0;
      document.getElementById('statRejected').textContent = stats.rejected ?? 0;
    }

    function getFiltered() {
      let data = allRequests;
      if (activeFilter !== 'all') data = data.filter(r => r.status === activeFilter);
      if (searchQuery) {
        const q = searchQuery.toLowerCase();
        data = data.filter(r => r.patient_name.toLowerCase().includes(q));
      }
      if (filterDocType) data = data.filter(r => r.document_type === filterDocType);
      if (filterDateFrom) { const from = new Date(filterDateFrom); data = data.filter(r => new Date(r.request_date) >= from); }
      if (filterDateTo) { const to = new Date(filterDateTo); to.setHours(23, 59, 59, 999); data = data.filter(r => new Date(r.request_date) <= to); }
      data = [...data].sort((a, b) => {
        if (filterSort === 'oldest') return new Date(a.request_date) - new Date(b.request_date);
        if (filterSort === 'name_asc') return a.patient_name.localeCompare(b.patient_name);
        if (filterSort === 'name_desc') return b.patient_name.localeCompare(a.patient_name);
        return new Date(b.request_date) - new Date(a.request_date);
      });
      return data;
    }

    function hasActiveFilters() {
      return searchQuery !== '' || activeFilter !== 'all' || filterDocType !== '' || filterDateFrom !== '' || filterDateTo !== '' || filterSort !== 'newest';
    }
    function countAdvancedFilters() {
      let n = 0;
      if (filterStatus !== 'all') n++;
      if (filterDocType) n++;
      if (filterDateFrom || filterDateTo) n++;
      if (filterSort !== 'newest') n++;
      return n;
    }
    function updateFilterBtn() {
      const btn = document.getElementById('filterBtn');
      const badge = document.getElementById('filterBadge');
      const count = countAdvancedFilters();
      if (count > 0) { btn.classList.add('has-filters'); badge.textContent = count; badge.style.display = 'inline-flex'; }
      else { btn.classList.remove('has-filters'); badge.style.display = 'none'; }
    }

    function buildClearFilterBtn() {
      const parts = [];
      if (searchQuery) parts.push(`"${esc(searchQuery)}"`);
      if (activeFilter !== 'all') parts.push(activeFilter.charAt(0).toUpperCase() + activeFilter.slice(1));
      if (filterDocType) parts.push(filterDocType);
      if (filterDateFrom || filterDateTo) parts.push('Date range');
      if (filterSort !== 'newest') parts.push('Sort');
      const label = parts.length ? `Clear filter${parts.length > 1 ? 's' : ''} (${parts.join(', ')})` : 'Clear filters';
      return `<div style="margin-top:1.25rem;"><button class="btn-clear-filter" onclick="resetAllFilters()"><i class="fa-solid fa-filter-circle-xmark"></i>${label}</button></div>`;
    }

    function resetAllFilters() {
      document.getElementById('searchInput').value = '';
      document.getElementById('searchClearBtn').classList.remove('visible');
      searchQuery = '';
      activeFilter = 'all'; filterStatus = 'all'; filterDocType = ''; filterDateFrom = ''; filterDateTo = ''; filterSort = 'newest';
      document.querySelectorAll('#statCards .stat-card').forEach(c =>
        c.getAttribute('data-filter') === 'all' ? c.classList.add('stat-active') : c.classList.remove('stat-active'));
      updateFilterBtn();
      currentPage = 1;
      renderList();
    }

    function renderList() {
      const filtered = getFiltered();
      const total = filtered.length;
      const lastPage = Math.max(1, Math.ceil(total / PER_PAGE));
      if (currentPage > lastPage) currentPage = lastPage;
      const start = (currentPage - 1) * PER_PAGE;
      const page = filtered.slice(start, start + PER_PAGE);

      document.getElementById('rowCount').textContent = `${total} ${total === 1 ? 'request' : 'requests'}`;
      document.getElementById('pageInfo').textContent = total === 0 ? '' : `Showing ${start + 1}–${Math.min(start + PER_PAGE, total)} of ${total} requests`;

      renderPagination(total, lastPage);

      const container = document.getElementById('requestContainer');

      if (!page.length) {
        const isSearchMiss = searchQuery !== '' && activeFilter === 'all';
        const isFilterMiss = searchQuery === '' && activeFilter !== 'all';
        const isCombinedMiss = searchQuery !== '' && activeFilter !== 'all';
        const isDataEmpty = allRequests.length === 0;
        let icon, title, subtitle, showClear;
        if (isDataEmpty) { icon = 'fa-regular fa-folder-open'; title = 'No requests yet'; subtitle = 'Incoming document requests will appear here.'; showClear = false; }
        else if (isSearchMiss) { icon = 'fa-solid fa-magnifying-glass'; title = `No results for "${esc(searchQuery)}"`; subtitle = 'Try a different name or spelling.'; showClear = true; }
        else if (isFilterMiss) { icon = 'fa-regular fa-folder-open'; title = `No ${activeFilter} requests`; subtitle = `There are no ${activeFilter} document requests at the moment.`; showClear = true; }
        else if (isCombinedMiss) { icon = 'fa-solid fa-magnifying-glass'; title = 'No matching requests'; subtitle = `No ${activeFilter} requests found for "${esc(searchQuery)}".`; showClear = true; }
        else { icon = 'fa-regular fa-folder-open'; title = 'No requests found'; subtitle = 'Try adjusting your filters.'; showClear = hasActiveFilters(); }
        container.innerHTML = `<div class="state-box"><i class="${icon}"></i><strong>${title}</strong><span>${subtitle}</span>${showClear ? buildClearFilterBtn() : ''}</div>`;
        return;
      }

      // Render both desktop rows and mobile cards; CSS media queries show/hide
      container.innerHTML = page.map(r => buildDesktopRow(r) + buildMobileCard(r)).join('');
    }

    /* ─── DESKTOP ROW ─── */
    function buildDesktopRow(r) {
      const accentHex = r.status === 'approved' ? '#15803d' : r.status === 'rejected' ? '#b91c1c' : '#c2410c';
      const avatarBg = r.status === 'approved' ? '#dcfce7' : r.status === 'rejected' ? '#fee2e2' : '#fff7ed';
      const avatarCol = r.status === 'approved' ? '#15803d' : r.status === 'rejected' ? '#b91c1c' : '#c2410c';
      const badgeCls = r.status === 'approved' ? 'badge-approved' : r.status === 'rejected' ? 'badge-rejected' : 'badge-pending';
      const sub = r.sub_label ? `<div style="font-size:.72rem;color:#aaa;margin-top:.08rem;">${esc(r.sub_label)}</div>` : `<div style="font-size:.72rem;color:#ddd;">—</div>`;

      const nameCol = `<div style="display:flex;align-items:center;gap:.8rem;"><div style="width:40px;height:40px;border-radius:11px;background:${avatarBg};display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fa-solid fa-user" style="color:${avatarCol};font-size:.88rem;"></i></div><div><div style="font-weight:700;font-size:.88rem;color:#1a1a1a;line-height:1.25;">${esc(r.patient_name)}</div>${sub}</div></div>`;
      const dateCol = `<div class="req-date-col"><div style="font-size:.65rem;font-weight:700;color:#bbb;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.18rem;">Date Requested</div><div style="font-size:.85rem;font-weight:600;color:#333;">${esc(r.request_date)}</div><div style="font-size:.72rem;color:#ccc;">${esc(r.request_time)}</div></div>`;
      const docCol = `<div class="req-doc-col"><div style="font-size:.65rem;font-weight:700;color:#bbb;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.18rem;">Document</div><div style="font-size:.85rem;font-weight:600;color:#333;margin-bottom:.35rem;">${esc(r.document_type)}</div><span class="status-badge ${badgeCls}">${r.status.charAt(0).toUpperCase() + r.status.slice(1)}</span></div>`;

      if (r.status === 'pending') {
        const actionCol = `<button class="btn-view" data-id="${r.id}" onclick="toggleDesktopDetail(this,${r.id})"><i class="fa-solid fa-eye"></i> View</button>`;
        const detail = `<div class="detail-panel" id="detail-${r.id}"><div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;margin-bottom:1.1rem;"><div style="font-size:.8rem;color:#888;">Pending request from <strong style="color:#333;">${esc(r.patient_name)}</strong></div><div style="display:flex;align-items:center;gap:.55rem;flex-wrap:wrap;"><button class="btn-approve" onclick="openApprove(${r.id},'${esc(r.patient_name)}')"><i class="fa-solid fa-check"></i> Approve</button><button class="btn-reject" onclick="openReject(${r.id},'${esc(r.patient_name)}')"><i class="fa-solid fa-xmark"></i> Reject</button><button class="btn-close-detail" onclick="closeDesktopDetail(${r.id})">Close</button></div></div><div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:1.1rem;padding-top:.9rem;border-top:1px solid #f0f0f0;"><div><div class="dl">Patient</div><div class="dv">${esc(r.patient_name)}</div></div>${r.sub_label ? `<div><div class="dl">Department</div><div class="dv">${esc(r.sub_label)}</div></div>` : ''}<div><div class="dl">Date</div><div class="dv">${esc(r.request_date)}</div></div><div><div class="dl">Time</div><div class="dv">${esc(r.request_time)}</div></div><div><div class="dl">Document</div><div class="dv">${esc(r.document_type)}</div></div><div><div class="dl">Purpose</div><div class="dv">${esc(r.purpose)}</div></div></div></div>`;
        return `<div class="req-row desktop-req-row" id="row-d-${r.id}"><div class="accent-bar" style="background:${accentHex};"></div><div class="req-inner" style="display:grid;grid-template-columns:1fr 1fr 1.4fr auto;align-items:center;gap:1rem;">${nameCol}${dateCol}${docCol}${actionCol}</div>${detail}</div>`;
      }
      const purposeCol = `<div class="req-purpose-col" style="text-align:right;"><div style="font-size:.65rem;font-weight:700;color:#bbb;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.18rem;">Purpose</div><div style="font-size:.8rem;color:#666;">${esc(r.purpose)}</div></div>`;
      return `<div class="req-row desktop-req-row"><div class="accent-bar" style="background:${accentHex};"></div><div class="req-inner" style="display:grid;grid-template-columns:1fr 1fr 1.4fr auto;align-items:center;gap:1rem;">${nameCol}${dateCol}${docCol}${purposeCol}</div></div>`;
    }

    /* ─── MOBILE CARD ─── */
    function buildMobileCard(r) {
      const accentHex = r.status === 'approved' ? '#15803d' : r.status === 'rejected' ? '#b91c1c' : '#c2410c';
      const avatarBg = r.status === 'approved' ? '#dcfce7' : r.status === 'rejected' ? '#fee2e2' : '#fff7ed';
      const avatarCol = r.status === 'approved' ? '#15803d' : r.status === 'rejected' ? '#b91c1c' : '#c2410c';
      const badgeCls = r.status === 'approved' ? 'badge-approved' : r.status === 'rejected' ? 'badge-rejected' : 'badge-pending';
      const sub = r.sub_label ? `<div class="mobile-sub-label">${esc(r.sub_label)}</div>` : '';

      const viewBtn = r.status === 'pending'
        ? `<button class="btn-view" style="font-size:.74rem;padding:.38rem .85rem;" id="mbtn-${r.id}" onclick="toggleMobileDetail(this,${r.id})"><i class="fa-solid fa-eye" id="micon-${r.id}"></i> <span id="mtext-${r.id}">View</span></button>`
        : `<span class="status-badge ${badgeCls}">${r.status.charAt(0).toUpperCase() + r.status.slice(1)}</span>`;

      const detailContent = r.status === 'pending' ? `
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
          <div><div class="mobile-meta-label">Date</div><div class="mobile-meta-value">${esc(r.request_date)}</div></div>
          <div><div class="mobile-meta-label">Time</div><div class="mobile-meta-value">${esc(r.request_time)}</div></div>
          <div style="grid-column:span 2;"><div class="mobile-meta-label">Document</div><div class="mobile-meta-value">${esc(r.document_type)}</div></div>
          <div style="grid-column:span 2;"><div class="mobile-meta-label">Purpose</div><div class="mobile-meta-value">${esc(r.purpose)}</div></div>
          ${r.sub_label ? `<div style="grid-column:span 2;"><div class="mobile-meta-label">Department</div><div class="mobile-meta-value">${esc(r.sub_label)}</div></div>` : ''}
        </div>
        <div class="mobile-action-btns">
          <button class="btn-approve" onclick="openApprove(${r.id},'${esc(r.patient_name)}')"><i class="fa-solid fa-check"></i> Approve</button>
          <button class="btn-reject"  onclick="openReject(${r.id},'${esc(r.patient_name)}')"><i class="fa-solid fa-xmark"></i> Reject</button>
          <button class="btn-close-detail" onclick="closeMobileDetail(${r.id})">Close</button>
        </div>` : `
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
          <div><div class="mobile-meta-label">Date</div><div class="mobile-meta-value">${esc(r.request_date)}</div></div>
          <div><div class="mobile-meta-label">Time</div><div class="mobile-meta-value">${esc(r.request_time)}</div></div>
          <div style="grid-column:span 2;"><div class="mobile-meta-label">Document</div><div class="mobile-meta-value">${esc(r.document_type)}</div></div>
          <div style="grid-column:span 2;"><div class="mobile-meta-label">Purpose</div><div class="mobile-meta-value">${esc(r.purpose)}</div></div>
        </div>`;

      return `
        <div class="mobile-req-card" id="row-m-${r.id}" style="border-left:4px solid ${accentHex};">
          <div class="mobile-card-inner">
            <div class="mobile-card-header">
              <div class="mobile-patient-info">
                <div class="mobile-avatar" style="background:${avatarBg};">
                  <i class="fa-solid fa-user" style="color:${avatarCol};"></i>
                </div>
                <div style="min-width:0;">
                  <div class="mobile-patient-name">${esc(r.patient_name)}</div>
                  ${sub}
                </div>
              </div>
              ${viewBtn}
            </div>
            <div class="mobile-card-meta">
              <div>
                <div class="mobile-meta-label">Date</div>
                <div class="mobile-meta-value">${esc(r.request_date)}</div>
              </div>
              <div>
                <div class="mobile-meta-label">Document</div>
                <div class="mobile-meta-value" style="font-size:.78rem;">${esc(r.document_type)}</div>
              </div>
            </div>
            <div class="mobile-card-footer">
              <span class="status-badge ${badgeCls}">${r.status.charAt(0).toUpperCase() + r.status.slice(1)}</span>
              <span style="font-size:.72rem;color:#aaa;">${esc(r.request_time)}</span>
            </div>
          </div>
          <div class="mobile-detail-panel" id="mdetail-${r.id}">
            ${detailContent}
          </div>
        </div>`;
    }

    /* ─── Desktop detail toggle ─── */
    function toggleDesktopDetail(btn, id) {
      const panel = document.getElementById(`detail-${id}`);
      const opening = !panel.classList.contains('open');
      panel.classList.toggle('open');
      btn.innerHTML = opening
        ? '<i class="fa-solid fa-eye-slash"></i> Hide'
        : '<i class="fa-solid fa-eye"></i> View';
    }
    function closeDesktopDetail(id) {
      const panel = document.getElementById(`detail-${id}`);
      if (panel) panel.classList.remove('open');
      const row = document.getElementById(`row-d-${id}`);
      if (row) { const vb = row.querySelector('.btn-view'); if (vb) vb.innerHTML = '<i class="fa-solid fa-eye"></i> View'; }
    }

    /* ─── Mobile detail toggle (smooth collapse) ─── */
    function toggleMobileDetail(btn, id) {
      const panel = document.getElementById(`mdetail-${id}`);
      const textEl = document.getElementById(`mtext-${id}`);
      const iconEl = document.getElementById(`micon-${id}`);
      const opening = !panel.classList.contains('open');
      panel.classList.toggle('open');
      if (textEl) textEl.textContent = opening ? 'Hide' : 'View';
      if (iconEl) iconEl.className = opening ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
    }
    function closeMobileDetail(id) {
      const panel = document.getElementById(`mdetail-${id}`);
      const textEl = document.getElementById(`mtext-${id}`);
      const iconEl = document.getElementById(`micon-${id}`);
      if (panel) panel.classList.remove('open');
      if (textEl) textEl.textContent = 'View';
      if (iconEl) iconEl.className = 'fa-solid fa-eye';
    }

    /* ── XSS escape ── */
    function esc(str) {
      return String(str ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    /* ── Pagination ── */
    function renderPagination(total, lastPage) {
      const ctrl = document.getElementById('pagControls');
      if (lastPage <= 1) { ctrl.innerHTML = ''; return; }
      let html = '';
      html += `<button class="pag-btn" ${currentPage > 1 ? '' : 'disabled'} onclick="goPage(${currentPage - 1})">‹ Prev</button>`;
      for (let p = 1; p <= lastPage; p++) html += `<button class="pag-btn ${p === currentPage ? 'pag-active' : ''}" onclick="goPage(${p})">${p}</button>`;
      html += `<button class="pag-btn" ${currentPage < lastPage ? '' : 'disabled'} onclick="goPage(${currentPage + 1})">Next ›</button>`;
      ctrl.innerHTML = html;
    }
    function goPage(p) {
      currentPage = p;
      renderList();
      document.getElementById('requestContainer').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    /* ── Filter / Search ── */
    function setFilter(f) {
      activeFilter = f;
      currentPage = 1;
      document.querySelectorAll('#statCards .stat-card').forEach(c =>
        c.getAttribute('data-filter') === f ? c.classList.add('stat-active') : c.classList.remove('stat-active'));
      renderList();
    }
    function onSearch(input) {
      searchQuery = input.value.trim();
      currentPage = 1;
      document.getElementById('searchClearBtn').classList.toggle('visible', input.value.length > 0);
      renderList();
    }
    function clearSearch() {
      document.getElementById('searchInput').value = '';
      document.getElementById('searchClearBtn').classList.remove('visible');
      searchQuery = '';
      currentPage = 1;
      renderList();
    }

    /* ── Modal helpers ── */
    function openModal(el) { el.classList.add('open'); document.body.style.overflow = 'hidden'; }
    function closeModal(el) { el.classList.remove('open'); document.body.style.overflow = ''; }
    function outside(el) { el.addEventListener('click', e => { if (e.target === el) closeModal(el); }); }

    function openApprove(id, name) {
      document.getElementById('approvePatientName').textContent = name;
      document.getElementById('approveRequestId').value = id;
      openModal(document.getElementById('approveModal'));
    }
    function openReject(id, name) {
      document.getElementById('rejectPatientName').textContent = name;
      document.getElementById('rejectRequestId').value = id;
      document.getElementById('rejectNotes').value = '';
      openModal(document.getElementById('rejectModal'));
      setTimeout(() => document.getElementById('rejectNotes').focus(), 60);
    }

    /* ── Filter modal ── */
    function openFilterModal() {
      syncFilterTagGroup('fStatusGroup', filterStatus);
      syncFilterTagGroup('fSortGroup', filterSort);
      document.getElementById('fDocType').value = filterDocType;
      document.getElementById('fDateFrom').value = filterDateFrom;
      document.getElementById('fDateTo').value = filterDateTo;
      openModal(document.getElementById('filterModal'));
    }
    function syncFilterTagGroup(groupId, activeVal) {
      document.querySelectorAll(`#${groupId} .ftag`).forEach(btn =>
        btn.getAttribute('data-val') === activeVal ? btn.classList.add('ftag-active') : btn.classList.remove('ftag-active'));
    }
    function applyFilterModal() {
      const statusActive = document.querySelector('#fStatusGroup .ftag.ftag-active');
      filterStatus = statusActive ? statusActive.getAttribute('data-val') : 'all';
      activeFilter = filterStatus;
      document.querySelectorAll('#statCards .stat-card').forEach(c =>
        c.getAttribute('data-filter') === activeFilter ? c.classList.add('stat-active') : c.classList.remove('stat-active'));
      const sortActive = document.querySelector('#fSortGroup .ftag.ftag-active');
      filterSort = sortActive ? sortActive.getAttribute('data-val') : 'newest';
      filterDocType = document.getElementById('fDocType').value;
      filterDateFrom = document.getElementById('fDateFrom').value;
      filterDateTo = document.getElementById('fDateTo').value;
      updateFilterBtn();
      currentPage = 1;
      closeModal(document.getElementById('filterModal'));
      renderList();
    }
    function resetFilterModal() {
      filterStatus = 'all'; filterDocType = ''; filterDateFrom = ''; filterDateTo = ''; filterSort = 'newest';
      syncFilterTagGroup('fStatusGroup', 'all');
      syncFilterTagGroup('fSortGroup', 'newest');
      document.getElementById('fDocType').value = '';
      document.getElementById('fDateFrom').value = '';
      document.getElementById('fDateTo').value = '';
    }

    /* ── DOMContentLoaded ── */
    document.addEventListener("DOMContentLoaded", () => {
      if (window.innerWidth >= 768) applyLayout('220px');
      applyTheme(localStorage.getItem("theme") || "light");

      document.querySelectorAll(".theme-option").forEach(o =>
        o.addEventListener("click", () => applyTheme(o.getAttribute("data-theme"))));
      document.querySelectorAll('#userMenuThemeToggle .theme-option').forEach(o =>
        o.addEventListener('click', e => { e.stopPropagation(); applyTheme(o.getAttribute('data-theme')); }));

      document.getElementById("notifBtn").addEventListener("click", e => {
        e.stopPropagation();
        document.getElementById("notifMenu").classList.toggle("open");
      });
      document.addEventListener("click", () => document.getElementById("notifMenu").classList.remove("open"));

      document.addEventListener('keydown', e => {
        if (e.key !== 'Escape') return;
        ['approveModal', 'rejectModal', 'approvedResultModal', 'rejectedResultModal', 'filterModal'].forEach(id => {
          const m = document.getElementById(id);
          if (m?.classList.contains('open')) closeModal(m);
        });
      });

      ['approveModal', 'rejectModal', 'approvedResultModal', 'rejectedResultModal', 'filterModal']
        .forEach(id => outside(document.getElementById(id)));

      const filterModal = document.getElementById('filterModal');
      document.getElementById('filterCloseBtn').addEventListener('click', () => closeModal(filterModal));
      document.getElementById('filterCancelBtn').addEventListener('click', () => closeModal(filterModal));
      document.getElementById('filterApplyBtn').addEventListener('click', applyFilterModal);
      document.getElementById('filterResetBtn').addEventListener('click', resetFilterModal);

      ['fStatusGroup', 'fSortGroup'].forEach(groupId => {
        document.getElementById(groupId).addEventListener('click', e => {
          const btn = e.target.closest('.ftag');
          if (!btn) return;
          document.querySelectorAll(`#${groupId} .ftag`).forEach(b => b.classList.remove('ftag-active'));
          btn.classList.add('ftag-active');
        });
      });

      const approveModal = document.getElementById('approveModal');
      const approvedModal = document.getElementById('approvedResultModal');
      ['approveCancelBtn', 'approveCancelBtn2'].forEach(id =>
        document.getElementById(id)?.addEventListener('click', () => closeModal(approveModal)));
      document.getElementById('approvedResultClose').addEventListener('click', () => { closeModal(approvedModal); loadData(); });
      document.getElementById('approveConfirmBtn').addEventListener('click', async () => {
        const id = document.getElementById('approveRequestId').value;
        const btn = document.getElementById('approveConfirmBtn');
        if (!id) return;
        btn.disabled = true;
        const res = await fetch(`/dentist/document-requests/${id}/approve`, {
          method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF }, body: '{}'
        });
        btn.disabled = false;
        if (res.ok) { closeModal(approveModal); openModal(approvedModal); } else alert('Something went wrong.');
      });

      const rejectModal = document.getElementById('rejectModal');
      const rejectedModal = document.getElementById('rejectedResultModal');
      ['rejectCancelBtn', 'rejectCancelBtn2'].forEach(id =>
        document.getElementById(id)?.addEventListener('click', () => closeModal(rejectModal)));
      document.getElementById('rejectedResultClose').addEventListener('click', () => { closeModal(rejectedModal); loadData(); });
      document.getElementById('rejectConfirmBtn').addEventListener('click', async () => {
        const id = document.getElementById('rejectRequestId').value;
        const btn = document.getElementById('rejectConfirmBtn');
        const notes = document.getElementById('rejectNotes').value.trim();
        if (!id) return;
        btn.disabled = true;
        const res = await fetch(`/dentist/document-requests/${id}/reject`, {
          method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
          body: JSON.stringify({ rejection_notes: notes })
        });
        btn.disabled = false;
        if (res.ok) { closeModal(rejectModal); openModal(rejectedModal); } else alert('Something went wrong.');
      });

      loadData();
    });
  </script>

</body>

</html>