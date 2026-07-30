<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            if (!Schema::hasColumn('patients', 'faculty_code')) {
                $table->string('faculty_code')->nullable()->after('gender');
            }

            if (!Schema::hasColumn('patients', 'student_no')) {
                $table->string('student_no')->nullable()->after('faculty_code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            if (Schema::hasColumn('patients', 'student_no')) {
                $table->dropColumn('student_no');
            }

            if (Schema::hasColumn('patients', 'faculty_code')) {
                $table->dropColumn('faculty_code');
            }
        });
    }
};