<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('audit_logs', 'is_archived')) {
                $table->boolean('is_archived')->default(false)->after('description');
            }

            if (!Schema::hasColumn('audit_logs', 'archived_at')) {
                $table->timestamp('archived_at')->nullable()->after('is_archived');
            }

            if (!Schema::hasColumn('audit_logs', 'archived_by')) {
                $table->unsignedBigInteger('archived_by')->nullable()->after('archived_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            if (Schema::hasColumn('audit_logs', 'archived_by')) {
                $table->dropColumn('archived_by');
            }

            if (Schema::hasColumn('audit_logs', 'archived_at')) {
                $table->dropColumn('archived_at');
            }

            if (Schema::hasColumn('audit_logs', 'is_archived')) {
                $table->dropColumn('is_archived');
            }
        });
    }
};
