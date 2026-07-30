@extends('layouts.app')

@section('layout-role', 'admin')
@section('title', 'Session Dashboard')

@section('styles')
    <style>
        .session-admin-page {
            padding-bottom: 44px;
        }

        .session-admin-page .page-banner {
            margin-bottom: 1.2rem;
        }

        .session-admin-stats {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 1.1rem;
        }

        .session-admin-stat {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            padding: 18px 18px 16px;
            border: 1px solid #f0dfdf;
            background:
                radial-gradient(circle at top right, rgba(139, 0, 0, .08), transparent 40%),
                linear-gradient(180deg, #ffffff, #fff8f8);
            box-shadow: 0 12px 30px rgba(15, 23, 42, .05);
        }

        .session-admin-stat::after {
            content: '';
            position: absolute;
            inset: auto -18px -24px auto;
            width: 76px;
            height: 76px;
            border-radius: 999px;
            background: rgba(139, 0, 0, .05);
        }

        .session-admin-stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .session-admin-stat-label {
            display: block;
            font-size: .72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #7b6f6f;
        }

        .session-admin-stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #8b0000;
            background: #fff0f0;
            border: 1px solid #f6d0d0;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .8);
        }

        .session-admin-stat-icon i {
            font-size: 1rem;
        }

        .session-admin-stat-value {
            display: block;
            font-size: 2rem;
            line-height: 1;
            font-weight: 900;
            color: #1f2937;
            letter-spacing: -.03em;
        }

        .session-admin-stat-note {
            display: block;
            margin-top: 8px;
            font-size: .78rem;
            color: #8b7f7f;
        }

        .session-admin-card {
            background: #fff;
            border: 1px solid #efe1e1;
            border-radius: 24px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, .05);
            overflow: hidden;
        }

        .session-admin-toolbar {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 18px;
            padding: 22px 22px 18px;
            border-bottom: 1px solid #f3e8e8;
            background: linear-gradient(180deg, #fffdfd, #fff7f7);
        }

        .session-admin-toolbar-copy {
            max-width: 520px;
        }

        .session-admin-toolbar-copy h2 {
            margin: 0;
            font-size: 1.28rem;
            font-weight: 900;
            color: #1f2937;
            letter-spacing: -.02em;
        }

        .session-admin-toolbar-copy p {
            margin: 8px 0 0;
            color: #6b7280;
            font-size: .92rem;
            line-height: 1.55;
        }

        .session-admin-filters {
            display: grid;
            grid-template-columns: minmax(260px, 1.3fr) 160px 140px auto;
            gap: 10px;
            align-items: center;
            width: 100%;
            max-width: 760px;
        }

        .session-admin-field {
            width: 100%;
            min-height: 46px;
            border-radius: 14px;
            border: 1px solid #ead9d9;
            background: #fff;
            color: #1f2937;
            font-size: .92rem;
            padding: 0 15px;
            transition: border-color .16s ease, box-shadow .16s ease, transform .16s ease;
        }

        .session-admin-field:focus {
            outline: none;
            border-color: #8b0000;
            box-shadow: 0 0 0 4px rgba(139, 0, 0, .08);
        }

        .session-admin-select-wrap {
            position: relative;
        }

        .session-admin-select-wrap::after {
            content: '\f078';
            font-family: 'Font Awesome 7 Free';
            font-weight: 900;
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: .8rem;
            color: #8b6d6d;
            pointer-events: none;
        }

        .session-admin-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 40px;
            background:
                linear-gradient(180deg, #fff, #fff8f8);
            cursor: pointer;
            font-weight: 700;
        }

        .session-admin-select:hover {
            border-color: #d8b4b4;
            box-shadow: 0 6px 18px rgba(139, 0, 0, .06);
        }

        .session-admin-search-wrap {
            position: relative;
        }

        .session-admin-search-wrap i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #a79a9a;
            font-size: .92rem;
            pointer-events: none;
        }

        .session-admin-search {
            padding-left: 42px;
        }

        .session-admin-btn {
            min-height: 46px;
            border-radius: 14px;
            border: 0;
            padding: 0 18px;
            font-size: .88rem;
            font-weight: 800;
            cursor: pointer;
            transition: transform .16s ease, box-shadow .16s ease, filter .16s ease;
            white-space: nowrap;
        }

        .session-admin-btn:hover {
            transform: translateY(-1px);
        }

        .session-admin-btn-primary {
            color: #fff;
            background: linear-gradient(135deg, #8b0000, #b31217);
            box-shadow: 0 10px 22px rgba(139, 0, 0, .18);
        }

        .session-admin-btn-primary:hover {
            filter: brightness(1.03);
        }

        .session-admin-btn-soft {
            color: #8b0000;
            background: #fff5f5;
            border: 1px solid #f2cece;
        }

        .session-admin-btn-danger {
            color: #fff;
            background: linear-gradient(135deg, #9f1239, #dc2626);
            box-shadow: 0 10px 22px rgba(220, 38, 38, .14);
        }

        .session-admin-btn-current {
            color: #166534;
            background: #ecfdf3;
            border: 1px solid #ccefd7;
            cursor: default;
        }

        .session-admin-btn-current:hover {
            transform: none;
        }

        .session-admin-resultsbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 16px 22px;
            border-bottom: 1px solid #f4ecec;
            background: #fff;
        }

        .session-admin-results-meta {
            color: #6b7280;
            font-size: .88rem;
        }

        .session-admin-results-meta strong {
            color: #1f2937;
        }

        .session-admin-rolechips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .session-admin-chip {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: .76rem;
            font-weight: 800;
            background: #faf4f4;
            color: #7f5a5a;
            border: 1px solid #f0e0e0;
        }

        .session-admin-list {
            padding: 16px;
            display: grid;
            gap: 14px;
            background: linear-gradient(180deg, #fff, #fffafa);
        }

        .session-admin-item {
            border-radius: 22px;
            border: 1px solid #efe2e2;
            background: #fff;
            box-shadow: 0 10px 28px rgba(15, 23, 42, .04);
            overflow: hidden;
        }

        .session-admin-item-current {
            border-color: #ccefd7;
            box-shadow: 0 14px 34px rgba(34, 197, 94, .08);
        }

        .session-admin-item-shell {
            display: grid;
            grid-template-columns: minmax(220px, 1.1fr) minmax(180px, .8fr) minmax(180px, .8fr) minmax(190px, .82fr) minmax(260px, 1fr);
            gap: 16px;
            padding: 18px;
            align-items: start;
        }

        .session-admin-userblock {
            display: grid;
            grid-template-columns: 48px minmax(0, 1fr);
            gap: 12px;
            align-items: start;
        }

        .session-admin-avatar {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: 900;
            color: #8b0000;
            background: #fff0f0;
            border: 1px solid #f5d4d4;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .9);
        }

        .session-admin-userhead {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 6px;
        }

        .session-admin-user-name {
            font-size: 1.06rem;
            font-weight: 900;
            color: #1f2937;
            line-height: 1.2;
        }

        .session-admin-current-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 800;
            color: #166534;
            background: #ecfdf3;
            border: 1px solid #caecd5;
        }

        .session-admin-user-email {
            color: #6b7280;
            font-size: .9rem;
            line-height: 1.4;
            word-break: break-word;
        }

        .session-admin-meta-col {
            display: grid;
            gap: 8px;
            align-content: start;
        }

        .session-admin-meta-label {
            font-size: .7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #9a8d8d;
        }

        .session-admin-role,
        .session-admin-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: fit-content;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: .78rem;
            font-weight: 800;
        }

        .session-admin-role-admin {
            color: #991b1b;
            background: #fef2f2;
            border: 1px solid #fed7d7;
        }

        .session-admin-role-dentist {
            color: #1d4ed8;
            background: #eff6ff;
            border: 1px solid #d4e5ff;
        }

        .session-admin-role-patient {
            color: #047857;
            background: #ecfdf5;
            border: 1px solid #c9f1dd;
        }

        .session-admin-status-active {
            color: #166534;
            background: #dcfce7;
            border: 1px solid #bde9cc;
        }

        .session-admin-status-inactive {
            color: #991b1b;
            background: #fef2f2;
            border: 1px solid #fed7d7;
        }

        .session-admin-device-title,
        .session-admin-ip {
            font-size: .98rem;
            font-weight: 800;
            color: #1f2937;
            line-height: 1.35;
        }

        .session-admin-device-sub,
        .session-admin-activity {
            color: #6b7280;
            font-size: .88rem;
            line-height: 1.55;
            word-break: break-word;
        }

        .session-admin-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: stretch;
        }

        .session-admin-actions form {
            margin: 0;
        }

        .session-admin-actions .session-admin-btn,
        .session-admin-actions form .session-admin-btn {
            width: 100%;
            min-height: 40px;
            height: 40px;
            padding: 0 14px;
            font-size: .82rem;
            border-radius: 12px;
            justify-content: center;
            text-align: center;
            line-height: 1.1;
        }

        .session-admin-empty {
            padding: 44px 24px 52px;
            text-align: center;
            color: #6b7280;
        }

        .session-admin-empty-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 16px;
            border-radius: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #8b0000;
            background: #fff1f1;
            border: 1px solid #f4d7d7;
        }

        .session-admin-empty-icon i {
            font-size: 1.5rem;
        }

        .session-admin-empty h3 {
            margin: 0 0 8px;
            font-size: 1.08rem;
            font-weight: 900;
            color: #1f2937;
        }

        .session-admin-empty p {
            margin: 0;
            max-width: 440px;
            margin-inline: auto;
            line-height: 1.6;
        }

        .session-admin-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            padding: 18px 22px 22px;
            border-top: 1px solid #f4ecec;
            background: #fff;
        }

        .session-admin-pagination-info {
            color: #6b7280;
            font-size: .9rem;
        }

        .session-admin-pagination-info strong {
            color: #1f2937;
        }

        .session-admin-links .pagination {
            margin: 0;
        }

        [data-theme="dark"] .session-admin-stat,
        .dark .session-admin-stat {
            background:
                radial-gradient(circle at top right, rgba(239, 68, 68, .12), transparent 42%),
                linear-gradient(180deg, #161b22, #12161d);
            border-color: #2c333c;
            box-shadow: 0 16px 36px rgba(0, 0, 0, .18);
        }

        [data-theme="dark"] .session-admin-stat-value,
        [data-theme="dark"] .session-admin-toolbar-copy h2,
        [data-theme="dark"] .session-admin-user-name,
        [data-theme="dark"] .session-admin-device-title,
        [data-theme="dark"] .session-admin-ip,
        [data-theme="dark"] .session-admin-empty h3,
        .dark .session-admin-stat-value,
        .dark .session-admin-toolbar-copy h2,
        .dark .session-admin-user-name,
        .dark .session-admin-device-title,
        .dark .session-admin-ip,
        .dark .session-admin-empty h3 {
            color: #f3f4f6;
        }

        [data-theme="dark"] .session-admin-stat-label,
        [data-theme="dark"] .session-admin-stat-note,
        [data-theme="dark"] .session-admin-toolbar-copy p,
        [data-theme="dark"] .session-admin-results-meta,
        [data-theme="dark"] .session-admin-user-email,
        [data-theme="dark"] .session-admin-device-sub,
        [data-theme="dark"] .session-admin-activity,
        [data-theme="dark"] .session-admin-empty p,
        [data-theme="dark"] .session-admin-pagination-info,
        [data-theme="dark"] .session-admin-meta-label,
        .dark .session-admin-stat-label,
        .dark .session-admin-stat-note,
        .dark .session-admin-toolbar-copy p,
        .dark .session-admin-results-meta,
        .dark .session-admin-user-email,
        .dark .session-admin-device-sub,
        .dark .session-admin-activity,
        .dark .session-admin-empty p,
        .dark .session-admin-pagination-info,
        .dark .session-admin-meta-label {
            color: #9ca3af;
        }

        [data-theme="dark"] .session-admin-card,
        [data-theme="dark"] .session-admin-toolbar,
        [data-theme="dark"] .session-admin-resultsbar,
        [data-theme="dark"] .session-admin-item,
        [data-theme="dark"] .session-admin-pagination,
        .dark .session-admin-card,
        .dark .session-admin-toolbar,
        .dark .session-admin-resultsbar,
        .dark .session-admin-item,
        .dark .session-admin-pagination {
            background: #161b22;
            border-color: #2b3139;
            box-shadow: 0 18px 40px rgba(0, 0, 0, .18);
        }

        [data-theme="dark"] .session-admin-list,
        .dark .session-admin-list {
            background: linear-gradient(180deg, #161b22, #12161d);
        }

        [data-theme="dark"] .session-admin-field,
        .dark .session-admin-field {
            background: #0d1117;
            border-color: #30363d;
            color: #f3f4f6;
        }

        [data-theme="dark"] .session-admin-select-wrap::after,
        .dark .session-admin-select-wrap::after {
            color: #a9b2bd;
        }

        [data-theme="dark"] .session-admin-select,
        .dark .session-admin-select {
            background: linear-gradient(180deg, #0d1117, #121821);
        }

        [data-theme="dark"] .session-admin-chip,
        .dark .session-admin-chip {
            background: #1c2128;
            border-color: #313843;
            color: #d1d5db;
        }

        [data-theme="dark"] .session-admin-btn-soft,
        .dark .session-admin-btn-soft {
            background: #1f252d;
            border-color: #39414b;
            color: #fca5a5;
        }

        [data-theme="dark"] .session-admin-btn-current,
        .dark .session-admin-btn-current {
            background: #13281e;
            border-color: #254c39;
            color: #86efac;
        }

        @media (max-width: 1400px) {
            .session-admin-stats {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .session-admin-item-shell {
                grid-template-columns: minmax(220px, 1fr) minmax(160px, .7fr) minmax(160px, .7fr);
            }

            .session-admin-actions {
                grid-column: 1 / -1;
                flex-direction: row;
                flex-wrap: wrap;
            }
        }

        @media (max-width: 1080px) {
            .session-admin-filters {
                grid-template-columns: 1fr 1fr;
                max-width: none;
            }

            .session-admin-item-shell {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 767px) {
            .session-admin-page .page-banner {
                padding: 1.2rem 1rem 1.45rem;
            }

            .session-admin-stats {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .session-admin-toolbar,
            .session-admin-resultsbar,
            .session-admin-pagination {
                padding-left: 16px;
                padding-right: 16px;
            }

            .session-admin-toolbar {
                align-items: stretch;
                gap: 14px;
            }

            .session-admin-filters {
                grid-template-columns: 1fr;
            }

            .session-admin-item-shell {
                grid-template-columns: 1fr;
                padding: 16px;
            }

            .session-admin-actions {
                flex-direction: column;
            }

            .session-admin-btn {
                width: 100%;
            }

            .session-admin-resultsbar {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endsection

@section('content')
    <main id="mainContent" class="admin-page-shell session-admin-page">
        <div class="w-full">
            <section class="page-banner">
                <div class="page-banner-inner">
                    <div class="page-banner-copy">
                        <h1 class="page-title">Session Dashboard</h1>
                    </div>

                    <div class="page-banner-actions">
                        <span class="page-badge">
                            <span class="page-badge-dot"></span>
                            Centralized Session Control
                        </span>
                    </div>
                </div>
            </section>

            <section class="session-admin-stats">
                <article class="session-admin-stat">
                    <div class="session-admin-stat-top">
                        <span class="session-admin-stat-label">Active Sessions</span>
                        <span class="session-admin-stat-icon"><i class="fa-solid fa-signal"></i></span>
                    </div>
                    <span class="session-admin-stat-value">{{ $stats['total_sessions'] ?? 0 }}</span>
                    <span class="session-admin-stat-note">All currently tracked browser sessions</span>
                </article>

                <article class="session-admin-stat">
                    <div class="session-admin-stat-top">
                        <span class="session-admin-stat-label">Active Users</span>
                        <span class="session-admin-stat-icon"><i class="fa-solid fa-users"></i></span>
                    </div>
                    <span class="session-admin-stat-value">{{ $stats['active_users'] ?? 0 }}</span>
                    <span class="session-admin-stat-note">Accounts with at least one active session</span>
                </article>

                <article class="session-admin-stat">
                    <div class="session-admin-stat-top">
                        <span class="session-admin-stat-label">Admin Sessions</span>
                        <span class="session-admin-stat-icon"><i class="fa-solid fa-user-shield"></i></span>
                    </div>
                    <span class="session-admin-stat-value">{{ $stats['admin_sessions'] ?? 0 }}</span>
                    <span class="session-admin-stat-note">Privileged access that deserves close review</span>
                </article>

                <article class="session-admin-stat">
                    <div class="session-admin-stat-top">
                        <span class="session-admin-stat-label">Dentist Sessions</span>
                        <span class="session-admin-stat-icon"><i class="fa-solid fa-user-doctor"></i></span>
                    </div>
                    <span class="session-admin-stat-value">{{ $stats['dentist_sessions'] ?? 0 }}</span>
                    <span class="session-admin-stat-note">Clinic-side operational accounts</span>
                </article>

                <article class="session-admin-stat">
                    <div class="session-admin-stat-top">
                        <span class="session-admin-stat-label">Patient Sessions</span>
                        <span class="session-admin-stat-icon"><i class="fa-solid fa-user"></i></span>
                    </div>
                    <span class="session-admin-stat-value">{{ $stats['patient_sessions'] ?? 0 }}</span>
                    <span class="session-admin-stat-note">Self-service access currently online</span>
                </article>
            </section>

            <section class="session-admin-card">
                <div class="session-admin-toolbar">
                    <div class="session-admin-toolbar-copy">
                        <h2>All Active User Sessions</h2>
                        <p>Filter by role, search by user or browser, and take action from a cleaner session queue without exposing raw session secrets.</p>
                    </div>

                    <form method="GET" action="{{ route('admin.session_management.index') }}" class="session-admin-filters">
                        <div class="session-admin-search-wrap">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input
                                type="text"
                                name="search"
                                value="{{ $filters['search'] ?? '' }}"
                                class="session-admin-field session-admin-search"
                                placeholder="Search user, email, IP, or browser">
                        </div>

                        <div class="session-admin-select-wrap">
                            <select name="role" class="session-admin-field session-admin-select">
                                @foreach (['all' => 'All Roles', 'admin' => 'Admin', 'dentist' => 'Dentist', 'patient' => 'Patient'] as $value => $label)
                                    <option value="{{ $value }}" {{ ($filters['role'] ?? 'all') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="session-admin-select-wrap">
                            <select name="per_page" class="session-admin-field session-admin-select">
                                @foreach ([10, 15, 20, 50, 100] as $size)
                                    <option value="{{ $size }}" {{ (int) $perPage === $size ? 'selected' : '' }}>
                                        {{ $size }} / page
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="session-admin-btn session-admin-btn-primary">Apply Filters</button>
                    </form>
                </div>

                <div class="session-admin-resultsbar">
                    <div class="session-admin-results-meta">
                        Showing
                        <strong>{{ $sessions->firstItem() ?? 0 }}-{{ $sessions->lastItem() ?? 0 }}</strong>
                        of
                        <strong>{{ $sessions->total() }}</strong>
                        active sessions
                    </div>

                    <div class="session-admin-rolechips">
                        <span class="session-admin-chip">
                            <i class="fa-solid fa-user-shield"></i>
                            Admin {{ $stats['admin_sessions'] ?? 0 }}
                        </span>
                        <span class="session-admin-chip">
                            <i class="fa-solid fa-user-doctor"></i>
                            Dentist {{ $stats['dentist_sessions'] ?? 0 }}
                        </span>
                        <span class="session-admin-chip">
                            <i class="fa-solid fa-user"></i>
                            Patient {{ $stats['patient_sessions'] ?? 0 }}
                        </span>
                    </div>
                </div>

                @if ($sessions->count() > 0)
                    <div class="session-admin-list">
                        @foreach ($sessions as $session)
                            @php
                                $roleClass = match ($session->role_slug) {
                                    'admin', 'super_admin' => 'session-admin-role-admin',
                                    'dentist' => 'session-admin-role-dentist',
                                    'patient' => 'session-admin-role-patient',
                                    default => 'session-admin-role-admin',
                                };

                                $statusClass = strtolower((string) $session->user_status) === 'active'
                                    ? 'session-admin-status-active'
                                    : 'session-admin-status-inactive';

                                $initial = strtoupper(substr((string) $session->user_name, 0, 1));
                            @endphp

                            <article class="session-admin-item {{ $session->is_current ? 'session-admin-item-current' : '' }}">
                                <div class="session-admin-item-shell">
                                    <div class="session-admin-userblock">
                                        <div class="session-admin-avatar">{{ $initial }}</div>

                                        <div>
                                            <div class="session-admin-userhead">
                                                <span class="session-admin-user-name">{{ $session->user_name }}</span>

                                                @if ($session->is_current)
                                                    <span class="session-admin-current-pill">
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        Current Admin Session
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="session-admin-user-email">{{ $session->user_email }}</div>
                                        </div>
                                    </div>

                                    <div class="session-admin-meta-col">
                                        <span class="session-admin-meta-label">Role</span>
                                        <span class="session-admin-role {{ $roleClass }}">{{ $session->role_label }}</span>
                                    </div>

                                    <div class="session-admin-meta-col">
                                        <span class="session-admin-meta-label">Account Status</span>
                                        <span class="session-admin-status {{ $statusClass }}">
                                            {{ ucfirst((string) $session->user_status) }}
                                        </span>
                                    </div>

                                    <div class="session-admin-meta-col">
                                        <span class="session-admin-meta-label">Device</span>
                                        <span class="session-admin-device-title">{{ $session->device_label }}</span>
                                        <span class="session-admin-device-sub">{{ $session->user_agent }}</span>
                                    </div>

                                    <div class="session-admin-meta-col">
                                        <span class="session-admin-meta-label">IP and Last Activity</span>
                                        <span class="session-admin-ip">{{ $session->ip_address }}</span>
                                        <span class="session-admin-activity">{{ $session->last_activity_label }}</span>

                                        <div class="session-admin-actions">
                                            @if (!$session->is_current)
                                                <form method="POST" action="{{ route('admin.session_management.destroy_session', $session->reference) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="session-admin-btn session-admin-btn-soft">Log Out This Session</button>
                                                </form>
                                            @else
                                                <button type="button" class="session-admin-btn session-admin-btn-current" disabled>This Session Is Protected</button>
                                            @endif

                                            <form method="POST" action="{{ route('admin.session_management.destroy_user_sessions', $session->user_id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="session-admin-btn {{ $session->is_current ? 'session-admin-btn-soft' : 'session-admin-btn-danger' }}">
                                                    {{ $session->is_current ? 'Log Out Other Sessions' : 'Log Out All User Sessions' }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="session-admin-empty">
                        <div class="session-admin-empty-icon">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h3>No Active Sessions Found</h3>
                        <p>The current filters did not match any active sessions. Try changing the role filter or clearing the search query.</p>
                    </div>
                @endif

                <div class="session-admin-pagination">
                    <div class="session-admin-pagination-info">
                        Page
                        <strong>{{ $sessions->currentPage() }}</strong>
                        of
                        <strong>{{ $sessions->lastPage() }}</strong>
                    </div>

                    <div class="session-admin-links">
                        {{ $sessions->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
