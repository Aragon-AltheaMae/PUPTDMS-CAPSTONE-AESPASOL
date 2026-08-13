<script>
    function makeCalendarDot(colorClass, text = '') {
        const sizeClass = text ? 'min-w-[16px] h-4 px-1 text-[9px] font-bold' : 'w-4 h-4 text-[9px]';
        return `
            <span class="absolute -top-1 -right-1 ${sizeClass} rounded-full ${colorClass} text-white leading-none flex items-center justify-center shadow-[0_2px_8px_rgba(0,0,0,0.18)] border border-white">
                ${text}
            </span>
        `;
    }

    function makeHolidayStar() {
        return `
        <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-yellow-400 text-[10px] leading-none
            flex items-center justify-center text-white shadow-[0_2px_8px_rgba(0,0,0,0.18)] border border-white">
            <i class="fa-solid fa-star text-[8px]"></i>
        </span>
    `;
    }

    function makeClinicClosedBadge() {
        return `
            <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-gray-500 text-[10px] leading-none
                flex items-center justify-center text-white shadow-[0_2px_8px_rgba(0,0,0,0.18)] border border-white">
                <i class="fa-solid fa-minus text-[8px]"></i>
            </span>
        `;
    }

    function makeCompletedAppointmentBadge() {
        return `
        <span
            class="completed-appointment-badge"
            aria-hidden="true"
        >
            <i class="fa-solid fa-check"></i>
        </span>
    `;
    }

    function makeMyAppointmentBadge() {
        return `
        <span class="absolute -top-1 -right-1 min-w-[16px] h-4 px-1 rounded-full bg-blue-600 text-[9px] leading-none
            flex items-center justify-center text-white shadow-[0_2px_8px_rgba(0,0,0,0.18)] border border-white">
            <i class="fa-regular fa-calendar-check text-[8px]"></i>
        </span>
    `;
    }

    const calendarConfig = {
        mode: @json($mode ?? 'booking'),
        calendarContainerId: @json($calendarContainerId ?? 'calendarSkeletonContainer'),
        calGridId: @json($calGridId ?? 'calGrid'),
        calMonthLabelId: @json($calMonthLabelId ?? 'calMonthLabel'),
        calYearLabelId: @json($calYearLabelId ?? 'calYearLabel'),
        dateInputId: @json($dateInputId),
        timeInputId: @json($timeInputId),
        dateBannerId: @json($dateBannerId ?? 'dateBanner'),
        slotPlaceholderId: @json($slotPlaceholderId ?? 'slotPlaceholder'),
        slotContainerId: @json($slotContainerId ?? 'slotContainer'),
        slotGridId: @json($slotGridId ?? 'slotGrid'),
        selectedSlotDisplayId: @json($selectedSlotDisplayId ?? 'selectedSlotDisplay'),
        selectedSlotTextId: @json($selectedSlotTextId ?? 'selectedSlotText'),
        selectedTimePillId: @json($selectedTimePillId ?? 'selectedTimePill'),
        selectedTimeTextId: @json($selectedTimeTextId ?? 'selectedTimeText'),
        datePillId: @json($datePillId ?? 'datePill'),
        dateErrorId: @json($dateErrorId ?? 'dateError'),
        timeErrorId: @json($timeErrorId ?? 'timeError'),
        calendarWrapSelector: @json($calendarWrapSelector ?? '.cal-wrap'),
        slotsWrapSelector: @json($slotsWrapSelector ?? '.slots-wrap'),
        slotEndpoint: @json($slotEndpoint),
        bookingUrl: @json($bookingUrl ?? null),
        maxFutureMonths: @json($maxFutureMonths ?? 6),
        historyMonths: @json($historyMonths ?? 12),
        appointmentHistoryUrl: @json($appointmentHistoryUrl ?? null),

        scheduleRules: @json($scheduleRules ?? []),
        blockedDates: @json($blockedDates ?? []),
        apptCounts: @json($appointmentCountsPerDay ?? []),
        holidaysMap: @json($philippineHolidays ?? []),
        personalAppointments: @json($personalAppointments ?? []),
        completedAppointments: @json($completedAppointments ?? []),
        disallowToday: @json($disallowToday ?? true),
        allowPastDates: @json($allowPastDates ?? false),
        allowAllDates: @json($allowAllDates ?? false),
        allowAllDatesExceptHolidays: @json($allowAllDatesExceptHolidays ?? false),
        disableWeekends: @json($disableWeekends ?? false),
        allowHolidaySelection: @json($allowHolidaySelection ?? false),
        allowToggleOffDate: @json($allowToggleOffDate ?? true),
        useDynamicScheduleRules: @json($useDynamicScheduleRules ?? false),
        renderStyle: @json($renderStyle ?? 'patient'),
        enableMonthYearShortcut: @json($enableMonthYearShortcut ?? false),
    };

    let selectedDate = null;
    let selectedTime = null;
    let activeCalendarFilter = 'all';
    let focusedDateIso = null;
    let hasCalendarRenderedOnce = false;
    let dashboardLoadingTimer = null;
    const dashboardSlotCache = new Map();
    const sharedCalendarSource = window.createCalendarSource ?
        window.createCalendarSource(calendarConfig) :
        null;

    window.__appCalendarSources = window.__appCalendarSources || {};
    window.__appCalendarSources[calendarConfig.dateInputId] = sharedCalendarSource;

    const todayDate = new Date();
    todayDate.setHours(0, 0, 0, 0);

    function pad(n) {
        return String(n).padStart(2, "0");
    }

    function getDayAbbrFromDate(dateObj) {
        return dateObj.toLocaleDateString('en-US', {
            weekday: 'short'
        }).replace('.', '');
    }

    function normalizeDays(days) {
        if (Array.isArray(days)) return days;

        if (typeof days === "string") {
            try {
                const parsed = JSON.parse(days);
                if (Array.isArray(parsed)) return parsed;
            } catch (e) {
                return days.split(",").map(d => d.trim());
            }
        }

        return [];
    }

    function isRuleActive(rule) {
        return (
            rule?.is_active === true ||
            rule?.is_active === 1 ||
            rule?.is_active === '1'
        );
    }

    function getRuleForDate(dateObj) {
        if (sharedCalendarSource) {
            return sharedCalendarSource.getRuleForDate(dateObj);
        }

        if (!calendarConfig.useDynamicScheduleRules) return null;

        const dayAbbr = getDayAbbrFromDate(dateObj);

        return (calendarConfig.scheduleRules || []).find(rule => {
            const days = normalizeDays(rule.days);

            return isRuleActive(rule) && days.includes(dayAbbr);
        }) || null;
    }

    function getMaxPerDay(dateObj) {
        if (sharedCalendarSource) {
            return sharedCalendarSource.getMaxPerDay(dateObj);
        }

        const rule = getRuleForDate(dateObj);
        return rule?.max_slots ?? 0;
    }

    function isDateSchedulable(dateObj, iso) {
        if (sharedCalendarSource) {
            return sharedCalendarSource.isDateSchedulable(dateObj, iso);
        }

        if (calendarConfig.blockedDates.includes(iso)) {
            return false;
        }

        if (calendarConfig.holidaysMap?.[iso]) {
            return false;
        }

        if (!calendarConfig.useDynamicScheduleRules) {
            return true;
        }

        const rule = getRuleForDate(dateObj);
        const status = String(rule?.status || '').trim().toLowerCase();

        if (
            !rule ||
            !isRuleActive(rule) ||
            status === 'closed'
        ) {
            return false;
        }

        return true;
    }

    async function fetchSlotsForDate(iso) {
        const response = await fetch(`${calendarConfig.slotEndpoint}?date=${encodeURIComponent(iso)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        });

        if (!response.ok) {
            throw new Error('Failed to load slots.');
        }

        return response.json();
    }

    function getSelectedDateValue() {
        const dateInput = document.getElementById(calendarConfig.dateInputId);
        const inputValue = String(dateInput?.value || '').trim();

        if (inputValue !== '') {
            return inputValue;
        }

        return String(selectedDate || '').trim();
    }

    function hasSelectedDateValue() {
        return getSelectedDateValue() !== '';
    }

    function getLegendItemsForMode(mode) {
        if (
            calendarConfig
            .allowAllDatesExceptHolidays
        ) {
            return calendarConfig
                .disableWeekends ? [
                    'today',
                    'holiday',
                    'clinicClosed'
                ] : [
                    'today',
                    'holiday'
                ];
        }
        if (mode === 'dentist') {
            return ['today', 'hasPatients', 'fullyBooked', 'holiday', 'clinicClosed'];
        }

        if (mode === 'patient-dashboard') {
            return [
                'myAppointment',
                'completedAppointment',
                'today',
                'fullyBooked',
                'holiday',
                'clinicClosed'
            ];
        }

        if (mode === 'patient-appointment') {
            return [
                'myAppointment',
                'today',
                'fullyBooked',
                'holiday',
                'clinicClosed'
            ];
        }

        return ['today', 'hasPatients', 'fullyBooked', 'holiday',
            'clinicClosed'
        ];
    }

    function renderUnifiedCalendarLegend(mode) {
        const items = getLegendItemsForMode(mode);

        return `
            <div class="cal-legend mt-4">
                ${items.map(key => `
                    <div class="cal-legend-item">
                        ${CALENDAR_THEME.statuses[key].legendIcon}
                    </div>
                `).join("")}
            </div>
        `;
    }

    const CALENDAR_THEME = {
        colors: {
            textMuted: "text-[#9e9690]",
            borderSoft: "border-[#f0ebe6]",
            navText: "text-[#8B0000]",
            monthText: "text-[#660000]",
        },

        statuses: {
            myAppointment: {
                key: "myAppointment",
                label: "My Appointment",
                dotClass: "bg-blue-600",
                tooltipBg: "bg-blue-600",
                tooltipArrow: "after:border-t-blue-600",
                cellBg: "bg-blue-50",
                cellText: "text-blue-700",
                legendIcon: `
        <span class="cal-pill cal-pill-blue">
            <i class="fa-regular fa-calendar-check text-[10px]"></i>
            My Appointment
        </span>
    `,
                badge: () => makeMyAppointmentBadge(),
            },
            completedAppointment: {
                key: "completedAppointment",
                label: "Completed Visit",

                tooltipBg: "bg-emerald-600",
                tooltipArrow: "after:border-t-emerald-600",

                legendIcon: `
        <span class="cal-pill cal-pill-green">
            <i class="fa-solid fa-circle-check text-[10px]"></i>
            Completed Visit
        </span>
    `,

                badge: () => makeCompletedAppointmentBadge(),
            },
            today: {
                key: "today",
                label: "Today",
                dotClass: "bg-[#8B0000]",
                tooltipBg: "bg-[#8B0000]",
                tooltipArrow: "after:border-t-[#8B0000]",
                cellBg: "bg-[#8B0000]",
                cellText: "text-white",
                legendIcon: `
                     <span class="cal-pill cal-pill-maroon">
                        <i class="fa-solid fa-calendar-day text-[10px]"></i>
                        Today
                    </span>
                `,
            },
            hasPatients: {
                key: "hasPatients",
                label: "Has Patients",
                dotClass: "bg-emerald-600",
                tooltipBg: "bg-emerald-600",
                tooltipArrow: "after:border-t-emerald-600",
                cellBg: "bg-emerald-50",
                cellText: "text-emerald-700",
                legendIcon: `
                    <span class="cal-pill cal-pill-green">
                        <i class="fa-solid fa-user-check text-[10px]"></i>
                        Has Patients
                    </span>
                `,
            },
            fullyBooked: {
                key: "fullyBooked",
                label: "Fully Booked",
                dotClass: "bg-red-600",
                tooltipBg: "bg-red-500",
                tooltipArrow: "after:border-t-red-500",
                cellBg: "bg-red-50",
                cellText: "text-red-700",
                legendIcon: `
                    <span class="cal-pill cal-pill-red">
                        <i class="fa-solid fa-ban text-[10px]"></i>
                        Fully Booked
                    </span>
                `,
            },
            holiday: {
                key: "holiday",
                label: "Holiday",
                tooltipBg: "bg-yellow-500",
                tooltipArrow: "after:border-t-yellow-500",
                cellBg: "bg-yellow-50",
                cellText: "text-yellow-700",
                legendIcon: `
                    <span class="cal-pill cal-pill-yellow">
                        <i class="fa-solid fa-star text-[10px]"></i>
                        Holiday
                    </span>
                `,
                badge: () => makeHolidayStar(),
            },
            clinicClosed: {
                key: "clinicClosed",
                label: "Clinic Closed",
                dotClass: "bg-gray-500",
                tooltipBg: "bg-gray-600",
                tooltipArrow: "after:border-t-gray-600",
                cellBg: "skeleton-line",
                cellText: "text-gray-500",
                legendIcon: `
                    <span class="cal-pill cal-pill-gray">
                        <i class="fa-solid fa-circle-minus text-[10px]"></i>
                        Unavailable
                    </span>
                `,
                badge: () => makeClinicClosedBadge(),
            },
            todayNotAvailable: {
                key: "todayNotAvailable",
                label: "Today not available",
                dotClass: "bg-gray-500",
                tooltipBg: "bg-gray-600",
                tooltipArrow: "after:border-t-gray-600",
                cellBg: "skeleton-line",
                cellText: "text-gray-500",
                legendIcon: `
                    <span class="cal-pill cal-pill-gray">
                        <i class="fa-solid fa-circle-minus text-[10px]"></i>
                        Today not available
                    </span>
                `,
            }
        }
    };

    function resolveCalendarDayState(year, month, day) {
        const iso = `${year}-${pad(month + 1)}-${pad(day)}`;
        const cellDate = new Date(year, month, day);
        cellDate.setHours(0, 0, 0, 0);

        const isToday =
            cellDate.getTime() ===
            todayDate.getTime();

        const isPast =
            cellDate < todayDate;

        const dayOfWeek =
            cellDate.getDay();

        const isWeekend =
            dayOfWeek === 0 ||
            dayOfWeek === 6;
        const isPastOrToday = calendarConfig.allowPastDates ?
            (calendarConfig.disallowToday ? isToday : false) :
            (calendarConfig.disallowToday ? cellDate <= todayDate : isPast);

        const holidayName = calendarConfig.holidaysMap?.[iso] || null;
        const isHoliday = !!holidayName;
        const isClosed = !isDateSchedulable(cellDate, iso);

        const maxPerDay = calendarConfig.useDynamicScheduleRules ? getMaxPerDay(cellDate) : 0;
        const count = calendarConfig.apptCounts?.[iso] ?? 0;
        const isFull = !isClosed && maxPerDay > 0 ? count >= maxPerDay : false;

        const myAppointment = calendarConfig.personalAppointments?.[iso] || null;
        const completedAppointments =
            calendarConfig.completedAppointments?.[iso] || [];

        const hasCompletedAppointment =
            Array.isArray(completedAppointments) &&
            completedAppointments.length > 0;
        const hasPatients = count > 0;

        const isBookingMode = calendarConfig.mode === 'booking';

        let isDisabled;

        if (
            calendarConfig
            .allowAllDatesExceptHolidays
        ) {
            const holidayBlocked =
                isHoliday &&
                !calendarConfig
                .allowHolidaySelection;

            const weekendBlocked =
                calendarConfig
                .disableWeekends ===
                true &&
                isWeekend;

            isDisabled =
                holidayBlocked ||
                weekendBlocked;

        } else if (
            calendarConfig.allowAllDates
        ) {
            isDisabled = false;
        } else {
            isDisabled =
                isPastOrToday ||
                isHoliday ||
                isClosed ||
                isFull;
        }

        const isSelected = iso === selectedDate;

        return {
            iso,
            cellDate,
            isToday,
            isPast,
            isWeekend,
            isPastOrToday,
            holidayName,
            isHoliday,
            isClosed,
            isFull,
            myAppointment,
            completedAppointments,
            hasCompletedAppointment,
            hasPatients,
            count,
            isBookingMode,
            isDisabled,
            isSelected
        };
    }

    function resetDashboardAvailabilityPanel() {
        const panel = getDashboardAvailabilityPanel();

        if (!panel) return;

        panel.innerHTML = `
            <div class="dashboard-calendar-side-empty">
                <div class="dashboard-calendar-side-empty-icon">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>

                <span class="dashboard-calendar-eyebrow">
                    Check availability
                </span>

                <strong>Select an available date</strong>

                <p>
                    Choose a future date from the calendar to view available
                    appointment times.
                </p>
            </div>
        `;
    }

    function getCalendarDayDecorations(state, variant = 'patient') {
        let cellClass = "cal-cell";
        const allowAllDates =
            calendarConfig.allowAllDates === true;

        const allowAllDatesExceptHolidays =
            calendarConfig
            .allowAllDatesExceptHolidays === true;

        const disableWeekends =
            calendarConfig
            .disableWeekends ===
            true;

        const ignoreAvailabilityRestrictions =
            allowAllDates ||
            allowAllDatesExceptHolidays;

        let badgeHtml = "";
        let tooltipHtml = "";
        let tooltip = "";
        let tooltipBg = "bg-[#1a1410]";
        let tooltipArrow = "after:border-t-[#1a1410]";

        if (variant !== 'dentist') {
            if (
                state.isSelected &&
                state.hasCompletedAppointment
            ) {
                cellClass += " completed-appointment selected-history";
            } else if (state.hasCompletedAppointment) {
                cellClass += " completed-appointment";
            } else if (state.isSelected && !state.isDisabled) {
                cellClass += " selected";
            } else if (
                state.isHoliday &&
                !allowAllDates
            ) {
                cellClass +=
                    " holiday";

                if (
                    !calendarConfig
                    .allowHolidaySelection
                ) {
                    cellClass +=
                        " disabled";
                }

            } else if (
                allowAllDatesExceptHolidays &&
                disableWeekends &&
                state.isWeekend
            ) {
                cellClass +=
                    " clinic-closed disabled";
            } else if (
                !ignoreAvailabilityRestrictions &&
                state.isToday
            ) {
                if (
                    state.isBookingMode &&
                    calendarConfig.disallowToday
                ) {
                    cellClass +=
                        " same-day-unavailable disabled";
                } else {
                    cellClass += " today";
                }

            } else if (
                !ignoreAvailabilityRestrictions &&
                state.isFull
            ) {
                cellClass +=
                    "full disabled";

            } else if (
                !ignoreAvailabilityRestrictions &&
                state.isClosed
            ) {
                cellClass +=
                    " clinic-closed disabled";

            } else if (
                !ignoreAvailabilityRestrictions &&
                state.isPastOrToday &&
                state.isBookingMode
            ) {
                cellClass +=
                    " past-date disabled";

            } else if (
                !ignoreAvailabilityRestrictions &&
                state.isPast &&
                !state.hasCompletedAppointment
            ) {
                cellClass +=
                    " past-date disabled";
            }
        } else {
            if (state.isSelected && !state.isDisabled) {
                cellClass += " selected";
            } else if (!allowAllDates && state.isToday) {
                cellClass += " today disabled";
            } else if (!allowAllDates && state.isHoliday) {
                cellClass += " holiday disabled";
            } else if (!allowAllDates && state.isFull) {
                cellClass += " full disabled";
            } else if (!allowAllDates && (state.isClosed || state.isPastOrToday)) {
                cellClass += ` disabled ${CALENDAR_THEME.statuses.clinicClosed.cellText}`;
            }
        }

        if (state.myAppointment && !state.isBookingMode) {
            badgeHtml += CALENDAR_THEME.statuses.myAppointment.badge();
            tooltip = `<i class="fa-regular fa-calendar-check mr-1 text-blue-200"></i>${state.myAppointment}`;
            tooltipBg = CALENDAR_THEME.statuses.myAppointment.tooltipBg;
            tooltipArrow = CALENDAR_THEME.statuses.myAppointment.tooltipArrow;
        }
        if (
            state.hasCompletedAppointment &&
            calendarConfig.mode === 'patient-dashboard'
        ) {
            badgeHtml +=
                CALENDAR_THEME.statuses.completedAppointment.badge();

            const firstVisit =
                state.completedAppointments[0];

            tooltip = `
        <i class="fa-solid fa-circle-check mr-1"></i>
        Completed: ${firstVisit?.service || 'Dental Visit'}
    `;

            tooltipBg =
                CALENDAR_THEME.statuses.completedAppointment.tooltipBg;

            tooltipArrow =
                CALENDAR_THEME.statuses.completedAppointment.tooltipArrow;
        }

        if (state.isHoliday && !allowAllDates) {
            badgeHtml += CALENDAR_THEME.statuses.holiday.badge();
            if (!tooltip) {
                tooltip = `<i class="fa-solid fa-star mr-1 text-white"></i>${state.holidayName}`;
                tooltipBg = CALENDAR_THEME.statuses.holiday.tooltipBg;
                tooltipArrow = CALENDAR_THEME.statuses.holiday.tooltipArrow;
            }
        } else if (
            !ignoreAvailabilityRestrictions &&
            state.isFull
        ) {
            if (!state.myAppointment && !state.isClosed) {
                badgeHtml += makeCalendarDot(CALENDAR_THEME.statuses.fullyBooked.dotClass, state.count > 0 ? String(
                    state.count) : '');
            }
            if (!tooltip) {
                tooltip = state.isBookingMode ? "Full Slot" : "Fully Booked";
                tooltipBg = CALENDAR_THEME.statuses.fullyBooked.tooltipBg;
                tooltipArrow = CALENDAR_THEME.statuses.fullyBooked.tooltipArrow;
            }
        } else if (
            !ignoreAvailabilityRestrictions &&
            state.isClosed &&
            !state.isPast
        ) {
            if (!state.myAppointment) {
                badgeHtml += CALENDAR_THEME.statuses.clinicClosed.badge();
            }

            if (!tooltip) {
                tooltip = `
            <i class="fa-solid fa-circle-minus mr-1"></i>
            Clinic Closed
        `;
                tooltipBg = CALENDAR_THEME.statuses.clinicClosed.tooltipBg;
                tooltipArrow = CALENDAR_THEME.statuses.clinicClosed.tooltipArrow;
            }
        } else if (
            !ignoreAvailabilityRestrictions &&
            state.isPast &&
            !state.hasCompletedAppointment
        ) {
            if (!tooltip) {
                tooltip = `
            <i class="fa-solid fa-clock-rotate-left mr-1"></i>
            Past date
        `;
                tooltipBg = "bg-gray-500";
                tooltipArrow = "after:border-t-gray-500";
            }
        } else if (variant === 'dentist' && state.hasPatients && !state.isPast && !state.isHoliday) {
            badgeHtml += makeCalendarDot(
                state.isFull ? CALENDAR_THEME.statuses.fullyBooked.dotClass : CALENDAR_THEME.statuses.hasPatients
                .dotClass,
                state.count > 0 ? String(state.count) : ''
            );
            cellClass +=
                ` ${CALENDAR_THEME.statuses.hasPatients.cellBg} ${CALENDAR_THEME.statuses.hasPatients.cellText} font-bold`;
            if (!tooltip) {
                tooltip = `${state.count} Appointment${state.count > 1 ? 's' : ''}`;
                tooltipBg = CALENDAR_THEME.statuses.hasPatients.tooltipBg;
                tooltipArrow = CALENDAR_THEME.statuses.hasPatients.tooltipArrow;
            }
        }

        if (
            allowAllDatesExceptHolidays &&
            disableWeekends &&
            state.isWeekend
        ) {
            tooltip = `
        <i class="fa-solid fa-circle-minus mr-1"></i>
        Clinic closed on weekends
    `;

            tooltipBg =
                "bg-gray-600";

            tooltipArrow =
                "after:border-t-gray-600";
        } else if (
            state.isHoliday &&
            !allowAllDates
        ) {} else if (
            !ignoreAvailabilityRestrictions &&
            state.isToday &&
            calendarConfig.disallowToday
        ) {
            tooltip = `
        <i class="fa-solid fa-calendar-day mr-1"></i>
        Same-day booking is not allowed
    `;
            tooltipBg = "bg-gray-600";
            tooltipArrow = "after:border-t-gray-600";
        } else if (
            !ignoreAvailabilityRestrictions &&
            state.isPast &&
            !state.hasCompletedAppointment
        ) {
            tooltip = `
        <i class="fa-solid fa-clock-rotate-left mr-1"></i>
        Past date — booking not allowed
    `;
            tooltipBg = "bg-gray-500";
            tooltipArrow = "after:border-t-gray-500";
        } else if (
            !ignoreAvailabilityRestrictions &&
            state.isClosed
        ) {
            tooltip = `
        <i class="fa-solid fa-circle-minus mr-1"></i>
        Clinic closed on this date
    `;
            tooltipBg = "bg-gray-600";
            tooltipArrow = "after:border-t-gray-600";
        } else if (state.isToday && !tooltip && !state.myAppointment) {
            tooltip = `
        <i class="fa-solid fa-calendar-day mr-1 text-white/90"></i>
        Today
    `;
            tooltipBg = CALENDAR_THEME.statuses.today.tooltipBg;
            tooltipArrow = CALENDAR_THEME.statuses.today.tooltipArrow;
        }

        if (tooltip) {
            const day = state.cellDate.getDay();
            const tooltipSide = day >= 5 ? "tooltip-left" : day <= 1 ? "tooltip-right" : "tooltip-center";

            tooltipHtml = `
        <div class="day-smart-tooltip ${tooltipSide} absolute bottom-[calc(100%+10px)] z-[9999] pointer-events-none">
            <div class="${tooltipBg} relative text-white text-[0.65rem] font-bold px-3 py-2 rounded-lg whitespace-nowrap shadow-xl
                after:content-[''] after:absolute after:top-full after:border-4 after:border-transparent ${tooltipArrow}">
                ${tooltip}
            </div>
        </div>
    `;
        }

        return {
            cellClass,
            badgeHtml,
            tooltipHtml
        };
    }

    function renderCalendarLoading() {
        const container = document.getElementById(calendarConfig.calendarContainerId);
        if (!container) return;

        const dayHeaderSkeleton = Array.from({
            length: 7
        }).map(() =>
            '<div class="h-4 skeleton-line rounded mx-2"></div>'
        ).join("");

        const dayCellSkeleton = Array.from({
            length: 35
        }).map(() =>
            '<div class="flex items-center justify-center py-1.5">' +
            '<div class="w-10 h-10 rounded-xl skeleton-line"></div>' +
            '</div>'
        ).join("");

        container.innerHTML =
            '<div class="skeleton-shell space-y-5 p-5 sm:p-6">' +
            '<div class="flex items-center justify-between mb-5">' +
            '<div class="w-8 h-8 rounded-full skeleton-block"></div>' +
            '<div class="text-center space-y-2">' +
            '<div class="h-5 w-28 skeleton-block rounded mx-auto"></div>' +
            '<div class="h-3 w-16 skeleton-line rounded mx-auto"></div>' +
            '</div>' +
            '<div class="w-8 h-8 rounded-full skeleton-block"></div>' +
            '</div>' +

            '<div class="border-t border-gray-100 mb-3"></div>' +

            '<div class="grid grid-cols-7 gap-0.5 mb-2">' +
            dayHeaderSkeleton +
            '</div>' +

            '<div class="grid grid-cols-7 gap-1">' +
            dayCellSkeleton +
            '</div>' +
            '</div>';
    }

    function renderSlotLoading(iso) {
        const slotPlaceholder = document.getElementById(calendarConfig.slotPlaceholderId);
        const slotContainer = document.getElementById(calendarConfig.slotContainerId);
        const slotGrid = document.getElementById(calendarConfig.slotGridId);
        const banner = document.getElementById(calendarConfig.dateBannerId);
        const pill = document.getElementById(calendarConfig.datePillId);

        const [y, m, d] = iso.split("-");
        const MONTHS = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        if (banner && calendarConfig.renderStyle !== 'dentist') {
            banner.innerHTML =
                `<i class="fa-regular fa-calendar mr-2"></i>${MONTHS[parseInt(m) - 1]} ${parseInt(d)}, ${y}`;
            banner.classList.remove("hidden");
            banner.style.display = "block";
        }

        if (pill) {
            pill.innerHTML =
                `<i class="fa-regular fa-calendar mr-1"></i>${MONTHS[parseInt(m) - 1]} ${parseInt(d)}, ${y}`;
            pill.classList.add("show");
        }

        if (slotPlaceholder) {
            slotPlaceholder.classList.add("hidden");
            slotPlaceholder.style.display = "none";
        }

        if (slotContainer) {
            slotContainer.classList.remove("hidden");
            slotContainer.style.display = "block";
        }

        if (slotGrid) {
            slotGrid.style.display = "grid";

            if (calendarConfig.renderStyle === 'dentist') {
                slotGrid.className = "slot-grid-ui";
            } else {
                slotGrid.className = "slot-grid-ui";
            }

            slotGrid.innerHTML = Array.from({
                length: 8
            }).map(() => `
            <div class="px-4 py-3 rounded-xl border border-gray-100 bg-gray-50">
                <div class="h-4 w-24 skeleton-block rounded"></div>
            </div>
        `).join("");
        }
    }

    function isCurrentMonthView(year, month) {
        return year === todayDate.getFullYear() && month === todayDate.getMonth();
    }


    function getMonthBounds() {
        const isDashboard =
            calendarConfig.mode === 'patient-dashboard';

        const minimum = (isDashboard || calendarConfig.allowPastDates) ?
            new Date(
                todayDate.getFullYear(),
                todayDate.getMonth() -
                Number(calendarConfig.historyMonths || 12),
                1
            ) :
            new Date(
                todayDate.getFullYear(),
                todayDate.getMonth(),
                1
            );

        const maxFutureMonths =
            Number.isFinite(
                Number(
                    calendarConfig
                    .maxFutureMonths
                )
            ) ?
            Number(
                calendarConfig
                .maxFutureMonths
            ) :
            6;

        const maximum =
            new Date(
                todayDate.getFullYear(),
                todayDate.getMonth() +
                maxFutureMonths,
                1
            );

        return {
            minimum,
            maximum
        };
    }

    function getVisibleMonthOptions() {
        const {
            minimum,
            maximum
        } = getMonthBounds();
        const options = [];
        const cursor = new Date(minimum);

        while (cursor <= maximum) {
            options.push({
                year: cursor.getFullYear(),
                month: cursor.getMonth(),
                label: cursor.toLocaleDateString('en-US', {
                    month: 'long',
                    year: 'numeric'
                })
            });

            cursor.setMonth(cursor.getMonth() + 1);
        }

        return options;
    }

    function getMonthSummary(year, month) {
        const totalDays = new Date(year, month + 1, 0).getDate();
        let available = 0;
        let unavailable = 0;
        let myAppointments = 0;

        for (let day = 1; day <= totalDays; day++) {
            const state = resolveCalendarDayState(year, month, day);

            if (!state.isDisabled) available++;
            if (state.isDisabled && !state.isPast) unavailable++;
            if (state.myAppointment) myAppointments++;
        }

        return {
            available,
            unavailable,
            myAppointments
        };
    }

    function getCalendarDateStateFromIso(iso) {
        const [year, month, day] = String(iso).split('-').map(Number);

        if (!year || !month || !day) return null;

        return resolveCalendarDayState(year, month - 1, day);
    }

    function getDateCellSelector(iso) {
        return `#${calendarConfig.calendarContainerId} [data-date="${iso}"]`;
    }

    function focusCalendarDate(iso) {
        if (!iso) return;

        focusedDateIso = iso;

        requestAnimationFrame(() => {
            const target = document.querySelector(getDateCellSelector(iso));
            target?.focus({
                preventScroll: true
            });
        });
    }

    function navigateCalendarFocus(currentIso, deltaDays) {
        const state = getCalendarDateStateFromIso(currentIso);
        if (!state) return;

        const candidate = new Date(state.cellDate);
        candidate.setDate(candidate.getDate() + deltaDays);

        const {
            minimum,
            maximum
        } = getMonthBounds();
        const maximumDay = new Date(maximum.getFullYear(), maximum.getMonth() + 1, 0);

        const minimumDay = new Date(
            minimum.getFullYear(),
            minimum.getMonth(),
            1
        );

        if (candidate < minimumDay || candidate > maximumDay) {
            return;
        }

        const nextIso = `${candidate.getFullYear()}-${pad(candidate.getMonth() + 1)}-${pad(candidate.getDate())}`;

        if (
            candidate.getFullYear() !== currentYear ||
            candidate.getMonth() !== currentMonth
        ) {
            currentYear = candidate.getFullYear();
            currentMonth = candidate.getMonth();
            renderCalendar();
        }

        focusCalendarDate(nextIso);
    }

    function applyCalendarFilter(filter = activeCalendarFilter) {
        activeCalendarFilter = filter || 'all';

        const container = document.getElementById(calendarConfig.calendarContainerId);
        if (!container) return;

        container.querySelectorAll('[data-calendar-filter]').forEach(button => {
            const active = button.dataset.calendarFilter === activeCalendarFilter;
            button.classList.toggle('active', active);
            button.setAttribute('aria-pressed', active ? 'true' : 'false');
        });

        container.querySelectorAll('.cal-cell-wrap[data-date-wrap]').forEach(wrapper => {
            const cell = wrapper.querySelector('[data-date]');
            if (!cell) return;

            const state = getCalendarDateStateFromIso(cell.dataset.date);
            let visible = true;

            if (activeCalendarFilter === 'available') {
                visible = Boolean(state && !state.isDisabled);
            } else if (
                activeCalendarFilter === 'appointment'
            ) {
                visible = Boolean(
                    state?.myAppointment ||
                    state?.hasCompletedAppointment
                );
            }

            wrapper.classList.toggle('calendar-filter-dimmed', !visible);
            wrapper.setAttribute('aria-hidden', visible ? 'false' : 'true');
        });
    }

    async function findEarliestAvailableDate() {
        const button = document.querySelector(
            `#${calendarConfig.calendarContainerId} [data-calendar-filter="earliest"]`
        );

        button?.classList.add('is-loading');
        button?.setAttribute('aria-busy', 'true');

        const {
            minimum,
            maximum
        } = getMonthBounds();
        const endDate = new Date(maximum.getFullYear(), maximum.getMonth() + 1, 0);
        const cursor = new Date(calendarConfig.allowPastDates ? minimum.getTime() : Math.max(todayDate.getTime(),
            minimum.getTime()));

        try {
            while (cursor <= endDate) {
                const state = resolveCalendarDayState(
                    cursor.getFullYear(),
                    cursor.getMonth(),
                    cursor.getDate()
                );

                if (!state.isDisabled) {
                    let payload = dashboardSlotCache.get(state.iso);

                    if (!payload) {
                        payload = await fetchSlotsForDate(state.iso);
                        dashboardSlotCache.set(state.iso, payload);
                    }

                    const slots = Array.isArray(payload?.slots) ? payload.slots : [];
                    const available = slots.some(slot => {
                        if (typeof slot === 'string') return true;

                        return !(
                            slot.is_taken ||
                            slot.taken ||
                            slot.booked ||
                            slot.available === false
                        );
                    });

                    if (available) {
                        currentYear = cursor.getFullYear();
                        currentMonth = cursor.getMonth();
                        selectedDate = state.iso;
                        renderCalendar();
                        await selectDate(state.iso);
                        focusCalendarDate(state.iso);
                        return;
                    }
                }

                cursor.setDate(cursor.getDate() + 1);
            }

            if (typeof window.showToast === 'function') {
                window.showToast({
                    type: 'info',
                    title: 'No available dates',
                    message: 'No open appointment slot was found in the visible booking range.'
                });
            }
        } catch (_) {
            if (typeof window.showToast === 'function') {
                window.showToast({
                    type: 'error',
                    title: 'Availability check failed',
                    message: 'Unable to search for the earliest appointment slot.'
                });
            }
        } finally {
            button?.classList.remove('is-loading');
            button?.removeAttribute('aria-busy');
        }
    }

    function bindCalendarToolbar() {
        const container = document.getElementById(calendarConfig.calendarContainerId);
        if (!container) return;

        const monthPicker = container.querySelector('[data-calendar-month-picker]');
        const monthSelect = container.querySelector('[data-calendar-month-select]');
        const yearSelect = container.querySelector('[data-calendar-year-select]');

        monthPicker?.addEventListener('change', event => {
            const [year, month] = String(event.target.value)
                .split('-')
                .map(Number);

            if (!year || Number.isNaN(month)) return;

            clearTimeout(dashboardLoadingTimer);
            dashboardLoadingTimer = null;

            currentYear = year;
            currentMonth = month;
            selectedDate = null;
            focusedDateIso = null;

            renderCalendar();
        });

        function updateCalendarFromSplitSelectors() {
            const selectedMonth = Number(monthSelect?.value);
            const selectedYear = Number(yearSelect?.value);

            if (Number.isNaN(selectedMonth) || Number.isNaN(selectedYear)) return;

            const candidate = new Date(selectedYear, selectedMonth, 1);
            const {
                minimum,
                maximum
            } = getMonthBounds();

            if (candidate < minimum || candidate > maximum) {
                return;
            }

            clearTimeout(dashboardLoadingTimer);
            dashboardLoadingTimer = null;

            currentYear = selectedYear;
            currentMonth = selectedMonth;
            selectedDate = null;
            focusedDateIso = null;

            renderCalendar();
        }

        monthSelect?.addEventListener('change', updateCalendarFromSplitSelectors);
        yearSelect?.addEventListener('change', updateCalendarFromSplitSelectors);

        container.querySelectorAll('[data-calendar-filter]').forEach(button => {
            button.addEventListener('click', async () => {
                const filter = button.dataset.calendarFilter || 'all';

                if (filter === 'earliest') {
                    applyCalendarFilter('earliest');
                    await findEarliestAvailableDate();
                    return;
                }

                applyCalendarFilter(filter);
            });
        });
    }

    function renderUnifiedCalendar(year, month) {
        const MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
            "October", "November", "December"
        ];
        const DAYS_PATIENT = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        const DAYS_DENTIST = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"];

        const isDentist = calendarConfig.renderStyle === 'dentist';
        const isDashboard = calendarConfig.mode === 'patient-dashboard';
        const showMonthYearShortcut = isDashboard || calendarConfig.enableMonthYearShortcut === true;
        const dayLabels = isDentist ? DAYS_DENTIST : DAYS_PATIENT;

        const firstDow = new Date(year, month, 1).getDay();
        const totalDays = new Date(year, month + 1, 0).getDate();
        const summary = getMonthSummary(year, month);

        const {
            minimum,
            maximum
        } = getMonthBounds();
        const currentViewDate = new Date(year, month, 1);
        const prevDisabled = currentViewDate <= minimum;
        const nextDisabled = currentViewDate >= maximum;

        const monthOptions = getVisibleMonthOptions().map(option => `
            <option value="${option.year}-${option.month}"
                ${option.year === year && option.month === month ? 'selected' : ''}>
                ${option.label}
            </option>
        `).join('');

        const visibleMonthOptions = getVisibleMonthOptions();
        const visibleYears = [...new Set(visibleMonthOptions.map(option => option.year))];
        const splitMonthOptions = MONTHS.map((label, index) => `
            <option value="${index}" ${index === month ? 'selected' : ''}>
                ${label}
            </option>
        `).join('');
        const splitYearOptions = visibleYears.map(optionYear => `
            <option value="${optionYear}" ${optionYear === year ? 'selected' : ''}>
                ${optionYear}
            </option>
        `).join('');

        const header = dayLabels.map((d, i) => `
            <div class="${i === 0 || i === 6 ? 'cal-day-weekend' : 'cal-day-label'} text-center text-[0.6rem] font-bold py-1 pb-2 uppercase tracking-widest">
                ${d}
            </div>
        `).join("");

        let cells = "";
        for (let i = 0; i < firstDow; i++) cells += `<div aria-hidden="true"></div>`;

        for (let d = 1; d <= totalDays; d++) {
            const state = resolveCalendarDayState(year, month, d);
            const ui = getCalendarDayDecorations(state, isDentist ? 'dentist' : 'patient');

            cells += `
                <div class="cal-cell-wrap relative flex items-center justify-center group"
                    data-date-wrap
                    data-calendar-state="${state.isDisabled ? 'unavailable' : 'available'}">
                    ${ui.tooltipHtml}
                    <div class="${ui.cellClass}"
                        data-date="${state.iso}"
                        data-disabled="${state.isDisabled ? 1 : 0}"
                        data-past="${state.isPast ? 1 : 0}"
                        data-my-appointment="${state.myAppointment ? 1 : 0}"
                        data-saturday="${state.cellDate.getDay() === 6 ? 1 : 0}"
                        aria-label="${formatCalendarDateLabel(state.iso)}">
                        <span>${d}</span>
                        ${ui.badgeHtml}
                    </div>
                </div>
            `;
        }

        const dashboardToolbar = isDashboard ? `
            <div class="dashboard-calendar-toolbar">
                <div class="dashboard-calendar-summary" aria-live="polite">
                    <span>
                        <i class="fa-solid fa-calendar-check"></i>
                        <strong>${summary.available}</strong> bookable dates
                    </span>

                    ${summary.myAppointments ? `
                        <span>
                            <i class="fa-regular fa-calendar-check"></i>
                            <strong>${summary.myAppointments}</strong> my appointment
                        </span>
                    ` : ''}
                </div>

                <div class="dashboard-calendar-filters" aria-label="Calendar filters">
                    <button type="button" data-calendar-filter="all" aria-pressed="true">
                        All
                    </button>

                    <button type="button" data-calendar-filter="available" aria-pressed="false">
                        Available
                    </button>

                    <button type="button" data-calendar-filter="earliest" aria-pressed="false">
                        <i class="fa-solid fa-bolt"></i>
                        Earliest Date
                    </button>

                    <button type="button" data-calendar-filter="appointment" aria-pressed="false">
                        My visits
                    </button>
                </div>
            </div>
        ` : '';

        const monthControl = showMonthYearShortcut ? `
    <div
        class="calendar-split-picker"
        aria-label="Choose month and year"
    >
        <div class="calendar-split-picker-item">
            <span class="sr-only">
                Choose month
            </span>

            <select
                ${isDashboard
                    ? 'data-calendar-month-picker'
                    : 'data-calendar-month-select'
                }
                class="js-custom-select calendar-month-picker"
                data-placeholder="Choose month"
                aria-label="Choose month"
            >
                ${isDashboard
                    ? monthOptions
                    : splitMonthOptions
                }
            </select>
        </div>

        ${isDashboard ? '' : `
            <div
                class="
                    calendar-split-picker-item
                    calendar-year-picker-wrap
                "
            >
                <span class="sr-only">
                    Choose year
                </span>

                <select
                    data-calendar-year-select
                    class="
                        js-custom-select
                        calendar-month-picker
                        calendar-year-picker
                    "
                    data-placeholder="Choose year"
                    aria-label="Choose year"
                >
                    ${splitYearOptions}
                </select>
            </div>
        `}
    </div>
` : `
            <div class="text-center">
                <p class="cal-month-label text-base font-extrabold">
                    ${MONTHS[month]}
                </p>

                <p class="text-[0.65rem] text-[#9e9690] font-semibold tracking-widest">
                    ${year}
                </p>
            </div>
        `;

        const calendarBody = `
            <div class="calendar-main-header">
                <button
                    type="button"
                    class="cal-nav-btn w-8 h-8 rounded-full border border-[#e8e2dd] flex items-center justify-center text-[#8B0000] text-xs ${prevDisabled ? 'opacity-40 cursor-not-allowed' : ''}"
                    ${prevDisabled ? 'disabled' : 'onclick="changeMonth(-1)"'}
                    aria-label="Previous month"
                >
                    <i class="fa-solid fa-chevron-left"></i>
                </button>

                ${monthControl}

                <button
                    type="button"
                    class="cal-nav-btn w-8 h-8 rounded-full border border-[#e8e2dd] flex items-center justify-center text-[#8B0000] text-xs ${nextDisabled ? 'opacity-40 cursor-not-allowed' : ''}"
                    ${nextDisabled ? 'disabled' : 'onclick="changeMonth(1)"'}
                    aria-label="Next month"
                >
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>

            ${dashboardToolbar}

            <hr class="border-[#f0ebe6] mb-3">

            <div
                class="cal-grid"
                role="grid"
                aria-label="${MONTHS[month]} ${year}"
            >
                ${header}${cells}
            </div>

            ${renderUnifiedCalendarLegend(calendarConfig.mode)}
        `;

        const dashboardSidePanel = isDashboard ? `
            <aside
                class="dashboard-calendar-side-panel"
                data-dashboard-availability
                aria-live="polite"
            >
                <div class="dashboard-calendar-side-empty">
                    <div class="dashboard-calendar-side-empty-icon">
                        <i class="fa-regular fa-calendar-check"></i>
                    </div>

                    <span class="dashboard-calendar-eyebrow">
                        Check availability
                    </span>

                    <strong>Select an available date</strong>

                    <p>
                        Choose a future date from the calendar to view available
                        appointment times.
                    </p>
                </div>
            </aside>
        ` : '';

        const markup = isDashboard ?
            `
                <div class="cal-shell dashboard-calendar-shell">
                    <div class="dashboard-calendar-layout">
                        <div class="dashboard-calendar-main">
                            ${calendarBody}
                        </div>

                        ${dashboardSidePanel}
                    </div>
                </div>
            ` :
            `
                <div class="cal-shell">
                    ${calendarBody}
                </div>
            `;

        const container = document.getElementById(
            calendarConfig.calendarContainerId
        );

        if (!container) return;

        const isInitialAnimatedRender = !hasCalendarRenderedOnce &&
            calendarConfig.mode !== 'booking';

        if (isInitialAnimatedRender) {
            swapSkeletonContent(
                calendarConfig.calendarContainerId,
                markup
            );
        } else {
            container.innerHTML = markup;

            container.classList.remove(
                'skeleton-fade-leave',
                'skeleton-fade-enter'
            );

            container.style.pointerEvents = '';
        }

        hasCalendarRenderedOnce = true;

        setTimeout(() => {
            const calendarContainer =
                document.getElementById(
                    calendarConfig.calendarContainerId
                );

            window.initCustomSelects?.(
                calendarContainer
            );

            calendarContainer
                ?.querySelectorAll(
                    '.custom-select'
                )
                .forEach(wrapper => {
                    window.syncCustomSelect?.(
                        wrapper
                    );
                });

            bindCalendarClicks(
                `#${calendarConfig.calendarContainerId} [data-date]`
            );

            bindCalendarToolbar();

            applyCalendarFilter(
                activeCalendarFilter
            );

            if (focusedDateIso) {
                focusCalendarDate(
                    focusedDateIso
                );
            }
        }, isInitialAnimatedRender ? 180 : 0);
    }

    function renderCalendar() {
        renderUnifiedCalendar(currentYear, currentMonth);
    }

    function bindCalendarClicks(selector) {
        const canSelectWithoutInput =
            calendarConfig.mode === 'patient-dashboard' ||
            calendarConfig.mode === 'patient-appointment' ||
            calendarConfig.mode === 'dentist';

        if (!calendarConfig.dateInputId && !canSelectWithoutInput) {
            return;
        }

        document.querySelectorAll(selector).forEach(el => {
            if (el.dataset.calendarClickBound === 'true') return;

            el.dataset.calendarClickBound = 'true';

            const state = getCalendarDateStateFromIso(el.dataset.date);
            const isDisabled =
                el.dataset.disabled === '1';

            const isCompletedAppointment =
                state?.hasCompletedAppointment === true;

            const isInteractive = !isDisabled || isCompletedAppointment;

            el.setAttribute(
                'tabindex',
                isInteractive ? '0' : '-1'
            );

            el.setAttribute(
                'role',
                isInteractive ? 'button' : 'presentation'
            );

            el.setAttribute(
                'aria-disabled',
                isInteractive ? 'false' : 'true'
            );

            const activateDate = () => {
                if (isCompletedAppointment) {
                    selectedDate = state.iso;
                    focusedDateIso = state.iso;

                    renderCalendar();
                    renderCompletedAppointmentPanel(state);

                    return;
                }

                if (isDisabled) return;

                focusedDateIso = el.dataset.date;
                selectDate(el.dataset.date);
            };

            el.addEventListener('click', activateDate);

            el.addEventListener('keydown', event => {
                const keyMap = {
                    ArrowLeft: -1,
                    ArrowRight: 1,
                    ArrowUp: -7,
                    ArrowDown: 7
                };

                if (event.key in keyMap) {
                    event.preventDefault();
                    navigateCalendarFocus(el.dataset.date, keyMap[event.key]);
                    return;
                }

                if (event.key !== 'Enter' && event.key !== ' ') return;

                event.preventDefault();
                activateDate();
            });

            if (isInteractive) {
                el.addEventListener('focus', () => {
                    focusedDateIso = el.dataset.date;
                });
            }
        });
    }

    function clearSlotSelectionUI() {
        const dateInput = document.getElementById(calendarConfig.dateInputId);
        const timeInput = document.getElementById(calendarConfig.timeInputId);
        const banner = document.getElementById(calendarConfig.dateBannerId);
        const pill = document.getElementById(calendarConfig.datePillId);
        const slotPlaceholder = document.getElementById(calendarConfig.slotPlaceholderId);
        const slotContainer = document.getElementById(calendarConfig.slotContainerId);
        const slotGrid = document.getElementById(calendarConfig.slotGridId);
        const timePill = document.getElementById(calendarConfig.selectedTimePillId);
        const timeText = document.getElementById(calendarConfig.selectedTimeTextId);
        const clearSlotBtn = document.getElementById('clearSlotSelectionBtn');

        selectedDate = null;
        selectedTime = null;

        if (dateInput) dateInput.value = "";
        if (timeInput) timeInput.value = "";

        if (banner) {
            banner.classList.add("hidden");
            banner.style.display = "none";
            banner.innerHTML = "";
        }

        if (pill) {
            pill.classList.remove("show");
            pill.innerHTML = "";
        }

        if (slotContainer) slotContainer.classList.add("hidden");
        if (slotGrid) {
            slotGrid.innerHTML = "";
            slotGrid.style.display = "none";
        }

        if (timePill) {
            timePill.classList.remove("show");
            timePill.classList.add("hidden");
            timePill.style.display = "none";
        }
        if (timeText) timeText.textContent = "";

        if (slotPlaceholder) {
            slotPlaceholder.classList.remove("hidden");
            slotPlaceholder.style.display = "flex";
        }

        if (clearSlotBtn) {
            clearSlotBtn.classList.add('hidden');
            clearSlotBtn.setAttribute('aria-hidden', 'true');
        }

        renderCalendar();
    }

    async function selectDate(iso) {
        if (calendarConfig.mode === 'patient-dashboard') {
            selectedDate = iso;
            selectedTime = null;

            renderCalendar();

            clearTimeout(dashboardLoadingTimer);

            const cachedPayload = dashboardSlotCache.get(iso);

            if (cachedPayload) {
                renderDashboardAvailability(cachedPayload, iso);
                return;
            }

            dashboardLoadingTimer = setTimeout(() => {
                if (selectedDate === iso) {
                    renderDashboardAvailabilityLoading(iso);
                }
            }, 250);

            try {
                const payload = await fetchSlotsForDate(iso);

                dashboardSlotCache.set(iso, payload);
                clearTimeout(dashboardLoadingTimer);
                dashboardLoadingTimer = null;

                if (selectedDate !== iso) return;

                renderDashboardAvailability(payload, iso);
            } catch (error) {
                clearTimeout(dashboardLoadingTimer);
                dashboardLoadingTimer = null;

                if (selectedDate !== iso) return;

                renderDashboardAvailability({
                    slots: [],
                    message: 'Unable to load availability for this date.'
                }, iso);
            }

            return;
        }

        if (calendarConfig.mode === 'patient-appointment') {
            return;
        }

        if (calendarConfig.mode === 'dentist') {
            selectedDate = iso;
            selectedTime = null;
            renderCalendar();
            renderSlotLoading(iso);

            try {
                const payload = await fetchSlotsForDate(iso);
                renderSlots(payload, iso);
            } catch (error) {
                renderSlots({
                    slots: [],
                    message: 'Unable to load available slots.'
                }, iso);
            }
            return;
        }

        const dateError = document.getElementById(calendarConfig.dateErrorId);
        const calendarWrap = document.querySelector(calendarConfig.calendarWrapSelector);

        if (dateError) dateError.style.display = "none";
        if (calendarWrap) calendarWrap.classList.remove("error");

        if (calendarConfig.allowToggleOffDate && selectedDate === iso) {
            clearSlotSelectionUI();
            return;
        }

        selectedDate = iso;
        selectedTime = null;

        const dateInput = document.getElementById(calendarConfig.dateInputId);
        const timeInput = document.getElementById(calendarConfig.timeInputId);

        if (dateInput) dateInput.value = iso;
        if (timeInput) timeInput.value = "";
        if (typeof markFormDirty === "function") markFormDirty();

        renderCalendar();
        renderSlotLoading(iso);

        try {
            const payload = await fetchSlotsForDate(iso);
            renderSlots(payload, iso);
        } catch (error) {
            renderSlots({
                slots: [],
                message: 'Unable to load available slots.'
            }, iso);
        }
    }

    window.selectDate = selectDate;

    function formatCalendarDateLabel(iso) {
        const [year, month, day] = iso.split('-').map(Number);

        return new Date(year, month - 1, day).toLocaleDateString('en-US', {
            weekday: 'long',
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        });
    }

    function getDashboardAvailabilityPanel() {
        const container = document.getElementById(
            calendarConfig.calendarContainerId
        );

        if (!container) return null;

        return container.querySelector(
            '[data-dashboard-availability]'
        );
    }

    function renderCompletedAppointmentPanel(state) {
        const panel = getDashboardAvailabilityPanel();

        if (!panel) return;

        const appointments =
            Array.isArray(state.completedAppointments) ?
            state.completedAppointments : [];

        if (!appointments.length) {
            resetDashboardAvailabilityPanel();
            return;
        }

        const historyUrl =
            calendarConfig.appointmentHistoryUrl || '#';

        panel.innerHTML = `
        <div class="dashboard-calendar-side-content history-panel">
            <div class="dashboard-calendar-side-top">
                <div>
                    <span class="dashboard-calendar-eyebrow">
                        Completed visit
                    </span>

                    <strong class="dashboard-calendar-side-date">
                        ${formatCalendarDateLabel(state.iso)}
                    </strong>
                </div>

                <span class="dashboard-calendar-status completed">
                    <i class="fa-solid fa-circle-check"></i>
                    Completed
                </span>
            </div>

            <div class="completed-visit-list">
                ${appointments.map(appointment => `
                    <article class="completed-visit-card">
                        <div class="completed-visit-heading">
                            <span class="completed-visit-icon">
                                <i class="fa-solid fa-tooth"></i>
                            </span>

                            <div>
                                <strong>
                                    ${escapeCalendarText(
                                        appointment.service ||
                                        'Dental Appointment'
                                    )}
                                </strong>

                                <span>
                                    <i class="fa-regular fa-clock"></i>
                                    ${escapeCalendarText(
                                        appointment.time ||
                                        'Time not recorded'
                                    )}
                                </span>
                            </div>
                        </div>

                        <div class="completed-visit-details">
                            <div>
                                <span>Dentist</span>
                                <strong>
                                    ${escapeCalendarText(
                                        appointment.dentist ||
                                        'Assigned Dentist'
                                    )}
                                </strong>
                            </div>

                            ${appointment.duration ? `
                                <div>
                                    <span>Duration</span>
                                    <strong>
                                        ${escapeCalendarText(
                                            appointment.duration
                                        )}
                                    </strong>
                                </div>
                            ` : ''}
                        </div>

                        ${appointment.remarks ? `
                            <div class="completed-visit-note">
                                <span>Remarks</span>
                                <p>
                                    ${escapeCalendarText(
                                        appointment.remarks
                                    )}
                                </p>
                            </div>
                        ` : ''}
                    </article>
                `).join('')}
            </div>

            <div class="dashboard-calendar-side-footer">
                <span>
                    This appointment is part of your dental visit history.
                </span>

                <a
                    href="${historyUrl}"
                    class="dashboard-calendar-history-btn"
                >
                    <i class="fa-solid fa-folder-open"></i>
                    View dental records
                </a>
            </div>
        </div>
    `;
    }

    function escapeCalendarText(value) {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function renderDashboardAvailabilityLoading(iso) {
        const panel = getDashboardAvailabilityPanel();

        if (!panel) return;

        panel.innerHTML = `
            <div class="dashboard-calendar-side-content">
                <div class="dashboard-calendar-side-top">
                    <div>
                        <span class="dashboard-calendar-eyebrow">
                            Checking availability
                        </span>

                        <strong class="dashboard-calendar-side-date">
                            ${formatCalendarDateLabel(iso)}
                        </strong>
                    </div>
                </div>

                <div class="dashboard-calendar-side-state loading">
                    <i class="fa-solid fa-spinner fa-spin"></i>

                    <p>
                        Checking available appointment times…
                    </p>
                </div>
            </div>
        `;
    }

    function renderDashboardAvailability(payload, iso) {
        const panel = getDashboardAvailabilityPanel();

        if (!panel) return;

        dashboardSlotCache.set(iso, payload);

        const slots = Array.isArray(payload?.slots) ? payload.slots : [];

        const availableSlots = slots.filter(slot => {
            if (typeof slot === 'string') return true;

            return !(
                slot.is_taken ||
                slot.taken ||
                slot.booked ||
                slot.available === false
            );
        });

        const previewSlots = availableSlots.slice(0, 5);
        const earliestSlot = previewSlots.length ?
            (typeof previewSlots[0] === 'string' ? previewSlots[0] : previewSlots[0]?.time) :
            null;

        const bookingUrl = calendarConfig.bookingUrl ?
            `${calendarConfig.bookingUrl}?date=${encodeURIComponent(iso)}` :
            '#';

        if (!availableSlots.length) {
            panel.innerHTML = `
        <div class="dashboard-calendar-side-content">
            <div class="dashboard-calendar-side-top">
                <div>
                    <span class="dashboard-calendar-eyebrow">
                        Selected date
                    </span>

                    <strong class="dashboard-calendar-side-date">
                        ${formatCalendarDateLabel(iso)}
                    </strong>
                </div>

                <span class="dashboard-calendar-status unavailable">
                    <i class="fa-solid fa-circle-xmark"></i>
                    No slots
                </span>
            </div>

            <div class="dashboard-calendar-side-state unavailable">
                <i class="fa-regular fa-calendar-xmark"></i>

                <p>
                    ${payload?.message || 'No available appointment slots for this date.'}
                </p>
            </div>
        </div>
    `;

            return;
        }

        panel.innerHTML = `
            <div class="dashboard-calendar-side-content">
                <div class="dashboard-calendar-side-top">
                    <div>
                        <span class="dashboard-calendar-eyebrow">
                            Selected date
                        </span>

                        <strong class="dashboard-calendar-side-date">
                            ${formatCalendarDateLabel(iso)}
                        </strong>
                    </div>

                    <span class="dashboard-calendar-status available">
                        <i class="fa-solid fa-circle-check"></i>
                        ${availableSlots.length}
                        ${availableSlots.length === 1 ? 'time slot' : 'time slots'}
                    </span>
                </div>

                <div class="dashboard-calendar-side-section">
                    <span class="dashboard-calendar-side-label">
                        Available times
                    </span>

                    <div class="dashboard-calendar-preview-slots">
                        ${previewSlots.map(slot => {
                            const time = typeof slot === 'string'
                                ? slot
                                : slot.time;

                            return `
                                <span class="dashboard-calendar-preview-slot">
                                    <i class="fa-regular fa-clock"></i>
                                    ${time}
                                </span>
                            `;
                        }).join('')}
                    </div>
                </div>

                <div class="dashboard-calendar-side-footer">
                    <span>
                        ${earliestSlot
                            ? `Earliest available: ${earliestSlot}`
                            : 'Slots are subject to confirmation'}
                    </span>

                    <a
                        href="${bookingUrl}"
                        class="dashboard-calendar-book-btn"
                    >
                        <i class="fa-solid fa-calendar-plus"></i>
                        Book this date
                    </a>
                </div>
            </div>
        `;
    }

    function renderSlots(payload, iso) {
        const slotPlaceholder = document.getElementById(calendarConfig.slotPlaceholderId);
        const slotContainer = document.getElementById(calendarConfig.slotContainerId);
        const slotGrid = document.getElementById(calendarConfig.slotGridId);
        const banner = document.getElementById(calendarConfig.dateBannerId);
        const pill = document.getElementById(calendarConfig.datePillId);
        const timePill = document.getElementById(calendarConfig.selectedTimePillId);
        const timeText = document.getElementById(calendarConfig.selectedTimeTextId);
        const clearSlotBtn = document.getElementById('clearSlotSelectionBtn');

        const slots = payload?.slots || [];
        const remaining = payload?.remaining ?? 0;
        const maxSlots = payload?.max_slots ?? 0;

        if (slotGrid) {
            slotGrid.innerHTML = "";
            slotGrid.style.display = "grid";

            slotGrid.className = "slot-grid-ui";
        }

        if (timePill) {
            timePill.classList.remove("show");
            timePill.classList.add("hidden");
            timePill.style.display = "none";
        }
        if (timeText) timeText.textContent = "";

        if (clearSlotBtn) {
            clearSlotBtn.classList.add('hidden');
            clearSlotBtn.setAttribute('aria-hidden', 'true');
        }

        const [y, m, d] = iso.split("-");
        const MONTHS = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        if (banner) {
            if (calendarConfig.renderStyle === 'dentist') {
                banner.classList.add("hidden");
                banner.style.display = "none";
                banner.innerHTML = "";
            } else {
                const slotColor = remaining <= 2 ? "rgba(255,220,100,0.9)" : "rgba(160,255,180,0.9)";
                banner.innerHTML =
                    `<i class="fa-regular fa-calendar mr-2"></i>${MONTHS[parseInt(m) - 1]} ${parseInt(d)}, ${y}<span style="margin-left:8px; font-size:0.75rem; color:${slotColor};">(${remaining}/${maxSlots} slots left)</span>`;
                banner.classList.remove("hidden");
                banner.style.display = "block";
            }
        }

        if (pill) {
            pill.innerHTML =
                `<i class="fa-regular fa-calendar mr-1"></i>${MONTHS[parseInt(m) - 1]} ${parseInt(d)}, ${y}<span style="margin-left:.5rem;opacity:.8;">${remaining}/${maxSlots} slots left</span>`;
            pill.classList.add("show");
        }

        if (slotPlaceholder) {
            slotPlaceholder.classList.add("hidden");
            slotPlaceholder.style.display = "none";
        }

        if (slotContainer) {
            slotContainer.classList.remove("hidden");
            slotContainer.style.display = "block";
        }

        if (!slots.length) {
            if (slotGrid) {
                slotGrid.innerHTML =
                    `<div class="text-sm text-[#9e9690] italic py-4 text-center w-full">${payload?.message || 'No available slots for this date.'}</div>`;
            }
            if (slotPlaceholder && calendarConfig.renderStyle === 'dentist') {
                slotPlaceholder.style.display = "flex";
                slotPlaceholder.innerHTML = `
                    <i class="fa-regular fa-calendar-xmark"></i>
                    <span>${payload?.message || 'No available slots for this date.'}</span>
                `;
            }
            if (clearSlotBtn) {
                clearSlotBtn.classList.add('hidden');
                clearSlotBtn.setAttribute('aria-hidden', 'true');
            }
            return;
        }

        slots.forEach(slot => {
            const timeValue = typeof slot === 'string' ? slot : slot.time;
            const disabled = typeof slot === 'object' ?
                (slot.is_taken || slot.taken || slot.booked || slot.available === false) :
                false;

            const chip = document.createElement("div");

            if (calendarConfig.renderStyle === 'dentist') {
                chip.className =
                    "slot-chip flex items-center justify-center gap-2 rounded-2xl border font-bold text-[0.98rem] " +
                    (disabled ?
                        "disabled border-[#e8dfdb] bg-[#f8f5f4] text-[#8f8580] line-through opacity-60 cursor-not-allowed pointer-events-none" :
                        "border-[#e7d8d2] bg-white text-[#2f2f2f] cursor-pointer");

                chip.innerHTML = disabled ?
                    `<i class="fa-solid fa-ban text-[0.9rem]"></i><span>${timeValue}</span>` :
                    `<i class="fa-regular fa-clock text-[0.9rem]"></i><span>${timeValue}</span>`;
            } else {
                chip.className =
                    "slot-chip flex items-center gap-2.5 px-4 py-2.5 rounded-xl border font-semibold text-sm cursor-pointer " +
                    (disabled ?
                        "border-[#e8e2dd] text-[#c4bfba] line-through opacity-60 cursor-not-allowed" :
                        "border-[#e8e2dd] bg-[#fafaf8] text-[#1a1410] hover:border-[#8B0000] hover:bg-[#fff5f5] hover:text-[#8B0000]"
                    );
                chip.innerHTML = disabled ?
                    `<i class="text-xs opacity-70 fa-solid fa-ban"></i><span>${timeValue} </span>` :
                    `<i class="text-xs opacity-70 fa-regular fa-clock"></i><span>${timeValue}</span>`;
            }

            chip.dataset.time = timeValue;

            if (!disabled) {
                chip.addEventListener("click", () => {
                    const timeError = document.getElementById(calendarConfig.timeErrorId);
                    const dateError = document.getElementById(calendarConfig.dateErrorId);
                    const slotsWrap = document.querySelector(calendarConfig.slotsWrapSelector);
                    const timeInput = document.getElementById(calendarConfig.timeInputId);

                    const currentDisplay = document.getElementById(calendarConfig
                        .selectedSlotDisplayId || "selectedSlotDisplay");
                    const currentDisplayTxt = document.getElementById(calendarConfig
                        .selectedSlotTextId || "selectedSlotText");
                    const currentTimePill = document.getElementById(calendarConfig.selectedTimePillId ||
                        "selectedTimePill");
                    const currentTimeText = document.getElementById(calendarConfig.selectedTimeTextId ||
                        "selectedTimeText");

                    if (!hasSelectedDateValue()) {
                        if (dateError) {
                            dateError.textContent = "Please select a date first.";
                            dateError.style.display = "block";
                        }

                        if (timeError) {
                            timeError.textContent = "Please select a date first.";
                            timeError.style.display = "block";
                        }

                        if (slotsWrap) {
                            slotsWrap.classList.add("error");
                        }

                        return;
                    }

                    if (timeError) timeError.style.display = "none";
                    if (dateError) dateError.style.display = "none";
                    if (slotsWrap) slotsWrap.classList.remove("error");

                    // click ulit sa same selected time = unselect
                    if (selectedTime === timeValue) {
                        chip.classList.remove(
                            "selected", "bg-[#8B0000]", "text-white",
                            "border-[#8B0000]", "shadow-[0_2px_12px_rgba(139,0,0,0.25)]"
                        );

                        chip.classList.add("border-[#e8e2dd]", "bg-[#fafaf8]", "text-[#1a1410]");
                        chip.setAttribute("aria-pressed", "false");

                        selectedTime = null;
                        if (timeInput) {
                            timeInput.value = "";
                            timeInput.dispatchEvent(new Event("change", {
                                bubbles: true
                            }));
                        }

                        if (currentDisplayTxt) currentDisplayTxt.textContent = "";
                        currentDisplay?.classList.add("hidden");

                        if (currentTimeText) currentTimeText.textContent = "";
                        if (currentTimePill) {
                            currentTimePill.classList.remove("show");
                            currentTimePill.classList.add("hidden");
                            currentTimePill.style.display = "none";
                        }

                        clearSlotBtn?.classList.add('hidden');
                        clearSlotBtn?.setAttribute('aria-hidden', 'true');

                        if (typeof markFormDirty === "function") markFormDirty();
                        return;
                    }

                    slotGrid.querySelectorAll(".slot-chip").forEach(c => {
                        c.classList.remove(
                            "selected", "bg-[#8B0000]", "text-white",
                            "border-[#8B0000]", "shadow-[0_2px_12px_rgba(139,0,0,0.25)]"
                        );
                        c.classList.add("border-[#e8e2dd]", "bg-[#fafaf8]", "text-[#1a1410]");
                        c.setAttribute("aria-pressed", "false");
                    });

                    chip.classList.add("selected", "bg-[#8B0000]", "text-white", "border-[#8B0000]");
                    chip.classList.remove(
                        "border-[#e8e2dd]", "border-[#e7d8d2]", "bg-[#fafaf8]",
                        "bg-white", "text-[#1a1410]", "text-[#2f2f2f]"
                    );
                    chip.setAttribute("aria-pressed", "true");

                    selectedTime = timeValue;
                    if (timeInput) {
                        timeInput.value = timeValue;
                        timeInput.dispatchEvent(new Event("change", {
                            bubbles: true
                        }));
                    }

                    if (currentDisplayTxt) currentDisplayTxt.textContent = timeValue;
                    currentDisplay?.classList.remove("hidden");

                    if (currentTimeText) currentTimeText.textContent = timeValue;
                    if (currentTimePill) {
                        currentTimePill.classList.remove("hidden");
                        currentTimePill.classList.add("show");
                        currentTimePill.style.display = "block";
                    }

                    clearSlotBtn?.classList.remove('hidden');
                    clearSlotBtn?.removeAttribute('aria-hidden');

                    if (typeof markFormDirty === "function") markFormDirty();
                });
            }

            slotGrid.appendChild(chip);
        });
    }

    let currentYear = new Date().getFullYear();
    let currentMonth = new Date().getMonth();

    window.changeMonth = function(dir) {
        const candidate = new Date(
            currentYear,
            currentMonth + Number(dir),
            1
        );

        const {
            minimum,
            maximum
        } = getMonthBounds();

        if (candidate < minimum || candidate > maximum) {
            return;
        }

        clearTimeout(dashboardLoadingTimer);
        dashboardLoadingTimer = null;

        currentYear = candidate.getFullYear();
        currentMonth = candidate.getMonth();
        selectedDate = null;
        focusedDateIso = null;

        renderCalendar();
    };

    document.addEventListener("DOMContentLoaded", function() {
        const queryDate = new URLSearchParams(window.location.search).get('date');
        const queryDateState = queryDate ? getCalendarDateStateFromIso(queryDate) : null;

        if (calendarConfig.mode === 'patient-dashboard') {
            currentYear = todayDate.getFullYear();
            currentMonth = todayDate.getMonth();
        }

        if (
            calendarConfig.mode === 'booking' &&
            queryDateState &&
            !queryDateState.isDisabled
        ) {
            currentYear = queryDateState.cellDate.getFullYear();
            currentMonth = queryDateState.cellDate.getMonth();
            selectedDate = queryDateState.iso;
            focusedDateIso = queryDateState.iso;
        }

        if (calendarConfig.mode !== 'booking') {
            renderCalendarLoading();
        }

        setTimeout(async () => {
            renderCalendar();

            if (
                calendarConfig.mode === 'booking' &&
                queryDateState &&
                !queryDateState.isDisabled
            ) {
                await selectDate(queryDateState.iso);
            }
        }, calendarConfig.mode === 'booking' ? 0 : 650);
    });
</script>
