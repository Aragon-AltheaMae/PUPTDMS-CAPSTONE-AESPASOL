<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
    Schema::create('dental_histories', function (Blueprint $table) {
        $table->id();
        
        $table->foreignId('patient_id')
            ->constrained('patients')
            ->cascadeOnDelete();

        $table->unique('patient_id');

        $table->date('last_dental_visit')->nullable();
        $table->string('previous_dentist', 60)->nullable();

        $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dental_histories');
    }
};

