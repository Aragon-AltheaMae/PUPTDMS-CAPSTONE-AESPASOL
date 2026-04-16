<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DentalRecordController extends Controller
{
    public function index()
    {
        $totalRecords = DB::table('dental_records')->count();

        $recordsToday = DB::table('dental_records')
            ->whereDate('created_at', Carbon::today())
            ->count();

        $pending = DB::table('dental_records')
            ->where('status', 'pending')
            ->count();

        $records = DB::table('dental_records as dr')
            ->leftJoin('patients as p', 'dr.patient_id', '=', 'p.id')
            ->leftJoin('users as d', 'dr.dentist_id', '=', 'd.id')
            ->select(
                'p.name as patient_name',
                'dr.procedure_name as procedure',
                'd.name as dentist_name',
                'dr.status',
                'dr.created_at as date'
            )
            ->latest('dr.created_at')
            ->get();

        return view('admin.dental-records.index', compact(
            'totalRecords',
            'recordsToday',
            'pending',
            'records'
        ));
    }
}