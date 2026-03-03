<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
        $table->id();

        $table->foreignId('patient_id')
            ->constrained('patients')
            ->onDelete('cascade');

        $table->string('service_type', 100);
        $table->string('other_services', 50)->nullable();

        $table->date('appointment_date');
        $table->time('appointment_time');

        $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])
              ->default('pending');

        $table->unique(['patient_id', 'appointment_date', 'appointment_time']);

        $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
