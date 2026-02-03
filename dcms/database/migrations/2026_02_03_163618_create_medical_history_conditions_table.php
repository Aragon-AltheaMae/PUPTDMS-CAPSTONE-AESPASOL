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
        Schema::create('medical_history_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_history_id')
                ->constrained()
                ->onDelete('cascade');

            $table->boolean('aids_hiv')->default(false);
            $table->boolean('fainting')->default(false);
            $table->boolean('alcohol_dependency')->default(false);
            $table->boolean('high_low_bp')->default(false);
            $table->boolean('arthritis')->default(false);
            $table->boolean('hyper_hypoglycemia')->default(false);
            $table->boolean('artificial_joints')->default(false);
            $table->boolean('kidney_disease')->default(false);
            $table->boolean('asthma')->default(false);
            $table->boolean('liver_disease')->default(false);
            $table->boolean('blood_transfusion')->default(false);
            $table->boolean('mental_disorder')->default(false);
            $table->boolean('cancer')->default(false);
            $table->boolean('stomach_ulcers')->default(false);
            $table->boolean('diabetes')->default(false);
            $table->boolean('stroke')->default(false);
            $table->boolean('eating_disorders')->default(false);
            $table->boolean('tuberculosis')->default(false);
            $table->boolean('epilepsy')->default(false);
            $table->boolean('venereal_disease')->default(false);

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_history_conditions');
    }
};
