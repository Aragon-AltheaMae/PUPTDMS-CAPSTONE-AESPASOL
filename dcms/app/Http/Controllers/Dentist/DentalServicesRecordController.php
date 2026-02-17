<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use App\Models\DentalServiceRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DentalServicesRecordController extends Controller
{
    public function index(Request $request)
    {
        // Initial load month filter (YYYY-MM), default current month
        $month = $request->input('month');
        $start = $month
            ? Carbon::createFromFormat('Y-m', $month)->startOfMonth()
            : now()->startOfMonth();
        $end = (clone $start)->endOfMonth();

        $records = DentalServiceRecord::query()
            ->whereBetween('time_in', [$start, $end])
            ->latest('time_in')
            ->get()
            ->map(fn ($r) => $this->toFrontendRow($r));

        // keep as-is for now
        $notifications = [];

        return view('dentist.dental-services-record', compact('records', 'notifications'));
    }

    public function data(Request $request)
    {
        $month = $request->input('month'); // YYYY-MM
        $start = $month
            ? Carbon::createFromFormat('Y-m', $month)->startOfMonth()
            : now()->startOfMonth();
        $end = (clone $start)->endOfMonth();

        $records = DentalServiceRecord::query()
            ->whereBetween('time_in', [$start, $end])
            ->latest('time_in')
            ->get()
            ->map(fn ($r) => $this->toFrontendRow($r));

        return response()->json($records);
    }

    private function toFrontendRow(DentalServiceRecord $r): array
    {
        $middleInitial = $r->patient_middle_name
            ? strtoupper(substr($r->patient_middle_name, 0, 1)) . '.'
            : '';

        $name = trim("{$r->patient_last_name}, {$r->patient_first_name} {$middleInitial}");

        $programDisplay = $r->department === 'Student'
            ? trim(($r->program_code ?? '') . ' ' . ($r->year_level ? $r->year_level : '') . ($r->section ? "-{$r->section}" : ''))
            : ($r->department ?? '');

        $priority = array_values(array_filter([
            $r->is_pwd ? 'PWD' : null,
            $r->is_senior ? 'Senior' : null,
        ]));

        $duration = '';
        if ($r->time_in && $r->time_out) {
            $duration = $r->time_in->diffInMinutes($r->time_out) . ' mins';
        }

        return [
            'id' => $r->id,
            'date' => $r->time_in->format('m/d/y'),
            'timeIn' => $r->time_in->format('h:i A'),
            'name' => $name,
            'program' => $programDisplay,
            'age' => $r->age,
            'gad' => [
                'gender' => $r->gender,
                'priority' => $priority,
            ],
            'email' => $r->email,
            'contact' => $r->contact,
            'timeOut' => $r->time_out ? $r->time_out->format('h:i A') : '',
            'duration' => $duration,
            'type' => $r->visit_type,          // "Emergency" | "Non-Emergency"
            'department' => $r->department,    // "Student" | "Faculty" | ...
            'has_signature' => $r->has_signature,
        ];
    }
}
