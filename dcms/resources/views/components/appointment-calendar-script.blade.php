<style>
    .slots-wrap #slotGrid.slot-grid-ui {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        grid-template-rows: repeat(4, 56px);
        grid-auto-rows: 56px;
        grid-auto-flow: column;
        gap: 0.75rem !important;
        align-items: stretch;
    }

    .slots-wrap #slotGrid.slot-grid-ui .slot-chip {
        width: 100%;
        min-height: 56px;
        height: 56px;
        border-radius: 16px !important;
        justify-content: center !important;
        padding: 0 0.9rem !important;
    }

    @media (max-width: 640px) {
        .slots-wrap #slotGrid.slot-grid-ui {
            grid-template-columns: 1fr !important;
            grid-template-rows: none;
            grid-auto-flow: row;
        }
    }

    .slots-wrap .slot-grid {
        display: grid !important;
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 12px !important;
    }

    .slots-wrap .slots-grid,
    .slots-wrap .slot-grid {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        gap: 12px !important;
    }

    @media (max-width: 480px) {
        .slots-wrap .slot-grid {
            grid-template-columns: 1fr !important;
        }

        .slots-wrap .slots-grid,
        .slots-wrap .slot-grid {
            grid-template-columns: 1fr !important;
        }
    }

    .cal-cell[data-disabled="1"],
    .cal-cell.disabled,
    .cal-cell.holiday,
    .cal-cell.full {
        cursor: not-allowed !important;
    }

    .cal-cell-wrap:has(.cal-cell.disabled) {
        cursor: not-allowed !important;
    }

    .cal-time-layout {
        grid-template-columns: minmax(0, 1fr) minmax(360px, 420px);
        gap: 1.5rem;
    }

    .two-col {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(360px, 420px);
        gap: 1.5rem;
        align-items: stretch;
    }

    .two-col>.cal-wrap,
    .two-col>.slots-wrap {
        height: 100%;
    }

    .two-col>.slots-wrap {
        display: flex;
        flex-direction: column;
    }

    .two-col>.slots-wrap #slotContainer,
    .two-col>.slots-wrap #slotPlaceholder {
        flex: 1 1 auto;
    }

    .two-col>.slots-wrap #slotContainer {
        display: flex;
        flex-direction: column;
    }

    .two-col>.slots-wrap #slotGrid.slot-grid-ui {
        flex: 1 1 auto;
        align-content: start;
    }

    .slots-wrap .slot-btn {
        background: #fff !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 10px !important;
        padding: 14px 16px !important;
        text-align: left !important;
        cursor: pointer !important;
        position: relative !important;
        overflow: hidden !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 4px !important;
        justify-content: flex-start !important;
        align-items: flex-start !important;
        transition: all 0.2s ease !important;
    }

    .slots-wrap .slot-btn.available:hover {
        border-color: #8b0000;
        background: #fffafb;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 0, 0, 0.08);
    }

    .slots-wrap .slot-btn.selected {
        background: #8b0000;
        border-color: #8b0000;
        color: #fff;
        box-shadow: 0 4px 12px rgba(139, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .slots-wrap .slot-time {
        font-size: 14px;
        font-weight: 700;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .slots-wrap .slot-btn.selected .slot-time {
        color: #fff;
    }

    .slots-wrap .slot-status {
        font-size: 12px;
        font-weight: 500;
        color: #6b7280;
    }

    .slots-wrap .slot-btn.selected .slot-status {
        color: rgba(255, 255, 255, 0.8);
    }

    .slots-wrap .slot-btn.booked {
        background: #f9fafb;
        border-color: #f3f4f6;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .slots-wrap .slot-btn.booked .slot-time {
        color: #9ca3af;
        text-decoration: line-through;
    }

    .slots-wrap .slot-btn.booked .slot-status {
        color: #ef4444;
    }

    .cal-shell {
        width: 100%;
    }

    .cal-nav-btn {
        transition: all 0.18s ease;
    }

    .cal-nav-btn:hover {
        background: #f9e8e8;
        border-color: #8B0000;
    }

    .cal-cell-wrap {
        min-height: 46px;
    }

    .cal-tooltip {
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.18s ease, transform 0.18s ease, visibility 0.18s ease;
    }

    .cal-cell-wrap:hover .cal-tooltip {
        opacity: 1;
        visibility: visible;
    }

    .cal-day,
    .cal-cell {
        transition: all 0.18s ease;
        user-select: none;
    }

    .cal-day:hover:not(.disabled):not(.other-month):not(.today),
    .cal-cell:hover:not(.disabled):not(.other-month):not(.today) {
        background: #f9e8e8;
        color: #8B0000;
        transform: translateY(-1px);
    }

    .cal-day.today:hover,
    .cal-cell.today:hover {
        background: #8B0000 !important;
        color: #fff !important;
        transform: none;
    }

    .cal-day.disabled,
    .cal-cell.disabled {
        cursor: not-allowed;
        opacity: 0.58;
    }

    .cal-day.selected,
    .cal-cell.selected {
        background: #8B0000 !important;
        color: #fff !important;
        font-weight: 800;
        box-shadow: 0 2px 12px rgba(139, 0, 0, 0.28);
    }

    .cal-cell {
        width: 40px;
        height: 40px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-inline: auto;
        position: relative;
        font-size: 0.92rem;
        font-weight: 700;
        color: #4b5563;
        background: transparent;
        border: 1px solid transparent;
    }

    .cal-cell.holiday {
        background: #fef3c7 !important;
        color: #a16207 !important;
        font-weight: 800;
    }

    .cal-cell.full {
        background: #fef2f2;
        color: #b91c1c;
        font-weight: 800;
    }

    .cal-cell.disabled {
        color: #c7c2bd;
        cursor: not-allowed !important;
    }

    .cal-cell.today {
        background: #8B0000;
        color: #fff;
        font-weight: 800;
        box-shadow: 0 2px 12px rgba(139, 0, 0, 0.25);
    }

    .cal-legend {
        margin-top: 1.25rem;
        padding-top: 0.9rem;
        border-top: 1px solid #e5e7eb;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.5rem;
    }

    .cal-legend-item {
        display: inline-flex;
        align-items: center;
        line-height: 1;
    }
</style>

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

    function makeMyAppointmentBadge() {
        return `
            <span class="absolute -top-1 -right-1 min-w-[16px] h-4 px-1 rounded-full bg-emerald-600 text-[9px] leading-none
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

        scheduleRules: @json($scheduleRules ?? []),
        blockedDates: @json($blockedDates ?? []),
        apptCounts: @json($appointmentCountsPerDay ?? []),
        holidaysMap: @json($philippineHolidays ?? []),
        personalAppointments: @json($personalAppointments ?? []),

        disallowToday: @json($disallowToday ?? true),
        allowToggleOffDate: @json($allowToggleOffDate ?? true),
        useDynamicScheduleRules: @json($useDynamicScheduleRules ?? false),
        renderStyle: @json($renderStyle ?? 'patient'),
    };

    let selectedDate = null;
    let selectedTime = null;

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

    function getRuleForDate(dateObj) {
        if (!calendarConfig.useDynamicScheduleRules) return null;
        const dayAbbr = getDayAbbrFromDate(dateObj);

        return (calendarConfig.scheduleRules || []).find(rule => {
            const days = normalizeDays(rule.days);
            return Boolean(rule.is_active) && days.includes(dayAbbr);
        }) || null;
    }

    function getMaxPerDay(dateObj) {
        const rule = getRuleForDate(dateObj);
        return rule?.max_slots ?? 0;
    }

    function isDateSchedulable(dateObj, iso) {
        if (!calendarConfig.useDynamicScheduleRules) {
            return !calendarConfig.blockedDates.includes(iso) && !calendarConfig.holidaysMap?.[iso];
        }

        const rule = getRuleForDate(dateObj);
        if (!rule || rule.status === 'closed') return false;
        if (calendarConfig.blockedDates.includes(iso)) return false;
        if (calendarConfig.holidaysMap?.[iso]) return false;

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

    function getLegendItemsForMode(mode) {
        if (mode === 'dentist') {
            return ['today', 'hasPatients', 'fullyBooked', 'holiday', 'clinicClosed'];
        }

        if (mode === 'patient-dashboard' || mode === 'patient-appointment') {
            return ['myAppointment', 'today', 'fullyBooked', 'holiday', 'clinicClosed'];
        }

        return ['fullyBooked', 'holiday', 'clinicClosed', 'todayNotAvailable'];
    }

    function renderUnifiedCalendarLegend(mode) {
        if (mode === 'dentist') {
            return `
            <div class="mt-5 pt-3 border-t border-gray-200 flex flex-wrap items-center justify-center gap-2">

                <div class="relative group">
                    <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#8B0000]/10 text-[#8B0000] text-[11px] font-semibold cursor-default">
                        <i class="fa-solid fa-calendar-day text-[10px]"></i>
                        Today
                    </div>
                    <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 hidden group-hover:block bg-[#8B0000] text-white text-[10px] px-2 py-1 rounded shadow whitespace-nowrap z-20">
                        Current date
                    </div>
                </div>

                <div class="relative group">
                    <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] font-semibold cursor-default">
                        <i class="fa-solid fa-user-check text-[10px]"></i>
                        Has Patients
                    </div>
                    <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 hidden group-hover:block bg-emerald-600 text-white text-[10px] px-2 py-1 rounded shadow whitespace-nowrap z-20">
                        Dates with scheduled patients
                    </div>
                </div>

                <div class="relative group">
                    <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-100 text-red-700 text-[11px] font-semibold cursor-default">
                        <i class="fa-solid fa-ban text-[10px]"></i>
                        Fully Booked
                    </div>
                    <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 hidden group-hover:block bg-red-600 text-white text-[10px] px-2 py-1 rounded shadow whitespace-nowrap z-20">
                        Maximum patients reached
                    </div>
                </div>

                <div class="relative group">
                    <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-[11px] font-semibold cursor-default">
                        <i class="fa-solid fa-star text-[10px]"></i>
                        Holiday
                    </div>
                    <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 hidden group-hover:block bg-yellow-500 text-white text-[10px] px-2 py-1 rounded shadow whitespace-nowrap z-20">
                        Official holiday (clinic closed)
                    </div>
                </div>

                <div class="relative group">
                    <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-[11px] font-semibold cursor-default">
                        <i class="fa-solid fa-circle-minus text-[10px]"></i>
                        Unavailable
                    </div>
                    <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 hidden group-hover:block bg-gray-700 text-white text-[10px] px-2 py-1 rounded shadow whitespace-nowrap z-20">
                        Clinic closed / weekends
                    </div>
                </div>

            </div>
            `;
        }

        const items = getLegendItemsForMode(mode);

        return `
            <div class="cal-legend">
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
                dotClass: "bg-emerald-600",
                tooltipBg: "bg-[#008440]",
                tooltipArrow: "after:border-t-[#008440]",
                cellBg: "bg-emerald-50",
                cellText: "text-emerald-700",
                legendIcon: `
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] font-semibold">
                        <i class="fa-regular fa-calendar-check text-[10px]"></i>
                        My Appointment
                    </span>
                `,
                badge: () => makeMyAppointmentBadge(),
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
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#8B0000]/10 text-[#8B0000] text-[11px] font-semibold">
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
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] font-semibold">
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
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-100 text-red-700 text-[11px] font-semibold">
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
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-[11px] font-semibold">
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
                cellBg: "bg-gray-100",
                cellText: "text-gray-500",
                legendIcon: `
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-[11px] font-semibold">
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
                cellBg: "bg-gray-100",
                cellText: "text-gray-500",
                legendIcon: `
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-[11px] font-semibold">
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

        const isToday = cellDate.getTime() === todayDate.getTime();
        const isPast = cellDate < todayDate;
        const isPastOrToday = calendarConfig.disallowToday ? cellDate <= todayDate : isPast;

        const holidayName = calendarConfig.holidaysMap?.[iso] || null;
        const isHoliday = !!holidayName;
        const isClosed = !isDateSchedulable(cellDate, iso);

        const maxPerDay = calendarConfig.useDynamicScheduleRules ? getMaxPerDay(cellDate) : 0;
        const count = calendarConfig.apptCounts?.[iso] ?? 0;
        const isFull = !isClosed && maxPerDay > 0 ? count >= maxPerDay : false;

        const myAppointment = calendarConfig.personalAppointments?.[iso] || null;
        const hasPatients = count > 0;

        const isBookingMode = calendarConfig.mode === 'booking';
        const isDisabled = isPastOrToday || isHoliday || isClosed || isFull;
        const isSelected = iso === selectedDate;

        return {
            iso,
            cellDate,
            isToday,
            isPast,
            isPastOrToday,
            holidayName,
            isHoliday,
            isClosed,
            isFull,
            myAppointment,
            hasPatients,
            count,
            isBookingMode,
            isDisabled,
            isSelected
        };
    }

    function getCalendarDayDecorations(state, variant = 'patient') {
        let cellClass = "cal-cell";

        let badgeHtml = "";
        let tooltipHtml = "";
        let tooltip = "";
        let tooltipBg = "bg-[#1a1410]";
        let tooltipArrow = "after:border-t-[#1a1410]";

        if (variant !== 'dentist') {
            if (state.isSelected) {
                cellClass += " selected bg-[#8B0000] text-white font-bold shadow-[0_2px_12px_rgba(139,0,0,0.3)]";
            } else if (state.isToday) {
                if (state.isBookingMode) {
                    cellClass += " bg-gray-200 text-gray-500 cursor-not-allowed disabled";
                } else {
                    cellClass += " today bg-[#8B0000] text-white font-extrabold ring-2 ring-[#8B0000]/30 ring-offset-1";
                }
            } else if (state.isHoliday) {
                cellClass +=
                    ` holiday ${CALENDAR_THEME.statuses.holiday.cellBg} ${CALENDAR_THEME.statuses.holiday.cellText} font-bold disabled`;
            } else if (state.isFull) {
                cellClass +=
                    ` full ${CALENDAR_THEME.statuses.fullyBooked.cellBg} ${CALENDAR_THEME.statuses.fullyBooked.cellText} font-bold disabled`;
            } else if (state.isClosed) {
                cellClass += " text-[#d1ccc8] cursor-not-allowed disabled";
            } else if (state.isPastOrToday && state.isBookingMode) {
                cellClass += " text-[#d1ccc8] cursor-not-allowed disabled";
            } else if (state.isPast) {
                cellClass += " text-gray-400 cursor-default disabled";
            }
        } else {
            if (state.isSelected) {
                cellClass += " selected";
            } else if (state.isToday) {
                cellClass += " today disabled";
            } else if (state.isHoliday) {
                cellClass += " holiday disabled";
            } else if (state.isFull) {
                cellClass += " full disabled";
            } else if (state.isClosed || state.isPastOrToday) {
                cellClass += ` disabled ${CALENDAR_THEME.statuses.clinicClosed.cellText}`;
            }
        }

        if (state.myAppointment && !state.isBookingMode) {
            badgeHtml += CALENDAR_THEME.statuses.myAppointment.badge();
            tooltip = `<i class="fa-regular fa-calendar-check mr-1 text-[#6EE7A0]"></i>${state.myAppointment}`;
            tooltipBg = CALENDAR_THEME.statuses.myAppointment.tooltipBg;
            tooltipArrow = CALENDAR_THEME.statuses.myAppointment.tooltipArrow;
        }

        if (state.isHoliday) {
            badgeHtml += CALENDAR_THEME.statuses.holiday.badge();
            if (!tooltip) {
                tooltip = `<i class="fa-solid fa-star mr-1 text-white"></i>${state.holidayName}`;
                tooltipBg = CALENDAR_THEME.statuses.holiday.tooltipBg;
                tooltipArrow = CALENDAR_THEME.statuses.holiday.tooltipArrow;
            }
        } else if (state.isFull) {
            if (!state.myAppointment && !state.isClosed) {
                badgeHtml += makeCalendarDot(CALENDAR_THEME.statuses.fullyBooked.dotClass, state.count > 0 ? String(
                    state.count) : '');
            }
            if (!tooltip) {
                tooltip = state.isBookingMode ? "Full Slot" : "Fully Booked";
                tooltipBg = CALENDAR_THEME.statuses.fullyBooked.tooltipBg;
                tooltipArrow = CALENDAR_THEME.statuses.fullyBooked.tooltipArrow;
            }
        } else if (state.isClosed && !state.isPast) {
            if (!state.myAppointment) {
                badgeHtml += CALENDAR_THEME.statuses.clinicClosed.badge();
            }
            if (!tooltip) {
                tooltip = "Clinic Closed";
                tooltipBg = CALENDAR_THEME.statuses.clinicClosed.tooltipBg;
                tooltipArrow = CALENDAR_THEME.statuses.clinicClosed.tooltipArrow;
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

        if (state.isBookingMode) {
            if (state.isHoliday) {} else if (state.isToday) {
                tooltip = "Same-day booking is not allowed.";
                tooltipBg = "bg-gray-600";
                tooltipArrow = "after:border-t-gray-600";
            } else if (state.isPastOrToday) {
                tooltip = "Past date — booking not allowed";
                tooltipBg = "bg-gray-500";
                tooltipArrow = "after:border-t-gray-500";
            } else if (state.isClosed && !state.isPast) {
                tooltip = "Clinic closed on this date.";
                tooltipBg = "bg-gray-600";
                tooltipArrow = "after:border-t-gray-600";
            }
        } else {
            if (state.isToday && !tooltip && !state.myAppointment) {
                tooltip = "Today";
                tooltipBg = CALENDAR_THEME.statuses.today.tooltipBg;
                tooltipArrow = CALENDAR_THEME.statuses.today.tooltipArrow;
            }
        }

        if (tooltip) {
            tooltipHtml = `
            <div class="cal-tooltip absolute bottom-[calc(100%+10px)] left-1/2 -translate-x-1/2 ${tooltipBg} text-white text-[0.65rem] font-medium px-2.5 py-1.5 rounded-lg whitespace-nowrap z-50 pointer-events-none after:content-[''] after:absolute after:top-full after:left-1/2 after:-translate-x-1/2 after:border-4 after:border-transparent ${tooltipArrow}">
                ${tooltip}
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
            '<div class="h-4 bg-gray-100 rounded mx-2"></div>'
        ).join("");

        const dayCellSkeleton = Array.from({
            length: 35
        }).map(() =>
            '<div class="flex items-center justify-center py-1.5">' +
            '<div class="w-10 h-10 rounded-xl bg-gray-100"></div>' +
            '</div>'
        ).join("");

        container.innerHTML =
            '<div class="cal-shell animate-pulse">' +
            '<div class="flex items-center justify-between mb-5">' +
            '<div class="w-8 h-8 rounded-full bg-gray-200"></div>' +
            '<div class="text-center space-y-2">' +
            '<div class="h-5 w-28 bg-gray-200 rounded mx-auto"></div>' +
            '<div class="h-3 w-16 bg-gray-100 rounded mx-auto"></div>' +
            '</div>' +
            '<div class="w-8 h-8 rounded-full bg-gray-200"></div>' +
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
                <div class="h-4 w-24 bg-gray-200 rounded"></div>
            </div>
        `).join("");
        }
    }

    function isPatientDashboardLockedMonth() {
        return calendarConfig.mode === 'patient-dashboard';
    }

    function isCurrentMonthView(year, month) {
        return year === todayDate.getFullYear() && month === todayDate.getMonth();
    }

    function renderUnifiedCalendar(year, month) {
        const MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
            "October", "November", "December"
        ];
        const DAYS_PATIENT = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        const DAYS_DENTIST = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"];

        const isDentist = calendarConfig.renderStyle === 'dentist';
        const dayLabels = isDentist ? DAYS_DENTIST : DAYS_PATIENT;

        const firstDow = new Date(year, month, 1).getDay();
        const totalDays = new Date(year, month + 1, 0).getDate();

        const lockMonth = isPatientDashboardLockedMonth();
        const atCurrentMonth = isCurrentMonthView(year, month);

        const prevDisabled = lockMonth ? true : false;
        const nextDisabled = lockMonth ? true : false;

        const header = dayLabels.map((d, i) => `
        <div class="text-center text-[0.6rem] font-bold py-1 pb-2 uppercase tracking-widest ${i === 0 || i === 6 ? 'text-[rgba(139,0,0,0.4)]' : 'text-[#9e9690]'}">
            ${d}
        </div>
    `).join("");

        let cells = "";
        for (let i = 0; i < firstDow; i++) cells += `<div></div>`;

        for (let d = 1; d <= totalDays; d++) {
            const state = resolveCalendarDayState(year, month, d);
            const ui = getCalendarDayDecorations(state, isDentist ? 'dentist' : 'patient');

            cells += `
            <div class="cal-cell-wrap relative flex items-center justify-center py-1.5 group">
                ${ui.tooltipHtml}
                <div class="${ui.cellClass}" data-date="${state.iso}" data-disabled="${state.isDisabled ? 1 : 0}">
                    <span>${d}</span>
                    ${ui.badgeHtml}
                </div>
            </div>
        `;
        }

        const markup = `
        <div class="cal-shell">
            <div class="flex items-center justify-between mb-5">
                <button
                    type="button"
                    class="cal-nav-btn w-8 h-8 rounded-full border border-[#e8e2dd] flex items-center justify-center text-[#8B0000] text-xs ${prevDisabled ? 'opacity-40 cursor-not-allowed pointer-events-none' : ''}"
                    ${prevDisabled ? 'disabled' : 'onclick="changeMonth(-1)"'}>
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <div class="text-center">
                    <p class="text-base font-extrabold text-[#660000]">${MONTHS[month]}</p>
                    <p class="text-[0.65rem] text-[#9e9690] font-semibold tracking-widest">${year}</p>
                </div>
                <button
                    type="button"
                    class="cal-nav-btn w-8 h-8 rounded-full border border-[#e8e2dd] flex items-center justify-center text-[#8B0000] text-xs ${nextDisabled ? 'opacity-40 cursor-not-allowed pointer-events-none' : ''}"
                    ${nextDisabled ? 'disabled' : 'onclick="changeMonth(1)"'}>
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
            <hr class="border-[#f0ebe6] mb-3">
            <div class="grid grid-cols-7 gap-0.5">${header}${cells}</div>
            ${renderUnifiedCalendarLegend(calendarConfig.mode)}
        </div>
    `;

        const container = document.getElementById(calendarConfig.calendarContainerId);
        if (container) container.innerHTML = markup;

        bindCalendarClicks(`#${calendarConfig.calendarContainerId} [data-date]`);
    }

    function renderCalendar() {
        renderUnifiedCalendar(currentYear, currentMonth);
    }

    function bindCalendarClicks(selector) {
        if (!calendarConfig.dateInputId && calendarConfig.mode !== 'dentist') return;

        document.querySelectorAll(selector).forEach(el => {
            el.addEventListener("click", () => {
                if (el.dataset.disabled === "1") return;
                selectDate(el.dataset.date);
            });
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

        renderCalendar();
    }

    async function selectDate(iso) {
        if (calendarConfig.mode === 'patient-dashboard' || calendarConfig.mode === 'patient-appointment') {
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

    function renderSlots(payload, iso) {
        const slotPlaceholder = document.getElementById(calendarConfig.slotPlaceholderId);
        const slotContainer = document.getElementById(calendarConfig.slotContainerId);
        const slotGrid = document.getElementById(calendarConfig.slotGridId);
        const banner = document.getElementById(calendarConfig.dateBannerId);
        const pill = document.getElementById(calendarConfig.datePillId);
        const timePill = document.getElementById(calendarConfig.selectedTimePillId);
        const timeText = document.getElementById(calendarConfig.selectedTimeTextId);

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
                    const slotsWrap = document.querySelector(calendarConfig.slotsWrapSelector);
                    const timeInput = document.getElementById(calendarConfig.timeInputId);

                    if (timeError) timeError.style.display = "none";
                    if (slotsWrap) slotsWrap.classList.remove("error");

                    slotGrid.querySelectorAll(".slot-chip").forEach(c => {
                        c.classList.remove("selected", "bg-[#8B0000]", "text-white",
                            "border-[#8B0000]", "shadow-[0_2px_12px_rgba(139,0,0,0.25)]");
                        if (calendarConfig.renderStyle !== 'dentist') {
                            c.classList.add("border-[#e8e2dd]", "bg-[#fafaf8]",
                                "text-[#1a1410]");
                        }
                    });

                    chip.classList.add("selected", "bg-[#8B0000]", "text-white", "border-[#8B0000]");
                    chip.classList.remove("border-[#e8e2dd]", "border-[#e7d8d2]", "bg-[#fafaf8]",
                        "bg-white", "text-[#1a1410]", "text-[#2f2f2f]");

                    selectedTime = timeValue;
                    if (timeInput) timeInput.value = timeValue;
                    if (typeof markFormDirty === "function") markFormDirty();

                    let currentDisplay = document.getElementById(calendarConfig.selectedSlotDisplayId ||
                        "selectedSlotDisplay");
                    let currentDisplayTxt = document.getElementById(calendarConfig.selectedSlotTextId ||
                        "selectedSlotText");
                    let currentTimePill = document.getElementById(calendarConfig.selectedTimePillId ||
                        "selectedTimePill");
                    let currentTimeText = document.getElementById(calendarConfig.selectedTimeTextId ||
                        "selectedTimeText");

                    if (currentDisplayTxt) currentDisplayTxt.textContent = timeValue;
                    if (currentDisplay) currentDisplay.classList.remove("hidden");

                    if (currentTimeText) currentTimeText.textContent = timeValue;
                    if (currentTimePill) {
                        currentTimePill.classList.remove("hidden");
                        currentTimePill.classList.add("show");
                        currentTimePill.style.display = "block";
                    }
                });
            }

            slotGrid.appendChild(chip);
        });
    }

    let currentYear = new Date().getFullYear();
    let currentMonth = new Date().getMonth();

    window.changeMonth = function(dir) {
        if (calendarConfig.mode === 'patient-dashboard') {
            currentYear = todayDate.getFullYear();
            currentMonth = todayDate.getMonth();
            renderCalendar();
            return;
        }

        currentMonth += dir;

        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }

        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }

        renderCalendar();
    };

    document.addEventListener("DOMContentLoaded", function() {
        if (calendarConfig.mode === 'patient-dashboard') {
            currentYear = todayDate.getFullYear();
            currentMonth = todayDate.getMonth();
        }

        renderCalendarLoading();

        setTimeout(() => {
            renderCalendar();
        }, 350);
    });
</script>
