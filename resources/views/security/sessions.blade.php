@extends('layouts.app')

@section('title', 'Account Sessions')
@section('layout-role', $role)
@section('body-class', 'bg-[#F4F4F4]')

@section('styles')
    <style>
        .session-page {
            margin-left: var(--sidebar-offset, 290px);
            padding: 104px 24px 48px;
        }

        .session-shell {
            max-width: 1180px;
            margin: 0 auto;
            display: grid;
            gap: 18px;
        }

        .session-hero {
            position: relative;
            overflow: hidden;
            border-radius: 30px;
            padding: 26px 32px;
            color: #fff;
            background:
                radial-gradient(circle at top right, rgba(255, 255, 255, .09), transparent 34%),
                linear-gradient(135deg, var(--crimson-dark, #6b0000) 0%, var(--crimson, #8b0000) 60%, #c0392b 100%);
            box-shadow: 0 22px 48px rgba(139, 0, 0, .14);
        }

        .session-hero::after {
            content: '';
            position: absolute;
            inset: auto -80px -100px auto;
            width: 240px;
            height: 240px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .08);
        }

        .session-hero-top {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .session-kicker {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            font-size: .76rem;
            font-weight: 800;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .8);
            margin-bottom: 0;
        }

        .session-kicker i {
            font-size: .86rem;
        }

        .session-hero h1 {
            margin: 0;
            font-size: clamp(2rem, 3vw, 3rem);
            line-height: 1.04;
            font-weight: 900;
            letter-spacing: -.03em;
        }

        .session-hero-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 40px;
            padding: 0 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(10px);
            font-size: .8rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .session-hero-pill-dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: #7bf1a8;
            box-shadow: 0 0 0 6px rgba(123, 241, 168, .12);
        }

        .session-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }

        .session-stat {
            border-radius: 20px;
            padding: 18px;
            background: #fff;
            border: 1px solid #efe1e1;
            box-shadow: 0 14px 30px rgba(15, 23, 42, .05);
        }

        .session-stat-label {
            display: block;
            font-size: .74rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #8f7b7b;
            margin-bottom: 8px;
        }

        .session-stat-value {
            display: block;
            font-size: 1.9rem;
            font-weight: 900;
            line-height: 1;
            color: #1f2937;
        }

        .session-stat-note {
            display: block;
            margin-top: 7px;
            color: #6b7280;
            font-size: .8rem;
        }

        .session-stats-wrap {
            margin-top: -2px;
        }

        .session-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.4fr) minmax(320px, .95fr);
            gap: 18px;
        }

        .session-panel {
            background: rgba(255, 255, 255, .95);
            border: 1px solid rgba(139, 0, 0, .08);
            border-radius: 24px;
            box-shadow: 0 18px 42px rgba(15, 23, 42, .07);
            overflow: hidden;
        }

        .session-panel-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 22px 24px 18px;
            border-bottom: 1px solid rgba(15, 23, 42, .08);
        }

        .session-panel-head h2 {
            margin: 0;
            font-size: 1.18rem;
            font-weight: 900;
            color: #1f2937;
            letter-spacing: -.02em;
        }

        .session-panel-head p {
            margin: 7px 0 0;
            color: #6b7280;
            font-size: .95rem;
            line-height: 1.5;
        }

        .session-btn {
            min-height: 42px;
            border: 0;
            border-radius: 14px;
            padding: 0 16px;
            font-size: .84rem;
            font-weight: 800;
            cursor: pointer;
            transition: transform .16s ease, filter .16s ease;
            white-space: nowrap;
        }

        .session-btn:hover {
            transform: translateY(-1px);
        }

        .session-btn-danger,
        .session-btn-dark,
        .session-btn-light,
        .session-btn-secondary,
        .session-btn-ghost {
            color: #fff;
            background: linear-gradient(135deg, #7a0000 0%, #980909 100%);
            box-shadow: 0 14px 24px rgba(122, 0, 0, .20);
        }

        .session-list {
            padding: 18px;
            display: grid;
            gap: 14px;
        }

        .session-panel-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .session-action-stack {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .session-card {
            border: 1px solid rgba(15, 23, 42, .08);
            border-radius: 22px;
            padding: 18px;
            background: #fff;
            box-shadow: 0 8px 20px rgba(15, 23, 42, .03);
        }

        .session-card-current {
            border-color: rgba(34, 197, 94, .34);
            background:
                linear-gradient(180deg, rgba(240, 253, 244, .84), #fff);
            box-shadow: 0 12px 28px rgba(34, 197, 94, .08);
        }

        .session-card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 14px;
        }

        .session-device-title {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .session-device-title h3 {
            margin: 0;
            font-size: 1.08rem;
            font-weight: 900;
            color: #111827;
            letter-spacing: -.02em;
        }

        .session-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 999px;
            padding: 6px 10px;
            font-size: .76rem;
            font-weight: 800;
            background: #fff1f1;
            color: #991b1b;
            border: 1px solid #f5d1d1;
        }

        .session-badge-current {
            background: #dcfce7;
            color: #166534;
            border-color: #bfe8cb;
        }

        .session-agent {
            margin-top: 12px;
            color: #6b7280;
            font-size: .9rem;
            line-height: 1.52;
            word-break: break-word;
        }

        .session-card-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
            min-width: 220px;
        }

        .session-meta {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-top: 15px;
        }

        .session-meta-item {
            background: #f8fafc;
            border: 1px solid #eff3f7;
            border-radius: 16px;
            padding: 12px 14px;
        }

        .session-meta-label {
            display: block;
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #7a8798;
            margin-bottom: 6px;
            font-weight: 800;
        }

        .session-meta-value {
            color: #111827;
            font-weight: 800;
            word-break: break-word;
            line-height: 1.4;
        }

        .session-history-wrap {
            padding: 18px;
            display: grid;
            gap: 12px;
        }

        .session-history-card {
            border-radius: 20px;
            border: 1px solid #f0e5e5;
            background: #fff;
            padding: 16px;
            box-shadow: 0 8px 18px rgba(15, 23, 42, .03);
        }

        .session-history-top {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: flex-start;
        }

        .session-history-device {
            font-size: .98rem;
            font-weight: 900;
            color: #1f2937;
            line-height: 1.3;
        }

        .session-history-time {
            color: #6b7280;
            font-size: .82rem;
            white-space: nowrap;
        }

        .session-history-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: .73rem;
            font-weight: 800;
        }

        .session-history-badge-success {
            color: #166534;
            background: #dcfce7;
        }

        .session-history-badge-warning {
            color: #9a3412;
            background: #ffedd5;
        }

        .session-history-badge-neutral {
            color: #475569;
            background: #eef2f7;
        }

        .session-history-desc {
            margin-top: 10px;
            color: #6b7280;
            font-size: .88rem;
            line-height: 1.55;
        }

        .session-history-badges {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .session-history-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 12px;
        }

        .session-history-meta .session-meta-item {
            background: #fbfcfd;
        }

        .session-empty {
            padding: 38px 24px;
            text-align: center;
            color: #6b7280;
        }

        .session-empty strong {
            display: block;
            margin-bottom: 8px;
            color: #1f2937;
            font-size: 1.04rem;
        }

        [data-theme="dark"] .session-stat,
        .dark .session-stat {
            background: #161b22;
            border-color: #2b3139;
            box-shadow: 0 18px 34px rgba(0, 0, 0, .14);
        }

        [data-theme="dark"] .session-stat-value,
        .dark .session-stat-value {
            color: #f3f4f6;
        }

        [data-theme="dark"] .session-stat-label,
        [data-theme="dark"] .session-stat-note,
        .dark .session-stat-label,
        .dark .session-stat-note {
            color: #9ca3af;
        }

        @media (max-width: 1024px) {
            .session-page {
                margin-left: 0;
                padding-top: 96px;
            }

            .session-grid {
                grid-template-columns: 1fr;
            }

            .session-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .session-hero,
            .session-panel-head {
                padding-left: 18px;
                padding-right: 18px;
            }

            .session-hero-top,
            .session-panel-head,
            .session-card-top,
            .session-history-top {
                flex-direction: column;
                align-items: stretch;
            }

            .session-stats,
            .session-meta,
            .session-history-meta {
                grid-template-columns: 1fr;
            }

            .session-btn,
            .session-panel-actions form,
            .session-card-actions,
            .session-action-stack {
                width: 100%;
            }

            .session-panel-actions {
                width: 100%;
                justify-content: stretch;
            }

            .session-card-actions {
                min-width: 0;
            }
        }
    </style>
@endsection

@section('content')
    <main class="session-page">
        <div class="session-shell">
            <section class="session-hero">
                <div class="session-hero-top">
                    <div>
                        <div class="session-kicker">
                            <i class="fa-solid fa-shield-halved"></i>
                            Account Security
                        </div>
                        <h1>Account Sessions</h1>
                    </div>

                    <div class="session-hero-pill">
                        <span class="session-hero-pill-dot"></span>
                        Security Activity Visible
                    </div>
                </div>
            </section>

            <div class="session-stats-wrap">
                <div class="session-stats">
                    <div class="session-stat">
                        <span class="session-stat-label">Current Device</span>
                        <span class="session-stat-value">{{ $currentSessionCount }}</span>
                        <span class="session-stat-note">The browser you are using right now</span>
                    </div>

                    <div class="session-stat">
                        <span class="session-stat-label">Other Active Sessions</span>
                        <span class="session-stat-value">{{ $otherSessionsCount }}</span>
                        <span class="session-stat-note">Other browsers still signed in</span>
                    </div>

                    <div class="session-stat">
                        <span class="session-stat-label">Role Session Limit</span>
                        <span class="session-stat-value">{{ $sessionLimit }}</span>
                        <span class="session-stat-note">Maximum active sessions for your role</span>
                    </div>

                    <div class="session-stat">
                        <span class="session-stat-label">Recent History</span>
                        <span class="session-stat-value">{{ $history->count() }}</span>
                        <span class="session-stat-note">Recent sign-in and logout activity</span>
                    </div>
                </div>
            </div>

            <div class="session-grid">
                <section class="session-panel">
                    <div class="session-panel-head">
                        <div>
                            <h2>Signed-in Devices</h2>
                            <p>These are your currently active sessions. Multiple tabs in the same browser still count as one shared session.</p>
                        </div>

                        <div class="session-panel-actions">
                            <div class="session-action-stack">
                                @if ($otherSessionsCount > 0)
                                    <form method="POST" action="{{ route('security.sessions.destroy-others') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="session-btn session-btn-ghost">Log Out Other Devices</button>
                                    </form>
                                @endif

                                @if ($sessions->isNotEmpty())
                                    <form method="POST" action="{{ route('security.sessions.destroy-all') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="session-btn session-btn-danger">Log Out All Devices</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($sessions->isEmpty())
                        <div class="session-empty">
                            <strong>No Active Sessions Found</strong>
                            Your account does not have any currently active sessions to display.
                        </div>
                    @else
                        <div class="session-list">
                            @foreach ($sessions as $session)
                                <article class="session-card {{ $session['is_current'] ? 'session-card-current' : '' }}">
                                    <div class="session-card-top">
                                        <div>
                                            <div class="session-device-title">
                                                <h3>{{ $session['device_label'] }}</h3>

                                                @if ($session['is_current'])
                                                    <span class="session-badge session-badge-current">This Device</span>
                                                @else
                                                    <span class="session-badge">Other Active Session</span>
                                                @endif
                                            </div>

                                            <div class="session-agent">{{ $session['user_agent'] }}</div>
                                        </div>

                                        <div class="session-card-actions">
                                            @unless ($session['is_current'])
                                                <form method="POST" action="{{ route('security.sessions.destroy', $session['reference']) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="session-btn session-btn-light">Log Out This Device</button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('security.sessions.destroy-current') }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="session-btn session-btn-secondary">Log Out This Session</button>
                                                </form>
                                            @endunless
                                        </div>
                                    </div>

                                    <div class="session-meta">
                                        <div class="session-meta-item">
                                            <span class="session-meta-label">Browser</span>
                                            <span class="session-meta-value">{{ $session['browser_label'] }}</span>
                                        </div>

                                        <div class="session-meta-item">
                                            <span class="session-meta-label">IP Address</span>
                                            <span class="session-meta-value">{{ $session['ip_address'] }}</span>
                                        </div>

                                        <div class="session-meta-item">
                                            <span class="session-meta-label">Last Activity</span>
                                            <span class="session-meta-value">{{ $session['last_activity_label'] }}</span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </section>

                <section class="session-panel">
                    <div class="session-panel-head">
                        <div>
                            <h2>Recent Browser History</h2>
                            <p>This section shows your recent sign-in and session-related activity, including browsers used in the past.</p>
                        </div>
                    </div>

                    @if ($history->isEmpty())
                        <div class="session-empty">
                            <strong>No Recent History Yet</strong>
                            Once your account records sign-ins or session events, your recent browser history will appear here.
                        </div>
                    @else
                        <div class="session-history-wrap">
                            @foreach ($history as $entry)
                                <article class="session-history-card">
                                    <div class="session-history-top">
                                        <div>
                                            <div class="session-history-device">{{ $entry['device_label'] }}</div>
                                            <div class="session-history-badges">
                                                <span class="session-history-badge session-history-badge-{{ $entry['action_tone'] }}">
                                                    {{ $entry['action_label'] }}
                                                </span>
                                                <span class="session-history-badge session-history-badge-neutral">
                                                    {{ $entry['browser_label'] }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="session-history-time">{{ $entry['occurred_at_label'] }}</div>
                                    </div>

                                    <div class="session-history-desc">{{ $entry['description'] }}</div>

                                    <div class="session-history-meta">
                                        <div class="session-meta-item">
                                            <span class="session-meta-label">Browser</span>
                                            <span class="session-meta-value">{{ $entry['browser_label'] }}</span>
                                        </div>

                                        <div class="session-meta-item">
                                            <span class="session-meta-label">IP Address</span>
                                            <span class="session-meta-value">{{ $entry['ip_address'] }}</span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </main>
@endsection
