<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('medical_history_disease_answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            $table->foreignId('medical_history_id')
                ->constrained('medical_histories')
                ->cascadeOnDelete();

            $table->foreignId('disease_id')
                ->constrained('diseases')
                ->cascadeOnDelete();

            $table->boolean('has_disease')->default(true);

            $table->unique(['medical_history_id', 'disease_id'], 'mhda_mh_dis_uq');
            $table->index(['patient_id', 'disease_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_history_disease_answers');
    }
};