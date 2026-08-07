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

            <button type="button" class="modal-x" id="modalCloseBtn" onclick="closeRecordModal()"
                aria-label="Close dental record">
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
                        <span id="m_remarks">—</span>
                    </div>
                </div>

                <div class="record-modal-section">
                    <div class="record-modal-section-title">
                        <i class="fa-solid fa-eye"></i>
                        <span>Oral Examination</span>
                    </div>

                    <div class="record-modal-content">
                        <span id="m_oral">—</span>
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
                        <span id="m_diagnosis">—</span>
                    </div>
                </div>

                <div class="record-modal-section">
                    <div class="record-modal-section-title">
                        <i class="fa-solid fa-prescription-bottle-medical"></i>
                        <span>Prescription</span>
                    </div>

                    <div class="record-modal-content">
                        <span id="m_prescription">—</span>
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
            <button type="button" class="btn-close-modal" id="modalCloseFooter" onclick="closeRecordModal()">
                Close
            </button>
        </div>

    </div>
</div>

<script>
    function normalizeRecordData(source) {
        if (source instanceof HTMLElement) {
            return {
                service: source.dataset.service ||
                    source.dataset.type ||
                    '',

                date: source.dataset.date ||
                    '',

                time: source.dataset.time ||
                    '',

                status: source.dataset.status ||
                    '',

                duration: source.dataset.duration ||
                    '',

                remarks: source.dataset.remarks ||
                    source.dataset.treatment ||
                    '',

                oral: source.dataset.oral ||
                    source.dataset.oralExamination ||
                    '',

                diagnosis: source.dataset.diagnosis ||
                    '',

                prescription: source.dataset.prescription ||
                    source.dataset.prescriptions ||
                    '',

                followUp: null,
                odontogramData: []
            };
        }

        return {
            service: source?.service ||
                source?.service_type ||
                source?.type ||
                '',

            date: source?.date ||
                source?.appointment_date ||
                '',

            time: source?.time ||
                source?.appointment_time ||
                '',

            status: source?.status ||
                '',

            durationSeconds: source?.duration_seconds ??
                source?.procedure_duration_seconds ??
                null,

            remarks: source?.remarks ||
                source?.treatment_notes ||
                source?.treatment ||
                '',

            oral: source?.oral ||
                source?.oral_examination ||
                '',

            diagnosis: source?.diagnosis ||
                '',

            prescription: source?.prescription ||
                source?.prescriptions ||
                '',

            followUp: source?.follow_up ||
                source?.followUp ||
                null,

            odontogramData: source?.odontogram_data ||
                source?.odontogramData || []
        };
    }

    function formatRecordDurationSeconds(
        seconds
    ) {
        const total =
            Number(seconds);

        if (
            !Number.isFinite(total) ||
            total <= 0
        ) {
            return '—';
        }

        const hours =
            Math.floor(
                total / 3600
            );

        const minutes =
            Math.floor(
                (
                    total % 3600
                ) / 60
            );

        const remainingSeconds =
            total % 60;

        const parts = [];

        if (hours) {
            parts.push(
                `${hours} hr${hours === 1 ? '' : 's'}`
            );
        }

        if (minutes) {
            parts.push(
                `${minutes} min${minutes === 1 ? '' : 's'}`
            );
        }

        if (
            !hours &&
            !minutes
        ) {
            parts.push(
                `${remainingSeconds} sec${remainingSeconds === 1 ? '' : 's'}`
            );
        }

        return parts.join(' ');
    }
    
    setText(
        'm_duration',
        formatRecordDurationSeconds(
            data.durationSeconds
        )
    );

    function formatRecordTime(raw) {
        if (!raw) return '—';

        raw = String(raw).trim();

        if (raw.includes('–') || raw.includes('-')) return raw;
        if (/[AaPp][Mm]/.test(raw)) return raw;

        var m = raw.match(/^(\d{1,2}):(\d{2})(?::\d{2})?/);
        if (!m) return raw;

        var h = parseInt(m[1], 10);
        var min = m[2];
        var ampm = h >= 12 ? 'PM' : 'AM';
        var hr = h % 12 || 12;

        return hr + ':' + min + ' ' + ampm;
    }

    function formatRecordDuration(raw) {
        if (!raw) return '—';

        raw = String(raw).trim();

        if (!raw || raw === '—') return '—';
        if (/[a-zA-Z]/.test(raw)) return raw;

        return raw + ' mins';
    }

    function formatRecordStatus(status) {
        status = String(status || '').trim();

        if (!status) return '—';

        return status.split(' - ').map(function(part, index) {
            if (index === 0) {
                var base = part.toLowerCase();
                return base.charAt(0).toUpperCase() + base.slice(1);
            }

            if (part.toLowerCase() === 'patient no-show') return 'No-show';
            if (part.toLowerCase() === 'no-show') return 'No-show';

            return part;
        }).join(' - ');
    }

    function setText(id, value) {
        var el = document.getElementById(id);
        if (el) el.textContent = value && String(value).trim() ? value : '—';
    }

    function formatRecordTreatment(value) {
        const normalized =
            String(value ?? '')
            .trim()
            .toLowerCase();

        if (!normalized) {
            return 'No treatment record yet.';
        }

        if (normalized === 'finished') {
            return 'Finished procedure';
        }

        if (normalized === 'follow_up') {
            return 'Follow-up required';
        }

        return String(value)
            .replace(/_/g, ' ')
            .replace(/\b\w/g, letter =>
                letter.toUpperCase()
            );
    }

    function formatRecordFollowUp(followUp) {
        if (!followUp) {
            return 'No follow-up appointment scheduled.';
        }

        const parts = [
            followUp.date,
            followUp.time,
            followUp.service
        ].filter(Boolean);

        let text = parts.join(' • ');

        if (followUp.reason) {
            text += `${text ? ' • ' : ''}${followUp.reason}`;
        }

        return text ||
            'No follow-up appointment scheduled.';
    }

    function formatRecordTreatments(
        rawOdontogram
    ) {
        let odontogram =
            rawOdontogram;

        if (
            typeof odontogram ===
            'string'
        ) {
            try {
                odontogram =
                    JSON.parse(
                        odontogram ||
                        '[]'
                    );
            } catch (_) {
                odontogram = [];
            }
        }

        const entries =
            Array.isArray(
                odontogram
            ) ?
            odontogram :
            Object.values(
                odontogram || {}
            );

        const treatments =
            new Map();

        const addTreatment =
            record => {
                if (
                    !record ||
                    !record.code
                ) {
                    return;
                }

                const code =
                    String(
                        record.code
                    ).trim();

                const label =
                    String(
                        record.label ||
                        code
                    ).trim();

                treatments.set(
                    `${code}|${label}`,
                    `${code} - ${label}`
                );
            };

        entries.forEach(entry => {
            addTreatment(
                entry?.status
            );

            addTreatment(
                entry?.threeD ||
                entry?.three_d
            );

            const surfaces =
                entry?.surfaces || {};

            [
                'top',
                'left',
                'center',
                'right',
                'bottom'
            ].forEach(surface => {
                addTreatment(
                    surfaces?.[
                        surface
                    ]
                );
            });
        });

        if (
            treatments.size === 0
        ) {
            return 'No treatment record yet.';
        }

        return Array.from(
            treatments.values()
        ).join(', ');
    }

    function setRecordModalData(source) {
        var data = normalizeRecordData(source || {});

        setText('m_service', data.service);
        setText('m_date', data.date);
        setText('m_time', formatRecordTime(data.time));
        setText('m_duration', formatRecordDuration(data.duration));

        var status = String(data.status || '').trim().toLowerCase();
        var sEl = document.getElementById('m_status');

        if (sEl) {
            const normalizedStatus =
                status === 'canceled' ?
                'cancelled' :
                status.split(' - ')[0];

            sEl.className =
                'status-pill status-' +
                (
                    [
                        'completed',
                        'cancelled',
                        'rescheduled',
                        'upcoming',
                        'pending'
                    ].includes(normalizedStatus) ?
                    normalizedStatus :
                    'default'
                );

            sEl.innerHTML = `
        <span class="status-dot"></span>
        ${formatRecordStatus(status)}
    `;
        }

        setText(
            'm_remarks',
            formatRecordTreatments(
                data.odontogramData
            )
        );

        setText(
            'm_oral',
            data.oral ||
            'No oral examination record yet.'
        );

        setText(
            'm_diagnosis',
            data.diagnosis ||
            'No diagnosis record yet.'
        );

        setText(
            'm_prescription',
            data.prescription ||
            'No prescription recorded.'
        );

        setText(
            'm_follow_up',
            formatRecordFollowUp(data.followUp)
        );

        const odontogramSection =
            document.getElementById(
                'm_odontogram'
            );

        const odontogramPreview =
            odontogramSection?.querySelector(
                '[data-odontogram-preview]'
            );

        if (
            odontogramPreview &&
            typeof window.setOdontogramPreviewData ===
            'function'
        ) {
            window.setOdontogramPreviewData(
                odontogramPreview,
                data.odontogramData
            );
        }
    }

    function openRecordModal(source) {
        const modal =
            document.getElementById('record_modal');

        if (!modal) return;

        modal.classList.remove('closing');
        modal.classList.add('open');

        document.documentElement.classList.add(
            'modal-lock'
        );

        document.body.classList.add(
            'modal-lock'
        );

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                setRecordModalData(
                    source || {}
                );
            });
        });
    }

    function closeRecordModal() {
        const modal = document.getElementById('record_modal');
        if (!modal || !modal.classList.contains('open')) return;

        modal.classList.add('closing');

        setTimeout(() => {
            modal.classList.remove('open', 'closing');

            document.documentElement.classList.remove('modal-lock');
            document.body.classList.remove('modal-lock');
        }, 160);
    }

    function initRecordModal() {
        const modal = document.getElementById('record_modal');
        if (!modal || modal.dataset.initialized === 'true') return;

        modal.dataset.initialized = 'true';

        const closeBtn = document.getElementById('modalCloseBtn');
        const closeFooter = document.getElementById('modalCloseFooter');
        const card = modal.querySelector('.ui-modal-card');

        closeBtn?.addEventListener('click', closeRecordModal);
        closeFooter?.addEventListener('click', closeRecordModal);

        modal.addEventListener('click', (event) => {
            if (card && !card.contains(event.target)) {
                closeRecordModal();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (
                event.key === 'Escape' &&
                modal.classList.contains('open')
            ) {
                closeRecordModal();
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener(
            'DOMContentLoaded',
            initRecordModal
        );
    } else {
        initRecordModal();
    }
</script>
