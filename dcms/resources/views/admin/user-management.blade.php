@extends('layouts.app')

@section('layout-role', 'admin')

@section('title', 'User Management')

@section('content')

@php
$totalUsers = $totalUsers ?? ($allUsersCount ?? ($users->total() ?? 0));
$activeCount = $activeCount ?? 0;
$inactiveCount = $inactiveCount ?? 0;
@endphp

<main id="mainContent" class="admin-page-shell user-management-page page-enter mode-list">
    <div class="w-full">
        <div class="page-banner">
            <div class="page-banner-inner">
                <div>
                    <h1 class="page-title">User Management</h1>
                </div>

                <div class="flex items-center gap-3 flex-wrap w-full sm:w-auto">
                    <button type="button" onclick="openModal('addModal', this)" class="um-hero-btn">
                        <i class="fa-solid fa-user-plus"></i>
                        <span>Add New User</span>
                    </button>
                </div>
            </div>
        </div>

        @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showSuccessToast("{{ session('success') }}");
            });
        </script>
        @endif

        @if (session('generated_user_password'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                openModal('generatedPasswordModal');
            });
        </script>
        @endif

        @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showErrorToast("{{ session('error') }}");
            });
        </script>
        @endif

        <div class="admin-page-body">

            <div id="statCards" class="stat-grid admin-dashboard-stat-grid user-management-stat-grid mb-6">
                <div class="stat-card s-all">
                    <div class="stat-card-info">
                        <span class="stat-label">Total Users</span>
                        <span class="stat-num" id="countTotalUsers">{{ $totalUsers }}</span>
                        <span class="stat-footer">
                            <i class="fa-solid fa-users"></i>
                            All registered system accounts
                        </span>
                    </div>

                    <div class="stat-icon-wrapper">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>

                <div class="stat-card s-approved">
                    <div class="stat-card-info">
                        <span class="stat-label">Active</span>
                        <span class="stat-num" id="countActiveUsers">{{ $activeCount }}</span>
                        <span class="stat-footer">
                            <i class="fa-solid fa-circle-check"></i>
                            Accounts currently enabled
                        </span>
                    </div>

                    <div class="stat-icon-wrapper">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>

                <div class="stat-card s-rejected">
                    <div class="stat-card-info">
                        <span class="stat-label">Inactive</span>
                        <span class="stat-num" id="countInactiveUsers">{{ $inactiveCount }}</span>
                        <span class="stat-footer">
                            <i class="fa-solid fa-user-slash"></i>
                            Accounts currently disabled
                        </span>
                    </div>

                    <div class="stat-icon-wrapper">
                        <i class="fa-solid fa-user-slash"></i>
                    </div>
                </div>
            </div>

            <div class="um-users-card card bg-white rounded-xl shadow border border-gray-100 overflow-visible">
                <div class="um-users-toolbar px-4 sm:px-5 py-4 border-b bg-gray-50">
                    <div class="um-users-heading">
                        <div class="card-header-icon">
                            <i class="fa-solid fa-users-gear"></i>
                        </div>

                        <h2 class="font-bold text-gray-800 text-sm">All System Users</h2>

                        <span id="countBadgeUsers"
                            class="text-[10px] font-bold bg-[#8B0000] text-white px-2 py-0.5 rounded-full">
                            {{ $totalUsers }}
                        </span>
                    </div>

                    <form method="GET" action="{{ route('admin.user_management') }}" id="umFilterForm"
                        class="um-users-filter-form">
                        <div class="um-search-mobile um-search-row voice-search-row" data-voice-field>
                            <div class="search-wrap global-search" data-search-wrapper>
                                <i class="fa-solid fa-magnifying-glass search-icon"></i>

                                <input id="umSearch" name="search" class="search-input no-voice"
                                    placeholder="Search name or email…" value="{{ $search ?? '' }}" autocomplete="off"
                                    data-search-input onkeydown="if(event.key==='Enter'){event.preventDefault();}" />

                                <button type="button" class="search-clear" data-search-clear aria-label="Clear search">
                                    <i class="fa-solid fa-xmark text-xs"></i>
                                </button>
                            </div>

                            <div class="voice-input-toggle">
                                <button type="button" id="umSearchMicBtn" class="voice-search-mic external"
                                    data-voice-trigger data-voice-target="#umSearch"
                                    data-voice-status="#umSearchVoiceStatus" aria-label="Voice input for user search">
                                    <i class="fa-solid fa-microphone"></i>
                                </button>

                                <span id="umSearchVoiceStatus" class="voice-status hidden" data-voice-status
                                    aria-live="polite"></span>
                            </div>
                        </div>

                        <x-view-toggle id="umViewToggle" class="um-view-toggle" storage-key="userManagementView"
                            list-view="#umListView" grid-view="#umGridView" />
                    </form>
                </div>

                <div class="global-pagebar global-pagebar-top">
                    <div class="global-pagebar-left">
                        <span class="global-pagebar-info">
                            Showing
                            <strong>{{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }}</strong>
                            of <strong>{{ $users->total() }}</strong> users
                        </span>

                        <div class="global-page-size-control">
                            <label for="umPerPageSelect">Show</label>

                            <div class="global-page-size-select" data-global-page-size
                                data-page-size-input="#umPerPageSelect">

                                <select id="umPerPageSelect" class="global-page-size-native" tabindex="-1"
                                    aria-hidden="true">

                                    @foreach ([10, 20, 50, 100] as $size)
                                    <option value="{{ $size }}" {{ (int) ($perPage ?? 10)===$size ? 'selected' : '' }}>
                                        {{ $size }}
                                    </option>
                                    @endforeach
                                </select>

                                <button type="button" class="global-page-size-trigger" data-page-size-trigger
                                    aria-haspopup="listbox" aria-expanded="false">

                                    <span data-page-size-value>
                                        {{ (int) ($perPage ?? 10) }}
                                    </span>

                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>

                                <div class="global-page-size-menu" role="listbox">
                                    @foreach ([10, 20, 50, 100] as $size)
                                    <button type="button"
                                        class="global-page-size-option {{ (int) ($perPage ?? 10) === $size ? 'is-selected' : '' }}"
                                        data-page-size-option data-value="{{ $size }}" role="option"
                                        aria-selected="{{ (int) ($perPage ?? 10) === $size ? 'true' : 'false' }}">

                                        <span>{{ $size }}</span>
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                    @endforeach
                                </div>
                            </div>

                            <span>per page</span>
                        </div>
                    </div>

                    <div class="global-pagination-wrap"></div>
                </div>

                <div class="um-users-content">
                    <div class="um-view um-list-view" id="umListView">
                        <div class="um-table-scroll overflow-x-auto">
                            <table class="w-full text-sm data-table um-table">
                                <thead class="bg-gray-50 border-b border-gray-100">
                                    <tr class="text-[10px] uppercase tracking-wide text-[#8B0000] font-bold">
                                        <th class="py-3 px-3 sm:px-5 text-left w-12 hidden sm:table-cell">#</th>
                                        <th class="py-3 px-4 text-left">User</th>
                                        <th class="py-3 px-4 text-left">Role</th>
                                        <th class="py-3 px-4 text-center">Status</th>
                                        <th class="py-3 px-4 text-left hidden lg:table-cell">Registered</th>
                                        <th class="py-3 px-4 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="umTableBody">
                                    @forelse($users as $user)
                                    <tr class="user-table-row border-b border-gray-50 last:border-0"
                                        data-name="{{ strtolower($user->name) }}"
                                        data-email="{{ strtolower($user->email) }}"
                                        data-role="{{ strtolower(optional($user->role)->name ?? '') }}">
                                        <td class="py-3.5 px-3 sm:px-5 hidden sm:table-cell">
                                            <span class="text-xs text-gray-400 font-medium">{{ $users->firstItem() +
                                                $loop->index }}</span>
                                        </td>

                                        <td class="py-3.5 px-2 sm:px-4">
                                            <div class="flex items-center gap-2 sm:gap-3">
                                                <div
                                                    class="w-9 h-9 rounded-full bg-gradient-to-br from-[#8B0000] to-[#b00000] flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-gray-800 text-sm leading-tight">
                                                        {{ $user->name }}
                                                    </div>
                                                    <div class="text-[11px] text-gray-400 mt-0.5 hidden sm:block">
                                                        {{ $user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="py-3.5 px-4">
                                            @php $roleSlug = optional($user->role)->slug ?? 'none'; @endphp

                                            <span class="badge-role role-{{ $roleSlug }}">
                                                {{ optional($user->role)->name ?? 'No Role' }}
                                            </span>
                                        </td>

                                        <td class="py-3.5 px-4 text-center">
                                            <span
                                                class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ $user->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </td>

                                        <td class="py-3.5 px-4 hidden lg:table-cell">
                                            <span class="text-xs text-gray-600">{{ $user->created_at->format('M d, Y')
                                                }}</span>
                                        </td>

                                        <td class="py-3.5 px-4">
                                            @php
                                            $userDetails = [
                                            'id' => $user->id,
                                            'name' => $user->name,
                                            'email' => $user->email,
                                            'role' =>
                                            optional($user->role)->display_name ??
                                            (optional($user->role)->name ?? 'No Role'),
                                            'status' => ucfirst($user->status),
                                            'source' => 'Users',
                                            'created_at' => $user->created_at
                                            ? $user->created_at->format('M d, Y h:i
                                            A')
                                            : 'N/A',
                                            'updated_at' => $user->updated_at
                                            ? $user->updated_at->format('M d, Y h:i
                                            A')
                                            : 'N/A',
                                            'phone' =>
                                            optional($user->patient)->phone ?:
                                            ($user->phone ?:
                                            'N/A'),
                                            'birthdate' =>
                                            optional(optional($user->patient)->birthdate)
                                            ?->format('M d,
                                            Y') ??
                                            (optional($user->birthdate)?->format('M d, Y') ??
                                            'N/A'),
                                            'gender' =>
                                            optional($user->patient)->gender ?:
                                            ($user->gender ?:
                                            'N/A'),
                                            'phone_raw' =>
                                            optional($user->patient)->phone ?? ($user->phone ?? ''),
                                            'birthdate_raw' =>
                                            optional(optional($user->patient)->birthdate)?->format(
                                            'Y-m-d',
                                            ) ??
                                            (optional($user->birthdate)?->format('Y-m-d') ?? ''),
                                            'gender_raw' =>
                                            optional($user->patient)->gender ??
                                            ($user->gender ?? ''),
                                            'patient_profile' => $user->patient
                                            ? 'Linked'
                                            : 'Not linked',
                                            'last_login_at' =>
                                            optional($user->last_login_at)?->format(
                                            'M d, Y h:i A',
                                            ) ?? 'Never',
                                            ];
                                            @endphp
                                            <div class="ui-action-group um-action-group">
                                                <button type="button" data-user-details='@json($userDetails)'
                                                    onclick="openEditModalFromButton(this, 'users', {{ $user->id }}, @js($user->name), @js($user->email), @js($user->role_id), @js($user->status))"
                                                    class="ui-action-btn ui-action-edit" data-tooltip="Edit account"
                                                    aria-label="Edit account">
                                                    <i class="fa-solid fa-pen text-[11px]"></i>
                                                </button>

                                                <button type="button" onclick="openToggleConfirm(
        {{ $user->id }},
        @js($user->status),
        @js($user->name)
    )" class="ui-action-btn {{ $user->status === 'active' ? 'ui-action-warning' : 'ui-action-success' }}"
                                                    data-tooltip="{{ $user->status === 'active' ? 'Deactivate account' : 'Activate account' }}"
                                                    aria-label="{{ $user->status === 'active' ? 'Deactivate account' : 'Activate account' }}">

                                                    <i
                                                        class="fa-solid {{ $user->status === 'active' ? 'fa-toggle-on' : 'fa-toggle-off' }}">
                                                    </i>
                                                </button>

                                                <button type="button" onclick="openResetModal(
        'users',
        {{ $user->id }},
        @js($user->name)
    )" class="ui-action-btn ui-action-reset" data-tooltip="Reset password" aria-label="Reset password">

                                                    <i class="fa-solid fa-key"></i>
                                                </button>

                                                <button type="button" data-user-details='@json($userDetails)'
                                                    onclick="openViewModalFromButton(this)"
                                                    class="ui-action-btn ui-action-view" data-tooltip="View details"
                                                    aria-label="View details">
                                                    <i class="fa-solid fa-eye text-[11px]"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr id="dbEmptyRow">
                                        <td colspan="6" style="padding:3.5rem 1rem;text-align:center;">
                                            <div
                                                style="display:inline-flex;align-items:center;justify-content:center;width:64px;height:64px;background:#f3f4f6;border-radius:18px;margin-bottom:1rem;">
                                                <i class="fa-solid fa-magnifying-glass"
                                                    style="font-size:1.6rem;color:#d1d5db;"></i>
                                            </div>
                                            <p style="font-size:.9rem;font-weight:700;color:#374151;margin:0 0 .3rem;">
                                                No
                                                users
                                                found</p>
                                            <p style="font-size:.78rem;color:#9ca3af;margin:0;">Try adjusting your
                                                filters.
                                            </p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="um-view" id="umGridView" hidden>
                        <div class="um-grid-wrap">
                            <div class="um-grid" id="umGridBody">
                                @forelse($users as $user)
                                @php
                                $roleSlug = optional($user->role)->slug;
                                $roleName = optional($user->role)->name ?? 'No Role';
                                @endphp

                                <div class="um-grid-card">
                                    <div class="um-grid-top">
                                        <div class="um-grid-number">#{{ $users->firstItem() + $loop->index }}
                                        </div>
                                        <span
                                            class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ $user->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#8B0000] to-[#b00000] flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-semibold text-gray-800 text-sm leading-tight">
                                                {{ $user->name }}
                                            </div>
                                            <div class="text-[11px] text-gray-400 mt-0.5">
                                                {{ $user->email }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="um-grid-meta">
                                        <div class="um-grid-field">
                                            <div class="um-grid-label">
                                                Role
                                            </div>

                                            <div class="um-grid-value">
                                                <span class="badge-role role-{{ $roleSlug ?? 'none' }}">
                                                    {{ $roleName }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="um-grid-field">
                                            <div class="um-grid-label">
                                                Registered
                                            </div>

                                            <div class="um-registered-date">
                                                <span class="um-registered-icon">
                                                    <i class="fa-solid fa-calendar-day"></i>
                                                </span>

                                                <span class="um-registered-text">
                                                    {{ $user->created_at->format('M d, Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ui-action-group">
                                        @php
                                        $userDetails = [
                                        'id' => $user->id,
                                        'name' => $user->name,
                                        'email' => $user->email,
                                        'role' =>
                                        optional($user->role)->display_name ??
                                        (optional($user->role)->name ?? 'No Role'),
                                        'status' => ucfirst($user->status),
                                        'source' => 'Users',
                                        'created_at' => $user->created_at
                                        ? $user->created_at->format('M d, Y h:i A')
                                        : 'N/A',
                                        'updated_at' => $user->updated_at
                                        ? $user->updated_at->format('M d, Y h:i A')
                                        : 'N/A',
                                        'phone' =>
                                        optional($user->patient)->phone ?: ($user->phone ?: 'N/A'),
                                        'birthdate' =>
                                        optional(optional($user->patient)->birthdate)?->format(
                                        'M d, Y',
                                        ) ??
                                        (optional($user->birthdate)?->format('M d, Y') ?? 'N/A'),
                                        'gender' =>
                                        optional($user->patient)->gender ?:
                                        ($user->gender ?:
                                        'N/A'),
                                        'phone_raw' =>
                                        optional($user->patient)->phone ?? ($user->phone ?? ''),
                                        'birthdate_raw' =>
                                        optional(optional($user->patient)->birthdate)?->format(
                                        'Y-m-d',
                                        ) ??
                                        (optional($user->birthdate)?->format('Y-m-d') ?? ''),
                                        'gender_raw' =>
                                        optional($user->patient)->gender ?? ($user->gender ?? ''),
                                        'patient_profile' => $user->patient ? 'Linked' : 'Not linked',
                                        'last_login_at' =>
                                        optional($user->last_login_at)?->format('M d, Y h:i A') ??
                                        'Never',
                                        ];
                                        @endphp
                                        <button type="button" data-user-details='@json($userDetails)'
                                            onclick="openEditModalFromButton(this, 'users', {{ $user->id }}, @js($user->name), @js($user->email), @js($user->role_id), @js($user->status))"
                                            class="ui-action-btn ui-action-edit" data-tooltip="Edit account"
                                            aria-label="Edit account">
                                            <i class="fa-solid fa-pen text-[11px]"></i>
                                        </button>

                                        <button type="button" onclick="openToggleConfirm(
        {{ $user->id }},
        @js($user->status),
        @js($user->name)
    )" class="ui-action-btn {{ $user->status === 'active' ? 'ui-action-warning' : 'ui-action-success' }}"
                                            data-tooltip="{{ $user->status === 'active' ? 'Deactivate account' : 'Activate account' }}"
                                            aria-label="{{ $user->status === 'active' ? 'Deactivate account' : 'Activate account' }}">

                                            <i
                                                class="fa-solid {{ $user->status === 'active' ? 'fa-toggle-on' : 'fa-toggle-off' }}">
                                            </i>
                                        </button>

                                        <button type="button" onclick="openResetModal(
                                        'users',
                                        {{ $user->id }},
                                        @js($user->name)
                                        )" class="ui-action-btn ui-action-reset" data-tooltip="Reset password"
                                            aria-label="Reset password">

                                            <i class="fa-solid fa-key"></i>
                                        </button>

                                        <button type="button" data-user-details='@json($userDetails)'
                                            onclick="openViewModalFromButton(this)" class="ui-action-btn ui-action-view"
                                            data-tooltip="View details" aria-label="View details">
                                            <i class="fa-solid fa-eye text-[11px]"></i>
                                        </button>
                                    </div>
                                </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="global-pagebar global-pagebar-bottom">
                    <span class="global-pagebar-info">
                        Showing
                        <strong>{{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }}</strong>
                        of <strong>{{ $users->total() }}</strong> users
                    </span>

                    <div class="global-pagination-wrap"></div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal-overlay" id="generatedPasswordModal" aria-hidden="true">
    <div class="modal-box-inner um-user-modal um-user-modal-sm" onclick="event.stopPropagation()">
        <div class="modal-themed-header
           px-6 py-5 border-b
           flex items-center justify-between
           sticky top-0 rounded-t-2xl z-10">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-green-600 flex items-center justify-center shadow">
                    <i class="fa-solid fa-key text-white text-sm"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-gray-800 text-base">Generated Password</h3>
                    <p class="text-[12px] text-gray-500">Share this with the new user before closing.</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('generatedPasswordModal')"
                data-close-modal="generatedPasswordModal" class="modal-x" aria-label="Close generated password modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="p-6 space-y-4">
            <div class="rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                <strong>{{ session('generated_user_password.name') }}</strong><br>
                <span class="text-xs">{{ session('generated_user_password.email') }}</span>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                    Temporary Password
                </label>
                <div class="relative">
                    <input type="text" id="generatedUserPasswordValue"
                        value="{{ session('generated_user_password.password') }}"
                        class="field-input w-full border border-gray-200 px-3.5 py-3 pr-24 text-sm bg-white font-mono"
                        readonly>
                    <button type="button" onclick="copyGeneratedPassword()"
                        class="absolute right-2 top-1/2 -translate-y-1/2 px-3 py-1.5 rounded-lg bg-[#8B0000] text-white text-xs font-bold">
                        Copy
                    </button>
                </div>
            </div>

            <div class="um-password-note">
                This password is shown only once. Ask the user to change it after first login.
            </div>
        </div>
    </div>
</div>

<div class="modal-overlay modal-theme-primary" id="addModal" aria-hidden="true">
    <div class="modal-box-inner um-user-modal um-user-modal-lg" onclick="event.stopPropagation()">
        <div
            class="um-user-modal-header modal-themed-header px-6 py-5 border-b flex items-center justify-between sticky top-0 rounded-t-2xl z-10">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-11 h-11 rounded-2xl modal-themed-icon flex-shrink-0">
                    <i class="fa-solid fa-user-plus text-white text-sm"></i>
                </div>
                <div class="min-w-0">
                    <h3 class="font-extrabold text-gray-800 text-lg leading-tight">Add New User</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Create a system account and assign access permissions.</p>
                </div>
            </div>

            <button type="button" data-discard-close="addModal" class="modal-x" aria-label="Close add user modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.user_management.store') }}" id="addUserForm"
            class="flex-1 flex flex-col min-h-0" data-global-validation data-global-selects data-discard-form
            data-discard-title="Discard new user?" data-discard-subtitle="You have unsaved account details."
            data-discard-message="Closing this modal will remove the user information you entered. Do you want to discard your changes?"
            novalidate>
            @csrf

            <div class="um-user-modal-body">
                @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 rounded-2xl p-3 text-xs text-red-700 space-y-1.5">
                    @foreach ($errors->all() as $error)
                    <div class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-xmark mt-0.5"></i>
                        <span>{{ $error }}</span>
                    </div>
                    @endforeach
                </div>
                @endif

                <div class="um-user-modal-grid">
                    <div class="um-user-main-card">
                        <div class="um-section-title">
                            <div class="um-section-icon bg-red-50 text-[#8B0000]">
                                <i class="fa-solid fa-id-card text-sm"></i>
                            </div>
                            <div>
                                <h4 class="text-base font-extrabold text-gray-800 leading-tight">Account Details</h4>
                                <p class="text-xs text-gray-500 mt-0.5">Basic identity, role assignment, and account
                                    status.</p>
                            </div>
                        </div>

                        <div class="um-field-grid">
                            <div class="um-field-full" data-global-field>
                                <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <div class="voice-search-row" data-voice-field>
                                    <input type="text" id="addNameInput" name="name" value="{{ old('name') }}"
                                        class="field-input flex-1 min-w-0 border border-gray-200 px-3.5 bg-white"
                                        placeholder="e.g. Juan dela Cruz" required>
                                    <div class="voice-input-toggle">
                                        <button type="button" id="addNameMicBtn" class="voice-search-mic external"
                                            data-voice-trigger data-voice-target="#addNameInput"
                                            data-voice-status="#addNameVoiceStatus"
                                            aria-label="Voice input for full name">
                                            <i class="fa-solid fa-microphone"></i>
                                        </button>
                                        <span id="addNameVoiceStatus" class="voice-status hidden" data-voice-status
                                            aria-live="polite"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="um-field-full" data-global-field>
                                <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <div class="voice-search-row" data-voice-field>
                                    <i class="fa-solid fa-envelope text-gray-400 text-xs flex-shrink-0 pl-1"></i>
                                    <input type="email" id="addEmailInput" name="email" value="{{ old('email') }}"
                                        class="field-input flex-1 min-w-0 border border-gray-200 px-3.5 bg-white"
                                        placeholder="user@pup.edu.ph" required>
                                    <div class="voice-input-toggle">
                                        <button type="button" id="addEmailMicBtn" class="voice-search-mic external"
                                            data-voice-trigger data-voice-target="#addEmailInput"
                                            data-voice-status="#addEmailVoiceStatus" aria-label="Voice input for email">
                                            <i class="fa-solid fa-microphone"></i>
                                        </button>
                                        <span id="addEmailVoiceStatus" class="voice-status hidden" data-voice-status
                                            aria-live="polite"></span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                                    Role
                                </label>
                                <select name="role_id" id="addRoleSelect" class="field-input js-custom-select">
                                    <option value="">No Role</option>

                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id')==$role->id ? 'selected' : '' }}>
                                        {{ $role->display_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                                    Account Type
                                </label>
                                <div
                                    class="field-input w-full border border-dashed border-gray-200 px-3.5 py-3 text-sm bg-gray-50 text-gray-500 flex items-center">
                                    System-managed user account
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                                    Phone Number
                                </label>
                                <input type="text" id="addPhoneInput" name="phone" value="{{ old('phone') }}"
                                    class="field-input w-full border border-gray-200 px-3.5 py-3 text-sm bg-white"
                                    placeholder="09xx xxx xxxx" inputmode="numeric" autocomplete="tel" maxlength="13">
                                <p id="addPhoneInputFeedback" class="text-xs text-gray-500 mt-1">Format: 09xx xxx xxxx
                                </p>
                            </div>

                            <div data-global-field>
                                <label for="addBirthdateInput"
                                    class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                                    Birthdate
                                </label>

                                <div class="fp-date-input-wrap">
                                    <input type="text" id="addBirthdateInput" name="birthdate"
                                        value="{{ old('birthdate') }}" class="field-input fp-date-input js-flatpickr-date-max-today
        w-full border border-gray-200 rounded-lg px-3.5 py-3 bg-white" placeholder="Select birthdate"
                                        autocomplete="off" data-validation-rule="notFutureDate" readonly>

                                    <i class="fa-regular fa-calendar fp-date-icon" aria-hidden="true"></i>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                                    Gender
                                </label>
                                <select name="gender" id="addGenderInput" class="field-input js-custom-select"
                                    data-placeholder="Select gender">
                                    <option value="" disabled>Select gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="um-divider"></div>
                    </div>

                    <div class="um-user-side-card">
                        <div class="um-section-title">
                            <div class="um-section-icon bg-blue-50 text-blue-600">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </div>
                            <div>
                                <h4 class="text-base font-extrabold text-gray-800 leading-tight">Security Setup</h4>
                                <p class="text-xs text-gray-500 mt-0.5">A secure password will be generated
                                    automatically.</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div data-global-field>
                                <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                                    Generated Password
                                </label>
                                <div class="relative">
                                    <i
                                        class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                                    <input type="password" name="password" id="addPassword" minlength="8"
                                        placeholder="Auto-generated password"
                                        class="field-input w-full border border-gray-200 pl-10 pr-11 py-3 text-sm bg-white"
                                        readonly>
                                    <button type="button" onclick="togglePassVis('addPassword','addEye')"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <i class="fa-regular fa-eye text-sm" id="addEye"></i>
                                    </button>
                                </div>
                                <div class="flex items-center gap-2 mt-2">
                                    <button type="button" onclick="refreshGeneratedPassword()"
                                        class="modal-btn-confirm-reject um-save-user-btn um-inline-action-btn">
                                        <span class="btn-confirm-icon">
                                            <i class="fa-solid fa-rotate"></i>
                                        </span>
                                        <span>Generate New</span>
                                    </button>
                                    <button type="button" onclick="copyFieldValue('addPassword')"
                                        class="modal-btn-confirm-reject um-save-user-btn um-inline-action-btn">
                                        <span class="btn-confirm-icon">
                                            <i class="fa-regular fa-copy"></i>
                                        </span>
                                        <span>Copy</span>
                                    </button>
                                </div>
                            </div>

                            <div data-global-field>
                                <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                                    Confirm Password
                                </label>
                                <div class="relative">
                                    <i
                                        class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                                    <input type="password" name="password_confirmation" id="addPasswordConf"
                                        placeholder="Repeat password"
                                        class="field-input w-full border border-gray-200 pl-10 pr-11 py-3 text-sm bg-white"
                                        readonly>
                                    <button type="button" onclick="togglePassVis('addPasswordConf','addEye2')"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <i class="fa-regular fa-eye text-sm" id="addEye2"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="um-password-note">
                                The same generated password is saved for the account and shown again after creation.
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>

                                <div class="um-status-grid">
                                    <label class="um-status-card um-status-card--active">
                                        <input type="radio" name="status" value="active" {{ old('status', 'active'
                                            )==='active' ? 'checked' : '' }} required
                                            style="accent-color:#8B0000; margin-top:.22rem;">
                                        <div class="min-w-0">
                                            <div class="text-sm font-bold text-emerald-800 leading-tight">Active</div>
                                            <div class="text-[11px] text-emerald-700 mt-0.5">Can access the system
                                                immediately</div>
                                        </div>
                                    </label>

                                    <label class="um-status-card um-status-card--inactive">
                                        <input type="radio" name="status" value="inactive" {{ old('status')==='inactive'
                                            ? 'checked' : '' }} style="accent-color:#8B0000; margin-top:.22rem;">
                                        <div class="min-w-0">
                                            <div class="text-sm font-bold text-gray-700 leading-tight">Inactive</div>
                                            <div class="text-[11px] text-gray-500 mt-0.5">Account exists but login is
                                                disabled</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-ft um-user-modal-footer">
                <button type="button" data-discard-close="addModal" class="ui-btn ui-btn-secondary">
                    Cancel
                </button>

                <button type="submit" class="ui-btn ui-btn-primary um-save-user-btn">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Save User</span>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="ui-modal modal-theme-edit" id="editModal" aria-hidden="true">
    <div class="ui-modal-card modal-md modal-split-card">
        <div class="modal-hd">
            <div class="modal-heading">
                <div class="modal-icon">
                    <i class="fa-solid fa-user-pen"></i>
                </div>

                <div class="modal-copy">
                    <h3 class="modal-title">Edit User</h3>
                    <p class="modal-subtitle" id="editModalSubtitle">
                        Updating user details
                    </p>
                </div>
            </div>

            <button type="button" data-discard-close="editModal" class="modal-x">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form method="POST" id="editForm" class="modal-card-form" data-global-validation data-global-selects
            data-discard-form data-discard-title="Discard user changes?"
            data-discard-subtitle="You have unsaved account updates."
            data-discard-message="Closing this modal will remove the changes made to this user. Do you want to discard them?"
            novalidate>
            @csrf
            @method('PUT')
            <input type="hidden" id="editOriginalRole" value="">
            <div class="modal-bd modal-scroll-body space-y-4">
                <div data-global-field>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                        Full Name <span class="text-red-500">*</span>
                    </label>

                    <div class="voice-search-row" data-voice-field>
                        <input type="text" name="name" id="editName" placeholder="Full name"
                            class="field-input flex-1 min-w-0 border border-gray-200 rounded-lg px-3 py-2.5 text-sm"
                            required>

                        <div class="voice-input-toggle">
                            <button type="button" id="editNameMicBtn" class="voice-search-mic external"
                                data-voice-trigger data-voice-target="#editName"
                                data-voice-status="#editNameVoiceStatus" aria-label="Voice input for edit full name">
                                <i class="fa-solid fa-microphone"></i>
                            </button>

                            <span id="editNameVoiceStatus" class="voice-status hidden" data-voice-status
                                aria-live="polite"></span>
                        </div>
                    </div>
                </div>

                <div data-global-field>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                        Email Address <span class="text-red-500">*</span>
                    </label>

                    <div class="voice-search-row" data-voice-field>
                        <div class="relative flex-1 min-w-0">
                            <i
                                class="fa-solid fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>

                            <input type="email" name="email" id="editEmail" placeholder="user@pup.edu.ph"
                                class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm"
                                required>
                        </div>

                        <div class="voice-input-toggle">
                            <button type="button" id="editEmailMicBtn" class="voice-search-mic external"
                                data-voice-trigger data-voice-target="#editEmail"
                                data-voice-status="#editEmailVoiceStatus" aria-label="Voice input for edit email">
                                <i class="fa-solid fa-microphone"></i>
                            </button>

                            <span id="editEmailVoiceStatus" class="voice-status hidden" data-voice-status
                                aria-live="polite"></span>
                        </div>
                    </div>
                </div>

                <div data-global-field>
                    <label for="editRole"
                        class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                        Role
                    </label>

                    <select name="role_id" id="editRole" class="field-input js-custom-select"
                        data-placeholder="No Role">
                        <option value="">No Role</option>

                        @foreach ($roles as $role)
                        <option value="{{ $role->id }}">
                            {{ $role->display_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div id="editRoleConfirmPanel" class="hidden rounded-xl border border-amber-200 bg-amber-50 px-4 py-3">
                    <label class="block text-[11px] font-bold text-amber-800 uppercase tracking-wide mb-1.5">
                        Confirm Role Change
                    </label>
                    <p class="text-[12px] text-amber-700 mb-2">
                        Enter your current admin password to continue changing this user's role.
                    </p>
                    <input type="password" name="admin_current_password" id="editAdminCurrentPassword"
                        placeholder="Current admin password"
                        class="field-input w-full border border-amber-200 rounded-lg px-3 py-2.5 text-sm bg-white"
                        autocomplete="current-password">
                </div>

                <div class="rounded-xl border border-gray-200 bg-gray-50/80 px-4 py-4 space-y-4">
                    <div>
                        <h4 class="text-sm font-bold text-gray-800">Backup Information</h4>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                            Phone Number
                        </label>
                        <input type="text" name="phone" id="editPhone" placeholder="09xx xxx xxxx"
                            class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white"
                            inputmode="numeric" autocomplete="tel" maxlength="13">
                        <p id="editPhoneFeedback" class="text-xs text-gray-500 mt-1">Format: 09xx xxx xxxx</p>
                    </div>

                    <div data-global-field>
                        <label for="editBirthdate"
                            class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                            Birthdate
                        </label>

                        <div class="fp-date-input-wrap">
                            <input type="text" id="editBirthdate" name="birthdate" class="field-input fp-date-input js-flatpickr-date-max-today
        w-full border border-gray-200 rounded-lg px-3.5 py-3 bg-white" placeholder="Select birthdate"
                                autocomplete="off" data-validation-rule="notFutureDate" readonly>

                            <i class="fa-regular fa-calendar fp-date-icon" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                            Gender
                        </label>
                        <select name="gender" id="editGender" class="field-input js-custom-select"
                            data-placeholder="Select gender">
                            <option value="" disabled>Select gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>

                <div data-global-field>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                        Status <span class="text-red-500">*</span>
                    </label>

                    <div class="global-choice-group" role="radiogroup" aria-label="Account status">

                        <label class="global-choice-card">
                            <input type="radio" name="status" id="editStatusActive" value="active"
                                class="global-choice-input" required>

                            <span class="global-choice-indicator">
                                <i class="fa-solid fa-check"></i>
                            </span>

                            <span class="global-choice-copy">
                                <strong class="global-choice-title">Active</strong>
                                <small class="global-choice-description">
                                    User can access the system
                                </small>
                            </span>
                        </label>

                        <label class="global-choice-card">
                            <input type="radio" name="status" id="editStatusInactive" value="inactive"
                                class="global-choice-input">

                            <span class="global-choice-indicator">
                                <i class="fa-solid fa-ban"></i>
                            </span>

                            <span class="global-choice-copy">
                                <strong class="global-choice-title">Inactive</strong>
                                <small class="global-choice-description">
                                    User login will be disabled
                                </small>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-ft modal-sticky-footer">
                <button type="button" data-discard-close="editModal" class="ui-btn ui-btn-secondary">
                    Cancel
                </button>

                <button type="submit" class="ui-btn ui-btn-edit">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Update User</span>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay modal-theme-reset" id="resetModal" aria-hidden="true">
    <div class="modal-box-inner
           um-user-modal
           um-user-modal-sm
           modal-split-card" onclick="event.stopPropagation()">
        <div class="modal-themed-header
           px-6 py-5 border-b
           flex items-center justify-between
           sticky top-0 rounded-t-2xl z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl modal-themed-icon">
                    <i class="fa-solid fa-key text-white text-sm"></i>
                </div>
                <div>
                    <h3 class="modal-themed-title font-extrabold text-base">
                        Reset Password
                    </h3>
                    <p class="text-[10px] text-gray-500" id="resetModalSubtitle">Set a new password</p>
                </div>
            </div>
            <button type="button" data-discard-close="resetModal" class="modal-x"
                aria-label="Close reset password modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form method="POST" id="resetForm" class="modal-card-form" data-global-validation data-discard-form
            data-discard-title="Discard password reset?" data-discard-subtitle="A new password has not been saved."
            data-discard-message="Closing this modal will remove the password you entered. Do you want to discard it?"
            novalidate>
            @csrf
            <div class="modal-bd modal-scroll-body space-y-4">
                <div data-global-field>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">New
                        Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="password" name="password" id="resetPassword" placeholder="Min. 8 characters"
                            class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-10 py-2.5 text-sm"
                            required>
                        <button type="button" onclick="togglePassVis('resetPassword','resetEye')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fa-regular fa-eye text-xs" id="resetEye"></i>
                        </button>
                    </div>

                    <div class="password-strength" id="resetPasswordStrength" data-strength="empty">
                        <div class="password-strength-track">
                            <span class="password-strength-fill"></span>
                        </div>

                        <div class="password-strength-meta">
                            <span id="resetPasswordStrengthLabel">Enter a password</span>
                            <span id="resetPasswordStrengthHint">Use 8+ chars, number, uppercase, and symbol.</span>
                        </div>
                    </div>
                </div>

                <div data-global-field>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Confirm
                        Password <span class="text-red-500">*</span></label>

                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="password" name="password_confirmation" id="resetPasswordConf"
                            placeholder="Repeat password"
                            class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-10 py-2.5 text-sm"
                            required>
                        <button type="button" onclick="togglePassVis('resetPasswordConf','resetEye2')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fa-regular fa-eye text-xs" id="resetEye2"></i>
                        </button>
                    </div>

                    <div class="password-match" id="resetPasswordMatch" data-match="empty">
                        <span class="password-match-dot"></span>
                        <span id="resetPasswordMatchText">Confirm your password.</span>
                    </div>
                </div>
            </div>
            <div class="modal-ft modal-sticky-footer">
                <button type="button" data-discard-close="resetModal" class="ui-btn ui-btn-secondary">
                    Cancel
                </button>

                <button type="submit" class="ui-btn ui-btn-reset-password">
                    <i class="fa-solid fa-key"></i>
                    <span>Reset Password</span>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="viewModal" aria-hidden="true">
    <div class="modal-box-inner um-user-modal um-user-modal-md um-view-details-modal" onclick="event.stopPropagation()">
        <div class="um-view-details-head">
            <div class="um-view-head-left">
                <div class="um-view-head-icon">
                    <i class="fa-solid fa-id-card-clip"></i>
                </div>

                <div>
                    <h3>Account Details</h3>
                    <p>Review selected account information</p>
                </div>
            </div>

            <button type="button" onclick="closeModal('viewModal')" data-close-modal="viewModal" class="modal-x"
                aria-label="Close account details modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="um-view-details-body">
            <div class="um-view-profile-card">
                <div class="um-view-avatar" id="viewInitial">?</div>

                <div class="um-view-profile-copy">
                    <div id="viewName" class="um-view-name"></div>
                    <div id="viewEmail" class="um-view-email"></div>
                </div>
            </div>

            <div class="um-view-info-grid">
                <div class="um-view-info-card">
                    <div class="um-view-info-icon source">
                        <i class="fa-solid fa-hashtag"></i>
                    </div>

                    <div>
                        <span class="um-view-label">User ID</span>
                        <strong id="viewId" class="um-view-value"></strong>
                    </div>
                </div>

                <div class="um-view-info-card">
                    <div class="um-view-info-icon role">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>

                    <div>
                        <span class="um-view-label">Role</span>
                        <strong id="viewRole" class="um-view-value"></strong>
                    </div>
                </div>

                <div class="um-view-info-card">
                    <div class="um-view-info-icon status">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>

                    <div>
                        <span class="um-view-label">Status</span>
                        <strong id="viewStatus" class="um-view-value um-view-status-pill"></strong>
                    </div>
                </div>

                <div class="um-view-info-card">
                    <div class="um-view-info-icon source">
                        <i class="fa-solid fa-database"></i>
                    </div>

                    <div>
                        <span class="um-view-label">Source</span>
                        <strong id="viewSource" class="um-view-value"></strong>
                    </div>
                </div>

                <div class="um-view-info-card">
                    <div class="um-view-info-icon date">
                        <i class="fa-solid fa-calendar-plus"></i>
                    </div>

                    <div>
                        <span class="um-view-label">Created At</span>
                        <strong id="viewCreatedAt" class="um-view-value"></strong>
                    </div>
                </div>

                <div class="um-view-info-card">
                    <div class="um-view-info-icon source">
                        <i class="fa-solid fa-phone"></i>
                    </div>

                    <div>
                        <span class="um-view-label">Phone</span>
                        <strong id="viewPhone" class="um-view-value"></strong>
                    </div>
                </div>

                <div class="um-view-info-card">
                    <div class="um-view-info-icon date">
                        <i class="fa-solid fa-cake-candles"></i>
                    </div>

                    <div>
                        <span class="um-view-label">Birthdate</span>
                        <strong id="viewBirthdate" class="um-view-value"></strong>
                    </div>
                </div>

                <div class="um-view-info-card">
                    <div class="um-view-info-icon status">
                        <i class="fa-solid fa-venus-mars"></i>
                    </div>

                    <div>
                        <span class="um-view-label">Gender</span>
                        <strong id="viewGender" class="um-view-value"></strong>
                    </div>
                </div>

                <div class="um-view-info-card">
                    <div class="um-view-info-icon role">
                        <i class="fa-solid fa-notes-medical"></i>
                    </div>

                    <div>
                        <span class="um-view-label">Patient Profile</span>
                        <strong id="viewPatientProfile" class="um-view-value"></strong>
                    </div>
                </div>

                <div class="um-view-info-card">
                    <div class="um-view-info-icon source">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>

                    <div>
                        <span class="um-view-label">Last Login</span>
                        <strong id="viewLastLoginAt" class="um-view-value"></strong>
                    </div>
                </div>

                <div class="um-view-info-card">
                    <div class="um-view-info-icon date">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>

                    <div>
                        <span class="um-view-label">Updated At</span>
                        <strong id="viewUpdatedAt" class="um-view-value"></strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-ft um-view-details-foot">
            <button type="button" onclick="closeModal('viewModal')" class="ui-btn ui-btn-secondary">
                Close
            </button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="toggleConfirmModal" aria-hidden="true">
    <div class="modal-box-inner um-user-modal um-user-modal-sm" onclick="event.stopPropagation()">
        <div
            class="modal-themed-header px-6 py-5 border-b flex items-center justify-between sticky top-0 rounded-t-2xl z-10">
            <div class="flex items-center gap-3">
                <div id="toggleModalIcon" class="w-10 h-10 rounded-xl modal-themed-icon">
                    <i class="fa-solid fa-question-circle text-white text-sm"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-gray-800 text-base" id="toggleModalTitle">Confirm Action</h3>
                    <p class="text-[10px] text-gray-500" id="toggleModalSubtitle">Please confirm this change</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('toggleConfirmModal')" data-close-modal="toggleConfirmModal"
                class="modal-x" aria-label="Close confirm action modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="p-6">
            <div id="toggleModalBody" class="rounded-xl p-4 mb-5 flex items-start gap-3 text-sm"></div>

            <div class="flex items-center justify-end gap-3">
                <button type="button" onclick="closeModal('toggleConfirmModal')" class="ui-btn ui-btn-secondary">
                    Cancel
                </button>
                <form id="toggleConfirmForm" method="POST">
                    @csrf
                    <button type="submit" id="toggleConfirmBtn" class="ui-btn ui-btn-primary">
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var umState = {
        search: @js($search ?? ''),
        role: @js($roleFilter ?? ''),
        status: @js($statusFilter ?? ''),
        perPage: {{ $perPage ?? 10 }},
    page: @json((int) request('page', 1)),
        };

    var umSearchTimer = null;
    var umController = null;

    window.closeAllModals = function () {
        document
            .querySelectorAll(
                '.modal-overlay.open, .ui-modal.open'
            )
            .forEach(function (modal) {
                if (modal.id) {
                    window.closeModal?.(modal.id);
                }
            });
    };

    @if ($errors -> any() && old('_method') !== 'PUT')
        document.addEventListener('DOMContentLoaded', () => openModal('addModal'));
    @endif

    function openToggleConfirm(userId, currentStatus, userName) {
        var isActive = currentStatus === 'active';
        var icon = document.getElementById('toggleModalIcon');
        var title = document.getElementById('toggleModalTitle');
        var subtitle = document.getElementById('toggleModalSubtitle');
        var body = document.getElementById('toggleModalBody');
        var btn = document.getElementById('toggleConfirmBtn');
        var form = document.getElementById('toggleConfirmForm');

        var modal = document.getElementById('toggleConfirmModal');

        modal.classList.remove('is-activate', 'is-deactivate');
        modal.classList.add(isActive ? 'is-deactivate' : 'is-activate');
        form.dataset.userId = userId;
        form.dataset.currentStatus = currentStatus;
        form.dataset.userName = userName;
        form.action = '/admin/user-management/' + userId + '/toggle-status';

        btn.disabled = false;

        if (isActive) {
            icon.className =
                'w-10 h-10 rounded-xl flex items-center justify-center shadow bg-gradient-to-br from-amber-400 to-orange-500';
            icon.innerHTML = '<i class="fa-solid fa-user-slash text-white text-sm"></i>';
            title.textContent = 'Deactivate User';
            subtitle.textContent = 'This will restrict their access';
            body.className = 'rounded-xl p-4 mb-5 flex items-start gap-3 text-sm bg-amber-50 border border-amber-100';
            body.innerHTML =
                '<i class="fa-solid fa-triangle-exclamation text-amber-500 mt-0.5 flex-shrink-0"></i><div><strong class="text-amber-800">' +
                userName +
                '</strong><span class="text-amber-700"> will be <strong>deactivated</strong>. They will no longer be able to log in until reactivated.</span></div>';
            btn.className = 'ui-btn ui-btn-warning';
            btn.innerHTML = '<i class="fa-solid fa-user-slash"></i> Deactivate';
        } else {
            icon.className =
                'w-10 h-10 rounded-xl flex items-center justify-center shadow bg-gradient-to-br from-emerald-500 to-green-600';
            icon.innerHTML = '<i class="fa-solid fa-user-check text-white text-sm"></i>';
            title.textContent = 'Activate User';
            subtitle.textContent = 'This will restore their access';
            body.className =
                'rounded-xl p-4 mb-5 flex items-start gap-3 text-sm bg-emerald-50 border border-emerald-100';
            body.innerHTML =
                '<i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 flex-shrink-0"></i><div><strong class="text-emerald-800">' +
                userName +
                '</strong><span class="text-emerald-700"> will be <strong>activated</strong>. They will regain full access to the system.</span></div>';
            btn.className = 'ui-btn ui-btn-success';
            btn.innerHTML = '<i class="fa-solid fa-user-check"></i> Activate';
        }

        btn.dataset.originalHtml = btn.innerHTML;

        openModal('toggleConfirmModal');
    }

    function syncEditRoleConfirmation() {
        const form = document.getElementById('editForm');
        const roleInput = document.getElementById('editRole');
        const originalRoleInput = document.getElementById('editOriginalRole');
        const panel = document.getElementById('editRoleConfirmPanel');
        const password = document.getElementById('editAdminCurrentPassword');

        if (!form || !roleInput || !originalRoleInput || !panel || !password) return;

        const roleChanged = String(roleInput.value || '') !== String(originalRoleInput.value || '');
        const shouldConfirm = form.dataset.source !== 'patients' && roleChanged;

        panel.classList.toggle('hidden', !shouldConfirm);
        password.required = shouldConfirm;

        if (!shouldConfirm) {
            password.value = '';
            password.setCustomValidity('');
        }
    }

    function setEditRoleDisabled(isDisabled) {
        const select = document.getElementById('editRole');

        if (!select) return;

        select.disabled = isDisabled;

        const wrapper = select.closest('.custom-select');

        if (wrapper) {
            wrapper.classList.toggle('is-disabled', isDisabled);
            window.syncCustomSelect?.(wrapper);
        }
    }

    function openEditModal(source, id, name, email, roleId, status, details = null) {
        const form = document.getElementById('editForm');
        const payload = details && typeof details === 'object' ? details : {};

        if (source === 'patients') {
            form.action = `/admin/user-management/patient/${id}`;
            setEditRoleDisabled(true);
            document.getElementById('editStatusActive').disabled = true;
            document.getElementById('editStatusInactive').disabled = true;
        } else {
            form.action = `/admin/user-management/${id}`;
            let methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                form.appendChild(methodInput);
            }
            methodInput.value = 'PUT';
            setEditRoleDisabled(false);
            document.getElementById('editStatusActive').disabled = false;
            document.getElementById('editStatusInactive').disabled = false;

            const editGender =
                document.getElementById('editGender');

            if (editGender) {
                editGender.value =
                    payload.gender_raw ||
                    payload.gender ||
                    '';

                window.syncCustomSelect?.(
                    editGender.closest('.custom-select')
                );
            }
        }

        form.dataset.source = source;

        document.getElementById('editName').value = name;
        document.getElementById('editEmail').value = email;
        document.getElementById('editModalSubtitle').textContent = 'Editing: ' + name;
        document.getElementById('editOriginalRole').value = roleId || '';
        document.getElementById('editAdminCurrentPassword').value = '';
        document.getElementById('editPhone').value = payload.phone_raw || payload.phone || '';

        const editBirthdate =
            document.getElementById('editBirthdate');

        const birthdateValue =
            payload.birthdate_raw || '';

        if (editBirthdate?._flatpickr) {
            editBirthdate._flatpickr.setDate(
                birthdateValue,
                false
            );
        } else if (editBirthdate) {
            editBirthdate.value = birthdateValue;
        }

        document.getElementById('editGender').value = payload.gender_raw || payload.gender || '';
        document.getElementById('editPhone').value = formatUserPhoneDisplay(
            getNormalizedUserPhoneValue(document.getElementById('editPhone'))
        );

        syncEditRoleConfirmation();

        document.getElementById('editStatusActive').checked = (status === 'active');
        document.getElementById('editStatusInactive').checked = (status === 'inactive');

        openModal('editModal');
    }

    function openResetModal(source, id, name) {
        if (source === 'patients') {
            document.getElementById('resetForm').action = `/admin/user-management/patient/${id}/reset-password`;
        } else {
            document.getElementById('resetForm').action = `/admin/user-management/${id}/reset-password`;
        }

        document.getElementById('resetModalSubtitle').textContent = 'Resetting password for: ' + name;
        document.getElementById('resetPassword').value = '';
        document.getElementById('resetPasswordConf').value = '';
        updateResetPasswordFeedback();
        openModal('resetModal');
    }

    function buildGeneratedPassword(length = 12) {
        const lower = 'abcdefghijkmnopqrstuvwxyz';
        const upper = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        const numbers = '23456789';
        const symbols = '@#$%*!?';
        const all = lower + upper + numbers + symbols;

        const pick = (chars) => chars.charAt(Math.floor(Math.random() * chars.length));
        const chars = [
            pick(lower),
            pick(upper),
            pick(numbers),
            pick(symbols),
        ];

        while (chars.length < length) {
            chars.push(pick(all));
        }

        for (let i = chars.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [chars[i], chars[j]] = [chars[j], chars[i]];
        }

        return chars.join('');
    }

    function refreshGeneratedPassword() {
        const password = buildGeneratedPassword();
        const passwordInput = document.getElementById('addPassword');
        const confirmInput = document.getElementById('addPasswordConf');

        if (passwordInput) passwordInput.value = password;
        if (confirmInput) confirmInput.value = password;
    }

    async function copyFieldValue(inputId) {
        const input = document.getElementById(inputId);
        if (!input || !input.value) return;

        try {
            await navigator.clipboard.writeText(input.value);
            showSuccessToast('Password copied to clipboard.');
        } catch (error) {
            input.removeAttribute('readonly');
            input.select();
            document.execCommand('copy');
            input.setAttribute('readonly', 'readonly');
            showSuccessToast('Password copied to clipboard.');
        }
    }

    function copyGeneratedPassword() {
        copyFieldValue('generatedUserPasswordValue');
    }

    let userPhoneFeedbackTimer = null;

    function formatUserPhoneDisplay(rawDigits) {
        const digits = String(rawDigits || '').slice(0, 11);
        let out = '';

        if (digits.length > 0) out += digits.slice(0, 4);
        if (digits.length > 4) out += ' ' + digits.slice(4, 7);
        if (digits.length > 7) out += ' ' + digits.slice(7, 11);

        return out;
    }

    function getNormalizedUserPhoneValue(input) {
        return String(input?.value || '').replace(/\D/g, '');
    }

    function bindUserPhoneValidation(inputId) {
        const input = document.getElementById(inputId);

        if (
            !input ||
            input.dataset.phoneFormattingReady === 'true'
        ) {
            return;
        }

        input.dataset.phoneFormattingReady = 'true';

        const syncPhone = () => {
            let digits =
                getNormalizedUserPhoneValue(input);

            if (digits.startsWith('9')) {
                digits = `0${digits}`;
            }

            input.value =
                formatUserPhoneDisplay(
                    digits.slice(0, 11)
                );

            window.validateFormInputField?.(input);
        };

        input.addEventListener('input', syncPhone);
        input.addEventListener('blur', syncPhone);
    }

    function parseUserDetailsFromButton(button) {
        if (!button) return {};

        const raw = button.getAttribute('data-user-details');

        if (!raw) return {};

        try {
            return JSON.parse(raw);
        } catch (error) {
            console.warn('Unable to parse user details payload.', error);
            return {};
        }
    }

    function openEditModalFromButton(button, source, id, name, email, roleId, status) {
        openEditModal(source, id, name, email, roleId, status, parseUserDetailsFromButton(button));
    }

    function openViewModalFromButton(button) {
        openViewModal(parseUserDetailsFromButton(button));
    }

    function openViewModal(payloadOrName, email, role, status, source, createdAt, details) {
        const payload = typeof payloadOrName === 'object' && payloadOrName !== null ?
            payloadOrName :
            {
                name: payloadOrName,
                email,
                role,
                status,
                source,
                created_at: createdAt,
                ...(details || {}),
            };

        const viewName = document.getElementById('viewName');
        const viewEmail = document.getElementById('viewEmail');
        const viewId = document.getElementById('viewId');
        const viewRole = document.getElementById('viewRole');
        const viewStatus = document.getElementById('viewStatus');
        const viewSource = document.getElementById('viewSource');
        const viewCreatedAt = document.getElementById('viewCreatedAt');
        const viewUpdatedAt = document.getElementById('viewUpdatedAt');
        const viewPhone = document.getElementById('viewPhone');
        const viewBirthdate = document.getElementById('viewBirthdate');
        const viewGender = document.getElementById('viewGender');
        const viewPatientProfile = document.getElementById('viewPatientProfile');
        const viewLastLoginAt = document.getElementById('viewLastLoginAt');
        const viewInitial = document.getElementById('viewInitial');

        if (viewName) viewName.textContent = payload.name || 'Unknown User';
        if (viewEmail) viewEmail.textContent = payload.email || 'No email available';
        if (viewId) viewId.textContent = payload.id || 'N/A';
        if (viewRole) viewRole.textContent = payload.role || 'No Role';
        if (viewSource) viewSource.textContent = payload.source || 'Users';
        if (viewCreatedAt) viewCreatedAt.textContent = payload.created_at || 'N/A';
        if (viewUpdatedAt) viewUpdatedAt.textContent = payload.updated_at || 'N/A';
        if (viewPhone) viewPhone.textContent = payload.phone || 'N/A';
        if (viewBirthdate) viewBirthdate.textContent = payload.birthdate || 'N/A';
        if (viewGender) viewGender.textContent = payload.gender || 'N/A';
        if (viewPatientProfile) viewPatientProfile.textContent = payload.patient_profile || 'Not linked';
        if (viewLastLoginAt) viewLastLoginAt.textContent = payload.last_login_at || 'Never';

        if (viewInitial) {
            viewInitial.textContent = String(payload.name || '?').trim().charAt(0).toUpperCase() || '?';
        }

        if (viewStatus) {
            const normalizedStatus = String(payload.status || '').toLowerCase();

            viewStatus.textContent = payload.status || 'Unknown';
            viewStatus.classList.remove('is-active', 'is-inactive');

            if (normalizedStatus === 'active') {
                viewStatus.classList.add('is-active');
            } else {
                viewStatus.classList.add('is-inactive');
            }
        }

        openModal('viewModal');
    }

    function getPasswordStrength(password) {
        const value = String(password || '');

        if (!value.length) {
            return {
                state: 'empty',
                width: '0%',
                label: 'Enter a password',
                hint: 'Use 8+ chars, number, uppercase, and symbol.',
            };
        }

        let score = 0;

        if (value.length >= 8) score++;
        if (/[a-z]/.test(value) && /[A-Z]/.test(value)) score++;
        if (/\d/.test(value)) score++;
        if (/[^A-Za-z0-9]/.test(value)) score++;

        if (score <= 1) {
            return {
                state: 'weak',
                width: '35%',
                label: 'Weak password',
                hint: 'Add more characters and numbers.',
            };
        }

        if (score <= 3) {
            return {
                state: 'medium',
                width: '68%',
                label: 'Medium password',
                hint: 'Add uppercase or symbol to improve.',
            };
        }

        return {
            state: 'strong',
            width: '100%',
            label: 'Strong password',
            hint: 'Good password strength.',
        };
    }

    function updateResetPasswordStrength() {
        const input = document.getElementById('resetPassword');
        const meter = document.getElementById('resetPasswordStrength');
        const label = document.getElementById('resetPasswordStrengthLabel');
        const hint = document.getElementById('resetPasswordStrengthHint');

        if (!input || !meter || !label || !hint) return;

        const result = getPasswordStrength(input.value);

        meter.dataset.strength = result.state;
        meter.style.setProperty('--strength-width', result.width);
        label.textContent = result.label;
        hint.textContent = result.hint;
    }

    function updateResetPasswordMatch() {
        const password = document.getElementById('resetPassword');
        const confirm = document.getElementById('resetPasswordConf');
        const match = document.getElementById('resetPasswordMatch');
        const text = document.getElementById('resetPasswordMatchText');

        if (!password || !confirm || !match || !text) return;

        const passwordValue = password.value.trim();
        const confirmValue = confirm.value.trim();

        confirm.classList.remove('is-password-match', 'is-password-mismatch');

        if (!confirmValue.length) {
            match.dataset.match = 'empty';
            text.textContent = 'Confirm your password.';
            return;
        }

        if (passwordValue === confirmValue) {
            match.dataset.match = 'matched';
            text.textContent = 'Passwords match.';
            confirm.classList.add('is-password-match');
            return;
        }

        match.dataset.match = 'mismatch';
        text.textContent = 'Passwords do not match.';
        confirm.classList.add('is-password-mismatch');
    }

    function updateResetPasswordFeedback() {
        updateResetPasswordStrength();
        updateResetPasswordMatch();
    }

    document.addEventListener('input', function (event) {
        if (!event.target) return;

        if (event.target.id === 'resetPassword' || event.target.id === 'resetPasswordConf') {
            updateResetPasswordFeedback();
        }
    });

    function togglePassVis(inputId, iconId) {
        const inp = document.getElementById(inputId);
        const ico = document.getElementById(iconId);

        if (!inp || !ico) return;

        if (inp.type === 'password') {
            inp.type = 'text';
            ico.className = ico.className.replace('fa-eye', 'fa-eye-slash');
        } else {
            inp.type = 'password';
            ico.className = ico.className.replace('fa-eye-slash', 'fa-eye');
        }
    }

    window.openToggleConfirm = openToggleConfirm;
    window.openEditModal = openEditModal;
    window.openEditModalFromButton = openEditModalFromButton;
    window.openResetModal = openResetModal;
    window.openViewModal = openViewModal;
    window.openViewModalFromButton = openViewModalFromButton;
    window.togglePassVis = togglePassVis;
    window.refreshGeneratedPassword = refreshGeneratedPassword;
    window.copyGeneratedPassword = copyGeneratedPassword;
    window.copyFieldValue = copyFieldValue;

    document.addEventListener('DOMContentLoaded', () => {
        if (typeof applyTheme === 'function') applyTheme(localStorage.getItem('theme') || 'light');

        refreshGeneratedPassword();
        bindUserPhoneValidation('addPhoneInput');
        bindUserPhoneValidation('editPhone');

        document.querySelectorAll('.flash-alert').forEach(el => {
            setTimeout(() => {
                el.style.transition = 'opacity .4s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 400);
            }, 4000);
        });
    });

    function umFetch(silent) {
        if (umController) umController.abort();
        umController = new AbortController();

        var params = new URLSearchParams({
            search: umState.search,
            role: umState.role,
            status: umState.status,
            per_page: umState.perPage,
            page: umState.page,
        });

        history.replaceState(null, '', window.location.pathname + '?' + params.toString());

        fetch('{{ route('admin.user_management') }}?' + params.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            signal: umController.signal
        })
            .then(function (res) {
                return res.json();
            })
            .then(function (data) {
                umRenderRows(data.users);
                umRenderPagebar(data.pagination);
                if (data.counts) {
                    umRenderCounts(data.counts);
                }
            })
            .catch(function (e) {
                if (e.name !== 'AbortError') console.error(e);
            });
    }


    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function normalizeUmRole(user) {
        const rawName = String(
            user.role_name ??
            user.role?.display_name ??
            user.role?.name ??
            ''
        ).trim();

        const rawSlug = String(
            user.role_slug ??
            user.role?.slug ??
            ''
        ).trim().toLowerCase();

        const invalidValues = [
            '',
            '-',
            '—',
            'null',
            'undefined',
            'none',
            'no-role'
        ];

        const hasNoRole =
            invalidValues.includes(rawName.toLowerCase()) ||
            !user.role_id;

        return {
            label: hasNoRole ? 'No Role' : rawName,
            slug: hasNoRole ? 'none' : rawSlug || 'none'
        };
    }

    function umRenderRows(users) {
        function jsAttr(value) {
            return JSON.stringify(value ?? '').replace(/"/g, '&quot;');
        }

        var tbody = document.getElementById('umTableBody');
        var gridBody = document.getElementById('umGridBody');

        if (!tbody || !gridBody) return;

        if (!users || users.length === 0) {
            var searchVal = umState.search || '';
            var hasSearch = searchVal.trim() !== '';
            var escapedSearch = escapeHtml(searchVal);
            var emptyTitle = hasSearch ?
                'No results for “' + escapedSearch + '”' :
                'No users found';
            var emptySub = hasSearch ?
                'Try a different name or email.' :
                'Try adjusting your filters.';
            var clearBtn = hasSearch ?
                '<button type="button" class="empty-state-btn" data-clear-search data-search-target="#umSearch"><i class="fa-solid fa-xmark"></i> Clear search</button>' :
                '';

            var emptyInner = `
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fa-solid ${hasSearch ? 'fa-magnifying-glass' : 'fa-users'}"></i>
                    </div>
                    <h3 class="empty-state-title">${emptyTitle}</h3>
                    <p class="empty-state-sub">${emptySub}</p>
                    ${clearBtn}
                </div>
            `;

            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="p-0">
                        ${emptyInner}
                    </td>
                </tr>
            `;

            gridBody.innerHTML = emptyInner;
            window.initSearchClearButtons?.();
            window.initGlobalVoiceInputs?.(document.getElementById('addModal') || document);
            return;
        }

        var startNumber = ((umState.page - 1) * umState.perPage) + 1;
        var tableHtml = '';
        var gridHtml = '';

        users.forEach(function (user, index) {
            var rowNumber = startNumber + index;
            var normalizedRole =
                normalizeUmRole(user);

            var roleSlug =
                normalizedRole.slug;

            var roleLabel =
                normalizedRole.label;
            var registeredDay = user.created_at_day || '—';

            var statusClass = user.status === 'active' ? 'badge-active' : 'badge-inactive';
            var initial = (user.name || 'U').charAt(0).toUpperCase();
            var statusLabel = (user.status || '').charAt(0).toUpperCase() + (user.status || '').slice(1);
            var createdFull = (user.created_at_day || '—') + (user.created_at_time ? ' ' + user
                .created_at_time : '');

            tableHtml += `
                <tr class="user-table-row border-b border-gray-50 last:border-0">
                    <td class="py-3.5 px-3 sm:px-5 hidden sm:table-cell">
                        <span class="text-xs text-gray-400 font-medium">${rowNumber}</span>
                    </td>

                    <td class="py-3.5 px-2 sm:px-4">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div
                                class="w-9 h-9 rounded-full bg-gradient-to-br from-[#8B0000] to-[#b00000] flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
                                ${initial}
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800 text-sm leading-tight">
                                    ${user.name}
                                </div>
                                <div class="text-[11px] text-gray-400 mt-0.5 hidden sm:block">
                                    ${user.email}
                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="py-3.5 px-4">
                        <span class="badge-role role-${roleSlug || 'none'}">
    ${roleLabel}
</span>
                    </td>

                    <td class="py-3.5 px-4 text-center">
                        <span class="text-[11px] font-bold px-2.5 py-1 rounded-full ${statusClass}">
                            ${statusLabel}
                        </span>
                    </td>

                    <td class="py-3.5 px-4 hidden lg:table-cell">
                        <span class="text-xs text-gray-600">${registeredDay}</span>
                    </td>

                    <td class="py-3.5 px-4">
                        <div class="ui-action-group um-action-group">
                            <button type="button"
                                data-user-details="${escapeHtml(JSON.stringify(user.details || {
                phone_raw: '',
                birthdate_raw: '',
                gender_raw: ''
            }))}"
                                onclick="openEditModalFromButton(this, 'users', ${user.id}, ${jsAttr(user.name)}, ${jsAttr(user.email)}, ${jsAttr(user.role_id)}, ${jsAttr(user.status)})"
                                class="ui-action-btn ui-action-edit"
data-tooltip="Edit account" data-tooltip-tone="edit"
aria-label="Edit account">
                                <i class="fa-solid fa-pen text-[11px]"></i>
                            </button>

                            <button type="button"
    onclick="openToggleConfirm(${user.id}, ${jsAttr(user.status)}, ${jsAttr(user.name)})"
    class="ui-action-btn ${user.status === 'active'
                    ? 'ui-action-warning'
                    : 'ui-action-success'}"
    data-tooltip="${user.status === 'active'
                    ? 'Deactivate account'
                    : 'Activate account'}"
    aria-label="${user.status === 'active'
                    ? 'Deactivate account'
                    : 'Activate account'}">
    <i class="fa-solid ${user.status === 'active'
                    ? 'fa-toggle-on'
                    : 'fa-toggle-off'}"></i>
</button>

                            <button type="button"
                                onclick="openResetModal('users', ${user.id}, ${jsAttr(user.name)})"
                                class="ui-action-btn ui-action-reset"
                                data-tooltip="Reset password"
                                aria-label="Reset password">
                                <i class="fa-solid fa-key text-[11px]"></i>
                            </button>

                            <button type="button"
    data-user-details="${escapeHtml(JSON.stringify(user.details || {
                        id: user.id,
                        name: user.name,
                        email: user.email,
                        role: roleLabel,
                        status: statusLabel,
                        source: 'Users',
                        created_at: createdFull
                    }))}"
    onclick="openViewModalFromButton(this)"
    class="ui-action-btn ui-action-view"
    data-tooltip="View details"
    aria-label="View details">
    <i class="fa-solid fa-eye"></i>
</button>
                        </div>
                    </td>
                </tr>
            `;

            gridHtml += `
                <div class="um-grid-card">
                    <div class="um-grid-top">
                        <div class="um-grid-number">#${rowNumber}</div>
                        <span class="text-[11px] font-bold px-2.5 py-1 rounded-full ${statusClass}">
                            ${statusLabel}
                        </span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#8B0000] to-[#b00000] flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
                            ${initial}
                        </div>
                        <div class="min-w-0">
                            <div class="font-semibold text-gray-800 text-sm leading-tight">${user.name}</div>
                            <div class="text-[11px] text-gray-400 mt-0.5">${user.email}</div>
                        </div>
                    </div>

                    <div class="um-grid-meta">
    <div class="um-grid-field">
        <div class="um-grid-label">
            Role
        </div>

        <div class="um-grid-value">
            <span class="badge-role role-${roleSlug || 'none'}">
                ${roleLabel}
            </span>
        </div>
    </div>

    <div class="um-grid-field">
        <div class="um-grid-label">
            Registered
        </div>

        <div class="um-registered-date">
            <span class="um-registered-icon">
                <i class="fa-solid fa-calendar-day"></i>
            </span>

            <span class="um-registered-text">
                ${registeredDay}
            </span>
        </div>
    </div>
</div>

                    <div class="ui-action-group">
                        <button type="button"
                            data-user-details="${escapeHtml(JSON.stringify(user.details || {
                phone_raw: '',
                birthdate_raw: '',
                gender_raw: ''
            }))}"
                            onclick="openEditModalFromButton(this, 'users', ${user.id}, ${jsAttr(user.name)}, ${jsAttr(user.email)}, ${jsAttr(user.role_id)}, ${jsAttr(user.status)})"
                            class="ui-action-btn ui-action-edit"
data-tooltip="Edit account" data-tooltip-tone="edit"
aria-label="Edit account">
                            <i class="fa-solid fa-pen text-[11px]"></i>
                        </button>

                        <button type="button"
                            onclick="openToggleConfirm(${user.id}, ${jsAttr(user.status)}, ${jsAttr(user.name)})"
                            class="action-btn ${user.status === 'active' ? 'btn-toggle-on' : 'btn-toggle-off'}"
                            title="${user.status === 'active' ? 'Deactivate' : 'Activate'}">
                            <i class="fa-solid ${user.status === 'active' ? 'fa-toggle-on' : 'fa-toggle-off'} text-[11px]"></i>
                        </button>

                        <button type="button"
                            onclick="openResetModal('users', ${user.id}, ${jsAttr(user.name)})"
                            class="ui-action-btn ui-action-reset"
data-tooltip="Reset password"
aria-label="Reset password">
                            <i class="fa-solid fa-key text-[11px]"></i>
                        </button>

                        <button type="button"
                            data-user-details="${escapeHtml(JSON.stringify(user.details || {
                id: user.id,
                name: user.name,
                email: user.email,
                role: roleLabel,
                status: statusLabel,
                source: 'Users',
                created_at: createdFull
            }))}"
                            onclick="openViewModalFromButton(this)"
                            class="ui-action-btn ui-action-view"
data-tooltip="View details"
aria-label="View details">
                            <i class="fa-solid fa-eye text-[11px]"></i>
                        </button>
                    </div>
                </div>
            `;
        });

        tbody.innerHTML = tableHtml;
        gridBody.innerHTML = gridHtml;
    }

    function umGoPage(page) {
        umState.page = page;
        umFetch();
    }

    function umRenderPagebar(p) {
        if (!p) return;

        document.querySelectorAll(
            '.user-management-page .global-pagebar-info'
        ).forEach(function (el) {
            el.innerHTML = 'Showing <strong>' + p.from + '–' + p.to + '</strong> of <strong>' + p.total +
                '</strong> users';
        });

        var html = umBuildPagination(p);
        document.querySelectorAll(
            '.user-management-page .global-pagination-wrap'
        ).forEach(function (el) {
            el.innerHTML = html;
        });

        var umPerPageSelect = document.getElementById('umPerPageSelect');
        if (umPerPageSelect && p.per_page) {
            umPerPageSelect.value = String(p.per_page);
            window.syncGlobalPageSizeSelect?.(umPerPageSelect, p.per_page);
        }
    }

    function umRenderCounts(counts) {
        if (!counts) return;

        var totalEl = document.getElementById('countTotalUsers');
        var activeEl = document.getElementById('countActiveUsers');
        var inactiveEl = document.getElementById('countInactiveUsers');
        var badgeEl = document.getElementById('countBadgeUsers');

        if (totalEl) totalEl.textContent = counts.all ?? 0;
        if (activeEl) activeEl.textContent = counts.active ?? 0;
        if (inactiveEl) inactiveEl.textContent = counts.inactive ?? 0;
        if (badgeEl) badgeEl.textContent = counts.all ?? 0;
    }

    function umBuildPagination(p) {
        if (!p) {
            return '';
        }

        const current = Number(p.current_page || 1);
        const last = Math.max(
            1,
            Number(p.last_page || 1)
        );
        const windowSize = 5;
        const half = Math.floor(windowSize / 2);

        let start = Math.max(1, current - half);
        let end = Math.min(last, start + windowSize - 1);

        if (end - start + 1 < windowSize) {
            start = Math.max(1, end - windowSize + 1);
        }

        let html = `
        <nav class="global-pagination" aria-label="User pagination">
    `;

        html += current <= 1 ?
            `
            <button
                type="button"
                class="global-page-disabled"
                aria-label="Previous page"
                disabled>
                <i class="fa-solid fa-chevron-left global-page-icon"></i>
            </button>
        ` :
            `
            <button
                type="button"
                class="global-page-btn"
                onclick="umGoPage(${current - 1})"
                aria-label="Previous page">
                <i class="fa-solid fa-chevron-left global-page-icon"></i>
            </button>
        `;

        if (start > 1) {
            html += `
            <button
                type="button"
                class="global-page-btn"
                onclick="umGoPage(1)">
                1
            </button>
        `;

            if (start > 2) {
                html += `
                <span
                    class="global-page-ellipsis"
                    aria-hidden="true">
                    &hellip;
                </span>
            `;
            }
        }

        for (let page = start; page <= end; page++) {
            html += page === current ?
                `
                <span
                    class="global-page-current"
                    aria-current="page">
                    ${page}
                </span>
            ` :
                `
                <button
                    type="button"
                    class="global-page-btn"
                    onclick="umGoPage(${page})">
                    ${page}
                </button>
            `;
        }

        if (end < last) {
            if (end < last - 1) {
                html += `
                <span
                    class="global-page-ellipsis"
                    aria-hidden="true">
                    &hellip;
                </span>
            `;
            }

            html += `
            <button
                type="button"
                class="global-page-btn"
                onclick="umGoPage(${last})">
                ${last}
            </button>
        `;
        }

        html += current >= last ?
            `
            <button
                type="button"
                class="global-page-disabled"
                aria-label="Next page"
                disabled>
                <i class="fa-solid fa-chevron-right global-page-icon"></i>
            </button>
        ` :
            `
            <button
                type="button"
                class="global-page-btn"
                onclick="umGoPage(${current + 1})"
                aria-label="Next page">
                <i class="fa-solid fa-chevron-right global-page-icon"></i>
            </button>
        `;

        html += '</nav>';

        return html;
    }

    const UM_TOAST_CACHE = new Map();

    function showUserManagementToast(type, message) {
        const normalizedMessage = String(message || '').trim();

        if (!normalizedMessage) return;

        const normalizedType = type === 'error' ? 'error' : 'success';
        const cacheKey = `${normalizedType}:${normalizedMessage}`;
        const now = Date.now();

        if (UM_TOAST_CACHE.has(cacheKey) && now - UM_TOAST_CACHE.get(cacheKey) < 1200) {
            return;
        }

        UM_TOAST_CACHE.set(cacheKey, now);

        if (typeof window.showToast === 'function') {
            window.showToast({
                type: normalizedType,
                title: normalizedType === 'error' ? 'Error' : 'Success',
                message: normalizedMessage,
                duration: normalizedType === 'error' ? 7000 : 6000,
            });

            return;
        }

        alert(normalizedMessage);
    }

    function showSuccessToast(message) {
        showUserManagementToast('success', message);
    }

    function showErrorToast(message) {
        showUserManagementToast('error', message);
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (typeof applyTheme === 'function') applyTheme(localStorage.getItem('theme') || 'light');

        umRenderPagebar({
            total: {{ $users-> total() }},
        from: {{ $users-> firstItem() ?? 0 }},
        to: {{ $users-> lastItem() ?? 0 }},
        current_page: {{ $users-> currentPage() }},
        last_page: {{ $users-> lastPage() }},
        per_page: {{ $users-> perPage() }},
            });

    var searchInput = document.getElementById('umSearch');

    window.initSearchClearButtons?.();
    window.initGlobalPageSizeSelects?.();

    var umPerPageSelect = document.getElementById('umPerPageSelect');
    if (umPerPageSelect) {
        umPerPageSelect.value = String(umState.perPage || 10);
        window.syncGlobalPageSizeSelect?.(umPerPageSelect, umState.perPage || 10);

        umPerPageSelect.addEventListener('change', function () {
            umState.perPage = Number(this.value) || 10;
            umState.page = 1;
            umFetch();
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(umSearchTimer);
            var val = this.value;
            umSearchTimer = setTimeout(function () {
                umState.search = val;
                umState.page = 1;
                umFetch(true);
            }, 350);
        });
    }

    if (statusFilter) {
        statusFilter.addEventListener('change', function () {
            umState.status = this.value;
            umState.page = 1;
            umFetch();
        });
    }

    var toggleForm = document.getElementById('toggleConfirmForm');
    if (toggleForm) {
        toggleForm.addEventListener('submit', function (e) {
            e.preventDefault();

            var form = this;
            var url = form.action;
            var btn = document.getElementById('toggleConfirmBtn');
            var originalHtml = btn.dataset.originalHtml || btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing…';

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: '_token={{ csrf_token() }}'
            })
                .then(function (res) {
                    return res.json().then(function (data) {
                        return {
                            ok: res.ok,
                            data: data
                        };
                    });
                })
                .then(function (result) {
                    if (result.ok && result.data.success) {
                        closeAllModals();
                        showSuccessToast(result.data.message);
                        umFetch(true);
                    } else {
                        showErrorToast(result.data.message || 'Something went wrong.');
                    }
                })
                .catch(function () {
                    showErrorToast('Something went wrong. Please try again.');
                })
                .finally(function () {
                    btn.disabled = false;
                    btn.innerHTML = originalHtml;
                });
        });
    }

    var editForm = document.getElementById('editForm');

    if (editForm) {
        editForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const validation = window.validateGlobalForm?.(this);

            if (validation && !validation.valid) {
                return;
            }

            var form = this;
            var url = form.action;
            var submitBtn = form.querySelector('button[type="submit"]');
            var originalHtml = submitBtn.innerHTML;
            var editPhoneInput = document.getElementById('editPhone');

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving…';

            var params = new URLSearchParams();
            params.append('_token', '{{ csrf_token() }}');
            params.append('_method', 'PUT');
            params.append('name', document.getElementById('editName').value);
            params.append('email', document.getElementById('editEmail').value);
            params.append('phone', getNormalizedUserPhoneValue(editPhoneInput));
            params.append('birthdate', document.getElementById('editBirthdate').value);
            params.append('gender', document.getElementById('editGender').value);
            params.append('role_id', document.getElementById('editRole').value);
            params.append('status', form.querySelector('input[name="status"]:checked')?.value ??
                '');

            if (String(document.getElementById('editRole').value || '') !== String(document
                .getElementById(
                    'editOriginalRole').value || '')) {
                params.append('admin_current_password', document.getElementById(
                    'editAdminCurrentPassword')
                    .value);
            }

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: params.toString()
            })
                .then(function (res) {
                    return res.json().then(function (data) {
                        return {
                            ok: res.ok,
                            status: res.status,
                            data: data
                        };
                    });
                })
                .then(function (result) {
                    if (
                        result.status === 422 &&
                        result.data?.errors
                    ) {
                        Object.entries(
                            result.data.errors
                        ).forEach(([name, messages]) => {
                            const field =
                                form.querySelector(
                                    `[name="${CSS.escape(name)}"]`
                                );

                            const message =
                                Array.isArray(messages) ?
                                    messages[0] :
                                    messages;

                            if (field) {
                                window
                                    .showFormInputValidationMessage
                                    ?.(field, message);
                            }
                        });

                        showErrorToast(
                            result.data.message ||
                            'Please review the highlighted fields.'
                        );

                        return;
                    }

                    if (
                        result.ok &&
                        result.data?.success
                    ) {
                        closeAllModals();

                        showSuccessToast(
                            result.data.message ||
                            'User updated successfully.'
                        );

                        umFetch(true);
                        return;
                    }

                    showErrorToast(
                        result.data?.message ||
                        'Something went wrong.'
                    );
                })
                .catch(function () {
                    showErrorToast('Something went wrong. Please try again.');
                })
                .finally(function () {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHtml;
                });
        });
    }

    var addUserForm = document.getElementById('addUserForm');
    if (addUserForm) {
        addUserForm.addEventListener('submit', function (e) {
            var addPhoneInput = document.getElementById('addPhoneInput');
            var addPhoneFeedback = document.getElementById('addPhoneInputFeedback');

            if (addPhoneInput) {
                addPhoneInput.value = getNormalizedUserPhoneValue(addPhoneInput);
            }
        });
    }

    var resetForm = document.getElementById('resetForm');
    if (resetForm) {
        resetForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const validation = window.validateGlobalForm?.(this);

            if (validation && !validation.valid) {
                return;
            }

            var form = this;
            var url = form.action;
            var submitBtn = form.querySelector('button[type="submit"]');
            var originalHtml = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Resetting…';

            var formData = new FormData(form);

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData
            })
                .then(function (res) {
                    return res.json().then(function (data) {
                        return {
                            ok: res.ok,
                            status: res.status,
                            data: data
                        };
                    });
                })
                .then(function (result) {
                    if (result.status === 422 && result.data.errors) {
                        var msgs = Object.values(result.data.errors).flat().join(' ');
                        showErrorToast(msgs);
                    } else if (result.ok && result.data.success) {
                        closeAllModals();
                        showSuccessToast(result.data.message || 'Password reset successfully.');
                        document.getElementById('resetPassword').value = '';
                        document.getElementById('resetPasswordConf').value = '';
                    } else {
                        showErrorToast(result.data.message || 'Something went wrong.');
                    }
                })
                .catch(function () {
                    showErrorToast('Something went wrong. Please try again.');
                })
                .finally(function () {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHtml;
                });
        });
    }
        });
</script>
@endsection