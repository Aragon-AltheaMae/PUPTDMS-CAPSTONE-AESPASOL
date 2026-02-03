<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medical_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');

            // GENERAL HEALTH
            $table->enum('good_health', ['YES', 'NO']);
            $table->string('good_health_details')->nullable();

            $table->date('medical_exam_date')->nullable();

            $table->enum('under_treatment', ['YES', 'NO']);
            $table->string('treatment_details')->nullable();

            $table->enum('hospitalized', ['YES', 'NO']);
            $table->string('hospital_details')->nullable();

            // ALLERGIES
            $table->enum('allergy_medicine', ['YES', 'NO']);
            $table->enum('allergy_food', ['YES', 'NO']);
            $table->string('allergy_others')->nullable();

            // MEDICATION
            $table->enum('medication', ['YES', 'NO']);
            $table->string('medication_details')->nullable();

            // WOMEN
            $table->enum('pregnant', ['YES', 'NO']);
            $table->enum('nursing', ['YES', 'NO']);
            $table->enum('birth_control', ['YES', 'NO']);

            // TOBACCO
            $table->enum('tobacco_use', ['YES', 'NO']);
            $table->string('tobacco_per_day')->nullable();
            $table->string('tobacco_per_week')->nullable();

            // SYMPTOMS
            $table->enum('headaches', ['YES', 'NO']);
            $table->enum('earaches', ['YES', 'NO']);
            $table->enum('neck_aches', ['YES', 'NO']);

            // EMERGENCY CONTACT
            $table->string('emergency_person', 100);
            $table->string('emergency_number', 20);
            $table->string('emergency_relation', 50);

            $table->string('patient_signature')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_histories');
    }
};
