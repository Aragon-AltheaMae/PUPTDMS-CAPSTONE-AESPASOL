<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dental_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');

            $table->enum('bleeding_gums', ['Yes','No'])->nullable();
            $table->enum('sensitive_temp', ['Yes','No'])->nullable();
            $table->enum('sensitive_taste', ['Yes','No'])->nullable();
            $table->enum('tooth_pain', ['Yes','No'])->nullable();
            $table->enum('sores', ['Yes','No'])->nullable();
            $table->enum('injuries', ['Yes','No'])->nullable();

            $table->enum('clicking', ['Yes','No'])->nullable();
            $table->enum('joint_pain', ['Yes','No'])->nullable();
            $table->enum('difficulty_moving', ['Yes','No'])->nullable();
            $table->enum('difficulty_chewing', ['Yes','No'])->nullable();
            $table->enum('headaches', ['Yes','No'])->nullable();
            $table->enum('clench_grind', ['Yes','No'])->nullable();
            $table->enum('biting', ['Yes','No'])->nullable();
            $table->enum('teeth_loosening', ['Yes','No'])->nullable();
            $table->enum('food_teeth', ['Yes','No'])->nullable();
            $table->enum('med_reaction', ['Yes','No'])->nullable();

            $table->enum('periodontal', ['Yes','No'])->nullable();
            $table->enum('difficult_extraction', ['Yes','No'])->nullable();
            $table->enum('dentures', ['Yes','No'])->nullable();
            $table->enum('ortho_treatment', ['Yes','No'])->nullable();

            $table->text('additional_concerns')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dental_histories');
    }
};
