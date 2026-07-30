<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            if (!Schema::hasColumn('patients', 'course_code')) {
                $table->string('course_code')->nullable()->after('student_no');
            }

            if (!Schema::hasColumn('patients', 'course_name')) {
                $table->string('course_name')->nullable()->after('course_code');
            }

            if (!Schema::hasColumn('patients', 'year_level')) {
                $table->integer('year_level')->nullable()->after('course_name');
            }

            if (!Schema::hasColumn('patients', 'section')) {
                $table->string('section')->nullable()->after('year_level');
            }

            if (!Schema::hasColumn('patients', 'is_pwd')) {
                $table->boolean('is_pwd')->default(false)->after('section');
            }

            if (!Schema::hasColumn('patients', 'is_senior')) {
                $table->boolean('is_senior')->default(false)->after('is_pwd');
            }

            if (!Schema::hasColumn('patients', 'address')) {
                $table->text('address')->nullable()->after('is_senior');
            }
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $columns = [];

            foreach (['course_code', 'course_name', 'year_level', 'section', 'is_pwd', 'is_senior', 'address'] as $column) {
                if (Schema::hasColumn('patients', $column)) {
                    $columns[] = $column;
                }
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};