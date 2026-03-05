<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dental_histories', function (Blueprint $table) {
            $table->id();

            // One dental history per patient
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->unique('patient_id');

            // Optional: which appointment created it
            $table->foreignId('source_appointment_id')
                ->nullable()
                ->constrained('appointments')
                ->nullOnDelete();

            // Basic info
            $table->date('last_dental_visit')->nullable();
            $table->string('previous_dentist', 100)->nullable();

            // YES / NO -> boolean
            $table->boolean('bleeding_gums')->default(false);
            $table->boolean('sensitive_temp')->default(false);
            $table->boolean('sensitive_taste')->default(false);
            $table->boolean('tooth_pain')->default(false);
            $table->boolean('sores')->default(false);
            $table->boolean('injuries')->default(false);

            $table->boolean('clicking')->default(false);
            $table->boolean('joint_pain')->default(false);
            $table->boolean('difficulty_moving')->default(false);
            $table->boolean('difficulty_chewing')->default(false);
            $table->boolean('jaw_headaches')->default(false);
            $table->boolean('clench_grind')->default(false);
            $table->boolean('biting')->default(false);
            $table->boolean('teeth_loosening')->default(false);
            $table->boolean('food_teeth')->default(false);
            $table->boolean('med_reaction')->default(false);

            $table->boolean('periodontal')->default(false);
            $table->boolean('difficult_extraction')->default(false);
            $table->boolean('prolonged_bleeding')->default(false);
            $table->boolean('dentures')->default(false);
            $table->boolean('ortho_treatment')->default(false);

            // Conditional dates
            $table->date('extraction_date')->nullable();
            $table->date('dentures_date')->nullable();
            $table->date('ortho_date')->nullable();

            // Free text
            $table->text('additional_concerns')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dental_histories');
    }
};