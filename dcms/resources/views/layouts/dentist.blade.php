<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dentist Portal | PUP Taguig Dental Clinic')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">

    <style>
        body {
            background-color: #F4F4F4;
            color: #333333;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            margin: 0;
        }

        .flatpickr-input[readonly],
        .flatpickr-input {
            cursor: pointer;
        }

        .flatpickr-calendar::before,
        .flatpickr-calendar::after {
            display: none !important;
        }

        .flatpickr-calendar {
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 18px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.12);
            font-family: 'Inter', sans-serif;
            overflow: visible;
            padding: 0;
            background: #ffffff;
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
        }

        .flatpickr-months {
            position: relative;
            background: linear-gradient(135deg, #8B0000, #660000);
            color: white;
            padding: 12px 14px;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px 18px 0 0;
        }

        .flatpickr-current-month {
            position: absolute !important;
            left: 50% !important;
            top: 50% !important;
            transform: translate(-50%, -50%) !important;
            width: auto !important;
            max-width: calc(100% - 96px);
            display: flex !important;
            align-items: center;
            justify-content: center;
            padding: 0 !important;
            margin: 0 !important;
            pointer-events: none;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months,
        .flatpickr-current-month input.cur-year {
            background: transparent;
            color: white;
            font-weight: 800;
            border: none;
            box-shadow: none;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months {
            cursor: pointer;
        }

        .flatpickr-weekdays {
            background: #F4F4F4;
            padding: 6px 2px;
        }

        span.flatpickr-weekday {
            color: #8B0000;
            font-size: 12px;
            font-weight: 800;
            display: flex !important;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .flatpickr-days {
            overflow: visible !important;
        }

        .flatpickr-weekdaycontainer,
        .flatpickr-days .dayContainer {
            width: 100% !important;
            justify-content: center;
        }

        .dayContainer {
            gap: 0;
            display: grid !important;
            grid-template-columns: repeat(7, 1fr);
            justify-items: center;
            align-items: center;
            overflow: visible !important;
        }

        .flatpickr-day {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 38px !important;
            max-width: 38px !important;
            height: 38px !important;
            line-height: 38px !important;
            margin: 0 auto !important;
            padding: 0 !important;
            border-radius: 12px;
            font-weight: 700;
            color: #444;
            border: 1px solid transparent;
            text-align: center !important;
        }

        .flatpickr-day:hover {
            background: #fff1f1;
            border-color: #fff1f1;
            color: #8B0000;
        }

        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange {
            background: #8B0000 !important;
            border-color: #8B0000 !important;
            color: white !important;
        }

        .flatpickr-day.selected:hover,
        .flatpickr-day.startRange:hover,
        .flatpickr-day.endRange:hover {
            background: #6b0000 !important;
            border-color: #6b0000 !important;
            color: white !important;
        }

        .flatpickr-day.today {
            border-color: #c9a84c !important;
            color: #8B0000 !important;
        }

        .flatpickr-day.today:hover {
            background: #fff8ea !important;
            border-color: #c9a84c !important;
            color: #8B0000 !important;
        }

        .flatpickr-day.prevMonthDay,
        .flatpickr-day.nextMonthDay {
            color: #d8d2cd !important;
        }

        .flatpickr-day.flatpickr-disabled,
        .flatpickr-day.prevMonthDay.flatpickr-disabled,
        .flatpickr-day.nextMonthDay.flatpickr-disabled {
            color: #d1ccc8 !important;
            cursor: not-allowed !important;
        }

        .flatpickr-months .flatpickr-prev-month,
        .flatpickr-months .flatpickr-next-month {
            color: #F4F4F4;
            top: 50% !important;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            display: flex !important;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            z-index: 5;
        }

        .flatpickr-prev-month svg,
        .flatpickr-next-month svg {
            fill: #F4F4F4 !important;
        }

        .flatpickr-months .flatpickr-prev-month:hover,
        .flatpickr-months .flatpickr-next-month:hover {
            background: rgba(255, 255, 255, 0.12);
        }

        .custom-flatpickr-selects {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: auto;
            margin: 0 auto;
            pointer-events: auto;
        }

        .custom-flatpickr-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: rgba(255, 255, 255, 0.12);
            color: #F4F4F4;
            border: 1px solid rgba(255, 255, 255, 0.14);
            outline: none;
            font-weight: 800;
            font-size: 15px;
            line-height: 1;
            cursor: pointer;
            padding: 6px 5px;
            border-radius: 10px;
            text-align: center;
            text-align-last: center;
            flex: 0 0 auto;
        }

        .custom-flatpickr-select:last-child {
            min-width: 96px;
        }

        .custom-flatpickr-select:hover,
        .custom-flatpickr-select:focus {
            background: rgba(255, 255, 255, 0.18);
            border-color: rgba(255, 255, 255, 0.75);
        }

        .custom-flatpickr-select option {
            background: #8B0000;
            color: #F4F4F4;
            font-weight: 700;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months,
        .flatpickr-current-month .numInputWrapper {
            display: none !important;
        }

        dialog,
        .modal-box-custom,
        .modal-box-split,
        .modal-scroll-body {
            position: relative;
        }

        dialog .flatpickr-calendar,
        .modal-box-custom .flatpickr-calendar,
        .modal-box-split .flatpickr-calendar,
        .modal-scroll-body .flatpickr-calendar {
            z-index: 99999 !important;
        }

        @media (max-width: 767px) {

            .flatpickr-weekdays {
                padding: 8px 12px 4px !important;
            }

            .flatpickr-weekdaycontainer {
                display: grid !important;
                grid-template-columns: repeat(7, minmax(0, 1fr)) !important;
                width: 100% !important;
                min-width: 100% !important;
                max-width: 100% !important;
                gap: 0 !important;
            }

            span.flatpickr-weekday {
                width: 100% !important;
                max-width: none !important;
                display: flex !important;
                align-items: center;
                justify-content: center;
                font-size: 11px !important;
                line-height: 1.2 !important;
                padding: 0 !important;
                margin: 0 !important;
                text-align: center !important;
            }

            .flatpickr-days {
                width: 100% !important;
                overflow-y: auto !important;
                overflow-x: hidden !important;
                padding: 0 12px calc(10px + env(safe-area-inset-bottom)) !important;
                box-sizing: border-box;
            }

            .dayContainer,
            .flatpickr-daycontainer {
                width: 100% !important;
                min-width: 100% !important;
                max-width: 100% !important;
                display: grid !important;
                grid-template-columns: repeat(7, minmax(0, 1fr)) !important;
                justify-items: center !important;
                align-items: center !important;
                gap: 4px !important;
                box-sizing: border-box;
            }

            .flatpickr-day {
                width: calc((100vw - 24px - 24px - 24px) / 7) !important;
                max-width: 42px !important;
                height: 38px !important;
                line-height: 38px !important;
                margin: 0 !important;
                padding: 0 !important;
                border-radius: 10px !important;
                font-size: 12px !important;
            }

            .flatpickr-calendar {
                position: fixed !important;
                inset: auto 0 0 0 !important;
                left: 0 !important;
                right: 0 !important;
                top: auto !important;
                bottom: 0 !important;
                width: 100vw !important;
                min-width: 100vw !important;
                max-width: 100vw !important;
                margin: 0 !important;
                transform: translate3d(0, 100%, 0) !important;
                border-radius: 24px 24px 0 0 !important;
                border: 1px solid rgba(255, 255, 255, 0.18);
                box-shadow: 0 -16px 40px rgba(0, 0, 0, 0.22);
                z-index: 99999 !important;
                opacity: 0;
                pointer-events: none;
                transition: transform .28s cubic-bezier(.4, 0, .2, 1), opacity .2s ease;
                max-height: min(72vh, 560px);
                overflow: hidden !important;
            }

            .flatpickr-calendar.open {
                transform: translate3d(0, 0, 0) !important;
                opacity: 1;
                pointer-events: auto;
            }

            .flatpickr-calendar::before,
            .flatpickr-calendar::after {
                display: none !important;
            }

            .flatpickr-innerContainer {
                display: flex !important;
                flex-direction: column;
                min-height: 0;
            }

            .flatpickr-rContainer {
                flex: 1 1 auto;
                min-height: 0;
                width: 100%;
            }

            .flatpickr-months {
                border-radius: 24px 24px 0 0 !important;
                padding-top: 16px;
            }

            .flatpickr-months::before {
                content: "";
                position: absolute;
                top: 8px;
                left: 50%;
                transform: translateX(-50%);
                width: 42px;
                height: 5px;
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.38);
            }

            .flatpickr-current-month {
                max-width: calc(100% - 84px);
            }

            body.flatpickr-mobile-sheet-open {
                overflow: hidden !important;
                touch-action: none;
            }
        }
    </style>

    @include('partials.dentist.styles')
    @include('partials.terms-styles')
    @include('partials.global-toast-styles')

    @yield('styles')

</head>

<body class="role-dentist @yield('body-class', 'bg-[#F4F4F4]')">

    @include('partials.header', [
        'role' => 'dentist',
        'notifications' => $notifications ?? [],
        'showMobileMenu' => true,
        'showSettings' => false,
    ])

    @include('partials.dentist.sidebar')
    @include('partials.dentist.drawer')

    @include('partials.impersonation-banner')

    <div id="toastContainer"></div>

    @include('components.reschedule-modal')
    @include('components.cancel-modal')

    @yield('content')

    @include('partials.footer')

    @include('partials.dentist.scripts')

    @include('partials.voice-logic')

    <script src="https://cdn.jsdelivr.net/npm/sienna-accessibility@latest/dist/sienna-accessibility.umd.js" defer></script>

    @include('partials.global-toast')

    {{-- GLOBAL TERMS MODAL --}}
    @include('partials.terms-modal')
    @include('partials.terms-scripts')

    @if (View::hasSection('usesAppointmentCalendar'))
        @include('components.appointment-calendar-script', [
            'mode' => 'booking',
            'calendarContainerId' => 'calGridWrapReschedule',
            'calGridId' => 'calGrid',
            'calMonthLabelId' => 'calMonthLabel',
            'calYearLabelId' => 'calYearLabel',
            'dateInputId' => 'new_appointment_date',
            'timeInputId' => 'new_appointment_time',
            'dateBannerId' => 'dateBanner',
            'slotPlaceholderId' => 'slotPlaceholder',
            'slotContainerId' => 'slotContainer',
            'slotGridId' => 'slotGrid',
            'selectedSlotDisplayId' => 'selectedSlotDisplay',
            'selectedSlotTextId' => 'selectedSlotText',
            'selectedTimePillId' => 'selectedTimePill',
            'selectedTimeTextId' => 'selectedTimeText',
            'datePillId' => 'datePill',
            'dateErrorId' => 'dateError',
            'timeErrorId' => 'timeError',
            'calendarWrapSelector' => '#rescheduleModal .cal-wrap',
            'slotsWrapSelector' => '#rescheduleModal .slots-wrap',
            'slotEndpoint' => route('dentist.appointment.slots'),
            'scheduleRules' => isset($schedules)
                ? $schedules
                : (isset($scheduleRules)
                    ? $scheduleRules
                    : \App\Models\ClinicSchedule::active()->get()->values()->toArray()),
            'blockedDates' => isset($blockedDates) ? $blockedDates : [],
            'appointmentCountsPerDay' => isset($appointmentCountsPerDay) ? $appointmentCountsPerDay : [],
            'philippineHolidays' => isset($philippineHolidays) ? $philippineHolidays : [],
            'disallowToday' => true,
            'allowToggleOffDate' => true,
            'useDynamicScheduleRules' => true,
            'renderStyle' => 'dentist',
        ])
    @endif

    @include('components.reschedule-modal-script')
    @include('components.cancel-modal-script')

    @stack('scripts')
    @yield('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof flatpickr === 'undefined') return;

            function enhanceFlatpickrHeader(instance) {
                if (!instance || !instance.calendarContainer) return;

                const monthContainer = instance.calendarContainer.querySelector('.flatpickr-current-month');
                if (!monthContainer) return;

                if (monthContainer.querySelector('.custom-flatpickr-selects')) return;

                const monthNames = flatpickr.l10ns.default.months.longhand;
                const currentYear = new Date().getFullYear();
                const minYear = instance.config.minDate ? new Date(instance.config.minDate).getFullYear() :
                    currentYear - 10;
                const maxYear = instance.config.maxDate ? new Date(instance.config.maxDate).getFullYear() :
                    currentYear + 10;

                const wrapper = document.createElement('div');
                wrapper.className = 'custom-flatpickr-selects';

                const monthSelect = document.createElement('select');
                monthSelect.className = 'custom-flatpickr-select';
                monthSelect.setAttribute('aria-label', 'Select month');

                monthNames.forEach((month, index) => {
                    const opt = document.createElement('option');
                    opt.value = index;
                    opt.textContent = month;
                    if (index === instance.currentMonth) opt.selected = true;
                    monthSelect.appendChild(opt);
                });

                const yearSelect = document.createElement('select');
                yearSelect.className = 'custom-flatpickr-select';
                yearSelect.setAttribute('aria-label', 'Select year');

                for (let year = maxYear; year >= minYear; year--) {
                    const opt = document.createElement('option');
                    opt.value = year;
                    opt.textContent = year;
                    if (year === instance.currentYear) opt.selected = true;
                    yearSelect.appendChild(opt);
                }

                monthSelect.addEventListener('change', function() {
                    instance.changeMonth(parseInt(this.value, 10) - instance.currentMonth);
                });

                yearSelect.addEventListener('change', function() {
                    instance.changeYear(parseInt(this.value, 10));
                });

                wrapper.appendChild(monthSelect);
                wrapper.appendChild(yearSelect);
                monthContainer.appendChild(wrapper);

                instance._customMonthSelect = monthSelect;
                instance._customYearSelect = yearSelect;
            }

            function syncFlatpickrHeader(instance) {
                if (!instance) return;
                if (instance._customMonthSelect) instance._customMonthSelect.value = String(instance.currentMonth);
                if (instance._customYearSelect) instance._customYearSelect.value = String(instance.currentYear);
            }

            function ensureMobileSheetOverlay(instance) {
                if (window.innerWidth > 767) return;

                let overlay = document.getElementById('flatpickrMobileSheetOverlay');
                if (!overlay) {
                    overlay = document.createElement('div');
                    overlay.id = 'flatpickrMobileSheetOverlay';
                    overlay.style.position = 'fixed';
                    overlay.style.inset = '0';
                    overlay.style.background = 'rgba(0,0,0,0.38)';
                    overlay.style.backdropFilter = 'blur(2px)';
                    overlay.style.webkitBackdropFilter = 'blur(2px)';
                    overlay.style.zIndex = '99998';
                    overlay.style.opacity = '0';
                    overlay.style.pointerEvents = 'none';
                    overlay.style.transition = 'opacity .2s ease';
                    overlay.addEventListener('click', function() {
                        if (instance) instance.close();
                    });
                    document.body.appendChild(overlay);
                }
                return overlay;
            }

            function openMobileSheet(instance) {
                if (window.innerWidth > 767) return;

                const overlay = ensureMobileSheetOverlay(instance);
                if (overlay) {
                    overlay.style.opacity = '1';
                    overlay.style.pointerEvents = 'auto';
                }

                document.body.classList.add('flatpickr-mobile-sheet-open');

                if (instance.calendarContainer.parentNode !== document.body) {
                    document.body.appendChild(instance.calendarContainer);
                }

                requestAnimationFrame(() => {
                    instance.calendarContainer.classList.add('open');
                });
            }

            function closeMobileSheet() {
                const overlay = document.getElementById('flatpickrMobileSheetOverlay');
                if (overlay) {
                    overlay.style.opacity = '0';
                    overlay.style.pointerEvents = 'none';
                }
                document.body.classList.remove('flatpickr-mobile-sheet-open');
            }

            function buildFlatpickrOptions(extraOptions = {}) {
                const extraOnReady = extraOptions.onReady;
                const extraOnMonthChange = extraOptions.onMonthChange;
                const extraOnYearChange = extraOptions.onYearChange;
                const extraOnOpen = extraOptions.onOpen;
                const extraOnClose = extraOptions.onClose;

                const mergedOptions = {
                    dateFormat: 'Y-m-d',
                    allowInput: false,
                    clickOpens: true,
                    disableMobile: true,
                    static: false,

                    onReady: function(selectedDates, dateStr, instance) {
                        const inputEl = instance.input;
                        const isMobile = window.innerWidth <= 767;

                        if (!isMobile) {
                            const hostDialog = inputEl ? inputEl.closest('dialog') : null;
                            const hostModalBox = inputEl ? inputEl.closest(
                                '.modal-box-custom, .modal-scroll-body, .modal-box-split') : null;
                            const hostContainer = hostDialog || hostModalBox;

                            if (hostContainer) {
                                instance.set('appendTo', hostContainer);
                                instance.set('positionElement', inputEl);
                            }
                        } else {
                            instance.set('appendTo', document.body);
                        }

                        enhanceFlatpickrHeader(instance);
                        syncFlatpickrHeader(instance);

                        if (typeof extraOnReady === 'function') {
                            extraOnReady(selectedDates, dateStr, instance);
                        }
                    },

                    onMonthChange: function(selectedDates, dateStr, instance) {
                        syncFlatpickrHeader(instance);
                        if (typeof extraOnMonthChange === 'function') {
                            extraOnMonthChange(selectedDates, dateStr, instance);
                        }
                    },

                    onYearChange: function(selectedDates, dateStr, instance) {
                        syncFlatpickrHeader(instance);
                        if (typeof extraOnYearChange === 'function') {
                            extraOnYearChange(selectedDates, dateStr, instance);
                        }
                    },

                    onOpen: function(selectedDates, dateStr, instance) {
                        const inputEl = instance.input;
                        const isMobile = window.innerWidth <= 767;

                        if (isMobile) {
                            openMobileSheet(instance);
                        } else {
                            const hostDialog = inputEl ? inputEl.closest('dialog') : null;
                            const hostModalBox = inputEl ? inputEl.closest(
                                '.modal-box-custom, .modal-scroll-body, .modal-box-split') : null;
                            const hostContainer = hostDialog || hostModalBox;

                            if (hostContainer) {
                                if (!instance.calendarContainer.parentNode || instance.calendarContainer
                                    .parentNode !== hostContainer) {
                                    hostContainer.appendChild(instance.calendarContainer);
                                }
                                instance.set('positionElement', inputEl);
                            }

                            requestAnimationFrame(() => {
                                if (typeof instance._positionCalendar === 'function') {
                                    instance._positionCalendar();
                                }
                            });
                        }

                        enhanceFlatpickrHeader(instance);
                        syncFlatpickrHeader(instance);

                        if (typeof extraOnOpen === 'function') {
                            extraOnOpen(selectedDates, dateStr, instance);
                        }
                    },

                    onClose: function(selectedDates, dateStr, instance) {
                        if (window.innerWidth <= 767) {
                            closeMobileSheet();
                        }

                        if (typeof extraOnClose === 'function') {
                            extraOnClose(selectedDates, dateStr, instance);
                        }
                    }
                };

                return {
                    ...mergedOptions,
                    ...extraOptions,
                    onReady: mergedOptions.onReady,
                    onMonthChange: mergedOptions.onMonthChange,
                    onYearChange: mergedOptions.onYearChange,
                    onOpen: mergedOptions.onOpen,
                    onClose: mergedOptions.onClose
                };
            }

            flatpickr('.js-flatpickr-date', buildFlatpickrOptions());
            flatpickr('.js-flatpickr-date-max-today', buildFlatpickrOptions({
                maxDate: 'today'
            }));
            flatpickr('.js-flatpickr-date-range-from', buildFlatpickrOptions({
                maxDate: 'today'
            }));
            flatpickr('.js-flatpickr-date-range-to', buildFlatpickrOptions({
                maxDate: 'today'
            }));
        });
    </script>

    <script src="{{ asset('js/header.js') }}"></script>
</body>

</html>
