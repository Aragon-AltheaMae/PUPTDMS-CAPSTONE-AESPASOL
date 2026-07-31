@push('styles')
<style>
    .continuity-page {
        --dt-red: #8b0000;
        --dt-red-deep: #6f0606;
        --dt-red-soft: #fff5f2;
        --dt-ink: #3f2c2c;
        --dt-muted: #8c6f6f;
        --dt-border: #efd8d3;
        --dt-shadow: 0 18px 40px rgba(122, 20, 16, 0.08);
        --dt-font-title: 1.02rem;
        --dt-font-body: 0.93rem;
        --dt-font-meta: 0.82rem;
        --dt-font-label: 0.72rem;
        font-family: inherit;
    }

    .continuity-page .dt-wrap {
        width: 100%;
        font-family: inherit;
    }

    .continuity-page .page-title,
    .continuity-page .dt-section-head h2,
    .continuity-page .dt-section-head h3,
    .continuity-page .dt-cell-title,
    .continuity-page .dt-cell-sub,
    .continuity-page .dt-summary-label,
    .continuity-page .dt-summary-card strong,
    .continuity-page .dt-label,
    .continuity-page .dt-note-block h3,
    .continuity-page .dt-note-block p,
    .continuity-page .dt-ready-box h3,
    .continuity-page .dt-ready-box li,
    .continuity-page .dt-checkline,
    .continuity-page .dt-table,
    .continuity-page .dt-table th,
    .continuity-page .dt-table td,
    .continuity-page .dt-btn,
    .continuity-page .dt-input,
    .continuity-page .dt-select,
    .continuity-page .dt-textarea {
        font-family: inherit;
    }

    .continuity-page .dt-hero {
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .continuity-page .dt-hero .page-banner-inner {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1rem;
    }

    .continuity-page .dt-kicker {
        display: inline-flex;
        align-items: center;
        gap: .55rem;
        margin: 0 0 .55rem;
        color: rgba(255, 255, 255, .84);
        font-size: .78rem;
        font-weight: 800;
        letter-spacing: .18em;
        text-transform: uppercase;
    }

    .continuity-page .dt-kicker::before {
        content: "";
        width: .65rem;
        height: .65rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, .86);
        box-shadow: 0 0 0 6px rgba(255, 255, 255, .12);
    }

    .continuity-page .dt-hero-copy {
        max-width: 760px;
    }

    .continuity-page .page-title {
        font-size: clamp(1.82rem, 3vw, 2.35rem);
        font-weight: 800;
        line-height: 1.06;
        letter-spacing: -0.03em;
    }

    .continuity-page .dt-subtitle {
        margin: .65rem 0 0;
        color: rgba(255, 255, 255, .92);
        font-size: var(--dt-font-body);
        line-height: 1.65;
        max-width: 840px;
    }

    .continuity-page .dt-panel,
    .continuity-page .dt-summary-card,
    .continuity-page .dt-action-card {
        background: #fff;
        border: 1px solid var(--dt-border);
        border-radius: 28px;
        box-shadow: var(--dt-shadow);
    }

    .continuity-page .dt-panel {
        padding: 1.35rem;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.98) 0%, rgba(255, 251, 249, 0.98) 100%);
    }

    .continuity-page .dt-wrap > .dt-panel + .dt-panel {
        margin-top: 1rem;
    }

    .continuity-page .dt-section-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .continuity-page .dt-section-head h2,
    .continuity-page .dt-section-head h3 {
        margin: 0;
        color: var(--dt-ink);
        font-size: var(--dt-font-title);
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .continuity-page .dt-section-head p {
        margin: .3rem 0 0;
        color: var(--dt-muted);
        font-size: var(--dt-font-meta);
        line-height: 1.55;
    }

    .continuity-page .dt-summary-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem;
        margin-bottom: 1.15rem;
    }

    .continuity-page .dt-summary-card {
        padding: 1.2rem 1.25rem;
    }

    .continuity-page .dt-summary-label {
        display: block;
        margin-bottom: .45rem;
        color: var(--dt-muted);
        font-size: var(--dt-font-label);
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .continuity-page .dt-summary-card strong {
        display: block;
        color: var(--dt-red);
        font-size: 1.78rem;
        font-weight: 900;
        line-height: 1;
    }

    .continuity-page .dt-summary-card span:last-child {
        display: block;
        margin-top: .45rem;
        color: #9c7e7e;
        font-size: var(--dt-font-meta);
    }

    .continuity-page .dt-filter-grid {
        display: grid;
        grid-template-columns: 1.15fr 1.15fr .9fr .9fr .85fr auto;
        gap: .85rem;
        align-items: end;
    }

    .continuity-page .dt-field {
        display: flex;
        flex-direction: column;
        gap: .45rem;
    }

    .continuity-page .dt-label {
        color: #6d4747;
        font-size: var(--dt-font-label);
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .continuity-page .dt-input,
    .continuity-page .dt-select,
    .continuity-page .dt-textarea {
        width: 100%;
        min-height: 54px;
        padding: .95rem 1.05rem;
        border: 1px solid var(--dt-border);
        border-radius: 18px;
        background: #fffdfc;
        color: var(--dt-ink);
        font-size: var(--dt-font-body);
        transition: border-color .18s ease, box-shadow .18s ease, background-color .18s ease;
    }

    .continuity-page .dt-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        padding-right: 3.2rem;
        background-color: #fff;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='none'%3E%3Cpath d='M5 7.5L10 12.5L15 7.5' stroke='%23665112' stroke-width='1.9' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1rem;
        cursor: pointer;
    }

    .continuity-page .dt-select:hover {
        border-color: rgba(139, 0, 0, .24);
        background-color: #fffaf8;
    }

    .continuity-page .dt-textarea {
        min-height: 132px;
        resize: vertical;
    }

    .continuity-page .dt-input:focus,
    .continuity-page .dt-select:focus,
    .continuity-page .dt-textarea:focus {
        outline: none;
        border-color: rgba(139, 0, 0, .42);
        box-shadow: 0 0 0 4px rgba(139, 0, 0, .08);
        background: #fff;
    }

    .continuity-page .dt-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
    }

    .continuity-page .dt-span-2 {
        grid-column: 1 / -1;
    }

    .continuity-page .dt-form-actions,
    .continuity-page .dt-toolbar-row,
    .continuity-page .dt-action-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .9rem;
        flex-wrap: wrap;
    }

    .continuity-page .dt-actions,
    .continuity-page .dt-btn-row {
        display: flex;
        gap: .65rem;
        flex-wrap: wrap;
    }

    .continuity-page .dt-table .dt-actions {
        flex-wrap: nowrap;
        justify-content: flex-start;
        gap: .45rem;
    }

    .continuity-page .dt-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .55rem;
        min-height: 50px;
        padding: .88rem 1.2rem;
        border-radius: 16px;
        border: 0;
        text-decoration: none;
        font-size: var(--dt-font-body);
        font-weight: 800;
        cursor: pointer;
        transition: transform .18s ease, box-shadow .18s ease, opacity .18s ease;
    }

    .continuity-page .dt-btn:hover {
        transform: translateY(-1px);
    }

    .continuity-page .dt-btn:disabled {
        opacity: .55;
        cursor: not-allowed;
        transform: none;
    }

    .continuity-page .dt-btn-primary {
        background: #7a0c12;
        color: #fff;
        box-shadow: 0 12px 24px rgba(139, 0, 0, .18);
    }

    .continuity-page .dt-btn-secondary {
        background: #f8ece8;
        color: #7a2421;
    }

    .continuity-page .dt-btn-light {
        background: rgba(255, 246, 244, .98);
        color: #8b0000;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .28);
    }

    .continuity-page .dt-btn-danger {
        background: #7a0c12;
        color: #fff;
    }

    .continuity-page .dt-btn-sm {
        min-height: 34px;
        padding: .45rem .78rem;
        font-size: .8rem;
        border-radius: 12px;
        min-width: 0;
    }

    .continuity-page .dt-table-wrap {
        overflow-x: auto;
        border-radius: 22px;
        background: rgba(255, 251, 250, 0.72);
    }

    .continuity-page .dt-table {
        width: 100%;
        border-collapse: collapse;
    }

    .continuity-page .dt-table th,
    .continuity-page .dt-table td {
        padding: 1rem .8rem;
        border-bottom: 1px solid #f3dfda;
        text-align: left;
        vertical-align: top;
    }

    .continuity-page .dt-table th {
        color: var(--dt-red);
        font-size: var(--dt-font-label);
        font-weight: 900;
        letter-spacing: .16em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .continuity-page .dt-cell-title {
        color: var(--dt-ink);
        font-weight: 800;
        font-size: var(--dt-font-body);
        line-height: 1.3;
    }

    .continuity-page .dt-cell-sub {
        color: var(--dt-muted);
        font-size: var(--dt-font-meta);
        line-height: 1.45;
    }

    .continuity-page .dt-inline-value {
        display: inline-block;
        max-width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        vertical-align: top;
    }

    .continuity-page .dt-inline-value-xs {
        max-width: 100px;
        font-size: var(--dt-font-meta);
    }

    .continuity-page .dt-inline-value-sm {
        max-width: 150px;
        font-size: var(--dt-font-body);
    }

    .continuity-page .dt-inline-value-md {
        max-width: 210px;
        font-size: var(--dt-font-body);
    }

    .continuity-page .dt-responsibility-table td {
        vertical-align: middle;
        padding-top: 1.15rem;
        padding-bottom: 1.15rem;
    }

    .continuity-page .dt-responsibility-table .dt-inline-value,
    .continuity-page .dt-responsibility-table .dt-cell-title,
    .continuity-page .dt-responsibility-table .dt-cell-sub {
        line-height: 1.35;
    }

    .continuity-page .dt-responsibility-table .dt-inline-value-sm {
        max-width: 165px;
    }

    .continuity-page .dt-responsibility-table .dt-inline-value-xs {
        max-width: 120px;
    }

    .continuity-page .dt-responsibility-table .dt-select,
    .continuity-page .dt-responsibility-table .dt-input {
        min-height: 44px;
        padding: .72rem .95rem;
        font-size: .92rem;
        border-radius: 16px;
    }

    .continuity-page .dt-responsibility-table .dt-select {
        padding-right: 2.75rem;
        background-position: right .85rem center;
        background-size: .92rem;
    }

    .continuity-page .dt-responsibility-table td:nth-child(5) .dt-select {
        max-width: 225px;
    }

    .continuity-page .dt-responsibility-table td:nth-child(6) .dt-select {
        min-width: 168px;
        max-width: 168px;
    }

    .continuity-page .dt-empty {
        padding: 2.4rem 1rem;
        text-align: center;
        color: var(--dt-muted);
        font-size: 1rem;
    }

    .continuity-page .dt-progress {
        width: 150px;
        height: 11px;
        border-radius: 999px;
        background: #f5dfdb;
        overflow: hidden;
        margin-bottom: .35rem;
    }

    .continuity-page .dt-progress-bar {
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, #8b0000 0%, #d24432 100%);
    }

    .continuity-page .dt-badge {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .52rem .76rem;
        border-radius: 999px;
        font-size: .77rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .continuity-page .dt-badge::before {
        content: "";
        width: .5rem;
        height: .5rem;
        border-radius: 999px;
        background: currentColor;
        opacity: .65;
    }

    .continuity-page .dt-badge-draft {
        background: #fff3e2;
        color: #b96c09;
    }

    .continuity-page .dt-badge-pending_review,
    .continuity-page .dt-badge-handover_in_progress {
        background: #fff2cc;
        color: #9a6407;
    }

    .continuity-page .dt-badge-scheduled {
        background: #e7f0ff;
        color: #1d4ed8;
    }

    .continuity-page .dt-badge-completed {
        background: #e8f9ef;
        color: #18794e;
    }

    .continuity-page .dt-badge-cancelled {
        background: #fde8e8;
        color: #b42318;
    }

    .continuity-page .dt-alert {
        margin-bottom: 1rem;
        padding: .95rem 1rem;
        border-radius: 18px;
        font-weight: 700;
    }

    .continuity-page .dt-alert-success {
        background: #ecfdf3;
        border: 1px solid #c6f6d5;
        color: #166534;
    }

    .continuity-page .dt-alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    .continuity-page .dt-page-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.38fr) minmax(300px, .62fr);
        gap: 1rem;
        margin-bottom: 1rem;
        align-items: stretch;
    }

    .continuity-page .dt-info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .95rem 1rem;
        margin: 0;
    }

    .continuity-page .dt-info-grid dt {
        margin-bottom: .22rem;
        color: var(--dt-muted);
        font-size: var(--dt-font-label);
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .continuity-page .dt-info-grid dd {
        margin: 0;
        color: var(--dt-ink);
        font-weight: 800;
        font-size: var(--dt-font-body);
        line-height: 1.45;
    }

    .continuity-page .dt-info-grid > div:last-child,
    .continuity-page .dt-info-grid > div:nth-last-child(2) {
        margin-bottom: .6rem;
    }

    .continuity-page .dt-note-block,
    .continuity-page .dt-ready-box,
    .continuity-page .dt-checklist-item,
    .continuity-page .dt-action-card {
        background: var(--dt-red-soft);
        border: 1px solid #f0d8d1;
        border-radius: 20px;
    }

    .continuity-page .dt-note-block,
    .continuity-page .dt-ready-box,
    .continuity-page .dt-action-card {
        padding: 1rem 1.05rem;
    }

    .continuity-page .dt-page-grid > .dt-panel {
        min-height: 100%;
    }

    .continuity-page .dt-page-grid > .dt-panel:last-child {
        padding: 1.1rem;
    }

    .continuity-page .dt-action-card {
        display: flex;
        flex-direction: column;
        min-height: 100%;
    }

    .continuity-page .dt-note-block + .dt-note-block {
        margin-top: .85rem;
    }

    .continuity-page .dt-note-block h3,
    .continuity-page .dt-ready-box h3,
    .continuity-page .dt-action-card h3 {
        margin: 0 0 .4rem;
        color: #7d1f1d;
        font-size: var(--dt-font-body);
        font-weight: 800;
    }

    .continuity-page .dt-note-block p,
    .continuity-page .dt-action-card p {
        margin: 0;
        color: #6e5757;
        font-size: var(--dt-font-meta);
        line-height: 1.6;
    }

    .continuity-page .dt-note-block {
        background: linear-gradient(180deg, #fff7f4 0%, #fff2ed 100%);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .8);
    }

    .continuity-page .dt-note-block h3 {
        display: flex;
        align-items: center;
        gap: .55rem;
        color: #8b2320;
        margin-bottom: .5rem;
    }

    .continuity-page .dt-note-block h3::before {
        content: "";
        width: .62rem;
        height: .62rem;
        border-radius: 999px;
        background: linear-gradient(135deg, #8b0000 0%, #c63d2d 100%);
        box-shadow: 0 0 0 5px rgba(139, 0, 0, .08);
    }

    .continuity-page .dt-action-card > .dt-btn,
    .continuity-page .dt-action-card > .dt-btn-row {
        margin-top: auto;
    }

    .continuity-page .dt-action-card .dt-input,
    .continuity-page .dt-action-card .dt-textarea {
        margin-bottom: .8rem;
    }

    .continuity-page .dt-action-card .dt-textarea {
        min-height: 164px;
    }

    .continuity-page .dt-actions-grid {
        align-items: stretch;
    }

    .continuity-page .dt-actions-grid .dt-btn {
        min-width: 212px;
        justify-content: center;
        border-radius: 18px;
    }

    .continuity-page .dt-ready-pill {
        display: inline-flex;
        align-items: center;
        gap: .55rem;
        margin-bottom: .85rem;
        width: 100%;
        padding: .78rem .9rem;
        border-radius: 16px;
        font-weight: 800;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .65);
    }

    .continuity-page .dt-ready-pill.success {
        background: #ecfdf3;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .continuity-page .dt-ready-pill.warning {
        background: #fff7ed;
        border: 1px solid #fdba74;
        color: #9a3412;
    }

    .continuity-page .dt-ready-pill-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1.65rem;
        height: 1.65rem;
        border-radius: 999px;
        flex-shrink: 0;
        background: rgba(255, 255, 255, .7);
    }

    .continuity-page .dt-ready-columns {
        display: grid;
        grid-template-columns: 1fr;
        gap: .8rem;
    }

    .continuity-page .dt-ready-box ul {
        margin: .65rem 0 0;
        padding-left: 0;
        color: #6d4747;
        list-style: none;
    }

    .continuity-page .dt-ready-box li + li {
        margin-top: .55rem;
    }

    .continuity-page .dt-ready-box {
        background: linear-gradient(180deg, #fff8f6 0%, #fff2ee 100%);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .8);
        padding: .9rem .95rem;
    }

    .continuity-page .dt-ready-box h3 {
        display: flex;
        align-items: center;
        gap: .6rem;
        color: #8b2320;
        margin-bottom: .1rem;
        font-size: var(--dt-font-body);
    }

    .continuity-page .dt-ready-box h3 i {
        font-size: .84rem;
        color: #9f1f17;
    }

    .continuity-page .dt-ready-box li {
        position: relative;
        padding-left: .95rem;
        line-height: 1.4;
        font-size: var(--dt-font-meta);
    }

    .continuity-page .dt-ready-box li::before {
        content: "";
        position: absolute;
        left: 0;
        top: .56rem;
        width: .32rem;
        height: .32rem;
        border-radius: 999px;
        background: #d24d3a;
        opacity: .9;
    }

    .continuity-page .dt-page-grid > .dt-panel:last-child .dt-section-head {
        margin-bottom: .7rem;
    }

    .continuity-page .dt-page-grid > .dt-panel:last-child .dt-section-head h2 {
        font-size: var(--dt-font-title);
    }

    .continuity-page .dt-page-grid > .dt-panel:last-child .dt-section-head p {
        font-size: var(--dt-font-meta);
    }

    .continuity-page .dt-assign-toolbar {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .continuity-page .dt-assign-field {
        width: min(360px, 100%);
    }

    .continuity-page .dt-checklist-grid,
    .continuity-page .dt-actions-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
    }

    .continuity-page .dt-actions-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .continuity-page .dt-checklist-item {
        padding: 1rem;
    }

    .continuity-page .dt-form-actions {
        justify-content: flex-end;
        margin-top: 1rem;
        padding-top: .15rem;
    }

    .continuity-page .dt-btn-save-checklist {
        min-width: 220px;
        min-height: 52px;
        border-radius: 18px;
        box-shadow: 0 14px 28px rgba(139, 0, 0, .16);
    }

    .continuity-page .dt-btn-impact {
        box-shadow: 0 12px 24px rgba(139, 0, 0, .2);
    }

    .continuity-page .dt-checkline {
        display: flex;
        align-items: flex-start;
        gap: .7rem;
        margin-bottom: .8rem;
        color: var(--dt-ink);
        font-weight: 800;
        font-size: var(--dt-font-body);
        line-height: 1.5;
    }

    .continuity-page .dt-checkline input[type="checkbox"] {
        width: 18px;
        height: 18px;
        margin-top: .15rem;
        accent-color: var(--dt-red);
    }

    .continuity-page .dt-error {
        margin: .4rem 0 0;
        color: #d02626;
        font-size: var(--dt-font-meta);
        font-weight: 700;
    }

    .continuity-page .dt-table tbody tr,
    .continuity-page .dt-responsibility-table tbody tr {
        transition: background-color .18s ease;
    }

    .continuity-page .dt-table tbody tr:hover,
    .continuity-page .dt-responsibility-table tbody tr:hover {
        background: rgba(139, 0, 0, 0.025);
    }

    .continuity-page .dt-pagination {
        margin-top: 1rem;
    }

    .continuity-page .dt-table-card {
        padding-top: 1.05rem;
    }

    .continuity-page .dt-table-card .dt-table th,
    .continuity-page .dt-table-card .dt-table td {
        vertical-align: middle;
    }

    .continuity-page .dt-table-card .dt-table th:first-child,
    .continuity-page .dt-table-card .dt-table td:first-child {
        text-align: left;
    }

    .continuity-page .dt-table-card .dt-table th:not(:first-child),
    .continuity-page .dt-table-card .dt-table td:not(:first-child) {
        text-align: center;
    }

    .continuity-page .dt-table-card .dt-table td:not(:first-child) .dt-inline-value {
        margin-inline: auto;
    }

    .continuity-page .dt-table-card .dt-progress {
        margin: 0 auto .35rem;
    }

    .continuity-page .dt-table-card .dt-cell-sub {
        text-align: inherit;
    }

    .continuity-page .dt-table-card .dt-badge {
        justify-content: center;
    }

    .continuity-page .dt-table-card .dt-actions {
        justify-content: center;
        align-items: center;
    }

    @media (max-width: 1200px) {
        .continuity-page .dt-filter-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 1024px) {
        .continuity-page .dt-summary-grid,
        .continuity-page .dt-page-grid,
        .continuity-page .dt-checklist-grid,
        .continuity-page .dt-actions-grid {
            grid-template-columns: 1fr;
        }

        .continuity-page .dt-filter-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .continuity-page .dt-hero .page-banner-inner,
        .continuity-page .dt-section-head {
            align-items: flex-start;
            flex-direction: column;
        }
    }

    @media (max-width: 768px) {
        .continuity-page .dt-filter-grid,
        .continuity-page .dt-form-grid,
        .continuity-page .dt-info-grid {
            grid-template-columns: 1fr;
        }

        .continuity-page .dt-span-2 {
            grid-column: auto;
        }

        .continuity-page .dt-panel,
        .continuity-page .dt-summary-card {
            padding: 1rem;
        }

        .continuity-page .dt-subtitle {
            font-size: .94rem;
        }
    }
</style>
@endpush
