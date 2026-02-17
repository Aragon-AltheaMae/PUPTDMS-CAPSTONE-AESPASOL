<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyTreatmentRecord;

class DailyTreatmentRecordController extends Controller
{

    public function index()
    {
        $notifications = [];
        return view('dentist.reports.daily-treatment-record', compact('notifications'));
    }

    public function list(Request $request)
    {
        $query = DailyTreatmentRecord::query();

        if ($request->filled('month')) {
            [$year, $month] = explode('-', $request->month);

            $query->whereYear('treatment_date', $year)
                  ->whereMonth('treatment_date', $month);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('patient_name', 'like', "%{$search}%")
                  ->orWhere('patient_email', 'like', "%{$search}%")
                  ->orWhere('patient_phone', 'like', "%{$search}%")
                  ->orWhere('office_type', 'like', "%{$search}%")
                  ->orWhere('program_code', 'like', "%{$search}%")
                  ->orWhere('treatment_done', 'like', "%{$search}%");
            });
        }

        if ($request->filled('office_type')) {
            $query->where('office_type', $request->office_type);
        }

        if ($request->filled('program_code')) {
            $query->where('program_code', $request->program_code);
        }

        if ($request->filled('sort_date')) {
            $query->orderBy(
                'treatment_date',
                $request->sort_date === 'desc' ? 'desc' : 'asc'
            );
        }

        if ($request->filled('sort_name')) {
            $query->orderBy(
                'patient_name',
                $request->sort_name === 'za' ? 'desc' : 'asc'
            );
        }

        if (!$request->filled('sort_date') && !$request->filled('sort_name')) {
            $query->orderBy('treatment_date', 'desc');
        }

        return response()->json([
            'data' => $query->get()
        ]);
    }
}
