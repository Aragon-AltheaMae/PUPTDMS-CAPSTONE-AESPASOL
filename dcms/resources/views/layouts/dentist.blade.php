<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    @if (auth()->check())
        <meta name="auth-user-id" content="{{ auth()->id() }}">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'light';
            if (theme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                document.documentElement.style.backgroundColor = '#000D1A';
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
                document.documentElement.style.backgroundColor = '#F4F4F4';
            }
        })();
    </script>
    <title>@yield('title', 'PUP Taguig Dental Clinic')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/header.css') }}">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            margin: 0;
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

    <script src="https://cdn.jsdelivr.net/npm/sienna-accessibility@latest/dist/sienna-accessibility.umd.js"
        data-position="bottom-right" data-offset="18,24" defer></script>

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

    @include('partials.chatbot')
    <script src="{{ asset('js/header.js') }}"></script>
</body>

</html>
