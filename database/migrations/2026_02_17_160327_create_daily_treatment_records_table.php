<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('daily_treatment_records', function (Blueprint $table) {
            $table->id();

            $table->date('treatment_date');

            $table->string('patient_name', 150);
            $table->string('patient_email', 190)->nullable();
            $table->string('patient_phone', 30)->nullable();

            $table->enum('office_type', ['Administrative', 'Faculty', 'Dependent'])->nullable();
            $table->string('program_code', 50)->nullable(); 

            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();

            $table->string('treatment_done', 150);
            $table->unsignedSmallInteger('minutes_processed')->default(0);

            $table->boolean('has_signature')->default(false);
            $table->string('signature_path')->nullable(); // if you store a file later

            $table->timestamps();

            // Indexes for fast filtering/search/sort
            $table->index('treatment_date');
            $table->index('office_type');
            $table->index('program_code');
            $table->index('patient_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_treatment_records');
    }
};
