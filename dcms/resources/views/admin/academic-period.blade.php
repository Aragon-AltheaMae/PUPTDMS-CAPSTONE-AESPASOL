@extends('layouts.admin')

@section('title', 'Academic Period | PUP Taguig Dental Clinic')

@section('styles')

<style>
  .scrollbar-thin::-webkit-scrollbar {
    width: 6px;
  }

  .scrollbar-thin::-webkit-scrollbar-track {
    background: transparent;
  }

  .scrollbar-thin::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 10px;
  }

  .scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
  }

  .active-banner {
    background: #fff;
    border-radius: 12px;
    border-left: 4px solid #8B0000;
    box-shadow: 0 1px 6px rgba(0, 0, 0, .06);
    overflow: hidden;
    margin-bottom: 1.5rem;
  }

  .active-banner-inner {
    padding: 1.25rem 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  @media (min-width:1024px) {
    .active-banner-inner {
      flex-direction: row;
      align-items: center;
      justify-content: space-between;
      gap: 1.25rem;
    }
  }

  .progress-track {
    height: 6px;
    border-radius: 99px;
    background: #f3f4f6;
    overflow: hidden;
  }

  .progress-fill {
    height: 100%;
    border-radius: 99px;
    background: linear-gradient(90deg, #8B0000, #c0392b);
    transition: width .6s cubic-bezier(.4, 0, .2, 1);
  }

  .sem-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 99px;
  }

  .s-active {
    background: #fee2e2;
    color: #8B0000;
  }

  .s-upcoming {
    background: #dbeafe;
    color: #1d4ed8;
  }

  .s-ended {
    background: #f3f4f6;
    color: #6b7280;
  }

  .s-inactive {
    background: #fef9c3;
    color: #92400e;
  }

  .act {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-size: 12px;
    transition: all .15s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    line-height: 1;
    font-weight: 600;
    flex-shrink: 0;
  }

  .act i {
    display: flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
  }

  .act:hover {
    transform: scale(1.06);
  }

  .act-edit {
    background: #eff6ff;
    color: #2563eb;
  }

  .act-edit:hover {
    background: #dbeafe;
  }

  .act-star {
    background: #d1fae5;
    color: #065f46;
  }

  .act-star:hover {
    background: #a7f3d0;
  }

  .act-del {
    background: #fef2f2;
    color: #dc2626;
  }

  .act-del:hover {
    background: #fee2e2;
  }

  .act-pinned {
    background: #d1fae5;
    color: #065f46;
    opacity: .55;
    cursor: default;
  }

  .tbl-row {
    transition: background .12s;
  }

  .tbl-row:hover {
    background: #fef9f9;
  }

  .tbl-row.is-active {
    background: #fff7f7;
  }

  .modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, .45);
    z-index: 200;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    opacity: 0;
    pointer-events: none;
    transition: opacity .2s;
  }

  .modal-overlay.open {
    opacity: 1;
    pointer-events: auto;
  }

  .modal-box {
    background: #fff;
    border-radius: 20px;
    width: 100%;
    max-width: 560px;
    max-height: 90vh;
    overflow-y: auto;
    transform: scale(.95) translateY(10px);
    transition: transform .25s cubic-bezier(.4, 0, .2, 1);
    box-shadow: 0 24px 60px rgba(0, 0, 0, .2);
  }

  .modal-overlay.open .modal-box {
    transform: scale(1) translateY(0);
  }

  .modal-sm .modal-box {
    max-width: 420px;
  }

  .field-input {
    transition: border-color .15s, box-shadow .15s;
  }

  .field-input:focus {
    outline: none;
    border-color: #8B0000 !important;
    box-shadow: 0 0 0 3px rgba(139, 0, 0, .1);
  }

  @keyframes pulse {

    0%,
    100% {
      opacity: 1
    }

    50% {
      opacity: .35
    }
  }

  .dot-pulse {
    animation: pulse 2s cubic-bezier(.4, 0, .6, 1) infinite;
  }

  .search-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #FAFAF9;
    border: 1.5px solid #E0DDD8;
    border-radius: 12px;
    padding: 0 14px;
    height: 38px;
    transition: border-color .2s, box-shadow .2s;
    min-width: 0;
    flex-shrink: 1;
  }

  .search-wrap:focus-within {
    border-color: #8B0000;
    box-shadow: 0 0 0 3px rgba(139, 0, 0, .1);
  }

  .search-wrap i {
    color: #8B0000;
    font-size: 13px;
    flex-shrink: 0;
  }

  .search-wrap input {
    border: none;
    background: none;
    outline: none;
    font-size: 13px;
    color: #333;
    width: 100%;
  }

  .search-wrap input::placeholder {
    color: #B0ABA6;
  }

  .search-clear-btn {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: none;
    background: #E0DDD8;
    color: #7A7370;
    font-size: 10px;
    cursor: pointer;
    display: none;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all .2s;
    padding: 0;
  }

  .search-clear-btn:hover {
    background: #8b000076;
    color: #fff;
  }

  .search-clear-btn.visible {
    display: flex;
  }

  .filter-select {
    height: 38px;
    border: 1.5px solid #E0DDD8;
    border-radius: 12px;
    background: #FAFAF9;
    padding: 0 12px;
    font-size: 12px;
    color: #4b5563;
    outline: none;
    cursor: pointer;
    transition: border-color .2s, box-shadow .2s;
  }

  .filter-select:focus {
    border-color: #8B0000;
    box-shadow: 0 0 0 3px rgba(139, 0, 0, .1);
  }

  .filter-btn {
    height: 38px;
    padding: 0 16px;
    border-radius: 10px;
    background: #8B0000;
    color: white;
    font-size: 12px;
    font-weight: 700;
    border: none;
    cursor: pointer;
  }

  .filter-btn:hover {
    background: #760000;
  }

  .reset-btn {
    height: 38px;
    padding: 0 16px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    background: #fff;
    color: #6b7280;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  .reset-btn:hover {
    background: #f9fafb;
  }

  [data-theme="dark"] .border-gray-100 {
    border-color: #21262d !important;
  }

  [data-theme="dark"] .border-gray-200 {
    border-color: #21262d !important;
  }

  [data-theme="dark"] .text-gray-800 {
    color: #e5e7eb !important;
  }

  [data-theme="dark"] .text-gray-600 {
    color: #9ca3af !important;
  }

  [data-theme="dark"] .text-gray-500 {
    color: #9ca3af !important;
  }

  [data-theme="dark"] .text-\[\#333333\] {
    color: #E5E7EB !important;
  }

  [data-theme="dark"] .flyout-panel {
    background: #161b22;
    border-color: #2d1a1a;
  }

  [data-theme="dark"] .flyout-link {
    color: #d1d5db;
  }

  [data-theme="dark"] .modal-box {
    background: #161b22;
  }

  [data-theme="dark"] .modal-box input,
  [data-theme="dark"] .modal-box select,
  [data-theme="dark"] .modal-box textarea {
    background: #0d1117 !important;
    border-color: #21262d !important;
    color: #e5e7eb !important;
  }

  [data-theme="dark"] .tbl-row:hover {
    background: #0d1117;
  }

  [data-theme="dark"] .tbl-row.is-active {
    background: rgba(139, 0, 0, .07);
  }

  [data-theme="dark"] thead tr {
    background: #0d1117 !important;
  }

  [data-theme="dark"] tr {
    border-color: #21262d !important;
  }

  [data-theme="dark"] .active-banner {
    background: #161b22 !important;
  }

  [data-theme="dark"] .progress-track {
    background: #21262d;
  }

  [data-theme="dark"] .modal-box .bg-gray-50 {
    background: #0d1117 !important;
  }

  [data-theme="dark"] .cal-card {
    background: #161b22 !important;
    border-color: #21262d !important;
  }

  .field-error {
    font-size: 11px;
    color: #dc2626;
    margin-top: 4px;
    display: none;
    align-items: center;
    gap: 4px;
    font-weight: 600;
  }

  .field-error.show {
    display: flex;
  }

  .field-invalid {
    border-color: #dc2626 !important;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, .1) !important;
  }

  .field-valid {
    border-color: #16a34a !important;
  }

  .ap-toolbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  flex-wrap: wrap;
}

.ap-toolbar-left {
  display: flex;
  align-items: center;
  gap: 8px;
  min-width: 0;
}

.ap-toolbar-right {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
  justify-content: flex-end;
}

.ap-table-wrap {
  width: 100%;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}

.ap-table {
  width: 100%;
  min-width: 760px;
  border-collapse: separate;
  border-spacing: 0;
}

.ap-table th,
.ap-table td {
  vertical-align: middle;
  white-space: nowrap;
}

.ap-table td.col-year,
.ap-table td.col-semester {
  white-space: normal;
}

.ap-actions {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.ap-empty {
  padding: 3rem 1rem;
}

@media (max-width: 1023px) {
  .ap-toolbar {
    align-items: stretch;
  }

  .ap-toolbar-right {
    width: 100%;
    justify-content: flex-start;
  }
}

@media (max-width: 767px) {
  #mainContent {
    padding-left: 0.9rem !important;
    padding-right: 0.9rem !important;
    padding-top: 74px !important;
  }

  .active-banner-inner {
    padding: 1rem;
  }

  .ap-toolbar {
    flex-direction: column;
    align-items: stretch;
  }

  .ap-toolbar-left,
  .ap-toolbar-right {
    width: 100%;
  }

  .ap-toolbar-right {
    flex-direction: column;
    align-items: stretch;
    gap: 8px;
  }

  .search-wrap,
  .filter-select,
  .filter-btn,
  .reset-btn {
    width: 100% !important;
  }

  .filter-select,
  .filter-btn,
  .reset-btn {
    justify-content: center;
  }

  .ap-table {
    min-width: 640px;
  }

  .ap-table th,
  .ap-table td {
    padding: 10px 12px !important;
    font-size: 12px;
  }

  .ap-table thead th:nth-child(4),
  .ap-table tbody td:nth-child(4),
  .ap-table thead th:nth-child(5),
  .ap-table tbody td:nth-child(5) {
    display: none;
  }

  .ap-actions {
    gap: 6px;
  }

  .act {
    width: 28px;
    height: 28px;
  }

  .sem-pill,
  .status-badge {
    font-size: 10px !important;
  }
}

</style>
@endsection

@php
$calendarPeriodsPayload = collect($calendarPeriods ?? [])
->sortBy('start_date')
->map(function ($period) {
return [
'id' => $period->id,
'academic_year' => $period->academic_year,
'semester' => $period->semester,
'start_date' => optional($period->start_date)->format('Y-m-d'),
'end_date' => optional($period->end_date)->format('Y-m-d'),
];
})
->values()
->all();

$holidayEvents = collect($holidays ?? [])
->map(function ($name, $date) {
return [
'date' => $date,
'label' => $name,
'year' => date('Y', strtotime($date)),
'color' => '#6b7280',
'type' => 'holiday',
];
})
->values()
->all();

$activePeriodPayload = $activePeriod
? [
'id' => $activePeriod->id,
'academic_year' => $activePeriod->academic_year,
'semester' => $activePeriod->semester,
'start_date' => optional($activePeriod->start_date)->format('Y-m-d'),
'end_date' => optional($activePeriod->end_date)->format('Y-m-d'),
'description' => $activePeriod->description,
'is_active' => (bool) $activePeriod->is_active,
]
: null;
@endphp

@section('content')
<main id="mainContent"
  style="padding-top:82px; padding-bottom:2rem; padding-left:1.5rem; padding-right:1.5rem; min-height:100vh;">
  <div style="max-width:1280px; margin:0 auto;">

    @if (session('success'))
    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
      {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
      <div class="font-bold mb-1">Please fix the following:</div>
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <div class="mb-6">
      <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
        <i class="fa-solid fa-sun text-yellow-400 text-xs" id="timeIcon"></i>
        <p id="currentDateTime"></p>
      </div>
      <div class="flex items-end justify-between flex-wrap gap-3">
        <h1 class="text-3xl md:text-4xl font-extrabold text-[#8B0000]">Academic Periods</h1>
        <button onclick="openModal('addModal')" type="button"
          class="flex items-center gap-2 bg-[#8B0000] hover:bg-[#760000] text-white px-5 py-2.5 rounded-lg font-semibold text-sm shadow transition-all">
          <i class="fa-solid fa-plus"></i> Add Period
        </button>
      </div>
    </div>

    <div class="active-banner mb-6" id="activeBannerWrap">
      <div class="active-banner-inner">
        <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-5">
          <div>
            <div class="flex items-center gap-2 mb-1">
              <i class="fa-solid fa-calendar text-[#8B0000] text-sm"></i>
              <p class="text-[10px] tracking-widest text-gray-500 uppercase font-semibold">Current
                Semester</p>
            </div>
            <p class="text-xl font-bold text-gray-800" id="bannerSem">
              {{ $activePeriod?->semester ??
              'No Active
              Period' }}
            </p>
          </div>
          <div>
            <div class="flex items-center gap-2 mb-1">
              <i class="fa-solid fa-graduation-cap text-[#8B0000] text-sm"></i>
              <p class="text-[10px] tracking-widest text-gray-500 uppercase font-semibold">Academic Year
              </p>
            </div>
            <p class="text-xl font-bold text-gray-800" id="bannerYear">
              {{ $activePeriod?->academic_year ?? '—' }}</p>
          </div>
          <div>
            <div class="flex items-center gap-2 mb-1">
              <i class="fa-solid fa-clock text-[#8B0000] text-sm"></i>
              <p class="text-[10px] tracking-widest text-gray-500 uppercase font-semibold">Period Ends</p>
            </div>
            <p class="text-xl font-bold text-gray-800" id="bannerEnd">
              {{ $activePeriod ? $activePeriod->end_date->format('F d, Y') : '—' }}</p>
          </div>
        </div>

        <div class="flex flex-col gap-3 lg:flex-shrink-0 lg:w-64">
          <div>
            <div class="flex justify-between items-center mb-1.5">
              <span class="text-[10px] text-gray-500 uppercase tracking-widest font-semibold">Semester
                Progress</span>
              <span class="text-[11px] font-bold text-[#8B0000]" id="bannerPct">{{ $activePeriod?->progress_percent ?? 0
                }}%</span>
            </div>
            <div class="progress-track">
              <div class="progress-fill" id="bannerFill" style="width:{{ $activePeriod?->progress_percent ?? 0 }}%;">
              </div>
            </div>
            <p class="text-[10px] text-gray-400 mt-1" id="bannerDaysLeft">
              {{ $activePeriod
              ? $activePeriod->days_remaining . ' day' . ($activePeriod->days_remaining !== 1 ? 's' : '') . ' remaining'
              : 'No active period' }}
            </p>
          </div>

          <button type="button" onclick='@if ($activePeriodPayload) openEditModal(@json($activePeriodPayload)) @endif'
            class="bg-[#8B0000] hover:bg-[#760000] text-white px-5 py-2.5 rounded-lg font-semibold text-sm shadow transition-all flex items-center justify-center gap-2">
            <i class="fa-solid fa-gear"></i> Manage Period
          </button>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
      <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">

          <div class="px-5 py-4 border-b bg-gray-50 ap-toolbar">
            <div class="ap-toolbar-left">
              <i class="fa-solid fa-school text-[#8B0000]"></i>
              <h2 class="font-bold text-gray-800 text-sm">All Academic Periods</h2>
              <span id="periodCount" class="text-[10px] font-bold bg-[#8B0000] text-white px-2 py-0.5 rounded-full">
                {{ $academicPeriods->total() }}
              </span>
            </div>

            <form method="GET" action="{{ route('admin.academic_periods') }}" id="filterForm" class="ap-toolbar-right">

              <div class="search-wrap" style="width:220px;">
                <i class="fa fa-search"></i>
                <input id="searchInput" name="search" type="text" placeholder="Search periods…"
                  value="{{ request('search') }}" autocomplete="off">
                <button type="button" id="clearSearch" class="search-clear-btn {{ request('search') ? 'visible' : '' }}"
                  title="Clear">
                  <i class="fa-solid fa-xmark"></i>
                </button>
              </div>

              <select name="semester" class="filter-select" onchange="this.form.submit()">
                <option value="">All Semesters</option>
                <option value="1st Semester" {{ request('semester')==='1st Semester' ? 'selected' : '' }}>1st Semester
                </option>
                <option value="2nd Semester" {{ request('semester')==='2nd Semester' ? 'selected' : '' }}>2nd Semester
                </option>
                <option value="Summer" {{ request('semester')==='Summer' ? 'selected' : '' }}>Summer</option>
              </select>

              <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="Active" {{ request('status')==='Active' ? 'selected' : '' }}>Active</option>
                <option value="Upcoming" {{ request('status')==='Upcoming' ? 'selected' : '' }}>Upcoming</option>
                <option value="Ended" {{ request('status')==='Ended' ? 'selected' : '' }}>Ended</option>
                <option value="Inactive" {{ request('status')==='Inactive' ? 'selected' : '' }}>Inactive</option>
              </select>

              <button type="submit" class="filter-btn">Filter</button>

              <a href="{{ route('admin.academic_periods') }}" class="reset-btn">
                Reset
              </a>
            </form>
          </div>

          <div class="ap-table-wrap scrollbar-thin">
            <table class="ap-table text-sm">
              <thead class="bg-gray-50 border-b border-gray-100">
                <tr class="text-[10px] uppercase tracking-wide text-[#8B0000] font-bold">
                  <th class="py-3 px-4 text-left">#</th>
                  <th class="py-3 px-4 text-left">Year</th>
                  <th class="py-3 px-4 text-left">Semester</th>
                  <th class="py-3 px-4 text-left">Start</th>
                  <th class="py-3 px-4 text-left">End</th>
                  <th class="py-3 px-4 text-center">Status</th>
                  <th class="py-3 px-4 text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($academicPeriods as $index => $period)
                @php
                $statusClass = match ($period->status) {
                'Active' => 's-active',
                'Upcoming' => 's-upcoming',
                'Ended' => 's-ended',
                default => 's-inactive',
                };

                $semStyle = match ($period->semester) {
                '1st Semester' => ['bg' => '#fee2e2', 'color' => '#8B0000'],
                '2nd Semester' => ['bg' => '#dbeafe', 'color' => '#1d4ed8'],
                'Summer' => ['bg' => '#fef3c7', 'color' => '#92400e'],
                default => ['bg' => '#f3f4f6', 'color' => '#6b7280'],
                };

                $periodPayload = [
                'id' => $period->id,
                'academic_year' => $period->academic_year,
                'semester' => $period->semester,
                'start_date' => optional($period->start_date)->format('Y-m-d'),
                'end_date' => optional($period->end_date)->format('Y-m-d'),
                'description' => $period->description,
                'is_active' => (bool) $period->is_active,
                ];
                @endphp

                <tr class="tbl-row {{ $period->is_active ? 'is-active' : '' }} border-b border-gray-50 last:border-0">
                  <td class="py-3 px-4 text-sm">{{ $academicPeriods->firstItem() + $index }}</td>

                  <td class="py-3 px-4 col-year">
                    <div class="flex items-center">
                      @if ($period->is_active)
                      <span class="dot-pulse"
                        style="display:inline-block;width:7px;height:7px;border-radius:50%;background:#22c55e;margin-right:6px;"></span>
                      @else
                      <span
                        style="display:inline-block;width:7px;height:7px;border-radius:50%;background:#e5e7eb;margin-right:6px;"></span>
                      @endif
                      <span class="font-bold text-sm">{{ $period->academic_year }}</span>
                    </div>
                  </td>

                  <td class="py-3 px-4 col-semester">
                    <span class="sem-pill" style="background:{{ $semStyle['bg'] }};color:{{ $semStyle['color'] }};">
                      <i class="fa-solid {{ $period->semester === 'Summer' ? 'fa-sun' : 'fa-book' }}"
                        style="font-size:9px;"></i>
                      {{ $period->semester }}
                    </span>
                  </td>

                  <td class="py-3 px-4 text-xs text-gray-600">
                    {{ optional($period->start_date)->format('M d, Y') }}
                  </td>
                  <td class="py-3 px-4 text-xs text-gray-600">
                    {{ optional($period->end_date)->format('M d, Y') }}</td>

                  <td class="py-3 px-4 text-center">
                    <span class="status-badge {{ $statusClass }}"
                      style="display:inline-flex;align-items:center;gap:3px;font-size:11px;font-weight:700;padding:3px 9px;border-radius:99px;">
                      {{ $period->status }}
                    </span>
                  </td>

                  <td class="py-3 px-4">
                    <div class="ap-actions">
                      <button type="button" class="act act-edit" title="Edit"
                        onclick='openEditModal(@json($periodPayload))'>
                        <i class="fa-solid fa-pen"></i>
                      </button>

                      @if (!$period->is_active)
                      <form method="POST" action="{{ route('admin.academic_periods.set_active', $period) }}"
                        class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="act act-star" title="Set as active">
                          <i class="fa-solid fa-circle-check" style="font-size:10px;"></i>
                        </button>
                      </form>
                      @else
                      <span class="act act-pinned"><i class="fa-solid fa-star" style="font-size:10px;"></i></span>
                      @endif

                      <button type="button" class="act act-del" title="Delete"
                        onclick='openDeleteModal(@json(route("admin.academic_periods.destroy", $period)), @json($period->academic_year . " — " . $period->semester))'>
                        <i class="fa-solid fa-trash" style="font-size:10px;"></i>
                      </button>
                    </div>
                  </td>
                </tr>
                @empty
                <tr id="serverEmptyState">
                  <td colspan="7" class="text-center text-gray-400 ap-empty">
                    <div class="flex flex-col items-center justify-center text-center">
                      <i class="fa-solid fa-school text-3xl mb-3 opacity-30 block"></i>
                      <p class="text-sm font-medium">No academic periods found.</p>
                    </div>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="px-5 py-3.5 border-t border-gray-100 bg-gray-50 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <p class="text-xs text-gray-500">
              Showing
              <strong>{{ $academicPeriods->firstItem() ?? 0 }}–{{ $academicPeriods->lastItem() ?? 0 }}</strong>
              of <strong>{{ $academicPeriods->total() }}</strong> periods
            </p>

            <div class="overflow-x-auto scrollbar-thin w-full md:w-auto">
              {{ $academicPeriods->onEachSide(2)->links('vendor.pagination.tailwind') }}
            </div>
          </div>
        </div>
      </div>

      <div class="space-y-5">

        {{-- 1. Quick Actions (moved to top) --}}
        <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
          <div class="px-5 py-4 border-b bg-gray-50 flex items-center gap-2">
            <i class="fa-solid fa-bolt text-[#8B0000]"></i>
            <h2 class="font-bold text-gray-800 text-sm">Quick Actions</h2>
          </div>
          <div class="p-4 space-y-2.5">
            <button onclick="openModal('addModal')" type="button"
              class="w-full flex items-center gap-3 bg-gradient-to-r from-red-50 to-white hover:from-red-100 hover:to-red-50 border border-red-100 rounded-lg px-4 py-3 text-left transition-all group">
              <div
                class="w-10 h-10 rounded-lg bg-white border border-red-200 flex items-center justify-center text-[#8B0000] shadow-sm group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-plus"></i>
              </div>
              <div class="flex-1">
                <div class="font-bold text-sm text-[#8B0000]">Add Period</div>
                <div class="text-[10px] text-gray-500">Create a new academic term</div>
              </div>
              <i
                class="fa-solid fa-chevron-right text-gray-300 text-xs group-hover:text-[#8B0000] group-hover:translate-x-1 transition-all"></i>
            </button>

            <button type="button" onclick='@if ($activePeriodPayload) openEditModal(@json($activePeriodPayload)) @endif'
              class="w-full flex items-center gap-3 bg-gradient-to-r from-red-50 to-white hover:from-red-100 hover:to-red-50 border border-red-100 rounded-lg px-4 py-3 text-left transition-all group">
              <div
                class="w-10 h-10 rounded-lg bg-white border border-red-200 flex items-center justify-center text-[#8B0000] shadow-sm group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-pen"></i>
              </div>
              <div class="flex-1">
                <div class="font-bold text-sm text-[#8B0000]">Edit Active Period</div>
                <div class="text-[10px] text-gray-500">Modify current semester</div>
              </div>
              <i
                class="fa-solid fa-chevron-right text-gray-300 text-xs group-hover:text-[#8B0000] group-hover:translate-x-1 transition-all"></i>
            </button>
          </div>
        </div>

        {{-- 2. Date & Time --}}
        <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
          <div class="px-5 py-4 border-b bg-gray-50 flex items-center gap-2">
            <i class="fa-solid fa-clock text-[#8B0000]"></i>
            <h2 class="font-bold text-gray-800 text-sm">Date &amp; Time</h2>
            <span class="ml-auto text-[10px] text-gray-400 font-semibold">Philippine Time</span>
          </div>
          <div class="p-5 text-center">
            <div id="liveClock" class="text-4xl font-extrabold text-[#8B0000] tracking-tight leading-none mb-1">
              00:00:00</div>
            <div id="liveAmPm" class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">AM
            </div>
            <div id="liveDate" class="text-sm font-semibold text-gray-700 mb-1"></div>
            <div id="liveDay" class="text-xs text-gray-400"></div>
          </div>
        </div>

        {{-- 3. Calendar --}}
        <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden cal-card">
          <div class="px-5 py-4 border-b bg-gray-50 flex items-center justify-between">
            <div class="flex items-center gap-2">
              <i class="fa-solid fa-calendar-days text-[#8B0000]"></i>
              <h2 class="font-bold text-gray-800 text-sm">PUP Academic Calendar</h2>
            </div>
            <span id="calYear" class="text-[10px] font-bold text-[#8B0000] bg-red-50 px-2 py-0.5 rounded-full">Academic
              Periods</span>
          </div>
          <div id="calendarList" class="p-4 space-y-1 overflow-y-auto scrollbar-thin" style="max-height:485px;"></div>
          <div class="px-4 pb-4">
            <a href="https://www.pup.edu.ph/calendar/" target="_blank"
              class="flex items-center justify-center gap-2 w-full py-2 rounded-lg border border-gray-200 text-xs font-semibold text-gray-500 hover:bg-red-50 hover:border-[#8B0000] hover:text-[#8B0000] transition-all mt-2">
              <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
              View Full PUP Calendar
            </a>
          </div>
        </div>

      </div>
    </div>
  </div>
</main>

<div class="modal-overlay" id="addModal" onclick="closeModalOutside(event,'addModal')">
  <div class="modal-box">
    <form method="POST" action="{{ route('admin.academic_periods.store') }}">
      @csrf

      <div
        class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white rounded-t-2xl z-10">
        <div class="flex items-center gap-3">
          <div
            class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#8B0000] to-[#6B0000] flex items-center justify-center shadow">
            <i class="fa-solid fa-plus text-white text-sm"></i>
          </div>
          <div>
            <h3 class="font-extrabold text-gray-800 text-base">Add Academic Period</h3>
            <p class="text-[10px] text-gray-500">Define a new semester or academic term</p>
          </div>
        </div>
        <button type="button" onclick="closeModal('addModal')"
          class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-[#8B0000] transition-all">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <div class="p-6 space-y-4">
        <div>
          <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Academic
            Year <span class="text-red-500">*</span></label>
          <div class="relative">
            <i class="fa-solid fa-graduation-cap absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input name="academic_year" type="text" placeholder="e.g. 2026-2027"
              class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm" required>
            <span class="field-error sem-error"></span>
          </div>
        </div>

        <div>
          <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-2">Semester
            <span class="text-red-500">*</span></label>
          <div class="grid grid-cols-3 gap-2">
            <label class="cursor-pointer">
              <input type="radio" name="semester" value="1st Semester" class="sr-only peer" required>
              <div
                class="peer-checked:bg-[#8B0000] peer-checked:text-white peer-checked:border-[#8B0000] border-2 border-gray-200 rounded-xl p-3 text-center text-xs font-bold text-gray-500 hover:border-[#8B0000] hover:text-[#8B0000] transition-all select-none">
                <i class="fa-solid fa-book block text-xl mb-1.5"></i>1st Semester
              </div>
            </label>

            <label class="cursor-pointer">
              <input type="radio" name="semester" value="2nd Semester" class="sr-only peer" required>
              <div
                class="peer-checked:bg-[#8B0000] peer-checked:text-white peer-checked:border-[#8B0000] border-2 border-gray-200 rounded-xl p-3 text-center text-xs font-bold text-gray-500 hover:border-[#8B0000] hover:text-[#8B0000] transition-all select-none">
                <i class="fa-solid fa-book block text-xl mb-1.5"></i>2nd Semester
              </div>
            </label>

            <label class="cursor-pointer">
              <input type="radio" name="semester" value="Summer" class="sr-only peer" required>
              <div
                class="peer-checked:bg-[#8B0000] peer-checked:text-white peer-checked:border-[#8B0000] border-2 border-gray-200 rounded-xl p-3 text-center text-xs font-bold text-gray-500 hover:border-[#8B0000] hover:text-[#8B0000] transition-all select-none">
                <i class="fa-solid fa-sun block text-xl mb-1.5"></i>Summer
              </div>
            </label>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Start
              Date <span class="text-red-500">*</span></label>
            <div class="relative">
              <i class="fa-solid fa-calendar-day absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
              <input name="start_date" type="date"
                class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm" required>
              <span class="field-error"></span>
            </div>
          </div>

          <div>
            <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">End
              Date <span class="text-red-500">*</span></label>
            <div class="relative">
              <i class="fa-solid fa-calendar-check absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
              <input name="end_date" type="date"
                class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm" required>
              <span class="field-error"></span>
            </div>
          </div>
        </div>

        <div>
          <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Description</label>
          <textarea name="description" rows="2"
            class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm resize-none"></textarea>
        </div>

        <div class="flex items-center justify-between rounded-xl border border-gray-200 bg-gray-50 px-4 py-3">
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-star text-[#8B0000]"></i>
            <div>
              <div class="text-sm font-semibold text-gray-700">Set as Active Period</div>
              <div class="text-[10px] text-gray-400">Deactivates the current active period</div>
            </div>
          </div>

          <label class="relative inline-flex items-center cursor-pointer">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" class="sr-only peer">
            <div
              class="w-10 h-5 bg-gray-200 rounded-full peer peer-checked:bg-[#8B0000] transition-colors after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-5">
            </div>
          </label>
        </div>
      </div>

      <div class="px-6 pb-6 pt-2 flex items-center justify-end gap-3">
        <button type="button" onclick="closeModal('addModal')"
          class="px-5 py-2.5 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">Cancel</button>
        <button type="submit"
          class="px-6 py-2.5 rounded-lg bg-[#8B0000] hover:bg-[#760000] text-white text-sm font-bold shadow transition-all flex items-center gap-2">
          <i class="fa-solid fa-floppy-disk"></i> Save Period
        </button>
      </div>
    </form>
  </div>
</div>

<div class="modal-overlay" id="editModal" onclick="closeModalOutside(event,'editModal')">
  <div class="modal-box">
    <form method="POST" id="editForm">
      @csrf
      @method('PUT')

      <div
        class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white rounded-t-2xl z-10">
        <div class="flex items-center gap-3">
          <div
            class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow">
            <i class="fa-solid fa-pen text-white text-sm"></i>
          </div>
          <div>
            <h3 class="font-extrabold text-gray-800 text-base">Edit Academic Period</h3>
            <p class="text-[10px] text-gray-500" id="editSubtitle">Updating period details</p>
          </div>
        </div>
        <button type="button" onclick="closeModal('editModal')"
          class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-[#8B0000] transition-all">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <div class="p-6 space-y-4">
        <div>
          <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Academic
            Year</label>
          <input type="text" name="academic_year" id="editYear"
            class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm" required>
        </div>

        <div>
          <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-2">Semester</label>
          <div class="grid grid-cols-3 gap-2">
            <label class="cursor-pointer">
              <input type="radio" name="semester" value="1st Semester" class="sr-only peer edit-sem" required>
              <div
                class="peer-checked:bg-[#8B0000] peer-checked:text-white peer-checked:border-[#8B0000] border-2 border-gray-200 rounded-xl p-3 text-center text-xs font-bold text-gray-500">
                1st Semester</div>
            </label>
            <label class="cursor-pointer">
              <input type="radio" name="semester" value="2nd Semester" class="sr-only peer edit-sem" required>
              <div
                class="peer-checked:bg-[#8B0000] peer-checked:text-white peer-checked:border-[#8B0000] border-2 border-gray-200 rounded-xl p-3 text-center text-xs font-bold text-gray-500">
                2nd Semester</div>
            </label>
            <label class="cursor-pointer">
              <input type="radio" name="semester" value="Summer" class="sr-only peer edit-sem" required>
              <div
                class="peer-checked:bg-[#8B0000] peer-checked:text-white peer-checked:border-[#8B0000] border-2 border-gray-200 rounded-xl p-3 text-center text-xs font-bold text-gray-500">
                Summer</div>
            </label>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Start
              Date</label>
            <input type="date" name="start_date" id="editStart"
              class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm" required>
          </div>
          <div>
            <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">End
              Date</label>
            <input type="date" name="end_date" id="editEnd"
              class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm" required>
          </div>
        </div>

        <div>
          <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Description</label>
          <textarea rows="2" name="description" id="editDesc"
            class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm resize-none"></textarea>
        </div>

        <div class="flex items-center justify-between rounded-xl border border-gray-200 bg-gray-50 px-4 py-3">
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-star text-[#8B0000]"></i>
            <div>
              <div class="text-sm font-semibold text-gray-700">Set as Active Period</div>
              <div class="text-[10px] text-gray-400">Deactivates the current active period</div>
            </div>
          </div>

          <label class="relative inline-flex items-center cursor-pointer">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" id="editIsActive" value="1" class="sr-only peer">
            <div
              class="w-10 h-5 bg-gray-200 rounded-full peer peer-checked:bg-[#8B0000] transition-colors after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-5">
            </div>
          </label>
        </div>
      </div>

      <div class="px-6 pb-6 pt-2 flex items-center justify-end gap-3">
        <button type="button" onclick="closeModal('editModal')"
          class="px-5 py-2.5 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">Cancel</button>
        <button type="submit"
          class="px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold shadow transition-all flex items-center gap-2">
          <i class="fa-solid fa-floppy-disk"></i> Update Period
        </button>
      </div>
    </form>
  </div>
</div>

<div class="modal-overlay modal-sm" id="deleteModal" onclick="closeModalOutside(event,'deleteModal')">
  <div class="modal-box">
    <form method="POST" id="deleteForm">
      @csrf
      @method('DELETE')

      <div class="p-6 text-center">
        <div
          class="w-16 h-16 rounded-2xl bg-red-50 border border-red-100 flex items-center justify-center mx-auto mb-4">
          <i class="fa-solid fa-triangle-exclamation text-[#8B0000] text-2xl"></i>
        </div>
        <h3 class="text-lg font-extrabold text-gray-800 mb-2">Delete Academic Period?</h3>
        <p class="text-sm text-gray-500 mb-1">You are about to permanently delete</p>
        <p class="font-bold text-[#8B0000] text-base mb-4" id="deletePeriodLabel">—</p>

        <div class="flex gap-3">
          <button type="button" onclick="closeModal('deleteModal')"
            class="flex-1 py-2.5 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">Cancel</button>
          <button type="submit"
            class="flex-1 py-2.5 rounded-lg bg-[#8B0000] hover:bg-[#760000] text-white text-sm font-bold shadow transition-all">
            <i class="fa-solid fa-trash mr-1.5"></i> Delete
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
  /* ── ADD PERIOD FORM VALIDATION ── */
  document.addEventListener('DOMContentLoaded', () => {
    const addForm = document.querySelector('#addModal form');
    if (!addForm) return;

    const yearInput = addForm.querySelector('[name="academic_year"]');
    const startInput = addForm.querySelector('[name="start_date"]');
    const endInput = addForm.querySelector('[name="end_date"]');
    const semRadios = addForm.querySelectorAll('[name="semester"]');

    /* -- helpers -- */
    function getErr(field) {
      return field.parentElement.parentElement.querySelector('.field-error')
        || field.parentElement.querySelector('.field-error');
    }

    function setError(field, msg) {
      field.classList.add('field-invalid');
      field.classList.remove('field-valid');
      const err = getErr(field);
      if (err) { err.textContent = '⚠ ' + msg; err.classList.add('show'); }
    }

    function clearError(field) {
      field.classList.remove('field-invalid');
      const err = getErr(field);
      if (err) err.classList.remove('show');
    }

    function setValid(field) {
      field.classList.remove('field-invalid');
      field.classList.add('field-valid');
      const err = getErr(field);
      if (err) err.classList.remove('show');
    }

    function validateYear() {
      const v = yearInput.value.trim();
      const pattern = /^\d{4}-\d{4}$/;
      if (!v) { setError(yearInput, 'Academic year is required.'); return false; }
      if (!pattern.test(v)) { setError(yearInput, 'Format must be YYYY-YYYY (e.g. 2025-2026).'); return false; }
      const [y1, y2] = v.split('-').map(Number);
      if (y2 !== y1 + 1) { setError(yearInput, 'Second year must be one after the first.'); return false; }
      setValid(yearInput); return true;
    }

    function validateSemester() {
      const checked = [...semRadios].some(r => r.checked);
      const semErr = addForm.querySelector('.sem-error');
      if (!checked) { if (semErr) { semErr.textContent = '⚠ Please select a semester.'; semErr.classList.add('show'); } return false; }
      if (semErr) semErr.classList.remove('show');
      return true;
    }

    function validateDates() {
      let ok = true;
      const s = startInput.value;
      const e = endInput.value;
      const today = new Date().toISOString().split('T')[0];

      if (!s) { setError(startInput, 'Start date is required.'); ok = false; }
      else { setValid(startInput); }

      if (!e) { setError(endInput, 'End date is required.'); ok = false; }
      else if (s && e <= s) { setError(endInput, 'End date must be after start date.'); ok = false; }
      else { setValid(endInput); }

      return ok;
    }

    /* -- live listeners -- */
    yearInput.addEventListener('input', validateYear);
    yearInput.addEventListener('blur', validateYear);
    startInput.addEventListener('change', () => { validateDates(); });
    endInput.addEventListener('change', () => { validateDates(); });

    /* -- submit guard -- */
    addForm.addEventListener('submit', e => {
      const y = validateYear();
      const s = validateSemester();
      const d = validateDates();
      if (!y || !s || !d) e.preventDefault();
    });
  });

  //const calendarPeriods = @json($calendarPeriods);
  const calendarPeriods = @json($calendarPeriodsPayload);
  const holidayEvents = @json($holidayEvents);

  function renderCalendar() {
    const list = document.getElementById('calendarList');
    const calYear = document.getElementById('calYear');
    if (!list) return;

    const periodEvents = [];

    calendarPeriods.forEach(period => {
      if (period.start_date) {
        periodEvents.push({
          date: period.start_date,
          label: `${period.semester} Start`,
          year: period.academic_year,
          color: '#8B0000',
          type: 'start'
        });
      }

      if (period.end_date) {
        periodEvents.push({
          date: period.end_date,
          label: `${period.semester} End`,
          year: period.academic_year,
          color: '#2563eb',
          type: 'end'
        });
      }
    });

    const events = [...periodEvents, ...holidayEvents].sort((a, b) => a.date.localeCompare(b.date));
    const today = todayStr();
    const show = events.sort((a, b) => a.date.localeCompare(b.date));

    if (show.length) {
      const years = [...new Set(show.map(e => e.year))];
      calYear.textContent = years.length === 1 ? years[0] : 'Academic Periods & Holidays';
    } else {
      calYear.textContent = 'Academic Periods & Holidays';
    }

    if (!show.length) {
      list.innerHTML = '<p class="text-xs text-gray-400 text-center py-3">No events found</p>';
      return;
    }

    list.innerHTML = show.map(e => {
      const d = new Date(e.date + 'T00:00:00');
      const isToday = e.date === today;
      const isPast = e.date < today;
      const mon = d.toLocaleDateString('en-US', {
        month: 'short'
      });
      const day = d.getDate();
      const isHoliday = e.type === 'holiday';
      let color = e.color;

      if (e.type === 'holiday') color = '#16a34a';
      if (e.type === 'start') color = '#8B0000';
      if (e.type === 'end') color = '#2563eb';

      return `
          <div class="flex items-start gap-3 py-2 border-b border-gray-50 last:border-0 ${isPast ? 'opacity-50' : ''}">
            <div style="flex-shrink:0;width:38px;text-align:center;background:${isToday ? '#8B0000' : isHoliday ? '#f3f4f6' : '#fef2f2'};
                        border-radius:8px;padding:4px 2px;border:1px solid ${isToday ? '#8B0000' : isHoliday ? '#e5e7eb' : '#fde8e8'}">
              <div style="font-size:9px;font-weight:700;text-transform:uppercase;color:${isToday ? 'rgba(255,255,255,.8)' : isHoliday ? '#6b7280' : '#8B0000'};">${mon}</div>
              <div style="font-size:16px;font-weight:900;line-height:1;color:${isToday ? '#fff' : isHoliday ? '#374151' : '#8B0000'};">${day}</div>
            </div>
            <div style="flex:1;min-width:0;">
              <div style="font-size:12px;font-weight:${isToday ? '700' : '600'};color:${isToday ? '#8B0000' : '#374151'};white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                ${e.label}
              </div>
              <div style="font-size:10px;color:#9ca3af;margin-top:1px;">
                ${e.year}${isHoliday ? ' • Holiday' : ''}${isToday ? ' • Today' : ''}
              </div>
            </div>
            <div style="width:8px;height:8px;border-radius:50%;background:${color};flex-shrink:0;margin-top:4px;"></div>
          </div>
        `;
    }).join('');
  }

  function todayStr() {
    const now = new Date();
    const ph = new Date(now.toLocaleString('en-US', {
      timeZone: 'Asia/Manila'
    }));
    return `${ph.getFullYear()}-${String(ph.getMonth() + 1).padStart(2, '0')}-${String(ph.getDate()).padStart(2, '0')}`;
  }

  function openModal(id) {
    document.getElementById(id).classList.add('open');
  }

  function closeModal(id) {
    document.getElementById(id).classList.remove('open');
  }

  function closeModalOutside(e, id) {
    if (e.target.id === id) {
      closeModal(id);
    }
  }

  function openEditModal(period) {
    document.getElementById('editForm').action = `/admin/academic-periods/${period.id}`;
    document.getElementById('editYear').value = period.academic_year ?? '';
    document.getElementById('editStart').value = period.start_date ?? '';
    document.getElementById('editEnd').value = period.end_date ?? '';
    document.getElementById('editDesc').value = period.description ?? '';
    document.getElementById('editIsActive').checked = !!period.is_active;
    document.getElementById('editSubtitle').textContent = `${period.academic_year} — ${period.semester}`;

    document.querySelectorAll('.edit-sem').forEach(radio => {
      radio.checked = radio.value === period.semester;
    });

    openModal('editModal');
  }

  function openDeleteModal(action, label) {
    document.getElementById('deleteForm').action = action;
    document.getElementById('deletePeriodLabel').textContent = label;
    openModal('deleteModal');
  }

  function updateClock() {
    const now = new Date();
    const ph = new Date(now.toLocaleString('en-US', {
      timeZone: 'Asia/Manila'
    }));
    let h = ph.getHours();
    const m = String(ph.getMinutes()).padStart(2, '0');
    const s = String(ph.getSeconds()).padStart(2, '0');
    const ampm = h >= 12 ? 'PM' : 'AM';
    h = h % 12 || 12;
    const hh = String(h).padStart(2, '0');

    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
      'October', 'November', 'December'
    ];

    const liveClock = document.getElementById('liveClock');
    const liveAmPm = document.getElementById('liveAmPm');
    const liveDate = document.getElementById('liveDate');
    const liveDay = document.getElementById('liveDay');
    const currentDateTime = document.getElementById('currentDateTime');
    const timeIcon = document.getElementById('timeIcon');

    if (liveClock) liveClock.textContent = `${hh}:${m}:${s}`;
    if (liveAmPm) liveAmPm.textContent = ampm;
    if (liveDate) liveDate.textContent = `${months[ph.getMonth()]} ${ph.getDate()}, ${ph.getFullYear()}`;
    if (liveDay) liveDay.textContent = days[ph.getDay()];
    if (currentDateTime) currentDateTime.textContent =
      `${days[ph.getDay()]}, ${months[ph.getMonth()]} ${ph.getDate()}, ${ph.getFullYear()} · ${hh}:${m} ${ampm}`;

    if (timeIcon) {
      if (ph.getHours() >= 6 && ph.getHours() < 18) {
        timeIcon.className = 'fa-solid fa-sun text-yellow-400 text-xs';
      } else {
        timeIcon.className = 'fa-solid fa-moon text-indigo-400 text-xs';
      }
    }
  }

  function clearAcademicSearch() {
      const searchInput = document.getElementById('searchInput');
      const clearBtn = document.getElementById('clearSearch');

      if (searchInput) searchInput.value = '';
      if (clearBtn) clearBtn.classList.remove('visible');

      const rows = document.querySelectorAll('tbody tr.tbl-row');
      rows.forEach(row => row.style.display = '');

      const jsEmpty = document.getElementById('jsEmptyState');
      if (jsEmpty) jsEmpty.style.display = 'none';

      const serverEmpty = document.getElementById('serverEmptyState');
      if (serverEmpty) {
  const hasRows = rows.length > 0;
  serverEmpty.style.display = hasRows ? 'none' : '';
}

      if (searchInput) searchInput.focus();
    }

  document.addEventListener('DOMContentLoaded', () => {
    updateClock();
    renderCalendar();
    setInterval(updateClock, 1000);
  });

  // ── LIVE SEARCH ──
  document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const clearBtn = document.getElementById('clearSearch');
    const tbody = document.querySelector('tbody');
    const allRows = () => tbody.querySelectorAll('tr.tbl-row');
    let searchTimer = null;

    function getEmptyRow() {
      return document.getElementById('jsEmptyState');
    }

    function showEmptyState(query) {
      let el = getEmptyRow();
      if (!el) {
        el = document.createElement('tr');
        el.id = 'jsEmptyState';
        el.innerHTML = `
          <td colspan="7" class="text-center py-12 text-gray-400">
            <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:1rem;text-align:center;gap:.5rem;">
              <div style="width:60px;height:60px;border-radius:16px;background:#f3f4f6;display:flex;align-items:center;justify-content:center;margin-bottom:.75rem;">
                <i class="fa-solid fa-magnifying-glass" style="font-size:1.6rem;color:#d1d5db;"></i>
              </div>
              <p class="font-semibold text-sm text-gray-500 mb-1">
                No results for "<span id="jsEmptyQuery"></span>"
              </p>
              <p class="text-xs text-gray-400">
                Try a different academic year or semester name.
              </p>
              <button
                type="button"
                onclick="clearAcademicSearch()"
                style="margin-top:.75rem;padding:.5rem 1.1rem;border-radius:10px;border:1.5px dashed #d1d5db;background:none;font-size:.8rem;color:#9ca3af;cursor:pointer;"
                onmouseover="this.style.borderColor='#8B0000';this.style.color='#8B0000';"
                onmouseout="this.style.borderColor='#d1d5db';this.style.color='#9ca3af';">
                <i class="fa-solid fa-xmark" style="margin-right:.4rem;font-size:.7rem;"></i>
                Clear search
              </button>
            </div>
          </td>`;
        tbody.appendChild(el);
      }

      document.getElementById('jsEmptyQuery').textContent = query;
      el.style.display = '';

      const serverEmpty = document.getElementById('serverEmptyState');
      if (serverEmpty) serverEmpty.style.display = 'none';
    }

    function hideEmptyState() {
      const el = getEmptyRow();
      if (el) el.style.display = 'none';

      const serverEmpty = document.getElementById('serverEmptyState');

      if (serverEmpty) {
        const rows = document.querySelectorAll('tbody tr.tbl-row');
        const hasRows = rows.length > 0;

        serverEmpty.style.display = hasRows ? 'none' : '';
      }
    }

    function doSearch(query) {
      const q = query.trim().toLowerCase();
      const rows = allRows();

      clearBtn.classList.toggle('visible', q !== '');

      if (q === '') {
        rows.forEach(r => r.style.display = '');
        hideEmptyState();
        return;
      }

      let visibleCount = 0;
      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(q)) {
          row.style.display = '';
          visibleCount++;
        } else {
          row.style.display = 'none';
        }
      });

      if (visibleCount === 0) {
        showEmptyState(query.trim());
      } else {
        hideEmptyState();
      }
    }

    clearBtn.addEventListener('click', () => {
      clearAcademicSearch();
    });

    searchInput.addEventListener('input', () => {
      clearTimeout(searchTimer);
      searchTimer = setTimeout(() => doSearch(searchInput.value), 250);
    });

    searchInput.addEventListener('keydown', e => {
      if (e.key === 'Enter') e.preventDefault();
    });

    if (searchInput.value) doSearch(searchInput.value);
  });
</script>
@endsection