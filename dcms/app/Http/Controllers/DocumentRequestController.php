<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentRequest;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DocumentRequestController extends Controller
{
    /* =======================
       STORE DOCUMENT REQUEST
    ======================= */
    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string|max:100',
            'purpose'       => 'required|string|max:150',
        ]);

        try {
            DB::transaction(function () use ($request) {
                DocumentRequest::create([
                    'patient_id'   => session('patient_id'),
                    'document_type' => $request->document_type,
                    'purpose'      => $request->purpose,
                    'request_date' => Carbon::now()->toDateString(),
                    'request_time' => Carbon::now()->toTimeString(),
                    'status'       => 'pending',
                ]);
            });
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to submit request.');
        }

        return response()->json([
            'success' => true,
            'message' => 'Document request submitted successfully.'
        ]);
    }

    /* =======================
       PATIENT REQUEST HISTORY
    ======================= */
    public function index()
    {
        $requests = DocumentRequest::where('patient_id', session('patient_id'))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('document-requests.index', compact('requests'));
    }

    /* =======================
       DENTIST: LIST PAGE
    ======================= */
    public function dentistIndex(Request $request)
    {
        $activeRole = session('impersonated_role') ?: session('role');

if ($activeRole !== 'dentist') {
            return redirect('/login');
        }

        $notifications = collect([]);

        return view('dentist.dentist-documentrequests', compact('notifications'));
    }

    public function dentistData(Request $request)
    {
        $activeRole = session('impersonated_role') ?: session('role');

if ($activeRole !== 'dentist') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $requests = DocumentRequest::with('patient')
            ->latest('request_date')
            ->get()
            ->map(function ($req) {
                $parts       = explode(' ', trim($req->patient->name ?? ''));
                $last        = count($parts) > 1 ? array_pop($parts) : ($parts[0] ?? '—');
                $first       = implode(' ', $parts);
                $displayName = $first ? "$last, $first" : $last;

                return [
                    'id'            => $req->id,
                    'status'        => $req->status,
                    'document_type' => $req->document_type,
                    'purpose'       => $req->purpose ?? '—',
                    'request_date'  => Carbon::parse($req->request_date)->format('M d, Y'),
                    'request_time'  => Carbon::parse($req->request_time)->format('h:i A'),
                    'patient_name'  => $displayName,
                    'sub_label'     => $req->patient->course_section
                        ?? $req->patient->department
                        ?? $req->patient->role
                        ?? null,
                ];
            });

        $counts = DocumentRequest::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return response()->json([
            'requests' => $requests,
            'stats'    => [
                'all'      => DocumentRequest::count(),
                'pending'  => $counts['pending']  ?? 0,
                'approved' => $counts['approved'] ?? 0,
                'rejected' => $counts['rejected'] ?? 0,
            ],
        ]);
    }

    /* =======================
       DENTIST: APPROVE (AJAX)
    ======================= */
    public function approve(Request $request, $id)
    {
       $activeRole = session('impersonated_role') ?: session('role');

if ($activeRole !== 'dentist') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $docRequest = DocumentRequest::findOrFail($id);
        $docRequest->update(['status' => 'approved']);

        return response()->json(['success' => true, 'message' => 'Document request approved.']);
    }

    /* =======================
       DENTIST: REJECT (AJAX)
    ======================= */
    public function reject(Request $request, $id)
    {
        $activeRole = session('impersonated_role') ?: session('role');

if ($activeRole !== 'dentist') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $docRequest = DocumentRequest::findOrFail($id);
        $docRequest->update(['status' => 'rejected']);

        return response()->json(['success' => true, 'message' => 'Document request rejected.']);
    }

    /* =======================
       LEGACY: UPDATE STATUS
    ======================= */
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:approved,rejected']);

        DocumentRequest::findOrFail($id)->update(['status' => $request->status]);

        return back()->with('success', 'Request updated.');
    }

    /* =======================
       ADMIN: UPDATE STATUS
    ======================= */
    // public function updateStatus(Request $request, $id)
    // {
    //     $request->validate([
    //         'status' => 'required|in:approved,rejected',
    //     ]);

    //     $docRequest = DocumentRequest::findOrFail($id);

    //     $docRequest->update([
    //         'status' => $request->status,
    //     ]);

    //     return back()->with('success', 'Request updated.');
    // }
}
