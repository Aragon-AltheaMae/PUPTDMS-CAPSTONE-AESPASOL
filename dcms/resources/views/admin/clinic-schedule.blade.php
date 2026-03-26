@extends('layouts.admin')

@section('title', 'Clinic Schedule | PUP Taguig Dental Clinic')

@section('styles')
    <style>
        /* TOAST */
        #toastContainer {
            position: fixed !important;
            top: 20px !important;
            right: 20px !important;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }

        #toastContainer .toast {
            min-width: 300px;
            max-width: 360px;
            background: white !important;
            border-radius: 14px !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, .18) !important;
            padding: 14px 18px 14px 16px !important;
            display: flex !important;
            align-items: center !important;
            gap: 12px;
            opacity: 0;
            transform: translateX(340px);
            transition: all .35s cubic-bezier(.68, -.55, .265, 1.55);
            position: relative;
            overflow: hidden;
            pointer-events: all;
            flex-direction: row !important;
        }

        #toastContainer .toast::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
        }

        #toastContainer .toast.error::before {
            background: #8B0000 !important;
        }

        #toastContainer .toast.success::before {
            background: #15803d !important;
        }

        #toastContainer .toast.show {
            opacity: 1 !important;
            transform: translateX(0) !important;
        }

        #toastContainer .toast.hide {
            opacity: 0 !important;
            transform: translateX(340px) !important;
        }

        #toastContainer .toast-icon-wrap {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        #toastContainer .toast.error .toast-icon-wrap {
            background: rgba(139, 0, 0, .08);
        }

        #toastContainer .toast.success .toast-icon-wrap {
            background: rgba(21, 128, 61, .08);
        }

        #toastContainer .toast-icon {
            font-size: 17px;
        }

        #toastContainer .toast.error .toast-icon {
            color: #8B0000 !important;
        }

        #toastContainer .toast.success .toast-icon {
            color: #15803d !important;
        }

        #toastContainer .toast-body {
            flex: 1;
            min-width: 0;
        }

        #toastContainer .toast-title {
            font-size: 13px;
            font-weight: 700;
            color: #1A0A0A !important;
        }

        #toastContainer .toast-msg {
            font-size: 12px;
            color: #888 !important;
            margin-top: 2px;
            line-height: 1.4;
        }

        #toastContainer .toast-close {
            background: none !important;
            border: none;
            cursor: pointer;
            color: #CCC;
            font-size: 13px;
            flex-shrink: 0;
            padding: 2px 4px;
        }

        .field-error {
            font-size: .72rem;
            color: #b91c1c;
            margin-top: .4rem;
            display: none;
            line-height: 1.35;
        }

        .field-error.show {
            display: block;
        }

        .form-ctrl.is-invalid,
        .form-sel.is-invalid,
        .day-toggle-group.is-invalid,
        .break-chip-group.is-invalid {
            border-color: #dc2626 !important;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, .08) !important;
        }

        .day-toggle-group.is-invalid {
            padding: .5rem;
            border: 1.5px solid #dc2626;
            border-radius: 10px;
            background: #fff7f7;
        }

        .break-chip-group.is-invalid {
            padding: .5rem;
            border: 1.5px solid #dc2626;
            border-radius: 10px;
            background: #fff7f7;
        }

        .stat-card {
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, .1);
        }

        .sched-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sched-table thead tr {
            background: linear-gradient(135deg, #6b0000, #8B0000);
        }

        .sched-table thead th {
            color: #fff;
            font-size: .72rem;
            font-weight: 700;
            padding: 10px 14px;
            text-align: left;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .sched-table tbody tr {
            border-bottom: 1px solid #f8f4f4;
            transition: background .12s;
        }

        .sched-table tbody tr:hover {
            background: #fef5f5;
        }

        .sched-table tbody td {
            padding: 11px 14px;
            font-size: .8rem;
            color: #374151;
            vertical-align: middle;
        }

        .badge-open {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            padding: 2px 10px;
            border-radius: 999px;
            font-size: .68rem;
            font-weight: 700;
        }

        .badge-closed {
            background: #f1f5f9;
            color: #64748b;
            border: 1px solid #e2e8f0;
            padding: 2px 10px;
            border-radius: 999px;
            font-size: .68rem;
            font-weight: 700;
        }

        .badge-limited {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
            padding: 2px 10px;
            border-radius: 999px;
            font-size: .68rem;
            font-weight: 700;
        }

        .badge-holiday {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
            padding: 2px 10px;
            border-radius: 999px;
            font-size: .68rem;
            font-weight: 700;
        }

        .cap-bar {
            height: 6px;
            border-radius: 999px;
            background: #f0e8e8;
            overflow: hidden;
        }

        .cap-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, #8B0000, #c9a84c);
            transition: width .4s ease;
        }

        .week-grid {
            display: grid;
            grid-template-columns: 80px repeat(7, 1fr);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #f0e8e8;
        }

        .wk-hdr {
            padding: 10px 6px;
            text-align: center;
            font-size: .72rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #6b0000, #8B0000);
            border-right: 1px solid rgba(255, 255, 255, .15);
        }

        .wk-hdr.empty {
            background: #fafafa;
            border-right: 1px solid #f0e8e8;
        }

        .wk-hdr.weekend-hdr {
            background: linear-gradient(135deg, #4a0000, #6b0000);
        }

        .wk-hdr.today-hdr {
            background: linear-gradient(135deg, #8B0000, #c9a84c);
        }

        .time-lbl {
            font-size: .65rem;
            font-weight: 600;
            color: #9ca3af;
            padding: 8px;
            border-bottom: 1px solid #f8f4f4;
            display: flex;
            align-items: center;
            border-right: 1px solid #f0e8e8;
            background: #fafafa;
        }

        .cal-slot {
            border-bottom: 1px solid #f8f4f4;
            border-right: 1px solid #f8f4f4;
            min-height: 54px;
            position: relative;
            transition: background .15s;
            cursor: pointer;
            padding: 2px;
            overflow: hidden;
        }

        .cal-slot:hover {
            background: #fef5f5;
        }

        .cal-slot.wk-closed {
            background: #f8f8f8;
            cursor: not-allowed;
            opacity: .6;
        }

        .cal-slot.wk-break {
            background: repeating-linear-gradient(45deg, #f8f8f8, #f8f8f8 6px, #fff 6px, #fff 12px);
            cursor: not-allowed;
        }

        .cal-slot.wk-weekend {
            background: #fcfcfc;
            cursor: not-allowed;
        }

        .slot-label {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .6rem;
            color: #d1d5db;
            font-weight: 600;
            pointer-events: none;
        }

        .modal-hdr {
            background: linear-gradient(135deg, #6b0000, #8B0000);
            padding: 1.25rem 1.5rem;
            color: #fff;
            position: sticky;
            top: 0;
            z-index: 10;
            border-radius: 20px 20px 0 0;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .form-label {
            font-size: .72rem;
            font-weight: 700;
            color: #5c5550;
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: .4rem;
            display: block;
        }

        .form-ctrl {
            width: 100%;
            border: 1.5px solid #e8e2dd;
            border-radius: 10px;
            padding: 8px 12px;
            font-size: .82rem;
            color: #1a1410;
            background: #fff;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
            font-family: 'Inter', sans-serif;
        }

        .form-ctrl:focus {
            border-color: #8B0000;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, .08);
        }

        .form-sel {
            appearance: none;
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            padding-right: 32px;
        }

        .break-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 8px;
            border: 1.5px solid #e8e2dd;
            font-size: .72rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
            background: #fafaf8;
            color: #5c5550;
            user-select: none;
        }

        .break-chip:hover {
            border-color: #8B0000;
            color: #8B0000;
            background: #fef2f2;
        }

        .break-chip.selected {
            background: #f59e0b;
            color: #fff;
            border-color: #f59e0b;
        }

        .day-toggle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 2px solid #e8e2dd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .7rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s;
            color: #9ca3af;
            background: #fff;
            user-select: none;
        }

        .day-toggle:hover {
            border-color: #8B0000;
            color: #8B0000;
        }

        .day-toggle.active {
            background: #8B0000;
            border-color: #8B0000;
            color: #fff;
        }

        [data-theme="dark"] .sched-table tbody tr {
            border-color: #21262d;
        }

        [data-theme="dark"] .sched-table tbody tr:hover {
            background: #1c2128;
        }

        [data-theme="dark"] .sched-table tbody td {
            color: #d1d5db;
        }

        [data-theme="dark"] .week-grid {
            border-color: #21262d;
        }

        [data-theme="dark"] .time-lbl {
            background: #0d1117;
            color: #6b7280;
            border-color: #21262d;
        }

        [data-theme="dark"] .cal-slot {
            border-color: #1c2128;
        }

        [data-theme="dark"] .cal-slot:hover {
            background: rgba(139, 0, 0, .1);
        }

        [data-theme="dark"] .modal-box {
            background: #161b22;
        }

        [data-theme="dark"] .form-ctrl {
            background: #0d1117;
            border-color: #30363d;
            color: #e6edf3;
        }

        [data-theme="dark"] .break-chip {
            background: #0d1117;
            border-color: #30363d;
            color: #8b949e;
        }

        [data-theme="dark"] .day-toggle {
            background: #0d1117;
            border-color: #30363d;
            color: #8b949e;
        }

        @media (max-width: 767px) {

            #toastContainer {
                left: .75rem !important;
                right: .75rem !important;
                top: 14px !important;
            }

            #toastContainer .toast {
                min-width: 0;
                max-width: none;
                width: 100%;
                transform: translateY(-20px);
            }

            #toastContainer .toast.show {
                transform: translateY(0) !important;
            }

            #toastContainer .toast.hide {
                transform: translateY(-20px) !important;
            }

            .page-actions {
                width: 100%;
                flex-direction: column;
                align-items: stretch;
            }

            .page-actions button {
                width: 100%;
                justify-content: center;
            }

            #mainContent {
                padding-left: .75rem !important;
                padding-right: .75rem !important;
                padding-top: 78px !important;
                padding-bottom: 1rem !important;
            }

            .stat-card {
                padding: .9rem;
            }

            .stat-card p.text-3xl {
                font-size: 1.5rem !important;
                line-height: 1.1;
            }

            /* top action buttons */
            .mb-6 .flex.items-center.gap-3,
            .mb-6 .flex.flex-col.sm\:flex-row.sm\:items-center.sm\:justify-between.gap-3>div:last-child {
                width: 100%;
                flex-direction: column;
                align-items: stretch;
            }

            .mb-6 .flex.items-center.gap-3 button,
            .mb-6 .flex.flex-col.sm\:flex-row.sm\:items-center.sm\:justify-between.gap-3>div:last-child button {
                width: 100%;
                justify-content: center;
            }

            /* week view */
            .week-grid {
                min-width: 640px;
            }

            .weekly-toolbar {
                flex-wrap: wrap;
                gap: .5rem;
                justify-content: flex-start;
            }

            .weekly-toolbar #weekRangeLabel {
                order: -1;
                width: 100%;
                text-align: left;
                padding: 0;
            }

            #weekRangeLabel {
                min-width: 0 !important;
                font-size: .7rem !important;
            }

            #todayBtn {
                padding: .35rem .55rem !important;
                font-size: .62rem !important;
            }

            /* legend */
            .p-4 .flex.flex-wrap.gap-3.mt-3.justify-end {
                justify-content: flex-start !important;
                gap: .5rem .75rem !important;
            }

            /* schedule table to cards */
            .sched-table thead {
                display: none;
            }

            .sched-table,
            .sched-table tbody,
            .sched-table tr,
            .sched-table td {
                display: block;
                width: 100%;
            }

            .sched-table tbody tr {
                margin: .5rem 0;
                padding: .75rem .8rem;
                border: 1px solid #f1ece8;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, .04);
                background: #fff;
            }

            .sched-table tbody td {
                padding: .24rem 0;
                font-size: .76rem;
            }

            .sched-table tbody td:last-child {
                padding-top: .6rem;
            }

            .sched-table tbody td[data-label="Actions"] {
                padding-top: .45rem;
            }

            .sched-table tbody td[data-label="Actions"] .flex {
                gap: .45rem;
            }

            .sched-table tbody td[data-label="Actions"] .w-7.h-7 {
                width: 2.25rem !important;
                height: 2.25rem !important;
            }

            .cap-bar.w-16 {
                width: 3rem !important;
            }

            .badge-open,
            .badge-closed,
            .badge-limited {
                font-size: .62rem;
                padding: 2px 8px;
            }

            .sched-table tbody td::before {
                content: attr(data-label);
                display: block;
                font-size: .1rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: .05em;
                color: #9ca3af;
            }

            /* right column cards tighter */
            .space-y-6>.bg-white {
                border-radius: 14px;
            }

            /* modals */
            .modal-backdrop {
                align-items: flex-end;
            }

            .modal-box {
                width: 100vw !important;
                max-width: 100vw !important;
                max-height: 92vh;
                border-radius: 18px 18px 0 0;
            }

            .modal-hdr {
                border-radius: 18px 18px 0 0;
                padding: 1rem 1rem;
            }

            .modal-body {
                padding: 1rem;
            }

            .modal-body .grid.grid-cols-2 {
                grid-template-columns: 1fr;
            }

            .modal-body .flex.justify-end.gap-3 {
                flex-direction: column-reverse;
            }

            .modal-body .flex.justify-end.gap-3>button {
                width: 100%;
                justify-content: center;
            }

            .day-toggle-group,
            .break-chip-group {
                gap: .5rem;
            }

            .break-chip {
                width: 100%;
                justify-content: center;
            }
        }

        .modal-kicker {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            font-size: .68rem;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .82);
            margin-bottom: .55rem;
        }

        .modal-title-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
        }

        .modal-title-block h3 {
            margin: 0;
        }

        .modal-title-sub {
            font-size: .82rem;
            color: rgba(255, 255, 255, .78);
            margin-top: .3rem;
            line-height: 1.45;
        }

        .modal-close-btn {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, .18);
            background: rgba(255, 255, 255, .12);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all .18s ease;
            flex-shrink: 0;
        }

        .modal-close-btn:hover {
            background: rgba(255, 255, 255, .2);
            transform: translateY(-1px);
        }

        .modal-section {
            background: #fff;
            border: 1px solid #f1e7e4;
            border-radius: 18px;
            padding: .8rem;
            box-shadow: 0 4px 14px rgba(0, 0, 0, .03);
        }

        .modal-section+.modal-section {
            margin-top: 1rem;
        }

        .modal-section-head {
            display: flex;
            align-items: center;
            gap: .65rem;
            margin-bottom: .9rem;
        }

        .modal-section-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: #fef2f2;
            color: #8B0000;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .modal-section-title {
            font-size: .88rem;
            font-weight: 800;
            color: #2f1b1b;
            line-height: 1.2;
        }

        .modal-section-sub {
            font-size: .72rem;
            color: #9a8f8c;
            margin-top: .15rem;
        }

        .form-label {
            font-size: .69rem;
            font-weight: 800;
            color: #6c5f5a;
            text-transform: uppercase;
            letter-spacing: .07em;
            margin-bottom: .45rem;
        }

        .form-ctrl {
            min-height: 44px;
            border: 1.5px solid #eadfd9;
            border-radius: 12px;
            padding: 10px 13px;
            background: #fff;
            font-size: .84rem;
        }

        .form-ctrl:focus {
            border-color: #8B0000;
            box-shadow: 0 0 0 4px rgba(139, 0, 0, .08);
        }

        .form-help {
            font-size: .7rem;
            color: #9b948f;
            margin-top: .4rem;
        }

        .day-toggle-group {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            gap: .5rem;
        }

        .day-toggle {
            width: 100%;
            height: 46px;
            border-radius: 14px;
            border: 1.5px solid #eadfd9;
            background: #fffdfc;
            font-size: .78rem;
            font-weight: 800;
        }

        .day-toggle.active {
            background: linear-gradient(135deg, #8B0000, #b91c1c);
            border-color: #8B0000;
            color: #fff;
            box-shadow: 0 8px 18px rgba(139, 0, 0, .18);
        }

        .break-chip-group {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: .65rem;
        }

        .break-chip {
            justify-content: center;
            min-height: 46px;
            border-radius: 14px;
            font-size: .76rem;
            font-weight: 700;
            text-align: center;
            padding: .7rem .8rem;
        }

        .break-chip.selected {
            background: linear-gradient(135deg, #f59e0b, #f97316);
            border-color: #f59e0b;
            color: #fff;
            box-shadow: 0 10px 18px rgba(245, 158, 11, .18);
        }

        .slot-stepper {
            display: inline-flex;
            align-items: center;
            gap: .75rem;
            background: #fffaf8;
            border: 1px solid #efe3dd;
            border-radius: 16px;
            padding: .45rem;
        }

        .slot-stepper-btn {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            border: 1px solid #e5d6d0;
            background: #fff;
            color: #6b5d57;
            font-size: 1.05rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all .15s ease;
        }

        .slot-stepper-btn:hover {
            border-color: #8B0000;
            color: #8B0000;
            background: #fef2f2;
        }

        .slot-stepper-input {
            width: 82px !important;
            min-width: 82px;
            text-align: center;
            font-size: 1.05rem !important;
            font-weight: 800 !important;
            border-radius: 12px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: .75rem;
            padding-top: 1rem;
            margin-top: 1rem;
            border-top: 1px solid #efe8e4;
        }

        .btn-soft {
            min-height: 44px;
            padding: 0 1rem;
            border-radius: 12px;
            border: 1px solid #e5deda;
            background: #fff;
            color: #6b635f;
            font-size: .84rem;
            font-weight: 700;
            transition: all .15s ease;
        }

        .btn-soft:hover {
            background: #faf7f5;
            border-color: #d9cdc7;
        }

        .btn-primary {
            min-height: 44px;
            padding: 0 1rem;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #8B0000, #b91c1c);
            color: #fff;
            font-size: .84rem;
            font-weight: 800;
            box-shadow: 0 10px 22px rgba(139, 0, 0, .18);
            transition: all .18s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 26px rgba(139, 0, 0, .22);
        }

        [data-theme="dark"] .modal-box.modal-form {
            background: #161b22;
            border-color: #2a2f36;
        }

        [data-theme="dark"] .modal-body.modal-form-body {
            background: linear-gradient(to bottom, #161b22, #12171d);
        }

        [data-theme="dark"] .modal-section {
            background: #0d1117;
            border-color: #2a2f36;
        }

        [data-theme="dark"] .modal-section-title {
            color: #f3f4f6;
        }

        [data-theme="dark"] .modal-section-sub,
        [data-theme="dark"] .form-help {
            color: #8b949e;
        }

        [data-theme="dark"] .form-ctrl {
            background: #0d1117;
            border-color: #30363d;
            color: #e6edf3;
        }

        [data-theme="dark"] .day-toggle {
            background: #0d1117;
            border-color: #30363d;
            color: #c9d1d9;
        }

        [data-theme="dark"] .break-chip {
            background: #0d1117;
            border-color: #30363d;
            color: #c9d1d9;
        }

        [data-theme="dark"] .slot-stepper {
            background: #11161c;
            border-color: #2a2f36;
        }

        [data-theme="dark"] .slot-stepper-btn {
            background: #0d1117;
            border-color: #30363d;
            color: #c9d1d9;
        }

        [data-theme="dark"] .btn-soft {
            background: #0d1117;
            border-color: #30363d;
            color: #c9d1d9;
        }

        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            z-index: 200;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity .2s;
            padding: 1rem;
            overflow-y: auto;
        }

        .modal-backdrop.open {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-backdrop.open .modal-box {
            transform: scale(1) translateY(0);
        }

        .modal-box {
            width: min(720px, calc(100vw - 2rem));
            max-height: calc(100dvh - 2rem);
            overflow-y: auto;
            overflow-x: hidden;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .2);
            transform: scale(.96) translateY(10px);
            transition: transform .2s;
            padding: 0 !important;
        }

        .modal-box.modal-form {
            width: min(760px, calc(100vw - 2rem));
            max-height: calc(100dvh - 2rem);
            border-radius: 24px;
            border: none;
            overflow: hidden;
            padding: 0 !important;
            background: #fff;
        }

        .modal-box.modal-form.modal-compact {
            width: min(520px, calc(100vw - 2rem));
        }

        .modal-hdr.modal-form-hdr {
            background:
                radial-gradient(circle at top right, rgba(255, 255, 255, .16), transparent 32%),
                linear-gradient(135deg, #6b0000, #8B0000 65%, #b91c1c);
            padding: 1.1rem 1.35rem .95rem;
            border-radius: 24px 24px 0 0;
            margin: 0;
        }

        .modal-body.modal-form-body {
            padding: 1.15rem;
            background: linear-gradient(to bottom, #fff, #fffdfc);
            max-height: calc(100dvh - 170px);
            overflow-y: auto;
            overflow-x: hidden;
        }

        @media (max-width: 767px) {

            .holiday-item {
                gap: .65rem;
                padding: .6rem 0;
            }

            .holiday-date-box {
                width: 34px;
            }

            .holiday-date-box .month {
                font-size: .56rem;
            }

            .holiday-date-box .day {
                font-size: 1rem;
            }

            .holiday-title {
                font-size: .72rem;
                line-height: 1.25;
            }

            .holiday-meta {
                font-size: .62rem;
            }

            .holiday-badge {
                font-size: .58rem;
                padding: 2px 7px;
            }

            .blocked-list-item {
                gap: .65rem;
                padding: .65rem 0;
            }

            .blocked-date-pill {
                width: 34px;
                height: 34px;
                font-size: .7rem;
                border-radius: 10px;
            }

            .blocked-title {
                font-size: .72rem;
                line-height: 1.25;
            }

            .blocked-note {
                font-size: .62rem;
                margin-top: .15rem;
            }

            .blocked-remove-btn {
                width: 28px;
                height: 28px;
            }

            .modal-backdrop {
                align-items: flex-end;
                padding: 0;
            }

            .modal-box {
                width: min(100vw, 420px) !important;
                max-width: 100vw !important;
                max-height: min(84dvh, 700px);
                border-radius: 18px 18px 0 0;
                margin: 0 auto;
            }

            .modal-box.modal-form,
            .modal-box.modal-form.modal-compact {
                width: 100vw !important;
                max-width: 100vw !important;
                max-height: 86dvh;
                border-radius: 18px 18px 0 0;
                margin: 0;
            }

            .modal-hdr,
            .modal-hdr.modal-form-hdr {
                border-radius: 18px 18px 0 0;
                padding: .95rem 1rem .9rem;
            }

            .modal-body,
            .modal-body.modal-form-body {
                padding: .9rem;
            }

            .modal-title-sub {
                font-size: .76rem;
                line-height: 1.35;
            }

            .modal-section {
                padding: .8rem;
                border-radius: 14px;
            }

            .modal-section+.modal-section {
                margin-top: .75rem;
            }

            .modal-section-head {
                margin-bottom: .7rem;
            }

            .modal-section-icon {
                width: 30px;
                height: 30px;
                border-radius: 9px;
            }

            .day-toggle-group {
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: .4rem;
            }

            .day-toggle {
                height: 40px;
                border-radius: 12px;
                font-size: .74rem;
            }

            .break-chip-group {
                grid-template-columns: 1fr;
                gap: .5rem;
            }

            .break-chip {
                min-height: 42px;
                padding: .6rem .75rem;
                font-size: .74rem;
            }

            .slot-stepper {
                width: 100%;
                gap: .5rem;
                padding: .35rem;
                border-radius: 14px;
            }

            .slot-stepper-btn {
                width: 38px;
                height: 38px;
            }

            .slot-stepper-input {
                width: 72px !important;
                min-width: 72px;
                font-size: .95rem !important;
            }

            .modal-footer {
                flex-direction: column-reverse;
                gap: .5rem;
                padding-top: .85rem;
                margin-top: .85rem;
            }

            .modal-footer>button {
                width: 100%;
                justify-content: center;
            }
        }

        .blocked-remove-btn {
            width: 30px;
            height: 30px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #b8b8b8;
            background: #fff;
            border: 1px solid #f1e5e5;
            transition: all .15s ease;
        }

        .blocked-remove-btn:hover {
            color: #dc2626;
            background: #fef2f2;
            border-color: #fecaca;
        }
    </style>
@endsection

@section('content')
    @php
        $openRules = $schedules->where('status', '!=', 'closed');
        $openDays = $openRules->sum(fn($s) => count($s->days ?? []));
        $maxSlots = $openRules->max('max_slots') ?? 0;
        $blockedThisMonth = $blockedDates->filter(fn($b) => \Carbon\Carbon::parse($b->date)->isCurrentMonth())->count();
        $holidaysThisMonth = collect($philippineHolidays)
            ->filter(fn($name, $date) => \Carbon\Carbon::parse($date)->isCurrentMonth())
            ->count();

        $scheduleByDay = [];
        foreach ($schedules as $s) {
            foreach ($s->days ?? [] as $d) {
                $scheduleByDay[$d] = $s;
            }
        }

        $dayNames = [
            'Monday' => 'Mon',
            'Tuesday' => 'Tue',
            'Wednesday' => 'Wed',
            'Thursday' => 'Thu',
            'Friday' => 'Fri',
            'Saturday' => 'Sat',
            'Sunday' => 'Sun',
        ];

        $breakSchedule = $openRules->first(fn($s) => $s->break_time && $s->break_time !== 'none');
    @endphp

    <main id="mainContent" class="px-4 sm:px-6 pt-[82px] pb-8 min-h-screen">
        <div class="max-w-[1280px] mx-auto">

            @if ($errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const hasRuleErrors =
                            @json(
                                $errors->has('days') ||
                                    $errors->has('status') ||
                                    $errors->has('open_time') ||
                                    $errors->has('close_time') ||
                                    $errors->has('max_slots') ||
                                    $errors->has('notes'));

                        const hasBlockErrors =
                            @json($errors->has('date') || $errors->has('reason') || $errors->has('note'));

                        if (hasRuleErrors) {
                            openRuleModal();
                        }

                        if (hasBlockErrors) {
                            openBlockModal();
                        }

                        @if ($errors->has('days'))
                            setFieldError('ruleDaysError', @json($errors->first('days')), null, 'ruleDaysGroup');
                        @endif
                        @if ($errors->has('status'))
                            setFieldError('ruleStatusError', @json($errors->first('status')), 'ruleStatus');
                        @endif
                        @if ($errors->has('open_time'))
                            setFieldError('ruleOpenTimeError', @json($errors->first('open_time')), 'ruleOpenTime');
                        @endif
                        @if ($errors->has('close_time'))
                            setFieldError('ruleCloseTimeError', @json($errors->first('close_time')), 'ruleCloseTime');
                        @endif
                        @if ($errors->has('max_slots'))
                            setFieldError('ruleMaxSlotsError', @json($errors->first('max_slots')), 'ruleMaxSlots');
                        @endif
                        @if ($errors->has('notes'))
                            setFieldError('ruleNotesError', @json($errors->first('notes')), 'ruleNotes');
                        @endif

                        @if ($errors->has('date'))
                            setFieldError('blockDateError', @json($errors->first('date')), 'blockDate');
                        @endif
                        @if ($errors->has('reason'))
                            setFieldError('blockReasonError', @json($errors->first('reason')), 'blockReason');
                        @endif
                        @if ($errors->has('note'))
                            setFieldError('blockNoteError', @json($errors->first('note')), 'blockNote');
                        @endif
                    });
                </script>
            @endif

            {{-- ── Title row ── --}}
            <div class="mb-6 mt-3">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-extrabold text-[#8B0000]">Clinic Schedule</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <button onclick="openRuleModal()"
                            class="flex items-center gap-2 bg-[#8B0000] hover:bg-[#760000] text-white px-4 py-2.5 rounded-xl font-semibold text-sm shadow transition-all">
                            <i class="fa-solid fa-plus"></i> Add Schedule Rule
                        </button>
                        <button onclick="openBlockModal()"
                            class="flex items-center gap-2 bg-white hover:bg-red-50 text-[#8B0000] border border-red-200 px-4 py-2.5 rounded-xl font-semibold text-sm shadow-sm transition-all">
                            <i class="fa-solid fa-ban"></i> Block Date
                        </button>
                    </div>
                </div>
            </div>

            {{-- ── Stat cards ── --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                @php
                    $statCards = [
                        [
                            'icon' => 'fa-calendar-days',
                            'color' => 'from-[#8B0000] to-[#6B0000]',
                            'val' => $openDays,
                            'label' => 'Open Days/Week',
                            'sub' => 'Active schedule days',
                        ],
                        [
                            'icon' => 'fa-clock',
                            'color' => 'from-blue-500 to-blue-600',
                            'val' => $maxSlots,
                            'label' => 'Daily Slot Cap',
                            'sub' => 'Max patients/day',
                        ],
                        [
                            'icon' => 'fa-ban',
                            'color' => 'from-green-500 to-green-600',
                            'val' => $blockedThisMonth,
                            'label' => 'Blocked
        Dates',
                            'sub' => 'This month',
                        ],
                        [
                            'icon' => 'fa-umbrella-beach',
                            'color' => 'from-amber-500
        to-amber-600',
                            'val' => $holidaysThisMonth,
                            'label' => 'Holidays',
                            'sub' => 'This month',
                        ],
                    ];
                @endphp
                @foreach ($statCards as $card)
                    <div class="stat-card bg-white rounded-xl p-4 shadow border border-gray-100 overflow-hidden relative">
                        <div
                            class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-gray-100 to-transparent rounded-full -mr-10 -mt-10">
                        </div>
                        <div class="relative">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $card['color'] }} flex items-center justify-center shadow mb-3">
                                <i class="fa-solid {{ $card['icon'] }} text-white text-sm"></i>
                            </div>
                            <p class="text-[10px] uppercase tracking-wide text-gray-500 font-semibold mb-0.5">
                                {{ $card['label'] }}</p>
                            <p class="text-3xl font-extrabold text-gray-800">{{ $card['val'] }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">{{ $card['sub'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ── Main two-column grid ── --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

                {{-- LEFT: weekly calendar + rules table --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Weekly view --}}
                    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                        <div class="px-5 py-4 border-b bg-gray-50 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-calendar-week text-[#8B0000]"></i>
                                <h2 class="font-bold text-gray-800 text-sm">Weekly Appointment View</h2>
                            </div>
                            <div class="flex items-center gap-2">
                                <button id="prevWeek"
                                    class="w-7 h-7 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:border-[#8B0000] hover:text-[#8B0000] transition-all text-xs"><i
                                        class="fa-solid fa-chevron-left"></i></button>
                                <span id="weekRangeLabel"
                                    class="text-xs font-semibold text-gray-600 px-1 min-w-[140px] text-center"></span>
                                <button id="nextWeek"
                                    class="w-7 h-7 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:border-[#8B0000] hover:text-[#8B0000] transition-all text-xs"><i
                                        class="fa-solid fa-chevron-right"></i></button>
                                <button id="todayBtn"
                                    class="text-[10px] font-bold text-[#8B0000] bg-red-50 border border-red-200 px-2.5 py-1 rounded-lg hover:bg-red-100 transition-colors">Today</button>
                            </div>
                        </div>
                        <div class="p-4 overflow-x-auto">
                            <div id="weekGrid" class="week-grid" style="min-width:480px;"></div>
                            <div class="flex flex-wrap gap-3 mt-3 justify-end">
                                <div class="flex items-center gap-1.5 text-xs text-gray-500"><span
                                        class="w-3 h-3 rounded bg-blue-200 border-l-2 border-blue-500 inline-block"></span>Check-up
                                </div>
                                <div class="flex items-center gap-1.5 text-xs text-gray-500"><span
                                        class="w-3 h-3 rounded bg-green-200 border-l-2 border-green-500 inline-block"></span>Cleaning
                                </div>
                                <div class="flex items-center gap-1.5 text-xs text-gray-500"><span
                                        class="w-3 h-3 rounded bg-yellow-100 border-l-2 border-yellow-400 inline-block"></span>Surgery
                                </div>
                                <div class="flex items-center gap-1.5 text-xs text-gray-500"><span
                                        class="w-3 h-3 rounded bg-purple-100 border-l-2 border-purple-400 inline-block"></span>Prosthesis
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Schedule rules table --}}
                    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                        <div class="px-5 py-4 border-b bg-gray-50 flex items-center justify-between">
                            <div class="weekly-toolbar flex items-center gap-2">
                                <i class="fa-solid fa-list-check text-[#8B0000]"></i>
                                <h2 class="font-bold text-gray-800 text-sm">Schedule Rules</h2>
                            </div>
                            <span class="text-xs text-gray-400 font-medium">{{ $schedules->count() }} rules</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="sched-table">
                                <thead>
                                    <tr>
                                        <th>Day(s)</th>
                                        <th>Opens</th>
                                        <th>Closes</th>
                                        <th>Lunch Break</th>
                                        <th>Max Slots</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($schedules as $rule)
                                        <tr>
                                            <td data-label="Day(s)" class="font-semibold text-gray-800">
                                                {{ $rule->days_label }}</td>
                                            <td data-label="Opens">
                                                {{ $rule->open_time ? date('g:i A', strtotime($rule->open_time)) : '—' }}
                                            </td>
                                            <td data-label="Closes">
                                                {{ $rule->close_time ? date('g:i A', strtotime($rule->close_time)) : '—' }}
                                            </td>
                                            <td data-label="Lunch Break" class="text-xs text-gray-500">
                                                @if ($rule->break_time && $rule->break_time !== 'none')
                                                    @php [$bs,$be]=explode('-',$rule->break_time); @endphp
                                                    {{ date('g:i A', strtotime(trim($bs) . ':00')) }} –
                                                    {{ date('g:i A', strtotime(trim($be) . ':00')) }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td data-label="Max Slots">
                                                <div class="flex items-center gap-2">
                                                    <span class="font-bold text-[#8B0000]">{{ $rule->max_slots }}</span>
                                                    @if ($rule->status !== 'closed')
                                                        <div class="cap-bar w-16">
                                                            <div class="cap-fill"
                                                                style="width:{{ min(100, ($rule->max_slots / 10) * 100) }}%">
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td data-label="Status">
                                                @if ($rule->status === 'open')
                                                    <span class="badge-open">Open</span>
                                                @elseif($rule->status === 'limited')
                                                    <span class="badge-limited">Limited</span>
                                                @else
                                                    <span class="badge-closed">Closed</span>
                                                @endif
                                            </td>
                                            <td data-label="Actions">
                                                <div class="flex items-center gap-1.5">
                                                    <button
                                                        onclick='openRuleModal("edit",{{ $rule->id }},{{ json_encode($rule) }})'
                                                        class="w-7 h-7 rounded-lg bg-blue-50 border border-blue-200 flex items-center justify-center text-blue-600 hover:bg-blue-100 text-xs"
                                                        title="Edit">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </button>

                                                    <form action="{{ route('admin.clinic_schedule.destroy', $rule) }}"
                                                        method="POST" onsubmit="return confirm('Delete this rule?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="w-7 h-7 rounded-lg bg-red-50 border border-red-200 flex items-center justify-center text-red-600 hover:bg-red-100 text-xs"
                                                            title="Delete">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-10">
                                                <i
                                                    class="fa-solid fa-calendar-xmark text-3xl text-gray-300 mb-2 block"></i>
                                                <p class="text-gray-400 text-sm">No rules yet. <button
                                                        onclick="openRuleModal()"
                                                        class="text-[#8B0000] font-semibold hover:underline">Add
                                                        one.</button></p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                {{-- RIGHT: Clinic Hours | Blocked Dates | Holidays --}}
                <div class="space-y-6">

                    {{-- Clinic Hours --}}
                    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                        <div class="px-5 py-4 border-b bg-gray-50 flex items-center justify-between">
                            <div class="flex items-center gap-2"><i class="fa-solid fa-clock text-[#8B0000]"></i>
                                <h2 class="font-bold text-gray-800 text-sm">Clinic Hours</h2>
                            </div>
                            <button onclick="openRuleModal()"
                                class="text-xs text-[#8B0000] font-semibold hover:underline flex items-center gap-1"><i
                                    class="fa-solid fa-pen text-[9px]"></i> Edit</button>
                        </div>
                        <div class="p-4 space-y-0.5">
                            @foreach ($dayNames as $fullName => $abbr)
                                @php $s = $scheduleByDay[$abbr] ?? null; @endphp
                                <div
                                    class="flex justify-between items-center py-1.5 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                                    <span class="text-xs font-semibold text-gray-600">{{ $fullName }}</span>
                                    @if ($s && $s->status !== 'closed')
                                        <span class="text-xs font-bold text-[#8B0000]">{{ $s->hours_range }}</span>
                                    @else
                                        <span class="text-xs font-medium text-gray-400">Closed</span>
                                    @endif
                                </div>
                            @endforeach
                            @if ($breakSchedule)
                                <div class="pt-2 mt-1 border-t border-gray-100">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-400 italic flex items-center gap-1"><i
                                                class="fa-solid fa-mug-hot text-yellow-400"></i> Lunch</span>
                                        @php [$bs,$be]=explode('-',$breakSchedule->break_time); @endphp
                                        <span
                                            class="text-xs font-medium text-gray-500">{{ date('g:i A', strtotime(trim($bs) . ':00')) }}
                                            – {{ date('g:i A', strtotime(trim($be) . ':00')) }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Blocked Dates --}}
                    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                        <div class="px-5 py-4 border-b bg-gray-50 flex items-center justify-between">
                            <div class="flex items-center gap-2"><i class="fa-solid fa-ban text-[#8B0000]"></i>
                                <h2 class="font-bold text-gray-800 text-sm">Blocked Dates</h2>
                            </div>
                            <button onclick="openBlockModal()"
                                class="text-xs text-[#8B0000] font-semibold hover:underline flex items-center gap-1"><i
                                    class="fa-solid fa-plus text-[9px]"></i> Add</button>
                        </div>
                        <div class="p-4">
                            @forelse($blockedDates as $blocked)
                                @php
                                    $bd = \Carbon\Carbon::parse($blocked->date);
                                    $badgeCls = match ($blocked->reason) {
                                        'Holiday' => 'badge-holiday',
                                        'Dentist Unavailable' => 'badge-limited',
                                        default => 'badge-closed',
                                    };
                                @endphp
                                <div
                                    class="blocked-list-item flex items-start gap-3 py-2.5 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                                    <div
                                        class="blocked-date-pill w-9 h-9 rounded-lg bg-red-50 border border-red-100 flex items-center justify-center flex-shrink-0 text-[#8B0000] text-xs font-bold">
                                        {{ $bd->day }}</div>
                                    <div class="flex-1 min-w-0">
                                        <p class="blocked-title text-xs font-bold text-gray-800 truncate">
                                            {{ $bd->format('D, M j, Y') }}
                                        </p>
                                        <span
                                            class="{{ $badgeCls }} mt-0.5 inline-block">{{ $blocked->reason }}</span>
                                        @if ($blocked->note)
                                            <p class="blocked-note text-[10px] text-gray-400 mt-0.5 italic truncate">
                                                {{ $blocked->note }}
                                            </p>
                                        @endif
                                    </div>
                                    <form action="{{ route('admin.clinic_schedule.unblock', $blocked) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="blocked-remove-btn" title="Remove">
                                            <i class="fa-solid fa-xmark text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <div class="text-center py-6"><i
                                        class="fa-solid fa-check-circle text-3xl text-green-400 mb-2 block"></i>
                                    <p class="text-xs text-gray-400">No blocked dates</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Upcoming Holidays --}}
                    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                        <div class="px-5 py-4 border-b bg-gray-50">
                            <div class="flex items-center gap-2"><i class="fa-solid fa-umbrella-beach text-[#8B0000]"></i>
                                <h2 class="font-bold text-gray-800 text-sm">Upcoming Holidays</h2>
                            </div>
                        </div>
                        <div class="p-4">
                            @php
                                $today = now()->startOfDay();
                                $MONTHS_SHORT = [
                                    'Jan',
                                    'Feb',
                                    'Mar',
                                    'Apr',
                                    'May',
                                    'Jun',
                                    'Jul',
                                    'Aug',
                                    'Sep',
                                    'Oct',
                                    'Nov',
                                    'Dec',
                                ];
                                $upcoming = collect($philippineHolidays)
                                    ->filter(fn($n, $d) => \Carbon\Carbon::parse($d)->gte($today))
                                    ->take(5);
                            @endphp
                            @forelse($upcoming as $hDate => $hName)
                                @php
                                    $hC = \Carbon\Carbon::parse($hDate);
                                    $diff = (int) $today->diffInDays($hC, false);
                                @endphp
                                <div
                                    class="holiday-item flex items-center gap-3 py-2 border-b border-gray-50 last:border-b-0">
                                    <div class="w-10 text-center flex-shrink-0">
                                        <div class="month text-[10px] font-bold uppercase text-[#8B0000]">
                                            {{ $MONTHS_SHORT[$hC->month - 1] }}</div>
                                        <div class="day text-xl font-extrabold text-gray-800 leading-tight">
                                            {{ $hC->day }}</div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="holiday-title text-xs font-semibold text-gray-800 truncate">
                                            {{ $hName }}</p>
                                        <p class="holiday-meta text-[10px] text-gray-400">
                                            {{ $diff === 0 ? 'Today' : ($diff === 1 ? 'Tomorrow' : "In $diff days") }}
                                        </p>
                                    </div>
                                    <span class="holiday-badge badge-holiday flex-shrink-0">Holiday</span>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 text-center py-4">No upcoming holidays.</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <div id="appointmentDetailModal" class="modal-backdrop" onclick="closeAppointmentDetailModal()">
        <div class="modal-box" onclick="event.stopPropagation()">
            <div class="modal-hdr">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold">Appointment Details</h3>
                        <p class="text-sm text-white/70 mt-0.5">Selected booked slot information</p>
                    </div>
                    <button onclick="closeAppointmentDetailModal()"
                        class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white hover:bg-white/30">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>
            </div>

            <div class="modal-body">
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Patient Name</label>
                        <div id="detailPatientName" class="form-ctrl bg-gray-50">—</div>
                    </div>

                    <div>
                        <label class="form-label">Service Type</label>
                        <div id="detailServiceType" class="form-ctrl bg-gray-50">—</div>
                    </div>

                    <div>
                        <label class="form-label">Schedule</label>
                        <div id="detailSchedule" class="form-ctrl bg-gray-50">—</div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 mt-4 border-t border-gray-100">
                    <button type="button" onclick="closeAppointmentDetailModal()"
                        class="px-5 py-2 rounded-xl bg-[#8B0000] hover:bg-[#760000] text-white text-sm font-bold shadow">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="ruleModalBackdrop" class="modal-backdrop" onclick="closeRuleModal()">
        <div class="modal-box modal-form" onclick="event.stopPropagation()">
            <div class="modal-hdr modal-form-hdr">
                <div class="modal-kicker">
                    <i class="fa-solid fa-calendar-plus"></i>
                    Schedule Manager
                </div>

                <div class="modal-title-row">
                    <div class="modal-title-block">
                        <h3 class="text-xl font-extrabold" id="ruleModalTitle">Add Schedule Rule</h3>
                        <p class="modal-title-sub">Choose clinic days, set operating hours, and control booking capacity.
                        </p>
                    </div>

                    <button type="button" onclick="closeRuleModal()" class="modal-close-btn">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            <div class="modal-body modal-form-body">
                <form id="ruleForm" method="POST" action="{{ route('admin.clinic_schedule.store') }}">
                    @csrf
                    <div id="ruleMethodField"></div>

                    <div class="modal-section">
                        <div class="modal-section-head">
                            <div class="modal-section-icon">
                                <i class="fa-solid fa-calendar-days"></i>
                            </div>
                            <div>
                                <div class="modal-section-title">Applicable Days</div>
                                <div class="modal-section-sub">Select one or more days for this rule.</div>
                            </div>
                        </div>

                        <label class="form-label">Select Days <span class="text-red-400">*</span></label>
                        <div id="ruleDaysGroup" class="day-toggle-group mt-1">
                            @foreach (['Mon' => 'M', 'Tue' => 'T', 'Wed' => 'W', 'Thu' => 'Th', 'Fri' => 'F', 'Sat' => 'S', 'Sun' => 'Su'] as $abbr => $lbl)
                                <div class="day-toggle" data-day="{{ $abbr }}" onclick="toggleDay(this)">
                                    {{ $lbl }}
                                </div>
                            @endforeach
                        </div>
                        <div class="form-help">You can apply one schedule to multiple weekdays.</div>
                        <div id="ruleDaysError" class="field-error"></div>
                    </div>

                    <div class="modal-section">
                        <div class="modal-section-head">
                            <div class="modal-section-icon">
                                <i class="fa-solid fa-hospital-user"></i>
                            </div>
                            <div>
                                <div class="modal-section-title">Clinic Availability</div>
                                <div class="modal-section-sub">Define whether the clinic is open, closed, or limited.</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="ruleStatus">Clinic Status</label>
                            <select id="ruleStatus" class="form-ctrl form-sel" onchange="toggleStatusFields(this.value)">
                                <option value="open">Open</option>
                                <option value="closed">Closed</option>
                                <option value="limited">Limited Hours</option>
                            </select>
                            <div id="ruleStatusError" class="field-error"></div>
                        </div>

                        <div id="ruleTimeFields">
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="form-label" for="ruleOpenTime">Opening Time</label>
                                    <select id="ruleOpenTime" class="form-ctrl form-sel">
                                        <option value="07:00">7:00 AM</option>
                                        <option value="08:00">8:00 AM</option>
                                        <option value="09:00" selected>9:00 AM</option>
                                        <option value="10:00">10:00 AM</option>
                                    </select>
                                    <div id="ruleOpenTimeError" class="field-error"></div>
                                </div>

                                <div>
                                    <label class="form-label" for="ruleCloseTime">Closing Time</label>
                                    <select id="ruleCloseTime" class="form-ctrl form-sel">
                                        <option value="15:00">3:00 PM</option>
                                        <option value="16:00">4:00 PM</option>
                                        <option value="17:00" selected>5:00 PM</option>
                                        <option value="18:00">6:00 PM</option>
                                    </select>
                                    <div id="ruleCloseTimeError" class="field-error"></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Lunch Break</label>
                                <div id="ruleBreakGroup" class="break-chip-group">
                                    <div class="break-chip selected" data-val="12:00-13:00" onclick="selectBreak(this)">
                                        12:00 – 1:00 PM
                                    </div>
                                    <div class="break-chip" data-val="13:00-14:00" onclick="selectBreak(this)">
                                        1:00 – 2:00 PM
                                    </div>
                                    <div class="break-chip" data-val="none" onclick="selectBreak(this)">
                                        <i class="fa-solid fa-ban text-[10px]"></i> No Break
                                    </div>
                                </div>
                                <div id="ruleBreakError" class="field-error"></div>
                            </div>

                            <div>
                                <label class="form-label" for="ruleMaxSlots">Max Appointments / Day</label>
                                <div class="slot-stepper">
                                    <button type="button" onclick="adjSlots(-1)" class="slot-stepper-btn">−</button>
                                    <input type="number" id="ruleMaxSlots" class="form-ctrl slot-stepper-input"
                                        value="5" min="1" max="30">
                                    <button type="button" onclick="adjSlots(1)" class="slot-stepper-btn">+</button>
                                </div>
                                <div class="form-help">Set how many appointments may be accepted for this schedule.</div>
                                <div id="ruleMaxSlotsError" class="field-error"></div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-section">
                        <div class="modal-section-head">
                            <div class="modal-section-icon">
                                <i class="fa-solid fa-note-sticky"></i>
                            </div>
                            <div>
                                <div class="modal-section-title">Additional Notes</div>
                                <div class="modal-section-sub">Optional reminder for holidays, special hours, or
                                    exceptions.</div>
                            </div>
                        </div>

                        <label class="form-label" for="ruleNotes">Notes (optional)</label>
                        <textarea id="ruleNotes" class="form-ctrl resize-none" rows="3"
                            placeholder="e.g. Reduced operations due to holiday program, dentist unavailable in the afternoon..."></textarea>
                        <div id="ruleNotesError" class="field-error"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" onclick="closeRuleModal()" class="btn-soft">Cancel</button>
                        <button type="button" onclick="submitRule()" class="btn-primary">
                            <i class="fa-solid fa-floppy-disk mr-1.5"></i> Save Rule
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="blockModalBackdrop" class="modal-backdrop" onclick="closeBlockModal()">
        <div class="modal-box modal-form modal-compact" onclick="event.stopPropagation()">
            <div class="modal-hdr modal-form-hdr">
                <div class="modal-kicker">
                    <i class="fa-solid fa-ban"></i>
                    Availability Control
                </div>

                <div class="modal-title-row">
                    <div class="modal-title-block">
                        <h3 class="text-xl font-extrabold">Block Date</h3>
                        <p class="modal-title-sub">Prevent appointments from being booked on a specific date.</p>
                    </div>

                    <button type="button" onclick="closeBlockModal()" class="modal-close-btn">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            <div class="modal-body modal-form-body">
                <form action="{{ route('admin.clinic_schedule.block') }}" method="POST">
                    @csrf

                    <div class="modal-section">
                        <div class="modal-section-head">
                            <div class="modal-section-icon">
                                <i class="fa-solid fa-calendar-xmark"></i>
                            </div>
                            <div>
                                <div class="modal-section-title">Date Details</div>
                                <div class="modal-section-sub">Choose the blocked date and specify the reason.</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="blockDate">Date <span class="text-red-400">*</span></label>
                            <input type="date" id="blockDate" name="date" class="form-ctrl" required
                                min="{{ date('Y-m-d') }}">
                            <div id="blockDateError" class="field-error"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="blockReason">Reason <span
                                    class="text-red-400">*</span></label>
                            <select id="blockReason" name="reason" class="form-ctrl form-sel">
                                <option value="Holiday">Holiday</option>
                                <option value="Dentist Unavailable">Dentist Unavailable</option>
                                <option value="Clinic Maintenance">Clinic Maintenance</option>
                                <option value="Special Event">Special Event</option>
                                <option value="Other">Other</option>
                            </select>
                            <div id="blockReasonError" class="field-error"></div>
                        </div>

                        <div>
                            <label class="form-label" for="blockNote">Note (optional)</label>
                            <input type="text" id="blockNote" name="note" class="form-ctrl"
                                placeholder="e.g. National holiday, maintenance, outreach event...">
                            <div class="form-help">Add extra context for admins viewing blocked dates later.</div>
                            <div id="blockNoteError" class="field-error"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" onclick="closeBlockModal()" class="btn-soft">Cancel</button>
                        <button type="submit" class="btn-primary">
                            <i class="fa-solid fa-ban mr-1.5"></i> Block Date
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const scheduleRules = @json($schedules);
        const weeklyAppointments = @json($weeklyAppointments ?? []);
        if (!weeklyAppointments || weeklyAppointments.length === 0) {}

        // Toast
        function showToast(title, message, type = 'error') {
            const c = document.getElementById('toastContainer');
            if (!c) return;

            const t = document.createElement('div');
            t.className = 'toast ' + type;

            const icon = type === 'error' ?
                '<i class="fa-solid fa-circle-exclamation toast-icon"></i>' :
                '<i class="fa-solid fa-circle-check toast-icon"></i>';

            t.innerHTML = `
        <div class="toast-icon-wrap">${icon}</div>
        <div class="toast-body">
            <div class="toast-title">${title}</div>
            <div class="toast-msg">${message}</div>
        </div>
        <button class="toast-close" onclick="this.closest('.toast').classList.add('hide')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    `;

            c.appendChild(t);
            requestAnimationFrame(() => requestAnimationFrame(() => t.classList.add('show')));
            setTimeout(() => {
                t.classList.remove('show');
                t.classList.add('hide');
                setTimeout(() => t.remove(), 400);
            }, 4500);
        }

        // Date Label
        const dateEl = document.getElementById('currentDate');
        if (dateEl) dateEl.textContent = new Date().toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        function clearFieldError(errorId, inputId = null, groupId = null) {
            const errorEl = document.getElementById(errorId);
            if (errorEl) {
                errorEl.textContent = '';
                errorEl.classList.remove('show');
            }

            if (inputId) {
                document.getElementById(inputId)?.classList.remove('is-invalid');
            }

            if (groupId) {
                document.getElementById(groupId)?.classList.remove('is-invalid');
            }
        }

        function setFieldError(errorId, message, inputId = null, groupId = null) {
            const errorEl = document.getElementById(errorId);
            if (errorEl) {
                errorEl.textContent = message;
                errorEl.classList.add('show');
            }

            if (inputId) {
                document.getElementById(inputId)?.classList.add('is-invalid');
            }

            if (groupId) {
                document.getElementById(groupId)?.classList.add('is-invalid');
            }
        }

        function clearRuleErrors() {
            clearFieldError('ruleDaysError', null, 'ruleDaysGroup');
            clearFieldError('ruleStatusError', 'ruleStatus');
            clearFieldError('ruleOpenTimeError', 'ruleOpenTime');
            clearFieldError('ruleCloseTimeError', 'ruleCloseTime');
            clearFieldError('ruleBreakError', null, 'ruleBreakGroup');
            clearFieldError('ruleMaxSlotsError', 'ruleMaxSlots');
            clearFieldError('ruleNotesError', 'ruleNotes');
        }

        function clearBlockErrors() {
            clearFieldError('blockDateError', 'blockDate');
            clearFieldError('blockReasonError', 'blockReason');
            clearFieldError('blockNoteError', 'blockNote');
        }

        function confirmBlockedDateRemoval(dateLabel, reasonLabel) {
            return window.confirm(`Remove blocked date for ${dateLabel} (${reasonLabel})?`);
        }

        function openAppointmentDetailModal(appt) {
            const service = appt.service_type === 'Others' ?
                (appt.other_services || 'Other Service') :
                (appt.service_type || '—');

            document.getElementById('detailPatientName').textContent = appt.patient_name || 'Unknown Patient';
            document.getElementById('detailServiceType').textContent = service;
            document.getElementById('detailSchedule').textContent =
                `${appt.appointment_date} ${appt.display_time || appt.appointment_time || ''}`;

            document.getElementById('appointmentDetailModal').classList.add('open');
        }

        function closeAppointmentDetailModal() {
            document.getElementById('appointmentDetailModal').classList.remove('open');
        }

        // Weekly Calendar
        const SHORT_MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const DAY_ABBRS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        const TIME_ROWS = [{
                h: 9,
                l: '9:00 AM'
            }, {
                h: 10,
                l: '10:00 AM'
            }, {
                h: 11,
                l: '11:00 AM'
            }, {
                h: 12,
                l: '12:00 PM'
            },
            {
                h: 13,
                l: '1:00 PM'
            }, {
                h: 14,
                l: '2:00 PM'
            }, {
                h: 15,
                l: '3:00 PM'
            }, {
                h: 16,
                l: '4:00 PM'
            }
        ];

        let weekOffset = 0;

        function weekStart(offset) {
            const t = new Date();
            t.setHours(0, 0, 0, 0);
            const dow = t.getDay();
            const mon = new Date(t);
            mon.setDate(t.getDate() - (dow === 0 ? 6 : dow - 1) + offset * 7);
            return mon;
        }

        function slotState(dayAbbr, hour) {
            const rule = scheduleRules.find(r => r.is_active && (r.days || []).includes(dayAbbr));
            if (!rule || rule.status === 'closed') return 'closed';
            const oh = rule.open_time ? parseInt(rule.open_time) : 9;
            const ch = rule.close_time ? parseInt(rule.close_time) : 17;
            if (hour < oh || hour >= ch) return 'closed';
            if (rule.break_time && rule.break_time !== 'none') {
                const [bs, be] = rule.break_time.split('-');
                if (hour >= parseInt(bs) && hour < parseInt(be)) return 'break';
            }
            return 'open';
        }

        function to24Hour(hour) {
            return String(hour).padStart(2, '0') + ':00';
        }

        function normalizeToHourMinute(timeValue) {
            if (!timeValue) return '';

            // already like 09:00
            if (/^\d{2}:\d{2}$/.test(timeValue)) {
                return timeValue;
            }

            // like 09:00:00
            if (/^\d{2}:\d{2}:\d{2}$/.test(timeValue)) {
                return timeValue.slice(0, 5);
            }

            // fallback for 9:00 AM style strings
            const temp = new Date(`1970-01-01 ${timeValue}`);
            if (!isNaN(temp.getTime())) {
                return `${String(temp.getHours()).padStart(2, '0')}:${String(temp.getMinutes()).padStart(2, '0')}`;
            }

            return String(timeValue).trim();
        }

        function getAppointmentsForSlot(isoDate, hour) {
            const slotTime = to24Hour(hour);

            return weeklyAppointments.filter(appt =>
                appt.appointment_date === isoDate &&
                normalizeToHourMinute(appt.appointment_time) === slotTime
            );
        }

        function getServiceColor(serviceType) {
            const s = (serviceType || '').toLowerCase();

            if (s.includes('oral check')) {
                return {
                    box: 'background:#dbeafe;border-left:3px solid #3b82f6;color:#1e3a8a;',
                    badge: 'Check-up'
                };
            }

            if (s.includes('cleaning')) {
                return {
                    box: 'background:#dcfce7;border-left:3px solid #22c55e;color:#166534;',
                    badge: 'Cleaning'
                };
            }

            if (s.includes('surgery')) {
                return {
                    box: 'background:#fef3c7;border-left:3px solid #f59e0b;color:#92400e;',
                    badge: 'Surgery'
                };
            }

            if (s.includes('restoration') || s.includes('prosthesis')) {
                return {
                    box: 'background:#f3e8ff;border-left:3px solid #a855f7;color:#6b21a8;',
                    badge: 'Prosthesis'
                };
            }

            return {
                box: 'background:#f3f4f6;border-left:3px solid #6b7280;color:#374151;',
                badge: 'Other'
            };
        }

        function buildWeekGrid() {
            const ws = weekStart(weekOffset);
            const days = Array.from({
                length: 7
            }, (_, i) => {
                const d = new Date(ws);
                d.setDate(d.getDate() + i);
                return d;
            });
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            document.getElementById('weekRangeLabel').textContent =
                `${SHORT_MONTHS[days[0].getMonth()]} ${days[0].getDate()} – ${SHORT_MONTHS[days[6].getMonth()]} ${days[6].getDate()}, ${days[6].getFullYear()}`;

            // Header row
            let html = `<div class="wk-hdr empty"></div>`;
            days.forEach((d, i) => {
                const isTod = d.getTime() === today.getTime();
                const cls = isTod ? 'today-hdr' : i >= 5 ? 'weekend-hdr' : '';
                html += `<div class="wk-hdr ${cls}">
      <div style="font-size:.65rem;opacity:.75">${DAY_ABBRS[d.getDay()]}</div>
      <div style="font-size:1rem;font-weight:800;line-height:1.2">${d.getDate()}</div>
      ${isTod ? '<div style="font-size:.55rem;background:rgba(255,255,255,.25);border-radius:999px;padding:1px 6px;margin-top:2px">Today</div>' : ''}
    </div>`;
            });

            TIME_ROWS.forEach(({
                h,
                l
            }) => {
                html += `<div class="time-lbl">${l}</div>`;

                days.forEach((d, i) => {
                    const isoDate =
                        `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;
                    const abbr = d.toLocaleDateString('en-US', {
                        weekday: 'short'
                    }).replace('.', '');

                    const state =
                        i >= 5 ?
                        'wk-weekend' :
                        slotState(abbr, h) === 'break' ?
                        'wk-break' :
                        slotState(abbr, h) === 'closed' ?
                        'wk-closed' :
                        '';

                    let inner = '';

                    if (state === 'wk-break') {
                        inner = '<span class="slot-label">BREAK</span>';
                    } else if (state === 'wk-closed') {
                        inner = '<span class="slot-label">CLOSED</span>';
                    } else if (state === 'wk-weekend') {
                        inner = '<span class="slot-label">CLOSED</span>';
                    } else {
                        const slotAppointments = getAppointmentsForSlot(isoDate, h);

                        if (slotAppointments.length > 0) {
                            inner = slotAppointments.map(appt => {
                                const service = appt.service_type === 'Others' ?
                                    (appt.other_services || 'Other Service') :
                                    appt.service_type;

                                const style = getServiceColor(service);

                                return `
            <button
              type="button"
              onclick='openAppointmentDetailModal(${JSON.stringify(appt)})'
              style="
                ${style.box}
                margin:4px;
                border-radius:8px;
                padding:6px 7px;
                font-size:.62rem;
                line-height:1.25;
                font-weight:600;
                box-shadow:0 1px 3px rgba(0,0,0,.06);
                width:calc(100% - 8px);
                text-align:left;
                cursor:pointer;
                transition:transform .15s ease, box-shadow .15s ease;
              "
              onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 4px 10px rgba(0,0,0,.10)'"
              onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 1px 3px rgba(0,0,0,.06)'"
              title="Click to view details"
            >
              <div style="font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                ${appt.patient_name}
              </div>
              <div style="font-size:.58rem; opacity:.9; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                ${service}
              </div>
            </button>
          `;
                            }).join('');
                        }
                    }

                    html += `<div class="cal-slot ${state}">${inner}</div>`;
                });
            });

            document.getElementById('weekGrid').innerHTML = html;
        }

        document.getElementById('prevWeek').addEventListener('click', () => {
            weekOffset--;
            buildWeekGrid();
        });
        document.getElementById('nextWeek').addEventListener('click', () => {
            weekOffset++;
            buildWeekGrid();
        });
        document.getElementById('todayBtn').addEventListener('click', () => {
            weekOffset = 0;
            buildWeekGrid();
        });

        // Schedule Rule Modal
        let selectedBreak = '12:00-13:00';
        let editingId = null;

        function openRuleModal(mode, ruleId, rule) {
            editingId = null;
            document.getElementById('ruleModalTitle').textContent = 'Add Schedule Rule';
            document.getElementById('ruleForm').action = '{{ route('admin.clinic_schedule.store') }}';
            document.getElementById('ruleMethodField').innerHTML = '';

            // Reset
            document.querySelectorAll('.day-toggle').forEach(d => d.classList.remove('active'));
            document.querySelectorAll('.break-chip').forEach(c => c.classList.remove('selected'));
            document.querySelector('.break-chip[data-val="12:00-13:00"]').classList.add('selected');
            selectedBreak = '12:00-13:00';
            document.getElementById('ruleStatus').value = 'open';
            document.getElementById('ruleOpenTime').value = '09:00';
            document.getElementById('ruleCloseTime').value = '17:00';
            document.getElementById('ruleMaxSlots').value = '5';
            document.getElementById('ruleNotes').value = '';
            document.getElementById('ruleTimeFields').style.display = '';

            if (mode === 'edit' && rule) {
                editingId = ruleId;
                document.getElementById('ruleModalTitle').textContent = 'Edit Schedule Rule';
                document.getElementById('ruleForm').action = `/admin/clinic-schedule/rules/${ruleId}`;
                document.getElementById('ruleMethodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';

                (rule.days || []).forEach(day => {
                    const el = document.querySelector(`.day-toggle[data-day="${day}"]`);
                    if (el) el.classList.add('active');
                });
                document.getElementById('ruleStatus').value = rule.status || 'open';
                toggleStatusFields(rule.status);
                if (rule.open_time) document.getElementById('ruleOpenTime').value = rule.open_time.substring(0, 5);
                if (rule.close_time) document.getElementById('ruleCloseTime').value = rule.close_time.substring(0, 5);
                document.getElementById('ruleMaxSlots').value = rule.max_slots || 5;
                document.getElementById('ruleNotes').value = rule.notes || '';
                selectedBreak = rule.break_time || 'none';
                document.querySelectorAll('.break-chip').forEach(c => c.classList.toggle('selected', c.dataset.val ===
                    selectedBreak));
            }

            document.getElementById('ruleModalBackdrop').classList.add('open');
        }

        function closeRuleModal() {
            document.getElementById('ruleModalBackdrop').classList.remove('open');
        }

        function toggleDay(el) {
            el.classList.toggle('active');
            clearFieldError('ruleDaysError', null, 'ruleDaysGroup');
        }

        function toggleStatusFields(val) {
            document.getElementById('ruleTimeFields').style.display = val === 'closed' ? 'none' : '';
        }

        function selectBreak(el) {
            document.querySelectorAll('.break-chip').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            selectedBreak = el.dataset.val;
            clearFieldError('ruleBreakError', null, 'ruleBreakGroup');
        }

        function adjSlots(delta) {
            const inp = document.getElementById('ruleMaxSlots');
            inp.value = Math.max(1, Math.min(30, parseInt(inp.value || 5) + delta));
        }

        function submitRule() {
            clearRuleErrors();

            const activeDays = [...document.querySelectorAll('.day-toggle.active')].map(d => d.dataset.day);
            const status = document.getElementById('ruleStatus').value;
            const openTime = document.getElementById('ruleOpenTime').value;
            const closeTime = document.getElementById('ruleCloseTime').value;
            const maxSlots = parseInt(document.getElementById('ruleMaxSlots').value || '0', 10);

            let hasError = false;

            if (!activeDays.length) {
                setFieldError('ruleDaysError', 'Please select at least one day.', null, 'ruleDaysGroup');
                hasError = true;
            }

            if (!status) {
                setFieldError('ruleStatusError', 'Please select a clinic status.', 'ruleStatus');
                hasError = true;
            }

            if (status !== 'closed') {
                if (!openTime) {
                    setFieldError('ruleOpenTimeError', 'Please select an opening time.', 'ruleOpenTime');
                    hasError = true;
                }

                if (!closeTime) {
                    setFieldError('ruleCloseTimeError', 'Please select a closing time.', 'ruleCloseTime');
                    hasError = true;
                }

                if (openTime && closeTime && openTime >= closeTime) {
                    setFieldError('ruleCloseTimeError', 'Closing time must be later than opening time.', 'ruleCloseTime');
                    hasError = true;
                }

                if (!maxSlots || maxSlots < 1) {
                    setFieldError('ruleMaxSlotsError', 'Max appointments must be at least 1.', 'ruleMaxSlots');
                    hasError = true;
                }
            }

            if (hasError) return;

            const form = document.getElementById('ruleForm');
            form.querySelectorAll('.injected-hidden').forEach(el => el.remove());

            const inject = (name, val) => {
                const inp = document.createElement('input');
                inp.type = 'hidden';
                inp.name = name;
                inp.value = val;
                inp.className = 'injected-hidden';
                form.appendChild(inp);
            };

            activeDays.forEach(d => inject('days[]', d));
            inject('status', status);

            if (status !== 'closed') {
                inject('open_time', openTime);
                inject('close_time', closeTime);
                inject('max_slots', maxSlots);
                inject('break_time', selectedBreak || 'none');
            }

            inject('notes', document.getElementById('ruleNotes').value);

            form.submit();
        }

        // Block date 
        function openBlockModal() {
            document.getElementById('blockDate').min = new Date().toISOString().split('T')[0];
            document.getElementById('blockModalBackdrop').classList.add('open');
        }

        function closeBlockModal() {
            document.getElementById('blockModalBackdrop').classList.remove('open');
        }

        document.addEventListener('DOMContentLoaded', function() {
            buildWeekGrid();

            document.getElementById('ruleStatus')?.addEventListener('change', () => clearFieldError(
                'ruleStatusError', 'ruleStatus'));
            document.getElementById('ruleOpenTime')?.addEventListener('change', () => clearFieldError(
                'ruleOpenTimeError', 'ruleOpenTime'));
            document.getElementById('ruleCloseTime')?.addEventListener('change', () => clearFieldError(
                'ruleCloseTimeError', 'ruleCloseTime'));
            document.getElementById('ruleMaxSlots')?.addEventListener('input', () => clearFieldError(
                'ruleMaxSlotsError', 'ruleMaxSlots'));

            document.getElementById('blockDate')?.addEventListener('input', () => clearFieldError('blockDateError',
                'blockDate'));
            document.getElementById('blockReason')?.addEventListener('change', () => clearFieldError(
                'blockReasonError', 'blockReason'));
            document.getElementById('blockNote')?.addEventListener('input', () => clearFieldError('blockNoteError',
                'blockNote'));
        });
    </script>
@endsection