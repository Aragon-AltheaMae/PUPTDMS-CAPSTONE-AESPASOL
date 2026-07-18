@extends('layouts.app')

@section('layout-role', 'admin')
@section('title', 'Dentist Continuity Management')

@section('content')
<main id="mainContent" class="admin-page-shell page-enter mode-list continuity-page">
    <div class="w-full dt-wrap">
        @include('admin.dentist-transitions._hero', [
            'title' => 'Dentist Continuity Management',
            'actions' => '<a href="' . route('admin.dentist-transitions.create') . '" class="dt-btn dt-btn-light">Create Transition</a>',
        ])

        @if (session('success'))
        <div class="dt-alert dt-alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
        <div class="dt-alert dt-alert-error">{{ session('error') }}</div>
        @endif

        <div class="dt-panel">
            <div class="dt-section-head">
                <div>
                    <h2>Transition Directory</h2>
                    <p>Review every planned handover, check successor coverage, and monitor transition progress before access is deactivated.</p>
                </div>
            </div>

            <form method="GET" class="dt-filter-grid">
                <label class="dt-field">
                    <span class="dt-label">Dentist</span>
                    <input class="dt-input" type="text" name="dentist" placeholder="Search dentist" value="{{ $filters['dentist'] ?? '' }}">
                </label>

                <label class="dt-field">
                    <span class="dt-label">Successor</span>
                    <input class="dt-input" type="text" name="successor" placeholder="Search successor" value="{{ $filters['successor'] ?? '' }}">
                </label>

                <label class="dt-field">
                    <span class="dt-label">Status</span>
                    <select class="dt-select" name="status">
                    <option value="">All statuses</option>
                    @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ str_replace('_', ' ', ucfirst($status)) }}</option>
                    @endforeach
                    </select>
                </label>

                <label class="dt-field">
                    <span class="dt-label">Reason</span>
                    <select class="dt-select" name="transition_type">
                    <option value="">All reasons</option>
                    @foreach ($types as $type)
                    <option value="{{ $type }}" @selected(($filters['transition_type'] ?? '') === $type)>{{ str_replace('_', ' ', ucfirst($type)) }}</option>
                    @endforeach
                    </select>
                </label>

                <label class="dt-field">
                    <span class="dt-label">Effective Date</span>
                    <input class="dt-input" type="date" name="effective_date" value="{{ $filters['effective_date'] ?? '' }}">
                </label>

                <div class="dt-field">
                    <button class="dt-btn dt-btn-primary" type="submit">Filter</button>
                </div>
            </form>
        </div>

        <div class="dt-panel dt-table-card">
            <div class="dt-section-head">
                <div>
                    <h2>All Transition Records</h2>
                    <p>Track who is leaving, who takes over, and how close each handover is to completion.</p>
                </div>
            </div>

            <div class="dt-table-wrap">
                <table class="dt-table">
                    <thead>
                        <tr>
                            <th>Dentist</th>
                            <th>Transition Type</th>
                            <th>Last Working Date</th>
                            <th>Access Expiration</th>
                            <th>Default Successor</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transitions as $transition)
                        <tr>
                            <td>
                                <div class="dt-cell-title dt-inline-value dt-inline-value-md">{{ $transition->dentist->name ?? 'Unknown dentist' }}</div>
                                <div class="dt-cell-sub dt-inline-value dt-inline-value-md">{{ $transition->dentist->email ?? 'No email' }}</div>
                            </td>
                            <td><span class="dt-inline-value dt-inline-value-sm">{{ str_replace('_', ' ', ucfirst($transition->transition_type)) }}</span></td>
                            <td><span class="dt-inline-value dt-inline-value-xs">{{ optional($transition->last_working_date)->format('M d, Y') }}</span></td>
                            <td><span class="dt-inline-value dt-inline-value-xs">{{ optional($transition->access_ends_at)->format('M d, Y') }}</span></td>
                            <td><span class="dt-inline-value dt-inline-value-sm">{{ $transition->defaultSuccessor->name ?? 'Not assigned' }}</span></td>
                            <td>
                                <div class="dt-progress">
                                    <div class="dt-progress-bar" style="width: {{ $transition->progress_percentage }}%;"></div>
                                </div>
                                <div class="dt-cell-sub">{{ $transition->progress_percentage }}% complete</div>
                            </td>
                            <td><span class="dt-badge dt-badge-{{ $transition->status }}">{{ str_replace('_', ' ', ucfirst($transition->status)) }}</span></td>
                            <td>
                                <div class="dt-actions">
                                    <a href="{{ route('admin.dentist-transitions.show', $transition) }}" class="dt-btn dt-btn-secondary dt-btn-sm">Open</a>
                                    @if (!in_array($transition->status, ['completed', 'cancelled'], true))
                                    <a href="{{ route('admin.dentist-transitions.edit', $transition) }}" class="dt-btn dt-btn-secondary dt-btn-sm">Edit</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="dt-empty">No transition records found yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="dt-pagination">
                {{ $transitions->links() }}
            </div>
        </div>
    </div>
</main>
@include('admin.dentist-transitions._styles')
@endsection
