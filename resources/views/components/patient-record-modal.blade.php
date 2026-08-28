<div id="record_modal" class="ui-modal" role="dialog" aria-modal="true" aria-labelledby="recordModalTitle">

    <div class="ui-modal-card record-modal-wide">

        <div class="modal-hd appointment-modal-header">
            <div class="modal-heading">

                <div class="appointment-modal-header-icon">
                    <i class="fa-solid fa-file-medical"></i>
                </div>

                <div class="appointment-modal-header-copy">
                    <span class="appointment-modal-eyebrow">
                        Dental Record
                    </span>

                    <h3 id="recordModalTitle" class="appointment-modal-title">
                        <span id="m_service">—</span>
                    </h3>

                    <div class="record-modal-meta">
                        <span>
                            <i class="fa-regular fa-calendar"></i>
                            <span id="m_date">—</span>
                        </span>

                        <span>
                            <i class="fa-regular fa-clock"></i>
                            <span id="m_time">—</span>
                        </span>
                    </div>
                </div>
            </div>

            <button type="button" class="modal-x" id="modalCloseBtn" aria-label="Close dental record">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="modal-bd">

            <div class="record-modal-summary record-modal-summary-three">
                <div class="record-summary-card">
                    <span class="record-summary-label">
                        <i class="fa-solid fa-shield-halved"></i>
                        Status
                    </span>

                    <span id="m_status" class="status-pill status-default">
                        <span class="status-dot"></span>
                        —
                    </span>
                </div>

                <div class="record-summary-card">
                    <span class="record-summary-label">
                        <i class="fa-regular fa-hourglass-half"></i>
                        Duration
                    </span>

                    <strong id="m_duration" class="record-summary-value">
                        —
                    </strong>
                </div>

                <div class="record-summary-card">
                    <span class="record-summary-label">
                        <i class="fa-solid fa-calendar-plus"></i>
                        Follow-up Appointment
                    </span>

                    <strong id="m_follow_up" class="record-summary-value">
                        —
                    </strong>
                </div>
            </div>

            <div class="record-modal-grid-two">
                <div class="record-modal-section">
                    <div class="record-modal-section-title">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <span>Treatment</span>
                    </div>

                    <div class="record-modal-content">
                        <div id="m_remarks" class="odontogram-preview-marking-list">
                            —
                        </div>
                    </div>
                </div>

                <div class="record-modal-section">
                    <div class="record-modal-section-title">
                        <i class="fa-solid fa-eye"></i>
                        <span>Oral Examination</span>
                    </div>

                    <div class="record-modal-content">
                        <div id="m_oral">—</div>
                    </div>
                </div>
            </div>

            <div class="record-modal-grid-two">
                <div class="record-modal-section">
                    <div class="record-modal-section-title">
                        <i class="fa-solid fa-circle-info"></i>
                        <span>Diagnosis</span>
                    </div>

                    <div class="record-modal-content">
                        <div id="m_diagnosis">—</div>
                    </div>
                </div>

                <div class="record-modal-section">
                    <div class="record-modal-section-title">
                        <i class="fa-solid fa-prescription-bottle-medical"></i>
                        <span>Prescription</span>
                    </div>

                    <div class="record-modal-content">
                        <div id="m_prescription">—</div>
                    </div>
                </div>
            </div>

            <div class="record-modal-section record-modal-odontogram-section">
                <div class="record-modal-section-title">
                    <i class="fa-solid fa-tooth"></i>
                    <span>Odontogram</span>
                </div>

                <div id="m_odontogram" class="record-modal-odontogram">

                    @include('components.odontogram-preview', [
                        'odontogramData' => [],
                    ])

                </div>
            </div>

        </div>

        <div class="modal-ft">
            <button type="button" class="btn-close-modal" id="modalCloseFooter">
                Close
            </button>
        </div>

    </div>
</div>
