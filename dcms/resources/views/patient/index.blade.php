@extends('layouts.patient')

@section('title', 'Patient Dashboard | PUP Taguig Dental Clinic')

@section('styles')
<style>
    /* ── DESKTOP SIDEBAR LAYOUT ── */
    #mainContent {
        margin-left: 220px;
        transition: margin-left .3s ease;
    }

    /* ── ANIMATIONS ── */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .fade-in { animation: fadeIn 0.6s ease-out forwards; }

    @keyframes softPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    .pulse-icon { animation: softPulse 2s ease-in-out infinite; }

    @keyframes shimmer {
        0% { background-position: -400px 0; }
        100% { background-position: 400px 0; }
    }
    .skeleton {
        background: linear-gradient(90deg, #e5e7eb 25%, #f3f4f6 37%, #e5e7eb 63%);
        background-size: 800px 100%;
        animation: shimmer 1.4s infinite linear;
        border-radius: 0.75rem;
    }

    @keyframes fadeUp {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp 0.6s ease-out forwards; }

    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-14px) rotate(2deg); }
    }
    .float-slow {
        animation: float 4.5s ease-in-out infinite;
        will-change: transform;
    }

    @keyframes shimmerBtn {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    .shimmer-btn {
        background: linear-gradient(110deg, #660000 25%, rgba(255, 80, 80, .87) 37%, #660000 63%);
        background-size: 200% 100%;
        animation: shimmerBtn 10s linear infinite;
    }

    @keyframes wave {
        0% { transform: rotate(0); }
        20% { transform: rotate(14deg); }
        40% { transform: rotate(-8deg); }
        60% { transform: rotate(14deg); }
        80% { transform: rotate(-4deg); }
        100% { transform: rotate(0); }
    }
    .wave-hand {
        transform-origin: 70% 70%;
        animation: wave 2.5s ease-in-out infinite;
    }

    @keyframes spinSlow {
        from { transform: rotate(0); }
        to { transform: rotate(360deg); }
    }

    @keyframes floatMoon {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-3px); }
    }

    @keyframes driftCloud {
        0%, 100% { transform: translateX(0); }
        50% { transform: translateX(3px); }
    }

    .greet-spin { animation: spinSlow 8s linear infinite; display: inline-block; }
    .greet-float { animation: floatMoon 3s ease-in-out infinite; display: inline-block; }
    .greet-drift { animation: driftCloud 3s ease-in-out infinite; display: inline-block; }

    @media (max-width:640px) {
        .hero-tooth {
            width: 70px !important;
            opacity: .12;
        }
        .hero-text h1 {
            font-size: 1.15rem !important;
            white-space: nowrap;
        }
        .hero-text h2 {
            font-size: .75rem !important;
            margin-top: 4px !important;
            margin-bottom: 12px !important;
        }
    }
</style>
@endsection

@section('content')
    @php
        $notifications = collect($notifications ?? []);
        $notifCount = $notifications->count();
        $homeRecords = ($records ?? collect())
            ->filter(function ($r) {
                return strtolower($r->status ?? '') === 'completed';
            })
            ->map(function ($r) {
                return [
                    'service' => $r->service_type,
                    // Fixed: Using absolute \Carbon\Carbon namespace
                    'date' => $r->appointment_date ? \Carbon\Carbon::parse($r->appointment_date)->format('F d, Y') : '',
                    'time' => $r->appointment_time ?? '',
                    'status' => 'completed',
                    'duration' => $r->duration ?? '',
                    'remarks' => $r->remarks ?? '',
                    'oral' => $r->oral_examination ?? '',
                    'diagnosis' => $r->diagnosis ?? '',
                    'prescription' => $r->prescription ?? '',
                ];
            })
            ->values();

        $calendarAppointments = [];
        foreach ($appointments ?? collect() as $appt) {
            // Fixed: Using absolute \Carbon\Carbon namespace
            $calendarAppointments[\Carbon\Carbon::parse($appt->appointment_date)->format('Y-m-d')] =
            $appt->service_type . ' • ' . $appt->appointment_time;
        }
    @endphp

    </div>

    <main id="mainContent" class="pt-[100px] px-4 sm:px-6 py-6 fade-up min-h-screen">
        <div class="mx-auto">

            {{-- Impersonation banner --}}
            @if(session('impersonated_role') === 'patient' && session('impersonator_role') === 'super_admin')
                <div style="background:#FEF3C7;border:1px solid #FCD34D;color:#92400E;padding:14px 18px;margin-bottom:16px;border-radius:12px;display:flex;justify-content:space-between;align-items:center;gap:12px;">
                    <div>
                        <strong>You are viewing as Patient</strong><br>
                        <span style="font-size:13px;">Super Admin impersonation mode is active.</span>
                    </div>
                    <form method="POST" action="{{ route('admin.stop_impersonation') }}">
                        @csrf
                        <button type="submit" style="background:#8B0000;color:#fff;border:none;padding:10px 16px;border-radius:8px;font-weight:700;cursor:pointer;">Return to Admin</button>
                    </form>
                </div>
            @endif

            <div class="bg-gradient-to-r from-[#8B0000] to-[#660000] text-[#F4F4F4] rounded-2xl p-4 sm:p-10 flex justify-between items-center mb-6 fade-up relative overflow-hidden">
                <div class="hero-text relative z-10 max-w-[60%] sm:max-w-[55%]">
                    <div class="flex items-center gap-1.5 mb-1">
                        <i class="fa-solid fa-sun text-yellow-400 text-sm greet-spin" id="greetingIcon"></i>
                        <p class="text-sm sm:text-base text-[#F4F4F4]" id="greetingText">Good morning</p>
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold mt-1 mb-2 text-[#F4F4F4] fade-up">
                        <span class="bg-gradient-to-r from-[#F4F4F4] to-[#FFD700] bg-clip-text text-transparent">
                            Welcome, {{ ucwords(strtolower($patient->name ?? 'Guest')) }}!
                        </span>
                        <i class="fa-solid fa-hand text-[#FFD700] wave-hand"></i>
                    </h1>
                    <h2 class="text-xs sm:text-base font-normal mt-2 sm:mt-4 mb-4 sm:mb-6 text-[#F4F4F4] fade-up">
                        Healthy teeth start with one appointment.
                    </h2>
                    <a href="{{ route('patient.book.appointment') }}" class="flex items-center gap-2 whitespace-nowrap">
                        <button class="btn btn-soft shimmer-btn px-3 sm:px-6 py-1.5 sm:py-3 rounded-xl sm:rounded-2xl border-none text-xs sm:text-base font-semibold text-[#F4F4F4] transition-transform duration-500 hover:-translate-y-2 hover:shadow-[0_0_10px_rgba(255,255,255,0.4)]">
                            <i class="fa-solid fa-calendar-plus"></i> Book Appointment
                        </button>
                    </a>
                </div>
                <div class="absolute right-4 sm:right-7 top-1/2 -translate-y-1/2 pointer-events-none">
                    <img src="{{ asset('images/home-tooth.png') }}" alt="Tooth"
                        class="hero-tooth float-slow w-[120px] sm:w-[250px] max-w-none drop-shadow-[0_14px_26px_rgba(255,255,255,0.25)] opacity-30 sm:opacity-100" />
                </div>
            </div>

            <div class="mb-6 fade-up">
                <div id="upcomingAppointmentWrapper">
                    <div class="rounded-2xl overflow-hidden border border-[#EDE8E4] shadow-sm animate-pulse">
                        <div class="flex items-center justify-between gap-3 px-5 py-3" style="background:linear-gradient(135deg,#5A0000,#8B0000);">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-xl bg-white/15 flex-shrink-0"></div>
                                <div class="h-4 w-40 bg-white/25 rounded-lg"></div>
                            </div>
                            <div class="h-6 w-20 bg-white/20 rounded-full"></div>
                        </div>
                        <div class="bg-white px-5 py-4">
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <div><div class="h-2 w-16 bg-gray-200 rounded mb-2"></div><div class="h-4 w-full bg-gray-200 rounded"></div></div>
                                <div><div class="h-2 w-24 bg-gray-200 rounded mb-2"></div><div class="h-4 w-full bg-gray-200 rounded"></div></div>
                                <div><div class="h-2 w-16 bg-gray-200 rounded mb-2"></div><div class="h-4 w-full bg-gray-200 rounded"></div></div>
                            </div>
                            <div class="mt-3 pt-3 border-t border-gray-100 flex justify-end">
                                <div class="h-3 w-20 bg-gray-200 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="max-w-7xl mx-auto mb-10">
                <div class="flex flex-col md:flex-row gap-6">

                    <div class="md:w-[600px] flex-shrink-0 flex flex-col gap-5">
                        <div id="profileSkeletonContainer" class="rounded-2xl overflow-hidden shadow-lg">
                            <div class="bg-white rounded-2xl overflow-hidden shadow-sm animate-pulse">
                                <div class="bg-gray-200 h-24 w-full"></div>
                                <div class="p-4 space-y-3">
                                    <div class="flex gap-4"><div class="h-3 w-24 skeleton"></div><div class="h-3 w-40 skeleton"></div></div>
                                    <div class="flex gap-4"><div class="h-3 w-24 skeleton"></div><div class="h-3 w-40 skeleton"></div></div>
                                    <div class="flex gap-4"><div class="h-3 w-24 skeleton"></div><div class="h-3 w-40 skeleton"></div></div>
                                    <div class="flex gap-4"><div class="h-3 w-24 skeleton"></div><div class="h-3 w-40 skeleton"></div></div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-lg p-5">
                            <div id="requestDocsContainer">
                                <div class="flex items-center gap-3 border rounded-xl p-3 animate-pulse mb-3">
                                    <div class="w-10 h-10 skeleton rounded-lg flex-shrink-0"></div>
                                    <div class="flex-1 space-y-2"><div class="h-3 w-36 skeleton"></div><div class="h-2 w-48 skeleton"></div></div>
                                </div>
                                <div class="flex items-center gap-3 border rounded-xl p-3 animate-pulse">
                                    <div class="w-10 h-10 skeleton rounded-lg flex-shrink-0"></div>
                                    <div class="flex-1 space-y-2"><div class="h-3 w-36 skeleton"></div><div class="h-2 w-48 skeleton"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 flex flex-col gap-2">
                        <div id="calendarSkeletonContainer" class="bg-white border shadow-sm rounded-2xl p-4 sm:p-6 w-full" style="min-height:500px;">
                            <div class="animate-pulse space-y-4">
                                <div class="h-6 w-32 bg-gray-200 rounded mx-auto"></div>
                                <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:8px;">
                                    @for ($i = 0; $i < 35; $i++) 
                                        <div class="h-9 bg-gray-200 rounded-lg"></div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <div class="mb-8 fade-up">
                <div class="relative overflow-hidden rounded-[20px] px-7 pt-7 pb-14 -mb-8" style="background:linear-gradient(135deg,#5A0000 0%,#8B0000 60%,#b5282a 100%);">
                    <div class="absolute inset-0" style="background:url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.04\'%3E%3Ccircle cx=\'30\' cy=\'30\' r=\'20\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                    <p class="relative z-10 text-[10px] font-bold tracking-[.15em] uppercase text-white/55 mb-1.5">Patient Portal</p>
                    <h2 class="relative z-10 text-[28px] font-extrabold text-white leading-tight">Dental Records</h2>
                    <p class="relative z-10 text-[13px] text-white/65 mt-1.5">A complete history of your dental visits and treatments.</p>
                    <div class="relative z-10 flex flex-wrap gap-3 mt-4">
                        <div id="recordsStatVisits" class="flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-semibold text-white/90" style="background:rgba(255,255,255,.13);border:1px solid rgba(255,255,255,.18);">
                            <i class="fa-solid fa-list text-[10px] opacity-70"></i>
                            <span id="recordsVisitCount">0 visits</span>
                        </div>
                        <div id="recordsStatLatest" class="hidden items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-semibold text-white/90" style="background:rgba(255,255,255,.13);border:1px solid rgba(255,255,255,.18);">
                            <i class="fa-regular fa-calendar text-[10px] opacity-70"></i>
                            <span id="recordsLatestDate"></span>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 bg-white rounded-[20px] border border-[#EDE8E4] p-5" style="box-shadow:0 4px 32px rgba(0,0,0,.06);">
                    <div id="viewAllContainer" class="hidden mb-5 pt-2">
                        <div class="flex items-center gap-3">
                            <span class="text-[9px] font-extrabold tracking-[.12em] uppercase text-[#9E9690] whitespace-nowrap">Visit History</span>
                            <div class="flex-1 h-px bg-[#EDE8E4]"></div>
                            <a href="{{ route('patient.record') }}" class="inline-flex items-center gap-1 text-[11px] font-bold text-[#8B0000] hover:text-[#5A0000] whitespace-nowrap transition-colors">
                                View Full Record <i class="fa-solid fa-arrow-right text-[9px]"></i>
                            </a>
                        </div>
                    </div>

                    <div id="recordsInnerContainer">
                        <div class="space-y-3 animate-pulse">
                            <div class="flex items-center gap-4 border rounded-xl p-4">
                                <div class="w-3 h-3 rounded-full bg-gray-200 flex-shrink-0"></div>
                                <div class="flex-1 space-y-2"><div class="h-4 w-40 skeleton"></div><div class="h-3 w-56 skeleton"></div></div>
                                <div class="h-8 w-20 skeleton rounded-lg"></div>
                            </div>
                            <div class="flex items-center gap-4 border rounded-xl p-4">
                                <div class="w-3 h-3 rounded-full bg-gray-200 flex-shrink-0"></div>
                                <div class="flex-1 space-y-2"><div class="h-4 w-36 skeleton"></div><div class="h-3 w-48 skeleton"></div></div>
                                <div class="h-8 w-20 skeleton rounded-lg"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <dialog id="record_modal" class="modal">
                <div class="modal-box p-0 w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-xl bg-[#F3F3F3]">
                    <div class="bg-gradient-to-r from-[#5A0000] to-[#8B0000] px-6 sm:px-8 py-5 sm:py-6 text-white">
                        <h3 id="m_service" class="text-2xl sm:text-3xl font-extrabold leading-tight">—</h3>
                        <div class="mt-2 flex items-center gap-3 text-white/95">
                            <i class="fa-regular fa-calendar"></i>
                            <p class="text-sm sm:text-base font-medium">
                                <span id="m_date">—</span><span class="mx-2">·</span><span id="m_time">—</span>
                            </p>
                        </div>
                    </div>
                    <div class="px-6 sm:px-8 py-6 sm:py-8 space-y-6 sm:space-y-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <div class="bg-white border border-gray-200 rounded-xl px-4 py-3 min-h-[90px] flex flex-col justify-center">
                                <div class="flex items-center gap-2 text-xs font-bold tracking-widest text-black-600">
                                    <span class="flex items-center justify-center w-3 h-3 rounded-full bg-gray-800"><i class="fa-solid fa-check text-white text-[8px]"></i></span> STATUS
                                </div>
                                <div class="mt-3 ml-4"><span id="m_status" class="inline-flex items-center justify-center w-32 px-4 py-1 text-sm leading-none rounded-full font-semibold bg-gray-200 text-gray-800">—</span></div>
                            </div>
                            <div class="bg-white border border-gray-200 rounded-xl px-4 py-3 min-h-[90px] flex flex-col justify-center">
                                <div class="flex items-center gap-2 text-xs font-bold tracking-widest text-black-600">
                                    <span class="flex items-center justify-center w-3 h-3 rounded-full bg-gray-800"><i class="fa-solid fa-check text-white text-[8px]"></i></span> DURATION
                                </div>
                                <div class="mt-3 ml-4"><span id="m_duration" class="inline-flex items-center justify-center w-32 px-4 py-1 text-sm leading-none rounded-full font-semibold bg-gray-200 text-gray-800">—</span></div>
                            </div>
                        </div>
                        @foreach ([['TREATMENT', 'm_remarks'], ['ORAL EXAMINATION', 'm_oral'], ['DIAGNOSIS', 'm_diagnosis'], ['PRESCRIPTION', 'm_prescription']] as [$label, $mid])
                            <div>
                                <div class="flex items-center gap-4 mb-3">
                                    <span class="text-xs font-extrabold tracking-widest text-[#8B0000]">{{ $label }}</span>
                                    <div class="h-px flex-1 bg-gray-300"></div>
                                </div>
                                <div class="bg-white rounded-md overflow-hidden">
                                    <div class="grid grid-cols-[6px_1fr]">
                                        <div class="bg-gray-300"></div>
                                        <div class="p-4 sm:p-6 text-gray-700 text-sm leading-relaxed"><span id="{{ $mid }}">—</span></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="flex justify-end pt-2">
                            <form method="dialog">
                                <button class="px-8 py-2 rounded-lg bg-gray-200 text-gray-800 font-semibold hover:bg-gray-300 transition">Close</button>
                            </form>
                        </div>
                    </div>
                </div>
                <form method="dialog" class="modal-backdrop"><button>close</button></form>
            </dialog>

            <dialog id="dentalClearanceModal" class="modal">
                <form id="clearanceRequestForm" method="POST" action="{{ route('patient.document.requests.store') }}" class="modal-box rounded-2xl bg-[#F4F4F4] relative" novalidate>
                    @csrf
                    <div id="clearanceWarning" class="hidden absolute top-4 left-1/2 -translate-x-1/2 px-4 py-1.5 rounded-full bg-red-600 text-[#F4F4F4] text-xs font-semibold shadow-lg">Please complete all required fields</div>
                    <h3 class="font-extrabold text-2xl text-[#8B0000] mb-3">Request Clearance</h3>
                    <p class="text-sm text-[#333333] mb-5">Please allow up to three (3) working days for processing.</p>
                    <div class="mb-5">
                        <label class="block text-sm font-bold text-[#8B0000] mb-1">Type of Clearance</label>
                        <select name="document_type" required class="select select-bordered w-full rounded-xl bg-[#F4F4F4] text-[#333333] focus:outline-none focus:ring-0 focus:border-[#8B0000]">
                            <option value="" disabled selected>Select type of clearance</option>
                            <option value="Dental Clearance">Dental Clearance</option>
                            <option value="Annual Dental Clearance">Annual Dental Clearance</option>
                        </select>
                    </div>
                    <div class="mb-5">
                        <label class="block text-sm font-bold text-[#8B0000] mb-1">Purpose</label>
                        <select name="purpose" required class="select select-bordered w-full rounded-xl bg-[#F4F4F4] text-[#333333] focus:outline-none focus:ring-0 focus:border-[#8B0000]">
                            <option value="" disabled selected>Select purpose</option>
                            <option value="On-the-Job Training (OJT)">On-the-Job Training (OJT)</option>
                            <option value="Employment Requirement">Employment Requirement</option>
                            <option value="Academic Requirement">Academic Requirement</option>
                        </select>
                    </div>
                    <div class="modal-action flex justify-between">
                        <button type="button" onclick="dentalClearanceModal.close()" class="px-6 py-2 rounded-xl bg-gray-200 text-gray-700 font-semibold">Back</button>
                        <button type="submit" class="px-6 py-2 rounded-xl bg-[#8B0000] text-[#F4F4F4] font-semibold">Save</button>
                    </div>
                </form>
            </dialog>

            <dialog id="dentalHealthRecordModal" class="modal">
                <form id="healthRecordRequestForm" method="POST" action="{{ route('patient.document.requests.store') }}" class="modal-box rounded-2xl bg-[#F4F4F4] relative" novalidate>
                    @csrf
                    <div id="healthRecordWarning" class="hidden absolute top-4 left-1/2 -translate-x-1/2 px-4 py-1.5 rounded-full bg-red-600 text-[#F4F4F4] text-xs font-semibold shadow-lg">Please complete all required fields</div>
                    <h3 class="font-extrabold text-2xl text-[#8B0000] mb-3">Request Dental Health Record</h3>
                    <p class="text-sm mb-5 text-[#333333]">Please allow up to three (3) working days for processing.</p>
                    <div class="mb-5">
                        <label class="block text-sm font-bold text-[#8B0000] mb-1">Type of Dental Health Record</label>
                        <select name="document_type" required class="select select-bordered w-full rounded-xl bg-[#F4F4F4] text-[#333333] focus:outline-none focus:ring-0 focus:border-[#8B0000]">
                            <option value="" disabled selected>Select type</option>
                            <option value="All Dental Records">All Dental Records</option>
                            <option value="Medical Records">Medical Records</option>
                            <option value="Diagnosis and Treatment">Diagnosis and Treatment</option>
                        </select>
                    </div>
                    <div class="mb-5">
                        <label class="block text-sm font-bold text-[#8B0000] mb-1">Purpose</label>
                        <select name="purpose" required class="select select-bordered w-full rounded-xl bg-[#F4F4F4] text-[#333333] focus:outline-none focus:ring-0 focus:border-[#8B0000]">
                            <option value="" disabled selected>Select purpose</option>
                            <option value="Personal Record">Personal Record</option>
                            <option value="Academic Requirement">Academic Requirement</option>
                            <option value="Employment Requirement">Employment Requirement</option>
                        </select>
                    </div>
                    <div class="modal-action flex justify-between">
                        <button type="button" onclick="dentalHealthRecordModal.close()" class="px-6 py-2 rounded-xl bg-gray-200 text-gray-700 font-semibold">Back</button>
                        <button type="submit" class="px-6 py-2 rounded-xl bg-[#8B0000] text-[#F4F4F4] font-semibold">Save</button>
                    </div>
                </form>
            </dialog>

            <dialog id="activeAppointmentModal" class="modal">
                <div class="modal-box swal-card rounded-2xl bg-white text-center shadow-2xl w-[min(92vw,420px)]">
                    <div class="mx-auto mb-4 w-16 h-16 rounded-full bg-[#FFF0F0] flex items-center justify-center">
                        <i class="fa-solid fa-calendar-xmark text-[#8B0000] text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-[#8B0000] mb-2">Active Appointment Detected</h3>
                    <p class="text-sm text-gray-600 mb-6">You already have an active appointment. Please complete or cancel it before booking a new one.</p>
                    <div class="modal-action justify-center gap-3">
                        <a href="{{ route('patient.appointment.index') }}" class="btn bg-[#8B0000] text-[#F4F4F4] hover:bg-[#7A0000] transition-colors duration-200">View My Appointments</a>
                        <button id="closeActiveApptModalBtn" type="button" class="btn btn-ghost">Close</button>
                    </div>
                </div>
            </dialog>

        </div>
    </main>
@endsection

@section('scripts')

    <script>
        const calendarData = {{ Illuminate\Support\Js::from([
            'appointments' => $calendarAppointments ?? [],
            'counts' => $appointmentCountsPerDay ?? [],
            'unavailableDates' => $unavailableDates ?? [],
            'holidays' => $philippineHolidays ?? [],
        ]) }};
        const calendarAppointments = calendarData.appointments;
        const calendarCounts = calendarData.counts;
        const calendarUnavailableDates = calendarData.unavailableDates;
        const calendarHolidays = calendarData.holidays;

        var HOME_RECORDS = @json($homeRecords ?? []);

        @php
            $upcomingJs = null;
            if (isset($upcomingAppointment) && $upcomingAppointment) {
                // Fixed: Using absolute \Carbon\Carbon namespace here
                $uD = \Carbon\Carbon::parse($upcomingAppointment->appointment_date);
                $uT = \Carbon\Carbon::parse($upcomingAppointment->appointment_time);
                $upcomingJs = [
                    'exists' => true,
                    'service' => $upcomingAppointment->service_type ?? '—',
                    'date' => $uD->format('M d, Y'),
                    'time_raw' => $upcomingAppointment->appointment_time,
                    'time_fmt' => $uT->format('g:i A'),
                    'dentist' => $upcomingAppointment->dentist_name ?? 'Dr. Nelson P. Angeles',
                    'status' => ucfirst($upcomingAppointment->status),
                    'isRescheduled' => strtolower($upcomingAppointment->status) === 'rescheduled',
                    'indexUrl' => route('patient.appointment.index'),
                    'bookUrl' => route('patient.book.appointment'),
                ];
            } else {
                $upcomingJs = [
                    'exists' => false,
                    'bookUrl' => route('patient.book.appointment'),
                ];
            }

            $profileRows = [
                // Fixed: Using absolute \Carbon\Carbon namespace here
                ['Date of Birth', isset($patient->birthdate) ? \Carbon\Carbon::parse($patient->birthdate)->format('F d, Y') : '—'],
                ['Age', $patient->age ?? '—'],
                ['Gender', $patient->gender ?? '—'],
                ['Contact', $patient->phone ?? '—'],
                ['Email', $patient->email ?? '—']
            ];
        @endphp

        var UPCOMING_DATA = @json($upcomingJs);
        var PATIENT_NAME = "{{ urlencode($patient->name ?? 'Guest') }}";

        var PROFILE_DATA = {
            name: "{{ ucwords(strtolower($patient->name ?? 'Guest')) }}",
            patientId: "{{ $patient->patient_id ?? 'N/A' }}",
            rows: @json($profileRows),
            avatar: "{{ isset($patient->profile_image) && $patient->profile_image ? asset('storage/' . $patient->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($patient->name ?? 'Guest') . '&background=660000&color=FFFFFF&rounded=true&size=128' }}"
        };

        var ROUTE_BOOK = "{{ route('patient.book.appointment') }}";
        var ROUTE_RECORD = "{{ route('patient.record') }}";

        @if (session('activeAppointmentModal'))
            document.addEventListener("DOMContentLoaded", function () {
                var modal = document.getElementById("activeAppointmentModal");
                var closeBtn = document.getElementById("closeActiveApptModalBtn");
                if (!modal) return;
                modal.showModal();
                modal.addEventListener('click', function (e) {
                    var box = modal.querySelector('.modal-box');
                    if (box && !box.contains(e.target)) e.preventDefault();
                });
                modal.addEventListener('cancel', function (e) {
                    e.preventDefault();
                });
                if (closeBtn) closeBtn.addEventListener("click", function () {
                    modal.close();
                });
            });
        @endif

        @if (session('login_as'))
            document.addEventListener('DOMContentLoaded', () => {
                showToast(
                    'Login Successful',
                    'Logged in successfully as <strong>{{ session('login_as') }}</strong>',
                    'success'
                );
            });
        @endif

        document.addEventListener('DOMContentLoaded', function () {
            const termsModal = document.getElementById('termsModal');
            const termsCheckbox = document.getElementById('termsCheckbox');
            const termsContinueBtn = document.getElementById('termsContinueBtn');

            if (termsCheckbox && termsContinueBtn) {
                termsCheckbox.checked = false;
                termsContinueBtn.disabled = true;

                termsCheckbox.addEventListener('change', function () {
                    termsContinueBtn.disabled = !this.checked;
                });
            }

            @if(session('show_terms_modal'))
                if (termsModal) {
                    termsModal.showModal();
                }
            @endif

            /* Layout */
            if (window.innerWidth >= 768) {
                applyLayout('220px');
            } else {
                document.getElementById('mainContent').style.marginLeft = '0';
            }

            /* Greeting */
            (function () {
                var h = new Date().getHours(), g, ic, an;
                if (h >= 6 && h < 12) {
                    g = 'Good morning';
                    ic = 'fa-solid fa-sun text-yellow-400 text-sm';
                    an = 'greet-spin';
                } else if (h >= 12 && h < 18) {
                    g = 'Good afternoon';
                    ic = 'fa-solid fa-cloud-sun text-yellow-300 text-sm';
                    an = 'greet-drift';
                } else {
                    g = 'Good evening';
                    ic = 'fa-solid fa-moon text-blue-300 text-sm';
                    an = 'greet-float';
                }
                var el = document.getElementById('greetingText'),
                    ico = document.getElementById('greetingIcon');
                if (el) el.textContent = g;
                if (ico) ico.className = ic + ' ' + an;
            })();

            /* ── Fire all renders with simulated 1s skeleton delay ── */
            setTimeout(function () {
                renderUpcomingAppointment();
                renderProfile();
                renderRequestDocs();
                renderRecords();
                loadCalendar();
            }, 1000);
        });

        function acceptTerms() {
            const termsModal = document.getElementById('termsModal');
            if (termsModal) {
                termsModal.close();
            }
        }

        /* TOAST */
        function showToast(title, message, type) {
            type = type || 'error';
            var container = document.getElementById('toastContainer');
            var t = document.createElement('div');
            t.className = 'toast ' + type;
            var icon = type === 'error' ?
                '<i class="fa-solid fa-circle-exclamation toast-icon"></i>' :
                '<i class="fa-solid fa-circle-check toast-icon"></i>';
            t.innerHTML = '<div class="toast-icon-wrap">' + icon + '</div>' +
                '<div class="toast-body"><div class="toast-title">' + title + '</div>' +
                '<div class="toast-msg">' + message + '</div></div>' +
                '<button class="toast-close" onclick="this.closest(\'.toast\').classList.add(\'hide\')">' +
                '<i class="fa-solid fa-xmark"></i></button>';
            container.appendChild(t);
            requestAnimationFrame(function () {
                requestAnimationFrame(function () {
                    t.classList.add('show');
                });
            });
            setTimeout(function () {
                t.classList.remove('show');
                t.classList.add('hide');
                setTimeout(function () {
                    t.remove();
                }, 400);
            }, 4500);
        }

        /* ══════════════════════════════════════
           HELPERS
        ══════════════════════════════════════ */
        function escapeHtml(str) {
            return String(str ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
        }

        function formatTime(raw) {
            if (!raw) return '—';
            raw = String(raw).trim();
            if (/[AaPp][Mm]$/.test(raw)) return raw;
            var m = raw.match(/^(\d{1,2}):(\d{2})/);
            if (!m) return raw;
            var h = parseInt(m[1], 10),
                mn = m[2],
                ampm = h >= 12 ? 'PM' : 'AM',
                hr = h % 12 || 12;
            return hr + ':' + mn + ' ' + ampm;
        }

        function shortDate(raw) {
            if (!raw) return '—';
            return String(raw).replace(
                /^(January|February|March|April|May|June|July|August|September|October|November|December)/,
                function (s) {
                    return s.slice(0, 3);
                });
        }

        /* Layout Helper */
        function applyLayout(w) {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            if(sidebar) sidebar.style.width = w;
            if(mainContent) mainContent.style.marginLeft = w;
        }

        /* ══════════════════════════════════════
           RENDER: UPCOMING APPOINTMENT
        ══════════════════════════════════════ */
        function renderUpcomingAppointment() {
            var wrapper = document.getElementById('upcomingAppointmentWrapper');
            if (!wrapper) return;
            var d = UPCOMING_DATA;

            if (d.exists) {
                var statusPillCls = d.isRescheduled ? 'bg-yellow-400/20 text-yellow-100' : 'bg-blue-500/20 text-blue-100';
                var statusDotCls = d.isRescheduled ? 'bg-yellow-300' : 'bg-blue-400';

                wrapper.innerHTML =
                    '<div class="rounded-2xl overflow-hidden border border-[#EDE8E4] shadow-sm fade-up">' +
                    '<div class="flex items-center justify-between gap-3 px-5 py-3" style="background:linear-gradient(135deg,#5A0000,#8B0000);">' +
                    '<div class="flex items-center gap-2.5">' +
                    '<div class="w-8 h-8 rounded-xl bg-white/15 flex items-center justify-center flex-shrink-0">' +
                    '<i class="fa-regular fa-calendar-check text-white text-sm"></i></div>' +
                    '<span class="text-white font-bold text-sm">Upcoming Appointment</span></div>' +
                    '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold flex-shrink-0 ' + statusPillCls + '">' +
                    '<span class="w-1.5 h-1.5 rounded-full flex-shrink-0 ' + statusDotCls + '"></span>' + escapeHtml(d.status) + '</span></div>' +
                    '<div class="bg-white px-5 py-4">' +
                    '<div class="grid grid-cols-2 sm:grid-cols-3 gap-3">' +
                    '<div><p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-1">Service</p><p class="text-sm font-bold text-[#8B0000]">' + escapeHtml(d.service) + '</p></div>' +
                    '<div><p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-1">Date &amp; Time</p><p class="text-sm font-bold text-[#1C1410]">' + escapeHtml(d.date) + '<span class="text-[#8B0000] mx-0.5">·</span>' + escapeHtml(d.time_fmt) + '</p></div>' +
                    '<div><p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-1">Dentist</p><p class="text-sm font-bold text-[#1C1410]">' + escapeHtml(d.dentist) + '</p></div>' +
                    '</div>' +
                    '<div class="mt-3 pt-3 border-t border-gray-100 flex justify-end">' +
                    '<a href="' + escapeHtml(d.indexUrl) + '" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#8B0000] hover:text-[#660000] transition-colors">View details <i class="fa-solid fa-arrow-right text-[10px]"></i></a>' +
                    '</div></div></div>';
            } else {
                wrapper.innerHTML =
                    '<div class="rounded-2xl overflow-hidden border border-[#EDE8E4] shadow-sm fade-up">' +
                    '<div class="flex items-center gap-2.5 px-5 py-3" style="background:linear-gradient(135deg,#5A0000,#8B0000);">' +
                    '<div class="w-8 h-8 rounded-xl bg-white/15 flex items-center justify-center flex-shrink-0">' +
                    '<i class="fa-regular fa-calendar text-white text-sm"></i></div>' +
                    '<span class="text-white font-bold text-sm">No Upcoming Appointment</span></div>' +
                    '<div class="bg-white px-5 py-4 flex items-center justify-between gap-3 flex-wrap">' +
                    '<p class="text-sm text-gray-500">Ready for your next visit? Book an appointment now.</p>' +
                    '<a href="' + escapeHtml(d.bookUrl) + '" class="inline-flex items-center gap-1.5 bg-[#8B0000] text-white text-xs font-semibold px-4 py-2 rounded-xl hover:bg-[#660000] transition-colors flex-shrink-0"><i class="fa-solid fa-calendar-plus text-xs"></i> Book Now</a>' +
                    '</div></div>';
            }
        }

        /* ── PROFILE ── */
        function renderProfile() {
            var pData = PROFILE_DATA;
            document.getElementById("profileSkeletonContainer").innerHTML =
                '<div class="bg-white rounded-2xl overflow-hidden shadow-sm fade-up">' +
                '<div class="bg-gradient-to-r from-[#660000] to-[#8B0000] px-6 pt-6 pb-6 text-[#F4F4F4] flex items-center gap-4">' +
                '<div class="avatar flex-shrink-0"><div class="w-14 h-14 rounded-full overflow-hidden ring-1 ring-white/30">' +
                '<img src="' + escapeHtml(pData.avatar) + '" alt="Profile">' +
                '</div></div>' +
                '<div><p class="font-bold text-xl leading-tight">' + escapeHtml(pData.name) + '</p>' +
                '<p class="text-sm text-[#F4F4F4]/70 mb-2">Student</p>' +
                '<span class="inline-block bg-[#FFD700]/40 text-[#FFD700] border border-[#FFD700] text-xs font-extrabold px-2.5 py-0.5 rounded-full">' + escapeHtml(pData.patientId) + '</span>' +
                '</div></div>' +
                '<div class="mx-0 bg-white divide-y divide-gray-100 text-sm rounded-b-2xl overflow-hidden">' +
                pData.rows.map(function (row) {
                    return '<div class="flex px-4 py-3 gap-4">' +
                        '<span class="text-[#757575] uppercase text-[10px] font-semibold w-28 flex-shrink-0 pt-0.5">' + escapeHtml(row[0]) + '</span>' +
                        '<span class="font-semibold text-[#333333]">' + escapeHtml(row[1]) + '</span></div>';
                }).join('') + '</div></div>';
        }

        /* ══════════════════════════════════════
           RENDER: REQUEST DOCS
        ══════════════════════════════════════ */
        function renderRequestDocs() {
            document.getElementById("requestDocsContainer").innerHTML =
                '<div class="flex items-center gap-4 mb-4">' +
                '<div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">' +
                '<i class="fa-solid fa-folder text-[#8B0000] text-lg"></i></div>' +
                '<h3 class="font-extrabold text-lg text-[#333333]">Request Documents</h3></div>' +
                '<a onclick="document.getElementById(\'dentalHealthRecordModal\')?.showModal()" ' +
                'class="flex items-center gap-3 border border-gray-300 rounded-xl p-3 hover:border-red-800 hover:shadow-lg transition cursor-pointer fade-up">' +
                '<div class="bg-[#8B0000] w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0">' +
                '<i class="fa-solid fa-file-medical text-white text-lg"></i></div>' +
                '<div><p class="font-bold text-sm text-[#333333]">Request Dental Health Record</p>' +
                '<p class="text-xs text-[#757575]">All Dental Records • Medical Record • Diagnosis &amp; Treatments</p></div></a>' +
                '<a onclick="document.getElementById(\'dentalClearanceModal\')?.showModal()" ' +
                'class="flex items-center gap-3 border border-gray-300 rounded-xl p-3 hover:border-red-800 hover:shadow-lg transition cursor-pointer fade-up mt-3">' +
                '<div class="bg-[#8B0000] w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0">' +
                '<i class="fa-solid fa-file-circle-check text-white text-lg"></i></div>' +
                '<div><p class="font-bold text-sm text-[#333333]">Request Dental Clearance</p>' +
                '<p class="text-xs text-[#757575]">Dental Clearance • Annual Dental Clearance</p></div></a>';
        }

        /* ══════════════════════════════════════
           RENDER: RECORDS
        ══════════════════════════════════════ */
        function renderRecords() {
            var container = document.getElementById("recordsInnerContainer");
            var viewAll = document.getElementById("viewAllContainer");
            var visitCount = document.getElementById("recordsVisitCount");
            var statLatest = document.getElementById("recordsStatLatest");
            var latestDate = document.getElementById("recordsLatestDate");
            if (!container) return;

            if (!HOME_RECORDS || HOME_RECORDS.length === 0) {
                if (visitCount) visitCount.textContent = "0 visits";
                container.innerHTML =
                    '<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px 20px;text-align:center;">' +
                    '<div style="width:72px;height:72px;border-radius:20px;background:#FDF1F1;border:1.5px solid rgba(139,0,0,.12);display:flex;align-items:center;justify-content:center;margin-bottom:16px;">' +
                    '<i class="fa-solid fa-tooth" style="font-size:28px;color:#8B0000;opacity:.4;"></i></div>' +
                    '<p style="font-size:20px;font-weight:700;color:#1C1410;margin-bottom:6px;">No records yet</p>' +
                    '<p style="font-size:13px;color:#9E9690;max-width:260px;line-height:1.6;">Completed appointment records will appear here after your first dental visit.</p>' +
                    '<a href="' + ROUTE_BOOK +
                    '" style="margin-top:24px;display:inline-flex;align-items:center;gap:8px;padding:10px 24px;border-radius:50px;background:#8B0000;color:white;font-size:13px;font-weight:600;text-decoration:none;box-shadow:0 2px 12px rgba(139,0,0,.3);">' +
                    '<i class="fa-solid fa-calendar-plus" style="font-size:11px;"></i> Book Appointment</a>' +
                    '</div>';
                if (viewAll) viewAll.style.display = "none";
                return;
            }

            var count = HOME_RECORDS.length;
            if (visitCount) visitCount.textContent = count + (count === 1 ? " visit" : " visits");
            if (statLatest && latestDate && HOME_RECORDS[0].date) {
                var pts = HOME_RECORDS[0].date.split(" ");
                latestDate.textContent = "Latest: " + (pts[0] ? pts[0].slice(0, 3) : "") + " " + (pts[2] || "");
                statLatest.style.display = "flex";
            }

            if (viewAll) {
                viewAll.style.display = "block";
                viewAll.classList.remove("hidden");
            }

            var html = '<div>';
            HOME_RECORDS.forEach(function (r, idx) {
                var encoded = encodeURIComponent(JSON.stringify(r));
                var dispTime = formatTime(r.time);
                var dispDate = shortDate(r.date);
                var isLast = idx === HOME_RECORDS.length - 1;

                html +=
                    '<div class="flex items-stretch">' +
                    '<div class="flex flex-col items-center w-8 flex-shrink-0 pt-4">' +
                    '<div class="w-[11px] h-[11px] rounded-full bg-[#8B0000] border-2 border-white flex-shrink-0 z-10" style="box-shadow:0 0 0 3px rgba(139,0,0,.18);"></div>' +
                    (isLast ? '<div class="flex-1"></div>' : '<div class="flex-1 w-px mt-1.5" style="background:linear-gradient(to bottom,rgba(139,0,0,.2),rgba(139,0,0,.04));"></div>') +
                    '</div>' +
                    '<div class="flex-1 min-w-0 pb-2.5">' +
                    '<div class="bg-white border border-[#EDE8E4] rounded-[14px] p-3.5 flex flex-wrap sm:flex-nowrap items-center justify-between gap-2.5 transition-all duration-200 hover:shadow-[0_6px_24px_rgba(139,0,0,.08)] hover:border-[rgba(139,0,0,.2)] hover:-translate-y-px">' +
                    '<div class="min-w-0 flex-1">' +
                    '<p class="text-[13.5px] font-bold text-[#8B0000] leading-snug mb-1.5">' + escapeHtml(r.service) + '</p>' +
                    '<div class="flex flex-wrap items-center gap-1.5">' +
                    '<span class="inline-flex items-center gap-1 bg-[#FDF1F1] text-[#8B0000] rounded-full px-2 py-0.5 text-[11px] font-semibold">' +
                    '<i class="fa-regular fa-calendar text-[9px] opacity-70"></i>' + escapeHtml(dispDate) + '</span>' +
                    '<span class="inline-flex items-center gap-1 bg-[#FDF1F1] text-[#8B0000] rounded-full px-2 py-0.5 text-[11px] font-semibold">' +
                    '<i class="fa-regular fa-clock text-[9px] opacity-70"></i>' + escapeHtml(dispTime) + '</span>' +
                    '</div></div>' +
                    '<button type="button" class="w-full sm:w-auto flex-shrink-0 inline-flex items-center justify-center gap-1.5 px-3.5 py-[7px] rounded-full bg-[#8B0000] hover:bg-[#5A0000] text-white text-xs font-semibold border-none cursor-pointer whitespace-nowrap transition-all duration-150 hover:-translate-y-px" style="box-shadow:0 2px 10px rgba(139,0,0,.28);" onclick="openRecordModalFromData(\'' + encoded + '\')">' +
                    '<i class="fa-regular fa-eye text-[11px]"></i> Details</button>' +
                    '</div></div></div>';
            });
            html += '</div>';
            container.innerHTML = html;
        }

        /* ══════════════════════════════════════
           RECORD MODAL
        ══════════════════════════════════════ */
        function openRecordModalFromData(encodedJson) {
            openRecordModal(JSON.parse(decodeURIComponent(encodedJson)));
        }

        function openRecordModal(data) {
            var modal = document.getElementById('record_modal');
            if (!modal) return;
            document.getElementById('m_service').textContent = data.service || '—';
            document.getElementById('m_date').textContent = data.date || '—';
            document.getElementById('m_time').textContent = formatTime(data.time);
            var BADGE = 'inline-flex items-center justify-center w-32 px-4 py-1 text-sm leading-none rounded-full font-semibold';
            var status = (data.status || 'completed').trim();
            var sEl = document.getElementById('m_status');
            sEl.textContent = status;
            sEl.className = BADGE;
            var s = status.toLowerCase();
            if (s === 'completed') sEl.classList.add('bg-emerald-200', 'text-emerald-900');
            else if (s === 'rescheduled') sEl.classList.add('bg-yellow-200', 'text-yellow-900');
            else if (s === 'cancelled') sEl.classList.add('bg-red-200', 'text-red-900');
            else sEl.classList.add('bg-gray-200', 'text-gray-800');
            var dEl = document.getElementById('m_duration');
            dEl.textContent = (data.duration || '—').trim() || '—';
            dEl.className = BADGE + ' bg-gray-200 text-gray-800';
            document.getElementById('m_remarks').textContent = (data.remarks || '').trim() || '—';
            document.getElementById('m_oral').textContent = (data.oral || '').trim() || '—';
            document.getElementById('m_diagnosis').textContent = (data.diagnosis || '').trim() || '—';
            document.getElementById('m_prescription').textContent = (data.prescription || '').trim() || '—';
            modal.showModal();
        }

        /* ══════════════════════════════════════
           CALENDAR
        ══════════════════════════════════════ */
        function loadCalendar() {
            var MAX_PER_DAY = 5;
            var myAppts = calendarAppointments || {};
            var apptCounts = calendarCounts || {};
            var unavail = calendarUnavailableDates || [];
            var holidays = calendarHolidays || {};
            var today = new Date();
            var curYear = today.getFullYear(), curMonth = today.getMonth();

            function pad(n) { return String(n).padStart(2, '0'); }

            function isWeekend(y, m, d) {
                var dow = new Date(y, m, d).getDay();
                return dow === 0 || dow === 6;
            }

            function getHolidaysForMonth(y, m) {
                var f = {};
                Object.keys(holidays).forEach(function (ds) {
                    var p = ds.split('-').map(Number);
                    if (p[0] === y && p[1] === m + 1) f[ds] = holidays[ds];
                });
                return f;
            }

            function renderCalendar(year, month) {
                var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                var dayLabels = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
                var firstDow = new Date(year, month, 1).getDay();
                var totalDays = new Date(year, month + 1, 0).getDate();
                var hl = getHolidaysForMonth(year, month);
                var cells = '';

                for (var i = 0; i < firstDow; i++) cells += '<div></div>';
                for (var d = 1; d <= totalDays; d++) {
                    var ds = year + '-' + pad(month + 1) + '-' + pad(d);
                    var isToday = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
                    var weekend = isWeekend(year, month, d);
                    var holiday = hl[ds] || null;
                    var myAppt = myAppts[ds] || null;
                    var count = apptCounts[ds] || 0;
                    var isFull = count >= MAX_PER_DAY;
                    var isUnavail = unavail.indexOf(ds) !== -1 || weekend;
                    var bgClass = '', textClass = 'text-[#333333]', ringClass = '', dotHtml = '', tooltipTxt = '';
                    if (isToday) {
                        bgClass = 'bg-[#8B0000]'; textClass = 'text-white font-extrabold'; ringClass = 'ring-2 ring-[#8B0000]/30 ring-offset-1';
                    } else if (holiday) {
                        bgClass = 'bg-blue-50 hover:bg-blue-100'; textClass = 'text-blue-700 font-semibold';
                    } else if (isUnavail) {
                        textClass = 'text-gray-300';
                    } else {
                        bgClass = 'hover:bg-[#FFF0F0]';
                    }
                    if (myAppt) {
                        dotHtml += '<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full ' + (isToday ? 'bg-white' : 'bg-[#008440]') + '"></span>';
                        tooltipTxt = '<i class="fa-regular fa-calendar-check mr-1 text-[#6EE7A0]"></i>' + myAppt;
                    }
                    if (isFull && !myAppt && !isUnavail && !holiday) {
                        dotHtml += '<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-red-500"></span>';
                        tooltipTxt = '<i class="fa-solid fa-circle-xmark mr-1 text-red-400"></i>Fully booked (' + count + ')';
                    }
                    if (holiday && !myAppt) {
                        dotHtml = '<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-blue-400"></span>';
                        tooltipTxt = '<i class="fa-solid fa-star mr-1 text-blue-300"></i>' + holiday;
                    }
                    if (isUnavail && !holiday && !myAppt) {
                        tooltipTxt = weekend ? '<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Clinic closed' : '<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Not available';
                    }
                    var tooltip = tooltipTxt ? '<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 z-50 bg-[#1a1a1a] text-white text-[11px] font-medium px-3 py-1.5 rounded-lg whitespace-nowrap shadow-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200">' + tooltipTxt + '<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-[#1a1a1a]"></div></div>' : '';
                    cells += '<div class="relative group flex items-center justify-center">' + tooltip + '<div class="relative w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center text-xs sm:text-sm rounded-full transition-all duration-150 ' + bgClass + ' ' + textClass + ' ' + ringClass + ' cursor-default">' + d + dotHtml + '</div></div>';
                }

                var headerHtml = dayLabels.map(function (l, i) {
                    return '<div class="text-center text-[9px] sm:text-[10px] font-bold ' + (i === 0 || i === 6 ? 'text-[#8B0000]/40' : 'text-[#333333]') + ' uppercase tracking-widest">' + l + '</div>';
                }).join('');

                document.getElementById("calendarSkeletonContainer").innerHTML =
                    '<div class="h-full flex flex-col select-none">' +
                    '<div class="flex items-center justify-center gap-2 mb-3"><i class="fa-regular fa-calendar-check text-[#333333] text-lg sm:text-xl"></i><h2 class="text-lg sm:text-xl font-extrabold text-[#333333]">Dental Clinic Schedule</h2></div>' +
                    '<hr class="border-t border-gray-200 mb-3 sm:mb-4">' +
                    '<div class="flex items-center justify-between mt-4 sm:mt-6 mb-4 sm:mb-5">' +
                    '<button onclick="changeMonth(-1)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-[#FFF0F0] text-[#8B0000] transition-colors duration-150"><i class="fa-solid fa-chevron-left text-xs"></i></button>' +
                    '<div class="text-center"><p class="text-base sm:text-lg font-extrabold text-[#8B0000]">' + monthNames[month] + '</p><p class="text-xs text-[#9CA3AF] font-semibold tracking-widest">' + year + '</p></div>' +
                    '<button onclick="changeMonth(1)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-[#FFF0F0] text-[#8B0000] transition-colors duration-150"><i class="fa-solid fa-chevron-right text-xs"></i></button></div>' +
                    '<div class="grid grid-cols-7 gap-1 sm:gap-2 mt-2 sm:mt-4 mb-2">' + headerHtml + '</div>' +
                    '<div class="grid grid-cols-7 gap-1 sm:gap-2 flex-1 content-start">' + cells + '</div>' +
                    '<div class="flex flex-wrap items-center justify-center gap-2 mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-100">' +
                    '<div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-600 font-medium px-2.5 py-1 rounded-full border border-gray-200 bg-gray-50"><span class="w-2 h-2 rounded-full bg-[#008440] inline-block flex-shrink-0"></span>My Appointment</div>' +
                    '<div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-600 font-medium px-2.5 py-1 rounded-full border border-gray-200 bg-gray-50"><span class="w-2 h-2 rounded-full bg-blue-400 inline-block flex-shrink-0"></span>Holiday</div>' +
                    '<div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-600 font-medium px-2.5 py-1 rounded-full border border-gray-200 bg-gray-50"><span class="w-2 h-2 rounded-full bg-red-500 inline-block flex-shrink-0"></span>Full Schedule</div>' +
                    '<div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-600 font-medium px-2.5 py-1 rounded-full border border-gray-200 bg-gray-50"><span class="w-2 h-2 rounded-full bg-[#8B0000] inline-block flex-shrink-0"></span>Today</div>' +
                    '</div></div>';
            }

            window.changeMonth = function (dir) {
                curMonth += dir;
                if (curMonth > 11) { curMonth = 0; curYear++; }
                if (curMonth < 0) { curMonth = 11; curYear--; }
                renderCalendar(curYear, curMonth);
            };
            renderCalendar(curYear, curMonth);
        }
    </script>
@endsection