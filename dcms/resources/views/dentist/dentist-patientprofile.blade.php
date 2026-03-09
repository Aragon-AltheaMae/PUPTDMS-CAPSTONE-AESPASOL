<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Patient Profile</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind + DaisyUI CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <!-- Font Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'ui-sans-serif']
          },
          colors: {
            primary: '#8B0000'
          }
        }
      }
    }
  </script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
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
      font-size: .95rem;
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

    /* Notif dropdown */
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

    /* ── SIDEBAR ── */
    .sidebar-link {
      display: flex;
      align-items: center;
      transition: background-color 0.2s ease, transform 0.2s ease;
    }

    #sidebar.expanded .sidebar-link {
      justify-content: flex-start;
      padding-left: 0.25rem;
    }

    #sidebar.expanded .sidebar-link i {
      margin-right: 0.75rem;
    }

    #sidebar.expanded .sidebar-link:hover {
      transform: translateX(4px);
    }

    #sidebar.expanded .sidebar-tooltip {
      display: none;
    }

    #sidebar.expanded .section-label {
      display: block;
    }

    #sidebar.expanded .sidebar-text {
      opacity: 1;
      width: auto;
      overflow: visible;
    }

    #sidebar.collapsed .sidebar-text {
      opacity: 0;
      width: 0;
      overflow: hidden;
    }

    #sidebar.collapsed .sidebar-tooltip {
      display: block;
    }

    #sidebar.collapsed .section-label {
      display: none;
    }

    .sidebar-link:hover .sidebar-tooltip {
      opacity: 1 !important;
      transform: scale(1) !important;
    }

    .section-label {
      font-size: 0.65rem;
      font-weight: 500;
      letter-spacing: 0.08em;
      color: #757575;
      text-transform: uppercase;
      margin-bottom: 0.25rem;
    }

    body,
    #sidebar,
    main,
    .card,
    .modal-box {
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    #sidebar.collapsed .section-label {
      display: none;
    }

    #sidebar.expanded .section-label {
      display: block;
    }

    #sidebar.collapsed .sidebar-link {
      justify-content: center;
      padding-left: 0;
      padding-right: 0;
    }

    #sidebar.collapsed .sidebar-link span:first-of-type {
      margin: 0 auto;
    }

    #sidebar.collapsed .sidebar-link i {
      margin-right: 0 !important;
      width: 100%;
      text-align: center;
    }

    #sidebar.expanded .sidebar-link {
      justify-content: flex-start;
    }

    #sidebar.expanded .sidebar-link i {
      margin-right: 0.75rem;
    }

    #sidebar.expanded .sidebar-link span i {
      margin-right: 0 !important;
    }

    #sidebar.expanded .sidebar-link:hover {
      transform: translateX(4px);
    }

    #sidebar.collapsed .sidebar-tooltip {
      display: block;
    }

    #sidebar.expanded .sidebar-tooltip {
      display: none;
    }

    .sidebar-link.bg-\[\#8B0000\] {
      box-shadow: 0 0 12px rgba(139, 0, 0, 0.45);
    }

    /* ── THEME ── */
    .theme-toggle-container {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      height: 34px;
      background: #F5F5F5;
      border: 1px solid #E0E0E0;
      border-radius: 24px;
      transition: all 0.3s ease;
    }

    #sidebar.collapsed .theme-toggle-container {
      flex-direction: column;
      width: 35px;
      height: 96px;
      border-radius: 24px;
      padding: 4px;
    }

    #sidebar.collapsed .w-full {
      display: flex;
      justify-content: center;
    }

    .theme-option {
      position: relative;
      z-index: 2;
      flex: 1;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: transparent;
      border: none;
      cursor: pointer;
      color: #9CA3AF;
      transition: color 0.2s ease;
      border-radius: 8px;
    }

    #sidebar.collapsed .theme-option {
      width: 35px;
      height: 40px;
      flex: none;
    }

    .theme-option i {
      font-size: 16px;
    }

    #sidebar.collapsed .theme-option i {
      font-size: 15px;
    }

    .theme-option.active {
      color: #374151;
    }

    .theme-indicator {
      position: absolute;
      background: white;
      border-radius: 24px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      pointer-events: none;
    }

    #sidebar.expanded .theme-indicator {
      width: calc(50% - 2px);
      height: calc(100% - 8px);
      left: 4px;
      top: 4px;
      border-radius: 20px;
    }

    #sidebar.expanded .theme-indicator.dark-mode {
      transform: translateX(calc(100% + 0px));
    }

    #sidebar.collapsed .theme-indicator {
      width: calc(100% - 8px);
      height: calc(50% - 6px);
      left: 4px;
      top: 4px;
      border-radius: 16px;
    }

    #sidebar.collapsed .theme-indicator.dark-mode {
      transform: translateY(calc(100% + 4px));
    }

    /* ── DARK MODE ── */
    [data-theme="dark"] body {
      background-color: #000D1A;
      color: #E5E7EB;
    }

    [data-theme="dark"] #sidebar {
      background-color: #000D1A;
    }

    [data-theme="dark"] .bg-white {
      background-color: #000D1A !important;
    }

    [data-theme="dark"] .text-\[\#333333\] {
      color: #E5E7EB !important;
    }

    [data-theme="dark"] .theme-toggle-container {
      background: #1F1F1F;
      border-color: #2A2A2A;
    }

    [data-theme="dark"] .theme-option {
      color: #6B7280;
    }

    [data-theme="dark"] .theme-option.active {
      color: #F3F4F6;
    }

    [data-theme="dark"] .theme-indicator {
      background: #2A2A2A;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }
  </style>
</head>

@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

<body class="bg-gray-100 min-h-screen">

  <!-- ===== APP SHELL ===== -->
  <div class="flex min-h-screen">

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
            @if($notifCount > 0)<span class="notif-badge">{{ $notifCount }}</span>@endif
          </button>
          <div id="notifMenu">
            <div style="padding:.85rem 1rem .65rem; font-weight:700; color:var(--red); font-size:.82rem; border-bottom:1px solid #f5e8e8;">
              Notifications
            </div>
            <div style="max-height:260px; overflow-y:auto;">
              @forelse($notifications as $n)
              <a href="{{ $n['url'] ?? '#' }}" style="display:block; padding:.65rem 1rem; font-size:.78rem; color:#333; text-decoration:none; border-bottom:1px solid #fdf5f5;">
                <div style="font-weight:600;">{{ $n['title'] ?? 'Notification' }}</div>
                @if(!empty($n['message']))<div style="color:#aaa; margin-top:2px;">{{ $n['message'] }}</div>@endif
              </a>
              @empty
              <div style="padding:2rem 1rem; text-align:center; color:#bbb; font-size:.78rem;">You're all caught up.</div>
              @endforelse
            </div>
          </div>
        </div>
        <div class="header-user">
          <img src="https://i.pravatar.cc/40" class="header-avatar" alt="Avatar">
          <div>
            <div class="header-name">Dr. Nelson Angeles</div>
            <div class="header-role">Dentist</div>
          </div>
        </div>
      </div>
    </header>

    <!-- ===== PAGE CONTENT ===== -->
    <main id="mainContent" class="pt-[100px] px-6 py-6 fade-up min-h-screen">
      <div class="max-w-7xl mt-4 mx-auto fade-in">

        <!-- Breadcrumb + Title -->
        <div>
          <p class="text-xs text-gray-400 mb-2">
            <a href="{{ route('dentist.dentist.appointments') }}" class="hover:underline">Appointments</a>
            <span class="mx-1">›</span>
            <span class="text-gray-600 font-medium">Patient Profile</span>
          </p>
          <div class="flex items-center gap-3">
            <a href="{{ route('dentist.dentist.appointments') }}"
              class="flex items-center gap-1 text-sm text-gray-600 border 
              border-gray-300 rounded-md px-3 py-1.5 hover:bg-gray-100 transition">
              <i class="fa-solid fa-arrow-left text-xs"></i>
              Back
            </a>
            <h1 class="text-2xl font-bold text-[#8B0000]">Patient Profile</h1>
          </div>
        </div>

        <!-- ===== STAT CARDS ===== -->
        <div class="grid grid-cols-3 gap-4">
          <!-- Total Visits -->
          <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4 shadow-sm">
            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-500">
              <i class="fa-regular fa-calendar text-lg"></i>
            </div>
            <div>
              <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total Visits</p>
              <p class="text-2xl font-bold text-gray-900 leading-tight">{{ $totalVisits ?? 0 }}</p>
              <p class="text-[11px] text-gray-400">Since Jan 2024</p>
            </div>
          </div>

          <!-- Last Visit -->
          <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4 shadow-sm">
            <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center text-green-500">
              <i class="fa-regular fa-calendar-check text-lg"></i>
            </div>
            <div>
              <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Last Visit</p>
              <p class="text-2xl font-bold text-gray-500 leading-tight">
                {{ $lastVisit ? \Carbon\Carbon::parse($lastVisit->appointment_date)->format('M d') : 'No Existing Appointments' }}
              </p>
              <p class="text-[11px] text-gray-400">
                {{ $lastVisit ? \Carbon\Carbon::parse($lastVisit->appointment_date)->format('Y') . ' · ' . ($lastVisit->service_type ?? $lastVisit->service ?? 'Visit') : 'No visit yet' }}
              </p>
            </div>
          </div>

          <!-- Next Appointment -->
          <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4 shadow-sm">
            <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center text-orange-400">
              <i class="fa-regular fa-calendar text-lg"></i>
            </div>
            <div>
              <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Next Appointment</p>
              <p class="text-2xl font-bold text-gray-900 leading-tight">
                {{ $nextAppointment ? \Carbon\Carbon::parse($nextAppointment->appointment_date)->format('M d') : 'No Existing Appointments' }}
              </p>
              <p class="text-[11px] text-gray-400">
                {{ $nextAppointment ? \Carbon\Carbon::parse($nextAppointment->appointment_date)->format('Y') . ' · ' . ($nextAppointment->service_type ?? $nextAppointment->service ?? 'Appointment') : 'No upcoming appointment' }}
              </p>
            </div>
          </div>
        </div>

        <!-- ===== PATIENT CARD + ODONTOGRAM ===== -->
        <div class="grid grid-cols-[380px,1fr] gap-4">

          <!-- Patient Card -->
          <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
            <!-- Maroon top with avatar -->
            <div class="bg-gradient-to-b from-[#8B0000] to-[#660000] px-8 pt-8 pb-6 flex flex-col items-center text-white">
              @php
              $age = $patient->birthdate ? \Carbon\Carbon::parse($patient->birthdate)->age : null;
              $birthdateFormatted = $patient->birthdate ? \Carbon\Carbon::parse($patient->birthdate)->format('F d, Y') : 'N/A';
              $patientName = $patient->name ?? 'Unknown Patient';
              @endphp

              <img
                src="{{ $patient->profile_image ? asset('storage/'.$patient->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($patientName).'&background=8B0000&color=FFFFFF&rounded=true&size=256' }}"
                class="w-28 h-28 rounded-full object-cover border-4 border-white/30 shadow-md mb-4"
                alt="{{ $patientName }}">

              <p class="font-bold text-xl text-center leading-tight">{{ $patient->name }}</p>
              <p class="text-sm opacity-75 mt-1">{{ $patient->course_year ?? 'BSIT 3-1' }}</p>

              <!-- ID badge -->
              <span class="mt-3 bg-yellow-500 text-white text-xs font-bold px-4 py-1 rounded-full tracking-wide">
                {{ $patient->student_id ?? '2023-0010-TO-S' }}
              </span>
            </div>

            <!-- Patient Details -->
            <div class="divide-y divide-gray-100 text-sm">
              <div class="grid grid-cols-[130px,1fr] px-6 py-3.5 gap-2">
                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider self-center">Date of Birth</span>
                <span class="text-gray-800 font-medium">{{ $birthdateFormatted }}</span>
              </div>
              <div class="grid grid-cols-[130px,1fr] px-6 py-3.5 gap-2">
                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider self-center">Age</span>
                <span class="text-gray-800 font-medium">{{ $age ? $age . ' years old' : 'N/A' }}</span>
              </div>
              <div class="grid grid-cols-[130px,1fr] px-6 py-3.5 gap-2">
                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider self-center">Gender</span>
                <span class="text-gray-800 font-medium">{{ $patient->gender ?? 'Female' }}</span>
              </div>
              <div class="grid grid-cols-[130px,1fr] px-6 py-3.5 gap-2">
                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider self-center">Address</span>
                <span class="text-gray-800 font-medium">{{ $patient->address ?? '10-A Tindalo St. North Signal Village, Taguig City' }}</span>
              </div>
              <div class="grid grid-cols-[130px,1fr] px-6 py-3.5 gap-2">
                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider self-center">Contact</span>
                <span class="text-gray-800 font-medium">{{ $patient->phone ?? '09162903429' }}</span>
              </div>
              <div class="grid grid-cols-[130px,1fr] px-6 py-3.5 gap-2">
                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider self-center">Email</span>
                <span class="text-gray-800 font-medium break-all">{{ $patient->email ?? 'limgraceannef@gmail.com' }}</span>
              </div>
            </div>
          </div>

          <!-- Odontogram Panel -->
          <div class="bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
              <h2 class="text-base font-bold text-[#8B0000]">Odontogram</h2>
              <a href="{{ route('dentist.viewOdontogram') }}"
                class="text-xs border border-gray-300 rounded-md px-3 py-1.5 text-gray-600 hover:bg-gray-50 transition">
                Full View
              </a>
            </div>
            <div class="flex-1 p-6">
              {{-- Odontogram component renders here --}}
            </div>
          </div>
        </div>

        <!-- ===== MEDICAL HISTORY + CLINICAL NOTES ===== -->
        <div class="grid grid-cols-2 gap-4">

          <!-- Medical History -->
          <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h2 class="text-base font-bold text-[#8B0000] mb-5">Medical History</h2>

            <div class="space-y-5">
              <div>
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Allergies</p>
                <hr class="border-gray-200 mb-3">
                <div class="flex flex-wrap gap-2">
                  @php $allergies = $patient->allergies ?? ['Foods', 'Medicine', 'Peanut']; @endphp
                  @foreach((is_array($allergies) ? $allergies : explode(',', $allergies)) as $allergy)
                  <span class="bg-red-50 border border-red-200 text-red-600 text-xs font-medium px-3 py-1 rounded-full">
                    {{ trim($allergy) }}
                  </span>
                  @endforeach
                </div>
              </div>

              <div>
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Current Medication</p>
                <hr class="border-gray-200 mb-3">
                <div class="flex flex-wrap gap-2">
                  @php $meds = $patient->medications ?? ['Ferrous Sulfate', 'Folic Acid']; @endphp
                  @foreach((is_array($meds) ? $meds : explode(',', $meds)) as $med)
                  <span class="bg-gray-50 border border-gray-200 text-gray-600 text-xs font-medium px-3 py-1 rounded-full">
                    {{ trim($med) }}
                  </span>
                  @endforeach
                </div>
              </div>
            </div>
          </div>

          <!-- Clinical Notes -->
          <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h2 class="text-base font-bold text-[#8B0000] mb-5">Clinical Notes</h2>
            <div class="text-sm text-gray-400 italic">No clinical notes yet.</div>
          </div>
        </div>

        <!-- ===== CLINIC VISITS ===== -->
        <div>
          <h2 class="text-xl font-bold text-[#8B0000] mb-4">Clinic Visits</h2>

          <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">

            <!-- Tabs -->
            <div class="flex gap-8 border-b border-gray-200 mb-5">
              <button id="futureTab" onclick="showFuture()"
                class="visit-tab pb-3 text-sm font-semibold text-[#8B0000] border-b-2 border-[#8B0000] -mb-px transition">
                Future Visits ({{ $futureVisits->count() ?? 1 }})
              </button>
              <button id="pastTab" onclick="showPast()"
                class="visit-tab pb-3 text-sm font-semibold text-gray-400 border-b-2 border-transparent -mb-px transition">
                Past Visits ({{ $pastVisits->count() ?? 3 }})
              </button>
            </div>

            <!-- Future Visits -->
            <div id="futureContent">
              @forelse($futureVisits ?? [] as $visit)
              <div class="border border-gray-200 rounded-lg flex items-center gap-0 overflow-hidden mb-3 hover:shadow-sm transition-shadow">
                <div class="w-1 self-stretch bg-[#8B0000] rounded-l-lg flex-shrink-0"></div>
                <div class="flex items-center gap-0 flex-1 px-4 py-4">
                  <div class="min-w-[150px]">
                    <p class="font-semibold text-[#8B0000] text-sm">{{ \Carbon\Carbon::parse($visit->appointment_date)->format('d M Y') }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($visit->appointment_time)->format('g:i A') }}</p>
                    <span class="mt-1.5 inline-block text-[11px] font-bold text-blue-500 uppercase">{{ $visit->status }}</span>
                  </div>
                  <div class="h-10 w-px bg-gray-200 mx-5"></div>
                  <div class="min-w-[130px]">
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Service</p>
                    <p class="text-sm font-medium text-gray-800 mt-0.5">{{ $visit->service_type }}</p>
                  </div>
                  <div class="h-10 w-px bg-gray-200 mx-5"></div>
                  <div class="flex-1">
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Dentist</p>
                    <p class="text-sm font-medium text-gray-800 mt-0.5">Dr. Nelson Angeles</p>
                  </div>
                  <button onclick="openStartModal()"
                    class="ml-auto flex items-center gap-2 bg-[#8B0000] hover:bg-[#7a0000] text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                    <i class="fa-regular fa-eye text-xs"></i>
                    Details
                  </button>
                </div>
              </div>
              @empty
              {{-- Static demo row --}}
              <div class="border border-gray-200 rounded-lg flex items-center overflow-hidden mb-3 hover:shadow-sm transition-shadow">
                <div class="w-1 self-stretch bg-[#8B0000] rounded-l-lg flex-shrink-0"></div>
                <div class="flex items-center flex-1 px-4 py-4">
                  <div class="min-w-[150px]">
                    <p class="font-semibold text-[#8B0000] text-sm">29 Dec 2025</p>
                    <p class="text-xs text-gray-500 mt-0.5">1:30 PM - 2:30 PM</p>
                    <span class="mt-1.5 inline-block text-[11px] font-bold text-blue-500 uppercase">Scheduled</span>
                  </div>
                  <div class="h-10 w-px bg-gray-200 mx-5"></div>
                  <div class="min-w-[130px]">
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Service</p>
                    <p class="text-sm font-medium text-gray-800 mt-0.5">Dental Surgery</p>
                  </div>
                  <div class="h-10 w-px bg-gray-200 mx-5"></div>
                  <div class="flex-1">
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide">
                      Dentist
                    </p>
                    <p class="text-sm font-medium text-gray-800 mt-0.5">
                      Dr. Nelson Angeles
                    </p>
                  </div>
                  <button onclick="openStartModal()"
                    class="ml-auto flex items-center gap-2 bg-[#8B0000] 
                      hover:bg-[#7a0000] text-white text-xs font-semibold 
                      px-4 py-2 rounded-lg transition">
                    <i class="fa-regular fa-eye text-xs"></i>
                    Details
                  </button>
                </div>
              </div>
              @endforelse
            </div>

            <!-- Past Visits -->
            <div id="pastContent" class="hidden">
              @forelse($pastVisits ?? [] as $visit)
              <div class="border border-gray-200 rounded-lg flex items-center 
                overflow-hidden mb-3 hover:shadow-sm transition-shadow">
                <div class="w-1 self-stretch bg-gray-400 rounded-l-lg flex-shrink-0"></div>
                <div class="flex items-center flex-1 px-4 py-4">
                  <div class="min-w-[150px]">

                    <p class="font-semibold text-gray-700 text-sm">{{ \Carbon\Carbon::parse($visit->appointment_date)->format('d M Y') }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($visit->appointment_time)->format('g:i A') }}</p>
                    <span class="mt-1.5 inline-block text-[11px] font-bold text-gray-500 uppercase">{{ $visit->status }}</span>

                  </div>
                  <div class="h-10 w-px bg-gray-200 mx-5"></div>
                  <div class="min-w-[130px]">
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Service</p>
                    <p class="text-sm font-medium text-gray-800 mt-0.5">{{ $visit->service_type }}</p>
                  </div>
                  <div class="h-10 w-px bg-gray-200 mx-5"></div>
                  <div class="flex-1">
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide">
                      Dentist
                    </p>
                    <p class="text-sm font-medium text-gray-800 mt-0.5">
                      Dr. Nelson Angeles
                    </p>
                  </div>
                  <button class="ml-auto flex items-center gap-2 bg-[#8B0000] 
                    hover:bg-[#7a0000] text-white text-xs font-semibold px-4 
                      py-2 rounded-lg transition">
                    <i class="fa-regular fa-eye text-xs"></i>
                    Details
                  </button>
                </div>
              </div>
              @empty
              <div class="text-center text-gray-400 py-10 text-sm">
                No past visits recorded.
              </div>
              @endforelse
            </div>

          </div>
        </div>
      </div>
    </main><!-- /main -->

    <!-- ===== FOOTER ===== -->
    <footer class="bg-[#660000] text-[#F4F4F4] px-10 
      py-6 text-xs text-center opacity-90">
      © {{ date('Y') }} PUP Taguig Dental Clinic. All rights reserved.
    </footer>

  </div><!-- /right column -->
  </div><!-- /app shell -->


  <!-- ===== START PROCEDURE MODAL ===== -->
  <div id="startModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
    <div class="bg-white w-[480px] rounded-2xl p-8 relative shadow-2xl">
      <h2 class="text-xl font-bold text-gray-800 mb-6">Confirm the start of procedure?</h2>
      <div class="flex items-center gap-4 mb-8">
        <span class="text-[#8B0000] font-medium text-sm w-20">Patient:</span>
        <div class="bg-[#8B0000] h-9 flex-1 rounded-lg"></div>
      </div>
      <div class="flex gap-3">
        <button onclick="confirmStart()"
          class="bg-green-500 hover:bg-green-600 text-white 
      font-semibold px-8 py-2.5 rounded-lg transition text-sm">
          START</button>
        <button onclick="closeStartModal()"
          class="bg-gray-200 hover:bg-gray-300 text-gray-700 
      font-semibold px-8 py-2.5 rounded-lg transition text-sm">
          BACK</button>
      </div>
    </div>
  </div>


  <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
  <script>
    // ── THEME TOGGLE ──
    const html = document.documentElement;
    const themeToggleContainer = document.getElementById("themeToggle");
    const themeIndicator = themeToggleContainer.querySelector(".theme-indicator");
    const themeOptions = themeToggleContainer.querySelectorAll(".theme-option");

    function applyTheme(theme) {
      html.setAttribute("data-theme", theme);
      localStorage.setItem("theme", theme);
      themeOptions.forEach(opt => opt.classList.toggle("active", opt.getAttribute("data-theme") === theme));
      themeIndicator.classList.toggle("dark-mode", theme === "dark");
    }

    applyTheme(localStorage.getItem("theme") || "light");
    themeOptions.forEach(opt => opt.addEventListener("click", () => applyTheme(opt.getAttribute("data-theme"))));

    // ── SIDEBAR ──
    let sidebarOpen = true;

    function applyLayout(sidebarWidth) {
      document.getElementById('sidebar').style.width = sidebarWidth;
      document.getElementById('mainContent').style.marginLeft = sidebarWidth;
    }

    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const texts = document.querySelectorAll('.sidebar-text');
      const icon = document.getElementById('sidebarIcon');
      const toggleWrapper = document.getElementById('sidebarToggleWrapper');
      sidebarOpen = !sidebarOpen;
      if (sidebarOpen) {
        applyLayout('220px');
        sidebar.classList.replace('collapsed', 'expanded');
        texts.forEach(t => {
          t.classList.remove('opacity-0', 'w-0');
          t.classList.add('opacity-100');
        });
        toggleWrapper.classList.replace('justify-center', 'justify-end');
        icon.classList.replace('fa-bars', 'fa-xmark');
      } else {
        applyLayout('72px');
        sidebar.classList.replace('expanded', 'collapsed');
        texts.forEach(t => {
          t.classList.add('opacity-0', 'w-0');
          t.classList.remove('opacity-100');
        });
        toggleWrapper.classList.replace('justify-end', 'justify-center');
        icon.classList.replace('fa-xmark', 'fa-bars');
      }
      applyTheme(localStorage.getItem("theme") || "light");
    }

    document.addEventListener('DOMContentLoaded', () => {
      sidebarOpen = true;
      applyLayout('220px');
    });

    // ── NOTIF ──
    document.getElementById("notifBtn").addEventListener("click", e => {
      e.stopPropagation();
      document.getElementById("notifMenu").classList.toggle("open");
    });
    document.addEventListener("click", () => document.getElementById("notifMenu").classList.remove("open"));

    function showFuture() {
      document.getElementById('futureContent').classList.remove('hidden');
      document.getElementById('pastContent').classList.add('hidden');

      document.getElementById('futureTab').classList.add('text-[#8B0000]', 'border-[#8B0000]');
      document.getElementById('futureTab').classList.remove('text-gray-400', 'border-transparent');

      document.getElementById('pastTab').classList.add('text-gray-400', 'border-transparent');
      document.getElementById('pastTab').classList.remove('text-[#8B0000]', 'border-[#8B0000]');
    }

    function showPast() {
      document.getElementById('pastContent').classList.remove('hidden');
      document.getElementById('futureContent').classList.add('hidden');

      document.getElementById('pastTab').classList.add('text-[#8B0000]', 'border-[#8B0000]');
      document.getElementById('pastTab').classList.remove('text-gray-400', 'border-transparent');

      document.getElementById('futureTab').classList.add('text-gray-400', 'border-transparent');
      document.getElementById('futureTab').classList.remove('text-[#8B0000]', 'border-[#8B0000]');
    }

    function openStartModal() {
      document.getElementById('startModal').classList.remove('hidden');
    }

    function closeStartModal() {
      document.getElementById('startModal').classList.add('hidden');
    }

    function confirmStart() {
      closeStartModal();

      // temporary behavior
      alert('Procedure started successfully.');
    }

    // close modal when clicking outside the modal box
    document.getElementById('startModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeStartModal();
      }
    });

    // optional: press ESC to close modal
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeStartModal();
      }
    });
  </script>