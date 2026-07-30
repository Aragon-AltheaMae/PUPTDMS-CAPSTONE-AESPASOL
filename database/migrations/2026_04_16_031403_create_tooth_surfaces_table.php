<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tooth_surfaces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tooth_id')->constrained('teeth')->onDelete('cascade');
            $table->unsignedTinyInteger('surface_number'); // 1 to 5
            $table->timestamps();

            $table->unique(['tooth_id', 'surface_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tooth_surfaces');
    }
};