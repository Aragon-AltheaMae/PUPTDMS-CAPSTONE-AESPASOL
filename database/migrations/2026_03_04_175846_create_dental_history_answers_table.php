<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dental_history_answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            $table->foreignId('condition_id')
                ->constrained('dental_history_conditions')
                ->cascadeOnDelete();

            // YES/NO
            $table->boolean('answer')->default(false);

            // one answer per question per patient
            $table->unique(['patient_id', 'condition_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dental_history_answers');
    }
};