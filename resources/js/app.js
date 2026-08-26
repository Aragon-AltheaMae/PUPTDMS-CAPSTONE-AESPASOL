import './bootstrap';

function startPageEnterAnimation() {
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            document.documentElement.classList.remove(
                'page-preload'
            );
        });
    });
}

if (document.readyState === 'loading') {
    document.addEventListener(
        'DOMContentLoaded',
        startPageEnterAnimation,
        { once: true }
    );
} else {
    startPageEnterAnimation();
}

let odontogramPreviewModulePromise = null;

async function loadOdontogramPreviewModule() {
    if (!odontogramPreviewModulePromise) {
        odontogramPreviewModulePromise =
            import('./odontogram/odontogram-preview')
                .catch(error => {
                    odontogramPreviewModulePromise = null;
                    throw error;
                });
    }

    return odontogramPreviewModulePromise;
}

window.loadOdontogramPreviewModule = loadOdontogramPreviewModule;

function preloadOdontogramPreviewWhenIdle() {
    const hasRecordAction =
        document.querySelector(
            [
                '[onclick*="openRecordModal"]',
                '[data-record]'
            ].join(',')
        );

    if (!hasRecordAction) {
        return;
    }

    const preload = async () => {
        try {
            const module =
                await window
                    .loadOdontogramPreviewModule?.();

            await module
                ?.preloadOdontogramThreeModule?.();

        } catch (_) {
        }
    };

    if (
        'requestIdleCallback'
        in window
    ) {
        window.requestIdleCallback(
            preload,
            {
                timeout: 2500
            }
        );

        return;
    }

    window.setTimeout(
        preload,
        1200
    );
}

document.addEventListener(
    'DOMContentLoaded',
    preloadOdontogramPreviewWhenIdle
);

if (
    document.querySelector(
        [
            '[data-global-voice-trigger]',
            '.voice-search-mic.external[data-voice-trigger]'
        ].join(',')
    )
) {
    import('./ui/voice-logic');
}

let bookingWorkflowModulePromise =
    null;

function loadBookingWorkflowModule() {
    if (!bookingWorkflowModulePromise) {
        bookingWorkflowModulePromise =
            import(
                './forms/booking-workflow'
            )
                .catch(error => {
                    bookingWorkflowModulePromise =
                        null;

                    throw error;
                });
    }

    return bookingWorkflowModulePromise;
}

window.loadBookingWorkflowModule = loadBookingWorkflowModule;

if (
    document.querySelector(
        '.step-content'
    )
) {
    loadBookingWorkflowModule()
        .catch(error => {
            console.error(
                'Unable to load booking workflow.',
                error
            );
        });
}

if (
    document.querySelector(
        '[data-booking-signature]'
    )
) {
    import(
        './forms/booking-signature'
    ).catch(error => {
        console.error(
            'Unable to load booking signature.',
            error
        );
    });
}

import './ui/header';
import './ui/pagination-bar';
import './ui/show-more';
import './ui/profile-avatar';
import './ui/search-bar';
import './ui/empty-state';
import './ui/filter-select';

import './core/helpers';
import './core/theme';
import './core/sidebar';
import './core/modal';
import './core/toast';
import './core/session';

import './ui/custom-select';
import './ui/preview-zoom';
import './ui/delete-confirm';
import './ui/date-picker';
import './ui/assistive';
import './ui/tooltips';
import './ui/input-clear';
import './ui/header-controls';
import './ui/filter-drawer';
import './ui/filter-controls';
import './ui/patient-name';
import './ui/view-toggle';
import './ui/refresh-watcher';
import './ui/page-size';
import './ui/back-to-top';

import './forms/validation';

import './appointments/status-meta';

let chartJsPromise = null;

async function loadChartJs() {
    if (window.Chart) {
        return window.Chart;
    }

    if (!chartJsPromise) {
        chartJsPromise =
            import(
                'chart.js/auto'
            )
                .then(module => {
                    window.Chart =
                        module.default;

                    return (
                        module.default
                    );
                })
                .catch(error => {
                    chartJsPromise =
                        null;

                    throw error;
                });
    }

    return chartJsPromise;
}

window.loadChartJs =
    loadChartJs;

import {
    swapSkeletonContent,
    renderWithStagger,
    runEnterpriseLoading,
    setDashboardLoadingStatus,
    finishDashboardLoading
} from './ui/skeleton';

window.swapSkeletonContent = swapSkeletonContent;
window.renderWithStagger = renderWithStagger;
window.runEnterpriseLoading = runEnterpriseLoading;
window.setDashboardLoadingStatus = setDashboardLoadingStatus;
window.finishDashboardLoading = finishDashboardLoading;

document.addEventListener(
    'ui-modal:opened',
    async function (event) {
        const modal =
            event.detail?.modal ||
            document;

        window.initCharLimitFields?.(modal);
        window.initSearchClearButtons?.(modal);
        window.initGlobalVoiceInputs?.(modal);

        const hasOdontogramPreview =
            modal.matches?.(
                '[data-odontogram-preview]'
            ) ||
            modal.querySelector?.(
                '[data-odontogram-preview]'
            );

        if (!hasOdontogramPreview) {
            return;
        }

        try {
            const module =
                await loadOdontogramPreviewModule();

            module.initOdontogramPreviews?.(
                modal
            );
        } catch (error) {
            console.error(
                'Unable to load odontogram preview.',
                error
            );
        }
    }
);