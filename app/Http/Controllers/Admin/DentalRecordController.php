<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DentalRecordController extends Controller
{
    public function index(Request $request)
    {
        $totalRecords = 0;
        $recordsToday = 0;
        $pending = 0;
        $ongoingCount = 0;
        $completedCount = 0;
        $cancelledCount = 0;

        $records = collect();

        $topProcedure = 'No data yet';
        $completedThisWeek = 0;
        $patientsForFollowUp = 0;

        $search = trim(
            (string) $request->input(
                'search',
                ''
            )
        );

        $status = trim(
            (string) $request->input(
                'status',
                'all'
            )
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


        if (Schema::hasTable('dental_records')) {

            $baseQuery =
                DB::table('dental_records');


            $totalRecords =
                (clone $baseQuery)
                ->count();


            $recordsToday =
                (clone $baseQuery)
                ->whereDate(
                    'created_at',
                    Carbon::today()
                )
                ->count();


            $pending =
                (clone $baseQuery)
                ->where(
                    'status',
                    'pending'
                )
                ->count();


            $ongoingCount =
                (clone $baseQuery)
                ->whereIn(
                    'status',
                    [
                        'ongoing',
                        'in-progress',
                        'in_progress',
                    ]
                )
                ->count();


            $completedCount =
                (clone $baseQuery)
                ->where(
                    'status',
                    'completed'
                )
                ->count();


            $cancelledCount =
                (clone $baseQuery)
                ->whereIn(
                    'status',
                    [
                        'cancelled',
                        'canceled',
                    ]
                )
                ->count();


            $recordsQuery =
                DB::table(
                    'dental_records as dr'
                )
                ->leftJoin(
                    'patients as p',
                    'dr.patient_id',
                    '=',
                    'p.id'
                )
                ->leftJoin(
                    'users as d',
                    'dr.dentist_id',
                    '=',
                    'd.id'
                )
                ->select(
                    'dr.id',
                    'p.name as patient_name',
                    'dr.procedure_name as procedure',
                    'd.name as dentist_name',
                    'dr.status',
                    'dr.created_at as date'
                );


            if ($search !== '') {
                $recordsQuery->where(
                    function ($query)
                    use ($search) {
                        $query
                            ->where(
                                'p.name',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'dr.procedure_name',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'd.name',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'dr.status',
                                'like',
                                "%{$search}%"
                            );
                    }
                );
            }


            if ($status === 'today') {
                $recordsQuery->whereDate(
                    'dr.created_at',
                    Carbon::today()
                );
            } elseif (
                $status === 'ongoing'
            ) {
                $recordsQuery->whereIn(
                    'dr.status',
                    [
                        'ongoing',
                        'in-progress',
                        'in_progress',
                    ]
                );
            } elseif (
                $status === 'cancelled'
            ) {
                $recordsQuery->whereIn(
                    'dr.status',
                    [
                        'cancelled',
                        'canceled',
                    ]
                );
            } elseif (
                in_array(
                    $status,
                    [
                        'pending',
                        'completed',
                    ],
                    true
                )
            ) {
                $recordsQuery->where(
                    'dr.status',
                    $status
                );
            }


            $records =
                $recordsQuery
                ->latest(
                    'dr.created_at'
                )
                ->paginate(
                    $perPage
                )
                ->withQueryString();


            $topProcedureObj =
                DB::table(
                    'dental_records'
                )
                ->select(
                    'procedure_name',
                    DB::raw(
                        'COUNT(*) as count'
                    )
                )
                ->groupBy(
                    'procedure_name'
                )
                ->orderByDesc(
                    'count'
                )
                ->first();


            $topProcedure =
                $topProcedureObj
                ->procedure_name
                ?? 'No data yet';


            $completedThisWeek =
                DB::table(
                    'dental_records'
                )
                ->where(
                    'status',
                    'completed'
                )
                ->whereBetween(
                    'created_at',
                    [
                        Carbon::now()
                            ->startOfWeek(),

                        Carbon::now()
                            ->endOfWeek(),
                    ]
                )
                ->count();


            $patientsForFollowUp =
                DB::table(
                    'dental_records'
                )
                ->where(
                    'status',
                    'pending'
                )
                ->distinct(
                    'patient_id'
                )
                ->count(
                    'patient_id'
                );
        }


        $viewData = compact(
            'totalRecords',
            'recordsToday',
            'pending',
            'ongoingCount',
            'completedCount',
            'cancelledCount',
            'records',
            'topProcedure',
            'completedThisWeek',
            'patientsForFollowUp'
        );


        $isPaginator =
            $records instanceof
            \Illuminate\Pagination\AbstractPaginator;


        $pagination = [
            'current_page' =>
            $isPaginator
                ? $records->currentPage()
                : 1,

            'last_page' =>
            $isPaginator
                ? $records->lastPage()
                : 1,

            'total' =>
            $isPaginator
                ? $records->total()
                : $records->count(),

            'from' =>
            $isPaginator
                ? ($records->firstItem() ?? 0)
                : 0,

            'to' =>
            $isPaginator
                ? ($records->lastItem() ?? 0)
                : $records->count(),

            'per_page' =>
            $isPaginator
                ? $records->perPage()
                : $perPage,
        ];


        if (
            $request->ajax() ||
            $request->expectsJson()
        ) {
            return response()->json([
                'success' => true,

                'html' => view(
                    'admin.dental-records',
                    $viewData
                )->render(),

                'pagination' =>
                $pagination,

                'counts' => [
                    'all' =>
                    $totalRecords,

                    'today' =>
                    $recordsToday,

                    'pending' =>
                    $pending,

                    'ongoing' =>
                    $ongoingCount,

                    'completed' =>
                    $completedCount,

                    'cancelled' =>
                    $cancelledCount,
                ],
            ]);
        }

        return view(
            'admin.dental-records',
            $viewData
        );
    }
}
