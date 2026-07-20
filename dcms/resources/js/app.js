import './bootstrap';
import Chart from 'chart.js/auto';
import JSVoice from 'jsvoice';

window.Chart = Chart;
window.JSVoice = JSVoice;

import {
    swapSkeletonContent,
    renderWithStagger,
    runEnterpriseLoading,
    setDashboardLoadingStatus,
    finishDashboardLoading
} from './skeleton';

import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

window.flatpickr = flatpickr;

function normalizeDateOnly(value) {
    if (!value) return null;

    const date = value instanceof Date ? new Date(value) : new Date(value);

    if (Number.isNaN(date.getTime())) return null;

    date.setHours(0, 0, 0, 0);
    return date;
}

function decorateFlatpickrDays(instance) {
    if (!instance?.calendarContainer) return;

    const minDate = normalizeDateOnly(instance.config?.minDate);
    const maxDate = normalizeDateOnly(instance.config?.maxDate);

    instance.calendarContainer.querySelectorAll('.flatpickr-day').forEach((dayElem) => {
        dayElem.classList.remove('flatpickr-has-tooltip');
        delete dayElem.dataset.tooltip;

        if (!dayElem.dateObj) return;

        const dayDate = normalizeDateOnly(dayElem.dateObj);
        if (!dayDate) return;

        if (minDate && dayDate < minDate) {
            dayElem.classList.add('flatpickr-has-tooltip');
            dayElem.dataset.tooltip = "You can't select previous date";
            return;
        }

        if (maxDate && dayDate > maxDate) {
            dayElem.classList.add('flatpickr-has-tooltip');
            dayElem.dataset.tooltip = "You can't select future date";
        }
    });
}

function syncFlatpickrHeader(instance) {
    if (!instance?.calendarContainer) return;

    const monthSelect = instance.calendarContainer.querySelector(
        '.custom-flatpickr-month'
    );

    const yearSelect = instance.calendarContainer.querySelector(
        '.custom-flatpickr-year'
    );

    if (monthSelect) {
        monthSelect.value = String(instance.currentMonth);

        const monthWrapper = monthSelect.closest('.custom-select');

        if (monthWrapper) {
            syncCustomSelect(monthWrapper);
        }
    }

    if (yearSelect) {
        yearSelect.value = String(instance.currentYear);

        const yearWrapper = yearSelect.closest('.custom-select');

        if (yearWrapper) {
            syncCustomSelect(yearWrapper);
        }
    }
}

function updateMonthOnlyInput(instance, options = {}) {
    if (!instance?.input?.matches?.('[data-month-only-picker]')) return;

    const shouldDispatch = options.dispatch !== false;
    const month = String(instance.currentMonth + 1).padStart(2, '0');
    const value = `${instance.currentYear}-${month}`;
    const label = `${instance.l10n.months.longhand[instance.currentMonth]} ${instance.currentYear}`;

    instance.input.value = value;

    if (instance.altInput) {
        instance.altInput.value = label;
    }

    if (shouldDispatch) {
        instance.input.dispatchEvent(new Event('change', { bubbles: true }));
    }
}

function buildFlatpickrHeader(instance) {
    if (!instance?.calendarContainer) return;

    const currentMonth = instance.calendarContainer.querySelector(
        '.flatpickr-current-month'
    );

    if (!currentMonth) return;

    const existing = currentMonth.querySelector(
        '.custom-flatpickr-selects'
    );

    if (existing) {
        syncFlatpickrHeader(instance);
        return;
    }

    const monthSelect = document.createElement('select');

    monthSelect.className = [
        'js-custom-select',
        'custom-flatpickr-select',
        'custom-flatpickr-month'
    ].join(' ');

    monthSelect.setAttribute('aria-label', 'Select month');

    instance.l10n.months.longhand.forEach((month, index) => {
        const option = document.createElement('option');

        option.value = String(index);
        option.textContent = month;

        monthSelect.appendChild(option);
    });

    const yearSelect = document.createElement('select');

    yearSelect.className = [
        'js-custom-select',
        'custom-flatpickr-select',
        'custom-flatpickr-year'
    ].join(' ');

    yearSelect.setAttribute('aria-label', 'Select year');

    const minimumYear =
        instance.config.minDate instanceof Date
            ? instance.config.minDate.getFullYear()
            : instance.currentYear - 80;

    const maximumYear =
        instance.config.maxDate instanceof Date
            ? instance.config.maxDate.getFullYear()
            : instance.currentYear + 10;

    for (let year = minimumYear; year <= maximumYear; year++) {
        const option = document.createElement('option');

        option.value = String(year);
        option.textContent = String(year);

        yearSelect.appendChild(option);
    }

    const wrapper = document.createElement('div');
    wrapper.className = 'custom-flatpickr-selects';

    wrapper.append(monthSelect, yearSelect);

    currentMonth.replaceChildren(wrapper);

    monthSelect.addEventListener('change', () => {
        const selectedMonth = Number(monthSelect.value);

        instance.changeMonth(
            selectedMonth - instance.currentMonth
        );

        syncFlatpickrHeader(instance);
        updateMonthOnlyInput(instance);
    });

    yearSelect.addEventListener('change', () => {
        instance.changeYear(Number(yearSelect.value));

        syncFlatpickrHeader(instance);
        updateMonthOnlyInput(instance);
    });

    initCustomSelects(currentMonth);

    syncFlatpickrHeader(instance);
}

function refreshFlatpickr(instance) {
    buildFlatpickrHeader(instance);
    decorateFlatpickrDays(instance);

    if (instance?.input?.matches?.('[data-month-only-picker]')) {
        instance.calendarContainer.classList.add('flatpickr-month-only');
    }
}

function initGlobalFlatpickr() {
    if (!window.flatpickr) return;

    const baseOptions = {
        dateFormat: "Y-m-d",
        allowInput: false,
        clickOpens: true,
        disableMobile: true,
        position: "auto center",

        onReady: (_dates, _str, instance) => refreshFlatpickr(instance),
        onMonthChange: (_dates, _str, instance) => refreshFlatpickr(instance),
        onYearChange: (_dates, _str, instance) => refreshFlatpickr(instance),

        onOpen: (_dates, _str, instance) => {
            refreshFlatpickr(instance);
            openFlatpickrSheet(instance);
        },
        onClose: (_dates, _str, instance) => {
            closeFlatpickrSheet(instance);
        },
    };


    const dateInputs = document.querySelectorAll(
        '.js-flatpickr-date, .js-flatpickr-date-min-today, .js-flatpickr-date-max-today, .js-flatpickr-date-range-from, .js-flatpickr-date-range-to'
    );

    dateInputs.forEach(el => {
        let options = { ...baseOptions };

        const parentPopup = el.closest(
            'dialog, .ui-modal, .modal-overlay'
        );

        options.appendTo = parentPopup || document.body;

        if (parentPopup) {
            options.positionElement = el;
        }

        if (el.min) {
            options.minDate = el.min;
        }

        if (el.max) {
            options.maxDate = el.max;
        }

        if (el.classList.contains('js-flatpickr-date-min-today')) {
            options.minDate = "today";
        }

        if (
            el.classList.contains('js-flatpickr-date-max-today') ||
            el.classList.contains('js-flatpickr-date-range-from') ||
            el.classList.contains('js-flatpickr-date-range-to')
        ) {
            options.maxDate = "today";
        }

        flatpickr(el, options);
    });

    const timeInputs = document.querySelectorAll('.js-flatpickr-time');

    timeInputs.forEach(el => {
        if (el._flatpickr) return;

        const parentPopup = el.closest(
            'dialog, .ui-modal, .modal-overlay'
        );

        const options = {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            altInput: true,
            altFormat: "h:i K",
            time_24hr: false,
            minuteIncrement: 5,
            allowInput: false,
            clickOpens: true,
            disableMobile: true,
            position: "auto center",
            appendTo: parentPopup || document.body,

            onOpen: (_dates, _str, instance) => {
                openFlatpickrSheet(instance);
            },

            onClose: (_dates, _str, instance) => {
                closeFlatpickrSheet(instance);
            },
        };

        if (parentPopup) {
            options.positionElement = el;
        }

        flatpickr(el, options);
    });
}

function initMonthOnlyFlatpickr(root = document) {
    if (!window.flatpickr) return;

    const scope = root && typeof root.querySelectorAll === 'function' ? root : document;

    scope.querySelectorAll('[data-month-only-picker]').forEach(el => {
        if (el._flatpickr) return;

        const parentPopup = el.closest(
            'dialog, .ui-modal, .modal-overlay'
        );
        const rawDefault = el.value || el.dataset.defaultMonth || '';
        const defaultDate = /^\d{4}-\d{2}$/.test(rawDefault)
            ? `${rawDefault}-01`
            : rawDefault || new Date();

        flatpickr(el, {
            dateFormat: 'Y-m',
            altInput: true,
            altFormat: 'F Y',
            altInputClass: 'form-input-custom service-period-input service-period-alt',
            defaultDate,
            allowInput: false,
            clickOpens: true,
            disableMobile: true,
            position: 'auto center',
            appendTo: parentPopup || document.body,
            positionElement: parentPopup ? el : undefined,

            onReady: (_dates, _str, instance) => {
                instance.calendarContainer.classList.add('flatpickr-month-only');
                refreshFlatpickr(instance);
                updateMonthOnlyInput(instance, { dispatch: false });
            },

            onOpen: (_dates, _str, instance) => {
                instance.calendarContainer.classList.add('flatpickr-month-only');
                refreshFlatpickr(instance);
                openFlatpickrSheet(instance);
            },

            onMonthChange: (_dates, _str, instance) => {
                instance.calendarContainer.classList.add('flatpickr-month-only');
                refreshFlatpickr(instance);
                updateMonthOnlyInput(instance);
            },

            onYearChange: (_dates, _str, instance) => {
                instance.calendarContainer.classList.add('flatpickr-month-only');
                refreshFlatpickr(instance);
                updateMonthOnlyInput(instance);
            },

            onClose: (_dates, _str, instance) => {
                closeFlatpickrSheet(instance);
            },
        });
    });
}

function setMonthOnlyPickerValue(inputOrSelector, value, dispatch = true) {
    const input = typeof inputOrSelector === 'string'
        ? document.querySelector(inputOrSelector)
        : inputOrSelector;

    if (!input || !value) return;

    const dateValue = /^\d{4}-\d{2}$/.test(value) ? `${value}-01` : value;

    if (input._flatpickr) {
        input._flatpickr.setDate(dateValue, false);
        refreshFlatpickr(input._flatpickr);
        updateMonthOnlyInput(input._flatpickr, { dispatch });
        return;
    }

    input.value = String(value).slice(0, 7);

    if (dispatch) {
        input.dispatchEvent(new Event('change', { bubbles: true }));
    }
}

window.initMonthOnlyFlatpickr = initMonthOnlyFlatpickr;
window.setMonthOnlyPickerValue = setMonthOnlyPickerValue;

document.addEventListener("DOMContentLoaded", () => {
    initGlobalFlatpickr();
    initMonthOnlyFlatpickr();
});

document.addEventListener('mousemove', (e) => {
    const day = e.target.closest('.flatpickr-day');

    let tooltip = document.querySelector('.flatpickr-floating-tooltip');

    if (!tooltip) {
        tooltip = document.createElement('div');
        tooltip.className = 'flatpickr-floating-tooltip';
        document.body.appendChild(tooltip);
    }

    const message = day?.dataset?.tooltip || '';

    if (!message) {
        tooltip.classList.remove('show');
        return;
    }

    tooltip.textContent = message;
    tooltip.style.left = `${e.clientX}px`;
    tooltip.style.top = `${e.clientY - 12}px`;
    tooltip.classList.add('show');
});

document.addEventListener('mouseleave', () => {
    document.querySelector('.flatpickr-floating-tooltip')?.classList.remove('show');
});

let activeFlatpickrInstance = null;

function ensureFlatpickrBackdrop() {
    let backdrop = document.querySelector('.flatpickr-mobile-backdrop');

    if (!backdrop) {
        backdrop = document.createElement('div');
        backdrop.className = 'flatpickr-mobile-backdrop';
        document.body.appendChild(backdrop);

        backdrop.addEventListener('click', () => {
            if (activeFlatpickrInstance) activeFlatpickrInstance.close();
        });
    }

    return backdrop;
}

function openFlatpickrSheet(instance) {
    activeFlatpickrInstance = instance;

    if (!window.matchMedia('(max-width: 640px)').matches) return;

    const backdrop = ensureFlatpickrBackdrop();

    document.body.classList.add('flatpickr-sheet-open');
    backdrop.classList.add('show');

    instance.calendarContainer.classList.add('flatpickr-mobile-sheet');

    requestAnimationFrame(() => {
        instance.calendarContainer.classList.add('sheet-show');
    });
}

function closeFlatpickrSheet(instance) {
    if (!window.matchMedia('(max-width: 640px)').matches) return;

    document.body.classList.remove('flatpickr-sheet-open');
    document.querySelector('.flatpickr-mobile-backdrop')?.classList.remove('show');

    instance.calendarContainer.classList.remove('sheet-show');

    setTimeout(() => {
        instance.calendarContainer.classList.remove('flatpickr-mobile-sheet', 'sheet-dragging');
        instance.calendarContainer.style.transform = '';
    }, 220);
}

function initFlatpickrSwipeClose() {
    let startY = 0;
    let dragging = false;

    document.addEventListener('touchstart', (e) => {
        const calendar = e.target.closest('.flatpickr-mobile-sheet.open');
        if (!calendar) return;

        startY = e.touches[0].clientY;
        dragging = true;
        calendar.classList.add('sheet-dragging');
    }, { passive: true });

    document.addEventListener('touchmove', (e) => {
        if (!dragging) return;

        const calendar = document.querySelector('.flatpickr-mobile-sheet.open');
        if (!calendar) return;

        const diff = Math.max(0, e.touches[0].clientY - startY);
        calendar.style.transform = `translateY(${diff}px)`;
    }, { passive: true });

    document.addEventListener('touchend', () => {
        if (!dragging) return;

        const calendar = document.querySelector('.flatpickr-mobile-sheet.open');
        if (!calendar) return;

        const matrixY = calendar.style.transform.match(/translateY\((\d+)px\)/);
        const diff = matrixY ? Number(matrixY[1]) : 0;

        calendar.classList.remove('sheet-dragging');

        if (diff > 90 && activeFlatpickrInstance) {
            activeFlatpickrInstance.close();
        } else {
            calendar.style.transform = '';
        }

        dragging = false;
    });
}

document.addEventListener('DOMContentLoaded', initFlatpickrSwipeClose);

window.swapSkeletonContent = swapSkeletonContent;
window.renderWithStagger = renderWithStagger;
window.runEnterpriseLoading = runEnterpriseLoading;
window.setDashboardLoadingStatus = setDashboardLoadingStatus;
window.finishDashboardLoading = finishDashboardLoading;

function initBackToTop() {
    let button = document.querySelector('.back-to-top');

    if (!button) {
        button = document.createElement('button');
        button.type = 'button';
        button.className = 'back-to-top floating-btn';
        button.setAttribute('aria-label', 'Back to top');
        button.setAttribute('title', 'Back to top');
        button.setAttribute('data-tooltip', 'Back to top');
        button.innerHTML = '<i class="fa-solid fa-arrow-up"></i>';

        document.body.appendChild(button);
    }

    button.setAttribute('data-tooltip', 'Back to top');
    if (button.dataset.backToTopInitialized === 'true') return;
    button.dataset.backToTopInitialized = 'true';

    const getScrollTop = () => {
        return window.scrollY ||
            document.documentElement.scrollTop ||
            document.body.scrollTop ||
            document.getElementById('mainContent')?.scrollTop ||
            0;
    };

    const scrollPageToTop = () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

        document.documentElement.scrollTo?.({
            top: 0,
            behavior: 'smooth'
        });

        document.body.scrollTo?.({
            top: 0,
            behavior: 'smooth'
        });

        const mainContent = document.getElementById('mainContent');

        if (mainContent) {
            mainContent.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    };

    const toggleButton = () => {
        button.classList.toggle('is-visible', getScrollTop() > 350);
    };

    button.addEventListener('click', event => {
        event.preventDefault();
        event.stopPropagation();
        scrollPageToTop();
    });

    window.addEventListener('scroll', toggleButton, { passive: true });
    document.getElementById('mainContent')?.addEventListener('scroll', toggleButton, { passive: true });

    toggleButton();
}

document.addEventListener('DOMContentLoaded', () => {
    initBackToTop();
    initAiHelpPopover();
});

function initAiHelpPopover() {
    if (document.querySelector('.ai-help-popover')) return;

    const popover = document.createElement('div');
    popover.className = 'ai-help-popover';
    popover.innerHTML = `
        <strong>Need help?</strong>
        <span>Open assistance tools for chatbot and accessibility options.</span>
    `;

    document.body.appendChild(popover);

    const assistiveBtn = document.getElementById('assistiveMainFab');
    if (!assistiveBtn) return;

    const showPopover = () => {
        if (document.getElementById('assistiveFabGroup')?.classList.contains('open')) return;
        popover.classList.add('show');
    };

    const hidePopover = () => {
        popover.classList.remove('show');
    };

    assistiveBtn.addEventListener('mouseenter', showPopover);
    assistiveBtn.addEventListener('focus', showPopover);

    assistiveBtn.addEventListener('mouseleave', hidePopover);
    assistiveBtn.addEventListener('blur', hidePopover);
    assistiveBtn.addEventListener('click', hidePopover);
}

function initAccessibilitySheetGesture() {
    let startY = 0;
    let currentY = 0;
    let dragging = false;

    document.addEventListener('touchstart', (e) => {
        const menu = document.querySelector('.asw-menu');
        if (!menu || !menu.contains(e.target)) return;

        startY = e.touches[0].clientY;
        currentY = startY;
        dragging = true;

        menu.classList.add('asw-dragging');
    }, { passive: true });

    document.addEventListener('touchmove', (e) => {
        if (!dragging) return;

        const menu = document.querySelector('.asw-menu');
        if (!menu) return;

        currentY = e.touches[0].clientY;
        const diff = Math.max(0, currentY - startY);

        menu.style.transform = `translateX(-50%) translateY(${diff}px)`;
    }, { passive: true });

    document.addEventListener('touchend', () => {
        if (!dragging) return;

        const menu = document.querySelector('.asw-menu');
        if (!menu) return;

        const diff = currentY - startY;

        menu.classList.remove('asw-dragging');

        if (diff > 90) {
            const closeBtn = menu.querySelector('.asw-menu-close');
            if (closeBtn) closeBtn.click();
        }

        menu.style.transform = 'translateX(-50%) translateY(0)';
        dragging = false;
    });
}

document.addEventListener('DOMContentLoaded', initAccessibilitySheetGesture);

function fixSiennaPosition() {
    const isMobile = window.matchMedia('(max-width: 640px)').matches;
    const isPatient = document.body.classList.contains('role-patient');

    const nav = document.querySelector(
        '.patient-mobile-nav, .mobile-bottom-nav, .bottom-nav, nav[class*="mobile"], #mobileBottomNav'
    );

    let navHeight = 0;

    if (isPatient && isMobile && nav) {
        navHeight = Math.ceil(nav.getBoundingClientRect().height);
    }

    if (isPatient && isMobile && navHeight < 70) {
        navHeight = 92;
    }

    const right = isMobile ? 18 : 22;
    const fabSize = isMobile ? 48 : 46;
    const gap = 14;

    const accessibilityBottom = isPatient && isMobile
        ? navHeight + 16
        : 24;

    const chatbotBottom = accessibilityBottom;
    const backTopBottom = accessibilityBottom + fabSize + gap;

    document.documentElement.style.setProperty('--float-right', `${right}px`);
    document.documentElement.style.setProperty('--float-right-final', `${right}px`);
    document.documentElement.style.setProperty('--patient-nav-height', `${navHeight}px`);
    document.documentElement.style.setProperty('--fab-final-size', `${fabSize}px`);
    document.documentElement.style.setProperty('--accessibility-bottom', `${accessibilityBottom}px`);
    document.documentElement.style.setProperty('--accessibility-bottom-final', `${accessibilityBottom}px`);
    document.documentElement.style.setProperty('--chatbot-bottom-final', `${chatbotBottom}px`);
    document.documentElement.style.setProperty('--back-top-bottom', `${backTopBottom}px`);
    document.documentElement.style.setProperty('--back-top-bottom-final', `${backTopBottom}px`);

    document.querySelectorAll('.asw-widget, .asw-menu-btn').forEach((el) => {
        el.style.setProperty('--asw-off-x', `${right}px`);
        el.style.setProperty('--asw-off-y', `${accessibilityBottom}px`);
        el.style.setProperty('--asw-right', `${right}px`);
        el.style.setProperty('--asw-bottom', `${accessibilityBottom}px`);
        el.style.right = `${right}px`;
        el.style.bottom = `${accessibilityBottom}px`;
    });
}

document.addEventListener('DOMContentLoaded', fixSiennaPosition);
window.addEventListener('load', fixSiennaPosition);
window.addEventListener('resize', fixSiennaPosition);
window.addEventListener('orientationchange', fixSiennaPosition);

function syncAssistiveFloatingState() {
    const group = document.getElementById('assistiveFabGroup');

    if (!group) return;

    const sync = () => {
        document.body.classList.toggle(
            'assistive-menu-open',
            group.classList.contains('open')
        );
    };

    sync();

    const observer = new MutationObserver(sync);

    observer.observe(group, {
        attributes: true,
        attributeFilter: ['class']
    });
}

document.addEventListener('DOMContentLoaded', syncAssistiveFloatingState);

function clearSearchInput(input, options = {}) {
    if (!input) return;

    const shouldFocus = options.focus !== false;

    input.value = '';

    input.dispatchEvent(new Event('input', { bubbles: true }));
    input.dispatchEvent(new Event('change', { bubbles: true }));

    if (shouldFocus) {
        input.focus();
    }
}

function getInputClearButton(input) {
    if (!input) return null;

    if (input.matches('[data-search-input]')) {
        return input
            .closest('[data-search-wrapper]')
            ?.querySelector(
                '[data-search-clear]'
            ) || null;
    }

    return input
        .closest('[data-clearable-field]')
        ?.querySelector(
            '[data-field-clear]'
        ) || null;
}

function syncInputClearButton(input) {
    const clearButton =
        getInputClearButton(input);

    if (!input || !clearButton) return;

    clearButton.classList.toggle(
        'show',
        String(input.value || '')
            .trim()
            .length > 0
    );
}

function bindInputClearButton(input) {
    if (
        !input ||
        input.dataset.clearButtonInitialized ===
        'true'
    ) {
        return;
    }

    const clearButton =
        getInputClearButton(input);

    if (!clearButton) return;

    input.dataset.clearButtonInitialized =
        'true';

    const sync = () => {
        syncInputClearButton(input);
    };

    input.addEventListener('input', sync);
    input.addEventListener('change', sync);

    clearButton.addEventListener(
        'click',
        event => {
            event.preventDefault();
            event.stopPropagation();

            clearSearchInput(input);
            sync();
        }
    );

    sync();
}

function initSearchClearButtons(
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
            [
                '[data-search-input]',
                '[data-clearable-input]'
            ].join(',')
        )
        .forEach(bindInputClearButton);
}

document.addEventListener(
    'reset',
    event => {
        requestAnimationFrame(() => {
            event.target
                ?.querySelectorAll?.(
                    [
                        '[data-search-input]',
                        '[data-clearable-input]'
                    ].join(',')
                )
                .forEach(
                    syncInputClearButton
                );
        });
    }
);

document.addEventListener(
    'DOMContentLoaded',
    () => {
        initSearchClearButtons();
    }
);

document.addEventListener(
    'ui-modal:opened',
    function (event) {
        const modal = event.detail?.modal || document;

        initCharLimitFields(modal);
        initSearchClearButtons(modal);
        initGlobalVoiceInputs(modal);
    }
);

window.syncInputClearButton =
    syncInputClearButton;

document.addEventListener('click', function (event) {
    const clearButton = event.target.closest('[data-clear-search]');
    if (!clearButton) return;

    event.preventDefault();

    const targetSelector = clearButton.dataset.searchTarget || '[data-search-input]';
    const input = document.querySelector(targetSelector);

    clearSearchInput(input);
});

window.clearSearchInput = clearSearchInput;
window.initSearchClearButtons = initSearchClearButtons;

function escapeToastHTML(value) {
    return String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

function formatToastMessage(message) {
    return escapeToastHTML(message)
        .replace(/&lt;strong&gt;(.*?)&lt;\/strong&gt;/g, '<strong>$1</strong>');
}

function normalizeToastArgs(first = 'success', second = '', third = undefined, fourth = undefined) {
    const validTypes = ['success', 'error', 'warning', 'info'];
    const defaultDuration = 5000;

    if (typeof first === 'object' && first !== null) {
        const type = validTypes.includes(String(first.type || '').toLowerCase())
            ? String(first.type).toLowerCase()
            : 'info';

        return {
            type,
            title: first.title || type.charAt(0).toUpperCase() + type.slice(1),
            message: first.message || '',
            duration: Number(first.duration) || defaultDuration,
        };
    }

    const firstLower = String(first || '').toLowerCase();
    const thirdLower = String(third || '').toLowerCase();

    if (validTypes.includes(firstLower)) {
        return {
            type: firstLower,
            title: firstLower.charAt(0).toUpperCase() + firstLower.slice(1),
            message: second || '',
            duration: Number(third) || defaultDuration,
        };
    }

    if (validTypes.includes(thirdLower)) {
        return {
            type: thirdLower,
            title: first || thirdLower.charAt(0).toUpperCase() + thirdLower.slice(1),
            message: second || '',
            duration: Number(fourth) || defaultDuration,
        };
    }

    return {
        type: 'info',
        title: first || 'Notification',
        message: second || '',
        duration: Number(third) || defaultDuration,
    };
}

const TOAST_MAX_VISIBLE = 3;
const activeToastRegistry = new Map();

function getToastKey(type, title, message) {
    return `${type}|${String(message || '').trim()}`;
}

function pruneToastStack(container) {
    if (!container) return;

    const visibleToasts = Array.from(
        container.querySelectorAll('.toast-item:not(.toast-exit)')
    );

    while (visibleToasts.length > TOAST_MAX_VISIBLE) {
        const oldestToast = visibleToasts.shift();

        if (oldestToast?.__closeToast) {
            oldestToast.__closeToast();
        } else {
            oldestToast?.remove();
        }
    }
}

function ensureToastContainer() {
    let container = document.getElementById('toastContainer');

    if (!container) {
        container = document.createElement('div');
        container.id = 'toastContainer';
    }

    if (container.parentElement !== document.body) {
        document.body.appendChild(container);
    }

    return container;
}

function showToast(first = 'success', second = '', third = undefined, fourth = undefined) {
    const { type, title, message, duration } = normalizeToastArgs(first, second, third, fourth);

    const container = ensureToastContainer();

    const toastKey = getToastKey(type, title, message);
    const existingToast = activeToastRegistry.get(toastKey);

    if (
        existingToast &&
        document.body.contains(existingToast) &&
        !existingToast.classList.contains('toast-exit')
    ) {
        existingToast.__restartToast?.(duration);

        existingToast.classList.remove('toast-bumped');
        void existingToast.offsetWidth;
        existingToast.classList.add('toast-bumped');

        return existingToast;
    }

    const toast = document.createElement('div');
    toast.className = `toast-item toast-${type} ${type}`;
    toast.dataset.toastKey = toastKey;
    toast.setAttribute('role', 'status');
    toast.setAttribute('aria-live', type === 'error' ? 'assertive' : 'polite');

    const icons = {
        success: 'fa-circle-check',
        error: 'fa-circle-xmark',
        warning: 'fa-triangle-exclamation',
        info: 'fa-circle-info',
    };

    toast.innerHTML = `
        <div class="toast-icon-wrap">
            <i class="fa-solid ${icons[type] || icons.info}"></i>
        </div>

        <div class="toast-content">
            <div class="toast-title">${escapeToastHTML(title)}</div>
            <div class="toast-message">${formatToastMessage(message)}</div>
        </div>

        <button type="button" class="toast-close" aria-label="Close notification">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="toast-progress"></div>
    `;

    container.appendChild(toast);
    activeToastRegistry.set(toastKey, toast);

    const progress = toast.querySelector('.toast-progress');

    let remaining = duration;
    let startedAt = Date.now();
    let timeoutId = null;
    let closed = false;

    const resetProgress = (nextDuration = duration) => {
        if (!progress) return;

        progress.style.animation = 'none';
        void progress.offsetWidth;
        progress.style.animation = `toastProgress ${nextDuration}ms linear forwards`;
    };

    const closeToast = () => {
        if (closed) return;

        closed = true;
        clearTimeout(timeoutId);

        if (activeToastRegistry.get(toastKey) === toast) {
            activeToastRegistry.delete(toastKey);
        }

        toast.classList.remove('is-paused', 'toast-bumped');
        toast.classList.add('toast-exit');

        setTimeout(() => {
            toast.remove();
        }, 320);
    };

    const startTimer = () => {
        clearTimeout(timeoutId);
        startedAt = Date.now();
        timeoutId = setTimeout(closeToast, remaining);
    };

    const restartToast = (nextDuration = duration) => {
        if (closed) return;

        clearTimeout(timeoutId);

        remaining = Number(nextDuration) || duration;
        startedAt = Date.now();

        toast.classList.remove('is-paused');
        resetProgress(remaining);

        timeoutId = setTimeout(closeToast, remaining);
    };

    const pauseToast = () => {
        if (closed) return;

        clearTimeout(timeoutId);
        remaining -= Date.now() - startedAt;
        remaining = Math.max(remaining, 0);

        toast.classList.add('is-paused');

        if (progress) {
            progress.style.animationPlayState = 'paused';
        }
    };

    const resumeToast = () => {
        if (closed) return;

        toast.classList.remove('is-paused');

        if (progress) {
            progress.style.animationPlayState = 'running';
        }

        if (remaining <= 0) {
            closeToast();
            return;
        }

        startTimer();
    };

    toast.__closeToast = closeToast;
    toast.__restartToast = restartToast;

    toast.querySelector('.toast-close')?.addEventListener('click', closeToast);

    toast.addEventListener('mouseenter', pauseToast);
    toast.addEventListener('mouseleave', resumeToast);

    resetProgress(duration);
    startTimer();
    pruneToastStack(container);

    return toast;
}

function dismissToast(toast) {
    if (!toast) return;

    const targetToast = toast.closest ? toast.closest('.toast-item') : toast;

    if (!targetToast || targetToast.classList.contains('toast-exit')) return;

    targetToast.classList.remove('is-paused');
    targetToast.classList.add('toast-exit');

    setTimeout(() => {
        targetToast.remove();
    }, 320);
}

window.showToast = showToast;
window.dismissToast = dismissToast;

function getCurrentRole() {
    const sidebar = document.getElementById('sidebar');

    if (
        document.body.classList.contains('role-admin') ||
        sidebar?.classList.contains('sidebar-admin')
    ) {
        return 'admin';
    }

    if (
        document.body.classList.contains('role-dentist') ||
        sidebar?.classList.contains('sidebar-dentist')
    ) {
        return 'dentist';
    }

    if (
        document.body.classList.contains('role-patient') ||
        sidebar?.classList.contains('sidebar-patient')
    ) {
        return 'patient';
    }

    return 'global';
}

function getSidebarStorageKey() {
    const role = getCurrentRole();

    return {
        admin: 'adminSidebarCollapsed',
        dentist: 'dentistSidebarCollapsed',
        patient: 'patientSidebarCollapsed',
        global: 'sidebarCollapsed',
    }[role] || 'sidebarCollapsed';
}

function getSidebarScrollStorageKey() {
    const role = getCurrentRole();

    return {
        admin: 'adminSidebarScrollTop',
        dentist: 'dentistSidebarScrollTop',
        patient: 'patientSidebarScrollTop',
        global: 'sidebarScrollTop',
    }[role] || 'sidebarScrollTop';
}

function initSidebarScrollMemory() {
    const sidebar = document.getElementById('sidebar');
    const sidebarInner = sidebar?.querySelector('.sidebar-inner');

    if (!sidebar || !sidebarInner) return;

    const storageKey = getSidebarScrollStorageKey();

    let isRestoring = true;
    let saveTimer = null;

    const getSavedScroll = () => {
        const saved = Number(localStorage.getItem(storageKey) || 0);
        return Number.isFinite(saved) && saved > 0 ? saved : 0;
    };

    const restoreSidebarScroll = () => {
        const savedScroll = getSavedScroll();

        if (savedScroll > 0) {
            sidebarInner.scrollTop = savedScroll;
        }
    };

    const saveSidebarScroll = () => {
        if (isRestoring) return;

        clearTimeout(saveTimer);

        saveTimer = setTimeout(() => {
            localStorage.setItem(storageKey, String(sidebarInner.scrollTop || 0));
        }, 80);
    };

    restoreSidebarScroll();

    requestAnimationFrame(() => {
        restoreSidebarScroll();

        requestAnimationFrame(() => {
            restoreSidebarScroll();
            isRestoring = false;
        });
    });

    sidebarInner.addEventListener('scroll', saveSidebarScroll, { passive: true });

    document.querySelectorAll('#sidebar a').forEach(link => {
        link.addEventListener('click', () => {
            localStorage.setItem(storageKey, String(sidebarInner.scrollTop || 0));
        });
    });

    window.addEventListener('beforeunload', () => {
        localStorage.setItem(storageKey, String(sidebarInner.scrollTop || 0));
    });

    window.addEventListener('pagehide', () => {
        localStorage.setItem(storageKey, String(sidebarInner.scrollTop || 0));
    });
}

function applyGlobalTheme(theme = 'light') {
    const nextTheme = theme === 'dark' ? 'dark' : 'light';

    document.documentElement.setAttribute('data-theme', nextTheme);
    document.documentElement.style.backgroundColor = nextTheme === 'dark' ? '#000D1A' : '#F4F4F4';

    localStorage.setItem('theme', nextTheme);

    document.querySelectorAll('.theme-option[data-theme-choice]').forEach(option => {
        option.classList.toggle('active', option.dataset.themeChoice === nextTheme);
    });

    document.querySelectorAll('.theme-indicator').forEach(indicator => {
        indicator.classList.toggle('dark-mode', nextTheme === 'dark');
    });

    document.querySelectorAll('#themeSwitchCheckbox').forEach(checkbox => {
        checkbox.checked = nextTheme === 'dark';
    });

    document.querySelectorAll('#themeIcon').forEach(icon => {
        icon.className = nextTheme === 'dark'
            ? 'fa-regular fa-moon text-gray-400 text-base'
            : 'fa-regular fa-sun text-gray-400 text-base';
    });

    window.dispatchEvent(new CustomEvent('global-theme-change', {
        detail: { theme: nextTheme }
    }));
}

function initGlobalThemeControls(root = document) {
    const scope = root && typeof root.querySelectorAll === 'function' ? root : document;
    const savedTheme = localStorage.getItem('theme') || 'light';

    applyGlobalTheme(savedTheme);

    scope.querySelectorAll('.theme-option[data-theme-choice]').forEach(option => {
        if (option.dataset.themeInitialized === 'true') return;

        option.dataset.themeInitialized = 'true';

        option.addEventListener('click', event => {
            event.preventDefault();
            event.stopPropagation();
            applyGlobalTheme(option.dataset.themeChoice || 'light');
        });
    });

    scope.querySelectorAll('#themeSwitchCheckbox').forEach(checkbox => {
        if (checkbox.dataset.themeInitialized === 'true') return;

        checkbox.dataset.themeInitialized = 'true';
        checkbox.checked = savedTheme === 'dark';

        checkbox.addEventListener('click', event => {
            event.stopPropagation();
        });

        checkbox.addEventListener('change', () => {
            applyGlobalTheme(checkbox.checked ? 'dark' : 'light');
        });
    });

    scope.querySelectorAll('#darkModeToggleItem').forEach(item => {
        if (item.dataset.themeItemInitialized === 'true') return;

        item.dataset.themeItemInitialized = 'true';

        item.addEventListener('click', event => {
            event.preventDefault();
            event.stopPropagation();

            const clickedCheckbox = event.target.closest('#themeSwitchCheckbox');

            if (clickedCheckbox) {
                return;
            }

            const checkbox = item.querySelector('#themeSwitchCheckbox');

            if (!checkbox) return;

            checkbox.checked = !checkbox.checked;
            checkbox.dispatchEvent(new Event('change', {
                bubbles: true
            }));
        });
    });
}

function initSidebarThemeDropdowns() {
    const dropdowns = document.querySelectorAll('[data-sidebar-theme-dropdown]');

    const syncThemeIcons = () => {
        const theme = localStorage.getItem('theme') || 'light';

        document.querySelectorAll('[data-sidebar-theme-icon]').forEach(icon => {
            icon.className = theme === 'dark'
                ? 'fa-regular fa-moon'
                : 'fa-solid fa-sun';
        });
    };

    dropdowns.forEach(dropdown => {
        if (dropdown.dataset.themeDropdownInitialized === 'true') return;

        dropdown.dataset.themeDropdownInitialized = 'true';

        const trigger = dropdown.querySelector('[data-sidebar-theme-trigger]');

        trigger?.addEventListener('click', event => {
            event.preventDefault();
            event.stopPropagation();

            dropdowns.forEach(item => {
                if (item !== dropdown) item.classList.remove('open');
            });

            dropdown.classList.toggle('open');
        });

        dropdown.querySelectorAll('[data-theme-choice]').forEach(option => {
            option.addEventListener('click', event => {
                event.preventDefault();
                event.stopPropagation();

                applyGlobalTheme(option.dataset.themeChoice || 'light');
                dropdown.classList.remove('open');
                setTimeout(syncThemeIcons, 0);
            });
        });
    });

    document.addEventListener('click', () => {
        dropdowns.forEach(dropdown => dropdown.classList.remove('open'));
    });

    window.addEventListener('global-theme-change', syncThemeIcons);
    syncThemeIcons();
}

function closeHeaderMenus() {
    document.getElementById('notifMenu')?.classList.remove('open', 'show');
    document.getElementById('userMenu')?.classList.remove('open', 'show');

    document.getElementById('notifBtn')?.classList.remove('active');
    document.getElementById('userBtn')?.classList.remove('active');
}

function initHeaderMenus() {
    if (window.__PUP_HEADER_JS_ACTIVE) return;

    const notifBtn = document.getElementById('notifBtn');
    const notifMenu = document.getElementById('notifMenu');
    const userBtn = document.getElementById('userBtn');
    const userMenu = document.getElementById('userMenu');

    notifBtn?.addEventListener('click', event => {
        event.preventDefault();
        event.stopPropagation();

        const willOpen = !notifMenu?.classList.contains('show');

        closeHeaderMenus();

        if (willOpen) {
            notifMenu?.classList.add('open', 'show');
            notifBtn.classList.add('active');
        }
    });

    userBtn?.addEventListener('click', event => {
        event.preventDefault();
        event.stopPropagation();

        const willOpen = !userMenu?.classList.contains('show');

        closeHeaderMenus();

        if (willOpen) {
            userMenu?.classList.add('open', 'show');
            userBtn.classList.add('active');
        }
    });

    notifMenu?.addEventListener('click', event => event.stopPropagation());
    userMenu?.addEventListener('click', event => event.stopPropagation());
}

function openDrawer() {
    const drawer = document.getElementById('mobileDrawer');
    const overlay = document.getElementById('mobileDrawerOverlay');

    if (!drawer || !overlay) return;

    overlay.classList.add('open');
    drawer.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeDrawer() {
    const drawer = document.getElementById('mobileDrawer');
    const overlay = document.getElementById('mobileDrawerOverlay');

    if (!drawer || !overlay) return;

    drawer.classList.remove('open');
    overlay.classList.remove('open');
    document.body.style.overflow = '';
}

function applySidebarState(isCollapsed) {
    const sidebar = document.getElementById('sidebar');

    if (!sidebar) return;

    const mainContent = document.getElementById('mainContent');
    const currentRole = getCurrentRole();
    const collapsed = Boolean(isCollapsed);

    if (window.innerWidth <= 767 && currentRole !== 'patient') {
        sidebar.classList.remove('collapsed');
        document.body.classList.remove('sidebar-collapsed');

        document.querySelectorAll('#sidebarIcon, #sidebarToggleIcon').forEach(icon => {
            icon.className = 'fa-solid fa-xmark';
        });

        return;
    }

    sidebar.classList.toggle('collapsed', collapsed);
    document.body.classList.toggle('sidebar-collapsed', collapsed);

    if (mainContent) {
        mainContent.classList.toggle('sidebar-content-collapsed', collapsed);
    }

    document.querySelectorAll('#sidebarIcon, #sidebarToggleIcon').forEach(icon => {
        icon.className = collapsed
            ? 'fa-solid fa-bars'
            : 'fa-solid fa-xmark';
    });

    document.querySelectorAll(
        '#sidebarToggleBtn, #desktopSidebarToggle, [data-sidebar-toggle]'
    ).forEach(button => {
        button.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
        button.setAttribute(
            'aria-label',
            collapsed ? 'Expand sidebar' : 'Collapse sidebar'
        );
    });
}

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');

    if (!sidebar) return;

    const nextState = !sidebar.classList.contains('collapsed');

    applySidebarState(nextState);

    localStorage.setItem(
        getSidebarStorageKey(),
        nextState ? '1' : '0'
    );
}

function initGlobalSidebar() {
    const sidebar = document.getElementById('sidebar');

    if (!sidebar) {
        document.documentElement.classList.remove(
            'sidebar-preload',
            'sidebar-collapsed-init'
        );
        return;
    }

    const storageKey = getSidebarStorageKey();
    const storedValue = localStorage.getItem(storageKey);
    const savedState = storedValue === '1';

    document.documentElement.classList.remove('sidebar-collapsed-init');

    applySidebarState(savedState);

    document.querySelectorAll(
        '#sidebarToggleBtn, #desktopSidebarToggle, [data-sidebar-toggle]'
    ).forEach(button => {
        if (button.dataset.sidebarInitialized === 'true') return;

        button.dataset.sidebarInitialized = 'true';

        if (!button.getAttribute('onclick')) {
            button.addEventListener('click', event => {
                event.preventDefault();
                event.stopPropagation();
                toggleSidebar();
            });
        }
    });

    requestAnimationFrame(() => {
        document.documentElement.classList.remove(
            'sidebar-preload',
            'sidebar-collapsed-init'
        );

        applySidebarState(savedState);
    });
}

function initAdminSidebarGroupClick() {
    const sidebar = document.querySelector('#sidebar.sidebar-admin');
    if (!sidebar) return;

    const groups = Array.from(sidebar.querySelectorAll('.nav-group'));

    const isCollapsed = () =>
        sidebar.classList.contains('collapsed') ||
        document.body.classList.contains('sidebar-collapsed');

    const closeGroups = () => {
        sidebar.classList.remove('has-flyout-open');

        groups.forEach(group => {
            group.classList.remove('is-flyout-open');
            group.querySelector('[data-admin-group-toggle]')?.setAttribute('aria-expanded', 'false');
        });
    };

    const openGroup = (targetGroup) => {
        sidebar.classList.add('has-flyout-open');

        groups.forEach(group => {
            const isOpen = group === targetGroup;

            group.classList.toggle('is-flyout-open', isOpen);
            group.querySelector('[data-admin-group-toggle]')?.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    };

    groups.forEach(group => {
        const trigger = group.querySelector('[data-admin-group-toggle]');
        const panel = group.querySelector('.group-body');

        if (!trigger || trigger.dataset.groupClickInitialized === 'true') return;

        trigger.dataset.groupClickInitialized = 'true';

        trigger.addEventListener('click', event => {
            if (!isCollapsed()) return;

            event.preventDefault();
            event.stopPropagation();

            const alreadyOpen = group.classList.contains('is-flyout-open');

            closeGroups();

            if (!alreadyOpen) {
                openGroup(group);
            }
        });

        panel?.addEventListener('click', event => {
            event.stopPropagation();
        });
    });

    document.addEventListener('click', event => {
        if (!sidebar.contains(event.target)) {
            closeGroups();
        }
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') {
            closeGroups();
        }
    });

    window.addEventListener('resize', () => {
        if (!isCollapsed()) {
            closeGroups();
        }
    });

    window.closeAdminSidebarGroups = closeGroups;
}

function initMobileDrawerControls() {
    const drawerButtons = document.querySelectorAll(
        '#mobileMenuBtn, [data-mobile-menu-toggle], [data-drawer-toggle]'
    );

    drawerButtons.forEach(button => {
        if (button.dataset.drawerToggleInitialized === 'true') return;

        button.dataset.drawerToggleInitialized = 'true';

        button.addEventListener('click', event => {
            event.preventDefault();
            event.stopPropagation();

            const drawer = document.getElementById('mobileDrawer');

            if (drawer?.classList.contains('open')) {
                closeDrawer();
            } else {
                openDrawer();
            }
        });
    });

    document.getElementById('mobileDrawerOverlay')?.addEventListener('click', closeDrawer);

    document.querySelectorAll('[data-drawer-close]').forEach(button => {
        if (button.dataset.drawerCloseInitialized === 'true') return;

        button.dataset.drawerCloseInitialized = 'true';

        button.addEventListener('click', event => {
            event.preventDefault();
            closeDrawer();
        });
    });
}

function initGlobalDateTime() {
    const dateEl = document.getElementById('currentDate');
    const dateIconEl = document.getElementById('currentDateIcon');

    if (!dateEl) return;

    function updateDateTime() {
        const now = new Date();

        const dateText = now.toLocaleDateString('en-US', {
            timeZone: 'Asia/Manila',
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        const timeText = now.toLocaleTimeString('en-US', {
            timeZone: 'Asia/Manila',
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });

        dateEl.textContent = `${dateText} | ${timeText}`;

        if (!dateIconEl) return;

        const hourInManila = Number(new Intl.DateTimeFormat('en-US', {
            timeZone: 'Asia/Manila',
            hour: 'numeric',
            hour12: false
        }).format(now));

        if (hourInManila >= 5 && hourInManila < 18) {
            dateIconEl.className = 'fa-solid fa-sun';
            dateIconEl.style.color = hourInManila < 12 ? '#fcd34d' : '#fb923c';
        } else {
            dateIconEl.className = 'fa-solid fa-moon';
            dateIconEl.style.color = '#c4b5fd';
        }
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);
}

function initPatientMobileFab() {
    const mobFab = document.getElementById('mobFab');
    const mobFabMenu = document.getElementById('mobFabMenu');

    if (!mobFab || !mobFabMenu) return;

    mobFab.addEventListener('click', event => {
        event.stopPropagation();

        closeHeaderMenus();

        mobFabMenu.classList.toggle('open');
        mobFab.classList.toggle('open');
    });

    mobFabMenu.addEventListener('click', event => {
        event.stopPropagation();
    });

    document.addEventListener('click', event => {
        const clickedInsideMenu = mobFabMenu.contains(event.target);
        const clickedFab = mobFab.contains(event.target);

        if (!clickedInsideMenu && !clickedFab) {
            mobFabMenu.classList.remove('open');
            mobFab.classList.remove('open');
        }
    });

    document.querySelectorAll('[data-quick-action]').forEach(button => {
        if (button.dataset.quickActionInitialized === 'true') return;

        button.dataset.quickActionInitialized = 'true';

        button.addEventListener('click', event => {
            event.preventDefault();
            event.stopPropagation();

            mobFabMenu.classList.remove('open');
            mobFab.classList.remove('open');

            if (typeof window.openQuickAction === 'function') {
                window.openQuickAction(button.dataset.quickAction);
            }
        });
    });
}

function initSessionStorageToasts() {
    const keys = ['dentistToast', 'adminToast', 'patientToast', 'globalToast'];

    keys.forEach(key => {
        const raw = sessionStorage.getItem(key);
        if (!raw) return;

        try {
            const toast = JSON.parse(raw);

            showToast({
                type: toast.type || (toast.tone === 'danger' ? 'error' : toast.tone) || 'success',
                title: toast.title || 'Notification',
                message: toast.message || '',
                duration: toast.duration || 4000,
            });
        } catch (_) {
        }

        sessionStorage.removeItem(key);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initGlobalThemeControls();
    initSidebarThemeDropdowns();
    initHeaderMenus();
    initMobileDrawerControls();
    initGlobalSidebar();
    initSidebarScrollMemory();
    initAdminSidebarGroupClick();
    initGlobalDateTime();
    initPatientMobileFab();
    initSessionStorageToasts();
});

document.addEventListener('click', event => {
    const clickedInsideHeaderMenu = event.target.closest(
        '#notifDropdown, #userDropdown'
    );

    if (clickedInsideHeaderMenu) {
        return;
    }

    closeHeaderMenus();
});

document.addEventListener('keydown', event => {
    if (event.key === 'Escape') {
        closeDrawer();
        closeHeaderMenus();
    }
});

window.addEventListener('storage', event => {
    if (event.key === 'theme') {
        applyGlobalTheme(event.newValue || 'light');
    }
});

window.applyTheme = applyGlobalTheme;
window.openDrawer = openDrawer;
window.closeDrawer = closeDrawer;
window.toggleSidebar = toggleSidebar;
window.applySidebarState = applySidebarState;

function readJsonPayload(id) {
    const el = document.getElementById(id);
    if (!el) return null;

    try {
        return JSON.parse(el.textContent || 'null');
    } catch (_) {
        return null;
    }
}

function initFlashToasts() {
    const payload = readJsonPayload('flashToastPayload');

    if (!Array.isArray(payload)) return;

    payload.forEach((toast) => {
        if (!toast || !toast.message) return;

        showToast({
            type: toast.type || 'info',
            title: toast.title || 'Notification',
            message: toast.message,
        });
    });
}

function acceptTerms() {
    const modal = document.getElementById('termsModal');

    if (modal?.open) {
        modal.close();
    }
}

function initTermsModal() {
    const modal = document.getElementById('termsModal');
    if (!modal) return;

    const checkbox = modal.querySelector('#termsCheckbox, [data-terms-checkbox]');
    const continueBtn = modal.querySelector('#termsContinueBtn, [data-terms-continue]');

    if (checkbox && continueBtn) {
        checkbox.checked = false;
        continueBtn.disabled = true;

        checkbox.addEventListener('change', () => {
            continueBtn.disabled = !checkbox.checked;
        });

        continueBtn.addEventListener('click', acceptTerms);
    }

    const shouldShow = modal.dataset.showTerms === 'true';

    if (shouldShow && typeof modal.showModal === 'function' && !modal.open) {
        requestAnimationFrame(() => {
            modal.showModal();
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    initFlashToasts();
    initTermsModal();
});

window.acceptTerms = acceptTerms;
window.initTermsModal = initTermsModal;
window.initFlashToasts = initFlashToasts;

const modalTimers = {};

function openModal(id) {
    const modal =
        document.getElementById(id);

    if (!modal) return;

    if (modalTimers[id]) {
        clearTimeout(modalTimers[id]);
        modalTimers[id] = null;
    }

    modal.classList.remove('closing');
    modal.classList.add('open');
    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.classList.add(
        'modal-lock'
    );

    document.dispatchEvent(
        new CustomEvent(
            'ui-modal:opened',
            {
                detail: {
                    modal
                }
            }
        )
    );
}

function closeModal(id) {
    const modal =
        document.getElementById(id);

    if (
        !modal ||
        (
            !modal.classList.contains('open') &&
            !modal.classList.contains('closing')
        )
    ) {
        return;
    }

    modal.classList.remove('open');
    modal.classList.add('closing');
    modal.setAttribute(
        'aria-hidden',
        'true'
    );

    if (modalTimers[id]) {
        clearTimeout(modalTimers[id]);
    }

    modalTimers[id] =
        setTimeout(() => {
            modal.classList.remove(
                'closing'
            );

            modalTimers[id] = null;

            const activeModal =
                document.querySelector(
                    [
                        '.ui-modal.open',
                        '.ui-modal.closing',
                        '.modal-overlay.open',
                        '.modal-overlay.closing'
                    ].join(',')
                );

            if (!activeModal) {
                document.body.classList.remove(
                    'modal-lock'
                );
            }
        }, 180);
}

function closeModalOnBackdrop(event, id) {
    return false;
}

document.addEventListener('keydown', function (event) {
    if (event.key !== 'Escape') return;

    const openModalEl =
        document.querySelector(
            [
                '.ui-modal.open',
                '.modal-overlay.open'
            ].join(',')
        );

    if (!openModalEl?.id) return;

    const hasDiscardForm =
        Boolean(
            openModalEl.querySelector(
                'form[data-discard-form]'
            )
        );

    if (
        hasDiscardForm &&
        window.DiscardChanges
    ) {
        event.preventDefault();
        event.stopImmediatePropagation();

        window.DiscardChanges.confirmClose(
            openModalEl,
            function () {
                closeModal(openModalEl.id);
            }
        );

        return;
    }

    closeModal(openModalEl.id);
});

window.openModal = openModal;
window.closeModal = closeModal;
window.closeModalOnBackdrop = closeModalOnBackdrop;

window.openInventoryModal = openModal;
window.closeInventoryModal = closeModal;
window.closeOnBackdrop = closeModalOnBackdrop;

function openDeleteConfirmModal({
    modalId,
    formId,
    nameId,
    action,
    itemName,
    recordId = null,
} = {}) {
    const modal =
        document.getElementById(modalId);

    const form =
        document.getElementById(formId);

    const name =
        document.getElementById(nameId);

    if (!modal || !form || !name) {
        console.error(
            'Global delete modal elements not found.',
            {
                modalId,
                formId,
                nameId,
            }
        );

        return null;
    }

    form.action =
        String(action || '');

    name.textContent =
        String(itemName || '');

    if (recordId !== null) {
        form.dataset.recordId =
            String(recordId);
    }

    openModal(modalId);

    return form;
}

window.openDeleteConfirmModal = openDeleteConfirmModal;

function openFilterDrawer(panelId = 'filterModal', overlayId = null) {
    const panel = document.getElementById(panelId);

    if (!panel) return;

    const overlay = overlayId
        ? document.getElementById(overlayId)
        : panel.querySelector('.filter-drawer-overlay');

    document.documentElement.classList.add('filter-lock');
    document.body.classList.add('filter-lock');

    panel.classList.remove('closing');
    panel.classList.add('open');
    panel.setAttribute('aria-hidden', 'false');

    overlay?.classList.add('open');
}

function closeFilterDrawer(panelId = 'filterModal', overlayId = null) {
    const panel = document.getElementById(panelId);

    if (!panel) return;

    const overlay = overlayId
        ? document.getElementById(overlayId)
        : panel.querySelector('.filter-drawer-overlay');

    overlay?.classList.remove('open');

    panel.classList.remove('open');
    panel.classList.add('closing');
    panel.setAttribute('aria-hidden', 'true');

    window.clearTimeout(panel.__filterCloseTimer);

    panel.__filterCloseTimer = window.setTimeout(() => {
        panel.classList.remove('closing');

        const anotherDrawerIsActive = document.querySelector(
            '.filter-drawer-wrapper.open, .filter-drawer-wrapper.closing'
        );

        if (!anotherDrawerIsActive) {
            document.documentElement.classList.remove('filter-lock');
            document.body.classList.remove('filter-lock');
        }
    }, 300);
}

window.openFilterDrawer = openFilterDrawer;
window.closeFilterDrawer = closeFilterDrawer;

function openFilterPanel() {
    openFilterDrawer('filterPanel', 'filterOverlay');
}

function closeFilterPanel() {
    closeFilterDrawer('filterPanel', 'filterOverlay');
}

function setFieldState(inputId, errorIdOrMessage = '', maybeMessage = null) {
    const message = maybeMessage === null ? errorIdOrMessage : maybeMessage;
    const errorId = maybeMessage === null ? `err-${inputId}` : errorIdOrMessage;

    const input = document.getElementById(inputId);
    const error = document.getElementById(errorId);

    if (!input) return;

    if (message) {
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');

        if (error) {
            error.innerHTML = `<i class="fa-solid fa-circle-exclamation" style="font-size:9px;"></i> ${message}`;
        }
    } else {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');

        if (error) {
            error.innerHTML = '';
        }
    }
}

function updateCharCounter(fieldId, max, counterId = `charCounter-${fieldId}`) {
    const field = document.getElementById(fieldId);
    const counter = document.getElementById(counterId);

    if (!field || !counter) return;

    const limit = Number(max) || 150;

    if (field.value.length > limit) {
        field.value = field.value.slice(0, limit);
    }

    const len = field.value.length;

    counter.textContent = `${len} / ${limit} characters`;
    counter.className = 'char-counter' + (len >= limit ? ' over' : len >= limit * 0.85 ? ' warn' : '');
}

function validateCharLimit(fieldId, max = 150, errorId = null) {
    const field = document.getElementById(fieldId);
    const error = errorId ? document.getElementById(errorId) : null;

    if (!field) return true;

    const limit = Number(max) || 150;

    if (field.value.length > limit) {
        field.value = field.value.slice(0, limit);
    }

    const isValid = field.value.length <= limit;

    field.classList.toggle('is-invalid', !isValid);

    if (error) {
        error.innerHTML = isValid
            ? ''
            : `<i class="fa-solid fa-circle-exclamation" style="font-size:9px;"></i> Maximum of ${limit} characters only.`;
    }

    return isValid;
}

const unsafeFormInputPatterns = [
    /<\s*\/?\s*script\b/i,
    /<\s*(iframe|object|embed|svg|math|link|meta|style)\b/i,
    /\bon[a-z]+\s*=/i,
    /\bjavascript\s*:/i,
    /\bdata\s*:\s*text\/html/i,
    /(?:^|[\s'"`])or\s+1\s*=\s*1(?:$|[\s;#\-)])/i,
    /(?:^|[\s'"`])or\s+['"]?1['"]?\s*=\s*['"]?1['"]?(?:$|[\s;#\-)])/i,
    /;\s*(drop|delete|insert|update|alter|truncate)\s+/i,
    /--\s*$/,
];

function isUnsafeFormText(value = '') {
    const decoded = document.createElement('textarea');
    decoded.innerHTML = String(value);

    return unsafeFormInputPatterns.some(pattern => pattern.test(decoded.value));
}

function isContactInput(field) {
    const key = `${field.name || ''} ${field.id || ''}`.toLowerCase();

    return /(^|[\s._-])(phone|mobile|contact[-_]?number|contact[-_]?no|emergency[-_]?number|emergency[-_]?contact[-_]?no)($|[\s._-])/.test(key);
}

function getGlobalFieldLabel(field) {
    if (!field) return 'This field';

    const explicitLabel = field.id
        ? document.querySelector(`label[for="${CSS.escape(field.id)}"]`)
        : null;

    const friendlyNames = {
        name: 'Full Name',
        email: 'Email Address',
        password: 'Password',
        password_confirmation: 'Confirm Password',
        role_id: 'Role',
        status: 'Status',
    };

    const fallbackName =
        friendlyNames[field.name] ||
        field.name ||
        'This field';

    const labelText =
        explicitLabel?.textContent ||
        field.closest('[data-global-field]')
            ?.querySelector('label')
            ?.textContent ||
        field.closest(
            '.um-field-full, .um-field-grid > div, .um-user-side-card .space-y-4 > div'
        )?.querySelector('label')?.textContent ||
        field.closest(
            '.field-group, .form-group, .st-form-group'
        )?.querySelector('label')?.textContent ||
        field.dataset.fieldLabel ||
        fallbackName;

    return String(labelText)
        .replace(/\*/g, '')
        .replace(/\s+/g, ' ')
        .trim();
}

function getFormInputValidationMessage(field) {
    if (!field || field.disabled) return '';

    if (
        field.readOnly &&
        !field.required &&
        !field.hasAttribute('data-validation-rule')
    ) {
        return '';
    }

    const type = String(field.type || '').toLowerCase();
    const value = String(field.value || '').trim();
    const label = getGlobalFieldLabel(field);

    if (type === 'radio') {
        if (!field.required) return '';

        const form = field.form || document;
        const radioGroup = form.querySelectorAll(
            `input[type="radio"][name="${CSS.escape(field.name)}"]`
        );

        const hasChecked = Array.from(radioGroup)
            .some(radio => radio.checked);

        return hasChecked
            ? ''
            : `Please select a ${label.toLowerCase()}.`;
    }

    if (type === 'checkbox') {
        return field.required && !field.checked
            ? `Please check ${label.toLowerCase()}.`
            : '';
    }

    if (field.required && !value) {
        if (field.dataset.requiredMessage) {
            return field.dataset.requiredMessage;
        }

        if (field instanceof HTMLSelectElement) {
            return `Please select a ${label.toLowerCase()}.`;
        }

        if (type === 'email') {
            return 'Please enter an email address.';
        }

        if (type === 'password') {
            if (field.name === 'password_confirmation') {
                return 'Please confirm the password.';
            }

            return 'Please enter a password.';
        }

        return `Please enter ${label.toLowerCase()}.`;
    }

    if (!value) return '';

    if (type === 'email' && !field.validity.valid) {
        return 'Please enter a valid email address.';
    }

    if (
        field.hasAttribute('minlength') &&
        value.length < Number(field.getAttribute('minlength'))
    ) {
        return `${label} must contain at least ${field.getAttribute('minlength')} characters.`;
    }
    if (
        field.name === 'password_confirmation' &&
        field.form
    ) {
        const passwordField =
            field.form.querySelector('[name="password"]');

        if (
            passwordField &&
            value !== String(passwordField.value || '')
        ) {
            return 'Passwords do not match.';
        }
    }
    if (
        field.hasAttribute('maxlength') &&
        value.length > Number(field.getAttribute('maxlength'))
    ) {
        return `${label} must not exceed ${field.getAttribute('maxlength')} characters.`;
    }

    if (field.validity.patternMismatch) {
        return field.dataset.patternMessage ||
            `Please enter a valid ${label.toLowerCase()}.`;
    }

    if (isContactInput(field)) {
        const digits = value.replace(/\D/g, '');

        if (digits && !digits.startsWith('09')) {
            return 'Contact number must start with 09.';
        }

        if (digits && digits.length !== 11) {
            return 'Contact number must contain exactly 11 digits.';
        }
    }

    if (isUnsafeFormText(value)) {
        return 'Please enter readable text only. Scripts and SQL-like input are not allowed.';
    }
    const customRuleMessage = runGlobalValidationRule(field);

    if (customRuleMessage) {
        return customRuleMessage;
    }
    return '';
}

const globalValidationRules = new Map();

function registerGlobalValidationRule(name, validator) {
    if (!name || typeof validator !== 'function') return;

    globalValidationRules.set(name, validator);
}

function runGlobalValidationRule(field) {
    const ruleName = field?.dataset?.validationRule;

    if (!ruleName) return '';

    const validator = globalValidationRules.get(ruleName);

    if (typeof validator !== 'function') return '';

    return validator(field) || '';
}

window.registerGlobalValidationRule = registerGlobalValidationRule;

registerGlobalValidationRule(
    'notFutureDate',
    function (field) {
        if (!field.value) return '';

        const picked = new Date(
            `${field.value}T00:00:00`
        );

        if (Number.isNaN(picked.getTime())) {
            return 'Please enter a valid date.';
        }

        const today = new Date();
        today.setHours(23, 59, 59, 999);

        return picked > today
            ? 'Date cannot be in the future.'
            : '';
    }
);

registerGlobalValidationRule(
    'wholeNumber',
    function (field) {
        if (!field.value) return '';

        const value = Number(field.value);

        if (
            !Number.isInteger(value) ||
            value < 0
        ) {
            return 'Please enter a whole number greater than or equal to 0.';
        }

        return '';
    }
);

registerGlobalValidationRule(
    'inventoryConsumed',
    function (field) {
        if (!field.value) return '';

        const consumed = Number(field.value);

        if (
            !Number.isInteger(consumed) ||
            consumed < 0
        ) {
            return 'Consumed must be a whole number greater than or equal to 0.';
        }

        const form = field.form;

        const quantityField =
            form?.querySelector(
                '[name="qty"]'
            );

        const quantity = Number(
            quantityField?.value || 0
        );

        return consumed > quantity
            ? 'Consumed cannot exceed quantity.'
            : '';
    }
);

const globalFormValidationRules = new Map();

function registerGlobalFormValidationRule(name, validator) {
    if (!name || typeof validator !== 'function') return;

    globalFormValidationRules.set(name, validator);
}

function runGlobalFormValidationRule(form) {
    const ruleName = form?.dataset?.formValidationRule;

    if (!ruleName) {
        return {
            valid: true,
            firstInvalid: null
        };
    }

    const validator = globalFormValidationRules.get(ruleName);

    if (typeof validator !== 'function') {
        return {
            valid: true,
            firstInvalid: null
        };
    }

    return validator(form) || {
        valid: true,
        firstInvalid: null
    };
}

function ensureGlobalGroupError(group, key) {
    if (!group) return null;

    const container =
        group.closest('[data-global-field]') ||
        group.parentElement;

    if (!container) return null;

    let error = container.querySelector(
        `.global-field-error[data-error-for="${CSS.escape(key)}"]`
    );

    if (!error) {
        error = document.createElement('div');
        error.className = 'global-field-error';
        error.dataset.errorFor = key;
        container.appendChild(error);
    }

    return error;
}

function showGlobalGroupError(group, key, message) {
    if (!group) return;

    const error = ensureGlobalGroupError(group, key);

    group.classList.toggle('is-invalid', Boolean(message));

    if (!error) return;

    error.innerHTML = message
        ? `
            <i class="fa-solid fa-circle-exclamation"></i>
            <span>${escapeHtml(message)}</span>
          `
        : '';

    error.classList.toggle('show', Boolean(message));
}

function clearGlobalGroupError(group, key) {
    showGlobalGroupError(group, key, '');
}

window.showGlobalGroupError = showGlobalGroupError;
window.clearGlobalGroupError = clearGlobalGroupError;

window.registerGlobalFormValidationRule = registerGlobalFormValidationRule;

window.dispatchEvent(
    new CustomEvent('global-validation-ready')
);

function getGlobalFieldContainer(field) {
    if (!field) return null;

    const explicitContainer = field.closest('[data-global-field]');

    if (explicitContainer) {
        return explicitContainer;
    }

    const userManagementContainer = field.closest(
        '.um-field-full, .um-field-grid > div, .um-user-side-card .space-y-4 > div'
    );

    if (userManagementContainer) {
        return userManagementContainer;
    }

    return field.closest(
        '.field-group, .form-group, .st-form-group, [data-field-wrapper]'
    ) || field.parentElement;
}

function getGlobalFieldControlHost(field) {
    if (!field) return null;

    if (field instanceof HTMLSelectElement) {
        return field.closest('.custom-select') || field;
    }

    if (field.type === 'radio' || field.type === 'checkbox') {
        return field.closest(
            '.global-choice-group, .um-status-grid, .radio-group, .checkbox-group'
        ) || field;
    }

    return field;
}

function ensureGlobalFieldError(field) {
    const container = getGlobalFieldContainer(field);

    if (!container) return null;

    const fieldKey = field.id || field.name;

    if (!fieldKey) return null;

    let error = container.querySelector(
        `.global-field-error[data-error-for="${CSS.escape(fieldKey)}"]`
    );

    if (error) {
        return error;
    }

    error = document.createElement('div');
    error.className = 'global-field-error';
    error.dataset.errorFor = fieldKey;

    container.appendChild(error);

    return error;
}

function showFormInputValidationMessage(field, message) {
    if (!field) return;

    field.setCustomValidity('');

    const hasError = Boolean(message);
    const controlHost = getGlobalFieldControlHost(field);
    const customSelect = field.closest?.('.custom-select');

    field.classList.toggle('is-invalid', hasError);

    if (
        controlHost &&
        controlHost !== field &&
        !customSelect
    ) {
        controlHost.classList.toggle('is-invalid', hasError);
    }

    customSelect?.classList.toggle('is-invalid', hasError);

    const error = ensureGlobalFieldError(field);

    if (error) {
        error.innerHTML = hasError
            ? `
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>${escapeHtml(message)}</span>
              `
            : '';

        error.classList.toggle('show', hasError);
        error.setAttribute(
            'aria-hidden',
            hasError ? 'false' : 'true'
        );
    }

    if (field.id && error) {
        error.id = `${field.id}-global-error`;

        if (hasError) {
            field.setAttribute('aria-invalid', 'true');
            field.setAttribute(
                'aria-describedby',
                error.id
            );
        } else {
            field.removeAttribute('aria-invalid');

            if (
                field.getAttribute('aria-describedby') === error.id
            ) {
                field.removeAttribute('aria-describedby');
            }
        }
    }
}

function validateFormInputField(field) {
    const message = getFormInputValidationMessage(field);

    showFormInputValidationMessage(field, message);

    return !message;
}

function focusGlobalInvalidField(field) {
    if (!field) return;

    const customSelect = field.closest?.('.custom-select');

    const target =
        customSelect?.querySelector('.custom-select-button') ||
        field;

    target.scrollIntoView({
        behavior: 'smooth',
        block: 'center'
    });

    window.setTimeout(() => {
        target.focus({
            preventScroll: true
        });
    }, 280);
}

function bindFormInputValidation(root = document) {
    const scope =
        root && typeof root.querySelectorAll === 'function'
            ? root
            : document;

    scope
        .querySelectorAll('form[data-global-validation]')
        .forEach(form => {
            if (
                form.dataset.formInputValidationInitialized === 'true'
            ) {
                return;
            }

            form.dataset.formInputValidationInitialized = 'true';

            form.setAttribute('novalidate', '');

            const validateEventField = event => {
                const field = event.target;

                if (
                    field instanceof HTMLInputElement ||
                    field instanceof HTMLTextAreaElement ||
                    field instanceof HTMLSelectElement
                ) {
                    validateFormInputField(field);
                }
            };

            form.addEventListener('input', validateEventField);
            form.addEventListener('change', validateEventField);
            form.addEventListener('blur', validateEventField, true);

            form.addEventListener('submit', event => {
                const result = validateGlobalForm(form);

                if (result.valid) return;

                event.preventDefault();
                event.stopPropagation();
            });

            const passwordField =
                form.querySelector('[name="password"]');

            const confirmationField =
                form.querySelector('[name="password_confirmation"]');

            passwordField?.addEventListener('input', () => {
                if (confirmationField?.value) {
                    validateFormInputField(confirmationField);
                }
            });
        });
}

function bindCharLimitField(field) {
    if (!field || field.dataset.charLimitInitialized === 'true') return;

    const limit = Number(field.dataset.charLimit || field.getAttribute('maxlength') || 150);
    const counterSelector = field.dataset.charCounter;
    const errorSelector = field.dataset.charError;

    const counterId = counterSelector ? counterSelector.replace('#', '') : `charCounter-${field.id}`;
    const errorId = errorSelector ? errorSelector.replace('#', '') : null;

    field.dataset.charLimitInitialized = 'true';
    field.setAttribute('maxlength', String(limit));

    const sync = () => {
        if (field.value.length > limit) {
            field.value = field.value.slice(0, limit);
        }

        updateCharCounter(field.id, limit, counterId);
        validateCharLimit(field.id, limit, errorId);
    };

    field.addEventListener('input', sync);
    field.addEventListener('change', sync);
    field.addEventListener('paste', () => {
        requestAnimationFrame(sync);
    });

    sync();
}

function initCharLimitFields(root = document) {
    root.querySelectorAll('[data-char-limit]').forEach(bindCharLimitField);
}

document.addEventListener('DOMContentLoaded', () => {
    initCharLimitFields();
    bindFormInputValidation();
});

function getGlobalNumberStepperConfig(
    stepper,
    input
) {
    const readNumber = (
        value,
        fallback
    ) => {
        const parsed = Number(value);

        return Number.isFinite(parsed)
            ? parsed
            : fallback;
    };

    return {
        min: readNumber(
            input.min ||
            stepper.dataset.min,
            Number.NEGATIVE_INFINITY
        ),

        max: readNumber(
            input.max ||
            stepper.dataset.max,
            Number.POSITIVE_INFINITY
        ),

        step: Math.abs(
            readNumber(
                input.step ||
                stepper.dataset.step,
                1
            )
        ) || 1
    };
}

function syncGlobalNumberStepper(
    stepper
) {
    const input =
        stepper.querySelector(
            '[data-number-stepper-input]'
        );

    if (!input) return;

    const {
        min,
        max
    } = getGlobalNumberStepperConfig(
        stepper,
        input
    );

    const value =
        Number(input.value);

    const hasValue =
        input.value !== '' &&
        Number.isFinite(value);

    stepper
        .querySelectorAll(
            '[data-number-step]'
        )
        .forEach(button => {
            const direction =
                Number(
                    button.dataset.numberStep
                );

            button.disabled =
                hasValue &&
                (
                    direction < 0 &&
                    value <= min ||
                    direction > 0 &&
                    value >= max
                );
        });
}

function setGlobalNumberStepperValue(
    stepper,
    nextValue
) {
    const input =
        stepper.querySelector(
            '[data-number-stepper-input]'
        );

    if (!input) return;

    const {
        min,
        max
    } = getGlobalNumberStepperConfig(
        stepper,
        input
    );

    const value = Math.max(
        min,
        Math.min(
            max,
            Number(nextValue)
        )
    );

    input.value =
        Number.isFinite(value)
            ? String(value)
            : '';

    input.dispatchEvent(
        new Event('input', {
            bubbles: true
        })
    );

    input.dispatchEvent(
        new Event('change', {
            bubbles: true
        })
    );

    syncGlobalNumberStepper(stepper);
}

function bindGlobalNumberStepper(
    stepper
) {
    if (
        !stepper ||
        stepper.dataset.numberStepperInitialized ===
        'true'
    ) {
        return;
    }

    const input =
        stepper.querySelector(
            '[data-number-stepper-input]'
        );

    if (!input) return;

    stepper.dataset.numberStepperInitialized =
        'true';

    stepper.addEventListener(
        'click',
        event => {
            const button =
                event.target.closest(
                    '[data-number-step]'
                );

            if (
                !button ||
                !stepper.contains(button)
            ) {
                return;
            }

            event.preventDefault();

            const {
                min,
                step
            } = getGlobalNumberStepperConfig(
                stepper,
                input
            );

            const current =
                input.value === ''
                    ? Number.isFinite(min)
                        ? min
                        : 0
                    : Number(input.value);

            const direction =
                Number(
                    button.dataset.numberStep
                );

            setGlobalNumberStepperValue(
                stepper,
                current +
                direction * step
            );
        }
    );

    input.addEventListener(
        'input',
        () => {
            syncGlobalNumberStepper(
                stepper
            );
        }
    );

    input.addEventListener(
        'blur',
        () => {
            if (input.value === '') return;

            setGlobalNumberStepperValue(
                stepper,
                Number(input.value)
            );
        }
    );

    input.addEventListener(
        'keydown',
        event => {
            if (
                event.key !== 'ArrowUp' &&
                event.key !== 'ArrowDown'
            ) {
                return;
            }

            event.preventDefault();

            const button =
                stepper.querySelector(
                    event.key === 'ArrowUp'
                        ? '[data-number-step="1"]'
                        : '[data-number-step="-1"]'
                );

            button?.click();
        }
    );

    syncGlobalNumberStepper(stepper);
}

function initGlobalNumberSteppers(
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
            '[data-global-number-stepper]'
        )
        .forEach(
            bindGlobalNumberStepper
        );
}

document.addEventListener(
    'DOMContentLoaded',
    () => {
        initGlobalNumberSteppers();
    }
);

document.addEventListener(
    'ui-modal:opened',
    event => {
        initGlobalNumberSteppers(
            event.detail?.modal ||
            document
        );
    }
);

window.initGlobalNumberSteppers =
    initGlobalNumberSteppers;

function validateGlobalForm(form, options = {}) {
    if (!form) {
        return {
            valid: true,
            firstInvalid: null
        };
    }

    const fields = Array.from(
        form.querySelectorAll(
            'input:not([type="hidden"]):not([type="submit"]):not([type="button"]), textarea, select'
        )
    );

    const processedRadioGroups = new Set();
    let firstInvalid = null;

    fields.forEach(field => {
        if (
            field.type === 'radio' &&
            processedRadioGroups.has(field.name)
        ) {
            return;
        }

        if (field.type === 'radio') {
            processedRadioGroups.add(field.name);
        }

        const valid = validateFormInputField(field);

        if (!valid && !firstInvalid) {
            firstInvalid = field;
        }
    });

    if (
        firstInvalid &&
        options.focus !== false
    ) {
        focusGlobalInvalidField(firstInvalid);
    }

    const customResult = runGlobalFormValidationRule(form);

    if (!customResult.valid && !firstInvalid) {
        firstInvalid = customResult.firstInvalid || null;
    }

    return {
        valid: !firstInvalid && customResult.valid,
        firstInvalid: firstInvalid || customResult.firstInvalid || null
    };
}

window.validateGlobalForm = validateGlobalForm;

window.validateCharLimit = validateCharLimit;
window.initCharLimitFields = initCharLimitFields;
window.bindFormInputValidation = bindFormInputValidation;
window.validateFormInputField = validateFormInputField;
window.focusGlobalInvalidField = focusGlobalInvalidField;
window.showFormInputValidationMessage = showFormInputValidationMessage;

function formatStockNo(input) {
    if (!input) return;

    let digits = input.value.replace(/\D/g, '');
    if (digits.length > 5) digits = digits.slice(0, 5);

    input.value = digits.length <= 2 ? digits : `${digits.slice(0, 2)}-${digits.slice(2)}`;
}

window.setFieldState = setFieldState;
window.updateCharCounter = updateCharCounter;
window.formatStockNo = formatStockNo;

const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

function escapeHtml(value = '') {
    return String(value)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

function debounce(callback, wait = 250) {
    let timeout;

    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => callback.apply(this, args), wait);
    };
}

async function requestJson(url, options = {}) {
    const response = await fetch(url, {
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken(),
            ...(options.headers || {})
        },
        ...options
    });

    const data = await response.json().catch(() => null);

    if (!response.ok) {
        const error = new Error('Request failed');
        error.response = response;
        error.data = data;
        throw error;
    }

    return data;
}

window.getCsrfToken = getCsrfToken;
window.escapeHtml = escapeHtml;
window.debounce = debounce;
window.requestJson = requestJson;

window.formatDateForInput = function (date) {
    const y = date.getFullYear();
    const m = String(date.getMonth() + 1).padStart(2, "0");
    const d = String(date.getDate()).padStart(2, "0");
    return `${y}-${m}-${d}`;
};

window.setQuickDateRange = function (days, fromId, toId) {
    const to = new Date();
    const from = new Date();

    from.setDate(to.getDate() - Number(days));

    const fromInput = document.getElementById(fromId);
    const toInput = document.getElementById(toId);

    if (fromInput) fromInput.value = window.formatDateForInput(from);
    if (toInput) toInput.value = window.formatDateForInput(to);
};

window.bindQuickDatePresets = function ({
    groupId = "datePresetGroup",
    fromId,
    toId,
    onChange
}) {
    const group = document.getElementById(groupId);
    if (!group) return;

    group.addEventListener("click", function (e) {
        const btn = e.target.closest(".quick-date-chip");
        if (!btn) return;

        group.querySelectorAll(".quick-date-chip").forEach(b => {
            b.classList.remove("active");
        });

        btn.classList.add("active");

        window.setQuickDateRange(btn.getAttribute("data-range"), fromId, toId);

        if (typeof onChange === "function") onChange();
    });

    [fromId, toId].forEach(id => {
        const input = document.getElementById(id);
        if (!input) return;

        ["input", "change"].forEach(evt => {
            input.addEventListener(evt, function () {
                group.querySelectorAll(".quick-date-chip").forEach(b => {
                    b.classList.remove("active");
                });

                if (typeof onChange === "function") onChange();
            });
        });
    });
};

window.syncFilterTagGroup = function (groupId, value) {
    const group = document.getElementById(groupId);
    if (!group) return;

    group.querySelectorAll(".ftag").forEach(btn => {
        btn.classList.toggle("ftag-active", btn.getAttribute("data-val") === value);
    });
};

window.bindFilterTagGroup = function ({
    groupId,
    onChange
}) {
    const group = document.getElementById(groupId);
    if (!group) return;

    group.addEventListener("click", function (e) {
        const btn = e.target.closest(".ftag");
        if (!btn) return;

        group.querySelectorAll(".ftag").forEach(b => {
            b.classList.remove("ftag-active");
        });

        btn.classList.add("ftag-active");

        if (typeof onChange === "function") onChange(btn.getAttribute("data-val"), btn);
    });
};

window.updateShowResultsText = function (count, targetId = "showResultsText") {
    const label = document.getElementById(targetId);
    if (!label) return;

    label.textContent = `Show ${count} ${count === 1 ? "result" : "results"}`;
};

window.APPOINTMENT_STATUS_META = {
    today: {
        label: 'Today',
        className: 'status-today',
        accentClass: 'accent-today',
        statClass: 's-today',
        icon: 'fa-calendar-day'
    },
    upcoming: {
        label: 'Upcoming',
        className: 'status-upcoming',
        accentClass: 'accent-upcoming',
        statClass: 's-upcoming',
        icon: 'fa-hourglass-half'
    },
    rescheduled: {
        label: 'Rescheduled',
        className: 'status-rescheduled',
        accentClass: 'accent-rescheduled',
        statClass: 's-rescheduled',
        icon: 'fa-rotate'
    },
    completed: {
        label: 'Completed',
        className: 'status-completed',
        accentClass: 'accent-completed',
        statClass: 's-completed',
        icon: 'fa-circle-check'
    },
    cancelled: {
        label: 'Cancelled',
        className: 'status-cancelled',
        accentClass: 'accent-cancelled',
        statClass: 's-cancelled',
        icon: 'fa-circle-xmark'
    },
    default: {
        label: 'Status',
        className: 'status-default',
        accentClass: 'accent-default',
        statClass: 's-default',
        icon: 'fa-circle'
    }
};

window.getAppointmentStatusMeta = function (status) {
    const key = String(status || '').toLowerCase().trim();
    return window.APPOINTMENT_STATUS_META[key] || window.APPOINTMENT_STATUS_META.default;
};

window.setGlobalFilterButtonState = function ({
    buttonId = 'filterBtn',
    badgeId = 'filterBadge',
    resetId = 'externalClearFilterBtn',
    count = 0
} = {}) {
    const btn = document.getElementById(buttonId);
    const badge = document.getElementById(badgeId);
    const reset = document.getElementById(resetId);

    const has = Number(count) > 0;

    if (btn) {
        btn.classList.toggle('has-filters', has);
        btn.setAttribute('aria-pressed', has ? 'true' : 'false');
    }

    if (badge) {
        badge.classList.toggle('show', has);
        badge.textContent = has ? String(count) : '';
    }

    if (reset) {
        reset.classList.toggle('hidden', !has);
        reset.classList.toggle('show', has);
    }
};

const globalRefreshWatchers = new Map();

function normalizeGlobalRefreshItems(payload, getItems) {
    const items = typeof getItems === 'function'
        ? getItems(payload)
        : Array.isArray(payload)
            ? payload
            : [];

    return Array.isArray(items) ? items : [];
}

function getGlobalRefreshNoticeId(key = 'global') {
    return `globalRefreshNotice-${String(key || 'global')}`;
}

function removeGlobalRefreshNotice(key = 'global') {
    document.getElementById(getGlobalRefreshNoticeId(key))?.remove();
}

function initGlobalRefreshWatcher(config = {}) {
    const key = config.key || 'global';

    if (globalRefreshWatchers.has(key)) {
        const existing = globalRefreshWatchers.get(key);
        existing.sync(config.initialItems || []);
        return existing;
    }

    const interval = Number(config.interval) || 15000;
    const getItems = config.getItems || ((payload) => Array.isArray(payload) ? payload : []);
    const getItemId = config.getItemId || ((item) => item?.id);
    const itemLabel = config.itemLabel || 'item';
    const anchorSelector = config.anchorSelector || '.table-card';
    const noticeId = getGlobalRefreshNoticeId(key);

    let pendingPayload = null;
    let timer = null;

    let knownIds = new Set(
        normalizeGlobalRefreshItems(config.initialItems || [], getItems)
            .map(getItemId)
            .filter((id) => id !== null && id !== undefined)
            .map(String)
    );

    const countLabel = (count) => `${itemLabel}${count === 1 ? '' : 's'}`;

    const showNotice = (count) => {
        let notice = document.getElementById(noticeId);

        if (!notice) {
            notice = document.createElement('div');
            notice.id = noticeId;
            notice.className = 'global-refresh-notice';

            const anchor = document.querySelector(anchorSelector);
            anchor?.parentNode?.insertBefore(notice, anchor);
        }

        const title = typeof config.title === 'function'
            ? config.title(count)
            : config.title || `${count} new ${countLabel(count)} available`;

        const subtitle = typeof config.subtitle === 'function'
            ? config.subtitle(count)
            : config.subtitle || `Refresh to see the latest ${countLabel(count)}.`;

        notice.innerHTML = `
            <div class="global-refresh-copy">
                <span class="global-refresh-icon">
                    <i class="fa-solid fa-rotate"></i>
                </span>

                <div>
                    <strong>${title}</strong>
                    <small>${subtitle}</small>
                </div>
            </div>

            <button type="button" class="global-refresh-btn">
                <i class="fa-solid fa-arrows-rotate"></i>
                Refresh
            </button>
        `;

        notice.querySelector('.global-refresh-btn')?.addEventListener('click', () => {
            controller.apply();
        });
    };

    const controller = {
        sync(source = []) {
            knownIds = new Set(
                normalizeGlobalRefreshItems(source, getItems)
                    .map(getItemId)
                    .filter((id) => id !== null && id !== undefined)
                    .map(String)
            );

            pendingPayload = null;
            removeGlobalRefreshNotice(key);
        },

        async check() {
            if (!config.url) return;

            try {
                const response = await fetch(config.url, {
                    cache: 'no-store',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) return;

                const payload = await response.json();
                const incoming = normalizeGlobalRefreshItems(payload, getItems);

                const newItems = incoming.filter((item) => {
                    const id = getItemId(item);
                    return id !== null && id !== undefined && !knownIds.has(String(id));
                });

                if (!newItems.length) return;

                pendingPayload = payload;
                showNotice(newItems.length);
            } catch (error) {
                console.warn(`${key} refresh check failed:`, error);
            }
        },

        apply() {
            if (!pendingPayload) return;

            if (typeof config.onRefresh === 'function') {
                config.onRefresh(pendingPayload);
            }

            this.sync(pendingPayload);

            if (config.toast !== false && typeof window.showToast === 'function') {
                window.showToast({
                    type: config.toast?.type || 'info',
                    title: config.toast?.title || 'Updated',
                    message: config.toast?.message || 'Latest records are now shown.',
                    duration: config.toast?.duration || 3500
                });
            }
        },

        start() {
            if (timer) clearInterval(timer);
            timer = setInterval(() => this.check(), interval);
        },

        stop() {
            if (timer) clearInterval(timer);
            timer = null;
            removeGlobalRefreshNotice(key);
        }
    };

    globalRefreshWatchers.set(key, controller);

    if (config.autoStart !== false) {
        controller.start();
    }

    return controller;
}

function syncGlobalRefreshWatcher(key = 'global', source = []) {
    globalRefreshWatchers.get(key)?.sync(source);
}

window.initGlobalRefreshWatcher = initGlobalRefreshWatcher;
window.syncGlobalRefreshWatcher = syncGlobalRefreshWatcher;
window.removeGlobalRefreshNotice = removeGlobalRefreshNotice;

function initGlobalViewToggles(root = document) {
    const scope =
        root &&
            typeof root.querySelectorAll === 'function'
            ? root
            : document;

    scope
        .querySelectorAll('[data-global-view-toggle]')
        .forEach(toggle => {
            if (
                toggle.dataset.globalViewInitialized ===
                'true'
            ) {
                return;
            }

            const buttons = Array.from(
                toggle.querySelectorAll(
                    '[data-view-mode]'
                )
            );

            if (!buttons.length) return;

            toggle.dataset.globalViewInitialized =
                'true';

            const pageRoot =
                document.querySelector(
                    toggle.dataset.viewRoot ||
                    '#mainContent'
                );

            const listView =
                toggle.dataset.listView
                    ? document.querySelector(
                        toggle.dataset.listView
                    )
                    : null;

            const gridView =
                toggle.dataset.gridView
                    ? document.querySelector(
                        toggle.dataset.gridView
                    )
                    : null;

            const storageKey =
                toggle.dataset.storageKey ||
                'ViewToggleMode';

            const setMode = (
                mode,
                options = {}
            ) => {
                const nextMode =
                    mode === 'grid'
                        ? 'grid'
                        : 'list';

                const isGrid =
                    nextMode === 'grid';

                if (listView) {
                    listView.hidden = isGrid;
                }

                if (gridView) {
                    gridView.hidden = !isGrid;
                }

                pageRoot?.classList.toggle(
                    'mode-grid',
                    isGrid
                );

                pageRoot?.classList.toggle(
                    'mode-list',
                    !isGrid
                );

                buttons.forEach(button => {
                    const active =
                        button.dataset.viewMode ===
                        nextMode;

                    button.classList.toggle(
                        'active',
                        active
                    );

                    button.classList.toggle(
                        'is-active',
                        active
                    );

                    button.setAttribute(
                        'aria-pressed',
                        active ? 'true' : 'false'
                    );
                });

                toggle.dataset.currentView =
                    nextMode;

                if (
                    options.persist !== false
                ) {
                    localStorage.setItem(
                        storageKey,
                        nextMode
                    );
                }

                toggle.dispatchEvent(
                    new CustomEvent(
                        'global-view-change',
                        {
                            bubbles: true,
                            detail: {
                                mode: nextMode
                            }
                        }
                    )
                );
            };

            toggle.__setGlobalViewMode =
                setMode;

            toggle.__getGlobalViewMode =
                () =>
                    toggle.dataset.currentView ||
                    localStorage.getItem(
                        storageKey
                    ) ||
                    'list';

            buttons.forEach(button => {
                button.addEventListener(
                    'click',
                    () => {
                        setMode(
                            button.dataset.viewMode
                        );
                    }
                );
            });

            const savedMode =
                localStorage.getItem(
                    storageKey
                );

            setMode(
                savedMode || 'list',
                {
                    persist: false
                }
            );
        });
}

function setGlobalViewMode(
    toggleOrId,
    mode,
    options = {}
) {
    const toggle =
        typeof toggleOrId === 'string'
            ? document.getElementById(
                toggleOrId
            ) ||
            document.querySelector(
                toggleOrId
            )
            : toggleOrId;

    if (!toggle) return;

    if (
        typeof toggle.__setGlobalViewMode !==
        'function'
    ) {
        initGlobalViewToggles(document);
    }

    toggle.__setGlobalViewMode?.(
        mode,
        options
    );
}

function getGlobalViewMode(toggleOrId) {
    const toggle =
        typeof toggleOrId === 'string'
            ? document.getElementById(
                toggleOrId
            ) ||
            document.querySelector(
                toggleOrId
            )
            : toggleOrId;

    return (
        toggle?.__getGlobalViewMode?.() ||
        toggle?.dataset.currentView ||
        'list'
    );
}

document.addEventListener(
    'DOMContentLoaded',
    () => {
        initGlobalViewToggles();
    }
);

window.initGlobalViewToggles = initGlobalViewToggles;
window.setGlobalViewMode = setGlobalViewMode;
window.getGlobalViewMode = getGlobalViewMode;


function injectGlobalPageSizeStyles() {
    if (document.getElementById('globalPageSizeStyles')) return;

    const style = document.createElement('style');
    style.id = 'globalPageSizeStyles';
    style.textContent = `
        .global-page-size-control {
            display: inline-flex !important;
            align-items: center !important;
            gap: 7px !important;
            color: #9CA3AF !important;
            font-size: .72rem !important;
            font-weight: 900 !important;
            white-space: nowrap !important;
            position: relative !important;
            z-index: 80 !important;
        }

        .global-page-size-control label,
        .global-page-size-control > span {
            color: #9CA3AF !important;
            font-size: .72rem !important;
            font-weight: 900 !important;
            line-height: 1 !important;
            white-space: nowrap !important;
        }

        .global-page-size-select {
            position: relative !important;
            width: 70px !important;
            min-width: 70px !important;
            height: 32px !important;
            z-index: 80 !important;
        }

        .global-page-size-select.open {
            z-index: 9998 !important;
        }

        .global-page-size-native {
            position: absolute !important;
            inset: 0 !important;
            width: 1px !important;
            height: 1px !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }

        .global-page-size-trigger {
            width: 100% !important;
            height: 32px !important;
            min-height: 32px !important;
            padding: 0 9px 0 11px !important;
            border-radius: 10px !important;
            border: 1px solid rgba(139, 0, 0, .14) !important;
            background:
                linear-gradient(135deg, rgba(255, 255, 255, .98), rgba(255, 247, 247, .92)) !important;
            color: #374151 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 6px !important;
            font-size: .76rem !important;
            font-weight: 950 !important;
            line-height: 1 !important;
            cursor: pointer !important;
            box-shadow:
                0 5px 12px rgba(139, 0, 0, .045),
                inset 0 1px 0 rgba(255, 255, 255, .75) !important;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease !important;
            font-family: inherit !important;
        }

        .global-page-size-trigger:hover {
            border-color: rgba(139, 0, 0, .28) !important;
            transform: translateY(-1px) !important;
        }

        .global-page-size-trigger i {
            color: #8B0000 !important;
            font-size: 8.5px !important;
            line-height: 1 !important;
            transition: transform .18s ease !important;
        }

        .global-page-size-select.open .global-page-size-trigger {
            border-color: rgba(139, 0, 0, .34) !important;
            box-shadow:
                0 0 0 3px rgba(139, 0, 0, .08),
                0 8px 18px rgba(139, 0, 0, .08) !important;
        }

        .global-page-size-select.open .global-page-size-trigger i {
            transform: rotate(180deg) !important;
        }

        .global-page-size-menu {
            position: absolute !important;
            top: calc(100% + 7px) !important;
            left: 0 !important;
            width: 82px !important;
            padding: 5px !important;
            border-radius: 13px !important;
            background:
                radial-gradient(circle at top left, rgba(139, 0, 0, .08), transparent 38%),
                #FFFFFF !important;
            border: 1px solid rgba(139, 0, 0, .12) !important;
            box-shadow: 0 18px 38px rgba(15, 23, 42, .16) !important;
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            transform: translateY(-5px) scale(.98) !important;
            transform-origin: top left !important;
            transition:
                opacity .16s ease,
                visibility .16s ease,
                transform .16s ease !important;
            z-index: 9999 !important;
        }

        .global-page-size-select.open .global-page-size-menu {
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
            transform: translateY(0) scale(1) !important;
        }

        .global-page-size-option {
            width: 100% !important;
            height: 29px !important;
            padding: 0 8px !important;
            border: 0 !important;
            border-radius: 9px !important;
            background: transparent !important;
            color: #4B5563 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 8px !important;
            font-size: .74rem !important;
            font-weight: 900 !important;
            line-height: 1 !important;
            cursor: pointer !important;
            transition: background .15s ease, color .15s ease, transform .15s ease !important;
            font-family: inherit !important;
        }

        .global-page-size-option:hover {
            background: rgba(139, 0, 0, .07) !important;
            color: #8B0000 !important;
        }

        .global-page-size-option.is-selected,
        .global-page-size-option.is-active,
        .global-page-size-option.active {
            background: #FEF2F2 !important;
            color: #8B0000 !important;
        }

        .global-page-size-option i {
            opacity: 0 !important;
            color: #8B0000 !important;
            font-size: 8.5px !important;
        }

        .global-page-size-option.is-selected i,
        .global-page-size-option.is-active i,
        .global-page-size-option.active i {
            opacity: 1 !important;
        }

        [data-theme="dark"] .global-page-size-control label,
        [data-theme="dark"] .global-page-size-control > span,
        .dark .global-page-size-control label,
        .dark .global-page-size-control > span {
            color: #94A3B8 !important;
        }

        [data-theme="dark"] .global-page-size-trigger,
        .dark .global-page-size-trigger {
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .055), rgba(255, 255, 255, .015)),
                rgba(13, 17, 23, .92) !important;
            border-color: rgba(255, 255, 255, .12) !important;
            color: #E5E7EB !important;
            box-shadow: 0 8px 18px rgba(0, 0, 0, .26) !important;
        }

        [data-theme="dark"] .global-page-size-trigger i,
        .dark .global-page-size-trigger i {
            color: #FCA5A5 !important;
        }

        [data-theme="dark"] .global-page-size-menu,
        .dark .global-page-size-menu {
            background:
                radial-gradient(circle at top left, rgba(139, 0, 0, .22), transparent 40%),
                #111827 !important;
            border-color: rgba(255, 255, 255, .12) !important;
            box-shadow: 0 18px 40px rgba(0, 0, 0, .46) !important;
        }

        [data-theme="dark"] .global-page-size-option,
        .dark .global-page-size-option {
            color: #CBD5E1 !important;
        }

        [data-theme="dark"] .global-page-size-option:hover,
        .dark .global-page-size-option:hover {
            background: rgba(139, 0, 0, .24) !important;
            color: #FCA5A5 !important;
        }

        [data-theme="dark"] .global-page-size-option.is-selected,
        [data-theme="dark"] .global-page-size-option.is-active,
        [data-theme="dark"] .global-page-size-option.active,
        .dark .global-page-size-option.is-selected,
        .dark .global-page-size-option.is-active,
        .dark .global-page-size-option.active {
            background: rgba(139, 0, 0, .32) !important;
            color: #FCA5A5 !important;
        }

        [data-theme="dark"] .global-page-size-option i,
        .dark .global-page-size-option i {
            color: #FCA5A5 !important;
        }

        @media (max-width: 767px) {
            .global-page-size-control {
                width: 100% !important;
                justify-content: flex-start !important;
                flex-wrap: wrap !important;
            }

            .global-page-size-select {
                width: 68px !important;
                min-width: 68px !important;
            }
        }
    `;

    document.head.appendChild(style);
}

function getGlobalPageSizeControl(inputOrSelector) {
    if (!inputOrSelector) return null;

    const input = typeof inputOrSelector === 'string'
        ? document.querySelector(inputOrSelector)
        : inputOrSelector;

    if (!input) return null;

    return document.querySelector(`[data-global-page-size][data-page-size-input="#${input.id}"]`)
        || input.closest('[data-global-page-size]');
}

function syncGlobalPageSizeSelect(controlOrInput, value) {
    const control = controlOrInput?.matches?.('[data-global-page-size]')
        ? controlOrInput
        : getGlobalPageSizeControl(controlOrInput);

    if (!control) return;

    const inputSelector = control.dataset.pageSizeInput;
    const nativeInput = inputSelector ? document.querySelector(inputSelector) : control.querySelector('.global-page-size-native');
    const nextValue = String(value || nativeInput?.value || control.dataset.defaultValue || '10');

    if (nativeInput) nativeInput.value = nextValue;

    control.querySelectorAll('[data-page-size-value]').forEach(label => {
        label.textContent = nextValue;
    });

    control.querySelectorAll('[data-page-size-option], .global-page-size-option').forEach(option => {
        const selected = String(option.dataset.value) === nextValue;

        option.classList.toggle('is-selected', selected);
        option.classList.toggle('is-active', selected);
        option.classList.toggle('active', selected);
        option.setAttribute('aria-selected', selected ? 'true' : 'false');
    });
}

function closeGlobalPageSizeSelect(control) {
    if (!control) return;

    control.classList.remove('open');

    const trigger = control.querySelector('[data-page-size-trigger]');
    trigger?.setAttribute('aria-expanded', 'false');
}

function openGlobalPageSizeSelect(control) {
    document.querySelectorAll('[data-global-page-size].open').forEach(item => {
        if (item !== control) closeGlobalPageSizeSelect(item);
    });

    control.classList.add('open');

    const trigger = control.querySelector('[data-page-size-trigger]');
    trigger?.setAttribute('aria-expanded', 'true');
}

function setGlobalPageSizeValue(control, value) {
    const inputSelector = control.dataset.pageSizeInput;
    const nativeInput = inputSelector ? document.querySelector(inputSelector) : control.querySelector('.global-page-size-native');
    const nextValue = String(value || '10');

    if (nativeInput) {
        nativeInput.value = nextValue;
        nativeInput.dispatchEvent(new Event('input', { bubbles: true }));
        nativeInput.dispatchEvent(new Event('change', { bubbles: true }));
    }

    syncGlobalPageSizeSelect(control, nextValue);

    const callbackName = control.dataset.pageSizeCallback;

    if (callbackName && typeof window[callbackName] === 'function') {
        window[callbackName](Number(nextValue) || nextValue, control);
    }
}

function initGlobalPageSizeSelects(root = document) {
    injectGlobalPageSizeStyles();

    const scope = root && typeof root.querySelectorAll === 'function' ? root : document;

    scope.querySelectorAll('[data-global-page-size]').forEach(control => {
        if (control.dataset.pageSizeInitialized === 'true') {
            syncGlobalPageSizeSelect(control);
            return;
        }

        control.dataset.pageSizeInitialized = 'true';

        const trigger = control.querySelector('[data-page-size-trigger]');
        const inputSelector = control.dataset.pageSizeInput;
        const nativeInput = inputSelector ? document.querySelector(inputSelector) : control.querySelector('.global-page-size-native');

        trigger?.addEventListener('click', event => {
            event.preventDefault();
            event.stopPropagation();

            control.classList.contains('open')
                ? closeGlobalPageSizeSelect(control)
                : openGlobalPageSizeSelect(control);
        });

        control.querySelectorAll('[data-page-size-option], .global-page-size-option').forEach(option => {
            option.addEventListener('click', event => {
                event.preventDefault();
                event.stopPropagation();

                setGlobalPageSizeValue(control, option.dataset.value || '10');
                closeGlobalPageSizeSelect(control);
            });
        });

        nativeInput?.addEventListener('change', () => {
            syncGlobalPageSizeSelect(control, nativeInput.value);
        });

        syncGlobalPageSizeSelect(control, nativeInput?.value);
    });
}

document.addEventListener('click', event => {
    if (event.target.closest('[data-global-page-size]')) return;

    document.querySelectorAll('[data-global-page-size].open').forEach(closeGlobalPageSizeSelect);
});

document.addEventListener('keydown', event => {
    if (event.key !== 'Escape') return;

    document.querySelectorAll('[data-global-page-size].open').forEach(closeGlobalPageSizeSelect);
});

document.addEventListener('DOMContentLoaded', () => {
    initGlobalPageSizeSelects();
});

window.initGlobalPageSizeSelects = initGlobalPageSizeSelects;
window.syncGlobalPageSizeSelect = syncGlobalPageSizeSelect;
window.setGlobalPageSizeValue = setGlobalPageSizeValue;

function initDashboardLogsViewToggle() {
    const root = document.getElementById('mainContent');
    const toggle = document.getElementById('dashboardLogsViewToggle');
    const listView = document.getElementById('dashboardLogsListView');
    const gridView = document.getElementById('dashboardLogsGridView');
    const buttons = document.querySelectorAll('[data-dashboard-logs-view]');

    if (!toggle || !listView || !gridView || !buttons.length) return;

    const setMode = (mode) => {
        const nextMode = mode === 'grid' ? 'grid' : 'list';
        const isGrid = nextMode === 'grid';

        listView.hidden = isGrid;
        gridView.hidden = !isGrid;

        root?.classList.toggle('mode-grid', isGrid);
        root?.classList.toggle('mode-list', !isGrid);

        buttons.forEach((button) => {
            const active = button.dataset.dashboardLogsView === nextMode;

            button.classList.toggle('active', active);
            button.setAttribute('aria-pressed', active ? 'true' : 'false');
        });

        localStorage.setItem('admin_dashboard_logs_view', nextMode);
    };

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            setMode(button.dataset.dashboardLogsView);
        });
    });

    const mobile = window.matchMedia('(max-width: 767px)').matches;
    const savedMode = localStorage.getItem('admin_dashboard_logs_view');

    setMode(mobile ? 'grid' : savedMode || 'list');
}

const activeVoiceControllers = new Map();

function getSpeechRecognitionConstructor() {
    return window.SpeechRecognition || window.webkitSpeechRecognition || null;
}

function setVoiceStatus(statusEl, message = '', state = 'default') {
    if (!statusEl) return;

    statusEl.textContent = message;
    statusEl.classList.remove('hidden', 'is-listening', 'is-success', 'is-error', 'is-default');

    if (!message) {
        statusEl.classList.add('hidden');
        return;
    }

    statusEl.classList.add(`is-${state}`);
}

function resolveVoiceTarget(button) {
    const targetSelector = button.dataset.voiceTarget;

    if (targetSelector) {
        return document.querySelector(targetSelector);
    }

    const field = button.closest('[data-voice-field], .voice-search-row, .st-voice-row');

    return field?.querySelector('input:not([type="hidden"]), textarea') || null;
}

function resolveVoiceStatus(button) {
    const statusSelector = button.dataset.voiceStatus;

    if (statusSelector) {
        return document.querySelector(statusSelector);
    }

    const field = button.closest('[data-voice-field], .voice-search-row, .st-voice-row');

    return field?.querySelector('[data-voice-status]') || null;
}

function stopActiveVoiceExcept(currentButton = null) {
    activeVoiceControllers.forEach((controller, button) => {
        if (button === currentButton) return;

        try {
            controller.recognition.stop();
        } catch (_) { }

        button.classList.remove('mic-active');
        setVoiceStatus(controller.statusEl, '', 'default');
        activeVoiceControllers.delete(button);
    });
}

function initGlobalVoiceInputs(root = document) {
    const scope = root && typeof root.querySelectorAll === 'function' ? root : document;

    const SpeechRecognition = getSpeechRecognitionConstructor();

    const buttons = scope.querySelectorAll(
        '.voice-search-mic.external[data-voice-trigger], [data-global-voice-trigger]'
    );

    buttons.forEach((button) => {
        if (button.dataset.voiceInitialized === 'true') return;

        button.dataset.voiceInitialized = 'true';

        button.addEventListener('click', () => {
            const input = resolveVoiceTarget(button);
            const statusEl = resolveVoiceStatus(button);

            if (!input) {
                setVoiceStatus(statusEl, 'No input found', 'error');
                return;
            }

            if (!SpeechRecognition) {
                setVoiceStatus(statusEl, 'Voice not supported', 'error');
                return;
            }

            if (activeVoiceControllers.has(button)) {
                const active = activeVoiceControllers.get(button);

                try {
                    active.recognition.stop();
                } catch (_) { }

                button.classList.remove('mic-active');
                setVoiceStatus(statusEl, '', 'default');
                activeVoiceControllers.delete(button);
                return;
            }

            stopActiveVoiceExcept(button);

            const recognition = new SpeechRecognition();

            recognition.lang = input.dataset.voiceLang || button.dataset.voiceLang || 'en-US';
            recognition.continuous = false;
            recognition.interimResults = true;
            recognition.maxAlternatives = 1;

            let finalTranscript = '';

            recognition.onstart = () => {
                button.classList.add('mic-active');
                setVoiceStatus(statusEl, 'Listening...', 'listening');
            };

            recognition.onresult = (event) => {
                let interimTranscript = '';

                for (let i = event.resultIndex; i < event.results.length; i++) {
                    const transcript = event.results[i][0]?.transcript?.trim() || '';

                    if (!transcript) continue;

                    if (event.results[i].isFinal) {
                        finalTranscript += ` ${transcript}`;
                    } else {
                        interimTranscript += ` ${transcript}`;
                    }
                }

                const spokenText = (finalTranscript || interimTranscript).trim();

                if (!spokenText) return;

                if (input.tagName.toLowerCase() === 'textarea' && input.value.trim()) {
                    input.value = `${input.value.trim()} ${spokenText}`.trim();
                } else {
                    input.value = spokenText;
                }

                input.dispatchEvent(new Event('input', { bubbles: true }));
                input.dispatchEvent(new Event('change', { bubbles: true }));
            };

            recognition.onerror = (event) => {
                button.classList.remove('mic-active');

                const error = event?.error || 'unknown';
                const message = error === 'not-allowed'
                    ? 'Microphone blocked'
                    : 'Voice input failed';

                setVoiceStatus(statusEl, message, 'error');
                activeVoiceControllers.delete(button);

                setTimeout(() => {
                    setVoiceStatus(statusEl, '', 'default');
                }, 1800);
            };

            recognition.onend = () => {
                button.classList.remove('mic-active');
                activeVoiceControllers.delete(button);

                if (input.value.trim()) {
                    setVoiceStatus(statusEl, 'Captured', 'success');

                    setTimeout(() => {
                        setVoiceStatus(statusEl, '', 'default');
                    }, 1200);
                } else {
                    setVoiceStatus(statusEl, '', 'default');
                }
            };

            activeVoiceControllers.set(button, {
                recognition,
                input,
                statusEl,
            });

            recognition.start();
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initGlobalVoiceInputs();
});

document.addEventListener('DOMContentLoaded', () => {
    const openModalSelector = [
        '.modal-overlay.open',
        '.ui-modal.open',
        'dialog[open]',
        '[id$="Modal"].opacity-100:not(.pointer-events-none)'
    ].join(',');

    const syncModalLock = () => {
        const hasOpenModal = !!document.querySelector(openModalSelector);

        document.documentElement.classList.toggle('modal-lock', hasOpenModal);
        document.body.classList.toggle('modal-lock', hasOpenModal);
    };

    const modalObserver = new MutationObserver(syncModalLock);

    modalObserver.observe(document.body, {
        subtree: true,
        childList: true,
        attributes: true,
        attributeFilter: ['class', 'open', 'style', 'aria-hidden']
    });

    document.addEventListener('click', () => requestAnimationFrame(syncModalLock), true);
    document.addEventListener('keydown', () => requestAnimationFrame(syncModalLock), true);

    syncModalLock();
});

window.initGlobalVoiceInputs = initGlobalVoiceInputs;

document.addEventListener('DOMContentLoaded', initDashboardLogsViewToggle);
window.initDashboardLogsViewToggle = initDashboardLogsViewToggle;

function closeCustomSelects(except = null) {
    document.querySelectorAll('.custom-select.is-open').forEach(wrapper => {
        if (wrapper === except) return;

        wrapper.classList.remove('is-open', 'drop-up');

        wrapper
            .querySelector('.custom-select-button')
            ?.setAttribute('aria-expanded', 'false');
    });
}

function syncCustomSelect(wrapper) {
    const select = wrapper.querySelector('select');
    const valueText = wrapper.querySelector('[data-custom-select-value]');
    const button = wrapper.querySelector('.custom-select-button');

    if (!select || !valueText || !button) return;

    const selectedOption = select.options[select.selectedIndex];

    valueText.textContent =
        selectedOption?.textContent?.trim() ||
        select.dataset.placeholder ||
        'Select option';

    wrapper.classList.toggle('is-disabled', select.disabled);
    wrapper.classList.toggle('has-value', Boolean(select.value));

    button.disabled = select.disabled;

    wrapper
        .querySelectorAll('.custom-select-option')
        .forEach(option => {
            const isActive =
                Number(option.dataset.index) === select.selectedIndex;

            option.classList.toggle('is-active', isActive);
            option.setAttribute(
                'aria-selected',
                isActive ? 'true' : 'false'
            );
        });
}

function positionCustomSelectMenu(wrapper) {
    if (!wrapper) return;

    const button = wrapper.querySelector('.custom-select-button');
    const menu = wrapper.querySelector('.custom-select-menu');

    if (!button || !menu) return;

    wrapper.classList.remove('drop-up');

    menu.style.removeProperty('--custom-select-max-height');

    if (wrapper.closest('.flatpickr-calendar')) {
        const isYearSelect = Boolean(
            wrapper.querySelector('.custom-flatpickr-year')
        );

        menu.style.setProperty(
            '--custom-select-max-height',
            isYearSelect ? '220px' : '210px'
        );

        return;
    }

    const buttonRect = button.getBoundingClientRect();

    const scrollContainer = wrapper.closest(
        '.um-user-modal-body, .modal-body, [data-modal-scroll], dialog'
    );

    const boundaryRect = scrollContainer?.getBoundingClientRect();

    const boundaryTop = boundaryRect
        ? Math.max(boundaryRect.top, 8)
        : 8;

    const boundaryBottom = boundaryRect
        ? Math.min(boundaryRect.bottom, window.innerHeight - 8)
        : window.innerHeight - 8;

    const spaceBelow = boundaryBottom - buttonRect.bottom - 10;
    const spaceAbove = buttonRect.top - boundaryTop - 10;

    const previousDisplay = menu.style.display;
    const previousVisibility = menu.style.visibility;
    const previousPointerEvents = menu.style.pointerEvents;

    menu.style.display = 'block';
    menu.style.visibility = 'hidden';
    menu.style.pointerEvents = 'none';

    const preferredHeight = Math.min(
        Math.max(menu.scrollHeight, 96),
        260
    );

    menu.style.display = previousDisplay;
    menu.style.visibility = previousVisibility;
    menu.style.pointerEvents = previousPointerEvents;

    const shouldOpenUp =
        spaceBelow < preferredHeight &&
        spaceAbove > spaceBelow;

    wrapper.classList.toggle('drop-up', shouldOpenUp);

    const availableSpace = shouldOpenUp
        ? spaceAbove
        : spaceBelow;

    const maxHeight = Math.max(
        96,
        Math.min(260, availableSpace)
    );

    menu.style.setProperty(
        '--custom-select-max-height',
        `${maxHeight}px`
    );
}

function initCustomSelects(root = document) {
    const scope =
        root && typeof root.querySelectorAll === 'function'
            ? root
            : document;

    const customSelectSelector = [
        'select.js-custom-select',

        '[data-global-selects] select:not([data-native-select])' +
        ':not(.global-page-size-native)' +
        ':not(.flatpickr-monthDropdown-months)'
    ].join(',');

    scope.querySelectorAll(customSelectSelector).forEach(select => {
        if (select.dataset.customSelectReady === 'true') return;

        select.dataset.customSelectReady = 'true';
        select.classList.add('custom-select-native');

        const wrapper = document.createElement('div');
        wrapper.className = 'custom-select';

        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'custom-select-button';
        button.setAttribute('aria-haspopup', 'listbox');
        button.setAttribute('aria-expanded', 'false');

        const value = document.createElement('span');
        value.dataset.customSelectValue = '';

        const icon = document.createElement('i');
        icon.className = 'fa-solid fa-chevron-down';
        icon.setAttribute('aria-hidden', 'true');

        button.append(value, icon);

        const menu = document.createElement('div');
        menu.className = 'custom-select-menu';
        menu.setAttribute('role', 'listbox');

        Array.from(select.options).forEach(option => {
            if (option.hidden || option.disabled) return;

            const item = document.createElement('button');

            item.type = 'button';
            item.className = 'custom-select-option';
            item.dataset.index = String(option.index);
            item.dataset.value = option.value;
            item.setAttribute('role', 'option');

            const label = document.createElement('span');
            label.textContent = option.textContent.trim();

            const check = document.createElement('i');
            check.className =
                'fa-solid fa-check custom-select-check';
            check.setAttribute('aria-hidden', 'true');

            item.append(label, check);

            item.addEventListener('click', event => {
                event.preventDefault();
                event.stopPropagation();

                if (select.disabled) return;

                select.selectedIndex = option.index;

                select.dispatchEvent(
                    new Event('input', { bubbles: true })
                );

                select.dispatchEvent(
                    new Event('change', { bubbles: true })
                );

                wrapper.classList.remove('is-open', 'drop-up');
                button.setAttribute('aria-expanded', 'false');

                syncCustomSelect(wrapper);
            });

            menu.appendChild(item);
        });

        select.parentNode.insertBefore(wrapper, select);

        wrapper.append(select, button, menu);

        button.addEventListener('pointerdown', event => {
            event.stopPropagation();
        });

        menu.addEventListener('pointerdown', event => {
            event.stopPropagation();
        });

        button.addEventListener('click', event => {
            event.preventDefault();
            event.stopPropagation();

            if (select.disabled) return;

            const willOpen =
                !wrapper.classList.contains('is-open');

            closeCustomSelects(wrapper);

            if (willOpen) {
                positionCustomSelectMenu(wrapper);
                wrapper.classList.add('is-open');
            } else {
                wrapper.classList.remove('is-open', 'drop-up');
            }

            button.setAttribute(
                'aria-expanded',
                willOpen ? 'true' : 'false'
            );
        });

        select.addEventListener('change', () => {
            syncCustomSelect(wrapper);
        });

        syncCustomSelect(wrapper);
    });
}

document.addEventListener('click', event => {
    if (event.target.closest('.custom-select')) return;

    closeCustomSelects();
});

document.addEventListener('keydown', event => {
    if (event.key === 'Escape') {
        closeCustomSelects();
    }
});

document.addEventListener('DOMContentLoaded', () => {
    initCustomSelects();
});

window.initCustomSelects = initCustomSelects;
window.syncCustomSelect = syncCustomSelect;