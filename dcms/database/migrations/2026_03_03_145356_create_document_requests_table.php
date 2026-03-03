<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('document_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')
                ->constrained('patients')
                ->onDelete('cascade');

            $table->string('document_type', 100);
            $table->string('purpose', 150);

            $table->date('request_date');
            $table->time('request_time');

            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_requests');
    }
};
