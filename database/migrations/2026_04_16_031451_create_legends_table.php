<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legends', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique(); // D, M, F, X, JC, etc.
            $table->string('description');
            $table->string('category')->nullable(); // Condition, Restoration, Surgery
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legends');
    }
};