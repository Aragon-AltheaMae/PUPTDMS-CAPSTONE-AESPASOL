<script>
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
        return dateObj.toLocaleDateString('en-US', { weekday: 'short' }).replace('.', '');
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

    function renderPatientStyleCalendar(year, month) {
        const MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        const DAYS = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        const firstDow = new Date(year, month, 1).getDay();
        const totalDays = new Date(year, month + 1, 0).getDate();

        let header = DAYS.map((d, i) => `
            <div class="text-center text-[0.6rem] font-bold py-1 pb-2 uppercase tracking-widest ${i === 0 || i === 6 ? 'text-[rgba(139,0,0,0.4)]' : 'text-[#9e9690]'}">
                ${d}
            </div>
        `).join("");

        let cells = "";
        for (let i = 0; i < firstDow; i++) cells += `<div></div>`;

        for (let d = 1; d <= totalDays; d++) {
            const iso = `${year}-${pad(month + 1)}-${pad(d)}`;
            const cellDate = new Date(year, month, d);
            cellDate.setHours(0, 0, 0, 0);

            const isToday = cellDate.getTime() === todayDate.getTime();
            const isPast = cellDate < todayDate;
            const isPastOrToday = calendarConfig.disallowToday ? cellDate <= todayDate : isPast;
            const isHoliday = !!calendarConfig.holidaysMap?.[iso];
            const isUnavail = !isDateSchedulable(cellDate, iso);
            const maxPerDay = calendarConfig.useDynamicScheduleRules ? getMaxPerDay(cellDate) : 0;
            const count = calendarConfig.apptCounts?.[iso] ?? 0;
            const isFull = !isUnavail && maxPerDay > 0 ? count >= maxPerDay : false;
            const isDisabled = isPastOrToday || isHoliday || isUnavail || isFull;
            const isSelected = iso === selectedDate;

            let cls = "cal-day w-full h-full flex items-center justify-center text-sm font-medium rounded-full cursor-pointer relative";

            if (isSelected) cls += " bg-[#8B0000] text-white font-bold shadow-[0_2px_12px_rgba(139,0,0,0.3)]";
            else if (isToday) cls += " bg-gray-200 text-gray-500 cursor-not-allowed disabled";
            else if (isPastOrToday) cls += " text-[#d1ccc8] cursor-not-allowed disabled";
            else if (isHoliday) cls += " bg-blue-50 text-blue-700 font-bold disabled";
            else if (isUnavail) cls += " text-[#d1ccc8] cursor-not-allowed unavailable disabled";
            else if (isFull) cls += " bg-red-50 text-red-700 font-bold disabled";

            let dotHtml = "";
            if (!isPastOrToday && !isSelected) {
                if (isHoliday) dotHtml = `<span class="absolute bottom-0.5 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-blue-400"></span>`;
                else if (isFull) dotHtml = `<span class="absolute bottom-0.5 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-red-500"></span>`;
                else if (isUnavail) dotHtml = `<span class="absolute bottom-0.5 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-gray-400"></span>`;
            }

            let tip = "";
            if (isToday) tip = "Same-day booking is not allowed.";
            else if (isPastOrToday) tip = "Past date — booking not allowed";
            else if (isHoliday) tip = calendarConfig.holidaysMap[iso];
            else if (isUnavail) tip = "Clinic closed on this date.";
            else if (isFull) tip = "Full Slot";

            const tipHtml = tip ? `
                <div class="cal-tooltip absolute bottom-[calc(100%+10px)] left-1/2 -translate-x-1/2 bg-[#1a1410] text-white text-[0.65rem] font-medium px-2.5 py-1.5 rounded-lg whitespace-nowrap z-50 after:content-[''] after:absolute after:top-full after:left-1/2 after:-translate-x-1/2 after:border-4 after:border-transparent after:border-t-[#1a1410]">
                    ${tip}
                </div>
            ` : "";

            cells += `
                <div class="cal-cell-wrap relative flex items-center justify-center aspect-square">
                    ${tipHtml}
                    <div class="${cls}" data-date="${iso}" data-disabled="${isDisabled ? 1 : 0}">
                        ${d}${dotHtml}
                    </div>
                </div>
            `;
        }

        document.getElementById(calendarConfig.calendarContainerId).innerHTML = `
            <div class="flex items-center justify-between mb-5">
                <button type="button" class="cal-nav-btn w-8 h-8 rounded-full border border-[#e8e2dd] flex items-center justify-center text-[#8B0000] text-xs" onclick="changeMonth(-1)">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <div class="text-center">
                    <p class="text-base font-extrabold text-[#660000]">${MONTHS[month]}</p>
                    <p class="text-[0.65rem] text-[#9e9690] font-semibold tracking-widest">${year}</p>
                </div>
                <button type="button" class="cal-nav-btn w-8 h-8 rounded-full border border-[#e8e2dd] flex items-center justify-center text-[#8B0000] text-xs" onclick="changeMonth(1)">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
            <hr class="border-[#f0ebe6] mb-3">
            <div class="grid grid-cols-7 gap-0.5">${header}${cells}</div>
        `;

        bindCalendarClicks(`#${calendarConfig.calendarContainerId} [data-date]`);
    }

    function renderDentistStyleCalendar(year, month) {
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        const dayLabels = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"];

        document.getElementById(calendarConfig.calMonthLabelId).textContent = monthNames[month];
        document.getElementById(calendarConfig.calYearLabelId).textContent = year;

        const firstDow = new Date(year, month, 1).getDay();
        const totalDays = new Date(year, month + 1, 0).getDate();

        const holidays = {};
        Object.keys(calendarConfig.holidaysMap || {}).forEach(ds => {
            const [hy, hm] = ds.split("-").map(Number);
            if (hy === year && hm === month + 1) holidays[ds] = calendarConfig.holidaysMap[ds];
        });

        let html = dayLabels.map((l, i) => `<div class="cal-day-hdr ${i === 0 || i === 6 ? 'weekend' : ''}">${l}</div>`).join('');
        for (let i = 0; i < firstDow; i++) html += `<div></div>`;

        for (let d = 1; d <= totalDays; d++) {
            const ds = `${year}-${pad(month + 1)}-${pad(d)}`;
            const cellDate = new Date(year, month, d);
            cellDate.setHours(0, 0, 0, 0);

            const isPast = cellDate < todayDate;
            const isToday = cellDate.getTime() === todayDate.getTime();
            const isPastOrToday = calendarConfig.disallowToday ? cellDate <= todayDate : isPast;
            const holiday = holidays[ds] || null;
            const isUnavail = !isDateSchedulable(cellDate, ds);
            const maxPerDay = calendarConfig.useDynamicScheduleRules ? getMaxPerDay(cellDate) : 0;
            const count = calendarConfig.apptCounts?.[ds] ?? 0;
            const isFull = !isUnavail && maxPerDay > 0 ? count >= maxPerDay : false;
            const isSelected = ds === selectedDate;
            const isDisabled = isPastOrToday || isUnavail || !!holiday || isFull;

            let cls = "cal-cell";
            if (isSelected) cls += " selected";
            else if (isToday) cls += " disabled";
            else if (holiday) cls += " holiday";
            else if (isFull) cls += " full";
            else if (isUnavail || isPastOrToday) cls += " disabled";

            let dot = "";
            if (holiday) dot = `<span class="cal-dot dot-blue"></span>`;
            else if (isFull) dot = `<span class="cal-dot dot-red"></span>`;
            else if (isUnavail && !isPastOrToday) dot = `<span class="cal-dot" style="background:#d1d5db;"></span>`;

            let tooltip = "";
            if (isToday) tooltip = "Today (not available)";
            else if (holiday) tooltip = holiday;
            else if (isFull) tooltip = "Full Slot";
            else if (isUnavail) tooltip = "Clinic closed";
            else if (isPastOrToday) tooltip = "Past date";

            const tipHtml = tooltip ? `
                <div style="
                    position:absolute;bottom:calc(100% + 6px);left:50%;transform:translateX(-50%);
                    background:#1a1a1a;color:#fff;font-size:.6rem;font-weight:600;white-space:nowrap;
                    padding:3px 8px;border-radius:6px;pointer-events:none;opacity:0;
                    transition:opacity .15s;z-index:99;" class="cal-tip">${tooltip}</div>
            ` : "";

            html += `
                <div class="cal-cell-wrap" style="position:relative;"
                    onmouseenter="this.querySelector('.cal-tip')&&(this.querySelector('.cal-tip').style.opacity=1)"
                    onmouseleave="this.querySelector('.cal-tip')&&(this.querySelector('.cal-tip').style.opacity=0)">
                    ${tipHtml}
                    <div class="${cls}" data-date="${ds}" data-disabled="${isDisabled ? 1 : 0}">
                        ${d}${dot}
                    </div>
                </div>
            `;
        }

        const grid = document.getElementById(calendarConfig.calGridId);
        if (grid) grid.innerHTML = html;
        bindCalendarClicks(`#${calendarConfig.calGridId} [data-date]`);
    }

    function bindCalendarClicks(selector) {
        document.querySelectorAll(selector).forEach(el => {
            el.addEventListener("click", () => {
                if (el.dataset.disabled === "1") return;
                selectDate(el.dataset.date);
            });
        });
    }

    function renderCalendar() {
        if (calendarConfig.renderStyle === 'dentist') {
            renderDentistStyleCalendar(currentYear, currentMonth);
        } else {
            renderPatientStyleCalendar(currentYear, currentMonth);
        }
    }

    function clearSlotSelectionUI() {
        const dateInput = document.getElementById(calendarConfig.dateInputId);
        const timeInput = document.getElementById(calendarConfig.timeInputId);
        const banner = document.getElementById(calendarConfig.dateBannerId);
        const pill = document.getElementById(calendarConfig.datePillId);
        const slotPlaceholder = document.getElementById(calendarConfig.slotPlaceholderId);
        const slotContainer = document.getElementById(calendarConfig.slotContainerId);
        const slotGrid = document.getElementById(calendarConfig.slotGridId);
        const display = document.getElementById(calendarConfig.selectedSlotDisplayId);
        const displayTxt = document.getElementById(calendarConfig.selectedSlotTextId);
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

        if (display) display.classList.add("hidden");
        if (displayTxt) displayTxt.textContent = "";

        if (timePill) timePill.classList.remove("show");
        if (timeText) timeText.textContent = "";

        if (slotPlaceholder) {
            slotPlaceholder.classList.remove("hidden");
            slotPlaceholder.style.display = "flex";
        }

        renderCalendar();
    }

    async function selectDate(iso) {
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

        renderCalendar();

        try {
            const payload = await fetchSlotsForDate(iso);
            renderSlots(payload, iso);
        } catch (error) {
            renderSlots({ slots: [], message: 'Unable to load available slots.' }, iso);
        }
    }

    function renderSlots(payload, iso) {
        const slotPlaceholder = document.getElementById(calendarConfig.slotPlaceholderId);
        const slotContainer = document.getElementById(calendarConfig.slotContainerId);
        const slotGrid = document.getElementById(calendarConfig.slotGridId);
        const banner = document.getElementById(calendarConfig.dateBannerId);
        const pill = document.getElementById(calendarConfig.datePillId);
        const display = document.getElementById(calendarConfig.selectedSlotDisplayId);
        const displayTxt = document.getElementById(calendarConfig.selectedSlotTextId);
        const timePill = document.getElementById(calendarConfig.selectedTimePillId);
        const timeText = document.getElementById(calendarConfig.selectedTimeTextId);

        const slots = payload?.slots || [];
        const remaining = payload?.remaining ?? 0;
        const maxSlots = payload?.max_slots ?? 0;

        if (slotGrid) {
            slotGrid.innerHTML = "";
            slotGrid.style.display = calendarConfig.renderStyle === 'dentist' ? "flex" : "block";
        }

        if (display) display.classList.add("hidden");
        if (displayTxt) displayTxt.textContent = "";
        if (timePill) timePill.classList.remove("show");
        if (timeText) timeText.textContent = "";

        const [y, m, d] = iso.split("-");
        const MONTHS = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        if (banner) {
            const slotColor = remaining <= 2 ? "rgba(255,220,100,0.9)" : "rgba(160,255,180,0.9)";
            banner.innerHTML = `<i class="fa-regular fa-calendar mr-2"></i>${MONTHS[parseInt(m) - 1]} ${parseInt(d)}, ${y}<span style="margin-left:8px; font-size:0.75rem; color:${slotColor};">(${remaining}/${maxSlots} slots left)</span>`;
            banner.classList.remove("hidden");
            banner.style.display = "block";
        }

        if (pill) {
            pill.innerHTML = `<i class="fa-regular fa-calendar mr-1"></i>${MONTHS[parseInt(m) - 1]} ${parseInt(d)}, ${y}<span style="margin-left:.5rem;opacity:.8;">${remaining}/${maxSlots} slots left</span>`;
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
                slotGrid.innerHTML = `<div class="text-sm text-[#9e9690] italic py-4 text-center w-full">${payload?.message || 'No available slots for this date.'}</div>`;
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
            const disabled = typeof slot === 'object' ? !slot.available : false;

            const chip = document.createElement("div");

            if (calendarConfig.renderStyle === 'dentist') {
                chip.className = "slot-chip" + (disabled ? " full" : "");
                chip.textContent = disabled ? `${timeValue} – Taken` : timeValue;
            } else {
                chip.className =
                    "slot-chip flex items-center gap-2.5 px-4 py-2.5 rounded-xl border font-semibold text-sm cursor-pointer " +
                    (disabled
                        ? "border-[#e8e2dd] text-[#c4bfba] line-through opacity-60 cursor-not-allowed"
                        : "border-[#e8e2dd] bg-[#fafaf8] text-[#1a1410] hover:border-[#8B0000] hover:bg-[#fff5f5] hover:text-[#8B0000]");
                chip.innerHTML = disabled
                    ? `<i class="text-xs opacity-70 fa-solid fa-ban"></i><span>${timeValue} — Taken</span>`
                    : `<i class="text-xs opacity-70 fa-regular fa-clock"></i><span>${timeValue}</span>`;
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
                        c.classList.remove("selected", "bg-[#8B0000]", "text-white", "border-[#8B0000]", "shadow-[0_2px_12px_rgba(139,0,0,0.25)]");
                        if (calendarConfig.renderStyle !== 'dentist') {
                            c.classList.add("border-[#e8e2dd]", "bg-[#fafaf8]", "text-[#1a1410]");
                        }
                    });

                    if (calendarConfig.renderStyle === 'dentist') {
                        chip.classList.add("selected");
                    } else {
                        chip.classList.add("bg-[#8B0000]", "text-white", "border-[#8B0000]", "shadow-[0_2px_12px_rgba(139,0,0,0.25)]");
                        chip.classList.remove("border-[#e8e2dd]", "bg-[#fafaf8]", "text-[#1a1410]");
                    }

                    selectedTime = timeValue;
                    if (timeInput) timeInput.value = timeValue;

                    if (displayTxt) displayTxt.textContent = timeValue;
                    if (display) display.classList.remove("hidden");

                    if (timeText) timeText.textContent = timeValue;
                    if (timePill) timePill.classList.add("show");
                });
            }

            slotGrid.appendChild(chip);
        });
    }

    let currentYear = new Date().getFullYear();
    let currentMonth = new Date().getMonth();

    window.changeMonth = function (dir) {
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

    document.addEventListener("DOMContentLoaded", function () {
        renderCalendar();
    });
</script>