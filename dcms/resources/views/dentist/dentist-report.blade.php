@extends('layouts.dentist')

@section('title', 'Reports & Analytics | PUP Taguig Dental Clinic')

@section('styles')
<style>
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
    animation: fadeIn .6s ease-out forwards;
  }

  .kpi-card {
    background: white;
    border-radius: 16px;
    padding: 18px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
    border: 1px solid #E5E7EB;
    transition: all .2s ease;
    text-decoration: none;
  }

  .kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(139, 0, 0, .08);
    border-color: #fca5a5;
  }

  .kpi-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
  }

  .kpi-value {
    font-size: 1.5rem;
    font-weight: 800;
    line-height: 1;
    color: #111827;
    margin-bottom: 4px;
  }

  .kpi-label {
    font-size: 0.65rem;
    font-weight: 700;
    color: #6B7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .kpi-delta {
    font-size: 0.7rem;
    font-weight: 600;
    margin-top: 4px;
    display: flex;
    align-items: center;
    gap: 3px;
  }

  .kpi-delta.up {
    color: #16a34a;
  }

  .kpi-delta.down {
    color: #dc2626;
  }

  .kpi-arrow {
    margin-left: auto;
    color: #D1D5DB;
    font-size: 0.8rem;
    transition: color .2s;
  }

  .kpi-card:hover .kpi-arrow {
    color: #8B0000;
  }

  .chart-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
    border: 1px solid #E5E7EB;
    padding: 20px;
    display: flex;
    flex-direction: column;
  }

  .chart-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
  }

  .chart-title {
    font-size: 0.9rem;
    font-weight: 700;
    color: #111827;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .chart-title i {
    color: #8B0000;
  }

  .period-select {
    font-size: 0.75rem;
    font-weight: 600;
    color: #1e293b;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 99px;
    padding: 6px 28px 6px 14px;
    cursor: pointer;
    outline: none;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2364748b'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    transition: all .2s ease;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
  }

  .period-select:hover {
    border-color: #94a3b8;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  }

  .period-select:focus {
    border-color: #8B0000;
    box-shadow: 0 0 0 2px rgba(139, 0, 0, 0.1);
  }

  .action-card {
    background: white;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: all .2s ease;
    cursor: pointer;
  }

  .action-card:hover {
    border-color: #8B0000;
    box-shadow: 0 4px 12px rgba(139, 0, 0, .05);
    transform: translateY(-2px);
  }

  .action-icon {
    width: 42px;
    height: 42px;
    background: #FFF5F5;
    color: #8B0000;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    transition: all .2s;
  }

  .action-card:hover .action-icon {
    background: #8B0000;
    color: white;
  }

  .stock-row {
    padding: 10px 0;
    border-bottom: 1px solid #F3F4F6;
  }

  .stock-row:last-child {
    border-bottom: none;
  }

  .stock-name {
    font-size: 0.8rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
    display: flex;
    justify-content: space-between;
  }

  .stock-bar-bg {
    height: 6px;
    background: #F3F4F6;
    border-radius: 10px;
    overflow: hidden;
  }

  .stock-bar-fill {
    height: 100%;
    border-radius: 10px;
    transition: width .8s cubic-bezier(.4, 0, .2, 1);
  }

  .chart-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    gap: 10px;
    color: #9CA3AF;
    text-align: center;
  }

  .chart-empty i {
    font-size: 2.5rem;
    color: #E5E7EB;
    margin-bottom: 4px;
  }

  .chart-empty p {
    font-size: 0.85rem;
    font-weight: 600;
    color: #6B7280;
    margin: 0;
  }

  .chart-empty span {
    font-size: 0.75rem;
    color: #9CA3AF;
  }

  .chart-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
  }

  .chart-loading i {
    font-size: 1.5rem;
    color: #8B0000;
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }

  @media (max-width: 1024px) {
    .kpi-grid {
      grid-template-columns: repeat(2, 1fr);
    }

    .main-dashboard-grid {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 767px) {

    /* Header layout */
    .page-title-row {
      flex-direction: column !important;
      align-items: flex-start !important;
      gap: 1rem !important;
    }

    .header-actions-container {
      width: 100% !important;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .header-actions-container button {
      width: 100% !important;
      justify-content: center !important;
    }

    .header-actions-container span {
      width: 100% !important;
      text-align: center !important;
    }

    /* KPI STATS FIX FOR MOBILE */
    .grid.grid-cols-2 {
      gap: 10px !important;
    }

    .kpi-card {
      padding: 12px 10px !important;
      /* Smaller padding */
      gap: 10px !important;
      flex-direction: row !important;
      /* Keep it side by side */
      align-items: center !important;
    }

    .kpi-icon {
      width: 36px !important;
      height: 36px !important;
      font-size: 14px !important;
      border-radius: 8px !important;
    }

    .kpi-value {
      font-size: 1.25rem !important;
      /* Smaller number */
      margin-bottom: 2px !important;
    }

    .kpi-label {
      font-size: 0.6rem !important;
      white-space: normal !important;
      /* Allows text to wrap instead of cutting off */
      line-height: 1.2 !important;
    }

    .kpi-delta {
      font-size: 0.55rem !important;
    }

    .kpi-arrow {
      display: none !important;
      /* Hide arrow on phone to give text more space */
    }
  }
</style>
@endsection

@section('content')

@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

<main id="mainContent" class="pt-[100px] px-3 md:px-6 py-6 min-h-screen flex-1">
  <div class="w-full fade-in">

    <div class="page-title-row flex items-start md:items-center justify-between mb-8">
      <div>
        <h2 class="text-xl md:text-2xl font-extrabold text-[#8B0000] tracking-tight leading-none mb-1.5">
          Reports & Analytics
        </h2>
      </div>
      <div class="header-actions-container flex flex-col items-end gap-2 mt-3 md:mt-0">
        <button onclick="document.getElementById('createReportModal').showModal()"
          class="bg-[#8B0000] hover:bg-[#6b0000] text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-sm transition-all flex items-center gap-2">
          <i class="fa-solid fa-plus"></i> Create Report
        </button>
        <span class="text-[11px] text-gray-400 font-medium">
          <i class="fa-regular fa-clock mr-1"></i> Last updated: {{ now()->format('M d, Y h:i A') }}
        </span>
      </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-5 mb-8">

      <a href="{{ route('dentist.dentist.patients') }}" class="kpi-card group">
        <div class="kpi-icon bg-red-50 group-hover:bg-[#8B0000] transition-colors"><i
            class="fa-solid fa-users text-[#8B0000] group-hover:text-white transition-colors"></i></div>
        <div class="flex-1 min-w-0">
          <div class="kpi-value">{{ $patientsThisMonth }}</div>
          <div class="kpi-label">Patients This Month</div>
          @if(!is_null($patientsDelta))
          <div class="kpi-delta {{ $patientsDelta >= 0 ? 'up' : 'down' }}">
            <i class="fa-solid fa-arrow-{{ $patientsDelta >= 0 ? 'up' : 'down' }}"></i> {{ abs($patientsDelta) }}%
          </div>
          @else
          <div class="kpi-delta text-gray-400 font-normal">No data last month</div>
          @endif
        </div>
        <i class="fa-solid fa-chevron-right kpi-arrow"></i>
      </a>

      <a href="{{ route('dentist.dentist.appointments') }}" class="kpi-card group">
        <div class="kpi-icon bg-amber-50 group-hover:bg-amber-500 transition-colors"><i
            class="fa-solid fa-calendar-check text-amber-600 group-hover:text-white transition-colors"></i></div>
        <div class="flex-1 min-w-0">
          <div class="kpi-value">{{ $appointmentsToday }}</div>
          <div class="kpi-label">Appointments Today</div>
          @if($appointmentsDelta > 0)
          <div class="kpi-delta up"><i class="fa-solid fa-arrow-up"></i> {{ $appointmentsDelta }} more</div>
          @elseif($appointmentsDelta < 0) <div class="kpi-delta down"><i class="fa-solid fa-arrow-down"></i> {{
            abs($appointmentsDelta) }} fewer
        </div>
        @else
        <div class="kpi-delta text-gray-400 font-normal">Same as yesterday</div>
        @endif
    </div>
    <i class="fa-solid fa-chevron-right kpi-arrow"></i>
    </a>

    <div class="kpi-card">
      <div class="kpi-icon bg-green-50"><i class="fa-solid fa-tooth text-green-600"></i></div>
      <div class="flex-1 min-w-0">
        <div class="kpi-value">{{ $casesThisMonth }}</div>
        <div class="kpi-label">Cases ({{ now()->format('M') }})</div>
        @if(!is_null($casesDelta))
        <div class="kpi-delta {{ $casesDelta >= 0 ? 'up' : 'down' }}">
          <i class="fa-solid fa-arrow-{{ $casesDelta >= 0 ? 'up' : 'down' }}"></i> {{ abs($casesDelta) }}%
        </div>
        @else
        <div class="kpi-delta text-gray-400 font-normal">No data last month</div>
        @endif
      </div>
    </div>

    <a href="{{ route('dentist.dentist.inventory') }}" class="kpi-card group !border-red-200 bg-red-50/30">
      <div class="kpi-icon bg-red-100 group-hover:bg-red-600 transition-colors"><i
          class="fa-solid fa-triangle-exclamation text-red-600 group-hover:text-white transition-colors"></i></div>
      <div class="flex-1 min-w-0">
        <div class="kpi-value text-red-600">{{ $lowStockItems }}</div>
        <div class="kpi-label text-red-800">Low Stock Items</div>
        @if($lowStockItems > 0)
        <div class="kpi-delta down"><i class="fa-solid fa-circle-exclamation"></i> Requires reorder</div>
        @else
        <div class="kpi-delta up"><i class="fa-solid fa-circle-check"></i> All stocked up</div>
        @endif
      </div>
      <i class="fa-solid fa-chevron-right kpi-arrow"></i>
    </a>

  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 md:gap-6 mb-8">

    @php
    $cleanPeriods = collect($periodOptions)->unique()->sortByDesc(function($date) {
    return \Carbon\Carbon::parse($date);
    });
    @endphp

    <div class="chart-card lg:col-span-1">
      <div class="chart-card-header">
        <span class="chart-title"><i class="fa-solid fa-chart-column"></i> GAD Report</span>
        <select class="period-select" id="gadPeriodSelect">
          @foreach($cleanPeriods as $opt) <option value="{{ $opt }}">{{ $opt }}</option> @endforeach
        </select>
      </div>
      <div id="gadChartWrap" class="relative flex-1 min-h-[260px]">
        <canvas id="gadChart"></canvas>
        <div id="gadEmptyState" class="chart-empty hidden absolute inset-0 bg-white">
          <i class="fa-solid fa-chart-column"></i>
          <p>No records found</p><span>for the selected period</span>
        </div>
        <div id="gadLoadingState" class="chart-loading hidden absolute inset-0 bg-white"><i
            class="fa-solid fa-spinner"></i></div>
      </div>
    </div>

    <div class="chart-card lg:col-span-1">
      <div class="chart-card-header">
        <span class="chart-title"><i class="fa-solid fa-chart-line"></i> Weekly Cases</span>
        <select class="period-select" id="weeklyPeriodSelect">
          @foreach($cleanPeriods as $opt) <option value="{{ $opt }}">{{ $opt }}</option> @endforeach
        </select>
      </div>
      <div id="weeklyChartWrap" class="relative flex-1 min-h-[260px]">
        <canvas id="weeklyDentalCasesChart"></canvas>
        <div id="weeklyEmptyState" class="chart-empty hidden absolute inset-0 bg-white">
          <i class="fa-solid fa-chart-line"></i>
          <p>No appointment data</p><span>for the selected period</span>
        </div>
        <div id="weeklyLoadingState" class="chart-loading hidden absolute inset-0 bg-white"><i
            class="fa-solid fa-spinner"></i></div>
      </div>
    </div>

    <div class="lg:col-span-1 flex flex-col gap-4">
      <h3 class="text-sm font-extrabold text-gray-800 uppercase tracking-wide px-1">Quick Reports</h3>

      <a href="{{ route('dentist.dentist.report.dental-services') }}" class="action-card group">
        <div class="action-icon"><i class="fa-solid fa-tooth"></i></div>
        <div>
          <h4 class="text-sm font-bold text-gray-800 group-hover:text-[#8B0000] transition-colors">Dental Services</h4>
          <p class="text-[11px] text-gray-400 mt-0.5">View and export full service logs</p>
        </div>
        <i
          class="fa-solid fa-chevron-right text-gray-300 ml-auto text-xs group-hover:text-[#8B0000] transition-colors"></i>
      </a>

      <a href="{{ route('dentist.dentist.report.daily-treatment') }}" class="action-card group">
        <div class="action-icon"><i class="fa-solid fa-notes-medical"></i></div>
        <div>
          <h4 class="text-sm font-bold text-gray-800 group-hover:text-[#8B0000] transition-colors">Daily Treatment
            Record</h4>
          <p class="text-[11px] text-gray-400 mt-0.5">Track daily patient treatments</p>
        </div>
        <i
          class="fa-solid fa-chevron-right text-gray-300 ml-auto text-xs group-hover:text-[#8B0000] transition-colors"></i>
      </a>
    </div>

  </div>

  <div class="chart-card mb-8">
    <div class="chart-card-header mb-6">
      <span class="chart-title text-base"><i class="fa-solid fa-boxes-stacked"></i> Inventory Analytics</span>
      <a href="{{ route('dentist.dentist.inventory') }}"
        class="text-[11px] font-bold text-[#8B0000] bg-red-50 px-3 py-1.5 rounded-lg hover:bg-red-100 transition-colors">
        Manage Inventory
      </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

      <div class="col-span-1">
        <h3 class="text-center text-[11px] font-bold text-gray-500 mb-4 uppercase tracking-wider">Medicine Stock</h3>
        <div class="relative h-[220px] w-full">
          @if($medicineItems->count() > 0)
          <canvas id="medicinePieChart"></canvas>
          @else
          <div class="chart-empty absolute inset-0">
            <i class="fa-solid fa-pills"></i>
            <p>No data</p>
          </div>
          @endif
        </div>
      </div>

      <div class="col-span-1">
        <h3 class="text-center text-[11px] font-bold text-gray-500 mb-4 uppercase tracking-wider">Medical Supplies</h3>
        <div class="relative h-[220px] w-full">
          @if($suppliesItems->count() > 0)
          <canvas id="suppliesPieChart"></canvas>
          @else
          <div class="chart-empty absolute inset-0">
            <i class="fa-solid fa-box-open"></i>
            <p>No data</p>
          </div>
          @endif
        </div>
      </div>

      <div class="col-span-1 bg-gray-50 rounded-xl p-5 border border-gray-100">
        <div class="flex items-center gap-2 mb-4">
          <i class="fa-solid fa-triangle-exclamation text-red-500"></i>
          <span class="text-sm font-bold text-gray-800">Low Stock Alerts</span>
        </div>

        @if($lowStockMedicine->count() > 0 || $lowStockSupplies->count() > 0)
        <div class="overflow-y-auto max-h-[190px] pr-2 scroll-smooth">

          @if($lowStockMedicine->count() > 0)
          @foreach($lowStockMedicine as $item)
          @php
          $remaining = $item->qty - $item->used;
          $pct = $item->qty > 0 ? round(($remaining / $item->qty) * 100) : 0;
          $barClass = $pct <= 15 ? 'bg-red-500' : 'bg-orange-400' ; @endphp <div class="stock-row">
            <div class="stock-name">
              <span class="truncate pr-2">{{ $item->name }}</span>
              <span class="text-red-600 font-bold text-[10px] whitespace-nowrap">{{ $remaining }} left</span>
            </div>
            <div class="stock-bar-bg">
              <div class="stock-bar-fill {{ $barClass }}" style="width:{{ $pct }}%"></div>
            </div>
        </div>
        @endforeach
        @endif

        @if($lowStockSupplies->count() > 0)
        @foreach($lowStockSupplies as $item)
        @php
        $remaining = $item->qty - $item->used;
        $pct = $item->qty > 0 ? round(($remaining / $item->qty) * 100) : 0;
        $barClass = $pct <= 15 ? 'bg-red-500' : 'bg-orange-400' ; @endphp <div class="stock-row">
          <div class="stock-name">
            <span class="truncate pr-2">{{ $item->name }}</span>
            <span class="text-red-600 font-bold text-[10px] whitespace-nowrap">{{ $remaining }} left</span>
          </div>
          <div class="stock-bar-bg">
            <div class="stock-bar-fill {{ $barClass }}" style="width:{{ $pct }}%"></div>
          </div>
      </div>
      @endforeach
      @endif

    </div>
    @else
    <div class="flex flex-col items-center justify-center h-[160px] text-center">
      <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mb-3">
        <i class="fa-solid fa-check text-green-500 text-xl"></i>
      </div>
      <p class="text-sm font-bold text-gray-700">Stock levels are good</p>
      <p class="text-xs text-gray-500 mt-1">No items require immediate restocking.</p>
    </div>
    @endif
  </div>

  </div>
  </div>

  </div>
</main>

<dialog id="createReportModal" class="modal">
  <div class="modal-box max-w-xl p-0 rounded-2xl overflow-hidden bg-white shadow-2xl flex flex-col"
    style="max-height:min(90vh,640px);">
    <div class="bg-gradient-to-r from-[#8B0000] to-[#660000] px-6 py-4 flex items-center justify-between flex-shrink-0">
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
          <i class="fa-solid fa-file-circle-plus text-white text-base"></i>
        </div>
        <div>
          <h2 class="text-base font-bold text-white leading-tight">Create Custom Report</h2>
          <p class="text-white/65 text-[11px] mt-0.5">Fields marked <span class="text-yellow-300 font-bold">*</span>
            are required</p>
        </div>
      </div>
      <button type="button" onclick="closeCreateModal()"
        class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/35 flex items-center justify-center text-white transition-all flex-shrink-0">
        <i class="fa-solid fa-xmark text-sm"></i>
      </button>
    </div>
    <div class="overflow-y-auto flex-1 px-6 py-5">
      <form id="reportForm" class="space-y-4" novalidate>
        <div>
          <div class="flex items-center justify-between mb-1">
            <label class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider">Report Name <span
                class="text-red-500">*</span></label>
            <span id="reportNameCounter" class="text-[11px] font-semibold text-gray-400">0 / 100</span>
          </div>
          <input id="reportName" type="text" maxlength="100" placeholder="e.g. GAD Monthly Report — Dec 2025"
            class="w-full px-3.5 py-2 rounded-xl border border-gray-300 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors placeholder-gray-400" />
          <p id="reportNameErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1">
            <i class="fa-solid fa-circle-exclamation"></i> Report name is required.
          </p>
        </div>
        <div>
          <label class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider mb-1">Report Type <span
              class="text-red-500">*</span></label>
          <div class="relative">
            <select id="reportType"
              class="w-full px-3.5 py-2 rounded-xl border border-gray-300 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors appearance-none pr-10 text-gray-700">
              <option value="" disabled selected>Select a report type...</option>
              <option class="text-gray-800">GAD Report</option>
              <option class="text-gray-800">Medicine Supply Report</option>
              <option class="text-gray-800">Medical Supplies Report</option>
              <option class="text-gray-800">Daily Treatment Record</option>
              <option class="text-gray-800">Dental Services Report</option>
            </select>
            <i
              class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
          </div>
          <p id="reportTypeErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1">
            <i class="fa-solid fa-circle-exclamation"></i> Please select a report type.
          </p>
        </div>
        <div>
          <label class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider mb-1">Date Range <span
              class="text-red-500">*</span></label>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <p class="text-[10px] text-gray-500 font-semibold uppercase mb-1">From <span class="text-red-400">*</span>
              </p>
              <input id="dateFrom" type="date"
                class="w-full px-3.5 py-2 rounded-xl border border-gray-300 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors" />
            </div>
            <div>
              <p class="text-[10px] text-gray-500 font-semibold uppercase mb-1">To <span
                  class="text-gray-400 normal-case font-normal">(optional)</span></p>
              <input id="dateTo" type="date"
                class="w-full px-3.5 py-2 rounded-xl border border-gray-300 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors" />
            </div>
          </div>
          <p class="text-[10px] text-gray-400 mt-1.5"><i class="fa-solid fa-circle-info mr-1"></i>Leave "To" empty to
            report on a single date.</p>
          <p id="dateFromErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1"><i
              class="fa-solid fa-circle-exclamation"></i> Start date is required.</p>
          <p id="dateFutureErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1"><i
              class="fa-solid fa-circle-exclamation"></i> Dates cannot be in the future.</p>
          <p id="dateRangeErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1"><i
              class="fa-solid fa-circle-exclamation"></i> End date must be on or after start date.</p>
        </div>
        <div>
          <label class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider mb-1">Quantity <span
              class="text-red-500">*</span></label>
          <input id="reportQty" type="number" min="1" max="100" step="1" placeholder="1 – 100"
            class="w-36 px-3.5 py-2 rounded-xl border border-gray-300 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors" />
          <span class="text-[11px] text-gray-400 ml-2">Whole numbers only</span>
          <p id="reportQtyErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1">
            <i class="fa-solid fa-circle-exclamation"></i> <span id="reportQtyErrMsg">Quantity must be between 1 and
              100.</span>
          </p>
        </div>
        <div id="formErrorBanner"
          class="hidden items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-2.5 text-sm font-medium">
          <i class="fa-solid fa-triangle-exclamation text-red-500 flex-shrink-0"></i>
          Please complete all required fields before downloading.
        </div>
      </form>
    </div>
    <div class="flex-shrink-0 border-t border-gray-100 px-6 py-4 flex justify-end gap-3 bg-gray-50">
      <button type="button" onclick="closeCreateModal()"
        class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-600 bg-white text-sm font-bold hover:bg-gray-50 transition-all">Cancel</button>
      <button type="button" id="downloadReportBtn"
        class="px-6 py-2.5 rounded-xl bg-[#8B0000] hover:bg-[#6b0000] text-white text-sm font-bold flex items-center gap-2 shadow-sm transition-all">
        <i class="fa-solid fa-download"></i> Download
      </button>
    </div>
  </div>
  <form method="dialog" class="modal-backdrop"><button onclick="closeCreateModal()"></button></form>
</dialog>

<dialog id="downloadCompleteModal" class="modal">
  <div class="modal-box p-0 rounded-2xl overflow-hidden bg-white shadow-2xl max-w-sm">
    <div class="h-1.5 bg-gradient-to-r from-[#8B0000] to-[#FFD700] w-full"></div>
    <div class="px-8 py-10 text-center">
      <div
        class="w-16 h-16 bg-green-50 border-2 border-green-200 rounded-full flex items-center justify-center mx-auto mb-5">
        <i class="fa-solid fa-check text-green-500 text-2xl"></i>
      </div>
      <h3 class="text-xl font-bold text-[#8B0000] mb-2">Download Complete!</h3>
      <p class="text-gray-500 text-sm leading-relaxed mb-7">Your report has been successfully generated and
        downloaded.</p>
      <button onclick="closeDownloadModal()"
        class="px-8 py-2.5 rounded-xl bg-[#8B0000] hover:bg-[#6b0000] text-white font-bold text-sm shadow-sm transition-all w-full">Done</button>
    </div>
  </div>
  <form method="dialog" class="modal-backdrop"><button onclick="closeDownloadModal()"></button></form>
</dialog>
@endsection

@section('scripts')
<script>
  const GAD_DATA = { labels: @json($gadLabels), female: @json($gadFemale), male: @json($gadMale) };
  const WEEKLY_DATA = { labels: @json($weekLabels), datasets: @json($weeklyDatasets) };
  const MEDICINE_ITEMS = @json($medicineItems);
  const SUPPLIES_ITEMS = @json($suppliesItems);
  const AJAX_GAD_URL = "{{ route('dentist.dentist.report.gad-data') }}";
  const AJAX_WEEKLY_URL = "{{ route('dentist.dentist.report.weekly-data') }}";
  const PIE_COLORS = ['#8B0000', '#b30000', '#cc3333', '#e06666', '#f4cccc', '#d9534f', '#c0392b', '#922b21', '#641e16', '#f1948a'];
</script>

<script>
  function closeCreateModal() {
    document.getElementById('createReportModal').close();
    document.getElementById('reportForm').reset();
    document.getElementById('reportNameCounter').textContent = '0 / 100';
    document.getElementById('reportNameCounter').classList.replace('text-red-500', 'text-gray-400');
    ['reportNameErr', 'reportTypeErr', 'dateFromErr', 'dateFutureErr', 'dateRangeErr', 'reportQtyErr', 'formErrorBanner']
      .forEach(id => {
        let el = document.getElementById(id);
        if (el) { el.classList.add('hidden'); el.classList.remove('flex'); }
      });
    ['reportName', 'reportType', 'dateFrom', 'dateTo', 'reportQty']
      .forEach(id => {
        let el = document.getElementById(id);
        if (el) { el.classList.remove('border-red-400'); el.classList.add('border-gray-300'); }
      });
  }
  function closeDownloadModal() { document.getElementById('downloadCompleteModal').close(); }

  let gadChartInstance = null, weeklyChartInstance = null;

  function showGadEmpty() { document.getElementById('gadChart').style.display = 'none'; document.getElementById('gadEmptyState').classList.remove('hidden'); document.getElementById('gadEmptyState').classList.add('flex'); document.getElementById('gadLoadingState').classList.add('hidden'); }
  function showGadLoading() { document.getElementById('gadChart').style.display = 'none'; document.getElementById('gadEmptyState').classList.add('hidden'); document.getElementById('gadLoadingState').classList.remove('hidden'); document.getElementById('gadLoadingState').classList.add('flex'); }
  function showGadChart() { document.getElementById('gadChart').style.display = 'block'; document.getElementById('gadEmptyState').classList.add('hidden'); document.getElementById('gadLoadingState').classList.add('hidden'); }

  function showWeeklyEmpty() { document.getElementById('weeklyDentalCasesChart').style.display = 'none'; document.getElementById('weeklyEmptyState').classList.remove('hidden'); document.getElementById('weeklyEmptyState').classList.add('flex'); document.getElementById('weeklyLoadingState').classList.add('hidden'); }
  function showWeeklyLoading() { document.getElementById('weeklyDentalCasesChart').style.display = 'none'; document.getElementById('weeklyEmptyState').classList.add('hidden'); document.getElementById('weeklyLoadingState').classList.remove('hidden'); document.getElementById('weeklyLoadingState').classList.add('flex'); }
  function showWeeklyChart() { document.getElementById('weeklyDentalCasesChart').style.display = 'block'; document.getElementById('weeklyEmptyState').classList.add('hidden'); document.getElementById('weeklyLoadingState').classList.add('hidden'); }

  function buildGadChart(labels, female, male) {
    if (gadChartInstance) { gadChartInstance.destroy(); gadChartInstance = null; }
    gadChartInstance = new Chart(document.getElementById('gadChart'), {
      type: 'bar',
      data: { labels, datasets: [{ label: 'Female', data: female, backgroundColor: '#FFC0CB', borderRadius: 4 }, { label: 'Male', data: male, backgroundColor: '#89CFF0', borderRadius: 4 }] },
      options: {
        responsive: true, maintainAspectRatio: false, indexAxis: 'y',
        plugins: { legend: { position: 'top', labels: { font: { family: 'Inter', size: 11 }, usePointStyle: true, boxWidth: 8 } }, tooltip: { callbacks: { label: ctx => `${ctx.dataset.label}: ${ctx.parsed.x} cases` } } },
        scales: { x: { beginAtZero: true, grid: { borderDash: [4, 4] }, title: { display: true, text: 'Number of Cases', font: { family: 'Inter', size: 10 } } }, y: { grid: { display: false }, ticks: { font: { family: 'Inter', size: 10 } } } }
      }
    });
  }

  function buildWeeklyChart(labels, datasets) {
    if (weeklyChartInstance) { weeklyChartInstance.destroy(); weeklyChartInstance = null; }
    weeklyChartInstance = new Chart(document.getElementById('weeklyDentalCasesChart'), {
      type: 'line',
      data: { labels, datasets },
      options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { position: 'top', labels: { font: { family: 'Inter', size: 11 }, usePointStyle: true, boxWidth: 8 } }, tooltip: { callbacks: { label: ctx => `${ctx.dataset.label}: ${ctx.parsed.y} cases` } } },
        scales: { x: { grid: { display: false }, ticks: { font: { family: 'Inter', size: 10 } } }, y: { beginAtZero: true, grid: { borderDash: [4, 4] }, ticks: { precision: 0, font: { family: 'Inter', size: 10 } }, title: { display: false } } }
      }
    });
  }

  function makePieChart(canvasId, items) {
    if (!items || items.length === 0) return;
    new Chart(document.getElementById(canvasId), {
      type: 'doughnut',
      data: { labels: items.map(i => i.name), datasets: [{ data: items.map(i => Math.max(0, i.qty - i.used)), backgroundColor: PIE_COLORS.slice(0, items.length), borderWidth: 2, borderColor: '#fff' }] },
      options: {
        responsive: true, maintainAspectRatio: false, cutout: '65%',
        plugins: { legend: { position: 'right', labels: { font: { family: 'Inter', size: 10 }, usePointStyle: true, boxWidth: 6, padding: 12 } }, tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed} remaining` } } }
      }
    });
  }

  async function reloadGadChart(period) {
    showGadLoading();
    try {
      const res = await fetch(`${AJAX_GAD_URL}?period=${encodeURIComponent(period)}`);
      const data = await res.json();
      if (data.empty) { showGadEmpty(); return; }
      showGadChart(); buildGadChart(data.labels, data.female, data.male);
    } catch (e) { showGadEmpty(); }
  }
  async function reloadWeeklyChart(period) {
    showWeeklyLoading();
    try {
      const res = await fetch(`${AJAX_WEEKLY_URL}?period=${encodeURIComponent(period)}`);
      const data = await res.json();
      if (data.empty || !data.datasets || data.datasets.length === 0) { showWeeklyEmpty(); return; }
      showWeeklyChart(); buildWeeklyChart(data.labels, data.datasets);
    } catch (e) { showWeeklyEmpty(); }
  }

  document.addEventListener('DOMContentLoaded', function () {

    setTimeout(function () {
      const gadHasData = GAD_DATA.female.reduce((a, b) => a + b, 0) + GAD_DATA.male.reduce((a, b) => a + b, 0) > 0;
      if (gadHasData) { showGadChart(); buildGadChart(GAD_DATA.labels, GAD_DATA.female, GAD_DATA.male); } else { showGadEmpty(); }
      if (WEEKLY_DATA.datasets && WEEKLY_DATA.datasets.length > 0) { showWeeklyChart(); buildWeeklyChart(WEEKLY_DATA.labels, WEEKLY_DATA.datasets); } else { showWeeklyEmpty(); }
      makePieChart('medicinePieChart', MEDICINE_ITEMS);
      makePieChart('suppliesPieChart', SUPPLIES_ITEMS);
    }, 150);

    document.getElementById('gadPeriodSelect').addEventListener('change', function () { reloadGadChart(this.value); });
    document.getElementById('weeklyPeriodSelect').addEventListener('change', function () { reloadWeeklyChart(this.value); });

    const todayStr = new Date().toISOString().split('T')[0];
    document.getElementById('dateFrom').setAttribute('max', todayStr);
    document.getElementById('dateTo').setAttribute('max', todayStr);

    function setError(inputId, errId, show) {
      const input = document.getElementById(inputId), err = document.getElementById(errId);
      if (!input || !err) return;
      if (show) { err.classList.remove('hidden'); err.classList.add('flex'); input.classList.add('border-red-400'); input.classList.remove('border-gray-300'); }
      else { err.classList.add('hidden'); err.classList.remove('flex'); input.classList.remove('border-red-400'); input.classList.add('border-gray-300'); }
    }
    const clearError = (a, b) => setError(a, b, false);

    document.getElementById('downloadReportBtn').addEventListener('click', function () {
      const name = document.getElementById('reportName').value.trim();
      const type = document.getElementById('reportType').value;
      const from = document.getElementById('dateFrom').value;
      const to = document.getElementById('dateTo').value;
      const qty = parseInt(document.getElementById('reportQty').value, 10);
      let valid = true;

      setError('reportName', 'reportNameErr', !name); if (!name) valid = false;
      setError('reportType', 'reportTypeErr', !type); if (!type) valid = false;

      ['dateFromErr', 'dateFutureErr', 'dateRangeErr'].forEach(id => {
        let el = document.getElementById(id);
        if (el) { el.classList.add('hidden'); el.classList.remove('flex'); }
      });
      ['dateFrom', 'dateTo'].forEach(id => {
        let el = document.getElementById(id);
        if (el) { el.classList.remove('border-red-400'); el.classList.add('border-gray-300'); }
      });

      if (!from) {
        document.getElementById('dateFromErr').classList.remove('hidden'); document.getElementById('dateFromErr').classList.add('flex');
        document.getElementById('dateFrom').classList.add('border-red-400'); document.getElementById('dateFrom').classList.remove('border-gray-300');
        valid = false;
      } else {
        const fromFuture = from > todayStr, toFuture = to && to > todayStr;
        if (fromFuture || toFuture) {
          document.getElementById('dateFutureErr').classList.remove('hidden'); document.getElementById('dateFutureErr').classList.add('flex');
          if (fromFuture) { document.getElementById('dateFrom').classList.add('border-red-400'); document.getElementById('dateFrom').classList.remove('border-gray-300'); }
          if (toFuture) { document.getElementById('dateTo').classList.add('border-red-400'); document.getElementById('dateTo').classList.remove('border-gray-300'); }
          valid = false;
        } else if (to && new Date(to) < new Date(from)) {
          document.getElementById('dateRangeErr').classList.remove('hidden'); document.getElementById('dateRangeErr').classList.add('flex');
          document.getElementById('dateTo').classList.add('border-red-400'); document.getElementById('dateTo').classList.remove('border-gray-300');
          valid = false;
        }
      }

      const qtyInvalid = isNaN(qty) || qty < 1 || qty > 100;
      document.getElementById('reportQtyErrMsg').textContent = (isNaN(qty) || qty < 1) ? 'Quantity must be between 1 and 100.' : 'Quantity cannot exceed 100.';
      setError('reportQty', 'reportQtyErr', qtyInvalid); if (qtyInvalid) valid = false;

      const banner = document.getElementById('formErrorBanner');
      if (!valid) {
        banner.classList.remove('hidden'); banner.classList.add('flex');
        const btn = document.getElementById('downloadReportBtn');
        btn.classList.add('animate-bounce'); setTimeout(() => btn.classList.remove('animate-bounce'), 600);
      } else {
        banner.classList.add('hidden'); banner.classList.remove('flex');
        document.getElementById('createReportModal').close();
        document.getElementById('downloadCompleteModal').showModal();
        document.getElementById('reportForm').reset();
        document.getElementById('reportNameCounter').textContent = '0 / 100';
        document.getElementById('reportNameCounter').classList.remove('text-red-500'); document.getElementById('reportNameCounter').classList.add('text-gray-400');
        ['reportNameErr', 'reportTypeErr', 'dateFromErr', 'dateFutureErr', 'dateRangeErr', 'reportQtyErr']
          .forEach(id => {
            let el = document.getElementById(id);
            if (el) { el.classList.add('hidden'); el.classList.remove('flex'); }
          });
      }
    });

    document.getElementById('reportName').addEventListener('input', function () {
      const len = this.value.length, counter = document.getElementById('reportNameCounter');
      counter.textContent = `${len} / 100`;
      counter.classList.toggle('text-red-500', len >= 90); counter.classList.toggle('text-gray-400', len < 90);
      if (this.value.trim()) clearError('reportName', 'reportNameErr');
      document.getElementById('formErrorBanner').classList.add('hidden');
    });
    document.getElementById('reportType').addEventListener('change', function () {
      if (this.value) clearError('reportType', 'reportTypeErr');
      document.getElementById('formErrorBanner').classList.add('hidden');
    });

    function checkDates() {
      const from = document.getElementById('dateFrom').value, to = document.getElementById('dateTo').value;
      ['dateFromErr', 'dateFutureErr', 'dateRangeErr'].forEach(id => {
        let el = document.getElementById(id);
        if (el) { el.classList.add('hidden'); el.classList.remove('flex'); }
      });
      ['dateFrom', 'dateTo'].forEach(id => {
        let el = document.getElementById(id);
        if (el) { el.classList.remove('border-red-400'); el.classList.add('border-gray-300'); }
      });
      if (!from && !to) return;
      const fromFuture = from && from > todayStr, toFuture = to && to > todayStr;
      if (fromFuture || toFuture) {
        document.getElementById('dateFutureErr').classList.remove('hidden'); document.getElementById('dateFutureErr').classList.add('flex');
        if (fromFuture) { document.getElementById('dateFrom').classList.add('border-red-400'); document.getElementById('dateFrom').classList.remove('border-gray-300'); }
        if (toFuture) { document.getElementById('dateTo').classList.add('border-red-400'); document.getElementById('dateTo').classList.remove('border-gray-300'); }
        return;
      }
      if (from && to && new Date(to) < new Date(from)) {
        document.getElementById('dateRangeErr').classList.remove('hidden'); document.getElementById('dateRangeErr').classList.add('flex');
        document.getElementById('dateTo').classList.add('border-red-400'); document.getElementById('dateTo').classList.remove('border-gray-300');
      }
      document.getElementById('formErrorBanner').classList.add('hidden');
    }
    document.getElementById('dateFrom').addEventListener('change', checkDates);
    document.getElementById('dateTo').addEventListener('change', checkDates);

    const qtyInput = document.getElementById('reportQty');
    qtyInput.addEventListener('keydown', e => { if (['-', '+', 'e', 'E', '.', ','].includes(e.key)) e.preventDefault(); });
    qtyInput.addEventListener('input', function () {
      let val = this.value.replace(/[^0-9]/g, '');
      if (val !== '' && parseInt(val, 10) > 100) val = '100';
      this.value = val;
      const qty = parseInt(val, 10);
      if (!isNaN(qty) && qty >= 1 && qty <= 100) clearError('reportQty', 'reportQtyErr');
      document.getElementById('formErrorBanner').classList.add('hidden');
    });
    qtyInput.addEventListener('paste', e => {
      e.preventDefault();
      const num = parseInt((e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, ''), 10);
      if (!isNaN(num)) qtyInput.value = Math.min(Math.max(num, 1), 100);
    });
  });
</script>
@endsection