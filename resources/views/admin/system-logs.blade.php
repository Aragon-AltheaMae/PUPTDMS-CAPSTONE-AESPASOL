@extends('layouts.app')

@section('layout-role', 'admin')

@section('title', 'System Logs')

@section('content')

@php
$logs = $logs ?? collect([]);
$perPage = $perPage ?? 10;
$status = $status ?? 'active';
@endphp

<main id="mainContent" class="admin-page-shell system-logs-page page-enter mode-list">
    <div class="w-full">

        <div class="page-banner rounded-2xl mb-6">
            <div class="page-banner-inner">
                <div>
                    <h1 class="page-title">System Logs</h1>
                </div>

                <div class="flex items-center gap-3 flex-shrink-0">
                    <span class="sl-live">
                        <span class="sl-live-dot"></span> Live Monitoring
                    </span>
                </div>
            </div>
        </div>

        <div id="statCards" class="stat-grid">
            <div class="stat-card s-crimson">
                <div class="stat-icon-wrapper">
                    <i class="fa-solid fa-clipboard-list"></i>
                </div>

                <div class="stat-card-info">
                    <span class="stat-label">
                        Total Logs
                    </span>

                    <span class="stat-num" id="statTotal">
                        {{ $totalCount }}
                    </span>

                    <span class="stat-footer">
                        All recorded activity
                    </span>
                </div>
            </div>

            <div class="stat-card s-red">
                <div class="stat-icon-wrapper">
                    <i class="fa-solid fa-user-tie"></i>
                </div>

                <div class="stat-card-info">
                    <span class="stat-label">
                        Admin Actions
                    </span>

                    <span class="stat-num" id="statAdmin">
                        {{ $adminCount }}
                    </span>

                    <span class="stat-footer">
                        Administrator activity
                    </span>
                </div>
            </div>

            <div class="stat-card s-blue">
                <div class="stat-icon-wrapper">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>

                <div class="stat-card-info">
                    <span class="stat-label">
                        Dentist Actions
                    </span>

                    <span class="stat-num" id="statDentist">
                        {{ $dentistCount }}
                    </span>

                    <span class="stat-footer">
                        Dentist activity
                    </span>
                </div>
            </div>

            <div class="stat-card s-green">
                <div class="stat-icon-wrapper">
                    <i class="fa-solid fa-user"></i>
                </div>

                <div class="stat-card-info">
                    <span class="stat-label">
                        Patient Actions
                    </span>

                    <span class="stat-num" id="statPatient">
                        {{ $patientCount }}
                    </span>

                    <span class="stat-footer">
                        Patient activity
                    </span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-header-icon"><i class="fa-solid fa-clipboard-list"></i></div>
                    <span class="card-title">Audit Trail</span>
                    <span id="entryBadge" class="entry-badge">
                        {{ $totalCount }} {{ Str::plural('entry', $totalCount) }}
                    </span>
                </div>

                <div class="card-header-right sl-toolbar-actions">
                    <div class="voice-search-row sl-search-row">
                        <x-search-bar id="slSearch" name="search" placeholder="Search logs…" :value="$search ?? ''"
                            callback="handleSystemLogsSearch" :debounce="400" class="sl-search-wrap" />

                        <div class="voice-input-toggle">
                            <span class="voice-status hidden" data-voice-status></span>
                            <button type="button" class="voice-search-mic external" data-global-voice-trigger
                                data-voice-target="#slSearch" aria-label="Use voice search" title="Voice search">
                                <i class="fa-solid fa-microphone"></i>
                            </button>
                        </div>
                    </div>

                    <div class="sl-filter-actions-wrap">
                        <button type="button" id="slFilterBtn" class="global-filter-btn sl-filter-btn"
                            onclick="openSlFilterPanel()" aria-pressed="false">
                            <i class="fa-solid fa-sliders"></i>
                            <span>Filter</span>
                            <span id="slFilterBadge" class="filter-badge hidden"></span>
                        </button>

                        <button type="button" id="slArchiveBtn" class="ui-btn ui-btn-secondary ui-btn-sm"
                            title="Archive old active logs" onclick="openSlArchiveModal()">

                            <i class="fa-solid fa-box-archive"></i>
                            <span>Archive Old Logs</span>
                        </button>

                        <button type="button" id="slExportBtn" class="ui-btn ui-btn-primary ui-btn-sm"
                            title="Export current logs view to PDF" onclick="exportSystemLogsPdf()">

                            <i class="fa-solid fa-file-pdf"></i>
                            <span>Export PDF</span>
                        </button>
                    </div>

                    <x-view-toggle id="slViewToggle" class="sl-view-toggle" storage-key="systemLogsView"
                        list-view="#slListView" grid-view="#slGridView" />

                    <button type="button" id="slClearFilterBtn" class="global-filter-reset-btn hidden"
                        onclick="clearOnlySlFilters()" title="Reset filters" aria-label="Reset filters">

                        <i class="fa-solid fa-rotate-left"></i>
                    </button>
                </div>
            </div>

            @php $activeRole = $role ?? 'all'; @endphp
            <div class="sl-status-tabs">
                <div class="sl-status-tabs">
                    @foreach ([['key' => 'active', 'label' => 'Active', 'count' => $activeCount ?? 0, 'icon' =>
                    'fa-wave-square'], ['key' => 'archived', 'label' => 'Archived', 'count' => $archivedCount ?? 0,
                    'icon' => 'fa-box-archive'], ['key' => 'all', 'label' => 'All Logs', 'count' => ($activeCount ?? 0)
                    + ($archivedCount ?? 0), 'icon' => 'fa-layer-group']] as $statusTab)
                    <button type="button" class="sl-status-tab {{ $status === $statusTab['key'] ? 'active' : '' }}"
                        onclick="slSetStatus(this, '{{ $statusTab['key'] }}')">
                        <i class="fa-solid {{ $statusTab['icon'] }}"></i>
                        <span>{{ $statusTab['label'] }}</span>
                        <span class="sl-status-count">{{ $statusTab['count'] }}</span>
                    </button>
                    @endforeach
                </div>

                <div class="sl-role-tabs">
                    @foreach ([['key' => 'all', 'label' => 'All', 'icon' => 'fa-layer-group', 'count' => $totalCount],
                    ['key' => 'admin', 'label' => 'Admin', 'icon' => 'fa-user-tie', 'count' => $adminCount], ['key' =>
                    'dentist', 'label' => 'Dentist', 'icon' => 'fa-user-doctor', 'count' => $dentistCount], ['key' =>
                    'patient', 'label' => 'Patient', 'icon' => 'fa-user', 'count' => $patientCount], ['key' => 'login',
                    'label' => 'Logins', 'icon' => 'fa-right-to-bracket', 'count' => $loginCount], ['key' => 'error',
                    'label' => 'Errors', 'icon' => 'fa-triangle-exclamation', 'count' => $errorCount ?? 0]] as $tab)
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

                <x-pagination-bar id="systemLogsPaginationTopBar" info-id="systemLogsPageInfoTop"
                    pagination-id="systemLogsPaginationTop" position="top" :show-entries="true"
                    page-size-id="perPageSelect" page-size-callback="handleSystemLogsPerPageChange"
                    :page-size-value="$perPage" page-size-label="per page" label="entries" />

                <div class="sl-view" id="slListView">
                    <div class="sl-table-wrap">
                        <table class="data-table" id="slTable">
                            <thead>
                                <tr>
                                    <th class="sl-col-id">ID</th>
                                    <th class="sl-col-timestamp">Timestamp</th>
                                    <th class="sl-col-role">Role</th>
                                    <th class="sl-col-user">User</th>
                                    <th class="sl-col-action">Action</th>
                                    <th class="sl-col-module">Module</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody id="slTableBody">
                                @forelse($logs as $log)
                                @php
                                $role = strtolower($log->actor_role ?? 'other');
                                $action = strtolower($log->action ?? '');
                                $actionClass = match (true) {
                                str_contains($action, 'error') ||
                                str_contains($action, 'failed') ||
                                str_contains($action, 'exception')
                                => 'error',
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
                                'error' => 'fa-triangle-exclamation',
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
                                    <td><span class="sl-id">#{{ str_pad($log->id, 3, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td>
                                        <span class="sl-date-day">{{ $log->created_at->format('M j, Y') }}</span>
                                        <span class="sl-date-time">{{ $log->created_at->format('h:i:s A') }}</span>
                                    </td>
                                    <td><span class="sl-role {{ $role }}"><i class="fa-solid {{ $roleIcon }}"></i>{{
                                            ucfirst($role) }}</span>
                                    </td>
                                    <td>
                                        <div class="sl-user">
                                            <div class="sl-avatar {{ $role }}">{{ $avatarLetter }}</div>
                                            <span class="sl-username">{{ $log->actor_name ?? 'Unknown User' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="sl-action {{ $actionClass }}">
                                            <i
                                                class="fa-solid {{ $actionIcon }} {{ $actionClass === 'error' ? 'sl-action-alert' : '' }}"></i>
                                            {{ ucwords(str_replace('_', ' ', $log->action)) }}
                                        </span>
                                        @if ($log->is_archived)
                                        <span class="sl-archive-badge"
                                            title="Archived {{ optional($log->archived_at)->format('M j, Y h:i A') }}">
                                            <i class="fa-solid fa-box-archive"></i> Archived
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="sl-module">
                                            <i class="fa-solid fa-cube"></i>{{ ucfirst(str_replace('_', ' ',
                                            $log->module)) }}
                                        </span>
                                    </td>
                                    <td><span class="sl-desc">{{ $log->description ?? 'No description provided.'
                                            }}</span>
                                    </td>
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
                        str_contains($action, 'error') ||
                        str_contains($action, 'failed') ||
                        str_contains($action, 'exception')
                        => 'error',
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
                        'error' => 'fa-triangle-exclamation',
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
                                    <i
                                        class="fa-solid {{ $actionIcon }} {{ $actionClass === 'error' ? 'sl-action-alert' : '' }}"></i>
                                    {{ ucwords(str_replace('_', ' ', $log->action)) }}
                                </span>
                                @if ($log->is_archived)
                                <span class="sl-archive-badge"
                                    title="Archived {{ optional($log->archived_at)->format('M j, Y h:i A') }}">
                                    <i class="fa-solid fa-box-archive"></i> Archived
                                </span>
                                @endif
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
                                            <i class="fa-solid fa-cube"></i>{{ ucfirst(str_replace('_', ' ',
                                            $log->module)) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="sl-grid-field">
                                    <div class="sl-grid-label">Description</div>
                                    <div class="sl-grid-value">
                                        {{ $log->description ?? 'No description provided.' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        @endforelse
                    </div>
                </div>

                <div id="emptyState" class="empty-state-host"></div>

                <x-pagination-bar id="systemLogsPaginationBottomBar" info-id="systemLogsPageInfoBottom"
                    pagination-id="systemLogsPaginationBottom" position="bottom" :page-size-value="$perPage"
                    label="entries" />
            </div>

        </div>
</main>

<x-filter-drawer id="filterModal" title="Filters" close-callback="closeSlFilterPanel()"
    clear-callback="clearSlFilterPanelDraft()" clear-label="Clear Filters" cancel-id="filterCloseBtn"
    cancel-callback="closeSlFilterPanel()" cancel-label="Cancel" apply-id="filterApplyBtn"
    apply-callback="applySlFilters()" apply-label="Show 0 results" results-id="slShowResultsText">

    <div id="slActiveFiltersSection" class="filter-active-section hidden">

        <div class="filter-active-header">

            <span class="filter-active-title">
                Active Filters
            </span>

            <button id="slClearAllChipsBtn" type="button" class="filter-clear-all ui-btn ui-btn-secondary ui-btn-sm">
                <i class="fa-solid fa-rotate-left"></i>

                <span>
                    Clear All
                </span>
            </button>

        </div>

        <div id="slActiveChipsContainer" class="active-filters-container"></div>

    </div>

    <x-filter-group title="Sort By">

        <input type="hidden" id="slSortOrder" value="desc">

        <div id="slSortGroup" class="filter-chip-row">

            <button type="button" class="ftag" data-sl-sort="desc">
                <i class="fa-solid fa-arrow-down-wide-short"></i>
                Newest First
            </button>

            <button type="button" class="ftag" data-sl-sort="asc">
                <i class="fa-solid fa-arrow-up-wide-short"></i>
                Oldest First
            </button>

        </div>

    </x-filter-group>

    <x-filter-group title="Filter by Date Range">

        <input type="hidden" id="slDatePreset" value="">

        <div id="slDatePresetGroup" class="filter-chip-row">

            <button type="button" class="quick-date-chip" data-sl-date-preset="today" onclick="setSlQuickDate('today')">
                Today
            </button>

            <button type="button" class="quick-date-chip" data-sl-date-preset="week" onclick="setSlQuickDate('week')">
                Last 7 Days
            </button>

            <button type="button" class="quick-date-chip" data-sl-date-preset="month" onclick="setSlQuickDate('month')">
                Last 30 Days
            </button>

        </div>

    </x-filter-group>

    <x-filter-group title="Custom Date Range">

        <div class="filter-date-grid">

            <div class="filter-date-input-wrap">

                <input type="text" id="slDateFrom" class="js-flatpickr-date-max-today" placeholder="Start date" readonly
                    autocomplete="off">

                <i class="fa-regular fa-calendar"></i>

            </div>

            <div class="filter-date-input-wrap">

                <input type="text" id="slDateTo" class="js-flatpickr-date-max-today" placeholder="End date" readonly
                    autocomplete="off">

                <i class="fa-regular fa-calendar"></i>

            </div>

        </div>

    </x-filter-group>

    <x-filter-group title="Action Type">

        <input type="hidden" id="slActionType" value="">

        <div id="slActionSelect" class="sl-action-select">

            <button type="button" id="slActionSelectBtn" class="sl-action-select-btn" aria-expanded="false">
                <span class="sl-action-select-current">

                    <i id="slActionSelectIcon" class="fa-solid fa-layer-group"></i>

                    <span id="slActionSelectLabel">
                        All Actions
                    </span>

                </span>

                <i class="fa-solid fa-chevron-down sl-action-select-chevron"></i>
            </button>

            <div id="slActionSelectMenu" class="sl-action-select-menu">

                @foreach ([
                [
                'value' => '',
                'label' => 'All Actions',
                'icon' => 'fa-layer-group',
                ],
                [
                'value' => 'login',
                'label' => 'Login',
                'icon' => 'fa-right-to-bracket',
                ],
                [
                'value' => 'logout',
                'label' => 'Logout',
                'icon' => 'fa-right-from-bracket',
                ],
                [
                'value' => 'error',
                'label' => 'Error',
                'icon' => 'fa-triangle-exclamation',
                ],
                [
                'value' => 'create',
                'label' => 'Create',
                'icon' => 'fa-plus',
                ],
                [
                'value' => 'update',
                'label' => 'Update',
                'icon' => 'fa-pen',
                ],
                [
                'value' => 'delete',
                'label' => 'Delete',
                'icon' => 'fa-trash',
                ],
                ] as $action)

                <button type="button" class="
                            sl-action-select-option
                            {{ $action['value'] === '' ? 'active' : '' }}
                        " data-value="{{ $action['value'] }}" data-label="{{ $action['label'] }}"
                    data-icon="{{ $action['icon'] }}">
                    <span>
                        <i class="fa-solid {{ $action['icon'] }}"></i>
                        {{ $action['label'] }}
                    </span>

                    <i class="fa-solid fa-check"></i>
                </button>

                @endforeach

            </div>

        </div>

    </x-filter-group>

    <x-filter-group title="Module" class="filter-group-last">

        <div class="filter-date-input-wrap">

            <input type="text" id="slModuleFilter" placeholder="e.g. appointments">

            <i class="fa-solid fa-cube"></i>

        </div>

    </x-filter-group>

</x-filter-drawer>

<div id="slArchiveModal" class="ui-modal modal-theme-warning" aria-hidden="true">

    <div class="ui-modal-card modal-md" role="dialog" aria-modal="true" aria-labelledby="slArchiveModalTitle">

        <div class="modal-hd">
            <div class="modal-heading">
                <div class="modal-icon">
                    <i class="fa-solid fa-box-archive"></i>
                </div>

                <div class="modal-copy">
                    <h3 id="slArchiveModalTitle" class="modal-title">
                        Archive System Logs
                    </h3>

                    <p class="modal-subtitle">
                        Move older log records out of the active view.
                    </p>
                </div>
            </div>

            <button type="button" class="modal-x" onclick="closeSlArchiveModal()" aria-label="Close archive modal">

                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="modal-bd">
            <div class="modal-form-grid">

                <div class="global-confirm-alert">
                    <i class="fa-solid fa-circle-info"></i>

                    <p>
                        Archive older active logs

                        <span>
                            Only active logs older than the selected
                            number of days will be archived. Archived
                            records remain accessible and are not deleted.
                        </span>
                    </p>
                </div>

                <div>
                    <label for="slArchiveDaysInput" class="form-label">
                        Archive logs older than
                    </label>

                    <div class="modal-inline-control">
                        <div class="modal-inline-main">
                            <input type="number" id="slArchiveDaysInput" class="form-input" min="1" max="3650" step="1"
                                value="90" placeholder="Enter number of days">
                        </div>

                        <span class="modal-helper-text">
                            days
                        </span>
                    </div>

                    <div id="slArchiveError" class="modal-error-banner hidden mt-3">

                        <i class="fa-solid fa-circle-exclamation"></i>

                        <span>
                            Please enter a valid number from 1 to 3650.
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-ft">
            <button type="button" class="ui-btn ui-btn-secondary" onclick="closeSlArchiveModal()">

                <i class="fa-solid fa-xmark"></i>
                <span>Cancel</span>
            </button>

            <button type="button" id="slArchiveConfirmBtn" class="ui-btn ui-btn-warning"
                onclick="submitSlArchiveModal()">

                <i class="fa-solid fa-box-archive"></i>
                <span>Archive Logs</span>
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function exportSystemLogsPdf() {
        var params = new URLSearchParams({
            role: slState.role || "all",
            search: slState.search || "",
            status: slState.status || "active",
            sort: slState.sort || "desc",
            date_from: slState.dateFrom || "",
            date_to: slState.dateTo || "",
            action_type: slState.actionType || "",
            module: slState.module || ""
        });

        window.location.assign(
            @json(route('admin.system_logs.export')) +
            "?" +
            params.toString()
        );
    }

    function handleSystemLogsPerPageChange(value) {
        const nextPerPage = Number(value) || 10;

        if (slState.perPage === nextPerPage) {
            return;
        }

        slState.perPage = nextPerPage;
        slState.page = 1;

        slFetch();
    }

    window.handleSystemLogsPerPageChange =
        handleSystemLogsPerPageChange;

    var slState = {
        role: @json($role ?? 'all'),
        search: @json($search ?? ''),
        status: @json($status ?? 'active'),
        perPage: {{ (int)($perPage ?? 10) }},
    page: @json((int) request('page', 1)),
    sort: @json($sort ?? 'desc'),
    dateFrom: @json($dateFrom ?? ''),
    dateTo: @json($dateTo ?? ''),
    actionType: @json($actionType ?? ''),
    module: @json($module ?? ''),
        };

    var slOverallTotal = {{ (int)($totalCount ?? 0) }};

    window.handleSystemLogsSearch =
        function (value) {
            slState.search =
                String(value || '')
                    .trim();

            slState.page = 1;

            slFetch(true);
        };

    var slController = null;
    var slDraftCountController = null;
    var slDraftCountTimer = null;
    var systemLogsRefreshWatcher = null;

    document.addEventListener('DOMContentLoaded', function () {
        syncSlFilterInputs();
        updateSlClearFilterButton();

        window.initSearchClearButtons?.();
        window.initGlobalVoiceInputs?.();

        ['slDateFrom', 'slDateTo'].forEach(function (id) {
            var el = document.getElementById(id);
            if (!el) return;

            el.addEventListener('change', function () {
                var preset = document.getElementById('slDatePreset');
                if (preset) preset.value = '';

                syncSlQuickDateChips();
                renderSlFilterChips();
                updateSlShowResultsButton();
            });

            el.addEventListener('input', function () {
                var preset = document.getElementById('slDatePreset');
                if (preset) preset.value = '';

                syncSlQuickDateChips();
                renderSlFilterChips();
                updateSlShowResultsButton();
            });
        });

        ['slModuleFilter'].forEach(function (id) {
            var el = document.getElementById(id);
            if (!el) return;

            el.addEventListener('change', function () {
                renderSlFilterChips();
                updateSlShowResultsButton();
            });

            el.addEventListener('input', function () {
                renderSlFilterChips();
                updateSlShowResultsButton();
            });
        });

        document.querySelectorAll('#slSortGroup [data-sl-sort]').forEach(function (button) {
            button.addEventListener('click', function () {
                var sort = document.getElementById('slSortOrder');

                if (sort) {
                    sort.value = this.dataset.slSort || 'desc';
                }

                syncSlFilterChoiceControls();
                renderSlFilterChips();
                updateSlShowResultsButton();
            });
        });

        initSlActionDropdown();
        syncSlFilterChoiceControls();
        updateSlShowResultsButton();

        @if (method_exists($logs, 'total') && $logs -> total() > 0)
            slRenderPagebar({
                total: {{ (int) $logs -> total() }},
        from: {{ (int)($logs -> firstItem() ?? 0) }},
        to: {{ (int)($logs -> lastItem() ?? 0) }},
        current_page: {{ (int) $logs -> currentPage() }},
        last_page: {{ (int) $logs -> lastPage() }},
        per_page: {{ (int) $logs -> perPage() }},
                });
    @else
    slRenderPagebar({
        total: {{ method_exists($logs, 'count') ? (int) $logs -> count() : 0 }},
        from: 0,
        to: 0,
        current_page: 1,
        last_page: 1,
        per_page: {{ (int)($perPage ?? 10) }},
                });
    @endif

    @if (method_exists($logs, 'count') && $logs -> count() === 0)
        showEmptyState(slState.search);
    @endif

    var searchInput = document.getElementById('slSearch');
    var slArchiveDaysInput = document.getElementById('slArchiveDaysInput');
    var slArchiveError = document.getElementById('slArchiveError');
    var slArchiveConfirmBtn = document.getElementById('slArchiveConfirmBtn');
    var perPageSelect =
        document.getElementById('perPageSelect');

    if (perPageSelect) {
        perPageSelect.value =
            String(slState.perPage || 10);

        window.syncGlobalPageSizeSelect?.(
            perPageSelect,
            slState.perPage || 10
        );

        window.initGlobalPageSizeSelects?.();
    }

    if (slArchiveDaysInput) {
        slArchiveDaysInput.addEventListener('input', clearSlArchiveError);
        slArchiveDaysInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                submitSlArchiveModal();
            }
        });
    }

    @php
    $latestLogId = optional(($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs -> getCollection() : $logs) -> first()) -> id ?? 0;
    @endphp

    systemLogsRefreshWatcher = window.initGlobalRefreshWatcher?.({
        key: 'system-logs',

        url: @json(route('admin.system_logs.check'). '?status=active'),

        interval: 5000,

        initialItems: @json($latestLogId ? [['id' => (int) $latestLogId]] : []),

        anchorSelector: '#mainContent.system-logs-page .card',

        itemLabel: 'log entry',

        getItems: function (payload) {
            if (Array.isArray(payload)) {
                return payload;
            }

            var latestId =
                Number(payload?.latest_id || 0);

            return latestId > 0 ? [{
                id: latestId
            }] : [];
        },

        getItemId: function (item) {
            return item?.id;
        },

        title: function () {
            return 'New log entries detected';
        },

        subtitle: function () {
            return 'Refresh to see the latest system activity.';
        },

        onRefresh: function () {
            slState.page = 1;
            slFetch();
        },

        toast: {
            type: 'success',
            title: 'System logs updated',
            message: 'Latest log entries are now shown.'
        }
    });

    if (slState.status === 'archived') {
        systemLogsRefreshWatcher?.stop();
    }

    function escapeSlHtml(value) {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function slSetTab(el, role) {
        slState.role = role;
        slState.page = 1;

        document.querySelectorAll('.sl-role-tabs .tab-btn').forEach(function (button) {
            button.classList.remove('active');
            button.querySelector('.tab-count')?.classList.remove('active');
        });

        el?.classList.add('active');
        el?.querySelector('.tab-count')?.classList.add('active');

        slFetch();
    }

    function openSlArchiveModal() {
        if (slState.status === "archived") {
            window.showToast?.(
                "Switch to active or all logs before archiving.",
                "warning"
            );

            return;
        }

        var modal =
            document.getElementById("slArchiveModal");

        if (!modal) {
            console.error(
                "Archive modal #slArchiveModal was not found."
            );
            return;
        }

        clearSlArchiveError();

        if (
            slArchiveDaysInput &&
            !slArchiveDaysInput.value
        ) {
            slArchiveDaysInput.value = "90";
        }

        if (typeof window.openModal === "function") {
            window.openModal("slArchiveModal");
        } else {
            modal.classList.add("open");
            modal.setAttribute("aria-hidden", "false");
            document.documentElement.classList.add(
                "modal-open"
            );
            document.body.classList.add("modal-open");
        }

        window.setTimeout(function () {
            slArchiveDaysInput?.focus();
            slArchiveDaysInput?.select();
        }, 100);
    }

    function closeSlArchiveModal() {
        var modal =
            document.getElementById("slArchiveModal");

        clearSlArchiveError();

        if (!modal) return;

        if (typeof window.closeModal === "function") {
            window.closeModal("slArchiveModal");
        } else {
            modal.classList.remove("open");
            modal.setAttribute("aria-hidden", "true");
            document.documentElement.classList.remove(
                "modal-open"
            );
            document.body.classList.remove("modal-open");
        }
    }

    function clearSlArchiveError() {
        slArchiveError?.classList.add('hidden');
    }

    function submitSlArchiveModal() {
        var olderThanDays = Number(slArchiveDaysInput?.value || '');

        if (!Number.isFinite(olderThanDays) || olderThanDays < 1 || olderThanDays > 3650) {
            slArchiveError?.classList.remove('hidden');
            slArchiveDaysInput?.focus();
            return;
        }

        var body = new URLSearchParams({
            older_than_days: String(Math.floor(olderThanDays)),
            role: slState.role || 'all',
            search: slState.search || '',
            sort: slState.sort || 'desc',
            date_from: slState.dateFrom || '',
            date_to: slState.dateTo || '',
            action_type: slState.actionType || '',
            module: slState.module || '',
        });

        if (slArchiveConfirmBtn) {
            slArchiveConfirmBtn.disabled = true;
            slArchiveConfirmBtn.innerHTML =
                '<i class="fa-solid fa-spinner fa-spin"></i><span>Archiving...</span>';
        }

        fetch('{{ route('admin.system_logs.archive') }}', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                'Accept': 'application/json'
            },
            body: body.toString()
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
                if (!result.ok) {
                    throw new Error(result.data?.message || 'Archive request failed');
                }

                closeSlArchiveModal();
                window.showToast?.(result.data?.message || 'Logs archived successfully.', 'success');
                slState.page = 1;
                slFetch();
            })
            .catch(function (error) {
                window.showToast?.(error.message || 'Unable to archive logs right now.', 'error');
            })
            .finally(function () {
                if (slArchiveConfirmBtn) {
                    slArchiveConfirmBtn.disabled = false;
                    slArchiveConfirmBtn.innerHTML =
                        '<i class="fa-solid fa-box-archive"></i><span>Archive Logs</span>';
                }
            });
    }

    function slSetStatus(el, status) {
        slState.status = status || 'active';
        slState.page = 1;

        document.querySelectorAll('.sl-status-tab').forEach(function (button) {
            button.classList.remove('active');
        });

        el?.classList.add('active');

        if (slState.status === 'archived') {
            systemLogsRefreshWatcher?.stop();
        } else {
            systemLogsRefreshWatcher?.start();
        }

        slFetch();
    }

    function hasActiveSlFilters() {
        return (slState.sort && slState.sort !== 'desc') ||
            !!slState.dateFrom || !!slState.dateTo ||
            !!slState.actionType || !!slState.module;
    }

    function detectSlDatePreset(from, to) {
        if (!from || !to) return '';

        var today = new Date();
        today.setHours(0, 0, 0, 0);

        var todayValue = formatSlDate(today);

        var week = new Date(today);
        week.setDate(today.getDate() - 6);

        var month = new Date(today);
        month.setDate(today.getDate() - 29);

        if (from === todayValue && to === todayValue) return 'today';
        if (from === formatSlDate(week) && to === todayValue) return 'week';
        if (from === formatSlDate(month) && to === todayValue) return 'month';

        return '';
    }

    function getSlDatePresetText(preset) {
        if (preset === 'today') return 'Today';
        if (preset === 'week') return 'Last 7 Days';
        if (preset === 'month') return 'Last 30 Days';
        return '';
    }

    function getSlDateChipLabel(from, to) {
        var preset = document.getElementById('slDatePreset')?.value || '';

        if (preset) {
            return getSlDatePresetText(preset);
        }

        if (from && to) return from + ' to ' + to;
        if (from) return 'From ' + from;
        if (to) return 'Until ' + to;

        return '';
    }

    function getSlActionOption(value) {
        var options = Array.from(document.querySelectorAll('#slActionSelectMenu .sl-action-select-option'));

        return options.find(function (option) {
            return String(option.dataset.value || '') === String(value || '');
        }) || options[0] || null;
    }

    function syncSlActionDropdownLabel(value) {
        var option = getSlActionOption(value);
        var label = document.getElementById('slActionSelectLabel');
        var icon = document.getElementById('slActionSelectIcon');

        if (!option) return;

        if (label) {
            label.textContent = option.dataset.label || 'All Actions';
        }

        if (icon) {
            icon.className = 'fa-solid ' + (option.dataset.icon || 'fa-layer-group');
        }

        document.querySelectorAll('#slActionSelectMenu .sl-action-select-option').forEach(function (button) {
            button.classList.toggle('active', button === option);
        });
    }

    function closeSlActionDropdown() {
        var select = document.getElementById('slActionSelect');
        var button = document.getElementById('slActionSelectBtn');

        select?.classList.remove('is-open');
        button?.setAttribute('aria-expanded', 'false');
    }

    function setSlActionType(value) {
        var action = document.getElementById('slActionType');

        if (action) {
            action.value = value || '';
        }

        syncSlFilterChoiceControls();
        renderSlFilterChips();
        updateSlShowResultsButton();
    }

    function initSlActionDropdown() {
        var select = document.getElementById('slActionSelect');
        var button = document.getElementById('slActionSelectBtn');
        var menu = document.getElementById('slActionSelectMenu');

        if (!select || !button || !menu || select.dataset.bound === '1') return;

        select.dataset.bound = '1';

        button.addEventListener('click', function (event) {
            event.stopPropagation();

            var isOpen = select.classList.toggle('is-open');
            button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        menu.querySelectorAll('.sl-action-select-option').forEach(function (option) {
            option.addEventListener('click', function (event) {
                event.stopPropagation();
                setSlActionType(this.dataset.value || '');
                closeSlActionDropdown();
            });
        });

        document.addEventListener('click', function (event) {
            if (!select.contains(event.target)) {
                closeSlActionDropdown();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeSlActionDropdown();
            }
        });
    }

    function syncSlQuickDateChips() {
        var preset = document.getElementById('slDatePreset')?.value || '';

        document.querySelectorAll('#slDatePresetGroup .quick-date-chip').forEach(function (button) {
            button.classList.toggle('active', String(button.dataset.slDatePreset || '') === String(
                preset ||
                ''));
        });
    }

    function syncSlFilterChoiceControls() {
        var sortEl = document.getElementById('slSortOrder');
        var actionEl = document.getElementById('slActionType');

        var sortValue = sortEl ? sortEl.value || 'desc' : slState.sort || 'desc';
        var actionValue = actionEl ? actionEl.value || '' : slState.actionType || '';

        document.querySelectorAll('#slSortGroup [data-sl-sort]').forEach(function (button) {
            button.classList.toggle('ftag-active', String(button.dataset.slSort || '') === String(
                sortValue ||
                'desc'));
        });

        syncSlActionDropdownLabel(actionValue);
        syncSlQuickDateChips();
    }

    function syncSlFilterInputs() {
        var sort = document.getElementById('slSortOrder');
        var from = document.getElementById('slDateFrom');
        var to = document.getElementById('slDateTo');
        var action = document.getElementById('slActionType');
        var module = document.getElementById('slModuleFilter');
        var preset = document.getElementById('slDatePreset');

        if (sort) sort.value = slState.sort || 'desc';
        if (from) from.value = slState.dateFrom || '';
        if (to) to.value = slState.dateTo || '';
        if (preset) preset.value = detectSlDatePreset(slState.dateFrom || '', slState.dateTo || '');
        if (action) action.value = slState.actionType || '';
        if (module) module.value = slState.module || '';

        syncSlFilterChoiceControls();
    }

    function getSlFilterModal() {
        return document.getElementById('filterModal');
    }

    function openSlFilterPanel() {
        syncSlFilterInputs();
        renderSlFilterChips();

        if (typeof window.openFilterDrawer === 'function') {
            window.openFilterDrawer('filterModal');
        } else {
            document.getElementById('filterModal')?.classList.add('open');
            document.documentElement.classList.add('filter-lock');
            document.body.classList.add('filter-lock');
        }

        document.getElementById('filterModal')?.setAttribute('aria-hidden', 'false');
    }

    function closeSlFilterPanel() {
        if (typeof window.closeFilterDrawer === 'function') {
            window.closeFilterDrawer('filterModal');
        } else {
            document.getElementById('filterModal')?.classList.remove('open');
            document.documentElement.classList.remove('filter-lock');
            document.body.classList.remove('filter-lock');
        }

        document.getElementById('filterModal')?.setAttribute('aria-hidden', 'true');
    }

    function updateSlClearFilterButton() {
        var count = 0;

        if (slState.sort && slState.sort !== 'desc') count++;
        if (slState.dateFrom || slState.dateTo) count++;
        if (slState.actionType) count++;
        if (slState.module) count++;

        if (typeof window.setGlobalFilterButtonState === 'function') {
            window.setGlobalFilterButtonState({
                buttonId: 'slFilterBtn',
                badgeId: 'slFilterBadge',
                resetId: 'slClearFilterBtn',
                count: count
            });

            return;
        }

        var has = count > 0;
        var btn = document.getElementById('slClearFilterBtn');
        var badge = document.getElementById('slFilterBadge');
        var filterBtn = document.getElementById('slFilterBtn');

        btn?.classList.toggle('hidden', !has);
        btn?.classList.toggle('show', has);

        filterBtn?.classList.toggle('has-filters', has);
        filterBtn?.setAttribute('aria-pressed', has ? 'true' : 'false');

        if (badge) {
            badge.classList.toggle('show', has);
            badge.textContent = has ? String(count) : '';
        }
    }

    function clearOnlySlFilters() {
        slState.sort = 'desc';
        slState.dateFrom = '';
        slState.dateTo = '';
        slState.actionType = '';
        slState.module = '';
        slState.page = 1;

        syncSlFilterInputs();
        renderSlFilterChips();
        updateSlClearFilterButton();
        closeSlFilterPanel();
        slFetch();
    }

    function clearSlFilterPanelDraft() {
        var sort = document.getElementById('slSortOrder');
        var from = document.getElementById('slDateFrom');
        var to = document.getElementById('slDateTo');
        var action = document.getElementById('slActionType');
        var module = document.getElementById('slModuleFilter');

        if (sort) sort.value = 'desc';
        if (from) from.value = '';
        if (to) to.value = '';
        if (action) action.value = '';
        if (module) module.value = '';

        syncSlFilterChoiceControls();
        renderSlFilterChips();
    }

    function renderSlFilterChips() {
        var container = document.getElementById('slActiveChipsContainer');
        var section = document.getElementById('slActiveFiltersSection');
        var clearAllBtn = document.getElementById('slClearAllChipsBtn');

        if (!container || !section) return;

        container.innerHTML = '';
        var hasChips = false;

        function addChip(label, callback) {
            hasChips = true;

            var chip = document.createElement('div');
            chip.className = 'filter-chip sl-filter-chip';
            chip.innerHTML =
                '<span>' + escapeSlHtml(label) +
                '</span><span class="filter-chip-remove sl-filter-chip-remove"><i class="fa-solid fa-xmark"></i></span>';

            chip.querySelector('.sl-filter-chip-remove').onclick = function () {
                callback();
                syncSlFilterChoiceControls();
                renderSlFilterChips();
            };

            container.appendChild(chip);
        }

        var sortVal = document.getElementById('slSortOrder')?.value || 'desc';
        var fromVal = document.getElementById('slDateFrom')?.value || '';
        var toVal = document.getElementById('slDateTo')?.value || '';
        var actionVal = document.getElementById('slActionType')?.value || '';
        var moduleVal = document.getElementById('slModuleFilter')?.value || '';

        if (sortVal === 'asc') {
            addChip('Sort: Oldest first', function () {
                document.getElementById('slSortOrder').value = 'desc';
            });
        }

        if (fromVal || toVal) {
            var lbl = getSlDateChipLabel(fromVal, toVal);

            addChip('Date: ' + lbl, function () {
                document.getElementById('slDateFrom').value = '';
                document.getElementById('slDateTo').value = '';

                var preset = document.getElementById('slDatePreset');
                if (preset) preset.value = '';
            });
        }

        if (actionVal) {
            addChip('Action: ' + actionVal.charAt(0).toUpperCase() + actionVal.slice(1), function () {
                document.getElementById('slActionType').value = '';
            });
        }

        if (moduleVal) {
            addChip('Module: ' + moduleVal, function () {
                document.getElementById('slModuleFilter').value = '';
            });
        }

        section.classList.toggle('hidden', !hasChips);

        if (clearAllBtn) {
            clearAllBtn.onclick = function () {
                clearSlFilterPanelDraft();
            };
        }

        updateSlShowResultsButton();
    }

    function formatSlDate(date) {
        var yyyy = date.getFullYear();
        var mm = String(date.getMonth() + 1).padStart(2, '0');
        var dd = String(date.getDate()).padStart(2, '0');
        return yyyy + '-' + mm + '-' + dd;
    }

    function setSlQuickDate(type) {
        var from = document.getElementById('slDateFrom');
        var to = document.getElementById('slDateTo');
        var preset = document.getElementById('slDatePreset');

        var today = new Date();
        today.setHours(0, 0, 0, 0);

        if (!from || !to) return;
        if (!['today', 'week', 'month'].includes(type)) return;

        var start = new Date(today);

        if (type === 'week') {
            start.setDate(today.getDate() - 6);
        } else if (type === 'month') {
            start.setDate(today.getDate() - 29);
        }

        from.value = formatSlDate(start);
        to.value = formatSlDate(today);

        if (preset) {
            preset.value = type;
        }

        syncSlQuickDateChips();
        renderSlFilterChips();
        updateSlShowResultsButton();
    }

    function setSlShowResultsText(total) {
        var text = document.getElementById('slShowResultsText');
        if (!text) return;

        var count = Number(total || 0);
        text.textContent = 'Show ' + count + ' ' + (count === 1 ? 'result' : 'results');
    }

    function getSlDraftFilterParams() {
        return new URLSearchParams({
            role: slState.role || 'all',
            search: slState.search || '',
            status: slState.status || 'active',
            per_page: 1,
            page: 1,
            sort: document.getElementById('slSortOrder')?.value || 'desc',
            date_from: document.getElementById('slDateFrom')?.value || '',
            date_to: document.getElementById('slDateTo')?.value || '',
            action_type: document.getElementById('slActionType')?.value || '',
            module: document.getElementById('slModuleFilter')?.value.trim() || '',
        });
    }

    function updateSlShowResultsButton(total) {
        if (typeof total === 'number') {
            setSlShowResultsText(total);
            return;
        }

        clearTimeout(slDraftCountTimer);

        slDraftCountTimer = setTimeout(function () {
            if (slDraftCountController) {
                slDraftCountController.abort();
            }

            slDraftCountController = new AbortController();

            fetch('{{ route('admin.system_logs') }}?' + getSlDraftFilterParams().toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        ?.content ?? ''
                },
                signal: slDraftCountController.signal
            })
                .then(function (res) {
                    if (!res.ok) throw new Error('Draft count request failed');
                    return res.json();
                })
                .then(function (data) {
                    var total = Number(data.pagination?.total ?? 0);
                    setSlShowResultsText(total);
                })
                .catch(function (e) {
                    if (e.name !== 'AbortError') {
                        setSlShowResultsText(slOverallTotal || 0);
                    }
                });
        }, 220);
    }

    function applySlFilters() {
        slState.sort = document.getElementById('slSortOrder')?.value || 'desc';
        slState.dateFrom = document.getElementById('slDateFrom')?.value || '';
        slState.dateTo = document.getElementById('slDateTo')?.value || '';
        slState.actionType = document.getElementById('slActionType')?.value || '';
        slState.module = document.getElementById('slModuleFilter')?.value.trim() || '';
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
            role: slState.role || 'all',
            search: slState.search || '',
            status: slState.status || 'active',
            per_page: slState.perPage || 10,
            page: slState.page || 1,
            sort: slState.sort || 'desc',
            date_from: slState.dateFrom || '',
            date_to: slState.dateTo || '',
            action_type: slState.actionType || '',
            module: slState.module || '',
        });

        history.replaceState(null, '', window.location.pathname + '?' + params.toString());

        var tableBody = document.getElementById('slTableBody');
        var gridBody = document.getElementById('slGridBody');

        if (!silent) {
            if (tableBody) tableBody.innerHTML = slSkeletonRows(slState.perPage);
            if (gridBody) gridBody.innerHTML = slSkeletonCards(slState.perPage);
        }

        window.EmptyState?.hide(
            '#emptyState'
        );

        fetch('{{ route('admin.system_logs') }}?' + params.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? ''
            },
            signal: slController.signal
        })
            .then(function (res) {
                if (!res.ok) throw new Error('Request failed');
                return res.json();
            })
            .then(function (data) {
                slRenderRows(data.logs || []);
                slRenderPagebar(data.pagination);
                slRenderCounts(data.counts);
                updateSlClearFilterButton();
                updateSlShowResultsButton(Number(data.pagination?.total ?? 0));
            })
            .catch(function (e) {
                if (e.name !== 'AbortError') console.error('Fetch error:', e);
            });
    }

    function slSkeletonRows(count) {
        var row = '<tr>' +
            '<td><span class="sl-id sl-skeleton sl-skeleton-check">&nbsp;&nbsp;&nbsp;&nbsp;</span></td>' +
            '<td><span class="sl-skeleton sl-skeleton-id">&nbsp;</span></td>' +
            '<td><span class="sl-skeleton sl-skeleton-role">&nbsp;</span></td>' +
            '<td><span class="sl-skeleton sl-skeleton-user">&nbsp;</span></td>' +
            '<td><span class="sl-skeleton sl-skeleton-action">&nbsp;</span></td>' +
            '<td><span class="sl-skeleton sl-skeleton-id">&nbsp;</span></td>' +
            '<td><span class="sl-skeleton sl-skeleton-desc">&nbsp;</span></td>' +
            '</tr>';
        var html = '';
        for (var i = 0; i < Math.min(Number(count) || 5, 5); i++) html += row;
        return html;
    }

    function slSkeletonCards(count) {
        var html = '';
        for (var i = 0; i < Math.min(Number(count) || 4, 4); i++) {
            html += '<div class="sl-grid-card sl-grid-card-skeleton">' +
                '<span class="sl-skeleton sl-skeleton-id"></span>' +
                '<span class="sl-skeleton sl-skeleton-user"></span>' +
                '<span class="sl-skeleton sl-skeleton-desc"></span>' +
                '<span class="sl-skeleton sl-skeleton-desc"></span>' +
                '</div>';
        }
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
            error: 'fa-triangle-exclamation',
            default: 'fa-bolt'
        };

        var roleIcons = {
            admin: 'fa-user-tie',
            dentist: 'fa-user-doctor',
            patient: 'fa-user'
        };

        var tableHtml = '';
        var gridHtml = '';

        logs.forEach(function (log) {
            var role = (log.actor_role || 'other').toLowerCase();
            var action = (log.action || '').toLowerCase();
            var actionClass = (action.includes('error') || action.includes('failed') || action
                .includes(
                    'exception')) ? 'error' :
                action.includes('login') ? 'login' :
                    action.includes('logout') ? 'logout' :
                        action.includes('create') ? 'create' :
                            action.includes('update') ? 'update' :
                                action.includes('delete') ? 'delete' :
                                    'default';

            var actionIcon = actionIcons[actionClass] || 'fa-bolt';
            var actionIconHtml = '<i class="fa-solid ' + actionIcon + (actionClass === 'error' ?
                ' sl-action-alert' : '') + '"></i>';
            var roleIcon = roleIcons[role] || 'fa-circle-user';
            var letter = escapeSlHtml((log.actor_name || role).charAt(0).toUpperCase());
            var idPadded = '#' + String(log.id || '').padStart(3, '0');
            var actionLabel = escapeSlHtml((log.action || '').replace(/_/g, ' ').replace(/\b\w/g,
                function (c) {
                    return c.toUpperCase();
                }));
            var moduleLabel = escapeSlHtml((log.module || '').replace(/_/g, ' ').replace(/\b\w/g,
                function (c) {
                    return c.toUpperCase();
                }));
            var archiveBadge = log.is_archived ?
                '<span class="sl-archive-badge" title="' + escapeSlHtml(log.archived_at ||
                    'Archived') + '"><i class="fa-solid fa-box-archive"></i> Archived</span>' :
                '';
            var actorName = escapeSlHtml(log.actor_name ?? log.actor_identifier ?? 'Unknown User');
            var description = escapeSlHtml(log.description || 'No description provided.');
            var createdDay = escapeSlHtml(log.created_at_day || '');
            var createdTime = escapeSlHtml(log.created_at_time || '');

            tableHtml += '<tr data-role="' + escapeSlHtml(role) + '" data-action="' + escapeSlHtml(
                actionClass) + '">';
            tableHtml += '<td><span class="sl-id">' + idPadded + '</span></td>';
            tableHtml += '<td><span class="sl-date-day">' + createdDay +
                '</span><span class="sl-date-time">' + createdTime + '</span></td>';
            tableHtml += '<td><span class="sl-role ' + escapeSlHtml(role) +
                '"><i class="fa-solid ' + roleIcon +
                '"></i>' +
                escapeSlHtml(role.charAt(0).toUpperCase() + role.slice(1)) + '</span></td>';
            tableHtml += '<td><div class="sl-user"><div class="sl-avatar ' + escapeSlHtml(role) +
                '">' +
                letter +
                '</div><span class="sl-username">' + actorName + '</span></div></td>';
            tableHtml += '<td><span class="sl-action ' + escapeSlHtml(actionClass) + '">' +
                actionIconHtml +
                ' ' + actionLabel + '</span ></td > ';
            tableHtml += '<td><span class="sl-module"><i class="fa-solid fa-cube"></i>' +
                moduleLabel +
                '</span></td>';
            tableHtml += '<td><span class="sl-desc" title="' + description + '">' + description +
                '</span></td>';
            tableHtml += '</tr>';

            gridHtml += '<div class="sl-grid-card" data-role="' + escapeSlHtml(role) +
                '" data-action="' +
                escapeSlHtml(actionClass) + '">';
            gridHtml += '<div class="sl-grid-top">';
            gridHtml += '<div class="sl-grid-id">' + idPadded + '</div>';
            gridHtml += '<span class="sl-action ' + escapeSlHtml(actionClass) + '"> ' +
                actionIconHtml + ' ' + actionLabel + '</span > ';
            gridHtml += '</div>';

            gridHtml += '<div class="sl-user"><div class="sl-avatar ' + escapeSlHtml(role) + '">' +
                letter +
                '</div><span class="sl-username">' + actorName + '</span></div>';

            gridHtml += '<div class="sl-grid-meta">';
            gridHtml +=
                '<div class="sl-grid-field"><div class="sl-grid-label">Timestamp</div><div class="sl-grid-value">' +
                createdDay + '<br>' + createdTime + '</div></div>';
            gridHtml +=
                '<div class="sl-grid-field"><div class="sl-grid-label">Role</div><div class="sl-grid-value"><span class="sl-role ' +
                escapeSlHtml(role) + '"><i class="fa-solid ' + roleIcon + '"></i>' + escapeSlHtml(
                    role.charAt(0)
                        .toUpperCase() + role
                            .slice(1)) + '</span></div></div>';
            gridHtml +=
                '<div class="sl-grid-field"><div class="sl-grid-label">Module</div><div class="sl-grid-value"><span class="sl-module"><i class="fa-solid fa-cube"></i>' +
                moduleLabel + '</span></div></div>';
            gridHtml +=
                '<div class="sl-grid-field"><div class="sl-grid-label">Description</div><div class="sl-grid-value">' +
                description + '</div></div>';
            gridHtml += '</div>';
            gridHtml += '</div>';
        });

        if (tableBody) tableBody.innerHTML = tableHtml;
        if (gridBody) gridBody.innerHTML = gridHtml;

        var emptyState = document.getElementById('emptyState');
        if (emptyState) {
            window.EmptyState?.hide(
                '#emptyState'
            );
        }
    }

    function slRenderPagebar(p) {
        if (!p) {
            return;
        }

        window.renderGlobalPagination?.({
            currentPage: Number(
                p.current_page
            ) || 1,

            lastPage: Number(
                p.last_page
            ) || 1,

            total: Number(
                p.total
            ) || 0,

            from: p.from ?? null,

            to: p.to ?? null,

            containers: [
                document.getElementById(
                    'systemLogsPaginationTop'
                ),
                document.getElementById(
                    'systemLogsPaginationBottom'
                ),
            ],

            bars: [
                document.getElementById(
                    'systemLogsPaginationTopBar'
                ),
                document.getElementById(
                    'systemLogsPaginationBottomBar'
                ),
            ],

            infoElements: [
                document.getElementById(
                    'systemLogsPageInfoTop'
                ),
                document.getElementById(
                    'systemLogsPageInfoBottom'
                ),
            ],

            itemLabel: 'entries',

            onPageChange(page) {
                slState.page = page;
                slFetch();
            },
        });

        const perPageSelect =
            document.getElementById(
                'perPageSelect'
            );

        if (
            perPageSelect &&
            p.per_page
        ) {
            perPageSelect.value =
                String(p.per_page);

            window
                .syncGlobalPageSizeSelect?.(
                    perPageSelect,
                    p.per_page
                );
        }

        const badge =
            document.getElementById(
                'entryBadge'
            );

        if (badge) {
            badge.textContent =
                `${slOverallTotal} ${slOverallTotal === 1
                    ? 'entry'
                    : 'entries'
                }`;
        }
    }

    function slRenderCounts(counts) {
        if (!counts) return;

        slOverallTotal = Number(counts.total || 0);

        if (document.getElementById('statTotal')) document.getElementById('statTotal').textContent = counts
            .total ?? 0;
        if (document.getElementById('statAdmin')) document.getElementById('statAdmin').textContent = counts
            .admin ?? 0;
        if (document.getElementById('statDentist')) document.getElementById('statDentist').textContent =
            counts
                .dentist ?? 0;
        if (document.getElementById('statPatient')) document.getElementById('statPatient').textContent =
            counts
                .patient ?? 0;

        var badge = document.getElementById('entryBadge');
        if (badge) badge.textContent = slOverallTotal + ' ' + (slOverallTotal === 1 ? 'entry' : 'entries');

        updateTabCount('all', counts.total);
        updateTabCount('admin', counts.admin);
        updateTabCount('dentist', counts.dentist);
        updateTabCount('patient', counts.patient);
        updateTabCount('login', counts.login);
        updateTabCount('error', counts.error);
        updateStatusCount('active', counts.active);
        updateStatusCount('archived', counts.archived);
        updateStatusCount('all', Number(counts.active || 0) + Number(counts.archived || 0));
    }

    function updateTabCount(role, value) {
        var buttons = document.querySelectorAll('.sl-role-tabs .tab-btn');

        buttons.forEach(function (button) {
            if (!button.getAttribute('onclick')?.includes("'" + role + "'")) return;

            var count = button.querySelector('.tab-count');
            if (count && value !== undefined && value !== null) {
                count.textContent = value;
            }
        });
    }

    function updateStatusCount(status, value) {
        document.querySelectorAll('.sl-status-tab').forEach(function (button) {
            if (!button.getAttribute('onclick')?.includes("'" + status + "'")) return;

            var count = button.querySelector('.sl-status-count');
            if (count && value !== undefined && value !== null) {
                count.textContent = value;
            }
        });
    }

    function showEmptyState(query) {
        var listView =
            document.getElementById(
                'slListView'
            );

        var gridView =
            document.getElementById(
                'slGridView'
            );

        if (listView) {
            listView.hidden = true;
        }

        if (gridView) {
            gridView.hidden = true;
        }

        if (query) {
            window.EmptyState?.renderSearch({
                host: '#emptyState',

                input: '#slSearch',

                query,

                message: 'Try a different name, action, module, or user.',
            });

            return;
        }

        if (
            slState.status === 'archived' &&
            !hasActiveSlFilters() &&
            slState.role === 'all'
        ) {
            window.EmptyState?.render({
                host: '#emptyState',

                icon: 'fa-box-archive',

                title: 'No archived logs yet',

                message: 'Archive older records to keep the active log view easier to manage.',
            });

            return;
        }

        if (hasActiveSlFilters()) {
            window.EmptyState?.render({
                host: '#emptyState',

                icon: 'fa-filter-circle-xmark',

                title: 'No logs match the selected filters',

                message: 'Try adjusting the filter panel or clearing all filters.',

                actionHtml: `
                <button
                    type="button"
                    class="empty-state-btn"
                    data-empty-action="clear-filters"
                >
                    <i class="fa-solid fa-filter-circle-xmark"></i>
                    Clear filters
                </button>
            `,
            });

            document
                .querySelector(
                    '#emptyState [data-empty-action="clear-filters"]'
                )
                ?.addEventListener(
                    'click',
                    clearOnlySlFilters
                );

            return;
        }

        if (slState.role !== 'all') {
            var labels = {
                admin: 'Admin',
                dentist: 'Dentist',
                patient: 'Patient',
                login: 'Login',
                error: 'Error',
            };

            window.EmptyState?.render({
                host: '#emptyState',

                icon: 'fa-filter',

                title: 'No ' +
                    (
                        labels[
                        slState.role
                        ] ||
                        slState.role
                    ) +
                    ' logs found',

                message: 'There are no logs matching this tab yet.',

                actionHtml: `
                <button
                    type="button"
                    class="empty-state-btn"
                    data-empty-action="show-all"
                >
                    <i class="fa-solid fa-layer-group"></i>
                    Show all logs
                </button>
            `,
            });

            document
                .querySelector(
                    '#emptyState [data-empty-action="show-all"]'
                )
                ?.addEventListener(
                    'click',
                    function () {
                        slSetTab(
                            document.querySelector(
                                '.sl-role-tabs .tab-btn'
                            ),
                            'all'
                        );
                    }
                );

            return;
        }

        window.EmptyState?.render({
            host: '#emptyState',

            icon: 'fa-clipboard-list',

            title: 'No system logs yet',

            message: 'Activity will appear here once users interact with the system.',
        });
    }

    window.slSetTab = slSetTab;
    window.slSetStatus = slSetStatus;

    window.openSlFilterPanel = openSlFilterPanel;
    window.closeSlFilterPanel = closeSlFilterPanel;
    window.applySlFilters = applySlFilters;
    window.clearOnlySlFilters = clearOnlySlFilters;
    window.clearSlFilterPanelDraft =
        clearSlFilterPanelDraft;
    window.setSlQuickDate = setSlQuickDate;

    window.openSlArchiveModal =
        openSlArchiveModal;
    window.closeSlArchiveModal =
        closeSlArchiveModal;
    window.submitSlArchiveModal =
        submitSlArchiveModal;

    window.exportSystemLogsPdf =
        exportSystemLogsPdf;
        });
</script>
@endsection