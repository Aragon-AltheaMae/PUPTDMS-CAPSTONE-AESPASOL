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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            $table->string('actor_role'); // admin / dentist / patient
            $table->string('actor_identifier')->nullable(); // email or id
            $table->string('action'); // login, create_appointment etc
            $table->string('module'); // appointments, inventory etc
            $table->text('description')->nullable();

            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
