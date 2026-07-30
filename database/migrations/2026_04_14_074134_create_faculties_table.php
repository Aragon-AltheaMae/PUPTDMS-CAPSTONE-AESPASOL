<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faculties', function (Blueprint $table) {
            $table->id();

            // Link to users table
            $table->unsignedBigInteger('user_id');

            // External system (FESR / FLSS) ID
            $table->unsignedBigInteger('fesr_user_id')->unique();

            // Faculty type (Full-Time, Part-Time, etc.)
            $table->unsignedBigInteger('faculty_type_id')->nullable();

            $table->timestamps();

            // Foreign key (optional but recommended)
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faculties');
    }
};