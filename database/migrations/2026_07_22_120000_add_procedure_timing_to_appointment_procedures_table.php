<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointment_procedures', function (Blueprint $table) {
            if (!Schema::hasColumn('appointment_procedures', 'procedure_started_at')) {
                $table->timestamp('procedure_started_at')->nullable()->after('completion_action');
            }

            if (!Schema::hasColumn('appointment_procedures', 'procedure_completed_at')) {
                $table->timestamp('procedure_completed_at')->nullable()->after('procedure_started_at');
            }

            if (!Schema::hasColumn('appointment_procedures', 'procedure_duration_seconds')) {
                $table->unsignedInteger('procedure_duration_seconds')->nullable()->after('procedure_completed_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('appointment_procedures', function (Blueprint $table) {
            $dropColumns = [];

            if (Schema::hasColumn('appointment_procedures', 'procedure_duration_seconds')) {
                $dropColumns[] = 'procedure_duration_seconds';
            }

            if (Schema::hasColumn('appointment_procedures', 'procedure_completed_at')) {
                $dropColumns[] = 'procedure_completed_at';
            }

            if (Schema::hasColumn('appointment_procedures', 'procedure_started_at')) {
                $dropColumns[] = 'procedure_started_at';
            }

            if (!empty($dropColumns)) {
                $table->dropColumn($dropColumns);
            }
        });
    }
};
