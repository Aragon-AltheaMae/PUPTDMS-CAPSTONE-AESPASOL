<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dental_service_records', function (Blueprint $table) {
            $table->id();

            // user who encoded/ the record 
            $table->foreignId('created_by')->constrained('patients')->cascadeOnDelete();

            // date + time
            $table->dateTime('time_in');
            $table->dateTime('time_out')->nullable();

            // patient identity
            $table->string('patient_last_name');
            $table->string('patient_first_name');
            $table->string('patient_middle_name')->nullable();

            $table->unsignedTinyInteger('age')->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();

            // GAD priority
            $table->boolean('is_senior')->default(false);
            $table->boolean('is_pwd')->default(false);

            // contact
            $table->string('email')->nullable();
            $table->string('contact')->nullable();

            // Emergency / Non-Emergency
            $table->enum('visit_type', ['Emergency', 'Non-Emergency'])->nullable();

            // Student/Faculty/Administrative/Dependent
            $table->enum('department', ['Student', 'Faculty', 'Administrative', 'Dependent'])->nullable();

            // student-specific fields (nullable)
            $table->string('program_code')->nullable();            // e.g. BSIT
            $table->unsignedTinyInteger('year_level')->nullable(); // 1..4
            $table->string('section')->nullable();                 // e.g. 1, 2

            // Signature column in UI (✔)
            $table->boolean('has_signature')->default(false);
            $table->string('signature_path')->nullable();

            $table->timestamps();

            // indexes for faster filtering
            $table->index('time_in');
            $table->index('department');
            $table->index(['program_code', 'year_level', 'section']);
            $table->index(['gender', 'is_pwd', 'is_senior']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dental_service_records');
    }
};
