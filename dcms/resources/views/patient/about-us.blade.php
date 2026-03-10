<!DOCTYPE html>
<html lang="en" data-theme="light" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PUP Taguig Dental Clinic | About Us</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <script type="module" src="https://unpkg.com/cally"></script>

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
      --crimson-deep: #660000;
      --crimson-light: #FDF1F1;
      --gold: #FFD700;
      --gold-soft: #FFF8DC;
    }

    body {
      font-family: 'Inter', sans-serif;
      overflow-x: hidden;
    }

    /* ── DESKTOP SIDEBAR LAYOUT ── */
    #mainContent {
      margin-left: 220px;
      transition: margin-left .3s ease;
    }

    #sidebar {
      width: 220px;
      transition: width .3s ease;
    }

    #sidebar.collapsed {
      width: 72px !important;
    }

    /* ── HEADER ── */
    .header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 50;
      background: linear-gradient(135deg, #6b0000 0%, #8B0000 100%);
      padding: 0 2rem;
      height: 62px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 2px 20px rgba(139, 0, 0, .25);
    }

    .header-left {
      display: flex;
      align-items: center;
      gap: .75rem;
    }

    .header-logo {
      width: 36px;
      height: 36px;
      object-fit: contain;
    }

    .header-title {
      font-size: 1rem;
      font-weight: 700;
      color: #fff;
      letter-spacing: .01em;
    }

    .header-right {
      display: flex;
      align-items: center;
      gap: 1.25rem;
    }

    .notif-btn {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .12);
      border: none;
      cursor: pointer;
      color: #fff;
      font-size: .95rem;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background .15s;
      position: relative;
    }

    .notif-btn:hover {
      background: rgba(255, 255, 255, .22);
    }

    .notif-badge {
      position: absolute;
      top: -3px;
      right: -3px;
      background: #ff6b6b;
      color: #fff;
      font-size: .6rem;
      font-weight: 700;
      width: 16px;
      height: 16px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 2px solid #8B0000;
    }

    .header-user {
      display: flex;
      align-items: center;
      gap: .6rem;
    }

    .header-avatar {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      border: 2px solid rgba(255, 255, 255, .4);
      object-fit: cover;
    }

    .header-name {
      font-size: .82rem;
      font-weight: 600;
      color: #fff;
      line-height: 1.2;
    }

    .header-role {
      font-size: .7rem;
      color: rgba(255, 255, 255, .7);
      font-style: italic;
    }

    #notifMenu {
      position: absolute;
      right: 0;
      top: calc(100% + 10px);
      width: 300px;
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, .12);
      border: 1px solid #f0e6e6;
      opacity: 0;
      transform: scale(.95) translateY(-6px);
      pointer-events: none;
      transition: all .2s;
      transform-origin: top right;
      z-index: 100;
    }

    #notifMenu.open {
      opacity: 1;
      transform: scale(1) translateY(0);
      pointer-events: auto;
    }

    #notifDropdown {
      position: relative;
    }

    @media (max-width: 480px) {
      .header-title {
        display: none;
      }

      .header-name,
      .header-role {
        display: none;
      }

      .header {
        padding: 0 1rem;
      }
    }

    /* ── MOBILE PROFILE ACCORDION ── */
    #mobileProfileAccordion {
      display: none;
    }

    /* ── MOBILE BOTTOM NAV ── */
    #mobileBottomNav {
      display: none;
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      height: 72px;
      background: white;
      border-top: 1px solid #f0e0e0;
      z-index: 200;
      align-items: center;
      justify-content: space-around;
      box-shadow: 0 -4px 20px rgba(139, 0, 0, .10);
    }

    .mob-nav-item {
      flex: 1;
      height: 72px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 2px;
      font-size: 10px;
      font-weight: 600;
      color: #9CA3AF;
      text-decoration: none;
      transition: color .2s;
      position: relative;
    }

    .mob-nav-item.active {
      color: #8B0000;
    }

    .mob-nav-item i {
      font-size: 22px;
    }

    #mobFabWrapper {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      position: static;
    }

    #mobFab {
      width: 52px;
      height: 52px;
      border-radius: 50%;
      background: linear-gradient(135deg, #8B0000, #660000);
      color: white;
      border: none;
      font-size: 22px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 16px rgba(139, 0, 0, .45);
      cursor: pointer;
      transition: transform .25s cubic-bezier(.34, 1.56, .64, 1), box-shadow .2s;
      z-index: 10;
      position: relative;
      top: -10px;
    }

    #mobFab.open {
      transform: rotate(45deg) translateY(-10px);
    }

    #mobFabMenu {
      position: fixed;
      bottom: 90px;
      left: 50%;
      transform: translateX(-50%) scaleY(0);
      transform-origin: bottom center;
      background: white;
      border-radius: 16px;
      box-shadow: 0 8px 32px rgba(139, 0, 0, .18);
      border: 1px solid #f5e8e8;
      min-width: 200px;
      overflow: hidden;
      transition: transform .25s cubic-bezier(.34, 1.56, .64, 1), opacity .2s;
      opacity: 0;
      pointer-events: none;
      z-index: 300;
    }

    #mobFabMenu.open {
      transform: translateX(-50%) scaleY(1);
      opacity: 1;
      pointer-events: auto;
    }

    .fab-menu-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 14px 18px;
      font-size: 14px;
      font-weight: 600;
      color: #333;
      text-decoration: none;
      transition: background .15s;
      border-bottom: 1px solid #fdf5f5;
    }

    .fab-menu-item:last-child {
      border-bottom: none;
    }

    .fab-menu-item:hover {
      background: #FFF0F0;
      color: #8B0000;
    }

    .fab-menu-item i {
      width: 32px;
      height: 32px;
      background: #FFF0F0;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      color: #8B0000;
      flex-shrink: 0;
    }

    /* ── DESKTOP SIDEBAR ── */
    .sidebar-link {
      display: flex;
      align-items: center;
      transition: background-color .2s ease, transform .2s ease;
    }

    #sidebar.expanded .sidebar-link {
      justify-content: flex-start;
      padding-left: .25rem;
    }

    #sidebar.expanded .sidebar-link i {
      margin-right: .75rem;
    }

    #sidebar.expanded .sidebar-link:hover {
      transform: translateX(4px);
    }

    #sidebar.expanded .sidebar-tooltip {
      display: none;
    }

    #sidebar.expanded .section-label {
      display: block;
    }

    #sidebar.expanded .sidebar-text {
      opacity: 1;
      width: auto;
      overflow: visible;
    }

    #sidebar.collapsed .sidebar-text {
      opacity: 0;
      width: 0;
      overflow: hidden;
    }

    #sidebar.collapsed .sidebar-tooltip {
      display: block;
    }

    #sidebar.collapsed .section-label {
      display: none;
    }

    #sidebar.collapsed .sidebar-link {
      justify-content: center;
      padding-left: 0;
      padding-right: 0;
    }

    #sidebar.collapsed .sidebar-link i {
      margin-right: 0 !important;
      width: 100%;
      text-align: center;
    }

    .sidebar-link:hover .sidebar-tooltip {
      opacity: 1 !important;
      transform: scale(1) !important;
    }

    .section-label {
      font-size: .65rem;
      font-weight: 500;
      letter-spacing: .08em;
      color: #757575;
      text-transform: uppercase;
      margin-bottom: .25rem;
    }

    body,
    #sidebar,
    main,
    .card,
    .modal-box {
      transition: background-color .3s ease, color .3s ease;
    }

    .sidebar-link.bg-\[\#8B0000\] {
      box-shadow: 0 0 12px rgba(139, 0, 0, .45);
    }

    /* ── THEME TOGGLE ── */
    .theme-toggle-container {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      height: 34px;
      background: #F5F5F5;
      border: 1px solid #E0E0E0;
      border-radius: 24px;
      transition: all .3s ease;
    }

    #sidebar.collapsed .theme-toggle-container {
      flex-direction: column;
      width: 35px;
      height: 96px;
      border-radius: 24px;
      padding: 4px;
    }

    #sidebar.collapsed .w-full {
      display: flex;
      justify-content: center;
    }

    .theme-option {
      position: relative;
      z-index: 2;
      flex: 1;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: transparent;
      border: none;
      cursor: pointer;
      color: #9CA3AF;
      transition: color .2s ease;
      border-radius: 8px;
    }

    #sidebar.collapsed .theme-option {
      width: 35px;
      height: 40px;
      flex: none;
    }

    .theme-option i {
      font-size: 16px;
    }

    #sidebar.collapsed .theme-option i {
      font-size: 15px;
    }

    .theme-option.active {
      color: #374151;
    }

    .theme-indicator {
      position: absolute;
      background: white;
      border-radius: 24px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
      transition: all .3s cubic-bezier(.4, 0, .2, 1);
      pointer-events: none;
    }

    #sidebar.expanded .theme-indicator {
      width: calc(50% - 2px);
      height: calc(100% - 8px);
      left: 4px;
      top: 4px;
      border-radius: 20px;
    }

    #sidebar.expanded .theme-indicator.dark-mode {
      transform: translateX(calc(100% + 0px));
    }

    #sidebar.collapsed .theme-indicator {
      width: calc(100% - 8px);
      height: calc(50% - 6px);
      left: 4px;
      top: 4px;
      border-radius: 16px;
    }

    #sidebar.collapsed .theme-indicator.dark-mode {
      transform: translateY(calc(100% + 4px));
    }

    /* ── DARK THEME ── */
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

    [data-theme="dark"] #mobileBottomNav {
      background: #0a0a0a;
      border-top-color: #1a1a1a;
    }

    [data-theme="dark"] #mobFabMenu {
      background: #111;
      border-color: #222;
    }

    [data-theme="dark"] .fab-menu-item {
      color: #E5E7EB;
      border-bottom-color: #1a1a1a;
    }

    [data-theme="dark"] .fab-menu-item:hover {
      background: #1a1a1a;
    }

    [data-theme="dark"] .mob-nav-item {
      color: #4B5563;
    }

    [data-theme="dark"] .mob-nav-item.active {
      color: #ff6b6b;
    }

    [data-theme="dark"] #mobileProfileAccordion {
      background: #0a0a0a;
      border-bottom-color: #1a1a1a;
    }

    /* ── MOBILE RESPONSIVE ── */
    @media (max-width: 767px) {
      #sidebar {
        display: none !important;
      }

      #mainContent {
        margin-left: 0 !important;
        padding-bottom: 90px;
      }

      #mobileBottomNav {
        display: flex;
      }

      footer {
        margin-bottom: 72px;
      }

      #desktopHeaderUser {
        display: none !important;
      }

      #mobileProfileAccordion {
        display: block;
        position: fixed;
        top: 62px;
        left: 0;
        right: 0;
        z-index: 45;
        background: white;
        border-bottom: 1px solid #f0e0e0;
        box-shadow: 0 4px 20px rgba(139, 0, 0, .08);
        max-height: 0;
        overflow: hidden;
        transition: max-height .35s cubic-bezier(.4, 0, .2, 1), opacity .25s ease;
        opacity: 0;
      }

      #mobileProfileAccordion.open {
        max-height: 200px;
        opacity: 1;
      }

      #mobileProfileToggle {
        display: flex !important;
      }
    }

    @media (min-width: 768px) {
      #mobileProfileToggle {
        display: none !important;
      }

      #darkModeFab {
        display: none !important;
      }

      #mobileBottomNav {
        display: none !important;
      }
    }

    /* ══════════════════════════════════════
       ABOUT US — REDESIGNED CONTENT STYLES
    ══════════════════════════════════════ */

    /* Hero banner */
    .about-hero {
      position: relative;
      overflow: hidden;
      background: linear-gradient(135deg, #6b0000 0%, #8B0000 55%, #a31515 100%);
      border-radius: 24px;
      padding: 64px 48px;
      margin-bottom: 56px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 32px;
      min-height: 240px;
    }

    .about-hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .about-hero-ring {
      position: absolute;
      border-radius: 50%;
      border: 1px solid rgba(255, 255, 255, 0.1);
      pointer-events: none;
    }

    .about-hero-text {
      position: relative;
      z-index: 2;
    }

    .about-hero-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(255, 255, 255, 0.15);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 100px;
      padding: 5px 14px;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: rgba(255, 255, 255, 0.85);
      margin-bottom: 16px;
    }

    .about-hero h1 {
      font-size: clamp(2.2rem, 5vw, 3.5rem);
      font-weight: 900;
      color: white;
      line-height: 1.05;
      letter-spacing: -0.02em;
      margin-bottom: 16px;
    }

    .about-hero p {
      font-size: 15px;
      color: rgba(255, 255, 255, 0.75);
      max-width: 500px;
      line-height: 1.7;
    }

    .about-hero-badge {
      position: relative;
      z-index: 2;
      flex-shrink: 0;
      width: 120px;
      height: 120px;
      background: rgba(255, 255, 255, 0.1);
      border: 2px solid rgba(255, 255, 255, 0.15);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .about-hero-badge i {
      font-size: 44px;
      color: rgba(255, 255, 255, 0.6);
    }

    @media (max-width: 640px) {
      .about-hero {
        padding: 36px 24px;
        flex-direction: column;
        align-items: flex-start;
        min-height: unset;
      }

      .about-hero-badge {
        display: none;
      }

      .about-hero h1 {
        font-size: 2rem;
      }
    }

    /* Mission strip */
    .mission-strip {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
      margin-bottom: 56px;
    }

    @media (max-width: 767px) {
      .mission-strip {
        grid-template-columns: 1fr;
      }
    }

    .mission-card {
      background: white;
      border: 1px solid #EDE0E0;
      border-radius: 20px;
      padding: 28px 24px;
      position: relative;
      overflow: hidden;
      transition: transform .25s ease, box-shadow .25s ease;
    }

    .mission-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 16px 40px rgba(139, 0, 0, 0.10);
    }

    .mission-card::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, #8B0000, #FFD700);
      transform: scaleX(0);
      transform-origin: left;
      transition: transform .35s ease;
    }

    .mission-card:hover::after {
      transform: scaleX(1);
    }

    .mission-icon {
      width: 48px;
      height: 48px;
      border-radius: 14px;
      background: #FDF1F1;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 16px;
    }

    .mission-icon i {
      font-size: 20px;
      color: #8B0000;
    }

    .mission-card h3 {
      font-size: 15px;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 8px;
    }

    .mission-card p {
      font-size: 13px;
      color: #6B7280;
      line-height: 1.65;
    }

    [data-theme="dark"] .mission-card {
      background: #0d1b2a;
      border-color: #1e2d3d;
    }

    [data-theme="dark"] .mission-card h3 {
      color: #E5E7EB;
    }

    [data-theme="dark"] .mission-icon {
      background: #1a0a0a;
    }

    /* Dentist section */
    .dentist-section {
      display: grid;
      grid-template-columns: 1fr 380px;
      gap: 48px;
      align-items: center;
      margin-bottom: 64px;
    }

    @media (max-width: 900px) {
      .dentist-section {
        grid-template-columns: 1fr;
      }
    }

    .dentist-profile-card {
      background: white;
      border: 1px solid #EDE0E0;
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 8px 40px rgba(139, 0, 0, 0.08);
    }

    .dentist-card-header {
      background: linear-gradient(135deg, #8B0000, #660000);
      padding: 32px 28px 24px;
      position: relative;
      overflow: hidden;
    }

    .dentist-card-header::before {
      content: '';
      position: absolute;
      top: -40px;
      right: -40px;
      width: 160px;
      height: 160px;
      background: rgba(255, 255, 255, 0.06);
      border-radius: 50%;
    }

    .dentist-card-header::after {
      content: '';
      position: absolute;
      bottom: -20px;
      left: -20px;
      width: 100px;
      height: 100px;
      background: rgba(255, 215, 0, 0.08);
      border-radius: 50%;
    }

    .dentist-img-wrap {
      width: 88px;
      height: 88px;
      border-radius: 50%;
      border: 3px solid rgba(255, 255, 255, 0.3);
      overflow: hidden;
      margin-bottom: 14px;
      position: relative;
      z-index: 1;
    }

    .dentist-img-wrap img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .dentist-name {
      font-size: 20px;
      font-weight: 800;
      color: white;
      position: relative;
      z-index: 1;
    }

    .dentist-title {
      font-size: 12px;
      color: rgba(255, 255, 255, 0.7);
      margin-top: 3px;
      position: relative;
      z-index: 1;
    }

    .dentist-card-body {
      padding: 24px 28px;
    }

    .dentist-tag {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: #FDF1F1;
      border: 1px solid #F0DADA;
      border-radius: 100px;
      padding: 5px 12px;
      font-size: 11.5px;
      font-weight: 600;
      color: #8B0000;
      margin: 4px 4px 4px 0;
    }

    .dentist-text-side {}

    .dentist-text-side h2 {
      font-size: clamp(1.6rem, 3vw, 2.4rem);
      font-weight: 800;
      color: #8B0000;
      line-height: 1.1;
      margin-bottom: 16px;
    }

    .dentist-text-side p {
      font-size: 14.5px;
      color: #5A5A6A;
      line-height: 1.8;
      margin-bottom: 14px;
    }

    [data-theme="dark"] .dentist-profile-card {
      background: #0d1b2a;
      border-color: #1e2d3d;
    }

    [data-theme="dark"] .dentist-text-side p {
      color: #9CA3AF;
    }

    [data-theme="dark"] .dentist-tag {
      background: #1a0a0a;
      border-color: #2a1515;
    }

    [data-theme="dark"] .dentist-card-body {
      background: #0d1b2a;
    }

    /* Services grid */
    .services-section {
      margin-bottom: 64px;
    }

    .services-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 16px;
    }

    @media (max-width: 600px) {
      .services-grid {
        grid-template-columns: 1fr;
      }
    }

    .service-item {
      background: white;
      border: 1px solid #EDE0E0;
      border-radius: 18px;
      padding: 24px 20px;
      display: flex;
      align-items: flex-start;
      gap: 16px;
      transition: transform .22s, box-shadow .22s;
      cursor: default;
    }

    .service-item:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 32px rgba(139, 0, 0, 0.09);
    }

    .service-item-icon {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      flex-shrink: 0;
      background: linear-gradient(135deg, #8B0000, #660000);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .service-item-icon i {
      font-size: 18px;
      color: white;
    }

    .service-item h4 {
      font-size: 14px;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 5px;
    }

    .service-item p {
      font-size: 12.5px;
      color: #8A8A9A;
      line-height: 1.6;
    }

    [data-theme="dark"] .service-item {
      background: #0d1b2a;
      border-color: #1e2d3d;
    }

    [data-theme="dark"] .service-item h4 {
      color: #E5E7EB;
    }

    /* FAQ section */
    .faq-section {
      margin-bottom: 64px;
    }

    .faq-header-row {
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      margin-bottom: 32px;
      gap: 16px;
      flex-wrap: wrap;
    }

    .faq-section-title {
      font-size: clamp(1.5rem, 3vw, 2.2rem);
      font-weight: 800;
      color: #8B0000;
    }

    .faq-section-sub {
      font-size: 13px;
      color: #8A8A9A;
      margin-top: 4px;
      max-width: 380px;
    }

    .faq-item-new {
      border: 1px solid #EDE0E0;
      border-radius: 16px;
      margin-bottom: 10px;
      overflow: hidden;
      transition: border-color .2s, box-shadow .2s;
      background: white;
    }

    .faq-item-new.open {
      border-color: #D4AAAA;
      box-shadow: 0 4px 20px rgba(139, 0, 0, 0.06);
    }

    .faq-trigger {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 18px 20px;
      background: transparent;
      border: none;
      cursor: pointer;
      text-align: left;
      gap: 16px;
    }

    .faq-trigger-left {
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .faq-num {
      width: 28px;
      height: 28px;
      border-radius: 8px;
      flex-shrink: 0;
      background: #FDF1F1;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
      font-weight: 800;
      color: #8B0000;
      transition: background .2s, color .2s;
    }

    .faq-item-new.open .faq-num {
      background: #8B0000;
      color: white;
    }

    .faq-q {
      font-size: 14px;
      font-weight: 600;
      color: #2D2D3A;
      line-height: 1.5;
      text-align: left;
    }

    [data-theme="dark"] .faq-q {
      color: #E5E7EB;
    }

    .faq-chevron {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      border: 1px solid #EDE0E0;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #8A8A9A;
      flex-shrink: 0;
      transition: transform .3s cubic-bezier(.4, 0, .2, 1), background .2s, border-color .2s;
    }

    .faq-item-new.open .faq-chevron {
      transform: rotate(180deg);
      background: #FDF1F1;
      border-color: #F0DADA;
      color: #8B0000;
    }

    .faq-body {
      max-height: 0;
      overflow: hidden;
      opacity: 0;
      transition: max-height .35s ease, opacity .3s ease;
    }

    .faq-item-new.open .faq-body {
      opacity: 1;
    }

    .faq-body-inner {
      padding: 0 20px 18px 62px;
      font-size: 13.5px;
      color: #6B7280;
      line-height: 1.75;
    }

    [data-theme="dark"] .faq-item-new {
      background: #0d1b2a;
      border-color: #1e2d3d;
    }

    [data-theme="dark"] .faq-item-new.open {
      border-color: #4a2020;
    }

    [data-theme="dark"] .faq-body-inner {
      color: #9CA3AF;
    }

    [data-theme="dark"] .faq-num {
      background: #1a0a0a;
    }

    /* Team section */
    .team-section {
      margin-bottom: 48px;
    }

    .team-title {
      font-size: clamp(1.5rem, 3vw, 2rem);
      font-weight: 800;
      color: #8B0000;
      margin-bottom: 8px;
    }

    .team-sub {
      font-size: 13px;
      color: #8A8A9A;
      margin-bottom: 32px;
    }

    .team-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
    }

    @media (max-width: 768px) {
      .team-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 400px) {
      .team-grid {
        grid-template-columns: 1fr 1fr;
        gap: 12px;
      }
    }

    .team-card {
      background: white;
      border: 1px solid #EDE0E0;
      border-radius: 20px;
      overflow: hidden;
      transition: transform .25s, box-shadow .25s;
      text-align: center;
    }

    .team-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 50px rgba(139, 0, 0, 0.12);
    }

    .team-img-wrap {
      width: 100%;
      aspect-ratio: 1;
      overflow: hidden;
      position: relative;
      background: #FDF1F1;
    }

    .team-img-wrap img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform .35s ease;
    }

    .team-card:hover .team-img-wrap img {
      transform: scale(1.06);
    }

    .team-info {
      padding: 16px 12px 18px;
    }

    .team-name {
      font-size: 13px;
      font-weight: 700;
      color: #2D2D3A;
      margin-bottom: 4px;
    }

    .team-role {
      display: inline-block;
      font-size: 10.5px;
      font-weight: 600;
      color: #8B0000;
      background: #FDF1F1;
      border: 1px solid #F0DADA;
      padding: 2px 10px;
      border-radius: 100px;
    }

    [data-theme="dark"] .team-card {
      background: #0d1b2a;
      border-color: #1e2d3d;
    }

    [data-theme="dark"] .team-name {
      color: #E5E7EB;
    }

    [data-theme="dark"] .team-img-wrap {
      background: #1a0a0a;
    }

    /* Closing statement */
    .closing-banner {
      background: linear-gradient(135deg, #8B0000 0%, #660000 100%);
      border-radius: 20px;
      padding: 40px 40px;
      display: flex;
      align-items: center;
      gap: 24px;
      margin-bottom: 16px;
      position: relative;
      overflow: hidden;
    }

    .closing-banner::before {
      content: '';
      position: absolute;
      top: -60px;
      right: -60px;
      width: 220px;
      height: 220px;
      background: rgba(255, 215, 0, 0.1);
      border-radius: 50%;
    }

    .closing-banner-icon {
      width: 56px;
      height: 56px;
      border-radius: 16px;
      flex-shrink: 0;
      background: rgba(255, 255, 255, 0.15);
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      z-index: 1;
    }

    .closing-banner-icon i {
      font-size: 24px;
      color: rgba(255, 255, 255, 0.85);
    }

    .closing-banner p {
      font-size: 15px;
      color: rgba(255, 255, 255, 0.85);
      line-height: 1.75;
      position: relative;
      z-index: 1;
    }

    .closing-banner strong {
      color: white;
    }

    @media (max-width: 600px) {
      .closing-banner {
        padding: 28px 20px;
        flex-direction: column;
        align-items: flex-start;
      }
    }

    /* Section label pill */
    .section-pill {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      background: #FDF1F1;
      border: 1px solid #F0DADA;
      border-radius: 100px;
      padding: 5px 14px;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: #8B0000;
      margin-bottom: 12px;
    }

    /* Scroll fade */
    .reveal {
      opacity: 0;
      transform: translateY(28px);
      transition: opacity .7s ease, transform .7s ease;
    }

    .reveal.visible {
      opacity: 1;
      transform: translateY(0);
    }

    .reveal-delay-1 {
      transition-delay: 0.1s;
    }

    .reveal-delay-2 {
      transition-delay: 0.2s;
    }

    .reveal-delay-3 {
      transition-delay: 0.3s;
    }

    .reveal-delay-4 {
      transition-delay: 0.4s;
    }
  </style>
</head>

@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

<body class="text-[#333333] bg-[#FAF8F8] overflow-x-hidden">

  <!-- ══════════════ HEADER ══════════════ -->
  <header class="header">
    <div class="header-left">
      <img src="{{ asset('images/PUP.png') }}" class="header-logo" alt="PUP">
      <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="header-logo" alt="DMS">
      <span class="header-title">PUP TAGUIG DENTAL CLINIC</span>
    </div>
    <div class="header-right">
      <div id="notifDropdown">
        <button class="notif-btn" id="notifBtn">
          <i class="fa-regular fa-bell"></i>
          @if($notifCount > 0)<span class="notif-badge">{{ $notifCount }}</span>@endif
        </button>
        <div id="notifMenu">
          <div style="padding:.85rem 1rem .65rem;font-weight:700;color:#8B0000;font-size:.82rem;border-bottom:1px solid #f5e8e8;">Notifications</div>
          <div style="max-height:260px;overflow-y:auto;">
            @forelse($notifications as $n)
            <a href="{{ $n['url'] ?? '#' }}" style="display:block;padding:.65rem 1rem;font-size:.78rem;color:#333;text-decoration:none;border-bottom:1px solid #fdf5f5;">
              <div style="font-weight:600;">{{ $n['title'] ?? 'Notification' }}</div>
              @if(!empty($n['message']))<div style="color:#aaa;margin-top:2px;">{{ $n['message'] }}</div>@endif
            </a>
            @empty
            <div style="padding:2rem 1rem;text-align:center;color:#bbb;font-size:.78rem;">You're all caught up.</div>
            @endforelse
          </div>
        </div>
      </div>

      <!-- Mobile profile toggle -->
      <button id="mobileProfileToggle" onclick="toggleMobileProfile()"
        style="display:none;align-items:center;gap:.6rem;background:none;border:none;cursor:pointer;padding:0;">
        <img class="header-avatar"
          src="{{ $patient->profile_image ? asset('storage/'.$patient->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($patient->name).'&background=660000&color=FFFFFF&rounded=true&size=36' }}"
          alt="Profile">
        <i id="mobileProfileChevron" class="fa-solid fa-chevron-down text-white text-xs transition-transform duration-300"></i>
      </button>

      <!-- Desktop header user -->
      <div class="header-user" id="desktopHeaderUser">
        <img class="header-avatar"
          src="{{ $patient->profile_image ? asset('storage/'.$patient->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($patient->name).'&background=660000&color=FFFFFF&rounded=true&size=36' }}"
          alt="Profile">
        <div>
          <div class="header-name">{{ ucwords(strtolower($patient->name)) }}</div>
          <div class="header-role">Student</div>
        </div>
      </div>
    </div>
  </header>

  <!-- ══════════════ MOBILE PROFILE ACCORDION ══════════════ -->
  <div id="mobileProfileAccordion">
    <div class="flex items-center gap-4 px-5 py-4 border-b border-gray-100">
      <img class="w-12 h-12 rounded-full border-2 border-[#8B0000]/20 object-cover flex-shrink-0"
        src="{{ $patient->profile_image ? asset('storage/'.$patient->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($patient->name).'&background=660000&color=FFFFFF&rounded=true&size=96' }}"
        alt="Profile">
      <div>
        <p class="font-bold text-[#333333] text-base leading-tight">{{ ucwords(strtolower($patient->name)) }}</p>
        <p class="text-xs text-[#757575] italic">Student</p>
      </div>
    </div>
    <div class="px-5 py-3">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit"
          class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-red-600 bg-red-50 hover:bg-red-100 font-semibold text-sm transition-colors duration-200">
          <i class="fa-solid fa-right-from-bracket"></i> Log out
        </button>
      </form>
    </div>
  </div>

  <!-- ══════════════ DESKTOP SIDEBAR ══════════════ -->
  <aside id="sidebar"
    class="fixed left-0 top-[62px] h-[calc(100vh-62px)] bg-white drop-shadow-xl transition-all duration-300 flex flex-col justify-between z-40 expanded"
    style="width:220px;">
    <div class="pt-4">
      <div id="sidebarToggleWrapper" class="flex items-center justify-end px-4 py-2">
        <button onclick="toggleSidebar()" id="sidebarToggleBtn"
          class="w-8 h-8 flex items-center justify-center rounded-full text-[#757575] hover:text-[#8B0000] hover:bg-[#F0F0F0] transition-all duration-300">
          <i id="sidebarIcon" class="fa-solid fa-xmark text-base"></i>
        </button>
      </div>
      <div class="section-label px-4 mb-6">Navigation</div>
      <nav class="space-y-2 px-3 text-gray-600">
        @foreach([
        ['route'=>'homepage', 'icon'=>'fa-house', 'label'=>'Home'],
        ['route'=>'patient.appointment.index', 'icon'=>'fa-calendar', 'label'=>'Appointment'],
        ['route'=>'patient.record', 'icon'=>'fa-folder-open', 'label'=>'Record'],
        ['route'=>'patient.about.us', 'icon'=>'fa-file-circle-check','label'=>'About Us'],
        ] as $nav)
        <a href="{{ route($nav['route']) }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8 transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4] {{ request()->routeIs($nav['route']) ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] {{ request()->routeIs($nav['route']) ? 'opacity-100' : 'opacity-0' }}"></span>
          <span class="w-8 h-8 rounded-lg flex items-center justify-center ml-1"><i class="fa-solid {{ $nav['icon'] }} text-lg"></i></span>
          <span class="sidebar-text ml-2 text-sm font-semibold whitespace-nowrap overflow-hidden transition-all duration-300">{{ $nav['label'] }}</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">{{ $nav['label'] }}</span>
        </a>
        @endforeach
      </nav>
    </div>
    <div class="px-3 pb-5 space-y-4">
      <div class="section-label">Settings</div>
      <div class="w-full px-3">
        <div id="themeToggle" class="theme-toggle-container">
          <button type="button" class="theme-option active" data-theme="light" aria-label="Light mode"><i class="fa-solid fa-sun"></i></button>
          <button type="button" class="theme-option" data-theme="dark" aria-label="Dark mode"><i class="fa-regular fa-moon"></i></button>
          <div class="theme-indicator" aria-hidden="true"></div>
        </div>
      </div>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="group sidebar-link w-full relative flex items-center rounded-xl text-sm text-red-600 hover:bg-red-100 transition-all duration-200">
          <div class="flex items-center justify-center w-8 h-8 rounded-lg flex-shrink-0 ml-2"><i class="fa-solid fa-right-from-bracket text-sm"></i></div>
          <span class="sidebar-text ml-2 opacity-0 w-0 font-semibold overflow-hidden transition-all duration-300 delay-150">Log out</span>
          <span class="sidebar-tooltip absolute left-full ml-2 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Log out</span>
        </button>
      </form>
    </div>
  </aside>

  <!-- ══════ MOBILE BOTTOM NAV ══════ -->
  <nav id="mobileBottomNav">
    <a href="{{ route('homepage') }}" class="mob-nav-item {{ request()->routeIs('homepage') ? 'active' : '' }}">
      <i class="fa-solid fa-house"></i><span>Home</span>
    </a>
    <a href="{{ route('patient.appointment.index') }}"
      class="mob-nav-item {{ request()->routeIs('patient.appointment.index') ? 'active' : '' }}">
      <i class="fa-solid fa-calendar"></i><span>Appointments</span>
    </a>
    <div id="mobFabWrapper">
      <div id="mobFabMenu">
        <a href="{{ route('patient.book.appointment') }}" class="fab-menu-item">
          <i class="fa-solid fa-calendar-plus"></i> Book Appointment
        </a>
        <a onclick="document.getElementById('dentalHealthRecordModal')?.showModal()"
          class="fab-menu-item cursor-pointer">
          <i class="fa-solid fa-file-medical"></i> Request Health Record
        </a>
        <a onclick="document.getElementById('dentalClearanceModal')?.showModal()" class="fab-menu-item cursor-pointer">
          <i class="fa-solid fa-file-circle-check"></i> Request Clearance
        </a>
      </div>
      <button id="mobFab" aria-label="Quick actions"><i class="fa-solid fa-plus"></i></button>
    </div>
    <a href="{{ route('patient.record') }}"
      class="mob-nav-item {{ request()->routeIs('patient.record') ? 'active' : '' }}">
      <i class="fa-solid fa-folder-open"></i><span>Record</span>
    </a>
    <a href="{{ route('patient.about.us') }}"
      class="mob-nav-item {{ request()->routeIs('patient.about.us') ? 'active' : '' }}">
      <i class="fa-solid fa-circle-info"></i><span>About</span>
    </a>
  </nav>

  <!-- ══════════════ DARK MODE FAB (mobile only) ══════════════ -->
  <button id="darkModeFab"
    onclick="applyTheme(document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark')"
    style="position:fixed;bottom:88px;right:16px;width:44px;height:44px;border-radius:50%;
           background:linear-gradient(135deg,#8B0000,#660000);color:white;border:none;font-size:18px;
           display:flex;align-items:center;justify-content:center;
           box-shadow:0 4px 16px rgba(139,0,0,.45);cursor:pointer;z-index:199;
           transition:transform .2s cubic-bezier(.34,1.56,.64,1);"
    aria-label="Toggle dark mode">
    <i id="darkModeFabIcon" class="fa-solid fa-moon"></i>
  </button>

  <!-- ══════════════ MAIN CONTENT ══════════════ -->
  <main id="mainContent" class="pt-[100px] px-4 sm:px-6 py-6 fade-up min-h-screen">
    <div class="mx-auto">

      <!-- Breadcrumb -->
      <div class="text-xs mb-5 font-medium flex items-center gap-1.5 text-gray-400 pt-4">
        <a href="{{ route('homepage') }}" class="hover:text-[#8B0000] transition-colors">Home</a>
        <i class="fa-solid fa-chevron-right text-[9px]"></i>
        <span class="text-[#8B0000] font-semibold">About Us</span>
      </div>

      <!-- ── HERO BANNER ── -->
      <div class="about-hero reveal">
        <!-- Decorative rings -->
        <div class="about-hero-ring" style="width:300px;height:300px;top:-100px;right:-100px;"></div>
        <div class="about-hero-ring" style="width:180px;height:180px;bottom:-60px;left:40%;"></div>

        <div class="about-hero-text">
          <div class="about-hero-eyebrow">
            <i class="fa-solid fa-tooth"></i>
            PUP Taguig Campus
          </div>
          <h1>Dental Clinic</h1>
          <p>Providing free, professional dental care to the PUP Taguig community — students, alumni, faculty, and staff in a safe and welcoming environment.</p>
        </div>
        <div class="about-hero-badge">
          <i class="fa-solid fa-tooth"></i>
        </div>
      </div>

      <!-- ── MISSION PILLARS ── -->
      <div class="mission-strip reveal">
        <div class="mission-card reveal reveal-delay-1">
          <div class="mission-icon"><i class="fa-solid fa-shield-heart"></i></div>
          <h3>Free Dental Care</h3>
          <p>All dental services are provided at no cost to eligible members of the PUP Taguig academic community.</p>
        </div>
        <div class="mission-card reveal reveal-delay-2">
          <div class="mission-icon"><i class="fa-solid fa-calendar-check"></i></div>
          <h3>Easy Scheduling</h3>
          <p>Book appointments online through the Dental Management System with real-time slot availability.</p>
        </div>
        <div class="mission-card reveal reveal-delay-3">
          <div class="mission-icon"><i class="fa-solid fa-file-medical"></i></div>
          <h3>Digital Records</h3>
          <p>Patient history, treatments, prescriptions, and diagnoses are securely stored and easily accessible.</p>
        </div>
      </div>

      <!-- ── MEET THE DENTIST ── -->
      <section class="mb-16 reveal">
        <div class="section-pill"><i class="fa-solid fa-user-doctor"></i> Our Dentist</div>
        <div class="dentist-section">
          <!-- Text side -->
          <div class="dentist-text-side">
            <h2>Led by an experienced professional</h2>
            <p>The PUP Taguig Dental Clinic is headed by <strong>Dr. Nelson P. Angeles</strong>, the campus dentist, who provides professional, safe, and reliable dental care to the entire university community.</p>
            <p>With a commitment to patient comfort and oral health excellence, Dr. Angeles oversees all dental services, consultations, and treatment plans delivered at the clinic.</p>
            <div class="flex flex-wrap gap-2 mt-4">
              <span class="dentist-tag"><i class="fa-solid fa-circle-check text-xs"></i> Licensed Dentist</span>
              <span class="dentist-tag"><i class="fa-solid fa-circle-check text-xs"></i> PUP Campus Dentist</span>
              <span class="dentist-tag"><i class="fa-solid fa-circle-check text-xs"></i> Free Consultations</span>
            </div>
          </div>

          <!-- Profile card -->
          <div class="dentist-profile-card">
            <div class="dentist-card-header">
              <div class="dentist-img-wrap">
                <img src="{{ asset('images/Nelson-Angeles.png') }}" alt="Dr. Nelson P. Angeles" onerror="this.src='https://ui-avatars.com/api/?name=Nelson+Angeles&background=660000&color=FFFFFF&size=88'">
              </div>
              <div class="dentist-name">Dr. Nelson P. Angeles</div>
              <div class="dentist-title">University Campus Dentist</div>
            </div>
            <div class="dentist-card-body">
              <p class="text-sm text-[#6B7280] leading-relaxed mb-4">Serving the PUP Taguig community with dedication, Dr. Angeles ensures every patient receives attentive and comprehensive dental care.</p>
              <div class="flex flex-col gap-3">
                <div class="flex items-center gap-3 text-sm text-[#5A5A6A]">
                  <span class="w-8 h-8 bg-[#FDF1F1] rounded-lg flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-location-dot text-[#8B0000] text-xs"></i></span>
                  PUP Taguig Campus Dental Clinic
                </div>
                <div class="flex items-center gap-3 text-sm text-[#5A5A6A]">
                  <span class="w-8 h-8 bg-[#FDF1F1] rounded-lg flex items-center justify-center flex-shrink-0"><i class="fa-regular fa-clock text-[#8B0000] text-xs"></i></span>
                  Monday – Friday, 8:00 AM – 5:00 PM
                </div>
                <div class="flex items-center gap-3 text-sm text-[#5A5A6A]">
                  <span class="w-8 h-8 bg-[#FDF1F1] rounded-lg flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-users text-[#8B0000] text-xs"></i></span>
                  Students, Alumni, Faculty & Staff
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ── SERVICES OFFERED ── -->
      <section class="services-section reveal">
        <div class="section-pill"><i class="fa-solid fa-stethoscope"></i> Services</div>
        <h2 class="text-2xl font-800 font-bold text-[#8B0000] mb-2">What We Offer</h2>
        <p class="text-sm text-[#8A8A9A] mb-6">The clinic provides a range of preventive and restorative dental services at no cost.</p>
        <div class="services-grid">
          <div class="service-item reveal reveal-delay-1">
            <div class="service-item-icon"><i class="fa-solid fa-hand-holding-medical"></i></div>
            <div>
              <h4>Oral Check-Up & Consultation</h4>
              <p>Routine oral examinations, dental consultation, and oral health assessment.</p>
            </div>
          </div>
          <div class="service-item reveal reveal-delay-2">
            <div class="service-item-icon"><i class="fa-solid fa-droplet"></i></div>
            <div>
              <h4>Dental Cleaning</h4>
              <p>Professional oral hygiene treatment to remove plaque, tartar, and surface stains.</p>
            </div>
          </div>
          <div class="service-item reveal reveal-delay-3">
            <div class="service-item-icon"><i class="fa-solid fa-teeth"></i></div>
            <div>
              <h4>Restoration & Prosthesis</h4>
              <p>Fillings, crowns, inlays, and other repairs to restore damaged or missing teeth.</p>
            </div>
          </div>
          <div class="service-item reveal reveal-delay-4">
            <div class="service-item-icon"><i class="fa-solid fa-crutch"></i></div>
            <div>
              <h4>Dental Surgery</h4>
              <p>Tooth extractions, supernumerary removal, and other surgical dental procedures.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- ── FAQs ── -->
      <section class="faq-section reveal">
        <div class="faq-header-row">
          <div>
            <div class="section-pill"><i class="fa-solid fa-circle-question"></i> FAQs</div>
            <h2 class="faq-section-title">Frequently Asked Questions</h2>
            <p class="faq-section-sub">Quick answers about the PUP Taguig Dental Management System.</p>
          </div>
        </div>

        @php
        $faqs = [
        ['q' => 'Who can avail of the dental services?',
        'a' => 'All students, alumni, faculty, and staff of the Polytechnic University of the Philippines – Taguig Campus are eligible for free dental services.'],
        ['q' => 'How do I book an appointment?',
        'a' => 'You can book an appointment online through the Dental Management System portal. Simply log in, choose your preferred schedule, and confirm your booking.'],
        ['q' => 'Will the dentist prescribe medications?',
        'a' => 'Yes. Depending on your dental condition, Dr. Angeles may prescribe antibiotics, pain relievers, or other necessary medications during your visit.'],
        ['q' => 'Can I book an appointment anytime?',
        'a' => 'Appointments are subject to slot availability. Since the clinic operates with a single dentist and limited daily slots, early booking is highly recommended.'],
        ['q' => 'How do I cancel or reschedule?',
        'a' => 'You can cancel or reschedule through the Dental Management System portal or by contacting the clinic directly — at least three (3) days before your scheduled appointment.'],
        ['q' => 'What if the dentist is unavailable on my scheduled day?',
        'a' => 'If Dr. Angeles is unavailable, your confirmed appointment will be rescheduled to the next available slot and you will be notified accordingly.'],
        ['q' => 'What services are available at the clinic?',
        'a' => 'The clinic provides oral check-ups, dental cleaning, fillings, extractions, dental surgery, restoration, prosthetics, and preventive care services.'],
        ['q' => 'Are urgent dental cases given priority?',
        'a' => 'Yes, urgent cases may be prioritized depending on the daily schedule and the dentist\'s discretion. Contact the clinic directly for urgent concerns.'],
        ['q' => 'Are there restrictions for certain treatments?',
        'a' => 'Some advanced procedures may not be available due to the clinic\'s resources and equipment. The dentist will guide you on available alternatives if needed.'],
        ['q' => 'Are follow-up appointments required?',
        'a' => 'Some treatments require follow-up visits. Dr. Angeles will advise you if a follow-up is necessary after your initial treatment.'],
        ];
        @endphp

        <div id="faqList">
          @foreach($faqs as $i => $faq)
          <div class="faq-item-new reveal" style="transition-delay: {{ $i * 0.04 }}s;">
            <button class="faq-trigger" onclick="toggleFaqNew(this)" aria-expanded="false">
              <div class="faq-trigger-left">
                <span class="faq-num">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</span>
                <span class="faq-q">{{ $faq['q'] }}</span>
              </div>
              <span class="faq-chevron"><i class="fa-solid fa-chevron-down text-xs"></i></span>
            </button>
            <div class="faq-body">
              <div class="faq-body-inner">{{ $faq['a'] }}</div>
            </div>
          </div>
          @endforeach
        </div>
      </section>

      <!-- ── THE DEVELOPERS ── -->
      <section class="team-section reveal">
        <div class="section-pill"><i class="fa-solid fa-code"></i> Development Team</div>
        <h2 class="team-title">The Developers</h2>
        <p class="team-sub">The PUPT Dental Management System was built by these talented developers.</p>

        <div class="team-grid">
          @php
            $devs = [
              ['img' => 'Althea-Aragon.jpg', 'name' => 'Althea Aragon', 'role' => 'Developer'],
              ['img' => 'Grace-Lim.jpg', 'name' => 'Grace Lim', 'role' => 'Developer'],
              ['img' => 'Hoshea-Lopez.jpg', 'name' => 'Hoshea Lopez', 'role' => 'Developer'],
              ['img' => 'Rain-Romero.jpg', 'name' => 'Rain Romero', 'role' => 'Developer'],
            ];
          @endphp

          @foreach($devs as $i => $dev)
            <div class="team-card reveal" style="transition-delay: {{ $i * 0.08 }}s;">
              <div class="team-img-wrap">
                <img
                  src="{{ asset('images/' . $dev['img']) }}"
                  alt="{{ $dev['name'] }}"
                  onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($dev['name']) }}&background=8B0000&color=FFFFFF&size=200'">
              </div>
              <div class="team-info">
                <div class="team-name">{{ $dev['name'] }}</div>
                <span class="team-role">{{ $dev['role'] }}</span>
              </div>
            </div>
          @endforeach
        </div>
      </section>

      <!-- ── CLOSING STATEMENT ── -->
      <div class="closing-banner reveal">
        <div class="closing-banner-icon"><i class="fa-solid fa-heart-pulse"></i></div>
        <p>The <strong>PUPT Dental Management System</strong> was developed to manage records and appointments more effectively — ensuring efficient dental service while supporting the University's commitment to quality and accessible care for all.</p>
      </div>

    </div>
  </main>

  <!-- ══════════════ FOOTER ══════════════ -->
  <footer class="footer bg-[#8B0000] text-[#F4F4F4] p-6">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 text-sm text-center">
      <span><span class="text-gray-300">© 2025–2026</span> <span class="font-semibold">Polytechnic University of the Philippines</span></span>
      <span class="hidden sm:inline">|</span>
      <a href="https://www.pup.edu.ph/terms/" class="hover:underline">Terms of Use</a>
      <span class="hidden sm:inline">|</span>
      <a href="https://www.pup.edu.ph/privacy/" class="hover:underline">Privacy Statement</a>
    </div>
  </footer>

  <script>
    /* ══════════════════════════════════════════════
       THEME
    ══════════════════════════════════════════════ */
    var html = document.documentElement;
    var themeToggleContainer = document.getElementById("themeToggle");
    var themeIndicator = themeToggleContainer.querySelector(".theme-indicator");
    var themeOptions = themeToggleContainer.querySelectorAll(".theme-option");

    function applyTheme(theme) {
      html.setAttribute("data-theme", theme);
      localStorage.setItem("theme", theme);
      themeOptions.forEach(function(opt) {
        opt.classList.toggle("active", opt.getAttribute("data-theme") === theme);
      });
      themeIndicator.classList.toggle("dark-mode", theme === "dark");
      var fabIcon = document.getElementById("darkModeFabIcon");
      if (fabIcon) fabIcon.className = theme === "dark" ? "fa-solid fa-sun" : "fa-solid fa-moon";
    }
    applyTheme(localStorage.getItem("theme") || "light");
    themeOptions.forEach(function(opt) {
      opt.addEventListener("click", function() {
        applyTheme(opt.getAttribute("data-theme"));
      });
    });

    /* ══════════════════════════════════════════════
       DESKTOP SIDEBAR
    ══════════════════════════════════════════════ */
    var sidebarOpen = true;

    function applyLayout(w) {
      document.getElementById('sidebar').style.width = w;
      document.getElementById('mainContent').style.marginLeft = w;
    }

    function toggleSidebar() {
      var sidebar = document.getElementById('sidebar');
      var texts = document.querySelectorAll('.sidebar-text');
      var icon = document.getElementById('sidebarIcon');
      var wrapper = document.getElementById('sidebarToggleWrapper');
      sidebarOpen = !sidebarOpen;
      if (sidebarOpen) {
        applyLayout('220px');
        sidebar.classList.replace('collapsed', 'expanded');
        texts.forEach(function(t) {
          t.classList.remove('opacity-0', 'w-0');
          t.classList.add('opacity-100');
        });
        wrapper.classList.replace('justify-center', 'justify-end');
        icon.classList.replace('fa-bars', 'fa-xmark');
      } else {
        applyLayout('72px');
        sidebar.classList.replace('expanded', 'collapsed');
        texts.forEach(function(t) {
          t.classList.add('opacity-0', 'w-0');
          t.classList.remove('opacity-100');
        });
        wrapper.classList.replace('justify-end', 'justify-center');
        icon.classList.replace('fa-xmark', 'fa-bars');
      }
      applyTheme(localStorage.getItem("theme") || "light");
    }

    /* ══════════════════════════════════════════════
       MOBILE PROFILE ACCORDION
    ══════════════════════════════════════════════ */
    function toggleMobileProfile() {
      var panel = document.getElementById('mobileProfileAccordion');
      var chevron = document.getElementById('mobileProfileChevron');
      var isOpen = panel.classList.contains('open');
      panel.classList.toggle('open', !isOpen);
      if (chevron) chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
    }

    /* ══════════════════════════════════════════════
       FAQ ACCORDION
    ══════════════════════════════════════════════ */
    function toggleFaqNew(btn) {
      var item = btn.closest('.faq-item-new');
      var body = item.querySelector('.faq-body');
      var isOpen = item.classList.contains('open');

      // close all
      document.querySelectorAll('.faq-item-new.open').forEach(function(el) {
        el.classList.remove('open');
        el.querySelector('.faq-body').style.maxHeight = '0';
        el.querySelector('.faq-trigger').setAttribute('aria-expanded', 'false');
      });

      if (!isOpen) {
        item.classList.add('open');
        body.style.maxHeight = body.scrollHeight + 'px';
        btn.setAttribute('aria-expanded', 'true');
      }
    }

    /* ══════════════════════════════════════════════
       DOM READY
    ══════════════════════════════════════════════ */
    document.addEventListener('DOMContentLoaded', function() {
      /* Desktop layout */
      if (window.innerWidth >= 768) {
        sidebarOpen = true;
        applyLayout('220px');
      } else {
        document.getElementById('mainContent').style.marginLeft = '0';
      }

      /* Mobile FAB */
      var mobFab = document.getElementById('mobFab');
      var mobFabMenu = document.getElementById('mobFabMenu');
      if (mobFab && mobFabMenu) {
        mobFab.addEventListener('click', function(e) {
          e.stopPropagation();
          var open = mobFabMenu.classList.contains('open');
          mobFabMenu.classList.toggle('open', !open);
          mobFab.classList.toggle('open', !open);
        });
        mobFabMenu.addEventListener('click', function(e) {
          e.stopPropagation();
        });
      }

      /* Notifications */
      var notifBtn = document.getElementById("notifBtn");
      var notifMenu = document.getElementById("notifMenu");
      if (notifBtn && notifMenu) {
        notifBtn.addEventListener("click", function(e) {
          e.stopPropagation();
          notifMenu.classList.toggle("open");
        });
        notifMenu.addEventListener("click", function(e) {
          e.stopPropagation();
        });
        document.addEventListener("keydown", function(e) {
          if (e.key === "Escape") notifMenu.classList.remove("open");
        });
      }

      /* Close all on outside click */
      document.addEventListener('click', function() {
        if (mobFabMenu) {
          mobFabMenu.classList.remove('open');
          if (mobFab) mobFab.classList.remove('open');
        }
        if (notifMenu) notifMenu.classList.remove('open');
        var panel = document.getElementById('mobileProfileAccordion');
        var toggle = document.getElementById('mobileProfileToggle');
        var chevron = document.getElementById('mobileProfileChevron');
        if (panel && toggle && !panel.contains(event.target) && !toggle.contains(event.target)) {
          panel.classList.remove('open');
          if (chevron) chevron.style.transform = 'rotate(0deg)';
        }
      });

      /* Scroll reveal */
      var revealObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            revealObserver.unobserve(entry.target);
          }
        });
      }, {
        threshold: 0.1
      });
      document.querySelectorAll('.reveal').forEach(function(el) {
        revealObserver.observe(el);
      });
    });
  </script>

</body>

</html>