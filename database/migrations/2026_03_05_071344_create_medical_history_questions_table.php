<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('medical_history_questions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 64)->unique();              
            $table->enum('type', ['bool', 'text', 'date'])->default('bool');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_history_questions');
    }
};