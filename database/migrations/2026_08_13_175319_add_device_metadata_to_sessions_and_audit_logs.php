<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            $table->string('device_type')->nullable()->after('browser_name');
            $table->string('device_name')->nullable()->after('device_type');
            $table->string('os_name')->nullable()->after('device_name');
        });

        Schema::table('audit_logs', function (Blueprint $table) {
            $table->string('device_type')->nullable()->after('browser_name');
            $table->string('device_name')->nullable()->after('device_type');
            $table->string('os_name')->nullable()->after('device_name');
        });
    }

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropColumn([
                'device_type',
                'device_name',
                'os_name',
            ]);
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->dropColumn([
                'device_type',
                'device_name',
                'os_name',
            ]);
        });
    }
};