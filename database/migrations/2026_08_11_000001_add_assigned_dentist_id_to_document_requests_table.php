<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('document_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('document_requests', 'assigned_dentist_id')) {
                $table->foreignId('assigned_dentist_id')
                    ->nullable()
                    ->after('patient_id')
                    ->constrained('users')
                    ->nullOnDelete();
            }
        });

        if (
            Schema::hasTable('document_requests')
            && Schema::hasTable('appointments')
            && Schema::hasColumn('document_requests', 'assigned_dentist_id')
            && Schema::hasColumn('appointments', 'patient_id')
            && Schema::hasColumn('appointments', 'dentist_id')
        ) {
            $documentRequests = DB::table('document_requests')
                ->select('id', 'patient_id')
                ->whereNull('assigned_dentist_id')
                ->get();

            foreach ($documentRequests as $documentRequest) {
                $latestAppointment = DB::table('appointments')
                    ->where('patient_id', $documentRequest->patient_id)
                    ->whereNotNull('dentist_id')
                    ->orderByDesc('appointment_date')
                    ->orderByDesc('appointment_time')
                    ->first(['dentist_id']);

                if ($latestAppointment?->dentist_id) {
                    DB::table('document_requests')
                        ->where('id', $documentRequest->id)
                        ->update(['assigned_dentist_id' => $latestAppointment->dentist_id]);
                }
            }
        }
    }

    public function down(): void
    {
        Schema::table('document_requests', function (Blueprint $table) {
            if (Schema::hasColumn('document_requests', 'assigned_dentist_id')) {
                $table->dropConstrainedForeignId('assigned_dentist_id');
            }
        });
    }
};
