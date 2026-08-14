@extends('layouts.app')

@section('layout-role', 'admin')

@section('title', 'Document Templates')

@section('content')

<main id="mainContent" class="admin-page-shell document-templates-page page-enter">
    <div class="w-full">
        <section class="page-banner document-template-banner">
            <div class="page-banner-inner">
                <div>
                    <div class="page-greeting">
                        <i class="fa-solid fa-file-shield"></i>
                        Template Management
                    </div>
                    <h1 class="page-title">Document Templates</h1>
                    <p class="page-subtitle">Manage default printable templates used by the dental clinic.</p>
                </div>

                <div class="admin-banner-actions">
                    <span class="admin-banner-pill">
                        <i class="fa-solid fa-lock"></i>
                        Default templates only
                    </span>
                </div>
            </div>
        </section>

        @php
        $stats = $stats ?? [];
        $totalTemplates = $stats['total'] ?? 0;
        $activeTemplates = $stats['active'] ?? 0;
        $archivedTemplates = $stats['archived'] ?? 0;
        @endphp

        <section class="stat-grid" id="statCards" aria-label="Template summary">
            <article class="stat-card s-all" data-template-stat="total">
                <div class="stat-icon-wrapper">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div class="stat-card-info">
                    <div class="stat-num" id="templateTotalStat">{{ $totalTemplates }}</div>
                    <div class="stat-label">Total Templates</div>
                </div>
            </article>

            <article class="stat-card s-active" data-template-stat="active">
                <div class="stat-icon-wrapper">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="stat-card-info">
                    <div class="stat-num" id="templateActiveStat">{{ $activeTemplates }}</div>
                    <div class="stat-label">Active</div>
                </div>
            </article>

            <article class="stat-card s-archived" data-template-stat="archived">
                <div class="stat-icon-wrapper">
                    <i class="fa-solid fa-box-archive"></i>
                </div>
                <div class="stat-card-info">
                    <div class="stat-num" id="templateArchivedStat">{{ $archivedTemplates }}</div>
                    <div class="stat-label">Archived</div>
                </div>
            </article>
        </section>

        <section class="table-card" aria-label="Template filters">
            <div class="table-toolbar">

                <div class="table-toolbar-actions">

                    <div class="voice-search-row table-toolbar-search">
                        <x-search-bar id="templateSearch" placeholder="Search templates..."
                            clear-label="Clear template search" />

                        <x-voice-input target="#templateSearch" status-id="templateVoiceStatus"
                            label="Voice search document templates" title="Voice search" />
                    </div>

                    <button id="templateFilterBtn" type="button" class="global-filter-btn"
                        onclick="openTemplateFilterDrawer()">
                        <i class="fa-solid fa-sliders"></i>
                        <span>Filter</span>

                        <span id="templateFilterBadge" class="filter-badge"></span>
                    </button>

                    <button id="templateFilterResetBtn" type="button" class="global-filter-reset-btn hidden"
                        onclick="resetTemplateFilters()" aria-label="Clear template filters">
                        <i class="fa-solid fa-rotate-left"></i>
                    </button>

                </div>

            </div>
        </section>

        <div id="templateResultsRegion">
            @if (empty($templates) || $templates->isEmpty())
            <section class="section-card template-empty-card">
                <div id="templateBaseEmptyState" class="empty-state-host"></div>
            </section>
            @else
            <section class="templates-grid" id="templatesGrid" aria-label="Document template cards">
                @foreach ($templates as $tpl)
                @php
                $category = strtolower(trim((string) ($tpl->category ?? '')));
                $dt = strtolower((string) ($tpl->document_type ?? ''));

                if ($category === '') {
                if (str_contains($dt, 'clearance')) {
                $category = 'clearance';
                } elseif (str_contains($dt, 'record')) {
                $category = 'record';
                } elseif (str_contains($dt, 'report')) {
                $category = 'report';
                } elseif (str_contains($dt, 'inventory')) {
                $category = 'inventory';
                } else {
                $category = 'other';
                }
                }

                if (!in_array($category, ['clearance', 'record', 'report', 'inventory'], true)) {
                $category = 'other';
                }

                $templateCode = $tpl->code ?? 'TPL-' . str_pad($tpl->id, 4, '0', STR_PAD_LEFT);
                $statusClass = $tpl->status === 'active' ? 'status-active' : 'status-archived';
                @endphp

                <article class="template-card status-{{ $tpl->status }}" data-id="{{ $tpl->id }}"
                    data-name="{{ strtolower((string) $tpl->name) }}"
                    data-type="{{ strtolower((string) $tpl->document_type) }}" data-category="{{ $category }}"
                    data-status="{{ $tpl->status }}" data-template-name="{{ e($tpl->name) }}"
                    data-archive-url="{{ route('admin.document-template.archive', $tpl->id) }}"
                    data-activate-url="{{ route('admin.document-template.activate', $tpl->id) }}" tabindex="0"
                    role="button" aria-label="Preview {{ $tpl->name }}" onclick="openTemplatePreview({{ $tpl->id }})">
                    <div class="template-card-top">
                        <div class="template-top-row">
                            <div class="template-doc-icon">
                                @if ($category === 'clearance')
                                <i class="fa-solid fa-file-circle-check"></i>
                                @elseif($category === 'record')
                                <i class="fa-solid fa-folder-open"></i>
                                @elseif($category === 'report')
                                <i class="fa-solid fa-chart-line"></i>
                                @elseif($category === 'inventory')
                                <i class="fa-solid fa-boxes-stacked"></i>
                                @else
                                <i class="fa-solid fa-file-lines"></i>
                                @endif
                            </div>

                            <div class="template-badge-stack">
                                <span class="status-badge {{ $statusClass }}" data-template-status-badge>
                                    {{ ucfirst($tpl->status) }}
                                </span>

                                @if ($tpl->is_default)
                                <span class="status-badge status-default" data-template-default-badge>
                                    Default
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="template-title-block">
                            <h2 class="template-name">{{ $tpl->name }}</h2>
                            <div class="template-code">{{ $templateCode }}</div>
                        </div>
                    </div>

                    <div class="template-card-body">
                        <p class="template-description">
                            {{ $tpl->description ?? ($tpl->notes ?? 'Default system template.') }}
                        </p>

                        <div class="template-meta-row">
                            <span class="template-meta-item">
                                <i class="fa-solid fa-tag template-meta-icon"></i>
                                <span>{{ ucwords(str_replace('_', ' ', $tpl->document_type)) }}</span>
                            </span>

                            <div class="template-actions" data-template-actions>
                                <button type="button" class="ui-action-btn ui-action-view"
                                    data-tooltip="Preview template" data-tooltip-tone="view"
                                    aria-label="Preview template"
                                    onclick="event.stopPropagation(); openTemplatePreview({{ $tpl->id }})">
                                    <i class="fa-solid fa-eye"></i>
                                </button>

                                @if ($tpl->status === 'active')
                                <button type="button" class="ui-action-btn ui-action-warning"
                                    data-tooltip="Archive template" aria-label="Archive template"
                                    data-template-action="archive" data-template-id="{{ $tpl->id }}"
                                    onclick="event.stopPropagation(); window.handleTemplateActionClick(this)">
                                    <i class="fa-solid fa-box-archive"></i>
                                </button>
                                @elseif ($tpl->status === 'archived')
                                <button type="button" class="ui-action-btn ui-action-success"
                                    data-tooltip="Activate template" aria-label="Activate template"
                                    data-template-action="activate" data-template-id="{{ $tpl->id }}"
                                    onclick="event.stopPropagation(); window.handleTemplateActionClick(this)">
                                    <i class="fa-solid fa-circle-check"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </section>

            <section id="templateClientEmpty" class="section-card template-empty-card template-client-empty" hidden>
                <div id="templateDynamicEmptyState" class="empty-state-host"></div>
            </section>
            @endif
        </div>

        <x-pagination-bar id="templatePagebar" info-id="templatePageInfo" pagination-id="templatePagination"
            page-size-id="templatePageSize" position="bottom" :show-entries="true" label="templates"
            data-current-page="{{ $templates->currentPage() }}" data-last-page="{{ $templates->lastPage() }}"
            data-total="{{ $templates->total() }}" data-from="{{ $templates->firstItem() ?? 0 }}"
            data-to="{{ $templates->lastItem() ?? 0 }}" data-per-page="{{ $templates->perPage() }}" />

    </div>
</main>

<x-filter-drawer id="templateFilterDrawer" title="Template Filters" close-id="closeTemplateFilterDrawer"
    close-callback="closeTemplateFilterDrawer()" clear-id="clearTemplateFiltersDrawer" clear-label="Clear Filters"
    cancel-id="cancelTemplateFilterDrawer" cancel-callback="closeTemplateFilterDrawer()" cancel-label="Cancel"
    apply-id="applyTemplateFilters" apply-label="Show Results">

    <div id="templateActiveFilters" class="filter-active-section hidden">
        <div class="filter-active-header">

            <span class="filter-active-title">
                Active Filters
            </span>

            <button type="button" id="clearTemplateFilterChips"
                class="filter-clear-all ui-btn ui-btn-secondary ui-btn-sm">
                <i class="fa-solid fa-rotate-left"></i>
                <span>Clear All</span>
            </button>

        </div>

        <div id="templateFilterChips" class="active-filters-container"></div>
    </div>


    <x-filter-group title="Category">

        <div class="filter-chip-row">

            <label class="choice-chip">
                <input type="radio" name="template_filter_category" value="" class="filter-input radio-red chip-radio"
                    checked>

                <span>
                    All Categories
                </span>
            </label>

            <label class="choice-chip">
                <input type="radio" name="template_filter_category" value="clearance"
                    class="filter-input radio-red chip-radio">

                <span>
                    Clearance
                </span>
            </label>

            <label class="choice-chip">
                <input type="radio" name="template_filter_category" value="record"
                    class="filter-input radio-red chip-radio">

                <span>
                    Record
                </span>
            </label>

            <label class="choice-chip">
                <input type="radio" name="template_filter_category" value="report"
                    class="filter-input radio-red chip-radio">

                <span>
                    Report
                </span>
            </label>

            <label class="choice-chip">
                <input type="radio" name="template_filter_category" value="inventory"
                    class="filter-input radio-red chip-radio">

                <span>
                    Inventory
                </span>
            </label>

        </div>

    </x-filter-group>


    <x-filter-group title="Status" class="filter-group-last">

        <div class="filter-chip-row">

            <label class="choice-chip">
                <input type="radio" name="template_filter_status" value="" class="filter-input radio-red chip-radio"
                    checked>

                <span>
                    All Status
                </span>
            </label>

            <label class="choice-chip">
                <input type="radio" name="template_filter_status" value="active"
                    class="filter-input radio-red chip-radio">

                <span>
                    Active
                </span>
            </label>

            <label class="choice-chip">
                <input type="radio" name="template_filter_status" value="archived"
                    class="filter-input radio-red chip-radio">

                <span>
                    Archived
                </span>
            </label>

        </div>

    </x-filter-group>

</x-filter-drawer>

<div id="templatePreviewBackdrop" class="ui-modal modal-theme-primary" aria-hidden="true">

    <div class="ui-modal-card modal-preview-card modal-card-form" role="dialog" aria-modal="true"
        aria-labelledby="templatePreviewTitle">

        <div class="modal-hd">
            <div class="modal-heading">
                <div class="modal-icon">
                    <i class="fa-solid fa-file-lines"></i>
                </div>

                <div class="modal-copy">
                    <h2 id="templatePreviewTitle" class="modal-title">
                        Template Preview
                    </h2>

                    <p id="templatePreviewSubtitle" class="modal-subtitle">
                        Loading...
                    </p>
                </div>
            </div>

            <button type="button" class="modal-x" id="closeTemplatePreview" aria-label="Close preview">

                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="modal-preview-body" data-global-preview-zoom data-preview-min="0.5" data-preview-max="2"
            data-preview-step="0.1">
            <div id="templatePreviewMeta" class="modal-preview-toolbar">
            </div>

            <div class="modal-preview-toolbar">
                <span class="modal-helper-text">
                    Use the controls to adjust the preview size.
                </span>

                <div class="modal-preview-toolbar-actions">
                    <button type="button" id="templateZoomOut" class="ui-action-btn ui-action-neutral"
                        data-preview-zoom-out data-tooltip="Zoom out" aria-label="Zoom out">

                        <i class="fa-solid fa-minus"></i>
                    </button>

                    <span id="templateZoomValue" class="modal-preview-zoom-value" data-preview-zoom-value>
                        100%
                    </span>

                    <button type="button" id="templateZoomIn" class="ui-action-btn ui-action-neutral"
                        data-preview-zoom-in data-tooltip="Zoom in" aria-label="Zoom in">

                        <i class="fa-solid fa-plus"></i>
                    </button>

                    <button type="button" id="templateZoomReset" class="ui-action-btn ui-action-reset"
                        data-preview-zoom-reset data-tooltip="Reset zoom" aria-label="Reset zoom">

                        <i class="fa-solid fa-arrows-rotate"></i>
                    </button>
                </div>
            </div>

            <div class="modal-preview-stage" id="templatePreviewStage" data-preview-stage>

                <div class="modal-preview-canvas" id="templatePreviewCanvas" data-preview-canvas>

                    <iframe id="templatePreviewFrame" class="modal-preview-frame" data-preview-content
                        title="Document template preview" scrolling="no">
                    </iframe>
                </div>
            </div>
        </div>

        <div class="modal-ft" id="templatePreviewFooter">
        </div>
    </div>
</div>

<div id="templateArchiveModal" class="ui-modal modal-theme-warning" aria-hidden="true">

    <div class="ui-modal-card modal-md modal-card-form" role="dialog" aria-modal="true"
        aria-labelledby="templateArchiveTitle">

        <div class="modal-hd">
            <div class="modal-heading">
                <div class="modal-icon">
                    <i class="fa-solid fa-box-archive"></i>
                </div>

                <div class="modal-copy">
                    <h2 id="templateArchiveTitle" class="modal-title">
                        Archive this template?
                    </h2>

                    <p class="modal-subtitle">
                        This template will be hidden from active template lists.
                    </p>
                </div>
            </div>

            <button type="button" class="modal-x" data-close-modal="templateArchiveModal"
                aria-label="Close archive modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="modal-bd">
            <div class="global-confirm-alert">
                <i class="fa-solid fa-file-lines"></i>

                <div>
                    <p>
                        Selected template
                    </p>

                    <strong id="templateArchiveName">
                        Template
                    </strong>
                </div>
            </div>

            <div class="modal-helper-text">
                <i class="fa-solid fa-circle-info"></i>

                <span>
                    You can activate this template again later from the
                    archived templates filter.
                </span>
            </div>
        </div>

        <div class="modal-ft">
            <button type="button" class="ui-btn ui-btn-secondary" data-close-modal="templateArchiveModal">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Keep</span>
            </button>

            <button type="button" class="ui-btn ui-btn-warning" id="confirmTemplateArchiveBtn">
                <i class="fa-solid fa-box-archive"></i>
                <span>Archive</span>
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfMeta ? csrfMeta.content : '';
    let pendingTemplateAction = null;
    let currentPreviewTemplateId = null;
    let currentPreviewPayload = null;

    function templateEscapeHtml(value = '') {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function formatTitle(value) {
        if (!value) return '—';
        return String(value).replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
    }

    function buildPreviewDocument(d) {
        return d.content || '<p style="padding:1rem;color:#9ca3af;">No preview available.</p>';
    }

    function openPreviewModal() {
        window.openModal?.(
            'templatePreviewBackdrop'
        );

        requestAnimationFrame(() => {
            window.resetGlobalPreviewZoom?.(
                document.getElementById(
                    'templatePreviewBackdrop'
                )
            );
        });
    }

    function closePreviewModal() {
        window.closeModal?.('templatePreviewBackdrop');

        const frame = document.getElementById('templatePreviewFrame');

        if (frame) {
            frame.srcdoc = '';
        }

        currentPreviewTemplateId = null;
        currentPreviewPayload = null;

        document
            .querySelectorAll('.template-card')
            .forEach(card => card.classList.remove('selected'));
    }

    function getTemplateCard(id) {
        return document.querySelector(`.template-card[data-id="${CSS.escape(String(id))}"]`);
    }

    function getTemplateActionUrl(id, action) {
        const card = getTemplateCard(id);
        if (card) {
            return action === 'archive' ? card.dataset.archiveUrl : card.dataset.activateUrl;
        }

        return `/admin/document-template/${id}/${action}`;
    }

    function getTemplateName(id) {
        const card = getTemplateCard(id);
        return card?.dataset.templateName || currentPreviewPayload?.name || 'Template';
    }

    function getStatusBadgeClass(status) {
        return status === 'active' ?
            'status-active' :
            'status-archived';
    }

    function getStatusLabel(status) {
        return status ? status.charAt(0).toUpperCase() + status.slice(1) : '—';
    }

    window.handleTemplateActionClick = function (button) {
        const action = button.dataset.templateAction;
        const id = button.dataset.templateId;
        const actionData = {
            action,
            id,
            name: getTemplateName(id),
            url: getTemplateActionUrl(id, action),
        };

        if (action === 'archive') {
            openTemplateArchiveModal(actionData);
            return;
        }

        submitTemplateAction(actionData);
    };

    function renderTemplateActionButtons(card, status) {
        const actions = card?.querySelector('[data-template-actions]');
        if (!actions || !card) return;

        const id = card.dataset.id;

        actions.innerHTML = `
        <button type="button"
            class="ui-action-btn ui-action-view"
            data-tooltip="Preview template"
            data-tooltip-tone="view"
            aria-label="Preview template"
            onclick="event.stopPropagation(); openTemplatePreview(${id})">
            <i class="fa-solid fa-eye"></i>
        </button>
        ${status === 'active' ? `
                    <button type="button"
            class="ui-action-btn ui-action-warning"
            data-tooltip="Archive template"
            data-tooltip-tone="reschedule"
            aria-label="Archive template"
                        data-template-action="archive" data-template-id="${id}"
                        onclick="event.stopPropagation(); window.handleTemplateActionClick(this)">
                        <i class="fa-solid fa-box-archive"></i>
                    </button>
                ` : `
                    <button type="button"
            class="ui-action-btn ui-action-success"
            data-tooltip="Activate template" data-tooltip-tone="start"
            aria-label="Activate template" data-template-action="activate" data-template-id="${id}"
            onclick="event.stopPropagation(); window.handleTemplateActionClick(this)">
                        <i class="fa-solid fa-circle-check"></i>
                    </button>
                `}
    `;
    }

    function updateStats(stats = {}) {
        if (stats.total !== undefined) document.getElementById('templateTotalStat').textContent = stats.total;
        if (stats.active !== undefined) document.getElementById('templateActiveStat').textContent = stats.active;
        if (stats.archived !== undefined) document.getElementById('templateArchivedStat').textContent = stats.archived;
    }

    function applyTemplateStatus(id, payload = {}) {
        const template = payload.template || payload;
        const status = template.status || (payload.action === 'archive' ? 'archived' : 'active');
        const card = getTemplateCard(id);

        if (card) {
            card.dataset.status = status;
            card.classList.remove('status-active', 'status-archived');
            card.classList.add(`status-${status}`);

            const badge = card.querySelector('[data-template-status-badge]');
            if (badge) {
                badge.className = `status-badge ${getStatusBadgeClass(status)}`;
                badge.textContent = getStatusLabel(status);
            }

            if (status === 'archived') {
                card.querySelector('[data-template-default-badge]')?.remove();
            }

            renderTemplateActionButtons(card, status);
        }

        if (payload.stats) updateStats(payload.stats);

        if (currentPreviewTemplateId && Number(currentPreviewTemplateId) === Number(id)) {
            currentPreviewPayload = {
                ...(currentPreviewPayload || {}),
                ...(template || {}),
                status,
                is_default: status === 'archived' ? false : (template.is_default ?? currentPreviewPayload
                    ?.is_default)
            };
            renderPreviewMeta(currentPreviewPayload);
            renderPreviewFooter(currentPreviewPayload);
        }

        filterTemplateCards();
    }

    function renderPreviewMeta(d) {
        const metaEl =
            document.getElementById('templatePreviewMeta');

        if (!metaEl || !d) return;

        const status = d.status || 'active';
        const statusClass =
            getStatusBadgeClass(status);

        metaEl.innerHTML = `
        <div class="ui-action-group">
            <span class="status-badge">
                <i class="fa-solid fa-file-lines"></i>
                ${templateEscapeHtml(
            formatTitle(d.document_type)
        )}
            </span>

            <span class="status-badge">
                <i class="fa-solid fa-layer-group"></i>
                ${templateEscapeHtml(
            d.category || '—'
        )}
            </span>

            <span class="status-badge">
                <i class="fa-solid fa-print"></i>
                ${templateEscapeHtml(
            d.paper_size || '—'
        )}
                •
                ${templateEscapeHtml(
            formatTitle(d.orientation || '')
        )}
            </span>

            <span class="status-badge ${statusClass}">
                ${templateEscapeHtml(
            getStatusLabel(status)
        )}
            </span>

            ${d.is_default
                ? `
                            <span class="status-badge">
                                Default
                            </span>
                        `
                : ''
            }
        </div>
    `;
    }

    function renderPreviewFooter(d) {
        const footerEl =
            document.getElementById('templatePreviewFooter');

        if (!footerEl || !d) return;

        footerEl.innerHTML = `
        <button type="button"
            class="ui-btn ui-btn-secondary"
            onclick="closePreviewModal()">

            <i class="fa-solid fa-xmark"></i>
            <span>Close</span>
        </button>

        ${d.status === 'active'
                ? `
                        <button type="button"
                            class="ui-btn ui-btn-warning"
                            data-template-action="archive"
                            data-template-id="${d.id}">

                            <i class="fa-solid fa-box-archive"></i>
                            <span>Archive</span>
                        </button>
                    `
                : `
                        <button type="button"
                            class="ui-btn ui-btn-success"
                            data-template-action="activate"
                            data-template-id="${d.id}">

                            <i class="fa-solid fa-circle-check"></i>
                            <span>Activate</span>
                        </button>
                    `
            }
    `;
    }

    async function openTemplatePreview(id) {
        document.querySelectorAll('.template-card').forEach(c => c.classList.remove('selected'));
        getTemplateCard(id)?.classList.add('selected');

        openPreviewModal();
        currentPreviewTemplateId = id;

        const titleEl = document.getElementById('templatePreviewTitle');
        const subtitleEl = document.getElementById('templatePreviewSubtitle');
        const metaEl = document.getElementById('templatePreviewMeta');
        const frameEl = document.getElementById('templatePreviewFrame');
        const footerEl = document.getElementById('templatePreviewFooter');

        titleEl.textContent = 'Loading...';
        subtitleEl.textContent = 'Please wait';
        metaEl.innerHTML = '';
        footerEl.innerHTML = '';

        frameEl.srcdoc =
            '<p style="padding:2rem;text-align:center;color:#94a3b8;font-family:Arial,sans-serif;">Loading preview...</p>';

        try {
            const res = await fetch(`/admin/document-template/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (!res.ok) throw new Error('Failed to fetch');

            const d = await res.json();
            currentPreviewPayload = d;

            titleEl.textContent = d.name || 'Template Preview';
            subtitleEl.textContent = formatTitle(d.document_type);
            renderPreviewMeta(d);
            frameEl.srcdoc = buildPreviewDocument(d);
            renderPreviewFooter(d);
        } catch (e) {
            titleEl.textContent = 'Template Preview';
            subtitleEl.textContent = 'Failed to load';
            frameEl.srcdoc =
                '<p style="padding:2rem;text-align:center;color:#dc2626;font-family:Arial,sans-serif;">Failed to load template preview.</p>';
        }
    }

    let appliedTemplateCategory = '';
    let appliedTemplateStatus = '';
    let templatePageLoading = false;
    let templateSearchTimer = null;

    let templatePerPage =
        Number(
            document
                .getElementById(
                    'templatePagebar'
                )
                ?.dataset
                .perPage
        ) || 10;

    function getTemplateFilterCount() {
        return (
            (appliedTemplateCategory ? 1 : 0) +
            (appliedTemplateStatus ? 1 : 0)
        );
    }

    function getTemplatePreviewFilters() {
        const category =
            document.querySelector(
                'input[name="template_filter_category"]:checked'
            )?.value || '';

        const status =
            document.querySelector(
                'input[name="template_filter_status"]:checked'
            )?.value || '';

        return {
            category,
            status,
        };
    }

    function syncTemplateFilterRadios() {
        document
            .querySelectorAll(
                'input[name="template_filter_category"]'
            )
            .forEach(radio => {
                radio.checked =
                    radio.value ===
                    appliedTemplateCategory;
            });

        document
            .querySelectorAll(
                'input[name="template_filter_status"]'
            )
            .forEach(radio => {
                radio.checked =
                    radio.value ===
                    appliedTemplateStatus;
            });
    }

    function renderTemplateFilterChips() {
        const section =
            document.getElementById(
                'templateActiveFilters'
            );

        const host =
            document.getElementById(
                'templateFilterChips'
            );

        if (!section || !host) {
            return;
        }

        const chips = [];

        if (appliedTemplateCategory) {
            chips.push({
                key: 'category',
                label: appliedTemplateCategory
                    .charAt(0)
                    .toUpperCase() +
                    appliedTemplateCategory.slice(1),
            });
        }

        if (appliedTemplateStatus) {
            chips.push({
                key: 'status',
                label: appliedTemplateStatus
                    .charAt(0)
                    .toUpperCase() +
                    appliedTemplateStatus.slice(1),
            });
        }

        section.classList.toggle(
            'hidden',
            chips.length === 0
        );

        host.innerHTML = chips
            .map(chip => `
            <span class="filter-chip">
                <span>
                    ${templateEscapeHtml(chip.label)}
                </span>

                <button
                    type="button"
                    class="filter-chip-remove"
                    data-template-filter-remove="${chip.key}"
                    aria-label="Remove ${chip.label} filter"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </span>
        `)
            .join('');
    }

    function updateTemplateFilterUi() {
        const count =
            getTemplateFilterCount();

        const badge =
            document.getElementById(
                'templateFilterBadge'
            );

        const filterButton =
            document.getElementById(
                'templateFilterBtn'
            );

        const resetButton =
            document.getElementById(
                'templateFilterResetBtn'
            );

        if (badge) {
            badge.textContent = count;

            badge.classList.toggle(
                'show',
                count > 0
            );
        }

        filterButton?.classList.toggle(
            'has-filters',
            count > 0
        );

        resetButton?.classList.toggle(
            'hidden',
            count === 0
        );

        renderTemplateFilterChips();
    }

    window.openTemplateFilterDrawer =
        function () {
            syncTemplateFilterRadios();

            window.openFilterDrawer?.(
                'templateFilterDrawer'
            );
        };

    window.closeTemplateFilterDrawer =
        function () {
            window.closeFilterDrawer?.(
                'templateFilterDrawer'
            );
        };

    function resetTemplateFilters() {
        appliedTemplateCategory = '';
        appliedTemplateStatus = '';

        syncTemplateFilterRadios();
        updateTemplateFilterUi();

        loadTemplatePage(1);
    }

    window.resetTemplateFilters =
        resetTemplateFilters;

    function openTemplateArchiveModal(actionData) {
        pendingTemplateAction = actionData;

        const nameEl =
            document.getElementById('templateArchiveName');

        if (nameEl) {
            nameEl.textContent =
                actionData.name || 'Template';
        }

        window.openModal?.('templateArchiveModal');
    }

    function closeTemplateArchiveModal() {
        window.closeModal?.('templateArchiveModal');
        pendingTemplateAction = null;
    }

    async function submitTemplateAction(actionData) {
        if (!actionData?.id || !actionData?.url || !actionData?.action) return;

        const triggerButtons = document.querySelectorAll(
            `[data-template-action="${actionData.action}"][data-template-id="${actionData.id}"]`);
        triggerButtons.forEach(button => {
            button.disabled = true;
            button.classList.add('is-loading');
        });

        const confirmBtn = document.getElementById('confirmTemplateArchiveBtn');
        const originalConfirmHTML = confirmBtn?.innerHTML;

        if (actionData.action === 'archive' && confirmBtn) {
            confirmBtn.disabled = true;
            confirmBtn.innerHTML = '<i class="fa-solid fa-spinner spin"></i> Archiving...';
        }

        try {
            const formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('_method', 'PATCH');

            const response = await fetch(actionData.url, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData,
            });

            const payload = await response.json().catch(() => ({}));

            if (!response.ok || payload.success === false) {
                throw new Error(payload.message || 'Unable to update template.');
            }

            updateStats(
                payload.stats || {}
            );

            closeTemplateArchiveModal();

            const currentPage =
                Number(
                    document
                        .getElementById(
                            'templatePagebar'
                        )
                        ?.dataset
                        .currentPage
                ) || 1;

            await loadTemplatePage(
                currentPage
            );

            window.showToast?.({
                type: actionData.action === 'archive' ? 'warning' : 'success',
                title: actionData.action === 'archive' ? 'Template archived' : 'Template activated',
                message: payload.message ||
                    `Template ${actionData.action === 'archive' ? 'archived' : 'activated'} successfully.`,
            });
        } catch (error) {
            window.showToast?.({
                type: 'error',
                title: 'Update failed',
                message: error.message || 'Please try again.',
            });
        } finally {
            triggerButtons.forEach(button => {
                button.disabled = false;
                button.classList.remove('is-loading');
            });

            if (confirmBtn) {
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = originalConfirmHTML ||
                    '<i class="fa-solid fa-box-archive"></i> Yes, Archive';
            }
        }
    }

    function handleTemplateActionClick(button) {
        const action = button.dataset.templateAction;
        const id = button.dataset.templateId;
        const actionData = {
            action,
            id,
            name: getTemplateName(id),
            url: getTemplateActionUrl(id, action),
        };

        if (action === 'archive') {
            openTemplateArchiveModal(actionData);
            return;
        }

        submitTemplateAction(actionData);
    }

    function renderTemplateEmptyState() {
        const host =
            document.getElementById(
                'templateBaseEmptyState'
            );

        if (!host) {
            return;
        }

        const searchInput =
            document.getElementById(
                'templateSearch'
            );

        const query =
            String(
                searchInput?.value || ''
            ).trim();


        if (query) {
            window.EmptyState?.renderSearch({
                host:
                    '#templateBaseEmptyState',

                input:
                    '#templateSearch',

                query,

                message:
                    'Try a different template name or clear your search.',
            });

            return;
        }


        if (
            appliedTemplateCategory ||
            appliedTemplateStatus
        ) {
            window.EmptyState?.render({
                host:
                    '#templateBaseEmptyState',

                icon:
                    'fa-sliders',

                title:
                    'No templates match your filters',

                message:
                    'Try another category or status.',

                actionHtml: `
                <button
                    type="button"
                    class="empty-state-btn"
                    onclick="resetTemplateFilters()"
                >
                    <i class="fa-solid fa-rotate-left"></i>
                    Clear filters
                </button>
            `,
            });

            return;
        }


        window.EmptyState?.render({
            host:
                '#templateBaseEmptyState',

            icon:
                'fa-file-circle-xmark',

            title:
                'No templates available',

            message:
                'No default document templates are currently available.',
        });
    }

    function renderTemplatePagination() {
        const pagebar =
            document.getElementById(
                'templatePagebar'
            );

        const info =
            document.getElementById(
                'templatePageInfo'
            );

        const pagination =
            document.getElementById(
                'templatePagination'
            );

        if (
            !pagebar ||
            !info ||
            !pagination
        ) {
            return;
        }


        window.renderGlobalPagination?.({
            currentPage:
                Number(
                    pagebar.dataset.currentPage
                ) || 1,

            lastPage:
                Number(
                    pagebar.dataset.lastPage
                ) || 1,

            total:
                Number(
                    pagebar.dataset.total
                ) || 0,

            from:
                Number(
                    pagebar.dataset.from
                ) || 0,

            to:
                Number(
                    pagebar.dataset.to
                ) || 0,

            containers: [
                pagination
            ],

            infoElements: [
                info
            ],

            bars: [
                pagebar
            ],

            itemLabel:
                'templates',

            onPageChange:
                loadTemplatePage,
        });
    }

    async function loadTemplatePage(
        page = 1
    ) {
        if (templatePageLoading) {
            return;
        }

        templatePageLoading = true;

        const searchInput =
            document.getElementById(
                'templateSearch'
            );

        const pagebar =
            document.getElementById(
                'templatePagebar'
            );

        const url =
            new URL(
                window.location.href
            );


        url.searchParams.set(
            'page',
            String(page)
        );

        url.searchParams.set(
            'per_page',
            String(templatePerPage)
        );


        const searchValue =
            String(
                searchInput?.value || ''
            ).trim();


        if (searchValue) {
            url.searchParams.set(
                'search',
                searchValue
            );
        } else {
            url.searchParams.delete(
                'search'
            );
        }


        if (appliedTemplateCategory) {
            url.searchParams.set(
                'category',
                appliedTemplateCategory
            );
        } else {
            url.searchParams.delete(
                'category'
            );
        }


        if (appliedTemplateStatus) {
            url.searchParams.set(
                'status',
                appliedTemplateStatus
            );
        } else {
            url.searchParams.delete(
                'status'
            );
        }


        try {
            pagebar?.classList.add(
                'is-loading'
            );


            const response =
                await fetch(
                    url.toString(),
                    {
                        headers: {
                            Accept:
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',
                        },

                        credentials:
                            'same-origin',
                    }
                );


            if (!response.ok) {
                throw new Error(
                    'Unable to load document templates.'
                );
            }


            const payload =
                await response.json();


            if (
                !payload.success ||
                !payload.results_html
            ) {
                throw new Error(
                    'Invalid document template response.'
                );
            }


            const parsed =
                new DOMParser()
                    .parseFromString(
                        payload.results_html,
                        'text/html'
                    );


            const newRegion =
                parsed.getElementById(
                    'templateResultsRegion'
                );

            const currentRegion =
                document.getElementById(
                    'templateResultsRegion'
                );


            if (
                !newRegion ||
                !currentRegion
            ) {
                throw new Error(
                    'Unable to update document template results.'
                );
            }


            currentRegion.innerHTML =
                newRegion.innerHTML;


            const pagination =
                payload.pagination || {};


            if (pagebar) {
                pagebar.dataset.currentPage =
                    String(
                        pagination.current_page
                        ?? 1
                    );

                pagebar.dataset.lastPage =
                    String(
                        pagination.last_page
                        ?? 1
                    );

                pagebar.dataset.total =
                    String(
                        pagination.total
                        ?? 0
                    );

                pagebar.dataset.from =
                    String(
                        pagination.from
                        ?? 0
                    );

                pagebar.dataset.to =
                    String(
                        pagination.to
                        ?? 0
                    );

                pagebar.dataset.perPage =
                    String(
                        pagination.per_page
                        ?? templatePerPage
                    );
            }


            if (payload.stats) {
                updateStats(
                    payload.stats
                );
            }


            window.history.replaceState(
                {},
                '',
                url.toString()
            );

            renderTemplateEmptyState();
            renderTemplatePagination();


        } catch (error) {
            window.showToast?.({
                type: 'error',

                title:
                    'Unable to load templates',

                message:
                    error.message ||
                    'Please try again.',

                duration: 4500,
            });
        } finally {
            templatePageLoading =
                false;

            pagebar?.classList.remove(
                'is-loading'
            );
        }
    }

    document.addEventListener('DOMContentLoaded', () => {

        document.getElementById('closeTemplatePreview')?.addEventListener('click', closePreviewModal);

        const templateSearch =
            document.getElementById(
                'templateSearch'
            );

        templateSearch
            ?.addEventListener(
                'input',
                () => {
                    clearTimeout(
                        templateSearchTimer
                    );

                    templateSearchTimer =
                        window.setTimeout(
                            () => {
                                loadTemplatePage(1);
                            },
                            300
                        );
                }
            );

        document
            .getElementById(
                'templatePageSize'
            )
            ?.addEventListener(
                'change',
                event => {
                    const value =
                        Number(
                            event.target.value
                        );

                    templatePerPage =
                        [10, 20, 50, 100]
                            .includes(value)
                            ? value
                            : 10;

                    loadTemplatePage(1);
                }
            );

        document.addEventListener('keydown', function (event) {
            if (event.key !== 'Escape') return;

            const archiveModal =
                document.getElementById('templateArchiveModal');

            const previewModal =
                document.getElementById('templatePreviewBackdrop');

            if (archiveModal?.classList.contains('open')) {
                closeTemplateArchiveModal();
                return;
            }

            if (previewModal?.classList.contains('open')) {
                closePreviewModal();
            }
        });

        document
            .getElementById('templatePreviewFooter')
            ?.addEventListener('click', function (event) {
                const actionButton =
                    event.target.closest('[data-template-action]');

                if (!actionButton) return;

                event.preventDefault();

                window.handleTemplateActionClick(actionButton);
            });

        document
            .getElementById(
                'applyTemplateFilters'
            )
            ?.addEventListener(
                'click',
                () => {
                    const preview =
                        getTemplatePreviewFilters();

                    appliedTemplateCategory =
                        preview.category;

                    appliedTemplateStatus =
                        preview.status;

                    updateTemplateFilterUi();

                    window
                        .closeTemplateFilterDrawer
                        ?.();

                    loadTemplatePage(1);
                }
            );

        document
            .getElementById(
                'clearTemplateFiltersDrawer'
            )
            ?.addEventListener(
                'click',
                () => {
                    resetTemplateFilters();
                    syncTemplateFilterRadios();
                }
            );

        document
            .getElementById(
                'clearTemplateFilterChips'
            )
            ?.addEventListener(
                'click',
                resetTemplateFilters
            );

        document
            .getElementById(
                'templateFilterChips'
            )
            ?.addEventListener(
                'click',
                event => {
                    const button =
                        event.target.closest(
                            '[data-template-filter-remove]'
                        );

                    if (!button) {
                        return;
                    }

                    const key =
                        button.dataset
                            .templateFilterRemove;

                    if (key === 'category') {
                        appliedTemplateCategory = '';
                    }

                    if (key === 'status') {
                        appliedTemplateStatus = '';
                    }

                    syncTemplateFilterRadios();
                    updateTemplateFilterUi();

                    loadTemplatePage(1);
                }
            );
        renderTemplateEmptyState();
        updateTemplateFilterUi();
        renderTemplatePagination();
    });
</script>
@endsection