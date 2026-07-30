<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('external_admin_accesses', function (Blueprint $table) {
            $table->string('cms_role')->nullable()->after('has_cms_access');
            $table->string('cms_status')->default('active')->after('cms_role');
        });
    }

    public function down(): void
    {
        Schema::table('external_admin_accesses', function (Blueprint $table) {
            $table->dropColumn(['cms_role', 'cms_status']);
        });
    }
};