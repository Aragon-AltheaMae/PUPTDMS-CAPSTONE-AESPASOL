<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'employment_status')) {
                $table->string('employment_status', 40)->nullable()->after('status');
            }

            if (!Schema::hasColumn('users', 'account_status')) {
                $table->string('account_status', 40)->nullable()->after('employment_status');
            }

            if (!Schema::hasColumn('users', 'last_working_date')) {
                $table->date('last_working_date')->nullable()->after('account_status');
            }

            if (!Schema::hasColumn('users', 'access_ends_at')) {
                $table->timestamp('access_ends_at')->nullable()->after('last_working_date');
            }

            if (!Schema::hasColumn('users', 'deactivated_at')) {
                $table->timestamp('deactivated_at')->nullable()->after('access_ends_at');
            }

            if (!Schema::hasColumn('users', 'deactivated_by')) {
                $table->foreignId('deactivated_by')->nullable()->after('deactivated_at')->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('users', 'deactivation_reason')) {
                $table->text('deactivation_reason')->nullable()->after('deactivated_by');
            }
        });

        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'dentist_id')) {
                $table->foreignId('dentist_id')->nullable()->after('patient_id')->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('appointments', 'original_dentist_id')) {
                $table->foreignId('original_dentist_id')->nullable()->after('dentist_id')->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('appointments', 'transferred_by')) {
                $table->foreignId('transferred_by')->nullable()->after('original_dentist_id')->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('appointments', 'transferred_at')) {
                $table->timestamp('transferred_at')->nullable()->after('transferred_by');
            }

            if (!Schema::hasColumn('appointments', 'transfer_reason')) {
                $table->string('transfer_reason', 120)->nullable()->after('transferred_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'transfer_reason')) {
                $table->dropColumn('transfer_reason');
            }

            if (Schema::hasColumn('appointments', 'transferred_at')) {
                $table->dropColumn('transferred_at');
            }

            if (Schema::hasColumn('appointments', 'transferred_by')) {
                $table->dropConstrainedForeignId('transferred_by');
            }

            if (Schema::hasColumn('appointments', 'original_dentist_id')) {
                $table->dropConstrainedForeignId('original_dentist_id');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'deactivation_reason')) {
                $table->dropColumn('deactivation_reason');
            }

            if (Schema::hasColumn('users', 'deactivated_by')) {
                $table->dropConstrainedForeignId('deactivated_by');
            }

            foreach (['deactivated_at', 'access_ends_at', 'last_working_date', 'account_status', 'employment_status'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
