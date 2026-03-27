@extends('layouts.dentist')

@section('title', 'Dentist Dashboard | PUP Taguig Dental Clinic')

@section('styles')
    <style>
        /* ════════ DASHBOARD SPECIFIC STYLES ════════ */
        @keyframes wave {
            0% {
                transform: rotate(0deg)
            }

            20% {
                transform: rotate(14deg)
            }

            40% {
                transform: rotate(-8deg)
            }

            60% {
                transform: rotate(14deg)
            }

            80% {
                transform: rotate(-4deg)
            }

            100% {
                transform: rotate(0deg)
            }
        }

        .wave-hand {
            transform-origin: 70% 70%;
            animation: wave 2.5s ease-in-out infinite;
        }

        /* GREETING ROW */
        .greeting-row {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: nowrap;
        }

        .greeting-title {
            font-size: clamp(1.25rem, 3.5vw, 2.1rem);
            line-height: 1.2;
            margin-bottom: 0 !important;
        }

        .greeting-title span {
            display: inline;
            word-break: break-word;
        }

        /* Status pill card (Top Right) */
        .status-card {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #fff;
            border: 1px solid #fce8e8;
            box-shadow: 0 2px 12px rgba(139, 0, 0, .06);
            border-radius: 999px;
            padding: 6px 6px 6px 20px;
            flex-shrink: 0;
        }

        .status-card-labels {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 1px;
        }

        .status-card-eyebrow {
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #b0b7c3;
        }

        .status-card-text {
            font-size: 11px;
            font-weight: 600;
            color: #757575;
            white-space: nowrap;
        }

        @media (max-width: 480px) {
            .greeting-row {
                flex-wrap: wrap;
                align-items: flex-start;
            }

            .status-card {
                width: 100%;
                justify-content: space-between;
            }

            .status-card-labels {
                align-items: flex-start;
            }
        }

        /* KPI GRID */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        @media (min-width: 640px) {
            .kpi-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 1024px) {

            /* EXACTLY 5 COLUMNS for 1 row */
            .kpi-grid {
                grid-template-columns: repeat(5, 1fr);
            }
        }

        /* ROW GRIDS */
        .row2-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        @media (min-width: 1024px) {
            .row2-grid {
                grid-template-columns: 7fr 5fr;
                align-items: stretch;
            }
        }

        .row3-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        @media (min-width: 1024px) {
            .row3-grid {
                grid-template-columns: 7fr 5fr;
            }
        }

        @media (max-width: 1023px) {
            #dentistCalendarContainer {
                min-height: 360px !important;
            }

            .inventory-scroll-wrap {
                position: relative;
            }

            .inventory-scroll-wrap::after {
                content: '';
                position: sticky;
                bottom: 0;
                display: block;
                height: 24px;
                background: linear-gradient(to bottom, transparent, rgba(255, 255, 255, .9));
                pointer-events: none;
                margin-top: -24px;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $dentalCasesThisMonth = $dentalCasesThisMonth ?? 0;
        $totalApptsThisMonth = $totalApptsThisMonth ?? 0;

        $dentalCasesDelta = $dentalCasesDelta ?? null;
        $totalApptsDelta = $totalApptsDelta ?? null;

        $gadLabels = $gadLabels ?? ['Student', 'Administrative', 'Faculty', 'Dependent'];
        $gadFemale = $gadFemale ?? [0, 0, 0, 0];
        $gadMale = $gadMale ?? [0, 0, 0, 0];

        $appointmentCountsPerDay = $appointmentCountsPerDay ?? [];
        $unavailableDates = $unavailableDates ?? [];
        $philippineHolidays = $philippineHolidays ?? [];
        $todayAppointments = $todayAppointments ?? collect();

        $medicalSupplies = $medicalSupplies ?? collect();
        $medicineSupplies = $medicineSupplies ?? collect();

        $calendarAppointmentCounts = $appointmentCountsPerDay;

        if (empty($calendarAppointmentCounts) && $todayAppointments->count() > 0) {
            $calendarAppointmentCounts = [
                \Carbon\Carbon::today()->format('Y-m-d') => $todayAppointments->count(),
            ];
        }
    @endphp

    <main id="mainContent" class="pt-[100px] px-6 py-6 fade-in min-h-screen">
        <div class="max-w-7xl mx-auto fade-in">

            <div class="greeting-row">
                <div class="min-w-0 flex-1">
                    <h1 class="greeting-title font-extrabold fade-in">
                        <span class="bg-gradient-to-r from-[#660000] to-[#FFD700] bg-clip-text text-transparent">
                            Good Morning, <span id="dentistName"></span>
                            <i class="fa-solid fa-hand text-[#FFD700] wave-hand"></i>
                        </span>
                    </h1>
                    <p class="text-xs text-[#9CA3AF] font-medium mt-1" id="greetingDate"></p>
                </div>

                <div class="status-card">
                    <div class="status-card-labels">
                        <span class="status-card-eyebrow">Clinic Status</span>
                        <span class="status-card-text">The Dentist is currently</span>
                    </div>
                    <button id="statusBtn" onclick="openStatusModal()"
                        class="rounded-full px-5 py-2 font-bold shadow text-white flex items-center gap-2 transition-colors duration-300"
                        style="background:#00A96E; font-size:13px; border:none;">
                        <span id="statusLabel" class="flex items-center gap-2">
                            <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span> IN
                        </span>
                    </button>
                </div>
            </div>

            <div class="kpi-grid">

                {{-- KPI 1: Dental Cases --}}
                <div class="relative overflow-hidden rounded-2xl p-5 text-white"
                    style="background:linear-gradient(135deg,#8B0000 0%,#5a0000 100%);box-shadow:0 4px 20px rgba(139,0,0,.35);">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                            style="background:rgba(255,255,255,.15);">
                            <i class="fa-solid fa-tooth text-yellow-300 text-lg"></i>
                        </div>
                        @if (!is_null($dentalCasesDelta))
                            <span class="text-[10px] font-bold px-2 py-1 rounded-full"
                                style="background:rgba(255,255,255,.15);">
                                {{ $dentalCasesDelta >= 0 ? '+' : '' }}{{ $dentalCasesDelta }}%
                            </span>
                        @endif
                    </div>
                    <p class="text-4xl font-extrabold leading-none tracking-tight">{{ $dentalCasesThisMonth }}</p>
                    <p class="text-xs font-semibold mt-1 uppercase tracking-widest" style="opacity:.65;">Dental Cases</p>
                    <p class="text-xs mt-0.5" style="opacity:.45;">{{ now()->format('F Y') }}</p>
                    <div class="absolute -bottom-5 -right-5 w-24 h-24 rounded-full"
                        style="background:rgba(255,255,255,.05);"></div>
                </div>

                {{-- KPI 2: Total Appointments --}}
                <div class="relative overflow-hidden rounded-2xl p-5 bg-white"
                    style="border:1.5px solid #fce8e8;box-shadow:0 2px 12px rgba(139,0,0,.08);">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
                            <i class="fa-regular fa-calendar-check text-[#8B0000] text-lg"></i>
                        </div>
                        @if (!is_null($totalApptsDelta))
                            <span
                                class="text-[10px] font-bold px-2 py-1 rounded-full {{ $totalApptsDelta >= 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                {{ $totalApptsDelta >= 0 ? '+' : '' }}{{ $totalApptsDelta }}%
                            </span>
                        @endif
                    </div>
                    <p class="text-4xl font-extrabold leading-none tracking-tight text-[#8B0000]">{{ $totalApptsThisMonth }}
                    </p>
                    <p class="text-xs font-semibold mt-1 uppercase tracking-widest text-[#8B0000]/50">Total Appointments</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ now()->format('F Y') }}</p>
                    <div class="absolute -bottom-5 -right-5 w-24 h-24 rounded-full bg-red-50/40"></div>
                </div>

                {{-- KPI 3: Today's Patients --}}
                <div class="relative overflow-hidden rounded-2xl p-5 bg-white"
                    style="border:1.5px solid #fce8e8;box-shadow:0 2px 12px rgba(139,0,0,.08);">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-red-50 flex-shrink-0"
                            style="display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-user-clock text-[#8B0000] text-lg"></i>
                        </div>
                        <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-green-50 text-green-700">Today</span>
                    </div>
                    <p class="text-4xl font-extrabold leading-none tracking-tight text-[#8B0000]">
                        {{ $todayAppointments->count() }}</p>
                    <p class="text-xs font-semibold mt-1 uppercase tracking-widest text-[#8B0000]/50">Today's Patients</p>
                    <p class="text-[10px] text-gray-400 mt-1 flex items-center gap-1">
                        <span
                            class="text-green-500 font-bold">{{ $todayAppointments->where('status', 'confirmed')->count() }}
                            confirmed</span>
                        <span class="text-gray-300">·</span>
                        <span
                            class="text-yellow-500 font-bold">{{ $todayAppointments->where('status', 'pending')->count() }}
                            pending</span>
                    </p>
                    <div class="absolute -bottom-5 -right-5 w-24 h-24 rounded-full bg-red-50/40"></div>
                </div>

                {{-- KPI 4: Live Clock --}}
                <div class="relative overflow-hidden rounded-2xl p-5"
                    style="background:linear-gradient(135deg,#7b0c0c 0%,#4a0606 100%);box-shadow:0 4px 20px rgba(100,0,0,.3);">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                            <i id="kpi-clock-icon" class="fa-solid fa-sun text-yellow-300 text-lg"></i>
                        </div>
                        <span class="text-[10px] font-bold px-2 py-1 rounded-full text-white"
                            style="background:rgba(255,255,255,.15);">
                            <span class="inline-block w-1.5 h-1.5 rounded-full bg-red-400 animate-pulse mr-1"
                                style="vertical-align:middle;"></span>Live
                        </span>
                    </div>
                    <p class="leading-none text-white">
                        <span id="kpi-clock-hhmm" class="text-3xl font-extrabold tracking-tight"
                            style="font-variant-numeric:tabular-nums;">00:00</span>
                        <span id="kpi-clock-ss" class="text-xl font-semibold opacity-50"
                            style="font-variant-numeric:tabular-nums;">:00</span>
                        <span id="kpi-clock-ampm" class="text-xs font-bold opacity-60 ml-1 align-super">AM</span>
                    </p>
                    <p class="text-xs font-semibold mt-1 uppercase tracking-widest text-white" style="opacity:.55;">Live
                        Time</p>
                    <p class="text-xs mt-0.5 text-white flex items-center gap-1.5" style="opacity:.45;">
                        <i id="kpi-clock-dayicon" class="fa-solid fa-sun text-xs flex-shrink-0" style="color:#fde68a;"></i>
                        <span id="kpi-clock-date"></span>
                    </p>
                    <div class="absolute -bottom-5 -right-5 w-24 h-24 rounded-full"
                        style="background:rgba(255,255,255,.04);"></div>
                </div>

                {{-- KPI 5: Clinic Status (Now matched to the other cards!) --}}
                <div class="relative overflow-hidden rounded-2xl p-5 bg-white"
                    style="border:1.5px solid #d1fae5;box-shadow:0 2px 12px rgba(16,185,129,.08);">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl flex-shrink-0"
                            style="background:#e6f4ea; display:flex; align-items:center; justify-content:center;">
                            <i id="statusKpiIcon" class="fa-solid fa-door-open text-lg" style="color:#00A96E;"></i>
                        </div>
                        <span class="text-[10px] font-bold px-2 py-1 rounded-full"
                            style="background:#e6f4ea; color:#00A96E;">Live</span>
                    </div>
                    <p id="statusKpiLabel" class="text-4xl font-extrabold leading-none tracking-tight"
                        style="color:#00A96E;">Open</p>
                    <p class="text-xs font-semibold mt-1 uppercase tracking-widest text-[#8B0000]/50">Clinic Status</p>
                    <button onclick="openStatusModal()"
                        class="mt-2 text-[11px] font-bold text-[#8B0000] hover:text-[#660000] transition flex items-center gap-1">
                        Change <i class="fa-solid fa-arrow-right"></i>
                    </button>
                    <div class="absolute -bottom-5 -right-5 w-24 h-24 rounded-full"
                        style="background:#e6f4ea; opacity: 0.5;"></div>
                </div>

            </div>

            <div class="row2-grid">
                <div>
                    <div id="dentistCalendarContainer"
                        class="bg-white border shadow rounded-2xl p-6 w-full min-h-[420px] h-full">
                        <div class="animate-pulse space-y-4">
                            <div class="h-6 w-40 bg-gray-200 rounded mx-auto"></div>
                            <div class="grid grid-cols-7 gap-2">
                                @for ($i = 0; $i < 35; $i++)
                                    <div class="h-9 bg-gray-200 rounded-lg"></div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card bg-gradient-to-b from-[#8B0000] to-[#660000] text-white shadow h-full">
                        <div class="card-body flex flex-col">
                            <div class="flex items-center justify-between mb-3">
                                <h2 class="text-base font-bold flex items-center gap-2">
                                    <i class="fa-regular fa-clock text-yellow-300"></i> Scheduled Today
                                </h2>
                                <span class="badge bg-yellow-400 text-[#660000] font-bold border-none px-3">
                                    {{ $todayAppointments->count() }}
                                    {{ \Illuminate\Support\Str::plural('patient', $todayAppointments->count()) }}
                                </span>
                            </div>
                            <div class="space-y-2 flex-1 overflow-y-auto pr-1">
                                @forelse($todayAppointments as $appointment)
                                    @php
                                        $name = $appointment->patient->name ?? 'Unknown Patient';
                                        $time = \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A');
                                        $service =
                                            $appointment->service_type === 'others'
                                                ? $appointment->other_services ?? 'Other Service'
                                                : $appointment->service_type;
                                        $isConfirmed = $appointment->status === 'confirmed';
                                    @endphp
                                    <a href="{{ route('dentist.dentist.appointments') }}"
                                        class="flex items-center gap-3 bg-white/10 hover:bg-white/20 border border-white/20 p-3 rounded-xl w-full transition duration-200 hover:scale-[1.01]">
                                        <div
                                            class="rounded-full w-9 h-9 border-2 border-yellow-300 bg-white/20 flex items-center justify-center font-bold text-sm flex-shrink-0">
                                            {{ strtoupper(substr($name, 0, 1)) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-sm truncate">{{ $name }}</p>
                                            <p class="text-xs opacity-70 truncate flex items-center gap-1">
                                                <i
                                                    class="fa-solid fa-stethoscope text-yellow-300 flex-shrink-0 text-[10px]"></i>
                                                {{ ucwords($service) }} · {{ $time }}
                                            </p>
                                        </div>
                                        @if ($isConfirmed)
                                            <span
                                                class="badge badge-sm bg-green-400 text-white border-none flex-shrink-0 text-[10px]">✓</span>
                                        @else
                                            <span
                                                class="badge badge-sm bg-yellow-400 text-[#660000] border-none flex-shrink-0 text-[10px]">!</span>
                                        @endif
                                    </a>
                                @empty
                                    <div class="flex flex-col items-center justify-center py-10 opacity-60">
                                        <i class="fa-regular fa-calendar-xmark text-4xl mb-3 text-yellow-300"></i>
                                        <p class="text-sm font-semibold">No appointments today</p>
                                        <p class="text-xs opacity-70 mt-1">Enjoy your free day, Doctor!</p>
                                    </div>
                                @endforelse
                            </div>
                            <a href="{{ route('dentist.dentist.appointments') }}"
                                class="mt-4 flex items-center justify-center gap-2 text-xs font-semibold text-yellow-300 hover:text-yellow-200 transition border-t border-white/10 pt-3">
                                View all appointments <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row3-grid">

                <div class="card bg-white shadow rounded-2xl">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-base font-bold text-[#8B0000]">
                                    <i class="fa-solid fa-chart-column mr-1.5 opacity-70"></i>GAD Analytics
                                </h3>
                                <p class="text-xs text-gray-400 mt-0.5">Patient cases by category and sex —
                                    {{ now()->format('F Y') }}</p>
                            </div>
                            <div class="flex items-center gap-4 text-xs font-semibold">
                                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full inline-block"
                                        style="background:#FFC0CB"></span>Female</span>
                                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full inline-block"
                                        style="background:#89CFF0"></span>Male</span>
                            </div>
                        </div>
                        <div style="height:300px; width:100%;"><canvas id="gadChart"></canvas></div>
                    </div>
                </div>

                <div class="flex flex-col gap-4">

                    <div class="relative rounded-2xl p-[2px]" style="background:linear-gradient(135deg,#660000,#FFD700);">
                        <div class="card bg-white rounded-2xl">
                            <div class="card-body p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="font-bold text-[#8B0000] flex items-center gap-2 text-sm">
                                        <i class="fa-solid fa-boxes"></i> Medical Supplies
                                    </h3>
                                    <a href="{{ route('dentist.dentist.inventory') }}"
                                        class="text-xs text-[#8B0000] hover:underline font-semibold flex items-center gap-1">
                                        View all <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                    </a>
                                </div>
                                @if ($medicalSupplies->count() > 0)
                                    <div class="overflow-y-auto inventory-scroll-wrap" style="max-height:180px;">
                                        <table class="table table-xs w-full">
                                            <thead class="sticky top-0 bg-white z-10">
                                                <tr class="text-[#8B0000] text-[11px]">
                                                    <th>Item</th>
                                                    <th class="text-center">Qty</th>
                                                    <th class="text-center">Used</th>
                                                    <th class="text-center">Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-xs text-[#333]">
                                                @foreach ($medicalSupplies as $item)
                                                    @php
                                                        $balance = $item->qty - $item->used;
                                                        $pct = $item->qty > 0 ? ($balance / $item->qty) * 100 : 100;
                                                        $isLow = $pct <= 30;
                                                        $badgeCls = $isLow
                                                            ? 'bg-red-100 text-red-700 animate-pulse'
                                                            : 'bg-green-100 text-green-700';
                                                    @endphp
                                                    <tr>
                                                        <td class="max-w-[140px] truncate">{{ $item->name }}</td>
                                                        <td class="text-center">{{ $item->qty }}</td>
                                                        <td class="text-center">{{ $item->used }}</td>
                                                        <td class="text-center">
                                                            <span
                                                                class="badge badge-xs border-none font-semibold {{ $badgeCls }}">
                                                                {{ $balance }}{{ $isLow ? ' ⚠' : '' }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center py-5 text-center opacity-50">
                                        <i class="fa-solid fa-box-open text-2xl mb-2 text-[#8B0000]"></i>
                                        <p class="text-xs font-semibold text-gray-500">No supply items yet</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="relative rounded-2xl p-[2px]" style="background:linear-gradient(135deg,#660000,#FFD700);">
                        <div class="card bg-white rounded-2xl">
                            <div class="card-body p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="font-bold text-[#8B0000] flex items-center gap-2 text-sm">
                                        <i class="fa-solid fa-pills"></i> Medicine Supplies
                                    </h3>
                                    <a href="{{ route('dentist.dentist.inventory') }}"
                                        class="text-xs text-[#8B0000] hover:underline font-semibold flex items-center gap-1">
                                        View all <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                    </a>
                                </div>
                                @if ($medicineSupplies->count() > 0)
                                    <div class="overflow-y-auto inventory-scroll-wrap" style="max-height:180px;">
                                        <table class="table table-xs w-full">
                                            <thead class="sticky top-0 bg-white z-10">
                                                <tr class="text-[#8B0000] text-[11px]">
                                                    <th>Medicine</th>
                                                    <th class="text-center">Form</th>
                                                    <th class="text-center">Qty</th>
                                                    <th class="text-center">Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-xs text-[#333]">
                                                @foreach ($medicineSupplies as $item)
                                                    @php
                                                        $balance = $item->qty - $item->used;
                                                        $pct = $item->qty > 0 ? ($balance / $item->qty) * 100 : 100;
                                                        $isLow = $pct <= 30;
                                                        $badgeCls = $isLow
                                                            ? 'bg-red-100 text-red-700 animate-pulse'
                                                            : 'bg-green-100 text-green-700';
                                                    @endphp
                                                    <tr>
                                                        <td class="max-w-[120px] truncate">{{ $item->name }}</td>
                                                        <td class="text-center">{{ $item->form ?? '—' }}</td>
                                                        <td class="text-center">{{ $item->qty }}</td>
                                                        <td class="text-center">
                                                            <span
                                                                class="badge badge-xs border-none font-semibold {{ $badgeCls }}">
                                                                {{ $balance }}{{ $isLow ? ' ⚠' : '' }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center py-5 text-center opacity-50">
                                        <i class="fa-solid fa-pills text-2xl mb-2 text-[#8B0000]"></i>
                                        <p class="text-xs font-semibold text-gray-500">No medicine items yet</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>

    <div id="statusModal"
        class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
        <div id="statusModalBox"
            class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 p-0 overflow-hidden scale-90 transition-all duration-300">
            <div id="modalBanner"
                class="bg-gradient-to-r from-[#660000] to-[#8B0000] px-6 pt-6 pb-4 text-white text-center">
                <div id="modalIcon"
                    class="w-16 h-16 rounded-full mx-auto mb-3 flex items-center justify-center text-2xl bg-white/20">
                    <i class="fa-solid fa-door-closed"></i>
                </div>
                <h2 id="modalTitle" class="text-xl font-extrabold">Close the Clinic?</h2>
                <p id="modalSubtitle" class="text-sm opacity-80 mt-1">You are about to mark yourself as
                    <strong>OUT</strong></p>
            </div>
            <div class="px-6 py-5">
                <p id="modalBody" class="text-sm text-[#555] text-center leading-relaxed">
                    This will indicate that the clinic is <span class="font-semibold text-red-700">currently closed</span>.
                    Patients will not be able to book new appointments while you are out.
                </p>
                <div class="flex gap-3 mt-5">
                    <button onclick="closeStatusModal()"
                        class="flex-1 btn btn-ghost border border-gray-200 rounded-xl font-semibold text-gray-600 hover:bg-gray-100">Cancel</button>
                    <button id="confirmStatusBtn" onclick="confirmStatus()"
                        class="flex-1 btn rounded-xl font-bold text-white bg-[#8B0000] hover:bg-[#660000] border-none shadow">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    @if (session('activeAppointmentModal'))
        <dialog id="activeAppointmentModal" class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Active Appointment!</h3>
                <p class="py-4">You have an ongoing appointment setup.</p>
                <div class="modal-action">
                    <form method="dialog">
                        <button class="btn" id="closeActiveApptModalBtn">Close</button>
                    </form>
                </div>
            </div>
        </dialog>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var modal = document.getElementById("activeAppointmentModal");
                if (modal) modal.showModal();
            });
        </script>
    @endif
@endsection

@section('scripts')
    <script>
        const dashboardData = {
            gadLabels: @json($gadLabels),
            gadFemale: @json($gadFemale),
            gadMale: @json($gadMale),
            apptCounts: @json($calendarAppointmentCounts),
            unavailableDates: @json($unavailableDates),
            holidays: @json($philippineHolidays),
        };

        const GAD_LABELS = dashboardData.gadLabels;
        const GAD_FEMALE = dashboardData.gadFemale;
        const GAD_MALE = dashboardData.gadMale;

        /* ── GREETING & CLOCK ── */
        document.addEventListener("DOMContentLoaded", () => {
            document.getElementById("dentistName").textContent = "Dr. Nelson!";
            document.getElementById("greetingDate").textContent = new Date().toLocaleDateString("en-US", {
                weekday: "long",
                year: "numeric",
                month: "long",
                day: "numeric"
            });

            const h = new Date().getHours();
            const greeting = h < 12 ? 'Good Morning,' : h < 18 ? 'Good Afternoon,' : 'Good Evening,';
            const greetEl = document.querySelector(
                '.bg-gradient-to-r.from-\\[\\#660000\\].to-\\[\\#FFD700\\].bg-clip-text');
            if (greetEl) {
                const fn = greetEl.childNodes[0];
                if (fn && fn.nodeType === Node.TEXT_NODE) fn.textContent = greeting + ' ';
            }
        });

        (function() {
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            function tickClock() {
                const now = new Date();
                let h = now.getHours(),
                    m = now.getMinutes(),
                    s = now.getSeconds();
                const ampm = h >= 12 ? 'PM' : 'AM';
                const isDaytime = h >= 6 && h < 18;
                const displayHour = h % 12 || 12;

                const hmEl = document.getElementById('kpi-clock-hhmm');
                if (!hmEl) return;

                hmEl.textContent = String(displayHour).padStart(2, '0') + ':' + String(m).padStart(2, '0');
                document.getElementById('kpi-clock-ss').textContent = ':' + String(s).padStart(2, '0');
                document.getElementById('kpi-clock-ampm').textContent = ampm;
                document.getElementById('kpi-clock-date').textContent = days[now.getDay()] + ', ' + months[now
                .getMonth()] + ' ' + now.getDate();

                const dayicon = document.getElementById('kpi-clock-dayicon');
                const bigicon = document.getElementById('kpi-clock-icon');
                if (dayicon && bigicon) {
                    dayicon.className = isDaytime ? 'fa-solid fa-sun text-xs flex-shrink-0' :
                        'fa-solid fa-moon text-xs flex-shrink-0';
                    dayicon.style.color = isDaytime ? '#fde68a' : '#bfdbfe';
                    bigicon.className = isDaytime ? 'fa-solid fa-sun text-lg' : 'fa-solid fa-moon text-lg';
                    bigicon.style.color = isDaytime ? '#fde68a' : '#bfdbfe';
                }
            }
            tickClock();
            setInterval(tickClock, 1000);
        })();

        /* ── STATUS MODAL ── */
        let dentistIsIn = true;

        function openStatusModal() {
            const modal = document.getElementById('statusModal');
            const box = document.getElementById('statusModalBox');
            const banner = document.getElementById('modalBanner');
            const icon = document.getElementById('modalIcon');
            const title = document.getElementById('modalTitle');
            const sub = document.getElementById('modalSubtitle');
            const body = document.getElementById('modalBody');

            if (dentistIsIn) {
                banner.className = 'bg-gradient-to-r from-[#660000] to-[#8B0000] px-6 pt-6 pb-4 text-white text-center';
                icon.innerHTML = '<i class="fa-solid fa-door-closed"></i>';
                title.textContent = 'Close the Clinic?';
                sub.innerHTML = 'You are about to mark yourself as <strong>OUT</strong>';
                body.innerHTML =
                    'This will indicate that the clinic is <span class="font-semibold text-red-700">currently closed</span>. Patients will not be able to book new appointments while you are out.';
            } else {
                banner.className = 'bg-gradient-to-r from-green-600 to-green-700 px-6 pt-6 pb-4 text-white text-center';
                icon.innerHTML = '<i class="fa-solid fa-door-open"></i>';
                title.textContent = 'Open the Clinic?';
                sub.innerHTML = 'You are about to mark yourself as <strong>IN</strong>';
                body.innerHTML =
                    'This will indicate that the clinic is <span class="font-semibold text-green-700">now open</span>. Patients will be able to see your availability and book appointments.';
            }

            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100');
            setTimeout(() => box.classList.replace('scale-90', 'scale-100'), 10);
        }

        function closeStatusModal() {
            const modal = document.getElementById('statusModal');
            const box = document.getElementById('statusModalBox');
            box.classList.replace('scale-100', 'scale-90');
            setTimeout(() => {
                modal.classList.add('opacity-0', 'pointer-events-none');
                modal.classList.remove('opacity-100');
            }, 150);
        }

        function confirmStatus() {
            const btn = document.getElementById('statusBtn');
            const label = document.getElementById('statusLabel');
            const kpiLabel = document.getElementById('statusKpiLabel');
            const kpiIcon = document.getElementById('statusKpiIcon');

            dentistIsIn = !dentistIsIn;

            if (dentistIsIn) {
                btn.style.background = '#00A96E';
                label.innerHTML = '<span class="w-2 h-2 bg-white rounded-full animate-pulse"></span> IN';
                if (kpiLabel) {
                    kpiLabel.textContent = 'Open';
                    kpiLabel.style.color = '#00A96E';
                }
                if (kpiIcon) {
                    kpiIcon.className = 'fa-solid fa-door-open text-lg';
                    kpiIcon.style.color = '#00A96E';
                }
            } else {
                btn.style.background = '#EF4444';
                label.innerHTML = '<span class="w-2 h-2 bg-white rounded-full"></span> OUT';
                if (kpiLabel) {
                    kpiLabel.textContent = 'Closed';
                    kpiLabel.style.color = '#EF4444';
                }
                if (kpiIcon) {
                    kpiIcon.className = 'fa-solid fa-door-closed text-lg';
                    kpiIcon.style.color = '#EF4444';
                }
            }
            closeStatusModal();
        }

        document.getElementById('statusModal').addEventListener('click', function(e) {
            if (e.target === this) closeStatusModal();
        });

        /* ── CHART & CALENDAR ── */
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                const ctx = document.getElementById('gadChart');
                if (!ctx) return;
                const hasData = [...GAD_FEMALE, ...GAD_MALE].some(v => v > 0);
                if (!hasData) {
                    const c = ctx.getContext('2d');
                    ctx.height = 300;
                    c.font = '14px Inter';
                    c.fillStyle = '#707070';
                    c.textAlign = 'center';
                    c.fillText('No treatment records this month', ctx.parentElement.offsetWidth / 2, 150);
                    return;
                }
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: GAD_LABELS,
                        datasets: [{
                                label: 'Female',
                                data: GAD_FEMALE,
                                backgroundColor: 'rgba(255,192,203,0.85)',
                                borderColor: '#FFB6C1',
                                borderWidth: 1,
                                borderRadius: 6
                            },
                            {
                                label: 'Male',
                                data: GAD_MALE,
                                backgroundColor: 'rgba(137,207,240,0.85)',
                                borderColor: '#7EC8E3',
                                borderWidth: 1,
                                borderRadius: 6
                            },
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y} cases`
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        family: 'Inter',
                                        size: 12
                                    },
                                    color: '#555'
                                },
                                title: {
                                    display: true,
                                    text: 'Patient Category',
                                    font: {
                                        family: 'Inter',
                                        size: 12
                                    },
                                    color: '#888'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    borderDash: [4, 4],
                                    color: '#f0f0f0'
                                },
                                ticks: {
                                    precision: 0,
                                    font: {
                                        family: 'Inter',
                                        size: 12
                                    },
                                    color: '#555'
                                },
                                title: {
                                    display: true,
                                    text: 'Number of Cases',
                                    font: {
                                        family: 'Inter',
                                        size: 12
                                    },
                                    color: '#888'
                                }
                            }
                        }
                    }
                });
            }, 150);

            loadDentistCalendar();
        });

        function loadDentistCalendar() {
            const MAX_PER_DAY = 5;
            const apptCounts = dashboardData.apptCounts;
            const unavailableDates = dashboardData.unavailableDates;
            const allHolidays = dashboardData.holidays;

            const today = new Date();
            let currentYear = today.getFullYear(),
                currentMonth = today.getMonth();

            function pad(n) {
                return String(n).padStart(2, '0');
            }

            function isWeekend(y, m, d) {
                const dow = new Date(y, m, d).getDay();
                return dow === 0 || dow === 6;
            }

            function getHolidaysForMonth(year, month) {
                const out = {};
                Object.keys(allHolidays).forEach(ds => {
                    const [y, m] = ds.split('-').map(Number);
                    if (y === year && m === month + 1) out[ds] = allHolidays[ds];
                });
                return out;
            }

            function renderDentistCalendar(year, month) {
                const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
                    "October", "November", "December"
                ];
                const dayLabels = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
                const firstDow = new Date(year, month, 1).getDay();
                const totalDays = new Date(year, month + 1, 0).getDate();
                const holidays = getHolidaysForMonth(year, month);

                const headerHtml = dayLabels.map((l, i) =>
                    `<div class="text-center text-[10px] font-bold ${(i === 0 || i === 6) ? 'text-[#8B0000]/40' : 'text-[#555]'} uppercase tracking-widest">${l}</div>`
                ).join('');

                let cells = '';
                for (let i = 0; i < firstDow; i++) cells += `<div></div>`;

                for (let d = 1; d <= totalDays; d++) {
                    const dateStr = `${year}-${pad(month + 1)}-${pad(d)}`;
                    const isToday = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
                    const weekend = isWeekend(year, month, d);
                    const holiday = holidays[dateStr] || null;
                    const count = apptCounts[dateStr] || 0;
                    const isFull = count >= MAX_PER_DAY;
                    const isUnavail = unavailableDates.includes(dateStr) || weekend;
                    const hasAppts = count > 0;

                    let dotHtml = '',
                        badgeHtml = '',
                        tooltipTxt = '';

                    if (holiday) {
                        dotHtml =
                            `<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-blue-400"></span>`;
                        tooltipTxt = `<i class="fa-solid fa-star mr-1 text-blue-300"></i>${holiday}`;
                    }

                    if (hasAppts && !isUnavail) {
                        if (isFull) {
                            dotHtml =
                                `<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-red-500"></span>`;
                            tooltipTxt =
                                `<i class="fa-solid fa-circle-xmark mr-1 text-red-400"></i>Fully booked — ${count} patients`;
                        } else {
                            dotHtml =
                                `<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full ${isToday ? 'bg-white' : 'bg-[#8B0000]'}"></span>`;
                            tooltipTxt =
                                `<i class="fa-solid fa-user-clock mr-1 text-yellow-300"></i>${count} patient${count > 1 ? 's' : ''} scheduled`;
                        }
                        const pillColor = isFull ? 'bg-red-500 text-white' : (isToday ? 'bg-white text-[#8B0000]' :
                            'bg-[#8B0000] text-white');
                        badgeHtml =
                            `<span class="absolute -top-1.5 -right-1.5 text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center ${pillColor} shadow">${count}</span>`;
                    }

                    if (isUnavail && !holiday && !hasAppts) {
                        tooltipTxt = weekend ?
                            `<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Clinic closed` :
                            `<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Not available`;
                    }

                    let bgClass = '',
                        textClass = 'text-[#333]',
                        ringClass = '',
                        cursor = 'cursor-default';

                    if (isToday) {
                        bgClass = 'bg-[#8B0000]';
                        textClass = 'text-white font-extrabold';
                        ringClass = 'ring-2 ring-[#8B0000]/30 ring-offset-1';
                    } else if (holiday) {
                        bgClass = 'bg-blue-50 hover:bg-blue-100';
                        textClass = 'text-blue-700 font-semibold';
                    } else if (isFull) {
                        bgClass = 'bg-red-50 hover:bg-red-100';
                        textClass = 'text-red-600 font-semibold';
                        cursor = 'cursor-pointer';
                    } else if (hasAppts) {
                        bgClass = 'bg-[#FFF5F5] hover:bg-[#FFE8E8]';
                        textClass = 'text-[#8B0000] font-semibold';
                        cursor = 'cursor-pointer';
                    } else if (isUnavail) {
                        textClass = 'text-gray-300';
                    } else {
                        bgClass = 'hover:bg-gray-100';
                    }

                    const tooltipHtml = tooltipTxt ?
                        `<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 z-50 bg-[#1a1a1a] text-white text-[11px] font-medium px-3 py-1.5 rounded-lg whitespace-nowrap shadow-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200">${tooltipTxt}<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-[#1a1a1a]"></div></div>` :
                        '';

                    cells += `
                    <div class="relative group flex items-center justify-center">
                        ${tooltipHtml}
                        <div class="relative w-9 h-9 flex items-center justify-center text-sm rounded-full transition-all duration-150 ${bgClass} ${textClass} ${ringClass} ${cursor}">
                            ${d}${dotHtml}${badgeHtml}
                        </div>
                    </div>`;
                }

                const container = document.getElementById('dentistCalendarContainer');
                if (container) {
                    container.innerHTML = `
                    <div class="h-full flex flex-col select-none">
                        <div class="flex items-center justify-center gap-2 mb-3">
                            <i class="fa-regular fa-calendar-check text-[#8B0000] text-xl"></i>
                            <h2 class="text-lg font-extrabold text-[#333]">Clinic Appointment Schedule</h2>
                        </div>
                        <hr class="border-t border-gray-200 mb-2">
                        <div class="flex items-center justify-between my-4">
                            <button onclick="changeDentistMonth(-1)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-[#FFF0F0] text-[#8B0000] transition-colors">
                                <i class="fa-solid fa-chevron-left text-xs"></i>
                            </button>
                            <div class="text-center">
                                <p class="text-lg font-extrabold text-[#8B0000]">${monthNames[month]}</p>
                                <p class="text-xs text-[#9CA3AF] font-semibold tracking-widest">${year}</p>
                            </div>
                            <button onclick="changeDentistMonth(1)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-[#FFF0F0] text-[#8B0000] transition-colors">
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            </button>
                        </div>
                        <div class="grid grid-cols-7 gap-2 mb-2">${headerHtml}</div>
                        <div class="grid grid-cols-7 gap-2" style="row-gap:1.2rem;">${cells}</div>
                        <div class="mt-5 pt-3 border-t border-gray-200 flex flex-wrap items-center justify-center gap-x-4 gap-y-1.5">
                            <div class="flex items-center gap-1.5"><span class="w-4 h-4 rounded-full bg-[#8B0000] flex-shrink-0"></span><span class="text-[11px] text-[#555]">Today</span></div>
                            <div class="flex items-center gap-1.5"><span class="w-4 h-4 rounded-full bg-[#FFF5F5] border border-[#8B0000] flex-shrink-0"></span><span class="text-[11px] text-[#555]">Has Patients</span></div>
                            <div class="flex items-center gap-1.5"><span class="w-4 h-4 rounded-full bg-red-50 border border-red-400 flex-shrink-0"></span><span class="text-[11px] text-[#555]">Fully Booked</span></div>
                            <div class="flex items-center gap-1.5"><span class="w-4 h-4 rounded-full bg-blue-50 border border-blue-400 flex-shrink-0"></span><span class="text-[11px] text-[#555]">Holiday</span></div>
                            <div class="flex items-center gap-1.5"><span class="text-gray-300 text-base font-bold leading-none">–</span><span class="text-[11px] text-[#555]">Unavailable</span></div>
                        </div>
                    </div>`;
                }
            }

            window.changeDentistMonth = function(dir) {
                currentMonth += dir;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                renderDentistCalendar(currentYear, currentMonth);
            };

            renderDentistCalendar(currentYear, currentMonth);
        }
    </script>
@endsection
