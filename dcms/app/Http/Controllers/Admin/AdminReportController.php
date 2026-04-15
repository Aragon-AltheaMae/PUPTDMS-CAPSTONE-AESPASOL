<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminReportController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // ---------------------------
        // PATIENT STATS
        // ---------------------------
        $totalPatients = DB::table('patients')->count();

        $newToday = DB::table('patients')
            ->whereDate('created_at', $now->toDateString())
            ->count();

        $newYesterday = DB::table('patients')
            ->whereDate('created_at', $now->copy()->subDay()->toDateString())
            ->count();

        $newThisWeek = DB::table('patients')
            ->whereBetween('created_at', [
                $now->copy()->startOfWeek(),
                $now->copy()->endOfWeek()
            ])
            ->count();

        $newThisMonth = DB::table('patients')
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();

        $lastMonth = $now->copy()->subMonth();

        $lastMonthPatients = DB::table('patients')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        $newMonthPct = $lastMonthPatients > 0
            ? round((($newThisMonth - $lastMonthPatients) / $lastMonthPatients) * 100)
            : 0;

        $stats = [
            'total_patients' => $totalPatients,
            'new_today' => $newToday,
            'new_today_diff' => $newToday - $newYesterday,
            'new_this_week' => $newThisWeek,
            'new_this_month' => $newThisMonth,
            'new_month_pct' => $newMonthPct,
            'returning_pct' => 0,
            'avg_visits' => 0,
        ];

        // ---------------------------
        // TREATMENTS
        // ---------------------------
        $treatmentRaw = DB::table('appointments')
            ->select('service_type', DB::raw('COUNT(*) as total'))
            ->whereMonth('appointment_date', $now->month)
            ->whereYear('appointment_date', $now->year)
            ->where('status', 'completed')
            ->groupBy('service_type')
            ->get();

        $totalTreatments = $treatmentRaw->sum('total');

        $breakdown = $treatmentRaw->map(function ($item) use ($totalTreatments) {
            return [
                'name' => ucfirst($item->service_type ?? 'Other'),
                'count' => (int) $item->total,
                'pct' => $totalTreatments > 0 ? round(($item->total / $totalTreatments) * 100) : 0,
            ];
        });

        $treatments = [
            'total' => $totalTreatments,
            'breakdown' => $breakdown,
        ];

        // ---------------------------
        // APPOINTMENTS
        // ---------------------------
        $appointmentsTotal = DB::table('appointments')
            ->whereMonth('appointment_date', $now->month)
            ->whereYear('appointment_date', $now->year)
            ->count();

        $completed = DB::table('appointments')
            ->where('status', 'completed')
            ->whereMonth('appointment_date', $now->month)
            ->whereYear('appointment_date', $now->year)
            ->count();

        $cancelled = DB::table('appointments')
            ->where('status', 'cancelled')
            ->whereMonth('appointment_date', $now->month)
            ->whereYear('appointment_date', $now->year)
            ->count();

        $noShow = DB::table('appointments')
            ->whereIn('status', ['no_show', 'no-show'])
            ->whereMonth('appointment_date', $now->month)
            ->whereYear('appointment_date', $now->year)
            ->count();

        $appointments = [
            'total' => $appointmentsTotal,
            'completed' => $completed,
            'cancelled' => $cancelled,
            'no_show' => $noShow,
            'completion_rate' => $appointmentsTotal > 0 ? round(($completed / $appointmentsTotal) * 100) : 0,
            'no_show_rate' => $appointmentsTotal > 0 ? round(($noShow / $appointmentsTotal) * 100) : 0,
            'cancelled_rate' => $appointmentsTotal > 0 ? round(($cancelled / $appointmentsTotal) * 100) : 0,
        ];

        // ---------------------------
        // INVENTORY
        // ---------------------------
        $inventoryItems = collect();
        $lowStockCount = 0;

        if (DB::getSchemaBuilder()->hasTable('inventory_items')) {
            $items = DB::table('inventory_items')->get();

            $inventoryItems = $items->map(function ($item) {
                $qty = isset($item->qty) ? (int) $item->qty : 0;
                $used = isset($item->used) ? (int) $item->used : 0;
                $minLevel = isset($item->min_level) ? (int) $item->min_level : 10;
                $inStock = $qty - $used;

                return [
                    'name' => $item->name ?? 'Unnamed Item',
                    'used' => $used,
                    'in_stock' => $inStock,
                    'min_level' => $minLevel,
                ];
            });

            $lowStockCount = $inventoryItems->filter(function ($item) {
                return $item['in_stock'] < $item['min_level'];
            })->count();
        }

        $inventory = [
            'items' => $inventoryItems,
            'low_stock_count' => $lowStockCount,
        ];

        // ---------------------------
        // CHARTS
        // ---------------------------
        $months = collect(range(1, 12))->map(function ($m) {
            return Carbon::create()->month($m)->format('M');
        });

        $barData = collect(range(1, 12))->map(function ($m) use ($now) {
            return DB::table('appointments')
                ->whereMonth('appointment_date', $m)
                ->whereYear('appointment_date', $now->year)
                ->where('status', 'completed')
                ->count();
        });

        $lineNewPatients = collect(range(1, 12))->map(function ($m) use ($now) {
            return DB::table('patients')
                ->whereMonth('created_at', $m)
                ->whereYear('created_at', $now->year)
                ->count();
        });

        $runningTotal = 0;
        $lineTotals = $lineNewPatients->map(function ($count) use (&$runningTotal) {
            $runningTotal += $count;
            return $runningTotal;
        });

        $charts = [
            'bar' => [
                'labels' => $months->values()->all(),
                'data' => $barData->values()->all(),
            ],
            'pie' => [
                'labels' => $breakdown->pluck('name')->values()->all(),
                'data' => $breakdown->pluck('count')->values()->all(),
            ],
            'line' => [
                'labels' => $months->values()->all(),
                'totals' => $lineTotals->values()->all(),
                'new_patients' => $lineNewPatients->values()->all(),
            ],
        ];

        return view('admin.reports', compact(
            'stats',
            'treatments',
            'appointments',
            'inventory',
            'charts'
        ));
    }
}