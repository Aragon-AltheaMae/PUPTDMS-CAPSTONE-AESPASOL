<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('medical_history_answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            $table->foreignId('medical_history_id')
                ->constrained('medical_histories')
                ->cascadeOnDelete();

            $table->foreignId('question_id')
                ->constrained('medical_history_questions')
                ->cascadeOnDelete();

            // Requested field
            $table->boolean('answer_bool')->nullable();

            // Needed to preserve your existing form details (still 3NF):
            $table->text('answer_text')->nullable();
            $table->date('answer_date')->nullable();

            $table->unique(['medical_history_id', 'question_id']);
            $table->index(['patient_id', 'question_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_history_answers');
    }
};