@extends('layouts.app')

@section('layout-role', 'admin')
@section('title', 'Dentist Transition Details')

@section('content')
<main id="mainContent" class="admin-page-shell page-enter mode-list continuity-page">
    <div class="w-full dt-wrap">
        @include('admin.dentist-transitions._hero', [
            'kicker' => 'Dentist Continuity Management',
            'title' => $transition->dentist->name ?? 'Unknown dentist',
            'subtitle' => str_replace('_', ' ', ucfirst($transition->transition_type)) . ' transition. Last working date: ' . optional($transition->last_working_date)->format('M d, Y') . '. Access ends: ' . optional($transition->access_ends_at)->format('M d, Y h:i A') . '.',
            'actions' => '<span class="dt-badge dt-badge-' . e($transition->status) . '">' . e(str_replace('_', ' ', ucfirst($transition->status))) . '</span><a href="' . route('admin.dentist-transitions.edit', $transition) . '" class="dt-btn dt-btn-light">Edit Transition</a>',
        ])

        @if (session('success'))
        <div class="dt-alert dt-alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
        <div class="dt-alert dt-alert-error">{{ session('error') }}</div>
        @endif

        <div class="dt-summary-grid">
            <div class="dt-summary-card">
                <span class="dt-summary-label">Future Appointments</span>
                <strong>{{ $summary['future_appointments'] }}</strong>
                <span>Appointments currently under the departing dentist.</span>
            </div>
            <div class="dt-summary-card">
                <span class="dt-summary-label">Ready To Transfer</span>
                <strong>{{ $summary['ready_to_transfer'] }}</strong>
                <span>Items with valid successor coverage.</span>
            </div>
            <div class="dt-summary-card">
                <span class="dt-summary-label">Transferred</span>
                <strong>{{ $summary['transferred_items'] }}</strong>
                <span>Records already completed by the handover process.</span>
            </div>
            <div class="dt-summary-card">
                <span class="dt-summary-label">Critical Unresolved</span>
                <strong>{{ $summary['critical_unresolved_items'] }}</strong>
                <span>Items still blocking finalization.</span>
            </div>
        </div>

        <div class="dt-page-grid">
            <section class="dt-panel">
                <div class="dt-section-head">
                    <div>
                        <h2>Transition Information</h2>
                        <p>Baseline departure details and successor coverage.</p>
                    </div>
                    <form action="{{ route('admin.dentist-transitions.generate-items', $transition) }}" method="POST">
                        @csrf
                        <button type="submit" class="dt-btn dt-btn-primary dt-btn-sm dt-btn-impact">Refresh Impact Summary</button>
                    </form>
                </div>

                <dl class="dt-info-grid">
                    <div><dt>Departing Dentist</dt><dd>{{ $transition->dentist->name ?? 'Unknown dentist' }}</dd></div>
                    <div><dt>Default Successor</dt><dd>{{ $transition->defaultSuccessor->name ?? 'Not assigned yet' }}</dd></div>
                    <div><dt>Initiated By</dt><dd>{{ $transition->initiatedBy->name ?? 'Unknown admin' }}</dd></div>
                    <div><dt>Reviewed By</dt><dd>{{ $transition->reviewedBy->name ?? 'Pending review' }}</dd></div>
                    <div><dt>Approved By</dt><dd>{{ $transition->approvedBy->name ?? 'Not finalized' }}</dd></div>
                    <div><dt>Progress</dt><dd>{{ $transition->progress_percentage }}% checklist completion</dd></div>
                </dl>

                @if ($transition->handover_notes)
                <div class="dt-note-block">
                    <h3>Handover Notes</h3>
                    <p>{{ $transition->handover_notes }}</p>
                </div>
                @endif

                @if ($transition->remarks)
                <div class="dt-note-block">
                    <h3>Admin Remarks</h3>
                    <p>{{ $transition->remarks }}</p>
                </div>
                @endif
            </section>

            <section class="dt-panel">
                <div class="dt-section-head">
                    <div>
                        <h2>Readiness Checks</h2>
                        <p>Server-side blockers checked before finalization.</p>
                    </div>
                </div>

                @if ($readiness['ready'])
                <div class="dt-ready-pill success">
                    <span class="dt-ready-pill-icon"><i class="fa-solid fa-circle-check"></i></span>
                    <span>Ready for finalization once you confirm the handover.</span>
                </div>
                @else
                <div class="dt-ready-pill warning">
                    <span class="dt-ready-pill-icon"><i class="fa-solid fa-triangle-exclamation"></i></span>
                    <span>This transition still has blockers that must be resolved first.</span>
                </div>
                @endif

                <div class="dt-ready-columns">
                    <div class="dt-ready-box">
                        <h3><i class="fa-solid fa-list-check"></i> Incomplete Checklist Items</h3>
                        <ul>
                            @forelse ($readiness['missing_checklist'] as $label)
                            <li>{{ $label }}</li>
                            @empty
                            <li>None</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="dt-ready-box">
                        <h3><i class="fa-solid fa-file-circle-exclamation"></i> Unresolved Critical Records</h3>
                        <ul>
                            @forelse ($readiness['unresolved_critical_items'] as $item)
                            <li>{{ $item->reference_label }} for {{ $item->patient->name ?? 'Unknown patient' }}</li>
                            @empty
                            <li>None</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </section>
        </div>

        <section class="dt-panel">
            <div class="dt-section-head">
                <div>
                    <h2>Active Responsibility Table</h2>
                    <p>Assign a default successor or override per eligible record before finalization.</p>
                </div>
            </div>

            <form action="{{ route('admin.dentist-transitions.assignments', $transition) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="dt-assign-toolbar">
                    <div class="dt-assign-field">
                        <label class="dt-label" for="default_successor_dentist_id">Default successor</label>
                        <select id="default_successor_dentist_id" name="default_successor_dentist_id" class="dt-select">
                            <option value="">Leave unchanged</option>
                            @foreach ($dentists as $dentist)
                            @continue($dentist->id === $transition->dentist_id)
                            <option value="{{ $dentist->id }}" @selected($transition->default_successor_dentist_id == $dentist->id)>
                                {{ $dentist->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="dt-btn dt-btn-primary">Save Assignments</button>
                </div>

                <div class="dt-table-wrap">
                    <table class="dt-table dt-responsibility-table">
                        <thead>
                            <tr>
                                <th>Record Type</th>
                                <th>Reference</th>
                                <th>Patient</th>
                                <th>Current Dentist</th>
                                <th>Successor Dentist</th>
                                <th>Status</th>
                                <th>Action Taken</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transition->items as $item)
                            <tr>
                                <td><span class="dt-inline-value dt-inline-value-sm">{{ str_replace('_', ' ', ucfirst($item->item_type)) }}</span></td>
                                <td><span class="dt-inline-value dt-inline-value-xs">{{ $item->reference_label }}</span></td>
                                <td><span class="dt-inline-value dt-inline-value-sm">{{ $item->patient->name ?? 'Unknown patient' }}</span></td>
                                <td><span class="dt-inline-value dt-inline-value-sm">{{ $item->originalDentist->name ?? 'Unknown dentist' }}</span></td>
                                <td>
                                    <select class="dt-select" name="items[{{ $item->id }}][successor_dentist_id]">
                                        <option value="">Select successor</option>
                                        @foreach ($dentists as $dentist)
                                        @continue($dentist->id === $transition->dentist_id)
                                        <option value="{{ $dentist->id }}" @selected($item->successor_dentist_id == $dentist->id)>
                                            {{ $dentist->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="dt-select" name="items[{{ $item->id }}][transfer_status]">
                                        <option value="pending" @selected($item->transfer_status === 'pending')>Pending</option>
                                        <option value="ready" @selected($item->transfer_status === 'ready')>Ready</option>
                                        <option value="excluded" @selected($item->transfer_status === 'excluded')>Excluded</option>
                                        <option value="manually_resolved" @selected($item->transfer_status === 'manually_resolved')>Manually resolved</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="dt-input" type="text" name="items[{{ $item->id }}][resolution_type]"
                                        value="{{ $item->resolution_type }}">
                                </td>
                                <td>
                                    <input class="dt-input" type="text" name="items[{{ $item->id }}][remarks]"
                                        value="{{ $item->remarks }}">
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="dt-empty">No active dentist-owned responsibilities were found for transfer.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>
        </section>

        <section class="dt-panel">
            <div class="dt-section-head">
                <div>
                    <h2>Handover Checklist</h2>
                    <p>Every required checklist item must be completed before the system allows finalization.</p>
                </div>
            </div>

            <form action="{{ route('admin.dentist-transitions.checklist', $transition) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="dt-checklist-grid">
                    @foreach ($transition->checklistItems as $item)
                    <div class="dt-checklist-item">
                        <label class="dt-checkline">
                            <input type="checkbox" name="checklist[{{ $item->id }}][is_completed]" value="1" @checked($item->is_completed)>
                            <span>{{ $item->label }}</span>
                        </label>
                        <input class="dt-input" type="text" name="checklist[{{ $item->id }}][remarks]"
                            value="{{ $item->remarks }}" placeholder="Optional remarks">
                        <div class="dt-cell-sub">
                            @if ($item->is_completed)
                            Completed by {{ $item->completedBy->name ?? 'Unknown user' }} on {{ optional($item->completed_at)->format('M d, Y h:i A') }}
                            @else
                            Pending completion
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="dt-form-actions">
                    <button type="submit" class="dt-btn dt-btn-primary dt-btn-save-checklist">Save Checklist</button>
                </div>
            </form>
        </section>

        <section class="dt-panel">
            <div class="dt-section-head">
                <div>
                    <h2>Finalization Controls</h2>
                    <p>These actions affect active patient responsibilities and dentist access. Final validation still runs on the server.</p>
                </div>
            </div>

            <div class="dt-actions-grid">
                <form action="{{ route('admin.dentist-transitions.finalize', $transition) }}" method="POST" class="dt-action-card">
                    @csrf
                    <h3>Finalize Transition</h3>
                    <p>{{ $summary['ready_to_transfer'] }} records are ready to transfer. {{ $summary['critical_unresolved_items'] }} critical items remain unresolved.</p>
                    <button type="submit" class="dt-btn dt-btn-primary" @disabled(in_array($transition->status, ['completed', 'cancelled'], true))>Finalize</button>
                </form>

                <form action="{{ route('admin.dentist-transitions.extend-access', $transition) }}" method="POST" class="dt-action-card">
                    @csrf
                    <h3>Extend Access</h3>
                    <input class="dt-input" type="datetime-local" name="access_ends_at" required>
                    <button type="submit" class="dt-btn dt-btn-secondary">Extend Access</button>
                </form>

                <form action="{{ route('admin.dentist-transitions.cancel', $transition) }}" method="POST" class="dt-action-card">
                    @csrf
                    <h3>Cancel Transition</h3>
                    <textarea class="dt-textarea" name="cancellation_reason" rows="3" placeholder="Reason for cancellation" required></textarea>
                    <button type="submit" class="dt-btn dt-btn-danger" @disabled(in_array($transition->status, ['completed', 'cancelled'], true))>Cancel Transition</button>
                </form>
            </div>
        </section>
    </div>
</main>
@include('admin.dentist-transitions._styles')
@endsection
