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
    Schema::create('dental_histories', function (Blueprint $table) {
        $table->id();
        $table->foreignId('appointment_id')->constrained()->onDelete('cascade');

            // Basic info
        $table->date('last_dental_visit')->nullable();
        $table->string('previous_dentist', 100)->nullable();

            // YES / NO (ENUM)
        $table->enum('bleeding_gums', ['YES', 'NO'])->default('NO');
        $table->enum('sensitive_temp', ['YES', 'NO'])->default('NO');
        $table->enum('sensitive_taste', ['YES', 'NO'])->default('NO');
        $table->enum('tooth_pain', ['YES', 'NO'])->default('NO');
        $table->enum('sores', ['YES', 'NO'])->default('NO');
        $table->enum('injuries', ['YES', 'NO'])->default('NO');

        $table->enum('clicking', ['YES', 'NO'])->default('NO');
        $table->enum('joint_pain', ['YES', 'NO'])->default('NO');
        $table->enum('difficulty_moving', ['YES', 'NO'])->default('NO');
        $table->enum('difficulty_chewing', ['YES', 'NO'])->default('NO');
        $table->enum('jaw_headaches', ['YES', 'NO'])->default('NO');
        $table->enum('clench_grind', ['YES', 'NO'])->default('NO');
        $table->enum('biting', ['YES', 'NO'])->default('NO');
        $table->enum('teeth_loosening', ['YES', 'NO'])->default('NO');
        $table->enum('food_teeth', ['YES', 'NO'])->default('NO');
        $table->enum('med_reaction', ['YES', 'NO'])->default('NO');

        $table->enum('periodontal', ['YES', 'NO'])->default('NO');
        $table->enum('difficult_extraction', ['YES', 'NO'])->default('NO');
        $table->enum('prolonged_bleeding', ['YES', 'NO'])->default('NO');
        $table->enum('dentures', ['YES', 'NO'])->default('NO');
        $table->enum('ortho_treatment', ['YES', 'NO'])->default('NO');

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

