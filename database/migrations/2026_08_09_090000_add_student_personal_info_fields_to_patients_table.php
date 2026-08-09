<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            if (! Schema::hasColumn('patients', 'place_of_birth')) {
                $table->string('place_of_birth')->nullable()->after('gender');
            }

            if (! Schema::hasColumn('patients', 'height_m')) {
                $table->decimal('height_m', 5, 2)->nullable()->after('place_of_birth');
            }

            if (! Schema::hasColumn('patients', 'weight_kg')) {
                $table->decimal('weight_kg', 5, 2)->nullable()->after('height_m');
            }
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $columns = [];

            foreach (['place_of_birth', 'height_m', 'weight_kg'] as $column) {
                if (Schema::hasColumn('patients', $column)) {
                    $columns[] = $column;
                }
            }

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
