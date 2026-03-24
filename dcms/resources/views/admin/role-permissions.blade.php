@extends('layouts.admin')

@section('title', 'Role Permissions | PUP Taguig Dental Clinic')

@section('body-class', 'bg-[#f4f5f7]')

@section('styles')

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #D1C9C0;
            border-radius: 10px;
        }
        
        /* ── DARK MODE ── */
        body,
        main,
        footer {
            transition: background-color .3s ease, color .3s ease;
        }

        [data-theme="dark"] body {
            background-color: #000D1A;
            color: #E5E7EB;
        }

        [data-theme="dark"] .sl-card,
        [data-theme="dark"] .sl-stat {
            background: #161b22 !important;
            border-color: #21262d !important;
        }

        [data-theme="dark"] .sl-page-title {
            color: #f3f4f6;
        }

        [data-theme="dark"] .sl-toolbar-title {
            color: #f3f4f6;
        }

        [data-theme="dark"] .sl-table thead tr {
            background: #0d1117;
        }

        [data-theme="dark"] .sl-table tbody tr:hover {
            background: #1c2128;
        }

        [data-theme="dark"] .sl-table tbody td {
            color: #d1d5db;
        }

        [data-theme="dark"] .sl-username,
        [data-theme="dark"] .sl-date-day {
            color: #e5e7eb;
        }

        [data-theme="dark"] .sl-pagebar {
            background: #0d1117;
            border-color: #21262d;
        }

        /* ── MOBILE RESPONSIVE ── */
        @media (max-width: 767px) {
            #mainContent {
                padding-bottom: 2rem !important;
            }

            .page-header {
                flex-direction: column !important;
                align-items: stretch !important;
            }

            .page-title-h1 {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .page-title-badge {
                font-size: 18px;
                padding: 6px 14px;
            }

            #newRoleBtn {
                width: 100%;
                justify-content: center;
            }

            /* ── Two-column grid collapses to single column ── */
            .grid.gap-6[style*="grid-template-columns"] {
                grid-template-columns: 1fr !important;
            }

            /* ── Accent card hidden on mobile ── */
            .accent-card {
                display: none;
            }

            /* ── Role cards: 2-col grid ── */
            #roleCardList {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }

            .role-card {
                padding: 10px 12px;
            }

            /* ── Toolbar ── */
            .flex.flex-wrap.items-center.gap-3.mb-5 {
                flex-direction: column;
                align-items: stretch;
            }

            .flex.flex-wrap.items-center.gap-3.mb-5>div,
            .flex.flex-wrap.items-center.gap-3.mb-5>.flex {
                width: 100%;
            }

            .flex.gap-2.w-full.sm\:w-auto {
                width: 100% !important;
            }

            #collapseBtn,
            #resetDefaultsBtn {
                flex: 1;
                justify-content: center;
                text-align: center;
            }

            /* ── Permission group header ── */
            .perm-group-header {
                padding: 12px 14px;
                gap: 10px;
            }

            .perm-group-icon {
                margin-right: 8px;
                width: 30px;
                height: 30px;
                font-size: 13px;
            }

            .dot-row {
                display: none;
            }

            /* ── Permission rows ── */
            .perm-row {
                padding: 10px 14px;
                flex-wrap: wrap;
                gap: 8px;
            }

            /* Remove left indent on mobile since there's no dot-row space */
            .perm-row {
                padding-left: 14px;
            }

            /* ── Footer bar ── */
            .footer-bar {
                flex-direction: column;
                align-items: stretch;
                padding: 14px 16px;
                gap: 10px;
            }

            .footer-bar>div:last-child {
                display: flex;
                flex-direction: column;
                width: 100%;
                gap: 8px;
            }

            .btn-save,
            .btn-view-as {
                width: 100%;
                justify-content: center;
            }
            /* ── Modals full-width on mobile ── */
            .delete-modal-box,
            .reset-modal-box {
                width: calc(100vw - 32px);
                padding: 24px 20px 20px;
            }

            /* ── VA panel full-width ── */
            .va-panel {
                width: calc(100vw - 24px) !important;
                max-height: calc(100vh - 80px);
            }

            .va-head {
                padding: 16px 18px 14px;
            }

            .va-body {
                padding: 14px 18px;
            }

            .va-foot {
                padding: 12px 18px 16px;
            }
        }

        /* ── Role cards ── */
        .role-card {
            background: #FDFCFB;
            border: 1.5px solid #EDE8E2;
            border-radius: 14px;
            padding: 14px 16px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(.4, 0, .2, 1);
        }

        .role-card:hover {
            transform: translateX(3px);
        }

        .role-card.active {
            background: #fff;
            border-color: #7B0D0D;
            box-shadow: 0 4px 20px rgba(123, 13, 13, 0.12);
        }

        .role-avatar {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 13px;
            flex-shrink: 0;
            transition: all 0.2s;
            background: #F0EBE6;
            color: #8A7A6F;
        }

        .role-card.active .role-avatar {
            background: linear-gradient(135deg, #7B0D0D, #9B1515);
            color: #fff;
            box-shadow: 0 4px 10px rgba(123, 13, 13, 0.3);
        }

        .badge-pill {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .progress-bar {
            height: 5px;
            background: #EDE8E2;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 10px;
            transition: width 0.4s ease;
        }

        .role-card.active .progress-fill {
            background: linear-gradient(90deg, #7B0D0D, #C9973A);
        }

        /* ── Permission group card ── */
        .group-card {
            background: #fff;
            border: 1.5px solid #EDE8E2;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
            transition: opacity 0.4s ease, transform 0.4s ease;
        }

        .perm-group-header {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            background: #FDFCFB;
            cursor: pointer;
            transition: background 0.15s;
            user-select: none;
        }

        .perm-group-header:hover {
            background: #FAF4EF;
        }

        .perm-group-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
            margin-right: 14px;
        }

        .dot-row {
            display: flex;
            gap: 3px;
            align-items: center;
        }

        .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #E5DDD5;
            transition: background 0.2s;
        }

        .all-toggle-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #F5EFE9;
            border-radius: 8px;
            padding: 5px 12px;
            cursor: pointer;
        }

        .toggle-switch {
            position: relative;
            width: 46px;
            height: 26px;
            display: inline-block;
            flex-shrink: 0;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
            position: absolute;
        }

        .toggle-track {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background: #F9FAFB;
            border: 2px solid #E5E7EB;
            border-radius: 13px;
            transition: all 0.25s cubic-bezier(.4, 0, .2, 1);
        }

        .toggle-track::after {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #D1D5DB;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.25);
            transition: left 0.25s cubic-bezier(.4, 0, .2, 1), background 0.2s;
        }

        .toggle-switch input:checked+.toggle-track {
            background: linear-gradient(135deg, #7B0D0D, #9B1515);
            border-color: #7B0D0D;
            box-shadow: 0 0 0 3px rgba(123, 13, 13, 0.13);
        }

        .toggle-switch input:checked+.toggle-track::after {
            left: 22px;
            background: #fff;
        }

        .toggle-switch.disabled .toggle-track {
            cursor: not-allowed;
            opacity: 0.45;
        }

        .perm-row {
            display: flex;
            align-items: center;
            padding: 12px 20px 12px 70px;
            border-bottom: 1px solid #F5F0EB;
            transition: background 0.15s;
        }

        .perm-row:last-child {
            border-bottom: none;
        }

        .perm-row:hover {
            background: #FAF6F0;
        }

        .status-granted {
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .status-denied {
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
            background: #F5F0EB;
            color: #B5A99A;
        }

        .perm-group-body {
            border-top: 1px solid #F0EBE6;
            overflow: hidden;
            transition: max-height 0.35s ease, opacity 0.25s ease;
            max-height: 9999px;
            opacity: 1;
        }

        .perm-group-body.collapsed {
            max-height: 0;
            opacity: 0;
            border-top: none;
        }

        .chevron {
            transition: transform 0.2s;
            color: #B5A99A;
            font-size: 11px;
        }

        .chevron.collapsed {
            transform: rotate(180deg);
        }

        /* ── Footer bar ── */
        .footer-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
            background: #fff;
            border-radius: 14px;
            border: 1.5px solid #EDE8E2;
            margin-top: 18px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-reset {
            background: #F5EFE9;
            color: #6B5E56;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background 0.15s;
        }

        .btn-reset:hover {
            background: #EDE5DA;
        }

        .btn-save {
            background: linear-gradient(135deg, #7B0D0D, #9B1515);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 28px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 4px 14px rgba(123, 13, 13, 0.25);
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(123, 13, 13, 0.35);
        }

        .btn-save:disabled {
            opacity: .6;
            cursor: not-allowed;
            transform: none;
        }

        .search-input {
            width: 100%;
            padding: 10px 14px 10px 38px;
            border: 1.5px solid #EDE8E2;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            background: #fff;
            outline: none;
            color: #333333;
            transition: border-color 0.18s;
        }

        .search-input:focus {
            border-color: #7B0D0D;
        }

        .btn-collapse {
            padding: 10px 16px;
            border: 1.5px solid #EDE8E2;
            border-radius: 10px;
            background: #fff;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            color: #6B5E56;
            white-space: nowrap;
            transition: background 0.15s;
        }

        .btn-collapse:hover {
            background: #F5EFE9;
        }

        .protected-banner {
            background: linear-gradient(135deg, #FEF3C7, #FDE68A);
            border: 1px solid #FCD34D;
            border-radius: 12px;
            padding: 12px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .accent-card {
            background: linear-gradient(135deg, #7B0D0D 0%, #9B1515 100%);
            border-radius: 14px;
            padding: 18px 20px;
            color: #fff;
            margin-top: 16px;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            animation: fadeUp 0.45s ease both;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 5, 5, 0.55);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 200;
            backdrop-filter: blur(4px);
        }

        .modal-box {
            background: #fff;
            border-radius: 20px;
            padding: 36px 36px 28px;
            width: 420px;
            box-shadow: 0 32px 80px rgba(0, 0, 0, 0.25);
        }

        /* ── View As button ── */
        .btn-view-as {
            display: none;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #1D4ED8, #3B82F6);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 4px 14px rgba(29, 78, 216, 0.3);
            transition: all 0.2s;
            position: relative;
            white-space: nowrap;
        }

        .btn-view-as.show {
            display: flex;
            animation: popSlide .45s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        .btn-view-as:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(29, 78, 216, .4);
        }

        @keyframes popSlide {
            from {
                opacity: 0;
                transform: translateX(16px) scale(.9);
            }

            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        .va-count-badge {
            position: absolute;
            top: -7px;
            right: -7px;
            background: #EF4444;
            color: #fff;
            font-size: 10px;
            font-weight: 800;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
            box-shadow: 0 2px 6px rgba(239, 68, 68, .4);
        }

        .grant-chips {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .grant-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border-radius: 20px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 700;
            animation: chipIn .35s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        @keyframes chipIn {
            from {
                opacity: 0;
                transform: scale(.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .hint-save {
            display: none;
            align-items: center;
            gap: 6px;
            background: #EFF6FF;
            border: 1px solid #BFDBFE;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
            color: #1D4ED8;
        }

        .hint-save.show {
            display: flex;
        }

        /* ── View As modal ── */
        .va-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 5, 5, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 300;
            backdrop-filter: blur(6px);
            opacity: 0;
            pointer-events: none;
            transition: opacity .25s;
        }

        .va-overlay.open {
            opacity: 1;
            pointer-events: auto;
        }

        .va-panel {
            background: #fff;
            border-radius: 22px;
            width: 680px;
            max-width: calc(100vw - 32px);
            max-height: calc(100vh - 60px);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 40px 100px rgba(0, 0, 0, .3);
            transform: scale(.94) translateY(16px);
            transition: transform .35s cubic-bezier(.34, 1.56, .64, 1);
        }

        .va-overlay.open .va-panel {
            transform: scale(1) translateY(0);
        }

        .va-head {
            padding: 22px 26px 18px;
            border-bottom: 1px solid #F0EBE6;
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .va-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px 26px;
        }

        .va-foot {
            padding: 14px 26px 20px;
            border-top: 1px solid #F0EBE6;
            display: flex;
            justify-content: flex-end;
        }

        .va-summary {
            background: linear-gradient(135deg, #7B0D0D, #9B1515);
            border-radius: 12px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 18px;
            color: #fff;
        }

        .va-role-row {
            display: flex;
            align-items: center;
            gap: 14px;
            background: #FDFCFB;
            border: 1.5px solid #EDE8E2;
            border-radius: 14px;
            padding: 16px 18px;
            cursor: pointer;
            transition: all .2s;
            position: relative;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .va-role-row:last-child {
            margin-bottom: 0;
        }

        .va-role-row:hover {
            border-color: #93C5FD;
            box-shadow: 0 4px 18px rgba(29, 78, 216, .1);
            transform: translateY(-1px);
        }

        .va-role-avatar {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 14px;
            flex-shrink: 0;
        }

        .va-perm-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .va-go-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #1D4ED8, #3B82F6);
            color: #fff;
            border: none;
            border-radius: 9px;
            padding: 9px 16px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            white-space: nowrap;
            flex-shrink: 0;
            transition: all .2s;
            box-shadow: 0 3px 10px rgba(29, 78, 216, .25);
        }

        .va-go-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(29, 78, 216, .35);
        }

        /* ── Redirect overlay ── */
        .redirect-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s;
        }

        .redirect-overlay.show {
            opacity: 1;
            pointer-events: auto;
        }

        .redirect-spinner {
            width: 48px;
            height: 48px;
            border: 3px solid rgba(255, 255, 255, .2);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .7s linear infinite;
            margin-bottom: 16px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ── Toast ── */
        .toast-pop {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 600;
            background: #fff;
            border: 1.5px solid #BBF7D0;
            border-radius: 14px;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            transform: translateY(80px);
            opacity: 0;
            transition: all .4s cubic-bezier(.34, 1.56, .64, 1);
            min-width: 300px;
        }

        .toast-pop.show {
            transform: translateY(0);
            opacity: 1;
        }

        .toast-pop.toast-error {
            border-color: #FECACA;
        }

        .toast-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #F0FDF4;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #22C55E;
            flex-shrink: 0;
        }

        .toast-pop.toast-error .toast-icon {
            background: #FEF2F2;
            color: #EF4444;
        }

        @keyframes cardSlide {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .card-new {
            animation: cardSlide 0.4s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        /* ── Delete Role Button ── */
        .btn-delete-role {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 26px;
            height: 26px;
            border-radius: 7px;
            border: none;
            background: transparent;
            color: #C4B8AF;
            font-size: 11px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all .15s;
            z-index: 10;
        }

        .role-card:hover .btn-delete-role {
            opacity: 1;
        }

        .btn-delete-role:hover {
            background: #FEE2E2;
            color: #DC2626;
        }

        .delete-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 5, 5, 0.55);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 500;
            backdrop-filter: blur(4px);
            opacity: 0;
            pointer-events: none;
            transition: opacity .2s;
        }

        .delete-modal-overlay.open {
            opacity: 1;
            pointer-events: auto;
        }

        .delete-modal-box {
            background: #fff;
            border-radius: 20px;
            padding: 32px 32px 24px;
            width: 400px;
            box-shadow: 0 32px 80px rgba(0, 0, 0, 0.25);
            transform: scale(.94) translateY(12px);
            transition: transform .3s cubic-bezier(.34, 1.56, .64, 1);
        }

        .delete-modal-overlay.open .delete-modal-box {
            transform: scale(1) translateY(0);
        }

        #newRoleBtn {
            transition: transform .18s, box-shadow .18s;
        }

        #newRoleBtn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(123, 13, 13, 0.45);
        }

        /* ════════════════════
           TITLE REDESIGN
        ════════════════════ */
        .page-title-h1 {
            margin: 0;
            line-height: 1;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .page-title-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #7B0D0D, #9B1515);
            color: #fff;
            border-radius: 10px;
            padding: 4px 14px;
            font-size: 22px;
            font-weight: 900;
            box-shadow: 0 4px 14px rgba(123, 13, 13, .25);
        }

        .page-title-badge i {
            font-size: 16px;
            opacity: .85;
        }

        .page-title-sub {
            margin: 10px 0 0;
            font-size: 13.5px;
            color: #8A7A6F;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ── Reset Confirm Modal ── */
        .reset-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 5, 5, 0.55);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 500;
            backdrop-filter: blur(4px);
            opacity: 0;
            pointer-events: none;
            transition: opacity .2s;
        }

        .reset-modal-overlay.open {
            opacity: 1;
            pointer-events: auto;
        }

        .reset-modal-box {
            background: #fff;
            border-radius: 20px;
            padding: 32px 32px 24px;
            width: 420px;
            box-shadow: 0 32px 80px rgba(0, 0, 0, 0.25);
            transform: scale(.94) translateY(12px);
            transition: transform .3s cubic-bezier(.34, 1.56, .64, 1);
        }

        .reset-modal-overlay.open .reset-modal-box {
            transform: scale(1) translateY(0);
        }

        #newRoleModal {
            opacity: 0;
            transition: opacity .25s ease;
        }

        #newRoleModal.modal-visible {
            opacity: 1;
        }

        #newRoleModal .modal-inner {
            transform: scale(.95) translateY(10px);
            transition: transform .3s cubic-bezier(.34, 1.56, .64, 1);
        }

        #newRoleModal.modal-visible .modal-inner {
            transform: scale(1) translateY(0);
        }
    </style>
@endsection
    
    <!-- ════════════ MAIN CONTENT ════════════ -->
    @php
    $logs = $logs ?? collect([]);
    $totalCount = $logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->total() : $logs->count();
    $adminCount = ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() :
    $logs)->where('actor_role','admin')->count();
    $dentistCount = ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() :
    $logs)->where('actor_role','dentist')->count();
    $patientCount = ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() :
    $logs)->where('actor_role','patient')->count();
    $loginCount = ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() :
    $logs)->whereIn('action',['login','Login'])->count();
    @endphp

@section('content')

    <main id="mainContent" class="px-4 sm:px-6 pt-[82px] pb-8 min-h-screen">
        <div style="max-width:1280px; margin:0 auto;">

            <!-- ══ REDESIGNED PAGE TITLE ══ -->
            <div class="page-header flex flex-col sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h1 style="font-size:2rem; font-weight:900; color:#333333; line-height:1.1;">
                        Roles &amp; <span style="color:#7B0D0D;">Permissions</span>
                    </h1>
                    <p style="margin:8px 0 0; font-size:13.5px; color:#8A7A6F;">
                        Define what each role can see and do across the clinic system.
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <button id="newRoleBtn" onclick="openNewRoleModal()"
                        style="background:linear-gradient(135deg,#7B0D0D,#9B1515);color:#fff;border:none;border-radius:10px;padding:11px 22px;font-weight:700;font-size:14px;cursor:pointer;font-family:'Inter',sans-serif;display:flex;align-items:center;gap:8px;box-shadow:0 4px 14px rgba(123,13,13,0.25);">
                        <i class="fa-solid fa-plus" style="font-size:13px;"></i> New Role
                    </button>
                </div>
            </div>

            <!-- Two-column grid -->
            <div class="grid gap-6" style="grid-template-columns:280px 1fr; align-items:start;">

                <!-- ══ LEFT: Role Cards ══ -->
                <div>
                    @php
                    function getRoleBadge($name, $slug) {
                    $n = strtolower($name); $s = strtolower($slug);
                    if (str_contains($n,'super') || str_contains($s,'super')) return
                    ['badgeColor'=>'#7B0D0D','label'=>'Full Access'];
                    if (str_contains($n,'dentist') || str_contains($s,'dentist')) return
                    ['badgeColor'=>'#B45309','label'=>'Clinical'];
                    if (str_contains($n,'staff') || str_contains($s,'staff') || str_contains($n,'clinic')) return
                    ['badgeColor'=>'#065F46','label'=>'Front Desk'];
                    if (str_contains($n,'student') || str_contains($s,'student') || str_contains($n,'patient') ||
                    str_contains($s,'patient')) return ['badgeColor'=>'#4B5563','label'=>'Limited'];
                    return ['badgeColor'=>'#6B7280','label'=>'Custom'];
                    }
                    $totalPerms = $groupedPermissions->flatten()->count();
                    @endphp

                    <div style="font-size:11px; color:#B5A99A; letter-spacing:2px; text-transform:uppercase; margin-bottom:12px; font-weight:600;"
                        id="roleCountLabel">
                        Roles ({{ $roles->count() }})
                    </div>

                    <div style="display:flex; flex-direction:column; gap:8px;" id="roleCardList">
                        @foreach ($roles as $i => $role)
                        @php
                        $c = getRoleBadge($role->name, $role->slug);
                        $granted = $role->permissions->count();
                        $pct = $totalPerms > 0 ? round(($granted / $totalPerms) * 100) : 0;
                        $words = array_slice(explode(' ', $role->name), 0, 2);
                        $initials = '';
                        foreach ($words as $_w) { $initials .= strtoupper($_w[0]); }
                        $isHighlighted = isset($highlightRoleId) && (int)$highlightRoleId === (int)$role->id;
                        $isFirst = isset($highlightRoleId) ? $isHighlighted : $i === 0;
                        $isSuperRole = in_array(strtolower($role->slug),['super_admin','super-admin','superadmin']) ||
                        str_contains(strtolower($role->name),'super');
                        $isProtectedRole = $isSuperRole ||
                        in_array(strtolower($role->slug),['admin','patient','dentist']);
                        @endphp

                        <div class="role-card {{ $isFirst ? 'active' : '' }}" data-role-id="{{ $role->id }}"
                            data-role-name="{{ $role->name }}" data-granted="{{ $granted }}"
                            data-total="{{ $totalPerms }}" data-pct="{{ $pct }}" data-slug="{{ $role->slug }}"
                            data-is-super="{{ $isSuperRole ? '1' : '0' }}" onclick="selectRole(this)"
                            style="position:relative;">

                            @if (!$isProtectedRole)
                            <button type="button" class="btn-delete-role"
                                onclick="event.stopPropagation(); openDeleteModal('{{ $role->id }}', '{{ addslashes($role->name) }}')"
                                title="Delete role">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            @endif

                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="role-avatar">{{ $initials }}</div>
                                <div style="flex:1;">
                                    <div style="display:flex; align-items:center; gap:7px; margin-bottom:3px;">
                                        <span style="font-weight:600; font-size:14px; color:#333333;"
                                            class="role-name-label">{{ $role->name }}</span>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                                        <span class="badge-pill"
                                            style="background:{{ $c['badgeColor'] }}18; color:{{ $c['badgeColor'] }}; border:1px solid {{ $c['badgeColor'] }}40; white-space:nowrap;">{{
                                            $c['label'] }}</span>
                                        <span style="font-size:11px; color:#B5A99A; white-space:nowrap;">{{ $role->slug
                                            }}</span>
                                    </div>
                                </div>
                                <div class="active-dot"
                                    style="width:8px; height:8px; border-radius:50%; background:#7B0D0D; flex-shrink:0; display:{{ $isFirst ? 'block' : 'none' }};">
                                </div>
                            </div>

                            <div style="margin-top:12px;">
                                <div
                                    style="display:flex; justify-content:space-between; font-size:11px; color:#B5A99A; margin-bottom:5px;">
                                    <span>Access level</span>
                                    <span style="font-weight:600;" class="pct-label">{{ $pct }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill"
                                        style="width:{{ $pct }}%; background:{{ $isFirst ? 'linear-gradient(90deg,#7B0D0D,#C9973A)' : '#C4B8AF' }};">
                                    </div>
                                </div>
                                <div style="font-size:11px; color:#C4B8AF; margin-top:4px;" class="count-label">
                                    {{ $granted }} of {{ $totalPerms }} permissions
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Accent card -->
                    <div class="accent-card">
                        @php
                        $fr = isset($highlightRoleId) ? $roles->firstWhere('id',(int)$highlightRoleId) :
                        $roles->first();
                        $fp = $fr ? ($totalPerms > 0 ? round(($fr->permissions->count()/$totalPerms)*100) : 0) : 0;
                        @endphp
                        <div style="font-size:16px; font-weight:700; margin-bottom:4px;" id="accentRoleName">{{
                            $fr->name ?? '' }}</div>
                        <div style="font-size:28px; font-weight:700; margin-bottom:2px;" id="accentPct">{{ $fp }}%</div>
                        <div style="font-size:12px; opacity:0.75; margin-bottom:14px;" id="accentCount">{{
                            $fr?->permissions->count() ?? 0 }} of {{ $totalPerms }} permissions active</div>
                        <div style="height:6px; background:rgba(255,255,255,0.2); border-radius:10px;">
                            <div id="accentBar"
                                style="height:100%; width:{{ $fp }}%; background:#C9973A; border-radius:10px; transition:width 0.4s;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ══ RIGHT: Permission Editor ══ -->
                <div>
                    <!-- Toolbar -->
                    <div class="flex flex-wrap items-center gap-3 mb-5">
                        <div class="relative w-full sm:flex-1" style="min-width:180px;">
                            <i class="fa-solid fa-magnifying-glass"
                                style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#B5A99A; font-size:13px;"></i>
                            <input type="text" id="permSearch" placeholder="Search permissions…" class="search-input"
                                oninput="filterPerms(this.value)">
                        </div>
                        <div class="flex gap-2 w-full sm:w-auto">
                            <button type="button" class="btn-collapse" id="collapseBtn"
                                onclick="toggleAllGroups()">Collapse All</button>
                            <button type="button" class="btn-reset" id="resetDefaultsBtn"
                                style="border:1.5px solid #EDE8E2;" onclick="ajaxResetDefaults()">
                                <i class="fa-solid fa-rotate-left" style="font-size:12px; margin-right:4px;"></i> Reset
                                Defaults
                            </button>
                        </div>
                    </div>

                    <!-- Protected banner -->
                    <div class="protected-banner" id="protectedBanner" style="display:none;">
                        <i class="fa-solid fa-shield-halved" style="font-size:20px; color:#92400E;"></i>
                        <div>
                            <div style="font-weight:700; font-size:13px; color:#78350F;">Protected Role</div>
                            <div style="font-size:12px; color:#92400E;">Super Admin has unrestricted access and cannot
                                be modified.</div>
                        </div>
                    </div>

                    <!-- Permission forms — one per role, shown/hidden by JS -->
                    @foreach ($roles as $ri => $role)
                    @php
                    $isSuperRole = in_array(strtolower($role->slug),['super_admin','super-admin','superadmin']) ||
                    str_contains(strtolower($role->name),'super');
                    $isActiveRole = isset($highlightRoleId) ? (int)$highlightRoleId === (int)$role->id : $ri === 0;
                    $micons = [
                    'Dental Records' => ['fa-notes-medical','#7B0D0D'],
                    'Patients' => ['fa-user-group','#B45309'],
                    'Appointments' => ['fa-calendar-days','#065F46'],
                    'Document Requests' => ['fa-envelope-open-text','#1D4ED8'],
                    'Document Templates' => ['fa-file-lines','#6D28D9'],
                    'Reports' => ['fa-chart-pie','#6D28D9'],
                    'General Access' => ['fa-user-shield','#065F46'],
                    'Inventory' => ['fa-boxes-stacked','#EA580C'],
                    'User Management' => ['fa-user-cog','#DC2626'],
                    'System Settings' => ['fa-screwdriver-wrench','#374151'],
                    ];
                    @endphp

                    {{-- NOTE: no action/method needed — AJAX handles submission --}}
                    <form id="form-role-{{ $role->id }}" class="role-form" data-role-id="{{ $role->id }}"
                        style="display:{{ $isActiveRole ? 'block' : 'none' }};">

                        @csrf
                        <input type="hidden" name="role_id" value="{{ $role->id }}">

                        <div style="display:flex; flex-direction:column; gap:10px;" class="groups-container">
                            @forelse($groupedPermissions as $module => $permissions)
                            @php
                            [$ico,$icol] = $micons[$module] ?? ['fa-shield-halved','#374151'];
                            $mSlug = Str::slug($module);
                            $mTotal = $permissions->count();
                            $roleGranted = 0;
                            foreach ($permissions as $_p) {
                            if ($role->permissions->contains('id',$_p->id)) $roleGranted++;
                            }
                            $allOn = $roleGranted === $mTotal;
                            @endphp

                            <div class="group-card perm-group" data-group="{{ strtolower($module) }}">
                                <div class="perm-group-header" onclick="togglePermGroup(this)">
                                    <div class="perm-group-icon"
                                        style="background:{{ $icol }}15; color:{{ $icol }}; border:1px solid {{ $icol }}25;">
                                        <i class="fa-solid {{ $ico }}"></i>
                                    </div>
                                    <div style="flex:1;">
                                        <div style="font-weight:700; font-size:14px; color:#333333;">{{ $module }}</div>
                                        <div style="font-size:12px; color:#B5A99A;" class="group-count">{{ $roleGranted
                                            }} of {{ $mTotal }} enabled</div>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:14px;">
                                        <div class="dot-row" id="dots-{{ $role->id }}-{{ $mSlug }}">
                                            @for ($d = 0; $d < $mTotal; $d++) <div
                                                class="dot {{ $d < $roleGranted ? 'on' : '' }}"
                                                style="{{ $d < $roleGranted ? 'background:'.$icol.';' : '' }}">
                                        </div>
                                        @endfor
                                    </div>
                                    <div class="all-toggle-wrap"
                                        onclick="event.stopPropagation(); toggleGroupPerms(this,'{{ $role->id }}','{{ $mSlug }}',{{ $allOn ? 'true' : 'false' }})">
                                        <span style="font-size:11px; color:#6B5E56; font-weight:600;">All</span>
                                        <label class="toggle-switch {{ $isSuperRole ? 'disabled' : '' }}"
                                            onclick="event.preventDefault();">
                                            <input type="checkbox" class="group-master" data-role="{{ $role->id }}"
                                                data-module="{{ $mSlug }}" {{ $allOn ? 'checked' : '' }} {{ $isSuperRole
                                                ? 'disabled' : '' }}>
                                            <span class="toggle-track"></span>
                                        </label>
                                    </div>
                                    <i class="fa-solid fa-chevron-up chevron"></i>
                                </div>
                            </div>

                            <div class="perm-group-body">
                                @foreach ($permissions as $permission)
                                @php $isGranted = $role->permissions->contains('id',$permission->id); @endphp
                                <div class="perm-row" style="{{ $isGranted ? 'background:'.$icol.'06;' : '' }}"
                                    data-perm-search="{{ strtolower($permission->name.' '.$permission->slug) }}">
                                    <div style="flex:1;">
                                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:2px;">
                                            <div class="perm-dot"
                                                style="width:7px; height:7px; border-radius:50%; flex-shrink:0; transition:background 0.2s; background:{{ $isGranted ? $icol : '#D5CEC8' }};">
                                            </div>
                                            <span
                                                style="font-weight:600; font-size:13px; color:{{ $isGranted ? '#333333' : '#8A7A6F' }};"
                                                class="perm-label">{{ $permission->name }}</span>
                                        </div>
                                        <div style="font-size:12px; color:#B5A99A; padding-left:15px;">{{
                                            $permission->slug }}</div>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <span class="perm-status {{ $isGranted ? 'status-granted' : 'status-denied' }}"
                                            style="{{ $isGranted ? 'background:'.$icol.'18; color:'.$icol.';' : '' }}">
                                            {{ $isGranted ? 'Granted' : 'Denied' }}
                                        </span>
                                        <label class="toggle-switch {{ $isSuperRole ? 'disabled' : '' }}">
                                            <input type="checkbox" name="permissions[{{ $role->id }}][]"
                                                value="{{ $permission->id }}" class="perm-toggle"
                                                data-role="{{ $role->id }}" data-module="{{ $mSlug }}"
                                                data-color="{{ $icol }}" data-perm-name="{{ $permission->name }}"
                                                data-perm-slug="{{ $permission->slug }}" {{ $isGranted ? 'checked' : ''
                                                }} {{ $isSuperRole ? 'disabled' : '' }} onchange="onPermChange(this)">
                                            <span class="toggle-track"></span>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        @empty
                        <div style="text-align:center; padding:60px 20px;">
                            <div style="font-size:40px; opacity:0.2; margin-bottom:12px;">🛡️</div>
                            <p style="font-size:14px; font-weight:600; color:#8A7A6F;">No permissions found.</p>
                        </div>
                        @endforelse
                </div>

                @if (!$isSuperRole)
                <div class="footer-bar" id="footer-bar-{{ $role->id }}">
                    <div style="display:flex; flex-direction:column; gap:6px; flex:1; min-width:0;">
                        <div style="font-size:13px; color:#8A7A6F;" id="footer-msg-{{ $role->id }}">
                            {{ $role->permissions->count() }} permissions enabled for {{ $role->name }}
                        </div>
                        <div class="grant-chips" id="chips-{{ $role->id }}"></div>
                        <div class="hint-save" id="hint-{{ $role->id }}">
                            <i class="fa-solid fa-eye" style="font-size:11px;"></i> Save changes to unlock "View As"
                        </div>
                    </div>
                    <div style="display:flex; gap:10px; align-items:center; flex-shrink:0;">
                        <button type="button" class="btn-view-as" id="viewas-{{ $role->id }}" onclick="openViewAs()">
                            <i class="fa-solid fa-eye" style="font-size:13px;"></i> View As
                            <span class="va-count-badge" id="va-badge-{{ $role->id }}">0</span>
                        </button>
                        {{-- AJAX save button — no form submit --}}
                        <button type="button" class="btn-save" id="save-btn-{{ $role->id }}"
                            onclick="ajaxSaveRole('{{ $role->id }}')">
                            <i class="fa-solid fa-floppy-disk" style="font-size:13px;"></i> Save Changes
                        </button>
                    </div>
                </div>
                @endif

                </form>
                @endforeach

            </div>
        </div>
        </div>
    </main>

    <!-- ════ DELETE ROLE MODAL ════ -->
    <div class="delete-modal-overlay" id="deleteRoleOverlay" onclick="if(event.target===this)closeDeleteModal()">
        <div class="delete-modal-box">
            <div
                style="width:48px;height:48px;border-radius:14px;background:#FEF2F2;border:1.5px solid #FECACA;display:flex;align-items:center;justify-content:center;font-size:20px;margin-bottom:16px;">
                <i class="fa-solid fa-trash" style="color:#DC2626;"></i>
            </div>
            <h2 style="margin:0 0 6px;font-size:20px;font-weight:800;color:#1E293B;">Delete Role</h2>
            <p style="margin:0 0 6px;font-size:14px;color:#8A7A6F;">You are about to permanently delete:</p>
            <div id="deleteRoleName" style="font-size:16px;font-weight:700;color:#DC2626;margin-bottom:6px;"></div>
            <p style="margin:0 0 22px;font-size:13px;color:#B5A99A;">This action cannot be undone. All permissions
                assigned to this role will be removed.</p>
            <div id="deleteRoleError"
                style="display:none;color:#B91C1C;font-size:13px;margin-bottom:12px;background:#FEF2F2;border-radius:8px;padding:8px 12px;">
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button onclick="closeDeleteModal()"
                    style="background:#F5EFE9;color:#6B5E56;border:none;border-radius:10px;padding:11px 22px;font-weight:600;font-size:14px;cursor:pointer;font-family:'Inter',sans-serif;">Cancel</button>
                <form id="deleteRoleForm" action="" method="POST" style="display:contents;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        style="background:linear-gradient(135deg,#DC2626,#B91C1C);color:#fff;border:none;border-radius:10px;padding:11px 24px;font-weight:700;font-size:14px;cursor:pointer;font-family:'Inter',sans-serif;display:flex;align-items:center;gap:8px;box-shadow:0 4px 14px rgba(220,38,38,0.3);">
                        <i class="fa-solid fa-trash" style="font-size:12px;"></i> Delete Role
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- ════ VIEW AS MODAL ════ -->
    <div class="va-overlay" id="vaOverlay" onclick="if(event.target===this)closeViewAs()">
        <div class="va-panel">
            <div class="va-head">
                <div
                    style="width:46px;height:46px;border-radius:13px;background:linear-gradient(135deg,#EFF6FF,#DBEAFE);border:1.5px solid #BFDBFE;display:flex;align-items:center;justify-content:center;font-size:19px;color:#1D4ED8;flex-shrink:0;">
                    <i class="fa-solid fa-eye"></i>
                </div>
                <div style="flex:1;">
                    <div style="font-size:19px;font-weight:800;color:#1E293B;margin-bottom:3px;">View As — Select Role
                    </div>
                    <div style="font-size:13px;color:#8A7A6F;" id="vaSubtitle">Select a role to preview their dashboard
                        access</div>
                </div>
                <button onclick="closeViewAs()"
                    style="margin-left:auto;width:34px;height:34px;border-radius:9px;background:#F5EFE9;border:none;cursor:pointer;color:#8A7A6F;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="va-body">
                <div class="va-summary">
                    <div
                        style="width:38px;height:38px;border-radius:10px;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <div style="font-size:12px;opacity:.75;margin-bottom:2px;">Total newly granted &amp; saved
                            permissions</div>
                        <div style="display:flex;align-items:baseline;gap:6px;">
                            <span style="font-size:22px;font-weight:800;" id="vaTotalPerms">0</span>
                            <span style="font-size:13px;opacity:.8;">permissions across</span>
                            <span style="font-size:22px;font-weight:800;" id="vaTotalRoles">0</span>
                            <span style="font-size:13px;opacity:.8;">roles</span>
                        </div>
                    </div>
                </div>
                <div
                    style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#B5A99A;margin-bottom:10px;">
                    Roles with newly granted access</div>
                <div id="vaRoleList"></div>
            </div>
            <div class="va-foot">
                <button onclick="closeViewAs()"
                    style="background:#F5EFE9;color:#6B5E56;border:none;border-radius:10px;padding:10px 22px;font-weight:600;font-size:14px;cursor:pointer;font-family:'Inter',sans-serif;">Close</button>
            </div>
        </div>
    </div>

    <!-- REDIRECT OVERLAY -->
    <div class="redirect-overlay" id="redirectOverlay">
        <div class="redirect-spinner"></div>
        <div id="redirectText" style="font-size:16px;font-weight:700;color:#fff;margin-bottom:6px;"></div>
        <div id="redirectSub" style="font-size:13px;color:rgba(255,255,255,.7);"></div>
    </div>

    <!-- TOAST -->
    <div class="toast-pop" id="toastPop">
        <div class="toast-icon"><i class="fa-solid fa-circle-check" id="toastIconEl"></i></div>
        <div>
            <div id="toastTitle" style="font-weight:700;font-size:14px;color:#333333;"></div>
            <div id="toastSub" style="font-size:12px;color:#6B7280;margin-top:2px;"></div>
        </div>
    </div>

    <!-- ════ NEW ROLE MODAL ════ -->
    <div id="newRoleModal"
        style="display:none;position:fixed;inset:0;background:rgba(15,5,5,0.55);align-items:center;justify-content:center;z-index:200;backdrop-filter:blur(4px);">
        <div class="modal-inner"
            style="background:#fff;border-radius:20px;padding:36px 36px 28px;width:440px;box-shadow:0 32px 80px rgba(0,0,0,0.25);">
            <div
                style="width:48px;height:48px;border-radius:14px;background:#FFF0F0;border:1.5px solid #7B0D0D30;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:16px;">
                <i class="fa-solid fa-user-shield" style="color:#7B0D0D;"></i>
            </div>
            <h2 style="margin:0 0 6px;font-size:22px;font-weight:800;color:#7B0D0D;">Create New Role</h2>
            <p style="margin:0 0 22px;font-size:14px;color:#8A7A6F;">Define a new role and assign permissions right
                after creating it.</p>
            <label
                style="display:block;font-size:12px;font-weight:700;color:#6B5E56;letter-spacing:0.5px;text-transform:uppercase;margin-bottom:6px;">Role
                Name</label>
            <input id="newRoleName" type="text" placeholder="e.g. Dental Intern"
                style="width:100%;padding:12px 16px;border:1.5px solid #EDE8E2;border-radius:10px;font-size:15px;font-family:'Inter',sans-serif;outline:none;color:#333333;margin-bottom:10px;transition:border-color 0.18s;"
                onfocus="this.style.borderColor='#7B0D0D'" onblur="this.style.borderColor='#EDE8E2'"
                onkeydown="if(event.key==='Enter') createNewRole()">
            <label
                style="display:block;font-size:12px;font-weight:700;color:#6B5E56;letter-spacing:0.5px;text-transform:uppercase;margin-bottom:6px;">Role
                Slug</label>
            <input id="newRoleSlug" type="text" placeholder="e.g. dental-intern"
                style="width:100%;padding:12px 16px;border:1.5px solid #EDE8E2;border-radius:10px;font-size:15px;font-family:'Inter',sans-serif;outline:none;color:#333333;margin-bottom:22px;transition:border-color 0.18s;"
                onfocus="this.style.borderColor='#7B0D0D'" onblur="this.style.borderColor='#EDE8E2'">
            <div id="newRoleError"
                style="display:none;color:#B91C1C;font-size:13px;margin-bottom:12px;background:#FEF2F2;border-radius:8px;padding:8px 12px;">
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button onclick="closeNewRoleModal()"
                    style="background:#F5EFE9;color:#6B5E56;border:none;border-radius:10px;padding:11px 22px;font-weight:600;font-size:14px;cursor:pointer;font-family:'Inter',sans-serif;">Cancel</button>
                <form id="createRoleForm" action="{{ route('admin.role_permissions.store_role') }}" method="POST"
                    style="display:contents;">
                    @csrf
                    <input type="hidden" name="name" id="createRoleName">
                    <input type="hidden" name="slug" id="createRoleSlug">
                    <button type="button" onclick="createNewRole()"
                        style="background:linear-gradient(135deg,#7B0D0D,#9B1515);color:#fff;border:none;border-radius:10px;padding:11px 24px;font-weight:700;font-size:14px;cursor:pointer;font-family:'Inter',sans-serif;">Create
                        Role</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Patient Picker -->
    <div class="va-overlay" id="patientPickerOverlay" onclick="if(event.target===this)closePatientPicker()">
        <div class="va-panel" style="width:760px;">
            <div class="va-head">
                <div
                    style="width:46px;height:46px;border-radius:13px;background:linear-gradient(135deg,#EFF6FF,#DBEAFE);border:1.5px solid #BFDBFE;display:flex;align-items:center;justify-content:center;font-size:19px;color:#1D4ED8;flex-shrink:0;">
                    <i class="fa-solid fa-user-injured"></i>
                </div>
                <div style="flex:1;">
                    <div style="font-size:19px;font-weight:800;color:#1E293B;margin-bottom:3px;">Select Patient Account
                    </div>
                    <div style="font-size:13px;color:#8A7A6F;">Choose which patient account to impersonate</div>
                </div>
                <button onclick="closePatientPicker()"
                    style="margin-left:auto;width:34px;height:34px;border-radius:9px;background:#F5EFE9;border:none;cursor:pointer;color:#8A7A6F;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="va-body">
                <div style="margin-bottom:14px; position:relative;">
                    <i class="fa-solid fa-magnifying-glass"
                        style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#B5A99A; font-size:13px;"></i>
                    <input type="text" id="patientPickerSearch" placeholder="Search patient name or email..."
                        class="search-input" style="padding-left:38px; padding-right:36px;"
                        oninput="filterPatientPicker(this.value)">
                    <button onclick="clearPatientSearch()"
                        style="position:absolute;right:10px;top:50%;transform:translateY(-50%);border:none;background:none;color:#7B0D0D;font-size:13px;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;">Clear</button>
                </div>
                <div id="patientPickerList"></div>
            </div>
            <div class="va-foot"
                style="display:flex;justify-content:flex-end;padding:18px 22px;border-top:1px solid #EDE8E2;background:#FAF8F6;">
                <button onclick="closePatientPicker()"
                    style="background:#F5EFE9;color:#6B5E56;border:none;border-radius:10px;padding:10px 22px;font-weight:600;font-size:14px;cursor:pointer;font-family:'Inter',sans-serif;"
                    onmouseover="this.style.background='#EDE6DF'"
                    onmouseout="this.style.background='#F5EFE9'">Cancel</button>
            </div>
        </div>
    </div>

    <!-- ════ RESET DEFAULTS CONFIRM MODAL ════ -->
    <div class="reset-modal-overlay" id="resetConfirmOverlay" onclick="if(event.target===this)closeResetConfirm()">
        <div class="reset-modal-box">

            <!-- Icon -->
            <div
                style="width:52px;height:52px;border-radius:14px;background:#FEF3C7;border:1.5px solid #FCD34D;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:18px;">
                <i class="fa-solid fa-rotate-left" style="color:#B45309;"></i>
            </div>

            <!-- Title -->
            <h2 style="margin:0 0 6px;font-size:20px;font-weight:800;color:#1E293B;">Reset to Defaults?</h2>
            <p style="margin:0 0 16px;font-size:14px;color:#8A7A6F;line-height:1.6;">
                This will restore the original permissions for <strong style="color:#333333;">Super Admin</strong>,
                <strong style="color:#333333;">Dentist</strong>, and <strong style="color:#333333;">Patient</strong>.
            </p>

            <!-- Warning callout -->
            <div
                style="background:#FEF3C7;border:1px solid #FCD34D;border-radius:10px;padding:10px 14px;display:flex;align-items:flex-start;gap:10px;margin-bottom:22px;">
                <i class="fa-solid fa-triangle-exclamation"
                    style="color:#B45309;font-size:14px;margin-top:1px;flex-shrink:0;"></i>
                <span style="font-size:12px;font-weight:600;color:#92400E;line-height:1.5;">
                    Any custom permission changes you have made will be lost. This action cannot be undone.
                </span>
            </div>

            <!-- Buttons -->
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button onclick="closeResetConfirm()"
                    style="background:#F5EFE9;color:#6B5E56;border:none;border-radius:10px;padding:11px 22px;font-weight:600;font-size:14px;cursor:pointer;font-family:'Inter',sans-serif;transition:background .15s;"
                    onmouseover="this.style.background='#EDE5DA'" onmouseout="this.style.background='#F5EFE9'">
                    Cancel
                </button>
                <button id="resetConfirmBtn" onclick="confirmResetDefaults()"
                    style="background:linear-gradient(135deg,#B45309,#D97706);color:#fff;border:none;border-radius:10px;padding:11px 24px;font-weight:700;font-size:14px;cursor:pointer;font-family:'Inter',sans-serif;display:flex;align-items:center;gap:8px;box-shadow:0 4px 14px rgba(180,83,9,0.3);transition:all .2s;"
                    onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 8px 24px rgba(180,83,9,0.4)'"
                    onmouseout="this.style.transform='';this.style.boxShadow='0 4px 14px rgba(180,83,9,0.3)'">
                    <i class="fa-solid fa-rotate-left" style="font-size:12px;"></i> Yes, Reset
                </button>
            </div>

        </div>
    </div>
    @endsection

    @section('scripts')
    <script>
        // PERM MODULE META
        const PERM_MODULES = [
            { module: 'Dashboard', icon: 'fa-chart-line', color: '#7B0D0D' },
            { module: 'Patients', icon: 'fa-users', color: '#B45309' },
            { module: 'Appointments', icon: 'fa-calendar-check', color: '#065F46' },
            { module: 'Document Requests', icon: 'fa-file-circle-check', color: '#1D4ED8' },
            { module: 'Document Template', icon: 'fa-file-pen', color: '#6D28D9' },
            { module: 'Reports', icon: 'fa-chart-column', color: '#6D28D9' },
            { module: 'Academic Periods', icon: 'fa-school', color: '#065F46' },
            { module: 'Data Backup', icon: 'fa-database', color: '#EA580C' },
            { module: 'System Logs', icon: 'fa-clipboard-list', color: '#6D28D9' },
            { module: 'System Settings', icon: 'fa-gear', color: '#374151' },
        ];
        function getModuleColor(module) {
            const found = PERM_MODULES.find(m => m.module === module);
            return found ? found.color : '#374151';
        }

        // VIEW-AS STATE
        const savedGrants = {};
        const pendingGrants = {};

        const flashedViewAs = @json(session('saved_view_as') ?? null);
        if (flashedViewAs && flashedViewAs.role_id) {
            savedGrants[String(flashedViewAs.role_id)] = (flashedViewAs.permissions || []).map(p => ({
                name: p.name, slug: p.slug, color: getModuleColor(p.module)
            }));
        }

        document.addEventListener('DOMContentLoaded', () => {
            applyTheme(localStorage.getItem('theme') || 'light');
            document.querySelectorAll('.theme-option').forEach(o =>
                o.addEventListener('click', e => { e.stopPropagation(); applyTheme(o.getAttribute('data-theme')); })
            );

            const firstCard = document.querySelector('.role-card');
            const protectedBanner = document.getElementById('protectedBanner');
            if (firstCard && protectedBanner && firstCard.dataset.isSuper === '1') {
                protectedBanner.style.display = 'flex';
            }

            document.querySelectorAll('.role-form').forEach(form => {
                const roleId = form.dataset.roleId;
                if (!roleId) return;
                if (!savedGrants[roleId]) savedGrants[roleId] = [];
                if (!pendingGrants[roleId]) pendingGrants[roleId] = [];

                form.querySelectorAll('.perm-toggle:checked').forEach(input => {
                    if (!savedGrants[roleId].find(p => p.slug === input.dataset.permSlug)) {
                        savedGrants[roleId].push({ name: input.dataset.permName || '', slug: input.dataset.permSlug || '', color: input.dataset.color || '#374151' });
                    }
                });

                updateFooterMsg(roleId);
                updateFooterExtras(roleId);

                const modules = [...new Set(Array.from(form.querySelectorAll('.perm-toggle')).map(t => t.dataset.module).filter(Boolean))];
                modules.forEach(module => {
                    const sample = form.querySelector(`.perm-toggle[data-module="${module}"]`);
                    if (!sample) return;
                    syncGroupMaster(roleId, module);
                    updateGroupCount(roleId, module);
                    updateDots(roleId, module, sample.dataset.color || '#374151');
                });
            });
        });

        // ROLE CARD SELECT
        function selectRole(card) {
            document.querySelectorAll('.role-card').forEach(c => {
                c.classList.remove('active');
                const dot = c.querySelector('.active-dot');
                if (dot) dot.style.display = 'none';
                const fill = c.querySelector('.progress-fill');
                if (fill) fill.style.background = '#C4B8AF';
            });

            card.classList.add('active');
            const dot = card.querySelector('.active-dot');
            if (dot) dot.style.display = 'block';
            const fill = card.querySelector('.progress-fill');
            if (fill) fill.style.background = 'linear-gradient(90deg,#7B0D0D,#C9973A)';

            const roleId = card.dataset.roleId;
            const roleName = card.dataset.roleName || '';
            const granted = parseInt(card.dataset.granted || '0', 10);
            const total = parseInt(card.dataset.total || '0', 10);
            const pct = parseInt(card.dataset.pct || '0', 10);

            document.getElementById('accentRoleName').textContent = roleName;
            document.getElementById('accentPct').textContent = pct + '%';
            document.getElementById('accentCount').textContent = granted + ' of ' + total + ' permissions active';
            document.getElementById('accentBar').style.width = pct + '%';

            const slug = (card.dataset.slug || '').toLowerCase();
            const isSuper = ['super_admin', 'super-admin', 'superadmin'].includes(slug) || roleName.toLowerCase().includes('super');
            const banner = document.getElementById('protectedBanner');
            if (banner) banner.style.display = isSuper ? 'flex' : 'none';

            document.querySelectorAll('.role-form').forEach(f => f.style.display = 'none');
            const form = document.getElementById('form-role-' + roleId);
            if (form) form.style.display = 'block';

            const permSearch = document.getElementById('permSearch');
            if (permSearch) permSearch.value = '';
            filterPerms('');
        }

        // PERMISSION GROUP COLLAPSE
        let allExpanded = true;
        function togglePermGroup(header) {
            const body = header.nextElementSibling;
            const chev = header.querySelector('.chevron');
            const isCollapsed = body.classList.contains('collapsed');
            body.classList.toggle('collapsed');
            chev.classList.toggle('collapsed', !isCollapsed);
        }
        function toggleAllGroups() {
            const btn = document.getElementById('collapseBtn');
            const form = [...document.querySelectorAll('.role-form')].find(f => f.style.display === 'block');
            if (!form) return;
            allExpanded = !allExpanded;
            form.querySelectorAll('.perm-group-body').forEach(b => b.classList.toggle('collapsed', !allExpanded));
            form.querySelectorAll('.chevron').forEach(c => c.classList.toggle('collapsed', !allExpanded));
            btn.textContent = allExpanded ? 'Collapse All' : 'Expand All';
        }

        // PER-PERMISSION TOGGLE
        function onPermChange(input) {
            const row = input.closest('.perm-row');
            const badge = row.querySelector('.perm-status');
            const dot = row.querySelector('.perm-dot');
            const label = row.querySelector('.perm-label');
            const color = input.dataset.color;
            const roleId = input.dataset.role;
            const mSlug = input.dataset.module;
            const pName = input.dataset.permName;
            const pSlug = input.dataset.permSlug;

            if (input.checked) {
                badge.textContent = 'Granted'; badge.className = 'perm-status status-granted';
                badge.style.background = color + '18'; badge.style.color = color;
                dot.style.background = color; label.style.color = '#333333';
                row.style.background = color + '06';
                if (!pendingGrants[roleId]) pendingGrants[roleId] = [];
                if (!pendingGrants[roleId].find(p => p.slug === pSlug)) {
                    pendingGrants[roleId].push({ name: pName, slug: pSlug, color });
                }
            } else {
                badge.textContent = 'Denied'; badge.className = 'perm-status status-denied';
                badge.style.background = ''; badge.style.color = '';
                dot.style.background = '#D5CEC8'; label.style.color = '#8A7A6F';
                row.style.background = 'transparent';
                if (pendingGrants[roleId]) pendingGrants[roleId] = pendingGrants[roleId].filter(p => p.slug !== pSlug);
                if (savedGrants[roleId]) savedGrants[roleId] = savedGrants[roleId].filter(p => p.slug !== pSlug);
            }

            updateDots(roleId, mSlug, color);
            updateGroupCount(roleId, mSlug);
            syncGroupMaster(roleId, mSlug);
            updateAccentCard(roleId);
            updateFooterMsg(roleId);
            updateFooterExtras(roleId);
        }

        // ALL TOGGLE
        function toggleGroupPerms(wrapper, roleId, mSlug, currentlyAllOn) {
            const newState = !currentlyAllOn;
            wrapper.setAttribute('onclick', `event.stopPropagation(); toggleGroupPerms(this,'${roleId}','${mSlug}',${newState})`);
            const form = document.getElementById('form-role-' + roleId);
            if (!form) return;
            form.querySelectorAll(`.perm-toggle[data-module="${mSlug}"]`).forEach(t => {
                if (t.disabled) return;
                t.checked = newState;
                onPermChange(t);
            });
            const master = form.querySelector(`.group-master[data-module="${mSlug}"]`);
            if (master) master.checked = newState;
        }

        function syncGroupMaster(roleId, mSlug) {
            const form = document.getElementById('form-role-' + roleId);
            if (!form) return;
            const all = [...form.querySelectorAll(`.perm-toggle[data-module="${mSlug}"]`)];
            const checked = all.filter(t => t.checked).length;
            const master = form.querySelector(`.group-master[data-module="${mSlug}"]`);
            if (!master) return;
            master.checked = checked === all.length;
            master.indeterminate = checked > 0 && checked < all.length;
        }

        function updateDots(roleId, mSlug, color) {
            const cont = document.getElementById(`dots-${roleId}-${mSlug}`);
            if (!cont) return;
            const form = document.getElementById('form-role-' + roleId);
            if (!form) return;
            const toggles = [...form.querySelectorAll(`.perm-toggle[data-module="${mSlug}"]`)];
            const dots = cont.querySelectorAll('.dot');
            toggles.forEach((t, i) => { if (dots[i]) dots[i].style.background = t.checked ? color : '#E5DDD5'; });
        }

        function updateGroupCount(roleId, mSlug) {
            const form = document.getElementById('form-role-' + roleId);
            if (!form) return;
            const dotsEl = form.querySelector(`[id="dots-${roleId}-${mSlug}"]`);
            if (!dotsEl) return;
            const gc = dotsEl.closest('.group-card');
            if (!gc) return;
            const all = [...gc.querySelectorAll('.perm-toggle')];
            const countEl = gc.querySelector('.group-count');
            if (countEl) countEl.textContent = `${all.filter(t => t.checked).length} of ${all.length} enabled`;
        }

        function updateAccentCard(roleId) {
            const form = document.getElementById('form-role-' + roleId);
            if (!form) return;
            const all = [...form.querySelectorAll('.perm-toggle')];
            const total = all.length;
            const checked = all.filter(t => t.checked).length;
            const pct = total > 0 ? Math.round(checked / total * 100) : 0;

            document.getElementById('accentPct').textContent = pct + '%';
            document.getElementById('accentCount').textContent = `${checked} of ${total} permissions active`;
            document.getElementById('accentBar').style.width = pct + '%';

            const card = document.querySelector(`.role-card[data-role-id="${roleId}"]`);
            if (card) {
                card.querySelector('.pct-label').textContent = pct + '%';
                card.querySelector('.count-label').textContent = `${checked} of ${total} permissions`;
                card.querySelector('.progress-fill').style.width = pct + '%';
                card.dataset.granted = checked;
                card.dataset.pct = pct;
            }
        }

        function updateFooterMsg(roleId) {
            const el = document.getElementById('footer-msg-' + roleId);
            if (!el) return;
            const form = document.getElementById('form-role-' + roleId);
            if (!form) return;
            const checked = [...form.querySelectorAll('.perm-toggle')].filter(t => t.checked).length;
            const roleName = document.querySelector(`.role-card[data-role-id="${roleId}"]`)?.dataset.roleName || '';
            el.textContent = `${checked} permissions enabled for ${roleName}`;
        }

        function updateFooterExtras(roleId) {
            const pending = pendingGrants[roleId] || [];
            const chipsEl = document.getElementById('chips-' + roleId);
            const hintEl = document.getElementById('hint-' + roleId);
            const vaBtn = document.getElementById('viewas-' + roleId);
            const roleName = document.querySelector(`.role-card[data-role-id="${roleId}"]`)?.dataset.roleName || '';

            if (chipsEl) {
                chipsEl.innerHTML = '';
                if (pending.length) {
                    const col = pending[0]?.color || '#374151';
                    chipsEl.innerHTML = `<span class="grant-chip" style="background:${col}18;color:${col};border:1px solid ${col}40;">
                    <i class="fa-solid fa-circle-plus" style="font-size:9px;"></i>
                    ${pending.length} new grant${pending.length > 1 ? 's' : ''} pending for ${roleName}
                </span>`;
                }
            }
            if (hintEl) hintEl.classList.toggle('show', pending.length > 0);

            if (vaBtn) {
                const totalSavedRoles = Object.values(savedGrants).filter(a => a.length > 0).length;
                const badge = document.getElementById('va-badge-' + roleId);
                if (totalSavedRoles > 0) {
                    vaBtn.classList.add('show');
                    if (badge) badge.textContent = totalSavedRoles;
                } else {
                    vaBtn.classList.remove('show');
                    if (badge) badge.textContent = '0';
                }
            }
        }

        // AJAX SAVE
        function ajaxSaveRole(roleId) {
            const form = document.getElementById('form-role-' + roleId);
            const btn = document.getElementById('save-btn-' + roleId);
            if (!form || !btn) return;

            const checkedIds = [...form.querySelectorAll('.perm-toggle:checked')].map(t => t.value);

            const csrf = document.querySelector('meta[name="csrf-token"]')?.content
                || form.querySelector('input[name="_token"]')?.value
                || '{{ csrf_token() }}';

            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin" style="font-size:13px;"></i> Saving…';

            fetch('{{ route("admin.role_permissions.update") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body: JSON.stringify({ role_id: roleId, permissions: checkedIds })
            })
                .then(async res => {
                    const data = await res.json().catch(() => ({}));
                    if (!res.ok) throw new Error(data.message || 'Server error ' + res.status);
                    return data;
                })
                .then(data => {
                    // Move pending → saved
                    const pending = pendingGrants[roleId] || [];
                    if (!savedGrants[roleId]) savedGrants[roleId] = [];
                    pending.forEach(p => {
                        if (!savedGrants[roleId].find(s => s.slug === p.slug)) savedGrants[roleId].push(p);
                    });
                    pendingGrants[roleId] = [];

                    // Update View As badges
                    document.querySelectorAll('[id^="viewas-"]').forEach(vbtn => {
                        const rid = vbtn.id.replace('viewas-', '');
                        const total = Object.values(savedGrants).filter(a => a.length > 0).length;
                        const badge = document.getElementById('va-badge-' + rid);
                        if (total > 0) { vbtn.classList.add('show'); if (badge) badge.textContent = total; }
                        else { vbtn.classList.remove('show'); if (badge) badge.textContent = '0'; }
                    });

                    updateFooterMsg(roleId);
                    updateFooterExtras(roleId);

                    showToast('Saved!', `Permissions updated successfully.`, 'success');
                })
                .catch(err => {
                    showToast('Error', err.message || 'Could not save permissions.', 'error');
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-floppy-disk" style="font-size:13px;"></i> Save Changes';
                });
        }

        // RESET DEFAULTS
        function ajaxResetDefaults() {
            document.getElementById('resetConfirmOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeResetConfirm() {
            document.getElementById('resetConfirmOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }

        function confirmResetDefaults() {
            const btn = document.getElementById('resetDefaultsBtn');
            const confirmBtn = document.getElementById('resetConfirmBtn');
            if (!confirmBtn) return;

            const csrf = document.querySelector('meta[name="csrf-token"]')?.content
                || '{{ csrf_token() }}';

            confirmBtn.disabled = true;
            confirmBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin" style="font-size:12px;"></i> Resetting…';

            fetch('{{ route("admin.role_permissions.reset") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body: JSON.stringify({})
            })
                .then(async res => {
                    const data = await res.json().catch(() => ({}));
                    if (!res.ok) throw new Error(data.message || 'Server error ' + res.status);
                    return data;
                })
                .then(() => {
                    closeResetConfirm();
                    showToast('Defaults Restored', 'All permissions have been reset to their defaults.', 'success');
                    setTimeout(() => window.location.reload(), 2000);
                })
                .catch(err => {
                    closeResetConfirm();
                    showToast('Error', err.message || 'Could not reset permissions.', 'error');
                })
                .finally(() => {
                    confirmBtn.disabled = false;
                    confirmBtn.innerHTML = '<i class="fa-solid fa-rotate-left" style="font-size:12px;"></i> Yes, Reset';
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa-solid fa-rotate-left" style="font-size:12px; margin-right:4px;"></i> Reset Defaults';
                    }
                });
        }

        function filterPerms(q) {
            q = q.toLowerCase().trim();
            const form = [...document.querySelectorAll('.role-form')].find(f => f.style.display === 'block');
            if (!form) return;
            form.querySelectorAll('.perm-row').forEach(row => {
                row.style.display = (!q || (row.dataset.permSearch || '').includes(q)) ? '' : 'none';
            });
            form.querySelectorAll('.perm-group').forEach(group => {
                const visible = [...group.querySelectorAll('.perm-row')].some(r => r.style.display !== 'none');
                group.style.display = visible ? '' : 'none';
                if (q && visible) { const b = group.querySelector('.perm-group-body'); if (b) b.classList.remove('collapsed'); }
            });
        }

        function openViewAs() {
            const overlay = document.getElementById('vaOverlay');
            const list = document.getElementById('vaRoleList');
            if (!overlay || !list) return;
            list.innerHTML = '';
            let totalPerms = 0, totalRoles = 0;

            document.querySelectorAll('.role-card').forEach(card => {
                const roleId = card.dataset.roleId;
                const roleName = card.dataset.roleName || 'Role';
                const roleSlug = (card.dataset.slug || '').toLowerCase();
                const granted = parseInt(card.dataset.granted || '0', 10);
                if (granted <= 0) return;

                const form = document.getElementById(`form-role-${roleId}`);
                if (!form) return;

                const checkedPerms = [...form.querySelectorAll('.perm-toggle:checked')].map(input => ({
                    name: input.dataset.permName || input.closest('.perm-row')?.querySelector('.perm-label')?.textContent?.trim() || 'Permission',
                    slug: input.dataset.permSlug || '',
                    color: input.dataset.color || '#374151'
                }));
                if (!checkedPerms.length) return;

                totalRoles++; totalPerms += checkedPerms.length;
                const words = roleName.split(' ').slice(0, 2);
                const initials = words.map(w => w[0].toUpperCase()).join('');
                const color = checkedPerms[0]?.color || '#374151';
                const grad = `linear-gradient(135deg,${color},${hexDarken(color)})`;
                const isSuperAdmin = ['super_admin', 'super-admin', 'superadmin'].includes(roleSlug) || roleName.toLowerCase().includes('super');

                const tags = checkedPerms.map(p => `<span class="va-perm-tag" style="background:${color}18;color:${color};border:1px solid ${color}40;"><i class="fa-solid fa-circle-check" style="font-size:8px;"></i> ${p.name}</span>`).join('');
                const goBtn = !isSuperAdmin ? `<button class="va-go-btn va-redirect-btn" data-role-id="${roleId}" data-role-name="${roleName}" data-role-slug="${roleSlug}" data-color="${color}"><i class="fa-solid fa-arrow-right" style="font-size:11px;"></i> Go to Dashboard</button>` : '';

                list.innerHTML += `
            <div class="va-role-row ${!isSuperAdmin ? 'va-redirect-btn' : ''}" data-role-id="${roleId}" data-role-name="${roleName}" data-role-slug="${roleSlug}" data-color="${color}" style="${isSuperAdmin ? 'cursor:default;' : ''}">
                <div style="position:absolute;left:0;top:0;bottom:0;width:4px;background:${grad};border-radius:14px 0 0 14px;"></div>
                <div class="va-role-avatar" style="background:${grad};color:#fff;">${initials}</div>
                <div style="flex:1;">
                    <div style="font-size:14px;font-weight:700;color:#333333;margin-bottom:3px;">${roleName}</div>
                    <div style="font-size:12px;color:#8A7A6F;">${checkedPerms.length} permission${checkedPerms.length > 1 ? 's' : ''} granted</div>
                    <div style="display:flex;flex-wrap:wrap;gap:5px;margin-top:7px;">${tags}</div>
                </div>
                ${goBtn}
            </div>`;
            });

            list.querySelectorAll('.va-redirect-btn').forEach(el => {
                el.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const t = this.closest('[data-role-id]') || this;
                    redirectToRole(t.dataset.roleId, t.dataset.roleName, t.dataset.roleSlug, t.dataset.color);
                });
            });

            document.getElementById('vaTotalPerms').textContent = totalPerms;
            document.getElementById('vaTotalRoles').textContent = totalRoles;
            document.getElementById('vaSubtitle').textContent = `${totalRoles} role${totalRoles > 1 ? 's' : ''} with granted access — select one to redirect`;
            overlay.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeViewAs() {
            const overlay = document.getElementById('vaOverlay');
            if (overlay) overlay.classList.remove('open');
            document.body.style.overflow = '';
        }

        function redirectToRole(roleId, roleName, roleSlug, color) {
            if (roleSlug === 'patient') { closeViewAs(); openPatientPicker(roleName, roleSlug, color); return; }
            closeViewAs();
            const ol = document.getElementById('redirectOverlay');
            ol.style.background = `linear-gradient(135deg,${color},${hexDarken(color)})`;
            document.getElementById('redirectText').textContent = `Redirecting to ${roleName} Dashboard…`;
            document.getElementById('redirectSub').textContent = `Loading ${roleName} view for Super Admin`;
            ol.classList.add('show');

            fetch("{{ route('admin.impersonate') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ role: roleSlug })
            })
                .then(async res => { const d = await res.json(); if (!res.ok) throw new Error(d.message || 'Error'); if (d.redirect) { window.location.href = d.redirect; return; } throw new Error('No redirect'); })
                .catch(err => { ol.classList.remove('show'); showToast('Error', err.message || 'Something went wrong', 'error'); });
        }

        document.getElementById('newRoleName')?.addEventListener('input', function () {
            document.getElementById('newRoleSlug').value = this.value.toLowerCase().trim()
                .replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
        });
        function openNewRoleModal() {
            const modal = document.getElementById('newRoleModal');
            modal.style.display = 'flex';
            // Trigger fade in on next frame
            requestAnimationFrame(() => requestAnimationFrame(() => modal.classList.add('modal-visible')));
        }

        function closeNewRoleModal() {
            const modal = document.getElementById('newRoleModal');
            modal.classList.remove('modal-visible');
            // Wait for fade out to finish before hiding
            setTimeout(() => {
                modal.style.display = 'none';
                document.getElementById('newRoleName').value = '';
                document.getElementById('newRoleSlug').value = '';
                document.getElementById('newRoleError').style.display = 'none';
            }, 250);
        }
        function createNewRole() {
            const name = document.getElementById('newRoleName').value.trim();
            const slug = document.getElementById('newRoleSlug').value.trim();
            const errEl = document.getElementById('newRoleError');
            if (!name) { errEl.textContent = 'Please enter a role name.'; errEl.style.display = 'block'; return; }
            if (!slug) { errEl.textContent = 'Please enter a slug.'; errEl.style.display = 'block'; return; }
            if (document.querySelector(`.role-card[data-slug="${slug}"]`)) { errEl.textContent = 'A role with this slug already exists.'; errEl.style.display = 'block'; return; }
            errEl.style.display = 'none';
            document.getElementById('createRoleName').value = name;
            document.getElementById('createRoleSlug').value = slug;
            document.getElementById('createRoleForm').submit();
        }

        function hexDarken(hex) {
            const r = parseInt(hex.slice(1, 3), 16), g = parseInt(hex.slice(3, 5), 16), b = parseInt(hex.slice(5, 7), 16);
            return '#' + Math.max(0, r - 45).toString(16).padStart(2, '0') + Math.max(0, g - 45).toString(16).padStart(2, '0') + Math.max(0, b - 45).toString(16).padStart(2, '0');
        }

        function showToast(title, sub, type = 'success') {
            const t = document.getElementById('toastPop');
            const icon = document.getElementById('toastIconEl');
            document.getElementById('toastTitle').textContent = title;
            document.getElementById('toastSub').textContent = sub;
            t.classList.remove('toast-error');
            if (type === 'error') {
                t.classList.add('toast-error');
                icon.className = 'fa-solid fa-circle-exclamation';
            } else {
                icon.className = 'fa-solid fa-circle-check';
            }
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 4500);
        }

        // DELETE ROLE MODAL
        const PROTECTED_ROLE_SLUGS = ['admin', 'patient', 'dentist', 'super_admin', 'super-admin', 'superadmin'];
        let deleteTargetRoleId = null;

        function openDeleteModal(roleId, roleName) {
            const card = document.querySelector(`.role-card[data-role-id="${roleId}"]`);
            const slug = (card?.dataset.slug || '').toLowerCase().trim();
            if (PROTECTED_ROLE_SLUGS.includes(slug)) { showToast('Protected Role', `"${roleName}" is a built-in role and cannot be deleted.`, 'error'); return; }
            deleteTargetRoleId = roleId;
            document.getElementById('deleteRoleName').textContent = roleName;
            document.getElementById('deleteRoleError').style.display = 'none';
            document.getElementById('deleteRoleForm').action = `/admin/role-permissions/${roleId}/destroy`;
            document.getElementById('deleteRoleOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeDeleteModal() {
            document.getElementById('deleteRoleOverlay').classList.remove('open');
            document.body.style.overflow = '';
            deleteTargetRoleId = null;
        }

        // PATIENT PICKER
        let patientAccountsCache = [];

        function escapeHtml(v) {
            return String(v).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
        }
        function closePatientPicker() {
            const o = document.getElementById('patientPickerOverlay');
            if (o) o.classList.remove('open');
            document.body.style.overflow = '';
        }
        function openPatientPicker(roleName, roleSlug, color) {
            fetch("{{ route('admin.patients.list') }}", { method: 'GET', headers: { 'Accept': 'application/json' } })
                .then(async res => { const d = await res.json(); if (!res.ok) throw new Error(d.message || 'Error'); patientAccountsCache = Array.isArray(d) ? d : []; renderPatientPicker(patientAccountsCache); document.getElementById('patientPickerSearch').value = ''; document.getElementById('patientPickerOverlay').classList.add('open'); document.body.style.overflow = 'hidden'; })
                .catch(err => showToast('Error', err.message || 'Unable to load patients', 'error'));
        }
        function renderPatientPicker(patients) {
            const list = document.getElementById('patientPickerList');
            if (!list) return;
            if (!patients.length) { list.innerHTML = '<div style="text-align:center;padding:32px 20px;color:#8A7A6F;font-size:14px;">No patient accounts found.</div>'; return; }
            list.innerHTML = patients.map(p => {
                const n = (p.name || 'Patient').replace(/'/g, "\\'");
                const i = (p.name || 'P').charAt(0).toUpperCase();
                return `<div class="va-role-row" data-patient-search="${((p.name || '') + ' ' + (p.email || '')).toLowerCase()}">
                <div class="va-role-avatar" style="background:linear-gradient(135deg,#065F46,#047857);color:#fff;">${i}</div>
                <div style="flex:1;">
                    <div style="font-size:14px;font-weight:700;color:#333333;margin-bottom:3px;">${escapeHtml(p.name || 'Unnamed Patient')}</div>
                    <div style="font-size:12px;color:#8A7A6F;">${escapeHtml(p.email || '')}</div>
                    <div style="font-size:12px;color:#B5A99A;margin-top:4px;">ID: ${p.id}${p.phone ? ' • ' + escapeHtml(p.phone) : ''}</div>
                </div>
                <button type="button" class="va-go-btn" onclick="event.stopPropagation(); startPatientImpersonation('patient','patient','#065F46',${p.id},'${n}')">
                    <i class="fa-solid fa-arrow-right" style="font-size:11px;"></i> Impersonate
                </button>
            </div>`;
            }).join('');
        }
        function filterPatientPicker(q) {
            q = q.toLowerCase().trim();
            if (!q) { renderPatientPicker(patientAccountsCache); return; }
            const filtered = patientAccountsCache.filter(p => ((p.name || '') + (p.email || '')).toLowerCase().includes(q));
            if (!filtered.length) {
                document.getElementById('patientPickerList').innerHTML = `<div style="text-align:center;padding:32px 20px;color:#8A7A6F;"><div style="font-size:16px;font-weight:700;color:#7B0D0D;margin-bottom:8px;">No results for "${escapeHtml(q)}"</div><div style="font-size:14px;">Try a different patient name.</div></div>`;
                return;
            }
            renderPatientPicker(filtered);
        }
        function clearPatientSearch() {
            const inp = document.getElementById('patientPickerSearch');
            if (inp) { inp.value = ''; filterPatientPicker(''); }
        }
        function startPatientImpersonation(roleName, roleSlug, color, patientId, patientName) {
            closePatientPicker();
            const ol = document.getElementById('redirectOverlay');
            ol.style.background = `linear-gradient(135deg,${color},${hexDarken(color)})`;
            document.getElementById('redirectText').textContent = `Redirecting as ${patientName}…`;
            document.getElementById('redirectSub').textContent = 'Loading patient dashboard for Super Admin';
            ol.classList.add('show');
            fetch("{{ route('admin.impersonate') }}", {
                method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ role: roleSlug, patient_id: patientId })
            })
                .then(async res => { const d = await res.json(); if (!res.ok) throw new Error(d.message || 'Error'); if (d.redirect) { window.location.href = d.redirect; return; } throw new Error('No redirect'); })
                .catch(err => { ol.classList.remove('show'); showToast('Error', err.message || 'Something went wrong', 'error'); });
        }

        // KEYBOARD SHORTCUTS
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                closeViewAs(); closeDeleteModal(); closePatientPicker(); closeResetConfirm();
                if (document.getElementById('newRoleModal').style.display !== 'none') closeNewRoleModal();
            }
        });
    </script>
@endsection