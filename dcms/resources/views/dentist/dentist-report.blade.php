@extends('layouts.dentist')

@section('title', 'Records | PUP Taguig Dental Clinic')

@section('styles')

<style>
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(6px)
    }

    to {
      opacity: 1;
      transform: translateY(0)
    }
  }

  .fade-in {
    animation: fadeIn .6s ease-out forwards;
  }

  @keyframes shimmer {
    0% {
      transform: translateX(-100%) skewX(-15deg)
    }

    100% {
      transform: translateX(300%) skewX(-15deg)
    }
  }

  .btn-shimmer {
    position: relative;
    overflow: hidden;
  }

  .btn-shimmer::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 40%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .25), transparent);
    animation: shimmer 2.4s infinite;
  }

  /* KPI */
  .kpi-card {
    background: white;
    border-radius: 14px;
    padding: 18px 22px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, .07);
    border: 1.5px solid #f0f0f0;
    transition: transform .2s, box-shadow .2s;
    text-decoration: none;
  }

  .kpi-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(139, 0, 0, .10);
  }

  .kpi-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
  }

  .kpi-value {
    font-size: 1.55rem;
    font-weight: 800;
    line-height: 1;
    color: #1a1a1a;
  }

  .kpi-label {
    font-size: .72rem;
    font-weight: 500;
    color: #888;
    margin-top: 3px;
    letter-spacing: .03em;
    text-transform: uppercase;
  }

  .kpi-delta {
    font-size: .7rem;
    font-weight: 600;
    margin-top: 4px;
  }

  .kpi-delta.up {
    color: #16a34a;
  }

  .kpi-delta.down {
    color: #dc2626;
  }

  .kpi-arrow {
    margin-left: auto;
    color: #ccc;
    font-size: .75rem;
    align-self: center;
  }

  .kpi-card:hover .kpi-arrow {
    color: #8B0000;
  }

  /* Chart card */
  .chart-card {
    background: white;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, .07);
    border: 1.5px solid #f0f0f0;
    padding: 20px;
  }

  .chart-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
  }

  .chart-title {
    font-size: .88rem;
    font-weight: 700;
    color: #8B0000;
  }

  .period-select {
    font-size: .72rem;
    font-weight: 600;
    color: #8B0000;
    background: #fff5f5;
    border: 1.5px solid #f9b2b2;
    border-radius: 20px;
    padding: 3px 24px 3px 12px;
    cursor: pointer;
    outline: none;
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238B0000'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 8px center;
  }

  /* Quick buttons */
  .quick-btn {
    position: relative;
    flex: 1;
    border-radius: 14px;
    overflow: hidden;
    background: linear-gradient(135deg, #8B0000 0%, #5a0000 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: white;
    font-weight: 700;
    font-size: .85rem;
    text-align: center;
    padding: 16px;
    transition: transform .2s, box-shadow .2s;
    box-shadow: 0 4px 16px rgba(139, 0, 0, .25);
    text-decoration: none;
  }

  .quick-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 28px rgba(139, 0, 0, .35);
  }

  .quick-btn .qb-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, .15);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
  }

  .quick-btn::before {
    content: '';
    position: absolute;
    top: -30%;
    right: -20%;
    width: 100px;
    height: 100px;
    background: rgba(255, 215, 0, .12);
    border-radius: 50%;
  }

  /* Stock bars */
  .stock-row {
    padding: 10px 0;
    border-bottom: 1px solid #f5f5f5;
  }

  .stock-name {
    font-size: .78rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 6px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .stock-bar-bg {
    height: 7px;
    background: #f0f0f0;
    border-radius: 10px;
    overflow: hidden;
  }

  .stock-bar-fill {
    height: 100%;
    border-radius: 10px;
    transition: width .8s cubic-bezier(.4, 0, .2, 1);
  }

  /* Chart empty/loading states */
  .chart-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    gap: 10px;
    color: #bbb;
  }

  .chart-empty i {
    font-size: 2rem;
  }

  .chart-empty p {
    font-size: .8rem;
    font-weight: 600;
  }

  .chart-empty span {
    font-size: .72rem;
    color: #ccc;
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

  [data-theme="dark"] .kpi-card {
    background: #111827;
    border-color: #1f2937;
  }

  [data-theme="dark"] .kpi-value {
    color: #f3f4f6;
  }

  [data-theme="dark"] .chart-card {
    background: #111827;
    border-color: #1f2937;
  }

  /* ════════════════════════════════
       MOBILE RESPONSIVE
    ════════════════════════════════ */
  @media (max-width: 767px) {

    /* Page title row */
    .page-title-row {
      flex-direction: column !important;
      align-items: flex-start !important;
      gap: .4rem !important;
      margin-bottom: 1rem !important;
    }

    .page-title-row h1 {
      font-size: 1.35rem !important;
    }

    .page-last-updated {
      font-size: .68rem !important;
    }

    /* KPI strip: 2-col grid */
    .kpi-strip {
      grid-template-columns: repeat(2, 1fr) !important;
      gap: .65rem !important;
      margin-bottom: 1.1rem !important;
    }

    .kpi-card {
      padding: 14px 14px !important;
      gap: 10px !important;
      border-radius: 12px !important;
    }

    .kpi-value {
      font-size: 1.25rem !important;
    }

    .kpi-label {
      font-size: .65rem !important;
    }

    .kpi-delta {
      font-size: .62rem !important;
    }

    .kpi-icon {
      width: 38px !important;
      height: 38px !important;
      font-size: 16px !important;
      border-radius: 10px !important;
    }

    .kpi-arrow {
      display: none !important;
    }

    /* Create report button */
    .create-report-btn {
      padding: .85rem 1rem !important;
      font-size: .82rem !important;
      border-radius: 14px !important;
      gap: .6rem !important;
    }

    .create-report-plus {
      width: 28px !important;
      height: 28px !important;
      font-size: 1rem !important;
    }

    /* Charts + quick buttons: stack vertically */
    .charts-quick-row {
      flex-direction: column !important;
      gap: .85rem !important;
    }

    .gad-chart-col {
      width: 100% !important;
    }

    .weekly-chart-col {
      width: 100% !important;
    }

    .quick-btns-col {
      width: 100% !important;
      flex-direction: row !important;
      min-height: unset !important;
      gap: .65rem !important;
    }

    .quick-btn {
      flex: 1 !important;
      padding: 14px 10px !important;
      border-radius: 12px !important;
    }

    .quick-btn .qb-icon {
      width: 34px !important;
      height: 34px !important;
      font-size: 15px !important;
    }

    .quick-btn span {
      font-size: .78rem !important;
    }

    /* Inventory analytics: stack pies + low stock */
    .inv-grid {
      flex-direction: column !important;
      gap: .85rem !important;
    }

    .inv-pies {
      width: 100% !important;
      flex-direction: column !important;
    }

    .inv-pie-item {
      width: 100% !important;
    }

    .inv-pie-item canvas-wrap {
      height: 220px !important;
    }

    .inv-low-stock {
      width: 100% !important;
    }

    /* Modal adjustments */
    .modal-box {
      max-width: calc(100vw - 2rem) !important;
      margin: 0 1rem !important;
    }
  }

  /* Tablet: 768–1023px */
  @media (min-width: 768px) and (max-width: 1023px) {

    .kpi-strip {
      grid-template-columns: repeat(2, 1fr) !important;
      gap: .85rem !important;
    }

    .charts-quick-row {
      flex-wrap: wrap !important;
    }

    .gad-chart-col {
      width: calc(50% - .5rem) !important;
    }

    .weekly-chart-col {
      width: calc(50% - .5rem) !important;
    }

    .quick-btns-col {
      width: 100% !important;
      flex-direction: row !important;
      gap: .85rem !important;
      min-height: unset !important;
    }

    .quick-btn {
      flex-direction: row !important;
      justify-content: flex-start !important;
      padding: 1rem 1.25rem !important;
    }

    .inv-pies {
      flex-direction: row !important;
    }

    .inv-pie-item {
      flex: 1 !important;
    }
  }
</style>
@endsection

@section('content')

@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

<!-- ══════════ MAIN ══════════ -->
<main id="mainContent" class="pt-[100px] px-6 py-6 fade-up min-h-screen">
  <div class="max-w-7xl mx-auto fade-in">

    <!-- PAGE TITLE -->
    <div class="page-title-row flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-[#660000]">Reports &amp; Analytics</h1>
        <p class="text-xs text-gray-500 mt-0.5">Overview of clinic data, trends, and inventory status</p>
      </div>
      <span class="page-last-updated text-xs text-gray-400 font-medium">
        <i class="fa-regular fa-clock mr-1"></i> Last updated: {{ now()->format('M d, Y h:i A') }}
      </span>
    </div>

    <!-- KPI STRIP -->
    <div class="kpi-strip grid grid-cols-4 gap-4 mb-7">

      <a href="{{ route('dentist.dentist.patients') }}" class="kpi-card">
        <div class="kpi-icon" style="background:#fff0f0;"><i class="fa-solid fa-users" style="color:#8B0000;"></i>
        </div>
        <div class="flex-1">
          <div class="kpi-value">{{ $patientsThisMonth }}</div>
          <div class="kpi-label">Patients This Month</div>
          @if(!is_null($patientsDelta))
          <div class="kpi-delta {{ $patientsDelta >= 0 ? 'up' : 'down' }}">
            <i class="fa-solid fa-arrow-{{ $patientsDelta >= 0 ? 'up' : 'down' }} text-[10px]"></i> {{
            abs($patientsDelta) }}% vs last month
          </div>
          @else
          <div class="kpi-delta" style="color:#888;">No data last month</div>
          @endif
        </div>
        <i class="fa-solid fa-chevron-right kpi-arrow"></i>
      </a>

      <a href="{{ route('dentist.dentist.appointments') }}" class="kpi-card">
        <div class="kpi-icon" style="background:#fffbeb;"><i class="fa-solid fa-calendar-check"
            style="color:#d97706;"></i></div>
        <div class="flex-1">
          <div class="kpi-value">{{ $appointmentsToday }}</div>
          <div class="kpi-label">Appointments Today</div>
          @if($appointmentsDelta > 0)
          <div class="kpi-delta up"><i class="fa-solid fa-arrow-up text-[10px]"></i> {{ $appointmentsDelta }} more
            than yesterday</div>
          @elseif($appointmentsDelta < 0) <div class="kpi-delta down"><i class="fa-solid fa-arrow-down text-[10px]"></i>
            {{ abs($appointmentsDelta) }} fewer than yesterday
        </div>
        @else
        <div class="kpi-delta" style="color:#888;">Same as yesterday</div>
        @endif
    </div>
    <i class="fa-solid fa-chevron-right kpi-arrow"></i>
    </a>

    <div class="kpi-card">
      <div class="kpi-icon" style="background:#f0fdf4;"><i class="fa-solid fa-tooth" style="color:#16a34a;"></i></div>
      <div>
        <div class="kpi-value">{{ $casesThisMonth }}</div>
        <div class="kpi-label">Dental Cases ({{ now()->format('M') }})</div>
        @if(!is_null($casesDelta))
        <div class="kpi-delta {{ $casesDelta >= 0 ? 'up' : 'down' }}">
          <i class="fa-solid fa-arrow-{{ $casesDelta >= 0 ? 'up' : 'down' }} text-[10px]"></i> {{ abs($casesDelta) }}%
          vs last month
        </div>
        @else
        <div class="kpi-delta" style="color:#888;">No data last month</div>
        @endif
      </div>
    </div>

    <a href="{{ route('dentist.dentist.inventory') }}" class="kpi-card" style="border-color:#fee2e2;">
      <div class="kpi-icon" style="background:#fff0f0;"><i class="fa-solid fa-triangle-exclamation"
          style="color:#dc2626;"></i></div>
      <div class="flex-1">
        <div class="kpi-value" style="color:#dc2626;">{{ $lowStockItems }}</div>
        <div class="kpi-label">Low Stock Items</div>
        @if($lowStockItems > 0)
        <div class="kpi-delta down"><i class="fa-solid fa-circle-exclamation text-[10px]"></i> Requires reorder</div>
        @else
        <div class="kpi-delta up"><i class="fa-solid fa-circle-check text-[10px]"></i> All stocked up</div>
        @endif
      </div>
      <i class="fa-solid fa-chevron-right kpi-arrow"></i>
    </a>

  </div>

  <!-- CREATE REPORT BUTTON -->
  <div class="flex justify-center mb-7">
    <button onclick="document.getElementById('createReportModal').showModal()" class="create-report-btn btn-shimmer w-full max-w-4xl bg-gradient-to-r from-[#8B0000] via-[#b30000] to-[#FFD700]
                   text-white py-4 rounded-2xl flex items-center justify-center gap-4
                   text-base font-bold shadow-lg hover:opacity-90 transition-opacity">
      <i class="fa-solid fa-file-circle-plus text-xl"></i>
      <span>Create New Report</span>
      <span
        class="create-report-plus bg-white text-[#8B0000] w-8 h-8 rounded-full flex items-center justify-center text-xl font-bold leading-none">+</span>
    </button>
  </div>

  <!-- CHARTS + QUICK BUTTONS -->
  {{-- Use a flex row that wraps on mobile via CSS classes --}}
  <div class="charts-quick-row flex gap-5 mb-5">

    <!-- GAD REPORT -->
    <div class="gad-chart-col chart-card" style="flex:5;">
      <div class="chart-card-header">
        <span class="chart-title"><i class="fa-solid fa-chart-column mr-1.5 opacity-70"></i>GAD Report</span>
        <select class="period-select" id="gadPeriodSelect">
          @foreach($periodOptions as $opt)
          <option>{{ $opt }}</option>
          @endforeach
        </select>
      </div>
      <div id="gadChartWrap" style="height:300px;width:100%;position:relative;">
        <canvas id="gadChart"></canvas>
        <div id="gadEmptyState" class="chart-empty" style="display:none;position:absolute;inset:0;">
          <i class="fa-solid fa-chart-column" style="color:#e5e7eb;"></i>
          <p>No GAD records found</p>
          <span>for the selected period</span>
        </div>
        <div id="gadLoadingState" class="chart-loading"
          style="display:none;position:absolute;inset:0;background:white;">
          <i class="fa-solid fa-spinner"></i>
        </div>
      </div>
    </div>

    <!-- WEEKLY DENTAL CASES -->
    <div class="weekly-chart-col chart-card" style="flex:5;">
      <div class="chart-card-header">
        <span class="chart-title"><i class="fa-solid fa-chart-line mr-1.5 opacity-70"></i>Weekly Dental Cases</span>
        <select class="period-select" id="weeklyPeriodSelect">
          @foreach($periodOptions as $opt)
          <option>{{ $opt }}</option>
          @endforeach
        </select>
      </div>
      <div id="weeklyChartWrap" style="height:300px;width:100%;position:relative;">
        <canvas id="weeklyDentalCasesChart"></canvas>
        <div id="weeklyEmptyState" class="chart-empty" style="display:none;position:absolute;inset:0;">
          <i class="fa-solid fa-chart-line" style="color:#e5e7eb;"></i>
          <p>No appointment data found</p>
          <span>for the selected period</span>
        </div>
        <div id="weeklyLoadingState" class="chart-loading"
          style="display:none;position:absolute;inset:0;background:white;">
          <i class="fa-solid fa-spinner"></i>
        </div>
      </div>
    </div>

    <!-- QUICK BUTTONS -->
    <div class="quick-btns-col flex flex-col gap-4" style="flex:2;min-height:360px;">
      <a href="{{ route('dentist.dentist.report.dental-services') }}" class="quick-btn">
        <div class="qb-icon"><i class="fa-solid fa-tooth"></i></div>
        <span>Dental Services</span>
      </a>
      <a href="{{ route('dentist.dentist.report.daily-treatment') }}" class="quick-btn">
        <div class="qb-icon"><i class="fa-solid fa-notes-medical"></i></div>
        <span style="line-height:1.3;">Daily Treatment<br>Record</span>
      </a>
    </div>

  </div>

  <!-- INVENTORY ANALYTICS -->
  <div class="chart-card mb-5" style="border:1.5px solid #fde68a;">
    <div class="chart-card-header mb-4">
      <span class="chart-title text-base"><i class="fa-solid fa-boxes-stacked mr-1.5 opacity-70"></i>Inventory
        Analytics</span>
      <a href="{{ route('dentist.dentist.inventory') }}" class="text-xs font-semibold text-[#8B0000] hover:underline">
        View All <i class="fa-solid fa-arrow-right text-[10px]"></i>
      </a>
    </div>

    {{-- inv-grid: flex row on desktop, column on mobile via CSS --}}
    <div class="inv-grid flex gap-6 items-start">

      <!-- PIE CHARTS -->
      <div class="inv-pies flex gap-6" style="flex:7;">
        <div class="inv-pie-item" style="flex:1;">
          <h3 class="text-center text-xs font-bold text-[#8B0000] mb-3 uppercase tracking-wider">Medicine Inventory
          </h3>
          <div style="height:280px;width:100%;position:relative;">
            @if($medicineItems->count() > 0)
            <canvas id="medicinePieChart"></canvas>
            @else
            <div class="chart-empty" style="position:absolute;inset:0;">
              <i class="fa-solid fa-capsules" style="color:#e5e7eb;"></i>
              <p>No medicine items</p>
              <span>Add inventory to see chart</span>
            </div>
            @endif
          </div>
        </div>
        <div class="inv-pie-item" style="flex:1;">
          <h3 class="text-center text-xs font-bold text-[#8B0000] mb-3 uppercase tracking-wider">Medical Supplies
            Inventory</h3>
          <div style="height:280px;width:100%;position:relative;">
            @if($suppliesItems->count() > 0)
            <canvas id="suppliesPieChart"></canvas>
            @else
            <div class="chart-empty" style="position:absolute;inset:0;">
              <i class="fa-solid fa-box-open" style="color:#e5e7eb;"></i>
              <p>No supply items</p>
              <span>Add inventory to see chart</span>
            </div>
            @endif
          </div>
        </div>
      </div>

      <!-- LOW STOCK PANEL -->
      <div class="inv-low-stock" style="flex:5;">
        <div class="flex items-center gap-2 mb-3">
          <i class="fa-solid fa-triangle-exclamation text-red-500 text-sm"></i>
          <span class="text-xs font-bold text-red-600 uppercase tracking-wider">Low Stock Alerts</span>
        </div>

        @if($lowStockMedicine->count() > 0)
        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2">Medicine</p>
        @foreach($lowStockMedicine as $item)
        @php
        $remaining = $item->qty - $item->used;
        $pct = $item->qty > 0 ? round(($remaining / $item->qty) * 100) : 0;
        $barClass = $pct <= 15 ? 'bg-red-400' : 'bg-orange-400' ; @endphp <div class="stock-row">
          <div class="stock-name">
            <span>{{ $item->name }}</span>
            <span class="text-red-500 font-bold text-[11px]">{{ $remaining }} / {{ $item->qty }}</span>
          </div>
          <div class="stock-bar-bg">
            <div class="stock-bar-fill {{ $barClass }}" style="width:{{ $pct }}%"></div>
          </div>
      </div>
      @endforeach
      @endif

      @if($lowStockSupplies->count() > 0)
      <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mt-4 mb-2">Medical Supplies</p>
      @foreach($lowStockSupplies as $item)
      @php
      $remaining = $item->qty - $item->used;
      $pct = $item->qty > 0 ? round(($remaining / $item->qty) * 100) : 0;
      $barClass = $pct <= 15 ? 'bg-red-400' : 'bg-orange-400' ; @endphp <div class="stock-row">
        <div class="stock-name">
          <span>{{ $item->name }}</span>
          <span class="text-red-500 font-bold text-[11px]">{{ $remaining }} / {{ $item->qty }}</span>
        </div>
        <div class="stock-bar-bg">
          <div class="stock-bar-fill {{ $barClass }}" style="width:{{ $pct }}%"></div>
        </div>
    </div>
    @endforeach
    @endif

    @if($lowStockMedicine->count() === 0 && $lowStockSupplies->count() === 0)
    <div class="flex flex-col items-center justify-center h-full py-8 text-center min-h-[200px]">
      <i class="fa-solid fa-circle-check text-green-400 text-3xl mb-2"></i>
      <p class="text-sm font-semibold text-green-600">No low stock items found.</p>
      <p class="text-xs text-gray-400 mt-1">No reorder needed at this time.</p>
    </div>
    @endif
  </div>

  </div>
  </div>

  </div>
</main>

<!-- CREATE REPORT MODAL -->
<dialog id="createReportModal" class="modal">
  <div class="modal-box max-w-xl p-0 rounded-2xl overflow-hidden bg-white shadow-2xl flex flex-col"
    style="max-height:min(90vh,640px);">
    <div class="bg-gradient-to-r from-[#8B0000] to-[#660000] px-6 py-4 flex items-center justify-between flex-shrink-0">
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
          <i class="fa-solid fa-file-circle-plus text-white text-base"></i>
        </div>
        <div>
          <h2 class="text-base font-bold text-white leading-tight">Create New Report</h2>
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
            class="w-full px-3.5 py-2 rounded-xl border-2 border-gray-200 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors placeholder-gray-300" />
          <p id="reportNameErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1">
            <i class="fa-solid fa-circle-exclamation"></i> Report name is required.
          </p>
        </div>
        <div>
          <label class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider mb-1">Report Type <span
              class="text-red-500">*</span></label>
          <div class="relative">
            <select id="reportType"
              class="w-full px-3.5 py-2 rounded-xl border-2 border-gray-200 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors appearance-none pr-10 text-gray-500">
              <option value="" disabled selected>Select a report type...</option>
              <option class="text-gray-800">GAD Report</option>
              <option class="text-gray-800">Medicine Supply Report</option>
              <option class="text-gray-800">Medical Supplies Report</option>
              <option class="text-gray-800">Daily Treatment Record</option>
              <option class="text-gray-800">Dental Services Report</option>
            </select>
            <i
              class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-[#8B0000] text-xs pointer-events-none"></i>
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
              <p class="text-[10px] text-gray-400 font-semibold uppercase mb-1">From <span class="text-red-400">*</span>
              </p>
              <input id="dateFrom" type="date"
                class="w-full px-3.5 py-2 rounded-xl border-2 border-gray-200 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors" />
            </div>
            <div>
              <p class="text-[10px] text-gray-400 font-semibold uppercase mb-1">To <span
                  class="text-gray-400 normal-case font-normal">(optional)</span></p>
              <input id="dateTo" type="date"
                class="w-full px-3.5 py-2 rounded-xl border-2 border-gray-200 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors" />
            </div>
          </div>
          <p class="text-[10px] text-gray-400 mt-1"><i class="fa-solid fa-circle-info mr-1"></i>Leave "To" empty to
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
            class="w-36 px-3.5 py-2 rounded-xl border-2 border-gray-200 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors" />
          <span class="text-[11px] text-gray-400 ml-2">Whole numbers only (1–100)</span>
          <p id="reportQtyErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1">
            <i class="fa-solid fa-circle-exclamation"></i> <span id="reportQtyErrMsg">Quantity must be between 1 and
              100.</span>
          </p>
        </div>
        <div id="formErrorBanner"
          class="hidden items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-2.5 text-sm font-medium">
          <i class="fa-solid fa-triangle-exclamation text-red-400 flex-shrink-0"></i>
          Please complete all required fields before downloading.
        </div>
      </form>
    </div>
    <div class="flex-shrink-0 border-t border-gray-100 px-6 py-4 flex justify-end gap-3 bg-white">
      <button type="button" onclick="closeCreateModal()"
        class="px-5 py-2 rounded-xl border-2 border-gray-200 text-gray-500 text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all">Cancel</button>
      <button type="button" id="downloadReportBtn"
        class="px-6 py-2 rounded-xl bg-[#8B0000] hover:bg-[#7a0000] text-white text-sm font-bold flex items-center gap-2 shadow-md hover:shadow-lg transition-all">
        <i class="fa-solid fa-download"></i> Download Report
      </button>
    </div>
  </div>
  <form method="dialog" class="modal-backdrop"><button onclick="closeCreateModal()"></button></form>
</dialog>

<!-- DOWNLOAD COMPLETE MODAL -->
<dialog id="downloadCompleteModal" class="modal">
  <div class="modal-box p-0 rounded-2xl overflow-hidden bg-white shadow-2xl max-w-sm">
    <div class="h-1.5 bg-gradient-to-r from-[#8B0000] to-[#FFD700] w-full"></div>
    <div class="px-8 py-10 text-center">
      <div
        class="w-16 h-16 bg-green-50 border-2 border-green-200 rounded-full flex items-center justify-center mx-auto mb-5">
        <i class="fa-solid fa-check text-green-500 text-2xl"></i>
      </div>
      <h3 class="text-xl font-bold text-[#8B0000] mb-2">Download Complete!</h3>
      <p class="text-gray-400 text-sm leading-relaxed mb-7">Your report has been successfully generated and
        downloaded.</p>
      <button onclick="closeDownloadModal()"
        class="px-8 py-2.5 rounded-xl bg-[#8B0000] hover:bg-[#7A0000] text-white font-bold text-sm shadow-md hover:shadow-lg transition-all duration-300">Done</button>
    </div>
  </div>
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
  /* ── Modal helpers ─────────────────────────────────────── */
  function closeCreateModal() {
    document.getElementById('createReportModal').close();
    document.getElementById('reportForm').reset();
    document.getElementById('reportNameCounter').textContent = '0 / 100';
    document.getElementById('reportNameCounter').classList.replace('text-red-500', 'text-gray-400');
    ['reportNameErr', 'reportTypeErr', 'dateFromErr', 'dateFutureErr', 'dateRangeErr', 'reportQtyErr', 'formErrorBanner']
      .forEach(id => { document.getElementById(id).classList.add('hidden'); document.getElementById(id).classList.remove('flex'); });
    ['reportName', 'reportType', 'dateFrom', 'dateTo', 'reportQty']
      .forEach(id => { document.getElementById(id).classList.remove('border-red-400'); document.getElementById(id).classList.add('border-gray-200'); });
  }
  function closeDownloadModal() { document.getElementById('downloadCompleteModal').close(); }

  /* ── Chart instances ───────────────────────────────────── */
  let gadChartInstance = null, weeklyChartInstance = null;

  function showGadEmpty() { document.getElementById('gadChart').style.display = 'none'; document.getElementById('gadEmptyState').style.display = 'flex'; document.getElementById('gadLoadingState').style.display = 'none'; }
  function showGadLoading() { document.getElementById('gadChart').style.display = 'none'; document.getElementById('gadEmptyState').style.display = 'none'; document.getElementById('gadLoadingState').style.display = 'flex'; }
  function showGadChart() { document.getElementById('gadChart').style.display = 'block'; document.getElementById('gadEmptyState').style.display = 'none'; document.getElementById('gadLoadingState').style.display = 'none'; }
  function showWeeklyEmpty() { document.getElementById('weeklyDentalCasesChart').style.display = 'none'; document.getElementById('weeklyEmptyState').style.display = 'flex'; document.getElementById('weeklyLoadingState').style.display = 'none'; }
  function showWeeklyLoading() { document.getElementById('weeklyDentalCasesChart').style.display = 'none'; document.getElementById('weeklyEmptyState').style.display = 'none'; document.getElementById('weeklyLoadingState').style.display = 'flex'; }
  function showWeeklyChart() { document.getElementById('weeklyDentalCasesChart').style.display = 'block'; document.getElementById('weeklyEmptyState').style.display = 'none'; document.getElementById('weeklyLoadingState').style.display = 'none'; }

  function buildGadChart(labels, female, male) {
    if (gadChartInstance) { gadChartInstance.destroy(); gadChartInstance = null; }
    gadChartInstance = new Chart(document.getElementById('gadChart'), {
      type: 'bar',
      data: { labels, datasets: [{ label: 'Female', data: female, backgroundColor: '#FFC0CB', borderRadius: 4 }, { label: 'Male', data: male, backgroundColor: '#89CFF0', borderRadius: 4 }] },
      options: {
        responsive: true, maintainAspectRatio: false, indexAxis: 'y',
        plugins: { legend: { position: 'top', labels: { font: { family: 'Inter', size: 12 } } }, tooltip: { callbacks: { label: ctx => `${ctx.dataset.label}: ${ctx.parsed.x} cases` } } },
        scales: { x: { beginAtZero: true, grid: { borderDash: [4, 4] }, title: { display: true, text: 'Number of Cases', font: { family: 'Inter' } } }, y: { grid: { display: false }, ticks: { font: { family: 'Inter' } } } }
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
        plugins: { legend: { position: 'top', labels: { font: { family: 'Inter', size: 12 } } }, tooltip: { callbacks: { label: ctx => `${ctx.dataset.label}: ${ctx.parsed.y} cases` } } },
        scales: { x: { grid: { display: false }, ticks: { font: { family: 'Inter' } } }, y: { beginAtZero: true, grid: { borderDash: [4, 4] }, ticks: { precision: 0, font: { family: 'Inter' } }, title: { display: true, text: 'Dental Cases', font: { family: 'Inter' } } } }
      }
    });
  }

  function makePieChart(canvasId, items) {
    if (!items || items.length === 0) return;
    new Chart(document.getElementById(canvasId), {
      type: 'doughnut',
      data: { labels: items.map(i => i.name), datasets: [{ data: items.map(i => Math.max(0, i.qty - i.used)), backgroundColor: PIE_COLORS.slice(0, items.length), borderWidth: 2, borderColor: '#fff' }] },
      options: {
        responsive: true, maintainAspectRatio: false, cutout: '50%',
        plugins: { legend: { position: 'bottom', labels: { font: { family: 'Inter', size: 10 }, boxWidth: 12, padding: 8 } }, tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed} remaining` } } }
      }
    });
  }

  /* ── Period AJAX ───────────────────────────────────────── */
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

  /* ── DOMContentLoaded ──────────────────────────────────── */
  document.addEventListener('DOMContentLoaded', function () {
    applyLayout('220px');
    applyTheme(localStorage.getItem('theme') || 'light');
    document.querySelectorAll('.theme-option').forEach(o =>
      o.addEventListener('click', () => applyTheme(o.getAttribute('data-theme'))));

    setTimeout(function () {
      const gadHasData = GAD_DATA.female.reduce((a, b) => a + b, 0) + GAD_DATA.male.reduce((a, b) => a + b, 0) > 0;
      if (gadHasData) { showGadChart(); buildGadChart(GAD_DATA.labels, GAD_DATA.female, GAD_DATA.male); } else { showGadEmpty(); }
      if (WEEKLY_DATA.datasets && WEEKLY_DATA.datasets.length > 0) { showWeeklyChart(); buildWeeklyChart(WEEKLY_DATA.labels, WEEKLY_DATA.datasets); } else { showWeeklyEmpty(); }
      makePieChart('medicinePieChart', MEDICINE_ITEMS);
      makePieChart('suppliesPieChart', SUPPLIES_ITEMS);
    }, 150);

    document.getElementById('gadPeriodSelect').addEventListener('change', function () { reloadGadChart(this.value); });
    document.getElementById('weeklyPeriodSelect').addEventListener('change', function () { reloadWeeklyChart(this.value); });

    /* ── Modal validation ── */
    const todayStr = new Date().toISOString().split('T')[0];
    document.getElementById('dateFrom').setAttribute('max', todayStr);
    document.getElementById('dateTo').setAttribute('max', todayStr);

    function setError(inputId, errId, show) {
      const input = document.getElementById(inputId), err = document.getElementById(errId);
      if (!input || !err) return;
      if (show) { err.classList.remove('hidden'); err.classList.add('flex'); input.classList.add('border-red-400'); input.classList.remove('border-gray-200'); }
      else { err.classList.add('hidden'); err.classList.remove('flex'); input.classList.remove('border-red-400'); input.classList.add('border-gray-200'); }
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

      ['dateFromErr', 'dateFutureErr', 'dateRangeErr'].forEach(id => { document.getElementById(id).classList.add('hidden'); document.getElementById(id).classList.remove('flex'); });
      ['dateFrom', 'dateTo'].forEach(id => { document.getElementById(id).classList.remove('border-red-400'); document.getElementById(id).classList.add('border-gray-200'); });

      if (!from) {
        document.getElementById('dateFromErr').classList.remove('hidden'); document.getElementById('dateFromErr').classList.add('flex');
        document.getElementById('dateFrom').classList.add('border-red-400'); document.getElementById('dateFrom').classList.remove('border-gray-200');
        valid = false;
      } else {
        const fromFuture = from > todayStr, toFuture = to && to > todayStr;
        if (fromFuture || toFuture) {
          document.getElementById('dateFutureErr').classList.remove('hidden'); document.getElementById('dateFutureErr').classList.add('flex');
          if (fromFuture) { document.getElementById('dateFrom').classList.add('border-red-400'); document.getElementById('dateFrom').classList.remove('border-gray-200'); }
          if (toFuture) { document.getElementById('dateTo').classList.add('border-red-400'); document.getElementById('dateTo').classList.remove('border-gray-200'); }
          valid = false;
        } else if (to && new Date(to) < new Date(from)) {
          document.getElementById('dateRangeErr').classList.remove('hidden'); document.getElementById('dateRangeErr').classList.add('flex');
          document.getElementById('dateTo').classList.add('border-red-400'); document.getElementById('dateTo').classList.remove('border-gray-200');
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
          .forEach(id => { document.getElementById(id).classList.add('hidden'); document.getElementById(id).classList.remove('flex'); });
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
      ['dateFromErr', 'dateFutureErr', 'dateRangeErr'].forEach(id => { document.getElementById(id).classList.add('hidden'); document.getElementById(id).classList.remove('flex'); });
      ['dateFrom', 'dateTo'].forEach(id => { document.getElementById(id).classList.remove('border-red-400'); document.getElementById(id).classList.add('border-gray-200'); });
      if (!from && !to) return;
      const fromFuture = from && from > todayStr, toFuture = to && to > todayStr;
      if (fromFuture || toFuture) {
        document.getElementById('dateFutureErr').classList.remove('hidden'); document.getElementById('dateFutureErr').classList.add('flex');
        if (fromFuture) { document.getElementById('dateFrom').classList.add('border-red-400'); document.getElementById('dateFrom').classList.remove('border-gray-200'); }
        if (toFuture) { document.getElementById('dateTo').classList.add('border-red-400'); document.getElementById('dateTo').classList.remove('border-gray-200'); }
        return;
      }
      if (from && to && new Date(to) < new Date(from)) {
        document.getElementById('dateRangeErr').classList.remove('hidden'); document.getElementById('dateRangeErr').classList.add('flex');
        document.getElementById('dateTo').classList.add('border-red-400'); document.getElementById('dateTo').classList.remove('border-gray-200');
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