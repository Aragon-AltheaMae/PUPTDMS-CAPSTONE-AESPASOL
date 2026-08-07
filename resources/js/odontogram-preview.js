import {
    createOdontogramThreeScene,
    updateOdontogramThreeScene,
    resizeOdontogramThreeScene,
    resetOdontogramThreeCamera,
    focusOdontogramThreeTooth,
    getOdontogramThreeToothMesh
} from './odontogram/odontogram-three';

const ODONTOGRAM_PREVIEW_COLORS = {
    D: '#ef4444',
    M: '#111827',
    F: '#2563eb',
    I: '#ef4444',
    RF: '#ef4444',
    MO: '#111827',
    IM: '#111827',
    J: '#2563eb',
    A: '#2563eb',
    AB: '#2563eb',
    P: '#2563eb',
    IN: '#2563eb',
    LC: '#2563eb',
    RM: '#2563eb',
    X: '#2563eb',
    XO: '#2563eb',
    '✓': '#111827',
    CM: '#111827',
    SP: '#111827'
};

const ODONTOGRAM_PREVIEW_SURFACES = [
    'top',
    'left',
    'center',
    'right',
    'bottom'
];

const ODONTOGRAM_PREVIEW_TEETH = {
    upperRight: [
        18, 17, 16, 15,
        14, 13, 12, 11
    ],

    upperLeft: [
        21, 22, 23, 24,
        25, 26, 27, 28
    ],

    lowerRight: [
        48, 47, 46, 45,
        44, 43, 42, 41
    ],

    lowerLeft: [
        31, 32, 33, 34,
        35, 36, 37, 38
    ]
};

function getOdontogramPreviewToothName(
    tooth
) {
    const typeIndex =
        Number(String(tooth).slice(-1));

    const typeNames = {
        1: 'Central Incisor',
        2: 'Lateral Incisor',
        3: 'Canine',
        4: '1st Premolar',
        5: '2nd Premolar',
        6: '1st Molar',
        7: '2nd Molar',
        8: '3rd Molar'
    };

    const firstDigit =
        Number(String(tooth)[0]);

    const quadrantNames = {
        1: 'Upper Right',
        2: 'Upper Left',
        3: 'Lower Left',
        4: 'Lower Right'
    };

    return {
        quadrant:
            quadrantNames[firstDigit] ||
            'Unknown',

        type:
            typeNames[typeIndex] ||
            'Tooth',

        arch:
            [1, 2].includes(firstDigit)
                ? 'Maxillary (Upper)'
                : 'Mandibular (Lower)'
    };
}

function normalizeOdontogramPreviewRecord(
    record
) {
    if (!record) return null;

    const code =
        String(
            record.code ||
            ''
        )
            .trim()
            .toUpperCase();

    if (!code) return null;

    return {
        ...record,

        code:
            ['PT', '+'].includes(code)
                ? '✓'
                : code,

        label:
            record.label ||
            code,

        colorHex:
            record.colorHex ||
            ODONTOGRAM_PREVIEW_COLORS[
            code
            ] ||
            '#111827'
    };
}

function normalizeOdontogramPreviewEntry(
    entry
) {
    if (!entry) return null;

    const tooth =
        Number(
            entry.tooth ||
            entry.tooth_number ||
            0
        );

    if (!tooth) return null;

    const surfaces =
        entry.surfaces &&
            typeof entry.surfaces === 'object' &&
            !Array.isArray(entry.surfaces)
            ? entry.surfaces
            : {};

    return {
        tooth,

        status:
            normalizeOdontogramPreviewRecord(
                entry.status
            ),

        threeD:
            normalizeOdontogramPreviewRecord(
                entry.threeD ||
                entry.three_d
            ),

        surfaces:
            Object.fromEntries(
                ODONTOGRAM_PREVIEW_SURFACES
                    .map(surface => [
                        surface,
                        normalizeOdontogramPreviewRecord(
                            surfaces[surface]
                        )
                    ])
            )
    };
}

function getOdontogramPreviewRecord(
    root,
    tooth
) {
    return root.__odontogramPreviewData
        ?.find(
            item =>
                Number(item.tooth) ===
                Number(tooth)
        ) || null;
}

function getOdontogramPreviewPrimaryMark(
    record
) {
    if (!record) return null;

    if (record.status) {
        return record.status;
    }

    if (record.threeD) {
        return record.threeD;
    }

    return ODONTOGRAM_PREVIEW_SURFACES
        .map(
            surface =>
                record.surfaces?.[surface]
        )
        .find(Boolean) || null;
}

function openOdontogramPreviewTooth(
    root,
    tooth
) {
    if (!root) {
        return;
    }

    const panel =
        root.querySelector(
            '[data-odontogram-preview-panel]'
        );

    const toothNumber =
        Number(tooth);

    if (
        !panel ||
        !Number.isFinite(toothNumber) ||
        toothNumber <= 0
    ) {
        return;
    }

    const emptyState =
        panel.querySelector(
            '[data-odontogram-preview-empty]'
        );

    const details =
        panel.querySelector(
            '[data-odontogram-preview-details]'
        );

    if (
        !emptyState ||
        !details
    ) {
        return;
    }

    emptyState.hidden = true;
    details.hidden = false;

    const record =
        getOdontogramPreviewRecord(
            root,
            toothNumber
        );

    const info =
        getOdontogramPreviewToothName(
            toothNumber
        );

    const primary =
        getOdontogramPreviewPrimaryMark(
            record
        );

    panel.querySelector(
        '[data-odontogram-preview-title]'
    ).textContent =
        `Tooth #${toothNumber}`;

    panel.querySelector(
        '[data-odontogram-preview-subtitle]'
    ).textContent =
        `${info.quadrant} · ${info.type}`;

    panel.querySelector(
        '[data-odontogram-preview-fdi]'
    ).textContent =
        `#${toothNumber}`;

    panel.querySelector(
        '[data-odontogram-preview-quadrant]'
    ).textContent =
        info.quadrant;

    panel.querySelector(
        '[data-odontogram-preview-type]'
    ).textContent =
        info.type;

    panel.querySelector(
        '[data-odontogram-preview-arch]'
    ).textContent =
        info.arch;

    const condition =
        panel.querySelector(
            '[data-odontogram-preview-condition]'
        );

    condition.textContent =
        primary
            ? `${primary.code} - ${primary.label}`
            : 'Healthy / No saved marking';

    condition.style.removeProperty(
        'background'
    );

    condition.style.removeProperty(
        'border-color'
    );

    condition.style.removeProperty(
        'color'
    );

    condition.style.removeProperty(
        'border-color'
    );

    condition.style.removeProperty(
        'color'
    );

    if (primary?.colorHex) {
        condition.style.color =
            primary.colorHex;
    }

    const markings =
        panel.querySelector(
            '[data-odontogram-preview-markings]'
        );

    markings.replaceChildren();

    const records = [];

    if (record?.status) {
        records.push({
            surface: 'Status',
            record: record.status
        });
    }

    if (record?.threeD) {
        records.push({
            surface: '3D',
            record: record.threeD
        });
    }

    ODONTOGRAM_PREVIEW_SURFACES
        .forEach(surface => {
            const surfaceRecord =
                record?.surfaces?.[
                surface
                ];

            if (!surfaceRecord) return;

            records.push({
                surface:
                    surface.charAt(0)
                        .toUpperCase() +
                    surface.slice(1),

                record:
                    surfaceRecord
            });
        });

    if (!records.length) {
        const empty =
            document.createElement('span');

        empty.className =
            'odontogram-preview-empty-marking';

        empty.textContent =
            'No saved markings for this tooth.';

        markings.appendChild(empty);
    } else {
        records.forEach(item => {
            const pill =
                document.createElement('span');

            pill.className =
                'odontogram-preview-marking';

            pill.innerHTML = `
                <i
                    class="odontogram-preview-marking-swatch"
                    style="background:${item.record.colorHex}">
                </i>

                <span>
                    ${item.surface}: ${item.record.code} -
                    ${item.record.label}
                </span>
            `;

            markings.appendChild(pill);
        });
    }

    requestAnimationFrame(() => {
        panel
            .querySelector(
                '[data-odontogram-preview-close]'
            )
            ?.focus({
                preventScroll: true
            });
    });
}

function initOdontogramPreviews(
    root = document
) {
    const scope =
        root &&
            typeof root.querySelectorAll ===
            'function'
            ? root
            : document;

    scope
        .querySelectorAll(
            '[data-odontogram-preview]'
        )
        .forEach(preview => {

            if (
                preview.dataset
                    .odontogramPreviewInitialized !==
                'true'
            ) {
                preview.dataset
                    .odontogramPreviewInitialized =
                    'true';

                try {
                    const raw =
                        JSON.parse(
                            preview.dataset
                                .odontogram ||
                            '[]'
                        );

                    preview.__odontogramPreviewData =
                        (
                            Array.isArray(raw)
                                ? raw
                                : Object.values(
                                    raw || {}
                                )
                        )
                            .map(
                                normalizeOdontogramPreviewEntry
                            )
                            .filter(Boolean);
                } catch (_) {
                    preview.__odontogramPreviewData =
                        [];
                }
            }
            renderOdontogramPreview(
                preview
            );
        });
    showOdontogramPreviewEmptyState(
        preview
    );
}

function showOdontogramPreviewEmptyState(
    root
) {
    if (!root) {
        return;
    }

    const panel =
        root.querySelector(
            '[data-odontogram-preview-panel]'
        );

    const emptyState =
        panel?.querySelector(
            '[data-odontogram-preview-empty]'
        );

    const details =
        panel?.querySelector(
            '[data-odontogram-preview-details]'
        );

    if (!panel) {
        return;
    }

    if (emptyState) {
        emptyState.hidden = false;
    }

    if (details) {
        details.hidden = true;
    }
}

document.addEventListener(
    'DOMContentLoaded',
    () => {
        initOdontogramPreviews();
    }
);

document.addEventListener(
    'ui-modal:opened',
    event => {
        initOdontogramPreviews(
            event.detail?.modal ||
            document
        );
    }
);

window.initOdontogramPreviews =
    initOdontogramPreviews;

function setOdontogramPreviewData(
    preview,
    rawData = []
) {
    if (!preview) {
        return;
    }

    let data = rawData;

    if (typeof data === 'string') {
        try {
            data = JSON.parse(
                data || '[]'
            );
        } catch (_) {
            data = [];
        }
    }

    const normalizedData =
        (
            Array.isArray(data)
                ? data
                : Object.values(
                    data || {}
                )
        )
            .map(
                normalizeOdontogramPreviewEntry
            )
            .filter(Boolean);

    preview.__odontogramPreviewData =
        normalizedData;

    preview.dataset.odontogram =
        JSON.stringify(
            data || []
        );

    showOdontogramPreviewEmptyState(
        preview
    );

    renderOdontogramPreview(
        preview
    );
}

window.setOdontogramPreviewData =
    setOdontogramPreviewData;

const odontogramPreviewThreeStates =
    new WeakMap();

function renderOdontogramPreview(
    root
) {
    if (!root) {
        return;
    }

    const container =
        root.querySelector(
            '[data-odontogram-preview-canvas]'
        );

    const loading =
        root.querySelector(
            '[data-odontogram-preview-loading]'
        );

    if (!container) {
        return;
    }

    const width =
        container.clientWidth;

    const height =
        container.clientHeight;

    if (
        width < 10 ||
        height < 10
    ) {
        requestAnimationFrame(() => {
            renderOdontogramPreview(
                root
            );
        });

        return;
    }

    let state =
        odontogramPreviewThreeStates.get(
            root
        );

    if (!state) {
        try {
            state =
                createOdontogramThreeScene({
                    container,

                    data:
                        root
                            .__odontogramPreviewData ||
                        [],

                    mode: 'preview',

                    onToothClick:
                        tooth => {
                            openOdontogramPreviewTooth(
                                root,
                                tooth
                            );
                        },

                    onReady: () => {
                        loading?.classList.add(
                            'is-hidden'
                        );
                    }
                });

            if (!state) {
                throw new Error(
                    'Odontogram scene was not created.'
                );
            }

            odontogramPreviewThreeStates.set(
                root,
                state
            );
        } catch (error) {
            console.error(
                'Odontogram 3D preview failed:',
                error
            );

            if (loading) {
                loading.classList.remove(
                    'is-hidden'
                );

                loading.innerHTML = `
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>
                    Unable to display the 3D odontogram.
                </span>
            `;
            }
        }

        return;
    }

    updateOdontogramThreeScene(
        state,
        root.__odontogramPreviewData || []
    );
}

function resizeOdontogramPreview(
    root
) {
    const state =
        odontogramPreviewThreeStates.get(
            root
        );

    if (!state) {
        return;
    }

    resizeOdontogramThreeScene(
        state
    );
}

let odontogramPreviewResizeFrame =
    null;

window.addEventListener(
    'resize',
    () => {
        cancelAnimationFrame(
            odontogramPreviewResizeFrame
        );

        odontogramPreviewResizeFrame =
            requestAnimationFrame(
                () => {
                    document
                        .querySelectorAll(
                            '[data-odontogram-preview]'
                        )
                        .forEach(
                            resizeOdontogramPreview
                        );
                }
            );
    }
);