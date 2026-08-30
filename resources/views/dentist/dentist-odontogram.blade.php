@extends('layouts.app')

@section('layout-role', $layoutRole ?? 'dentist')

@section('hide-sidebar')
@endsection

@section('hide-footer')
@endsection

@section('title', 'Patient Odontogram')

@section('styles')
    @vite('resources/css/pages/dentist/odontogram.css')
@endsection

@section('content')

@php
use Carbon\Carbon;

$existingAppointmentMode = (bool) ($existingAppointmentMode ?? false);
$savedVisitEditMode = (bool) ($savedVisitEditMode ?? false);
$patientName = $patient->name ?? 'Unknown Patient';
$patientAvatarUrl = !empty($patient?->profile_image)
? asset('storage/' . $patient->profile_image)
: (!empty($patient?->user?->profile_image)
? asset('storage/' . $patient->user->profile_image)
: '');

$appointmentDateValue = $existingAppointmentMode
? data_get($existingAppointmentDraft ?? [], 'appointment_date')
: $appointment?->appointment_date;

$appointmentTimeValue = $existingAppointmentMode
? data_get($existingAppointmentDraft ?? [], 'appointment_time')
: $appointment?->appointment_time;

$formattedAppointmentDate = filled($appointmentDateValue)
? Carbon::parse($appointmentDateValue)->format('M d, Y')
: '—';

$formattedAppointmentTime = filled($appointmentTimeValue)
? Carbon::parse($appointmentTimeValue)->format('h:i A')
: '—';

$currentServiceType = $existingAppointmentMode
? data_get($existingAppointmentDraft ?? [], 'service_type', '')
: ($appointment?->service_type ?? '');

$isOralProphylaxis =
strcasecmp(
trim((string) $currentServiceType),
'Oral Prophylaxis'
) === 0;

$entrySource = request()->query('from');
$isWalkInMode = $entrySource === 'walk-in';

$pageEyebrow = $savedVisitEditMode ? 'Saved Dental Record Editor' : 'Dental Procedure Workspace';
$pageTitle = $savedVisitEditMode ? 'Edit Saved Odontogram' : 'Patient Odontogram';
$pageSubtitle = '2D / 3D Treatment &amp; Condition Mapping';

$entryContextLabel = $existingAppointmentMode
? 'Existing Appointment'
: ($savedVisitEditMode ? 'Saved Visit Record' : ($isWalkInMode ? 'Walk-in Visit' : null));

$entryContextMessage = $existingAppointmentMode
? 'This odontogram is for an existing appointment. Saving it will store the visit as completed.'
 : ($savedVisitEditMode
? 'You are editing a previously saved visit. Any changes here will update the saved 2D and 3D odontogram plus the clinical notes.'
: ($isWalkInMode
? 'This odontogram is being created for a walk-in visit.'
: null));

$existingProcedureDuration = $existingAppointmentMode
? data_get($existingAppointmentDraft ?? [], 'procedure_duration_hms', '00:00:00')
: ($savedVisitEditMode
    ? sprintf(
        '%02d:%02d:%02d',
        floor((int) data_get($procedure, 'procedure_duration_seconds', 0) / 3600),
        floor(((int) data_get($procedure, 'procedure_duration_seconds', 0) % 3600) / 60),
        (int) data_get($procedure, 'procedure_duration_seconds', 0) % 60
    )
    : '00:00:00');
@endphp

<main id="mainContent" class="odontogram-page">

    <div id="odontogramDockLayout" class="odontogram-dock-layout">

        <section class="odontogram-dock-main">
            <div class="page-enter">

                <div class="odontogram-hero">
                    <div class="odontogram-hero-main">

                        @if ($entryContextLabel)
                        <div class="card" style="position: relative; margin-bottom: 0.95rem; overflow: hidden; border: 1px solid rgba(120, 22, 22, 0.1); border-radius: 1.35rem; background: linear-gradient(135deg, rgba(255, 252, 251, 0.98), rgba(255, 255, 255, 1)); box-shadow: 0 12px 26px rgba(95, 25, 25, 0.08);">
                            <span style="position: absolute; inset: 0 auto 0 0; width: 0.35rem; background: linear-gradient(180deg, #8b0000 0%, #b4232c 100%);"></span>

                            <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem 1.35rem 1rem 1.5rem; font-family: inherit;">
                                <span style="width: 5rem; height: 5rem; border-radius: 1.1rem; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; background: linear-gradient(145deg, rgba(139, 0, 0, 0.06), rgba(139, 0, 0, 0.025)); box-shadow: inset 0 1px 0 rgba(255,255,255,0.85), 0 8px 16px rgba(139, 0, 0, 0.04); color: #9e1c29;">
                                    <i class="fa-solid fa-shield-halved" style="font-size: 2rem;"></i>
                                </span>

                                <div style="display: flex; flex-direction: column; justify-content: center; gap: 0.35rem; min-width: 0; flex: 1; font-family: inherit;">
                                    <div style="display: flex; align-items: center; gap: 0.65rem; flex-wrap: wrap;">
                                        <h2 style="margin: 0; font: inherit; font-size: clamp(1.2rem, 1.8vw, 1.9rem); font-weight: 800; line-height: 1.08; letter-spacing: -0.03em; color: #1f2937;">
                                            {{ $entryContextLabel }}
                                        </h2>

                                        <span style="display: inline-flex; align-items: center; justify-content: center; padding: 0.45rem 0.85rem; border-radius: 0.75rem; background: linear-gradient(135deg, rgba(139, 0, 0, 0.06), rgba(139, 0, 0, 0.1)); color: #a12633; font: inherit; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.14em; text-transform: uppercase; white-space: nowrap;">
                                            Saved Record
                                        </span>
                                    </div>

                                    <p style="margin: 0; max-width: none; color: #5f636d; font: inherit; font-size: clamp(0.88rem, 0.92vw, 1rem); line-height: 1.4; font-weight: 400; white-space: nowrap;">
                                        {{ $entryContextMessage }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="card hero-title-card">

                            <div class="hero-title-icon">
                                <i class="fa-solid fa-tooth"></i>
                            </div>

                            <div class="odontogram-hero-copy">
                                <p class="hero-eyebrow">{{ $pageEyebrow }}</p>

                                <h1 class="hero-title">
                                    {{ $pageTitle }}
                                </h1>

                                <p class="hero-subtitle">
                                    {!! $pageSubtitle !!}
                                </p>

                            </div>

                            <button type="button" id="cancelProcedureBtn"
                                class="ui-btn {{ $savedVisitEditMode ? 'ui-btn-primary' : 'ui-btn-danger' }}">

                                <i class="fa-solid fa-xmark"></i>

                                <span>
                                    {{ $existingAppointmentMode
                                    ? 'Cancel Entry'
                                    : ($savedVisitEditMode ? 'Cancel Edit' : 'Cancel Procedure') }}
                                </span>
                            </button>

                        </div>

                        <div class="card odontogram-patient-card">
                            <div class="odontogram-patient-main">
                                <span class="patient-avatar patient-avatar-lg" data-patient-avatar
                                    data-patient-name="{{ $patientName }}" data-patient-url="{{ $patientAvatarUrl }}"
                                    aria-label="{{ $patientName }}">
                                </span>

                                <div class="odontogram-patient-copy">
                                    <span class="odontogram-patient-eyebrow">
                                        Patient
                                    </span>

                                    <h2 class="odontogram-patient-name" data-patient-name>
                                        {{ $patientName }}
                                    </h2>

                                    <span class="odontogram-patient-service">
                                        <i class="fa-solid fa-tooth"></i>
                                        {{ $currentServiceType ?: 'No service type' }}
                                    </span>
                                </div>
                            </div>

                            <div class="odontogram-appointment-meta">
                                <div class="odontogram-appointment-meta-item">
                                    <span class="odontogram-appointment-meta-icon">
                                        <i class="fa-regular fa-calendar"></i>
                                    </span>

                                    <div>
                                        <span class="odontogram-appointment-meta-label">
                                            Appointment Date
                                        </span>

                                        <strong class="odontogram-appointment-meta-value">
                                            {{ $formattedAppointmentDate }}
                                        </strong>
                                    </div>
                                </div>

                                <div class="odontogram-appointment-meta-item">
                                    <span class="odontogram-appointment-meta-icon">
                                        <i class="fa-regular fa-clock"></i>
                                    </span>

                                    <div>
                                        <span class="odontogram-appointment-meta-label">
                                            Appointment Time
                                        </span>

                                        <strong class="odontogram-appointment-meta-value">
                                            {{ $formattedAppointmentTime }}
                                        </strong>
                                    </div>
                                </div>

                                <div class="odontogram-appointment-meta-item">
                                    <span class="odontogram-appointment-meta-icon">
                                        <i class="fa-solid fa-stopwatch"></i>
                                    </span>

                                    <div>
                                        <span class="odontogram-appointment-meta-label">
                                            {{ $existingAppointmentMode ? 'Procedure Duration' : 'Session Timer' }}
                                        </span>

                                        <strong id="procedureTimer" class="odontogram-appointment-meta-value">
                                            {{ $existingAppointmentMode ? $existingProcedureDuration : '00:00:00' }}
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card odontogram-toolbar" id="odontogramToolbar">
                        <div class="toolbar-group toolbar-group-tools">
                            <span class="toolbar-label">Selection Tools</span>
                            <div class="toolbar-actions">
                                <button type="button" id="clearSelectionBtn" class="ui-icon-btn neutral"
                                    data-tooltip="Clear Selection" data-tooltip-tone="neutral"
                                    aria-label="Clear Selection" disabled>
                                    <i class="fa-solid fa-arrow-pointer"></i>
                                </button>

                                <button type="button" id="undoBtn" class="ui-icon-btn neutral" data-tooltip="Undo"
                                    data-tooltip-tone="neutral" aria-label="Undo" disabled>
                                    <i class="fa-solid fa-undo"></i>
                                </button>

                                <button type="button" id="redoBtn" class="ui-icon-btn neutral" data-tooltip="Redo"
                                    data-tooltip-tone="neutral" aria-label="Redo" disabled>
                                    <i class="fa-solid fa-rotate-right"></i>
                                </button>
                            </div>
                        </div>

                        <div class="toolbar-group toolbar-group-view">
                            <span class="toolbar-label">View Mode</span>
                            <div class="toolbar-actions">
                                <button type="button" id="view2dBtn" class="ui-icon-btn neutral active"
                                    data-tooltip="2D View" data-tooltip-tone="neutral" aria-label="2D View">
                                    <i class="fa-regular fa-image"></i>
                                </button>

                                <button type="button" id="view3dBtn" class="ui-icon-btn neutral" data-tooltip="3D View"
                                    data-tooltip-tone="neutral" aria-label="3D View">
                                    <i class="fa-solid fa-cube"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="odontogramToolbarSentinel" class="odontogram-toolbar-sentinel" aria-hidden="true">
                    </div>
                </div>

                <div class="odontogram-workspace-grid">
                    <div class="card odontogram-left-panel">

                        <div class="card-body left-view-shell">
                            <div class="odontogram-guide-row">
                                <div class="global-info-group">
                                    <span class="global-info-icon status-all">
                                        <i class="fa-solid fa-tooth"></i>
                                    </span>

                                    <div class="global-info-copy">
                                        <span class="global-info-label">
                                            Tooth Selection
                                        </span>

                                        <span id="viewInstructionText" class="global-info-subvalue">
                                            Select a surface to begin treatment
                                        </span>
                                    </div>
                                </div>

                                <div class="global-info-pill">
                                    <i class="fa-solid fa-tooth"></i>

                                    <span id="toothHoverLabel">
                                        Select a tooth
                                    </span>
                                </div>
                            </div>

                            <div id="odontogram2DPanel" class="mode-panel active">
                                <div class="odontogram2d-shell custom-scrollbar">
                                    <div id="odontogram2DBoard" class="odontogram-board"></div>
                                </div>
                            </div>

                            <div id="odontogram3DPanel" class="mode-panel">
                                <div id="canvas-container">
                                    <div id="loadingOverlay" class="odontogram-loading-overlay">
                                        <i class="fa-solid fa-circle-notch fa-spin"></i>
                                        <p>Generating 3D Model...</p>
                                    </div>

                                    <div class="three-mouse-guide" aria-label="3D model mouse controls">
                                        <div class="three-mouse-guide-item">
                                            <span class="mouse-button-key">L</span>
                                            <span><strong>Left mouse:</strong> Navigate and select a tooth</span>
                                        </div>
                                        <div class="three-mouse-guide-item">
                                            <span class="mouse-button-key">R</span>
                                            <span><strong>Right mouse:</strong> Move the model</span>
                                        </div>
                                        <div class="three-mouse-guide-item">
                                            <span class="mouse-button-key mouse-wheel-key"><i
                                                    class="fa-solid fa-arrows-up-down"></i></span>
                                            <span><strong>Scroll:</strong> Zoom in/out</span>
                                        </div>
                                    </div>

                                    <div id="toothTooltip" class="tooth-tooltip">
                                        <div id="toothTooltipContent"></div>
                                    </div>

                                    <div id="surfacePicker3D" class="hidden odontogram-surface-picker">
                                        <div class="odontogram-surface-picker-head">
                                            <div class="odontogram-surface-picker-copy">
                                                <p class="global-form-label">
                                                    3D Surface Picker
                                                </p>
                                                <h4 id="surfacePickerToothLabel"
                                                    class="odontogram-surface-picker-title">No
                                                    tooth
                                                    selected</h4>
                                                <p id="surfacePickerHelperText" class="ui-muted-text">
                                                    Step 1: Click a tooth in the 3D model. The camera will zoom in
                                                    automatically.
                                                </p>
                                            </div>
                                            <div class="odontogram-surface-picker-actions">
                                                <span class="global-info-icon crimson">
                                                    <i class="fa-solid fa-cube"></i>
                                                </span>
                                                <button type="button" id="close3DSurfacePickerBtn"
                                                    class="ui-icon-btn neutral" title="Hide surface picker"
                                                    aria-label="Hide surface picker">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="section-block odontogram-surface-grid-shell">
                                            <div class="odontogram-surface-grid">
                                                <div></div>
                                                <button type="button" data-surface="top" class="surface-picker-btn">
                                                    Top
                                                </button>
                                                <div></div>

                                                <button type="button" data-surface="left" class="surface-picker-btn">
                                                    Left
                                                </button>
                                                <button type="button" data-surface="center"
                                                    class="surface-picker-btn surface-picker-btn-center">
                                                    Center
                                                </button>
                                                <button type="button" data-surface="right" class="surface-picker-btn">
                                                    Right
                                                </button>

                                                <div></div>
                                                <button type="button" data-surface="bottom" class="surface-picker-btn">
                                                    Bottom
                                                </button>
                                                <div></div>
                                            </div>
                                        </div>

                                        <div class="odontogram-surface-picker-footer">
                                            <p class="ui-muted-text">
                                                Choose a surface, select a treatment, then apply.
                                            </p>
                                            <button type="button" id="reset3DViewBtn"
                                                class="ui-btn ui-btn-secondary ui-btn-sm">
                                                <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                                                Full View
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="odontogram-clinical-section">
                            <div class="odontogram-clinical-header">
                                <div>
                                    <p class="right-section-eyebrow">
                                        Clinical Documentation
                                    </p>

                                    <h3 class="right-section-title">
                                        Procedure Notes
                                    </h3>
                                </div>
                            </div>

                            <div class="odontogram-clinical-grid">
                                <div class="global-form-group">
                                    <label for="oralExaminationNotes" class="global-form-label">
                                        Oral Examination
                                    </label>

                                    <textarea id="oralExaminationNotes" rows="4"
                                        class="form-input-custom global-form-textarea"
                                        placeholder="Record oral examination findings...">{{ old('oral_examination', $procedure?->oral_examination) }}</textarea>
                                </div>

                                <div class="global-form-group">
                                    <label for="diagnosisNotes" class="global-form-label">
                                        Diagnosis
                                    </label>

                                    <textarea id="diagnosisNotes" rows="4"
                                        class="form-input-custom global-form-textarea"
                                        placeholder="Record the clinical diagnosis...">{{ old('diagnosis', $procedure?->diagnosis) }}</textarea>
                                </div>

                                <div class="global-form-group odontogram-prescription-field">
                                    <label for="prescriptionsNotes" class="global-form-label">
                                        Prescription
                                        <span class="odontogram-label-optional">
                                            (Optional)
                                        </span>
                                    </label>

                                    <textarea id="prescriptionsNotes" rows="3"
                                        class="form-input-custom global-form-textarea"
                                        placeholder="Add medication or aftercare instructions...">{{ old('prescriptions', $procedure?->prescriptions) }}</textarea>
                                </div>

                                <div class="odontogram-procedure-actions">
                                    @unless ($existingAppointmentMode || $savedVisitEditMode)
                                    <button type="button" id="followUpBtn" class="ui-btn ui-btn-warning">
                                        <i class="fa-solid fa-calendar-plus"></i>
                                        <span>Set Follow-Up Appointment</span>
                                    </button>
                                    @endunless

                                    <button type="button" id="finishProcedureBtn" class="ui-btn ui-btn-primary">
                                        <i class="fa-solid fa-check"></i>

                                        <span>
                                            {{ $existingAppointmentMode
                                            ? 'Save Existing Appointment'
                                            : ($savedVisitEditMode ? 'Save Changes' : 'Finish Procedure') }}
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="odontogramData" name="odontogram_data" value="[]">
                </div>
        </section>

        <div id="legendResizeHandle" class="odontogram-legend-resizer" role="separator" aria-orientation="vertical"
            aria-label="Resize Treatment Legend panel"></div>

        <aside id="legendDrawer" class="odontogram-legend-panel">
            <div class="legend-drawer-header">
                <div class="legend-drawer-heading">
                    <span class="legend-drawer-title-icon">
                        <i class="fa-solid fa-layer-group"></i>
                    </span>
                    <div>
                        <h3 class="legend-drawer-title">Treatment Legend</h3>
                        <p class="legend-drawer-subtitle">
                            Select a treatment for the chosen surface.
                        </p>
                    </div>
                </div>

                <div class="section-block odontogram-legend-target">
                    <div class="odontogram-target-row">
                        <span class="global-form-label">
                            Target
                        </span>

                        <span id="selectedViewBadge" class="badge-pill status-all">
                            2D
                        </span>
                    </div>

                    <div id="selectedToothDisplay" class="odontogram-selected-display">
                        Select a tooth surface
                    </div>

                    <p id="selectedToothName" class="odontogram-selected-name"></p>

                    <div class="odontogram-treatment-row">
                        <span class="global-form-label">
                            Treatment
                        </span>

                        <div id="selectedToothLegendList">
                            <span class="ui-muted-text">
                                None selected
                            </span>
                        </div>
                    </div>

                    <div id="legendStatusNote" class="hidden legend-status-note odontogram-legend-status-note">
                        Select a treatment, then apply.
                    </div>

                    <div class="odontogram-target-actions">
                        <button type="button" id="applyTreatmentBtn" class="ui-btn ui-btn-primary w-full" disabled>
                            <i class="fa-solid fa-stethoscope"></i>
                            Apply
                        </button>

                        <button type="button" id="clearCurrentToothBtn" class="ui-btn ui-btn-secondary w-full" disabled>
                            <i class="fa-solid fa-eraser"></i>
                            Clear
                        </button>
                    </div>
                </div>

                <span id="selectedLegendPreview" hidden>None selected</span>
                <span id="drawerSelectedLegendPreview" hidden>None selected</span>

                <div class="odontogram-legend-search-wrap">
                    <x-search-bar id="legendSearchInput" class="search-compact" placeholder="Search treatments…"
                        clear-label="Clear treatment search" callback="filterOdontogramLegends" :debounce="150" />
                </div>

                <div class="odontogram-legend-options-head">
                    <p class="global-form-label">
                        Treatment Options
                    </p>

                    <p id="legendResultCount" class="ui-muted-text">
                        0
                    </p>
                </div>
            </div>

            <div class="legend-drawer-body custom-scrollbar">
                <div id="legendContainer" class="odontogram-legend-list"></div>
                <div id="legendEmptyState" class="empty-state-host"></div>
            </div>
        </aside>
    </div>
</main>

@unless ($existingAppointmentMode || $savedVisitEditMode)
<x-follow-up-modal :patient-name="$patientName" :patient-avatar-url="$patientAvatarUrl"
    :service-type="$currentServiceType ?: '—'" :appointment-date="$formattedAppointmentDate"
    :appointment-time="$formattedAppointmentTime"
    :store-url="route('dentist.dentist.appointments.follow-up.store', $appointment->id)" />
@endunless

<div id="resetTreatmentModal" class="ui-modal modal-theme-danger" aria-hidden="true" role="dialog" aria-modal="true"
    aria-labelledby="resetTreatmentModalTitle">
    <div class="ui-modal-card modal-md">
        <div class="modal-hd">
            <div class="modal-heading">
                <div class="modal-icon">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>

                <div class="modal-copy">
                    <h2 id="resetTreatmentModalTitle" class="modal-title">
                        Reset Tooth Treatment
                    </h2>
                    <p class="modal-subtitle">
                        Remove the treatment currently assigned to this target.
                    </p>
                </div>
            </div>

            <button type="button" id="closeResetTreatmentModalBtn" class="modal-x"
                aria-label="Close reset treatment modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="modal-bd">
            <div class="global-confirm-alert">
                <i class="fa-solid fa-eraser"></i>

                <div>
                    <strong>Reset selected treatment?</strong>
                    <span id="resetTreatmentMessage">
                        Are you sure you want to reset the treatment for this tooth?
                    </span>
                </div>
            </div>
        </div>

        <div class="modal-ft">
            <button type="button" id="cancelResetTreatmentBtn" class="ui-btn ui-btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Keep Treatment</span>
            </button>

            <button type="button" id="confirmResetTreatmentBtn" class="ui-btn ui-btn-danger">
                <i class="fa-solid fa-eraser"></i>
                <span>Reset Treatment</span>
            </button>
        </div>
    </div>
</div>

<div id="cancelProcedureModal" class="ui-modal modal-theme-danger" aria-hidden="true" role="dialog" aria-modal="true"
    aria-labelledby="cancelProcedureModalTitle">
    <div class="ui-modal-card modal-md">
        <div class="modal-hd">
            <div class="modal-heading">
                <div class="modal-icon">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>

                <div class="modal-copy">
                    <h2 id="cancelProcedureModalTitle" class="modal-title">
                        {{ $savedVisitEditMode ? 'Cancel Edit?' : 'Cancel Procedure?' }}
                    </h2>
                    <p class="modal-subtitle">
                        {{ $savedVisitEditMode
                            ? 'Unsaved changes in this saved visit editor may be lost.'
                            : 'Unsaved changes in this procedure session may be lost.' }}
                    </p>
                </div>
            </div>

            <button type="button" id="closeCancelProcedureModalBtn" class="modal-x"
                aria-label="Close cancel procedure modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="modal-bd">
            <div class="global-confirm-alert">
                <i class="fa-solid fa-triangle-exclamation"></i>

                <div>
                    <strong>{{ $savedVisitEditMode ? 'Leave this edit?' : 'Leave this procedure?' }}</strong>
                    <span>
                        {{ $savedVisitEditMode
                            ? 'Are you sure you want to cancel this edit? Any unsaved changes in this saved visit may be lost.'
                            : 'Are you sure you want to cancel this procedure? Any unsaved progress in this session may be lost.' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="modal-ft">
            <button type="button" id="dismissCancelProcedureBtn" class="ui-btn ui-btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>
                <span>{{ $savedVisitEditMode ? 'Continue Editing' : 'Continue Procedure' }}</span>
            </button>

            <button type="button" id="confirmCancelProcedureBtn"
                class="ui-btn {{ $savedVisitEditMode ? 'ui-btn-primary' : 'ui-btn-danger' }}">
                <i class="fa-solid fa-ban"></i>
                <span>{{ $savedVisitEditMode ? 'Cancel Edit' : 'Cancel Procedure' }}</span>
            </button>
        </div>
    </div>
</div>

<div id="finishProcedureModal" class="ui-modal modal-theme-success" aria-hidden="true" role="dialog" aria-modal="true"
    aria-labelledby="finishProcedureModalTitle">
    <div class="ui-modal-card modal-md">
        <div class="modal-hd">
            <div class="modal-heading">
                <div class="modal-icon">
                    <i id="finishProcedureModalIcon" class="fa-solid fa-clipboard-check"></i>
                </div>

                <div class="modal-copy">
                    <h2 id="finishProcedureModalTitle" class="modal-title">
                        Procedure Completed!
                    </h2>
                    <p id="finishProcedureModalMessage" class="modal-subtitle"></p>
                </div>
            </div>

            <button type="button" id="closeFinishProcedureModalBtn" class="modal-x" aria-label="Close procedure modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="modal-bd">
            <div class="global-confirm-alert">
                <i class="fa-solid fa-circle-check"></i>

                <div>
                    <strong id="finishProcedureModalAlertTitle">
                        Procedure status
                    </strong>
                    <span id="finishProcedureModalAlertMessage">
                        Review the message above before continuing.
                    </span>
                </div>
            </div>
        </div>

        <div id="finishProcedureConfirmActions" class="modal-ft hidden">
            <button type="button" id="dismissFinishProcedureBtn" class="ui-btn ui-btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Review</span>
            </button>

            <button type="button" id="confirmFinishProcedureBtn" class="ui-btn ui-btn-warning">
                <i class="fa-solid fa-check"></i>
                <span>Finish Procedure</span>
            </button>
        </div>

        <div id="finishProcedureResultActions" class="modal-ft">
            <button type="button" id="finishProcedureModalActionBtn" class="ui-btn ui-btn-primary">
                <i class="fa-solid fa-arrow-right"></i>
                <span>Back to Appointments</span>
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@unless ($existingAppointmentMode || $savedVisitEditMode)
@include('components.appointment-calendar-script', [
'mode' => 'booking',

'calendarContainerId' => 'followUpCalendarWrap',
'calGridId' => 'followUpCalGrid',
'calMonthLabelId' => 'followUpCalMonthLabel',
'calYearLabelId' => 'followUpCalYearLabel',

'dateInputId' => 'followup_appointment_date',
'timeInputId' => 'followup_appointment_time',

'dateBannerId' => 'followUpDateBanner',

'slotPlaceholderId' => 'followUpSlotPlaceholder',
'slotContainerId' => 'followUpSlotContainer',
'slotGridId' => 'followUpSlotGrid',

'selectedSlotDisplayId' => 'followUpSelectedSlotDisplay',
'selectedSlotTextId' => 'followUpSelectedSlotText',

'datePillId' => null,

'dateErrorId' => 'followUpDateError',
'timeErrorId' => 'followUpTimeError',

'calendarWrapSelector' => '#followUpCalendarWrap',
'slotsWrapSelector' => '#followUpTimeWrap',

'slotEndpoint' => route('dentist.appointment.slots'),

'scheduleRules' => $schedules ?? [],
'blockedDates' => $blockedDates ?? [],
'appointmentCountsPerDay' => $appointmentCountsPerDay ?? [],
'philippineHolidays' => $philippineHolidays ?? [],
'personalAppointments' => [],

'disallowToday' => true,
'allowToggleOffDate' => true,
'useDynamicScheduleRules' => true,
'renderStyle' => 'patient',
])
@endunless
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cancelProcedureBtn = document.getElementById('cancelProcedureBtn');
        const cancelProcedureModal = document.getElementById('cancelProcedureModal');
        const confirmCancelProcedureBtn = document.getElementById('confirmCancelProcedureBtn');
        const dismissCancelProcedureBtn = document.getElementById('dismissCancelProcedureBtn');
        const finishProcedureModal = document.getElementById('finishProcedureModal');
        const finishProcedureModalTitle = document.getElementById('finishProcedureModalTitle');
        const finishProcedureModalMessage = document.getElementById('finishProcedureModalMessage');
        const finishProcedureModalIcon = document.getElementById('finishProcedureModalIcon');
        const finishProcedureConfirmActions = document.getElementById('finishProcedureConfirmActions');
        const confirmFinishProcedureBtn = document.getElementById('confirmFinishProcedureBtn');
        const dismissFinishProcedureBtn = document.getElementById('dismissFinishProcedureBtn');
        const finishProcedureModalActionBtn = document.getElementById('finishProcedureModalActionBtn');
        const finishProcedureResultActions = document.getElementById('finishProcedureResultActions');
        const finishProcedureModalAlertTitle = document.getElementById('finishProcedureModalAlertTitle');
        const finishProcedureModalAlertMessage = document.getElementById('finishProcedureModalAlertMessage');
        const closeResetTreatmentModalBtn = document.getElementById('closeResetTreatmentModalBtn');
        const closeCancelProcedureModalBtn = document.getElementById('closeCancelProcedureModalBtn');
        const closeFinishProcedureModalBtn = document.getElementById('closeFinishProcedureModalBtn');
        const existingAppointmentMode = @json($existingAppointmentMode);
        const savedVisitEditMode = @json($savedVisitEditMode);
        const existingProcedureDuration = @json($existingProcedureDuration);
        const isOralProphylaxis = @json($isOralProphylaxis);
        const cancelProcedureRedirectUrl = @json($cancelProcedureRedirectUrl ?? route('dentist.dentist.patient.profile', $patient -> id ?? 1));
        let finishProcedureModalRedirectUrl = null;

        const legendResultCount = document.getElementById('legendResultCount');
        const legendEmptyState = document.getElementById('legendEmptyState');
        const drawerSelectedLegendPreview = document.getElementById('drawerSelectedLegendPreview');

        const procedureTimer = document.getElementById('procedureTimer');
        const container = document.getElementById('canvas-container');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const legendDrawer = document.getElementById('legendDrawer');

        const odontogramDockLayout = document.getElementById('odontogramDockLayout');
        const legendResizeHandle = document.getElementById('legendResizeHandle');

        const view2dBtn = document.getElementById('view2dBtn');
        const view3dBtn = document.getElementById('view3dBtn');
        const panel2d = document.getElementById('odontogram2DPanel');
        const panel3d = document.getElementById('odontogram3DPanel');
        const board2d = document.getElementById('odontogram2DBoard');
        const viewInstructionText = document.getElementById('viewInstructionText');
        const selectedViewBadge = document.getElementById('selectedViewBadge');

        const selectedToothDisplay = document.getElementById('selectedToothDisplay');
        const selectedToothName = document.getElementById('selectedToothName');
        const toothHoverLabel = document.getElementById('toothHoverLabel');
        const legendContainer = document.getElementById('legendContainer');
        const odontogramDataInput = document.getElementById('odontogramData');
        const selectedLegendPreview = document.getElementById('selectedLegendPreview');
        const selectedToothLegendList = document.getElementById('selectedToothLegendList');
        const legendStatusNote = document.getElementById('legendStatusNote');
        const applyTreatmentBtn = document.getElementById('applyTreatmentBtn');
        const clearCurrentToothBtn = document.getElementById('clearCurrentToothBtn');

        const clearSelectionBtn = document.getElementById('clearSelectionBtn');
        const undoBtn = document.getElementById('undoBtn');
        const redoBtn = document.getElementById('redoBtn');

        const toothTooltip = document.getElementById('toothTooltip');
        const toothTooltipContent = document.getElementById('toothTooltipContent');
        const surfacePicker3D = document.getElementById('surfacePicker3D');
        const surfacePickerToothLabel = document.getElementById('surfacePickerToothLabel');
        const surfacePickerHelperText = document.getElementById('surfacePickerHelperText');
        const surfacePickerButtons = Array.from(document.querySelectorAll('.surface-picker-btn'));
        const reset3DViewBtn = document.getElementById('reset3DViewBtn');
        const close3DSurfacePickerBtn = document.getElementById('close3DSurfacePickerBtn');

        const resetTreatmentModal = document.getElementById('resetTreatmentModal');
        const resetTreatmentMessage = document.getElementById('resetTreatmentMessage');
        const confirmResetTreatmentBtn = document.getElementById('confirmResetTreatmentBtn');
        const cancelResetTreatmentBtn = document.getElementById('cancelResetTreatmentBtn');

        let currentView = '2d';
        let selectedTooth = null;
        let selectedLegend = null;
        let selectedTargetType = null;
        let selectedSurfaceKey = null;
        let selectedMesh = null;
        let pendingResetPayload = null;
        let hasAppliedTreatmentThisSession = false;

        let historyStack = [];
        let redoStack = [];
        const HISTORY_LIMIT = 50;

        let odontogramThreeState = null;

        const legends = [{
            code: 'D',
            label: 'Decayed (Caries indicated for Filling)'
        },
        {
            code: 'M',
            label: 'Missing due to Caries'
        },
        {
            code: 'F',
            label: 'Filled'
        },
        {
            code: 'I',
            label: 'Caries Indicated for Extraction'
        },
        {
            code: 'RF',
            label: 'Root Fragment'
        },
        {
            code: 'MO',
            label: 'Missing due to Other Causes'
        },
        {
            code: 'IM',
            displayCode: 'Im',
            label: 'Impacted Tooth'
        },
        {
            code: 'J',
            label: 'Jacket Crown'
        },
        {
            code: 'A',
            label: 'Amalgam Filling'
        },
        {
            code: 'AB',
            label: 'Abutment'
        },
        {
            code: 'P',
            label: 'Pontic'
        },
        {
            code: 'IN',
            displayCode: 'In',
            label: 'Inlay'
        },
        {
            code: 'LC',
            label: 'Light Cure Composite'
        },
        {
            code: 'RM',
            displayCode: 'Rm',
            label: 'Removable Denture'
        },
        {
            code: 'X',
            label: 'Extraction due to Caries'
        },
        {
            code: 'XO',
            label: 'Extraction due to Other Causes'
        },
        {
            code: '✓',
            label: 'Present Teeth'
        },
        {
            code: 'CM',
            displayCode: 'Cm',
            label: 'Congenitally Missing'
        },
        {
            code: 'SP',
            displayCode: 'Sp',
            label: 'Supernumerary'
        }
        ];

        const legendColors = {
            D: '#ef4444',
            M: '#111827',
            F: '#2563eb',
            I: '#ef4444',
            RF: '#ef4444',
            MO: '#111827',
            IM: '#111827',
            J: '#2563eb',
            A: '#2563eb',
            AB: '#2563eb',
            P: '#2563eb',
            IN: '#2563eb',
            LC: '#2563eb',
            RM: '#2563eb',
            X: '#2563eb',
            XO: '#2563eb',
            '✓': '#111827',
            CM: '#111827',
            SP: '#111827'
        };

        const legendIcons = {
            D: 'fa-solid fa-bug',
            M: 'fa-solid fa-ban',
            F: 'fa-solid fa-square-check',
            I: 'fa-solid fa-syringe',
            RF: 'fa-solid fa-teeth-open',
            MO: 'fa-solid fa-circle-xmark',
            IM: 'fa-solid fa-triangle-exclamation',
            J: 'fa-solid fa-crown',
            A: 'fa-solid fa-fill-drip',
            AB: 'fa-solid fa-anchor',
            P: 'fa-solid fa-link',
            IN: 'fa-solid fa-puzzle-piece',
            LC: 'fa-solid fa-wand-magic-sparkles',
            RM: 'fa-solid fa-teeth',
            X: 'fa-solid fa-xmark',
            XO: 'fa-solid fa-skull-crossbones',
            '✓': 'fa-solid fa-check',
            CM: 'fa-solid fa-question',
            SP: 'fa-solid fa-plus'
        };

        const legendCategories = [{
            key: 'conditions',
            title: 'Conditions',
            icon: 'fa-solid fa-heart-pulse',
            items: ['D', 'M', 'F', 'I', 'RF', 'MO', 'IM']
        },
        {
            key: 'restoration-prosthetics',
            title: 'Restorations & Prosthetics',
            icon: 'fa-solid fa-screwdriver-wrench',
            items: ['J', 'A', 'AB', 'P', 'IN', 'LC', 'RM']
        },
        {
            key: 'surgery',
            title: 'Surgery',
            icon: 'fa-solid fa-user-doctor',
            items: ['X', 'XO', '✓', 'CM', 'SP']
        }];

        const rawSavedOdontogramData = @json($savedOdontogramData ?? []);
        const savedOdontogramData = Array.isArray(rawSavedOdontogramData) ?
            rawSavedOdontogramData :
            Object.values(rawSavedOdontogramData || {});

        const odontogramState = {};

        async function initThreeScene() {
            if (odontogramThreeState) {
                return;
            }

            if (!window.Odontogram3D) {
                try {
                    await window.loadOdontogramThreeModule?.();
                } catch (error) {
                    console.error(
                        'Unable to load odontogram 3D module.',
                        error
                    );

                    showProcedureToast(
                        'Unable to load the 3D odontogram.',
                        'error',
                        '3D View Unavailable'
                    );

                    return;
                }
            }

            if (!window.Odontogram3D) {
                showProcedureToast(
                    'The 3D odontogram module is unavailable.',
                    'error',
                    '3D View Unavailable'
                );

                return;
            }

            odontogramThreeState =
                window.Odontogram3D.create({
                    container,

                    data:
                        Object.values(
                            odontogramState
                        ),

                    mode:
                        'editor',

                    onToothHover:
                        (
                            toothNumber,
                            mesh,
                            event
                        ) => {

                            if (!toothNumber) {
                                toothHoverLabel
                                    .innerText =
                                    selectedTooth
                                        ? `Selected: #${selectedTooth}`
                                        : 'Select a tooth';

                                hideTooltip();

                                return;
                            }

                            toothHoverLabel
                                .innerText =
                                `Tooth #${toothNumber}`;

                            showTooltip(
                                event,
                                mesh
                            );
                        },

                    onToothClick:
                        (
                            toothNumber,
                            mesh
                        ) => {
                            if (
                                !toothNumber ||
                                !mesh
                            ) {
                                clear3DSurfacePickerSelection(
                                    false
                                );

                                hideTooltip();

                                return;
                            }

                            selectedTooth =
                                toothNumber;

                            selectedMesh =
                                mesh;

                            restoreSavedSurfaceSelectionForTooth(
                                toothNumber
                            );

                            window
                                .Odontogram3D
                                .focusTooth(
                                    odontogramThreeState,
                                    mesh
                                );

                            renderThreeVisuals();

                            updateSelectedToothUI();
                        },

                    onReady:
                        () => {
                            loadingOverlay.style
                                .opacity =
                                '0';

                            setTimeout(() => {
                                loadingOverlay.style
                                    .display =
                                    'none';
                            }, 500);
                        }
                });
        }

        function renderThreeVisuals() {
            if (
                !odontogramThreeState
            ) {
                return;
            }

            window.Odontogram3D.update(
                odontogramThreeState,

                Object.values(
                    odontogramState
                ),

                {
                    selectedTooth:
                        selectedTooth,

                    dimUnselected:
                        currentView === '3d' &&
                        Boolean(
                            selectedTooth
                        )
                }
            );
        }

        function resetCameraToFull3DView() {
            if (
                !odontogramThreeState
            ) {
                return;
            }

            window.Odontogram3D
                .resetCamera(
                    odontogramThreeState
                );
        }

        function handleResize() {
            if (
                !odontogramThreeState
            ) {
                return;
            }

            window.Odontogram3D
                .resize(
                    odontogramThreeState
                );
        }

        function createDefaultToothState(toothNumber) {
            return {
                tooth: Number(toothNumber),
                toothName: getToothName(Number(toothNumber)),
                status: null,
                surfaces: {
                    top: null,
                    left: null,
                    center: null,
                    right: null,
                    bottom: null
                },
                threeD: null,
                lastSelectedSurface: null
            };
        }

        function normalizeOdontogramEntry(entry) {
            if (!entry) return null;

            const toothNumber = Number(entry.tooth || entry.tooth_number || 0);

            if (!toothNumber) return null;

            const defaultState = createDefaultToothState(toothNumber);

            const surfaces =
                entry.surfaces &&
                    typeof entry.surfaces === 'object' &&
                    !Array.isArray(entry.surfaces) ?
                    entry.surfaces : {};

            const normalizeLegendRecord = function (record) {
                if (!record || !record.code) return null;

                const rawCode = String(record.code).trim();
                const normalizedCode = ['PT', '+'].includes(rawCode.toUpperCase())
                    ? '✓'
                    : rawCode.toUpperCase();
                const currentLegend = getLegendByCode(normalizedCode);

                return {
                    ...record,
                    code: normalizedCode,
                    label: currentLegend?.label || record.label || normalizedCode,
                    colorHex: legendColors[normalizedCode] || record.colorHex || '#111827'
                };
            };

            return {
                ...defaultState,
                ...entry,
                tooth: toothNumber,
                toothName: entry.toothName || entry.tooth_name || defaultState.toothName,
                status: normalizeLegendRecord(entry.status),
                threeD: normalizeLegendRecord(entry.threeD || entry.three_d),
                lastSelectedSurface: ['top', 'left', 'center', 'right', 'bottom'].includes(
                    entry.lastSelectedSurface || entry.last_selected_surface
                )
                    ? (entry.lastSelectedSurface || entry.last_selected_surface)
                    : null,
                surfaces: {
                    top: normalizeLegendRecord(surfaces.top),
                    left: normalizeLegendRecord(surfaces.left),
                    center: normalizeLegendRecord(surfaces.center),
                    right: normalizeLegendRecord(surfaces.right),
                    bottom: normalizeLegendRecord(surfaces.bottom)
                }
            };
        }

        savedOdontogramData.forEach(function (entry) {
            const normalizedEntry = normalizeOdontogramEntry(entry);

            if (normalizedEntry) {
                odontogramState[normalizedEntry.tooth] = normalizedEntry;
            }
        });

        const primaryUpperRight = [55, 54, 53, 52, 51];
        const primaryUpperLeft = [61, 62, 63, 64, 65];

        const adultUpperRight = [18, 17, 16, 15, 14, 13, 12, 11];
        const adultUpperLeft = [21, 22, 23, 24, 25, 26, 27, 28];

        const adultLowerRight = [48, 47, 46, 45, 44, 43, 42, 41];
        const adultLowerLeft = [31, 32, 33, 34, 35, 36, 37, 38];

        const primaryLowerRight = [85, 84, 83, 82, 81];
        const primaryLowerLeft = [71, 72, 73, 74, 75];

        const adultUpper = [...adultUpperRight, ...adultUpperLeft];
        const adultLower = [...adultLowerRight, ...adultLowerLeft];

        function getLegendByCode(code) {
            return legends.find(item => item.code === code) || null;
        }

        function getLegendDisplayCode(code) {
            const legend = getLegendByCode(code);
            return legend?.displayCode || legend?.code || code;
        }

        function getToothName(toothNumber) {
            const names = {
                18: 'Upper Right Third Molar',
                17: 'Upper Right Second Molar',
                16: 'Upper Right First Molar',
                15: 'Upper Right Second Premolar',
                14: 'Upper Right First Premolar',
                13: 'Upper Right Canine',
                12: 'Upper Right Lateral Incisor',
                11: 'Upper Right Central Incisor',
                21: 'Upper Left Central Incisor',
                22: 'Upper Left Lateral Incisor',
                23: 'Upper Left Canine',
                24: 'Upper Left First Premolar',
                25: 'Upper Left Second Premolar',
                26: 'Upper Left First Molar',
                27: 'Upper Left Second Molar',
                28: 'Upper Left Third Molar',
                48: 'Lower Right Third Molar',
                47: 'Lower Right Second Molar',
                46: 'Lower Right First Molar',
                45: 'Lower Right Second Premolar',
                44: 'Lower Right First Premolar',
                43: 'Lower Right Canine',
                42: 'Lower Right Lateral Incisor',
                41: 'Lower Right Central Incisor',
                31: 'Lower Left Central Incisor',
                32: 'Lower Left Lateral Incisor',
                33: 'Lower Left Canine',
                34: 'Lower Left First Premolar',
                35: 'Lower Left Second Premolar',
                36: 'Lower Left First Molar',
                37: 'Lower Left Second Molar',
                38: 'Lower Left Third Molar',

                55: 'Upper Right Second Molar (Primary)',
                54: 'Upper Right First Molar (Primary)',
                53: 'Upper Right Canine (Primary)',
                52: 'Upper Right Lateral Incisor (Primary)',
                51: 'Upper Right Central Incisor (Primary)',
                61: 'Upper Left Central Incisor (Primary)',
                62: 'Upper Left Lateral Incisor (Primary)',
                63: 'Upper Left Canine (Primary)',
                64: 'Upper Left First Molar (Primary)',
                65: 'Upper Left Second Molar (Primary)',

                85: 'Lower Right Second Molar (Primary)',
                84: 'Lower Right First Molar (Primary)',
                83: 'Lower Right Canine (Primary)',
                82: 'Lower Right Lateral Incisor (Primary)',
                81: 'Lower Right Central Incisor (Primary)',
                71: 'Lower Left Central Incisor (Primary)',
                72: 'Lower Left Lateral Incisor (Primary)',
                73: 'Lower Left Canine (Primary)',
                74: 'Lower Left First Molar (Primary)',
                75: 'Lower Left Second Molar (Primary)',
            };

            return names[toothNumber] || `Tooth #${toothNumber}`;
        }

        function openUiModal(modal) {
            if (!modal) return;

            modal.classList.remove('closing');
            modal.classList.add('open');
            modal.setAttribute('aria-hidden', 'false');

            document.documentElement.classList.add('modal-lock');
            document.body.classList.add('modal-lock');
        }

        function closeUiModal(modal) {
            if (!modal || !modal.classList.contains('open')) return;

            modal.classList.remove('open');
            modal.classList.add('closing');
            modal.setAttribute('aria-hidden', 'true');

            window.setTimeout(() => {
                modal.classList.remove('closing');

                if (!document.querySelector('.ui-modal.open')) {
                    document.documentElement.classList.remove('modal-lock');
                    document.body.classList.remove('modal-lock');
                }
            }, 170);
        }

        function openCancelProcedureModal() {
            openUiModal(cancelProcedureModal);
        }

        function closeCancelProcedureModal() {
            closeUiModal(cancelProcedureModal);
        }

        function openFinishProcedureModal({
            title,
            message,
            icon = 'fa-clipboard-check',
            buttonText = 'Back to Appointments',
            redirectUrl = null,
            confirmation = false,
        }) {
            finishProcedureModalTitle.textContent = title;
            finishProcedureModalMessage.textContent =
                confirmation
                    ? 'Confirm before completing this dental procedure.'
                    : (
                        redirectUrl
                            ? 'The procedure was completed successfully.'
                            : title === 'Treatment Required'
                                ? 'A treatment entry is required before this procedure can be completed.'
                                : message
                    );
            finishProcedureModalIcon.className = `fa-solid ${icon}`;
            finishProcedureModalRedirectUrl = redirectUrl;

            const actionButton = finishProcedureModalActionBtn;

            if (actionButton) {
                actionButton.classList.remove(
                    'ui-btn-primary',
                    'ui-btn-success',
                    'ui-btn-warning',
                    'ui-btn-danger'
                );

                actionButton.classList.add(
                    redirectUrl
                        ? 'ui-btn-success'
                        : confirmation
                            ? 'ui-btn-warning'
                            : 'ui-btn-primary'
                );
            }

            finishProcedureModal.classList.remove(
                'modal-theme-success',
                'modal-theme-warning',
                'modal-theme-danger'
            );

            finishProcedureModal.classList.add(
                confirmation
                    ? 'modal-theme-warning'
                    : (redirectUrl ? 'modal-theme-success' : 'modal-theme-danger')
            );

            finishProcedureModalAlertTitle.textContent =
                confirmation
                    ? 'This action will complete the appointment'
                    : (
                        redirectUrl
                            ? 'Appointment completed'
                            : title === 'Treatment Required'
                                ? 'Add a treatment first'
                                : 'Action required'
                    );

            finishProcedureModalAlertMessage.textContent = message;

            finishProcedureConfirmActions.classList.toggle('hidden', !confirmation);
            finishProcedureResultActions.classList.toggle('hidden', confirmation);

            const actionLabel = finishProcedureModalActionBtn?.querySelector('span');
            if (actionLabel) {
                actionLabel.textContent = buttonText;
            }

            openUiModal(finishProcedureModal);

            requestAnimationFrame(() => {
                (confirmation ? confirmFinishProcedureBtn : finishProcedureModalActionBtn)?.focus();
            });
        }

        function closeFinishProcedureModal() {
            const redirectUrl = finishProcedureModalRedirectUrl;
            finishProcedureModalRedirectUrl = null;

            closeUiModal(finishProcedureModal);

            if (redirectUrl) {
                window.setTimeout(() => {
                    window.location.href = redirectUrl;
                }, 180);
                return;
            }

            window.setTimeout(() => {
                finishProcedureBtn?.focus();
            }, 180);
        }

        function getSurfaceLabel(surface) {
            const map = {
                top: 'Top Surface',
                bottom: 'Bottom Surface',
                left: 'Left Surface',
                right: 'Right Surface',
                center: 'Center Surface',
                status: 'Status Box',
                whole: 'Whole Tooth'
            };
            return map[surface] || surface;
        }

        function update3DSurfacePicker() {
            if (!surfacePicker3D) return;

            const showPicker = currentView === '3d' && !!selectedTooth;
            surfacePicker3D.classList.toggle('hidden', !showPicker);

            if (!showPicker) {
                return;
            }

            if (selectedTooth) {
                surfacePickerToothLabel.textContent = `Tooth #${selectedTooth} - ${getToothName(selectedTooth)}`;
                surfacePickerHelperText.textContent = selectedTargetType === 'surface'
                    ? `${getSurfaceLabel(selectedSurfaceKey)} selected.`
                    : 'Camera focused on the selected tooth. Now choose one large surface button below.';
            } else {
                surfacePickerToothLabel.textContent = 'No tooth selected';
                surfacePickerHelperText.textContent = 'Step 1: Click a tooth in the 3D model. The camera will zoom in automatically.';
            }

            surfacePickerButtons.forEach(btn => {
                const surfaceKey = btn.dataset.surface;
                const disabled = !selectedTooth;
                const isActive =
                    selectedTooth &&
                    selectedTargetType === 'surface' &&
                    selectedSurfaceKey === surfaceKey;

                btn.disabled = disabled;
                btn.classList.toggle('active', isActive);
            });
        }

        function selectSurfaceFrom3DPicker(surfaceKey) {
            if (!selectedTooth) {
                showProcedureToast(
                    'Select a tooth in the 3D model before choosing a surface.',
                    'warning',
                    'Select a Tooth'
                );
                return;
            }

            selectedTargetType = 'surface';
            selectedSurfaceKey = surfaceKey;

            const state = ensureToothState(selectedTooth);
            state.lastSelectedSurface = surfaceKey;
            const currentSurfaceRecord = state.surfaces[surfaceKey];
            selectedLegend = currentSurfaceRecord ? currentSurfaceRecord.code : null;

            updateSelectedToothUI();
            renderThreeVisuals();
        }

        function clear3DSurfacePickerSelection(shouldResetCamera = false) {
            selectedTooth = null;
            selectedTargetType = null;
            selectedSurfaceKey = null;
            selectedMesh = null;
            selectedLegend = null;

            if (odontogramThreeState) {
                renderThreeVisuals();

                if (shouldResetCamera) {
                    resetCameraToFull3DView();
                }
            }

            updateSelectedToothUI();
            updateLegendActiveState();
            updateActionButtons();
            updateHistoryButtons();
            update3DSurfacePicker();
        }

        function ensureToothState(toothNumber) {
            const numericToothNumber = Number(toothNumber);

            if (!odontogramState[numericToothNumber]) {
                odontogramState[numericToothNumber] = createDefaultToothState(numericToothNumber);
            } else {
                odontogramState[numericToothNumber] = normalizeOdontogramEntry(odontogramState[
                    numericToothNumber]) ||
                    createDefaultToothState(numericToothNumber);
            }

            return odontogramState[numericToothNumber];
        }

        function updateHiddenInput() {
            odontogramDataInput.value = JSON.stringify(Object.values(odontogramState));
        }

        function updateLegendActiveState() {
            document.querySelectorAll('.legend-btn').forEach(btn => {
                btn.classList.remove('active');
                if (selectedLegend && btn.dataset.code === selectedLegend) {
                    btn.classList.add('active');
                }
            });
        }

        function getSelectedRecord() {
            if (!selectedTooth || !selectedTargetType) return null;

            const state = ensureToothState(selectedTooth);

            if (selectedTargetType === 'status') return state.status;
            if (selectedTargetType === 'surface' && selectedSurfaceKey) return state.surfaces[
                selectedSurfaceKey];
            if (selectedTargetType === '3d') return state.threeD;

            return null;
        }

        function renderSelectedToothLegendList() {
            const selectedRecord = getSelectedRecord();

            if (!selectedRecord) {
                selectedToothLegendList.innerHTML =
                    '<span class="ui-muted-text">None selected</span>';

                return;
            }

            selectedToothLegendList.innerHTML = `
        <span class="odontogram-preview-marking">
            <span
                class="odontogram-preview-marking-swatch"
                style="background:${selectedRecord.colorHex};"
            ></span>

            <span>
                ${getLegendDisplayCode(selectedRecord.code)} - ${selectedRecord.label}
            </span>
        </span>
    `;
        }

        function updateActionButtons() {
            const hasSelectedTarget = !!selectedTooth && !!selectedTargetType;
            const hasSelectedLegend = !!selectedLegend;
            const hasAssignedTreatment = !!getSelectedRecord();

            applyTreatmentBtn.disabled = !(hasSelectedTarget && hasSelectedLegend);
            clearCurrentToothBtn.disabled = !hasAssignedTreatment;
            updateHistoryButtons();
        }

        function updateSelectedToothUI() {
            if (!selectedTooth || !selectedTargetType) {
                drawerSelectedLegendPreview.textContent =
                    selectedLegend
                        ? `${getLegendDisplayCode(selectedLegend)} - ${getLegendByCode(selectedLegend)?.label || selectedLegend
                        }`
                        : 'None selected';

                selectedToothDisplay.textContent =
                    currentView === '2d'
                        ? 'Select a tooth surface.'
                        : 'Select a tooth.';

                selectedToothName.textContent = '';
                toothHoverLabel.innerText = 'Select a tooth';
                legendStatusNote.classList.add('hidden');
                selectedLegend = null;
                selectedViewBadge.textContent = currentView === '2d' ? '2D View' : '3D View';

                updateLegendActiveState();
                renderSelectedToothLegendList();
                updateActionButtons();
                update3DSurfacePicker();
                return;
            }

            if (currentView === '3d' && !selectedTargetType) {
                selectedToothDisplay.textContent = `Tooth #${selectedTooth} - Choose a surface below`;
                selectedToothName.textContent = getToothName(selectedTooth);
                toothHoverLabel.innerText = `Selected: #${selectedTooth}`;
                selectedViewBadge.textContent = '3D View';
                legendStatusNote.classList.remove('hidden');
                legendStatusNote.textContent =
                    'Choose a surface, select a treatment, then apply.';
                selectedLegend = null;

                updateLegendActiveState();
                renderSelectedToothLegendList();
                updateActionButtons();
                update3DSurfacePicker();
                return;
            }

            const surfaceText = selectedTargetType === 'surface' ?
                getSurfaceLabel(selectedSurfaceKey) :
                selectedTargetType === 'status' ?
                    getSurfaceLabel('status') :
                    getSurfaceLabel('whole');

            selectedToothDisplay.textContent = `Tooth #${selectedTooth} - ${surfaceText}`;
            selectedToothName.textContent = getToothName(selectedTooth);
            toothHoverLabel.innerText = `Selected: #${selectedTooth}`;
            selectedViewBadge.textContent = currentView === '2d' ? '2D View' : '3D View';
            legendStatusNote.classList.remove('hidden');
            legendStatusNote.textContent = 'Select a treatment, then apply.';

            const record = getSelectedRecord();
            selectedLegend = record ? record.code : null;

            updateLegendActiveState();
            renderSelectedToothLegendList();
            updateActionButtons();
            update3DSurfacePicker();
        }

        function renderLegendButtons(searchTerm = '') {
            legendContainer.innerHTML = '';

            const normalizedSearch = searchTerm.trim().toLowerCase();
            let totalResults = 0;

            legendCategories.forEach(category => {
                const categoryLegends = category.items
                    .map(code => legends.find(item => item.code === code))
                    .filter(Boolean)
                    .filter(legend => {
                        if (!normalizedSearch) return true;
                        return (
                            legend.code.toLowerCase().includes(normalizedSearch) ||
                            legend.label.toLowerCase().includes(normalizedSearch)
                        );
                    });

                if (!categoryLegends.length) return;

                totalResults += categoryLegends.length;

                const categoryBlock = document.createElement('div');
                categoryBlock.className = 'legend-category-block';

                categoryBlock.innerHTML = `
                        <div class="legend-category-head">
                            <div class="legend-category-title">
                                <span class="legend-category-icon">
                                    <i class="${category.icon}"></i>
                                </span>
                                <div>
                                    <p class="odontogram-legend-category-name">
                                        ${category.title}
                                    </p>
                                </div>
                            </div>
                            <span class="legend-category-count">${categoryLegends.length}</span>
                        </div>
                    `;

                const body = document.createElement('div');
                body.className = 'legend-category-body';

                categoryLegends.forEach(legend => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.dataset.code = legend.code;
                    btn.className = 'legend-btn';
                    btn.title = `${legend.displayCode || legend.code} - ${legend.label}`;

                    btn.innerHTML = `
                            <span class="legend-color-dot" style="background:${legendColors[legend.code]};"></span>
                            <i class="${legendIcons[legend.code]}"></i>
                            <span class="legend-meta">
                                <span class="legend-code">${legend.displayCode || legend.code}</span>
                                <span class="legend-label">${legend.label}</span>
                            </span>
                        `;

                    btn.addEventListener('click', function () {
                        if (!selectedTooth || !selectedTargetType) {
                            showProcedureToast(
                                'Select a tooth surface first, then choose a treatment legend.',
                                'warning',
                                'Select a Tooth'
                            );
                            return;
                        }

                        selectedLegend = legend.code;
                        selectedLegendPreview.textContent =
                            `${legend.displayCode || legend.code} - ${legend.label}`;
                        drawerSelectedLegendPreview.textContent =
                            `${legend.displayCode || legend.code} - ${legend.label}`;
                        updateLegendActiveState();
                        updateActionButtons();
                    });

                    body.appendChild(btn);
                });

                categoryBlock.appendChild(body);
                legendContainer.appendChild(categoryBlock);
            });

            legendResultCount.textContent =
                String(totalResults);

            if (totalResults === 0) {
                window.renderGlobalSearchEmptyState?.({
                    host: legendEmptyState,
                    input: '#legendSearchInput',
                    title: 'No treatments found',
                    message: 'Try another name or code.',
                    icon: 'fa-tooth',
                    className: 'empty-state-compact',
                });
            } else {
                window.hideGlobalSearchEmptyState?.(
                    legendEmptyState
                );
            }

            updateLegendActiveState();
        }

        window.filterOdontogramLegends = function (query = '') {
            renderLegendButtons(query);
        };

        function createLegendPayload(code) {
            const legendObj = getLegendByCode(code);
            return {
                code: code,
                label: legendObj ? legendObj.label : code,
                colorHex: legendColors[code] || '#ef4444'
            };
        }

        function isAdultTooth(toothNumber) {
            return adultUpper.includes(toothNumber) || adultLower.includes(toothNumber);
        }

        function getPreferredToothVisual(state) {
            if (!state) return null;

            if (state.status) return state.status;

            const surfacePriority = ['center', 'top', 'right', 'bottom', 'left'];
            for (const key of surfacePriority) {
                if (state.surfaces[key]) return state.surfaces[key];
            }

            return null;
        }

        function getFirstTreatedSurfaceKey(state) {
            if (!state || !state.surfaces) return null;

            const surfacePriority = ['top', 'left', 'center', 'right', 'bottom'];

            for (const key of surfacePriority) {
                if (state.surfaces[key] && state.surfaces[key].code) {
                    return key;
                }
            }

            return null;
        }

        function getPreferredSurfaceKey(state) {
            if (!state || !state.surfaces) return null;

            const lastSurface = state.lastSelectedSurface;

            if (
                lastSurface &&
                state.surfaces[lastSurface] &&
                state.surfaces[lastSurface].code
            ) {
                return lastSurface;
            }

            return getFirstTreatedSurfaceKey(state);
        }

        function getStatusBoxDisplayRecord(state) {
            if (!state || !state.surfaces) return null;

            const preferredSurfaceKey = getPreferredSurfaceKey(state);

            if (
                preferredSurfaceKey &&
                state.surfaces[preferredSurfaceKey] &&
                state.surfaces[preferredSurfaceKey].code
            ) {
                return state.surfaces[preferredSurfaceKey];
            }

            return null;
        }

        function applyDividedStatusBoxVisual(statusBox, record) {
            const colorPart = document.createElement('span');
            const codePart = document.createElement('span');
            const colorHex = record ? record.colorHex : '#ffffff';
            const code = record ? record.code : '';

            statusBox.classList.add('status-box-divided');
            statusBox.innerHTML = '';

            statusBox.style.padding = '0';
            statusBox.style.display = 'flex';
            statusBox.style.flexDirection = 'column';
            statusBox.style.alignItems = 'stretch';
            statusBox.style.justifyContent = 'stretch';
            statusBox.style.overflow = 'hidden';
            statusBox.style.boxSizing = 'border-box';
            statusBox.style.background = '#ffffff';
            statusBox.style.borderColor = record ? colorHex : '';

            colorPart.className = 'status-box-color-part';
            colorPart.style.display = 'flex';
            colorPart.style.alignItems = 'center';
            colorPart.style.justifyContent = 'center';
            colorPart.style.flex = '1 1 0';
            colorPart.style.minHeight = '0';
            colorPart.style.width = '100%';
            colorPart.style.background = record ? colorHex : '#ffffff';

            codePart.className = 'status-box-code-part';
            codePart.textContent = code;
            codePart.style.display = 'flex';
            codePart.style.alignItems = 'center';
            codePart.style.justifyContent = 'center';
            codePart.style.flex = '1 1 0';
            codePart.style.minHeight = '0';
            codePart.style.width = '100%';
            codePart.style.background = '#ffffff';
            codePart.style.borderTop = '1px solid #8B0000';
            codePart.style.color = record ? colorHex : 'transparent';
            codePart.style.fontSize = code.length > 1 ? '8.5px' : '10px';
            codePart.style.fontWeight = '900';
            codePart.style.lineHeight = '1';
            codePart.style.letterSpacing = '-0.03em';
            codePart.style.whiteSpace = 'nowrap';

            statusBox.appendChild(colorPart);
            statusBox.appendChild(codePart);
        }


        function restoreSavedSurfaceSelectionForTooth(toothNumber) {
            const state = ensureToothState(toothNumber);
            const savedSurfaceKey = getPreferredSurfaceKey(state);

            if (!savedSurfaceKey) {
                selectedTargetType = null;
                selectedSurfaceKey = null;
                selectedLegend = null;
                return;
            }

            selectedTargetType = 'surface';
            selectedSurfaceKey = savedSurfaceKey;
            selectedLegend = state.surfaces[savedSurfaceKey].code;
            state.lastSelectedSurface = savedSurfaceKey;
        }

        function sync3DFrom2D(toothNumber) {
            const state = ensureToothState(toothNumber);

            if (!isAdultTooth(toothNumber)) {
                state.threeD = null;
                return;
            }

            state.threeD = getPreferredToothVisual(state);
        }

        function fillAll2DSurfacesFromLegend(state, payload) {
            state.status = payload;
            state.surfaces.top = payload;
            state.surfaces.left = payload;
            state.surfaces.center = payload;
            state.surfaces.right = payload;
            state.surfaces.bottom = payload;
        }

        function clearAll2DSurfaces(state) {
            state.status = null;
            state.surfaces.top = null;
            state.surfaces.left = null;
            state.surfaces.center = null;
            state.surfaces.right = null;
            state.surfaces.bottom = null;
        }

        function snapshotState() {
            return JSON.stringify(odontogramState);
        }

        function restoreStateFromSnapshot(snapshot) {
            const parsed = JSON.parse(snapshot);

            Object.keys(odontogramState).forEach(key => delete odontogramState[key]);
            Object.keys(parsed).forEach(key => {
                odontogramState[key] = parsed[key];
            });

            updateHiddenInput();
            render2DOdontogram();

            if (odontogramThreeState) {
                renderThreeVisuals();
            }

            updateSelectedToothUI();
            updateLegendActiveState();
            renderSelectedToothLegendList();
            updateActionButtons();
            updateHistoryButtons();
        }

        function pushHistory() {
            historyStack.push(snapshotState());
            if (historyStack.length > HISTORY_LIMIT) {
                historyStack.shift();
            }
            redoStack = [];
            updateHistoryButtons();
        }

        function updateHistoryButtons() {
            if (undoBtn) undoBtn.disabled = historyStack.length === 0;
            if (redoBtn) redoBtn.disabled = redoStack.length === 0;
            if (clearSelectionBtn) clearSelectionBtn.disabled = !(selectedTooth && selectedTargetType);
        }

        function clearCurrentSelection() {
            if (currentView === '3d') {
                clear3DSurfacePickerSelection(true);
                return;
            }

            selectedTooth = null;
            selectedTargetType = null;
            selectedSurfaceKey = null;
            selectedMesh = null;
            selectedLegend = null;

            render2DOdontogram();

            if (odontogramThreeState) {
                renderThreeVisuals();
            }

            updateSelectedToothUI();
            updateLegendActiveState();
            updateActionButtons();
            updateHistoryButtons();
        }

        function undoLastAction() {
            if (!historyStack.length) return;

            redoStack.push(snapshotState());
            const previous = historyStack.pop();
            restoreStateFromSnapshot(previous);
        }

        function redoLastAction() {
            if (!redoStack.length) return;

            historyStack.push(snapshotState());
            const next = redoStack.pop();
            restoreStateFromSnapshot(next);
        }

        function applyLegendToSelectedTarget(code) {
            if (!selectedTooth || !selectedTargetType) return;

            if (selectedTargetType === 'status') {
                showProcedureToast(
                    'Apply treatments to an actual tooth surface instead of the divided status indicator.',
                    'warning',
                    'Select a Tooth Surface'
                );
                return;
            }

            pushHistory();

            const state = ensureToothState(selectedTooth);
            const payload = createLegendPayload(code);
            hasAppliedTreatmentThisSession = true;

            if (
                selectedTargetType === 'surface' &&
                selectedSurfaceKey
            ) {
                state.surfaces[selectedSurfaceKey] =
                    payload;

                sync3DFrom2D(selectedTooth);
            } else if (
                selectedTargetType === '3d'
            ) {
                state.threeD = payload;

                fillAll2DSurfacesFromLegend(
                    state,
                    payload
                );
            }

            updateHiddenInput();
            render2DOdontogram();

            if (odontogramThreeState) {
                renderThreeVisuals();
            }

            renderSelectedToothLegendList();
            updateLegendActiveState();
            updateActionButtons();
            selectedLegendPreview.textContent = `${getLegendDisplayCode(payload.code)} - ${payload.label}`;
            drawerSelectedLegendPreview.textContent = `${getLegendDisplayCode(payload.code)} - ${payload.label}`;

            if (currentView === '3d') {
                setTimeout(function () {
                    clear3DSurfacePickerSelection(false);
                }, 120);
            }
        }

        function clearSelectedTargetTreatment() {
            if (!pendingResetPayload) return;
            pushHistory();

            const {
                tooth,
                targetType,
                surfaceKey
            } = pendingResetPayload;
            const state = ensureToothState(tooth);

            if (targetType === 'status') {
                pendingResetPayload = null;
                closeResetModal();
                return;
            } else if (targetType === 'surface' && surfaceKey) {
                state.surfaces[surfaceKey] = null;
                state.lastSelectedSurface = getFirstTreatedSurfaceKey(state);
                sync3DFrom2D(tooth);
            } else if (targetType === '3d') {
                state.threeD = null;
                state.lastSelectedSurface = null;
                clearAll2DSurfaces(state);
            }

            selectedLegend = null;
            pendingResetPayload = null;

            selectedLegendPreview.textContent = 'None selected';
            drawerSelectedLegendPreview.textContent = 'None selected';

            updateHiddenInput();
            render2DOdontogram();

            if (odontogramThreeState) {
                renderThreeVisuals();
            }

            renderSelectedToothLegendList();
            updateLegendActiveState();
            updateActionButtons();
            closeResetModal();
        }

        function openResetModal() {
            if (!selectedTooth || !selectedTargetType || !getSelectedRecord()) return;

            pendingResetPayload = {
                tooth: selectedTooth,
                targetType: selectedTargetType,
                surfaceKey: selectedSurfaceKey
            };

            const partText = selectedTargetType === 'surface' ?
                getSurfaceLabel(selectedSurfaceKey) :
                selectedTargetType === 'status' ?
                    'Status Box' :
                    'Whole Tooth';

            resetTreatmentMessage.textContent =
                `Are you sure you want to reset the treatment for tooth #${selectedTooth} (${getToothName(selectedTooth)}) - ${partText}?`;

            openUiModal(resetTreatmentModal);
        }

        function closeResetModal() {
            pendingResetPayload = null;
            closeUiModal(resetTreatmentModal);
        }

        function createToothUnit(toothNumber, statusPlacement = 'top') {
            const state = ensureToothState(toothNumber);

            const wrap = document.createElement('div');
            wrap.className = 'tooth-unit';

            const statusBox = document.createElement('div');
            statusBox.className = 'status-box';
            statusBox.dataset.tooth = toothNumber;
            statusBox.setAttribute('aria-label', `Surface legend indicator for tooth #${toothNumber}`);
            statusBox.title = 'Display only: this box updates after applying a legend to a tooth surface.';
            statusBox.style.cursor = 'default';

            const statusDisplayRecord = getStatusBoxDisplayRecord(state);

            applyDividedStatusBoxVisual(statusBox, statusDisplayRecord);

            const toothNumberEl = document.createElement('div');
            toothNumberEl.className = 'tooth-number';
            toothNumberEl.textContent = toothNumber;

            const toothFace = document.createElement('div');
            toothFace.className = 'tooth-2d-wrapper';

            toothFace.innerHTML = `
                    <svg viewBox="0 0 100 100" class="tooth-svg" preserveAspectRatio="xMidYMid meet">
                        <path class="surface-part surface-top" data-surface="top" d="M 0 0 L 100 0 L 50 50 Z" />
                        <path class="surface-part surface-right" data-surface="right" d="M 100 0 L 100 100 L 50 50 Z" />
                        <path class="surface-part surface-bottom" data-surface="bottom" d="M 100 100 L 0 100 L 50 50 Z" />
                        <path class="surface-part surface-left" data-surface="left" d="M 0 100 L 0 0 L 50 50 Z" />
                        <circle class="surface-part surface-center" data-surface="center" cx="50" cy="50" r="22" />
                    </svg>
                `;

            const surfaces = toothFace.querySelectorAll('.surface-part');
            surfaces.forEach(part => {
                const surface = part.dataset.surface;
                const surfaceRecord = state.surfaces[surface];

                if (surfaceRecord) {
                    part.style.fill = surfaceRecord.colorHex;
                }

                if (selectedTooth === toothNumber && selectedTargetType === 'surface' &&
                    selectedSurfaceKey === surface) {
                    part.classList.add('selected-target');
                }

                part.addEventListener('click', function () {
                    currentView = '2d';
                    selectedTooth = toothNumber;
                    selectedTargetType = 'surface';
                    selectedSurfaceKey = surface;
                    updateSelectedToothUI();
                    render2DOdontogram();
                });

                part.addEventListener('mouseenter', function () {
                    toothHoverLabel.innerText = `Tooth #${toothNumber}`;
                });

                part.addEventListener('mouseleave', function () {
                    toothHoverLabel.innerText = selectedTooth ? `Selected: #${selectedTooth}` :
                        'Select a tooth';
                });
            });

            if (statusPlacement === 'top') {
                wrap.appendChild(statusBox);
                wrap.appendChild(toothNumberEl);
                wrap.appendChild(toothFace);
            } else {
                wrap.appendChild(toothFace);
                wrap.appendChild(toothNumberEl);
                wrap.appendChild(statusBox);
            }

            return wrap;
        }

        function createRow(leftTeeth, rightTeeth, statusPlacement = 'top', leftLabel = '', rightLabel = '') {
            const row = document.createElement('div');
            row.className = 'odontogram-row';

            const left = document.createElement('div');
            left.className = 'status-label-left';
            left.innerHTML = leftLabel ? leftLabel : '&nbsp;';

            if (statusPlacement === 'top') {
                left.style.paddingTop = '10px';
            } else {
                left.style.alignSelf = 'flex-end';
                left.style.paddingBottom = '10px';
            }
            row.appendChild(left);

            leftTeeth.forEach(tooth => row.appendChild(createToothUnit(tooth, statusPlacement)));

            const spacer = document.createElement('div');
            spacer.className = 'odontogram-arch-spacer';
            row.appendChild(spacer);

            rightTeeth.forEach(tooth => row.appendChild(createToothUnit(tooth, statusPlacement)));

            const right = document.createElement('div');
            right.className = 'status-label-right';
            right.innerHTML = rightLabel ? rightLabel : '&nbsp;';

            if (statusPlacement === 'top') {
                right.style.paddingTop = '10px';
            } else {
                right.style.alignSelf = 'flex-end';
                right.style.paddingBottom = '10px';
            }
            row.appendChild(right);

            return row;
        }

        function render2DOdontogram() {
            board2d.innerHTML = '';

            const row1 = createRow(primaryUpperRight, primaryUpperLeft, 'top', 'STATUS<br>RIGHT', 'LEFT');
            row1.classList.add('arch-divider');
            board2d.appendChild(row1);

            const row2 = createRow(adultUpperRight, adultUpperLeft, 'top', '', '');
            row2.style.marginBottom = '24px';
            board2d.appendChild(row2);

            const row3 = createRow(adultLowerRight, adultLowerLeft, 'bottom', '', '');
            row3.classList.add('arch-divider');
            board2d.appendChild(row3);

            const row4 = createRow(primaryLowerRight, primaryLowerLeft, 'bottom', 'STATUS<br>RIGHT', 'LEFT');
            board2d.appendChild(row4);
        }

        async function switchView(view) {
            const previousView = currentView;
            currentView = view;

            if (view === '2d') {
                selectedMesh = null;
                panel2d.classList.add('active');
                panel3d.classList.remove('active');
                view2dBtn.classList.add('active');
                view3dBtn.classList.remove('active');
                viewInstructionText.textContent =
                    'Select a surface to begin treatment';
            } else {
                panel2d.classList.remove('active');
                panel3d.classList.add('active');
                view2dBtn.classList.remove('active');
                view3dBtn.classList.add('active');
                viewInstructionText.textContent =
                    'Select a tooth, then choose a surface';

                if (previousView !== '3d') {
                    selectedTooth = null;
                    selectedTargetType = null;
                    selectedSurfaceKey = null;
                    selectedMesh = null;
                    selectedLegend = null;
                }

                if (!odontogramThreeState) {
                    await initThreeScene();
                } else {
                    handleResize();
                    renderThreeVisuals();
                }
            }

            if (
                view === '3d' &&
                odontogramThreeState &&
                selectedTooth
            ) {
                selectedMesh =
                    window.Odontogram3D
                        .getToothMesh(
                            odontogramThreeState,
                            selectedTooth
                        );

                renderThreeVisuals();
            }

            updateSelectedToothUI();
            update3DSurfacePicker();
        }

        view2dBtn.addEventListener('click', () => switchView('2d'));
        view3dBtn.addEventListener('click', () => switchView('3d'));

        function showTooltip(event, mesh) {
            const toothNumber = mesh.userData.tooth;
            const toothName = getToothName(toothNumber);
            const state = ensureToothState(toothNumber);
            const treatment = state.threeD || getPreferredToothVisual(state);

            toothTooltipContent.innerHTML = `
    <div class="tooth-tooltip-number">
        Tooth #${toothNumber}
    </div>

    <div class="tooth-tooltip-name">
        ${toothName}
    </div>

    <div class="tooth-tooltip-help">
        Click to choose this tooth, then select a surface.
    </div>

    <div class="tooth-tooltip-treatment ${treatment ? 'has-treatment' : ''}">
        ${treatment
                    ? `Current visual: ${getLegendDisplayCode(treatment.code)} - ${treatment.label}`
                    : 'No treatment assigned'
                }
    </div>
`;

            const rect = container.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;

            toothTooltip.style.left = `${x}px`;
            toothTooltip.style.top = `${y}px`;
            toothTooltip.classList.add('show');
        }

        function hideTooltip() {
            toothTooltip.classList.remove('show');
        }

        const procedureStartTimestamp = Date.now();

        function formatElapsedTime(totalSeconds) {
            const hours = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
            const minutes = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
            const seconds = String(totalSeconds % 60).padStart(2, '0');
            return `${hours}:${minutes}:${seconds}`;
        }

        function updateProcedureTimer() {
            const elapsedSeconds = Math.floor((Date.now() - procedureStartTimestamp) / 1000);
            procedureTimer.textContent = formatElapsedTime(elapsedSeconds);
        }

        applyTreatmentBtn.addEventListener('click', function () {
            if (!selectedTooth || !selectedTargetType) {
                showProcedureToast(
                    'Please select a tooth surface before choosing a treatment legend.',
                    'warning',
                    'Select a Tooth'
                );
                selectedLegendPreview.textContent = selectedLegend ?
                    `${selectedLegend} - ${(getLegendByCode(selectedLegend)?.label || selectedLegend)}` :
                    'None selected';
                return;
            }

            if (!selectedLegend) {
                showProcedureToast(
                    'Choose a treatment legend before applying treatment.',
                    'warning',
                    'Select a Legend'
                );
                return;
            }

            applyLegendToSelectedTarget(selectedLegend);
        });

        clearCurrentToothBtn.addEventListener('click', function () {
            if (!selectedTooth || !selectedTargetType || !getSelectedRecord()) return;
            openResetModal();
        });

        confirmResetTreatmentBtn.addEventListener('click', clearSelectedTargetTreatment);
        cancelResetTreatmentBtn.addEventListener('click', closeResetModal);
        closeResetTreatmentModalBtn?.addEventListener('click', closeResetModal);
        closeCancelProcedureModalBtn?.addEventListener('click', closeCancelProcedureModal);
        closeFinishProcedureModalBtn?.addEventListener('click', closeFinishProcedureModal);

        resetTreatmentModal.addEventListener('click', function (event) {
            if (event.target === resetTreatmentModal) {
                closeResetModal();
            }
        });

        window.addEventListener('resize', handleResize);

        const finishProcedureBtn = document.getElementById('finishProcedureBtn');
        const followUpBtn = document.getElementById('followUpBtn');
        const closeFollowUpModalBtn = document.getElementById('closeFollowUpModalBtn');
        const cancelFollowUpModalBtn = document.getElementById('cancelFollowUpModalBtn');
        const saveProcedureUrl = @json($saveProcedureUrl ?? null);
        const storeFollowUpUrl = @json(!$existingAppointmentMode && $appointment ? route('dentist.dentist.appointments.follow-up.store', $appointment -> id) : null);

        function showProcedureToast(message, type = 'success', title = null) {
            window.showToast?.({
                type,
                title:
                    title ||
                    (
                        type === 'error'
                            ? 'Action Required'
                            : type === 'warning'
                                ? 'Attention'
                                : 'Success'
                    ),
                message,
                duration: 4000,
            });
        }

        function resetFollowUpForm() {
            const form = document.getElementById('followUpForm');
            const dateInput = document.getElementById('followup_appointment_date');
            const timeInput = document.getElementById('followup_appointment_time');
            const reasonInput = document.getElementById('followup_reason');
            const dateBanner =
                document.getElementById(
                    'followUpDateBanner'
                );

            const slotPlaceholder =
                document.getElementById(
                    'followUpSlotPlaceholder'
                );

            const slotContainer =
                document.getElementById(
                    'followUpSlotContainer'
                );

            const slotGrid =
                document.getElementById(
                    'followUpSlotGrid'
                );

            const selectedSlotDisplay =
                document.getElementById(
                    'followUpSelectedSlotDisplay'
                );

            const selectedSlotText =
                document.getElementById(
                    'followUpSelectedSlotText'
                );

            const clearTimeBtn =
                document.getElementById(
                    'followUpClearTimeBtn'
                );

            const dateGroup =
                document.getElementById(
                    'followUpCalendarWrap'
                );

            const timeGroup =
                document.getElementById(
                    'followUpTimeWrap'
                );

            form?.reset();
            if (dateInput) dateInput.value = '';
            if (timeInput) timeInput.value = '';
            if (reasonInput) reasonInput.value = '';

            if (typeof selectedDate !== 'undefined') selectedDate = null;
            if (typeof selectedTime !== 'undefined') selectedTime = null;

            window.clearGlobalGroupError?.(
                dateGroup,
                'followup_appointment_date'
            );

            window.clearGlobalGroupError?.(
                timeGroup,
                'followup_appointment_time'
            );

            document.getElementById('followUpDateError')?.classList.remove('show');
            document.getElementById('followUpTimeError')?.classList.remove('show');

            if (dateBanner) {
                dateBanner.replaceChildren();
                dateBanner.classList.add('hidden');
                dateBanner.style.removeProperty('display');
            }

            if (slotPlaceholder) {
                slotPlaceholder.classList.remove('hidden');
                slotPlaceholder.style.removeProperty('display');
            }

            if (slotContainer) {
                slotContainer.classList.add('hidden');
                slotContainer.style.removeProperty('display');
            }

            if (slotGrid) {
                slotGrid.replaceChildren();
                slotGrid.style.removeProperty('display');
            }

            selectedSlotDisplay?.classList.add(
                'hidden'
            );

            if (selectedSlotText) {
                selectedSlotText.textContent = '';
            }

            clearTimeBtn?.classList.add(
                'hidden'
            );
        }

        const followUpClearTimeBtn =
            document.getElementById(
                'followUpClearTimeBtn'
            );

        followUpClearTimeBtn?.addEventListener(
            'click',
            function () {

                const slotGrid =
                    document.getElementById(
                        'followUpSlotGrid'
                    );

                const timeInput =
                    document.getElementById(
                        'followup_appointment_time'
                    );

                const selectedDisplay =
                    document.getElementById(
                        'followUpSelectedSlotDisplay'
                    );

                const selectedText =
                    document.getElementById(
                        'followUpSelectedSlotText'
                    );

                if (
                    typeof selectedTime !==
                    'undefined'
                ) {
                    selectedTime = null;
                }

                if (timeInput) {
                    timeInput.value = '';

                    timeInput.dispatchEvent(
                        new Event(
                            'change',
                            {
                                bubbles: true
                            }
                        )
                    );
                }

                slotGrid
                    ?.querySelectorAll(
                        '.slot-chip'
                    )
                    .forEach(chip => {

                        chip.classList.remove(
                            'selected'
                        );

                        chip.setAttribute(
                            'aria-pressed',
                            'false'
                        );
                    });

                selectedDisplay?.classList.add(
                    'hidden'
                );

                if (selectedText) {
                    selectedText.textContent = '';
                }

                followUpClearTimeBtn.classList.add(
                    'hidden'
                );

                window.clearGlobalGroupError?.(
                    document.getElementById(
                        'followUpTimeWrap'
                    ),
                    'followup_appointment_time'
                );
            }
        );

        function openFollowUpModal() {
            const modal =
                document.getElementById(
                    'followUpModal'
                );

            if (!modal) return;

            resetFollowUpForm();

            window.PatientUI
                ?.initAvatars?.(modal);

            window.openModal?.(
                'followUpModal'
            );
        }

        function getCleanOdontogramDataForSave() {
            let rawData = [];

            try {
                rawData = JSON.parse(odontogramDataInput.value || '[]');
            } catch (error) {
                rawData = [];
            }

            if (!Array.isArray(rawData)) {
                rawData = Object.values(rawData || {});
            }

            return rawData
                .map(function (entry) {
                    const toothNumber = Number(entry?.tooth || 0);

                    if (!toothNumber) {
                        return null;
                    }

                    const cleanEntry = {
                        tooth: toothNumber,
                        toothName: entry.toothName || getToothName(toothNumber),
                        status: null,
                        surfaces: {
                            top: null,
                            left: null,
                            center: null,
                            right: null,
                            bottom: null,
                        },
                        threeD: null,
                        lastSelectedSurface: null,
                    };

                    if (entry.status && entry.status.code) {
                        cleanEntry.status = entry.status;
                    }

                    if (entry.threeD && entry.threeD.code) {
                        cleanEntry.threeD = entry.threeD;
                    }

                    const surfaces = entry.surfaces || {};

                    ['top', 'left', 'center', 'right', 'bottom'].forEach(function (surfaceKey) {
                        if (surfaces[surfaceKey] && surfaces[surfaceKey].code) {
                            cleanEntry.surfaces[surfaceKey] = surfaces[surfaceKey];
                        }
                    });

                    const savedSurfaceKey =
                        ['top', 'left', 'center', 'right', 'bottom'].includes(entry.lastSelectedSurface)
                            ? entry.lastSelectedSurface
                            : null;

                    cleanEntry.lastSelectedSurface =
                        savedSurfaceKey && cleanEntry.surfaces[savedSurfaceKey]
                            ? savedSurfaceKey
                            : getFirstTreatedSurfaceKey(cleanEntry);

                    if (!cleanEntry.threeD) {
                        cleanEntry.threeD = getPreferredToothVisual(cleanEntry);
                    }

                    const hasTreatment =
                        (cleanEntry.status && cleanEntry.status.code) ||
                        (cleanEntry.threeD && cleanEntry.threeD.code) ||
                        Object.values(cleanEntry.surfaces).some(function (surface) {
                            return surface && surface.code;
                        });

                    return hasTreatment ? cleanEntry : null;
                })
                .filter(Boolean);
        }

        async function saveProcedure(completionAction, clickedButton, loadingText) {
            const originalButtonHtml = clickedButton.innerHTML;

            updateHiddenInput();
            const cleanOdontogramData = getCleanOdontogramDataForSave();
            const hasAnySavedTreatment = cleanOdontogramData.length > 0;

            if (!isOralProphylaxis && !hasAppliedTreatmentThisSession && !(savedVisitEditMode && hasAnySavedTreatment)) {
                showProcedureToast(
                    'Apply at least one treatment to the tooth chart before finishing the procedure.',
                    'warning',
                    'Treatment Required'
                );

                return;
            }

            if (!isOralProphylaxis && cleanOdontogramData.length === 0) {
                showProcedureToast(
                    'Apply at least one treatment to the tooth chart before finishing the procedure.',
                    'warning',
                    'Treatment Required'
                );

                return;
            }

            const payload = {
                odontogram_data: cleanOdontogramData,
                oral_examination: document.getElementById('oralExaminationNotes').value,
                diagnosis: document.getElementById('diagnosisNotes').value,
                prescriptions: document.getElementById('prescriptionsNotes').value,
                completion_action: completionAction,
                has_applied_treatment: isOralProphylaxis || hasAppliedTreatmentThisSession,
                procedure_duration_seconds: (existingAppointmentMode || savedVisitEditMode)
                    ? 0
                    : Math.max(0, Math.floor((Date.now() - procedureStartTimestamp) / 1000)),
            };

            finishProcedureBtn.disabled = true;
            if (followUpBtn) {
                followUpBtn.disabled = true;
            }

            clickedButton.innerHTML = `<i class="fa-solid fa-circle-notch fa-spin"></i> ${loadingText}`;

            try {
                const response = await fetch(saveProcedureUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': @json(csrf_token()),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                const result = await response.json();

                if (!response.ok) {
                    console.error(result);
                    showProcedureToast(
                        result.message ||
                        'Failed to save procedure. Please check your inputs and try again.',
                        'error'
                    );
                    return;
                }

                if (completionAction === 'finished') {
                    openFinishProcedureModal({
                        title: existingAppointmentMode
                            ? 'Existing Appointment Saved!'
                            : (savedVisitEditMode ? 'Odontogram Updated!' : 'Procedure Completed!'),
                        message: existingAppointmentMode
                            ? 'The existing appointment, notes, duration, and odontogram were saved successfully.'
                            : (savedVisitEditMode
                                ? 'The saved 2D/3D odontogram and clinical notes were updated successfully.'
                                : 'The odontogram and procedure notes were saved successfully. This appointment has been marked as completed.'),
                        icon: 'fa-clipboard-check',
                        buttonText: (existingAppointmentMode || savedVisitEditMode) ? 'Back to Patient Profile' : 'Back to Appointments',
                        redirectUrl: result.redirect_url || null,
                    });
                } else {
                    showProcedureToast(result.message || 'Procedure completed successfully.', 'success');

                    if (result.redirect_url) {
                        setTimeout(() => {
                            window.location.href = result.redirect_url;
                        }, 900);
                    }
                }

            } catch (error) {
                console.error(error);
                showProcedureToast('Something went wrong while saving the procedure.', 'error');
            } finally {
                finishProcedureBtn.disabled = false;
                if (followUpBtn) {
                    followUpBtn.disabled = false;
                }
                clickedButton.innerHTML = originalButtonHtml;
            }
        }

        finishProcedureBtn.addEventListener('click', function () {
            updateHiddenInput();
            const cleanOdontogramData = getCleanOdontogramDataForSave();
            const hasAnySavedTreatment = cleanOdontogramData.length > 0;

            if (!isOralProphylaxis &&
                (
                    (!hasAppliedTreatmentThisSession && !(savedVisitEditMode && hasAnySavedTreatment)) ||
                    cleanOdontogramData.length === 0
                )
            ) {
                openFinishProcedureModal({
                    title: 'Treatment Required',
                    message:
                        'Select a tooth surface and apply at least one treatment before completing this procedure.',
                    icon: 'fa-tooth',
                    buttonText: 'Back to Odontogram',
                });
                return;
            }

            openFinishProcedureModal({
                title: existingAppointmentMode
                    ? 'Save Existing Appointment?'
                    : (savedVisitEditMode ? 'Save Odontogram Changes?' : 'Finish Procedure?'),

                message: existingAppointmentMode
                    ? 'Are you sure you want to save this existing appointment? The old visit details, odontogram, and notes will be stored as a completed appointment.'
                    : (savedVisitEditMode
                        ? 'Are you sure you want to update this saved visit? The saved 2D/3D odontogram and procedure notes will be replaced with your latest edits.'
                        : 'Are you sure you want to finish this procedure? The odontogram and procedure notes will be saved, and this appointment will be marked as completed.'),

                icon: 'fa-circle-question',
                confirmation: true,
            });
        });

        confirmFinishProcedureBtn.addEventListener('click', function () {
            closeFinishProcedureModal();
            saveProcedure('finished', finishProcedureBtn, 'Saving Procedure...');
        });

        dismissFinishProcedureBtn.addEventListener('click', closeFinishProcedureModal);
        finishProcedureModalActionBtn.addEventListener('click', closeFinishProcedureModal);

        finishProcedureModal.addEventListener('click', function (event) {
            if (event.target === finishProcedureModal) {
                closeFinishProcedureModal();
            }
        });

        followUpBtn?.addEventListener('click', function () {
            openFollowUpModal();
        });

        closeFollowUpModalBtn?.addEventListener(
            'click',
            closeFollowUpModal
        );

        cancelFollowUpModalBtn?.addEventListener(
            'click',
            closeFollowUpModal
        );

        document.getElementById('followUpModal')?.addEventListener('click', function (event) {
            if (event.target === event.currentTarget) {
                closeFollowUpModal();
            }
        });

        document.getElementById('followUpForm')?.addEventListener('submit', async function (event) {
            event.preventDefault();

            const form = event.currentTarget;
            const dateInput = document.getElementById('followup_appointment_date');
            const timeInput = document.getElementById('followup_appointment_time');
            const reasonInput = document.getElementById('followup_reason');
            const confirmBtn = document.getElementById('confirmFollowUpBtn');

            let valid = true;

            const dateGroup =
                document.getElementById(
                    'followUpCalendarWrap'
                );

            const timeGroup =
                document.getElementById(
                    'followUpTimeWrap'
                );

            if (!dateInput?.value) {
                window.showGlobalGroupError?.(
                    dateGroup,
                    'followup_appointment_date',
                    'Select a follow-up date.'
                );

                valid = false;
            } else {
                window.clearGlobalGroupError?.(
                    dateGroup,
                    'followup_appointment_date'
                );
            }

            if (!timeInput?.value) {
                window.showGlobalGroupError?.(
                    timeGroup,
                    'followup_appointment_time',
                    'Select a follow-up time.'
                );

                valid = false;
            } else {
                window.clearGlobalGroupError?.(
                    timeGroup,
                    'followup_appointment_time'
                );
            }

            if (!valid) {
                return;
            }

            const originalBtnHtml = confirmBtn.innerHTML;
            confirmBtn.disabled = true;
            confirmBtn.innerHTML =
                '<i class="fa-solid fa-circle-notch fa-spin mr-1"></i> Saving...';

            try {
                const followUpResponse = await fetch(storeFollowUpUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': @json(csrf_token()),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: new FormData(form),
                });

                const followUpResult = await followUpResponse.json().catch(() => null);

                if (!followUpResponse.ok) {
                    showProcedureToast(followUpResult?.message || 'Failed to schedule follow-up appointment.', 'error');
                    confirmBtn.disabled = false;
                    confirmBtn.innerHTML = originalBtnHtml;
                    return;
                }

                await saveProcedure('follow_up', confirmBtn, 'Saving Procedure...');

            } catch (error) {
                console.error(error);
                showProcedureToast('Something went wrong while scheduling the follow-up appointment.', 'error');
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = originalBtnHtml;
            }
        });

        if (clearSelectionBtn) {
            clearSelectionBtn.addEventListener('click', clearCurrentSelection);
        }

        if (undoBtn) {
            undoBtn.addEventListener('click', undoLastAction);
        }

        if (redoBtn) {
            redoBtn.addEventListener('click', redoLastAction);
        }

        function handleHistoryKeyboardShortcuts(event) {
            const isTyping =
                event.target &&
                (
                    event.target.tagName === 'INPUT' ||
                    event.target.tagName === 'TEXTAREA' ||
                    event.target.isContentEditable
                );

            if (isTyping) return;

            const key = event.key.toLowerCase();
            const isCtrlOrCmd = event.ctrlKey || event.metaKey;

            if (!isCtrlOrCmd) return;

            if (key === 'z' && !event.shiftKey) {
                event.preventDefault();
                undoLastAction();
                return;
            }

            if (key === 'y' || (key === 'z' && event.shiftKey)) {
                event.preventDefault();
                redoLastAction();
            }
        }

        if (cancelProcedureBtn) {
            cancelProcedureBtn.addEventListener('click', openCancelProcedureModal);
        }

        if (dismissCancelProcedureBtn) {
            dismissCancelProcedureBtn.addEventListener('click', closeCancelProcedureModal);
        }

        if (confirmCancelProcedureBtn) {
            confirmCancelProcedureBtn.addEventListener('click', function () {
                window.location.href = cancelProcedureRedirectUrl;
            });
        }

        if (cancelProcedureModal) {
            cancelProcedureModal.addEventListener('click', function (event) {
                if (event.target === cancelProcedureModal) {
                    closeCancelProcedureModal();
                }
            });
        }

        function initLegendPanelResize() {
            if (!odontogramDockLayout || !legendResizeHandle || !legendDrawer) {
                return;
            }

            const MIN_WIDTH = 320;
            const MAX_WIDTH = 560;
            const MIN_MAIN_WIDTH = 680;

            let resizing = false;

            function stopResize() {
                if (!resizing) return;

                resizing = false;

                legendResizeHandle.classList.remove('is-resizing');
                document.body.classList.remove('odontogram-resizing');

                document.removeEventListener('pointermove', handleResizeMove);
                document.removeEventListener('pointerup', stopResize);
                document.removeEventListener('pointercancel', stopResize);

                handleResize();
            }

            function handleResizeMove(event) {
                if (!resizing) return;

                const layoutRect = odontogramDockLayout.getBoundingClientRect();

                let nextWidth = layoutRect.right - event.clientX;

                const availableMaxWidth = Math.max(
                    MIN_WIDTH,
                    layoutRect.width - MIN_MAIN_WIDTH
                );

                nextWidth = Math.min(
                    nextWidth,
                    MAX_WIDTH,
                    availableMaxWidth
                );

                nextWidth = Math.max(
                    MIN_WIDTH,
                    nextWidth
                );

                odontogramDockLayout.style.setProperty(
                    '--legend-panel-width',
                    `${nextWidth}px`
                );

                localStorage.setItem(
                    'odontogramLegendPanelWidth',
                    String(nextWidth)
                );

                handleResize();
            }

            const savedWidth = Number(
                localStorage.getItem('odontogramLegendPanelWidth')
            );

            if (Number.isFinite(savedWidth)) {
                const safeSavedWidth = Math.min(
                    MAX_WIDTH,
                    Math.max(MIN_WIDTH, savedWidth)
                );

                odontogramDockLayout.style.setProperty(
                    '--legend-panel-width',
                    `${safeSavedWidth}px`
                );
            }

            legendResizeHandle.addEventListener('pointerdown', function (event) {
                if (window.innerWidth <= 900) {
                    return;
                }

                event.preventDefault();

                resizing = true;

                legendResizeHandle.classList.add('is-resizing');
                document.body.classList.add('odontogram-resizing');

                legendResizeHandle.setPointerCapture?.(event.pointerId);

                document.addEventListener('pointermove', handleResizeMove);
                document.addEventListener('pointerup', stopResize);
                document.addEventListener('pointercancel', stopResize);
            });
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeResetModal();
                closeCancelProcedureModal();
                closeFinishProcedureModal();
                closeFollowUpModal();

                if (currentView === '3d' && selectedTooth) {
                    clear3DSurfacePickerSelection(false);
                }
            }
        });

        surfacePickerButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                selectSurfaceFrom3DPicker(button.dataset.surface);
            });
        });

        if (reset3DViewBtn) {
            reset3DViewBtn.addEventListener('click', function () {
                clear3DSurfacePickerSelection(true);
            });
        }

        if (close3DSurfacePickerBtn) {
            close3DSurfacePickerBtn.addEventListener('click', function () {
                clear3DSurfacePickerSelection(false);
            });
        }

        initLegendPanelResize();

        if (existingAppointmentMode || savedVisitEditMode) {
            procedureTimer.textContent = existingProcedureDuration || '00:00:00';
        } else {
            updateProcedureTimer();
            setInterval(updateProcedureTimer, 1000);
        }

        renderLegendButtons('');
        updateHiddenInput();
        render2DOdontogram();
        updateSelectedToothUI();
        updateHistoryButtons();

        document.addEventListener('keydown', handleHistoryKeyboardShortcuts);
    });
</script>
@endsection
