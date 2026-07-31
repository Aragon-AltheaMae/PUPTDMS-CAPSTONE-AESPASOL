<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignDentistSuccessorsRequest;
use App\Http\Requests\CancelDentistTransitionRequest;
use App\Http\Requests\FinalizeDentistTransitionRequest;
use App\Http\Requests\StoreDentistTransitionRequest;
use App\Http\Requests\UpdateDentistTransitionRequest;
use App\Models\DentistTransition;
use App\Models\User;
use App\Services\DentistTransitionService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DentistTransitionController extends Controller
{
    public function __construct(private readonly DentistTransitionService $service)
    {
    }

    public function index(Request $request)
    {
        $this->authorizeAction('view_dentist_transitions');

        $query = DentistTransition::query()
            ->with(['dentist.role', 'defaultSuccessor', 'checklistItems'])
            ->latest();

        if ($status = trim((string) $request->get('status', ''))) {
            $query->where('status', $status);
        }

        if ($type = trim((string) $request->get('transition_type', ''))) {
            $query->where('transition_type', $type);
        }

        if ($dentist = trim((string) $request->get('dentist', ''))) {
            $query->whereHas('dentist', function ($builder) use ($dentist) {
                $builder->where('name', 'like', '%' . $dentist . '%');
            });
        }

        if ($successor = trim((string) $request->get('successor', ''))) {
            $query->whereHas('defaultSuccessor', function ($builder) use ($successor) {
                $builder->where('name', 'like', '%' . $successor . '%');
            });
        }

        if ($effectiveDate = trim((string) $request->get('effective_date', ''))) {
            $query->whereDate('access_ends_at', $effectiveDate);
        }

        $transitions = $query->paginate(10)->withQueryString();

        return view('admin.dentist-transitions.index', [
            'transitions' => $transitions,
            'statuses' => DentistTransition::STATUSES,
            'types' => DentistTransition::TYPES,
            'filters' => $request->only(['status', 'transition_type', 'dentist', 'successor', 'effective_date']),
        ]);
    }

    public function create()
    {
        $this->authorizeAction('create_dentist_transitions');

        return view('dentist.dentist-continuity', [
            'transition' => new DentistTransition(),
            'dentists' => $this->activeDentists(),
            'types' => DentistTransition::TYPES,
            'formAction' => route('admin.dentist-transitions.store'),
            'formMethod' => 'POST',
        ]);
    }

    public function store(StoreDentistTransitionRequest $request)
    {
        $this->authorizeAction('create_dentist_transitions');

        $transition = $this->service->createTransition($request->validated(), $request->user());

        return redirect()
            ->route('admin.dentist-transitions.show', $transition)
            ->with('success', 'Dentist transition created successfully.');
    }

    public function show(DentistTransition $transition)
    {
        $this->authorizeAction('view_dentist_transitions');

        $transition->load([
            'dentist.role',
            'defaultSuccessor',
            'initiatedBy',
            'reviewedBy',
            'approvedBy',
            'items.patient',
            'items.originalDentist',
            'items.successorDentist',
            'checklistItems.completedBy',
        ]);

        $transition = $this->service->generateTransitionItems($transition);

        return view('admin.dentist-transitions.show', [
            'transition' => $transition,
            'summary' => $this->service->generateImpactSummary($transition),
            'dentists' => $this->activeDentists($transition->dentist_id),
            'readiness' => $this->service->validateTransitionReadiness($transition),
        ]);
    }

    public function edit(DentistTransition $transition)
    {
        $this->authorizeAction('update_dentist_transitions');

        return view('dentist.dentist-continuity', [
            'transition' => $transition,
            'dentists' => $this->activeDentists($transition->dentist_id),
            'types' => DentistTransition::TYPES,
            'formAction' => route('admin.dentist-transitions.update', $transition),
            'formMethod' => 'PUT',
        ]);
    }

    public function update(UpdateDentistTransitionRequest $request, DentistTransition $transition)
    {
        $this->authorizeAction('update_dentist_transitions');

        if (in_array($transition->status, ['scheduled', 'completed', 'cancelled'], true)) {
            return back()->with('error', 'This transition can no longer be edited.');
        }

        $transition = $this->service->updateTransition($transition, $request->validated(), $request->user());

        return redirect()
            ->route('admin.dentist-transitions.show', $transition)
            ->with('success', 'Transition details updated successfully.');
    }

    public function generateItems(DentistTransition $transition)
    {
        $this->authorizeAction('update_dentist_transitions');

        $this->service->generateTransitionItems($transition);

        return back()->with('success', 'Impact summary refreshed successfully.');
    }

    public function assignments(AssignDentistSuccessorsRequest $request, DentistTransition $transition)
    {
        $this->authorizeAction('assign_dentist_successors');

        $this->service->updateSuccessorAssignments($transition, $request->validated(), $request->user());

        return back()->with('success', 'Successor assignments updated successfully.');
    }

    public function checklist(Request $request, DentistTransition $transition)
    {
        $this->authorizeAction('update_dentist_transitions');

        $request->validate([
            'checklist' => ['required', 'array'],
            'checklist.*.remarks' => ['nullable', 'string'],
        ]);

        $this->service->updateChecklist($transition, $request->only('checklist'), $request->user());

        return back()->with('success', 'Handover checklist updated successfully.');
    }

    public function finalize(FinalizeDentistTransitionRequest $request, DentistTransition $transition)
    {
        $this->authorizeAction('finalize_dentist_transitions');

        try {
            $this->service->finalizeTransition($transition, $request->user());
        } catch (\RuntimeException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return back()->with('success', 'Transition finalized successfully.');
    }

    public function cancel(CancelDentistTransitionRequest $request, DentistTransition $transition)
    {
        $this->authorizeAction('cancel_dentist_transitions');

        $this->service->cancelTransition($transition, $request->validated()['cancellation_reason'], $request->user());

        return back()->with('success', 'Transition cancelled successfully.');
    }

    public function extendAccess(Request $request, DentistTransition $transition)
    {
        $this->authorizeAction('extend_dentist_access');

        $validated = $request->validate([
            'access_ends_at' => ['required', 'date', 'after:now'],
        ]);

        $this->service->extendAccess($transition, Carbon::parse($validated['access_ends_at']), $request->user());

        return back()->with('success', 'Dentist access extended successfully.');
    }

    private function activeDentists(?int $includeDentistId = null)
    {
        return User::query()
            ->with('role')
            ->whereHas('role', function ($query) {
                $query->where('slug', 'dentist');
            })
            ->where(function ($query) use ($includeDentistId) {
                $query->where('status', 'active');

                if ($includeDentistId) {
                    $query->orWhere('id', $includeDentistId);
                }
            })
            ->orderBy('name')
            ->get();
    }

    private function authorizeAction(string $permission): void
    {
        $user = request()->user();

        abort_unless($user, 403);
        abort_unless($user->hasAnyRole(['admin', 'super_admin']), 403);

        $allowed = $user->hasPermission($permission) || $user->hasPermission('manage_dentist_accounts');

        abort_unless($allowed, 403, 'Unauthorized.');
    }
}
