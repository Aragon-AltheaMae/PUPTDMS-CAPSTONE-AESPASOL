@extends('layouts.dentist')

@section('title', 'Dental Services Record | PUP Taguig Dental Clinic')

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
            min-height: 96px;
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
            gap: 12px;
            margin-bottom: 16px;
            flex-wrap: wrap;
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

        .period-input {
            font-size: 0.75rem;
            font-weight: 600;
            color: #1e293b;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 99px;
            padding: 6px 12px;
            cursor: pointer;
            outline: none;
            transition: all .2s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .period-input:hover {
            border-color: #94a3b8;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .period-input:focus {
            border-color: #8B0000;
            box-shadow: 0 0 0 2px rgba(139, 0, 0, 0.1);
        }

        .toolbar-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .search-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #F9FAFB;
            border: 1px solid #E5E7EB;
            border-radius: 999px;
            padding: 8px 14px;
            min-width: 260px;
            transition: all .2s ease;
        }

        .search-wrap:focus-within {
            border-color: #8B0000;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.08);
            background: white;
        }

        .search-wrap i {
            color: #9CA3AF;
            font-size: 12px;
        }

        .search-wrap input {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
            font-size: 12px;
            color: #111827;
        }

        .search-wrap input::placeholder {
            color: #9CA3AF;
        }

        .toolbar-btn {
            border: 1px solid #E5E7EB;
            background: white;
            color: #374151;
            border-radius: 12px;
            padding: 8px 14px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
            transition: all .2s ease;
        }

        .toolbar-btn:hover {
            border-color: #8B0000;
            color: #8B0000;
            background: #fffafa;
        }

        .toolbar-btn.active {
            background: #8B0000;
            color: white;
            border-color: #8B0000;
        }

        .clear-btn {
            background: transparent;
            border: none;
            color: #9CA3AF;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            padding: 8px 4px;
            transition: color .2s ease;
        }

        .clear-btn:hover {
            color: #8B0000;
        }

        .table-wrap {
            overflow-x: auto;
            border-radius: 14px;
            border: 1px solid #F3F4F6;
        }

        .records-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1200px;
        }

        .records-table thead tr {
            background: linear-gradient(135deg, #7a0000 0%, #8B0000 100%);
        }

        .records-table th {
            color: rgba(255, 255, 255, 0.92);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.06em;
            padding: 12px 10px;
            text-align: center;
            white-space: nowrap;
        }

        .records-table th:first-child,
        .records-table td:first-child {
            padding-left: 18px;
            text-align: left;
        }

        .records-table tbody tr {
            border-bottom: 1px solid #F3F4F6;
            transition: background .15s ease;
        }

        .records-table tbody tr:hover {
            background: #fcfcfd;
        }

        .records-table td {
            padding: 10px;
            text-align: center;
            font-size: 12px;
            color: #374151;
            vertical-align: middle;
        }

        .name-cell {
            text-align: left !important;
            font-weight: 700;
            color: #111827 !important;
            white-space: nowrap;
        }

        .muted-cell {
            color: #6B7280 !important;
            font-size: 11px !important;
        }

        /* .program-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 999px;
            background: #FEF2F2;
            color: #8B0000;
            font-size: 10px;
            font-weight: 700;
            border: 1px solid #FECACA;
            white-space: nowrap;
        } */

          .records-table td:nth-child(4) {
            color: #374151;
            font-weight: 600;
            letter-spacing: 0.2px;
          }
        .check-mark {
            width: 20px;
            height: 20px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 900;
            background: #FEE2E2;
            color: #8B0000;
        }

        .check-gold {
            background: #FEF3C7;
            color: #B45309;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 56px 20px;
            text-align: center;
            color: #9CA3AF;
        }

        .empty-state i {
            font-size: 2.2rem;
            color: #E5E7EB;
            margin-bottom: 10px;
        }

        .empty-state p {
            font-size: 0.9rem;
            font-weight: 700;
            color: #6B7280;
            margin-bottom: 4px;
        }

        .empty-state span {
            font-size: 0.75rem;
            color: #9CA3AF;
        }

        .filter-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 190;
            background: rgba(0, 0, 0, .35);
            backdrop-filter: blur(2px);
        }

        .filter-overlay.open {
            display: block;
        }

        .filter-panel {
            position: fixed;
            bottom: 0;
            left: 0;
            top: auto;
            right: auto;
            width: 100%;
            height: 85vh;
            max-width: none;
            background: #fff;
            border-radius: 24px 24px 0 0;
            box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            transform: translateY(100%);
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 200;
        }

        .filter-panel.open {
            transform: translateY(0);
        }

        @media (min-width: 768px) {
            .filter-panel {
                top: 0;
                right: 0;
                bottom: 0;
                left: auto;
                width: 360px;
                height: 100vh;
                border-radius: 24px 0 0 24px;
                transform: translateX(100%);
            }

            .filter-panel.open {
                transform: translateX(0);
            }
        }

        .fp-header {
            padding: 18px 24px;
            border-bottom: 1px solid #EDE9E4;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .fp-title {
            font-size: 16px;
            font-weight: 700;
            color: #8B0000;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .fp-close-btn {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            border: 1.5px solid #E8E4DE;
            background: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9A9490;
            font-size: 15px;
            transition: all .2s;
        }

        .fp-close-btn:hover {
            border-color: #8B0000;
            color: #8B0000;
            background: #FFF8F8;
        }

        .fp-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px 24px;
        }

        .fp-section {
            margin-bottom: 22px;
        }

        .fp-section-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: #9A9490;
            margin-bottom: 10px;
        }

        .fp-radio-item {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 8px;
            transition: background .15s;
            margin-bottom: 2px;
        }

        .fp-radio-item:hover {
            background: #FFF5F5;
        }

        .fp-radio-item input[type="radio"],
        .fp-radio-item input[type="checkbox"] {
            accent-color: #8B0000;
            width: 16px;
            height: 16px;
        }

        .fp-radio-item label,
        .fp-radio-item span {
            font-size: 13px;
            color: #333;
            cursor: pointer;
        }

        .fp-date-row {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .fp-date-group {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .fp-date-label {
            font-size: 11px;
            color: #9A9490;
            font-weight: 600;
        }

        .fp-date-input {
            height: 44px;
            padding: 0 12px;
            border: 1.5px solid #E0DDD8;
            border-radius: 12px;
            font-size: 12px;
            outline: none;
            transition: border-color .2s;
            background: #FFFFFF;
            color: #333;
        }

        .fp-date-input:focus {
            border-color: #8B0000;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, .08);
        }

        .fp-footer {
            padding: 14px 24px;
            border-top: 1px solid #EDE9E4;
            display: flex;
            gap: 10px;
        }

        .fp-btn-clear {
            flex: 1;
            height: 44px;
            border-radius: 14px;
            border: 1.5px solid #E0DDD8;
            background: #fff;
            font-size: 13px;
            font-weight: 700;
            color: #8B0000;
            cursor: pointer;
            transition: all .2s;
        }

        .fp-btn-clear:hover {
            background: #FFF8F8;
        }

        .fp-btn-apply {
            flex: 2;
            height: 44px;
            border-radius: 14px;
            border: none;
            background: #8B0000;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            box-shadow: 0 3px 10px rgba(139, 0, 0, .3);
        }

        .fp-btn-apply:hover {
            background: #660000;
        }

        .filter-label {
            font-size: 11px;
            font-weight: 800;
            color: #8B0000;
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #E5E7EB;
        }

        .filter-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .radio-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 999px;
            border: 1px solid #E5E7EB;
            font-size: 12px;
            color: #4B5563;
            cursor: pointer;
            transition: all .15s ease;
            user-select: none;
            white-space: nowrap;
            background: white;
            font-weight: 700;
        }

        .radio-chip:hover {
            border-color: #8B0000;
            color: #8B0000;
        }

        .radio-chip input {
            display: none;
        }

        .radio-chip.selected {
            background: #8B0000;
            border-color: #8B0000;
            color: white;
        }

        .radio-chip.disabled-chip {
            opacity: .35;
            pointer-events: none;
        }

        .toast {
            position: fixed;
            top: 24px;
            right: 24px;
            background: #166534;
            color: white;
            padding: 12px 18px;
            border-radius: 14px;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .18);
            display: flex;
            align-items: center;
            gap: 8px;
            transform: translateY(-14px);
            opacity: 0;
            pointer-events: none;
            transition: all .25s ease;
            z-index: 80;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        @media (max-width: 1024px) {
            .kpi-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 767px) {
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

            .header-actions-container button,
            .header-actions-container input {
                width: 100% !important;
            }

            .toolbar-wrap {
                width: 100%;
                flex-direction: column;
                align-items: stretch;
            }

            .search-wrap {
                width: 100%;
                min-width: 0;
            }

            .grid.grid-cols-2 {
                gap: 10px !important;
            }

            .kpi-card {
                padding: 12px 10px !important;
                gap: 10px !important;
                flex-direction: row !important;
                align-items: center !important;
                min-height: auto;
            }

            .kpi-icon {
                width: 36px !important;
                height: 36px !important;
                font-size: 14px !important;
                border-radius: 8px !important;
            }

            .kpi-value {
                font-size: 1.25rem !important;
                margin-bottom: 2px !important;
            }

            .kpi-label {
                font-size: 0.6rem !important;
                line-height: 1.2 !important;
            }

            .modal-box-custom {
                width: 100%;
            }

            .modal-footer-custom {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $records = $records ?? [
            [
                'date' => '12/01/25',
                'timeIn' => '08:30 AM',
                'name' => 'Dela Cruz, Juan M.',
                'program' => 'BSIT 3-1',
                'age' => 21,
                'gad' => ['gender' => 'Male', 'priority' => ['PWD']],
                'email' => 'juan@gmail.com',
                'contact' => '0917-123-4567',
                'timeOut' => '09:00 AM',
                'duration' => '30 mins',
                'type' => 'Non-Emergency',
                'department' => 'Student',
            ],
            [
                'date' => '12/01/25',
                'timeIn' => '09:10 AM',
                'name' => 'Santos, Maria L.',
                'program' => 'Faculty',
                'age' => 45,
                'gad' => ['gender' => 'Female', 'priority' => []],
                'email' => 'maria@gmail.com',
                'contact' => '0998-456-7890',
                'timeOut' => '10:00 AM',
                'duration' => '50 mins',
                'type' => 'Emergency',
                'department' => 'Faculty',
            ],
            [
                'date' => '12/02/25',
                'timeIn' => '08:45 AM',
                'name' => 'Reyes, Paul A.',
                'program' => 'Administrative',
                'age' => 38,
                'gad' => ['gender' => 'Male', 'priority' => []],
                'email' => 'paul@gmail.com',
                'contact' => '0920-888-1234',
                'timeOut' => '09:15 AM',
                'duration' => '30 mins',
                'type' => 'Non-Emergency',
                'department' => 'Administrative',
            ],
            [
                'date' => '12/02/25',
                'timeIn' => '10:30 AM',
                'name' => 'Lopez, Ana C.',
                'program' => 'BSBA - HRM 2-2',
                'age' => 20,
                'gad' => ['gender' => 'Female', 'priority' => []],
                'email' => 'ana@gmail.com',
                'contact' => '0916-555-7891',
                'timeOut' => '11:05 AM',
                'duration' => '35 mins',
                'type' => 'Non-Emergency',
                'department' => 'Student',
            ],
            [
                'date' => '12/03/25',
                'timeIn' => '09:00 AM',
                'name' => 'Torres, Elaine C.',
                'program' => 'Dependent',
                'age' => 62,
                'gad' => ['gender' => 'Female', 'priority' => ['Senior']],
                'email' => 'elaine@gmail.com',
                'contact' => '0999-332-4488',
                'timeOut' => '09:50 AM',
                'duration' => '50 mins',
                'type' => 'Non-Emergency',
                'department' => 'Dependent',
            ],
            [
                'date' => '12/03/25',
                'timeIn' => '10:40 AM',
                'name' => 'Castillo, Brian R.',
                'program' => 'BSECE 2-2',
                'age' => 20,
                'gad' => ['gender' => 'Male', 'priority' => ['PWD']],
                'email' => 'brian@gmail.com',
                'contact' => '0908-777-5566',
                'timeOut' => '11:15 AM',
                'duration' => '35 mins',
                'type' => 'Non-Emergency',
                'department' => 'Student',
            ],
            [
                'date' => '12/04/25',
                'timeIn' => '08:20 AM',
                'name' => 'Mendoza, Joshua P.',
                'program' => 'BSPSYCH 3-1',
                'age' => 21,
                'gad' => ['gender' => 'Male', 'priority' => []],
                'email' => 'josh@gmail.com',
                'contact' => '0917-889-3342',
                'timeOut' => '08:50 AM',
                'duration' => '30 mins',
                'type' => 'Non-Emergency',
                'department' => 'Student',
            ],
            [
                'date' => '12/04/25',
                'timeIn' => '09:45 AM',
                'name' => 'Navarro, Rhea T.',
                'program' => 'Faculty',
                'age' => 41,
                'gad' => ['gender' => 'Female', 'priority' => []],
                'email' => 'rhea@gmail.com',
                'contact' => '0995-441-2098',
                'timeOut' => '10:30 AM',
                'duration' => '45 mins',
                'type' => 'Emergency',
                'department' => 'Faculty',
            ],
            [
                'date' => '12/05/25',
                'timeIn' => '08:10 AM',
                'name' => 'Cruz, Daniel S.',
                'program' => 'BSIT 4-1',
                'age' => 22,
                'gad' => ['gender' => 'Male', 'priority' => []],
                'email' => 'daniel@gmail.com',
                'contact' => '0928-334-8899',
                'timeOut' => '08:40 AM',
                'duration' => '30 mins',
                'type' => 'Non-Emergency',
                'department' => 'Student',
            ],
            [
                'date' => '12/05/25',
                'timeIn' => '09:30 AM',
                'name' => 'Ramos, Angela D.',
                'program' => 'BSED - ENG 2-1',
                'age' => 19,
                'gad' => ['gender' => 'Female', 'priority' => []],
                'email' => 'angela@gmail.com',
                'contact' => '0915-223-7781',
                'timeOut' => '10:00 AM',
                'duration' => '30 mins',
                'type' => 'Non-Emergency',
                'department' => 'Student',
            ],
            [
                'date' => '12/06/25',
                'timeIn' => '10:15 AM',
                'name' => 'Tan, Michael K.',
                'program' => 'Administrative',
                'age' => 36,
                'gad' => ['gender' => 'Male', 'priority' => []],
                'email' => 'mike@gmail.com',
                'contact' => '0991-667-9900',
                'timeOut' => '10:55 AM',
                'duration' => '40 mins',
                'type' => 'Non-Emergency',
                'department' => 'Administrative',
            ],
            [
                'date' => '12/06/25',
                'timeIn' => '01:20 PM',
                'name' => 'Lim, Samantha J.',
                'program' => 'DOMT 1-2',
                'age' => 18,
                'gad' => ['gender' => 'Female', 'priority' => []],
                'email' => 'sam@gmail.com',
                'contact' => '0922-889-4455',
                'timeOut' => '01:45 PM',
                'duration' => '25 mins',
                'type' => 'Non-Emergency',
                'department' => 'Student',
            ],
            [
                'date' => '12/07/25',
                'timeIn' => '08:40 AM',
                'name' => 'Bautista, Kevin A.',
                'program' => 'BSME 3-1',
                'age' => 21,
                'gad' => ['gender' => 'Male', 'priority' => []],
                'email' => 'kevin@gmail.com',
                'contact' => '0919-556-1123',
                'timeOut' => '09:10 AM',
                'duration' => '30 mins',
                'type' => 'Non-Emergency',
                'department' => 'Student',
            ],
            [
                'date' => '12/07/25',
                'timeIn' => '10:05 AM',
                'name' => 'Flores, Christine M.',
                'program' => 'BSBA - MM 4-1',
                'age' => 22,
                'gad' => ['gender' => 'Female', 'priority' => []],
                'email' => 'cflores@gmail.com',
                'contact' => '0918-774-9921',
                'timeOut' => '10:50 AM',
                'duration' => '45 mins',
                'type' => 'Non-Emergency',
                'department' => 'Student',
            ],
            [
                'date' => '12/09/25',
                'timeIn' => '08:25 AM',
                'name' => 'Perez, John R.',
                'program' => 'BSIT 2-1',
                'age' => 19,
                'gad' => ['gender' => 'Male', 'priority' => []],
                'email' => 'john@gmail.com',
                'contact' => '0927-888-1122',
                'timeOut' => '08:55 AM',
                'duration' => '30 mins',
                'type' => 'Non-Emergency',
                'department' => 'Student',
            ],
        ];
    @endphp

    <main id="mainContent" class="pt-[90px] px-3 md:px-6 py-6 fade-in min-h-screen flex-1">
        <div class="w-full fade-in">

            <div class="page-title-row flex items-start md:items-center justify-between mb-8">
                <div>
                    <h2 class="text-xl md:text-2xl font-extrabold text-[#8B0000] tracking-tight leading-none mb-1.5">
                        Dental Services Record
                    </h2>
                    <p class="text-[12px] text-gray-500 font-medium">
                        View, filter, and export dental service records.
                    </p>
                </div>

                <div class="header-actions-container flex flex-col items-end gap-2 mt-3 md:mt-0">
                    <div class="flex items-center gap-2 flex-wrap justify-end">
                        <input type="month" id="monthPicker" class="period-input">
                        <button onclick="document.getElementById('createReportModal').showModal()"
                            class="bg-[#8B0000] hover:bg-[#6b0000] text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-sm transition-all flex items-center gap-2">
                            <i class="fa-solid fa-plus"></i> Create Report
                        </button>
                    </div>
                    <span class="text-[11px] text-gray-400 font-medium">
                        <i class="fa-regular fa-clock mr-1"></i> Last updated: {{ now()->format('M d, Y h:i A') }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-5 mb-8 kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-icon bg-red-50">
                        <i class="fa-solid fa-file-lines text-[#8B0000]"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="kpi-value" id="statTotal">0</div>
                        <div class="kpi-label">Total Records</div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon bg-amber-50">
                        <i class="fa-solid fa-triangle-exclamation text-amber-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="kpi-value text-amber-600" id="statEmergency">0</div>
                        <div class="kpi-label">Emergency</div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon bg-green-50">
                        <i class="fa-solid fa-circle-check text-green-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="kpi-value text-green-600" id="statNonEmergency">0</div>
                        <div class="kpi-label">Non-Emergency</div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon bg-blue-50">
                        <i class="fa-solid fa-venus text-blue-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="kpi-value text-blue-600" id="statFemale">0</div>
                        <div class="kpi-label">Female Patients</div>
                    </div>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-card-header">
                    <span class="chart-title">
                        <i class="fa-solid fa-table-list"></i> Patient Records
                    </span>

                    <div class="toolbar-wrap">
                        <div class="search-wrap">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input id="searchInput" type="text" placeholder="Search name, program, contact…">
                        </div>

                        <button class="toolbar-btn" id="openFilter" type="button" onclick="openFilterPanel()">
                            <i class="fa-solid fa-sliders"></i> Filter
                        </button>

                        <button class="clear-btn" id="clearBtn" type="button">Clear</button>
                    </div>
                </div>

                <div class="table-wrap">
                    <table class="records-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time In</th>
                                <th>Name of Patient</th>
                                <th>Course / Dept</th>
                                <th>Age</th>
                                <th>Male</th>
                                <th>Female</th>
                                <th>Senior</th>
                                <th>PWD</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Time Out</th>
                                <th>Duration</th>
                                <th>Emergency</th>
                                <th>Non-Emerg.</th>
                                <th>Sig.</th>
                            </tr>
                        </thead>
                        <tbody id="dentalServicesTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <div class="filter-overlay" id="filterOverlay" onclick="closeFilterPanel()"></div>

    <div class="filter-panel" id="filterPanel">
        <div class="fp-header">
            <span class="fp-title"><i class="fa-solid fa-sliders"></i> Filter</span>
            <button class="fp-close-btn" type="button" onclick="closeFilterPanel()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="fp-body">

            <div class="fp-section">
                <div class="fp-section-title">Sort by Name</div>
                <label class="fp-radio-item">
                    <input type="radio" name="sort" value="az">
                    <span>A → Z</span>
                </label>
                <label class="fp-radio-item">
                    <input type="radio" name="sort" value="za">
                    <span>Z → A</span>
                </label>
            </div>

            <div class="fp-section">
                <div class="fp-section-title">Date Order</div>
                <label class="fp-radio-item">
                    <input type="radio" name="dateOrder" value="asc">
                    <span>Ascending</span>
                </label>
                <label class="fp-radio-item">
                    <input type="radio" name="dateOrder" value="desc">
                    <span>Descending</span>
                </label>
            </div>

            <div class="fp-section">
                <div class="fp-section-title">Gender</div>
                <label class="fp-radio-item">
                    <input type="radio" name="gender" value="Male">
                    <span>Male</span>
                </label>
                <label class="fp-radio-item">
                    <input type="radio" name="gender" value="Female">
                    <span>Female</span>
                </label>
            </div>

            <div class="fp-section">
                <div class="fp-section-title">Priority</div>
                <label class="fp-radio-item">
                    <input type="checkbox" name="gad" value="PWD" class="gadPriority">
                    <span>PWD</span>
                </label>
                <label class="fp-radio-item">
                    <input type="checkbox" name="gad" value="Senior" class="gadPriority">
                    <span>Senior</span>
                </label>
            </div>

            <div class="fp-section">
                <div class="fp-section-title">Type</div>
                <label class="fp-radio-item">
                    <input type="radio" name="type" value="Emergency">
                    <span>Emergency</span>
                </label>
                <label class="fp-radio-item">
                    <input type="radio" name="type" value="Non-Emergency">
                    <span>Non-Emergency</span>
                </label>
            </div>

            <div class="fp-section">
                <div class="fp-section-title">Department</div>
                <label class="fp-radio-item">
                    <input type="radio" name="department" value="Administrative" class="departmentRadio">
                    <span>Administrative</span>
                </label>
                <label class="fp-radio-item">
                    <input type="radio" name="department" value="Faculty" class="departmentRadio">
                    <span>Faculty</span>
                </label>
                <label class="fp-radio-item">
                    <input type="radio" name="department" value="Dependent" class="departmentRadio">
                    <span>Dependent</span>
                </label>
            </div>

        </div>

        <div class="fp-footer">
            <button class="fp-btn-clear" id="clearFilterBtn" type="button">Clear All</button>
            <button class="fp-btn-apply" id="applyFiltersBtn" type="button">
                <i class="fa-solid fa-check mr-1"></i> Apply
            </button>
        </div>
    </div>

    <dialog id="createReportModal" class="modal">
        <div class="modal-box max-w-xl p-0 rounded-2xl overflow-hidden bg-white shadow-2xl flex flex-col"
            style="max-height:min(90vh,640px);">
            <div
                class="bg-gradient-to-r from-[#8B0000] to-[#660000] px-6 py-4 flex items-center justify-between flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-file-circle-plus text-white text-base"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-white leading-tight">Create Dental Services Report</h2>
                        <p class="text-white/65 text-[11px] mt-0.5">Generate and download a report</p>
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
                        <label class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider mb-1">Report
                            Name</label>
                        <input id="reportName" type="text" placeholder="e.g. December 2025 Dental Report"
                            class="w-full px-3.5 py-2 rounded-xl border border-gray-300 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors placeholder-gray-400">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider mb-1">Report
                            Type</label>
                        <select id="reportType"
                            class="w-full px-3.5 py-2 rounded-xl border border-gray-300 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors">
                            <option selected>Dental Services Report</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider mb-1">Date
                            Range</label>
                        <div class="grid grid-cols-2 gap-3">
                            <input id="dateFrom" type="date"
                                class="w-full px-3.5 py-2 rounded-xl border border-gray-300 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors">
                            <input id="dateTo" type="date"
                                class="w-full px-3.5 py-2 rounded-xl border border-gray-300 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors">
                        </div>
                    </div>

                    <div>
                        <label
                            class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider mb-1">Quantity</label>
                        <input id="reportQty" type="number" value="1" min="1"
                            class="w-36 px-3.5 py-2 rounded-xl border border-gray-300 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors">
                    </div>
                </form>
            </div>

            <div class="flex-shrink-0 border-t border-gray-100 px-6 py-4 flex justify-end gap-3 bg-gray-50">
                <button type="button" onclick="closeCreateModal()"
                    class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-600 bg-white text-sm font-bold hover:bg-gray-50 transition-all">
                    Back
                </button>
                <button type="button" id="downloadReportBtn"
                    class="px-6 py-2.5 rounded-xl bg-[#8B0000] hover:bg-[#6b0000] text-white text-sm font-bold flex items-center gap-2 shadow-sm transition-all">
                    <i class="fa-solid fa-download"></i> Download Report
                </button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop"><button onclick="closeCreateModal()"></button></form>
    </dialog>

    <div class="toast" id="toast">
        <i class="fa-solid fa-circle-check"></i> Download Complete
    </div>
@endsection

@section('scripts')

    <script>
      const records = @json($records);

let searchKeyword = '';
let nameSort = null;
let dateSort = null;
let selectedMonth = null;
let selectedCalendarYear = null;
let selectedGender = null;
let selectedPriority = [];
let selectedType = null;
let selectedDepartment = null;

/* =========================
   FILTER PANEL (FIXED)
========================= */
function openFilterPanel() {
    document.getElementById('filterPanel').classList.add('open');
    document.getElementById('filterOverlay').classList.add('open');
}

function closeFilterPanel() {
    document.getElementById('filterPanel').classList.remove('open');
    document.getElementById('filterOverlay').classList.remove('open');
}

/* =========================
   MODAL
========================= */
function closeCreateModal() {
    document.getElementById('createReportModal').close();
    document.getElementById('reportForm').reset();
}

/* =========================
   RENDER
========================= */
function renderRecords(data) {
    const tbody = document.getElementById('dentalServicesTableBody');
    tbody.innerHTML = '';

    document.getElementById('statTotal').textContent = data.length;
    document.getElementById('statEmergency').textContent = data.filter(r => r.type === 'Emergency').length;
    document.getElementById('statNonEmergency').textContent = data.filter(r => r.type === 'Non-Emergency').length;
    document.getElementById('statFemale').textContent = data.filter(r => r.gad.gender === 'Female').length;

    if (!data.length) {
        tbody.innerHTML = `
        <tr>
          <td colspan="16">
            <div class="empty-state">
              <i class="fa-regular fa-folder-open"></i>
              <p>No records found</p>
              <span>Try adjusting your search or filters.</span>
            </div>
          </td>
        </tr>
      `;
        return;
    }

    data.forEach((r) => {
        const programMarkup = r.program;

        const emergencyMark = r.type === 'Emergency'
            ? `<span class="check-mark check-gold"><i class="fa-solid fa-check"></i></span>`
            : '';

        const nonEmergencyMark = r.type === 'Non-Emergency'
            ? `<span class="check-mark"><i class="fa-solid fa-check"></i></span>`
            : '';

        tbody.innerHTML += `
        <tr>
          <td class="muted-cell whitespace-nowrap">${r.date}</td>
          <td class="whitespace-nowrap text-[11px]">${r.timeIn}</td>
          <td class="name-cell">${r.name}</td>
          <td>${programMarkup}</td>
          <td>${r.age}</td>
          <td>${r.gad.gender === 'Male' ? '<span class="check-mark"><i class="fa-solid fa-check"></i></span>' : ''}</td>
          <td>${r.gad.gender === 'Female' ? '<span class="check-mark"><i class="fa-solid fa-check"></i></span>' : ''}</td>
          <td>${r.gad.priority.includes('Senior') ? '<span class="check-mark check-gold"><i class="fa-solid fa-check"></i></span>' : ''}</td>
          <td>${r.gad.priority.includes('PWD') ? '<span class="check-mark check-gold"><i class="fa-solid fa-check"></i></span>' : ''}</td>
          <td class="muted-cell">${r.email}</td>
          <td class="text-[11px]">${r.contact}</td>
          <td class="whitespace-nowrap text-[11px]">${r.timeOut}</td>
          <td class="text-[11px]">${r.duration}</td>
          <td>${emergencyMark}</td>
          <td>${nonEmergencyMark}</td>
          <td><span class="check-mark"><i class="fa-solid fa-check"></i></span></td>
        </tr>
      `;
    });
}

/* =========================
   DATE PARSER
========================= */
function parseRecordDate(dateString) {
    const [month, day, year] = dateString.split('/');
    return new Date(`20${year}-${month}-${day}`);
}

/* =========================
   FILTER LOGIC
========================= */
function applyFilters() {
    let data = [...records];

    if (searchKeyword) {
        data = data.filter(r =>
            `${r.name} ${r.program} ${r.type} ${r.contact} ${r.email}`
                .toLowerCase()
                .includes(searchKeyword)
        );
    }

    if (selectedGender) {
        data = data.filter(r => r.gad.gender === selectedGender);
    }

    if (selectedPriority.length) {
        data = data.filter(r =>
            selectedPriority.every(p => r.gad.priority.includes(p))
        );
    }

    if (selectedType) {
        data = data.filter(r => r.type === selectedType);
    }

    if (selectedDepartment) {
        data = data.filter(r => r.department === selectedDepartment);
    }

    if (selectedMonth && selectedCalendarYear) {
        data = data.filter(r => {
            const [month, , year] = r.date.split('/');
            return month === selectedMonth && `20${year}` === selectedCalendarYear;
        });
    }

    if (dateSort === 'asc') {
        data.sort((a, b) => parseRecordDate(a.date) - parseRecordDate(b.date));
    }

    if (dateSort === 'desc') {
        data.sort((a, b) => parseRecordDate(b.date) - parseRecordDate(a.date));
    }

    if (nameSort === 'az') {
        data.sort((a, b) => a.name.localeCompare(b.name));
    }

    if (nameSort === 'za') {
        data.sort((a, b) => b.name.localeCompare(a.name));
    }

    renderRecords(data);
}

/* =========================
   EVENTS
========================= */
document.addEventListener('DOMContentLoaded', function () {

    const clearFilterBtn = document.getElementById('clearFilterBtn');
    const clearBtn = document.getElementById('clearBtn');
    const searchInput = document.getElementById('searchInput');
    const monthPicker = document.getElementById('monthPicker');
    const downloadReportBtn = document.getElementById('downloadReportBtn');

    /* APPLY BUTTON */
    document.getElementById('applyFiltersBtn').addEventListener('click', () => {
        applyFilters();
        closeFilterPanel();
    });

    /* CLEAR FILTER */
    clearFilterBtn.addEventListener('click', () => {
        selectedGender = null;
        selectedPriority = [];
        selectedType = null;
        selectedDepartment = null;
        nameSort = null;
        dateSort = null;

        document.querySelectorAll('input').forEach(i => i.checked = false);

        applyFilters();
    });

    /* CLEAR SEARCH */
    clearBtn.addEventListener('click', () => {
        searchKeyword = '';
        searchInput.value = '';
        applyFilters();
    });

    /* SEARCH */
    searchInput.addEventListener('input', (e) => {
        searchKeyword = e.target.value.trim().toLowerCase();
        applyFilters();
    });

    /* SORT NAME */
    document.querySelectorAll("input[name='sort']").forEach(radio => {
        radio.addEventListener('change', () => {
            nameSort = radio.value;
            applyFilters();
        });
    });

    /* DATE SORT */
    document.querySelectorAll("input[name='dateOrder']").forEach(radio => {
        radio.addEventListener('change', () => {
            dateSort = radio.value;
            applyFilters();
        });
    });

    /* GENDER */
    document.querySelectorAll("input[name='gender']").forEach(radio => {
        radio.addEventListener('change', () => {
            selectedGender = radio.value;
            applyFilters();
        });
    });

    /* PRIORITY */
    document.querySelectorAll('.gadPriority').forEach(cb => {
        cb.addEventListener('change', () => {
            selectedPriority = [...document.querySelectorAll('.gadPriority:checked')]
                .map(i => i.value);
            applyFilters();
        });
    });

    /* TYPE */
    document.querySelectorAll("input[name='type']").forEach(radio => {
        radio.addEventListener('change', () => {
            selectedType = radio.value;
            applyFilters();
        });
    });

    /* DEPARTMENT */
    document.querySelectorAll(".departmentRadio").forEach(radio => {
        radio.addEventListener('change', () => {
            selectedDepartment = radio.value;
            applyFilters();
        });
    });

    /* MONTH FILTER */
    monthPicker.addEventListener('change', (e) => {
        if (!e.target.value) {
            selectedMonth = null;
            selectedCalendarYear = null;
        } else {
            const [year, month] = e.target.value.split('-');
            selectedMonth = month;
            selectedCalendarYear = year;
        }
        applyFilters();
    });

    /* DOWNLOAD */
    downloadReportBtn.addEventListener('click', () => {
        const toast = document.getElementById('toast');
        closeCreateModal();
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    });

    /* DEFAULT MONTH */
    const now = new Date();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const year = now.getFullYear();

    monthPicker.value = `${year}-${month}`;
    selectedMonth = month;
    selectedCalendarYear = String(year);

    applyFilters();
});
    </script>
@endsection
