@php
    $layoutRole =
        trim($__env->yieldContent('layout-role')) ?:
        optional(optional(auth()->user())->role)->slug ?? (session('role') ?? 'patient');

    if ($layoutRole === 'super_admin') {
        $layoutRole = 'admin';
    }

    $isAdmin = $layoutRole === 'admin';
    $isDentist = $layoutRole === 'dentist';
    $isPatient = $layoutRole === 'patient';

    $hideSidebar = View::hasSection('hide-sidebar');
    $hideMobileNav = View::hasSection('hide-mobile-nav');
    $hidePatientModals = View::hasSection('hide-patient-modals');

    $showMobileMenu = ($isAdmin || $isDentist) && !$hideSidebar;
    $showSettings = $isAdmin;

    $accessibilityOffset = $isPatient && !$hideMobileNav ? '18,118' : '18,24';
@endphp

<!DOCTYPE html>
<html lang="en" data-theme="{{ session('theme', 'light') }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @if (auth()->check())
        <meta name="auth-user-id" content="{{ auth()->id() }}">
    @endif

    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'light';
            const role = @json($layoutRole);

            document.documentElement.setAttribute('data-theme', theme);
            document.documentElement.classList.toggle('dark', theme === 'dark');
            document.documentElement.style.backgroundColor =
                theme === 'dark' ? '#000D1A' : '#F4F4F4';

            const sidebarKeys = {
                admin: 'adminSidebarCollapsed',
                dentist: 'dentistSidebarCollapsed',
                patient: 'patientSidebarCollapsed'
            };

            document.documentElement.classList.add('sidebar-preload');

            try {
                if (localStorage.getItem(sidebarKeys[role]) === '1') {
                    document.documentElement.classList.add(
                        'sidebar-collapsed-init'
                    );
                }
            } catch (error) {}
        })();
    </script>

    <title>
        @hasSection('title')
            @yield('title') | PUP Taguig Dental Clinic
        @else
            PUP Taguig Dental Clinic
        @endif
    </title>

    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('css/header.css') }}">

    <script src="{{ asset('js/header.js') }}?v={{ filemtime(public_path('js/header.js')) }}" defer></script>

    @yield('styles')
    @stack('styles')
</head>

<body
    class="
        role-{{ $layoutRole }}
        {{ $hideSidebar ? 'layout-no-sidebar' : '' }}
        {{ $hideMobileNav ? 'layout-no-mobile-nav' : '' }}
        @yield('body-class', 'bg-[#F4F4F4]')">

    @include('partials.header', [
        'role' => $layoutRole,
        'patient' => $patient ?? null,
        'notifications' => $notifications ?? [],
        'showMobileMenu' => $showMobileMenu,
        'showSettings' => $showSettings,
    ])

    @if (!$hideSidebar)
        @include('components.global-sidebar', [
            'role' => $layoutRole,
        ])
    @endif

    @if ($isPatient && !$hideMobileNav)
        @include('partials.patient.mobile-nav')
    @endif

    @if ($isPatient && !$hidePatientModals)
        @include('components.patient-document-modals')
        @include('components.patient-record-modal')
    @endif

    @if ($isPatient)
        @include('partials.impersonation-banner')
    @endif

    @if ($isDentist)
        @include('partials.impersonation-banner')
        @include('components.reschedule-modal')
        @include('components.cancel-modal')
        @include('components.patient-record-modal')
    @endif

    @if ($isAdmin)
        @include('components.patient-record-modal')
    @endif

    @yield('content')

    @include('partials.footer')

    @include('partials.voice-logic')

    @if ($isAdmin || $isDentist)
        @include('components.discard-changes')
    @endif

    @include('partials.global-toast')
    @include('partials.terms-modal')
    @include('partials.inactivity-logout')

    @if ($isDentist && View::hasSection('usesAppointmentCalendar'))
        @include('components.appointment-calendar-script', [
            'mode' => 'booking',
            'calendarContainerId' => 'calGridWrapReschedule',
            'calGridId' => 'calGrid',
            'calMonthLabelId' => 'calMonthLabel',
            'calYearLabelId' => 'calYearLabel',
            'dateInputId' => 'new_appointment_date',
            'timeInputId' => 'new_appointment_time',
            'dateBannerId' => 'dateBanner',
            'slotPlaceholderId' => 'slotPlaceholder',
            'slotContainerId' => 'slotContainer',
            'slotGridId' => 'slotGrid',
            'selectedSlotDisplayId' => 'selectedSlotDisplay',
            'selectedSlotTextId' => 'selectedSlotText',
            'selectedTimePillId' => 'selectedTimePill',
            'selectedTimeTextId' => 'selectedTimeText',
            'datePillId' => 'datePill',
            'dateErrorId' => 'dateError',
            'timeErrorId' => 'timeError',
            'calendarWrapSelector' => '#rescheduleModal .cal-wrap',
            'slotsWrapSelector' => '#rescheduleModal .slots-wrap',
            'slotEndpoint' => route('dentist.appointment.slots'),
        
            'scheduleRules' => isset($schedules)
                ? $schedules
                : (isset($scheduleRules)
                    ? $scheduleRules
                    : \App\Models\ClinicSchedule::active()->get()->values()->toArray()),
        
            'blockedDates' => $blockedDates ?? [],
            'appointmentCountsPerDay' => $appointmentCountsPerDay ?? [],
            'philippineHolidays' => $philippineHolidays ?? [],
        
            'disallowToday' => true,
            'allowToggleOffDate' => true,
            'useDynamicScheduleRules' => true,
            'renderStyle' => 'dentist',
        ])
    @endif

    @if ($isPatient && !$hideMobileNav && !$hidePatientModals)
        <script>
            function openQuickAction(type) {
                if (type === 'record') {
                    document
                        .getElementById('dentalHealthRecordModal')
                        ?.showModal();
                }

                if (type === 'clearance') {
                    document
                        .getElementById('dentalClearanceModal')
                        ?.showModal();
                }
            }
        </script>
    @endif

    <div id="globalActionTooltip" class="global-action-tooltip" role="tooltip" aria-hidden="true">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sienna-accessibility@latest/dist/sienna-accessibility.umd.js"
        data-position="bottom-right" data-offset="{{ $accessibilityOffset }}" defer></script>

    @include('partials.chatbot')

    @stack('scripts')
    @yield('scripts')
</body>

</html>
