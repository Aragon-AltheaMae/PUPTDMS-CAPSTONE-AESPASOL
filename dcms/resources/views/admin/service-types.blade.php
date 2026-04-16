@extends('layouts.admin')

@section('title', 'Service Types | Admin Dashboard')

@section('styles')
    <style>
        #toastContainer {
            position: fixed !important;
            top: 20px !important;
            right: 20px !important;
            bottom: unset !important;
            left: unset !important;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
            width: auto !important;
            padding: 0 !important;
        }

        #toastContainer .toast {
            min-width: 300px;
            max-width: 360px;
            background: white !important;
            border-radius: 14px !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, .15) !important;
            padding: 14px 16px !important;
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
            width: 3px;
            background: none;
        }

        #toastContainer .toast.error::before {
            background: var(--crimson) !important;
        }

        #toastContainer .toast.success::before {
            background: #16a34a !important;
        }

        #toastContainer .toast.show {
            opacity: 1 !important;
            transform: translateX(0) !important;
        }

        #toastContainer .toast.hide {
            opacity: 0 !important;
            transform: translateX(340px) !important;
        }

        .toast-icon-wrap {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .toast.error .toast-icon-wrap {
            background: rgba(139, 0, 0, .08);
        }

        .toast.success .toast-icon-wrap {
            background: rgba(22, 163, 74, .08);
        }

        .toast-icon {
            font-size: 15px;
        }

        .toast.error .toast-icon {
            color: var(--crimson) !important;
        }

        .toast.success .toast-icon {
            color: #16a34a !important;
        }

        .toast-body {
            flex: 1;
            min-width: 0;
        }

        .toast-title {
            font-size: 12px;
            font-weight: 800;
            color: #333333 !important;
        }

        .toast-msg {
            font-size: 11px;
            color: #9ca3af !important;
            margin-top: 2px;
            line-height: 1.4;
        }

        .toast-close {
            background: none !important;
            border: none;
            cursor: pointer;
            color: #d1d5db;
            font-size: 12px;
            flex-shrink: 0;
            padding: 2px 4px;
            transition: color .15s;
        }

        .toast-close:hover {
            color: #6b7280;
        }

        /* Dark mode overrides for Toasts */
        [data-theme="dark"] #toastContainer .toast {
            background: #161b22 !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, .4) !important;
        }

        [data-theme="dark"] .toast-title {
            color: #f3f4f6 !important;
        }

        [data-theme="dark"] .toast.error .toast-icon-wrap {
            background: rgba(239, 68, 68, .1);
        }

        [data-theme="dark"] .toast.success .toast-icon-wrap {
            background: rgba(34, 197, 94, .1);
        }
        /* Page Banner */
       .page-banner {
            background: linear-gradient(135deg, var(--crimson-dark) 0%, var(--crimson) 60%, #c0392b 100%);
            padding: 1.75rem 2rem 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(139, 0, 0, .25);
            border-radius: 16px;
            margin-bottom: 1.5rem;
        }

        .page-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .page-banner-inner {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-greeting {
            font-size: .75rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .65);
            letter-spacing: .05em;
            text-transform: uppercase;
            margin-bottom: .3rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 900;
            color: #fff;
            line-height: 1.1;
        }

        .page-subtitle {
            font-size: .78rem;
            color: rgba(255, 255, 255, .6);
            margin-top: .4rem;
        }

        .content-lift {
            margin-top: 0;
            padding: 0 1.75rem 2rem;
            position: relative;
            z-index: 2;
        }

        .main-grid {
            display: grid;
            grid-template-columns: 340px 1fr;
            gap: 1.25rem;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, .05);
            box-shadow: 0 2px 12px rgba(0, 0, 0, .04);
            overflow: hidden;
        }

        .card-header {
            padding: .9rem 1.25rem;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fafafa;
        }

        .card-header-left {
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .card-header-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: var(--crimson-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: var(--crimson);
        }

        .card-title {
            font-size: .82rem;
            font-weight: 800;
            color: #1a202c;
        }

        /* ══════════════════════════════════════
                               SERVICE TYPES SPECIFIC
                            ══════════════════════════════════════ */
        .st-form-group {
            margin-bottom: 1.1rem;
        }

        .st-label {
            display: block;
            font-size: .68rem;
            font-weight: 700;
            color: #4b5563;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .st-input-wrap {
            position: relative;
        }

        .st-input-icon {
            position: absolute;
            left: 12px;
            top: 13px;
            color: #9ca3af;
            font-size: 12px;
            pointer-events: none;
        }

        .st-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            font-size: .8rem;
            font-family: 'Inter', sans-serif;
            background: #fff;
            color: #1f2937;
            outline: none;
            transition: all .2s;
        }

        .st-input-wrap,
        .st-textarea-wrap {
            width: 100%;
            position: relative;
        }

        .st-input,
        .st-textarea {
            width: 100%;
            display: block;
            box-sizing: border-box;
        }

        .st-textarea {
            min-height: 110px;
            resize: none;
            padding: 10px 14px 26px 14px;
            line-height: 1.45;
        }

        .st-input.with-icon {
            padding-left: 34px;
        }

        .st-input::placeholder {
            color: #9ca3af;
        }

        .st-input:focus {
            border-color: var(--crimson);
            box-shadow: 0 0 0 3px rgba(139, 0, 0, .1);
        }

        .st-input.is-invalid {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .st-input.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, .2);
        }

        .st-input-wrap .voice-input-wrap {
            position: relative;
            width: 100%;
        }

        .st-input-wrap .voice-input-wrap > .st-input.has-voice-padding {
            padding-right: 2.35rem;
        }

        .st-textarea-wrap .voice-input-wrap > .st-textarea.has-voice-padding {
            padding-right: 2.35rem;
        }

        .st-input-wrap .voice-input-wrap .voice-mic-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            border: none;
            background: transparent;
            padding: 0;
            margin: 0;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #8B0000;
            cursor: pointer;
            z-index: 4;
        }

        .st-textarea-wrap .voice-input-wrap .voice-mic-btn {
            top: 10px;
            transform: none;
        }

        .st-input-wrap .voice-input-wrap [data-voice-status] {
            position: absolute;
            right: 0;
            top: -1.35rem;
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
            font-size: .74rem;
            font-weight: 700;
            line-height: 1;
            padding: .18rem .48rem;
            border-radius: 999px;
            pointer-events: none;
            z-index: 6;
            background: rgba(255, 255, 255, .92);
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        }

        .st-input-wrap .voice-input-wrap [data-voice-status].hidden {
            display: none;
        }

        .st-input-wrap .voice-input-wrap [data-voice-status].is-listening {
            color: #1d4ed8;
            border-color: #bfdbfe;
            background: #eff6ff;
        }

        .st-input-wrap .voice-input-wrap [data-voice-status].is-error {
            color: #b91c1c;
            border-color: #fecaca;
            background: #fef2f2;
        }

        .st-input-wrap .voice-input-wrap [data-voice-status].is-success {
            color: #166534;
            border-color: #bbf7d0;
            background: #f0fdf4;
        }

        /* Character Counter Styles */
        .st-char-count {
            position: absolute;
            bottom: 8px;
            right: 12px;
            font-size: .65rem;
            font-weight: 700;
            color: #9ca3af;
            pointer-events: none;
            transition: color .2s;
        }

        .st-char-count.near-limit {
            color: #f59e0b;
        }

        .st-char-count.at-limit {
            color: #ef4444;
        }

        .st-field-error {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 6px;
            font-size: .72rem;
            font-weight: 600;
            color: #ef4444;
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, var(--crimson) 0%, var(--crimson-dark) 100%);
            color: #fff;
            font-weight: 800;
            font-size: .8rem;
            padding: .8rem 1rem;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            transition: all .2s;
            box-shadow: 0 4px 14px rgba(139, 0, 0, .3);
            font-family: 'Inter', sans-serif;
        }

        .btn-submit:hover {
            box-shadow: 0 6px 20px rgba(139, 0, 0, .4);
            transform: translateY(-1px);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: .76rem;
        }

        .data-table thead th {
            padding: .7rem 1rem;
            text-align: left;
            font-weight: 700;
            color: #9ca3af;
            font-size: .65rem;
            text-transform: uppercase;
            letter-spacing: .06em;
            background: #fafafa;
            border-bottom: 1px solid #f3f4f6;
        }

        .data-table tbody td {
            padding: .8rem 1rem;
            color: #4a5568;
            border-bottom: 1px solid #f9fafb;
            vertical-align: middle;
        }

        .data-table tbody tr:hover td {
            background: #fafafa;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        .service-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 24px;
            padding: 0 8px;
            background: #f3f4f6;
            color: #6b7280;
            border-radius: 6px;
            font-size: .68rem;
            font-weight: 700;
        }

        .btn-delete-sm {
            background: #fef2f2;
            color: #ef4444;
            border: 1px solid #fee2e2;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            cursor: pointer;
            transition: all .15s;
        }

        .btn-delete-sm:hover {
            background: #ef4444;
            color: #fff;
            border-color: #ef4444;
            box-shadow: 0 2px 8px rgba(239, 68, 68, .3);
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.4rem;
            color: #d1d5db;
        }

        /* ══════════════════════════════════════
                   DELETE MODAL STYLES (MODERN)
                ══════════════════════════════════════ */
        #deleteServiceModal {
            border: none;
            padding: 32px 24px 24px;
            border-radius: 20px;
            width: min(90vw, 380px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            background: #ffffff;
            text-align: center;
            overflow: visible;
            /* Allows the icon to breathe */
        }

        #deleteServiceModal::backdrop {
            background: rgba(17, 24, 39, 0.6);
            backdrop-filter: blur(4px);
        }

        .del-modal-icon {
            width: 64px;
            height: 64px;
            background: #fef2f2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            color: #ef4444;
            font-size: 28px;
            border: 6px solid #fff;
            box-shadow: 0 0 0 1px #fee2e2;
        }

        .del-modal-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: #111827;
            margin: 0 0 8px;
        }

        .del-modal-body {
            font-size: .85rem;
            color: #6b7280;
            line-height: 1.6;
            margin: 0 0 24px;
        }

        .del-modal-name {
            display: inline-block;
            font-size: .9rem;
            font-weight: 700;
            color: #111827;
            background: #f3f4f6;
            padding: 4px 10px;
            border-radius: 6px;
            margin: 8px 0;
            word-break: break-all;
        }

        .del-modal-warning {
            display: block;
            color: #ef4444;
            font-weight: 600;
            font-size: .8rem;
            margin-top: 8px;
        }

        .del-modal-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .del-btn-cancel {
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            color: #374151;
            font-weight: 600;
            font-size: .85rem;
            cursor: pointer;
            transition: all .15s;
            font-family: 'Inter', sans-serif;
        }

        .del-btn-cancel:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }

        .del-btn-confirm {
            padding: 10px;
            border-radius: 10px;
            border: none;
            background: #ef4444;
            color: #ffffff;
            font-weight: 600;
            font-size: .85rem;
            cursor: pointer;
            transition: all .15s;
            width: 100%;
            font-family: 'Inter', sans-serif;
        }

        .del-btn-confirm:hover {
            background: #dc2626;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
        }

        [data-theme="dark"] #deleteServiceModal {
            background: #1f2937;
        }

        [data-theme="dark"] .del-modal-icon {
            background: rgba(239, 68, 68, 0.1);
            border-color: #1f2937;
            box-shadow: 0 0 0 1px rgba(239, 68, 68, 0.2);
        }

        [data-theme="dark"] .del-modal-title {
            color: #f9fafb;
        }

        [data-theme="dark"] .del-modal-body {
            color: #9ca3af;
        }

        [data-theme="dark"] .del-modal-name {
            color: #f9fafb;
            background: #374151;
        }

        [data-theme="dark"] .del-btn-cancel {
            background: #374151;
            border-color: #4b5563;
            color: #d1d5db;
        }

        [data-theme="dark"] .del-btn-cancel:hover {
            background: #4b5563;
        }

        /* Dark mode overrides (optional) */
        [data-theme="dark"] .card {
            background: #161b22;
            border-color: #21262d;
        }

        [data-theme="dark"] .card-header {
            background: #0d1117;
            border-color: #21262d;
        }

        [data-theme="dark"] .card-title {
            color: #f3f4f6;
        }

        [data-theme="dark"] .st-input {
            background: #0d1117;
            border-color: #21262d;
            color: #f3f4f6;
        }

        [data-theme="dark"] .data-table thead th {
            background: #0d1117;
            border-color: #21262d;
            color: #6b7280;
        }

        [data-theme="dark"] .data-table tbody td {
            border-color: #1c2128;
            color: #d1d5db;
        }

        [data-theme="dark"] .data-table tbody tr:hover td {
            background: #1c2128;
        }
        

        .service-type-view-toggle {
            display: inline-flex;
            align-items: center;
            background: #FAFAF9;
            border: 1.5px solid #E0DDD8;
            border-radius: 12px;
            padding: 3px;
            gap: 3px;
            height: 38px;
        }

        .service-type-view-btn {
            width: 32px;
            height: 30px;
            padding: 0;
            border: none;
            background: transparent;
            color: #6b7280;
            border-radius: 9px;
            font-size: .82rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .15s ease;
            flex-shrink: 0;
        }

        .service-type-view-btn:hover {
            background: #f3f4f6;
            color: var(--crimson);
        }

        .service-type-view-btn.active {
            background: var(--crimson);
            color: #fff;
            box-shadow: 0 2px 8px rgba(139, 0, 0, .15);
        }

        .service-type-view[hidden] {
            display: none !important;
        }

        .service-types-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
            padding: 1rem;
        }

        .service-type-card {
            background: #fff;
            border: 1px solid #f0eaea;
            border-radius: 16px;
            padding: 1rem;
            transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
            display: flex;
            flex-direction: column;
            gap: .85rem;
            min-width: 0;
        }

        .service-type-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, .06);
            border-color: #ead6d6;
        }

        .service-type-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: .75rem;
        }

        .service-type-card-id {
            font-size: .72rem;
            font-weight: 800;
            color: var(--crimson);
            line-height: 1.2;
        }

        .service-type-card-name-wrap {
            display: flex;
            align-items: center;
            gap: .7rem;
            min-width: 0;
        }

        .service-type-card-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--crimson), var(--crimson-dark));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .82rem;
            flex-shrink: 0;
        }

        .service-type-card-name {
            font-size: .88rem;
            font-weight: 700;
            color: #111827;
            line-height: 1.25;
            word-break: break-word;
        }

        .service-type-card-desc-wrap {
            min-width: 0;
        }

        .service-type-card-label {
            font-size: .64rem;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: .28rem;
        }

        .service-type-card-desc {
            font-size: .8rem;
            color: #374151;
            line-height: 1.4;
            word-break: break-word;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .service-type-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .75rem;
            margin-top: .1rem;
            flex-wrap: wrap;
        }

        .service-type-card-actions {
            display: flex;
            align-items: center;
            gap: .35rem;
            flex-wrap: wrap;
        }

        [data-theme="dark"] .service-type-view-toggle {
            background: #0d1117;
            border-color: #21262d;
        }

        [data-theme="dark"] .service-type-view-btn {
            color: #9ca3af;
        }

        [data-theme="dark"] .service-type-view-btn:hover {
            background: #1c2128;
            color: #f3f4f6;
        }

        [data-theme="dark"] .service-type-card {
            background: #161b22;
            border-color: #21262d;
        }

        [data-theme="dark"] .service-type-card-name {
            color: #f9fafb;
        }

        [data-theme="dark"] .service-type-card-desc {
            color: #d1d5db;
        }

        @media (max-width: 900px) {
            .service-types-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 1024px) {
            .main-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 767px) {
            .page-banner {
                padding: 1.5rem 1rem 3rem;
            }

            .content-lift {
                padding: 0 1rem 2rem;
            }

            #serviceTypeListView {
                display: none !important;
            }

            #serviceTypeGridView {
                display: block !important;
            }

            #serviceTypeViewToggle {
                display: none !important;
            }

            .service-types-grid {
                grid-template-columns: 1fr;
                padding: .85rem;
                gap: .85rem;
            }
        }
    </style>
@endsection

@section('content')
    <main id="mainContent" class="px-4 sm:px-6 pt-[82px] pb-8 min-h-screen">

        <div class="page-banner">
            <div class="page-banner-inner">
                <div>
                    <h1 class="page-title">Service Types</h1>
                </div>

                <div class="flex items-center gap-2 whitespace-nowrap">
                    <span style="
                        background: rgba(255,255,255,.12);
                        border: 1px solid rgba(255,255,255,.18);
                        color: #fff;
                        padding: .6rem 1rem;
                        border-radius: 10px;
                        font-size: .75rem;
                        font-weight: 700;
                        line-height: 1;
                    ">
                        Active Services: {{ $services->count() }}
                    </span>

                    <div class="service-type-view-toggle" id="serviceTypeViewToggle" style="margin-left:4px;">
                        <button type="button" class="service-type-view-btn active" id="serviceTypeListBtn" title="List view" aria-label="List view">
                            <i class="fa-solid fa-table-list"></i>
                        </button>
                        <button type="button" class="service-type-view-btn" id="serviceTypeGridBtn" title="Grid view" aria-label="Grid view">
                            <i class="fa-solid fa-grip"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-lift">
            <div class="main-grid">

                <div style="display:flex;flex-direction:column;gap:1.25rem;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-left">
                                <div class="card-header-icon"><i class="fa-solid fa-plus"></i></div>
                                <span class="card-title">Add New Service</span>
                            </div>
                        </div>

                        <div style="padding:1.25rem;">
                            <form id="addServiceForm" method="POST" action="{{ route('admin.service-types.store') }}"
                                novalidate>
                                @csrf

                                <div class="st-form-group">
                                    <label class="st-label">Service Name</label>
                                    <div class="st-input-wrap">
                                        <i class="fa-solid fa-tag st-input-icon"></i>
                                        <input type="text" id="serviceNameInput" name="name"
                                            placeholder="e.g. Tooth Extraction" autocomplete="off"
                                            value="{{ old('name') }}" class="st-input with-icon">
                                    </div>

                                    <div id="nameClientError" class="st-field-error" style="display: none;">
                                        <i class="fa-solid fa-circle-exclamation"></i> Please provide a service name.
                                    </div>

                                    @error('name')
                                        <div class="st-field-error"><i class="fa-solid fa-circle-exclamation"></i>
                                            {{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="st-form-group">
                                    <label class="st-label">Description (Optional)</label>

                                    <div class="st-input-wrap st-textarea-wrap">
                                        <textarea id="serviceDescInput"
                                            name="description"
                                            placeholder="Brief details about the service..."
                                            class="st-input st-textarea"
                                            maxlength="100">{{ old('description') }}</textarea>

                                        <div id="serviceDescCount" class="st-char-count">0 / 100</div>
                                    </div>

                                    @error('description')
                                        <div class="st-field-error"><i class="fa-solid fa-circle-exclamation"></i>
                                            {{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn-submit">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                    Save Service
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div style="display:flex;flex-direction:column;gap:1.25rem;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-left">
                                <div class="card-header-icon"><i class="fa-solid fa-list-check"></i></div>
                                <span class="card-title">Existing Services</span>
                            </div>
                            <span
                                style="font-size:.65rem;font-weight:700;background:#fef2f2;color:var(--crimson);padding:.25rem .6rem;border-radius:20px;border:1px solid #fce8e8;">
                                {{ $services->count() }} {{ Str::plural('Item', $services->count()) }}
                            </span>
                        </div>
                        
                        @php
                            $defaultServices = [
                                'Oral Check-Up',
                                'Dental Cleaning',
                                'Restoration & Prosthesis',
                                'Dental Surgery',
                            ];
                        @endphp
                        
                                                <div class="service-type-view" id="serviceTypeListView">
                            <div style="overflow-x:auto;">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th style="width:70px;">ID</th>
                                            <th style="width:220px;">Service Name</th>
                                            <th>Description</th>
                                            <th style="width:80px; text-align:center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($services as $service)
                                            <tr>
                                                <td><span class="service-badge">#{{ $service->id }}</span></td>
                                                <td>
                                                    <div style="display:flex; align-items:center; gap:.6rem;">
                                                        <div
                                                            style="width:26px; height:26px; background:#fef2f2; color:var(--crimson); border-radius:6px; display:flex; align-items:center; justify-content:center; font-size:11px;">
                                                            <i class="fa-solid fa-tooth"></i>
                                                        </div>
                                                        <span style="font-size:.78rem;font-weight:700;color:#1a202c;">{{ $service->name }}</span>
                                                    </div>
                                                </td>
                                                <td style="font-size:.72rem; line-height:1.5;">
                                                    {{ $service->description ?: '—' }}
                                                </td>
                                                <td style="text-align:center;">
                                                    @if (!in_array($service->name, $defaultServices))
                                                        <button type="button" class="btn-delete-sm" title="Delete"
                                                            onclick="openDeleteModal('{{ route('admin.service-types.destroy', $service->id) }}', '{{ addslashes($service->name) }}')">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    @else
                                                        <span class="service-badge" style="background:#ecfdf5;color:#166534;border:1px solid #bbf7d0;">
                                                            Default
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">
                                                    <div class="empty-state">
                                                        <div class="empty-icon"><i class="fa-solid fa-folder-open"></i></div>
                                                        <p style="font-size:.82rem;font-weight:700;color:#6b7280;margin-bottom:.25rem;">
                                                            No services found
                                                        </p>
                                                        <p style="font-size:.72rem;color:#b0b7c3;">
                                                            Your clinic doesn't have any service types yet. Use the form to add one.
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="service-type-view" id="serviceTypeGridView" hidden>
                            @if($services->count())
                                <div class="service-types-grid">
                                    @foreach($services as $service)
                                        <div class="service-type-card">
                                            <div class="service-type-card-top">
                                                <div class="service-type-card-id">#{{ $service->id }}</div>

                                                @if (in_array($service->name, $defaultServices))
                                                    <span class="service-badge" style="background:#ecfdf5;color:#166534;border:1px solid #bbf7d0;">
                                                        Default
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="service-type-card-name-wrap">
                                                <div class="service-type-card-icon">
                                                    <i class="fa-solid fa-tooth"></i>
                                                </div>
                                                <div class="service-type-card-name">{{ $service->name }}</div>
                                            </div>

                                            <div class="service-type-card-desc-wrap">
                                                <div class="service-type-card-label">Description</div>
                                                <div class="service-type-card-desc">
                                                    {{ $service->description ?: '—' }}
                                                </div>
                                            </div>

                                            <div class="service-type-card-footer">
                                                <span class="service-badge">Service Type</span>

                                                <div class="service-type-card-actions">
                                                    @if (!in_array($service->name, $defaultServices))
                                                        <button type="button" class="btn-delete-sm" title="Delete"
                                                            onclick="openDeleteModal('{{ route('admin.service-types.destroy', $service->id) }}', '{{ addslashes($service->name) }}')">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="fa-solid fa-folder-open"></i></div>
                                    <p style="font-size:.82rem;font-weight:700;color:#6b7280;margin-bottom:.25rem;">
                                        No services found
                                    </p>
                                    <p style="font-size:.72rem;color:#b0b7c3;">
                                        Your clinic doesn't have any service types yet. Use the form to add one.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <dialog id="deleteServiceModal">
            <div class="del-modal-icon">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h2 class="del-modal-title">Delete Service Type</h2>
            <div class="del-modal-body">
                Are you sure you want to delete <span class="del-modal-name" id="deleteServiceName"></span>?
                <span class="del-modal-warning">This action cannot be undone.</span>
            </div>
            <div class="del-modal-actions">
                <button type="button" class="del-btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                <form id="deleteServiceForm" method="POST" action="" style="margin:0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="del-btn-confirm">Yes, delete it</button>
                </form>
            </div>
        </dialog>

    </main>
@endsection

@section('scripts')
    <script>
        // Frontend Validation Logic
        document.getElementById('addServiceForm').addEventListener('submit', function(e) {
            const nameInput = document.getElementById('serviceNameInput');
            const errorDiv = document.getElementById('nameClientError');

            // Check if field is empty (ignoring whitespace)
            if (nameInput.value.trim() === '') {
                e.preventDefault(); // Stop the form from submitting

                errorDiv.style.display = 'flex'; // Show our custom error
                nameInput.classList.add('is-invalid'); // Add red border styling
                nameInput.focus();
            }
        });

        // Remove the error as soon as the user starts typing
        document.getElementById('serviceNameInput').addEventListener('input', function() {
            document.getElementById('nameClientError').style.display = 'none';
            this.classList.remove('is-invalid');
        });

        // Delete Modal Logic
        function openDeleteModal(actionUrl, serviceName) {
            document.getElementById('deleteServiceName').textContent = serviceName;
            document.getElementById('deleteServiceForm').action = actionUrl;
            document.getElementById('deleteServiceModal').showModal();
        }

        function closeDeleteModal() {
            document.getElementById('deleteServiceModal').close();
        }

        function getPreferredServiceTypeView() {
            if (window.innerWidth <= 767) return 'grid';
            return localStorage.getItem('serviceTypeView') || 'list';
        }

        function applyServiceTypeView(view, save = true) {
            const listView = document.getElementById('serviceTypeListView');
            const gridView = document.getElementById('serviceTypeGridView');
            const listBtn = document.getElementById('serviceTypeListBtn');
            const gridBtn = document.getElementById('serviceTypeGridBtn');

            if (!listView || !gridView) return;

            const finalView = window.innerWidth <= 767 ? 'grid' : view;

            if (finalView === 'grid') {
                listView.hidden = true;
                gridView.hidden = false;
            } else {
                listView.hidden = false;
                gridView.hidden = true;
            }

            if (listBtn) listBtn.classList.toggle('active', finalView === 'list');
            if (gridBtn) gridBtn.classList.toggle('active', finalView === 'grid');

            if (save && window.innerWidth > 767) {
                localStorage.setItem('serviceTypeView', finalView);
            }
        }

        function initServiceTypeViewToggle() {
            const listBtn = document.getElementById('serviceTypeListBtn');
            const gridBtn = document.getElementById('serviceTypeGridBtn');

            applyServiceTypeView(getPreferredServiceTypeView(), false);

            if (listBtn && !listBtn.dataset.bound) {
                listBtn.dataset.bound = '1';
                listBtn.addEventListener('click', () => applyServiceTypeView('list', true));
            }

            if (gridBtn && !gridBtn.dataset.bound) {
                gridBtn.dataset.bound = '1';
                gridBtn.addEventListener('click', () => applyServiceTypeView('grid', true));
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            initServiceTypeViewToggle();

            const descInput = document.getElementById('serviceDescInput');
            const charCount = document.getElementById('serviceDescCount');
            const maxChars = 100;

            if (descInput && charCount) {
                function updateCharCount() {
                    const currentLength = descInput.value.length;
                    charCount.textContent = `${currentLength} / ${maxChars}`;

                    if (currentLength >= maxChars) {
                        charCount.classList.remove('near-limit');
                        charCount.classList.add('at-limit');
                    } else if (currentLength >= maxChars * 0.8) {
                        charCount.classList.remove('at-limit');
                        charCount.classList.add('near-limit');
                    } else {
                        charCount.classList.remove('at-limit', 'near-limit');
                    }
                }

                // Run on load (for old data) and on input
                updateCharCount();
                descInput.addEventListener('input', updateCharCount);
            }

            // Trigger Toast Notifications based on Session
            @if (session('success'))
                showToast('Success', '{!! addslashes(session('success')) !!}', 'success');
            @endif

            @if (session('error'))
                showToast('Error', '{!! addslashes(session('error')) !!}', 'error');
            @endif
        });

        window.addEventListener('resize', () => {
            applyServiceTypeView(getPreferredServiceTypeView(), false);
        });
    </script>
@endsection