<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Helpers\AuditLogger;
use Illuminate\Support\Facades\Auth;
use App\Notifications\DocumentRequestSubmittedNotification;
use App\Notifications\DocumentRequestApprovedNotification;
use App\Notifications\DocumentRequestRejectedNotification;

class DocumentRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string|max:100',
            'purpose' => 'required|string|max:150',
        ]);

        $user = Auth::user();
        $patient = Patient::where('user_id', Auth::id())->first();

        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient record not found. Please log in again.',
            ], 401);
        }

        if ($user && $user->email && $patient->email !== $user->email) {
            $patient->forceFill(['email' => $user->email])->save();
        }

        session(['patient_id' => $patient->id]);

        try {
            $documentRequest = DB::transaction(function () use ($request, $patient) {
                $nextId = (DocumentRequest::max('id') ?? 0) + 1;

                return DocumentRequest::create([
                    'patient_id' => $patient->id,
                    'reference_number' => 'DOC-' . now()->format('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT),
                    'document_type' => $request->document_type,
                    'purpose' => $request->purpose,
                    'request_date' => Carbon::now()->toDateString(),
                    'request_time' => Carbon::now()->toTimeString(),
                    'status' => 'pending',
                ]);
            });

            $recipients = User::whereHas('role', function ($query) {
                $query->whereIn('slug', ['dentist', 'admin']);
            })->get()->unique('id');

            foreach ($recipients as $recipient) {
                $recipient->notify(new DocumentRequestSubmittedNotification($documentRequest));
            }

            if ($patient) {
                AuditLogger::log(
                    'create',
                    'document_request',
                    'Patient submitted document request'
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Document request submitted successfully.',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit request: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        $requests = DocumentRequest::where('patient_id', session('patient_id'))
            ->orderByDesc('created_at')
            ->get();

        return view('document-requests.index', compact('requests'));
    }

    public function dentistIndex(Request $request)
    {
        $activeRole =
            session('impersonated_role')
            ?: session('role')
            ?: optional(optional(Auth::user())->role)->slug;

        abort_unless(
            $activeRole === 'dentist',
            403
        );

        $search = trim(
            (string) $request->get('search', '')
        );

        $status = $this->normalizeDocumentRequestStatusFilter(
            $request->get('status', '')
        );

        $type = trim(
            (string) $request->get('type', '')
        );

        $dateFrom = trim(
            (string) $request->get('date_from', '')
        );

        $dateTo = trim(
            (string) $request->get('date_to', '')
        );

        $sort = trim(
            (string) $request->get('sort', 'newest')
        );

        $perPageInput = (int) $request->input(
            'per_page',
            10
        );

        $perPage = in_array(
            $perPageInput,
            [10, 20, 50, 100],
            true
        )
            ? $perPageInput
            : 10;

        $query = $this->buildDocumentRequestQuery(
            $request
        );

        $requests = $query
            ->paginate($perPage)
            ->withQueryString();

        $stats = $this->getDocumentRequestStats();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,

                'requests' => $requests
                    ->getCollection()
                    ->map(
                        fn($item) =>
                        $this->formatDocumentRequestPayload(
                            $item
                        )
                    )
                    ->values(),

                'pagination' => [
                    'total' =>
                    $requests->total(),

                    'from' =>
                    $requests->firstItem() ?? 0,

                    'to' =>
                    $requests->lastItem() ?? 0,

                    'current_page' =>
                    $requests->currentPage(),

                    'last_page' =>
                    $requests->lastPage(),

                    'per_page' =>
                    $requests->perPage(),
                ],

                'stats' => $stats,

                'types' => DocumentRequest::query()
                    ->whereNotNull('document_type')
                    ->pluck('document_type')
                    ->filter()
                    ->unique()
                    ->sort()
                    ->values(),
            ]);
        }

        $user = Auth::user();

        $notifications = $user
            ? $user->notifications()
            ->latest()
            ->take(10)
            ->get()
            : collect();

        return view(
            'shared.document-requests',
            [
                'role' => 'dentist',

                'requests' => $requests,
                'stats' => $stats,
                'notifications' => $notifications,

                'search' => $search,
                'status' => $status,
                'type' => $type,
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
                'sort' => $sort,
                'perPage' => $perPage,

                'routes' => [
                    'index' => route(
                        'dentist.dentist.documentrequests'
                    ),

                    'data' => null,

                    'approve' => url('/dentist/document-requests/__ID__/approve'),
                    'reject' => url('/dentist/document-requests/__ID__/reject'),

                    'export' => null,
                    'print_queue' => null,
                ],

                'methods' => [
                    'approve' => 'POST',
                    'reject' => 'POST',
                ],

                'permissions' => [
                    'can_approve' => true,
                    'can_reject' => true,
                    'can_export' => false,
                    'can_print' => false,
                ],
            ]
        );
    }

    public function dentistData(Request $request)
    {
        $activeRole =
            session('impersonated_role')
            ?: session('role')
            ?: optional(optional(Auth::user())->role)->slug;

        abort_unless(
            $activeRole === 'dentist',
            403
        );

        $requests = $this
            ->buildDocumentRequestQuery($request)
            ->get()
            ->map(
                fn($item) =>
                $this->formatDocumentRequestPayload(
                    $item
                )
            )
            ->values();

        return response()->json([
            'success' => true,

            'requests' => $requests,

            'stats' =>
            $this->getDocumentRequestStats(),

            'types' => DocumentRequest::query()
                ->whereNotNull('document_type')
                ->where('document_type', '!=', '')
                ->pluck('document_type')
                ->filter()
                ->unique()
                ->sort()
                ->values(),
        ]);
    }

    public function approve(Request $request, $id)
    {
        $activeRole = session('impersonated_role') ?: session('role');

        if ($activeRole !== 'dentist') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $docRequest = DocumentRequest::with('patient.user')->findOrFail($id);

        $docRequest->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
            'rejection_reason' => null,
        ]);

        if ($docRequest->patient && $docRequest->patient->user) {
            $docRequest->patient->user->notify(
                new DocumentRequestApprovedNotification($docRequest)
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Document request approved.'
        ]);
    }

    public function reject(Request $request, $id)
    {
        $activeRole = session('impersonated_role') ?: session('role');

        if ($activeRole !== 'dentist') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'reason' => 'nullable|string|max:255',
        ]);

        $docRequest = DocumentRequest::with('patient.user')->findOrFail($id);

        $docRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason,
            'approved_at' => null,
            'approved_by' => null,
        ]);

        if ($docRequest->patient && $docRequest->patient->user) {
            $docRequest->patient->user->notify(
                new DocumentRequestRejectedNotification($docRequest)
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Document request rejected.'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,ready,released',
        ]);

        $docRequest = DocumentRequest::findOrFail($id);

        $updates = [
            'status' => $request->status,
        ];

        if ($request->status === 'approved') {
            $updates['approved_at'] = now();
            $updates['approved_by'] = Auth::id();
            $updates['rejection_reason'] = null;
        }

        if ($request->status === 'rejected') {
            $updates['approved_at'] = null;
            $updates['approved_by'] = null;
        }

        $docRequest->update($updates);

        return back()->with('success', 'Request updated.');
    }
    private const LEGACY_APPROVED_STATUSES = [
        'approved',
        'ready',
        'ready-for-pickup',
        'ready-for-release',
        'released',
    ];

    private function buildDocumentRequestQuery(Request $request)
    {
        $search = trim((string) $request->get('search', ''));
        $status = $this->normalizeDocumentRequestStatusFilter(
            $request->get('status', '')
        );
        $type = trim((string) $request->get('type', ''));
        $dateFrom = trim((string) $request->get('date_from', ''));
        $dateTo = trim((string) $request->get('date_to', ''));
        $sort = trim((string) $request->get('sort', 'newest'));

        $query = DocumentRequest::with('patient');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('reference_number', 'like', "%{$search}%")
                    ->orWhere('document_type', 'like', "%{$search}%")
                    ->orWhere('purpose', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('patient', function ($patientQuery) use ($search) {
                        $patientQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('student_no', 'like', "%{$search}%")
                            ->orWhere('faculty_code', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($status !== '' && $status !== 'all') {
            if ($status === 'approved') {
                $query->whereIn(
                    DB::raw('LOWER(status)'),
                    self::LEGACY_APPROVED_STATUSES
                );
            } else {
                $query->whereRaw('LOWER(status) = ?', [$status]);
            }
        }

        if ($type !== '') {
            $query->whereRaw(
                'LOWER(document_type) = ?',
                [strtolower($type)]
            );
        }

        if ($dateFrom !== '') {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo !== '') {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        switch (strtolower($sort)) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;

            case 'az':
            case 'alpha':
                $query
                    ->leftJoin(
                        'patients',
                        'document_requests.patient_id',
                        '=',
                        'patients.id'
                    )
                    ->orderBy('patients.name', 'asc')
                    ->select('document_requests.*');
                break;

            case 'za':
                $query
                    ->leftJoin(
                        'patients',
                        'document_requests.patient_id',
                        '=',
                        'patients.id'
                    )
                    ->orderBy('patients.name', 'desc')
                    ->select('document_requests.*');
                break;

            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query;
    }

    private function getDocumentRequestStats(): array
    {
        $counts = DocumentRequest::query()
            ->selectRaw('LOWER(status) as status_key, COUNT(*) as total')
            ->groupBy('status_key')
            ->pluck('total', 'status_key')
            ->toArray();

        return [
            'total' => DocumentRequest::count(),
            'all' => DocumentRequest::count(),
            'pending' => (int) ($counts['pending'] ?? 0),

            'approved' => (int) (
                ($counts['approved'] ?? 0)
                + ($counts['ready'] ?? 0)
                + ($counts['ready-for-pickup'] ?? 0)
                + ($counts['ready-for-release'] ?? 0)
                + ($counts['released'] ?? 0)
            ),

            'rejected' => (int) ($counts['rejected'] ?? 0),
        ];
    }

    private function formatDocumentRequestPayload(
        DocumentRequest $documentRequest
    ): array {
        $documentRequest->loadMissing('patient');

        $patient = $documentRequest->patient;
        $createdAt = $documentRequest->created_at;

        $patientIdentifier =
            optional($patient)->student_no
            ?? optional($patient)->student_number
            ?? optional($patient)->student_id
            ?? optional($patient)->faculty_code
            ?? optional($patient)->employee_no
            ?? optional($patient)->id
            ?? 'No ID set';

        return [
            'id' => $documentRequest->id,

            'reference_number' =>
            $documentRequest->reference_number
                ?? (
                    'DR-' .
                    str_pad(
                        (string) $documentRequest->id,
                        5,
                        '0',
                        STR_PAD_LEFT
                    )
                ),

            'patient_name' =>
            optional($patient)->name
                ?? optional($patient)->full_name
                ?? 'Unknown Patient',

            'patient_identifier' => $patientIdentifier,
            'patient_id' => $patientIdentifier,
            'sub_label' => $patientIdentifier,

            'document_type' => $this->formatDocumentRequestType(
                $documentRequest->document_type
                    ?? 'Document'
            ),

            'document_type_raw' =>
            $documentRequest->document_type
                ?? 'Document',

            'purpose' =>
            $documentRequest->purpose ?: '—',

            'status' => $this->normalizeDocumentRequestStatus(
                $documentRequest->status
            ),

            'request_date' =>
            optional($createdAt)?->format('M d, Y')
                ?? '—',

            'request_time' =>
            optional($createdAt)?->format('h:i A')
                ?? '',

            'request_sort_date' =>
            optional($createdAt)?->format('Y-m-d H:i:s')
                ?? '',

            'filter_date' =>
            optional($createdAt)?->format('Y-m-d')
                ?? '',

            'copies_needed' =>
            $documentRequest->copies_needed ?? 1,

            'rejection_reason' =>
            $documentRequest->rejection_reason,

            'patient_photo_url' =>
            optional($patient)->profile_photo_url
                ?? optional($patient)->profile_picture_url
                ?? optional($patient)->avatar_url
                ?? optional($patient)->photo_url
                ?? '',
        ];
    }

    private function normalizeDocumentRequestStatus($status): string
    {
        $status = strtolower(
            str_replace(
                '_',
                '-',
                (string) ($status ?: 'pending')
            )
        );

        if (
            in_array(
                $status,
                self::LEGACY_APPROVED_STATUSES,
                true
            )
        ) {
            return 'approved';
        }

        if ($status === 'rejected') {
            return 'rejected';
        }

        return 'pending';
    }

    private function normalizeDocumentRequestStatusFilter($status): string
    {
        $status = strtolower(
            str_replace(
                '_',
                '-',
                trim((string) $status)
            )
        );

        if ($status === '' || $status === 'all') {
            return '';
        }

        if (
            in_array(
                $status,
                [
                    'ready',
                    'ready-for-pickup',
                    'ready-for-release',
                    'released',
                ],
                true
            )
        ) {
            return 'approved';
        }

        return in_array(
            $status,
            ['pending', 'approved', 'rejected'],
            true
        )
            ? $status
            : '';
    }

    private function formatDocumentRequestType($type): string
    {
        return ucwords(
            str_replace(
                ['_', '-'],
                ' ',
                (string) ($type ?: 'Document')
            )
        );
    }
}
