<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'sso_user_id')) {
                $table->string('sso_user_id')->nullable()->unique()->after('status');
            }

            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('sso_user_id');
            }

            if (!Schema::hasColumn('users', 'access_token')) {
                $table->text('access_token')->nullable()->after('last_login_at');
            }

            if (!Schema::hasColumn('users', 'refresh_token')) {
                $table->text('refresh_token')->nullable()->after('access_token');
            }
        });

        Schema::table('patients', function (Blueprint $table) {
            if (!Schema::hasColumn('patients', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            if (Schema::hasColumn('patients', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            $columns = [];

            if (Schema::hasColumn('users', 'sso_user_id')) {
                $columns[] = 'sso_user_id';
            }

            if (Schema::hasColumn('users', 'last_login_at')) {
                $columns[] = 'last_login_at';
            }

            if (Schema::hasColumn('users', 'access_token')) {
                $columns[] = 'access_token';
            }

            if (Schema::hasColumn('users', 'refresh_token')) {
                $columns[] = 'refresh_token';
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};