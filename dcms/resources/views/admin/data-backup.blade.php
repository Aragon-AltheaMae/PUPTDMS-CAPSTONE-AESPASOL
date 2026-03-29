@extends('layouts.admin')

@section('title', 'Data Backup | PUP Taguig Dental Clinic')

@section('styles')
<style>
    .backup-topbar {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .backup-title {
        font-size: 2rem;
        font-weight: 900;
        color: #8B0000;
        line-height: 1;
        margin: 0 0 .45rem;
    }

    .backup-subtitle {
        margin: 0;
        color: #8f96a3;
        font-size: .95rem;
    }

    .backup-run-btn {
        background: linear-gradient(135deg, var(--crimson, #8B0000) 0%, 
                    var(--crimson-dark, #6b0000) 100%);
        color: #fff;
        font-weight: 800;
        font-size: .8rem;
        padding: .82rem 1.1rem;
        border-radius: 12px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: .55rem;
        box-shadow: 0 8px 24px rgba(139, 0, 0, .16);
        transition: all .18s ease;
        font-family: 'Inter', sans-serif;
    }

    .backup-run-btn:hover {
        transform: translateY(-1px);
    }
    /* Page Banner */
    .page-banner {
        background: linear-gradient(135deg, #6b0000 0%, #8B0000 60%, #c0392b 100%);
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
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 900;
        color: #fff;
    }

    .backup-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0;
        background: #fff;
        border: 1px solid #ececef;
        border-radius: 18px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,.03);
        position: relative;
    }

    .backup-stat {
        padding: 1.1rem 1.15rem .95rem;
        border-right: 1px solid #ececef;
        position: relative;
        min-height: 84px;
        background: #fff;
    }

    .backup-stat.clickable {
        appearance: none;
        -webkit-appearance: none;
        background: #fff;
        text-decoration: none;
        cursor: pointer;
        transition: background .15s ease, transform .15s ease;
        border: none;
        width: 100%;
        text-align: left;
        font-family: inherit;
    }

    .backup-stat.clickable:hover {
        background: #fafafa;
    }

    .backup-stat.clickable:focus,
    .backup-stat.clickable:focus-visible,
    .backup-stat.clickable:active {
        outline: none !important;
        box-shadow: none !important;
    }

    .backup-stat:last-child {
        border-right: none;
    }

    .backup-stat.active::after {
        display: none !important;
    }

    .backup-stat-value {
        font-size: 1.2rem;
        font-weight: 900;
        color: #111827;
        line-height: 1;
        margin-bottom: .45rem;
    }

    .stats-indicator {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 3px;
        background: #8B0000;
        border-radius: 999px 999px 0 0;
        box-shadow: 0 0 6px rgba(139, 0, 0, 0.25);
        pointer-events: none;
        z-index: 5;
        will-change: left, width;
        transition:
            left .38s cubic-bezier(.22, 1, .36, 1),
            width .38s cubic-bezier(.22, 1, .36, 1);
    }

    .backup-stat-value.red { color: #8B0000; }
    .backup-stat-value.green { color: #15803d; }

    .backup-stat-label {
        font-size: .72rem;
        color: #9aa3b2;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    .backup-main {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 312px;
        gap: 1rem;
        align-items: start;
    }

    .card {
        background: #fff;
        border: 1px solid #ececef;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,.03);
    }

    .card-header {
        padding: 1rem 1.15rem;
        border-bottom: 1px solid #f0f2f5;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        background: #fff;
    }

    .card-header-left {
        display: flex;
        align-items: flex-start;
        gap: .75rem;
    }

    .card-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: #8B0000;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .card-title {
        font-size: .95rem;
        font-weight: 800;
        color: #1f2937;
        margin: 0;
        line-height: 1.2;
    }

    .card-subtitle {
        font-size: .72rem;
        color: #b0b7c3;
        margin-top: .15rem;
    }

    .toolbar {
        display: flex;
        align-items: center;
        gap: .6rem;
        flex-wrap: wrap;
    }

    .toolbar select {
        height: 38px;
        min-width: 140px;
        border: 1px solid #e5e7eb;
        background: #fff;
        color: #6b7280;
        border-radius: 10px;
        padding: 0 .85rem;
        font-size: .78rem;
        font-weight: 700;
        outline: none;
        cursor: pointer;
        transition: border-color .15s ease, box-shadow .15s ease;
    }

    .toolbar select:hover {
        border-color: #d1d5db;
    }

    .toolbar select:focus {
        border-color: #8B0000;
        box-shadow: 0 0 0 3px rgba(139, 0, 0, .08);
    }

    .filter-reset-btn {
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 .9rem;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        background: #fff;
        color: #6b7280;
        text-decoration: none;
        font-size: .76rem;
        font-weight: 700;
        transition: all .15s ease;
    }

    .filter-reset-btn:hover {
        background: #f9fafb;
        color: #374151;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: .78rem;
    }

    .data-table thead th {
        padding: .85rem 1rem;
        text-align: left;
        font-size: .66rem;
        font-weight: 800;
        color: #a2aab8;
        text-transform: uppercase;
        letter-spacing: .06em;
        border-bottom: 1px solid #f1f3f6;
        background: #fafafa;
        white-space: nowrap;
    }

    .data-table tbody td {
        padding: .95rem 1rem;
        border-bottom: 1px solid #f5f6f8;
        vertical-align: middle;
        color: #4b5563;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .backup-id {
        font-family: monospace;
        font-size: .76rem;
        font-weight: 800;
        color: #8B0000;
        line-height: 1.35;
    }

    .type-pill,
    .status-pill {
        display: inline-flex;
        align-items: center;
        padding: .22rem .6rem;
        border-radius: 999px;
        font-size: .67rem;
        font-weight: 800;
        line-height: 1;
    }

    .type-pill.full {
        background: #fef0ee;
        color: #b42318;
    }

    .type-pill.incremental {
        background: #eaf6ff;
        color: #0b72b9;
    }

    .status-pill.completed {
        background: #dff8e8;
        color: #15803d;
    }

    .status-pill.failed {
        background: #fde8e8;
        color: #b42318;
    }

    .status-pill.in_progress {
        background: #fef3c7;
        color: #a16207;
    }

    .table-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .act-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-size: .72rem;
        transition: .15s ease;
    }

    .act-btn.dl {
        background: #dbeafe;
        color: #2563eb;
    }

    .act-btn.dl:hover {
        background: #2563eb;
        color: #fff;
    }

    .act-btn.restore {
        background: #fef2f2;
        color: #8B0000;
    }

    .act-btn.restore:hover {
        background: #8B0000;
        color: #fff;
    }

    .act-btn.del {
        background: #fff;
        color: #dc2626;
        border: 1px solid #f3d3d3;
    }

    .act-btn.del:hover {
        background: #fef2f2;
    }

    .table-footer {
        padding: .95rem 1rem;
        border-top: 1px solid #f0f2f5;
        background: #fafafa;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        font-size: .78rem;
        color: #9aa3b2;
    }

    .side-stack {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .mini-card-body {
        padding: 1rem 1.15rem 1.1rem;
    }

    .usage-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
        margin-bottom: .7rem;
        font-size: .8rem;
        color: #4b5563;
        font-weight: 700;
    }

    .usage-row .percent {
        color: #b42318;
        font-weight: 800;
    }

    .usage-bar {
        width: 100%;
        height: 7px;
        border-radius: 999px;
        background: #eceef2;
        overflow: hidden;
        margin-bottom: .95rem;
    }

    .usage-fill {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #8B0000 0%, #c0392b 100%);
    }

    .usage-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .8rem;
    }

    .usage-box {
        border-radius: 14px;
        padding: .9rem .95rem;
    }

    .usage-box.full {
        background: #f8eded;
    }

    .usage-box.incremental {
        background: #edf4f8;
    }

    .usage-box-label {
        font-size: .7rem;
        color: #b0b7c3;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: .3rem;
    }

    .usage-box-value {
        font-size: 1.9rem;
        font-weight: 900;
        line-height: 1;
    }

    .usage-box.full .usage-box-value {
        color: #b42318;
    }

    .usage-box.incremental .usage-box-value {
        color: #0b72b9;
    }

    .schedule-item {
        display: grid;
        grid-template-columns: 1fr auto auto;
        align-items: center;
        gap: .75rem;
        padding: .95rem 0;
        border-bottom: 1px solid #f1f3f6;
    }

    .schedule-item:last-of-type {
        border-bottom: none;
    }

    .schedule-title {
        font-size: .88rem;
        font-weight: 800;
        color: #374151;
        margin-bottom: .15rem;
    }

    .schedule-time {
        font-size: .74rem;
        color: #a0a8b6;
    }

    .schedule-pill {
        display: inline-flex;
        align-items: center;
        padding: .25rem .6rem;
        border-radius: 999px;
        font-size: .65rem;
        font-weight: 800;
    }

    .schedule-pill.active {
        background: #dff8e8;
        color: #15803d;
    }

    .schedule-pill.paused {
        background: #fef3c7;
        color: #a16207;
    }

    .schedule-toggle {
        width: 34px;
        height: 20px;
        border-radius: 999px;
        position: relative;
        transition: background .2s ease;
        flex-shrink: 0;
        cursor: pointer;
    }

    .schedule-thumb {
        position: absolute;
        top: 2px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,.22);
        transition: left .2s ease;
    }

    .schedule-edit-btn {
        width: 100%;
        margin-top: .95rem;
        border: 1px solid #e5e7eb;
        background: #fff;
        color: #6b7280;
        border-radius: 10px;
        padding: .8rem 1rem;
        font-size: .78rem;
        font-weight: 700;
        cursor: pointer;
    }

    .schedule-edit-btn:hover {
        background: #f9fafb;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-icon {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto .85rem;
        font-size: 1.3rem;
        color: #d1d5db;
    }

    #backupModal {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.45);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
    }

    #backupModal.open {
        display: flex;
    }

    .backup-modal-inner {
        background: #fff;
        border-radius: 18px;
        padding: 2rem;
        width: 380px;
        max-width: 90vw;
        text-align: center;
        box-shadow: 0 24px 64px rgba(0,0,0,.2);
    }

    #toastContainer {
        position: fixed !important;
        top: calc(var(--header-h, 70px) + 16px) !important;
        right: 20px !important;
        left: auto !important;
        bottom: auto !important;
        z-index: 20000 !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-end !important;
        gap: 10px !important;
        width: auto !important;
        max-width: min(380px, calc(100vw - 32px)) !important;
        pointer-events: none !important;
    }

    .toast {
        position: relative !important;
        inset: auto !important;
        right: auto !important;
        bottom: auto !important;
        left: auto !important;
        top: auto !important;
        display: flex !important;
        align-items: flex-start !important;
        gap: .75rem !important;
        background: #ffffff !important;
        border: 1px solid #ececef !important;
        border-left: 4px solid #8B0000 !important;
        border-radius: 14px !important;
        box-shadow: 0 16px 36px rgba(0,0,0,.12) !important;
        padding: .9rem 1rem !important;
        width: min(380px, calc(100vw - 32px)) !important;
        min-width: unset !important;
        max-width: 380px !important;
        margin: 0 !important;
        opacity: 0;
        transform: translateY(-8px);
        transition: opacity .25s ease, transform .25s ease;
        pointer-events: auto !important;
    }

    .toast.show {
        opacity: 1;
        transform: translateY(0);
    }

    .toast.hide {
        opacity: 0;
        transform: translateY(-8px);
    }

    .toast.success {
        border-left-color: #15803d;
    }

    .toast.error {
        border-left-color: #b42318;
    }

    .toast-icon-wrap {
        flex-shrink: 0;
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f3f4f6;
    }

    .toast.success .toast-icon-wrap {
        background: #e8f7ee;
        color: #15803d;
    }

    .toast.error .toast-icon-wrap {
        background: #fdecec;
        color: #b42318;
    }

    .toast-body {
        flex: 1;
        min-width: 0;
    }

    .toast-title {
        font-size: .82rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: .2rem;
    }

    .toast-msg {
        font-size: .75rem;
        color: #6b7280;
        line-height: 1.4;
    }

    .toast-close {
        border: none;
        background: transparent;
        color: #9ca3af;
        cursor: pointer;
        padding: 0;
        margin-left: .25rem;
        font-size: .85rem;
        flex-shrink: 0;
    }

    .toast-close:hover {
        color: #374151;
    }

    [data-theme="dark"] #toastContainer .toast {
        background: #161b22;
        border-color: #21262d;
    }

    [data-theme="dark"] .toast-title {
        color: #e5e7eb;
    }

    [data-theme="dark"] .toast-msg,
    [data-theme="dark"] .toast-close {
        color: #9ca3af;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .spin {
        animation: spin .8s linear infinite;
        display: inline-block;
    }

    [data-theme="dark"] .backup-page {
        background: #0d1117;
    }

    [data-theme="dark"] .backup-title {
        color: #fca5a5;
    }

    [data-theme="dark"] .backup-subtitle,
    [data-theme="dark"] .backup-stat-label,
    [data-theme="dark"] .card-subtitle,
    [data-theme="dark"] .usage-box-label,
    [data-theme="dark"] .schedule-time,
    [data-theme="dark"] .table-footer {
        color: #9ca3af;
    }

    [data-theme="dark"] .backup-stats,
    [data-theme="dark"] .backup-stat,
    [data-theme="dark"] .card,
    [data-theme="dark"] .mini-card-body,
    [data-theme="dark"] .toolbar select,
    [data-theme="dark"] .schedule-edit-btn {
        background: #161b22 !important;
        border-color: #21262d !important;
    }

    [data-theme="dark"] .data-table thead th,
    [data-theme="dark"] .table-footer {
        background: #0d1117 !important;
        border-color: #21262d !important;
    }

    [data-theme="dark"] .backup-stat-value,
    [data-theme="dark"] .card-title,
    [data-theme="dark"] .schedule-title,
    [data-theme="dark"] .data-table tbody td {
        color: #e5e7eb !important;
    }

    [data-theme="dark"] .usage-bar {
        background: #30363d;
    }

    [data-theme="dark"] .empty-icon {
        background: #21262d;
    }

    [data-theme="dark"] .data-table tbody tr:hover td {
        background: #1c2128;
    }

    [data-theme="dark"] .backup-modal-inner {
        background: #161b22;
    }

    [data-theme="dark"] .backup-stat-value.green {
        color: #15803d !important;
    }

    [data-theme="dark"] .backup-stat-value.red {
        color: #8B0000 !important;
    }

    @media (max-width: 1280px) {
        .backup-stats {
            grid-template-columns: repeat(3, 1fr);
            gap: 0;
        }

        .backup-main {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        .backup-page {
            margin-left: 0;
            padding: 1rem;
        }

        .backup-stats {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 520px) {
        .backup-stats {
            grid-template-columns: 1fr;
        }

        .usage-grid {
            grid-template-columns: 1fr;
        }

        .schedule-item {
            grid-template-columns: 1fr;
            align-items: start;
        }
    }
</style>
@endsection

@section('content')
@php
    $totalAllocatedBytes = $totalAllocatedBytes ?? (50 * 1024 * 1024 * 1024);
    $storageUsedBytes = $storageUsedBytes ?? 0;
    $fullBackupsBytes = $fullBackupsBytes ?? 0;
    $incrementalBackupsBytes = $incrementalBackupsBytes ?? 0;
    $totalBackups = $totalBackups ?? 0;
    $storagePercent = $totalAllocatedBytes > 0 ? round(($storageUsedBytes / $totalAllocatedBytes) * 100, 1) : 0;
    $storageFreeBytes = max($totalAllocatedBytes - $storageUsedBytes, 0);

    $formatBytes = function ($bytes) {
        $bytes = (int) $bytes;
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 1) . ' GB';
        if ($bytes >= 1048576) return number_format($bytes / 1048576, 1) . ' MB';
        if ($bytes >= 1024) return number_format($bytes / 1024, 1) . ' KB';
        return $bytes . ' B';
    };

    $autoBackupEnabled = isset($autoBackupEnabled) ? (bool) $autoBackupEnabled : true;
@endphp

<div id="toastContainer" role="region" aria-live="polite"></div>

<div id="backupModal">
    <div class="backup-modal-inner">
        <div style="width:52px;height:52px;background:linear-gradient(135deg,#8B0000,#6b0000);
        border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
            <i id="modalIcon" class="fa-solid fa-database" style="color:#fff;font-size:1.2rem;"></i>
        </div>

        <div id="modalTitle" style="font-size:.95rem;font-weight:800;
            color:#1f2937;margin-bottom:.3rem;">
                Creating Backup...
            </div>

        <div id="modalSubtitle" style="font-size:.76rem;color:#9ca3af;margin-bottom:1.25rem;">
            Please wait while the system archives your data.
        </div>

        <div style="background:#f3f4f6;border-radius:99px;height:7px;overflow:hidden;margin-bottom:.4rem;">
            <div id="modalBar" style="height:100%;border-radius:99px;
                background:linear-gradient(90deg,#8B0000,#c0392b);
                width:0%;transition:width .3s ease;"></div>
        </div>

        <div id="modalPct" style="font-size:.7rem;
            color:#9ca3af;text-align:right;margin-bottom:1.25rem;">0%</div>
        <button class="terms-cancel-btn" id="modalClose" onclick="closeModal()" disabled>
            Close
        </button>
    </div>
</div>

<div id="scheduleModal" style="position:fixed;inset:0;background:rgba(0,0,0,.45);
    z-index:10000;display:none;align-items:center;justify-content:center;">

    <div style="background:#fff;border-radius:18px;padding:1.5rem;width:460px;
        max-width:92vw;box-shadow:0 24px 64px rgba(0,0,0,.2);">
        <div style="display:flex;align-items:center;
            justify-content:space-between;margin-bottom:1rem;">
            <div>
                <div style="font-size:1rem;font-weight:800;color:#1f2937;">
                    Edit Backup Schedule
                </div>
                <div style="font-size:.75rem;color:#9ca3af;margin-top:.2rem;">
                    Update recurring backup schedule settings
                </div>
            </div>

            <button type="button" onclick="closeScheduleModal()" 
                style="border:none;background:none;
                    font-size:1rem;color:#9ca3af;cursor:pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="scheduleForm">
            <div style="display:grid;gap:1rem;">
                <div>
                    <label style="display:flex;align-items:center;justify-content:space-between;
                        font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.45rem;">
                        <span>
                            Daily Incremental
                        </span>
                        <input type="checkbox" id="daily_enabled" 
                            {{ $backupSchedule['daily_enabled'] ? 'checked' : '' }}>
                    </label>
                    <input type="time" id="daily_time" value="{{ $backupSchedule['daily_time'] }}" 
                        style="width:100%;height:40px;
                        border:1px solid #e5e7eb;border-radius:10px;padding:0 .8rem;">
                </div>

                <div>
                    <label style="display:flex;align-items:center;justify-content:space-between;
                        font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.45rem;">
                        <span>
                            Weekly Full Backup
                        </span>
                        <input type="checkbox" id="weekly_enabled" 
                            {{ $backupSchedule['weekly_enabled'] ? 'checked' : '' }}>
                    </label>
                    <input type="time" id="weekly_time" value="{{ $backupSchedule['weekly_time'] }}" 
                        style="width:100%;height:40px;border:1px solid #e5e7eb;border-radius:10px;padding:0 .8rem;">
                </div>

                <div>
                    <label style="display:flex;align-items:center;justify-content:space-between;
                        font-size:.8rem;font-weight:700;color:#374151;margin-bottom:.45rem;">
                        <span>
                            Monthly Archive
                        </span>
                        <input type="checkbox" id="monthly_enabled" 
                            {{ $backupSchedule['monthly_enabled'] ? 'checked' : '' }}>
                    </label>
                    <input type="time" id="monthly_time" value="{{ $backupSchedule['monthly_time'] }}" 
                        style="width:100%;height:40px;border:1px solid #e5e7eb;border-radius:10px;padding:0 .8rem;">
                </div>
            </div>

            <div style="display:flex;justify-content:flex-end;gap:.75rem;margin-top:1.25rem;">
                <button type="button" onclick="closeScheduleModal()" 
                    class="filter-reset-btn">Cancel</button>
                <button type="submit" class="backup-run-btn" 
                    style="padding:.72rem 1rem;">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<main id="mainContent" class="px-4 sm:px-6 pt-[82px] pb-8 min-h-[calc(100vh-82px)]">
    <div class="max-w-[1280px] mx-auto">
        
        <div class="page-banner">
            <div class="page-banner-inner">

        <div>
            <h1 class="page-title">Data Backup</h1>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="startBackup()"
                class="flex items-center gap-2 bg-white hover:bg-gray-100 text-[#8B0000] 
                px-5 py-2.5 rounded-lg font-semibold text-sm shadow transition-all">
                <i class="fa-solid fa-database"></i>
                Backup Now
            </button>
        </div>

    </div>
</div>

        <div class="backup-stats" id="backupStats">
            <span class="stats-indicator" id="statsIndicator"></span>
            
            <button id="stat-all"
                type="button"
                class="backup-stat clickable {{ !request()->filled('type') && 
                    !request()->filled('status') && !request()->filled('scope') && 
                    request('stat') !== 'last' && request('stat') !== 'auto' ? 'active' : '' }}"
                onclick="animateThenGo(this, '{{ route('admin.data_backup') }}')">
                <div class="backup-stat-value red">{{ $totalBackups }}</div>
                <div class="backup-stat-label">Total Backups</div>
            </button>

            <button id="stat-month"
                type="button"
                class="backup-stat clickable {{ request('scope') === 'month' ? 'active' : '' }}"
                onclick="animateThenGo(this, '{{ route('admin.data_backup', ['scope' => 'month']) }}')">
                <div class="backup-stat-value green">{{ $thisMonthBackups ?? 0 }}</div>
                <div class="backup-stat-label">This Month</div>
            </button>

            <button id="stat-last"
                    type="button"
                    class="backup-stat clickable {{ request('stat') === 'last' ? 'active' : '' }}"
                    onclick="setActiveStat(this); scrollToTable()">
                <div class="backup-stat-value green">
                    {{ isset($lastBackup) && $lastBackup ? $lastBackup->created_at->format('M d') : '—' }}
                </div>
                <div class="backup-stat-label">Last Backup</div>
            </button>

            <button id="stat-auto"
                    type="button"
                    class="backup-stat clickable {{ request('stat') === 'auto' ? 'active' : '' }}"
                    onclick="setActiveStat(this); openScheduleModal(true)">
                <div class="backup-stat-value green">{{ $autoBackupEnabled ? 'Active' : 'Paused' }}</div>
                <div class="backup-stat-label">Auto-Schedule</div>
            </button>
        </div>

        <div class="backup-main">
            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
                        <div>
                            <div class="card-title">Backup History</div>
                            <div class="card-subtitle">All archived snapshots</div>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('admin.data_backup') }}" 
                        class="toolbar" id="backupFilterForm">
                        <select name="type" id="typeFilter">
                            <option value="">All Types</option>
                            <option value="full" {{ request('type') === 'full' ? 'selected' : '' }}>Full</option>
                            <option value="incremental" 
                                {{ request('type') === 'incremental' ? 'selected' : '' }}>Incremental</option>
                        </select>

                        <select name="status" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        </select>

                        @if(request()->filled('type') || request()->filled('status'))
                            <a href="{{ route('admin.data_backup') }}" class="filter-reset-btn">Reset</a>
                        @endif
                    </form>
                </div>

                <div style="overflow-x:auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Backup ID</th>
                                <th>Date & Time</th>
                                <th>Type</th>
                                <th>Size</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="backupTableBody">
                            @forelse($backups as $backup)
                                <tr id="row-{{ $backup->id }}">
                                    <td>
                                        <div class="backup-id">{{ $backup->backup_id }}</div>
                                    </td>
                                    <td>
                                        {{ $backup->created_at ? $backup->created_at->format('M d, Y h:i A') : '—' }}
                                    </td>
                                    <td>
                                        <span class="type-pill {{ $backup->type === 'full' ? 'full' : 'incremental' }}">
                                            {{ ucfirst($backup->type ?? 'full') }}
                                        </span>
                                    </td>
                                    <td style="font-weight:700;">
                                        {{ isset($backup->size_formatted) ? $backup->size_formatted : 
                                            $formatBytes($backup->size_bytes ?? 0) }}
                                    </td>
                                    <td>
                                        <span class="status-pill {{ $backup->status ?? 'completed' }}">
                                            {{ ucfirst(str_replace('_', ' ', $backup->status ?? 'completed')) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="table-actions">
                                            <a class="act-btn dl" title="Download" 
                                                href="{{ route('admin.data_backup.download', $backup->id) }}">
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                            <button type="button" class="act-btn restore" title="Restore" 
                                                onclick="restoreBackup({{ $backup->id }}, '{{ $backup->backup_id }}')">
                                                <i class="fa-solid fa-rotate-left"></i>
                                            </button>
                                            <button type="button" class="act-btn del" title="Delete" 
                                                onclick="deleteBackup({{ $backup->id }}, '{{ $backup->backup_id }}')">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="empty-icon"><i class="fa-solid fa-database"></i></div>
                                            <p style="font-size:.9rem;font-weight:800;
                                                color:#6b7280;margin:0 0 .25rem;">No backups found.</p>
                                            <p style="font-size:.78rem;color:#b0b7c3;margin:0;">
                                                Create your first backup to start protecting system data</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="table-footer">
                    <span>Showing {{ $backups->firstItem() ?? 0 }}–{{ $backups->lastItem() ?? 0 }} of 
                        {{ $backups->total() }} backups</span>
                    <div>{{ $backups->links() }}</div>
                </div>
            </div>

            <div class="side-stack">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon"><i class="fa-solid fa-database"></i></div>
                            <div>
                                <div class="card-title">Storage Usage</div>
                                <div class="card-subtitle">{{ $formatBytes($totalAllocatedBytes) }} total allocated</div>
                            </div>
                        </div>
                    </div>

                    <div class="mini-card-body">
                        <div class="usage-row">
                            <span>{{ $formatBytes($storageUsedBytes) }} used</span>
                            <span class="percent">{{ $storagePercent }}%</span>
                        </div>

                        <div class="usage-bar">
                            <div class="usage-fill" style="width: {{ min($storagePercent, 100) }}%;"></div>
                        </div>

                        <div class="usage-grid">
                            <div class="usage-box full">
                                <div class="usage-box-label">Full Backups</div>
                                <div class="usage-box-value">{{ $formatBytes($fullBackupsBytes) }}</div>
                            </div>

                            <div class="usage-box incremental">
                                <div class="usage-box-label">Incremental</div>
                                <div class="usage-box-value">{{ $formatBytes($incrementalBackupsBytes) }}</div>
                            </div>
                        </div>

                        <div style="margin-top:.9rem;font-size:.75rem;color:#9aa3b2;font-weight:700;">
                            Free Space: {{ $formatBytes($storageFreeBytes) }}
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon"><i class="fa-solid fa-clock"></i></div>
                            <div>
                                <div class="card-title">Auto-Backup Schedule</div>
                                <div class="card-subtitle">Configure recurring backups</div>
                            </div>
                        </div>
                    </div>

                    <div class="mini-card-body" id="scheduleCard">
                        <div class="schedule-item">
                            <div>
                                <div class="schedule-title">Daily Incremental</div>
                                <div class="schedule-time">
                                    Every day at {{ \Carbon\Carbon::createFromFormat('H:i', $backupSchedule['daily_time'])->format('g:i A') }}
                                </div>
                            </div>
                            <span class="schedule-pill {{ $backupSchedule['daily_enabled'] ? 'active' : 'paused' }}">
                                {{ $backupSchedule['daily_enabled'] ? 'Active' : 'Paused' }}
                            </span>
                            <div class="schedule-toggle"
                                 onclick="toggleSchedule('daily')"
                                 style="background:{{ $backupSchedule['daily_enabled'] ? '#8B0000' : '#d1d5db' }};">
                                <div class="schedule-thumb" style="left:{{ $backupSchedule['daily_enabled'] ? '16px' : '2px' }};"></div>
                            </div>
                        </div>

                        <div class="schedule-item">
                            <div>
                                <div class="schedule-title">Weekly Full Backup</div>
                                <div class="schedule-time">
                                    Every Sunday at {{ \Carbon\Carbon::createFromFormat('H:i', $backupSchedule['weekly_time'])->format('g:i A') }}
                                </div>
                            </div>
                            <span class="schedule-pill {{ $backupSchedule['weekly_enabled'] ? 'active' : 'paused' }}">
                                {{ $backupSchedule['weekly_enabled'] ? 'Active' : 'Paused' }}
                            </span>
                            <div class="schedule-toggle"
                                 onclick="toggleSchedule('weekly')"
                                 style="background:{{ $backupSchedule['weekly_enabled'] ? '#8B0000' : '#d1d5db' }};">
                                <div class="schedule-thumb" style="left:{{ $backupSchedule['weekly_enabled'] ? '16px' : '2px' }};"></div>
                            </div>
                        </div>

                        <div class="schedule-item">
                            <div>
                                <div class="schedule-title">Monthly Archive</div>
                                <div class="schedule-time">
                                    1st of every month at {{ \Carbon\Carbon::createFromFormat('H:i', $backupSchedule['monthly_time'])->format('g:i A') }}
                                </div>
                            </div>
                            <span class="schedule-pill {{ $backupSchedule['monthly_enabled'] ? 'active' : 'paused' }}">
                                {{ $backupSchedule['monthly_enabled'] ? 'Active' : 'Paused' }}
                            </span>
                            <div class="schedule-toggle"
                                 onclick="toggleSchedule('monthly')"
                                 style="background:{{ $backupSchedule['monthly_enabled'] ? '#8B0000' : '#d1d5db' }};">
                                <div class="schedule-thumb" style="left:{{ $backupSchedule['monthly_enabled'] ? '16px' : '2px' }};"></div>
                            </div>
                        </div>

                        <button class="schedule-edit-btn" type="button" onclick="openScheduleModal()">
                            <i class="fa-solid fa-pen-to-square" style="margin-right:.45rem;"></i> Edit Schedule Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let scheduleOn = @json($autoBackupEnabled);
    let backupSchedule = @json($backupSchedule);

    const restoreUrlTemplate = @json(route('admin.data_backup.restore', ['id' => '__ID__']));
    const deleteUrlTemplate = @json(route('admin.data_backup.delete', ['id' => '__ID__']));

    async function startBackup() {
        const modal = document.getElementById('backupModal');
        const bar = document.getElementById('modalBar');
        const pct = document.getElementById('modalPct');
        const title = document.getElementById('modalTitle');
        const sub = document.getElementById('modalSubtitle');
        const btn = document.getElementById('modalClose');
        const icon = document.getElementById('modalIcon');
        const backupBtn = document.getElementById('backupNowBtn');

        if (backupBtn) {
            backupBtn.disabled = true;
            backupBtn.style.opacity = '.7';
            backupBtn.style.pointerEvents = 'none';
        }

        bar.style.width = '0%';
        pct.textContent = '0%';
        title.textContent = 'Creating Backup...';
        sub.textContent = 'Please wait while the system archives your data.';
        icon.className = 'fa-solid fa-database spin';
        btn.disabled = true;
        modal.classList.add('open');

        let p = 0;
        const fakeProgress = setInterval(() => {
            if (p < 90) {
                p += 5;
                bar.style.width = p + '%';
                pct.textContent = p + '%';
            }
        }, 150);

        try {
            const response = await fetch("{{ route('admin.data_backup.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ type: 'full' })
            });

            const result = await response.json();
            clearInterval(fakeProgress);

            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Backup failed.');
            }

            bar.style.width = '100%';
            pct.textContent = '100%';
            title.textContent = 'Backup Complete!';
            sub.textContent = result.message || 'Your data has been successfully backed up.';
            icon.className = 'fa-solid fa-circle-check';
            btn.disabled = false;

            showToast('Backup Complete', result.message || 
                'New backup saved successfully.', 'success');
            setTimeout(() => window.location.reload(), 1000);
        } catch (error) {
            clearInterval(fakeProgress);
            title.textContent = 'Backup Failed';
            sub.textContent = error.message;
            icon.className = 'fa-solid fa-circle-exclamation';
            btn.disabled = false;
            showToast('Backup Failed', error.message, 'error');
        } finally {
            if (backupBtn) {
                backupBtn.disabled = false;
                backupBtn.style.opacity = '';
                backupBtn.style.pointerEvents = '';
            }
        }
    }

    function closeModal() {
        document.getElementById('backupModal').classList.remove('open');
    }

    function openScheduleModal(updateUrl = false) {
        document.getElementById('daily_enabled').checked = !!backupSchedule.daily_enabled;
        document.getElementById('daily_time').value = backupSchedule.daily_time;
        document.getElementById('weekly_enabled').checked = !!backupSchedule.weekly_enabled;
        document.getElementById('weekly_time').value = backupSchedule.weekly_time;
        document.getElementById('monthly_enabled').checked = !!backupSchedule.monthly_enabled;
        document.getElementById('monthly_time').value = backupSchedule.monthly_time;

        document.getElementById('scheduleModal').style.display = 'flex';

        if (updateUrl) {
            const url = new URL(window.location.href);
            url.searchParams.set('stat', 'auto');
            window.history.replaceState({}, '', url);
        }
    }

    function closeScheduleModal() {
        document.getElementById('scheduleModal').style.display = 'none';

        const url = new URL(window.location.href);
        if (url.searchParams.get('stat') === 'auto') {
            url.searchParams.delete('stat');
            window.history.replaceState({}, '', url);
        }
    }

    async function toggleSchedule(type) {
        try {
            backupSchedule[type + '_enabled'] = !backupSchedule[type + '_enabled'];

            const response = await fetch("{{ route('admin.data_backup.update_schedule') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    daily_enabled: !!backupSchedule.daily_enabled,
                    daily_time: backupSchedule.daily_time,
                    weekly_enabled: !!backupSchedule.weekly_enabled,
                    weekly_time: backupSchedule.weekly_time,
                    monthly_enabled: !!backupSchedule.monthly_enabled,
                    monthly_time: backupSchedule.monthly_time,
                })
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                backupSchedule[type + '_enabled'] = !backupSchedule[type + '_enabled'];
                throw new Error(result.message || 'Failed to update schedule.');
            }

            scheduleOn = !!result.auto_backup_enabled;
            showToast('Schedule Updated', result.message, 'success');
            setTimeout(() => window.location.reload(), 1200);
        } catch (error) {
            showToast('Schedule Update Failed', error.message, 'error');
        }
    }

    async function restoreBackup(id, backupId) {
        if (!confirm(`Restore ${backupId}?`)) return;

        try {
            const response = await fetch(restoreUrlTemplate.replace('__ID__', id), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Restore failed.');
            }

            showToast('Restore', result.message, 'success');
        } catch (error) {
            showToast('Restore Failed', error.message, 'error');
        }
    }

    async function deleteBackup(id, backupId) {
        if (!confirm(`Delete ${backupId}? This cannot be undone.`)) return;

        try {
            const response = await fetch(deleteUrlTemplate.replace('__ID__', id), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Delete failed.');
            }

            const row = document.getElementById(`row-${id}`);
            if (row) row.remove();

            showToast('Deleted', result.message, 'success');
            setTimeout(() => window.location.reload(), 700);
        } catch (error) {
            showToast('Delete Failed', error.message, 'error');
        }
    }

    function setActiveStat(el) {
        document.querySelectorAll('.backup-stat').forEach(stat => stat.classList.remove('active'));
        el.classList.add('active');
        requestAnimationFrame(moveStatsIndicator);
    }

    function animateThenGo(el, url) {
        setActiveStat(el);
        setTimeout(() => {
            window.location = url;
        }, 380);
    }

    function moveStatsIndicator() {
        const container = document.getElementById('backupStats');
        const indicator = document.getElementById('statsIndicator');
        const active = container ? container.querySelector('.backup-stat.active') : null;

        if (!container || !indicator || !active) return;

        const containerRect = container.getBoundingClientRect();
        const activeRect = active.getBoundingClientRect();

        const left = activeRect.left - containerRect.left;
        const width = activeRect.width;

        if (!indicator.dataset.ready) {
            indicator.style.transition = 'none';
            indicator.style.left = left + 'px';
            indicator.style.width = width + 'px';
            indicator.offsetHeight;
            indicator.style.transition = '';
            indicator.dataset.ready = '1';
        } else {
            indicator.style.left = left + 'px';
            indicator.style.width = width + 'px';
        }
    }

    function scrollToTable() {
        const table = document.getElementById('backupTableBody');

        const url = new URL(window.location.href);
        url.searchParams.set('stat', 'last');
        window.history.replaceState({}, '', url);

        if (table) {
            table.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function closeToast(button) {
        const toast = button.closest('.toast');
        if (!toast) return;

        toast.classList.remove('show');
        toast.classList.add('hide');

        setTimeout(() => {
            toast.remove();
        }, 400);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const filterForm = document.getElementById('backupFilterForm');
        const typeFilter = document.getElementById('typeFilter');
        const statusFilter = document.getElementById('statusFilter');
        const scheduleForm = document.getElementById('scheduleForm');

        if (typeFilter) {
            typeFilter.addEventListener('change', function () {
                filterForm.submit();
            });
        }

        if (statusFilter) {
            statusFilter.addEventListener('change', function () {
                filterForm.submit();
            });
        }

        if (scheduleForm) {
            scheduleForm.addEventListener('submit', async function (e) {
                e.preventDefault();

                try {
                    const response = await fetch("{{ route('admin.data_backup.update_schedule') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            daily_enabled: document.getElementById('daily_enabled').checked,
                            daily_time: document.getElementById('daily_time').value,
                            weekly_enabled: document.getElementById('weekly_enabled').checked,
                            weekly_time: document.getElementById('weekly_time').value,
                            monthly_enabled: document.getElementById('monthly_enabled').checked,
                            monthly_time: document.getElementById('monthly_time').value,
                        })
                    });

                    const result = await response.json();

                    if (!response.ok || !result.success) {
                        throw new Error(result.message || 'Failed to update schedule.');
                    }

                    backupSchedule.daily_enabled = document.getElementById('daily_enabled').checked;
                    backupSchedule.daily_time = document.getElementById('daily_time').value;
                    backupSchedule.weekly_enabled = document.getElementById('weekly_enabled').checked;
                    backupSchedule.weekly_time = document.getElementById('weekly_time').value;
                    backupSchedule.monthly_enabled = document.getElementById('monthly_enabled').checked;
                    backupSchedule.monthly_time = document.getElementById('monthly_time').value;
                    scheduleOn = !!result.auto_backup_enabled;

                    closeScheduleModal();
                    showToast('Schedule Updated', result.message, 'success');
                    setTimeout(() => window.location.reload(), 700);
                } catch (error) {
                    showToast('Schedule Update Failed', error.message, 'error');
                }
            });
        }

        moveStatsIndicator();
    });

    window.addEventListener('resize', moveStatsIndicator);

    function showToast(title, message, type = 'error') {
        const c = document.getElementById('toastContainer');
        const t = document.createElement('div');
        t.className = 'toast ' + type;
        t.innerHTML = `
            <div class="toast-icon-wrap">
                <i class="fa-solid ${type === 'success' ? 'fa-circle-check' : 
                    'fa-circle-exclamation'} toast-icon"></i>
            </div>
            <div class="toast-body">
                <div class="toast-title">${title}</div>
                <div class="toast-msg">${message}</div>
            </div>
            <button class="toast-close" onclick="closeToast(this)">
                <i class="fa-solid fa-xmark"></i>
            </button>
        `;
        c.appendChild(t);
        requestAnimationFrame(() => requestAnimationFrame(() => t.classList.add('show')));
        setTimeout(() => {
            if (!t.isConnected) return;
            t.classList.remove('show');
            t.classList.add('hide');
            setTimeout(() => {
                if (t.isConnected) t.remove();
            }, 400);
        }, 4500);
    }
</script>
@endsection