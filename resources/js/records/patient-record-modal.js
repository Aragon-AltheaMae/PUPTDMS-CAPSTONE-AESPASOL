function parseRecordDatasetJson(value, fallback) {
    if (!value) {
        return fallback;
    }

    try {
        return JSON.parse(value);
    } catch (_) {
        return fallback;
    }
}

function normalizeRecordData(source) {
    if (source instanceof HTMLElement) {
        if (source.dataset.record) {
            try {
                return normalizeRecordData(JSON.parse(source.dataset.record));
            } catch (_) {
            }
        }

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

            durationSeconds: source.dataset.durationSeconds ??
                null,

            duration: source.dataset.duration ||
                '',

            remarks: source.dataset.remarks ||
                source.dataset.treatment ||
                '',

            treatmentItems: parseRecordDatasetJson(
                source.dataset.treatmentItems,
                []
            ),

            oral: source.dataset.oral ||
                source.dataset.oralExamination ||
                '',

            diagnosis: source.dataset.diagnosis ||
                '',

            prescription: source.dataset.prescription ||
                source.dataset.prescriptions ||
                '',

            followUp: parseRecordDatasetJson(
                source.dataset.followUp,
                null
            ),

            editUrl: source.dataset.editUrl ||
                '',

            odontogramData: parseRecordDatasetJson(
                source.dataset.odontogramData,
                []
            )
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

        duration: source?.duration ??
            '',

        remarks: source?.remarks ||
            source?.treatment_notes ||
            source?.treatment ||
            '',

        treatmentItems: source?.treatment_items ||
            source?.treatmentItems || [],

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

        editUrl: source?.edit_url ||
            source?.editUrl ||
            '',

        odontogramData: source?.odontogram ||
            source?.odontogram_data ||
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
        remainingSeconds ||
        (!hours && !minutes)
    ) {
        parts.push(
            `${remainingSeconds} sec${remainingSeconds === 1 ? '' : 's'}`
        );
    }

    return parts.join(' ');
}

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

    return status.split(' - ').map(function (part, index) {
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

    const treatments = [];

    const addTreatment = (
        surface,
        record
    ) => {
        if (
            !record ||
            !record.code
        ) {
            return;
        }

        let code =
            String(
                record.code
            )
                .trim()
                .toUpperCase();

        if (
            code === 'PT' ||
            code === '+'
        ) {
            code = '✓';
        }

        const label =
            String(
                record.label ||
                code
            ).trim();

        const colorHex =
            String(
                record.colorHex ||
                record.color_hex ||
                ''
            ).trim();

        treatments.push({
            surface,
            code,
            label,
            colorHex,
        });
    };

    entries.forEach(entry => {
        const surfaceTreatments = [];

        if (entry?.status) {
            addTreatment(
                'Status',
                entry.status
            );
        }

        const surfaces =
            entry?.surfaces || {};

        [
            'top',
            'left',
            'center',
            'right',
            'bottom'
        ].forEach(surface => {

            const record =
                surfaces?.[
                surface
                ];

            if (!record) {
                return;
            }

            const surfaceLabel =
                surface
                    .charAt(0)
                    .toUpperCase() +
                surface.slice(1);

            addTreatment(
                surfaceLabel,
                record
            );

            surfaceTreatments.push({
                code: String(
                    record.code || ''
                )
                    .trim()
                    .toUpperCase(),
                label: String(
                    record.label ||
                    record.code ||
                    ''
                )
                    .trim()
                    .toLowerCase(),
            });
        });

        const threeDRecord =
            entry?.threeD ||
            entry?.three_d;

        const hasMatchingSurfaceTreatment =
            !!threeDRecord &&
            surfaceTreatments.some(
                treatment =>
                    treatment.code ===
                    String(
                        threeDRecord.code || ''
                    )
                        .trim()
                        .toUpperCase() &&
                    treatment.label ===
                    String(
                        threeDRecord.label ||
                        threeDRecord.code ||
                        ''
                    )
                        .trim()
                        .toLowerCase()
            );

        if (
            threeDRecord &&
            !hasMatchingSurfaceTreatment
        ) {
            addTreatment(
                '3D',
                threeDRecord
            );
        }
    });

    return treatments;
}

function safeRecordText(
    value
) {
    return String(
        value ?? ''
    )
        .replaceAll(
            '&',
            '&amp;'
        )
        .replaceAll(
            '<',
            '&lt;'
        )
        .replaceAll(
            '>',
            '&gt;'
        )
        .replaceAll(
            '"',
            '&quot;'
        )
        .replaceAll(
            "'",
            '&#039;'
        );
}

function renderRecordTreatments(
    containerId,
    treatments,
    fallbackText = ''
) {
    const container =
        document.getElementById(
            containerId
        );

    if (!container) {
        return;
    }

    if (
        !Array.isArray(
            treatments
        ) ||
        treatments.length === 0
    ) {
        container.textContent =
            String(
                fallbackText ||
                'No treatment record yet.'
            ).trim();

        return;
    }

    container.innerHTML =
        treatments
            .map(
                treatment => `
                    <span class="odontogram-preview-marking">
                        <i
                            class="odontogram-preview-marking-swatch"
                            style="background:${safeRecordText(
                    treatment.colorHex ||
                    '#111827'
                )}"
                        ></i>

                        <span>${safeRecordText(
                    treatment.surface
                )}: ${safeRecordText(
                    treatment.code
                )} - ${safeRecordText(
                    treatment.label
                )}</span>
                    </span>
                `
            )
            .join('');
}

function setRecordModalData(
    source,
    alreadyNormalized = false
) {
    const data =
        alreadyNormalized ?
            source :
            normalizeRecordData(
                source || {}
            );

    setText('m_service', data.service);
    setText('m_date', data.date);
    setText('m_time', formatRecordTime(data.time));
    const normalizedRecordStatus = String(
        data.status || ''
    )
        .trim()
        .toLowerCase();

    const isCancelledRecord =
        normalizedRecordStatus === 'cancelled' ||
        normalizedRecordStatus === 'canceled';

    setText(
        'm_duration',
        isCancelledRecord ?
            '—' :
            (
                data.durationSeconds !== null &&
                    data.durationSeconds !== undefined ?
                    formatRecordDurationSeconds(
                        data.durationSeconds
                    ) :
                    formatRecordDuration(
                        data.duration
                    )
            )
    );

    var status = normalizedRecordStatus;
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

    const treatments =
        Array.isArray(
            data.treatmentItems
        ) &&
            data.treatmentItems.length
            ? data.treatmentItems
            : formatRecordTreatments(
                data.odontogramData
            );

    renderRecordTreatments(
        'm_remarks',
        treatments,
        data.remarks ||
        'No treatment record yet.'
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

    const editBtn =
        document.getElementById(
            'recordModalEditBtn'
        );

    if (editBtn) {
        const editUrl = String(
            data.editUrl || ''
        ).trim();

        if (editUrl) {
            editBtn.href = editUrl;
            editBtn.hidden = false;
        } else {
            editBtn.href = '#';
            editBtn.hidden = true;
        }
    }
}

export async function openRecordModal(source) {
    initRecordModal();

    const modal =
        document.getElementById(
            'record_modal'
        );

    if (!modal) {
        return;
    }

    const recordData =
        normalizeRecordData(
            source || {}
        );

    setRecordModalData(
        recordData,
        true
    );

    const odontogramPreview =
        modal.querySelector(
            '[data-odontogram-preview]'
        );

    if (odontogramPreview) {
        odontogramPreview.dataset.odontogram =
            JSON.stringify(
                recordData.odontogramData ||
                []
            );

        odontogramPreview
            .removeAttribute(
                'data-odontogram-preview-initialized'
            );
    }

    window.openModal?.(
        'record_modal'
    );
}

export function closeRecordModal() {
    window.closeModal?.(
        'record_modal'
    );
}

function initRecordModal() {
    const modal =
        document.getElementById(
            'record_modal'
        );

    if (
        !modal ||
        modal.dataset.initialized ===
        'true'
    ) {
        return;
    }

    modal.dataset.initialized =
        'true';

    const closeBtn =
        modal.querySelector(
            '#modalCloseBtn'
        );

    const closeFooter =
        modal.querySelector(
            '#modalCloseFooter'
        );

    const card =
        modal.querySelector(
            '.ui-modal-card'
        );

    closeBtn?.addEventListener(
        'click',
        closeRecordModal
    );

    closeFooter?.addEventListener(
        'click',
        closeRecordModal
    );

    modal.addEventListener(
        'click',
        event => {
            if (
                card &&
                !card.contains(
                    event.target
                )
            ) {
                closeRecordModal();
            }
        }
    );
}
