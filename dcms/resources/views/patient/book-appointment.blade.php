<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    @include('partials.patient.styles')

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    colors: {
                        crimson: {
                            DEFAULT: '#8B0000',
                            dark: '#660000',
                            light: '#b30000',
                            faint: '#F4F4F4',
                            muted: '#f9e8e8'
                        },
                        gold: '#c9a84c',
                    },
                    keyframes: {
                        fadeUp: {
                            from: {
                                opacity: '0',
                                transform: 'translateY(16px)'
                            },
                            to: {
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        },
                        shake: {
                            '0%,100%': {
                                transform: 'translateX(0)'
                            },
                            '25%': {
                                transform: 'translateX(-5px)'
                            },
                            '75%': {
                                transform: 'translateX(5px)'
                            }
                        },
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.5s ease-out both',
                        'fade-up-1': 'fadeUp 0.5s 0.1s ease-out both',
                        'fade-up-2': 'fadeUp 0.5s 0.2s ease-out both',
                        shake: 'shake 0.3s ease',
                    },
                }
            }
        }
    </script>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .step-content {
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .step-content.show {
            opacity: 1;
        }

        .step-circle {
            transition: all 0.4s ease;
        }

        .step-connector {
            transition: background 0.4s;
        }

        .slot-chip {
            transition: all 0.2s;
        }

        .service-step-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .service-option {
            display: block;
            cursor: pointer;
        }

        .service-option-input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .service-option-card {
            min-height: 98px;
            border-radius: 20px;
            border: 1px solid #eadfda;
            background: linear-gradient(180deg, #fffefe 0%, #fff8f7 100%);
            padding: 0.85rem 0.95rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.85rem;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.03);
            transition:
                transform 0.22s ease,
                box-shadow 0.22s ease,
                border-color 0.22s ease,
                background 0.22s ease;
        }

        .service-option-main {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            min-width: 0;
            flex: 1;
        }

        .service-option-icon {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: #f9e8e8;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8B0000;
            flex-shrink: 0;
            box-shadow: inset 0 0 0 1px rgba(139, 0, 0, 0.05);
        }

        .service-option-icon i {
            font-size: 1rem;
        }

        .service-option-copy {
            min-width: 0;
            flex: 1;
        }

        .service-option-topline {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            flex-wrap: wrap;
            margin-bottom: 0.35rem;
        }

        .service-option-title {
            margin: 0;
            font-size: 0.98rem;
            font-weight: 800;
            color: #1a1410;
            line-height: 1.2;
        }

        .service-option-badge {
            padding: 0.24rem 0.48rem;
            border-radius: 999px;
            background: #fff3e8;
            color: #9a5b00;
            font-size: 0.62rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .service-option-desc {
            margin: 0;
            font-size: 0.82rem;
            line-height: 1.45;
            color: #8c817a;
        }

        .service-option-arrow {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            border: 1px solid #efe4df;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #d4c7c0;
            flex-shrink: 0;
            transition: all 0.22s ease;
        }

        .service-option:hover .service-option-card {
            transform: translateY(-2px);
            border-color: #d9b8b0;
            box-shadow: 0 18px 34px rgba(139, 0, 0, 0.08);
            background: linear-gradient(180deg, #fffafa 0%, #fff4f3 100%);
        }

        .service-option:hover .service-option-arrow {
            color: #8B0000;
            border-color: #d9b8b0;
            background: #fff5f5;
        }

        .service-option:has(.service-option-input:checked) .service-option-card {
            border-color: #8B0000;
            background: linear-gradient(135deg, #8B0000 0%, #660000 100%);
            box-shadow: 0 18px 36px rgba(139, 0, 0, 0.22);
            transform: translateY(-2px);
        }

        .service-option:has(.service-option-input:checked) .service-option-title {
            color: #ffffff;
        }

        .service-option:has(.service-option-input:checked) .service-option-desc {
            color: rgba(255, 255, 255, 0.8);
        }

        .service-option:has(.service-option-input:checked) .service-option-icon {
            background: rgba(255, 255, 255, 0.16);
            color: #ffffff;
        }

        .service-option:has(.service-option-input:checked) .service-option-icon img {
            filter: brightness(0) invert(1) !important;
        }

        .service-option:has(.service-option-input:checked) .service-option-badge {
            background: rgba(255, 255, 255, 0.14);
            color: #fff3d6;
        }

        .service-option:has(.service-option-input:checked) .service-option-arrow {
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.08);
        }

        .booking-step-shell {
            background: linear-gradient(180deg, #ffffff 0%, #fffafa 100%);
            border: 1px solid #ece3de;
            border-radius: 28px;
            padding: 1.35rem;
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.05);
        }

        .booking-step-header {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            margin-bottom: 1.15rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1e8e3;
        }

        .booking-step-eyebrow {
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #8B0000;
        }

        .booking-step-title {
            font-size: clamp(1.7rem, 2.5vw, 2.45rem);
            font-weight: 900;
            line-height: 1.06;
            color: #660000;
            margin: 0;
        }

        .booking-step-subtitle {
            font-size: 0.95rem;
            line-height: 1.65;
            color: #8c817a;
            margin: 0;
            max-width: 760px;
        }

        .booking-step-body {
            min-width: 0;
        }

        .section-card {
            background: linear-gradient(180deg, #fffefe 0%, #fff8f7 100%);
            border: 1px solid #e8e2dd;
            border-radius: 22px;
            padding: 1rem;
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.025);
        }

        .booking-step-body>.section-card+.section-card,
        .section-stack>.section-card+.section-card {
            margin-top: 1rem;
        }

        .cal-time-layout>.section-card,
        .cal-time-layout>.time-panel.section-card {
            height: 100%;
            align-self: stretch;
        }

        .section-card-title {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #8B0000;
            margin-bottom: 0.9rem;
        }

        .section-card-title-line {
            flex: 1;
            height: 1px;
            background: #f0e4df;
        }

        @media (max-width: 768px) {
            .booking-step-shell {
                border-radius: 22px;
                padding: 1rem;
            }

            .booking-step-header {
                padding-bottom: 0.85rem;
                margin-bottom: 1rem;
            }

            .booking-step-title {
                font-size: 1.6rem;
            }

            .booking-step-subtitle {
                font-size: 0.88rem;
            }

            .section-card {
                border-radius: 18px;
                padding: 0.9rem;
            }
        }

        .progress-fill {
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-input {
            height: 46px;
            color: #333 !important;
        }

        textarea.form-input {
            height: auto;
            min-height: 110px;
            color: #333 !important;
        }

        select.form-input {
            height: 46px;
            color: #333 !important;
        }

        .form-input::placeholder,
        textarea.form-input::placeholder {
            color: #9ca3af;
        }

        .form-input:focus {
            border-color: #8B0000;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.08);
            padding-right: 2.75rem !important;
        }

        .date-input-wrap {
            position: relative;
            width: 100%;
        }

        .date-input-wrap .form-input {
            height: 46px !important;
            min-height: 46px !important;
            padding-right: 2.85rem !important;
        }

        .date-input-wrap.compact {
            max-width: 260px;
        }

        .date-input-icon {
            position: absolute;
            right: 0.95rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 0.95rem;
            pointer-events: none;
            z-index: 5;
        }

        .question-text {
            color: #333 !important;
        }

        .required-star {
            color: #8B0000;
            font-weight: 800;
            margin-left: 0.2rem;
            display: inline;
        }

        .q-radio:checked {
            border-color: #8B0000;
            background: #8B0000;
            box-shadow: inset 0 0 0 3px white;
        }

        .q-radio:hover:not(:checked) {
            border-color: #8B0000;
        }

        .btn-primary-custom:hover {
            background: #660000;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(139, 0, 0, 0.3);
        }

        .btn-secondary-custom:hover {
            border-color: #8B0000;
            color: #8B0000;
            background: #fff5f5;
        }

        .confirm-checkbox-wrap:hover {
            border-color: #8B0000;
        }

        .file-upload-zone:hover {
            border-color: #8B0000;
            background: #fff1f1;
        }

        .mini-tab {
            bottom: 5rem;
        }

        @media (max-width: 640px) {
            .sm-grid-1col {
                grid-template-columns: 1fr !important;
            }
        }

        input[type="text"],
        input[type="email"],
        textarea {
            padding-right: 2.5rem !important;
        }

        #leaveModal::backdrop,
        #othersModal::backdrop,
        #confirmModal::backdrop {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(2px);
        }

        #leaveModal.flex {
            display: flex;
        }

        .flatpickr-input.form-input[readonly] {
            height: 46px !important;
            min-height: 46px !important;
            padding: 0 2.85rem 0 1rem !important;
            line-height: 46px !important;
            cursor: pointer;
            color: #333 !important;
        }

        .flatpickr-calendar::before,
        .flatpickr-calendar::after {
            display: none !important;
        }

        .flatpickr-calendar {
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 18px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.12);
            font-family: 'Inter', sans-serif;
            overflow: visible;
            padding: 0;
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .flatpickr-months {
            position: relative;
            background: linear-gradient(135deg, #8B0000, #660000);
            color: white;
            padding: 12px 14px;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .flatpickr-current-month {
            position: absolute !important;
            left: 50% !important;
            top: 50% !important;
            transform: translate(-50%, -50%) !important;
            width: auto !important;
            max-width: calc(100% - 96px);
            display: flex !important;
            align-items: center;
            justify-content: center;
            padding: 0 !important;
            margin: 0 !important;
            pointer-events: none;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months,
        .flatpickr-current-month input.cur-year {
            background: transparent;
            color: white;
            font-weight: 800;
            border: none;
            box-shadow: none;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months {
            cursor: pointer;
        }

        .flatpickr-weekdays {
            background: #F4F4F4;
            padding: 6px 2px;
        }

        span.flatpickr-weekday {
            color: #8B0000;
            font-size: 12px;
            font-weight: 800;
            display: flex !important;
            align-items: center;
            justify-content: center;
            text-align: center;
        }


        .flatpickr-days {
            overflow: visible !important;
        }

        .flatpickr-day {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 38px !important;
            max-width: 38px !important;
            height: 38px !important;
            line-height: 38px !important;
            margin: 0 auto !important;
            padding: 0 !important;
            border-radius: 12px;
            font-weight: 700;
            color: #444;
            border: 1px solid transparent;
            text-align: center !important;
        }


        .flatpickr-day:hover {
            background: #fff1f1;
            border-color: #fff1f1;
            color: #8B0000;
        }

        .flatpickr-weekdaycontainer,
        .flatpickr-days .dayContainer {
            justify-content: center;
            width: 100% !important;
        }

        .dayContainer {
            gap: 0;
            display: grid !important;
            grid-template-columns: repeat(7, 1fr);
            justify-items: center;
            align-items: center;
            overflow: visible !important;
        }

        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange {
            background: #8B0000 !important;
            border-color: #8B0000 !important;
            color: white !important;
        }

        .flatpickr-day.today {
            border-color: #c9a84c !important;
            color: #8B0000 !important;
        }

        .flatpickr-day.today:hover {
            background: #fff8ea !important;
            border-color: #c9a84c !important;
            color: #8B0000 !important;
        }

        .flatpickr-day.prevMonthDay,
        .flatpickr-day.nextMonthDay {
            color: #d8d2cd !important;
        }

        .flatpickr-day.flatpickr-disabled,
        .flatpickr-day.prevMonthDay.flatpickr-disabled,
        .flatpickr-day.nextMonthDay.flatpickr-disabled {
            color: #d1ccc8 !important;
            cursor: not-allowed !important;
        }

        .flatpickr-day.flatpickr-future-disabled {
            position: relative;
        }

        .flatpickr-day.flatpickr-future-disabled::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: calc(100% + 10px);
            left: 50%;
            transform: translateX(-50%) translateY(4px);
            background: linear-gradient(135deg, #8B0000, #660000);
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            line-height: 1.2;
            padding: 8px 10px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.18s ease, transform 0.18s ease;
            z-index: 999;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.22);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .flatpickr-day.flatpickr-future-disabled::before {
            content: "";
            position: absolute;
            bottom: calc(100% + 2px);
            left: 50%;
            transform: translateX(-50%);
            border-width: 6px 6px 0 6px;
            border-style: solid;
            border-color: #8B0000 transparent transparent transparent;
            opacity: 0;
            transition: opacity 0.18s ease, transform 0.18s ease;
            z-index: 998;
        }

        .flatpickr-day.flatpickr-future-disabled:hover::after,
        .flatpickr-day.flatpickr-future-disabled:hover::before {
            opacity: 1;
        }

        .flatpickr-day.tooltip-center::after {
            left: 50%;
            right: auto;
            transform: translateX(-50%) translateY(4px);
        }

        .flatpickr-day.tooltip-center::before {
            left: 50%;
            right: auto;
            transform: translateX(-50%);
        }

        .flatpickr-day.tooltip-center:hover::after,
        .flatpickr-day.tooltip-center:hover::before {
            transform: translateX(-50%) translateY(0);
        }

        .flatpickr-day.tooltip-left::after {
            left: auto;
            right: 0;
            transform: translateX(0) translateY(4px);
        }

        .flatpickr-day.tooltip-left::before {
            left: auto;
            right: 12px;
            transform: translateX(0);
        }

        .flatpickr-day.tooltip-left:hover::after,
        .flatpickr-day.tooltip-left:hover::before {
            transform: translateX(0) translateY(0);
        }

        .flatpickr-day.tooltip-right::after {
            left: 0;
            right: auto;
            transform: translateX(0) translateY(4px);
        }

        .flatpickr-day.tooltip-right::before {
            left: 12px;
            right: auto;
            transform: translateX(0);
        }

        .flatpickr-day.tooltip-right:hover::after,
        .flatpickr-day.tooltip-right:hover::before {
            transform: translateX(0) translateY(0);
        }

        .flatpickr-day.flatpickr-future-disabled:hover {
            background: #fff5f5 !important;
            border-color: #f3d4d4 !important;
            color: #8B0000 !important;
        }

        .custom-flatpickr-selects {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: auto;
            margin: 0 auto;
            pointer-events: auto;
        }

        .custom-flatpickr-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: rgba(255, 255, 255, 0.12);
            color: #F4F4F4;
            border: 1px solid rgba(255, 255, 255, 0.14);
            outline: none;
            font-weight: 800;
            font-size: 15px;
            line-height: 1;
            cursor: pointer;
            padding: 6px 5px 6px 5px;
            border-radius: 10px;
            text-align: center;
            text-align-last: center;
            flex: 0 0 auto;
        }

        .custom-flatpickr-select:last-child {
            min-width: 96px;
        }

        .flatpickr-months .flatpickr-prev-month,
        .flatpickr-months .flatpickr-next-month {
            color: #F4F4F4;
            top: 50% !important;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            display: flex !important;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            z-index: 5;
        }

        .flatpickr-prev-month svg,
        .flatpickr-next-month svg {
            fill: #F4F4F4 !important;
        }

        .flatpickr-months .flatpickr-prev-month:hover,
        .flatpickr-months .flatpickr-next-month:hover {
            background: rgba(255, 255, 255, 0.12);
        }

        .custom-flatpickr-select:hover,
        .custom-flatpickr-select:focus {
            background: rgba(255, 255, 255, 0.18);
            border-color: rgba(255, 255, 255, 0.749);
        }

        .custom-flatpickr-select option {
            background: #8B0000;
            color: #F4F4F4;
            font-weight: 700;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months,
        .flatpickr-current-month .numInputWrapper {
            display: none !important;
        }

        .cal-time-layout {
            align-items: stretch !important;
        }

        .time-panel {
            position: relative;
            overflow: hidden;
            min-height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .time-panel::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 160px;
            background: linear-gradient(180deg, rgba(139, 0, 0, 0.05), rgba(139, 0, 0, 0.01), transparent);
            pointer-events: none;
        }

        #slotGrid.slot-grid-ui {
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            grid-auto-rows: 60px;
            grid-auto-flow: row;
            gap: 0.85rem !important;
            margin-top: 0.8rem;
            align-items: stretch;
        }

        #slotGrid .slot-chip {
            width: 100%;
            height: 60px;
            min-height: 60px;
            border-radius: 16px !important;
            border: 1px solid #e7d8d2 !important;
            background: #ffffff !important;
            color: #2f2f2f !important;
            font-weight: 700 !important;
            font-size: 0.98rem !important;
            display: flex !important;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            padding: 0 0.9rem !important;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.03);
            transition:
                transform 0.22s ease,
                box-shadow 0.22s ease,
                border-color 0.22s ease,
                background 0.22s ease,
                color 0.22s ease,
                opacity 0.22s ease;
        }

        #slotGrid .slot-chip:hover:not(:disabled):not(.disabled) {
            transform: translateY(-2px);
            border-color: #d5b2a9 !important;
            box-shadow: 0 16px 30px rgba(139, 0, 0, 0.10);
            background: linear-gradient(180deg, #fffafa 0%, #fff3f2 100%) !important;
        }

        #slotGrid .slot-chip.selected,
        #slotGrid .slot-chip[aria-pressed="true"],
        #slotGrid .slot-chip.bg-\[\#8B0000\] {
            background: linear-gradient(135deg, #8B0000 0%, #660000 100%) !important;
            border-color: #8B0000 !important;
            color: #ffffff !important;
            box-shadow: 0 16px 32px rgba(139, 0, 0, 0.22);
        }

        #slotGrid .slot-chip.selected i,
        #slotGrid .slot-chip[aria-pressed="true"] i,
        #slotGrid .slot-chip.bg-\[\#8B0000\] i {
            color: #ffffff !important;
        }

        #slotGrid .slot-chip.disabled,
        #slotGrid .slot-chip:disabled {
            height: 60px;
            min-height: 60px;
            opacity: 0.6;
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
            background: #f8f5f4 !important;
            color: #8f8580 !important;
            border-color: #e8dfdb !important;
        }

        #slotGrid .slot-chip span,
        #slotGrid .slot-chip small,
        #slotGrid .slot-chip strong {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #dateBanner {
            font-size: 0.92rem !important;
            font-weight: 800 !important;
            border-radius: 16px !important;
            padding: 0.9rem 1rem !important;
        }

        #slotPlaceholder {
            border: 1px dashed #e7d8d2;
            border-radius: 22px;
            background: linear-gradient(180deg, #fffdfd 0%, #fff7f6 100%);
            min-height: 320px;
        }

        #slotGrid .slot-chip i {
            color: #8B0000 !important;
            font-size: 0.9rem !important;
            transition: color 0.22s ease, transform 0.22s ease;
        }

        #slotGrid .slot-chip.selected i,
        #slotGrid .slot-chip[aria-pressed="true"] i,
        #slotGrid .slot-chip.bg-\[\#8B0000\] i {
            color: #fff !important;
        }

        #slotGrid .slot-chip:hover {
            transform: translateY(-2px) scale(1.01);
            border-color: #cfaaaa !important;
            box-shadow: 0 14px 28px rgba(139, 0, 0, 0.10);
            background: linear-gradient(180deg, #fffafa 0%, #fff4f4 100%) !important;
        }

        #slotGrid .slot-chip.selected,
        #slotGrid .slot-chip[aria-pressed="true"],
        #slotGrid .slot-chip.bg-\[\#8B0000\] {
            background: linear-gradient(135deg, #8B0000, #660000) !important;
            border-color: #8B0000 !important;
            color: #fff !important;
            transform: translateY(-1px);
            box-shadow: 0 14px 30px rgba(139, 0, 0, 0.24);
        }

        #slotGrid .slot-chip.selected::before,
        #slotGrid .slot-chip[aria-pressed="true"]::before,
        #slotGrid .slot-chip.bg-\[\#8B0000\]::before {
            color: #fff;
            opacity: 0.95;
        }

        #slotGrid .slot-chip:active {
            transform: scale(0.985);
        }

        #slotGrid .slot-chip span,
        #slotGrid .slot-chip strong {
            transition: color 0.22s ease;
        }

        #slotGrid .slot-chip span,
        #slotGrid .slot-chip small,
        #slotGrid .slot-chip strong {
            white-space: nowrap;
        }

        .voice-input-wrap {
            position: relative;
            width: 100%;
            max-width: 420px;
        }

        .voice-input-wrap>input,
        .voice-input-wrap>textarea {
            width: 100%;
        }

        .voice-input-wrap.is-full {
            max-width: 100%;
        }

        #additional_concerns {
            min-height: 136px;
        }

        .voice-input-wrap.is-medium {
            max-width: 320px;
        }

        .voice-input-wrap.is-small {
            max-width: 220px;
        }

        .voice-mic-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1.75rem;
            height: 1.75rem;
            border: 0;
            background: transparent;
            cursor: pointer;
        }

        .voice-mic-btn:focus {
            outline: none;
        }

        .voice-mic-btn i {
            pointer-events: none;
        }

        @media only screen and (max-width: 600px) {

            .service-option-card {
                min-height: 84px;
                gap: 0.75rem;
                padding: 0.75rem 0.8rem;
            }

            .service-option-main {
                gap: 0.7rem;
            }

            .service-option-icon {
                width: 40px;
                height: 40px;
            }

            .service-option-arrow {
                width: 30px;
                height: 30px;
            }

            .cal-time-layout {
                grid-template-columns: 1fr !important;
                gap: 1rem !important;
            }

            .booking-step-shell {
                padding: 0.95rem;
                border-radius: 22px;
            }

            .section-card,
            .time-panel.section-card {
                padding: 0.9rem;
                border-radius: 18px;
            }

            .booking-step-title {
                font-size: 1.65rem;
            }

            .booking-step-subtitle {
                font-size: 0.88rem;
                line-height: 1.55;
            }

            #slotGrid.slot-grid-ui {
                grid-template-columns: 1fr !important;
                grid-auto-rows: 56px;
                gap: 0.75rem !important;
            }

            #slotGrid .slot-chip,
            #slotGrid .slot-chip.disabled,
            #slotGrid .slot-chip:disabled {
                height: 56px;
                min-height: 56px;
                font-size: 0.92rem !important;
                border-radius: 14px !important;
                padding: 0 0.85rem !important;
            }

            #slotPlaceholder {
                min-height: 180px;
            }

            #dateBanner {
                font-size: 0.84rem !important;
                padding: 0.8rem 0.9rem !important;
            }

            .time-panel {
                padding: 0.95rem !important;
            }

            .service-step-grid {
                grid-template-columns: 1fr;
            }
        }

        @media only screen and (min-width: 600px) {
            .cal-time-layout {
                grid-template-columns: 1fr !important;
            }

            .service-step-grid {
                grid-template-columns: 1fr;
            }
        }

        @media only screen and (min-width: 768px) {

            .service-option-card {
                min-height: 88px;
                border-radius: 18px;
                padding: 0.8rem 0.85rem;
            }

            .service-option-icon {
                width: 42px;
                height: 42px;
                border-radius: 13px;
            }

            .service-option-title {
                font-size: 0.93rem;
            }

            .service-option-desc {
                font-size: 0.78rem;
            }

            .service-option-badge {
                font-size: 0.58rem;
            }

            .cal-time-layout {
                grid-template-columns: minmax(0, 1fr) minmax(330px, 390px) !important;
                align-items: stretch !important;
            }

            .service-step-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            #slotGrid.slot-grid-ui {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                grid-auto-rows: 58px;
            }

            #slotPlaceholder {
                min-height: 260px;
            }
        }

        @media only screen and (min-width: 992px) {
            .cal-time-layout {
                grid-template-columns: minmax(0, 1fr) minmax(360px, 420px) !important;
                gap: 1.5rem !important;
            }

            #slotGrid.slot-grid-ui {
                grid-auto-rows: 60px;
            }

            #slotPlaceholder {
                min-height: 320px;
            }
        }

        @media only screen and (min-width: 1200px) {

            .cal-time-layout {
                grid-template-columns: minmax(0, 1fr) minmax(380px, 430px) !important;
            }
        }
    </style>
</head>

@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
$isFemalePatient = strtolower($patient->gender ?? '') === 'female';
@endphp

<body class="role-patient bg-[#F4F4F4] text-[#8B0000] min-h-screen">

    @include('partials.header', [
    'role' => 'patient',
    'patient' => $patient ?? null,
    'notifications' => $notifications ?? [],
    'showMobileMenu' => false,
    'showSettings' => false,
    ])

    <div class="max-w-4xl mx-auto px-4 sm:px-6 pt-16 pb-2 animate-fade-up">

        <div class="flex items-center justify-between mt-8 mb-4">
            <a href="{{ route('homepage') }}"
                class="back-home-btn flex items-center gap-2 bg-[#8B0000] hover:bg-[#660000] text-white px-4 py-2 rounded-xl text-xs font-bold border border-[#660000] transition shadow-sm">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Back to Home
            </a>
            <span
                class="text-xs text-[#9e9690] font-semibold bg-white border border-[#e8e2dd] px-3 py-1.5 rounded-full shadow-sm">
                Step <span id="stepCounterText">1</span> <span class="text-[#c4bfba]">of 5</span>
            </span>
        </div>

        <div class="w-full h-2 rounded-full bg-[#e8e2dd] overflow-hidden mb-5">
            <div id="headerProgressFill" class="h-full rounded-full progress-fill"
                style="width:20%; background: linear-gradient(90deg, #8B0000, #c9a84c)"></div>
        </div>

        <div class="text-center mb-1">
            <p class="text-xs font-semibold uppercase tracking-widest mb-1 text-[#8B0000]">
                <i class="fa-regular fa-calendar-check mr-1"></i> PUP TAGUIG DENTAL CLINIC
            </p>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-[#660000]">Book an Appointment</h1>
            <p class="text-sm text-[#9e9690] mt-1">Complete all five steps to schedule your dental visit.</p>
        </div>

    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 pb-16">

        <div class="w-full mt-4 mb-0 animate-fade-up-1 py-3 px-2" style="overflow: visible;">
            <div class="flex items-start justify-between w-full" style="padding: 6px 0;">
                <div class="flex flex-col items-center gap-1 min-w-0 flex-1">
                    <div id="sc1"
                        class="step-circle w-10 h-10 rounded-full border-2 border-blue-600 bg-blue-600 flex items-center justify-center text-sm font-bold text-white shadow-[0_0_0_6px_rgba(37,99,235,0.12)] scale-110">
                        1</div>
                    <span id="sl1"
                        class="step-label text-[0.65rem] font-semibold uppercase tracking-wide text-blue-600 text-center hidden sm:block mt-4">Date
                        &amp; Time</span>
                </div>
                <div id="conn1" class="h-0.5 bg-[#e8e2dd] flex-shrink-0 self-start step-connector"
                    style="width:clamp(8px, 3vw, 40px); margin-top:20px;"></div>
                <div class="flex flex-col items-center gap-1 min-w-0 flex-1">
                    <div id="sc2"
                        class="step-circle w-10 h-10 rounded-full border-2 border-[#e8e2dd] bg-white flex items-center justify-center text-sm font-bold text-[#9e9690]">
                        2</div>
                    <span id="sl2"
                        class="step-label text-[0.65rem] font-semibold uppercase tracking-wide text-[#9e9690] text-center hidden sm:block mt-4">Service</span>
                </div>
                <div id="conn2" class="h-0.5 bg-[#e8e2dd] flex-shrink-0 self-start step-connector"
                    style="width:clamp(8px, 3vw, 40px); margin-top:20px;"></div>
                <div class="flex flex-col items-center gap-1 min-w-0 flex-1">
                    <div id="sc3"
                        class="step-circle w-10 h-10 rounded-full border-2 border-[#e8e2dd] bg-white flex items-center justify-center text-sm font-bold text-[#9e9690]">
                        3</div>
                    <span id="sl3"
                        class="step-label text-[0.65rem] font-semibold uppercase tracking-wide text-[#9e9690] text-center hidden sm:block mt-4">Dental
                        History</span>
                </div>
                <div id="conn3" class="h-0.5 bg-[#e8e2dd] flex-shrink-0 self-start step-connector"
                    style="width:clamp(8px, 3vw, 40px); margin-top:20px;"></div>
                <div class="flex flex-col items-center gap-1 min-w-0 flex-1">
                    <div id="sc4"
                        class="step-circle w-10 h-10 rounded-full border-2 border-[#e8e2dd] bg-white flex items-center justify-center text-sm font-bold text-[#9e9690]">
                        4</div>
                    <span id="sl4"
                        class="step-label text-[0.65rem] font-semibold uppercase tracking-wide text-[#9e9690] text-center hidden sm:block mt-4">Medical
                        History</span>
                </div>
                <div id="conn4" class="h-0.5 bg-[#e8e2dd] flex-shrink-0 self-start step-connector"
                    style="width:clamp(8px, 3vw, 40px); margin-top:20px;"></div>
                <div class="flex flex-col items-center gap-1 min-w-0 flex-1">
                    <div id="sc5"
                        class="step-circle w-10 h-10 rounded-full border-2 border-[#e8e2dd] bg-white flex items-center justify-center text-sm font-bold text-[#9e9690]">
                        5</div>
                    <span id="sl5"
                        class="step-label text-[0.65rem] font-semibold uppercase tracking-wide text-[#9e9690] text-center hidden sm:block mt-4">Confirm</span>
                </div>
            </div>
        </div>

        <div
            class="mt-6 bg-white rounded-2xl shadow-[0_4px_40px_rgba(0,0,0,0.08),0_1px_4px_rgba(0,0,0,0.04)] overflow-hidden animate-fade-up-2">
            <div class="h-1 w-full" style="background: linear-gradient(90deg, #660000, #8B0000, #c9a84c)"></div>
            <div class="p-6 sm:p-8">

                <form id="appointmentForm" action="{{ route('book.appointment.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="step-content hidden">
                        <div class="booking-step-shell">
                            <div class="booking-step-header">
                                <p class="booking-step-eyebrow">Step 1 of 5</p>
                                <h2 class="booking-step-title">Select Date &amp; Time</h2>
                                <p class="booking-step-subtitle">
                                    Choose your preferred appointment date and available clinic time slot.
                                </p>
                            </div>

                            <div class="booking-step-body">
                                <input type="hidden" id="appointment_date" name="appointment_date" required>
                                <input type="hidden" id="appointment_time" name="appointment_time" required>

                                <div class="cal-time-layout grid gap-5 lg:gap-6"
                                    style="grid-template-columns: minmax(0, 1fr) minmax(360px, 420px);">

                                    <div class="section-card">
                                        <div id="calendarSkeletonContainer"></div>
                                    </div>

                                    <div class="time-panel section-card flex flex-col">
                                        <div class="mb-5">
                                            <p
                                                class="text-[0.78rem] font-extrabold text-[#8B0000] uppercase tracking-[0.24em]">
                                                Pick a Time Slot
                                            </p>
                                            <p class="text-sm text-[#8c817a] mt-1 leading-6">
                                                Choose your preferred schedule for the selected date.
                                            </p>
                                        </div>

                                        <div id="dateBanner"
                                            class="hidden rounded-xl px-3 py-2 text-sm font-semibold text-white mb-3 shadow-md"
                                            style="background: linear-gradient(135deg, #660000, #8B0000)"></div>

                                        <div id="slotContainer" class="hidden">
                                            <div id="slotGrid" class="slot-grid-ui grid grid-cols-2 gap-4"></div>

                                            <div id="selectedSlotDisplay"
                                                class="hidden mt-4 rounded-2xl px-4 py-3 text-sm font-semibold text-[#8B0000] bg-[linear-gradient(135deg,#fff5f5,#fffafa)] border border-[#e8caca] shadow-sm">
                                                <i class="fa-solid fa-circle-check mr-1.5"></i>
                                                Selected:
                                                <span id="selectedSlotText" class="font-bold"></span>
                                            </div>
                                        </div>

                                        <div id="slotPlaceholder"
                                            class="flex flex-col items-center justify-center gap-3 py-8 text-center text-[#9e9690] flex-1">
                                            <div
                                                class="w-12 h-12 rounded-full bg-[#f9e8e8] flex items-center justify-center text-[#8B0000] text-lg">
                                                <i class="fa-regular fa-calendar"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-[#5c5550]">Choose a date</p>
                                                <p class="text-xs mt-1">Select an available day to see time slots.</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-content hidden">
                        <div class="booking-step-shell">
                            <div class="booking-step-header">
                                <p class="booking-step-eyebrow">Step 2 of 5</p>
                                <h2 class="booking-step-title">Choose Your Dental Service</h2>
                                <p class="booking-step-subtitle">
                                    Select the type of service you want to book for your appointment.
                                </p>
                            </div>

                            <div class="booking-step-body">
                                <div class="service-step-grid">
                                    @foreach ($serviceTypes as $service)
                                    <label class="service-option group">
                                        <input type="radio" name="service_type" value="{{ $service['name'] }}"
                                            class="service-option-input">

                                        <div class="service-option-card">
                                            <div class="service-option-main">
                                                <div class="service-option-icon">
                                                    @if (!empty($service['img']))
                                                    <img src="{{ asset('images/' . $service['img'] . '.png') }}"
                                                        class="w-6 h-6"
                                                        style="filter:brightness(0) saturate(100%) invert(8%) sepia(80%) saturate(3000%) hue-rotate(345deg)" />
                                                    @else
                                                    <i class="fa-solid fa-tooth"></i>
                                                    @endif
                                                </div>

                                                <div class="service-option-copy">
                                                    <div class="service-option-topline">
                                                        <p class="service-option-title">{{ $service['name'] }}</p>
                                                        <span class="service-option-badge">Available</span>
                                                    </div>
                                                    <p class="service-option-desc">{{ $service['desc'] }}</p>
                                                </div>
                                            </div>

                                            <div class="service-option-arrow">
                                                <i class="fa-solid fa-chevron-right"></i>
                                            </div>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-content hidden">
                        <div class="booking-step-shell">
                            <div class="booking-step-header">
                                <p class="booking-step-eyebrow">Step 3 of 5</p>
                                <h2 class="booking-step-title">Dental History</h2>
                                <p class="booking-step-subtitle">
                                    Share your past dental records, treatments, and dental concerns for a better
                                    assessment.
                                </p>
                            </div>

                            <div class="booking-step-body">

                                <div class="section-card">
                                    <p class="section-card-title">
                                        <i class="fa-regular fa-calendar-days text-xs"></i> Basic Info
                                        <span class="section-card-title-line"></span>
                                    </p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-[#333] mb-1.5">Last
                                                Dental
                                                Visit</label>
                                            <div class="date-input-wrap compact">
                                                <input type="text" id="lastDentalVisit" name="last_dental_visit"
                                                    class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                                    placeholder="Select date" readonly required>
                                                <i class="fa-regular fa-calendar date-input-icon"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-[#333] mb-1.5">Previous
                                                Dentist</label>
                                            <input type="text" id="previous_dentist" name="previous_dentist"
                                                maxlength="50"
                                                class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                                placeholder="Dr. Name" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-card">
                                    <p
                                        class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                        <i class="fa-solid fa-tooth text-xs"></i> Dental Symptoms <span
                                            class="flex-1 h-px bg-[#f9e8e8]"></span>
                                    </p>
                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                        <span>Question</span><span class="text-center">YES</span><span
                                            class="text-center">NO</span>
                                    </div>
                                    @php
                                    $dentalQ1 = [
                                    [
                                    'name' => 'bleeding_gums',
                                    'q' => 'Do your gums bleed while brushing/flossing?',
                                    ],
                                    [
                                    'name' => 'sensitive_temp',
                                    'q' => 'Are your teeth sensitive to hot or cold?',
                                    ],
                                    [
                                    'name' => 'sensitive_taste',
                                    'q' => 'Are your teeth sensitive to sweets or sour?',
                                    ],
                                    ['name' => 'tooth_pain', 'q' => 'Do you feel any pain in your teeth?'],
                                    [
                                    'name' => 'sores',
                                    'q' => 'Do you have any sores/lumps in or near your mouth?',
                                    ],
                                    [
                                    'name' => 'injuries',
                                    'q' => 'Have you had any head, neck, or jaw injuries?',
                                    ],
                                    ];
                                    @endphp
                                    @foreach ($dentalQ1 as $q)
                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 {{ !$loop->last ? 'border-b border-[#f0ebe6]' : '' }} text-sm text-[#1a1410]">
                                        <span class="leading-snug question-text">{{ $q['q'] }}</span>
                                        <input type="radio" name="{{ $q['name'] }}" value="YES"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                            required>
                                        <input type="radio" name="{{ $q['name'] }}" value="NO"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                    </div>
                                    @endforeach
                                </div>

                                <div class="section-card">
                                    <p
                                        class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                        <i class="fa-solid fa-circle-dot text-xs"></i> Jaw &amp; Bite Symptoms <span
                                            class="flex-1 h-px bg-[#f9e8e8]"></span>
                                    </p>
                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                        <span>Question</span><span class="text-center">YES</span><span
                                            class="text-center">NO</span>
                                    </div>
                                    @php
                                    $dentalQ2 = [
                                    ['name' => 'clicking', 'q' => 'Clicking'],
                                    ['name' => 'joint_pain', 'q' => 'Pain (joint, side of the face)'],
                                    ['name' => 'difficulty_moving', 'q' => 'Difficulty in opening/closing'],
                                    ['name' => 'difficulty_chewing', 'q' => 'Difficulty in chewing'],
                                    ['name' => 'jaw_headaches', 'q' => 'Frequent headaches'],
                                    ['name' => 'clench_grind', 'q' => 'Do you clench or grind your teeth?'],
                                    ['name' => 'biting', 'q' => 'Frequent lips/cheek biting'],
                                    [
                                    'name' => 'teeth_loosening',
                                    'q' => 'Have you noticed loosening of your teeth?',
                                    ],
                                    ['name' => 'food_teeth', 'q' => 'Does food get caught between your teeth?'],
                                    [
                                    'name' => 'med_reaction',
                                    'q' =>
                                    'Have you ever had a reaction to any medicine or dental anesthetic?',
                                    ],
                                    ];
                                    @endphp
                                    @foreach ($dentalQ2 as $q)
                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 {{ !$loop->last ? 'border-b border-[#f0ebe6]' : '' }} text-sm text-[#1a1410]">
                                        <span class="leading-snug question-text">{{ $q['q'] }}</span>
                                        <input type="radio" name="{{ $q['name'] }}" value="YES"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                            required>
                                        <input type="radio" name="{{ $q['name'] }}" value="NO"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                    </div>
                                    @endforeach
                                    <p class="text-xs text-[#8B0000] mt-2 italic pl-4">
                                        <i class="fa-solid fa-circle-info mr-1"></i> If <b>YES</b>, please provide
                                        details
                                        during your
                                        consultation.
                                    </p>
                                </div>

                                <div class="section-card">
                                    <p
                                        class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                        <i class="fa-solid fa-notes-medical text-xs"></i> Dental Procedures <span
                                            class="flex-1 h-px bg-[#f9e8e8]"></span>
                                    </p>
                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                        <span>Question</span><span class="text-center">YES</span><span
                                            class="text-center">NO</span>
                                    </div>

                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                        <span class="question-text">Have you had any periodontal (gum)
                                            treatment?</span>
                                        <input type="radio" name="periodontal" value="YES"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                            required>
                                        <input type="radio" name="periodontal" value="NO"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                    </div>

                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                        <span class="question-text">Have you had a difficult tooth extraction?</span>
                                        <input type="radio" name="difficult_extraction" value="YES"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                            required>
                                        <input type="radio" name="difficult_extraction" value="NO"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                    </div>
                                    <div class="ml-6 mt-2 mb-2 hidden" id="extraction_date_box">
                                        <label class="text-xs text-[#8B0000] italic block mb-1">Date of
                                            extraction:</label>
                                        <div class="date-input-wrap compact">
                                            <input type="text" id="extractionDate" name="extraction_date"
                                                class="form-input voice-small border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none w-full"
                                                placeholder="Select date" readonly>
                                            <i class="fa-regular fa-calendar date-input-icon"></i>
                                        </div>
                                    </div>

                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                        <span class="question-text">Have you had prolonged bleeding following tooth
                                            extractions?</span>
                                        <input type="radio" name="prolonged_bleeding" value="YES"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                            required>
                                        <input type="radio" name="prolonged_bleeding" value="NO"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                    </div>

                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                        <span class="question-text">Do you wear complete or partial dentures?</span>
                                        <input type="radio" name="dentures" value="YES"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                            required>
                                        <input type="radio" name="dentures" value="NO"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                    </div>
                                    <div class="ml-6 mt-2 mb-2 hidden" id="dentures_date_box">
                                        <label class="text-xs text-[#8B0000] italic block mb-1">Date of
                                            placement:</label>
                                        <div class="date-input-wrap compact">
                                            <input type="text" id="denturesDate" name="dentures_date"
                                                class="form-input voice-small border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none w-full"
                                                placeholder="Select date" readonly>
                                            <i class="fa-regular fa-calendar date-input-icon"></i>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 text-sm">
                                        <span class="question-text">Have you had orthodontic treatment?</span>
                                        <input type="radio" name="ortho_treatment" value="YES"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                            required>
                                        <input type="radio" name="ortho_treatment" value="NO"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                    </div>
                                    <div class="ml-6 mt-2 mb-2 hidden" id="ortho_date_box">
                                        <label class="text-xs text-[#8B0000] italic block mb-1">Date of
                                            completion:</label>
                                        <div class="date-input-wrap compact">
                                            <input type="text" id="orthoDate" name="ortho_date"
                                                class="form-input voice-small border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none w-full"
                                                placeholder="Select date" readonly>
                                            <i class="fa-regular fa-calendar date-input-icon"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-card">
                                    <p
                                        class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                        <i class="fa-regular fa-comment-dots text-xs"></i> Additional Concerns <span
                                            class="flex-1 h-px bg-[#f9e8e8]"></span>
                                    </p>
                                    <textarea name="additional_concerns" id="additional_concerns" rows="4"
                                        maxlength="150"
                                        class="form-input voice-full w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none resize-none"
                                        placeholder="Write any additional concerns here..."></textarea>
                                    <div class="flex justify-between items-center text-xs mt-1">
                                        <span id="concernWarning" class="text-red-500 hidden">
                                            Character limit reached
                                        </span>
                                        <span id="concernCount" class="text-[#9e9690]">0/150</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-content hidden">
                        <div class="booking-step-shell">
                            <div class="booking-step-header">
                                <p class="booking-step-eyebrow">Step 4 of 5</p>
                                <h2 class="booking-step-title">Medical History</h2>
                                <p class="booking-step-subtitle">
                                    Provide important medical information so the clinic can prepare safe and proper
                                    dental care for you.
                                </p>
                            </div>

                            <div class="booking-step-body">

                                <div class="section-card">
                                    <p class="section-card-title">
                                        <i class="fa-solid fa-heart-pulse text-xs"></i> General Health
                                        <span class="section-card-title-line"></span>
                                    </p>
                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                        <span>Question</span><span class="text-center">YES</span><span
                                            class="text-center">NO</span>
                                    </div>

                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                        <span class="question-text">Are you in good health?</span>
                                        <input type="radio" name="good_health" value="YES"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                            required>
                                        <input type="radio" name="good_health" value="NO"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                    </div>
                                    <div class="ml-6 mt-1 mb-2 hidden" id="good_health_box">
                                        <label class="text-xs text-[#8B0000] italic">If NO, please provide
                                            details:</label>
                                        <input type="text" name="good_health_details" maxlength="150"
                                            id="good_health_details"
                                            class="form-input mt-1 w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                            placeholder="Input here">
                                        <div class="text-right text-xs"><span id="goodHealthCount">0/150</span></div>
                                    </div>

                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                        <span class="question-text">When was your last medical examination?</span>
                                        <input type="radio" name="had_medical_exam" value="YES"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                            required>
                                        <input type="radio" name="had_medical_exam" value="NO"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                    </div>
                                    <div class="ml-6 mt-1 mb-2 hidden" id="medical_exam_box">
                                        <label class="text-xs text-[#8B0000] italic block mb-1">If YES, when was your
                                            last medical examination?</label>
                                        <div class="date-input-wrap compact">
                                            <input type="text" id="medicalExamDate" name="medical_exam_date"
                                                class="form-input voice-small border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none w-full"
                                                placeholder="Select date" readonly>
                                            <i class="fa-regular fa-calendar date-input-icon"></i>
                                        </div>
                                    </div>

                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                        <span class="question-text">Are you currently receiving treatment for any
                                            illness?</span>
                                        <input type="radio" name="under_treatment" value="YES"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                            required>
                                        <input type="radio" name="under_treatment" value="NO"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                    </div>
                                    <div class="ml-6 mt-1 mb-2 hidden" id="treatment_box">
                                        <label class="text-xs text-[#8B0000] italic">If YES, please specify:</label>
                                        <input type="text" name="treatment_details" maxlength="150"
                                            id="treatment_details"
                                            class="form-input mt-1 w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                            placeholder="Input here">
                                        <div class="text-right text-xs"><span id="treatmentCount">0/150</span></div>
                                    </div>

                                    <div class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 text-sm">
                                        <span class="question-text">Have you ever been hospitalized?</span>
                                        <input type="radio" name="hospitalized" value="YES"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                            required>
                                        <input type="radio" name="hospitalized" value="NO"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                    </div>
                                    <div class="ml-6 mt-1 mb-2 hidden" id="hospital_box">
                                        <label class="text-xs text-[#8B0000] italic">If YES, please provide
                                            details:</label>
                                        <input type="text" name="hospital_details" maxlength="150" id="hospital_details"
                                            class="form-input mt-1 w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                            placeholder="Input here">
                                        <div class="text-right text-xs"><span id="hospitalCount">0/150</span></div>
                                    </div>
                                </div>

                                <div class="section-card">
                                    <p class="section-card-title">
                                        <i class="fa-solid fa-triangle-exclamation text-xs"></i> Allergies
                                        <span class="section-card-title-line"></span>
                                    </p>
                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                        <span>Are you allergic to any of the following?</span><span
                                            class="text-center">YES</span><span class="text-center">NO</span>
                                    </div>
                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                        <span class="question-text">Medicines</span>
                                        <input type="radio" name="allergy_medicine" value="YES"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                            required>
                                        <input type="radio" name="allergy_medicine" value="NO"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                    </div>
                                    <div class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 text-sm">
                                        <span class="question-text">Food</span>
                                        <input type="radio" name="allergy_food" value="YES"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                            required>
                                        <input type="radio" name="allergy_food" value="NO"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                    </div>
                                    <div class="mt-3">
                                        <label class="text-xs text-[#8B0000] italic block mb-1">Others (please
                                            specify):</label>
                                        <input type="text" name="allergy_others"
                                            class="form-input voice-medium border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none w-full"
                                            placeholder="Input here">
                                    </div>
                                </div>

                                <div class="section-card">
                                    <p class="section-card-title">
                                        <i class="fa-solid fa-pills text-xs"></i> Medications
                                        <span class="section-card-title-line"></span>
                                    </p>
                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                        <span>Question</span><span class="text-center">YES</span><span
                                            class="text-center">NO</span>
                                    </div>
                                    <div class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 text-sm">
                                        <span class="question-text">Are you taking any prescription or non-prescription
                                            medication?</span>
                                        <input type="radio" name="medication" value="YES"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                            required>
                                        <input type="radio" name="medication" value="NO"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                    </div>
                                    <div class="ml-6 mt-1 mb-2 hidden" id="medication_box">
                                        <label class="text-xs text-[#8B0000] italic">If YES, please specify:</label>
                                        <input type="text" name="medication_details" maxlength="150"
                                            id="medication_details"
                                            class="form-input mt-1 w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                            placeholder="Input here">
                                        <div class="text-right text-xs"><span id="medicationCount">0/150</span></div>
                                    </div>
                                </div>

                                @if ($isFemalePatient)
                                <div class="section-card" id="forWomenSection">
                                    <p class="section-card-title">
                                        <i class="fa-solid fa-venus text-xs"></i> For Women Only
                                        <span class="section-card-title-line"></span>
                                    </p>
                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                        <span>Question</span><span class="text-center">YES</span><span
                                            class="text-center">NO</span>
                                    </div>

                                    @foreach ([['name' => 'pregnant', 'q' => 'Are you pregnant?'], ['name' => 'nursing',
                                    'q' => 'Are you nursing?'], ['name' => 'birth_control', 'q' => 'Are you taking birth
                                    control pills?']] as $i => $q)
                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 {{ $i < 2 ? 'border-b border-[#f0ebe6]' : '' }} text-sm">
                                        <span class="question-text">{{ $q['q'] }}</span>
                                        <input type="radio" name="{{ $q['name'] }}" value="YES"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                            required>
                                        <input type="radio" name="{{ $q['name'] }}" value="NO"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <input type="hidden" name="pregnant" value="NO">
                                <input type="hidden" name="nursing" value="NO">
                                <input type="hidden" name="birth_control" value="NO">
                                @endif

                                <div class="section-card mt-5">
                                    <p class="section-card-title">
                                        <i class="fa-solid fa-stethoscope text-xs"></i> Medical Conditions
                                        <span class="section-card-title-line"></span>
                                    </p>
                                    <p class="text-xs text-[#5c5550] mb-3">Please indicate below if you presently have
                                        or have ever had any of the following:</p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2.5 gap-x-6">
                                        @foreach ($diseases as $d)
                                        <label class="flex items-center gap-2.5 cursor-pointer">
                                            <input type="checkbox" name="diseases[]" value="{{ $d->code }}"
                                                class="w-4 h-4 rounded border-2 border-[#e8e2dd] cursor-pointer accent-[#8B0000] flex-shrink-0">
                                            <span class="text-[0.82rem] text-[#1a1410]">{{ $d->label }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="section-card">
                                    <p class="section-card-title">
                                        <i class="fa-solid fa-smoking text-xs"></i> Tobacco Use
                                        <span class="section-card-title-line"></span>
                                    </p>
                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                        <span>Question</span><span class="text-center">YES</span><span
                                            class="text-center">NO</span>
                                    </div>
                                    <div class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 text-sm">
                                        <span class="question-text">Do you use tobacco products or any
                                            derivatives?</span>
                                        <input type="radio" name="tobacco_use" value="YES"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                            required>
                                        <input type="radio" name="tobacco_use" value="NO"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                    </div>
                                    <div id="tobacco_details" class="ml-6 mt-2 space-y-2 hidden text-sm">
                                        <div class="flex items-center gap-3 flex-wrap">
                                            <span class="text-xs text-[#8B0000] italic w-28">How much per day:</span>
                                            <input type="text" name="tobacco_per_day" placeholder="Input here"
                                                class="form-input voice-small border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none w-full">
                                        </div>
                                        <div class="flex items-center gap-3 flex-wrap">
                                            <span class="text-xs text-[#8B0000] italic w-28">Per week:</span>
                                            <input type="text" name="tobacco_per_week" placeholder="Input here"
                                                class="form-input voice-small border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none w-full">
                                        </div>
                                    </div>
                                </div>

                                <div class="section-card">
                                    <p class="section-card-title">
                                        <i class="fa-solid fa-head-side-mask text-xs"></i> Do You Suffer From
                                        <span class="section-card-title-line"></span>
                                    </p>
                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                        <span>Condition</span><span class="text-center">YES</span><span
                                            class="text-center">NO</span>
                                    </div>
                                    @foreach ([['name' => 'headaches', 'q' => 'Headaches'], ['name' => 'earaches', 'q'
                                    => 'Earaches'], ['name' => 'neck_aches', 'q' => 'Neck aches']] as $i => $q)
                                    <div
                                        class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 {{ $i < 2 ? 'border-b border-[#f0ebe6]' : '' }} text-sm">
                                        <span class="question-text">{{ $q['q'] }}</span>
                                        <input type="radio" name="{{ $q['name'] }}" value="YES"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                            required>
                                        <input type="radio" name="{{ $q['name'] }}" value="NO"
                                            class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                    </div>
                                    @endforeach
                                </div>

                                <div class="section-card">
                                    <p class="section-card-title">
                                        <i class="fa-solid fa-phone-volume text-xs"></i> Emergency Contact
                                        <span class="section-card-title-line"></span>
                                    </p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-semibold text-[#333] mb-1.5">
                                                Person to contact in case of emergency
                                            </label>
                                            <input type="text" name="emergency_person" maxlength="50"
                                                class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                                placeholder="Full name" required>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-semibold text-[#333] mb-1.5">
                                                Contact Number
                                            </label>
                                            <input type="tel" id="emergency_number" name="emergency_number"
                                                maxlength="11"
                                                class="form-input border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none w-full"
                                                placeholder="09XXXXXXXXX" required>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-semibold text-[#333] mb-1.5">
                                                Relation to Patient <span class="required-star">*</span>
                                            </label>
                                            <div class="relative w-full">
                                                <select id="emergency_relation" name="emergency_relation"
                                                    class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none appearance-none pr-8"
                                                    required>
                                                    <option value="" disabled selected>Select relation</option>
                                                    <option value="Mother">Mother</option>
                                                    <option value="Father">Father</option>
                                                    <option value="Guardian">Guardian</option>
                                                    <option value="Spouse">Spouse</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                                <div class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center">
                                                    <i class="fa-solid fa-chevron-down text-[10px] text-[#5c5550]"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-semibold text-[#333] mb-1.5">
                                                Patient's Signature <span class="required-star">*</span>
                                            </label>

                                            <div class="file-upload-zone border-2 border-dashed border-[#e8e2dd] rounded-xl p-5 flex flex-col items-center justify-center text-center cursor-pointer min-h-[180px]">
                                                <i class="fa-regular fa-image text-gray-400 text-3xl mb-2"></i>

                                                <p class="text-xs text-[#5c5550] mb-1">
                                                    Select your file or drag and drop
                                                </p>
                                                <p class="text-xs text-[#9e9690] mb-3">
                                                    JPG, PNG, up to 25 MB
                                                </p>

                                                <label class="btn-primary-custom inline-flex items-center gap-1.5 bg-[#8B0000] text-white rounded-xl px-4 py-1.5 text-xs font-bold cursor-pointer">
                                                    <i class="fa-solid fa-upload"></i> Browse
                                                    <input type="file" name="patient_signature" id="patient_signature"
                                                        class="hidden" accept=".jpg,.jpeg,.png" required>
                                                </label>

                                                <p id="signature_filename"
                                                    class="text-xs text-[#5c5550] mt-2 hidden truncate"></p>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="step-content hidden" id="step5">
                        <div class="booking-step-shell">
                            <div id="summarySection">
                                <div class="booking-step-header">
                                    <p class="booking-step-eyebrow">Step 5 of 5</p>
                                    <h2 class="booking-step-title">Review Your Information</h2>
                                    <p class="booking-step-subtitle">
                                        Please review all the information you provided before proceeding to final
                                        confirmation.
                                    </p>
                                </div>

                                <div id="summaryBox" class="space-y-4"></div>

                                <div class="flex justify-center gap-3 mt-8 nav-btns-row">
                                    <button type="button" id="summaryBackBtn"
                                        class="btn-secondary-custom inline-flex items-center gap-2 border border-[#e8e2dd] rounded-xl px-6 py-2.5 text-sm font-semibold text-[#5c5550] bg-transparent">
                                        <i class="fa-solid fa-chevron-left text-xs"></i> Back
                                    </button>
                                    <button type="button" id="goToConfirmationBtn"
                                        class="btn-primary-custom inline-flex items-center gap-2 bg-[#8B0000] text-white rounded-xl px-6 py-2.5 text-sm font-bold">
                                        Proceed to Confirm <i class="fa-solid fa-chevron-right text-xs"></i>
                                    </button>
                                </div>
                            </div>

                            <div id="confirmationSection" class="hidden">
                                <div class="booking-step-header">
                                    <p class="booking-step-eyebrow">Step 5 of 5</p>
                                    <h2 class="booking-step-title">Final Confirmation</h2>
                                    <p class="booking-step-subtitle">
                                        Confirm that the information is accurate and that you accept the clinic terms
                                        and privacy policy.
                                    </p>
                                </div>

                                <div class="section-card mb-2">
                                    <div class="flex items-start gap-2 mb-4">
                                        <i class="fa-solid fa-shield-halved text-[#8B0000] mt-0.5"></i>
                                        <p class="text-sm text-[#5c5550]">
                                            By submitting, you confirm that all the information provided is accurate and
                                            complete.
                                        </p>
                                    </div>
                                    <label
                                        class="confirm-checkbox-wrap flex items-start gap-3 p-4 rounded-xl border border-[#e8e2dd] bg-[#fafaf8] cursor-pointer">
                                        <input id="finalConfirm" type="checkbox"
                                            class="w-5 h-5 rounded border-2 border-[#e8e2dd] bg-white cursor-pointer flex-shrink-0 mt-0.5 accent-[#8B0000]"
                                            required>
                                        <span class="text-sm text-[#1a1410] leading-relaxed">
                                            I have reviewed my dental and medical information and I accept the
                                            <a href="/privacy-policy"
                                                class="text-[#8B0000] hover:underline font-semibold">Privacy Policy</a>
                                            and
                                            <a href="/terms-of-service"
                                                class="text-[#8B0000] hover:underline font-semibold">Terms of
                                                Service</a>.
                                        </span>
                                    </label>
                                </div>

                                <div class="flex justify-center gap-3 mt-8 nav-btns-row">
                                    <button type="button" id="confirmBackBtn"
                                        class="btn-secondary-custom inline-flex items-center gap-2 border border-[#e8e2dd] rounded-xl px-6 py-2.5 text-sm font-semibold text-[#5c5550] bg-transparent">
                                        <i class="fa-solid fa-chevron-left text-xs"></i> Back
                                    </button>
                                    <button type="button" id="finalSubmitBtn"
                                        class="btn-primary-custom inline-flex items-center gap-2 bg-[#8B0000] text-white rounded-xl px-6 py-2.5 text-sm font-bold">
                                        <i class="fa-solid fa-check"></i> Submit Appointment
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="navBtns" class="flex justify-end mt-8 gap-3 nav-btns-row">
                        <button type="button" id="prevBtn" style="display:none;"
                            class="btn-secondary-custom inline-flex items-center gap-2 border border-[#e8e2dd] rounded-2xl px-6 py-3 text-sm font-semibold text-[#5c5550] bg-white shadow-sm">
                            <i class="fa-solid fa-chevron-left text-xs"></i> Previous
                        </button>

                        <button type="button" id="nextBtn"
                            class="btn-primary-custom inline-flex items-center gap-2 bg-[#8B0000] text-white rounded-2xl px-8 py-3 text-sm font-bold shadow-[0_10px_24px_rgba(139,0,0,0.18)]">
                            Next <i class="fa-solid fa-chevron-right text-xs"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="miniTab"
        class="mini-tab fixed left-1/2 -translate-x-1/2 bg-[#1a1410] text-white px-5 py-2.5 rounded-full text-sm font-semibold z-[200] shadow-xl flex items-center gap-2 whitespace-nowrap opacity-0 pointer-events-none"
        style="transition: opacity 0.25s;">
        <i class="fa-solid fa-circle-exclamation text-red-400"></i>
        <span id="miniTabText">Please complete all required fields.</span>
    </div>


    <dialog id="confirmModal"
        class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 m-0 border-0 p-0 rounded-2xl overflow-hidden shadow-[0_25px_60px_rgba(0,0,0,0.25)] max-w-[480px] w-[calc(100vw-2rem)]">
        <div class="bg-[#8B0000] px-8 py-10 text-center">
            <div class="w-16 h-16 rounded-full bg-white/15 flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-calendar-check text-white text-2xl"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-white mb-4">Appointment Confirmed!</h2>
            <p id="confirmMessage" class="text-white/85 text-sm leading-7 mb-6"></p>
            <button type="button" id="okBtn"
                class="bg-white text-[#8B0000] border-0 px-8 py-2.5 rounded-xl font-bold text-sm cursor-pointer">Back
                to
                Home</button>
        </div>
    </dialog>

    <dialog id="leaveModal"
        class="m-auto border-0 p-0 rounded-2xl overflow-hidden shadow-[0_25px_60px_rgba(0,0,0,0.25)] max-w-[440px] w-[calc(100vw-2rem)]">
        <div class="bg-[#8B0000] px-6 py-5">
            <h3 class="text-lg font-bold text-white mb-0.5">Leave this page?</h3>
            <p class="text-sm text-white/80">Your appointment form has unsaved changes. You can save your draft,
                discard it, or continue editing.</p>
        </div>
        <div class="bg-white px-6 py-5 flex justify-end gap-3 flex-wrap">
            <button type="button" id="cancelLeaveBtn"
                class="btn-secondary-custom inline-flex items-center gap-2 border border-[#e8e2dd] rounded-xl px-4 py-2 text-sm font-semibold text-[#5c5550] bg-transparent">
                Cancel
            </button>
            <button type="button" id="discardDraftBtn"
                class="btn-secondary-custom inline-flex items-center gap-2 border border-red-200 text-red-600 bg-red-50 hover:bg-red-100 rounded-xl px-4 py-2 text-sm font-semibold transition-colors">
                Discard
            </button>
            <button type="button" id="saveDraftBtn"
                class="btn-primary-custom inline-flex items-center gap-2 bg-[#8B0000] text-white rounded-xl px-5 py-2 text-sm font-bold">
                Save Draft
            </button>
        </div>
    </dialog>

    @include('components.appointment-calendar-script', [
    'mode' => 'booking',
    'renderStyle' => 'patient',
    'calendarContainerId' => 'calendarSkeletonContainer',
    'dateInputId' => 'appointment_date',
    'timeInputId' => 'appointment_time',
    'dateBannerId' => 'dateBanner',
    'slotPlaceholderId' => 'slotPlaceholder',
    'slotContainerId' => 'slotContainer',
    'slotGridId' => 'slotGrid',
    'selectedSlotDisplayId' => 'selectedSlotDisplay',
    'selectedSlotTextId' => 'selectedSlotText',
    'slotEndpoint' => route('book.appointment.slots'),
    'scheduleRules' => $schedules ?? [],
    'blockedDates' => $blockedDates ?? [],
    'appointmentCountsPerDay' => $appointmentCountsPerDay ?? [],
    'philippineHolidays' => $philippineHolidays ?? [],
    'useDynamicScheduleRules' => true,
    'disallowToday' => true,
    'allowToggleOffDate' => true,
    ])

    @include('partials.footer')
    @include('partials.patient.script')
    @include('partials.voice-logic')
    <script src="{{ asset('js/header.js') }}"></script>

    <script>
        const diseaseLabelByCode = @json($diseases -> pluck('label', 'code'));
        const isFemalePatient = @json($isFemalePatient);
        const DRAFT_KEY = "appointmentDraft:v1";

        function saveDraftData() {
            const form = document.getElementById("appointmentForm");
            if (!form) return;
            const data = new FormData(form),
                obj = {};
            for (const [key, value] of data.entries()) {
                if (key === "patient_signature") continue;
                if (obj[key] === undefined) obj[key] = value;
                else if (Array.isArray(obj[key])) obj[key].push(value);
                else obj[key] = [obj[key], value];
            }
            obj.__meta = {
                step: typeof step !== "undefined" ? step : 0,
                savedAt: new Date().toISOString()
            };
            localStorage.setItem(DRAFT_KEY, JSON.stringify(obj));
        }

        function clearDraft() {
            localStorage.removeItem(DRAFT_KEY);
        }

        document.getElementById("appointment_date")?.addEventListener("change", markFormDirty);
        document.getElementById("appointment_time")?.addEventListener("change", markFormDirty);

        document.querySelectorAll('input[name="service_type"]').forEach(radio => {
            radio.addEventListener("change", markFormDirty);
        });

        function restoreDraft() {
            const raw = localStorage.getItem(DRAFT_KEY);
            if (!raw) return;
            let obj;
            try {
                obj = JSON.parse(raw);
            } catch {
                return;
            }
            const form = document.getElementById("appointmentForm");
            if (!form) return;
            Object.keys(obj).forEach((name) => {
                if (name === "__meta") return;
                const value = obj[name];
                if (Array.isArray(value)) {
                    form.querySelectorAll(`[name="${CSS.escape(name)}"]`).forEach((el) => {
                        if (el.type === "checkbox") el.checked = value.includes(el.value);
                    });
                    return;
                }
                form.querySelectorAll(`[name="${CSS.escape(name)}"]`).forEach((el) => {
                    if (el.type === "radio") el.checked = (el.value === value);
                    else if (el.type === "checkbox") el.checked = (value === true || value === "on" ||
                        value === el.value);
                    else el.value = value;
                });
            });
            if (document.getElementById("emergency_relation")?.value === "Others") {
                const other = document.getElementById("relation_other");
                if (other) {
                    other.classList.remove("hidden");
                    other.setAttribute("required", "true");
                }
            }
            const restoredDate = document.getElementById("appointment_date")?.value;
            const restoredTime = document.getElementById("appointment_time")?.value;
            if (restoredDate) {
                selectedDate = restoredDate;
                selectDate(restoredDate);
                if (restoredTime) {
                    selectedTime = restoredTime;
                    document.querySelectorAll(".slot-chip").forEach(c => {
                        if (c.dataset.time === restoredTime) c.classList.add("selected");
                    });
                    const txt = document.getElementById("selectedSlotText");
                    const disp = document.getElementById("selectedSlotDisplay");
                    if (txt) txt.textContent = restoredTime;
                    if (disp) disp.classList.remove("hidden");
                }
            }
            formIsDirty = true;
        }

        const miniTab = document.getElementById("miniTab");
        const miniTabText = document.getElementById("miniTabText");

        function showMiniTab(msg) {
            if (!miniTab) return;
            miniTabText.textContent = msg || "Please complete all required fields.";
            miniTab.style.opacity = "1";
            miniTab.style.pointerEvents = "auto";
            clearTimeout(window.__mtTimer);
            window.__mtTimer = setTimeout(() => {
                miniTab.style.opacity = "0";
                miniTab.style.pointerEvents = "none";
            }, 3000);
        }

        function showInputError(input) {
            if (!input) return;
            input.classList.add("border-red-500");
            input.style.animation = "shake 0.3s ease";
            setTimeout(() => input.style.animation = "", 400);
        }

        let step = 0,
            completedSteps = [];
        const steps = document.querySelectorAll(".step-content");
        const navBtns = document.getElementById("navBtns");
        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");
        const summarySection = document.getElementById("summarySection");
        const confirmationSection = document.getElementById("confirmationSection");

        function updateStepperUI(i) {
            for (let idx = 0; idx < 5; idx++) {
                const circle = document.getElementById(`sc${idx + 1}`);
                const label = document.getElementById(`sl${idx + 1}`);
                const conn = document.getElementById(`conn${idx + 1}`);
                if (!circle || !label) continue;
                circle.className =
                    "step-circle w-10 h-10 rounded-full border-2 flex items-center justify-center text-sm font-bold";
                label.className =
                    "step-label text-[0.65rem] font-semibold uppercase tracking-wide text-center block w-full mt-4";
                if (idx < i && completedSteps.includes(idx)) {
                    circle.className += " border-green-700 bg-green-700 text-white";
                    label.className += " text-green-700";
                    circle.innerHTML = `<i class="fa-solid fa-check text-xs"></i>`;
                } else if (idx === i) {
                    circle.className +=
                        " border-blue-600 bg-blue-600 text-white shadow-[0_0_0_6px_rgba(37,99,235,0.12)] scale-110";
                    label.className += " text-blue-600";
                    circle.innerHTML = String(idx + 1);
                } else {
                    circle.className += " border-[#e8e2dd] bg-white text-[#9e9690]";
                    label.className += " text-[#9e9690]";
                    circle.innerHTML = String(idx + 1);
                }
                if (conn) {
                    conn.className = "h-0.5 flex-shrink-0 self-start step-connector ";
                    conn.style.width = window.innerWidth < 640 ? "8px" : "40px";
                    conn.style.marginTop = "20px";
                    conn.className += (idx < i && completedSteps.includes(idx)) ? "bg-green-700" : (idx === i ?
                        "bg-blue-600" : "bg-[#e8e2dd]");
                }
            }
            const fill = document.getElementById("headerProgressFill");
            if (fill) fill.style.width = (((i + 1) / 5) * 100) + "%";
            const counter = document.getElementById("stepCounterText");
            if (counter) counter.textContent = i + 1;
        }

        function showStep(i) {
            steps.forEach((s, idx) => {
                s.classList.remove("show");
                s.classList.add("hidden");
                if (idx === i) {
                    s.classList.remove("hidden");
                    setTimeout(() => s.classList.add("show"), 40);
                }
            });
            const isLast = i === steps.length - 1;
            navBtns.style.display = isLast ? "none" : "flex";
            prevBtn.style.display = i === 0 ? "none" : "inline-flex";
            nextBtn.style.display = isLast ? "none" : "inline-flex";
            if (isLast) {
                buildSummary();
                resetStep5View();
            }
            updateStepperUI(i);
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
            step = i;
        }

        function resetStep5View() {
            summarySection?.classList.remove("hidden");
            confirmationSection?.classList.add("hidden");
        }

        function scrollToInvalidTarget(target) {
            if (!target) return;

            const block =
                target.closest('.grid') ||
                target.closest('.ml-6') ||
                target.closest('.section-card') ||
                target.closest('.voice-input-wrap') ||
                target.closest('.date-input-wrap') ||
                target;

            block.scrollIntoView({
                behavior: "smooth",
                block: "center"
            });

            if (typeof target.focus === "function" && !target.hasAttribute("readonly")) {
                setTimeout(() => target.focus(), 250);
            }
        }

        function isStepComplete(s) {


            const stepEl = steps[s];
            if (!stepEl) return true;

            if (s === 0) {
                const dateInput = document.getElementById("appointment_date");
                const timeInput = document.getElementById("appointment_time");
                const slotArea = document.getElementById("slotContainer") || document.getElementById("slotPlaceholder");

                if (!dateInput?.value) {
                    showMiniTab("Please select a date first.");
                    scrollToInvalidTarget(document.getElementById("calendarSkeletonContainer"));
                    return false;
                }

                if (!timeInput?.value) {
                    showMiniTab("Please select a time slot.");
                    scrollToInvalidTarget(slotArea);
                    return false;
                }
            }

            if (s === 1) {
                const selectedService = stepEl.querySelector('input[name="service_type"]:checked');
                if (!selectedService) {
                    showMiniTab("Please select a service type.");
                    scrollToInvalidTarget(stepEl.querySelector(".service-step-grid"));
                    return false;
                }
            }

            const fields = stepEl.querySelectorAll(
                "input[required]:not([type='radio']):not([type='checkbox']):not([type='hidden']), select[required], textarea[required]"
            );

            for (const input of fields) {
                if (!input.value || !input.value.trim()) {
                    scrollToInvalidTarget(input);
                    return false;
                }
            }

            const radios = stepEl.querySelectorAll("input[type='radio']");
            if (radios.length) {
                const groups = [...new Set([...radios].map(r => r.name))];

                for (const name of groups) {
                    const checked = stepEl.querySelector(`input[name="${name}"]:checked`);
                    if (!checked) {
                        const firstRadio = stepEl.querySelector(`input[name="${name}"]`);
                        scrollToInvalidTarget(firstRadio);
                        return false;
                    }
                }
            }

            const phone = stepEl.querySelector("#emergency_number");
            if (phone) {
                const v = phone.value.trim();
                if (!/^\d{1,11}$/.test(v)) {
                    showMiniTab("Emergency Contact must be 1–11 digits only!");
                    scrollToInvalidTarget(phone);
                    return false;
                }
            }

            return true;
        }

        nextBtn?.addEventListener("click", () => {
            if (!isStepComplete(step)) {
                showMiniTab("Please complete all required fields before proceeding.");
                return;
            }
            if (!completedSteps.includes(step)) completedSteps.push(step);
            showStep(Math.min(step + 1, steps.length - 1));
        });
        prevBtn?.addEventListener("click", () => showStep(Math.max(step - 1, 0)));
        document.getElementById("summaryBackBtn")?.addEventListener("click", () => showStep(3));
        document.getElementById("goToConfirmationBtn")?.addEventListener("click", () => {
            summarySection?.classList.add("hidden");
            confirmationSection?.classList.remove("hidden");
            confirmationSection?.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });
        });
        document.getElementById("confirmBackBtn")?.addEventListener("click", () => {
            confirmationSection?.classList.add("hidden");
            summarySection?.classList.remove("hidden");
            summarySection?.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });
        });

        function setupCharLimit(inputId, counterId, max = 150, warningId = null) {
            const input = document.getElementById(inputId);
            const counter = document.getElementById(counterId);
            const warning = warningId ? document.getElementById(warningId) : null;

            if (!input || !counter) return;

            function updateUI() {
                let length = input.value.length;

                if (length > max) {
                    input.value = input.value.slice(0, max);
                    length = max;
                }

                counter.textContent = `${length}/${max}`;

                counter.classList.remove("text-red-600", "text-yellow-500");
                input.classList.remove("border-red-500", "ring-1", "ring-red-400");

                if (warning) warning.classList.add("hidden");

                if (length >= max) {
                    counter.classList.add("text-red-600");
                    input.classList.add("border-red-500", "ring-1", "ring-red-400");
                    if (warning) warning.classList.remove("hidden");
                } else if (length >= max - 10) {
                    counter.classList.add("text-yellow-500");
                }
            }

            input.addEventListener("input", updateUI);

            updateUI();
        }

        window.addEventListener("beforeunload", (e) => {
            if (formIsDirty && !formSubmitting) {
                e.preventDefault();
                e.returnValue = "";
            }
        });

        function markFormDirty() {
            formIsDirty = true;
        }

        setupCharLimit("additional_concerns", "concernCount", 150);

        function buildSummary() {
            const form = document.getElementById("appointmentForm");
            if (!form) return;

            const data = new FormData(form);
            const get = n => data.get(n) || "N/A";
            const getAll = n => data.getAll(n);

            const relation = data.get("emergency_relation") || "";
            const otherRel = (data.get("relation_other") || "").trim();
            const emergencyRelation = relation === "Others" ? (otherRel || "Others") : (relation || "N/A");

            const sigFile = data.get("patient_signature");
            let sigHTML = `<span class="text-[#9e9690] italic">Not uploaded</span>`;
            if (sigFile && sigFile.size > 0) {
                const url = URL.createObjectURL(sigFile);
                sigHTML = `<img src="${url}" alt="Signature" class="max-w-[220px] max-h-[130px] rounded-lg border border-[#e8e2dd]">`;
            }

            const row = (label, val) =>
                `<p><b class="text-[#5c5550] font-semibold">${label}:</b> ${val || '<span class="text-[#9e9690]">N/A</span>'}</p>`;

            const summaryCard = (title, icon, body) => `
                <div class="border border-[#e8e2dd] rounded-xl overflow-hidden bg-white">
                    <div class="bg-[#f9e8e8] px-4 py-2.5 text-xs font-bold text-[#8B0000] uppercase tracking-widest border-b border-[#e8e2dd]">
                        <i class="fa-solid ${icon} mr-2"></i>${title}
                    </div>
                    <div class="p-4 text-sm leading-7 text-[#1a1410] space-y-4">${body}</div>
                </div>
            `;

            const subSection = (title, body) => `
                <div class="rounded-xl border border-[#f1e8e3] bg-[#fffdfd] overflow-hidden">
                    <div class="px-4 py-2.5 bg-[#fff7f6] border-b border-[#f1e8e3] text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-[#8B0000]">
                        ${title}
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-2 gap-x-8 gap-y-1 sm-grid-1col">
                            ${body}
                        </div>
                    </div>
                </div>
            `;

            const fullWidthSection = (title, body) => `
                <div class="rounded-xl border border-[#f1e8e3] bg-[#fffdfd] overflow-hidden">
                    <div class="px-4 py-2.5 bg-[#fff7f6] border-b border-[#f1e8e3] text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-[#8B0000]">
                        ${title}
                    </div>
                    <div class="p-4 text-sm leading-7 text-[#1a1410]">
                        ${body}
                    </div>
                </div>
            `;

            const diseases = getAll("diseases[]");
            const diseaseText = diseases.length
                ? diseases.map(code => diseaseLabelByCode?.[code] ?? code).join(", ")
                : "None";

            const dentalHistoryBody = `
                ${subSection("Basic Info", `
                    ${row("Last Dental Visit", get("last_dental_visit"))}
                    ${row("Previous Dentist", get("previous_dentist"))}
                `)}

                ${subSection("Dental Symptoms", `
                    ${row("Bleeding Gums", get("bleeding_gums"))}
                    ${row("Sensitive (Hot/Cold)", get("sensitive_temp"))}
                    ${row("Sensitive (Sweets/Sour)", get("sensitive_taste"))}
                    ${row("Tooth Pain", get("tooth_pain"))}
                    ${row("Sores/Lumps", get("sores"))}
                    ${row("Jaw Injuries", get("injuries"))}
                `)}

                ${subSection("Jaw & Bite Symptoms", `
                    ${row("Clicking", get("clicking"))}
                    ${row("Joint Pain", get("joint_pain"))}
                    ${row("Difficulty Moving", get("difficulty_moving"))}
                    ${row("Difficulty Chewing", get("difficulty_chewing"))}
                    ${row("Frequent Headaches", get("jaw_headaches"))}
                    ${row("Grinding/Clenching", get("clench_grind"))}
                    ${row("Lips/Cheek Biting", get("biting"))}
                    ${row("Teeth Loosening", get("teeth_loosening"))}
                    ${row("Food Caught Between Teeth", get("food_teeth"))}
                    ${row("Medicine Reaction", get("med_reaction"))}
                `)}

                ${subSection("Dental Procedures", `
                    ${row("Periodontal Treatment", get("periodontal"))}
                    ${row("Difficult Extraction", get("difficult_extraction"))}
                    ${get("difficult_extraction") === "YES" ? row("Extraction Date", get("extraction_date")) : ""}

                    ${row("Prolonged Bleeding", get("prolonged_bleeding"))}
                    ${row("Dentures", get("dentures"))}
                    ${get("dentures") === "YES" ? row("Dentures Placement Date", get("dentures_date")) : ""}

                    ${row("Orthodontic Treatment", get("ortho_treatment"))}
                    ${get("ortho_treatment") === "YES" ? row("Orthodontic Completion Date", get("ortho_date")) : ""}
                `)}

                ${fullWidthSection("Additional Concerns", `
                    ${get("additional_concerns") !== "N/A"
                    ? get("additional_concerns")
                    : '<span class="text-[#9e9690] italic">No additional concerns provided.</span>'}
                `)}
            `;

            const medicalHistoryBody = `
                ${subSection("General Health", `
                    ${row("Good Health", get("good_health"))}
                    ${get("good_health") === "NO" ? row("Good Health Details", get("good_health_details")) : ""}

                    ${row("Had Medical Examination", get("had_medical_exam"))}
                    ${get("had_medical_exam") === "YES" ? row("Medical Examination Date", get("medical_exam_date")) : ""}

                    ${row("Under Treatment", get("under_treatment"))}
                    ${get("under_treatment") === "YES" ? row("Treatment Details", get("treatment_details")) : ""}

                    ${row("Hospitalized", get("hospitalized"))}
                    ${get("hospitalized") === "YES" ? row("Hospital Details", get("hospital_details")) : ""}
                `)}

                ${subSection("Allergies", `
                    ${row("Allergy (Medicine)", get("allergy_medicine"))}
                    ${row("Allergy (Food)", get("allergy_food"))}
                    ${row("Allergy (Others)", get("allergy_others"))}
                `)}

                ${subSection("Medications", `
                    ${row("Medication", get("medication"))}
                    ${get("medication") === "YES" ? row("Medication Details", get("medication_details")) : ""}
                `)}

                ${isFemalePatient ? subSection("For Women Only", `
                    ${row("Pregnant", get("pregnant"))}
                    ${row("Nursing", get("nursing"))}
                    ${row("Birth Control Pills", get("birth_control"))}
                `) : ""}

                ${fullWidthSection("Medical Conditions", `
                    <b class="text-[#5c5550] font-semibold">Selected Conditions:</b> ${diseaseText}
                `)}

                ${subSection("Tobacco Use", `
                    ${row("Tobacco Use", get("tobacco_use"))}
                    ${get("tobacco_use") === "YES" ? row("Tobacco Per Day", get("tobacco_per_day")) : ""}
                    ${get("tobacco_use") === "YES" ? row("Tobacco Per Week", get("tobacco_per_week")) : ""}
                `)}

                ${subSection("Do You Suffer From", `
                    ${row("Headaches", get("headaches"))}
                    ${row("Earaches", get("earaches"))}
                    ${row("Neck Aches", get("neck_aches"))}
                `)}
            `;

            document.getElementById("summaryBox").innerHTML = `
                <div class="grid grid-cols-2 gap-4 sm-grid-1col">
                    ${summaryCard("Appointment Details", "fa-calendar-check", `
                        <div class="grid grid-cols-1 gap-y-1">
                            ${row("Date", get("appointment_date"))}
                            ${row("Time", get("appointment_time"))}
                        </div>
                    `)}

                    ${summaryCard("Service", "fa-tooth", `
                        <div class="grid grid-cols-1 gap-y-1">
                            ${row("Type", get("service_type"))}
                        </div>
                    `)}
                </div>

                ${summaryCard("Dental History", "fa-teeth", dentalHistoryBody)}

                ${summaryCard("Medical History", "fa-heart-pulse", medicalHistoryBody)}

                <div class="grid grid-cols-2 gap-4 sm-grid-1col">
                    ${summaryCard("Emergency Contact", "fa-phone", `
                        <div class="grid grid-cols-1 gap-y-1">
                            ${row("Name", get("emergency_person"))}
                            ${row("Number", get("emergency_number"))}
                            ${row("Relation", emergencyRelation)}
                        </div>
                    `)}

                    ${summaryCard("Signature", "fa-signature", sigHTML)}
                </div>
            `;

            document.querySelectorAll(".sm-grid-1col").forEach(el => {
                if (window.innerWidth < 640) el.style.gridTemplateColumns = "1fr";
            });
        }

        const confirmModal = document.getElementById("confirmModal");
        const confirmMessage = document.getElementById("confirmMessage");
        const okBtn = document.getElementById("okBtn");

        const finalSubmitBtn = document.getElementById('finalSubmitBtn');
        const finalConfirm = document.getElementById('finalConfirm');

        if (finalSubmitBtn) {
            finalSubmitBtn.addEventListener("click", () => {
                if (!finalConfirm || !finalConfirm.checked) {
                    showMiniTab("Please confirm before submitting.");
                    return;
                }

                const date = document.getElementById("appointment_date")?.value || "N/A";
                const time = document.getElementById("appointment_time")?.value || "N/A";

                if (confirmMessage) {
                    confirmMessage.innerHTML = `
Your dental appointment at PUP Taguig Dental Clinic has been successfully scheduled on 
<b>${date}</b> at <b>${time}</b>.<br>
Please arrive on time and bring your school or office ID.
<br>
`;
                }
                confirmModal?.showModal();
            });
        }

        if (okBtn) {
            okBtn.addEventListener("click", () => {
                clearDraft();
                formSubmitting = true;
                document.getElementById("appointmentForm").submit();
            });
        }

        var html = document.documentElement;
        var themeToggleContainer = document.getElementById("themeToggle");

        ["lastDentalVisit", "extractionDate", "denturesDate", "orthoDate", "medicalExamDate"].forEach(id => {
            const el = document.getElementById(id);
            if (!el) return;

            flatpickr(el, {
                dateFormat: "Y-m-d",
                allowInput: false,
                disableMobile: true,
                static: false,
                maxDate: "today",
                prevArrow: '<i class="fa-solid fa-chevron-left"></i>',
                nextArrow: '<i class="fa-solid fa-chevron-right"></i>',

                onReady: function (selectedDates, dateStr, fp) {
                    const monthNames = [
                        "January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];

                    const currentMonthWrap = fp.calendarContainer.querySelector(
                        ".flatpickr-current-month");
                    if (!currentMonthWrap) return;

                    const oldMonth = currentMonthWrap.querySelector(".flatpickr-monthDropdown-months");
                    const oldYear = currentMonthWrap.querySelector(".numInputWrapper");

                    if (oldMonth) oldMonth.remove();
                    if (oldYear) oldYear.remove();

                    const customWrap = document.createElement("div");
                    customWrap.className = "custom-flatpickr-selects";

                    const monthSelect = document.createElement("select");
                    monthSelect.className = "custom-flatpickr-select";
                    monthNames.forEach((name, index) => {
                        const opt = document.createElement("option");
                        opt.value = index;
                        opt.textContent = name;
                        if (index === fp.currentMonth) opt.selected = true;
                        monthSelect.appendChild(opt);
                    });

                    const yearSelect = document.createElement("select");
                    yearSelect.className = "custom-flatpickr-select";

                    const currentYear = new Date().getFullYear();
                    for (let year = 1950; year <= currentYear; year++) {
                        const opt = document.createElement("option");
                        opt.value = year;
                        opt.textContent = year;
                        if (year === fp.currentYear) opt.selected = true;
                        yearSelect.appendChild(opt);
                    }

                    monthSelect.addEventListener("change", function () {
                        fp.changeMonth(parseInt(this.value, 10) - fp.currentMonth);
                    });

                    yearSelect.addEventListener("change", function () {
                        fp.changeYear(parseInt(this.value, 10));
                    });

                    customWrap.appendChild(monthSelect);
                    customWrap.appendChild(yearSelect);
                    currentMonthWrap.appendChild(customWrap);

                    fp._customMonthSelect = monthSelect;
                    fp._customYearSelect = yearSelect;
                },

                onMonthChange: function (selectedDates, dateStr, fp) {
                    if (fp._customMonthSelect) {
                        fp._customMonthSelect.value = fp.currentMonth;
                    }
                },

                onYearChange: function (selectedDates, dateStr, fp) {
                    if (fp._customYearSelect) {
                        fp._customYearSelect.value = fp.currentYear;
                    }
                },

                onChange: function (selectedDates, dateStr, fp) {
                    markFormDirty();
                    fp._input.dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                    fp._input.dispatchEvent(new Event('change', {
                        bubbles: true
                    }));
                },

                onDayCreate: function (dObj, dStr, fp, dayElem) {
                    const date = dayElem.dateObj;
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    const cmp = new Date(date);
                    cmp.setHours(0, 0, 0, 0);

                    if (cmp > today) {
                        dayElem.classList.add("flatpickr-future-disabled");
                        dayElem.setAttribute("data-tooltip", "You can't select a future date.");

                        const day = date.getDay();

                        dayElem.classList.remove("tooltip-left", "tooltip-right", "tooltip-center");

                        if (day >= 5) {
                            dayElem.classList.add("tooltip-left");
                        } else if (day <= 1) {
                            dayElem.classList.add("tooltip-right");
                        } else {
                            dayElem.classList.add("tooltip-center");
                        }
                    }
                }
            });
        });

        [{
            name: "difficult_extraction",
            boxId: "extraction_date_box",
            showOn: "YES"
        }, {
            name: "dentures",
            boxId: "dentures_date_box",
            showOn: "YES"
        }, {
            name: "ortho_treatment",
            boxId: "ortho_date_box",
            showOn: "YES"
        }].forEach(({
            name,
            boxId,
            showOn
        }) => {
            const radios = document.getElementsByName(name);
            const box = document.getElementById(boxId);
            if (!box || !radios.length) return;
            const inp = box.querySelector("input");
            radios.forEach(r => r.addEventListener("change", () => {
                if (r.checked && r.value === showOn) {
                    box.classList.remove("hidden");
                    if (inp) inp.required = true;
                } else if (r.checked) {
                    box.classList.add("hidden");
                    if (inp) {
                        inp.required = false;
                        inp.value = "";
                    }
                }
            }));
        });

        function syncMedicalExamBox() {
            const sel = document.querySelector('input[name="had_medical_exam"]:checked');
            const box = document.getElementById("medical_exam_box");
            const inp = document.getElementById("medicalExamDate");
            if (!sel || !box || !inp) return;
            if (sel.value === "YES") {
                box.classList.remove("hidden");
                inp.required = true;
            } else {
                box.classList.add("hidden");
                inp.required = false;
                inp.value = "";
            }
        }
        document.querySelectorAll('input[name="had_medical_exam"]').forEach(r => r.addEventListener("change",
            syncMedicalExamBox));
        syncMedicalExamBox();
        document.getElementById("emergency_relation")
            ?.addEventListener("change", function () {
                const other = document.getElementById("relation_other");
                if (!other) return;
                if (this.value === "Others") {
                    other.classList.remove("hidden");
                    other.setAttribute("required", "true");
                } else {
                    other.classList.add("hidden");
                    other.removeAttribute("required");
                    other.value = "";
                }
            });
        [{
            name: "good_health",
            boxId: "good_health_box",
            showOn: "NO"
        }, {
            name: "under_treatment",
            boxId: "treatment_box",
            showOn: "YES"
        }, {
            name: "hospitalized",
            boxId: "hospital_box",
            showOn: "YES"
        }, {
            name: "medication",
            boxId: "medication_box",
            showOn: "YES"
        }].forEach(({
            name,
            boxId,
            showOn
        }) => {
            const radios = document.getElementsByName(name);
            const box = document.getElementById(boxId);
            if (!box || !radios.length) return;
            radios.forEach(r => r.addEventListener("change", () => {
                const sel = [...radios].find(x => x.checked);
                const inputs = box.querySelectorAll("input");
                if (sel?.value === showOn) {
                    box.classList.remove("hidden");
                    inputs.forEach(i => i.required = true);
                } else {
                    box.classList.add("hidden");
                    inputs.forEach(i => {
                        i.required = false;
                        i.value = "";
                    });
                }
            }));
        });
        [...document.getElementsByName("tobacco_use")].forEach(r => r.addEventListener("change", () => {
            if (r.checked && r.value === "YES") document.getElementById("tobacco_details")?.classList
                .remove(
                    "hidden");
            else document.getElementById("tobacco_details")?.classList.add("hidden");
        }));
        const sigInput = document.getElementById("patient_signature");
        const sigName = document.getElementById("signature_filename");

        sigInput?.addEventListener("change", () => {
            const file = sigInput.files?.[0];

            if (!file) {
                sigName.textContent = "";
                sigName.classList.add("hidden");
                return;
            }

            const allowedTypes = ["image/jpeg", "image/png"];
            const maxSize = 25 * 1024 * 1024;

            if (!allowedTypes.includes(file.type)) {
                showMiniTab("Signature must be a JPG or PNG file.");
                sigInput.value = "";
                sigName.textContent = "";
                sigName.classList.add("hidden");
                return;
            }

            if (file.size > maxSize) {
                showMiniTab("Signature file must not exceed 25 MB.");
                sigInput.value = "";
                sigName.textContent = "";
                sigName.classList.add("hidden");
                return;
            }

            const img = new Image();
            const objectUrl = URL.createObjectURL(file);

            img.onload = function () {
                const { width, height } = img;

                if (width < 120 || height < 60) {
                    showMiniTab("Signature image is too small. Please upload a clearer signature.");
                    sigInput.value = "";
                    sigName.textContent = "";
                    sigName.classList.add("hidden");
                    URL.revokeObjectURL(objectUrl);
                    return;
                }

                if (width > 5000 || height > 5000) {
                    showMiniTab("Signature image is too large. Please upload a smaller image.");
                    sigInput.value = "";
                    sigName.textContent = "";
                    sigName.classList.add("hidden");
                    URL.revokeObjectURL(objectUrl);
                    return;
                }

                sigName.textContent = file.name;
                sigName.classList.remove("hidden");
                URL.revokeObjectURL(objectUrl);
            };

            img.onerror = function () {
                showMiniTab("Invalid signature image file.");
                sigInput.value = "";
                sigName.textContent = "";
                sigName.classList.add("hidden");
                URL.revokeObjectURL(objectUrl);
            };

            img.src = objectUrl;
        });
        const emergencyNumber = document.getElementById("emergency_number");
        emergencyNumber?.addEventListener(
            "input", e => {
                if (/[^0-9]/.test(e.target.value)) {
                    showMiniTab("Contact number must contain digits only.");
                    showInputError(emergencyNumber);
                }
                let v = e.target.value.replace(/\D/g, "");
                if (v.startsWith("9")) v = "0" + v;
                v = v.slice(0, 11);
                emergencyNumber.value = v;
                if (/^09\d{9}$/.test(v)) {
                    emergencyNumber.classList.remove("border-red-500");
                    emergencyNumber.classList.add("border-green-600");
                } else emergencyNumber.classList.remove("border-green-600");
            });
        emergencyNumber?.addEventListener("blur", () => {
            if (!emergencyNumber.value) emergencyNumber.classList.remove("border-red-500", "border-green-600");
        });

        let formIsDirty = false;
        let formSubmitting = false;
        let pendingNavigation = null;

        const leaveModal = document.getElementById('leaveModal');

        document.querySelectorAll('input, textarea, select').forEach(input => {
            input.addEventListener('input', () => {
                formIsDirty = true;
            });
        });
        document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(input => {
            input.addEventListener('change', () => {
                formIsDirty = true;
            });
        });

        function openLeaveModal(onConfirm) {
            pendingNavigation = onConfirm;
            leaveModal.showModal();
        }

        function confirmReloadPage() {
            openLeaveModal(() => {
                window.location.reload();
            });
        }

        function closeLeaveModal() {
            if (leaveModal.open) leaveModal.close();
            pendingNavigation = null;
        }

        document.getElementById('cancelLeaveBtn')?.addEventListener('click', closeLeaveModal);

        document.getElementById('saveDraftBtn')?.addEventListener('click', () => {
            saveDraftData();
            formIsDirty = false;
            leaveModal.close();

            if (typeof pendingNavigation === "function") {
                const action = pendingNavigation;
                pendingNavigation = null;
                action();
            }
        });

        document.getElementById('discardDraftBtn')?.addEventListener('click', () => {
            clearDraft();
            formIsDirty = false;
            leaveModal.close();

            if (typeof pendingNavigation === "function") {
                const action = pendingNavigation;
                pendingNavigation = null;
                action();
            }
        });

        document.querySelectorAll('a[href]').forEach(link => {
            link.addEventListener("click", e => {
                const href = link.getAttribute("href") || "";

                if (href.startsWith("#") || href.startsWith("javascript:") || link.type === 'submit')
                    return;

                if (formIsDirty && !formSubmitting) {
                    e.preventDefault();
                    openLeaveModal(() => {
                        window.location.href = link.href;
                    });
                }
            });
        });

        showStep(0);
        restoreDraft();

        window.addEventListener("resize", () => {
            document.querySelectorAll(".sm-grid-1col").forEach(el => {
                el.style.gridTemplateColumns = window.innerWidth < 640 ? "1fr" : "1fr 1fr";
            });
        });

        setupCharLimit("additional_concerns", "concernCount", 150, "concernWarning");
        setupCharLimit(
            "good_health_details", "goodHealthCount", 150);
        setupCharLimit("treatment_details", "treatmentCount",
            150);
        setupCharLimit("hospital_details", "hospitalCount", 150);
        setupCharLimit("medication_details",
            "medicationCount", 150);

        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll(".question-text").forEach(q => {
                const row = q.closest("div");
                const hasRequiredRadio = row?.querySelector("input[required]");

                if (hasRequiredRadio && !q.querySelector(".required-star")) {
                    const star = document.createElement("span");
                    star.className = "required-star";
                    star.textContent = " *";
                    q.appendChild(star);
                }
            });

            document.querySelectorAll("input[required], select[required], textarea[required]").forEach(input => {
                if (input.tagName === "INPUT" && input.type === "hidden") return;

                let label = null;

                if (input.id) {
                    label = document.querySelector(`label[for="${input.id}"]`);
                }

                if (!label) {
                    label = input.closest("label");
                }

                if (!label) {
                    const fieldContainer = input.closest(
                        ".space-y-4 > div, .grid > div, .ml-6, .mt-3, .mt-2, .date-input-wrap, .voice-input-wrap"
                    );
                    label = fieldContainer?.parentElement?.querySelector(":scope > label") || null;
                }

                if (!label) {
                    const previous = input.previousElementSibling;
                    if (previous && previous.tagName === "LABEL") {
                        label = previous;
                    }
                }

                if (label && !label.querySelector(".required-star")) {
                    const star = document.createElement("span");
                    star.className = "required-star";
                    star.textContent = " *";
                    label.appendChild(star);
                }
            });
        });
    </script>
</body>

</html>