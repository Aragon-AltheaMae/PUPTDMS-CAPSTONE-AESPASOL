<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('audit_logs', 'actor_identifier')) {
                $table->unsignedBigInteger('actor_identifier')->nullable()->after('id');
            }

            if (!Schema::hasColumn('audit_logs', 'actor_name')) {
                $table->string('actor_name')->nullable()->after('actor_identifier');
            }

            if (!Schema::hasColumn('audit_logs', 'actor_role')) {
                $table->string('actor_role')->nullable()->after('actor_name');
            }

            if (!Schema::hasColumn('audit_logs', 'action')) {
                $table->string('action')->nullable()->after('actor_role');
            }

            if (!Schema::hasColumn('audit_logs', 'module')) {
                $table->string('module')->nullable()->after('action');
            }

            if (!Schema::hasColumn('audit_logs', 'description')) {
                $table->text('description')->nullable()->after('module');
            }

            if (!Schema::hasColumn('audit_logs', 'ip_address')) {
                $table->ipAddress('ip_address')->nullable()->after('description');
            }

            if (!Schema::hasColumn('audit_logs', 'user_agent')) {
                $table->text('user_agent')->nullable()->after('ip_address');
            }
        });
    }

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            //
        });
    }
};