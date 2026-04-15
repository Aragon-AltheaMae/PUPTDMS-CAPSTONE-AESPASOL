@extends('layouts.admin')

@section('title', 'System Logs | PUP Taguig Dental Clinic')

@section('styles')
    <style>
        @keyframes sl-pulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, .5);
            }

            50% {
                box-shadow: 0 0 0 4px rgba(16, 185, 129, 0);
            }
        }

        @keyframes sl-shimmer {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

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

        @keyframes slNewRowSlideIn {
            0% {
                opacity: 0;
                transform: translateY(-8px);
                background: rgba(16, 185, 129, .20);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
                background: transparent;
            }
        }

        [data-theme="dark"] .sl-row-new {
            animation: slNewRowFlashDark 1.2s ease;
        }

        @keyframes slNewRowFlashDark {
            0% {
                background: rgba(16, 185, 129, .18);
                transform: scale(1.01);
            }

            40% {
                background: rgba(16, 185, 129, .10);
            }

            100% {
                background: transparent;
                transform: scale(1);
            }
        }

        /* Page Banner */
        .page-banner {
            background: linear-gradient(135deg, var(--crimson-dark) 0%, var(--crimson) 60%, #c0392b 100%);
            padding: 1.75rem 2rem 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(139, 0, 0, .25);
        }

        .page-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
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

        .page-title {
            font-size: 2rem;
            font-weight: 900;
            color: #fff !important;
            line-height: 1.1;
            letter-spacing: -.02em;
        }
 
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.25rem 1.4rem;
            border: 1px solid rgba(0, 0, 0, .05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, .06);
            transition: transform .2s, box-shadow .2s;
            position: relative;
            overflow: hidden;
            animation: fadeSlideUp .4s ease both;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, .1);
        }

        .stat-card:nth-child(1) {
            animation-delay: .05s;
        }

        .stat-card:nth-child(2) {
            animation-delay: .10s;
        }

        .stat-card:nth-child(3) {
            animation-delay: .15s;
        }

        .stat-card:nth-child(4) {
            animation-delay: .20s;
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
            color: #757575;
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
            color: #757575;
            display: flex;
            align-items: center;
            gap: .35rem;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, .05);
            box-shadow: 0 2px 12px rgba(0, 0, 0, .04);
            overflow: visible;
            animation: fadeSlideUp .4s ease .2s both;
        }

        .card-header {
            padding: .9rem 1.25rem;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fafafa;
            position: relative;
            z-index: 20;
            gap: .75rem;
            flex-wrap: wrap;
        }

        .card-header-left {
            display: flex;
            align-items: center;
            gap: .6rem;
            flex-shrink: 0;
        }

        .card-header-right {
            display: flex;
            align-items: center;
            gap: .6rem;
            flex-wrap: wrap;
            flex: 1 1 auto;
            justify-content: flex-end;
        }

        .card-header-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--crimson-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: var(--crimson);
            flex-shrink: 0;
        }

        .card-title {
            font-size: 1rem;
            font-weight: 800;
            color: #1a202c;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: .76rem;
            table-layout: fixed;
        }

        .data-table thead th {
            padding: .7rem 1rem;
            text-align: left;
            font-weight: 700;
            color: #757575;
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

        /* ── Search ── */
        .search-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #FAFAF9;
            border: 1.5px solid #E0DDD8;
            border-radius: 12px;
            padding: 0 14px;
            height: 38px;
            transition: border-color .2s, box-shadow .2s;
            min-width: 0;
            flex-shrink: 1;
        }

        .search-wrap:focus-within {
            border-color: var(--crimson);
            box-shadow: 0 0 0 3px rgba(139, 0, 0, .1);
        }

        .search-wrap i {
            color: var(--crimson);
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

        /* ── Tab group ── */
        .tab-group {
            display: flex;
            background: #F5F2EE;
            border: 1px solid #E8E4DE;
            border-radius: 10px;
            padding: 3px;
            gap: 2px;
            flex-shrink: 0;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .tab-btn {
            padding: 6px 14px;
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
            background: var(--crimson);
            color: #fff;
            box-shadow: 0 2px 8px rgba(139, 0, 0, .3);
        }

        /* ── Live badge ── */
        .sl-live {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .72rem;
            font-weight: 600;
            color: #059669;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            padding: .3rem .7rem;
            border-radius: 99px;
            white-space: nowrap;
        }

        .sl-live-dot {
            width: 7px;
            height: 7px;
            background: #10b981;
            border-radius: 50%;
            animation: sl-pulse 2s infinite;
        }

        .sl-view-toggle {
            display: inline-flex;
            align-items: center;
            background: #FAFAF9;
            border: 1.5px solid #E0DDD8;
            border-radius: 12px;
            padding: 3px;
            gap: 3px;
            height: 38px;
        }

        .sl-view-toggle-btn {
            width: 32px;
            height: 30px;
            padding: 0;
            border: none;
            background: transparent;
            color: #6b7280;
            border-radius: 9px;
            font-size: .82rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .15s ease;
            flex-shrink: 0;
        }

        .sl-view-toggle-btn:hover {
            background: #f3f4f6;
            color: #8B0000;
        }

        .sl-view-toggle-btn.active {
            background: #8B0000;
            color: #fff;
            box-shadow: 0 2px 8px rgba(139, 0, 0, .15);
        }

        .sl-view[hidden] {
            display: none !important;
        }

        .sl-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
            padding: 1rem;
        }

        .sl-grid-card {
            background: #fff;
            border: 1px solid #f0f0f0;
            border-radius: 16px;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: .85rem;
            transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
            min-width: 0;
        }

        .sl-grid-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, .06);
            border-color: #ead6d6;
        }

        .sl-grid-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: .75rem;
        }

        .sl-grid-id {
            font-size: .72rem;
            font-weight: 800;
            color: #8B0000;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        }

        .sl-grid-meta {
            display: grid;
            gap: .65rem;
        }

        .sl-grid-field {
            min-width: 0;
        }

        .sl-grid-label {
            font-size: .64rem;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: .28rem;
        }

        .sl-grid-value {
            font-size: .8rem;
            color: #374151;
            line-height: 1.35;
            min-width: 0;
            word-break: break-word;
        }

        /* ── Log cell styles ── */
        .sl-id {
            font-size: .7rem;
            font-weight: 500;
            color: #757575;
            background: #f3f4f6;
            padding: .18rem .48rem;
            border-radius: 6px;
            display: inline-block;
        }

        .sl-date-day {
            font-weight: 600;
            color: #333333;
            font-size: .78rem;
            display: block;
            margin-right: 8px;
        }

        .sl-date-time {
            font-size: .65rem;
            color: #757575;
            display: block;
            margin-top: 1px;
        }

        .sl-role {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            padding: .25rem .6rem;
            border-radius: 8px;
            font-size: .7rem;
            font-weight: 700;
        }

        .sl-role i {
            font-size: .62rem;
        }

        .sl-role.admin {
            background: #fff0f0;
            color: #c0392b;
            border: 1px solid #fecaca;
        }

        .sl-role.dentist {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
        }

        .sl-role.patient {
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }

        .sl-user {
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .sl-avatar {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .68rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .sl-avatar.admin {
            background: #fef2f2;
            color: #8B0000;
        }

        .sl-avatar.dentist {
            background: #eff6ff;
            color: #2563eb;
        }

        .sl-avatar.patient {
            background: #ecfdf5;
            color: #059669;
        }

        .sl-username {
            font-weight: 600;
            color: #333333;
            font-size: .78rem;
            white-space: nowrap;
        }

        .sl-action {
            display: inline-flex;
            align-items: center;
            gap: .28rem;
            padding: .22rem .55rem;
            border-radius: 7px;
            font-size: .72rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .sl-action i {
            font-size: .6rem;
        }

        .sl-action.login {
            background: #fefdee;
            color: #988f0d;
        }

        .sl-action.logout {
            background: #fff7ed;
            color: #ea580c;
        }

        .sl-action.create {
            background: #eff6ff;
            color: #2563eb;
        }

        .sl-action.update {
            background: #faf5ff;
            color: #7c3aed;
        }

        .sl-action.delete {
            background: #fff0f0;
            color: #c0392b;
        }

        .sl-action.default {
            background: #f1f5f9;
            color: #475569;
        }

        .sl-module {
            font-size: .74rem;
            color: #333;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: .3rem;
            white-space: normal;
            word-break: break-word;
            max-width: 130px;
            line-height: 1.35;
        }

        .sl-module i {
            color: #8B0000;
            font-size: .65rem;
            flex-shrink: 0;
        }

        .sl-desc {
            color: #333;
            font-size: .76rem;
            max-width: 240px;
            line-height: 1.45;
            white-space: normal;
            word-break: break-word;
        }

        .sl-desc strong {
            color: #333333;
            font-weight: 600;
        }

        .sl-pagebar {
            padding: .85rem 1.4rem;
            border-top: 1px solid #f3f4f6;
            background: #fafafa;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .75rem;
            flex-wrap: wrap;
        }

        .sl-pagebar-info {
            font-size: .73rem;
            color: #757575;
            font-weight: 500;
        }

        .sl-pagebar-info strong {
            color: #333333;
        }

        .sl-row-new {
            animation: slNewRowSlideIn .8s ease;
        }

        .sl-filter-wrap {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .sl-filter-btn {
            height: 38px;
            padding: 0 14px;
            border-radius: 12px;
            border: 1.5px solid #E0DDD8;
            background: #FAFAF9;
            color: #6b7280;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all .2s;
        }

        .sl-filter-btn:hover,
        .sl-filter-btn.active {
            border-color: #8B0000;
            color: #8B0000;
            background: #fef2f2;
        }

        .sl-filter-panel {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 320px;
            background: #fff;
            border: 1px solid #ececec;
            border-radius: 16px;
            box-shadow: 0 14px 40px rgba(0, 0, 0, .12);
            padding: 14px;
            z-index: 60;
        }

        .sl-filter-panel.hidden {
            display: none;
        }

        .sl-filter-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 13px;
            font-weight: 800;
            color: #333333;
        }

        .sl-filter-close {
            width: 28px;
            height: 28px;
            border: none;
            background: #f3f4f6;
            border-radius: 8px;
            cursor: pointer;
            color: #6b7280;
        }

        .sl-filter-grid {
            display: grid;
            gap: 10px;
        }

        .sl-filter-group {
            display: grid;
            gap: 6px;
        }

        .sl-filter-group label {
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
        }

        .sl-filter-select,
        .sl-filter-input {
            width: 100%;
            height: 38px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 0 11px;
            font-size: 12px;
            outline: none;
            background: #fff;
            color: #333333;
        }

        .sl-filter-select:focus,
        .sl-filter-input:focus {
            border-color: #8B0000;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, .08);
        }

        .sl-filter-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 14px;
        }

        .sl-filter-reset,
        .sl-filter-apply {
            height: 36px;
            padding: 0 14px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .sl-filter-reset {
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #6b7280;
        }

        .sl-filter-apply {
            border: none;
            background: #8B0000;
            color: #fff;
        }

        .sl-clear-filter-btn {
            height: 38px;
            padding: 0 14px;
            border-radius: 12px;
            border: 1.5px dashed #fca5a5;
            background: #fff7f7;
            color: #b91c1c;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all .2s;
        }

        .sl-clear-filter-btn:hover {
            background: #fef2f2;
            border-color: #dc2626;
            color: #8B0000;
        }

        .sl-clear-filter-btn.hidden {
            display: none;
        }


        [data-theme="dark"] .stat-card,
        [data-theme="dark"] .card {
            background: #161b22 !important;
            border-color: #21262d !important;
        }

        [data-theme="dark"] .card-header {
            background: #0d1117 !important;
            border-color: #21262d !important;
        }

        [data-theme="dark"] .card-title,
        [data-theme="dark"] .stat-value {
            color: #f3f4f6;
        }

        [data-theme="dark"] .data-table thead th {
            background: #0d1117;
            border-color: #21262d;
        }

        [data-theme="dark"] .data-table tbody td {
            color: #d1d5db;
            border-color: #1c2128;
        }

        [data-theme="dark"] .data-table tbody tr:hover td {
            background: #1c2128;
        }

        [data-theme="dark"] .sl-clear-filter-btn {
            background: #2a1215;
            border-color: #7f1d1d;
            color: #fca5a5;
        }

        [data-theme="dark"] .sl-filter-panel {
            background: #161b22;
            border-color: #21262d;
        }

        [data-theme="dark"] .sl-filter-head {
            color: #f3f4f6;
        }

        [data-theme="dark"] .sl-filter-close {
            background: #0d1117;
            color: #757575;
        }

        [data-theme="dark"] .sl-filter-select,
        [data-theme="dark"] .sl-filter-input {
            background: #0d1117;
            border-color: #21262d;
            color: #e5e7eb;
        }

        [data-theme="dark"] .sl-filter-reset {
            background: #0d1117;
            border-color: #21262d;
            color: #757575;
        }

        [data-theme="dark"] #slTable tbody tr {
            background: #161b22;
            border-color: #21262d;
        }

        @media (max-width: 767px) {

            /* Banner */
            .page-banner {
                border-radius: 14px !important;
                padding: 1.1rem 1.1rem 1.4rem !important;
            }

            .page-title {
                font-size: 1.45rem !important;
            }

            .page-banner-inner {
                flex-direction: column;
                gap: .6rem;
            }

            /* Stat grid → 2 columns */
            .stat-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: .75rem;
            }

            .stat-value {
                font-size: 1.8rem !important;
            }

            .stat-footer {
                display: none;
            }

            /* ── Card header: stack vertically ── */
            .card-header {
                flex-direction: column;
                align-items: stretch !important;
                padding: .75rem 1rem;
                gap: .65rem;
            }

            .card-header-left {
                width: 100%;
            }

            .card-header-right {
                width: 100%;
                flex-direction: column;
                align-items: stretch;
                gap: .55rem;
                justify-content: flex-start;
            }

            /* Search → full width */
            .search-wrap {
                width: 100% !important;
                min-width: 0;
                height: 42px;
                padding: 0 12px;
            }

            .search-wrap input {
                font-size: 14px;
            }

            /* Filter row → two equal buttons side by side */
            .sl-filter-wrap {
                width: 100%;
                display: flex;
                gap: 8px;
            }

            .sl-filter-btn {
                flex: 1;
                height: 42px;
                justify-content: center;
            }

            .sl-clear-filter-btn {
                flex: 1;
                height: 42px;
                justify-content: center;
                min-width: 0;
            }

            /* Filter panel → full width, positioned better on mobile */
            .sl-filter-panel {
                position: absolute;
                top: calc(100% + 8px);
                left: 0;
                right: auto;
                bottom: auto;
                width: 100%;
                min-width: 0;
                border-radius: 16px;
                max-height: none;
                overflow-y: visible;
                z-index: 9999;
            }

            /* Tab strip → scrollable */
            .flex.gap-1.px-5.py-2\\.5 {
                padding-left: .75rem !important;
                padding-right: .75rem !important;
            }

            .tab-btn {
                padding: 5px 10px;
                font-size: 11px;
            }

            /* Pagebar → wrap naturally */
            .sl-pagebar {
                flex-direction: column;
                align-items: flex-start;
                gap: .6rem;
                padding: .75rem 1rem;
            }

            .sl-pagination-wrap {
                width: 100%;
                overflow-x: auto;
            }

            .sl-pagination-wrap nav {
                width: max-content;
            }

            /* ── Table → card-per-row layout ── */
            #slTable thead {
                display: none;
            }

            #slTable tbody tr {
                display: grid;
                grid-template-columns: 1fr auto;
                grid-template-rows: auto auto auto auto;
                column-gap: .5rem;
                row-gap: .3rem;
                margin: .75rem;
                border-radius: 12px;
                border: 1px solid #f0f0f0;
                box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
                background: #fff;
                padding: .85rem .9rem;
            }

            #slTable tbody tr:hover {
                background: #fafbff;
            }

            /* Hide all cells by default, then reveal selectively */
            #slTable tbody td {
                display: none;
                border: none !important;
                padding: 0 !important;
            }

            /* Col 1 → ID  (row 1, col 1) */
            #slTable tbody td:nth-child(1) {
                display: flex;
                align-items: center;
                grid-column: 1;
                grid-row: 1;
            }

            /* Col 2 → Timestamp  (row 1, col 2 – right-aligned) */
            #slTable tbody td:nth-child(2) {
                display: flex;
                align-items: flex-start;
                justify-content: flex-end;
                grid-column: 2;
                grid-row: 1;
            }

            /* Col 3 → Role  (row 2, col 1–2) */
            #slTable tbody td:nth-child(3) {
                display: flex;
                align-items: center;
                grid-column: 1 / -1;
                grid-row: 2;
            }

            /* Col 4 → User  (row 3, col 1) */
            #slTable tbody td:nth-child(4) {
                display: flex;
                align-items: center;
                grid-column: 1;
                grid-row: 3;
            }

            /* Col 5 → Action  (row 3, col 2 – right-aligned) */
            #slTable tbody td:nth-child(5) {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                grid-column: 2;
                grid-row: 3;
            }

            /* Col 6 → Module: hide on mobile (saves space) */
            #slTable tbody td:nth-child(6) {
                display: none;
            }

            /* Col 7 → Description  (row 4, full width, with top divider) */
            #slTable tbody td:nth-child(7) {
                display: block;
                grid-column: 1 / -1;
                grid-row: 4;
                padding-top: .55rem !important;
                margin-top: .15rem;
                border-top: 1px solid #f3f4f6 !important;
            }

            .sl-desc {
                max-width: 100%;
                font-size: .72rem;
                color: #6b7280;
            }

            #slTable {
                border-collapse: separate;
                border-spacing: 0;
            }

            [data-theme="dark"] #slTable tbody tr {
                background: #161b22;
                border-color: #21262d;
            }

            [data-theme="dark"] #slTable tbody td:nth-child(7) {
                border-color: #21262d !important;
            }

            /* Per-page + info row */
            .flex.items-center.gap-3.flex-wrap {
                gap: .4rem;
            }

            #entryBadge {
                white-space: nowrap;
            }

            /* Table columns not needed */
            .data-table thead th {
                padding: .5rem;
                font-size: .6rem;
            }

            .data-table tbody td {
                padding: .6rem .5rem;
                font-size: .72rem;
            }

            #slListView {
                display: none !important;
            }

            #slGridView {
                display: block !important;
            }

            #slViewToggle {
                display: none !important;
            }

            .sl-grid {
                grid-template-columns: 1fr;
                padding: .85rem;
                gap: .85rem;
            }
        }

        @media (max-width: 480px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: .5rem;
            }

            .stat-card {
                padding: 1rem;
            }

            .stat-value {
                font-size: 1.6rem !important;
            }

            .stat-badge {
                display: none;
            }

            .page-title {
                font-size: 1.25rem !important;
            }

            .card-header {
                padding: .65rem .75rem;
            }

            .tab-btn .tab-count-label {
                display: none;
            }

            .sl-filter-panel {
                width: 100%;
                left: 0;
            }

            #slTable tbody tr {
                margin: .5rem;
                padding: .75rem .75rem;
            }
        }
    </style>
@endsection

@section('content')

    @php
        $logs = $logs ?? collect([]);
        $perPage = $perPage ?? 20;
    @endphp

    <main id="mainContent" class="px-4 sm:px-6 pt-[82px] pb-8 min-h-screen">
        <div class="max-w-[1280px] mx-auto">

            <!-- Page Banner -->
            <div class="page-banner rounded-2xl mb-6">
                <div class="page-banner-inner">
                    <div>
                        <h1 class="page-title">System Logs</h1>
                    </div>

                    <div class="flex items-center gap-3 flex-shrink-0">
                        <span class="sl-live">
                            <span class="sl-live-dot"></span> Live Monitoring
                        </span>

                        <div class="sl-view-toggle" id="slViewToggle">
                            <button type="button"
                                class="sl-view-toggle-btn active"
                                id="slListViewBtn"
                                title="List view"
                                aria-label="List view">
                                <i class="fa-solid fa-table-list"></i>
                            </button>
                            <button type="button"
                                class="sl-view-toggle-btn"
                                id="slGridViewBtn"
                                title="Grid view"
                                aria-label="Grid view">
                                <i class="fa-solid fa-grip"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- STAT CARDS --}}
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-card-accent" style="background:linear-gradient(90deg,var(--crimson),#c0392b);"></div>
                    <div class="stat-top">
                        <div class="stat-icon" style="background:#fef2f2;">
                            <i class="fa-solid fa-clipboard-list" style="color:var(--crimson);"></i>
                        </div>
                        <span class="stat-badge" style="background:#fef2f2;color:var(--crimson);">Total</span>
                    </div>
                    <div class="stat-label">Total Logs</div>
                    <div class="stat-value" id="statTotal">{{ $totalCount }}</div>
                    <div class="stat-footer"><i class="fa-solid fa-list" style="font-size:.65rem;color:var(--crimson);"></i>
                        All recorded activity</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-accent" style="background:linear-gradient(90deg,#af2626,#fca5a5);"></div>
                    <div class="stat-top">
                        <div class="stat-icon" style="background:#fef2f2;"><i class="fa-solid fa-user-tie"
                                style="color:#af2626;"></i></div>
                        <span class="stat-badge" style="background:#fef2f2;color:#af2626;">Admin</span>
                    </div>
                    <div class="stat-label">Admin Actions</div>
                    <div class="stat-value" id="statAdmin" style="color:#af2626;">{{ $adminCount }}</div>
                    <div class="stat-footer"><i class="fa-solid fa-shield" style="font-size:.65rem;color:#af2626;"></i>
                        Administrator activity</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-accent" style="background:linear-gradient(90deg,#3b82f6,#93c5fd);"></div>
                    <div class="stat-top">
                        <div class="stat-icon" style="background:#eff6ff;"><i class="fa-solid fa-user-doctor"
                                style="color:#3b82f6;"></i></div>
                        <span class="stat-badge" style="background:#eff6ff;color:#3b82f6;">Dentist</span>
                    </div>
                    <div class="stat-label">Dentist Actions</div>
                    <div class="stat-value" id="statDentist" style="color:#3b82f6;">{{ $dentistCount }}</div>
                    <div class="stat-footer"><i class="fa-solid fa-stethoscope" style="font-size:.65rem;color:#3b82f6;"></i>
                        Dentist activity</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-accent" style="background:linear-gradient(90deg,#10b981,#6ee7b7);"></div>
                    <div class="stat-top">
                        <div class="stat-icon" style="background:#ecfdf5;"><i class="fa-solid fa-user"
                                style="color:#10b981;"></i></div>
                        <span class="stat-badge" style="background:#ecfdf5;color:#059669;">Patient</span>
                    </div>
                    <div class="stat-label">Patient Actions</div>
                    <div class="stat-value" id="statPatient" style="color:#10b981;">{{ $patientCount }}</div>
                    <div class="stat-footer"><i class="fa-solid fa-heart-pulse"
                            style="font-size:.65rem;color:#10b981;"></i> Patient activity</div>
                </div>
            </div>

            <div class="card">
                {{-- Card Header --}}
                <div class="card-header">
                    {{-- Left: icon + title + badge --}}
                    <div class="card-header-left">
                        <div class="card-header-icon"><i class="fa-solid fa-clipboard-list"></i></div>
                        <span class="card-title">Audit Trail</span>
                        <span id="entryBadge"
                            class="bg-red-50 text-[#8B0000] text-[0.68rem] font-bold px-2 py-0.5 rounded-full border border-red-200 ml-1.5">
                            {{ $totalCount }} {{ Str::plural('entry', $totalCount) }}
                        </span>
                    </div>

                    {{-- Right: search + filter --}}
                    <div class="card-header-right">
                        {{-- Search --}}
                        <div class="search-wrap" style="width:200px;">
                            <i class="fa fa-search"></i>
                            <input id="slSearch" name="search" placeholder="Search logs…" value="{{ $search ?? '' }}"
                                onkeydown="if(event.key==='Enter'){event.preventDefault();slState.search=this.value;slState.page=1;slFetch();}">
                            <button type="button" id="searchClearBtn"
                                class="search-clear-btn {{ $search ?? '' ? 'visible' : '' }}" onclick="clearSearch()"
                                title="Clear">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        {{-- Filter wrap --}}
                        <div class="sl-filter-wrap">
                            <button type="button" id="slFilterBtn" class="sl-filter-btn"
                                onclick="toggleSlFilterPanel(event)">
                                <i class="fa-solid fa-sliders"></i>
                                <span>Filter</span>
                            </button>

                            <button type="button" id="slClearFilterBtn" class="sl-clear-filter-btn hidden"
                                onclick="clearOnlySlFilters()" title="Clear filters">
                                <i class="fa-solid fa-filter-circle-xmark"></i>
                                <span>Clear</span>
                            </button>

                            <div id="slFilterPanel" class="sl-filter-panel hidden">
                                <div class="sl-filter-head">
                                    <span>Filter logs</span>
                                    <button type="button" class="sl-filter-close" onclick="closeSlFilterPanel()">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                                <div class="sl-filter-grid">
                                    <div class="sl-filter-group">
                                        <label>Sort order</label>
                                        <select id="slSortOrder" class="sl-filter-select">
                                            <option value="desc">Newest first</option>
                                            <option value="asc">Oldest first</option>
                                        </select>
                                    </div>
                                    <div class="sl-filter-group">
                                        <label>From date</label>
                                        <input type="date" id="slDateFrom" class="sl-filter-input">
                                    </div>
                                    <div class="sl-filter-group">
                                        <label>To date</label>
                                        <input type="date" id="slDateTo" class="sl-filter-input">
                                    </div>
                                    <div class="sl-filter-group">
                                        <label>Action type</label>
                                        <select id="slActionType" class="sl-filter-select">
                                            <option value="">All actions</option>
                                            <option value="login">Login</option>
                                            <option value="logout">Logout</option>
                                            <option value="create">Create</option>
                                            <option value="update">Update</option>
                                            <option value="delete">Delete</option>
                                        </select>
                                    </div>
                                    <div class="sl-filter-group">
                                        <label>Module</label>
                                        <input type="text" id="slModuleFilter" class="sl-filter-input"
                                            placeholder="e.g. appointments">
                                    </div>
                                </div>
                                <div class="sl-filter-actions">
                                    <button type="button" class="sl-filter-reset"
                                        onclick="resetSlFilters()">Reset</button>
                                    <button type="button" class="sl-filter-apply" onclick="applySlFilters()">Apply
                                        filters</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Role Tabs --}}
                @php $activeRole = $role ?? 'all'; @endphp
                <div class="flex gap-1 px-5 py-2.5 border-b border-gray-100 overflow-x-auto">
                    @foreach ([['key' => 'all', 'label' => 'All', 'icon' => 'fa-layer-group', 'count' => $totalCount], ['key' => 'admin', 'label' => 'Admin', 'icon' => 'fa-user-tie', 'count' => $adminCount], ['key' => 'dentist', 'label' => 'Dentist', 'icon' => 'fa-user-doctor', 'count' => $dentistCount], ['key' => 'patient', 'label' => 'Patient', 'icon' => 'fa-user', 'count' => $patientCount], ['key' => 'login', 'label' => 'Logins', 'icon' => 'fa-right-to-bracket', 'count' => $loginCount]] as $tab)
                        <button class="tab-btn {{ $activeRole === $tab['key'] ? 'active' : '' }}"
                            onclick="slSetTab(this, '{{ $tab['key'] }}')">
                            <i class="fa-solid {{ $tab['icon'] }} mr-1 text-[0.7rem]"></i>{{ $tab['label'] }}
                            <span
                                class="tab-count {{ $activeRole === $tab['key'] ? 'bg-red-200 text-[#8B0000]' : 'bg-gray-200 text-gray-500' }} text-[0.62rem] font-bold px-1.5 py-0.5 rounded-full ml-1">
                                {{ $tab['count'] }}
                            </span>
                        </button>
                    @endforeach
                </div>

                {{-- Top pagebar --}}
                <div class="sl-pagebar" style="border-top:none; border-bottom:1px solid #f3f4f6;">
                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="sl-pagebar-info">
                            @if (method_exists($logs, 'total'))
                                Showing <strong>{{ $logs->firstItem() }}–{{ $logs->lastItem() }}</strong>
                                of <strong>{{ $logs->total() }}</strong> entries
                            @else
                                Showing <strong>{{ $logs->count() }}</strong> {{ Str::plural('entry', $logs->count()) }}
                            @endif
                        </span>
                        <div class="flex items-center gap-1.5">
                            <label class="text-[0.7rem] text-gray-400 font-semibold">Show</label>
                            <select id="perPageSelect"
                                class="h-[30px] px-2 border border-gray-200 rounded-lg text-xs font-semibold text-gray-700 bg-white outline-none cursor-pointer transition-colors focus:border-[#8B0000]">
                                @foreach ([10, 20, 50, 100] as $size)
                                    <option value="{{ $size }}" {{ $perPage == $size ? 'selected' : '' }}>
                                        {{ $size }}</option>
                                @endforeach
                            </select>
                            <span class="text-[0.7rem] text-gray-400 font-semibold">per page</span>
                        </div>
                    </div>
                    <div class="sl-pagination-wrap"></div>
                </div>

               {{-- List View --}}
                <div class="sl-view" id="slListView">
                    <div style="overflow-x:auto;">
                        <table class="data-table" id="slTable">
                            <thead>
                                <tr>
                                    <th style="width:100px;">ID</th>
                                    <th style="width:150px;">Timestamp</th>
                                    <th style="width:150px;">Role</th>
                                    <th style="width:180px;">User</th>
                                    <th style="width:150px;">Action</th>
                                    <th style="width:200px;">Module</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody id="slTableBody">
                                @forelse($logs as $log)
                                    @php
                                        $role = strtolower($log->actor_role ?? 'other');
                                        $action = strtolower($log->action ?? '');
                                        $actionClass = match (true) {
                                            str_contains($action, 'login') => 'login',
                                            str_contains($action, 'logout') => 'logout',
                                            str_contains($action, 'create') => 'create',
                                            str_contains($action, 'update') => 'update',
                                            str_contains($action, 'delete') => 'delete',
                                            default => 'default',
                                        };
                                        $actionIcon = match ($actionClass) {
                                            'login' => 'fa-right-to-bracket',
                                            'logout' => 'fa-right-from-bracket',
                                            'create' => 'fa-plus',
                                            'update' => 'fa-pen',
                                            'delete' => 'fa-trash',
                                            default => 'fa-bolt',
                                        };
                                        $roleIcon = match ($role) {
                                            'admin' => 'fa-user-tie',
                                            'dentist' => 'fa-user-doctor',
                                            'patient' => 'fa-user',
                                            default => 'fa-circle-user',
                                        };
                                        $avatarLetter = strtoupper(substr($log->actor_name ?? $role, 0, 1));
                                    @endphp
                                    <tr data-role="{{ $role }}" data-action="{{ $actionClass }}">
                                        <td><span class="sl-id">#{{ str_pad($log->id, 3, '0', STR_PAD_LEFT) }}</span></td>
                                        <td>
                                            <span class="sl-date-day">{{ $log->created_at->format('M j, Y') }}</span>
                                            <span class="sl-date-time">{{ $log->created_at->format('h:i:s A') }}</span>
                                        </td>
                                        <td><span class="sl-role {{ $role }}"><i class="fa-solid {{ $roleIcon }}"></i>{{ ucfirst($role) }}</span></td>
                                        <td>
                                            <div class="sl-user">
                                                <div class="sl-avatar {{ $role }}">{{ $avatarLetter }}</div>
                                                <span class="sl-username">{{ $log->actor_name ?? 'Unknown User' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="sl-action {{ $actionClass }}">
                                                <i class="fa-solid {{ $actionIcon }}"></i>{{ ucwords(str_replace('_', ' ', $log->action)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="sl-module">
                                                <i class="fa-solid fa-cube"></i>{{ ucfirst(str_replace('_', ' ', $log->module)) }}
                                            </span>
                                        </td>
                                        <td><span class="sl-desc">{{ $log->description ?? 'No description provided.' }}</span></td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="sl-view" id="slGridView" hidden>
                    <div class="sl-grid" id="slGridBody">
                        @forelse($logs as $log)
                            @php
                                $role = strtolower($log->actor_role ?? 'other');
                                $action = strtolower($log->action ?? '');
                                $actionClass = match (true) {
                                    str_contains($action, 'login') => 'login',
                                    str_contains($action, 'logout') => 'logout',
                                    str_contains($action, 'create') => 'create',
                                    str_contains($action, 'update') => 'update',
                                    str_contains($action, 'delete') => 'delete',
                                    default => 'default',
                                };
                                $actionIcon = match ($actionClass) {
                                    'login' => 'fa-right-to-bracket',
                                    'logout' => 'fa-right-from-bracket',
                                    'create' => 'fa-plus',
                                    'update' => 'fa-pen',
                                    'delete' => 'fa-trash',
                                    default => 'fa-bolt',
                                };
                                $roleIcon = match ($role) {
                                    'admin' => 'fa-user-tie',
                                    'dentist' => 'fa-user-doctor',
                                    'patient' => 'fa-user',
                                    default => 'fa-circle-user',
                                };
                                $avatarLetter = strtoupper(substr($log->actor_name ?? $role, 0, 1));
                            @endphp

                            <div class="sl-grid-card" data-role="{{ $role }}" data-action="{{ $actionClass }}">
                                <div class="sl-grid-top">
                                    <div class="sl-grid-id">#{{ str_pad($log->id, 3, '0', STR_PAD_LEFT) }}</div>
                                    <span class="sl-action {{ $actionClass }}">
                                        <i class="fa-solid {{ $actionIcon }}"></i>{{ ucwords(str_replace('_', ' ', $log->action)) }}
                                    </span>
                                </div>

                                <div class="sl-user">
                                    <div class="sl-avatar {{ $role }}">{{ $avatarLetter }}</div>
                                    <span class="sl-username">{{ $log->actor_name ?? 'Unknown User' }}</span>
                                </div>

                                <div class="sl-grid-meta">
                                    <div class="sl-grid-field">
                                        <div class="sl-grid-label">Timestamp</div>
                                        <div class="sl-grid-value">
                                            {{ $log->created_at->format('M j, Y') }}<br>
                                            {{ $log->created_at->format('h:i:s A') }}
                                        </div>
                                    </div>

                                    <div class="sl-grid-field">
                                        <div class="sl-grid-label">Role</div>
                                        <div class="sl-grid-value">
                                            <span class="sl-role {{ $role }}">
                                                <i class="fa-solid {{ $roleIcon }}"></i>{{ ucfirst($role) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="sl-grid-field">
                                        <div class="sl-grid-label">Module</div>
                                        <div class="sl-grid-value">
                                            <span class="sl-module">
                                                <i class="fa-solid fa-cube"></i>{{ ucfirst(str_replace('_', ' ', $log->module)) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="sl-grid-field">
                                        <div class="sl-grid-label">Description</div>
                                        <div class="sl-grid-value">{{ $log->description ?? 'No description provided.' }}</div>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>

                <div id="emptyState" style="display:none;"></div>

                {{-- Bottom pagebar --}}
                <div class="sl-pagebar">
                    <span class="sl-pagebar-info">
                        @if (method_exists($logs, 'total'))
                            Showing <strong>{{ $logs->firstItem() }}–{{ $logs->lastItem() }}</strong>
                            of <strong>{{ $logs->total() }}</strong> entries
                        @else
                            Showing <strong>{{ $logs->count() }}</strong> {{ Str::plural('entry', $logs->count()) }}
                        @endif
                    </span>
                    <div class="sl-pagination-wrap"></div>
                </div>
            </div>

        </div>
    </main>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            syncSlFilterInputs();
            updateSlClearFilterButton();
            initSlViewToggle();

            document.getElementById('slFilterPanel')?.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            document.addEventListener('click', function(e) {
                var wrap = document.querySelector('.sl-filter-wrap');
                if (!wrap) return;
                if (!wrap.contains(e.target)) closeSlFilterPanel();
            });

            @if (method_exists($logs, 'total') && $logs->total() > 0)
                slRenderPagebar({
                    total: {{ $logs->total() }},
                    from: {{ $logs->firstItem() ?? 0 }},
                    to: {{ $logs->lastItem() ?? 0 }},
                    current_page: {{ $logs->currentPage() }},
                    last_page: {{ $logs->lastPage() }},
                    per_page: {{ $logs->perPage() }},
                });
            @endif

            var searchInput = document.getElementById('slSearch');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    toggleSearchClear(this);
                    clearTimeout(slSearchTimer);
                    slSearchTimer = setTimeout(function() {
                        slState.search = searchInput.value;
                        slState.page = 1;
                        slFetch(true);
                    }, 400);
                });
            }

            var perPageSelect = document.getElementById('perPageSelect');
            if (perPageSelect) {
                perPageSelect.addEventListener('change', function() {
                    slState.perPage = parseInt(this.value);
                    slState.page = 1;
                    slFetch();
                });
            }

            @php $latestLogId = optional(($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() : $logs)->first())->id ?? 0; @endphp

            var lastKnownId = {{ $latestLogId }};
            var notifBanner = null;

            function checkForNewLogs() {
                fetch("{{ route('admin.system_logs.check') }}", {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(function(res) {
                        return res.json();
                    })
                    .then(function(data) {
                        if (data.latest_id > lastKnownId) {
                            lastKnownId = data.latest_id;
                            showNewLogBanner();
                        }
                    }).catch(function() {});
            }

            function showNewLogBanner() {
                if (notifBanner) notifBanner.remove();
                notifBanner = document.createElement('div');
                notifBanner.style.cssText =
                    'position:fixed;top:80px;left:50%;transform:translateX(-50%);z-index:9999;display:flex;align-items:center;gap:.6rem;background:#fff;border:1.5px solid #a7f3d0;border-radius:12px;padding:.65rem 1.1rem;box-shadow:0 8px 24px rgba(0,0,0,.12);font-size:.78rem;font-weight:600;color:#059669;white-space:nowrap;max-width:90vw;';
                notifBanner.innerHTML =
                    '<i class="fa-solid fa-circle-check" style="color:#10b981;"></i> New log entries detected. <span style="color:#8B0000;text-decoration:underline;margin-left:.25rem;cursor:pointer;" onclick="slState.page=1;slFetch();this.closest(\'div\').remove();">Refresh to see</span><button onclick="this.parentElement.remove()" style="margin-left:.5rem;background:none;border:none;cursor:pointer;color:#757575;font-size:.7rem;padding:0;"><i class="fa-solid fa-xmark"></i></button>';
                document.body.appendChild(notifBanner);
            }

            setInterval(checkForNewLogs, 5000);
        });

        /* ════════════════════════════════════════
           AJAX STATE
        ════════════════════════════════════════ */
        var slState = {
            role: '{{ $role ?? 'all' }}',
            search: '{{ $search ?? '' }}',
            perPage: {{ $perPage ?? 20 }},
            page: {{ request('page', 1) }},
            sort: '{{ $sort ?? 'desc' }}',
            dateFrom: '{{ $dateFrom ?? '' }}',
            dateTo: '{{ $dateTo ?? '' }}',
            actionType: '{{ $actionType ?? '' }}',
            module: '{{ $module ?? '' }}',
        };

        var slOverallTotal = {{ $totalCount }};
        var slSearchTimer = null;
        var slController = null;

        function getPreferredSlView() {
            if (window.innerWidth <= 767) return 'grid';
            return localStorage.getItem('systemLogsView') || 'list';
        }

        function applySlView(view, save = true) {
            var listView = document.getElementById('slListView');
            var gridView = document.getElementById('slGridView');
            var listBtn = document.getElementById('slListViewBtn');
            var gridBtn = document.getElementById('slGridViewBtn');

            if (!listView || !gridView) return;

            var finalView = window.innerWidth <= 767 ? 'grid' : view;

            if (finalView === 'grid') {
                listView.hidden = true;
                gridView.hidden = false;
            } else {
                listView.hidden = false;
                gridView.hidden = true;
            }

            if (listBtn) listBtn.classList.toggle('active', finalView === 'list');
            if (gridBtn) gridBtn.classList.toggle('active', finalView === 'grid');

            if (save && window.innerWidth > 767) {
                localStorage.setItem('systemLogsView', finalView);
            }
        }

        function initSlViewToggle() {
            var listBtn = document.getElementById('slListViewBtn');
            var gridBtn = document.getElementById('slGridViewBtn');

            applySlView(getPreferredSlView(), false);

            if (listBtn && !listBtn.dataset.bound) {
                listBtn.dataset.bound = '1';
                listBtn.addEventListener('click', function() {
                    applySlView('list', true);
                });
            }

            if (gridBtn && !gridBtn.dataset.bound) {
                gridBtn.dataset.bound = '1';
                gridBtn.addEventListener('click', function() {
                    applySlView('grid', true);
                });
            }
        }

        function toggleSearchClear(input) {
            document.getElementById('searchClearBtn').classList.toggle('visible', input.value.length > 0);
        }

        function clearSearch() {
            var input = document.getElementById('slSearch');
            input.value = '';
            document.getElementById('searchClearBtn').classList.remove('visible');
            slState.search = '';
            slState.page = 1;
            slFetch();
            input.focus();
        }

        function slSetTab(el, role) {
            slState.role = role;
            slState.page = 1;
            document.querySelectorAll('.tab-btn').forEach(function(b) {
                b.classList.remove('active');
            });
            el.classList.add('active');
            document.querySelectorAll('.tab-btn .tab-count').forEach(function(span) {
                span.className =
                    'tab-count bg-gray-200 text-gray-500 text-[0.62rem] font-bold px-1.5 py-0.5 rounded-full ml-1';
            });
            var activeSpan = el.querySelector('.tab-count');
            if (activeSpan) activeSpan.className =
                'tab-count bg-red-200 text-[#8B0000] text-[0.62rem] font-bold px-1.5 py-0.5 rounded-full ml-1';
            slFetch();
        }

        function slGoPage(page) {
            slState.page = page;
            slFetch();
        }

        function hasActiveSlFilters() {
            return (slState.sort && slState.sort !== 'desc') ||
                !!slState.dateFrom || !!slState.dateTo ||
                !!slState.actionType || !!slState.module;
        }

        function syncSlFilterInputs() {
            var sort = document.getElementById('slSortOrder');
            var from = document.getElementById('slDateFrom');
            var to = document.getElementById('slDateTo');
            var action = document.getElementById('slActionType');
            var module = document.getElementById('slModuleFilter');
            if (sort) sort.value = slState.sort || 'desc';
            if (from) from.value = slState.dateFrom || '';
            if (to) to.value = slState.dateTo || '';
            if (action) action.value = slState.actionType || '';
            if (module) module.value = slState.module || '';
        }

        function updateSlClearFilterButton() {
            var btn = document.getElementById('slClearFilterBtn');
            if (!btn) return;
            btn.classList.toggle('hidden', !hasActiveSlFilters());
        }

        function clearOnlySlFilters() {
            slState.sort = 'desc';
            slState.dateFrom = '';
            slState.dateTo = '';
            slState.actionType = '';
            slState.module = '';
            slState.page = 1;
            syncSlFilterInputs();
            updateSlClearFilterButton();
            closeSlFilterPanel();
            slFetch();
        }

        function toggleSlFilterPanel(e) {
            if (e) e.stopPropagation();

            var panel = document.getElementById('slFilterPanel');
            var btn = document.getElementById('slFilterBtn');
            if (!panel || !btn) return;

            panel.classList.toggle('hidden');
            btn.classList.toggle('active', !panel.classList.contains('hidden'));
        }

        function closeSlFilterPanel() {
            var panel = document.getElementById('slFilterPanel');
            var btn = document.getElementById('slFilterBtn');
            if (panel) panel.classList.add('hidden');
            if (btn) btn.classList.remove('active');
        }

        function applySlFilters() {
            slState.sort = document.getElementById('slSortOrder')?.value || 'desc';
            slState.dateFrom = document.getElementById('slDateFrom')?.value || '';
            slState.dateTo = document.getElementById('slDateTo')?.value || '';
            slState.actionType = document.getElementById('slActionType')?.value || '';
            slState.module = document.getElementById('slModuleFilter')?.value || '';
            slState.page = 1;
            updateSlClearFilterButton();
            closeSlFilterPanel();
            slFetch();
        }

        function resetSlFilters() {
            clearOnlySlFilters();
        }

        function slFetch(silent) {
            if (slController) slController.abort();
            slController = new AbortController();

            var params = new URLSearchParams({
                role: slState.role,
                search: slState.search,
                per_page: slState.perPage,
                page: slState.page,
                sort: slState.sort,
                date_from: slState.dateFrom,
                date_to: slState.dateTo,
                action_type: slState.actionType,
                module: slState.module,
            });

            history.replaceState(null, '', window.location.pathname + '?' + params.toString());

            if (!silent) {
                document.getElementById('slTableBody').innerHTML = slSkeletonRows(slState.perPage);
            }
            document.getElementById('emptyState').style.display = 'none';
            document.getElementById('slTable').style.display = '';

            fetch('{{ route('admin.system_logs') }}?' + params.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? ''
                    },
                    signal: slController.signal
                })
                .then(function(res) {
                    return res.json();
                })
                .then(function(data) {
                    slRenderRows(data.logs);
                    slRenderPagebar(data.pagination);
                    slRenderCounts(data.counts);
                })
                .catch(function(e) {
                    if (e.name !== 'AbortError') console.error('Fetch error:', e);
                });
        }

        function slSkeletonRows(count) {
            var pulse =
                'style="background:linear-gradient(90deg,#f3f4f6 25%,#e5e7eb 50%,#f3f4f6 75%);background-size:200% 100%;animation:sl-shimmer 1.2s infinite;border-radius:6px;display:inline-block;"';
            var row = '<tr>' +
                '<td><span class="sl-id" ' + pulse +
                ' style="width:36px;height:14px;background:linear-gradient(90deg,#f3f4f6 25%,#e5e7eb 50%,#f3f4f6 75%);background-size:200% 100%;animation:sl-shimmer 1.2s infinite;border-radius:6px;display:inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;</span></td>' +
                '<td><span ' + pulse + ' style="width:80px;height:14px;">&nbsp;</span></td>' +
                '<td><span ' + pulse + ' style="width:60px;height:22px;">&nbsp;</span></td>' +
                '<td><span ' + pulse + ' style="width:70px;height:14px;">&nbsp;</span></td>' +
                '<td><span ' + pulse + ' style="width:55px;height:22px;">&nbsp;</span></td>' +
                '<td><span ' + pulse + ' style="width:80px;height:14px;">&nbsp;</span></td>' +
                '<td><span ' + pulse + ' style="width:140px;height:14px;">&nbsp;</span></td>' +
                '</tr>';
            var html = '';
            for (var i = 0; i < Math.min(count, 5); i++) html += row;
            return html;
        }

        function slRenderRows(logs) {
            var tableBody = document.getElementById('slTableBody');
            var gridBody = document.getElementById('slGridBody');

            if (!logs || logs.length === 0) {
                if (tableBody) tableBody.innerHTML = '';
                if (gridBody) gridBody.innerHTML = '';
                showEmptyState(slState.search);
                return;
            }

            var actionIcons = {
                login: 'fa-right-to-bracket',
                logout: 'fa-right-from-bracket',
                create: 'fa-plus',
                update: 'fa-pen',
                delete: 'fa-trash',
                default: 'fa-bolt'
            };

            var roleIcons = {
                admin: 'fa-user-tie',
                dentist: 'fa-user-doctor',
                patient: 'fa-user'
            };

            var tableHtml = '';
            var gridHtml = '';

            logs.forEach(function(log) {
                var role = (log.actor_role || 'other').toLowerCase();
                var action = (log.action || '').toLowerCase();
                var actionClass = action.includes('login') ? 'login'
                    : action.includes('logout') ? 'logout'
                    : action.includes('create') ? 'create'
                    : action.includes('update') ? 'update'
                    : action.includes('delete') ? 'delete'
                    : 'default';

                var actionIcon = actionIcons[actionClass] || 'fa-bolt';
                var roleIcon = roleIcons[role] || 'fa-circle-user';
                var letter = (log.actor_name || role).charAt(0).toUpperCase();
                var idPadded = '#' + String(log.id).padStart(3, '0');
                var actionLabel = (log.action || '').replace(/_/g, ' ').replace(/\b\w/g, function(c) {
                    return c.toUpperCase();
                });
                var moduleLabel = (log.module || '').replace(/_/g, ' ').replace(/\b\w/g, function(c) {
                    return c.toUpperCase();
                });
                var actorName = log.actor_display_name ?? log.actor_identifier ?? 'Unknown User';
                var description = log.description || 'No description provided.';

                tableHtml += '<tr data-role="' + role + '" data-action="' + actionClass + '" class="sl-row-new">';
                tableHtml += '<td><span class="sl-id">' + idPadded + '</span></td>';
                tableHtml += '<td><span class="sl-date-day">' + log.created_at_day + '</span><span class="sl-date-time">' + log.created_at_time + '</span></td>';
                tableHtml += '<td><span class="sl-role ' + role + '"><i class="fa-solid ' + roleIcon + '"></i>' + role.charAt(0).toUpperCase() + role.slice(1) + '</span></td>';
                tableHtml += '<td><div class="sl-user"><div class="sl-avatar ' + role + '">' + letter + '</div><span class="sl-username">' + actorName + '</span></div></td>';
                tableHtml += '<td><span class="sl-action ' + actionClass + '"><i class="fa-solid ' + actionIcon + '"></i>' + actionLabel + '</span></td>';
                tableHtml += '<td><span class="sl-module"><i class="fa-solid fa-cube"></i>' + moduleLabel + '</span></td>';
                tableHtml += '<td><span class="sl-desc" title="' + description + '">' + description + '</span></td>';
                tableHtml += '</tr>';

                gridHtml += '<div class="sl-grid-card">';
                gridHtml += '<div class="sl-grid-top">';
                gridHtml += '<div class="sl-grid-id">' + idPadded + '</div>';
                gridHtml += '<span class="sl-action ' + actionClass + '"><i class="fa-solid ' + actionIcon + '"></i>' + actionLabel + '</span>';
                gridHtml += '</div>';

                gridHtml += '<div class="sl-user"><div class="sl-avatar ' + role + '">' + letter + '</div><span class="sl-username">' + actorName + '</span></div>';

                gridHtml += '<div class="sl-grid-meta">';
                gridHtml += '<div class="sl-grid-field"><div class="sl-grid-label">Timestamp</div><div class="sl-grid-value">' + log.created_at_day + '<br>' + log.created_at_time + '</div></div>';
                gridHtml += '<div class="sl-grid-field"><div class="sl-grid-label">Role</div><div class="sl-grid-value"><span class="sl-role ' + role + '"><i class="fa-solid ' + roleIcon + '"></i>' + role.charAt(0).toUpperCase() + role.slice(1) + '</span></div></div>';
                gridHtml += '<div class="sl-grid-field"><div class="sl-grid-label">Module</div><div class="sl-grid-value"><span class="sl-module"><i class="fa-solid fa-cube"></i>' + moduleLabel + '</span></div></div>';
                gridHtml += '<div class="sl-grid-field"><div class="sl-grid-label">Description</div><div class="sl-grid-value">' + description + '</div></div>';
                gridHtml += '</div>';
                gridHtml += '</div>';
            });

            if (tableBody) tableBody.innerHTML = tableHtml;
            if (gridBody) gridBody.innerHTML = gridHtml;

            document.getElementById('emptyState').style.display = 'none';
            applySlView(getPreferredSlView(), false);
        }

        function slRenderPagebar(p) {
            if (!p) return;
            var infoHtml = 'Showing <strong>' + p.from + '–' + p.to + '</strong> of <strong>' + p.total +
                '</strong> entries';
            document.querySelectorAll('.sl-pagebar-info').forEach(function(el) {
                el.innerHTML = infoHtml;
            });
            var navHtml = slBuildPagination(p);
            document.querySelectorAll('.sl-pagination-wrap').forEach(function(el) {
                el.innerHTML = navHtml;
            });
            var badge = document.getElementById('entryBadge');
            if (badge) badge.textContent = slOverallTotal + ' ' + (slOverallTotal === 1 ? 'entry' : 'entries');
        }

        function slBuildPagination(p) {
            if (p.last_page <= 1) return '';
            var current = p.current_page,
                last = p.last_page;
            var winSize = 5,
                half = Math.floor(winSize / 2);
            var start = Math.max(1, current - half);
            var end = Math.min(last, start + winSize - 1);
            if (end - start + 1 < winSize) start = Math.max(1, end - winSize + 1);

            var btn =
                'style="height:32px;min-width:32px;padding:0 10px;border-radius:8px;border:1.5px solid #e5e7eb;background:#fff;color:#333333;font-size:.75rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;transition:all .15s;" onmouseover="this.style.borderColor=\'#8B0000\';this.style.color=\'#8B0000\';this.style.background=\'#fef2f2\';" onmouseout="this.style.borderColor=\'#e5e7eb\';this.style.color=\'#333333\';this.style.background=\'#fff\';"';
            var btnActive =
                'style="height:32px;min-width:32px;padding:0 10px;border-radius:8px;border:1.5px solid #8B0000;background:linear-gradient(135deg,#8B0000,#6b0000);color:#fff;font-size:.75rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(139,0,0,.25);"';
            var btnDis =
                'style="height:32px;min-width:32px;padding:0 10px;border-radius:8px;border:1.5px solid #e5e7eb;background:#f9fafb;color:#d1d5db;font-size:.75rem;font-weight:600;cursor:not-allowed;display:inline-flex;align-items:center;justify-content:center;"';
            var dots =
                '<span style="height:32px;min-width:32px;display:inline-flex;align-items:center;justify-content:center;color:#757575;font-size:.75rem;font-weight:600;">…</span>';

            var html = '<nav style="display:flex;align-items:center;gap:.35rem;flex-wrap:nowrap;">';
            if (current <= 1) {
                html += '<button disabled ' + btnDis +
                    '><i class="fa-solid fa-chevron-left" style="font-size:.65rem;"></i></button>';
            } else {
                html += '<button onclick="slGoPage(' + (current - 1) + ')" ' + btn +
                    '><i class="fa-solid fa-chevron-left" style="font-size:.65rem;"></i></button>';
            }
            if (start > 1) {
                html += '<button onclick="slGoPage(1)" ' + btn + '>1</button>';
                if (start > 2) html += dots;
            }
            for (var i = start; i <= end; i++) {
                html += i === current ? '<span ' + btnActive + '>' + i + '</span>' : '<button onclick="slGoPage(' + i +
                    ')" ' + btn + '>' + i + '</button>';
            }
            if (end < last) {
                if (end < last - 1) html += dots;
                html += '<button onclick="slGoPage(' + last + ')" ' + btn + '>' + last + '</button>';
            }
            if (current >= last) {
                html += '<button disabled ' + btnDis +
                    '><i class="fa-solid fa-chevron-right" style="font-size:.65rem;"></i></button>';
            } else {
                html += '<button onclick="slGoPage(' + (current + 1) + ')" ' + btn +
                    '><i class="fa-solid fa-chevron-right" style="font-size:.65rem;"></i></button>';
            }
            html += '</nav>';
            return html;
        }

        function slRenderCounts(counts) {
            if (!counts) return;
            slOverallTotal = counts.total;
            document.getElementById('statTotal').textContent = counts.total;
            document.getElementById('statAdmin').textContent = counts.admin;
            document.getElementById('statDentist').textContent = counts.dentist;
            document.getElementById('statPatient').textContent = counts.patient;
            var badge = document.getElementById('entryBadge');
            if (badge) badge.textContent = slOverallTotal + ' ' + (slOverallTotal === 1 ? 'entry' : 'entries');
        }

        function showEmptyState(query) {
            var emptyState = document.getElementById('emptyState');
            var table = document.getElementById('slTable');
            if (!emptyState) return;
            if (table) table.style.display = '';
            var listView = document.getElementById('slListView');
            var gridView = document.getElementById('slGridView');
            if (listView) listView.hidden = true;
            if (gridView) gridView.hidden = true;
            emptyState.style.display = 'block';

            var icon, title, sub, extra = '';
            if (query) {
                icon = 'fa-magnifying-glass';
                title = 'No results for \u201c' + query + '\u201d';
                sub = 'Try a different name, action, or user.';
                extra =
                    '<button onclick="clearSearch()" style="margin-top:.75rem;padding:.5rem 1.1rem;border-radius:10px;border:1.5px dashed #d1d5db;background:none;font-size:.8rem;color:#757575;cursor:pointer;" onmouseover="this.style.borderColor=\'#8B0000\';this.style.color=\'#8B0000\';" onmouseout="this.style.borderColor=\'#d1d5db\';this.style.color=\'#757575\';"><i class="fa-solid fa-xmark" style="margin-right:.4rem;font-size:.7rem;"></i>Clear search</button>';
            } else if (slState.role !== 'all') {
                var labels = {
                    admin: 'Admin',
                    dentist: 'Dentist',
                    patient: 'Patient',
                    login: 'Login'
                };
                icon = 'fa-filter';
                title = 'No ' + (labels[slState.role] || slState.role) + ' logs found';
                sub = 'There are no logs matching this filter yet.';
                extra =
                    '<button onclick="slSetTab(document.querySelector(\'.tab-btn\'),\'all\')" style="margin-top:.75rem;padding:.5rem 1.1rem;border-radius:10px;border:1.5px dashed #d1d5db;background:none;font-size:.8rem;color:#757575;cursor:pointer;" onmouseover="this.style.borderColor=\'#8B0000\';this.style.color=\'#8B0000\';" onmouseout="this.style.borderColor=\'#d1d5db\';this.style.color=\'#757575\';"><i class="fa-solid fa-xmark" style="margin-right:.4rem;font-size:.7rem;"></i>Show all logs</button>';
            } else if (hasActiveSlFilters()) {
                icon = 'fa-filter-circle-xmark';
                title = 'No logs match the selected filters';
                sub = 'Try adjusting or clearing the filters.';
                extra =
                    '<button onclick="clearOnlySlFilters()" style="margin-top:.75rem;padding:.5rem 1.1rem;border-radius:10px;border:1.5px dashed #d1d5db;background:none;font-size:.8rem;color:#757575;cursor:pointer;" onmouseover="this.style.borderColor=\'#8B0000\';this.style.color=\'#8B0000\';" onmouseout="this.style.borderColor=\'#d1d5db\';this.style.color=\'#757575\';"><i class="fa-solid fa-filter-circle-xmark" style="margin-right:.4rem;font-size:.7rem;"></i>Clear filters</button>';
            } else {
                icon = 'fa-clipboard-list';
                title = 'No system logs yet';
                sub = 'Activity will appear here once users interact with the system.';
            }

            emptyState.innerHTML =
                '<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:3.5rem 1rem;text-align:center;gap:.5rem;"><div style="width:60px;height:60px;border-radius:16px;background:#f3f4f6;display:flex;align-items:center;justify-content:center;margin-bottom:.75rem;"><i class="fa-solid ' +
                icon +
                '" style="font-size:1.6rem;color:#d1d5db;"></i></div><p style="font-size:.9rem;font-weight:700;color:#6b7280;margin:0;">' +
                title + '</p><p style="font-size:.78rem;color:#b0b7c3;margin:0;max-width:280px;">' + sub + '</p>' + extra +
                '</div>';

                window.addEventListener('resize', function() {
                applySlView(getPreferredSlView(), false);
            });
        }
    </script>
@endsection