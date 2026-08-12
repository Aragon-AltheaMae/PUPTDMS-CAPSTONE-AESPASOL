<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use App\Models\DentistTransition;
use App\Services\DentistTransitionService;
use Illuminate\Http\Request;

class DentistTransitionController extends Controller
{
    public function __construct(private readonly DentistTransitionService $service) {}

    public function index(Request $request)
    {
        $user = $request->user();

        $baseQuery = DentistTransition::query()
            ->with(['dentist.role', 'defaultSuccessor', 'items.patient', 'items.successorDentist', 'checklistItems'])
            ->where(function ($query) use ($user) {
                $query->where('dentist_id', $user->id)
                    ->orWhere('default_successor_dentist_id', $user->id);
            })
            ->latest();

        $transitions = $baseQuery->paginate(10)->withQueryString();

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'active' => (clone $baseQuery)->whereIn('status', ['draft', 'pending_review', 'handover_in_progress', 'scheduled'])->count(),
            'completed' => (clone $baseQuery)->where('status', 'completed')->count(),
        ];

        return view('dentist.dentist-transition', [
            'transitions' => $transitions,
            'stats' => $stats,
            'statuses' => DentistTransition::STATUSES,
            'types' => DentistTransition::TYPES,
            'layoutRole' => 'dentist',
        ]);
    }

    public function show(Request $request, DentistTransition $transition)
    {
        $user = $request->user();

        abort_unless(
            $transition->dentist_id === $user->id || $transition->default_successor_dentist_id === $user->id,
            403
        );

        $transition->load([
            'dentist.role',
            'defaultSuccessor',
            'initiatedBy',
            'reviewedBy',
            'approvedBy',
            'items.patient',
            'items.originalDentist',
            'items.successorDentist',
            'items.documentRequest',
            'checklistItems.completedBy',
        ]);

        $transition = $this->service->generateTransitionItems($transition);

        return view('dentist.dentist-transition', [
            'transition' => $transition,
            'summary' => $this->service->generateImpactSummary($transition),
            'layoutRole' => 'dentist',
        ]);
    }

    public function assignments(Request $request, DentistTransition $transition)
    {
        $user = $request->user();

        abort_unless(
            $transition->default_successor_dentist_id === $user->id,
            403
        );

        $request->validate([
            'items' => ['required', 'array'],
            'items.*.selected_for_transfer' => ['required', 'boolean'],
            'items.*.transfer_status' => ['nullable', 'string'],
            'items.*.remarks' => ['nullable', 'string'],
            'items.*.resolution_type' => ['nullable', 'string'],
        ]);

        $payload = $request->only(['items']);

        if ($request->has('default_successor_dentist_id')) {
            $payload['default_successor_dentist_id'] = $request->input('default_successor_dentist_id');
        }

        $this->service->updateSuccessorAssignments($transition, $payload, $user);

        return back()->with('success', 'Assignments updated successfully.');
    }

    public function checklist(Request $request, DentistTransition $transition)
    {
        $user = $request->user();

        abort_unless(
            $transition->default_successor_dentist_id === $user->id || $transition->dentist_id === $user->id,
            403
        );

        $request->validate([
            'checklist' => ['required', 'array'],
            'checklist.*.remarks' => ['nullable', 'string'],
        ]);

        $this->service->updateChecklist($transition, $request->only('checklist'), $user);

        return back()->with('success', 'Checklist updated successfully.');
    }
}
