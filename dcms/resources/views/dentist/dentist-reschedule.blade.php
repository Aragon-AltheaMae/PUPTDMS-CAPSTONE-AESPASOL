@extends('layouts.dentist')

@section('title', 'Appointments | PUP Taguig Dental Clinic')

@section('styles')

    <style>
        :root {
            --red: #8B0000;
            --red-mid: #a31515;
            --red-lt: #fff0f0;
            --red-pale: #fde8e8;
            --sand: #fdf6f0;
            --warm: #f9f0e8;
            --text: #2d1f1f;
            --muted: #9a7b7b;
            --border: #ecdada;
            --crimson: #8B0000;
            --crimson-dark: #6b0000;
            --crimson-light: #fef2f2;
            --crimson-mid: #fce8e8;
            --sidebar-w: 256px;
            --header-h: 64px;
        }

        * {
            box-sizing: border-box;
        }

        /* ── PAGE WRAPPER ── */
        .page {
            padding-top: 78px;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding-bottom: 2rem;
            background: #f4f4f4;
        }

        /* ── MAIN CARD ── */
        .card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 40px rgba(139, 0, 0, 0.28), 0 1px 4px rgba(0, 0, 0, .04);
            width: 100%;
            max-width: 860px;
            margin: 1.25rem 1rem;
            overflow: hidden;
        }

        /* Card top stripe */
        .card-header {
            background: linear-gradient(135deg, #6b0000, #8B0000);
            padding: 1.25rem 1.75rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .card-header-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: #fff;
            flex-shrink: 0;
        }

        .card-header h1 {
            font-size: 1.35rem;
            font-weight: 700;
            color: #fff;
            margin: 0;
            line-height: 1.2;
        }

        .card-header p {
            font-size: .75rem;
            color: rgba(255, 255, 255, .7);
            margin: .15rem 0 0;
        }

        .card-body {
            padding: 1.5rem 1.75rem;
        }

        /* ── CURRENT APPOINTMENT BANNER ── */
        .appt-banner {
            background: var(--warm);
            border: 1.5px solid #f0d8c0;
            border-radius: 14px;
            padding: 1rem 1.25rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .appt-banner-item {
            flex: 1;
            min-width: 120px;
        }

        .appt-banner-label {
            font-size: .65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: #c07b3a;
            margin-bottom: .2rem;
        }

        .appt-banner-value {
            font-size: .9rem;
            font-weight: 600;
            color: #7a4a1e;
        }

        /* ── SECTION LABEL ── */
        .section-label {
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: .75rem;
            display: flex;
            align-items: center;
            gap: .4rem;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── TWO-COL LAYOUT ── */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }

        @media (max-width: 600px) {
            .two-col {
                grid-template-columns: 1fr;
            }
        }

        /* ── COMPACT CALENDAR ── */
        .cal-wrap {
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 1rem;
            background: #fff;
        }

        .cal-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: .75rem;
        }

        .cal-nav-btn {
            width: 28px;
            height: 28px;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            background: var(--red-lt);
            color: var(--red);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            transition: background .15s;
        }

        .cal-nav-btn:hover {
            background: var(--red-pale);
        }

        .cal-month {
            font-size: .95rem;
            font-weight: 700;
            color: var(--red);
        }

        .cal-year {
            font-size: .7rem;
            color: var(--muted);
        }

        .cal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
            text-align: center;
        }

        .cal-day-hdr {
            font-size: .58rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--muted);
            padding: 2px 0 6px;
        }

        .cal-day-hdr.weekend {
            color: #c07b7b;
        }

        .cal-cell-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .cal-cell {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            font-size: .75rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all .12s;
            color: var(--text);
        }

        .cal-cell:hover:not(.disabled):not(.past) {
            background: var(--red-lt);
            color: var(--red);
        }

        .cal-cell.today {
            background: var(--red);
            color: #fff;
            font-weight: 700;
        }

        .cal-cell.selected {
            background: var(--red) !important;
            color: #fff !important;
            font-weight: 700;
        }

        .cal-cell.disabled,
        .cal-cell.past {
            color: #ddd;
            cursor: not-allowed;
        }

        .cal-cell.holiday {
            background: #eff6ff;
            color: #2563eb;
            font-weight: 600;
        }

        .cal-cell.full {
            background: #fef2f2;
            color: #dc2626;
            font-weight: 600;
            cursor: not-allowed;
        }

        .cal-dot.dot-red {
            background: #ef4444;
        }

        .cal-cell.unavail {
            color: #e0e0e0;
            cursor: not-allowed;
        }

        .cal-dot {
            position: absolute;
            bottom: 1px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            border-radius: 50%;
        }

        .dot-red {
            background: #ef4444;
        }

        .dot-blue {
            background: #3b82f6;
        }

        .cal-tooltip {
            opacity: 0;
            transition: opacity 0.15s;
            pointer-events: none;
        }
        .cal-cell-wrap:hover .cal-tooltip {
            opacity: 1;
        }

        /* ── TIME SLOTS ── */
        .slots-wrap {
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 1rem;
            background: #fff;
            display: flex;
            flex-direction: column;
        }

        .slots-date-pill {
            background: linear-gradient(135deg, var(--red), #a31515);
            color: #fff;
            border-radius: 10px;
            padding: .45rem .85rem;
            font-size: .75rem;
            font-weight: 600;
            margin-bottom: .75rem;
            display: none;
        }

        .slots-date-pill.show {
            display: block;
        }

        .slots-placeholder {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            font-size: .78rem;
            gap: .4rem;
            padding: 1rem 0;
        }

        .slots-placeholder i {
            font-size: 1.4rem;
            opacity: .4;
        }

        .slots-grid {
            display: flex;
            flex-wrap: wrap;
            gap: .4rem;
        }

        .slot-chip {
            padding: .35rem .75rem;
            border-radius: 9999px;
            border: 1.5px solid var(--border);
            background: #fff;
            font-size: .72rem;
            font-weight: 600;
            cursor: pointer;
            color: var(--text);
            transition: all .12s;
        }

        .slot-chip:hover:not(.full) {
            border-color: var(--red);
            background: var(--red-lt);
            color: var(--red);
        }

        .slot-chip.selected {
            background: var(--red);
            border-color: var(--red);
            color: #fff;
        }

        .slot-chip.full {
            border-color: #eee;
            color: #ccc;
            cursor: not-allowed;
            text-decoration: line-through;
            font-size: .68rem;
        }

        .selected-time-pill {
            margin-top: .6rem;
            font-size: .75rem;
            font-weight: 600;
            color: var(--red);
            display: none;
            align-items: center;
            gap: .3rem;
        }

        .selected-time-pill.show {
            display: flex;
        }

        /* Legend */
        .legend {
            display: flex;
            flex-wrap: wrap;
            gap: .6rem .9rem;
            padding-top: .75rem;
            border-top: 1px solid var(--border);
            margin-top: .75rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: .35rem;
            font-size: .68rem;
            color: var(--muted);
        }

        .legend-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* ── REASON TEXTAREA ── */
        .reason-wrap {
            margin-bottom: 1.25rem;
        }

        .reason-textarea {
            width: 100%;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: .75rem 1rem;
            font-size: .82rem;
            resize: none;
            color: var(--text);
            background: #fff;
            transition: border-color .15s;
            outline: none;
        }

        .reason-textarea:focus {
            border-color: var(--red-mid);
        }

        .reason-textarea::placeholder {
            color: #cbb8b8;
        }

        /* ── BUTTONS ── */
        .btn-row {
            display: flex;
            justify-content: flex-end;
            gap: .75rem;
        }

        .btn {
            padding: .6rem 1.5rem;
            border-radius: 10px;
            font-size: .82rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            transition: all .15s;
            border: none;
            text-decoration: none;
        }

        .btn-cancel {
            background: #fff;
            color: var(--red);
            border: 1.5px solid var(--border);
        }

        .btn-cancel:hover {
            background: var(--red-lt);
            border-color: var(--red-pale);
        }

        .btn-confirm {
            background: linear-gradient(135deg, #6b0000, var(--red));
            color: #fff;
            box-shadow: 0 3px 12px rgba(139, 0, 0, .25);
        }

        .btn-confirm:hover {
            box-shadow: 0 5px 18px rgba(139, 0, 0, .35);
            transform: translateY(-1px);
        }

        /* ── SUCCESS MODAL ── */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .35);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 200;
        }

        .modal-backdrop.show {
            display: flex;
        }

        .modal-box {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            max-width: 360px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .15);
            animation: popIn .25s ease;
        }

        @keyframes popIn {
            from {
                transform: scale(.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #c6fde4;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: green;
        }

        .modal-title {
            font-size: 1.3rem;
            font-weight: 500;
            color: var(--text);
            margin-bottom: .4rem;
        }

        .modal-msg {
            font-size: .8rem;
            color: var(--muted);
            margin-bottom: 1.25rem;
            line-height: 1.6;
        }

        .modal-btn {
            background: var(--red);
            color: #fff;
            border: none;
            padding: .6rem 1.75rem;
            border-radius: 10px;
            font-size: .82rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s;
        }

        .modal-btn:hover {
            background: #6b0000;
        }

        .error-msg {
            font-size: .72rem;
            font-weight: 600;
            color: #be123c;
            background: #fff1f2;
            border: 1.5px solid #fecdd3;
            border-radius: 8px;
            padding: .4rem .75rem;
            margin-bottom: .5rem;
            display: flex;
            align-items: center;
            gap: .4rem;
        }

        .cal-wrap.error,
        .slots-wrap.error {
            border-color: #fca5a5;
            background: #fffafa;
        }
    </style>
@endsection

@section('content')
@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

    <!-- PAGE -->
    <main class="page">
        <div class="card">

            <!-- Card Header -->
            <div class="card-header">
                <div class="card-header-icon"><i class="fa-regular fa-calendar-check"></i></div>
                <div>
                    <h1>Reschedule Appointment</h1>
                    <p>Pick a new date, time, and optionally add a reason.</p>
                </div>
            </div>

            <div class="card-body">

                <!-- Current Appointment Banner -->
                <div class="appt-banner">
                    <div class="appt-banner-item">
                        <div class="appt-banner-label"><i class="fa-solid fa-user fa-xs mr-1"></i>Patient</div>
                        <div class="appt-banner-value">{{ $appointment->patient->name ?? 'N/A' }}</div>
                    </div>
                    <div class="appt-banner-item">
                        <div class="appt-banner-label"><i class="fa-regular fa-clock fa-xs mr-1"></i>Current Schedule
                        </div>
                        <div class="appt-banner-value">{{
                            \Carbon\Carbon::parse($appointment->appointment_date)->format('M j, Y') }} · {{
                            \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</div>
                    </div>
                    <div class="appt-banner-item">
                        <div class="appt-banner-label"><i class="fa-solid fa-tooth fa-xs mr-1"></i>Service</div>
                        <div class="appt-banner-value">{{ $appointment->service_type ?? 'N/A' }}</div>
                    </div>
                </div>

                <!-- Form -->
                <form id="rescheduleForm"
                    action="{{ route('dentist.dentist.appointments.reschedule.update', $appointment->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="service_type" value="{{ $appointment->service_type }}">
                    <input type="hidden" id="new_appointment_date" name="new_appointment_date" required>
                    <input type="hidden" id="new_appointment_time" name="new_appointment_time" required>

                    <!-- Calendar + Slots -->
                    <div class="section-label"><i class="fa-regular fa-calendar fa-xs"></i> New Date & Time</div>

                    <div id="dateError" class="error-msg" style="display:none;">
                        <i class="fa-solid fa-circle-exclamation"></i> Please select a date.
                    </div>

                    <div class="two-col">

                        <!-- Calendar -->
                        <div class="cal-wrap">                        
                            <div id="calendarContainer"></div>

                            <!-- Legend -->
                            <div class="legend">
                                <div class="legend-item"><span class="legend-dot" style="background:#ef4444;"></span>
                                    Full</div>
                                <div class="legend-item"><span class="legend-dot" style="background:#3b82f6;"></span>
                                    Holiday</div>
                                <div class="legend-item"><span class="legend-dot" style="background:#d1d5db;"></span>
                                    Unavailable</div>
                                <div class="legend-item"><span class="legend-dot" style="background:#9ca3af;"></span>
                                    Today not available</div>
                            </div>
                        </div>

                        <!-- Time Slots -->
                        <div class="slots-wrap">
                            <div class="section-label" style="margin-bottom:.6rem;"><i
                                    class="fa-regular fa-clock fa-xs"></i> Time Slot</div>
                            <div class="slots-date-pill" id="datePill"></div>
                            <div id="slotPlaceholder" class="slots-placeholder">
                                <i class="fa-regular fa-calendar-xmark"></i>
                                <span>Select a date to see available slots</span>
                            </div>
                            <div id="slotGrid" class="slots-grid" style="display:none;"></div>
                            <div class="selected-time-pill" id="selectedTimePill">
                                <i class="fa-solid fa-circle-check" style="color:var(--red);"></i>
                                <span id="selectedTimeText"></span>
                            </div>
                        </div>

                        <div id="timeError" class="error-msg" style="display:none;">
                            <i class="fa-solid fa-circle-exclamation"></i> Please select a time slot.
                        </div>

                    </div>

                    <!-- Reason -->
                    <div class="section-label"><i class="fa-regular fa-message fa-xs"></i> Reason for Rescheduling <span
                            style="font-weight:400;text-transform:none;letter-spacing:0;">(optional)</span></div>
                    <div class="reason-wrap">
                        <textarea name="reschedule_reason" id="reschedule_reason" class="reason-textarea"
                            placeholder="e.g. Patient requested a later date…" rows="3"></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="btn-row">
                        <button type="button" class="btn btn-cancel" id="cancelBtn">
                            <i class="fa-solid fa-xmark"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-confirm">
                            <i class="fa-solid fa-check"></i> Confirm Reschedule
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </main>

    <!-- Success Modal -->
    <div class="modal-backdrop" id="successModal">
        <div class="modal-box">
            <div class="modal-icon"><i class="fa-solid fa-check text-green"></i></div>
            <div class="modal-title">All Set!</div>
            <div class="modal-msg" id="successMessage">The appointment has been rescheduled successfully.</div>
            <button class="modal-btn" id="okBtn">Back to Appointments</button>
        </div>
    </div>

    <!-- Cancel Confirmation Modal -->
    <div class="modal-backdrop" id="cancelModal">
        <div class="modal-box">
            <div class="modal-icon" style="background:#fff5f5;">
                <i class="fa-solid fa-triangle-exclamation" style="color:#f59e0b;"></i>
            </div>
            <div class="modal-title">Discard Changes?</div>
            <div class="modal-msg">Are you sure you want to cancel? Any unsaved changes will be lost.</div>
            <div style="display:flex;gap:.75rem;justify-content:center;">
                <button class="modal-btn" style="background:#e5e7eb;color:#374151;" id="cancelStayBtn">
                    Stay on Page
                </button>
                <button class="modal-btn" id="cancelConfirmBtn">
                    Yes, Cancel
                </button>
            </div>
        </div>
    </div>

    @include('components.appointment-calendar-script', [
        'mode'                    => 'reschedule',
        'renderStyle'             => 'patient',
        'calendarContainerId'     => 'calendarContainer',
        'calGridId'               => 'calendarContainer',
        'calMonthLabelId'         => 'calMonthLabel', 
        'calYearLabelId'          => 'calYearLabel',
        'dateInputId'             => 'new_appointment_date',
        'timeInputId'             => 'new_appointment_time',
        'datePillId'              => 'datePill',
        'slotPlaceholderId'       => 'slotPlaceholder',
        'slotGridId'              => 'slotGrid',
        'selectedTimePillId'      => 'selectedTimePill',
        'selectedTimeTextId'      => 'selectedTimeText',
        'dateErrorId'             => 'dateError',
        'timeErrorId'             => 'timeError',
        'calendarWrapSelector'    => '.cal-wrap',
        'slotsWrapSelector'       => '.slots-wrap',
        'slotEndpoint'            => route('dentist.appointment.slots'),
        'scheduleRules'           => $schedules ?? [],
        'blockedDates'            => $blockedDates ?? [],
        'appointmentCountsPerDay' => $appointmentCountsPerDay ?? [],
        'philippineHolidays'      => $philippineHolidays ?? [],
        'disallowToday'           => true,
        'allowToggleOffDate'      => true,
        'useDynamicScheduleRules' => true,
    ])
@endsection

@section('scripts')
    <script>
        // ── Mobile Drawer ────────────────────────────────────────────
        function openDrawer() {
            document.getElementById('mobileDrawer').classList.add('open');
            document.getElementById('mobileDrawerOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeDrawer() {
            document.getElementById('mobileDrawer').classList.remove('open');
            document.getElementById('mobileDrawerOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }

        /* NOTIF */
        document.getElementById('notifBtn').addEventListener('click', e => {
            e.stopPropagation();
            document.getElementById('notifMenu').classList.toggle('open');
        });
        document.addEventListener('click', () => document.getElementById('notifMenu').classList.remove('open'));

        /* USER DROPDOWN */
        document.getElementById('userBtn').addEventListener('click', e => {
            e.stopPropagation();
            document.getElementById('notifMenu').classList.remove('open'); // close notif if open
            document.getElementById('userMenu').classList.toggle('open');
        });
        document.addEventListener('click', () => document.getElementById('userMenu').classList.remove('open'));

        /* Sync user menu theme toggle */
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('#userMenuThemeToggle .theme-option').forEach(o =>
                o.addEventListener('click', e => { e.stopPropagation(); applyTheme(o.getAttribute('data-theme')); })
            );
        });

        // ── Theme & Sidebar
        const html = document.documentElement;

        function applyTheme(theme) {
            html.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            document.querySelectorAll('.theme-option').forEach(o =>
                o.getAttribute('data-theme') === theme ? o.classList.add('active') : o.classList.remove('active'));
            const ind = document.querySelector('.theme-indicator');
            if (ind) theme === 'dark' ? ind.classList.add('dark-mode') : ind.classList.remove('dark-mode');
        }

        let sidebarOpen = true;

        function applyLayout(w) {
            document.getElementById('sidebar').style.width = w;
            document.getElementById('mainContent').style.marginLeft = w;
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const icon = document.getElementById('sidebarIcon');
            const isCollapsed = sidebar.classList.contains('collapsed');

            if (isCollapsed) {
                sidebar.classList.remove('collapsed');
                sidebar.style.width = '220px';
                document.getElementById('mainContent').style.marginLeft = '220px';
                icon.className = 'fa-solid fa-xmark';
            } else {
                sidebar.classList.add('collapsed');
                sidebar.style.width = '64px';
                document.getElementById('mainContent').style.marginLeft = '64px';
                icon.className = 'fa-solid fa-bars';
            }
        }

        function applyLayout(w) {
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('mainContent');
            if (sidebar) sidebar.style.width = w;
            if (main) main.style.marginLeft = w;
        }

        document.getElementById("cancelBtn").addEventListener("click", () => {
            document.getElementById("cancelModal").classList.add("show");
        });

        document.getElementById("cancelStayBtn").addEventListener("click", () => {
            document.getElementById("cancelModal").classList.remove("show");
        });

        document.getElementById("cancelConfirmBtn").addEventListener("click", () => {
            window.location.href = "{{ route('dentist.dentist.appointments') }}";
        });

        /* ── FORM SUBMIT ── */
        document.getElementById("rescheduleForm").addEventListener("submit", async e => {
            e.preventDefault();

            let valid = true;

            if (!selectedDate) {
                document.getElementById("dateError").style.display = "flex";
                document.querySelector(".cal-wrap").classList.add("error");
                valid = false;
            }

            if (!selectedTime) {
                document.getElementById("timeError").style.display = "flex";
                document.querySelector(".slots-wrap").classList.add("error");
                valid = false;
            }

            if (!valid) return;

            const form = document.getElementById("rescheduleForm");
            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                        "Accept": "application/json",
                    },
                    body: formData,
                });

                if (response.ok || response.redirected) {
                    document.getElementById("successModal").classList.add("show");
                } else {
                    const data = await response.json().catch(() => null);
                    alert(data?.message ?? "Something went wrong. Please try again.");
                }
            } catch (err) {
                alert("Network error. Please try again.");
            }
        });

        document.getElementById("okBtn").addEventListener("click", () => {
            document.getElementById("successModal").classList.remove("show");
            window.location.href = "{{ route('dentist.dentist.appointments') }}";
        });
    </script>
@endsection