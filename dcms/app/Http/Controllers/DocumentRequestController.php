<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentRequest;
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
                    'document_type'=> $request->document_type,
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
       ADMIN: UPDATE STATUS
    ======================= */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $docRequest = DocumentRequest::findOrFail($id);

        $docRequest->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Request updated.');
    }
}
