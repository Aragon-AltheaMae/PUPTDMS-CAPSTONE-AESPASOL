<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_odontograms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->unique()->constrained()->cascadeOnDelete();
            $table->json('odontogram_data')->nullable();
            $table->foreignId('last_appointment_id')->nullable()->constrained('appointments')->nullOnDelete();
            $table->foreignId('last_updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        if (!Schema::hasTable('appointment_procedures')) {
            return;
        }

        $latestProcedures = DB::table('appointment_procedures')
            ->whereNotNull('odontogram_data')
            ->orderBy('patient_id')
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->get()
            ->unique('patient_id');

        foreach ($latestProcedures as $procedure) {
            DB::table('patient_odontograms')->insertOrIgnore([
                'patient_id' => $procedure->patient_id,
                'odontogram_data' => $procedure->odontogram_data,
                'last_appointment_id' => $procedure->appointment_id,
                'last_updated_by' => null,
                'created_at' => $procedure->created_at ?? now(),
                'updated_at' => $procedure->updated_at ?? now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_odontograms');
    }
};
