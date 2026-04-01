<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentRequestController extends Controller
{
    private function ensureAdminAccess()
    {
        $activeRole = session('impersonated_role') ?: session('role');

        if (!session('admin_logged_in') || !in_array($activeRole, ['super_admin', 'admin'])) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function index(Request $request)
    {
        $this->ensureAdminAccess();

        $query = DocumentRequest::with('patient');

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('reference_number', 'like', "%{$search}%")
                    ->orWhereHas('patient', function ($patientQuery) use ($search) {
                        $patientQuery->where('full_name', 'like', "%{$search}%")
                            ->orWhere('student_id', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('document_type', $request->type);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $requests = $query->latest()->paginate(10);

        $stats = [
            'total' => DocumentRequest::count(),
            'pending' => DocumentRequest::where('status', 'pending')->count(),
            'approved' => DocumentRequest::where('status', 'approved')->count(),
            'ready' => DocumentRequest::where('status', 'ready')->count(),
            'released' => DocumentRequest::where('status', 'released')->count(),
            'rejected' => DocumentRequest::where('status', 'rejected')->count(),
        ];

        $documentTypes = DocumentRequest::select('document_type')
            ->distinct()
            ->orderBy('document_type')
            ->pluck('document_type');

        $notifications = collect([]);

        return view('admin.document-request', compact(
            'requests',
            'stats',
            'documentTypes',
            'notifications'
        ));

        $sort = $request->get('sort', 'newest');

        $query = DocumentRequest::with('patient');

        match ($sort) {
            'oldest' => $query->oldest(),
            'alpha'  => $query->join('patients', 'document_requests.patient_id', '=', 'patients.id')
                            ->orderBy('patients.last_name')
                            ->select('document_requests.*'),
            default  => $query->latest(),
        };
    }

    public function show(DocumentRequest $documentRequest)
    {
        $this->ensureAdminAccess();

        $documentRequest->load('patient');

        return response()->json([
            'id' => $documentRequest->id,
            'reference_number' => $documentRequest->reference_number,
            'patient_name' => $documentRequest->patient->full_name ?? 'Unknown Patient',
            'patient_id' => $documentRequest->patient->student_id ?? 'No ID',
            'document_type' => $documentRequest->document_type,
            'purpose' => $documentRequest->purpose,
            'priority' => $documentRequest->priority,
            'status' => $documentRequest->status,
            'created_at' => optional($documentRequest->created_at)->format('M d, Y h:i A'),
            'copies_needed' => 1,
            'activities' => [
                [
                    'date' => optional($documentRequest->created_at)->format('M d, Y h:i A'),
                    'description' => 'Request submitted.',
                ],
                [
                    'date' => optional($documentRequest->updated_at)->format('M d, Y h:i A'),
                    'description' => 'Current status: ' . ucfirst($documentRequest->status),
                ],
            ],
        ]);
    }

    public function approve(DocumentRequest $documentRequest)
    {
        $this->ensureAdminAccess();

        if ($documentRequest->status !== 'pending') {
            return back()->withErrors(['This request cannot be approved anymore.']);
        }

        $documentRequest->update([
            'status' => 'approved',
        ]);

        return back()->with('success', 'Request approved successfully.');
    }

    public function release(DocumentRequest $documentRequest)
    {
        $this->ensureAdminAccess();

        if (!in_array($documentRequest->status, ['approved', 'ready'])) {
            return back()->withErrors(['Only approved or ready requests can be released.']);
        }

        $documentRequest->update([
            'status' => 'released',
        ]);

        return back()->with('success', 'Document released successfully.');
    }

    public function reject(DocumentRequest $documentRequest)
    {
        $this->ensureAdminAccess();

        if (!in_array($documentRequest->status, ['pending', 'approved'])) {
            return back()->withErrors(['This request cannot be rejected anymore.']);
        }

        $documentRequest->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Request rejected successfully.');
    }

    public function export(): StreamedResponse
    {
        $this->ensureAdminAccess();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=document_requests.csv',
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Reference Number',
                'Patient Name',
                'Student ID',
                'Document Type',
                'Purpose',
                'Priority',
                'Status',
                'Request Date',
                'Request Time',
            ]);

            DocumentRequest::with('patient')->chunk(100, function ($requests) use ($handle) {
                foreach ($requests as $request) {
                    fputcsv($handle, [
                        $request->reference_number,
                        $request->patient->full_name ?? '',
                        $request->patient->student_id ?? '',
                        $request->document_type,
                        $request->purpose,
                        $request->priority,
                        $request->status,
                        $request->request_date,
                        $request->request_time,
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function printQueue()
    {
        $this->ensureAdminAccess();

        $requests = DocumentRequest::with('patient')
            ->whereIn('status', ['approved', 'ready'])
            ->latest()
            ->get();

        return view('admin.document-request-print-queue', compact('requests'));
    }
}