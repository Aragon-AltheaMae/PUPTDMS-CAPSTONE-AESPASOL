@extends('layouts.app')

@section('layout-role', 'admin')
@section('title', 'Session Dashboard')

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
                        <span class="session-admin-stat-label global-info-label">Active Sessions</span>
                        <span class="session-admin-stat-icon global-info-icon">
                            <i class="fa-solid fa-signal"></i>
                        </span>
                    </div>
                    <span class="session-admin-stat-value">{{ $stats['total_sessions'] ?? 0 }}</span>
                    <span class="session-admin-stat-note">All currently tracked browser sessions</span>
                </article>

                <article class="session-admin-stat">
                    <div class="session-admin-stat-top">
                        <span class="session-admin-stat-label global-info-label">Active Users</span>
                        <span class="session-admin-stat-icon global-info-icon">
                            <i class="fa-solid fa-users"></i>
                        </span>
                    </div>
                    <span class="session-admin-stat-value">{{ $stats['active_users'] ?? 0 }}</span>
                    <span class="session-admin-stat-note">Accounts with at least one active session</span>
                </article>

                <article class="session-admin-stat">
                    <div class="session-admin-stat-top">
                        <span class="session-admin-stat-label global-info-label">Admin Sessions</span>
                        <span class="session-admin-stat-icon global-info-icon">
                            <i class="fa-solid fa-user-shield"></i>
                        </span>
                    </div>
                    <span class="session-admin-stat-value">{{ $stats['admin_sessions'] ?? 0 }}</span>
                    <span class="session-admin-stat-note">Privileged access that deserves close review</span>
                </article>

                <article class="session-admin-stat">
                    <div class="session-admin-stat-top">
                        <span class="session-admin-stat-label global-info-label">Dentist Sessions</span>
                        <span class="session-admin-stat-icon global-info-icon">
                            <i class="fa-solid fa-user-doctor"></i>
                        </span>
                    </div>
                    <span class="session-admin-stat-value">{{ $stats['dentist_sessions'] ?? 0 }}</span>
                    <span class="session-admin-stat-note">Clinic-side operational accounts</span>
                </article>

                <article class="session-admin-stat">
                    <div class="session-admin-stat-top">
                        <span class="session-admin-stat-label global-info-label">Patient Sessions</span>
                        <span class="session-admin-stat-icon global-info-icon">
                            <i class="fa-solid fa-user"></i>
                        </span>
                    </div>
                    <span class="session-admin-stat-value">{{ $stats['patient_sessions'] ?? 0 }}</span>
                    <span class="session-admin-stat-note">Self-service access currently online</span>
                </article>
            </section>

            <section class="session-admin-card">
                <div class="session-admin-toolbar">
                    <div class="session-admin-toolbar-copy">
                        <h2>All Active User Sessions</h2>
                        <p>Filter by role, search by user or browser, and take action
                            from a cleaner session queue without exposing raw session secrets.</p>
                    </div>

                    <form method="GET" action="{{ route('admin.session_management.index') }}"
                        class="session-admin-filters">
                        <div class="session-admin-search-wrap">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                                class="session-admin-field session-admin-search"
                                placeholder="Search user, email, IP, or browser">
                        </div>

                        <div class="session-admin-select-wrap">
                            <select name="role" class="session-admin-field session-admin-select">
                                @foreach (['all' => 'All Roles', 'admin' => 'Admin', 'dentist' => 'Dentist', 'patient' => 'Patient'] as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ ($filters['role'] ?? 'all') === $value ? 'selected' : '' }}>
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

                        <button type="submit" class="session-admin-btn session-admin-btn-primary ui-btn">
                            Apply Filters
                        </button>
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
                        <span class="session-admin-chip global-info-pill">
                            <i class="fa-solid fa-user-shield"></i>
                            Admin {{ $stats['admin_sessions'] ?? 0 }}
                        </span>
                        <span class="session-admin-chip global-info-pill">
                            <i class="fa-solid fa-user-doctor"></i>
                            Dentist {{ $stats['dentist_sessions'] ?? 0 }}
                        </span>
                        <span class="session-admin-chip global-info-pill">
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

                                $statusClass =
                                    strtolower((string) $session->user_status) === 'active'
                                        ? 'session-admin-status-active'
                                        : 'session-admin-status-inactive';

                                $initial = strtoupper(substr((string) $session->user_name, 0, 1));
                            @endphp

                            <article
                                class="session-admin-item {{ $session->is_current ? 'session-admin-item-current' : '' }}">
                                <div class="session-admin-item-shell">
                                    <div class="session-admin-userblock">
                                        <div class="session-admin-avatar global-record-avatar">
                                            {{ $initial }}
                                        </div>

                                        <div>
                                            <div class="session-admin-userhead">
                                                <span class="session-admin-user-name">{{ $session->user_name }}</span>

                                                @if ($session->is_current)
                                                    <span class="session-admin-current-pill status-pill">
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        Current Admin Session
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="session-admin-user-email">{{ $session->user_email }}</div>
                                        </div>
                                    </div>

                                    <div class="session-admin-meta-col">
                                        <span class="session-admin-meta-label global-info-label">
                                            Role
                                        </span>

                                        <span class="session-admin-role status-pill {{ $roleClass }}">
                                            {{ $session->role_label }}
                                        </span>
                                    </div>

                                    <div class="session-admin-meta-col">
                                        <span class="session-admin-meta-label global-info-label">
                                            Account Status
                                        </span>

                                        <span class="session-admin-status status-pill {{ $statusClass }}">
                                            {{ ucfirst((string) $session->user_status) }}
                                        </span>
                                    </div>

                                    <div class="session-admin-meta-col">
                                        <span class="session-admin-meta-label global-info-label">
                                            Device
                                        </span>

                                        <span class="session-admin-device-title global-info-value">
                                            @if ($session->device_type === 'mobile')
                                                <i class="fa-solid fa-mobile-screen-button"></i>
                                            @elseif ($session->device_type === 'tablet')
                                                <i class="fa-solid fa-tablet-screen-button"></i>
                                            @else
                                                <i class="fa-solid fa-desktop"></i>
                                            @endif

                                            {{ $session->device_label }}
                                        </span>

                                        <span class="session-admin-device-sub global-info-subvalue">
                                            {{ $session->browser_label }} · {{ $session->os_label }}
                                        </span>
                                    </div>

                                    <div class="session-admin-meta-col">
                                        <span class="session-admin-meta-label global-info-label">
                                            IP and Last Activity
                                        </span>

                                        <span class="session-admin-ip global-info-value">
                                            {{ $session->ip_address }}
                                        </span>

                                        <span class="session-admin-activity global-info-subvalue">
                                            {{ $session->last_activity_label }}
                                        </span>

                                        <div class="session-admin-actions">
                                            @if (!$session->is_current)
                                                <form method="POST"
                                                    action="{{ route('admin.session_management.destroy_session', $session->reference) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="session-admin-btn session-admin-btn-soft ui-btn">
                                                        Log Out This Session
                                                    </button>
                                                </form>
                                            @else
                                                <button type="button"
                                                    class="session-admin-btn session-admin-btn-current ui-btn" disabled>
                                                    This Session Is Protected
                                                </button>
                                            @endif

                                            <form method="POST"
                                                action="{{ route('admin.session_management.destroy_user_sessions', $session->user_id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="session-admin-btn ui-btn 
                                                        {{ $session->is_current ? 'session-admin-btn-soft' : 'session-admin-btn-danger' }}">
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
                        <div class="session-admin-empty-icon global-info-icon">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h3>No Active Sessions Found</h3>
                        <p>The current filters did not match any active sessions. Try changing the role filter or clearing
                            the search query.</p>
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
