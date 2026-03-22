<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document Requests | PUP Taguig Dental Clinic</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            daisyui: {
                themes: false
            }
        };
    </script>

    <style>
        :root {
            --crimson: #8B0000;
            --crimson-dark: #6b0000;
            --crimson-light: #fef2f2;
            --header-h: 64px;
            --sidebar-w: 256px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f5f5;
            color: #333333;
            overflow-x: hidden;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
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
            box-shadow: 0 1px 0 rgba(255,255,255,.08), 0 4px 24px rgba(139,0,0,.3);
        }

        .header-left,
        .header-right {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .header-logo {
            width: 34px;
            height: 34px;
            object-fit: contain;
        }

        .header-divider {
            width: 1px;
            height: 28px;
            background: rgba(255,255,255,.2);
        }

        .header-title {
            font-size: .85rem;
            font-weight: 700;
            color: #fff;
            text-transform: uppercase;
        }

        .hdr-icon-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.12);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: .15s ease;
            position: relative;
        }

        .hdr-icon-btn:hover {
            background: rgba(255,255,255,.2);
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
        }

        .header-user-btn {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .35rem .75rem .35rem .35rem;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 40px;
            cursor: pointer;
        }

        .header-avatar,
        .user-menu-avatar,
        .drawer-avatar {
            border-radius: 50%;
            object-fit: cover;
        }

        .header-avatar {
            width: 30px;
            height: 30px;
            border: 2px solid rgba(255,255,255,.4);
        }

        .header-name {
            font-size: .78rem;
            font-weight: 700;
            color: #fff;
        }

        .header-role {
            font-size: .64rem;
            color: rgba(255,255,255,.65);
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
            border-radius: 14px;
            box-shadow: 0 12px 40px rgba(0,0,0,.15), 0 0 0 1px rgba(0,0,0,.06);
            opacity: 0;
            transform: scale(.95) translateY(-8px);
            pointer-events: none;
            transition: all .2s cubic-bezier(.4,0,.2,1);
            transform-origin: top right;
            z-index: 100;
            overflow: hidden;
        }

        #notifMenu {
            width: 320px;
        }

        #userMenu {
            width: 210px;
        }

        #notifMenu.open,
        #userMenu.open {
            opacity: 1;
            transform: scale(1) translateY(0);
            pointer-events: auto;
        }

        .notif-header,
        .user-menu-header {
            padding: .85rem 1rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .notif-header {
            font-weight: 800;
            color: var(--crimson);
            font-size: .8rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .user-menu-header {
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .user-menu-avatar {
            width: 32px;
            height: 32px;
            border: 2px solid #e5e7eb;
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
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .user-menu-item:hover {
            background: #f9fafb;
        }

        .user-menu-item.danger {
            color: #ef4444;
        }

        .user-menu-item.danger:hover {
            background: #fef2f2;
        }

        .user-menu-sep {
            height: 1px;
            background: #f3f4f6;
        }

        #sidebar {
            position: fixed;
            left: 0;
            top: var(--header-h);
            width: var(--sidebar-w);
            height: calc(100vh - var(--header-h));
            background: #fff;
            border-right: 1px solid #eff0f2;
            box-shadow: 4px 0 24px rgba(0,0,0,.04);
            z-index: 40;
            display: flex;
            flex-direction: column;
        }

        .sidebar-inner {
            flex: 1;
            overflow-y: auto;
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

        .group-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 10px;
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
        }

        .active-group .group-icon-wrap {
            background: var(--crimson);
            color: #fff;
        }

        .group-label {
            font-size: .7rem;
            font-weight: 800;
            color: var(--crimson);
            text-transform: uppercase;
        }

        .group-sublabel {
            font-size: .62rem;
            color: #adb5bd;
        }

        .group-body {
            padding: 2px 0 6px;
        }

        .nav-link,
        .drawer-link {
            display: flex;
            align-items: center;
            gap: 9px;
            text-decoration: none;
            transition: .15s ease;
        }

        .nav-link {
            padding: 7px 10px 7px 42px;
            border-radius: 9px;
            margin: 1px 2px;
            font-size: .76rem;
            color: #4a5568;
        }

        .nav-link:hover {
            background: var(--crimson-light);
            color: var(--crimson);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--crimson) 0%, var(--crimson-dark) 100%);
            color: #fff;
            font-weight: 600;
        }

        .nav-sep {
            height: 1px;
            background: #f3f4f6;
            margin: 10px 6px;
        }

        .sidebar-bottom {
            padding: 10px 10px 14px;
            border-top: 1px solid #f3f4f6;
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
            box-shadow: 0 2px 8px rgba(0,0,0,.1);
            transition: all .3s cubic-bezier(.4,0,.2,1);
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
            margin-top: 6px;
        }

        .logout-btn:hover {
            background: #fef2f2;
        }

        #mainContent,
        #siteFooter {
            margin-left: var(--sidebar-w);
        }

        .pg-title {
            font-size: 2rem;
            font-weight: 800;
            color: #8B0000;
            letter-spacing: -.02em;
        }

        .pg-subtitle {
            font-size: .85rem;
            color: #9ca3af;
            margin-top: .25rem;
        }

        .kpi-strip {
            display: flex;
            gap: 1px;
            background: #f0eaea;
            border: 1px solid #f0eaea;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .kpi-item {
            flex: 1;
            min-width: 140px;
            background: #fff;
            padding: 1rem 1.25rem;
        }

        .kpi-val {
            font-size: 1.5rem;
            font-weight: 800;
            color: #111;
            line-height: 1;
        }

        .kpi-lbl {
            font-size: .68rem;
            color: #9ca3af;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-top: .15rem;
        }

        .toolbar {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 1.25rem;
            flex-wrap: wrap;
        }

        .search-wrap {
            position: relative;
            flex: 1;
            min-width: 200px;
            max-width: 300px;
        }

        .search-wrap i {
            position: absolute;
            left: .75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #d1d5db;
            font-size: .78rem;
        }

        .search-wrap input {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            padding: .5rem .75rem .5rem 2.2rem;
            font-size: .82rem;
            background: #fff;
            outline: none;
        }

        .search-wrap input:focus,
        .form-sel-sm:focus {
            border-color: #8B0000;
            box-shadow: 0 0 0 3px rgba(139,0,0,.08);
        }

        .form-sel-sm {
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            padding: .5rem .75rem;
            font-size: .82rem;
            background: #fff;
            outline: none;
        }

        .btn-primary,
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            border-radius: 8px;
            font-size: .82rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: .15s ease;
        }

        .btn-primary {
            padding: .52rem 1.1rem;
            border: none;
            background: #8B0000;
            color: #fff;
        }

        .btn-primary:hover {
            background: #6b0000;
        }

        .btn-secondary {
            padding: .5rem 1rem;
            background: #fff;
            color: #374151;
            border: 1.5px solid #e5e7eb;
        }

        .btn-secondary:hover {
            background: #f9fafb;
        }

        .tbl-wrap {
            background: #fff;
            border: 1px solid #f0eaea;
            border-radius: 14px;
            overflow: hidden;
        }

        .tbl {
            width: 100%;
            border-collapse: collapse;
        }

        .tbl th {
            padding: .7rem 1rem;
            font-size: .67rem;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .08em;
            text-align: left;
            background: #fafafa;
            border-bottom: 1px solid #f3f4f6;
            white-space: nowrap;
        }

        .tbl td {
            padding: .9rem 1rem;
            font-size: .8rem;
            color: #374151;
            border-bottom: 1px solid #f8f5f5;
            vertical-align: middle;
        }

        .tbl tbody tr:last-child td {
            border-bottom: none;
        }

        .tbl tbody tr:hover td {
            background: #fffafa;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #9ca3af;
        }

        .empty-state i {
            font-size: 2.5rem;
            display: block;
            margin-bottom: 1rem;
            color: #e5e7eb;
        }

        .tbl-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .85rem 1.25rem;
            border-top: 1px solid #f3f4f6;
            background: #fafafa;
            font-size: .78rem;
            color: #9ca3af;
            flex-wrap: wrap;
            gap: .5rem;
        }

        .act-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: .7rem;
            transition: .12s ease;
        }

        .act-btn.view {
            background: #fef2f2;
            color: #8B0000;
        }

        .act-btn.view:hover {
            background: #8B0000;
            color: #fff;
        }

        .act-btn.tog-on {
            background: #f0fdf4;
            color: #166534;
        }

        .act-btn.tog-on:hover {
            background: #166534;
            color: #fff;
        }

        .act-btn.del {
            background: transparent;
            color: #dc2626;
        }

        .act-btn.del:hover {
            background: #fef2f2;
        }

        #siteFooter {
            background: var(--crimson);
            color: rgba(255,255,255,.8);
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
            color: rgba(255,255,255,.7);
            text-decoration: none;
        }

        .footer-inner a:hover {
            color: #fff;
        }

        .footer-dot {
            color: rgba(255,255,255,.3);
        }

        #toastContainer {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }

        #toastContainer .toast {
            min-width: 300px;
            max-width: 360px;
            background: white;
            border-radius: 14px;
            box-shadow: 0 10px 40px rgba(0,0,0,.18);
            padding: 14px 18px 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            opacity: 0;
            transform: translateX(340px);
            transition: all .35s cubic-bezier(.68,-.55,.265,1.55);
            position: relative;
            overflow: hidden;
            pointer-events: all;
        }

        #toastContainer .toast::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
        }

        #toastContainer .toast.error::before {
            background: #8B0000;
        }

        #toastContainer .toast.success::before {
            background: #15803d;
        }

        #toastContainer .toast.show {
            opacity: 1;
            transform: translateX(0);
        }

        #toastContainer .toast.hide {
            opacity: 0;
            transform: translateX(340px);
        }

        .toast-icon-wrap {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .toast.error .toast-icon-wrap {
            background: rgba(139,0,0,.08);
        }

        .toast.success .toast-icon-wrap {
            background: rgba(21,128,61,.08);
        }

        .toast-icon {
            font-size: 17px;
        }

        .toast.error .toast-icon {
            color: #8B0000;
        }

        .toast.success .toast-icon {
            color: #15803d;
        }

        .toast-body {
            flex: 1;
            min-width: 0;
        }

        .toast-title {
            font-size: 13px;
            font-weight: 700;
            color: #1A0A0A;
        }

        .toast-msg {
            font-size: 12px;
            color: #888;
            margin-top: 2px;
            line-height: 1.4;
        }

        .toast-close {
            background: none;
            border: none;
            cursor: pointer;
            color: #CCC;
            font-size: 13px;
            flex-shrink: 0;
            padding: 2px 4px;
        }

        #mobileMenuBtn {
            display: none;
            background: rgba(255,255,255,.12);
            border: none;
            color: #fff;
            width: 36px;
            height: 36px;
            border-radius: 9px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        #mobileDrawerOverlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 998;
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
            transition: transform .3s cubic-bezier(.4,0,.2,1);
            box-shadow: 4px 0 32px rgba(0,0,0,.15);
            overflow: hidden;
        }

        #mobileDrawer.open {
            transform: translateX(0);
        }

        .drawer-header {
            background: linear-gradient(135deg, #6b0000 0%, #8B0000 100%);
            padding: 20px 18px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
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
        }

        .drawer-subtitle {
            font-size: .75rem;
            color: #F4F4F4;
            font-weight: 600;
        }

        .drawer-close {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(255,255,255,.15);
            border: none;
            color: #fff;
            cursor: pointer;
        }

        .drawer-user {
            padding: 14px 18px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fdf9f9;
        }

        .drawer-avatar {
            width: 38px;
            height: 38px;
            border: 2px solid #e5e7eb;
        }

        .drawer-user-name {
            font-size: .82rem;
            font-weight: 700;
            color: #1f2937;
        }

        .drawer-user-role {
            font-size: .68rem;
            color: #9ca3af;
            font-style: italic;
        }

        .drawer-inner {
            flex: 1;
            overflow-y: auto;
            padding: 10px 0 6px;
        }

        .drawer-group {
            margin: 0 8px 2px;
        }

        .drawer-group-header {
            display: flex;
            align-items: center;
            padding: 6px 8px 4px;
            color: #6b7280;
        }

        .drawer-group-icon {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: #8B0000;
        }

        .drawer-group-label {
            font-size: .68rem;
            font-weight: 700;
            color: #8B0000;
            text-transform: uppercase;
            letter-spacing: .07em;
            margin-left: 8px;
        }

        .drawer-link {
            padding: 8px 10px 8px 40px;
            border-radius: 8px;
            margin: 1px 4px;
            font-size: .78rem;
            color: #374151;
        }

        .drawer-link:hover {
            background: #fef2f2;
            color: #8B0000;
        }

        .drawer-link.active {
            background: #8B0000;
            color: #fff;
        }

        .drawer-sep {
            height: 1px;
            background: #f3f4f6;
            margin: 6px 12px;
        }

        .drawer-bottom {
            padding: 10px 12px 14px;
            border-top: 1px solid #f3f4f6;
        }

        [data-theme="dark"] body {
            background: #000D1A;
            color: #E5E7EB;
        }

        [data-theme="dark"] #sidebar,
        [data-theme="dark"] #mobileDrawer,
        [data-theme="dark"] #userMenu,
        [data-theme="dark"] #notifMenu,
        [data-theme="dark"] .tbl-wrap,
        [data-theme="dark"] .kpi-item,
        [data-theme="dark"] [style*="background:#fff"] {
            background: #161b22 !important;
            border-color: #21262d !important;
        }

        [data-theme="dark"] .tbl th,
        [data-theme="dark"] .tbl-pagination,
        [data-theme="dark"] [style*="background:#fafafa"] {
            background: #0d1117 !important;
            border-color: #21262d !important;
        }

        [data-theme="dark"] .tbl td,
        [data-theme="dark"] .nav-link,
        [data-theme="dark"] .drawer-link,
        [data-theme="dark"] .user-menu-item,
        [data-theme="dark"] .search-wrap input,
        [data-theme="dark"] .form-sel-sm,
        [data-theme="dark"] textarea {
            color: #d1d5db !important;
        }

        [data-theme="dark"] .search-wrap input,
        [data-theme="dark"] .form-sel-sm,
        [data-theme="dark"] textarea,
        [data-theme="dark"] .btn-secondary {
            background: #161b22 !important;
            border-color: #30363d !important;
        }

        [data-theme="dark"] .theme-toggle-container {
            background: #1F1F1F;
            border-color: #2A2A2A;
        }

        [data-theme="dark"] .theme-option.active {
            color: #F3F4F6;
        }

        [data-theme="dark"] .theme-indicator {
            background: #2A2A2A;
        }

        [data-theme="dark"] .nav-sep,
        [data-theme="dark"] .sidebar-bottom,
        [data-theme="dark"] .drawer-sep,
        [data-theme="dark"] .drawer-bottom,
        [data-theme="dark"] .drawer-user,
        [data-theme="dark"] .user-menu-header,
        [data-theme="dark"] .user-menu-sep {
            border-color: #21262d !important;
            background: #161b22 !important;
        }

        [data-theme="dark"] .pg-title,
        [data-theme="dark"] .kpi-val,
        [data-theme="dark"] .text-gray-800 {
            color: #f3f4f6 !important;
        }

        [data-theme="dark"] .pg-subtitle,
        [data-theme="dark"] .kpi-lbl,
        [data-theme="dark"] .text-gray-400,
        [data-theme="dark"] .text-gray-500 {
            color: #9ca3af !important;
        }

        [data-theme="dark"] .tbl tbody tr:hover td {
            background: #1c2128 !important;
        }

        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr !important;
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
    </style>
</head>

<body>
    <div id="toastContainer" role="region" aria-live="polite"></div>

    <header class="header">
        <div class="header-left">
            <button id="mobileMenuBtn" aria-label="Open menu">
                <i class="fa-solid fa-bars"></i>
            </button>
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
                    @if($notifCount > 0)
                        <span class="notif-badge">{{ $notifCount }}</span>
                    @endif
                </button>

                <div id="notifMenu">
                    <div class="notif-header">
                        <i class="fa-solid fa-bell text-xs"></i>
                        Notifications
                    </div>

                    <div style="max-height:260px;overflow-y:auto;">
                        @forelse($notifications as $n)
                            <a href="{{ $n['url'] ?? '#' }}"
                               style="display:block;padding:.65rem 1rem;font-size:.76rem;color:#333;text-decoration:none;border-bottom:1px solid #fdf5f5;"
                               onmouseover="this.style.background='#fef2f2'"
                               onmouseout="this.style.background=''">
                                <div style="font-weight:700;">{{ $n['title'] ?? 'Notification' }}</div>
                                @if(!empty($n['message']))
                                    <div style="color:#aaa;margin-top:2px;font-size:.7rem;">
                                        {{ $n['message'] }}
                                    </div>
                                @endif
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

            <a href="{{ route('admin.system_settings') }}" class="hdr-icon-btn" aria-label="Settings">
                <i class="fa-solid fa-gear"></i>
            </a>

            <div id="userDropdown">
                <div class="header-user-btn" id="userBtn">
                    <img src="https://i.pravatar.cc/40" class="header-avatar" alt="Avatar">
                    <div>
                        <div class="header-name">Admin</div>
                        <div class="header-role">Administrator</div>
                    </div>
                    <i class="fa-solid fa-chevron-down" style="color:rgba(255,255,255,.5);font-size:.6rem;"></i>
                </div>

                <div id="userMenu">
                    <div class="user-menu-header">
                        <img src="https://i.pravatar.cc/40" class="user-menu-avatar" alt="Avatar">
                        <div>
                            <div class="user-menu-name">Admin</div>
                            <div class="user-menu-role">Administrator</div>
                        </div>
                    </div>

                    <div style="padding:.5rem .75rem;border-bottom:1px solid #f3f4f6;">
                        <div style="font-size:.6rem;font-weight:800;letter-spacing:.08em;color:#b0b7c3;text-transform:uppercase;margin-bottom:6px;">
                            Appearance
                        </div>
                        <div class="theme-toggle-container">
                            <button type="button" class="theme-option active" data-theme="light">
                                <i class="fa-solid fa-sun"></i>
                            </button>
                            <button type="button" class="theme-option" data-theme="dark">
                                <i class="fa-regular fa-moon"></i>
                            </button>
                            <div class="theme-indicator" aria-hidden="true"></div>
                        </div>
                    </div>

                    <div class="user-menu-sep"></div>

                    <form method="POST" action="{{ route('logout') }}">
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

    <aside id="sidebar">
        <div class="sidebar-inner">
            <div class="nav-section-label">Clinic Management</div>
            <div class="nav-group">
                <div class="group-trigger {{ request()->routeIs('admin.admin.dashboard') ? 'active-group' : '' }}">
                    <div class="group-icon-wrap"><i class="fa-solid fa-hospital"></i></div>
                    <div>
                        <span class="group-label">Clinic</span>
                        <span class="group-sublabel">Core clinical modules</span>
                    </div>
                </div>

                <div class="group-body">
                    <a href="{{ route('admin.admin.dashboard') }}"
                       class="nav-link {{ request()->routeIs('admin.admin.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-line"></i> Dashboard
                    </a>

                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-users"></i> Patients
                    </a>

                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-calendar-check"></i> Appointments
                    </a>

                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-tooth"></i> Dental Records
                    </a>

                    <a href="{{ route('admin.document-requests.index') }}"
                       class="nav-link {{ request()->routeIs('admin.document-requests*') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-circle-check"></i> Document Request
                    </a>

                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-file"></i> Reports
                    </a>
                </div>
            </div>

            <div class="nav-sep"></div>

            <div class="nav-section-label">Maintenance</div>
            <div class="nav-group">
                <div class="group-trigger {{ request()->routeIs('admin.user_management*','admin.role_permissions','admin.academic_periods*','admin.clinic_schedule*') ? 'active-group' : '' }}">
                    <div class="group-icon-wrap"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                    <div>
                        <span class="group-label">Configuration</span>
                        <span class="group-sublabel">Settings & scheduling</span>
                    </div>
                </div>

                <div class="group-body">
                    <a href="{{ route('admin.user_management') }}" class="nav-link {{ request()->routeIs('admin.user_management*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-gear"></i> User Management
                    </a>

                    <a href="{{ route('admin.role_permissions') }}" class="nav-link {{ request()->routeIs('admin.role_permissions') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-shield"></i> Roles & Permissions
                    </a>

                    <a href="{{ route('admin.academic_periods') }}" class="nav-link {{ request()->routeIs('admin.academic_periods*') ? 'active' : '' }}">
                        <i class="fa-solid fa-school"></i> Academic Periods
                    </a>

                    <a href="{{ route('admin.clinic_schedule') }}" class="nav-link {{ request()->routeIs('admin.clinic_schedule*') ? 'active' : '' }}">
                        <i class="fa-solid fa-calendar-days"></i> Clinic Schedule
                    </a>

                    <a href="{{ route('admin.service-types') }}" class="nav-link {{ request()->routeIs('admin.service-types*') ? 'active' : '' }}">
                        <i class="fa-solid fa-list-check"></i> Service Types
                    </a>

                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-file-pen"></i> Document Templates
                    </a>

                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-boxes-stacked"></i> Inventory
                    </a>
                </div>
            </div>

            <div class="nav-sep"></div>

            <div class="nav-section-label">System</div>
            <div class="nav-group">
                <div class="group-trigger {{ request()->routeIs('admin.system_logs','admin.system_settings*') ? 'active-group' : '' }}">
                    <div class="group-icon-wrap"><i class="fa-solid fa-server"></i></div>
                    <div>
                        <span class="group-label">System</span>
                        <span class="group-sublabel">Admin & configuration</span>
                    </div>
                </div>

                <div class="group-body">
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-database"></i> Data Backup
                    </a>

                    <a href="{{ route('admin.system_logs') }}" class="nav-link {{ request()->routeIs('admin.system_logs') ? 'active' : '' }}">
                        <i class="fa-solid fa-clipboard-list"></i> System Logs
                    </a>

                    <a href="{{ route('admin.system_settings') }}" class="nav-link {{ request()->routeIs('admin.system_settings*') ? 'active' : '' }}">
                        <i class="fa-solid fa-sliders"></i> System Settings
                    </a>
                </div>
            </div>
        </div>

        <div class="sidebar-bottom">
            <div class="theme-toggle-container">
                <button type="button" class="theme-option active" data-theme="light">
                    <i class="fa-solid fa-sun"></i>
                </button>
                <button type="button" class="theme-option" data-theme="dark">
                    <i class="fa-regular fa-moon"></i>
                </button>
                <div class="theme-indicator" aria-hidden="true"></div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <span class="logout-icon">
                        <i class="fa-solid fa-right-from-bracket" style="color:#ef4444;"></i>
                    </span>
                    <span>Log out</span>
                </button>
            </form>
        </div>
    </aside>

    <div id="mobileDrawerOverlay" onclick="closeDrawer()"></div>

    <div id="mobileDrawer">
        <div class="drawer-header">
            <div class="drawer-header-left">
                <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="drawer-logo" alt="DMS">
                <div>
                    <div class="drawer-title">PUP TAGUIG</div>
                    <div class="drawer-subtitle">Dental Clinic</div>
                </div>
            </div>
            <button class="drawer-close" onclick="closeDrawer()">
                <i class="fa-solid fa-xmark"></i>
            </button>
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
                <div class="drawer-group-header">
                    <div class="drawer-group-icon"><i class="fa-solid fa-hospital"></i></div>
                    <span class="drawer-group-label">Clinic Management</span>
                </div>

                <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link {{ request()->routeIs('admin.admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line"></i> Dashboard
                </a>

                <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link">
                    <i class="fa-solid fa-users"></i> Patients
                </a>

                <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link">
                    <i class="fa-solid fa-calendar-check"></i> Appointments
                </a>

                <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link">
                    <i class="fa-solid fa-tooth"></i> Dental Records
                </a>

                <a href="{{ route('admin.document-requests.index') }}" class="drawer-link {{ request()->routeIs('admin.document-requests*') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-circle-check"></i> Document Request
                </a>

                <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link">
                    <i class="fa-solid fa-file"></i> Reports
                </a>
            </div>

            <div class="drawer-sep"></div>

            <div class="drawer-group">
                <div class="drawer-group-header">
                    <div class="drawer-group-icon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                    <span class="drawer-group-label">Maintenance</span>
                </div>

                <a href="{{ route('admin.user_management') }}" class="drawer-link {{ request()->routeIs('admin.user_management*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-gear"></i> User Management
                </a>

                <a href="{{ route('admin.role_permissions') }}" class="drawer-link {{ request()->routeIs('admin.role_permissions') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-shield"></i> Roles & Permissions
                </a>

                <a href="{{ route('admin.academic_periods') }}" class="drawer-link {{ request()->routeIs('admin.academic_periods*') ? 'active' : '' }}">
                    <i class="fa-solid fa-school"></i> Academic Periods
                </a>

                <a href="{{ route('admin.clinic_schedule') }}" class="drawer-link {{ request()->routeIs('admin.clinic_schedule*') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-days"></i> Clinic Schedule
                </a>

                <a href="{{ route('admin.service-types') }}" class="drawer-link {{ request()->routeIs('admin.service-types*') ? 'active' : '' }}">
                    <i class="fa-solid fa-list-check"></i> Service Types
                </a>

                <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link">
                    <i class="fa-solid fa-file-pen"></i> Document Templates
                </a>

                <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link">
                    <i class="fa-solid fa-boxes-stacked"></i> Inventory
                </a>
            </div>

            <div class="drawer-sep"></div>

            <div class="drawer-group">
                <div class="drawer-group-header">
                    <div class="drawer-group-icon"><i class="fa-solid fa-server"></i></div>
                    <span class="drawer-group-label">System</span>
                </div>

                <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link">
                    <i class="fa-solid fa-database"></i> Data Backup
                </a>

                <a href="{{ route('admin.system_logs') }}" class="drawer-link {{ request()->routeIs('admin.system_logs') ? 'active' : '' }}">
                    <i class="fa-solid fa-clipboard-list"></i> System Logs
                </a>

                <a href="{{ route('admin.system_settings') }}" class="drawer-link {{ request()->routeIs('admin.system_settings*') ? 'active' : '' }}">
                    <i class="fa-solid fa-sliders"></i> System Settings
                </a>
            </div>
        </div>

        <div class="drawer-bottom">
            <div style="margin-bottom:10px;">
                <div class="theme-toggle-container">
                    <button type="button" class="theme-option active" data-theme="light">
                        <i class="fa-solid fa-sun"></i>
                    </button>
                    <button type="button" class="theme-option" data-theme="dark">
                        <i class="fa-regular fa-moon"></i>
                    </button>
                    <div class="theme-indicator" aria-hidden="true"></div>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn" style="font-size:.8rem;">
                    <span style="width:28px;height:28px;background:#fef2f2;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fa-solid fa-right-from-bracket text-xs"></i>
                    </span>
                    <span class="font-semibold">Log out</span>
                </button>
            </form>
        </div>
    </div>

    <main id="mainContent" style="padding-top:82px;padding-bottom:2rem;padding-left:1.5rem;padding-right:1.5rem;min-height:100vh;">
        <div style="max-width:1280px;margin:0 auto;">
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        showToast('Success', @json(session('success')), 'success');
                    });
                </script>
            @endif

            @if($errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        showToast('Error', @json($errors->first()), 'error');
                    });
                </script>
            @endif

            <div class="mb-6 flex items-start justify-between gap-4 flex-wrap">
                <div>
                    <h1 class="pg-title">Document Requests</h1>
                    <p class="pg-subtitle">Track and process patient requests for clinic documents.</p>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('admin.document-requests.export') }}" class="btn-secondary">
                        <i class="fa-solid fa-file-export text-xs"></i> Export CSV
                    </a>

                    <a href="{{ route('admin.document-requests.print-queue') }}" class="btn-primary">
                        <i class="fa-solid fa-print text-xs"></i> Print Queue
                    </a>
                </div>
            </div>

            <div class="kpi-strip">
                @foreach([
                    ['val' => $stats['total'], 'lbl' => 'Total', 'hi' => false],
                    ['val' => $stats['pending'], 'lbl' => 'Pending', 'hi' => true],
                    ['val' => $stats['approved'], 'lbl' => 'Approved', 'hi' => false],
                    ['val' => $stats['ready'], 'lbl' => 'Ready', 'hi' => false],
                    ['val' => $stats['released'], 'lbl' => 'Released', 'hi' => false],
                    ['val' => $stats['rejected'], 'lbl' => 'Rejected', 'hi' => false],
                ] as $s)
                    <div class="kpi-item" style="{{ $s['hi'] ? 'border-bottom:3px solid #8B0000;' : '' }}">
                        <div>
                            <div class="kpi-val" style="{{ $s['hi'] ? 'color:#8B0000;' : '' }}">{{ $s['val'] }}</div>
                            <div class="kpi-lbl">{{ $s['lbl'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <form method="GET" action="{{ route('admin.document-requests.index') }}" class="toolbar">
                <div class="search-wrap">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" placeholder="Patient name or request ID..." value="{{ request('search') }}">
                </div>

                <select name="status" class="form-sel-sm" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    @foreach(['pending','approved','ready','released','rejected'] as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>

                <select name="type" class="form-sel-sm" onchange="this.form.submit()">
                    <option value="">All Types</option>
                    @foreach($documentTypes as $type)
                        <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>
                            {{ ucwords(str_replace('_', ' ', $type)) }}
                        </option>
                    @endforeach
                </select>

                <select name="priority" class="form-sel-sm" onchange="this.form.submit()">
                    <option value="">All Priority</option>
                    @foreach(['high','normal','low'] as $priority)
                        <option value="{{ $priority }}" {{ request('priority') === $priority ? 'selected' : '' }}>
                            {{ ucfirst($priority) }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn-primary" style="margin-left:auto;">
                    <i class="fa-solid fa-filter text-xs"></i> Filter
                </button>
            </form>

            <div class="content-grid" style="display:grid;grid-template-columns:1fr 360px;gap:1.25rem;align-items:start;">
                <div class="tbl-wrap">
                    @if($requests->isEmpty())
                        <div class="empty-state">
                            <i class="fa-solid fa-inbox"></i>
                            <p class="font-semibold text-gray-500 mb-1">No requests found</p>
                            <p class="text-sm">Try adjusting your filters.</p>
                        </div>
                    @else
                        <div style="overflow-x:auto;">
                            <table class="tbl">
                                <thead>
                                    <tr>
                                        <th>Ref No.</th>
                                        <th>Patient</th>
                                        <th>Document</th>
                                        <th>Priority</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($requests as $req)
                                        @php
                                            $prioDot = ['high'=>'#ef4444','normal'=>'#f59e0b','low'=>'#94a3b8'];
                                            $prioTxt = ['high'=>'#ef4444','normal'=>'#b45309','low'=>'#94a3b8'];
                                            $sBg = ['pending'=>'#fef3c7','approved'=>'#d1fae5','ready'=>'#dbeafe','released'=>'#f0fdf4','rejected'=>'#fef2f2'];
                                            $sTx = ['pending'=>'#92400e','approved'=>'#065f46','ready'=>'#1e40af','released'=>'#166534','rejected'=>'#8B0000'];

                                            $patientName = $req->patient->full_name ?? 'Unknown Patient';
                                            $patientStudentId = $req->patient->student_id ?? 'No ID';
                                            $patientInitial = strtoupper(substr($patientName, 0, 1));
                                        @endphp

                                        <tr>
                                            <td>
                                                <span class="font-mono text-xs font-bold text-[#8B0000]">
                                                    {{ $req->reference_number }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class="flex items-center gap-2">
                                                    <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#8B0000,#6b0000);color:#fff;display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:700;flex-shrink:0;">
                                                        {{ $patientInitial }}
                                                    </div>
                                                    <div>
                                                        <div class="font-semibold text-gray-800 text-xs leading-tight">
                                                            {{ $patientName }}
                                                        </div>
                                                        <div class="text-[10px] text-gray-400">
                                                            {{ $patientStudentId }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <span style="background:#fef2f2;color:#8B0000;padding:.15rem .55rem;border-radius:5px;font-size:.68rem;font-weight:700;">
                                                    {{ ucwords(str_replace('_', ' ', $req->document_type)) }}
                                                </span>
                                            </td>

                                            <td>
                                                <span style="display:inline-flex;align-items:center;gap:.3rem;font-size:.72rem;font-weight:700;color:{{ $prioTxt[$req->priority] ?? '#94a3b8' }}">
                                                    <span style="width:5px;height:5px;border-radius:50%;background:{{ $prioDot[$req->priority] ?? '#94a3b8' }};display:inline-block;"></span>
                                                    {{ ucfirst($req->priority) }}
                                                </span>
                                            </td>

                                            <td class="text-xs text-gray-400 whitespace-nowrap">
                                                {{ $req->created_at->format('M d, Y') }}
                                            </td>

                                            <td>
                                                <span style="background:{{ $sBg[$req->status] ?? '#f3f4f6' }};color:{{ $sTx[$req->status] ?? '#6b7280' }};padding:.2rem .65rem;border-radius:999px;font-size:.68rem;font-weight:700;display:inline-block;">
                                                    {{ ucfirst($req->status) }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class="flex items-center gap-1">
                                                    <button type="button" class="act-btn view" onclick="openPanel({{ $req->id }})" title="View">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button>

                                                    @if($req->status === 'pending')
                                                        <form action="{{ route('admin.document-requests.approve', $req) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="act-btn tog-on" title="Approve">
                                                                <i class="fa-solid fa-check"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if(in_array($req->status, ['approved', 'ready']))
                                                        <form action="{{ route('admin.document-requests.release', $req) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="act-btn" style="background:#dbeafe;color:#1e40af;" title="Release">
                                                                <i class="fa-solid fa-paper-plane"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if(in_array($req->status, ['pending', 'approved']))
                                                        <form action="{{ route('admin.document-requests.reject', $req) }}" method="POST" style="display:inline;" onsubmit="return confirm('Reject this request?')">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="act-btn del" title="Reject">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($requests->hasPages())
                            <div class="tbl-pagination">
                                <span>
                                    Showing {{ $requests->firstItem() }}–{{ $requests->lastItem() }} of {{ $requests->total() }} requests
                                </span>
                                <div>{{ $requests->withQueryString()->links() }}</div>
                            </div>
                        @endif
                    @endif
                </div>

                <div style="background:#fff;border:1px solid #f0eaea;border-radius:14px;overflow:hidden;position:sticky;top:82px;">
                    <div style="padding:.9rem 1.25rem;border-bottom:1px solid #f3f4f6;background:#fafafa;display:flex;align-items:center;gap:.6rem;">
                        <div style="width:28px;height:28px;border-radius:7px;background:linear-gradient(135deg,#8B0000,#6b0000);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fa-solid fa-file-circle-check text-white" style="font-size:.7rem;"></i>
                        </div>
                        <div>
                            <div class="font-bold text-gray-800 text-sm" id="panelRefNo">Select a request</div>
                            <div class="text-[11px] text-gray-400">Document Request</div>
                        </div>
                    </div>

                    <div style="padding:1.25rem;" id="panelBody">
                        <div style="text-align:center;padding:2rem 0;color:#d1d5db;">
                            <i class="fa-solid fa-file-circle-check" style="font-size:2rem;display:block;margin-bottom:.75rem;"></i>
                            <p style="font-size:.78rem;">Click a row to view details</p>
                        </div>
                    </div>

                    <div id="panelFoot" style="padding:.9rem 1.25rem;border-top:1px solid #f3f4f6;background:#fafafa;display:none;gap:.5rem;flex-wrap:wrap;"></div>
                </div>
            </div>
        </div>
    </main>

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
        function showToast(title, message, type = 'error') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            const icon = type === 'error'
                ? '<i class="fa-solid fa-circle-exclamation toast-icon"></i>'
                : '<i class="fa-solid fa-circle-check toast-icon"></i>';

            toast.className = 'toast ' + type;
            toast.innerHTML = `
                <div class="toast-icon-wrap">${icon}</div>
                <div class="toast-body">
                    <div class="toast-title">${title}</div>
                    <div class="toast-msg">${message}</div>
                </div>
                <button class="toast-close" type="button">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;

            toast.querySelector('.toast-close').addEventListener('click', function () {
                toast.classList.add('hide');
                setTimeout(() => toast.remove(), 400);
            });

            container.appendChild(toast);

            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    toast.classList.add('show');
                });
            });

            setTimeout(() => {
                toast.classList.remove('show');
                toast.classList.add('hide');
                setTimeout(() => toast.remove(), 400);
            }, 4500);
        }

        const notifBtn = document.getElementById('notifBtn');
        const notifMenu = document.getElementById('notifMenu');
        const userBtn = document.getElementById('userBtn');
        const userMenu = document.getElementById('userMenu');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileDrawer = document.getElementById('mobileDrawer');
        const mobileDrawerOverlay = document.getElementById('mobileDrawerOverlay');
        const html = document.documentElement;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        notifBtn?.addEventListener('click', function (event) {
            event.stopPropagation();
            notifMenu.classList.toggle('open');
            userMenu.classList.remove('open');
        });

        userBtn?.addEventListener('click', function (event) {
            event.stopPropagation();
            userMenu.classList.toggle('open');
            notifMenu.classList.remove('open');
        });

        document.addEventListener('click', function () {
            notifMenu?.classList.remove('open');
            userMenu?.classList.remove('open');
        });

        function openDrawer() {
            mobileDrawerOverlay.style.display = 'block';
            requestAnimationFrame(() => {
                mobileDrawerOverlay.classList.add('open');
                mobileDrawer.classList.add('open');
            });
            document.body.style.overflow = 'hidden';
        }

        function closeDrawer() {
            mobileDrawer.classList.remove('open');
            mobileDrawerOverlay.classList.remove('open');

            setTimeout(() => {
                mobileDrawerOverlay.style.display = 'none';
            }, 250);

            document.body.style.overflow = '';
        }

        mobileMenuBtn?.addEventListener('click', function (event) {
            event.stopPropagation();
            openDrawer();
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeDrawer();
            }
        });

        function applyTheme(theme) {
            html.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);

            document.querySelectorAll('.theme-option').forEach(button => {
                button.classList.toggle('active', button.dataset.theme === theme);
            });

            document.querySelectorAll('.theme-indicator').forEach(indicator => {
                indicator.classList.toggle('dark-mode', theme === 'dark');
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            applyTheme(localStorage.getItem('theme') || 'light');

            document.querySelectorAll('.theme-option').forEach(button => {
                button.addEventListener('click', function (event) {
                    event.stopPropagation();
                    applyTheme(button.dataset.theme);
                });
            });
        });

        const statusBackground = {
            pending: '#fef3c7',
            approved: '#d1fae5',
            ready: '#dbeafe',
            released: '#f0fdf4',
            rejected: '#fef2f2'
        };

        const statusText = {
            pending: '#92400e',
            approved: '#065f46',
            ready: '#1e40af',
            released: '#166534',
            rejected: '#8B0000'
        };

        function detailRow(label, value) {
            return `
                <div style="display:flex;gap:.5rem;margin-bottom:.6rem;font-size:.8rem;">
                    <span style="color:#9ca3af;min-width:100px;flex-shrink:0;">${label}</span>
                    <span style="color:#111;font-weight:600;">${value}</span>
                </div>
            `;
        }

        async function openPanel(id) {
            const panelRefNo = document.getElementById('panelRefNo');
            const panelBody = document.getElementById('panelBody');
            const panelFoot = document.getElementById('panelFoot');

            panelRefNo.textContent = 'Loading...';
            panelBody.innerHTML = `
                <div style="text-align:center;padding:2rem 0;color:#d1d5db;">
                    <i class="fa-solid fa-spinner fa-spin" style="font-size:1.5rem;"></i>
                </div>
            `;
            panelFoot.style.display = 'none';
            panelFoot.innerHTML = '';

            try {
                const response = await fetch(`/admin/document-requests/${id}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to fetch request details.');
                }

                const data = await response.json();

                panelRefNo.textContent = data.reference_number;

                panelBody.innerHTML = `
                    <div style="background:#fef2f2;border-radius:10px;padding:.9rem 1rem;margin-bottom:1rem;display:flex;align-items:center;gap:.75rem;border:1px solid #fce8e8;">
                        <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#8B0000,#6b0000);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">
                            ${((data.patient_name || '?')[0] || '?').toUpperCase()}
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:.84rem;font-weight:700;color:#111;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                ${data.patient_name || '—'}
                            </div>
                            <div style="font-size:.7rem;color:#9ca3af;">
                                ${data.patient_id || ''}
                            </div>
                        </div>
                        <span style="background:${statusBackground[data.status] || '#f3f4f6'};color:${statusText[data.status] || '#6b7280'};padding:.2rem .65rem;border-radius:999px;font-size:.68rem;font-weight:700;white-space:nowrap;">
                            ${data.status ? data.status.charAt(0).toUpperCase() + data.status.slice(1) : '—'}
                        </span>
                    </div>

                    ${detailRow('Document', formatTitle(data.document_type))}
                    ${detailRow('Purpose', data.purpose || '—')}
                    ${detailRow('Priority', data.priority ? capitalize(data.priority) : '—')}
                    ${detailRow('Date', data.created_at || '—')}
                    ${detailRow('Copies', data.copies_needed || '1')}

                    <div style="margin-top:1rem;">
                        <div style="font-size:.67rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.08em;margin-bottom:.6rem;">
                            Activity
                        </div>
                        <div style="padding-left:1rem;border-left:2px solid #f0eaea;">
                            ${(data.activities || [{ date: '—', description: 'No activity yet.' }]).map(activity => `
                                <div style="position:relative;margin-bottom:.6rem;">
                                    <div style="position:absolute;left:-1.35rem;top:.3rem;width:6px;height:6px;border-radius:50%;background:#8B0000;border:1.5px solid #fef2f2;"></div>
                                    <div style="font-size:.67rem;color:#9ca3af;">${activity.date}</div>
                                    <div style="font-size:.76rem;color:#374151;">${activity.description}</div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;

                panelFoot.style.display = 'flex';

                let actions = '';

                if (data.status === 'pending') {
                    actions += `
                        <form action="/admin/document-requests/${data.id}/approve" method="POST">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="PATCH">
                            <button type="submit" class="btn-primary" style="font-size:.75rem;padding:.4rem .9rem;">
                                <i class="fa-solid fa-check text-xs"></i> Approve
                            </button>
                        </form>
                    `;
                }

                if (data.status === 'approved' || data.status === 'ready') {
                    actions += `
                        <form action="/admin/document-requests/${data.id}/release" method="POST">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="PATCH">
                            <button type="submit" class="btn-secondary" style="font-size:.75rem;padding:.38rem .9rem;">
                                Release
                            </button>
                        </form>
                    `;
                }

                if (data.status === 'pending' || data.status === 'approved') {
                    actions += `
                        <form action="/admin/document-requests/${data.id}/reject" method="POST" onsubmit="return confirm('Reject this request?')">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="PATCH">
                            <button type="submit" class="btn-secondary" style="font-size:.75rem;padding:.38rem .9rem;color:#dc2626;border-color:#fce8e8;">
                                Reject
                            </button>
                        </form>
                    `;
                }

                panelFoot.innerHTML = actions;
            } catch (error) {
                panelBody.innerHTML = `
                    <p style="color:#dc2626;text-align:center;padding:1.5rem;">
                        Failed to load details.
                    </p>
                `;
            }
        }

        function capitalize(value) {
            return value ? value.charAt(0).toUpperCase() + value.slice(1) : '';
        }

        function formatTitle(value) {
            if (!value) return '—';
            return value
                .replace(/_/g, ' ')
                .replace(/\b\w/g, function (char) {
                    return char.toUpperCase();
                });
        }
    </script>
</body>
</html>