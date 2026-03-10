<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DentistReportController extends Controller
{
    public function index()
    {
        $activeRole = session('impersonated_role') ?: session('role');

if ($activeRole !== 'dentist') {
            return redirect('/login');
        }

        $now       = Carbon::now();
        $thisMonth = $now->month;
        $thisYear  = $now->year;
        $today     = $now->toDateString();
        $lastMonth = $now->copy()->subMonth();

        // ── KPI 1: Patients This Month 
        $patientsThisMonth = Appointment::whereYear('appointment_date', $thisYear)
            ->whereMonth('appointment_date', $thisMonth)
            ->distinct('patient_id')->count('patient_id');

        $patientsLastMonth = Appointment::whereYear('appointment_date', $lastMonth->year)
            ->whereMonth('appointment_date', $lastMonth->month)
            ->distinct('patient_id')->count('patient_id');

        $patientsDelta = $patientsLastMonth > 0
            ? round((($patientsThisMonth - $patientsLastMonth) / $patientsLastMonth) * 100)
            : null;

        // ── KPI 2: Appointments Today 
        $appointmentsToday = Appointment::whereDate('appointment_date', $today)
            ->whereIn('status', ['pending', 'confirmed'])->count();

        $yesterday = $now->copy()->subDay()->toDateString();
        $appointmentsYesterday = Appointment::whereDate('appointment_date', $yesterday)
            ->whereIn('status', ['pending', 'confirmed', 'completed'])->count();

        $appointmentsDelta = $appointmentsToday - $appointmentsYesterday;

        // ── KPI 3: Dental Cases This Month 
        $casesThisMonth = Appointment::whereYear('appointment_date', $thisYear)
            ->whereMonth('appointment_date', $thisMonth)
            ->where('status', 'completed')->count();

        $casesLastMonth = Appointment::whereYear('appointment_date', $lastMonth->year)
            ->whereMonth('appointment_date', $lastMonth->month)
            ->where('status', 'completed')->count();

        $casesDelta = $casesLastMonth > 0
            ? round((($casesThisMonth - $casesLastMonth) / $casesLastMonth) * 100)
            : null;

        // ── KPI 4: Low Stock Items 
        $lowStockItems = DB::table('inventory_items')
            ->whereRaw('(qty - used) <= (qty * 0.30)')->count();

        // ── GAD Chart (current month) 
        [$gadLabels, $gadFemale, $gadMale] = $this->buildGadData($thisYear, $thisMonth);

        // ── Weekly Dental Cases (current month) 
        [$weekLabels, $weeklyDatasets] = $this->buildWeeklyData($thisYear, $thisMonth);

        // ── Inventory Pie Charts 
        $inventoryItems = DB::table('inventory_items')
            ->select('category', 'name', 'qty', 'used')->orderBy('name')->get();

        $medicineItems = $inventoryItems->where('category', 'Medicine')->values();
        $suppliesItems = $inventoryItems->where('category', 'Supplies')->values();

        // ── Low Stock Panel 
        $lowStockRows     = DB::table('inventory_items')
            ->whereRaw('(qty - used) <= (qty * 0.30)')
            ->orderByRaw('(qty - used) ASC')->get();

        $lowStockMedicine = $lowStockRows->where('category', 'Medicine')->values();
        $lowStockSupplies = $lowStockRows->where('category', 'Supplies')->values();

        // ── Period selector labels
        $periodOptions = [];
        for ($i = 0; $i < 3; $i++) {
            $periodOptions[] = $now->copy()->subMonths($i)->format('M Y');
        }

        $notifications = collect([]);

        return view('dentist.dentist-report', compact(
            'patientsThisMonth',
            'patientsDelta',
            'appointmentsToday',
            'appointmentsDelta',
            'casesThisMonth',
            'casesDelta',
            'lowStockItems',
            'gadLabels',
            'gadFemale',
            'gadMale',
            'weekLabels',
            'weeklyDatasets',
            'medicineItems',
            'suppliesItems',
            'lowStockMedicine',
            'lowStockSupplies',
            'periodOptions',
            'notifications'
        ));
    }

    // ── AJAX: GAD chart for selected period 
    public function gadData(Request $request)
    {
        $activeRole = session('impersonated_role') ?: session('role');

if ($activeRole !== 'dentist') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Expect "Mar 2026" or "March 2026"
        $parsed = Carbon::createFromFormat('M Y', $request->input('period'))
            ?? Carbon::createFromFormat('F Y', $request->input('period'));

        [$labels, $female, $male] = $this->buildGadData($parsed->year, $parsed->month);

        $hasData = array_sum($female) + array_sum($male) > 0;

        return response()->json([
            'labels' => $labels,
            'female' => $female,
            'male'   => $male,
            'empty'  => !$hasData,
        ]);
    }

    // ── AJAX: Weekly dental cases for selected period 
    public function weeklyData(Request $request)
    {
        $activeRole = session('impersonated_role') ?: session('role');

if ($activeRole !== 'dentist') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $parsed = Carbon::createFromFormat('M Y', $request->input('period'))
            ?? Carbon::createFromFormat('F Y', $request->input('period'));

        [$weekLabels, $datasets] = $this->buildWeeklyData($parsed->year, $parsed->month);

        return response()->json([
            'labels'   => $weekLabels,
            'datasets' => $datasets,
            'empty'    => empty($datasets),
        ]);
    }

    // ── Shared: Build GAD data for any year/month 
    private function buildGadData(int $year, int $month): array
    {
        $gadRaw = DB::table('daily_treatment_records')
            ->whereYear('treatment_date', $year)
            ->whereMonth('treatment_date', $month)
            ->select('office_type', 'gender', DB::raw('COUNT(*) as total'))
            ->groupBy('office_type', 'gender')
            ->get();

        $gadLabels = ['Student', 'Administrative', 'Faculty', 'Dependent'];
        $gadFemale = [];
        $gadMale   = [];

        foreach ($gadLabels as $label) {
            $key       = $label === 'Student' ? null : $label;
            $gadFemale[] = (int) $gadRaw->where('office_type', $key)->where('gender', 'Female')->sum('total');
            $gadMale[]   = (int) $gadRaw->where('office_type', $key)->where('gender', 'Male')->sum('total');
        }

        return [$gadLabels, $gadFemale, $gadMale];
    }

    // ── Shared: Build weekly dental cases for any year/month
    private function buildWeeklyData(int $year, int $month): array
    {
        $topServices = Appointment::whereYear('appointment_date', $year)
            ->whereMonth('appointment_date', $month)
            ->select('service_type', DB::raw('COUNT(*) as total'))
            ->groupBy('service_type')
            ->orderByDesc('total')
            ->limit(3)
            ->pluck('service_type')
            ->toArray();

        if (empty($topServices)) {
            return [[], []];
        }

        $daysInMonth  = Carbon::createFromDate($year, $month, 1)->daysInMonth;
        $weeksInMonth = (int) ceil($daysInMonth / 7);
        $weekLabels   = array_map(fn($i) => "Week $i", range(1, $weeksInMonth));

        $weeklyRaw = Appointment::whereYear('appointment_date', $year)
            ->whereMonth('appointment_date', $month)
            ->whereIn('service_type', $topServices)
            ->select(
                'service_type',
                DB::raw('CEIL(DAY(appointment_date) / 7) as week_num'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('service_type', 'week_num')
            ->get();

        $chartColors = [
            ['border' => '#8B0000', 'bg' => 'rgba(139,0,0,0.08)'],
            ['border' => '#F59E0B', 'bg' => 'rgba(245,158,11,0.08)'],
            ['border' => '#3B82F6', 'bg' => 'rgba(59,130,246,0.08)'],
        ];

        $datasets = [];
        foreach ($topServices as $i => $service) {
            $data = [];
            for ($w = 1; $w <= $weeksInMonth; $w++) {
                $data[] = (int) $weeklyRaw->where('service_type', $service)->where('week_num', $w)->sum('total');
            }
            $color      = $chartColors[$i] ?? ['border' => '#6B7280', 'bg' => 'rgba(107,114,128,0.08)'];
            $datasets[] = [
                'label'           => $service,
                'data'            => $data,
                'borderColor'     => $color['border'],
                'backgroundColor' => $color['bg'],
                'tension'         => 0.4,
                'pointRadius'     => 5,
                'fill'            => true,
            ];
        }

        return [$weekLabels, $datasets];
    }
}
