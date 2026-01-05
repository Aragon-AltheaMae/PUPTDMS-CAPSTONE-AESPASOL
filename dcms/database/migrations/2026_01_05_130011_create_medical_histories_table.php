<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('medical_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');

            $table->boolean('hypertension')->default(false);
            $table->boolean('diabetes')->default(false);
            $table->boolean('heart_condition')->default(false);

            $table->boolean('allergy')->default(false);
            $table->boolean('pregnant')->default(false);
            $table->boolean('nursing')->default(false);
            $table->boolean('birth_control')->default(false);

            $table->string('emergency_person', 100);
            $table->string('emergency_number', 20);
            $table->string('emergency_relation', 50);

            $table->string('patient_signature');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_histories');
    }
};
