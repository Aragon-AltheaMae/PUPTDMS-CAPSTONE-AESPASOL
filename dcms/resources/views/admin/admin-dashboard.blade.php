<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard | PUP Taguig Dental Clinic</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"rel="stylesheet">

  <script>tailwind.config = { daisyui: { themes: false } }</script>

  <style>
    :root {
      --crimson: #8B0000;
      --crimson-dark: #6b0000;
      --crimson-light: #fef2f2;
      --crimson-mid: #fce8e8;
      --sidebar-w: 256px;
      --header-h: 64px;
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: #F4F4F4;
      overflow-x: hidden;
      color: #1a1a2e;
    }

    /* ── SCROLLBAR ── */
    ::-webkit-scrollbar {
      width: 5px;
      height: 5px;
    }

    ::-webkit-scrollbar-track {
      background: transparent;
    }

    ::-webkit-scrollbar-thumb {
      background: #ddd;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #bbb;
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

    /* ════════════════════════════════
       SIDEBAR
    ════════════════════════════════ */
    #sidebar {
      position: fixed;
      left: 0;
      top: var(--header-h);
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

    /* Sidebar bottom */
    .sidebar-bottom {
      padding: 10px 10px 14px;
      border-top: 1px solid #f3f4f6;
      flex-shrink: 0;
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

    /* ════════════════════════════════
       LAYOUT
    ════════════════════════════════ */
    #mainContent,
    #siteFooter {
      margin-left: var(--sidebar-w);
    }

    /* ════════════════════════════════
       PAGE HEADER AREA
    ════════════════════════════════ */
    .page-banner {
      background: linear-gradient(135deg, var(--crimson-dark) 0%, var(--crimson) 60%, #c0392b 100%);
      padding: 2rem 2rem 3.5rem;
      position: relative;
      overflow: hidden;
    }

    .page-banner::before {
      content: '';
      position: absolute;
      inset: 0;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .page-banner::after {
      content: '';
      position: absolute;
      right: -60px;
      top: -60px;
      width: 280px;
      height: 280px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .04);
      pointer-events: none;
    }

    .page-banner-inner {
      position: relative;
      z-index: 1;
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .page-greeting {
      font-size: .75rem;
      font-weight: 600;
      color: rgba(255, 255, 255, .65);
      letter-spacing: .05em;
      text-transform: uppercase;
      margin-bottom: .3rem;
      display: flex;
      align-items: center;
      gap: .5rem;
    }

    .page-title {
      font-size: 2rem;
      font-weight: 900;
      color: #fff;
      line-height: 1.1;
      letter-spacing: -.02em;
    }

    .page-subtitle {
      font-size: .78rem;
      color: rgba(255, 255, 255, .6);
      margin-top: .4rem;
    }

    /* Academic Period pill in banner */
    .period-pill {
      background: rgba(255, 255, 255, .12);
      border: 1px solid rgba(255, 255, 255, .2);
      border-radius: 14px;
      padding: .75rem 1.25rem;
      display: flex;
      align-items: center;
      gap: 1.5rem;
      backdrop-filter: blur(8px);
      flex-wrap: wrap;
    }

    .period-item {
      text-align: left;
    }

    .period-label {
      font-size: .6rem;
      font-weight: 700;
      color: rgba(255, 255, 255, .55);
      text-transform: uppercase;
      letter-spacing: .08em;
      display: block;
    }

    .period-value {
      font-size: .95rem;
      font-weight: 800;
      color: #fff;
      display: block;
      margin-top: 2px;
    }

    .period-divider {
      width: 1px;
      height: 32px;
      background: rgba(255, 255, 255, .2);
    }

    .manage-btn {
      background: rgba(255, 255, 255, .15);
      border: 1px solid rgba(255, 255, 255, .25);
      color: #fff;
      padding: .6rem 1.1rem;
      border-radius: 10px;
      font-size: .75rem;
      font-weight: 700;
      cursor: pointer;
      transition: all .15s;
      display: flex;
      align-items: center;
      gap: .5rem;
      white-space: nowrap;
      font-family: 'Inter', sans-serif;
    }

    .manage-btn:hover {
      background: rgba(255, 255, 255, .25);
      transform: translateY(-1px);
    }

    /* ════════════════════════════════
       CONTENT LIFT (cards overlap banner)
    ════════════════════════════════ */
    .content-lift {
      margin-top: -2rem;
      padding: 0 1.75rem 2rem;
      position: relative;
      z-index: 2;
    }

    /* ════════════════════════════════
       STAT CARDS
    ════════════════════════════════ */
    .stat-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1rem;
      margin-bottom: 1.5rem;
    }

    .stat-card {
      background: #fff;
      border-radius: 16px;
      padding: 1.25rem 1.4rem;
      border: 1px solid rgba(0, 0, 0, .05);
      box-shadow: 0 4px 20px rgba(0, 0, 0, .06), 0 1px 3px rgba(0, 0, 0, .04);
      transition: transform .2s, box-shadow .2s;
      position: relative;
      overflow: hidden;
    }

    .stat-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 32px rgba(0, 0, 0, .1), 0 2px 6px rgba(0, 0, 0, .05);
    }

    .stat-card-accent {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
    }

    .stat-top {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1rem;
    }

    .stat-icon {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.1rem;
    }

    .stat-badge {
      font-size: .68rem;
      font-weight: 700;
      padding: .3rem .75rem;
      border-radius: 20px;
    }

    .stat-label {
      font-size: .68rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .06em;
      color: #9ca3af;
      margin-bottom: .3rem;
    }

    .stat-value {
      font-size: 2.4rem;
      font-weight: 900;
      line-height: 1;
      color: #1a202c;
      letter-spacing: -.03em;
      margin-bottom: .5rem;
    }

    .stat-footer {
      font-size: .7rem;
      color: #9ca3af;
      display: flex;
      align-items: center;
      gap: .35rem;
    }

    /* ════════════════════════════════
       MAIN GRID
    ════════════════════════════════ */
    .main-grid {
      display: grid;
      grid-template-columns: 1fr 320px;
      gap: 1.25rem;
    }

    .card {
      background: #fff;
      border-radius: 16px;
      border: 1px solid rgba(0, 0, 0, .05);
      box-shadow: 0 2px 12px rgba(0, 0, 0, .04);
      overflow: hidden;
    }

    .card-header {
      padding: .9rem 1.25rem;
      border-bottom: 1px solid #f3f4f6;
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: #fafafa;
    }

    .card-header-left {
      display: flex;
      align-items: center;
      gap: .6rem;
    }

    .card-header-icon {
      width: 30px;
      height: 30px;
      border-radius: 8px;
      background: var(--crimson-light);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      color: var(--crimson);
    }

    .card-title {
      font-size: .82rem;
      font-weight: 800;
      color: #1a202c;
    }

    .card-link {
      font-size: .72rem;
      color: var(--crimson);
      font-weight: 700;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: .3rem;
      transition: gap .15s;
    }

    .card-link:hover {
      gap: .5rem;
    }

    /* ════════════════════════════════
       LOG MINI-STATS
    ════════════════════════════════ */
    .log-stats-row {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: .75rem;
      padding: 1rem 1.25rem;
      border-bottom: 1px solid #f3f4f6;
    }

    .log-stat {
      text-align: center;
      padding: .7rem .5rem;
      border-radius: 10px;
      cursor: pointer;
      transition: transform .15s;
    }

    .log-stat:hover {
      transform: translateY(-2px);
    }

    .log-stat-value {
      font-size: 1.4rem;
      font-weight: 900;
      line-height: 1;
    }

    .log-stat-label {
      font-size: .58rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .06em;
      margin-top: 4px;
    }

    /* ════════════════════════════════
       TABLE
    ════════════════════════════════ */
    .data-table {
      width: 100%;
      border-collapse: collapse;
      font-size: .76rem;
    }

    .data-table thead th {
      padding: .7rem 1rem;
      text-align: left;
      font-weight: 700;
      color: #9ca3af;
      font-size: .65rem;
      text-transform: uppercase;
      letter-spacing: .06em;
      background: #fafafa;
      border-bottom: 1px solid #f3f4f6;
    }

    .data-table tbody td {
      padding: .8rem 1rem;
      color: #4a5568;
      border-bottom: 1px solid #f9fafb;
    }

    .data-table tbody tr:hover td {
      background: #fafafa;
    }

    .data-table tbody tr:last-child td {
      border-bottom: none;
    }

    .empty-state {
      text-align: center;
      padding: 3rem 1rem;
    }

    .empty-icon {
      width: 56px;
      height: 56px;
      border-radius: 16px;
      background: #f3f4f6;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem;
      font-size: 1.4rem;
      color: #d1d5db;
    }

    /* ════════════════════════════════
       BOTTOM ROW — 2 col
    ════════════════════════════════ */
    .bottom-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.25rem;
      margin-top: 1.25rem;
    }

    /* ════════════════════════════════
       QUICK ACTIONS
    ════════════════════════════════ */
    .qa-btn {
      display: flex;
      align-items: center;
      gap: .85rem;
      padding: .85rem 1rem;
      border-radius: 12px;
      border: 1px solid #f0f0f0;
      background: #fff;
      cursor: pointer;
      transition: all .15s;
      text-align: left;
      width: 100%;
      margin-bottom: .6rem;
      font-family: 'Inter', sans-serif;
    }

    .qa-btn:last-child {
      margin-bottom: 0;
    }

    .qa-btn:hover {
      border-color: var(--crimson-mid);
      background: var(--crimson-light);
      transform: translateX(3px);
    }

    .qa-btn:hover .qa-icon {
      background: var(--crimson);
      color: #fff;
    }

    .qa-icon {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      background: var(--crimson-light);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--crimson);
      font-size: .95rem;
      flex-shrink: 0;
      transition: all .15s;
    }

    .qa-text {
      flex: 1;
    }

    .qa-title {
      font-size: .8rem;
      font-weight: 700;
      color: var(--crimson);
      display: block;
    }

    .qa-sub {
      font-size: .68rem;
      color: #9ca3af;
      display: block;
      margin-top: 1px;
    }

    .qa-arrow {
      color: #d1d5db;
      font-size: .7rem;
      transition: all .15s;
    }

    .qa-btn:hover .qa-arrow {
      color: var(--crimson);
    }

    /* ════════════════════════════════
       BACKUP CARD
    ════════════════════════════════ */
    .backup-status {
      display: flex;
      align-items: center;
      gap: .85rem;
      padding: 1rem 1.1rem;
      background: linear-gradient(135deg, #f0fdf4, #dcfce7);
      border: 1px solid #bbf7d0;
      border-radius: 12px;
      margin-bottom: .75rem;
    }

    .backup-check {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      background: #fff;
      border: 1px solid #86efac;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #16a34a;
      font-size: 1rem;
      flex-shrink: 0;
    }

    .backup-label {
      font-size: .6rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .06em;
      color: #16a34a;
      display: block;
    }

    .backup-date {
      font-size: .85rem;
      font-weight: 800;
      color: #1a202c;
      display: block;
      margin-top: 2px;
    }

    .backup-sub {
      font-size: .65rem;
      color: #4ade80;
      margin-top: 1px;
      display: block;
    }

    .next-backup {
      display: flex;
      align-items: center;
      gap: .75rem;
      padding: .75rem 1rem;
      background: #f9fafb;
      border: 1px solid #e5e7eb;
      border-radius: 10px;
      margin-bottom: .75rem;
    }

    .next-icon {
      color: #9ca3af;
      font-size: .85rem;
    }

    .next-label {
      font-size: .62rem;
      font-weight: 600;
      color: #9ca3af;
      text-transform: uppercase;
      letter-spacing: .05em;
    }

    .next-date {
      font-size: .8rem;
      font-weight: 800;
      color: #374151;
      margin-top: 1px;
    }

    .run-backup-btn {
      width: 100%;
      background: linear-gradient(135deg, var(--crimson) 0%, var(--crimson-dark) 100%);
      color: #fff;
      font-weight: 800;
      font-size: .8rem;
      padding: .8rem 1rem;
      border-radius: 12px;
      border: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: .5rem;
      transition: all .2s;
      box-shadow: 0 4px 14px rgba(139, 0, 0, .3);
      font-family: 'Inter', sans-serif;
    }

    .run-backup-btn:hover {
      box-shadow: 0 6px 20px rgba(139, 0, 0, .4);
      transform: translateY(-1px);
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
       TOAST
    ════════════════════════════════ */
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
      box-shadow: 0 10px 40px rgba(0, 0, 0, .15) !important;
      padding: 14px 16px !important;
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
      width: 3px;
      background: none;
    }

    #toastContainer .toast.error::before {
      background: var(--crimson) !important;
    }

    #toastContainer .toast.success::before {
      background: #16a34a !important;
    }

    #toastContainer .toast.show {
      opacity: 1 !important;
      transform: translateX(0) !important;
    }

    #toastContainer .toast.hide {
      opacity: 0 !important;
      transform: translateX(340px) !important;
    }

    .toast-icon-wrap {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .toast.error .toast-icon-wrap {
      background: rgba(139, 0, 0, .08);
    }

    .toast.success .toast-icon-wrap {
      background: rgba(22, 163, 74, .08);
    }

    .toast-icon {
      font-size: 15px;
    }

    .toast.error .toast-icon {
      color: var(--crimson) !important;
    }

    .toast.success .toast-icon {
      color: #16a34a !important;
    }

    .toast-body {
      flex: 1;
      min-width: 0;
    }

    .toast-title {
      font-size: 12px;
      font-weight: 800;
      color: #1a1a2e !important;
    }

    .toast-msg {
      font-size: 11px;
      color: #9ca3af !important;
      margin-top: 2px;
      line-height: 1.4;
    }

    .toast-close {
      background: none !important;
      border: none;
      cursor: pointer;
      color: #d1d5db;
      font-size: 12px;
      flex-shrink: 0;
      padding: 2px 4px;
      transition: color .15s;
    }

    .toast-close:hover {
      color: #6b7280;
    }

    /* ════════════════════════════════
       TERMS MODAL
    ════════════════════════════════ */
    #termsModal {
      border: none;
      padding: 0;
      border-radius: 18px;
      width: min(94vw, 480px);
      box-shadow: 0 24px 60px rgba(0, 0, 0, .2);
      overflow: hidden;
    }

    #termsModal::backdrop {
      background: rgba(0, 0, 0, .55);
      backdrop-filter: blur(4px);
    }

    .terms-header {
      background: linear-gradient(135deg, var(--crimson-dark) 0%, var(--crimson) 100%);
      padding: 20px 22px 18px;
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
    }

    .terms-header-icon i {
      font-size: 15px;
      color: rgba(255, 255, 255, .9);
    }

    .terms-header h2 {
      color: #fff;
      font-size: 1rem;
      font-weight: 800;
      margin: 0;
    }

    .terms-header p {
      color: rgba(255, 255, 255, .6);
      font-size: .7rem;
      margin: 2px 0 0;
    }

    .terms-body {
      padding: 20px 22px 18px;
    }

    .terms-body p {
      font-size: .83rem;
      color: #4b5563;
      line-height: 1.75;
      margin-bottom: 10px;
    }

    .terms-body strong {
      color: #1f2937;
      font-weight: 700;
    }

    .terms-divider {
      height: 1px;
      background: #f0e8e8;
      margin: 4px 0 14px;
    }

    .terms-checkbox-row {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      background: #fdf5f5;
      border: 1px solid #fce8e8;
      border-radius: 10px;
      padding: 11px 13px;
      margin-bottom: 18px;
      cursor: pointer;
    }

    .terms-checkbox-row input[type="checkbox"] {
      margin-top: 2px;
      cursor: pointer;
      accent-color: var(--crimson);
      width: 14px;
      height: 14px;
      flex-shrink: 0;
    }

    .terms-checkbox-row span {
      font-size: .8rem;
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
      padding: 8px 18px;
      border-radius: 9px;
      border: 1px solid #e5e7eb;
      background: #f9fafb;
      color: #6b7280;
      font-weight: 600;
      font-size: .8rem;
      cursor: pointer;
      transition: all .15s;
      font-family: 'Inter', sans-serif;
    }

    .terms-cancel-btn:hover {
      background: #f3f4f6;
      color: #374151;
    }

    .terms-continue-btn {
      padding: 8px 20px;
      border-radius: 9px;
      border: none;
      background: #9ca3af;
      color: white;
      font-weight: 700;
      font-size: .8rem;
      cursor: not-allowed;
      transition: all .2s;
      font-family: 'Inter', sans-serif;
    }

    .terms-continue-btn:not(:disabled) {
      background: var(--crimson);
      cursor: pointer;
      box-shadow: 0 2px 10px rgba(139, 0, 0, .3);
    }

    .terms-continue-btn:not(:disabled):hover {
      background: var(--crimson-dark);
      box-shadow: 0 4px 14px rgba(139, 0, 0, .4);
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
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .45);
      z-index: 998;
      backdrop-filter: blur(2px);
      opacity: 0;
      transition: opacity .25s;
    }

    #mobileDrawerOverlay.open {
      opacity: 1;
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

    /* ════════════════════════════════
       DARK MODE
    ════════════════════════════════ */
    body,
    main,
    footer {
      transition: background-color .3s ease, color .3s ease;
    }

    [data-theme="dark"] body {
      background-color: #0d1117;
      color: #e5e7eb;
    }

    [data-theme="dark"] #sidebar {
      background: #161b22;
      border-color: #21262d;
    }

    [data-theme="dark"] .card,
    [data-theme="dark"] .stat-card {
      background: #161b22 !important;
      border-color: #21262d !important;
    }

    [data-theme="dark"] .card-header,
    [data-theme="dark"] .log-stats-row {
      background: #0d1117 !important;
      border-color: #21262d !important;
    }

    [data-theme="dark"] .stat-value {
      color: #f3f4f6;
    }

    [data-theme="dark"] .card-title {
      color: #f3f4f6;
    }

    [data-theme="dark"] .nav-link {
      color: #d1d5db;
    }

    [data-theme="dark"] .nav-link:hover {
      background: rgba(139, 0, 0, .15);
    }

    [data-theme="dark"] .nav-sep,
    [data-theme="dark"] .sidebar-bottom {
      border-color: #21262d;
    }

    [data-theme="dark"] .group-sublabel,
    [data-theme="dark"] .nav-section-label {
      color: #4b5563;
    }

    [data-theme="dark"] .data-table thead th {
      background: #0d1117;
      color: #6b7280;
      border-color: #21262d;
    }

    [data-theme="dark"] .data-table tbody td {
      color: #d1d5db;
      border-color: #1c2128;
    }

    [data-theme="dark"] .data-table tbody tr:hover td {
      background: #1c2128;
    }

    [data-theme="dark"] .theme-toggle-container {
      background: #1f2937;
      border-color: #374151;
    }

    [data-theme="dark"] .theme-indicator {
      background: #374151;
    }

    [data-theme="dark"] .theme-option.active {
      color: #f3f4f6;
    }

    [data-theme="dark"] .next-backup,
    [data-theme="dark"] .qa-btn {
      background: #1c2128;
      border-color: #21262d;
    }

    [data-theme="dark"] .qa-title {
      color: #fca5a5;
    }

    [data-theme="dark"] .qa-sub {
      color: #6b7280;
    }

    [data-theme="dark"] .qa-btn:hover {
      background: rgba(139, 0, 0, .15);
      border-color: #5b2020;
    }

    [data-theme="dark"] .next-date {
      color: #e5e7eb;
    }

    [data-theme="dark"] .empty-icon {
      background: #21262d;
    }

    [data-theme="dark"] #mobileDrawer {
      background: #0d1117;
    }

    [data-theme="dark"] .drawer-user {
      background: #161b22;
      border-color: #21262d;
    }

    [data-theme="dark"] .drawer-user-name {
      color: #e5e7eb;
    }

    [data-theme="dark"] .drawer-link {
      color: #d1d5db;
    }

    [data-theme="dark"] .drawer-link:hover {
      background: rgba(139, 0, 0, .15);
      color: #fff;
    }

    [data-theme="dark"] .drawer-sep {
      background: #21262d;
    }

    [data-theme="dark"] .drawer-bottom {
      border-color: #21262d;
    }

    [data-theme="dark"] .period-pill {
      background: rgba(255, 255, 255, .08);
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

    /* ════════════════════════════════
       RESPONSIVE
    ════════════════════════════════ */
    @media (max-width: 1024px) {
      .main-grid {
        grid-template-columns: 1fr;
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

      .stat-grid {
        grid-template-columns: 1fr 1fr;
      }

      .stat-grid .stat-card:last-child {
        grid-column: span 2;
      }

      .content-lift {
        padding: 0 1rem 2rem;
      }

      .page-banner {
        padding: 1.5rem 1rem 3rem;
      }

      .period-pill {
        gap: .75rem;
      }

      .log-stats-row {
        grid-template-columns: repeat(3, 1fr);
      }

      .bottom-grid {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 480px) {
      .stat-grid {
        grid-template-columns: 1fr;
      }

      .stat-grid .stat-card:last-child {
        grid-column: span 1;
      }
    }

    /* ════════════════════════════════
       ANIMATIONS
    ════════════════════════════════ */
    @keyframes fadeSlideUp {
      from {
        opacity: 0;
        transform: translateY(16px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .stat-card {
      animation: fadeSlideUp .4s ease both;
    }

    .stat-card:nth-child(1) {
      animation-delay: .05s;
    }

    .stat-card:nth-child(2) {
      animation-delay: .1s;
    }

    .stat-card:nth-child(3) {
      animation-delay: .15s;
    }

    .card {
      animation: fadeSlideUp .4s ease .2s both;
    }
  </style>
</head>

<body class="bg-[#f4f5f7]">

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
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-users"></i> Patients</a>
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-calendar-check"></i>
            Appointments</a>
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-tooth"></i> Dental
            Records</a>
          <a href="{{ route('admin.document-requests.index') }}"
            class="nav-link {{ request()->routeIs('admin.document-requests*') ? 'active' : '' }}">
            <i class="fa-solid fa-file-circle-check"></i> Document Request
          </a>
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-file"></i> Reports</a>
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
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-file-pen"></i> Document
            Templates</a>
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-boxes-stacked"></i>
            Inventory</a>
        </div>
      </div>

      <div class="nav-sep"></div>
      <div class="nav-section-label">System</div>
      <div class="nav-group">
        <div class="group-trigger {{ request()->routeIs('admin.system_logs') ? 'active-group' : '' }}">
          <div class="group-icon-wrap"><i class="fa-solid fa-server"></i></div>
          <div class="group-text">
            <span class="group-label">System</span>
            <span class="group-sublabel">Admin & configuration</span>
          </div>
        </div>
        <div class="group-body">
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-database"></i> Data
            Backup</a>
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
        <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-tooth"></i> Dental
          Records</a>
        <a href="{{ route('admin.document-requests.index') }}"
          class="drawer-link {{ request()->routeIs('admin.document-requests*') ? 'active' : '' }}">
          <i class="fa-solid fa-file-circle-check"></i> Document Request
        </a>
        <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-file"></i> Reports</a>
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
        <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-file-pen"></i> Document
          Templates</a>
        <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-boxes-stacked"></i>
          Inventory</a>
      </div>
      <div class="drawer-sep"></div>
      <div class="drawer-group">
        <div class="drawer-group-header"><i class="drawer-group-icon fa-solid fa-server"></i><span
            class="drawer-group-label">System</span></div>
        <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-database"></i> Data
          Backup</a>
        <a href="{{ route('admin.system_logs') }}"
          class="drawer-link {{ request()->routeIs('admin.system_logs') ? 'active' : '' }}"><i
            class="fa-solid fa-clipboard-list"></i> System Logs</a>
        <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-sliders"></i> System
          Settings</a>
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
              style="color:#ef4444;"></i></span><span>Log out</span></button>
      </form>
    </div>
  </div>

  <!-- ════════ MAIN ════════ -->
  @php
  $logs = $logs ?? collect([]);
  @endphp

  <main id="mainContent" style="padding-top: var(--header-h); min-height: 100vh;">

    <!-- Page banner -->
    <div class="page-banner">
      <div class="page-banner-inner">
        <div>
          <div class="page-greeting">
            <i id="currentDateIcon" class="fa-solid fa-calendar-day" style="color:#fcd34d;"></i>
            <span id="currentDate"></span>
          </div>
          <h1 class="page-title">Admin Dashboard</h1>
          <p class="page-subtitle">Welcome back, Administrator. Here's what's happening today.</p>
        </div>
        <div class="period-pill">
          <div class="period-item">
            <span class="period-label"><i class="fa-solid fa-calendar" style="margin-right:3px;"></i> Semester</span>
            <span class="period-value">2nd Semester</span>
          </div>
          <div class="period-divider"></div>
          <div class="period-item">
            <span class="period-label"><i class="fa-solid fa-graduation-cap" style="margin-right:3px;"></i> Academic
              Year</span>
            <span class="period-value">2025–2026</span>
          </div>
          <div class="period-divider"></div>
          <div class="period-item">
            <span class="period-label"><i class="fa-solid fa-clock" style="margin-right:3px;"></i> Period Ends</span>
            <span class="period-value">June 10, 2026</span>
          </div>
          <a href="{{ route('admin.academic_periods') }}" class="manage-btn">
            <i class="fa-solid fa-gear"></i> Manage
          </a>
        </div>
      </div>
    </div>

    <!-- Content (overlaps banner) -->
    <div class="content-lift">

      <!-- STAT CARDS -->
      <div class="stat-grid">

        <!-- Total Patients -->
        <div class="stat-card">
          <div class="stat-card-accent" style="background: linear-gradient(90deg, var(--crimson), #c0392b);"></div>
          <div class="stat-top">
            <div class="stat-icon" style="background:#fef2f2;">
              <i class="fa-solid fa-users" style="color:var(--crimson);"></i>
            </div>
            <span class="stat-badge" style="background:#fef2f2;color:var(--crimson);">All time</span>
          </div>
          <div class="stat-label">Total Patients</div>
          <div class="stat-value">{{ number_format($totalPatients) }}</div>
          <div class="stat-footer">
            <i class="fa-solid fa-user-plus" style="font-size:.65rem;color:var(--crimson);"></i>
            All registered patients
          </div>
        </div>

        <!-- Appointments -->
        <div class="stat-card">
          <div class="stat-card-accent" style="background: linear-gradient(90deg, #3b82f6, #2563eb);"></div>
          <div class="stat-top">
            <div class="stat-icon" style="background:#eff6ff;">
              <i class="fa-solid fa-calendar-check" style="color:#3b82f6;"></i>
            </div>
            <span class="stat-badge" style="background:#eff6ff;color:#3b82f6;">{{ \Carbon\Carbon::now()->format('F Y')
              }}</span>
          </div>
          <div class="stat-label">Appointments</div>
          <div class="stat-value">{{ $appointmentsThisMonth }}</div>
          <div class="stat-footer">
            <i class="fa-solid fa-clock" style="font-size:.65rem;color:#3b82f6;"></i>
            This month
          </div>
        </div>

        <!-- Documents Issued -->
        <div class="stat-card">
          <div class="stat-card-accent" style="background: linear-gradient(90deg, #22c55e, #16a34a);"></div>
          <div class="stat-top">
            <div class="stat-icon" style="background:#f0fdf4;">
              <i class="fa-solid fa-file-arrow-up" style="color:#22c55e;"></i>
            </div>
            <span class="stat-badge" style="background:#f0fdf4;color:#16a34a;">{{ \Carbon\Carbon::now()->format('F Y')
              }}</span>
          </div>
          <div class="stat-label">Documents Issued</div>
          <div class="stat-value">{{ $documentsThisMonth }}</div>
          <div class="stat-footer">
            <i class="fa-solid fa-file-lines" style="font-size:.65rem;color:#22c55e;"></i>
            This month
          </div>
        </div>

      </div>

      <!-- MAIN GRID -->
      <div class="main-grid">

        <!-- LEFT -->
        <div style="display:flex;flex-direction:column;gap:1.25rem;">

          <!-- System Logs Card -->
          <div class="card">
            <div class="card-header">
              <div class="card-header-left">
                <div class="card-header-icon"><i class="fa-solid fa-clipboard-list"></i></div>
                <span class="card-title">System Logs Overview</span>
              </div>
              <a href="{{ route('admin.system_logs') }}" class="card-link">
                View All <i class="fa-solid fa-arrow-right" style="font-size:.65rem;"></i>
              </a>
            </div>

            <!-- Mini stats -->
            <div class="log-stats-row">
              <div class="log-stat" style="background:#f5f3ff;">
                <div class="log-stat-value" style="color:#7c3aed;">{{ $logThisMonth ?? 0 }}</div>
                <div class="log-stat-label" style="color:#7c3aed;">This Month</div>
              </div>
              <div class="log-stat" style="background:#eff6ff;">
                <div class="log-stat-value" style="color:#2563eb;">{{ $logInfo ?? 0 }}</div>
                <div class="log-stat-label" style="color:#3b82f6;">Views</div>
              </div>
              <div class="log-stat" style="background:#fffbeb;">
                <div class="log-stat-value" style="color:#d97706;">{{ $logWarnings ?? 0 }}</div>
                <div class="log-stat-label" style="color:#f59e0b;">Logins</div>
              </div>
              <div class="log-stat" style="background:#f0fdf4;">
                <div class="log-stat-value" style="color:#16a34a;">{{ $logBackups ?? 0 }}</div>
                <div class="log-stat-label" style="color:#22c55e;">Backups</div>
              </div>
              <div class="log-stat" style="background:#fef2f2;">
                <div class="log-stat-value" style="color:var(--crimson);">{{ $logErrors ?? 0 }}</div>
                <div class="log-stat-label" style="color:#ef4444;">Errors</div>
              </div>
            </div>

            <!-- Table -->
            <div style="overflow-x:auto;">
              <table class="data-table">
                <thead>
                  <tr>
                    <th style="width:60px;">ID</th>
                    <th style="width:160px;">Date & Time</th>
                    <th>Description</th>
                    <th style="width:120px;">User</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($recentLogs ?? [] as $log)
                  @php
                    $logId         = data_get($log, 'id', '—');
                    $logDate       = data_get($log, 'created_at');
                    $logDesc       = data_get($log, 'description', 'No description provided.');
                    $logActor      = data_get($log, 'actor_identifier', '—');
                    $logRole       = data_get($log, 'actor_role', '');
                  @endphp
                  <tr>
                    <td style="color:#9ca3af;font-size:.72rem;">#{{ $logId }}</td>
                    <td>
                      <div style="font-size:.74rem;font-weight:600;color:#374151;">
                        {{ $logDate ? \Carbon\Carbon::parse($logDate)->format('M j, Y') : '—' }}
                      </div>
                      <div style="font-size:.68rem;color:#9ca3af;">
                        {{ $logDate ? \Carbon\Carbon::parse($logDate)->format('h:i:s A') : '—' }}
                      </div>
                    </td>
                    <td style="font-size:.76rem;">{{ $logDesc }}</td>
                    <td>
                      <span style="font-size:.72rem;font-weight:600;color:#4a5568;">{{ $logActor }}</span>
                      <div style="font-size:.65rem;color:#9ca3af;text-transform:capitalize;">{{ $logRole }}</div>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="4">
                      <div class="empty-state">
                        <div class="empty-icon"><i class="fa-solid fa-inbox"></i></div>
                        <p style="font-size:.82rem;font-weight:700;color:#6b7280;margin-bottom:.25rem;">No logs yet</p>
                        <p style="font-size:.72rem;color:#b0b7c3;">System activity will appear here</p>
                      </div>
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>

          <!-- Bottom row: GAD + Inventory -->
          <div class="bottom-grid">
            <div class="card">
              <div class="card-header">
                <div class="card-header-left">
                  <div class="card-header-icon"><i class="fa-solid fa-chart-pie"></i></div>
                  <span class="card-title">GAD Analytics</span>
                </div>
                <a href="#" class="card-link">View <i class="fa-solid fa-arrow-right" style="font-size:.65rem;"></i></a>
              </div>
              <div style="padding:1.25rem;">
                <div
                  style="height:140px;border-radius:10px;border:2px dashed #e5e7eb;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#fafafa,#fff);">
                  <div style="text-align:center;">
                    <i class="fa-solid fa-chart-area"
                      style="font-size:2rem;color:#e5e7eb;display:block;margin-bottom:.5rem;"></i>
                    <span style="font-size:.72rem;color:#b0b7c3;font-weight:600;">Chart coming soon</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <div class="card-header-left">
                  <div class="card-header-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                  <span class="card-title">Inventory</span>
                </div>
                <a href="#" class="card-link">View <i class="fa-solid fa-arrow-right" style="font-size:.65rem;"></i></a>
              </div>
              <div style="padding:1.25rem;">
                <div
                  style="height:140px;border-radius:10px;border:2px dashed #e5e7eb;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#fafafa,#fff);">
                  <div style="text-align:center;">
                    <i class="fa-solid fa-box"
                      style="font-size:2rem;color:#e5e7eb;display:block;margin-bottom:.5rem;"></i>
                    <span style="font-size:.72rem;color:#b0b7c3;font-weight:600;">Coming soon</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- RIGHT COLUMN -->
        <div style="display:flex;flex-direction:column;gap:1.25rem;">

          <!-- Quick Actions -->
          <div class="card">
            <div class="card-header">
              <div class="card-header-left">
                <div class="card-header-icon"><i class="fa-solid fa-bolt"></i></div>
                <span class="card-title">Quick Actions</span>
              </div>
            </div>
            <div style="padding:1rem;">
              <button class="qa-btn">
                <div class="qa-icon"><i class="fa-solid fa-file-circle-plus"></i></div>
                <div class="qa-text">
                  <span class="qa-title">New Template</span>
                  <span class="qa-sub">Create document format</span>
                </div>
                <i class="fa-solid fa-chevron-right qa-arrow"></i>
              </button>
              <button class="qa-btn">
                <div class="qa-icon"><i class="fa-solid fa-file-invoice"></i></div>
                <div class="qa-text">
                  <span class="qa-title">Generate Report</span>
                  <span class="qa-sub">Create report documents</span>
                </div>
                <i class="fa-solid fa-chevron-right qa-arrow"></i>
              </button>
              <button class="qa-btn">
                <div class="qa-icon"><i class="fa-solid fa-chart-column"></i></div>
                <div class="qa-text">
                  <span class="qa-title">View Reports</span>
                  <span class="qa-sub">All reports & analytics</span>
                </div>
                <i class="fa-solid fa-chevron-right qa-arrow"></i>
              </button>
              <a href="{{ route('admin.user_management') }}" class="qa-btn">
                <div class="qa-icon"><i class="fa-solid fa-user-plus"></i></div>
                <div class="qa-text">
                  <span class="qa-title">Add User</span>
                  <span class="qa-sub">Register new account</span>
                </div>
                <i class="fa-solid fa-chevron-right qa-arrow"></i>
              </a>
            </div>
          </div>

          <!-- Data Backup -->
          <div class="card">
            <div class="card-header">
              <div class="card-header-left">
                <div class="card-header-icon"><i class="fa-solid fa-database"></i></div>
                <span class="card-title">Data Backup</span>
              </div>
              <span
                style="font-size:.65rem;font-weight:700;background:#f0fdf4;color:#16a34a;padding:.25rem .6rem;border-radius:20px;border:1px solid #bbf7d0;">Healthy</span>
            </div>
            <div style="padding:1rem;">
              <div class="backup-status">
                <div class="backup-check"><i class="fa-solid fa-check"></i></div>
                <div>
                  <span class="backup-label">Last Backup</span>
                  <span class="backup-date">December 25, 2025</span>
                  <span class="backup-sub">✓ Completed successfully</span>
                </div>
              </div>
              <div class="next-backup">
                <i class="fa-regular fa-clock next-icon"></i>
                <div>
                  <div class="next-label">Next Scheduled</div>
                  <div class="next-date">March 30, 2026</div>
                </div>
              </div>
              <button class="run-backup-btn">
                <i class="fa-solid fa-database"></i>
                Run Backup Now
              </button>
            </div>
          </div>

        </div>
      </div><!-- /main-grid -->

    </div><!-- /content-lift -->
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

  @if(session('activeAppointmentModal'))
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var modal = document.getElementById("activeAppointmentModal");
      var closeBtn = document.getElementById("closeActiveApptModalBtn");
      if (!modal) return;
      modal.showModal();
      modal.addEventListener('click', function (e) { var box = modal.querySelector('.modal-box'); if (box && !box.contains(e.target)) e.preventDefault(); });
      modal.addEventListener('cancel', function (e) { e.preventDefault(); });
      if (closeBtn) closeBtn.addEventListener("click", function () { modal.close(); });
    });
  </script>
  @endif

  @if (session('login_as'))
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      showToast('Login Successful', 'Logged in successfully as <strong>{{ session("login_as") }}</strong>', 'success');
    });
  </script>
  @endif

  <script>
    /* TERMS */
    document.addEventListener('DOMContentLoaded', function () {
      const termsModal = document.getElementById('termsModal');
      const termsCheckbox = document.getElementById('termsCheckbox');
      const termsContinueBtn = document.getElementById('termsContinueBtn');
      if (termsCheckbox && termsContinueBtn) {
        termsCheckbox.checked = false;
        termsContinueBtn.disabled = true;
        termsCheckbox.addEventListener('change', function () { termsContinueBtn.disabled = !this.checked; });
      }
      @if (session('show_terms_modal'))
        if (termsModal) termsModal.showModal();
      @endif
    });
    function acceptTerms() {
      const m = document.getElementById('termsModal');
      if (m) m.close();
    }

    /* TOAST */
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

    /* DATE */
    document.addEventListener('DOMContentLoaded', function () {
    const dateEl = document.getElementById('currentDate');
    const dateIconEl = document.getElementById('currentDateIcon');

    if (!dateEl) return;

    function updateDateTime() {
      const now = new Date();

      const dateText = now.toLocaleDateString('en-US', {
        timeZone: 'Asia/Manila',
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });

      const timeText = now.toLocaleTimeString('en-US', {
        timeZone: 'Asia/Manila',
        hour: 'numeric',
        minute: '2-digit',
        hour12: true
      });

      dateEl.textContent = dateText + ' | ' + timeText;

      if (dateIconEl) {
        const hourInManila = Number(new Intl.DateTimeFormat('en-US', {
          timeZone: 'Asia/Manila',
          hour: 'numeric',
          hour12: false
        }).format(now));

        if (hourInManila >= 5 && hourInManila < 12) {
          dateIconEl.className = 'fa-solid fa-sun';
          dateIconEl.style.color = '#fcd34d';
        } else if (hourInManila >= 12 && hourInManila < 18) {
          dateIconEl.className = 'fa-solid fa-sun';
          dateIconEl.style.color = '#fb923c';
        } else {
          dateIconEl.className = 'fa-solid fa-moon';
          dateIconEl.style.color = '#c4b5fd';
        }
      }
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);
  });

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

    /* THEME */
    const html = document.documentElement;
    function applyTheme(theme) {
      html.setAttribute('data-theme', theme);
      localStorage.setItem('theme', theme);
      document.querySelectorAll('.theme-option').forEach(o =>
        o.getAttribute('data-theme') === theme ? o.classList.add('active') : o.classList.remove('active')
      );
      document.querySelectorAll('.theme-indicator').forEach(ind =>
        theme === 'dark' ? ind.classList.add('dark-mode') : ind.classList.remove('dark-mode')
      );
    }
    document.addEventListener('DOMContentLoaded', () => {
      applyTheme(localStorage.getItem('theme') || 'light');
      document.querySelectorAll('.theme-option').forEach(o =>
        o.addEventListener('click', e => { e.stopPropagation(); applyTheme(o.getAttribute('data-theme')); })
      );
    });

    /* MOBILE DRAWER */
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
  </script>

</body>

</html>