@php
    $previewOdontogramData = $odontogramData ?? [];
    $showEditButton = $showEditButton ?? false;
@endphp

<div class="odontogram-preview" data-odontogram-preview data-odontogram='@json($previewOdontogramData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)'>

    <div class="odontogram-preview-head">
        <div>
            <p class="odontogram-preview-subtitle">
                Click any tooth to view its saved markings.
            </p>
        </div>

        @if ($showEditButton)
            <a href="#" id="recordModalEditBtn"
                class="ui-btn ui-btn-primary ui-btn-sm odontogram-preview-head-edit-btn"
                hidden>
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Edit Odontogram</span>
            </a>
        @endif
    </div>

    <div class="odontogram-preview-layout">
        <div class="odontogram-preview-stage">
            <div class="odontogram-preview-loading" data-odontogram-preview-loading>
                <i class="fa-solid fa-circle-notch fa-spin"></i>
                <span>Generating 3D Model...</span>
            </div>

            <div class="odontogram-preview-canvas" data-odontogram-preview-canvas>
            </div>

            <div class="odontogram-preview-tooltip" data-odontogram-preview-tooltip>
            </div>
        </div>

        <aside class="odontogram-preview-side-panel" data-odontogram-preview-panel aria-live="polite">
            <div class="empty-state odontogram-preview-panel-empty" data-odontogram-preview-empty>

                <div class="empty-state-icon">
                    <i class="fa-solid fa-tooth" aria-hidden="true">
                    </i>
                </div>

                <p class="empty-state-title">
                    Select a tooth
                </p>

                <p class="empty-state-sub">
                    Click any tooth in the 3D odontogram
                    to view its saved markings and dental information.
                </p>

            </div>

            <div class="odontogram-preview-panel-details" data-odontogram-preview-details hidden>
                <div class="odontogram-preview-panel-header">
                    <div class="odontogram-preview-panel-heading">
                        <div class="odontogram-preview-panel-icon">
                            <i class="fa-solid fa-tooth"></i>
                        </div>

                        <div>
                            <h3 class="odontogram-preview-panel-title" data-odontogram-preview-title>
                                Tooth
                            </h3>

                            <p class="odontogram-preview-panel-subtitle" data-odontogram-preview-subtitle>
                                Tooth information
                            </p>
                        </div>
                    </div>
                </div>

                <div class="odontogram-preview-panel-body">
                    <div class="odontogram-preview-detail-main">
                        <div>
                            <p class="odontogram-preview-detail-label">
                                Overall Marking
                            </p>

                            <div class="odontogram-preview-condition" data-odontogram-preview-condition>
                                Healthy
                            </div>
                        </div>
                    </div>

                    <div class="odontogram-preview-info-grid">
                        <div class="odontogram-preview-info-item">
                            <span class="global-info-label">
                                FDI Number
                            </span>

                            <span class="global-info-value" data-odontogram-preview-fdi>
                                —
                            </span>
                        </div>

                        <div class="odontogram-preview-info-item">
                            <span class="global-info-label">
                                Quadrant
                            </span>

                            <span class="global-info-value" data-odontogram-preview-quadrant>
                                —
                            </span>
                        </div>

                        <div class="odontogram-preview-info-item">
                            <span class="global-info-label">
                                Tooth Type
                            </span>

                            <span class="global-info-value" data-odontogram-preview-type>
                                —
                            </span>
                        </div>

                        <div class="odontogram-preview-info-item">
                            <span class="global-info-label">
                                Arch
                            </span>

                            <span class="global-info-value" data-odontogram-preview-arch>
                                —
                            </span>
                        </div>
                    </div>

                    <section class="odontogram-preview-markings">
                        <p class="odontogram-preview-detail-label">
                            Surface Markings
                        </p>

                        <div class="odontogram-preview-marking-list" data-odontogram-preview-markings>
                        </div>
                    </section>
                </div>
            </div>
        </aside>
    </div>
</div>
