@extends('layouts.app')

@section('layout-role', 'dentist')

@section('title', 'Daily Treatment Records')

@section('content')

<main id="mainContent" class="dentist-page-shell dentist-records-page daily-treatment-page page-enter">
  <div class="w-full">

    <section class="dentist-hero mb-5">
      <div class="dentist-hero-content">
        <div class="dentist-hero-icon">
          <i class="fa-solid fa-notes-medical"></i>
        </div>

        <div class="min-w-0">
          <div class="dentist-hero-eyebrow">
            <i class="fa-solid fa-tooth"></i>
            Daily Treatment
          </div>

          <h1 class="dentist-hero-title">Daily Treatment Record</h1>
        </div>
      </div>

      <div class="dentist-hero-actions">
        <button type="button" class="ui-btn ui-btn-primary" onclick="openDailyCreateReportModal()">
          <i class="fa-solid fa-plus"></i>
          <span>Create Report</span>
        </button>
      </div>
    </section>

    <section class="card service-records-card dtr-card">
      <div class="card-header dtr-card-header">
        <div class="card-header-left">
          <div class="card-header-icon">
            <i class="fa-solid fa-table-list"></i>
          </div>

          <div>
            <h2 class="card-title">Treatment Records</h2>
            <p class="card-subtitle">Daily patient treatment entries</p>
          </div>
        </div>

        <div class="card-header-right dtr-toolbar search-filter-row">
          <div class="dtr-month-picker fp-date-input-wrap">
          <input type="text" id="monthPicker" class="form-input-custom fp-date-input"
              data-month-only-picker placeholder="Select month" readonly>

            <i class="fa-solid fa-calendar-days fp-date-icon"></i>
          </div>

            <div class="voice-search-row">
              <x-search-bar
                  id="searchInput"
                  placeholder="Search patient, program, treatment…"
                  callback="handleDailyTreatmentSearch"
                  :debounce="350"
                  clear-label="Clear search"
              />

              <x-voice-input
                  target="#searchInput"
                  status-id="dailySearchVoiceStatus"
                  label="Use voice search"
                  title="Voice search"
              />
          </div>

          <div class="dtr-filter-actions">
            <button id="openFilter" type="button" class="global-filter-btn" aria-pressed="false"
              onclick="openDailyFilterPanel()">
              <i class="fa-solid fa-sliders"></i>
              <span>Filter</span>
              <span id="filterBadge" class="filter-badge"></span>
            </button>

            <button id="externalClearFilterBtn" type="button" class="global-filter-reset-btn hidden"
              title="Reset filters" aria-label="Reset filters" onclick="clearDailyFilters()">
              <i class="fa-solid fa-rotate-left"></i>
            </button>
          </div>
        </div>
      </div>

      <x-pagination-bar
        id="dailyPagebarTop"
        info-id="dailyPageInfoTop"
        pagination-id="dailyPaginationTop"
        position="top"
        :show-entries="true"
        page-size-id="dtPerPageSelect"
        page-size-callback="selectDailyPerPage"
        :page-size-value="10"
        label="entries"
      />

      <div class="card-body dtr-card-body">
        <div id="dailyListView" class="table-responsive-fix service-table-wrap dtr-table-wrap">
          <table class="data-table service-table dtr-table">
            <thead>
              <tr>
                <th>Date</th>
                <th>Patient Name</th>
                <th>Email / Contact Number</th>
                <th>Office / Program</th>
                <th>Gender</th>
                <th>Treatment Done</th>
                <th>Minutes Processed</th>
                <th>Signature</th>
              </tr>
            </thead>

            <tbody id="dailyTableBody"></tbody>
          </table>
        </div>

        <div id="dailyGridView" class="service-record-grid dtr-grid" hidden></div>

        <div id="dailyEmptyState" class="empty-state-host"></div>
      </div>

      <x-pagination-bar
        id="dailyPagebarBottom"
        info-id="dailyPageInfoBottom"
        pagination-id="dailyPaginationBottom"
        position="bottom"
        label="entries"
      />
    </section>
  </div>
</main>

<div id="filterModal" class="filter-drawer-wrapper" aria-hidden="true">
  <div class="filter-drawer-overlay" onclick="closeDailyFilterPanel()"></div>

  <div class="filter-drawer-panel">

        <div class="filter-drawer-header">
          <div class="filter-drawer-title">
          <i class="fa-solid fa-sliders"></i>
          <h2>Filters</h2>
        </div>

    <button type="button" class="filter-drawer-close"
      onclick="closeDailyFilterPanel()" aria-label="Close Filters">

      <i class="fa-solid fa-xmark"></i>
    </button>
  </div>

    <div class="filter-drawer-body">
      <div id="dailyActiveFiltersSection" class="filter-active-section hidden">

        <div class="filter-active-header">
            <span class="filter-active-title">Active Filters</span>

            <button id="dailyClearAllChipsBtn" type="button" 
            class="filter-clear-all ui-btn ui-btn-secondary ui-btn-sm" onclick="clearDailyFilterPanelDraft()">
              
            <i class="fa-solid fa-rotate-left"></i>
            <span>Clear All</span>
        </button>
    </div>

        <div id="dailyActiveChipsContainer" class="active-filters-container"></div>
    </div>

      <div>
        <h3 class="filter-section-title">Sort by Name</h3>

        <div class="filter-chip-row" id="dailyNameSortGroup">
          <label class="choice-chip">
            <input type="radio" name="daily_sort_name" value="az" class="chip-radio" data-daily-filter-key="sort_name">
            <span>A to Z</span>
          </label>

          <label class="choice-chip">
            <input type="radio" name="daily_sort_name" value="za" class="chip-radio" data-daily-filter-key="sort_name">
            <span>Z to A</span>
          </label>
        </div>
      </div>

      <div>
        <h3 class="filter-section-title">Date Order</h3>

        <div class="filter-chip-row" id="dailyDateSortGroup">
          <label class="choice-chip">
            <input type="radio" name="daily_sort_date" value="desc" class="chip-radio"
              data-daily-filter-key="sort_date">
            <span>Newest First</span>
          </label>

          <label class="choice-chip">
            <input type="radio" name="daily_sort_date" value="asc" class="chip-radio" data-daily-filter-key="sort_date">
            <span>Oldest First</span>
          </label>
        </div>
      </div>

      <div>
        <h3 class="filter-section-title">Office</h3>

        <div class="filter-chip-row" id="dailyOfficeGroup">
          @foreach (['Administrative', 'Faculty', 'Dependent'] as $office)
          <label class="choice-chip">
            <input type="radio" name="daily_office_type" value="{{ $office }}" class="chip-radio"
              data-daily-filter-key="office_type">
            <span>{{ $office }}</span>
          </label>
          @endforeach
        </div>
      </div>

      <div>
        <h3 class="filter-section-title">Course</h3>

        <div class="filter-chip-grid" id="dailyProgramGroup">
          @foreach (['BSIT', 'BSECE', 'BSBA - HRM', 'BSED - ENG', 'BSOA', 'BSPSYCH', 'DIT', 'BSME', 'BSBA - MM', 'BSED -
          MATH', 'DOMT'] as $course)
          <label class="choice-chip">
            <input type="radio" name="daily_program_code" value="{{ $course }}" class="chip-radio"
              data-daily-filter-key="program_code">
            <span>{{ $course }}</span>
          </label>
          @endforeach
        </div>
      </div>
    </div>

    <div class="filter-drawer-footer">
      <button id="filterResetBtn" type="button"
        class="filter-clear-btn ui-btn ui-btn-secondary ui-btn-sm"
        onclick="clearDailyFilterPanelDraft()">

        <i class="fa-regular fa-trash-can text-lg"></i>
        <span>Clear Filters</span>
      </button>

      <div class="filter-footer-actions">
        <button id="filterCloseBtn" type="button"
          class="filter-cancel-btn ui-btn ui-btn-secondary"
          onclick="closeDailyFilterPanel()">

          <i class="fa-solid fa-xmark"></i>
          <span>Cancel</span>
        </button>

        <button id="filterApplyBtn" type="button"
          class="filter-apply-btn ui-btn ui-btn-primary"
          onclick="applyDailyFilters()">

          <i class="fa-solid fa-check"></i>
          <span id="dailyShowResultsText" class="filter-results-text">
            Show 0 results
          </span>
        </button>

      </div>
    </div>
  </div>
</div>

<div id="dailyRecordModal" class="ui-modal modal-overlay" aria-hidden="true"
  onclick="closeModalOnBackdrop(event, 'dailyRecordModal')">
  <div class="modal-box-inner um-user-modal report-create-modal max-w-5xl" onclick="event.stopPropagation()">
    <div
      class="um-user-modal-header px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white rounded-t-2xl z-10">
      <div class="flex items-center gap-3 min-w-0">
        <div
          class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#8B0000] via-[#a40000] to-[#6B0000] flex items-center justify-center shadow-lg shadow-red-900/20 flex-shrink-0">
          <i class="fa-solid fa-user-pen text-white text-sm"></i>
        </div>

        <div class="min-w-0">
          <h3 class="font-extrabold text-gray-800 text-lg leading-tight">Add Daily Treatment Record</h3>
          <p class="text-xs text-gray-500 mt-0.5">Cleaner entry form with live procedure timer and signature upload.</p>
        </div>
      </div>

      <button type="button" onclick="closeDailyRecordModal()" class="um-modal-x" aria-label="Close add record modal">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <form id="dailyRecordForm" class="flex-1 flex flex-col min-h-0" novalidate>
      <div class="um-user-modal-body">
        <div class="um-user-main-card space-y-6">
          <div class="grid gap-4 lg:grid-cols-[minmax(0,1.4fr)_minmax(280px,0.9fr)]">
            <section class="rounded-2xl border border-[#ead9d9] bg-[#fffafa] p-4 sm:p-5">
              <div class="flex items-start justify-between gap-3 mb-4">
                <div>
                  <h4 class="text-base font-extrabold text-gray-800 leading-tight">Patient and Treatment Details</h4>
                  <p class="text-xs text-gray-500 mt-1">Fields are spaced out para mas madaling basahin at encode-an.</p>
                </div>
                <span class="inline-flex items-center rounded-full bg-white px-3 py-1 text-[11px] font-bold text-[#8B0000] border border-[#f1d7d7]">
                  Record Entry
                </span>
              </div>

              <div class="grid gap-4 md:grid-cols-2">
                <div>
                  <label for="recordTreatmentDate" class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                    Treatment Date <span class="text-red-500">*</span>
                  </label>
                  <input id="recordTreatmentDate" name="treatment_date" type="date"
                    class="field-input w-full border border-gray-200 px-3.5 py-3 text-sm bg-white">
                </div>

                <div>
                  <label for="recordGender" class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                    Gender
                  </label>
                  <select id="recordGender" name="gender" class="field-input w-full border border-gray-200 px-3.5 py-3 text-sm bg-white">
                    <option value="">Select gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                  </select>
                </div>

                <div class="md:col-span-2">
                  <label for="recordPatientName" class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                    Patient Name <span class="text-red-500">*</span>
                  </label>
                  <input id="recordPatientName" name="patient_name" type="text" maxlength="150"
                    placeholder="Enter patient full name"
                    class="field-input w-full border border-gray-200 px-3.5 py-3 text-sm bg-white">
                </div>

                <div>
                  <label for="recordPatientEmail" class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                    Email Address
                  </label>
                  <input id="recordPatientEmail" name="patient_email" type="email" maxlength="190"
                    placeholder="name@example.com"
                    class="field-input w-full border border-gray-200 px-3.5 py-3 text-sm bg-white">
                </div>

                <div>
                  <label for="recordPatientPhone" class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                    Contact Number
                  </label>
                  <input id="recordPatientPhone" name="patient_phone" type="text" maxlength="30"
                    placeholder="09XXXXXXXXX"
                    class="field-input w-full border border-gray-200 px-3.5 py-3 text-sm bg-white">
                </div>

                <div>
                  <label for="recordOfficeType" class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                    Office
                  </label>
                  <select id="recordOfficeType" name="office_type" class="field-input w-full border border-gray-200 px-3.5 py-3 text-sm bg-white">
                    <option value="">Select office</option>
                    <option value="Administrative">Administrative</option>
                    <option value="Faculty">Faculty</option>
                    <option value="Dependent">Dependent</option>
                  </select>
                </div>

                <div>
                  <label for="recordProgramCode" class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                    Program / Course
                  </label>
                  <input id="recordProgramCode" name="program_code" type="text" maxlength="50"
                    placeholder="e.g. BSIT"
                    class="field-input w-full border border-gray-200 px-3.5 py-3 text-sm bg-white">
                </div>

                <div class="md:col-span-2">
                  <label for="recordTreatmentDone" class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                    Treatment Done <span class="text-red-500">*</span>
                  </label>
                  <textarea id="recordTreatmentDone" name="treatment_done" rows="4" maxlength="150"
                    placeholder="Describe the treatment performed"
                    class="field-input w-full border border-gray-200 px-3.5 py-3 text-sm bg-white resize-none"></textarea>
                </div>
              </div>
            </section>

            <section class="rounded-2xl border border-[#ead9d9] bg-white p-4 sm:p-5">
              <div class="flex items-start justify-between gap-3 mb-4">
                <div>
                  <h4 class="text-base font-extrabold text-gray-800 leading-tight">Procedure Timer and Signature</h4>
                  <p class="text-xs text-gray-500 mt-1">Mag-start ito once pinindot ang procedure start.</p>
                </div>
                <i class="fa-solid fa-clock text-[#8B0000] text-lg"></i>
              </div>

              <div class="rounded-2xl bg-gradient-to-br from-[#8B0000] via-[#a10000] to-[#6B0000] text-white p-5 shadow-lg">
                <p class="text-[11px] uppercase tracking-[0.22em] text-white/70 font-bold mb-2">Live Procedure Time</p>
                <div id="dailyTimerDisplay" class="text-3xl sm:text-[2rem] font-black tracking-[0.18em]">00:00:00</div>
                <p id="dailyTimerStatus" class="text-xs text-white/80 mt-3">Timer has not started yet.</p>
              </div>

              <div class="grid gap-3 sm:grid-cols-2 mt-4">
                <button type="button" id="dailyTimerStartBtn"
                  class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#8B0000] px-4 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#6B0000]">
                  <i class="fa-solid fa-play"></i>
                  Start Procedure
                </button>

                <button type="button" id="dailyTimerStopBtn"
                  class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm font-bold text-gray-700 transition hover:border-[#8B0000] hover:text-[#8B0000]">
                  <i class="fa-solid fa-stop"></i>
                  Stop Procedure
                </button>
              </div>

              <div class="grid gap-4 sm:grid-cols-2 mt-4">
                <div>
                  <label for="recordTimeInDisplay" class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                    Started At
                  </label>
                  <input id="recordTimeInDisplay" type="text" readonly
                    class="field-input w-full border border-gray-200 px-3.5 py-3 text-sm bg-gray-50 text-gray-700">
                </div>

                <div>
                  <label for="recordTimeOutDisplay" class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                    Stopped At
                  </label>
                  <input id="recordTimeOutDisplay" type="text" readonly
                    class="field-input w-full border border-gray-200 px-3.5 py-3 text-sm bg-gray-50 text-gray-700">
                </div>

                <div class="sm:col-span-2">
                  <label for="recordMinutesProcessed" class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                    Number of Minutes Processed
                  </label>
                  <input id="recordMinutesProcessed" name="minutes_processed" type="number" min="0" max="1440" readonly
                    class="field-input w-full border border-gray-200 px-3.5 py-3 text-sm bg-gray-50 text-gray-700">
                </div>
              </div>

              <input id="recordTimeIn" name="time_in" type="hidden">
              <input id="recordTimeOut" name="time_out" type="hidden">

              <div class="mt-4">
                <label for="recordPatientSignature" class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                  Patient Signature
                </label>
                <input id="recordPatientSignature" name="patient_signature" type="file" accept=".png,.jpg,.jpeg,image/png,image/jpeg"
                  class="field-input w-full border border-gray-200 px-3.5 py-3 text-sm bg-white file:mr-3 file:rounded-lg file:border-0 file:bg-[#fff0f0] file:px-3 file:py-2 file:text-xs file:font-bold file:text-[#8B0000]">
                <p class="text-[11px] text-gray-400 mt-2">Optional. Accepted formats: PNG, JPG, JPEG up to 5 MB.</p>
              </div>

              <div id="dailyRecordErrorBanner" class="report-modal-error hidden mt-4">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>Please complete the required fields before saving.</span>
              </div>
            </section>
          </div>
        </div>
      </div>

      <div class="modal-ft um-user-modal-footer">
        <button type="button" onclick="closeDailyRecordModal()" class="modal-btn-ghost">
          Cancel
        </button>

        <button type="button" id="saveDailyRecordBtn" class="modal-btn-confirm-reject um-save-user-btn">
          <span class="btn-confirm-icon">
            <i class="fa-solid fa-floppy-disk"></i>
          </span>
          <span>Save Record</span>
        </button>
      </div>
    </form>
  </div>
</div>

<div id="createReportModal" class="ui-modal" aria-hidden="true"
  onclick="closeModalOnBackdrop(event, 'createReportModal')">

  <div class="ui-modal-card modal-md"
      onclick="event.stopPropagation()">
  
  <div class="modal-hd">
    <div class="modal-heading">
      <div class="modal-icon">
        <i class="fa-solid fa-file-circle-plus"></i>
      </div>

        <div class="modal-copy">
          <h3 class="modal-title">
            Create Daily Treatment Report
          </h3>

          <p class="modal-subtitle">
            Fields marked <span class="text-yellow-500 font-bold">*</span> are required.
          </p>
        </div>
      </div>

      <button type="button" class="modal-x" onclick="closeDailyCreateReportModal()" aria-label="Close create report modal">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <form id="reportForm" class="flex-1 flex flex-col min-h-0" novalidate>
      <div class="modal-bd">
        <div class="modal-form-section">
          <div class="modal-section-heading">
            <div class="modal-section-icon">
              <i class="fa-solid fa-file-lines"></i>
            </div>

            <div>
              <h4>Report Details</h4>
              <p>Choose the report type, date range, and quantity.</p>
            </div>
          </div>

          <div class="modal-form-grid">
            <div>
              <div class="modal-inline-control">
                <label for="reportName" class="form-label">
                  Report Name <span class="text-red-500">*</span>
                </label>

                <span id="reportNameCounter" class="modal-helper-text">0 / 100</span>
              </div>

              <div class="modal-inline-control" data-voice-field>
                <input id="reportName" name="report_name" type="text" maxlength="100"
                  placeholder="e.g. Daily Treatment Report — Dec 2026"
                  class="form-input modal-inline-main">

                <x-voice-input
                  target="#reportName"
                  status-id="reportNameVoiceStatus"
                  label="Voice input for report name"
                  title="Voice input"
                />
              </div>

              <p id="reportNameErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1">
                <i class="fa-solid fa-circle-exclamation"></i>
                Report name is required.
              </p>
            </div>

            <div>
              <label for="reportType" class="form-label">
                Report Type <span class="text-red-500">*</span>
              </label>

              <div class="report-custom-select report-template-select" data-report-select>
                <select id="reportType" name="document_type" class="report-native-select" data-report-select-native>
                  <option value="daily_treatment_record" data-document-type="daily_treatment_record" selected>Daily
                    Treatment Record</option>
                </select>

                <button type="button" class="report-select-trigger" data-report-select-trigger
                  data-placeholder="Select a report type..." aria-expanded="false">
                  <span class="report-select-main">
                    <span class="report-select-icon">
                      <i class="fa-solid fa-file-lines"></i>
                    </span>
                    <span data-report-select-label>Select a report type...</span>
                  </span>
                  <i class="fa-solid fa-chevron-down report-select-chevron"></i>
                </button>

                <div class="report-select-menu" data-report-select-menu>
                  @forelse (($dailyTreatmentTemplates ?? collect()) as $index => $template)
                  <button type="button" class="report-select-option {{ $index === 0 ? 'is-active' : '' }}" data-report-select-option
                    data-value="{{ $template->id }}" data-document-type="{{ $template->document_type }}">
                    <span>{{ $template->name }}</span>
                    <i class="fa-solid fa-check"></i>
                  </button>
                  @empty
                  <button type="button" class="report-select-option" disabled>
                    <span>No active daily treatment templates available</span>
                    <i class="fa-solid fa-check"></i>
                  </button>
                  @endforelse
                </div>
              </div>

              <p id="reportTypeErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1">
                <i class="fa-solid fa-circle-exclamation"></i>
                Please select a report type.
              </p>
            </div>
            
          <div class="modal-form-grid modal-form-grid-2">
            <div>
              <label class="form-label">
              From <span class="text-red-500">*</span>
              </label>

              <div class="fp-date-input-wrap">
                <input id="dateFrom" name="date_from" type="text"
                  class="form-input js-flatpickr-date-max-today"
                  placeholder="Select start date" readonly>
                <i class="fa-regular fa-calendar fp-date-icon"></i>
              </div>

              <p id="dateFromErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1">
                <i class="fa-solid fa-circle-exclamation"></i>
                Start date is required.
              </p>
            </div>

            <div>
              <label class="form-label">
                To <span class="text-gray-400 normal-case font-normal">(optional)</span>
              </label>

              <div class="fp-date-input-wrap">
                <input id="dateTo" name="date_to" type="text"
                  class="form-input js-flatpickr-date-max-today"
                  placeholder="Select end date" readonly>
                <i class="fa-regular fa-calendar fp-date-icon"></i>
              </div>
            </div>
          </div>

            <div>
              <p class="modal-helper-text">
                <i class="fa-solid fa-circle-info mr-1"></i>
                Leave "To" empty to report on a single date.
              </p>

              <p id="dateFutureErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1">
                <i class="fa-solid fa-circle-exclamation"></i>
                Dates cannot be in the future.
              </p>

              <p id="dateRangeErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1">
                <i class="fa-solid fa-circle-exclamation"></i>
                End date must be on or after start date.
              </p>
            </div>

            <div>
              <label for="reportQty" class="form-label">
              Quantity <span class="text-red-500">*</span>
              </label>

              <div class="report-qty-row">
                <div class="report-qty-control">
                  <button type="button" class="report-qty-btn" data-qty-minus aria-label="Decrease quantity">
                    <i class="fa-solid fa-minus"></i>
                  </button>

                  <input id="reportQty" name="quantity" type="number" min="1" max="100" step="1" placeholder="1 – 100"
                    class="form-input modal-number-input report-qty-input">

                  <button type="button" class="report-qty-btn" data-qty-plus aria-label="Increase quantity">
                    <i class="fa-solid fa-plus"></i>
                  </button>
                </div>

                <span class="report-qty-helper">Whole numbers only</span>
              </div>

              <p id="reportQtyErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span id="reportQtyErrMsg">Quantity must be between 1 and 100.</span>
              </p>
            </div>

            <div>
              <div id="formErrorBanner" class="modal-error-banner hidden">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>Please complete all required fields before downloading.</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-ft">
        <button type="button" class="btn-close-modal" onclick="closeDailyCreateReportModal()" >
          Cancel
        </button>

        <button type="button" id="downloadReportBtn" class="modal-btn-primary">
          
            <i class="fa-solid fa-download"></i>
            <span>Download</span>
          </button>
        </div>
      </form>
    </div>
  </div>

<div id="downloadCompleteModal" class="ui-modal" onclick="closeModalOnBackdrop(event, 'downloadCompleteModal')">
  <div class="ui-modal-card modal-box p-0 rounded-2xl overflow-hidden bg-white shadow-2xl max-w-sm">
    <div class="h-1.5 bg-gradient-to-r from-[#8B0000] to-[#FFD700] w-full"></div>
    <div class="px-8 py-10 text-center">
      <div
        class="w-16 h-16 bg-green-50 border-2 border-green-200 rounded-full flex items-center justify-center mx-auto mb-5">
        <i class="fa-solid fa-check text-green-500 text-2xl"></i>
      </div>
      <h3 class="text-xl font-bold text-[#8B0000] mb-2">Download Complete!</h3>
      <p class="text-gray-500 text-sm leading-relaxed mb-7">Your report has been successfully generated and downloaded.
      </p>
      <button type="button" onclick="closeDownloadModal()"
        class="px-8 py-2.5 rounded-xl bg-[#8B0000] hover:bg-[#6b0000] text-white font-bold text-sm shadow-sm transition-all w-full">Done</button>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  const DTR_LIST_URL = "{{ route('dentist.dentist.reports.daily-treatment-record.list') }}";
  const DTR_STORE_URL = "{{ route('dentist.dentist.reports.daily-treatment-record.store') }}";
  const DTR_DOWNLOAD_URL = "{{ route('dentist.dentist.report.daily-treatment-record-download') }}";
  const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || "{{ csrf_token() }}";

  const dtrState = {
    search: '',
    month: '',
    office_type: '',
    program_code: '',
    sort_name: '',
    sort_date: '',
    page: 1,
    perPage: 10,
    total: 0,
  };

  let dtrDraft = { ...dtrState };
  let dtrListController = null;
  let dtrDraftCountController = null;
  let dtrDraftCountTimer = null;
  let dailyTimerInterval = null;
  let dailyTimerStartedAt = null;
  let dailyTimerStoppedAt = null;

  function escapeDtrHtml(value) {
    return String(value ?? '')
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  function formatDateToMMDDYY(dateStr) {
    if (!dateStr) return '';

    const d = new Date(dateStr);
    if (Number.isNaN(d.getTime())) return escapeDtrHtml(dateStr);

    const mm = String(d.getMonth() + 1).padStart(2, '0');
    const dd = String(d.getDate()).padStart(2, '0');
    const yy = String(d.getFullYear()).slice(-2);

    return `${mm}/${dd}/${yy}`;
  }

  function formatDtrMonthLabel(value) {
    if (!/^\d{4}-\d{2}$/.test(value || '')) return '';

    const [year, month] = value.split('-');
    const date = new Date(Number(year), Number(month) - 1, 1);

    return date.toLocaleDateString('en-US', {
      month: 'long',
      year: 'numeric',
    });
  }

  function formatDtrClock(value) {
    if (!value) return '—';
    return escapeDtrHtml(value);
  }

  function formatDtrDateTimeDisplay(date) {
    if (!(date instanceof Date) || Number.isNaN(date.getTime())) return '';

    return date.toLocaleString('en-US', {
      month: 'short',
      day: '2-digit',
      year: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit',
      hour12: true,
    });
  }

  function toLocalDateInputValue(date) {
    if (!(date instanceof Date) || Number.isNaN(date.getTime())) return '';

    const pad = (value) => String(value).padStart(2, '0');
    const year = date.getFullYear();
    const month = pad(date.getMonth() + 1);
    const day = pad(date.getDate());
    const hour = pad(date.getHours());
    const minute = pad(date.getMinutes());
    const second = pad(date.getSeconds());

    return `${year}-${month}-${day}T${hour}:${minute}:${second}`;
  }

  function buildDtrParams(source = dtrState, options = {}) {
    const params = new URLSearchParams();

    if (source.month) params.set('month', source.month);
    if (source.search) params.set('search', source.search);
    if (source.office_type) params.set('office_type', source.office_type);
    if (source.program_code) params.set('program_code', source.program_code);
    if (source.sort_name) params.set('sort_name', source.sort_name);
    if (source.sort_date) params.set('sort_date', source.sort_date);

    params.set('per_page', options.perPage || source.perPage || 10);
    params.set('page', options.page || source.page || 1);

    return params;
  }

  function dtrFilterCount(source = dtrState) {
    return [source.office_type, source.program_code, source.sort_name, source.sort_date].filter(Boolean).length;
  }

  function updateFilterButtonState() {
    window.setGlobalFilterButtonState?.({
      buttonId: 'openFilter',
      badgeId: 'filterBadge',
      resetId: 'externalClearFilterBtn',
      count: dtrFilterCount(),
    });
  }

  function renderDailyRecords(records) {
    const tbody = document.getElementById('dailyTableBody');
    const grid = document.getElementById('dailyGridView');
    const listView = document.getElementById('dailyListView');
    const emptyState = document.getElementById('dailyEmptyState');

    if (tbody) tbody.innerHTML = '';
    if (grid) grid.innerHTML = '';

    const hasData = Array.isArray(records) && records.length > 0;

    if (!hasData) {
      if (listView) listView.hidden = true;
      if (grid) grid.hidden = true;
      showDailyEmptyState();
      return;
    }

    if (emptyState) {
      window.hideGlobalEmptyState?.(emptyState);
    }

    if (listView) listView.hidden = false;

    records.forEach(record => {
      const contact = [record.patient_email, record.patient_phone].filter(Boolean).join(' / ') || '—';
      const officeOrProgram = record.office_type || record.program_code || '—';
      const signature = record.has_signature
        ? '<span class="dtr-signature yes"><i class="fa-solid fa-check"></i> Signed</span>'
        : '<span class="dtr-signature no">No signature</span>';
      const timeRange = record.time_in || record.time_out
        ? `<div class="text-[11px] text-gray-500 mt-1">${formatDtrClock(record.time_in)}${record.time_out ? ` - ${formatDtrClock(record.time_out)}` : ''}</div>`
        : '';

      if (tbody) {
        tbody.insertAdjacentHTML('beforeend', `
          <tr>
            <td class="whitespace-nowrap">
              <div class="font-semibold text-gray-800">${formatDateToMMDDYY(record.treatment_date)}</div>
              ${timeRange}
            </td>
            <td class="min-w-[220px]">
              <div class="font-semibold text-gray-800">${escapeDtrHtml(record.patient_name || '—')}</div>
              <div class="text-[11px] text-gray-500 mt-1">${escapeDtrHtml(record.gender || 'Gender not set')}</div>
            </td>
            <td class="min-w-[240px] text-[12px] leading-5">${escapeDtrHtml(contact)}</td>
            <td class="min-w-[140px]">
              <div class="font-semibold text-gray-800">${escapeDtrHtml(officeOrProgram)}</div>
            </td>
            <td class="text-center">${escapeDtrHtml(record.gender || '—')}</td>
            <td class="min-w-[220px] text-[12px] leading-5">${escapeDtrHtml(record.treatment_done || '—')}</td>
            <td class="text-center whitespace-nowrap">
              <span class="inline-flex min-w-[56px] items-center justify-center rounded-full bg-[#fff5f5] px-3 py-1 text-xs font-bold text-[#8B0000]">
                ${escapeDtrHtml(record.minutes_processed ?? 0)} mins
              </span>
            </td>
            <td class="text-center">${signature}</td>
          </tr>
        `);
      }

      if (grid) {
        grid.insertAdjacentHTML('beforeend', `
          <article class="service-record-card">
            <div class="service-record-card-head">
              <div>
                <h3>${escapeDtrHtml(record.patient_name || '—')}</h3>
                <p>${formatDateToMMDDYY(record.treatment_date)}</p>
              </div>
              <span class="service-record-chip">${escapeDtrHtml(record.gender || 'N/A')}</span>
            </div>

            <div class="service-record-meta">
              <span><i class="fa-solid fa-envelope"></i>${escapeDtrHtml(record.patient_email || 'No email')}</span>
              <span><i class="fa-solid fa-phone"></i>${escapeDtrHtml(record.patient_phone || 'No contact')}</span>
              <span><i class="fa-solid fa-building"></i>${escapeDtrHtml(officeOrProgram)}</span>
              <span><i class="fa-solid fa-clock"></i>${escapeDtrHtml(record.minutes_processed ?? 0)} mins</span>
            </div>

            <p class="service-record-treatment">${escapeDtrHtml(record.treatment_done || '—')}</p>
          </article>
        `);
      }
    });
  }

  function showDailyEmptyState() {
    const emptyState = document.getElementById('dailyEmptyState');
    if (!emptyState) return;

    let icon = 'fa-clipboard-list';
    let title = 'No daily treatment records yet';
    let sub = 'Treatment records will appear here once added to the system.';
    let actionHtml = '';

    if (dtrState.search) {
      icon = 'fa-magnifying-glass';
      title = `No results for “${escapeDtrHtml(dtrState.search)}”`;
      sub = 'Try searching another patient, program, contact, or treatment.';
      actionHtml = `
        <button type="button" class="empty-state-btn" onclick="clearDailySearch()">
          <i class="fa-solid fa-xmark"></i>
          Clear search
        </button>
      `;
    } else if (dtrState.month) {
      icon = 'fa-calendar-xmark';
      title = `No record found for “${escapeDtrHtml(formatDtrMonthLabel(dtrState.month))}”`;
      sub = dtrFilterCount() > 0
        ? 'Try adjusting the filter panel or clearing filters.'
        : 'No daily treatment entries were recorded for this month.';
      actionHtml = dtrFilterCount() > 0
        ? `<button type="button" class="empty-state-btn" onclick="clearDailyFilters()"><i class="fa-solid fa-filter-circle-xmark"></i>Clear filters</button>`
        : '';
    } else if (dtrFilterCount() > 0) {
      icon = 'fa-filter-circle-xmark';
      title = 'No records match the selected filters';
      sub = 'Try adjusting the filter panel or clearing all filters.';
      actionHtml = `
        <button type="button" class="empty-state-btn" onclick="clearDailyFilters()">
          <i class="fa-solid fa-filter-circle-xmark"></i>
          Clear filters
        </button>
      `;
    }

    emptyState.hidden = false;
    emptyState.className = 'empty-state-host dtr-empty-host show';
    emptyState.innerHTML = `
      <div class="empty-state">
        <div class="empty-state-icon">
          <i class="fa-solid ${icon}"></i>
        </div>
        <h3 class="empty-state-title">${title}</h3>
        <p class="empty-state-sub">${sub}</p>
        ${actionHtml ? `<div class="empty-state-actions">${actionHtml}</div>` : ''}
      </div>
    `;
  }

  async function fetchDailyRecords(options = {}) {
    if (dtrListController) dtrListController.abort();
    dtrListController = new AbortController();

    const params = buildDtrParams(dtrState, {
      page: options.page || dtrState.page,
      perPage: dtrState.perPage,
    });

    try {
      const res = await fetch(`${DTR_LIST_URL}?${params.toString()}`, {
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        signal: dtrListController.signal,
      });

      if (!res.ok) throw new Error('Failed to load records');

      const json = await res.json();
      const meta = json.meta || {};

      dtrState.total = Number(meta.total || 0);
      dtrState.page = Number(meta.current_page || 1);
      dtrState.perPage = Number(meta.per_page || dtrState.perPage || 10);

      renderDailyRecords(json.data || []);
      renderDtrPagebar(meta);
      updateFilterButtonState();
      updateDailyDraftCountText(dtrState.total);
    } catch (err) {
      if (err.name === 'AbortError') return;

      console.error(err);
      dtrState.total = 0;
      renderDailyRecords([]);
      renderDtrPagebar({ total: 0, from: 0, to: 0, current_page: 1, last_page: 1, per_page: dtrState.perPage });
      updateFilterButtonState();
    }
  }

  function renderDtrPagebar(meta = {}) {
    const total = Number(meta.total || 0);
    const from = Number(meta.from || 0);
    const to = Number(meta.to || 0);

    const infoHtml = total > 0
        ? `Showing <strong>${from}–${to}</strong> of <strong>${total}</strong> entries`
        : 'Showing <strong>0</strong> entries';

    const topInfo =
        document.getElementById('dailyPageInfoTop');

    const bottomInfo =
        document.getElementById('dailyPageInfoBottom');

    if (topInfo) {
        topInfo.innerHTML = infoHtml;
    }

    if (bottomInfo) {
        bottomInfo.innerHTML = infoHtml;
    }

    const paginationHtml =
        buildDtrPagination(meta);

    const topPagination =
        document.getElementById('dailyPaginationTop');

    const bottomPagination =
        document.getElementById('dailyPaginationBottom');

    if (topPagination) {
        topPagination.innerHTML = paginationHtml;
    }

    if (bottomPagination) {
        bottomPagination.innerHTML = paginationHtml;
    }

    setDailyPageSizeUI(
        meta.per_page ||
        dtrState.perPage ||
        10
    );
}

  function buildDtrPagination(meta = {}) {
    if (Number(meta.last_page || 1) <= 1) return '';

    const current = Number(meta.current_page || 1);
    const last = Number(meta.last_page || 1);
    const winSize = 5;
    const half = Math.floor(winSize / 2);
    let start = Math.max(1, current - half);
    let end = Math.min(last, start + winSize - 1);

    if (end - start + 1 < winSize) start = Math.max(1, end - winSize + 1);

    let html = '<nav class="global-pagination" aria-label="Daily treatment pagination">';

    html += current <= 1
      ? '<button type="button" disabled class="global-page-disabled" aria-label="Previous page"><i class="fa-solid fa-chevron-left global-page-icon"></i></button>'
      : `<button type="button" onclick="goDailyPage(${current - 1})" class="global-page-btn" aria-label="Previous page"><i class="fa-solid fa-chevron-left global-page-icon"></i></button>`;

    if (start > 1) {
      html += '<button type="button" onclick="goDailyPage(1)" class="global-page-btn">1</button>';
      if (start > 2) html += '<span class="global-page-ellipsis" aria-hidden="true">&hellip;</span>';
    }

    for (let i = start; i <= end; i++) {
      html += i === current
        ? `<span class="global-page-current" aria-current="page">${i}</span>`
        : `<button type="button" onclick="goDailyPage(${i})" class="global-page-btn">${i}</button>`;
    }

    if (end < last) {
      if (end < last - 1) html += '<span class="global-page-ellipsis" aria-hidden="true">&hellip;</span>';
      html += `<button type="button" onclick="goDailyPage(${last})" class="global-page-btn">${last}</button>`;
    }

    html += current >= last
      ? '<button type="button" disabled class="global-page-disabled" aria-label="Next page"><i class="fa-solid fa-chevron-right global-page-icon"></i></button>'
      : `<button type="button" onclick="goDailyPage(${current + 1})" class="global-page-btn" aria-label="Next page"><i class="fa-solid fa-chevron-right global-page-icon"></i></button>`;

    html += '</nav>';
    return html;
  }

  function goDailyPage(page) {
    dtrState.page = Number(page) || 1;
    fetchDailyRecords();
  }

  window.goDailyPage = goDailyPage;

  function clearDailySearch() {
    const input = document.getElementById('searchInput');
    if (input) input.value = '';

    dtrState.search = '';
    dtrState.page = 1;
    fetchDailyRecords();
  }

  window.clearDailySearch = clearDailySearch;

  function handleDailyTreatmentSearch(value) {
    dtrState.search = String(value || '').trim();
    dtrState.page = 1;

    fetchDailyRecords();
  }

  window.handleDailyTreatmentSearch = handleDailyTreatmentSearch;

  function openDailyFilterPanel() {
    dtrDraft = { ...dtrState };
    renderDailyFilterDraft();

    if (typeof window.openFilterDrawer === 'function') {
      window.openFilterDrawer('filterModal');
    } else {
      document.getElementById('filterModal')?.classList.add('open');
      document.getElementById('filterModal')?.setAttribute('aria-hidden', 'false');
    }

    updateDailyDraftCount();
  }

  function closeDailyFilterPanel() {
    if (typeof window.closeFilterDrawer === 'function') {
      window.closeFilterDrawer('filterModal');
    } else {
      document.getElementById('filterModal')?.classList.remove('open');
      document.getElementById('filterModal')?.setAttribute('aria-hidden', 'true');
    }
  }

  window.openDailyFilterPanel = openDailyFilterPanel;
  window.closeDailyFilterPanel = closeDailyFilterPanel;

  function setDailyDraftFilter(key, value) {
    if (key === 'office_type') {
      dtrDraft.office_type = dtrDraft.office_type === value ? '' : value;
      if (dtrDraft.office_type) dtrDraft.program_code = '';
    } else if (key === 'program_code') {
      dtrDraft.program_code = dtrDraft.program_code === value ? '' : value;
      if (dtrDraft.program_code) dtrDraft.office_type = '';
    } else {
      dtrDraft[key] = dtrDraft[key] === value ? '' : value;
    }

    renderDailyFilterDraft();
    updateDailyDraftCount();
  }

  window.setDailyDraftFilter = setDailyDraftFilter;

  function syncDailyChoiceGroup(name, value) {
    document.querySelectorAll(`input[name="${name}"]`).forEach(input => {
      const active = input.value === value;

      input.checked = active;
      input.closest('.choice-chip')?.classList.toggle('active', active);
    });
  }

  function renderDailyFilterDraft() {
    syncDailyChoiceGroup('daily_sort_name', dtrDraft.sort_name);
    syncDailyChoiceGroup('daily_sort_date', dtrDraft.sort_date);
    syncDailyChoiceGroup('daily_office_type', dtrDraft.office_type);
    syncDailyChoiceGroup('daily_program_code', dtrDraft.program_code);

    renderDailyActiveChips();
  }

  function bindDailyChoiceChipFilters() {
    document.querySelectorAll('[data-daily-filter-key]').forEach(input => {
      if (input.dataset.dailyChoiceReady === 'true') return;

      input.dataset.dailyChoiceReady = 'true';

      input.addEventListener('click', event => {
        const key = input.dataset.dailyFilterKey;
        const value = input.value;

        if (dtrDraft[key] === value) {
          event.preventDefault();

          dtrDraft[key] = '';

          renderDailyFilterDraft();
          updateDailyDraftCount();
        }
      });

      input.addEventListener('change', event => {
        if (!event.target.checked) return;

        setDailyDraftFilter(input.dataset.dailyFilterKey, input.value);
      });
    });
  }

  function renderDailyActiveChips() {
    const section = document.getElementById('dailyActiveFiltersSection');
    const container = document.getElementById('dailyActiveChipsContainer');
    if (!section || !container) return;

    const chips = [];

    if (dtrDraft.sort_name) chips.push({ label: `Name: ${dtrDraft.sort_name === 'za' ? 'Z to A' : 'A to Z'}`, key: 'sort_name' });
    if (dtrDraft.sort_date) chips.push({ label: `Date: ${dtrDraft.sort_date === 'asc' ? 'Oldest First' : 'Newest First'}`, key: 'sort_date' });
    if (dtrDraft.office_type) chips.push({ label: `Office: ${dtrDraft.office_type}`, key: 'office_type' });
    if (dtrDraft.program_code) chips.push({ label: `Course: ${dtrDraft.program_code}`, key: 'program_code' });

    section.classList.toggle('hidden', chips.length === 0);

    container.innerHTML = chips.map(chip => `
      <span class="filter-chip">
        <span>${escapeDtrHtml(chip.label)}</span>

        <button type="button" class="filter-chip-remove" onclick="removeDailyDraftChip('${chip.key}')"
            aria-label="Remove ${escapeDtrHtml(chip.label)} filter">

            <i class="fa-solid fa-xmark"></i>
          </button>
        </span>
      `).join('');
    }

  function removeDailyDraftChip(key) {
    dtrDraft[key] = '';
    renderDailyFilterDraft();
    updateDailyDraftCount();
  }

  window.removeDailyDraftChip = removeDailyDraftChip;

  function clearDailyFilterPanelDraft() {
    dtrDraft.office_type = '';
    dtrDraft.program_code = '';
    dtrDraft.sort_name = '';
    dtrDraft.sort_date = '';

    renderDailyFilterDraft();
    updateDailyDraftCount();
  }

  window.clearDailyFilterPanelDraft = clearDailyFilterPanelDraft;

  function clearDailyFilters() {
    dtrState.office_type = '';
    dtrState.program_code = '';
    dtrState.sort_name = '';
    dtrState.sort_date = '';
    dtrState.page = 1;

    dtrDraft = { ...dtrState };
    renderDailyFilterDraft();
    fetchDailyRecords();
  }

  window.clearDailyFilters = clearDailyFilters;

  function applyDailyFilters() {
    dtrState.office_type = dtrDraft.office_type || '';
    dtrState.program_code = dtrDraft.program_code || '';
    dtrState.sort_name = dtrDraft.sort_name || '';
    dtrState.sort_date = dtrDraft.sort_date || '';
    dtrState.page = 1;

    fetchDailyRecords();
    closeDailyFilterPanel();
  }

  window.applyDailyFilters = applyDailyFilters;

  function updateDailyDraftCountText(total) {
    const text = document.getElementById('dailyShowResultsText');
    if (!text) return;

    const value = Number(total || 0);
    text.textContent = `Show ${value} ${value === 1 ? 'result' : 'results'}`;
  }

  function updateDailyDraftCount() {
    clearTimeout(dtrDraftCountTimer);

    dtrDraftCountTimer = setTimeout(async () => {
      if (dtrDraftCountController) dtrDraftCountController.abort();
      dtrDraftCountController = new AbortController();

      const params = buildDtrParams({ ...dtrDraft, page: 1, perPage: 1 }, { page: 1, perPage: 1 });

      try {
        const res = await fetch(`${DTR_LIST_URL}?${params.toString()}`, {
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
          },
          signal: dtrDraftCountController.signal,
        });

        if (!res.ok) throw new Error('Unable to count records');

        const json = await res.json();
        updateDailyDraftCountText(json.meta?.total || 0);
      } catch (err) {
        if (err.name !== 'AbortError') updateDailyDraftCountText(0);
      }
    }, 180);
  }

  function setDailyPageSizeUI(value) {
    const normalized = String(value || 10);
    const hidden = document.getElementById('dtPerPageSelect');

    if (hidden) {
      hidden.value = normalized;
      window.syncGlobalPageSizeSelect?.(hidden, normalized);
    }
  }

  function selectDailyPerPage(value) {
    const selectedValue =
        Number(value) || 10;

    dtrState.perPage =
        selectedValue;

    dtrState.page = 1;

    setDailyPageSizeUI(
        selectedValue
    );

    fetchDailyRecords();
}

  window.selectDailyPerPage =
    selectDailyPerPage;

  function forceCloseDailyModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;

    modal.classList.remove('open', 'closing');
    modal.setAttribute('aria-hidden', 'true');

    if (!document.querySelector('.ui-modal.open, .modal-overlay.open, dialog[open]')) {
      document.documentElement.classList.remove('modal-lock');
      document.body.classList.remove('modal-lock');
    }
  }

  function resetDailyReportForm() {
    const form = document.getElementById('reportForm');
    if (form) form.reset();

    syncDailyReportCustomSelects(document.getElementById('createReportModal'));

    const counter = document.getElementById('reportNameCounter');
    if (counter) {
      counter.textContent = '0 / 100';
      counter.classList.remove('text-red-500');
      counter.classList.add('text-gray-400');
    }

    ['reportNameErr', 'reportTypeErr', 'dateFromErr', 'dateFutureErr', 'dateRangeErr', 'reportQtyErr', 'formErrorBanner'].forEach(id => {
      const el = document.getElementById(id);
      if (!el) return;

      el.classList.add('hidden');
      el.classList.remove('flex');
    });

    ['reportName', 'reportType', 'dateFrom', 'dateTo', 'reportQty'].forEach(id => {
      const el = document.getElementById(id);
      if (!el) return;

      el.classList.remove('border-red-400');
      el.classList.add('border-gray-300');
    });
  }

  function ensureDailyReportFlatpickrs() {
    if (!window.flatpickr) return;

    const today = new Date();
    const todayStr = today.toISOString().split('T')[0];

    ['dateFrom', 'dateTo'].forEach(id => {
      const input = document.getElementById(id);
      if (!input) return;

      input.setAttribute('max', todayStr);

      if (input._flatpickr) {
        input._flatpickr.set('maxDate', 'today');
        return;
      }

      window.flatpickr(input, {
        dateFormat: 'Y-m-d',
        maxDate: 'today',
        allowInput: false,
        clickOpens: true,
        disableMobile: true,
        appendTo: document.body,
        positionElement: input,
        onOpen: (_dates, _str, instance) => {
          instance.calendarContainer.style.zIndex = '1000000';
        },
      });
    });
  }

  function openDailyCreateReportModal() {
    const modal = document.getElementById('createReportModal');
    if (!modal) return;

    modal.classList.remove('closing');
    modal.classList.add('open');
    modal.setAttribute('aria-hidden', 'false');

    document.documentElement.classList.add('modal-lock');
    document.body.classList.add('modal-lock');

    initDailyReportCustomSelects(modal);
    syncDailyReportCustomSelects(modal);
    ensureDailyReportFlatpickrs();
    initDailyReportQtyButtons();

    document.dispatchEvent(new CustomEvent('voice:refresh', { detail: { root: modal } }));
  }

  function closeDailyCreateReportModal() {
    if (typeof window.closeModal === 'function') {
      window.closeModal('createReportModal');
    } else {
      forceCloseDailyModal('createReportModal');
    }

    resetDailyReportForm();
  }

  function closeDownloadModal() {
    if (typeof window.closeModal === 'function') {
      window.closeModal('downloadCompleteModal');
    } else {
      forceCloseDailyModal('downloadCompleteModal');
    }
  }

  window.openDailyCreateReportModal = openDailyCreateReportModal;
  window.closeDailyCreateReportModal = closeDailyCreateReportModal;
  window.closeDownloadModal = closeDownloadModal;

  function closeDailyReportSelects(except = null) {
    document.querySelectorAll('.report-custom-select.open').forEach(select => {
      if (select === except) return;

      select.classList.remove('open');
      select.querySelector('[data-report-select-trigger]')?.setAttribute('aria-expanded', 'false');
    });
  }

  function syncDailyReportSelectUI(nativeSelect) {
    if (!nativeSelect) return;

    const wrap = nativeSelect.closest('[data-report-select]');
    if (!wrap) return;

    const label = wrap.querySelector('[data-report-select-label]');
    const trigger = wrap.querySelector('[data-report-select-trigger]');
    const selectedOption = nativeSelect.selectedOptions?.[0];
    const placeholder = trigger?.dataset.placeholder || 'Select option';
    const selectedText = nativeSelect.value ? selectedOption?.textContent?.trim() : placeholder;

    if (label) label.textContent = selectedText || placeholder;

    wrap.querySelectorAll('[data-report-select-option]').forEach(option => {
      const isActive = option.dataset.value === nativeSelect.value;
      option.classList.toggle('is-active', isActive);
      option.setAttribute('aria-selected', isActive ? 'true' : 'false');
    });
  }

  function syncDailyReportCustomSelects(root = document) {
    const scope = root && typeof root.querySelectorAll === 'function' ? root : document;
    scope.querySelectorAll('[data-report-select-native]').forEach(syncDailyReportSelectUI);
  }

  function initDailyReportCustomSelects(root = document) {
    const scope = root && typeof root.querySelectorAll === 'function' ? root : document;

    scope.querySelectorAll('[data-report-select]').forEach(wrap => {
      if (wrap.dataset.reportSelectInitialized === 'true') {
        syncDailyReportSelectUI(wrap.querySelector('[data-report-select-native]'));
        return;
      }

      wrap.dataset.reportSelectInitialized = 'true';

      const nativeSelect = wrap.querySelector('[data-report-select-native]');
      const trigger = wrap.querySelector('[data-report-select-trigger]');

      trigger?.addEventListener('click', event => {
        event.preventDefault();
        event.stopPropagation();

        const willOpen = !wrap.classList.contains('open');
        closeDailyReportSelects(wrap);
        wrap.classList.toggle('open', willOpen);
        trigger.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
      });

      wrap.querySelectorAll('[data-report-select-option]').forEach(option => {
        option.addEventListener('click', event => {
          event.preventDefault();
          event.stopPropagation();

          if (!nativeSelect) return;

          nativeSelect.value = option.dataset.value || '';
          syncDailyReportSelectUI(nativeSelect);
          nativeSelect.dispatchEvent(new Event('change', { bubbles: true }));
          wrap.classList.remove('open');
          trigger?.setAttribute('aria-expanded', 'false');
        });
      });

      nativeSelect?.addEventListener('change', () => syncDailyReportSelectUI(nativeSelect));
      syncDailyReportSelectUI(nativeSelect);
    });
  }

  function initDailyReportQtyButtons() {
    const input = document.getElementById('reportQty');
    const minus = document.querySelector('[data-qty-minus]');
    const plus = document.querySelector('[data-qty-plus]');
    if (!input || input.dataset.qtyReady === 'true') return;

    input.dataset.qtyReady = 'true';

    function normalize(value) {
      const parsed = parseInt(value, 10);
      if (Number.isNaN(parsed)) return '';
      return Math.min(100, Math.max(1, parsed));
    }

    function updateButtons() {
      const value = parseInt(input.value, 10);
      minus?.classList.toggle('is-disabled', Number.isNaN(value) || value <= 1);
      plus?.classList.toggle('is-disabled', !Number.isNaN(value) && value >= 100);
    }

    minus?.addEventListener('click', () => {
      const value = normalize(input.value || 1) || 1;
      input.value = Math.max(1, value - 1);
      input.dispatchEvent(new Event('input', { bubbles: true }));
      updateButtons();
    });

    plus?.addEventListener('click', () => {
      const value = normalize(input.value || 0) || 0;
      input.value = Math.min(100, value + 1);
      input.dispatchEvent(new Event('input', { bubbles: true }));
      updateButtons();
    });

    input.addEventListener('input', updateButtons);
    updateButtons();
  }

  function setDailyModalError(inputId, errId, show) {
    const input = document.getElementById(inputId);
    const err = document.getElementById(errId);
    if (!input || !err) return;

    const selectWrap = input.closest('[data-report-select]');
    if (selectWrap) selectWrap.classList.toggle('is-invalid', show);

    err.classList.toggle('hidden', !show);
    err.classList.toggle('flex', show);
    input.classList.toggle('border-red-400', show);
    input.classList.toggle('border-gray-300', !show);
  }

  function formatDailyElapsedTime(totalSeconds) {
    const hours = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
    const minutes = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
    const seconds = String(totalSeconds % 60).padStart(2, '0');
    return `${hours}:${minutes}:${seconds}`;
  }

  function getDailyTimerElements() {
    return {
      display: document.getElementById('dailyTimerDisplay'),
      status: document.getElementById('dailyTimerStatus'),
      timeIn: document.getElementById('recordTimeIn'),
      timeOut: document.getElementById('recordTimeOut'),
      timeInDisplay: document.getElementById('recordTimeInDisplay'),
      timeOutDisplay: document.getElementById('recordTimeOutDisplay'),
      minutes: document.getElementById('recordMinutesProcessed'),
      startBtn: document.getElementById('dailyTimerStartBtn'),
      stopBtn: document.getElementById('dailyTimerStopBtn'),
    };
  }

  function syncDailyTimerButtons(isRunning) {
    const { startBtn, stopBtn } = getDailyTimerElements();
    startBtn?.classList.toggle('opacity-60', isRunning);
    startBtn?.classList.toggle('cursor-not-allowed', isRunning);
    stopBtn?.classList.toggle('opacity-60', !isRunning && !dailyTimerStartedAt);
    stopBtn?.classList.toggle('cursor-not-allowed', !isRunning && !dailyTimerStartedAt);

    if (startBtn) startBtn.disabled = isRunning;
    if (stopBtn) stopBtn.disabled = !isRunning;
  }

  function updateDailyTimerDisplay() {
    const elements = getDailyTimerElements();
    if (!elements.display || !elements.minutes) return;

    if (!dailyTimerStartedAt) {
      elements.display.textContent = '00:00:00';
      elements.minutes.value = 0;
      elements.status.textContent = 'Timer has not started yet.';
      syncDailyTimerButtons(false);
      return;
    }

    const endDate = dailyTimerStoppedAt || new Date();
    const elapsedSeconds = Math.max(0, Math.floor((endDate.getTime() - dailyTimerStartedAt.getTime()) / 1000));
    elements.display.textContent = formatDailyElapsedTime(elapsedSeconds);
    elements.minutes.value = Math.floor(elapsedSeconds / 60);
    elements.status.textContent = dailyTimerStoppedAt
      ? 'Procedure timer stopped and ready to save.'
      : 'Procedure is running live.';
    syncDailyTimerButtons(!dailyTimerStoppedAt);
  }

  function startDailyProcedureTimer() {
    if (dailyTimerInterval) {
      clearInterval(dailyTimerInterval);
      dailyTimerInterval = null;
    }

    dailyTimerStartedAt = new Date();
    dailyTimerStoppedAt = null;

    const elements = getDailyTimerElements();
    if (elements.timeIn) elements.timeIn.value = toLocalDateInputValue(dailyTimerStartedAt);
    if (elements.timeOut) elements.timeOut.value = '';
    if (elements.timeInDisplay) elements.timeInDisplay.value = formatDtrDateTimeDisplay(dailyTimerStartedAt);
    if (elements.timeOutDisplay) elements.timeOutDisplay.value = '';

    updateDailyTimerDisplay();
    dailyTimerInterval = setInterval(updateDailyTimerDisplay, 1000);
  }

  function stopDailyProcedureTimer() {
    if (!dailyTimerStartedAt) return;

    dailyTimerStoppedAt = new Date();

    const elements = getDailyTimerElements();
    if (elements.timeOut) elements.timeOut.value = toLocalDateInputValue(dailyTimerStoppedAt);
    if (elements.timeOutDisplay) elements.timeOutDisplay.value = formatDtrDateTimeDisplay(dailyTimerStoppedAt);

    if (dailyTimerInterval) {
      clearInterval(dailyTimerInterval);
      dailyTimerInterval = null;
    }

    updateDailyTimerDisplay();
  }

  function resetDailyRecordForm() {
    const form = document.getElementById('dailyRecordForm');
    const today = new Date();
    if (form) form.reset();

    dailyTimerStartedAt = null;
    dailyTimerStoppedAt = null;

    if (dailyTimerInterval) {
      clearInterval(dailyTimerInterval);
      dailyTimerInterval = null;
    }

    const elements = getDailyTimerElements();
    if (elements.timeIn) elements.timeIn.value = '';
    if (elements.timeOut) elements.timeOut.value = '';
    if (elements.timeInDisplay) elements.timeInDisplay.value = '';
    if (elements.timeOutDisplay) elements.timeOutDisplay.value = '';

    const dateInput = document.getElementById('recordTreatmentDate');
    if (dateInput) dateInput.value = today.toISOString().split('T')[0];

    document.getElementById('dailyRecordErrorBanner')?.classList.add('hidden');
    document.getElementById('dailyRecordErrorBanner')?.classList.remove('flex');

    ['recordTreatmentDate', 'recordPatientName', 'recordTreatmentDone'].forEach(id => {
      const input = document.getElementById(id);
      input?.classList.remove('border-red-400');
      input?.classList.add('border-gray-300');
    });

    updateDailyTimerDisplay();
  }

  function openDailyRecordModal() {
    const modal = document.getElementById('dailyRecordModal');
    if (!modal) return;

    resetDailyRecordForm();
    modal.classList.remove('closing');
    modal.classList.add('open');
    modal.setAttribute('aria-hidden', 'false');
    document.documentElement.classList.add('modal-lock');
    document.body.classList.add('modal-lock');
  }

  function closeDailyRecordModal() {
    if (typeof window.closeModal === 'function') {
      window.closeModal('dailyRecordModal');
    } else {
      forceCloseDailyModal('dailyRecordModal');
    }

    resetDailyRecordForm();
  }

  window.openDailyRecordModal = openDailyRecordModal;
  window.closeDailyRecordModal = closeDailyRecordModal;

  async function saveDailyRecord() {
    const saveBtn = document.getElementById('saveDailyRecordBtn');
    const banner = document.getElementById('dailyRecordErrorBanner');
    const treatmentDate = document.getElementById('recordTreatmentDate');
    const patientName = document.getElementById('recordPatientName');
    const treatmentDone = document.getElementById('recordTreatmentDone');

    const requiredFields = [
      treatmentDate,
      patientName,
      treatmentDone,
    ];

    let valid = true;

    requiredFields.forEach(field => {
      const hasValue = !!field?.value?.trim();
      field?.classList.toggle('border-red-400', !hasValue);
      field?.classList.toggle('border-gray-300', hasValue);
      if (!hasValue) valid = false;
    });

    if (!valid) {
      banner.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i><span>Please complete the treatment date, patient name, and treatment details.</span>';
      banner.classList.remove('hidden');
      banner.classList.add('flex');
      return;
    }

    banner.classList.add('hidden');
    banner.classList.remove('flex');

    const form = document.getElementById('dailyRecordForm');
    const formData = new FormData(form);
    formData.append('_token', CSRF_TOKEN);

    const originalHtml = saveBtn?.innerHTML || '';
    if (saveBtn) {
      saveBtn.disabled = true;
      saveBtn.classList.add('opacity-70', 'cursor-not-allowed');
      saveBtn.innerHTML = '<span class="btn-confirm-icon"><i class="fa-solid fa-spinner fa-spin"></i></span><span>Saving...</span>';
    }

    try {
      const response = await fetch(DTR_STORE_URL, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': CSRF_TOKEN,
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
        },
        body: formData,
        credentials: 'same-origin',
      });

      const payload = await response.json();

      if (!response.ok) {
        let message = payload.message || 'Unable to save the daily treatment record.';
        if (payload.errors) {
          const firstError = Object.values(payload.errors)[0];
          if (Array.isArray(firstError) && firstError.length > 0) {
            message = firstError[0];
          }
        }
        throw new Error(message);
      }

      closeDailyRecordModal();
      dtrState.page = 1;
      await fetchDailyRecords();
    } catch (error) {
      banner.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i><span>${escapeDtrHtml(error.message || 'Unable to save the daily treatment record.')}</span>`;
      banner.classList.remove('hidden');
      banner.classList.add('flex');
    } finally {
      if (saveBtn) {
        saveBtn.disabled = false;
        saveBtn.classList.remove('opacity-70', 'cursor-not-allowed');
        saveBtn.innerHTML = originalHtml;
      }
    }
  }

  async function downloadDailyReport() {
    const btn = document.getElementById('downloadReportBtn');
    const name = document.getElementById('reportName')?.value.trim() || '';
    const templateId = document.getElementById('reportType')?.value || '';
    const from = document.getElementById('dateFrom')?.value || '';
    const to = document.getElementById('dateTo')?.value || '';
    const qty = parseInt(document.getElementById('reportQty')?.value, 10);
    const banner = document.getElementById('formErrorBanner');
    const todayStr = new Date().toISOString().split('T')[0];

    let valid = true;

    function showBanner(message = 'Please complete all required fields before downloading.') {
      if (!banner) return;

      banner.innerHTML = `<i class="fa-solid fa-triangle-exclamation text-red-500 flex-shrink-0"></i><span>${escapeDtrHtml(message)}</span>`;
      banner.classList.remove('hidden');
      banner.classList.add('flex');
    }

    function hideBanner() {
      banner?.classList.add('hidden');
      banner?.classList.remove('flex');
    }

    setDailyModalError('reportName', 'reportNameErr', !name);
    if (!name) valid = false;

    setDailyModalError('reportType', 'reportTypeErr', !templateId);
    if (!templateId) valid = false;

    ['dateFromErr', 'dateFutureErr', 'dateRangeErr'].forEach(id => {
      const el = document.getElementById(id);
      el?.classList.add('hidden');
      el?.classList.remove('flex');
    });

    ['dateFrom', 'dateTo'].forEach(id => {
      const el = document.getElementById(id);
      el?.classList.remove('border-red-400');
      el?.classList.add('border-gray-300');
    });

    if (!from) {
      document.getElementById('dateFromErr')?.classList.remove('hidden');
      document.getElementById('dateFromErr')?.classList.add('flex');
      document.getElementById('dateFrom')?.classList.add('border-red-400');
      document.getElementById('dateFrom')?.classList.remove('border-gray-300');
      valid = false;
    } else if (from > todayStr || (to && to > todayStr)) {
      document.getElementById('dateFutureErr')?.classList.remove('hidden');
      document.getElementById('dateFutureErr')?.classList.add('flex');
      valid = false;
    } else if (to && new Date(to) < new Date(from)) {
      document.getElementById('dateRangeErr')?.classList.remove('hidden');
      document.getElementById('dateRangeErr')?.classList.add('flex');
      document.getElementById('dateTo')?.classList.add('border-red-400');
      document.getElementById('dateTo')?.classList.remove('border-gray-300');
      valid = false;
    }

    const qtyInvalid = Number.isNaN(qty) || qty < 1 || qty > 100;
    document.getElementById('reportQtyErrMsg').textContent = Number.isNaN(qty) || qty < 1
      ? 'Quantity must be between 1 and 100.'
      : 'Quantity cannot exceed 100.';
    setDailyModalError('reportQty', 'reportQtyErr', qtyInvalid);
    if (qtyInvalid) valid = false;

    if (!valid) {
      showBanner();
      btn?.classList.add('animate-bounce');
      setTimeout(() => btn?.classList.remove('animate-bounce'), 600);
      return;
    }

    hideBanner();

    const originalBtnHtml = btn?.innerHTML || '';

    if (btn) {
      btn.disabled = true;
      btn.classList.add('opacity-70', 'cursor-not-allowed');
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Generating...';
    }

    try {
      const formData = new FormData();
      formData.append('_token', CSRF_TOKEN);
      formData.append('report_name', name);
      formData.append('document_template_id', templateId);
      formData.append('date_from', from);
      formData.append('quantity', String(qty));

      if (to) formData.append('date_to', to);

      const response = await fetch(DTR_DOWNLOAD_URL, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': CSRF_TOKEN,
          'X-XSRF-TOKEN': CSRF_TOKEN,
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/pdf, application/json',
        },
        body: formData,
        credentials: 'same-origin',
      });

      if (!response.ok) {
        let message = `Unable to generate the report. Server returned ${response.status}.`;
        const contentType = response.headers.get('content-type') || '';

        if (contentType.includes('application/json')) {
          const errorData = await response.json();
          message = errorData.message || message;

          if (errorData.errors) {
            const firstError = Object.values(errorData.errors)[0];
            if (Array.isArray(firstError) && firstError.length > 0) message = firstError[0];
          }
        }

        throw new Error(message);
      }

      const blob = await response.blob();
      const downloadUrl = window.URL.createObjectURL(blob);
      let fileName = `${name.replace(/[^A-Za-z0-9_-]/g, '_')}.pdf`;
      const disposition = response.headers.get('Content-Disposition') || response.headers.get('content-disposition') || '';
      const fileNameMatch = disposition.match(/filename="?([^"]+)"?/i);

      if (fileNameMatch?.[1]) fileName = fileNameMatch[1];

      const link = document.createElement('a');
      link.href = downloadUrl;
      link.download = fileName;
      document.body.appendChild(link);
      link.click();
      link.remove();
      window.URL.revokeObjectURL(downloadUrl);

      closeDailyCreateReportModal();

      if (typeof window.openModal === 'function') {
        window.openModal('downloadCompleteModal');
      } else {
        document.getElementById('downloadCompleteModal')?.classList.add('open');
      }
    } catch (err) {
      showBanner(err.message || 'Unable to generate the report. Please try again.');
    } finally {
      if (btn) {
        btn.disabled = false;
        btn.classList.remove('opacity-70', 'cursor-not-allowed');
        btn.innerHTML = originalBtnHtml;
      }
    }
  }

  document.addEventListener('click', event => {
    if (!event.target.closest('[data-report-select]')) closeDailyReportSelects();
  });

  document.addEventListener('DOMContentLoaded', () => {
    initDailyReportCustomSelects(document);
    initDailyReportQtyButtons();
    resetDailyRecordForm();

    const monthPicker = document.getElementById('monthPicker');
    const now = new Date();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const year = now.getFullYear();
    const currentMonthValue = `${year}-${month}`;

    if (window.setMonthOnlyPickerValue) {
      window.setMonthOnlyPickerValue(monthPicker, currentMonthValue, false);
    } else if (monthPicker) {
      monthPicker.value = currentMonthValue;
    }

    dtrState.month = currentMonthValue;

    monthPicker?.addEventListener('change', event => {
      dtrState.month = event.target.value || '';
      dtrState.page = 1;
      fetchDailyRecords();
    });

    document.getElementById('reportName')?.addEventListener('input', event => {
      const counter = document.getElementById('reportNameCounter');
      if (!counter) return;

      const length = event.target.value.length;
      counter.textContent = `${length} / 100`;
      counter.classList.toggle('text-red-500', length >= 100);
      counter.classList.toggle('text-gray-400', length < 100);
    });

    document.getElementById('recordTreatmentDate')?.setAttribute('max', now.toISOString().split('T')[0]);
    document.getElementById('dailyTimerStartBtn')?.addEventListener('click', startDailyProcedureTimer);
    document.getElementById('dailyTimerStopBtn')?.addEventListener('click', stopDailyProcedureTimer);
    document.getElementById('saveDailyRecordBtn')?.addEventListener('click', saveDailyRecord);
    document.getElementById('downloadReportBtn')?.addEventListener('click', downloadDailyReport);

    bindDailyChoiceChipFilters();
    fetchDailyRecords();
  });
</script>
@endsection
