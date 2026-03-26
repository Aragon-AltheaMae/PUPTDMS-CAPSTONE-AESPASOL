<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    colors: {
                        crimson: {
                            DEFAULT: '#8B0000',
                            dark: '#660000',
                            light: '#b30000',
                            faint: '#fff5f5',
                            muted: '#f9e8e8'
                        },
                        gold: '#c9a84c',
                    },
                    keyframes: {
                        fadeUp: {
                            from: {
                                opacity: '0',
                                transform: 'translateY(16px)'
                            },
                            to: {
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        },
                        shake: {
                            '0%,100%': {
                                transform: 'translateX(0)'
                            },
                            '25%': {
                                transform: 'translateX(-5px)'
                            },
                            '75%': {
                                transform: 'translateX(5px)'
                            }
                        },
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.5s ease-out both',
                        'fade-up-1': 'fadeUp 0.5s 0.1s ease-out both',
                        'fade-up-2': 'fadeUp 0.5s 0.2s ease-out both',
                        shake: 'shake 0.3s ease',
                    },
                }
            }
        }
    </script>
    <style>
        /* Minimal overrides not expressible in Tailwind utility classes */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .step-content {
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .step-content.show {
            opacity: 1;
        }

        .step-circle {
            transition: all 0.4s ease;
        }

        .step-connector {
            transition: background 0.4s;
        }

        .slot-chip {
            transition: all 0.2s;
        }

        .service-card-inner {
            transition: all 0.25s;
        }

        .progress-fill {
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .cal-tooltip {
            opacity: 0;
            transition: opacity 0.15s;
            pointer-events: none;
        }

        .cal-cell-wrap:hover .cal-tooltip {
            opacity: 1;
        }

        .form-input:focus {
            border-color: #8B0000;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.08);
            padding-right: 2.5rem !important;
        }

        .q-radio:checked {
            border-color: #8B0000;
            background: #8B0000;
            box-shadow: inset 0 0 0 3px white;
        }

        .q-radio:hover:not(:checked) {
            border-color: #8B0000;
        }

        .cal-day {
            transition: all 0.18s;
        }

        .cal-day:hover:not(.disabled):not(.other-month) {
            background: #f9e8e8;
            color: #8B0000;
        }

        .btn-primary-custom:hover {
            background: #660000;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(139, 0, 0, 0.3);
        }

        .btn-secondary-custom:hover {
            border-color: #8B0000;
            color: #8B0000;
            background: #fff5f5;
        }

        .service-card-label:hover .service-card-inner {
            border-color: #8B0000;
            background: #fff5f5;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 0, 0, 0.1);
        }

        .service-card-label:has(input:checked) .service-card-inner {
            border-color: #8B0000;
            background: #8B0000;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 0, 0, 0.25);
        }

        .service-card-label:has(input:checked) .svc-title {
            color: white;
        }

        .service-card-label:has(input:checked) .svc-desc {
            color: rgba(255, 255, 255, 0.75);
        }

        .service-card-label:has(input:checked) .svc-icon-wrap {
            background: rgba(255, 255, 255, 0.2);
        }

        .service-card-label:has(input:checked) .svc-arrow {
            color: rgba(255, 255, 255, 0.5);
        }

        .confirm-checkbox-wrap:hover {
            border-color: #8B0000;
        }

        .file-upload-zone:hover {
            border-color: #8B0000;
            background: #fff5f5;
        }

        .pika-single {
            font-family: 'Inter', sans-serif !important;
            border-radius: 12px !important;
            border: 1.5px solid #e8e2dd !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
        }

        .pika-button:hover {
            background: #f9e8e8 !important;
            color: #8B0000 !important;
        }

        .is-selected .pika-button {
            background: #8B0000 !important;
        }

        .cal-nav-btn:hover {
            background: #f9e8e8;
            border-color: #8B0000;
        }

        .mini-tab {
            bottom: 5rem;
        }

        /* ── HEADER ── */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            background: linear-gradient(135deg, #6b0000 0%, #8B0000 100%);
            padding: 0 2rem;
            height: 62px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 20px rgba(139, 0, 0, .25);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .header-logo {
            width: 36px;
            height: 36px;
            object-fit: contain;
        }

        .header-title {
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: .01em;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .notif-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .12);
            border: none;
            cursor: pointer;
            color: #fff;
            font-size: .95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .15s;
            position: relative;
        }

        .notif-btn:hover {
            background: rgba(255, 255, 255, .22);
        }

        .notif-badge {
            position: absolute;
            top: -3px;
            right: -3px;
            background: #ff6b6b;
            color: #fff;
            font-size: .6rem;
            font-weight: 700;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #8B0000;
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .header-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, .4);
            object-fit: cover;
        }

        .header-name {
            font-size: .82rem;
            font-weight: 600;
            color: #fff;
            line-height: 1.2;
        }

        .header-role {
            font-size: .7rem;
            color: rgba(255, 255, 255, .7);
            font-style: italic;
        }

        /* ── NOTIF MENU ── */
        #notifMenu {
            position: absolute;
            right: 0;
            top: calc(100% + 10px);
            width: 300px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .12);
            border: 1px solid #f0e6e6;
            opacity: 0;
            transform: scale(.95) translateY(-6px);
            pointer-events: none;
            transition: all .2s;
            transform-origin: top right;
            z-index: 100;
        }

        #notifMenu.open {
            opacity: 1;
            transform: scale(1) translateY(0);
            pointer-events: auto;
        }

        #notifDropdown {
            position: relative;
        }

        /* ── MOBILE PROFILE ACCORDION ── */
        #mobileProfileAccordion {
            display: none;
        }

        @media (max-width: 768px) {
            .cal-time-layout {
                grid-template-columns: 1fr !important;
            }

            .nav-btns-row {
                flex-direction: column;
                gap: 0.75rem;
            }

            .nav-btns-row button {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 640px) {
            .sm-grid-1col {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 767px) {
            #sidebar {
                display: none !important;
            }

            #mainContent {
                margin-left: 0 !important;
                padding-bottom: 90px;
            }

            #mobileBottomNav {
                display: flex;
            }

            footer {
                margin-bottom: 72px;
            }

            #desktopHeaderUser {
                display: none !important;
            }

            #mobileProfileAccordion {
                display: block;
                position: fixed;
                top: 62px;
                left: 0;
                right: 0;
                z-index: 45;
                background: white;
                border-bottom: 1px solid #f0e0e0;
                box-shadow: 0 4px 20px rgba(139, 0, 0, .08);
                max-height: 0;
                overflow: hidden;
                transition: max-height .35s cubic-bezier(.4, 0, .2, 1), opacity .25s ease;
                opacity: 0;
            }

            #mobileProfileAccordion.open {
                max-height: 200px;
                opacity: 1;
            }

            #mobileProfileToggle {
                display: flex !important;
            }
        }

        @media (min-width: 768px) {
            #mobileProfileToggle {
                display: none !important;
            }

            #darkModeFab {
                display: none !important;
            }

            #mobileBottomNav {
                display: none !important;
            }
        }

        @media (max-width: 480px) {
            .header-title {
                display: none;
                font-size: .55rem;
            }

            .header-name,
            .header-role {
                display: none;
            }

            .header {
                padding: 0 1rem;
            }
        }

        /* Ensure inputs have room for the mic icon */
        input[type="text"],
        input[type="email"],
        textarea {
            padding-right: 2.5rem !important;
        }

        #leaveModal::backdrop,
        #othersModal::backdrop,
        #confirmModal::backdrop {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(2px);
        }

        #leaveModal.flex {
            display: flex;
        }

        .pika-single {
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
            font-family: 'Inter', sans-serif;
        }

        .pika-button:hover {
            background: #8B0000 !important;
            color: white !important;
        }

        .is-selected .pika-button {
            background: #8B0000 !important;
            box-shadow: none !important;
        }

        .is-today .pika-button {
            color: #8B0000 !important;
            font-weight: bold;
        }
    </style>
</head>

@php
    $notifications = collect($notifications ?? []);
    $notifCount = $notifications->count();
@endphp

<body class="bg-[#F4F4F4] text-[#8B0000] min-h-screen"
    style="background-image: radial-gradient(circle at 20% 50%, rgba(139,0,0,0.03) 0%, transparent 60%), radial-gradient(circle at 80% 20%, rgba(201,168,76,0.04) 0%, transparent 50%);">

    <!-- HEADER -->
    <header class="header">
        <div class="header-left">
            <img src="{{ asset('images/PUP.png') }}" class="header-logo" alt="PUP">
            <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="header-logo" alt="DMS">
            <span class="header-title">PUP TAGUIG DENTAL CLINIC</span>
        </div>
        <div class="header-right">
            <div id="notifDropdown">
                <button class="notif-btn" id="notifBtn">
                    <i class="fa-regular fa-bell"></i>
                    @if ($notifCount > 0)
                        <span class="notif-badge">{{ $notifCount }}</span>
                    @endif
                </button>
                <div id="notifMenu">
                    <div
                        style="padding:.85rem 1rem .65rem;font-weight:700;color:#8B0000;font-size:.82rem;border-bottom:1px solid #f5e8e8;">
                        Notifications</div>
                    <div style="max-height:260px;overflow-y:auto;">
                        @forelse($notifications as $n)
                            <a href="{{ $n['url'] ?? '#' }}"
                                style="display:block;padding:.65rem 1rem;font-size:.78rem;color:#333;text-decoration:none;border-bottom:1px solid #fdf5f5;">
                                <div style="font-weight:600;">{{ $n['title'] ?? 'Notification' }}</div>
                                @if (!empty($n['message']))
                                    <div style="color:#aaa;margin-top:2px;">{{ $n['message'] }}</div>
                                @endif
                            </a>
                        @empty
                            <div style="padding:2rem 1rem;text-align:center;color:#bbb;font-size:.78rem;">You're all
                                caught up.</div>
                        @endforelse
                    </div>
                </div>
            </div>
            <button id="mobileProfileToggle" onclick="toggleMobileProfile()"
                style="display:none;align-items:center;gap:.6rem;background:none;border:none;cursor:pointer;padding:0;">
                <img class="header-avatar"
                    src="{{ $patient->profile_image ? asset('storage/' . $patient->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($patient->name) . '&background=660000&color=FFFFFF&rounded=true&size=36' }}"
                    alt="Profile">
                <i id="mobileProfileChevron"
                    class="fa-solid fa-chevron-down text-white text-xs transition-transform duration-300"></i>
            </button>
            <div class="header-user" id="desktopHeaderUser">
                <img class="header-avatar"
                    src="{{ $patient->profile_image ? asset('storage/' . $patient->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($patient->name) . '&background=660000&color=FFFFFF&rounded=true&size=36' }}"
                    alt="Profile">
                <div>
                    <div class="header-name">{{ ucwords(strtolower($patient->name)) }}</div>
                    <div class="header-role">Student</div>
                </div>
            </div>
        </div>
    </header>

    <!-- ══════ MOBILE PROFILE ACCORDION ══════ -->
    <div id="mobileProfileAccordion">
        <div class="flex items-center gap-4 px-5 py-4 border-b border-gray-100">
            <img class="w-12 h-12 rounded-full border-2 border-[#8B0000]/20 object-cover flex-shrink-0"
                src="{{ $patient->profile_image ? asset('storage/' . $patient->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($patient->name) . '&background=660000&color=FFFFFF&rounded=true&size=96' }}"
                alt="Profile">
            <div>
                <p class="font-bold text-[#333333] text-base leading-tight">{{ ucwords(strtolower($patient->name)) }}
                </p>
                <p class="text-xs text-[#757575] italic">Student</p>
            </div>
        </div>
        <div class="px-5 py-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-red-600 bg-red-50 hover:bg-red-100 font-semibold text-sm transition-colors duration-200">
                    <i class="fa-solid fa-right-from-bracket"></i> Log out
                </button>
            </form>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 pt-16 pb-2 animate-fade-up">

        <div class="flex items-center justify-between mt-8 mb-4">
            <a href="{{ route('homepage') }}"
                class="back-home-btn flex items-center gap-2 bg-[#8B0000] hover:bg-[#660000] text-white px-4 py-2 rounded-xl text-xs font-bold border border-[#660000] transition shadow-sm">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Back to Home
            </a>
            <span
                class="text-xs text-[#9e9690] font-semibold bg-white border border-[#e8e2dd] px-3 py-1.5 rounded-full shadow-sm">
                Step <span id="stepCounterText">1</span> <span class="text-[#c4bfba]">of 5</span>
            </span>
        </div>

        <!-- Progress bar -->
        <div class="w-full h-2 rounded-full bg-[#e8e2dd] overflow-hidden mb-5">
            <div id="headerProgressFill" class="h-full rounded-full progress-fill"
                style="width:20%; background: linear-gradient(90deg, #8B0000, #c9a84c)"></div>
        </div>

        <!-- Title -->
        <div class="text-center mb-1">
            <p class="text-xs font-semibold uppercase tracking-widest mb-1 text-[#8B0000]">
                <i class="fa-regular fa-calendar-check mr-1"></i> PUP TAGUIG DENTAL CLINIC
            </p>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-[#660000]">Book an Appointment</h1>
            <p class="text-sm text-[#9e9690] mt-1">Complete all five steps to schedule your dental visit.</p>
        </div>

    </div>

    <!-- ════ MAIN ════ -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 pb-16">

        <!-- STEPPER -->
        <div class="w-full mt-4 mb-0 animate-fade-up-1 py-3 px-2" style="overflow: visible;">
            <div class="flex items-start justify-between w-full" style="padding: 6px 0;">
                <!-- Node 1 -->
                <div class="flex flex-col items-center gap-1 min-w-0 flex-1">
                    <div id="sc1"
                        class="step-circle w-10 h-10 rounded-full border-2 border-blue-600 bg-blue-600 flex items-center justify-center text-sm font-bold text-white shadow-[0_0_0_6px_rgba(37,99,235,0.12)] scale-110">
                        1</div>
                    <span id="sl1"
                        class="step-label text-[0.65rem] font-semibold uppercase tracking-wide text-blue-600 text-center hidden sm:block mt-4">Date
                        &amp; Time</span>
                </div>
                <div id="conn1" class="h-0.5 bg-[#e8e2dd] flex-shrink-0 self-start step-connector"
                    style="width:clamp(8px, 3vw, 40px); margin-top:20px;"></div>
                <!-- Node 2 -->
                <div class="flex flex-col items-center gap-1 min-w-0 flex-1">
                    <div id="sc2"
                        class="step-circle w-10 h-10 rounded-full border-2 border-[#e8e2dd] bg-white flex items-center justify-center text-sm font-bold text-[#9e9690]">
                        2</div>
                    <span id="sl2"
                        class="step-label text-[0.65rem] font-semibold uppercase tracking-wide text-[#9e9690] text-center hidden sm:block mt-4">Service</span>
                </div>
                <div id="conn2" class="h-0.5 bg-[#e8e2dd] flex-shrink-0 self-start step-connector"
                    style="width:clamp(8px, 3vw, 40px); margin-top:20px;"></div>
                <!-- Node 3 -->
                <div class="flex flex-col items-center gap-1 min-w-0 flex-1">
                    <div id="sc3"
                        class="step-circle w-10 h-10 rounded-full border-2 border-[#e8e2dd] bg-white flex items-center justify-center text-sm font-bold text-[#9e9690]">
                        3</div>
                    <span id="sl3"
                        class="step-label text-[0.65rem] font-semibold uppercase tracking-wide text-[#9e9690] text-center hidden sm:block mt-4">Dental
                        History</span>
                </div>
                <div id="conn3" class="h-0.5 bg-[#e8e2dd] flex-shrink-0 self-start step-connector"
                    style="width:clamp(8px, 3vw, 40px); margin-top:20px;"></div>
                <!-- Node 4 -->
                <div class="flex flex-col items-center gap-1 min-w-0 flex-1">
                    <div id="sc4"
                        class="step-circle w-10 h-10 rounded-full border-2 border-[#e8e2dd] bg-white flex items-center justify-center text-sm font-bold text-[#9e9690]">
                        4</div>
                    <span id="sl4"
                        class="step-label text-[0.65rem] font-semibold uppercase tracking-wide text-[#9e9690] text-center hidden sm:block mt-4">Medical
                        History</span>
                </div>
                <div id="conn4" class="h-0.5 bg-[#e8e2dd] flex-shrink-0 self-start step-connector"
                    style="width:clamp(8px, 3vw, 40px); margin-top:20px;"></div>
                <!-- Node 5 -->
                <div class="flex flex-col items-center gap-1 min-w-0 flex-1">
                    <div id="sc5"
                        class="step-circle w-10 h-10 rounded-full border-2 border-[#e8e2dd] bg-white flex items-center justify-center text-sm font-bold text-[#9e9690]">
                        5</div>
                    <span id="sl5"
                        class="step-label text-[0.65rem] font-semibold uppercase tracking-wide text-[#9e9690] text-center hidden sm:block mt-4">Confirm</span>
                </div>
            </div>
        </div>

        <!-- BOOKING CARD -->
        <div
            class="mt-6 bg-white rounded-2xl shadow-[0_4px_40px_rgba(0,0,0,0.08),0_1px_4px_rgba(0,0,0,0.04)] overflow-hidden animate-fade-up-2">
            <div class="h-1 w-full" style="background: linear-gradient(90deg, #660000, #8B0000, #c9a84c)"></div>
            <div class="p-6 sm:p-8">

                <form id="appointmentForm" action="{{ route('book.appointment.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- ════ STEP 1: DATE & TIME ════ -->
                    <div class="step-content hidden">
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#660000] mb-0.5">Select Date &amp; Time
                        </h2>
                        <div class="h-0.5 mb-7 rounded-sm"
                            style="background: linear-gradient(90deg, #8B0000, transparent)"></div>

                        <input type="text" id="appointment_date" name="appointment_date" readonly required>
                        <input type="hidden" id="appointment_time" name="appointment_time" required>

                        <div class="cal-time-layout grid gap-5 items-start" style="grid-template-columns: 1fr 280px;">

                            <!-- CALENDAR -->
                            <div class="border border-[#e8e2dd] rounded-2xl p-5 bg-white">
                                <div id="calendarSkeletonContainer"></div>
                                <div
                                    class="mt-4 pt-3 border-t border-[#f0ebe6] flex flex-wrap gap-x-4 gap-y-2 justify-center">
                                    <div class="flex items-center gap-1.5 text-xs text-[#5c5550] font-medium">
                                        <span class="w-2 h-2 rounded-full bg-red-500 flex-shrink-0"></span> Full Slot
                                    </div>
                                    <div class="flex items-center gap-1.5 text-xs text-[#5c5550] font-medium">
                                        <span class="w-2 h-2 rounded-full bg-blue-500 flex-shrink-0"></span> Holiday
                                    </div>
                                    <div class="flex items-center gap-1.5 text-xs text-[#5c5550] font-medium">
                                        <span class="w-2 h-2 rounded-full bg-gray-200 flex-shrink-0"></span>
                                        Unavailable
                                    </div>
                                    <div class="flex items-center gap-1.5 text-xs text-[#5c5550] font-medium">
                                        <span class="w-2 h-2 rounded-full bg-gray-500 flex-shrink-0"></span> Today not
                                        available
                                    </div>
                                </div>
                            </div>

                            <!-- TIME SLOTS -->
                            <div class="border border-[#e8e2dd] rounded-2xl p-5 bg-white flex flex-col">
                                <p
                                    class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                    <i class="fa-regular fa-clock text-xs"></i> Available Times
                                    <span class="flex-1 h-px bg-[#f9e8e8]"></span>
                                </p>

                                <div id="dateBanner"
                                    class="hidden rounded-xl px-3 py-2 text-sm font-semibold text-white mb-3 shadow-md"
                                    style="background: linear-gradient(135deg, #660000, #8B0000)"></div>

                                <div id="slotContainer" class="hidden">
                                    <p class="text-xs text-[#9e9690] mb-2 italic">Select your preferred time slot.</p>
                                    <div id="slotGrid" class="flex flex-col gap-2"></div>
                                    <div id="selectedSlotDisplay"
                                        class="hidden mt-3 rounded-lg px-3 py-2 text-sm font-semibold text-[#8B0000] bg-[#f9e8e8] border border-[#8B0000]/20">
                                        <i class="fa-solid fa-circle-check mr-1.5"></i>Selected: <span
                                            id="selectedSlotText" class="font-bold"></span>
                                    </div>
                                </div>

                                <div id="slotPlaceholder"
                                    class="flex flex-col items-center justify-center gap-3 py-8 text-center text-[#9e9690] flex-1">
                                    <div
                                        class="w-12 h-12 rounded-full bg-[#f9e8e8] flex items-center justify-center text-[#8B0000] text-lg">
                                        <i class="fa-regular fa-calendar"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-[#5c5550]">Choose a date</p>
                                        <p class="text-xs mt-1">Select an available day to see time slots.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- ════ STEP 2: SERVICE ════ -->
                    <div class="step-content hidden">
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#660000] mb-0.5">Select Service Type</h2>
                        <div class="h-0.5 mb-7 rounded-sm"
                            style="background: linear-gradient(90deg, #8B0000, transparent)"></div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">

                            @foreach ($serviceTypes as $service)
                                <label class="service-card-label block cursor-pointer">
                                    <input type="radio" name="service_type" value="{{ $service['name'] }}"
                                        class="hidden" {{ $loop->first ? 'required' : '' }}>
                                    <div
                                        class="service-card-inner flex items-center gap-4 px-5 py-4 rounded-2xl border-2 border-[#e8e2dd] bg-[#fafaf8]">
                                        <div
                                            class="svc-icon-wrap w-12 h-12 rounded-xl bg-[#f9e8e8] flex items-center justify-center flex-shrink-0">
                                            @if (!empty($service['img']))
                                                <img src="{{ asset('images/' . $service['img'] . '.png') }}"
                                                    class="w-6 h-6"
                                                    style="filter:brightness(0) saturate(100%) invert(8%) sepia(80%) saturate(3000%) hue-rotate(345deg)" />
                                            @else
                                                <i class="fa-solid fa-tooth text-[#8B0000] text-lg"></i>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="svc-title font-bold text-sm text-[#1a1410]">
                                                {{ $service['name'] }}</p>
                                            <p class="svc-desc text-xs text-[#9e9690] mt-0.5">{{ $service['desc'] }}
                                            </p>
                                        </div>
                                        <i
                                            class="svc-arrow fa-solid fa-chevron-right text-xs text-[#e8e2dd] flex-shrink-0"></i>
                                    </div>
                                </label>
                            @endforeach

                            <label class="service-card-label block cursor-pointer sm:col-span-2">
                                <input type="radio" name="service_type" value="Others" class="hidden">
                                <div
                                    class="service-card-inner flex items-center gap-4 px-5 py-4 rounded-2xl border-2 border-[#e8e2dd] bg-[#fafaf8]">
                                    <div
                                        class="svc-icon-wrap w-12 h-12 rounded-xl bg-[#f9e8e8] flex items-center justify-center flex-shrink-0">
                                        <img src="{{ asset('images/dental-others.png') }}" class="w-6 h-6"
                                            style="filter:brightness(0) saturate(100%) invert(8%) sepia(80%) saturate(3000%) hue-rotate(345deg)" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="svc-title font-bold text-sm text-[#1a1410]">Others</p>
                                        <p class="svc-desc text-xs text-[#9e9690] mt-0.5">Can't find your service? Let
                                            us know what you
                                            need.</p>
                                    </div>
                                    <i
                                        class="svc-arrow fa-solid fa-chevron-right text-xs text-[#e8e2dd] flex-shrink-0"></i>
                                </div>
                            </label>

                        </div>
                    </div>

                    <!-- ════ STEP 3: DENTAL HISTORY ════ -->
                    <div class="step-content hidden">
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#660000] mb-0.5">Dental History</h2>
                        <div class="h-0.5 mb-7 rounded-sm"
                            style="background: linear-gradient(90deg, #8B0000, transparent)"></div>
                        <p class="text-sm text-[#5c5550] mb-6">Share your past dental records, treatments, or concerns
                            for a better
                            assessment.</p>

                        <!-- Basic Info -->
                        <div class="bg-[#fafaf8] rounded-2xl border border-[#e8e2dd] p-5 mb-5">
                            <p
                                class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-4">
                                <i class="fa-regular fa-calendar-days text-xs"></i> Basic Info <span
                                    class="flex-1 h-px bg-[#f9e8e8]"></span>
                            </p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-[#5c5550] mb-1.5">Last Dental
                                        Visit</label>
                                    <input type="text" id="lastDentalVisit" name="last_dental_visit"
                                        class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                        placeholder="Select date" readonly required>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-[#5c5550] mb-1.5">Previous
                                        Dentist</label>
                                    <input type="text" name="previous_dentist" maxlength="50"
                                        class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                        placeholder="Dr. Name">
                                </div>
                            </div>
                        </div>

                        <!-- Dental Symptoms -->
                        <div class="bg-[#fafaf8] rounded-2xl border border-[#e8e2dd] p-5 mb-5">
                            <p
                                class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                <i class="fa-solid fa-tooth text-xs"></i> Dental Symptoms <span
                                    class="flex-1 h-px bg-[#f9e8e8]"></span>
                            </p>
                            <div
                                class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                <span>Question</span><span class="text-center">YES</span><span
                                    class="text-center">NO</span>
                            </div>
                            @php
                                $dentalQ1 = [
                                    ['name' => 'bleeding_gums', 'q' => 'Do your gums bleed while brushing/flossing?'],
                                    ['name' => 'sensitive_temp', 'q' => 'Are your teeth sensitive to hot or cold?'],
                                    ['name' => 'sensitive_taste', 'q' => 'Are your teeth sensitive to sweets or sour?'],
                                    ['name' => 'tooth_pain', 'q' => 'Do you feel any pain in your teeth?'],
                                    ['name' => 'sores', 'q' => 'Do you have any sores/lumps in or near your mouth?'],
                                    ['name' => 'injuries', 'q' => 'Have you had any head, neck, or jaw injuries?'],
                                ];
                            @endphp
                            @foreach ($dentalQ1 as $q)
                                <div
                                    class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 {{ !$loop->last ? 'border-b border-[#f0ebe6]' : '' }} text-sm text-[#1a1410]">
                                    <span class="leading-snug">{{ $q['q'] }}</span>
                                    <input type="radio" name="{{ $q['name'] }}" value="YES"
                                        class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                        {{ $loop->first ? 'required' : '' }}>
                                    <input type="radio" name="{{ $q['name'] }}" value="NO"
                                        class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                </div>
                            @endforeach
                        </div>

                        <!-- Jaw & Bite -->
                        <div class="bg-[#fafaf8] rounded-2xl border border-[#e8e2dd] p-5 mb-5">
                            <p
                                class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                <i class="fa-solid fa-circle-dot text-xs"></i> Jaw &amp; Bite Symptoms <span
                                    class="flex-1 h-px bg-[#f9e8e8]"></span>
                            </p>
                            <div
                                class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                <span>Question</span><span class="text-center">YES</span><span
                                    class="text-center">NO</span>
                            </div>
                            @php
                                $dentalQ2 = [
                                    ['name' => 'clicking', 'q' => 'Clicking'],
                                    ['name' => 'joint_pain', 'q' => 'Pain (joint, side of the face)'],
                                    ['name' => 'difficulty_moving', 'q' => 'Difficulty in opening/closing'],
                                    ['name' => 'difficulty_chewing', 'q' => 'Difficulty in chewing'],
                                    ['name' => 'jaw_headaches', 'q' => 'Frequent headaches'],
                                    ['name' => 'clench_grind', 'q' => 'Do you clench or grind your teeth?'],
                                    ['name' => 'biting', 'q' => 'Frequent lips/cheek biting'],
                                    ['name' => 'teeth_loosening', 'q' => 'Have you noticed loosening of your teeth?'],
                                    ['name' => 'food_teeth', 'q' => 'Does food get caught between your teeth?'],
                                    [
                                        'name' => 'med_reaction',
                                        'q' => 'Have you ever had a reaction to any medicine or dental anesthetic?',
                                    ],
                                ];
                            @endphp
                            @foreach ($dentalQ2 as $q)
                                <div
                                    class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 {{ !$loop->last ? 'border-b border-[#f0ebe6]' : '' }} text-sm text-[#1a1410]">
                                    <span class="leading-snug">{{ $q['q'] }}</span>
                                    <input type="radio" name="{{ $q['name'] }}" value="YES"
                                        class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                        required>
                                    <input type="radio" name="{{ $q['name'] }}" value="NO"
                                        class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                </div>
                            @endforeach
                            <p class="text-xs text-[#8B0000] mt-2 italic pl-4">
                                <i class="fa-solid fa-circle-info mr-1"></i> If <b>YES</b>, please provide details
                                during your
                                consultation.
                            </p>
                        </div>

                        <!-- Dental Procedures -->
                        <div class="bg-[#fafaf8] rounded-2xl border border-[#e8e2dd] p-5 mb-5">
                            <p
                                class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                <i class="fa-solid fa-notes-medical text-xs"></i> Dental Procedures <span
                                    class="flex-1 h-px bg-[#f9e8e8]"></span>
                            </p>
                            <div
                                class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                <span>Question</span><span class="text-center">YES</span><span
                                    class="text-center">NO</span>
                            </div>

                            <div
                                class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                <span>Have you had any periodontal (gum) treatment?</span>
                                <input type="radio" name="periodontal" value="YES"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                    required>
                                <input type="radio" name="periodontal" value="NO"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                            </div>

                            <div
                                class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                <span>Have you had a difficult tooth extraction?</span>
                                <input type="radio" name="difficult_extraction" value="YES"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                    required>
                                <input type="radio" name="difficult_extraction" value="NO"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                            </div>
                            <div class="ml-6 mt-2 mb-2 hidden" id="extraction_date_box">
                                <label class="text-xs text-[#8B0000] italic block mb-1">Date of extraction:</label>
                                <input type="text" id="extractionDate" name="extraction_date"
                                    class="form-input border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none max-w-[220px] w-full"
                                    placeholder="Select date" readonly>
                            </div>

                            <div
                                class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                <span>Have you had prolonged bleeding following tooth extractions?</span>
                                <input type="radio" name="prolonged_bleeding" value="YES"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                    required>
                                <input type="radio" name="prolonged_bleeding" value="NO"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                            </div>

                            <div
                                class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                <span>Do you wear complete or partial dentures?</span>
                                <input type="radio" name="dentures" value="YES"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                    required>
                                <input type="radio" name="dentures" value="NO"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                            </div>
                            <div class="ml-6 mt-2 mb-2 hidden" id="dentures_date_box">
                                <label class="text-xs text-[#8B0000] italic block mb-1">Date of placement:</label>
                                <input type="text" id="denturesDate" name="dentures_date"
                                    class="form-input border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none max-w-[220px] w-full"
                                    placeholder="Select date" readonly>
                            </div>

                            <div class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 text-sm">
                                <span>Have you had orthodontic treatment?</span>
                                <input type="radio" name="ortho_treatment" value="YES"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                    required>
                                <input type="radio" name="ortho_treatment" value="NO"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                            </div>
                            <div class="ml-6 mt-2 mb-2 hidden" id="ortho_date_box">
                                <label class="text-xs text-[#8B0000] italic block mb-1">Date of completion:</label>
                                <input type="text" id="orthoDate" name="ortho_date"
                                    class="form-input border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none max-w-[220px] w-full"
                                    placeholder="Select date" readonly>
                            </div>
                        </div>

                        <!-- Additional Concerns -->
                        <div class="bg-[#fafaf8] rounded-2xl border border-[#e8e2dd] p-5 mb-5">
                            <p
                                class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                <i class="fa-regular fa-comment-dots text-xs"></i> Additional Concerns <span
                                    class="flex-1 h-px bg-[#f9e8e8]"></span>
                            </p>
                            <textarea name="additional_concerns" id="additional_concerns" rows="4"
                                class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none resize-none"
                                placeholder="Write any additional concerns here..."></textarea>
                        </div>
                    </div>

                    <!-- ════ STEP 4: MEDICAL HISTORY ════ -->
                    <div class="step-content hidden">
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#660000] mb-0.5">Medical History</h2>
                        <div class="h-0.5 mb-7 rounded-sm"
                            style="background: linear-gradient(90deg, #8B0000, transparent)"></div>
                        <p class="text-sm text-[#5c5550] mb-6">Provide important medical information to help the
                            dentist ensure safe
                            and proper care.</p>

                        @php
                            function qSectionOpen(string $icon, string $label): string
                            {
                                return '<div class="bg-[#fafaf8] rounded-2xl border border-[#e8e2dd] p-5 mb-5">
              <p class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                <i class="' .
                                    $icon .
                                    ' text-xs"></i> ' .
                                    $label .
                                    ' <span class="flex-1 h-px bg-[#f9e8e8]"></span>
              </p>
              <div
                class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                <span>Question</span><span class="text-center">YES</span><span class="text-center">NO</span>
              </div>';
                            }
                        @endphp

                        <!-- General Health -->
                        <div class="bg-[#fafaf8] rounded-2xl border border-[#e8e2dd] p-5 mb-5">
                            <p
                                class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                <i class="fa-solid fa-heart-pulse text-xs"></i> General Health <span
                                    class="flex-1 h-px bg-[#f9e8e8]"></span>
                            </p>
                            <div
                                class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                <span>Question</span><span class="text-center">YES</span><span
                                    class="text-center">NO</span>
                            </div>

                            <div
                                class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                <span>Are you in good health?</span>
                                <input type="radio" name="good_health" value="YES"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                    required>
                                <input type="radio" name="good_health" value="NO"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                            </div>
                            <div class="ml-6 mt-1 mb-2 hidden" id="good_health_box">
                                <label class="text-xs text-[#8B0000] italic">If NO, please provide details:</label>
                                <input type="text" name="good_health_details"
                                    class="form-input mt-1 w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                    placeholder="Input here">
                            </div>

                            <div
                                class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                <span>When was your last medical examination?</span>
                                <input type="radio" name="had_medical_exam" value="YES"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                    required>
                                <input type="radio" name="had_medical_exam" value="NO"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                            </div>
                            <div class="ml-6 mt-1 mb-2 hidden" id="medical_exam_box">
                                <label class="text-xs text-[#8B0000] italic block mb-1">If YES, when was your last
                                    medical
                                    examination?</label>
                                <input type="text" id="medicalExamDate" name="medical_exam_date"
                                    class="form-input border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none max-w-[220px] w-full"
                                    placeholder="Select date" readonly>
                            </div>

                            <div
                                class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                <span>Are you currently receiving treatment for any illness?</span>
                                <input type="radio" name="under_treatment" value="YES"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                    required>
                                <input type="radio" name="under_treatment" value="NO"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                            </div>
                            <div class="ml-6 mt-1 mb-2 hidden" id="treatment_box">
                                <label class="text-xs text-[#8B0000] italic">If YES, please specify:</label>
                                <input type="text" name="treatment_details"
                                    class="form-input mt-1 w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                    placeholder="Input here">
                            </div>

                            <div class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 text-sm">
                                <span>Have you ever been hospitalized?</span>
                                <input type="radio" name="hospitalized" value="YES"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                    required>
                                <input type="radio" name="hospitalized" value="NO"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                            </div>
                            <div class="ml-6 mt-1 mb-2 hidden" id="hospital_box">
                                <label class="text-xs text-[#8B0000] italic">If YES, please provide details:</label>
                                <input type="text" name="hospital_details"
                                    class="form-input mt-1 w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                    placeholder="Input here">
                            </div>
                        </div>

                        <!-- Allergies -->
                        <div class="bg-[#fafaf8] rounded-2xl border border-[#e8e2dd] p-5 mb-5">
                            <p
                                class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                <i class="fa-solid fa-triangle-exclamation text-xs"></i> Allergies <span
                                    class="flex-1 h-px bg-[#f9e8e8]"></span>
                            </p>
                            <div
                                class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                <span>Are you allergic to any of the following?</span><span
                                    class="text-center">YES</span><span class="text-center">NO</span>
                            </div>
                            <div
                                class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                <span>Medicines</span>
                                <input type="radio" name="allergy_medicine" value="YES"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                    required>
                                <input type="radio" name="allergy_medicine" value="NO"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                            </div>
                            <div class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 text-sm">
                                <span>Food</span>
                                <input type="radio" name="allergy_food" value="YES"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                    required>
                                <input type="radio" name="allergy_food" value="NO"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                            </div>
                            <div class="mt-3">
                                <label class="text-xs text-[#8B0000] italic block mb-1">Others (please
                                    specify):</label>
                                <input type="text" name="allergy_others"
                                    class="form-input border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none max-w-[280px] w-full"
                                    placeholder="Input here">
                            </div>
                        </div>

                        <!-- Medications -->
                        <div class="bg-[#fafaf8] rounded-2xl border border-[#e8e2dd] p-5 mb-5">
                            <p
                                class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                <i class="fa-solid fa-pills text-xs"></i> Medications <span
                                    class="flex-1 h-px bg-[#f9e8e8]"></span>
                            </p>
                            <div
                                class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                <span>Question</span><span class="text-center">YES</span><span
                                    class="text-center">NO</span>
                            </div>
                            <div class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 text-sm">
                                <span>Are you taking any prescription or non-prescription medication?</span>
                                <input type="radio" name="medication" value="YES"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                    required>
                                <input type="radio" name="medication" value="NO"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                            </div>
                            <div class="ml-6 mt-1 mb-2 hidden" id="medication_box">
                                <label class="text-xs text-[#8B0000] italic">If YES, please specify:</label>
                                <input type="text" name="medication_details"
                                    class="form-input mt-1 w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                    placeholder="Input here">
                            </div>
                        </div>

                        <!-- For Women -->
                        <div class="bg-[#fafaf8] rounded-2xl border border-[#e8e2dd] p-5 mb-5">
                            <p
                                class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                <i class="fa-solid fa-venus text-xs"></i> For Women Only <span
                                    class="flex-1 h-px bg-[#f9e8e8]"></span>
                            </p>
                            <div
                                class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                <span>Question</span><span class="text-center">YES</span><span
                                    class="text-center">NO</span>
                            </div>
                            @foreach ([
        ['name' => 'pregnant', 'q' => 'Are you pregnant?'],
        [
            'name' => 'nursing',
            'q' => 'Are you
                nursing?',
        ],
        ['name' => 'birth_control', 'q' => 'Are you taking birth control pills?'],
    ] as $i => $q)
                                <div
                                    class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 {{ $i < 2 ? 'border-b border-[#f0ebe6]' : '' }} text-sm">
                                    <span>{{ $q['q'] }}</span>
                                    <input type="radio" name="{{ $q['name'] }}" value="YES"
                                        class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                        required>
                                    <input type="radio" name="{{ $q['name'] }}" value="NO"
                                        class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                </div>
                            @endforeach
                        </div>

                        <!-- Medical Conditions -->
                        <div class="bg-[#fafaf8] rounded-2xl border border-[#e8e2dd] p-5 mb-5">
                            <p
                                class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                <i class="fa-solid fa-stethoscope text-xs"></i> Medical Conditions <span
                                    class="flex-1 h-px bg-[#f9e8e8]"></span>
                            </p>
                            <p class="text-xs text-[#5c5550] mb-3">Please indicate below if you presently have or have
                                ever had any
                                of
                                the following:</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2.5 gap-x-6">
                                @foreach ($diseases as $d)
                                    <label class="flex items-center gap-2.5 cursor-pointer">
                                        <input type="checkbox" name="diseases[]" value="{{ $d->code }}"
                                            class="w-4 h-4 rounded border-2 border-[#e8e2dd] cursor-pointer accent-[#8B0000] flex-shrink-0">
                                        <span class="text-[0.82rem] text-[#1a1410]">{{ $d->label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Tobacco -->
                        <div class="bg-[#fafaf8] rounded-2xl border border-[#e8e2dd] p-5 mb-5">
                            <p
                                class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                <i class="fa-solid fa-smoking text-xs"></i> Tobacco Use <span
                                    class="flex-1 h-px bg-[#f9e8e8]"></span>
                            </p>
                            <div
                                class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                <span>Question</span><span class="text-center">YES</span><span
                                    class="text-center">NO</span>
                            </div>
                            <div class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 text-sm">
                                <span>Do you use tobacco products or any derivatives?</span>
                                <input type="radio" name="tobacco_use" value="YES"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                    required>
                                <input type="radio" name="tobacco_use" value="NO"
                                    class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                            </div>
                            <div id="tobacco_details" class="ml-6 mt-2 space-y-2 hidden text-sm">
                                <div class="flex items-center gap-3 flex-wrap">
                                    <span class="text-xs text-[#8B0000] italic w-28">How much per day:</span>
                                    <input type="text" name="tobacco_per_day" placeholder="Input here"
                                        class="form-input border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none max-w-[160px] w-full">
                                </div>
                                <div class="flex items-center gap-3 flex-wrap">
                                    <span class="text-xs text-[#8B0000] italic w-28">Per week:</span>
                                    <input type="text" name="tobacco_per_week" placeholder="Input here"
                                        class="form-input border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none max-w-[160px] w-full">
                                </div>
                            </div>
                        </div>

                        <!-- Suffers From -->
                        <div class="bg-[#fafaf8] rounded-2xl border border-[#e8e2dd] p-5 mb-5">
                            <p
                                class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                <i class="fa-solid fa-head-side-mask text-xs"></i> Do You Suffer From <span
                                    class="flex-1 h-px bg-[#f9e8e8]"></span>
                            </p>
                            <div
                                class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                <span>Condition</span><span class="text-center">YES</span><span
                                    class="text-center">NO</span>
                            </div>
                            @foreach ([['name' => 'headaches', 'q' => 'Headaches'], ['name' => 'earaches', 'q' => 'Earaches'], ['name' => 'neck_aches', 'q' => 'Neck aches']] as $i => $q)
                                <div
                                    class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 {{ $i < 2 ? 'border-b border-[#f0ebe6]' : '' }} text-sm">
                                    <span>{{ $q['q'] }}</span>
                                    <input type="radio" name="{{ $q['name'] }}" value="YES"
                                        class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                        required>
                                    <input type="radio" name="{{ $q['name'] }}" value="NO"
                                        class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                </div>
                            @endforeach
                        </div>

                        <!-- Emergency Contact -->
                        <div class="bg-[#fafaf8] rounded-2xl border border-[#e8e2dd] p-5 mb-5">
                            <p
                                class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-4">
                                <i class="fa-solid fa-phone-volume text-xs"></i> Emergency Contact <span
                                    class="flex-1 h-px bg-[#f9e8e8]"></span>
                            </p>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-[#5c5550] mb-1.5">Person to contact
                                        in case of
                                        emergency</label>
                                    <input type="text" name="emergency_person" maxlength="50"
                                        class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                        placeholder="Full name" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-[#5c5550] mb-1.5">Contact
                                        Number</label>
                                    <input type="tel" id="emergency_number" name="emergency_number"
                                        maxlength="11"
                                        class="form-input border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none max-w-[240px] w-full"
                                        placeholder="09XXXXXXXXX" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-[#5c5550] mb-1.5">Relation to
                                        Patient</label>
                                    <div class="relative max-w-[280px]">
                                        <select id="emergency_relation" name="emergency_relation"
                                            class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none appearance-none pr-8"
                                            required>
                                            <option value="" disabled selected>Select relation</option>
                                            <option value="Mother">Mother</option>
                                            <option value="Father">Father</option>
                                            <option value="Guardian">Guardian</option>
                                            <option value="Spouse">Spouse</option>
                                            <option value="Others">Others</option>
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center">
                                            <i class="fa-solid fa-chevron-down text-[10px] text-[#5c5550]"></i>
                                        </div>
                                    </div>
                                    <input type="text" id="relation_other" name="relation_other" maxlength="30"
                                        class="form-input mt-2 hidden border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none max-w-[280px] w-full"
                                        placeholder="Please specify relation">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-[#5c5550] mb-1.5">Patient's
                                        Signature</label>
                                    <div
                                        class="file-upload-zone max-w-[320px] border-2 border-dashed border-[#e8e2dd] rounded-xl p-5 text-center cursor-pointer">
                                        <i class="fa-regular fa-image text-2xl text-[#9e9690] mb-2 block"></i>
                                        <p class="text-xs text-[#5c5550] mb-1">Select your file or drag and drop</p>
                                        <p class="text-xs text-[#9e9690] mb-3">JPG, PNG, up to 25 MB</p>
                                        <label
                                            class="btn-primary-custom inline-flex items-center gap-1.5 bg-[#8B0000] text-white rounded-xl px-4 py-1.5 text-xs font-bold cursor-pointer">
                                            <i class="fa-solid fa-upload"></i> Browse
                                            <input type="file" name="patient_signature" id="patient_signature"
                                                class="hidden" accept=".jpg,.jpeg,.png" required>
                                        </label>
                                        <p id="signature_filename"
                                            class="text-xs text-[#5c5550] mt-2 hidden truncate"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ════ STEP 5: SUMMARY & CONFIRMATION ════ -->
                    <div class="step-content hidden" id="step5">

                        <!-- SUMMARY -->
                        <div id="summarySection">
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#660000] mb-0.5">Review Your
                                Information</h2>
                            <div class="h-0.5 mb-7 rounded-sm"
                                style="background: linear-gradient(90deg, #8B0000, transparent)">
                            </div>
                            <p class="text-sm text-[#5c5550] mb-6">Please review all the information you've provided
                                before
                                proceeding
                                to confirmation.</p>
                            <div id="summaryBox" class="space-y-4"></div>
                            <div class="flex justify-center gap-3 mt-8 nav-btns-row">
                                <button type="button" id="summaryBackBtn"
                                    class="btn-secondary-custom inline-flex items-center gap-2 border border-[#e8e2dd] rounded-xl px-6 py-2.5 text-sm font-semibold text-[#5c5550] bg-transparent">
                                    <i class="fa-solid fa-chevron-left text-xs"></i> Back
                                </button>
                                <button type="button" id="goToConfirmationBtn"
                                    class="btn-primary-custom inline-flex items-center gap-2 bg-[#8B0000] text-white rounded-xl px-6 py-2.5 text-sm font-bold">
                                    Proceed to Confirm <i class="fa-solid fa-chevron-right text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <!-- CONFIRMATION -->
                        <div id="confirmationSection" class="hidden">
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#660000] mb-0.5">Final Confirmation
                            </h2>
                            <div class="h-0.5 mb-7 rounded-sm"
                                style="background: linear-gradient(90deg, #8B0000, transparent)">
                            </div>

                            <div class="bg-[#fff5f5] border border-[rgba(139,0,0,0.15)] rounded-2xl p-5 mb-2">
                                <div class="flex items-start gap-2 mb-4">
                                    <i class="fa-solid fa-shield-halved text-[#8B0000] mt-0.5"></i>
                                    <p class="text-sm text-[#5c5550]">By submitting, you confirm that all the
                                        information provided is
                                        accurate and complete.</p>
                                </div>
                                <label
                                    class="confirm-checkbox-wrap flex items-start gap-3 p-4 rounded-xl border border-[#e8e2dd] bg-[#fafaf8] cursor-pointer">
                                    <input id="finalConfirm" type="checkbox"
                                        class="w-5 h-5 rounded border-2 border-[#e8e2dd] bg-white cursor-pointer flex-shrink-0 mt-0.5 accent-[#8B0000]"
                                        required>
                                    <span class="text-sm text-[#1a1410] leading-relaxed">
                                        I have reviewed my dental and medical information and I accept the
                                        <a href="/privacy-policy"
                                            class="text-[#8B0000] hover:underline font-semibold">Privacy Policy</a>
                                        and <a href="/terms-of-service"
                                            class="text-[#8B0000] hover:underline font-semibold">Terms of
                                            Service</a>.
                                    </span>
                                </label>
                            </div>

                            <div class="flex justify-center gap-3 mt-8 nav-btns-row">
                                <button type="button" id="confirmBackBtn"
                                    class="btn-secondary-custom inline-flex items-center gap-2 border border-[#e8e2dd] rounded-xl px-6 py-2.5 text-sm font-semibold text-[#5c5550] bg-transparent">
                                    <i class="fa-solid fa-chevron-left text-xs"></i> Back
                                </button>
                                <button type="button" id="finalSubmitBtn"
                                    class="btn-primary-custom inline-flex items-center gap-2 bg-[#8B0000] text-white rounded-xl px-6 py-2.5 text-sm font-bold">
                                    <i class="fa-solid fa-check"></i> Submit Appointment
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- ════ NAV BUTTONS ════ -->
                    <div id="navBtns" class="flex justify-center mt-8 gap-3 nav-btns-row">
                        <button type="button" id="prevBtn" style="display:none;"
                            class="btn-secondary-custom inline-flex items-center gap-2 border border-[#e8e2dd] rounded-xl px-6 py-2.5 text-sm font-semibold text-[#5c5550] bg-transparent">
                            <i class="fa-solid fa-chevron-left text-xs"></i> Previous
                        </button>
                        <button type="button" id="nextBtn"
                            class="btn-primary-custom inline-flex items-center gap-2 bg-[#8B0000] text-white rounded-xl px-8 py-2.5 text-sm font-bold">
                            Next <i class="fa-solid fa-chevron-right text-xs"></i>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- ════ MINI TAB ════ -->
    <div id="miniTab"
        class="mini-tab fixed left-1/2 -translate-x-1/2 bg-[#1a1410] text-white px-5 py-2.5 rounded-full text-sm font-semibold z-[200] shadow-xl flex items-center gap-2 whitespace-nowrap opacity-0 pointer-events-none"
        style="transition: opacity 0.25s;">
        <i class="fa-solid fa-circle-exclamation text-red-400"></i>
        <span id="miniTabText">Please complete all required fields.</span>
    </div>

    <!-- ════ OTHERS MODAL ════ -->
    <dialog id="othersModal"
        class="m-auto border-0 p-0 rounded-2xl overflow-hidden shadow-[0_25px_60px_rgba(0,0,0,0.25)] max-w-[480px] w-[calc(100vw-2rem)]">
        <div class="bg-[#8B0000] px-8 py-6">
            <h3 class="text-xl font-bold text-white mb-1">Other Service</h3>
            <p class="text-sm text-white/75">Please describe the service you need.</p>
        </div>
        <div class="bg-white px-8 py-6">
            <div class="w-full mb-5">
                <x-voice-input id="other_services" name="service_others_text"
                    placeholder="e.g. Teeth whitening, fluoride treatment..." maxlength="100"
                    class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2.5 text-sm bg-white outline-none" />
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" id="othersCancelBtn"
                    class="btn-secondary-custom inline-flex items-center gap-2 border border-[#e8e2dd] rounded-xl px-5 py-2 text-sm font-semibold text-[#5c5550] bg-transparent">Cancel</button>
                <button type="button" id="othersConfirmBtn"
                    class="btn-primary-custom inline-flex items-center gap-2 bg-[#8B0000] text-white rounded-xl px-5 py-2 text-sm font-bold">Confirm</button>
            </div>
        </div>
    </dialog>

    <!-- ════ CONFIRM MODAL ════ -->
    <dialog id="confirmModal"
        class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 m-0 border-0 p-0 rounded-2xl overflow-hidden shadow-[0_25px_60px_rgba(0,0,0,0.25)] max-w-[480px] w-[calc(100vw-2rem)]">
        <div class="bg-[#8B0000] px-8 py-10 text-center">
            <div class="w-16 h-16 rounded-full bg-white/15 flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-calendar-check text-white text-2xl"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-white mb-4">Appointment Confirmed!</h2>
            <p id="confirmMessage" class="text-white/85 text-sm leading-7 mb-6"></p>
            <button type="button" id="okBtn"
                class="bg-white text-[#8B0000] border-0 px-8 py-2.5 rounded-xl font-bold text-sm cursor-pointer">Back
                to
                Home</button>
        </div>
    </dialog>

    <!-- ════ LEAVE MODAL ════ -->
    <dialog id="leaveModal"
        class="m-auto border-0 p-0 rounded-2xl overflow-hidden shadow-[0_25px_60px_rgba(0,0,0,0.25)] max-w-[440px] w-[calc(100vw-2rem)]">
        <div class="bg-[#8B0000] px-6 py-5">
            <h3 class="text-lg font-bold text-white mb-0.5">Unsaved Changes</h3>
            <p class="text-sm text-white/80">Save your progress, discard changes, or stay on the page.</p>
        </div>
        <div class="bg-white px-6 py-5 flex justify-end gap-3 flex-wrap">
            <button type="button" id="cancelLeaveBtn"
                class="btn-secondary-custom inline-flex items-center gap-2 border border-[#e8e2dd] rounded-xl px-4 py-2 text-sm font-semibold text-[#5c5550] bg-transparent">
                Cancel
            </button>
            <button type="button" id="discardDraftBtn"
                class="btn-secondary-custom inline-flex items-center gap-2 border border-red-200 text-red-600 bg-red-50 hover:bg-red-100 rounded-xl px-4 py-2 text-sm font-semibold transition-colors">
                Discard
            </button>
            <button type="button" id="saveDraftBtn"
                class="btn-primary-custom inline-flex items-center gap-2 bg-[#8B0000] text-white rounded-xl px-5 py-2 text-sm font-bold">
                Save Draft
            </button>
        </div>
    </dialog>

    @include('components.appointment-calendar-script', [
        'mode' => 'booking',
        'renderStyle' => 'patient',
        'calendarContainerId' => 'calendarSkeletonContainer',
        'dateInputId' => 'appointment_date',
        'timeInputId' => 'appointment_time',
        'dateBannerId' => 'dateBanner',
        'slotPlaceholderId' => 'slotPlaceholder',
        'slotContainerId' => 'slotContainer',
        'slotGridId' => 'slotGrid',
        'selectedSlotDisplayId' => 'selectedSlotDisplay',
        'selectedSlotTextId' => 'selectedSlotText',
        'slotEndpoint' => route('book.appointment.slots'),
        'scheduleRules' => $schedules ?? [],
        'blockedDates' => $blockedDates ?? [],
        'appointmentCountsPerDay' => $appointmentCountsPerDay ?? [],
        'philippineHolidays' => $philippineHolidays ?? [],
        'useDynamicScheduleRules' => true,
        'disallowToday' => true,
        'allowToggleOffDate' => true,
    ])
    
    @include('partials.voice-logic')
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script>
        const diseaseLabelByCode = @json($diseases->pluck('label', 'code'));


        /* DRAFT */
        const DRAFT_KEY = "appointmentDraft:v1";

        function saveDraftData() {
            const form = document.getElementById("appointmentForm");
            if (!form) return;
            const data = new FormData(form),
                obj = {};
            for (const [key, value] of data.entries()) {
                if (key === "patient_signature") continue;
                if (obj[key] === undefined) obj[key] = value;
                else if (Array.isArray(obj[key])) obj[key].push(value);
                else obj[key] = [obj[key], value];
            }
            obj.__meta = {
                step: typeof step !== "undefined" ? step : 0,
                savedAt: new Date().toISOString()
            };
            localStorage.setItem(DRAFT_KEY, JSON.stringify(obj));
        }

        function clearDraft() {
            localStorage.removeItem(DRAFT_KEY);
        }

        function restoreDraft() {
            const raw = localStorage.getItem(DRAFT_KEY);
            if (!raw) return;
            let obj;
            try {
                obj = JSON.parse(raw);
            } catch {
                return;
            }
            const form = document.getElementById("appointmentForm");
            if (!form) return;
            Object.keys(obj).forEach((name) => {
                if (name === "__meta") return;
                const value = obj[name];
                if (Array.isArray(value)) {
                    form.querySelectorAll(`[name="${CSS.escape(name)}"]`).forEach((el) => {
                        if (el.type === "checkbox") el.checked = value.includes(el.value);
                    });
                    return;
                }
                form.querySelectorAll(`[name="${CSS.escape(name)}"]`).forEach((el) => {
                    if (el.type === "radio") el.checked = (el.value === value);
                    else if (el.type === "checkbox") el.checked = (value === true || value === "on" ||
                        value === el.value);
                    else el.value = value;
                });
            });
            if (document.getElementById("emergency_relation")?.value === "Others") {
                const other = document.getElementById("relation_other");
                if (other) {
                    other.classList.remove("hidden");
                    other.setAttribute("required", "true");
                }
            }
            const restoredDate = document.getElementById("appointment_date")?.value;
            const restoredTime = document.getElementById("appointment_time")?.value;
            if (restoredDate) {
                selectedDate = restoredDate;
                selectDate(restoredDate);
                if (restoredTime) {
                    selectedTime = restoredTime;
                    document.querySelectorAll(".slot-chip").forEach(c => {
                        if (c.dataset.time === restoredTime) c.classList.add("selected");
                    });
                    const txt = document.getElementById("selectedSlotText");
                    const disp = document.getElementById("selectedSlotDisplay");
                    if (txt) txt.textContent = restoredTime;
                    if (disp) disp.classList.remove("hidden");
                }
            }
            formIsDirty = true;
        }

        /* MINI TAB */
        const miniTab = document.getElementById("miniTab");
        const miniTabText = document.getElementById("miniTabText");

        function showMiniTab(msg) {
            if (!miniTab) return;
            miniTabText.textContent = msg || "Please complete all required fields.";
            miniTab.style.opacity = "1";
            miniTab.style.pointerEvents = "auto";
            clearTimeout(window.__mtTimer);
            window.__mtTimer = setTimeout(() => {
                miniTab.style.opacity = "0";
                miniTab.style.pointerEvents = "none";
            }, 3000);
        }

        function showInputError(input) {
            if (!input) return;
            input.classList.add("border-red-500");
            input.style.animation = "shake 0.3s ease";
            setTimeout(() => input.style.animation = "", 400);
        }

        /* STEPPER */
        let step = 0,
            completedSteps = [];
        const steps = document.querySelectorAll(".step-content");
        const navBtns = document.getElementById("navBtns");
        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");
        const summarySection = document.getElementById("summarySection");
        const confirmationSection = document.getElementById("confirmationSection");

        function updateStepperUI(i) {
            for (let idx = 0; idx < 5; idx++) {
                const circle = document.getElementById(`sc${idx + 1}`);
                const label = document.getElementById(`sl${idx + 1}`);
                const conn = document.getElementById(`conn${idx + 1}`);
                if (!circle || !label) continue;
                circle.className =
                    "step-circle w-10 h-10 rounded-full border-2 flex items-center justify-center text-sm font-bold";
                label.className =
                    "step-label text-[0.65rem] font-semibold uppercase tracking-wide text-center block w-full mt-4";
                if (idx < i && completedSteps.includes(idx)) {
                    circle.className += " border-green-700 bg-green-700 text-white";
                    label.className += " text-green-700";
                    circle.innerHTML = `<i class="fa-solid fa-check text-xs"></i>`;
                } else if (idx === i) {
                    circle.className +=
                        " border-blue-600 bg-blue-600 text-white shadow-[0_0_0_6px_rgba(37,99,235,0.12)] scale-110";
                    label.className += " text-blue-600";
                    circle.innerHTML = String(idx + 1);
                } else {
                    circle.className += " border-[#e8e2dd] bg-white text-[#9e9690]";
                    label.className += " text-[#9e9690]";
                    circle.innerHTML = String(idx + 1);
                }
                if (conn) {
                    conn.className = "h-0.5 flex-shrink-0 self-start step-connector ";
                    conn.style.width = window.innerWidth < 640 ? "8px" : "40px";
                    conn.style.marginTop = "20px";
                    conn.className += (idx < i && completedSteps.includes(idx)) ? "bg-green-700" : (idx === i ?
                        "bg-blue-600" : "bg-[#e8e2dd]");
                }
            }
            const fill = document.getElementById("headerProgressFill");
            if (fill) fill.style.width = (((i + 1) / 5) * 100) + "%";
            const counter = document.getElementById("stepCounterText");
            if (counter) counter.textContent = i + 1;
        }

        function showStep(i) {
            steps.forEach((s, idx) => {
                s.classList.remove("show");
                s.classList.add("hidden");
                if (idx === i) {
                    s.classList.remove("hidden");
                    setTimeout(() => s.classList.add("show"), 40);
                }
            });
            const isLast = i === steps.length - 1;
            navBtns.style.display = isLast ? "none" : "flex";
            prevBtn.style.display = i === 0 ? "none" : "inline-flex";
            nextBtn.style.display = isLast ? "none" : "inline-flex";
            if (isLast) {
                buildSummary();
                resetStep5View();
            }
            updateStepperUI(i);
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
            step = i;
        }

        function resetStep5View() {
            summarySection?.classList.remove("hidden");
            confirmationSection?.classList.add("hidden");
        }

        /* VALIDATION */
        function isStepComplete(s) {
            const stepEl = steps[s];
            if (!stepEl) return true;
            if (s === 0) {
                if (!document.getElementById("appointment_date")?.value) {
                    showMiniTab("Please select a date first.");
                    return false;
                }
                if (!document.getElementById("appointment_time")?.value) {
                    showMiniTab("Please select a time slot.");
                    return false;
                }
            }
            const fields = stepEl.querySelectorAll(
                "input[required]:not([type='radio']):not([type='checkbox']), select[required], textarea[required]");
            for (const input of fields) {
                if (!input.value || !input.value.trim()) return false;
            }
            const radios = stepEl.querySelectorAll("input[type='radio']");
            if (radios.length) {
                const groups = [...new Set([...radios].map(r => r.name))];
                for (const name of groups) {
                    if (!stepEl.querySelector(`input[name="${name}"]:checked`)) return false;
                }
            }
            const phone = stepEl.querySelector("#emergency_number");
            if (phone) {
                const v = phone.value.trim();
                if (!/^\d{1,11}$/.test(v)) {
                    showMiniTab("Emergency Contact must be 1–11 digits only!");
                    phone.focus();
                    return false;
                }
            }
            return true;
        }

        nextBtn?.addEventListener("click", () => {
            if (!isStepComplete(step)) {
                showMiniTab("Please complete all required fields before proceeding.");
                return;
            }
            if (!completedSteps.includes(step)) completedSteps.push(step);
            showStep(Math.min(step + 1, steps.length - 1));
        });
        prevBtn?.addEventListener("click", () => showStep(Math.max(step - 1, 0)));
        document.getElementById("summaryBackBtn")?.addEventListener("click", () => showStep(3));
        document.getElementById("goToConfirmationBtn")?.addEventListener("click", () => {
            summarySection?.classList.add("hidden");
            confirmationSection?.classList.remove("hidden");
            confirmationSection?.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });
        });
        document.getElementById("confirmBackBtn")?.addEventListener("click", () => {
            confirmationSection?.classList.add("hidden");
            summarySection?.classList.remove("hidden");
            summarySection?.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });
        });

        /* SUMMARY BUILDER */
        function buildSummary() {
            const form = document.getElementById("appointmentForm");
            if (!form) return;
            const data = new FormData(form);
            const get = n => data.get(n) || "N/A";
            const getAll = n => data.getAll(n);
            const relation = data.get("emergency_relation") || "";
            const otherRel = (data.get("relation_other") || "").trim();
            const emergencyRelation = relation === "Others" ? (otherRel || "Others") : (relation || "N/A");
            const sigFile = data.get("patient_signature");
            let sigHTML = `<span class="text-[#9e9690] italic">Not uploaded</span>`;
            if (sigFile && sigFile.size > 0) {
                const url = URL.createObjectURL(sigFile);
                sigHTML =
                    `<img src="${url}" alt="Signature" class="max-w-[220px] max-h-[130px] rounded-lg border border-[#e8e2dd]">`;
            }
            const card = (title, icon, body) => `
        <div class="border border-[#e8e2dd] rounded-xl overflow-hidden bg-white">
          <div class="bg-[#f9e8e8] px-4 py-2.5 text-xs font-bold text-[#8B0000] uppercase tracking-widest border-b border-[#e8e2dd]">
            <i class="fa-solid ${icon} mr-2"></i>${title}
          </div>
          <div class="p-4 text-sm leading-7 text-[#1a1410]">${body}</div>
        </div>`;
            const row = (label, val) =>
                `<p><b class="text-[#5c5550] font-semibold">${label}:</b> ${val || '<span class="text-[#9e9690]">N/A</span>'}</p>`;
            const diseases = getAll("diseases[]");
            document.getElementById("summaryBox").innerHTML = `
        <div class="grid grid-cols-2 gap-4 sm-grid-1col">
          ${card("Appointment Details", "fa-calendar-check", row("Date", get("appointment_date")) + row("Time", get("appointment_time")))}
          ${card("Service", "fa-tooth", row("Type", get("service_type") === "Others" ? "Others – " + (get("service_others_text") || "N/A") : get("service_type")))}
        </div>
        ${card("Dental History", "fa-teeth", `
                  <div class="grid grid-cols-2 gap-x-8 sm-grid-1col">
                    ${row("Last Dental Visit", get("last_dental_visit"))}
                    ${row("Bleeding Gums", get("bleeding_gums"))}
                    ${row("Sensitive (Hot/Cold)", get("sensitive_temp"))}
                    ${row("Sensitive (Sweets)", get("sensitive_taste"))}
                    ${row("Tooth Pain", get("tooth_pain"))}
                    ${row("Sores/Lumps", get("sores"))}
                    ${row("Jaw Injuries", get("injuries"))}
                    ${row("Clicking Jaw", get("clicking"))}
                    ${row("Joint Pain", get("joint_pain"))}
                    ${row("Difficulty Moving", get("difficulty_moving"))}
                    ${row("Difficulty Chewing", get("difficulty_chewing"))}
                    ${row("Headaches", get("jaw_headaches"))}
                    ${row("Grinding/Clenching", get("clench_grind"))}
                    ${row("Lips/Cheek Biting", get("biting"))}
                    ${row("Teeth Loosening", get("teeth_loosening"))}
                    ${row("Food Caught Between Teeth", get("food_teeth"))}
                    ${row("Medicine Reaction", get("med_reaction"))}
                    ${row("Periodontal Treatment", get("periodontal"))}
                    ${row("Difficult Extraction", get("extraction_date"))}
                    ${row("Prolonged Bleeding", get("prolonged_bleeding"))}
                    ${row("Dentures", get("dentures_date"))}
                    ${row("Orthodontic Treatment", get("ortho_date"))}
                  </div>
                  ${get("additional_concerns") !== "N/A" ? `<p class="mt-2"><b class="text-[#5c5550] font-semibold">Additional Concerns:</b><br>${get("additional_concerns")}</p>` : ""}
                `)}
        ${card("Medical History", "fa-heart-pulse", `
                  <div class="grid grid-cols-2 gap-x-8 sm-grid-1col">
                    ${row("Good Health", get("good_health"))}
                    ${row("Last Medical Exam", get("medical_exam_date"))}
                    ${row("Under Treatment", get("under_treatment"))}
                    ${row("Hospitalized", get("hospitalized"))}
                    ${row("Allergy (Medicine)", get("allergy_medicine"))}
                    ${row("Allergy (Food)", get("allergy_food"))}
                    ${row("Medication", get("medication"))}
                    ${row("Tobacco Use", get("tobacco_use"))}
                  </div>
                  <p class="mt-2"><b class="text-[#5c5550] font-semibold">Medical Conditions:</b> ${diseases.length ? diseases.map(c => diseaseLabelByCode?.[c] ?? c).join(", ") : "None"}</p>
                `)}
        <div class="grid grid-cols-2 gap-4 sm-grid-1col">
          ${card("Emergency Contact", "fa-phone", row("Name", get("emergency_person")) + row("Number", get("emergency_number")) + row("Relation", emergencyRelation))}
          ${card("Signature", "fa-signature", sigHTML)}
        </div>`;
            document.querySelectorAll(".sm-grid-1col").forEach(el => {
                if (window.innerWidth < 640) el.style.gridTemplateColumns = "1fr";
            });
        }

        // MODAL (FINAL SUBMIT)
        const confirmModal = document.getElementById("confirmModal");
        const confirmMessage = document.getElementById("confirmMessage");
        const okBtn = document.getElementById("okBtn");

        const finalSubmitBtn = document.getElementById('finalSubmitBtn');
        const finalConfirm = document.getElementById('finalConfirm');

        if (finalSubmitBtn) {
            finalSubmitBtn.addEventListener("click", () => {
                if (!finalConfirm || !finalConfirm.checked) {
                    showMiniTab("Please confirm before submitting.");
                    return;
                }

                const date = document.getElementById("appointment_date")?.value || "N/A";
                const time = document.getElementById("appointment_time")?.value || "N/A";

                if (confirmMessage) {
                    confirmMessage.innerHTML = `
        Your dental appointment at PUP Taguig Dental Clinic has been successfully scheduled on 
        <b>${date}</b> at <b>${time}</b>.<br>
        Please arrive on time and bring your school or office ID.
        <br>
      `;
                }

                // show modal first
                confirmModal?.showModal();
            });
        }

        if (okBtn) {
            okBtn.addEventListener("click", () => {
                clearDraft();
                formSubmitting = true;
                document.getElementById("appointmentForm").submit();
            });
        }

        /* ══════════════════════════════════════════════
           THEME
        ══════════════════════════════════════════════ */
        var html = document.documentElement;
        var themeToggleContainer = document.getElementById("themeToggle");

        function applyTheme(theme) {
            html.setAttribute("data-theme", theme);
            localStorage.setItem("theme", theme);
            if (themeToggleContainer) {
                themeToggleContainer.querySelectorAll(".theme-option").forEach(function(opt) {
                    opt.classList.toggle("active", opt.getAttribute("data-theme") === theme);
                });
                var indicator = themeToggleContainer.querySelector(".theme-indicator");
                if (indicator) indicator.classList.toggle("dark-mode", theme === "dark");
            }
            var fabIcon = document.getElementById("darkModeFabIcon");
            if (fabIcon) fabIcon.className = theme === "dark" ? "fa-solid fa-sun" : "fa-solid fa-moon";
        }
        applyTheme(localStorage.getItem("theme") || "light");
        if (themeToggleContainer) {
            themeToggleContainer.querySelectorAll(".theme-option").forEach(function(opt) {
                opt.addEventListener("click", function() {
                    applyTheme(opt.getAttribute("data-theme"));
                });
            });
        }

        /* ══════════════════════════════════════════════
           DESKTOP SIDEBAR
        ══════════════════════════════════════════════ */
        var sidebarOpen = true;

        function applyLayout(w) {
            var sb = document.getElementById('sidebar');
            var mc = document.getElementById('mainContent');
            if (sb) sb.style.width = w;
            if (mc) mc.style.marginLeft = w;
        }

        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            var texts = document.querySelectorAll('.sidebar-text');
            var icon = document.getElementById('sidebarIcon');
            var wrapper = document.getElementById('sidebarToggleWrapper');
            sidebarOpen = !sidebarOpen;
            if (sidebarOpen) {
                applyLayout('220px');
                sidebar.classList.replace('collapsed', 'expanded');
                texts.forEach(function(t) {
                    t.classList.remove('opacity-0', 'w-0');
                    t.classList.add('opacity-100');
                });
                wrapper.classList.replace('justify-center', 'justify-end');
                icon.classList.replace('fa-bars', 'fa-xmark');
            } else {
                applyLayout('72px');
                sidebar.classList.replace('expanded', 'collapsed');
                texts.forEach(function(t) {
                    t.classList.add('opacity-0', 'w-0');
                    t.classList.remove('opacity-100');
                });
                wrapper.classList.replace('justify-end', 'justify-center');
                icon.classList.replace('fa-xmark', 'fa-bars');
            }
            applyTheme(localStorage.getItem("theme") || "light");
        }

        /* ── MOBILE PROFILE ── */
        function toggleMobileProfile() {
            var p = document.getElementById('mobileProfileAccordion'),
                c = document.getElementById('mobileProfileChevron');
            var o = p.classList.contains('open');
            p.classList.toggle('open', !o);
            if (c) c.style.transform = o ? 'rotate(0deg)' : 'rotate(180deg)';
        }

        /* ══════════════════════════════════════════════
           DOM READY
        ══════════════════════════════════════════════ */
        document.addEventListener('DOMContentLoaded', function() {

            // Initialize Pikaday on the input with id="datepicker"
            var picker = new Pikaday({
                field: document.getElementById('datepicker'),
                format: 'YYYY-MM-DD',
                minDate: new Date(), // Prevents selecting past dates
                toString(date, format) {
                    // Ensure the date is formatted correctly for your database
                    const day = date.getDate();
                    const month = date.getMonth() + 1;
                    const year = date.getFullYear();
                    return `${year}-${month}-${day}`;
                },
                onSelect: function() {
                    // Trigger the 'input' event so your "formIsDirty" logic 
                    // and draft saving features detect the change
                    document.getElementById('datepicker').dispatchEvent(new Event('input'));
                }
            });

            /* Desktop layout */
            if (window.innerWidth >= 768) {
                sidebarOpen = true;
                applyLayout('220px');
            } else {
                var mc = document.getElementById('mainContent');
                if (mc) mc.style.marginLeft = '0';
            }

            /* Mobile FAB */
            var mobFab = document.getElementById('mobFab');
            var mobFabMenu = document.getElementById('mobFabMenu');
            if (mobFab && mobFabMenu) {
                mobFab.addEventListener('click', function(e) {
                    e.stopPropagation();
                    var open = mobFabMenu.classList.contains('open');
                    mobFabMenu.classList.toggle('open', !open);
                    mobFab.classList.toggle('open', !open);
                });
                mobFabMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }

            /* Notifications */
            var notifBtn = document.getElementById("notifBtn");
            var notifMenu = document.getElementById("notifMenu");
            if (notifBtn && notifMenu) {
                notifBtn.addEventListener("click", function(e) {
                    e.stopPropagation();
                    notifMenu.classList.toggle("open");
                });
                notifMenu.addEventListener("click", function(e) {
                    e.stopPropagation();
                });
                document.addEventListener("keydown", function(e) {
                    if (e.key === "Escape") notifMenu.classList.remove("open");
                });
            }

            /* Close all on outside click */
            document.addEventListener('click', function() {
                if (mobFabMenu) {
                    mobFabMenu.classList.remove('open');
                    if (mobFab) mobFab.classList.remove('open');
                }
                if (notifMenu) notifMenu.classList.remove('open');
                var panel = document.getElementById('mobileProfileAccordion');
                var toggle = document.getElementById('mobileProfileToggle');
                var chevron = document.getElementById('mobileProfileChevron');
                if (panel && toggle && !panel.contains(event.target) && !toggle.contains(event.target)) {
                    panel.classList.remove('open');
                    if (chevron) chevron.style.transform = 'rotate(0deg)';
                }
            });

            /* Scroll reveal */
            var revealObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });
            document.querySelectorAll('.reveal').forEach(function(el) {
                revealObserver.observe(el);
            });
        });

        /* OTHERS MODAL */
        const othersModal = document.getElementById("othersModal");
        const othersInput = document.getElementById("other_services");
        const othersRadio = document.querySelector('input[name="service_type"][value="Others"]');
        const othersLabel = othersRadio?.closest('label');

        function openOthersModal() {
            if (!othersModal || othersModal.open) return;
            othersInput.required = true;
            othersModal.showModal();
            setTimeout(() => othersInput?.focus(), 100);
        }

        // Use click on the label so it fires even when already selected
        othersLabel?.addEventListener("click", () => {
            // Let the radio check first, then open
            setTimeout(openOthersModal, 0);
        });

        // Also handle change as a fallback for first-time selection
        othersRadio?.addEventListener("change", openOthersModal);

        document.getElementById("othersConfirmBtn")?.addEventListener("click", () => {
            if (!othersInput?.value.trim()) {
                showInputError(othersInput);
                return;
            }
            othersModal?.close();
        });
        document.getElementById("othersCancelBtn")?.addEventListener("click", () => {
            if (othersInput) {
                othersInput.value = "";
                othersInput.required = false;
            }
            othersModal?.close();
            if (othersRadio) othersRadio.checked = false;
        });

        /* DATE PICKERS */
        ["lastDentalVisit", "extractionDate", "denturesDate", "orthoDate", "medicalExamDate"].forEach(id => {
            const el = document.getElementById(id);
            if (!el) return;
            new Pikaday({
                field: el,
                maxDate: new Date(),
                yearRange: [1950, new Date().getFullYear()],
                firstDay: 1,
                onSelect(date) {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');

                    el.value = `${year}-${month}-${day}`;

                    formIsDirty = true;
                }
            });
        });

        /* CONDITIONAL TOGGLES */
        [{
            name: "difficult_extraction",
            boxId: "extraction_date_box",
            showOn: "YES"
        }, {
            name: "dentures",
            boxId: "dentures_date_box",
            showOn: "YES"
        }, {
            name: "ortho_treatment",
            boxId: "ortho_date_box",
            showOn: "YES"
        }].forEach(({
            name,
            boxId,
            showOn
        }) => {
            const radios = document.getElementsByName(name);
            const box = document.getElementById(boxId);
            if (!box || !radios.length) return;
            const inp = box.querySelector("input");
            radios.forEach(r => r.addEventListener("change", () => {
                if (r.checked && r.value === showOn) {
                    box.classList.remove("hidden");
                    if (inp) inp.required = true;
                } else if (r.checked) {
                    box.classList.add("hidden");
                    if (inp) {
                        inp.required = false;
                        inp.value = "";
                    }
                }
            }));
        });

        function syncMedicalExamBox() {
            const sel = document.querySelector('input[name="had_medical_exam"]:checked');
            const box = document.getElementById("medical_exam_box");
            const inp = document.getElementById("medicalExamDate");
            if (!sel || !box || !inp) return;
            if (sel.value === "YES") {
                box.classList.remove("hidden");
                inp.required = true;
            } else {
                box.classList.add("hidden");
                inp.required = false;
                inp.value = "";
            }
        }
        document.querySelectorAll('input[name="had_medical_exam"]').forEach(r => r.addEventListener("change",
            syncMedicalExamBox));
        syncMedicalExamBox();
        document.getElementById("emergency_relation")?.addEventListener("change", function() {
            const other = document.getElementById("relation_other");
            if (!other) return;
            if (this.value === "Others") {
                other.classList.remove("hidden");
                other.setAttribute("required", "true");
            } else {
                other.classList.add("hidden");
                other.removeAttribute("required");
                other.value = "";
            }
        });
        [{
            name: "good_health",
            boxId: "good_health_box",
            showOn: "NO"
        }, {
            name: "under_treatment",
            boxId: "treatment_box",
            showOn: "YES"
        }, {
            name: "hospitalized",
            boxId: "hospital_box",
            showOn: "YES"
        }, {
            name: "medication",
            boxId: "medication_box",
            showOn: "YES"
        }].forEach(({
            name,
            boxId,
            showOn
        }) => {
            const radios = document.getElementsByName(name);
            const box = document.getElementById(boxId);
            if (!box || !radios.length) return;
            radios.forEach(r => r.addEventListener("change", () => {
                const sel = [...radios].find(x => x.checked);
                const inputs = box.querySelectorAll("input");
                if (sel?.value === showOn) {
                    box.classList.remove("hidden");
                    inputs.forEach(i => i.required = true);
                } else {
                    box.classList.add("hidden");
                    inputs.forEach(i => {
                        i.required = false;
                        i.value = "";
                    });
                }
            }));
        });
        [...document.getElementsByName("tobacco_use")].forEach(r => r.addEventListener("change", () => {
            if (r.checked && r.value === "YES") document.getElementById("tobacco_details")?.classList.remove(
                "hidden");
            else document.getElementById("tobacco_details")?.classList.add("hidden");
        }));
        const sigInput = document.getElementById("patient_signature");
        const sigName = document.getElementById("signature_filename");
        sigInput?.addEventListener("change", () => {
            if (sigInput.files.length > 0) {
                sigName.textContent = sigInput.files[0].name;
                sigName.classList.remove("hidden");
            } else {
                sigName.textContent = "";
                sigName.classList.add("hidden");
            }
        });
        const emergencyNumber = document.getElementById("emergency_number");
        emergencyNumber?.addEventListener("input", e => {
            if (/[^0-9]/.test(e.target.value)) {
                showMiniTab("Contact number must contain digits only.");
                showInputError(emergencyNumber);
            }
            let v = e.target.value.replace(/\D/g, "");
            if (v.startsWith("9")) v = "0" + v;
            v = v.slice(0, 11);
            emergencyNumber.value = v;
            if (/^09\d{9}$/.test(v)) {
                emergencyNumber.classList.remove("border-red-500");
                emergencyNumber.classList.add("border-green-600");
            } else emergencyNumber.classList.remove("border-green-600");
        });
        emergencyNumber?.addEventListener("blur", () => {
            if (!emergencyNumber.value) emergencyNumber.classList.remove("border-red-500", "border-green-600");
        });

        /* --- NAVIGATION & DIRTY CHECK --- */
        let formIsDirty = false;
        let formSubmitting = false;
        let pendingNavigation = null;

        const leaveModal = document.getElementById('leaveModal');

        // Track if form is touched (typing, clicking radios, voice input, picking dates)
        document.querySelectorAll('input, textarea, select').forEach(input => {
            input.addEventListener('input', () => {
                formIsDirty = true;
            });
        });
        document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(input => {
            input.addEventListener('change', () => {
                formIsDirty = true;
            });
        });

        // Function to open modal
        function openLeaveModal(onConfirm) {
            pendingNavigation = onConfirm;
            leaveModal.showModal(); // Native way to open a <dialog>
        }

        // Function to close modal
        function closeLeaveModal() {
            leaveModal.close();
            pendingNavigation = null;
        }

        // BUTTON ACTIONS
        // 1. Cancel: Just close the modal, do nothing else.
        document.getElementById('cancelLeaveBtn')?.addEventListener('click', closeLeaveModal);

        // 2. Save Draft: Call the save function, turn off dirty warning, and navigate.
        document.getElementById('saveDraftBtn')?.addEventListener('click', () => {
            saveDraftData();
            formIsDirty = false;
            if (typeof pendingNavigation === "function") pendingNavigation();
        });

        // 3. Discard: Call the clear function, turn off dirty warning, and navigate.
        document.getElementById('discardDraftBtn')?.addEventListener('click', () => {
            clearDraft();
            formIsDirty = false;
            if (typeof pendingNavigation === "function") pendingNavigation();
        });

        // Handle Clicks on internal links (like "Back to Home")
        document.querySelectorAll('a[href]').forEach(link => {
            link.addEventListener("click", e => {
                const href = link.getAttribute("href") || "";

                // Ignore internal anchors and javascript links
                if (href.startsWith("#") || href.startsWith("javascript:") || link.type === 'submit')
                    return;

                if (formIsDirty && !formSubmitting) {
                    e.preventDefault();
                    openLeaveModal(() => {
                        window.location.href = link.href;
                    });
                }
            });
        });

        // System Tab-Close Validation (Cannot be customized visually)
        window.addEventListener("beforeunload", e => {
            if (formIsDirty && !formSubmitting) {
                e.preventDefault();
                e.returnValue = "";
            }
        });

        /* CALENDAR INITIALIZATION */
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('datepicker');

            if (dateInput) {
                const picker = new Pikaday({
                    field: dateInput,
                    format: 'YYYY-MM-DD',
                    minDate: new Date(), // Prevents picking dates in the past
                    theme: 'crimson-theme', // Optional: for custom styling
                    onSelect: function() {
                        // Ensure the form is marked as "dirty" when a date is picked
                        formIsDirty = true;
                        dateInput.dispatchEvent(new Event('input'));
                    }
                });
            }
        });

        /* INIT */
        showStep(0);
        restoreDraft();

        window.addEventListener("resize", () => {
            document.querySelectorAll(".sm-grid-1col").forEach(el => {
                el.style.gridTemplateColumns = window.innerWidth < 640 ? "1fr" : "1fr 1fr";
            });
        });
    </script>
</body>

</html>
