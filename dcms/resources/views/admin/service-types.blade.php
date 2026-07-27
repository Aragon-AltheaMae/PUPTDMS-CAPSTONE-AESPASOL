@extends('layouts.app')

@section('layout-role', 'admin')

@section('title', 'Service Types')

@section('content')

<main id="mainContent" class="admin-page-shell page-enter mode-list">

    <div class="page-banner">
        <div class="page-banner-inner">
            <div>
                <h1 class="page-title">Service Types</h1>
            </div>

            <div class="admin-banner-actions">
                <span class="admin-banner-pill" id="serviceActiveCountPill">
                    Active Services: <span data-service-count>{{ $services->count() }}</span>
                </span>
            </div>
        </div>
    </div>

    <div class="admin-page-body">

        <div class="content-lift">
            <div class="main-grid">

                <div class="admin-stack">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-left">
                                <div class="card-header-icon"><i class="fa-solid fa-plus"></i></div>
                                <span class="card-title">Add New Service</span>
                            </div>
                        </div>

                        <div class="admin-card-pad">
                            <form id="addServiceForm" method="POST" action="{{ route('admin.service-types.store') }}"
                                data-global-validation novalidate>
                                @csrf

                                <div class="global-form-group" data-global-field>
                                    <label for="serviceNameInput" class="global-form-label">
                                        Service Name
                                        <span class="required-mark">*</span>
                                    </label>

                                    <div class="voice-search-row" data-voice-field>
                                        <div class="global-control-wrap" data-clearable-field>
                                            <i class="fa-solid fa-tag global-control-icon"></i>

                                            <input type="text" id="serviceNameInput" name="name"
                                                value="{{ old('name') }}"
                                                class="form-input-custom global-control-with-icon no-voice"
                                                placeholder="e.g. Tooth Extraction" autocomplete="off" required
                                                data-clearable-input>

                                            <button type="button" id="serviceNameClearBtn"
                                                class="search-clear field-clear-btn" data-field-clear
                                                aria-label="Clear service name" title="Clear service name">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>

                                        <div class="voice-input-toggle">
                                            <button type="button" class="voice-search-mic external" data-voice-trigger
                                                data-voice-target="#serviceNameInput"
                                                data-voice-status="#serviceNameVoiceStatus"
                                                aria-label="Voice input for service name">
                                                <i class="fa-solid fa-microphone"></i>
                                            </button>

                                            <span id="serviceNameVoiceStatus" class="voice-status hidden"
                                                data-voice-status aria-live="polite"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="global-form-group" data-global-field>
                                    <div class="global-label-row">
                                        <label for="serviceDescInput" class="global-form-label">
                                            Description (Optional)
                                        </label>

                                        <div class="global-label-meta">
                                            <button type="button" class="service-copy-bullet-box" data-copy-bullet>

                                                <span class="service-copy-bullet-symbol">
                                                    •
                                                </span>

                                                <span class="service-copy-bullet-label">
                                                    Copy this bullet
                                                </span>
                                            </button>

                                            <span id="serviceDescCount" class="char-counter">
                                                0 / 255 characters
                                            </span>
                                        </div>
                                    </div>

                                    <div class="voice-search-row" data-voice-field>
                                        <div class="global-control-wrap global-form-textarea-wrap" data-clearable-field>
                                            <textarea id="serviceDescInput" name="description"
                                                class="form-input-custom global-form-textarea no-voice"
                                                placeholder="Brief details about the service..." maxlength="255"
                                                data-char-limit="255" data-char-counter="#serviceDescCount"
                                                data-clearable-input>{{ old('description') }}</textarea>

                                            <button type="button" id="serviceDescClearBtn"
                                                class="search-clear field-clear-btn field-clear-btn--textarea"
                                                data-field-clear aria-label="Clear description"
                                                title="Clear description">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>

                                        <div class="voice-input-toggle">
                                            <button type="button" class="voice-search-mic external" data-voice-trigger
                                                data-voice-target="#serviceDescInput"
                                                data-voice-status="#serviceDescVoiceStatus"
                                                aria-label="Voice input for service description">
                                                <i class="fa-solid fa-microphone"></i>
                                            </button>

                                            <span id="serviceDescVoiceStatus" class="voice-status hidden"
                                                data-voice-status aria-live="polite"></span>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="ui-btn ui-btn-primary">

                                    <i class="fa-solid fa-floppy-disk"></i>
                                    <span>Save Service</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="admin-stack">
                    <div class="card">
                        <div class="card-header service-list-card-header">
                            <div class="card-header-left">
                                <div class="card-header-icon"><i class="fa-solid fa-list-check"></i></div>
                                <span class="card-title">Existing Services</span>
                            </div>

                            <div class="service-card-header-actions">
                                <span class="entry-badge" id="serviceEntryCountBadge">
                                    {{ $services->count() }} {{ Str::plural('Item', $services->count()) }}
                                </span>

                                <x-view-toggle id="serviceTypeViewToggle" class="service-type-view-toggle"
                                    storage-key="serviceTypeView" list-view="#serviceTypeListView"
                                    grid-view="#serviceTypeGridView" />
                            </div>
                        </div>

                        <div class="service-type-view" id="serviceTypeListView">
                            <div class="admin-scroll-x">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th class="service-col-id">ID</th>
                                            <th class="service-col-name">Service Name</th>
                                            <th>Description</th>
                                            <th class="service-col-visibility">Booking Visibility</th>
                                            <th class="service-col-action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="serviceTypeTableBody">
                                        @forelse($services as $service)
                                        <tr>
                                            <td><span class="service-badge">#{{ $service->id }}</span></td>
                                            <td>
                                                <div class="service-name-cell">
                                                    <div class="service-name-icon">
                                                        <i class="fa-solid fa-tooth"></i>
                                                    </div>
                                                    <span class="service-name-text">
                                                        {{ $service->name }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="service-desc-cell">
                                                {{ $service->description ?: '—' }}
                                            </td>
                                            <td class="service-center-cell">
                                                <div class="service-visibility-actions">
                                                    @if ($service->is_active_for_booking)
                                                    <span class="service-visibility-badge is-visible">
                                                        <i class="fa-solid fa-thumbtack"></i> Visible
                                                    </span>
                                                    @else
                                                    <span class="service-visibility-badge is-hidden">
                                                        <i class="fa-solid fa-eye-slash"></i> Hidden
                                                    </span>
                                                    @endif

                                                    @if ($service->is_default)
                                                    <span class="service-badge service-badge-bookable">
                                                        Default
                                                    </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="service-center-cell">
                                                <div class="service-inline-actions ui-action-group">
                                                    <button type="button" class="ui-action-btn ui-action-edit"
                                                        data-tooltip="Manage service" aria-label="Manage service"
                                                        onclick="openManageServiceModal(
        '{{ route('admin.service-types.update', $service->id) }}',
        @js($service->name),
        @js($service->description),
        {{ $service->is_active_for_booking ? 'true' : 'false' }},
        {{ $service->is_default ? 'true' : 'false' }}
    )">

                                                        <i class="fa-solid fa-pen"></i>
                                                    </button>

                                                    @if (!$service->is_default)
                                                    <button type="button" class="ui-action-btn ui-action-delete"
                                                        data-tooltip="Delete service" aria-label="Delete service"
                                                        onclick="openDeleteModal(
        '{{ route('admin.service-types.destroy', $service->id) }}',
        '{{ addslashes($service->name) }}'
    )">

                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5">
                                                <div class="empty-state">
                                                    <div class="empty-icon"><i class="fa-solid fa-folder-open"></i>
                                                    </div>
                                                    <p class="service-empty-title">
                                                        No services found
                                                    </p>
                                                    <p class="service-empty-subtitle">
                                                        Your clinic doesn't have any service types yet. Use the form
                                                        to
                                                        add
                                                        one.
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="service-type-view" id="serviceTypeGridView" hidden>
                            @if ($services->count())
                            <div class="service-types-grid" id="serviceTypeGridContainer">
                                @foreach ($services as $service)
                                <div class="service-type-card">
                                    <div class="service-type-card-top">
                                        <span class="service-badge service-type-card-id">#{{ $service->id }}</span>

                                        @if ($service->is_default)
                                        <span class="service-badge service-badge-bookable">
                                            Default
                                        </span>
                                        @endif
                                    </div>

                                    <div class="service-type-card-name-wrap">
                                        <div class="service-type-card-icon">
                                            <i class="fa-solid fa-tooth"></i>
                                        </div>
                                        <div class="service-type-card-name">{{ $service->name }}</div>
                                    </div>

                                    <div class="service-type-card-desc-wrap">
                                        <div class="service-type-card-label">Description</div>
                                        <div class="service-type-card-desc">
                                            {{ $service->description ?: '—' }}
                                        </div>
                                    </div>

                                    <div class="service-type-card-footer">
                                        <div class="service-card-actions">
                                            @if ($service->is_active_for_booking)
                                            <span class="service-visibility-badge is-visible">
                                                <i class="fa-solid fa-thumbtack"></i> Visible
                                            </span>
                                            @else
                                            <span class="service-visibility-badge is-hidden">
                                                <i class="fa-solid fa-eye-slash"></i> Hidden
                                            </span>
                                            @endif
                                        </div>

                                        <div class="service-type-card-actions ui-action-group">
                                            <button type="button" class="ui-action-btn ui-action-edit"
                                                data-tooltip="Manage service" aria-label="Manage service" onclick="openManageServiceModal(
            '{{ route('admin.service-types.update', $service->id) }}',
            @js($service->name),
            @js($service->description),
            {{ $service->is_active_for_booking ? 'true' : 'false' }},
            {{ $service->is_default ? 'true' : 'false' }}
        )">

                                                <i class="fa-solid fa-pen"></i>
                                            </button>

                                            @if (!$service->is_default)
                                            <button type="button" class="ui-action-btn ui-action-delete"
                                                data-tooltip="Delete service" aria-label="Delete service" onclick="openDeleteModal(
        '{{ route('admin.service-types.destroy', $service->id) }}',
        '{{ addslashes($service->name) }}'
    )">

                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fa-solid fa-folder-open"></i></div>
                                <p class="service-empty-title">
                                    No services found
                                </p>
                                <p class="service-empty-subtitle">
                                    Your clinic doesn't have any service types yet. Use the form to add one.
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<x-delete-confirm-modal id="deleteServiceModal" form-id="deleteServiceForm" name-id="deleteServiceName"
    title="Delete Service Type" helper="This service type will be permanently removed." />

<div class="ui-modal modal-theme-edit" id="manageServiceModal" aria-hidden="true">
    <form id="manageServiceForm" method="POST" class="ui-modal-card modal-lg" role="dialog" aria-modal="true"
        aria-labelledby="manageServiceTitle" data-global-validation data-discard-form
        data-discard-title="Discard service changes?" data-discard-subtitle="You have unsaved service updates."
        data-discard-message="Closing this modal will remove your changes to this service. Do you want to discard them?"
        novalidate onclick="event.stopPropagation()">
        @csrf
        @method('PUT')

        <div class="modal-hd">
            <div class="modal-heading">
                <div class="modal-icon">
                    <i class="fa-solid fa-pen"></i>
                </div>

                <div class="modal-copy">
                    <h3 class="modal-title" id="manageServiceTitle">
                        Manage Service Type
                    </h3>

                    <p class="modal-subtitle">
                        Update service details and booking visibility
                    </p>
                </div>
            </div>

            <button type="button" class="modal-x" data-discard-close="manageServiceModal" aria-label="Close modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="modal-bd">
            <div class="modal-form-grid-2">

                <div class="global-form-group" data-global-field>
                    <label for="manageServiceName" class="global-form-label">
                        Service Name
                        <span class="required-mark">*</span>
                    </label>

                    <div class="voice-search-row" data-voice-field>
                        <div class="global-control-wrap">
                            <i class="fa-solid fa-tag global-control-icon"></i>

                            <input type="text" id="manageServiceName" name="name"
                                class="form-input-custom global-control-with-icon no-voice" maxlength="255"
                                autocomplete="off" required>
                        </div>

                        <div class="voice-input-toggle">
                            <button type="button" class="voice-search-mic external" data-voice-trigger
                                data-voice-target="#manageServiceName" data-voice-status="#manageServiceNameVoiceStatus"
                                aria-label="Voice input for service name">
                                <i class="fa-solid fa-microphone"></i>
                            </button>

                            <span id="manageServiceNameVoiceStatus" class="voice-status hidden" data-voice-status
                                aria-live="polite"></span>
                        </div>
                    </div>
                </div>

                <div class="global-form-group" data-global-field>
                    <div class="global-label-row">
                        <label for="manageServiceDescription" class="global-form-label">
                            Description
                        </label>

                        <div class="global-label-meta">
                            <button type="button" class="service-copy-bullet-box" data-copy-bullet>

                                <span class="service-copy-bullet-symbol">
                                    •
                                </span>

                                <span class="service-copy-bullet-label">
                                    Copy this bullet
                                </span>
                            </button>

                            <span id="manageServiceDescCount" class="char-counter">
                                0 / 255 characters
                            </span>
                        </div>
                    </div>

                    <div class="voice-search-row" data-voice-field>
                        <div class="global-form-textarea-wrap">
                            <textarea id="manageServiceDescription" name="description"
                                class="form-input-custom global-form-textarea no-voice" maxlength="255"
                                data-char-limit="255" data-char-counter="#manageServiceDescCount"
                                placeholder="Brief details about the service..."></textarea>
                        </div>

                        <div class="voice-input-toggle">
                            <button type="button" class="voice-search-mic external" data-voice-trigger
                                data-voice-target="#manageServiceDescription"
                                data-voice-status="#manageServiceDescVoiceStatus"
                                aria-label="Voice input for service description">
                                <i class="fa-solid fa-microphone"></i>
                            </button>

                            <span id="manageServiceDescVoiceStatus" class="voice-status hidden" data-voice-status
                                aria-live="polite"></span>
                        </div>
                    </div>
                </div>

                <div class="field-group full">
                    <div class="service-booking-row">
                        <div class="service-booking-copy">
                            <div class="service-booking-icon">
                                <i class="fa-solid fa-thumbtack"></i>
                            </div>

                            <div>
                                <p class="service-booking-title">
                                    Show in Book Appointment
                                </p>

                                <p class="service-booking-description">
                                    Turn this off to hide the service from booking
                                    while keeping it in Service Types.
                                </p>
                            </div>
                        </div>

                        <label class="global-switch">
                            <input type="checkbox" id="manageServiceBookingToggle" name="is_active_for_booking"
                                value="1" class="global-switch-input" aria-label="Show service in Book Appointment">

                            <span class="global-switch-track" aria-hidden="true"></span>
                        </label>
                    </div>

                    <div id="manageDefaultNote" class="modal-helper-text">
                        This is a default service type. It can be edited
                        and hidden from booking, but it cannot be deleted.
                    </div>
                </div>

            </div>
        </div>

        <div class="modal-ft">
            <button type="button" class="ui-btn ui-btn-secondary" data-discard-close="manageServiceModal">
                Cancel
            </button>

            <button type="submit" class="ui-btn ui-btn-edit">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Save Changes</span>
            </button>
        </div>
    </form>
</div>
@endsection

@php
$serviceTypePayload = $services
->map(function ($service) {
return [
'id' => $service->id,
'name' => $service->name,
'description' => $service->description,
'is_active_for_booking' => (bool) $service->is_active_for_booking,
'is_default' => (bool) $service->is_default,
];
})
->values()
->toArray();

$serviceTypeUpdateRoute = route('admin.service-types.update', 0);
$serviceTypeDestroyRoute = route('admin.service-types.destroy', 0);

$serviceTypeRoutes = [
'update' => preg_replace('/0$/', '__SERVICE_ID__', $serviceTypeUpdateRoute),
'destroy' => preg_replace('/0$/', '__SERVICE_ID__', $serviceTypeDestroyRoute),
];
@endphp

@section('scripts')
<script>
    function copyTextToClipboard(text) {
        if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(text);
        }

        return new Promise((resolve, reject) => {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.setAttribute('readonly', '');
            textarea.style.position = 'fixed';
            textarea.style.left = '-9999px';
            textarea.style.top = '-9999px';

            document.body.appendChild(textarea);
            textarea.select();

            try {
                document.execCommand('copy');
                resolve();
            } catch (error) {
                reject(error);
            } finally {
                textarea.remove();
            }
        });
    }

    function showServiceToast(
        type,
        title,
        message
    ) {
        if (
            typeof window.showToast ===
            'function'
        ) {
            window.showToast({
                type,
                title,
                message
            });

            return;
        }

        console[
            type === 'error'
                ? 'error'
                : 'log'
        ](`${title}: ${message}`);
    }

    function initServiceBulletCopy() {
        document.querySelectorAll('[data-copy-bullet]').forEach((button) => {
            if (button.dataset.copyInitialized === 'true') return;

            button.dataset.copyInitialized = 'true';

            const label =
                button.querySelector('.service-copy-bullet-label');
            const originalText = label?.textContent || 'Copy this bullet';

            button.addEventListener('click', async () => {
                try {
                    await copyTextToClipboard('•');

                    button.classList.add('copied');

                    if (label) {
                        label.textContent = 'Copied';
                    }

                    showServiceToast(
                        'success',
                        'Copied',
                        'Bullet copied. You can now paste it in the description.'
                    );

                    setTimeout(() => {
                        button.classList.remove('copied');

                        if (label) {
                            label.textContent = originalText;
                        }
                    }, 1400);
                } catch (error) {
                    showServiceToast(
                        'error',
                        'Copy failed',
                        'Unable to copy bullet.'
                    );

                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', initServiceBulletCopy);

    (() => {
        const initialServices = @json($serviceTypePayload);

        let serviceTypeServices = Array.isArray(initialServices) ? [...initialServices] : [];

        const routes = @json($serviceTypeRoutes);

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ||
            document.querySelector('input[name="_token"]')?.value ||
            '';

        const escapeHtml = (value = '') => String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');

        const normalizeService = (service) => ({
            id: Number(service.id),
            name: service.name || '',
            description: service.description || '',
            is_active_for_booking: Boolean(service.is_active_for_booking),
            is_default: Boolean(service.is_default),
        });

        const serviceUpdateUrl = (id) => routes.update.replace('__SERVICE_ID__', encodeURIComponent(
            id));
        const serviceDestroyUrl = (id) => routes.destroy.replace('__SERVICE_ID__', encodeURIComponent(
            id));

        function sortServices() {
            serviceTypeServices.sort((a, b) => String(a.name).localeCompare(String(b.name)));
        }

        function servicePlural(count) {
            return count === 1 ? 'Item' : 'Items';
        }

        function updateServiceCounts() {
            const count = serviceTypeServices.length;
            document.querySelectorAll('[data-service-count]').forEach((node) => {
                node.textContent = count;
            });

            const entryBadge = document.getElementById('serviceEntryCountBadge');
            if (entryBadge) {
                entryBadge.textContent = `${count} ${servicePlural(count)}`;
            }
        }

        function visibilityBadge(service) {
            return service.is_active_for_booking ?
                `<span class="service-visibility-badge is-visible"><i class="fa-solid fa-thumbtack"></i> Visible</span>` :
                `<span class="service-visibility-badge is-hidden"><i class="fa-solid fa-eye-slash"></i> Hidden</span>`;
        }

        function defaultBadge(service) {
            return service.is_default ?
                `<span class="service-badge service-badge-bookable">Default</span>` :
                '';
        }

        function actionButtons(service) {
            const deleteButton = service.is_default ? '' : `
        <button type="button"
            class="ui-action-btn ui-action-delete"
            data-tooltip="Delete service"
            aria-label="Delete service"
            data-service-action="delete"
            data-service-id="${service.id}">

            <i class="fa-solid fa-trash"></i>
        </button>
    `;

            return `
        <button type="button"
            class="ui-action-btn ui-action-edit"
            data-tooltip="Manage service"
            aria-label="Manage service"
            data-service-action="edit"
            data-service-id="${service.id}">

            <i class="fa-solid fa-pen"></i>
        </button>

        ${deleteButton}
    `;
        }

        function emptyStateHtml() {
            return `
            <div class="empty-state">
                <div class="empty-icon"><i class="fa-solid fa-folder-open"></i></div>
                <p class="service-empty-title">No services found</p>
                <p class="service-empty-subtitle">
                    Your clinic doesn't have any service types yet. Use the form to add one.
                </p>
            </div>`;
        }

        function renderServiceTable() {
            const tbody = document.getElementById('serviceTypeTableBody');
            if (!tbody) return;

            if (!serviceTypeServices.length) {
                tbody.innerHTML = `<tr><td colspan="5">${emptyStateHtml()}</td></tr>`;
                return;
            }

            tbody.innerHTML = serviceTypeServices.map((service) => `
            <tr data-service-id="${service.id}">
                <td><span class="service-badge">#${service.id}</span></td>
                <td>
                    <div class="service-name-cell">
                        <div class="service-name-icon">
                            <i class="fa-solid fa-tooth"></i>
                        </div>
                        <span class="service-name-text">${escapeHtml(service.name)}</span>
                    </div>
                </td>
                <td class="service-desc-cell">${service.description ? escapeHtml(service.description) : '—'}</td>
                <td class="service-center-cell">
                    <div class="service-visibility-actions">
                        ${visibilityBadge(service)}
                        ${defaultBadge(service)}
                    </div>
                </td>
                <td class="service-center-cell">
                    <div class="service-inline-actions ui-action-group">
    ${actionButtons(service)}
</div>
                </td>
            </tr>
        `).join('');
        }

        function renderServiceGrid() {
            const gridView = document.getElementById('serviceTypeGridView');
            if (!gridView) return;

            if (!serviceTypeServices.length) {
                gridView.innerHTML = emptyStateHtml();
                return;
            }

            gridView.innerHTML = `
            <div class="service-types-grid" id="serviceTypeGridContainer">
                ${serviceTypeServices.map((service) => `
                                                        <div class="service-type-card" data-service-id="${service.id}">
                                                            <div class="service-type-card-top">
                                                                <span class="service-badge service-type-card-id">#${service.id}</span>
                                                                ${defaultBadge(service)}
                                                            </div>

                                                            <div class="service-type-card-name-wrap">
                                                                <div class="service-type-card-icon">
                                                                    <i class="fa-solid fa-tooth"></i>
                                                                </div>
                                                                <div class="service-type-card-name">${escapeHtml(service.name)}</div>
                                                            </div>

                                                            <div class="service-type-card-desc-wrap">
                                                                <div class="service-type-card-label">Description</div>
                                                                <div class="service-type-card-desc">
                                                                    ${service.description ? escapeHtml(service.description) : '—'}
                                                                </div>
                                                            </div>

                                                            <div class="service-type-card-footer">
                                                                <div class="service-card-actions">
                                                                    ${visibilityBadge(service)}
                                                                </div>

                                                                <div class="service-type-card-actions ui-action-group">
                                                                    ${actionButtons(service)}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    `).join('')}
            </div>`;
        }

        function renderServices() {
            sortServices();
            updateServiceCounts();
            renderServiceTable();
            renderServiceGrid();
        }

        function firstValidationMessage(data, fallback = 'Please check the form and try again.') {
            const errors = data?.errors || {};
            const firstKey = Object.keys(errors)[0];

            if (firstKey && Array.isArray(errors[firstKey]) && errors[firstKey][0]) {
                return errors[firstKey][0];
            }

            return data?.message || fallback;
        }

        async function parseJsonResponse(response) {
            const contentType = response.headers.get('content-type') || '';

            if (contentType.includes('application/json')) {
                return response.json();
            }

            return {
                success: false,
                message: 'The server returned an unexpected response. Please check your route or controller.',
            };
        }

        function setButtonLoading(button, isLoading, loadingText = 'Saving...') {
            if (!button) return;

            if (isLoading) {
                button.dataset.originalHtml = button.innerHTML;
                button.disabled = true;
                button.innerHTML = `<i class="fa-solid fa-spinner spin"></i> ${loadingText}`;
                return;
            }

            button.disabled = false;

            if (button.dataset.originalHtml) {
                button.innerHTML = button.dataset.originalHtml;
                delete button.dataset.originalHtml;
            }
        }

        async function submitJson(form, submitButton, loadingText = 'Saving...') {
            setButtonLoading(submitButton, true, loadingText);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        ...(csrfToken ? {
                            'X-CSRF-TOKEN': csrfToken
                        } : {}),
                    },
                    body: new FormData(form),
                });

                const data = await parseJsonResponse(response);

                if (!response.ok || data.success === false) {
                    throw data;
                }

                return data;
            } finally {
                setButtonLoading(submitButton, false);
            }
        }

        function addOrUpdateService(service) {
            const normalized = normalizeService(service);
            const existingIndex = serviceTypeServices.findIndex((item) => Number(item.id) ===
                Number(normalized
                    .id));

            if (existingIndex >= 0) {
                serviceTypeServices[existingIndex] = normalized;
            } else {
                serviceTypeServices.push(normalized);
            }

            renderServices();
        }

        function removeService(id) {
            serviceTypeServices = serviceTypeServices.filter((service) => Number(service.id) !==
                Number(id));
            renderServices();
        }

        window.openManageServiceById = function (id) {
            const service = serviceTypeServices.find((item) => Number(item.id) === Number(id));

            if (!service) {
                showServiceToast('error', 'Service not found',
                    'Unable to find the selected service.');
                return;
            }

            window.openManageServiceModal(
                serviceUpdateUrl(service.id),
                service.name,
                service.description,
                service.is_active_for_booking,
                service.is_default,
                service.id
            );
        };

        window.openDeleteServiceById = function (id) {
            const service = serviceTypeServices.find((item) => Number(item.id) === Number(id));

            if (!service) {
                showServiceToast('error', 'Service not found',
                    'Unable to find the selected service.');
                return;
            }

            window.openDeleteModal(serviceDestroyUrl(service.id), service.name, service.id);
        };

        window.openDeleteModal = function (
            actionUrl,
            serviceName,
            serviceId = null
        ) {
            const form =
                window.openDeleteConfirmModal?.({
                    modalId:
                        'deleteServiceModal',

                    formId:
                        'deleteServiceForm',

                    nameId:
                        'deleteServiceName',

                    action:
                        actionUrl,

                    itemName:
                        serviceName,

                    recordId:
                        serviceId,
                });

            if (!form) return;

            form.dataset.serviceId =
                serviceId ||
                String(actionUrl)
                    .split('/')
                    .filter(Boolean)
                    .pop() ||
                '';
        };

        window.openManageServiceModal = function (actionUrl, serviceName, serviceDescription,
            isActiveForBooking,
            isDefault, serviceId = null) {

            const form = document.getElementById('manageServiceForm');
            const nameInput = document.getElementById('manageServiceName');
            const descInput = document.getElementById('manageServiceDescription');
            const bookingToggle = document.getElementById('manageServiceBookingToggle');
            const defaultNote = document.getElementById('manageDefaultNote');

            if (!form || !nameInput || !descInput || !bookingToggle || !defaultNote) {
                console.error('Manage modal elements not found.');
                return;
            }

            form.action = actionUrl;
            form.dataset.serviceId = serviceId || String(actionUrl).split('/').filter(Boolean)
                .pop() || '';

            nameInput.value = serviceName ?? '';
            descInput.value = serviceDescription ?? '';

            window.initCharLimitFields?.(
                document.getElementById(
                    'manageServiceModal'
                )
            );

            descInput.dispatchEvent(
                new Event('input', {
                    bubbles: true
                })
            );

            bookingToggle.checked = Boolean(isActiveForBooking);

            defaultNote.classList.toggle('admin-hidden', !isDefault);
            defaultNote.style.display = isDefault ? 'block' : 'none';

            window.openModal('manageServiceModal');

            setTimeout(() => {
                nameInput.focus();
            }, 180);
        };

        function showServiceFormErrors(
            form,
            response
        ) {
            const errors =
                response?.errors || {};

            Object.entries(errors)
                .forEach(([name, messages]) => {
                    const field =
                        form.querySelector(
                            `[name="${CSS.escape(name)}"]`
                        );

                    if (!field) return;

                    const message =
                        Array.isArray(messages) ?
                            messages[0] :
                            messages;

                    window
                        .showFormInputValidationMessage
                        ?.(field, String(message || ''));
                });
        }

        function bindAjaxForms() {
            const addForm = document.getElementById('addServiceForm');
            const manageForm = document.getElementById('manageServiceForm');
            const deleteForm = document.getElementById('deleteServiceForm');

            addForm?.addEventListener(
                'submit',
                async event => {
                    event.preventDefault();

                    const validation =
                        window.validateGlobalForm?.(addForm);

                    if (
                        validation &&
                        !validation.valid
                    ) {
                        return;
                    }

                    const submitButton =
                        addForm.querySelector(
                            '[type="submit"]'
                        );

                    try {
                        const data = await submitJson(
                            addForm,
                            submitButton,
                            'Saving...'
                        );

                        addOrUpdateService(data.service);

                        addForm.reset();

                        requestAnimationFrame(() => {
                            addForm
                                .querySelectorAll(
                                    '[data-clearable-input]'
                                )
                                .forEach(field => {
                                    field.dispatchEvent(
                                        new Event('input', {
                                            bubbles: true
                                        })
                                    );
                                });
                        });

                        document
                            .getElementById(
                                'serviceNameInput'
                            )
                            ?.classList.remove(
                                'is-valid',
                                'is-invalid'
                            );

                        document
                            .getElementById(
                                'serviceDescInput'
                            )
                            ?.classList.remove(
                                'is-valid',
                                'is-invalid'
                            );

                        showServiceToast(
                            'success',
                            'Service added',
                            data.service
                                ?.is_active_for_booking ?
                                'Patients can now select it when booking.' :
                                'Saved in Service Types and hidden from booking.'
                        );
                    } catch (error) {
                        showServiceFormErrors(
                            addForm,
                            error
                        );

                        showServiceToast(
                            'error',
                            'Add failed',
                            firstValidationMessage(
                                error,
                                'Unable to add service type.'
                            )
                        );
                    }
                },
                true
            );

            manageForm?.addEventListener('submit', async (event) => {
                event.preventDefault();
                const validation =
                    window.validateGlobalForm?.(manageForm);

                if (validation && !validation.valid) {
                    return;
                }
                const submitButton = manageForm.querySelector('[type="submit"]');

                try {
                    const data = await submitJson(manageForm, submitButton, 'Saving...');
                    addOrUpdateService(data.service);
                    window.closeModal('manageServiceModal');
                    showServiceToast(
                        'success',
                        'Changes saved',
                        'Service details and booking visibility updated.'
                    );
                } catch (error) {
                    showServiceToast('error', 'Update failed', firstValidationMessage(error,
                        'Unable to update service type.'));
                }
            });

            deleteForm?.addEventListener('submit', async (event) => {
                event.preventDefault();

                const submitButton = deleteForm.querySelector('[type="submit"]');

                try {
                    const data = await submitJson(deleteForm, submitButton, 'Deleting...');
                    removeService(data.deleted_id || deleteForm.dataset.serviceId);
                    window.closeModal('deleteServiceModal');
                    showServiceToast(
                        'success',
                        'Service deleted',
                        'Removed from the service list.'
                    );
                } catch (error) {
                    showServiceToast('error', 'Delete failed', firstValidationMessage(error,
                        'Unable to delete service type.'));
                }
            });
        }

        document.addEventListener('click', (event) => {
            const button = event.target.closest('[data-service-action]');
            if (!button) return;

            const id = button.dataset.serviceId;

            if (button.dataset.serviceAction === 'edit') {
                window.openManageServiceById(id);
            }

            if (button.dataset.serviceAction === 'delete') {
                window.openDeleteServiceById(id);
            }
        });

        function initServiceTypesPage() {
            renderServices();
            bindAjaxForms();
        }

        if (
            document.readyState ===
            'loading'
        ) {
            document.addEventListener(
                'DOMContentLoaded',
                initServiceTypesPage,
                {
                    once: true
                }
            );
        } else {
            initServiceTypesPage();
        }

    })();
</script>
@endsection