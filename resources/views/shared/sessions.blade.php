@extends('layouts.app')

@section('title', 'Account Sessions')
@section('layout-role', $role)
@section('body-class', 'bg-[#F4F4F4]')

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
                        <span class="session-stat-label global-info-label">Current Device</span>
                        <span class="session-stat-value global-info-value">{{ $currentSessionCount }}</span>
                        <span class="session-stat-note">The browser you are using right now</span>
                    </div>

                    <div class="session-stat">
                        <span class="session-stat-label global-info-label">Other Active Sessions</span>
                        <span class="session-stat-value global-info-value">{{ $otherSessionsCount }}</span>
                        <span class="session-stat-note">Other browsers still signed in</span>
                    </div>

                    <div class="session-stat">
                        <span class="session-stat-label global-info-label">Role Session Limit</span>
                        <span class="session-stat-value global-info-value">{{ $sessionLimit }}</span>
                        <span class="session-stat-note">Maximum active sessions for your role</span>
                    </div>

                    <div class="session-stat">
                        <span class="session-stat-label global-info-label">Recent History</span>
                        <span class="session-stat-value global-info-value">{{ $history->count() }}</span>
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
                                        <button type="submit" class="session-btn ui-btn session-btn-ghost">Log Out Other Devices</button>
                                    </form>
                                @endif

                                @if ($sessions->isNotEmpty())
                                    <form method="POST" action="{{ route('security.sessions.destroy-all') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="session-btn ui-btn session-btn-danger">Log Out All Devices</button>
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
                                                    <span class="session-badge status-pill session-badge-current">This Device</span>
                                                @else
                                                    <span class="session-badge status-pill">Other Active Session</span>
                                                @endif
                                            </div>

                                            <div class="session-agent">{{ $session['user_agent'] }}</div>
                                        </div>

                                        <div class="session-card-actions">
                                            @unless ($session['is_current'])
                                                <form method="POST" action="{{ route('security.sessions.destroy', $session['reference']) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="session-btn ui-btn session-btn-light">Log Out This Device</button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('security.sessions.destroy-current') }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="session-btn ui-btn session-btn-secondary">Log Out This Session</button>
                                                </form>
                                            @endunless
                                        </div>
                                    </div>

                                    <div class="session-meta">
                                        <div class="session-meta-item">
                                            <span class="session-meta-label global-info-label">Browser</span>
                                            <span class="session-meta-value global-info-value">{{ $session['browser_label'] }}</span>
                                        </div>

                                        <div class="session-meta-item">
                                            <span class="session-meta-label global-info-label">IP Address</span>
                                            <span class="session-meta-value global-info-value">{{ $session['ip_address'] }}</span>
                                        </div>

                                        <div class="session-meta-item">
                                            <span class="session-meta-label global-info-label">Last Activity</span>
                                            <span class="session-meta-value global-info-value">{{ $session['last_activity_label'] }}</span>
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
                                                <span class="session-history-badge status-pill session-history-badge-{{ $entry['action_tone'] }}">
                                                    {{ $entry['action_label'] }}
                                                </span>
                                                <span class="session-history-badge status-pill session-history-badge-neutral">
                                                    {{ $entry['browser_label'] }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="session-history-time">{{ $entry['occurred_at_label'] }}</div>
                                    </div>

                                    <div class="session-history-desc">{{ $entry['description'] }}</div>

                                    <div class="session-history-meta">
                                        <div class="session-meta-item">
                                            <span class="session-meta-label global-info-label">Browser</span>
                                            <span class="session-meta-value global-info-value">{{ $entry['browser_label'] }}</span>
                                        </div>

                                        <div class="session-meta-item">
                                            <span class="session-meta-label global-info-label">IP Address</span>
                                            <span class="session-meta-value global-info-value">{{ $entry['ip_address'] }}</span>
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