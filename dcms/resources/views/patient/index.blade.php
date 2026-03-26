@extends('layouts.patient')

@section('title', 'Patient Dashboard | PUP Taguig Dental Clinic')

@section('styles')
<style>
    /* ── RESPONSIVE SIDEBAR LAYOUT ── */
    @media (max-width: 767px) {
        #mainContent {
            margin-left: 0 !important;
            padding-bottom: 100px;
        }
    }

    /* ── ANIMATIONS ── */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(6px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeIn 0.6s ease-out forwards;
    }

    @keyframes softPulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    .pulse-icon {
        animation: softPulse 2s ease-in-out infinite;
    }

    @keyframes shimmer {
        0% {
            background-position: -400px 0;
        }

        100% {
            background-position: 400px 0;
        }
    }

    .skeleton {
        background: linear-gradient(90deg, #e5e7eb 25%, #f3f4f6 37%, #e5e7eb 63%);
        background-size: 800px 100%;
        animation: shimmer 1.4s infinite linear;
        border-radius: 0.75rem;
    }

    @keyframes fadeUp {
        0% {
            opacity: 0;
            transform: translateY(10px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-up {
        animation: fadeUp 0.6s ease-out forwards;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0) rotate(0deg);
        }

        50% {
            transform: translateY(-14px) rotate(2deg);
        }
    }

    .float-slow {
        animation: float 4.5s ease-in-out infinite;
        will-change: transform;
    }

    @keyframes shimmerBtn {
        0% {
            background-position: -200% 0;
        }

        100% {
            background-position: 200% 0;
        }
    }

    .shimmer-btn {
        background: linear-gradient(110deg, #660000 25%, rgba(255, 80, 80, .87) 37%, #660000 63%);
        background-size: 200% 100%;
        animation: shimmerBtn 10s linear infinite;
    }

    @keyframes wave {
        0% {
            transform: rotate(0);
        }

        20% {
            transform: rotate(14deg);
        }

        40% {
            transform: rotate(-8deg);
        }

        60% {
            transform: rotate(14deg);
        }

        80% {
            transform: rotate(-4deg);
        }

        100% {
            transform: rotate(0);
        }
    }

    .wave-hand {
        transform-origin: 70% 70%;
        animation: wave 2.5s ease-in-out infinite;
    }

    @keyframes spinSlow {
        from {
            transform: rotate(0);
        }

        to {
            transform: rotate(360deg);
        }
    }

    @keyframes floatMoon {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-3px);
        }
    }

    @keyframes driftCloud {

        0%,
        100% {
            transform: translateX(0);
        }

        50% {
            transform: translateX(3px);
        }
    }

    .greet-spin {
        animation: spinSlow 8s linear infinite;
        display: inline-block;
    }

    .greet-float {
        animation: floatMoon 3s ease-in-out infinite;
        display: inline-block;
    }

    .greet-drift {
        animation: driftCloud 3s ease-in-out infinite;
        display: inline-block;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: transparent;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* ── MOBILE OPTIMIZATIONS ── */
    @media (max-width:640px) {
        .hero-tooth {
            width: 85px !important;
            opacity: .12;
            right: -8px !important;
        }

        .hero-text h1 {
            font-size: 1.45rem !important;
            line-height: 1.3 !important;
            white-space: normal !important;
            word-break: break-word;
            hyphens: auto;
        }

        .hero-text h2 {
            font-size: 0.82rem !important;
            margin-top: 6px !important;
            margin-bottom: 18px !important;
        }

        /* Leave room so text doesn't overlap the ghost tooth */
        .hero-text {
            width: 100% !important;
            padding-right: 75px;
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
$calendarAppointments[\Carbon\Carbon::parse($appt->appointment_date)->format('Y-m-d')] =
$appt->service_type . ' • ' . $appt->appointment_time;
}
@endphp

<main id="mainContent" class="pt-[72px] md:pt-[80px] px-4 sm:px-6 md:px-8 pb-6 fade-up min-h-screen bg-[#F4F4F4]">
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Impersonation banner --}}
        @if(session('impersonated_role') === 'patient' && session('impersonator_role') === 'super_admin')
        <div
            class="bg-amber-100 border border-amber-300 text-amber-900 px-5 py-4 rounded-xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shadow-sm">
            <div>
                <strong class="text-base">You are viewing as Patient</strong><br>
                <span class="text-sm opacity-80">Super Admin impersonation mode is active.</span>
            </div>
            <form method="POST" action="{{ route('admin.stop_impersonation') }}" class="w-full sm:w-auto">
                @csrf
                <button type="submit"
                    class="w-full sm:w-auto bg-[#8B0000] hover:bg-[#660000] text-white px-5 py-2.5 rounded-lg font-bold transition-colors shadow-md">Return
                    to Admin</button>
            </form>
        </div>
        @endif

        {{-- Hero Welcome Section --}}
        <div
            class="bg-gradient-to-br from-[#8B0000] via-[#7A0000] to-[#5A0000] rounded-[1.5rem] p-6 sm:p-10 flex flex-col md:flex-row justify-between items-start md:items-center relative overflow-hidden shadow-lg border border-white/10">
            <div
                class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.03\'%3E%3Ccircle cx=\'30\' cy=\'30\' r=\'20\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]">
            </div>

            {{-- Text Container with max-width to prevent overlapping the image --}}
            <div class="hero-text relative z-10 w-full lg:w-[65%]">
                <div
                    class="inline-flex items-center gap-2 bg-black/20 backdrop-blur-sm px-3 py-1.5 rounded-full mb-4 border border-white/10">
                    <i class="fa-solid fa-sun text-yellow-400 text-sm greet-spin" id="greetingIcon"></i>
                    <p class="text-xs sm:text-sm font-medium text-white/90" id="greetingText">Good morning</p>
                </div>

                <h1
                    class="text-2xl sm:text-3xl md:text-4xl font-extrabold mt-1 mb-2 text-white leading-tight break-words hyphens-auto">
                    Welcome,
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 to-yellow-500">
                        {{ ucwords(strtolower($patient->name ?? 'Guest')) }}!
                    </span>
                    <i class="fa-solid fa-hand text-yellow-400 wave-hand inline-block ml-1"></i>
                </h1>

                <h2 class="text-sm sm:text-base font-medium mt-2 mb-6 text-white/80 max-w-md">
                    Healthy teeth start with one appointment. Let's maintain that bright smile.
                </h2>

                <a href="{{ route('patient.book.appointment') }}" class="inline-block">
                    <button
                        class="shimmer-btn px-5 sm:px-6 py-3 rounded-xl border border-white/20 text-sm sm:text-base font-bold text-white transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-red-900/50 flex items-center gap-2">
                        <i class="fa-solid fa-calendar-plus"></i> Book Appointment
                    </button>
                </a>
            </div>

            {{-- Decorative Tooth Image --}}
            <div class="absolute right-[-10%] sm:right-4 top-1/2 -translate-y-1/2 pointer-events-none z-0">
                <img src="{{ asset('images/home-tooth.png') }}" alt="Tooth"
                    class="hero-tooth float-slow w-[120px] sm:w-[220px] md:w-[260px] drop-shadow-[0_20px_40px_rgba(0,0,0,0.4)] opacity-20 sm:opacity-90" />
            </div>
        </div>

        {{-- Upcoming Appointment --}}
        <div id="upcomingAppointmentWrapper">
            <div class="bg-white rounded-[1.25rem] border border-gray-200 shadow-sm animate-pulse overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gray-200"></div>
                        <div class="h-5 w-40 bg-gray-200 rounded-md"></div>
                    </div>
                    <div class="h-8 w-24 bg-gray-200 rounded-full hidden sm:block"></div>
                </div>
                <div class="px-6 py-5">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div>
                            <div class="h-3 w-20 bg-gray-200 rounded mb-3"></div>
                            <div class="h-5 w-full bg-gray-200 rounded"></div>
                        </div>
                        <div>
                            <div class="h-3 w-28 bg-gray-200 rounded mb-3"></div>
                            <div class="h-5 w-full bg-gray-200 rounded"></div>
                        </div>
                        <div>
                            <div class="h-3 w-20 bg-gray-200 rounded mb-3"></div>
                            <div class="h-5 w-full bg-gray-200 rounded"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Dashboard Layout (Using Fluid Tailwind Grid) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- Left Column (Profile & Docs) --}}
            <div class="lg:col-span-4 flex flex-col gap-6">

                {{-- Profile Card --}}
                <div id="profileSkeletonContainer"
                    class="bg-white rounded-[1.25rem] border border-gray-200 shadow-sm overflow-hidden">
                    <div class="animate-pulse">
                        <div class="bg-gray-200 h-28 w-full"></div>
                        <div class="p-5 space-y-4">
                            <div class="flex gap-4">
                                <div class="h-4 w-20 skeleton"></div>
                                <div class="h-4 w-full skeleton"></div>
                            </div>
                            <div class="flex gap-4">
                                <div class="h-4 w-20 skeleton"></div>
                                <div class="h-4 w-full skeleton"></div>
                            </div>
                            <div class="flex gap-4">
                                <div class="h-4 w-20 skeleton"></div>
                                <div class="h-4 w-full skeleton"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Request Docs --}}
                <div class="bg-white rounded-[1.25rem] border border-gray-200 shadow-sm p-5 sm:p-6">
                    <div id="requestDocsContainer">
                        <div class="flex items-center gap-4 border border-gray-100 rounded-xl p-4 animate-pulse mb-4">
                            <div class="w-12 h-12 skeleton rounded-xl flex-shrink-0"></div>
                            <div class="flex-1 space-y-3">
                                <div class="h-4 w-32 skeleton"></div>
                                <div class="h-3 w-full skeleton"></div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 border border-gray-100 rounded-xl p-4 animate-pulse">
                            <div class="w-12 h-12 skeleton rounded-xl flex-shrink-0"></div>
                            <div class="flex-1 space-y-3">
                                <div class="h-4 w-32 skeleton"></div>
                                <div class="h-3 w-full skeleton"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column (Calendar & Records) --}}
            <div class="lg:col-span-8 flex flex-col gap-6">

                {{-- Calendar Widget --}}
                <div id="calendarSkeletonContainer"
                    class="bg-white border border-gray-200 shadow-sm rounded-[1.25rem] p-5 sm:p-7 w-full min-h-[450px]">
                    <div class="animate-pulse space-y-6">
                        <div class="h-8 w-48 bg-gray-200 rounded-lg mx-auto"></div>
                        <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:10px;">
                            @for ($i = 0; $i < 35; $i++) <div class="h-10 sm:h-12 bg-gray-100 rounded-xl">
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Dental Records --}}
            <div class="relative mt-2">
                {{-- Header Banner --}}
                <div
                    class="bg-gradient-to-r from-[#5A0000] to-[#8B0000] rounded-t-[1.25rem] px-6 py-6 pb-12 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-y-1/2 translate-x-1/3">
                    </div>
                    <p class="relative z-10 text-[10px] font-bold tracking-widest uppercase text-white/60 mb-1.5">
                        Patient Portal</p>
                    <h2 class="relative z-10 text-2xl sm:text-3xl font-extrabold text-white">Dental Records</h2>
                    <p class="relative z-10 text-sm text-white/80 mt-1">A complete timeline of your treatments.</p>

                    <div class="relative z-10 flex flex-wrap gap-2.5 mt-4">
                        <div id="recordsStatVisits"
                            class="flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold text-white bg-white/10 border border-white/20">
                            <i class="fa-solid fa-list text-white/70"></i>
                            <span id="recordsVisitCount">0 visits</span>
                        </div>
                        <div id="recordsStatLatest"
                            class="hidden items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold text-white bg-white/10 border border-white/20">
                            <i class="fa-regular fa-calendar text-white/70"></i>
                            <span id="recordsLatestDate"></span>
                        </div>
                    </div>
                </div>

                {{-- Records List Container --}}
                <div
                    class="bg-white rounded-b-[1.25rem] border border-gray-200 border-t-0 p-5 sm:p-6 -mt-6 relative z-10 shadow-sm">
                    <div id="viewAllContainer" class="hidden mb-6 flex items-center justify-between">
                        <h3 class="text-xs font-bold tracking-widest uppercase text-gray-500">Visit History</h3>
                        <a href="{{ route('patient.record') }}"
                            class="inline-flex items-center gap-1.5 text-xs font-bold text-[#8B0000] hover:text-[#5A0000] transition-colors bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg">
                            View All <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                    <div id="recordsInnerContainer">
                        <div class="space-y-4 animate-pulse">
                            <div
                                class="flex flex-col sm:flex-row items-start sm:items-center gap-4 border border-gray-100 rounded-xl p-4">
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex-shrink-0"></div>
                                <div class="flex-1 space-y-2 w-full">
                                    <div class="h-4 w-40 skeleton"></div>
                                    <div class="h-3 w-56 skeleton"></div>
                                </div>
                                <div class="h-8 w-24 skeleton rounded-lg mt-2 sm:mt-0"></div>
                            </div>
                            <div
                                class="flex flex-col sm:flex-row items-start sm:items-center gap-4 border border-gray-100 rounded-xl p-4">
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex-shrink-0"></div>
                                <div class="flex-1 space-y-2 w-full">
                                    <div class="h-4 w-40 skeleton"></div>
                                    <div class="h-3 w-48 skeleton"></div>
                                </div>
                                <div class="h-8 w-24 skeleton rounded-lg mt-2 sm:mt-0"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Modals --}}
    <dialog id="record_modal" class="modal">
        <div class="modal-box p-0 w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl bg-gray-50">
            <div class="bg-gradient-to-r from-[#5A0000] to-[#8B0000] px-6 sm:px-8 py-6 text-white relative">
                <button onclick="document.getElementById('record_modal').close()"
                    class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-black/20 hover:bg-black/40 text-white transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <p class="text-[10px] font-bold tracking-widest text-white/60 mb-1 uppercase">Treatment Details</p>
                <h3 id="m_service" class="text-2xl sm:text-3xl font-extrabold leading-tight">—</h3>
                <div class="mt-4 flex flex-wrap items-center gap-3 text-sm font-medium">
                    <div class="flex items-center gap-2 bg-white/10 px-3 py-1.5 rounded-lg border border-white/20">
                        <i class="fa-regular fa-calendar"></i> <span id="m_date">—</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white/10 px-3 py-1.5 rounded-lg border border-white/20">
                        <i class="fa-regular fa-clock"></i> <span id="m_time">—</span>
                    </div>
                </div>
            </div>

            <div class="p-5 sm:p-8 space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white border border-gray-200 shadow-sm rounded-xl p-4 text-center">
                        <div class="text-[10px] font-bold tracking-widest text-gray-400 mb-2 uppercase">Status</div>
                        <div><span id="m_status"
                                class="inline-flex px-3 py-1 text-xs rounded-full font-bold uppercase tracking-wider">—</span>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-200 shadow-sm rounded-xl p-4 text-center">
                        <div class="text-[10px] font-bold tracking-widest text-gray-400 mb-2 uppercase">Duration</div>
                        <div><span id="m_duration"
                                class="inline-flex px-3 py-1 text-xs rounded-full font-bold uppercase tracking-wider bg-gray-100 text-gray-700">—</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach ([['TREATMENT REMARKS', 'm_remarks', 'fa-notes-medical'], ['ORAL EXAMINATION', 'm_oral',
                    'fa-tooth'], ['DIAGNOSIS', 'm_diagnosis', 'fa-stethoscope'], ['PRESCRIPTION', 'm_prescription',
                    'fa-pills']] as [$label, $mid, $icon])
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                        <div class="bg-gray-50 border-b border-gray-100 px-4 py-3 flex items-center gap-2">
                            <i class="fa-solid {{ $icon }} text-[#8B0000] opacity-80"></i>
                            <span class="text-xs font-bold tracking-widest text-gray-700 uppercase">{{ $label }}</span>
                        </div>
                        <div class="p-4 text-gray-600 text-sm leading-relaxed break-words whitespace-pre-wrap"><span
                                id="{{ $mid }}">—</span></div>
                    </div>
                    @endforeach
                </div>
                <div class="flex justify-end pt-2">
                    <form method="dialog">
                        <button
                            class="px-8 py-2.5 rounded-xl bg-gray-200 text-gray-800 font-bold hover:bg-gray-300 transition text-sm">Close</button>
                    </form>
                </div>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    <dialog id="dentalClearanceModal" class="modal">
        <form id="clearanceRequestForm" method="POST" action="{{ route('patient.document.requests.store') }}"
            class="modal-box rounded-2xl bg-white shadow-xl relative" novalidate>
            @csrf
            <div id="clearanceWarning"
                class="hidden absolute top-4 left-1/2 -translate-x-1/2 px-4 py-1.5 rounded-full bg-red-600 text-white text-xs font-bold shadow-lg">
                Please complete all required fields</div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-full bg-red-50 text-[#8B0000] flex items-center justify-center"><i
                        class="fa-solid fa-file-circle-check text-lg"></i></div>
                <h3 class="font-extrabold text-2xl text-gray-800">Clearance</h3>
            </div>
            <p class="text-sm text-gray-500 mb-6 border-b border-gray-100 pb-4">Please allow up to three (3) working
                days for processing.</p>

            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Type of
                        Clearance</label>
                    <select name="document_type" required
                        class="w-full rounded-xl border-gray-200 bg-gray-50 text-gray-700 focus:ring-2 focus:ring-red-900 focus:border-red-900 py-3 px-4 transition-all">
                        <option value="" disabled selected>Select type of clearance</option>
                        <option value="Dental Clearance">Dental Clearance</option>
                        <option value="Annual Dental Clearance">Annual Dental Clearance</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Purpose</label>
                    <select name="purpose" required
                        class="w-full rounded-xl border-gray-200 bg-gray-50 text-gray-700 focus:ring-2 focus:ring-red-900 focus:border-red-900 py-3 px-4 transition-all">
                        <option value="" disabled selected>Select purpose</option>
                        <option value="On-the-Job Training (OJT)">On-the-Job Training (OJT)</option>
                        <option value="Employment Requirement">Employment Requirement</option>
                        <option value="Academic Requirement">Academic Requirement</option>
                    </select>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" onclick="dentalClearanceModal.close()"
                    class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition-colors">Cancel</button>
                <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-[#8B0000] hover:bg-[#660000] text-white font-bold shadow-md transition-colors">Submit
                    Request</button>
            </div>
        </form>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    <dialog id="dentalHealthRecordModal" class="modal">
        <form id="healthRecordRequestForm" method="POST" action="{{ route('patient.document.requests.store') }}"
            class="modal-box rounded-2xl bg-white shadow-xl relative" novalidate>
            @csrf
            <div id="healthRecordWarning"
                class="hidden absolute top-4 left-1/2 -translate-x-1/2 px-4 py-1.5 rounded-full bg-red-600 text-white text-xs font-bold shadow-lg">
                Please complete all required fields</div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-full bg-red-50 text-[#8B0000] flex items-center justify-center"><i
                        class="fa-solid fa-file-medical text-lg"></i></div>
                <h3 class="font-extrabold text-2xl text-gray-800">Health Record</h3>
            </div>
            <p class="text-sm text-gray-500 mb-6 border-b border-gray-100 pb-4">Please allow up to three (3) working
                days for processing.</p>

            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Type of
                        Record</label>
                    <select name="document_type" required
                        class="w-full rounded-xl border-gray-200 bg-gray-50 text-gray-700 focus:ring-2 focus:ring-red-900 focus:border-red-900 py-3 px-4 transition-all">
                        <option value="" disabled selected>Select type</option>
                        <option value="All Dental Records">All Dental Records</option>
                        <option value="Medical Records">Medical Records</option>
                        <option value="Diagnosis and Treatment">Diagnosis and Treatment</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Purpose</label>
                    <select name="purpose" required
                        class="w-full rounded-xl border-gray-200 bg-gray-50 text-gray-700 focus:ring-2 focus:ring-red-900 focus:border-red-900 py-3 px-4 transition-all">
                        <option value="" disabled selected>Select purpose</option>
                        <option value="Personal Record">Personal Record</option>
                        <option value="Academic Requirement">Academic Requirement</option>
                        <option value="Employment Requirement">Employment Requirement</option>
                    </select>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" onclick="dentalHealthRecordModal.close()"
                    class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition-colors">Cancel</button>
                <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-[#8B0000] hover:bg-[#660000] text-white font-bold shadow-md transition-colors">Submit
                    Request</button>
            </div>
        </form>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    <dialog id="activeAppointmentModal" class="modal">
        <div class="modal-box p-8 rounded-[1.5rem] bg-white text-center shadow-2xl w-[min(92vw,400px)]">
            <div
                class="mx-auto mb-5 w-20 h-20 rounded-full bg-red-50 flex items-center justify-center border-4 border-white shadow-sm">
                <i class="fa-solid fa-calendar-xmark text-[#8B0000] text-3xl"></i>
            </div>
            <h3 class="text-2xl font-extrabold text-gray-800 mb-3">Active Appointment</h3>
            <p class="text-sm text-gray-500 mb-8 leading-relaxed">You already have an active appointment scheduled.
                Please complete or cancel it before booking a new one.</p>
            <div class="flex flex-col gap-3">
                <a href="{{ route('patient.appointment.index') }}"
                    class="w-full py-3.5 rounded-xl bg-[#8B0000] text-white font-bold hover:bg-[#660000] transition-colors shadow-md">View
                    My Appointments</a>
                <button id="closeActiveApptModalBtn" type="button"
                    class="w-full py-3.5 rounded-xl bg-gray-100 text-gray-700 font-bold hover:bg-gray-200 transition-colors">Close</button>
            </div>
        </div>
    </dialog>

    </div>
</main>
@endsection

@section('scripts')
<script>
    const calendarData = {{ Illuminate\Support\Js:: from([
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
        $uD = \Carbon\Carbon:: parse($upcomingAppointment -> appointment_date);
        $uT = \Carbon\Carbon:: parse($upcomingAppointment -> appointment_time);
        $upcomingJs = [
            'exists' => true,
            'service' => $upcomingAppointment -> service_type ?? '—',
            'date' => $uD -> format('M d, Y'),
            'time_raw' => $upcomingAppointment -> appointment_time,
            'time_fmt' => $uT -> format('g:i A'),
            'dentist' => $upcomingAppointment -> dentist_name ?? 'Dr. Nelson P. Angeles',
            'status' => ucfirst($upcomingAppointment -> status),
            'isRescheduled' => strtolower($upcomingAppointment -> status) === 'rescheduled',
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
        ['Date of Birth', isset($patient -> birthdate) ?\Carbon\Carbon:: parse($patient -> birthdate) -> format('F d, Y') : '—'],
        ['Age', $patient -> age ?? '—'],
        ['Gender', $patient -> gender ?? '—'],
        ['Contact', $patient -> phone ?? '—'],
        ['Email', $patient -> email ?? '—']
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

        @if (session('show_terms_modal'))
            if (termsModal) {
                termsModal.showModal();
            }
        @endif

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
                    ic = 'fa-solid fa-moon text-blue-200 text-sm';
                    an = 'greet-float';
                }
                var el = document.getElementById('greetingText'),
                    ico = document.getElementById('greetingIcon');
                if (el) el.textContent = g;
                if (ico) ico.className = ic + ' ' + an;
            })();

        setTimeout(function () {
            renderUpcomingAppointment();
            renderProfile();
            renderRequestDocs();
            renderRecords();
            loadCalendar();
        }, 800);
    });

    function acceptTerms() {
        const termsModal = document.getElementById('termsModal');
        if (termsModal) {
            termsModal.close();
        }
    }

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
            function (s) { return s.slice(0, 3); }
        );
    }

    function renderUpcomingAppointment() {
        var wrapper = document.getElementById('upcomingAppointmentWrapper');
        if (!wrapper) return;
        var d = UPCOMING_DATA;

        if (d.exists) {
            var statusPillCls = d.isRescheduled ? 'bg-yellow-100 text-yellow-800 border-yellow-200' : 'bg-green-100 text-green-800 border-green-200';
            var statusDotCls = d.isRescheduled ? 'bg-yellow-500' : 'bg-green-500';

            wrapper.innerHTML =
                '<div class="bg-white rounded-[1.25rem] border border-gray-200 shadow-sm overflow-hidden fade-up">' +
                '<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4 bg-gray-50 border-b border-gray-100">' +
                '<div class="flex items-center gap-3">' +
                '<div class="w-10 h-10 rounded-full bg-red-50 text-[#8B0000] flex items-center justify-center flex-shrink-0">' +
                '<i class="fa-regular fa-calendar-check text-lg"></i></div>' +
                '<span class="text-gray-800 font-extrabold text-base">Upcoming Appointment</span></div>' +
                '<span class="inline-flex w-max items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-bold border ' + statusPillCls + '">' +
                '<span class="w-2 h-2 rounded-full ' + statusDotCls + '"></span>' + escapeHtml(d.status) + '</span></div>' +
                '<div class="px-6 py-5">' +
                '<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 sm:gap-6">' +
                '<div class="bg-gray-50/50 p-4 rounded-xl border border-gray-100"><p class="text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1.5">Service</p><p class="text-sm sm:text-base font-bold text-[#8B0000]">' + escapeHtml(d.service) + '</p></div>' +
                '<div class="bg-gray-50/50 p-4 rounded-xl border border-gray-100"><p class="text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1.5">Date &amp; Time</p><p class="text-sm sm:text-base font-bold text-gray-800">' + escapeHtml(d.date) + '<span class="text-gray-300 mx-2">|</span>' + escapeHtml(d.time_fmt) + '</p></div>' +
                '<div class="bg-gray-50/50 p-4 rounded-xl border border-gray-100"><p class="text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1.5">Dentist</p><p class="text-sm sm:text-base font-bold text-gray-800">' + escapeHtml(d.dentist) + '</p></div>' +
                '</div>' +
                '<div class="mt-5 pt-4 border-t border-gray-100 flex justify-end">' +
                '<a href="' + escapeHtml(d.indexUrl) + '" class="inline-flex items-center gap-2 text-sm font-bold text-[#8B0000] hover:text-[#5A0000] transition-colors bg-red-50 px-4 py-2 rounded-lg">Manage Appointment <i class="fa-solid fa-arrow-right text-xs"></i></a>' +
                '</div></div></div>';
        } else {
            wrapper.innerHTML =
                '<div class="bg-white rounded-[1.25rem] border border-gray-200 shadow-sm overflow-hidden fade-up">' +
                '<div class="flex items-center gap-3 px-6 py-4 bg-gray-50 border-b border-gray-100">' +
                '<div class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center flex-shrink-0">' +
                '<i class="fa-regular fa-calendar text-lg"></i></div>' +
                '<span class="text-gray-600 font-bold text-base">No Upcoming Appointment</span></div>' +
                '<div class="px-6 py-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">' +
                '<p class="text-sm text-gray-500 leading-relaxed">Ready for your next visit? Book an appointment now to maintain your healthy smile.</p>' +
                '<a href="' + escapeHtml(d.bookUrl) + '" class="inline-flex items-center gap-2 bg-[#8B0000] text-white text-sm font-bold px-6 py-3 rounded-xl hover:bg-[#660000] transition-colors shadow-md w-full sm:w-auto justify-center"><i class="fa-solid fa-calendar-plus text-sm"></i> Book Now</a>' +
                '</div></div>';
        }
    }

    function renderProfile() {
        var pData = PROFILE_DATA;
        document.getElementById("profileSkeletonContainer").innerHTML =
            '<div class="bg-white rounded-[1.25rem] overflow-hidden border border-gray-200 shadow-sm fade-up">' +
            '<div class="bg-gradient-to-r from-[#660000] to-[#8B0000] p-6 text-white flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-5">' +
            '<div class="avatar flex-shrink-0"><div class="w-20 h-20 sm:w-16 sm:h-16 rounded-full overflow-hidden ring-4 ring-white/20 shadow-lg">' +
            '<img src="' + escapeHtml(pData.avatar) + '" alt="Profile" class="w-full h-full object-cover">' +
            '</div></div>' +
            '<div class="flex-1"><h3 class="font-extrabold text-xl sm:text-2xl leading-tight mb-1">' + escapeHtml(pData.name) + '</h3>' +
            '<p class="text-sm font-medium text-white/70 mb-3">Student</p>' +
            '<span class="inline-block bg-black/20 text-yellow-300 border border-yellow-300/30 text-xs font-bold px-3 py-1 rounded-lg tracking-wider">' + escapeHtml(pData.patientId) + '</span>' +
            '</div></div>' +
            '<div class="bg-white text-sm flex flex-col divide-y divide-gray-100">' +
            pData.rows.map(function (row) {
                return '<div class="flex flex-col sm:flex-row sm:items-center px-6 py-3.5 gap-1 sm:gap-4 hover:bg-gray-50 transition-colors">' +
                    '<span class="text-gray-500 uppercase text-[10px] font-bold tracking-widest sm:w-32 flex-shrink-0">' + escapeHtml(row[0]) + '</span>' +
                    '<span class="font-bold text-gray-800">' + escapeHtml(row[1]) + '</span></div>';
            }).join('') + '</div></div>';
    }

    function renderRequestDocs() {
        document.getElementById("requestDocsContainer").innerHTML =
            '<div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">' +
            '<div class="w-10 h-10 bg-red-50 rounded-full flex items-center justify-center">' +
            '<i class="fa-solid fa-folder-open text-[#8B0000]"></i></div>' +
            '<h3 class="font-extrabold text-lg text-gray-800">Request Documents</h3></div>' +

            '<div class="space-y-3">' +
            '<a onclick="document.getElementById(\'dentalHealthRecordModal\')?.showModal()" ' +
            'class="group flex items-center gap-4 border border-gray-200 rounded-xl p-4 hover:border-red-200 hover:bg-red-50/50 hover:shadow-md transition-all cursor-pointer fade-up">' +
            '<div class="bg-gray-50 group-hover:bg-red-100 w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors">' +
            '<i class="fa-solid fa-file-medical text-gray-400 group-hover:text-[#8B0000] text-xl transition-colors"></i></div>' +
            '<div class="flex-1"><p class="font-bold text-sm text-gray-800 mb-0.5 group-hover:text-[#8B0000] transition-colors">Dental Health Record</p>' +
            '<p class="text-[11px] font-medium text-gray-500 line-clamp-1">All Records, Medical, Diagnosis</p></div>' +
            '<i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-[#8B0000] text-sm"></i></a>' +

            '<a onclick="document.getElementById(\'dentalClearanceModal\')?.showModal()" ' +
            'class="group flex items-center gap-4 border border-gray-200 rounded-xl p-4 hover:border-red-200 hover:bg-red-50/50 hover:shadow-md transition-all cursor-pointer fade-up" style="animation-delay: 0.1s">' +
            '<div class="bg-gray-50 group-hover:bg-red-100 w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors">' +
            '<i class="fa-solid fa-file-circle-check text-gray-400 group-hover:text-[#8B0000] text-xl transition-colors"></i></div>' +
            '<div class="flex-1"><p class="font-bold text-sm text-gray-800 mb-0.5 group-hover:text-[#8B0000] transition-colors">Dental Clearance</p>' +
            '<p class="text-[11px] font-medium text-gray-500 line-clamp-1">Standard & Annual Clearance</p></div>' +
            '<i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-[#8B0000] text-sm"></i></a>' +
            '</div>';
    }

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
                '<div class="flex flex-col items-center justify-center py-12 px-6 text-center">' +
                '<div class="w-20 h-20 rounded-full bg-gray-50 flex items-center justify-center mb-4">' +
                '<i class="fa-solid fa-tooth text-3xl text-gray-300"></i></div>' +
                '<p class="text-lg font-extrabold text-gray-800 mb-2">No records yet</p>' +
                '<p class="text-sm text-gray-500 max-w-xs leading-relaxed mb-6">Completed appointment records will appear here after your first visit.</p>' +
                '<a href="' + ROUTE_BOOK + '" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition-colors">' +
                '<i class="fa-solid fa-calendar-plus"></i> Book First Appointment</a>' +
                '</div>';
            if (viewAll) viewAll.classList.add("hidden");
            return;
        }

        var count = HOME_RECORDS.length;
        if (visitCount) visitCount.textContent = count + (count === 1 ? " visit" : " visits");
        if (statLatest && latestDate && HOME_RECORDS[0].date) {
            var pts = HOME_RECORDS[0].date.split(" ");
            latestDate.textContent = "Latest: " + (pts[0] ? pts[0].slice(0, 3) : "") + " " + (pts[2] || "");
            statLatest.classList.remove("hidden");
            statLatest.classList.add("flex");
        }

        if (viewAll) {
            viewAll.classList.remove("hidden");
            viewAll.classList.add("flex");
        }

        var html = '<div class="space-y-4">';
        HOME_RECORDS.forEach(function (r, idx) {
            var encoded = encodeURIComponent(JSON.stringify(r));
            var dispTime = formatTime(r.time);
            var dispDate = shortDate(r.date);

            html +=
                '<div class="bg-white border border-gray-200 rounded-xl p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all hover:shadow-md hover:border-red-100 group">' +
                '<div class="flex items-start sm:items-center gap-4 min-w-0">' +
                '<div class="w-10 h-10 rounded-full bg-red-50 text-[#8B0000] flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform"><i class="fa-solid fa-tooth text-sm"></i></div>' +
                '<div class="min-w-0 flex-1">' +
                '<p class="text-sm sm:text-base font-extrabold text-gray-800 truncate mb-1.5">' + escapeHtml(r.service) + '</p>' +
                '<div class="flex flex-wrap items-center gap-2">' +
                '<span class="inline-flex items-center gap-1.5 bg-gray-50 border border-gray-100 text-gray-600 rounded-md px-2 py-1 text-[10px] sm:text-xs font-bold">' +
                '<i class="fa-regular fa-calendar opacity-70"></i>' + escapeHtml(dispDate) + '</span>' +
                '<span class="inline-flex items-center gap-1.5 bg-gray-50 border border-gray-100 text-gray-600 rounded-md px-2 py-1 text-[10px] sm:text-xs font-bold">' +
                '<i class="fa-regular fa-clock opacity-70"></i>' + escapeHtml(dispTime) + '</span>' +
                '</div></div></div>' +
                '<button type="button" class="w-full sm:w-auto flex-shrink-0 inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-gray-50 hover:bg-[#8B0000] hover:text-white text-gray-700 text-xs font-bold transition-all shadow-sm border border-gray-200 hover:border-transparent" onclick="openRecordModalFromData(\'' + encoded + '\')">' +
                'Details <i class="fa-solid fa-arrow-right text-[10px]"></i></button>' +
                '</div>';
        });
        html += '</div>';
        container.innerHTML = html;
    }

    function openRecordModalFromData(encodedJson) {
        openRecordModal(JSON.parse(decodeURIComponent(encodedJson)));
    }

    function openRecordModal(data) {
        var modal = document.getElementById('record_modal');
        if (!modal) return;
        document.getElementById('m_service').textContent = data.service || '—';
        document.getElementById('m_date').textContent = data.date || '—';
        document.getElementById('m_time').textContent = formatTime(data.time);
        var BADGE = 'inline-flex px-3 py-1 text-xs rounded-full font-bold uppercase tracking-wider';
        var status = (data.status || 'completed').trim();
        var sEl = document.getElementById('m_status');
        sEl.textContent = status;
        sEl.className = BADGE;
        var s = status.toLowerCase();
        if (s === 'completed') sEl.classList.add('bg-green-100', 'text-green-800');
        else if (s === 'rescheduled') sEl.classList.add('bg-yellow-100', 'text-yellow-800');
        else if (s === 'cancelled') sEl.classList.add('bg-red-100', 'text-red-800');
        else sEl.classList.add('bg-gray-100', 'text-gray-700');

        var dEl = document.getElementById('m_duration');
        dEl.textContent = (data.duration || '—').trim() || '—';
        dEl.className = BADGE + ' bg-gray-100 text-gray-700';

        document.getElementById('m_remarks').textContent = (data.remarks || '').trim() || '—';
        document.getElementById('m_oral').textContent = (data.oral || '').trim() || '—';
        document.getElementById('m_diagnosis').textContent = (data.diagnosis || '').trim() || '—';
        document.getElementById('m_prescription').textContent = (data.prescription || '').trim() || '—';
        modal.showModal();
    }

    function loadCalendar() {
        var MAX_PER_DAY = 5;
        var myAppts = calendarAppointments || {};
        var apptCounts = calendarCounts || {};
        var unavail = calendarUnavailableDates || [];
        var holidays = calendarHolidays || {};
        var today = new Date();
        var curYear = today.getFullYear(), curMonth = today.getMonth();

        function pad(n) { return String(n).padStart(2, '0'); }
        function isWeekend(y, m, d) { var dow = new Date(y, m, d).getDay(); return dow === 0 || dow === 6; }
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
                var bgClass = '', textClass = 'text-gray-700', ringClass = '', dotHtml = '', tooltipTxt = '';

                if (isToday) {
                    bgClass = 'bg-[#8B0000] shadow-md'; textClass = 'text-white font-extrabold'; ringClass = '';
                } else if (holiday) {
                    bgClass = 'bg-blue-50 hover:bg-blue-100'; textClass = 'text-blue-700 font-bold';
                } else if (isUnavail) {
                    textClass = 'text-gray-300';
                } else {
                    bgClass = 'hover:bg-gray-100'; textClass = 'font-semibold text-gray-600';
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
                var tooltip = tooltipTxt ? '<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 z-50 bg-gray-900 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg whitespace-nowrap shadow-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200">' + tooltipTxt + '<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div></div>' : '';
                cells += '<div class="relative group flex items-center justify-center py-1">' + tooltip + '<div class="relative w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center text-sm rounded-full transition-all duration-200 ' + bgClass + ' ' + textClass + ' ' + ringClass + ' cursor-default">' + d + dotHtml + '</div></div>';
            }

            var headerHtml = dayLabels.map(function (l, i) {
                return '<div class="text-center text-[10px] sm:text-xs font-bold ' + (i === 0 || i === 6 ? 'text-gray-400' : 'text-gray-500') + ' uppercase tracking-wider py-2">' + l + '</div>';
            }).join('');

            document.getElementById("calendarSkeletonContainer").innerHTML =
                '<div class="h-full flex flex-col select-none">' +
                '<div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">' +
                '<h2 class="text-lg sm:text-xl font-extrabold text-gray-800 flex items-center gap-2"><i class="fa-regular fa-calendar-days text-[#8B0000]"></i> Schedule</h2>' +
                '<div class="flex items-center gap-2 bg-gray-50 rounded-full p-1">' +
                '<button onclick="changeMonth(-1)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-white hover:shadow-sm text-gray-600 transition-all"><i class="fa-solid fa-chevron-left text-xs"></i></button>' +
                '<span class="w-24 text-center text-sm font-bold text-[#8B0000]">' + monthNames[month] + ' ' + year + '</span>' +
                '<button onclick="changeMonth(1)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-white hover:shadow-sm text-gray-600 transition-all"><i class="fa-solid fa-chevron-right text-xs"></i></button>' +
                '</div></div>' +
                '<div class="grid grid-cols-7 gap-1 sm:gap-2 mb-2">' + headerHtml + '</div>' +
                '<div class="grid grid-cols-7 gap-1 sm:gap-2 flex-1 content-start">' + cells + '</div>' +
                '<div class="flex flex-wrap items-center justify-center gap-3 mt-6 pt-5 border-t border-gray-100">' +
                '<div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-600 font-bold"><span class="w-2.5 h-2.5 rounded-full bg-green-500 inline-block"></span>My Appt</div>' +
                '<div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-600 font-bold"><span class="w-2.5 h-2.5 rounded-full bg-[#8B0000] inline-block"></span>Today</div>' +
                '<div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-600 font-bold"><span class="w-2.5 h-2.5 rounded-full bg-red-500 inline-block"></span>Full</div>' +
                '<div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-600 font-bold"><span class="w-2.5 h-2.5 rounded-full bg-blue-400 inline-block"></span>Holiday</div>' +
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