<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->date('birthdate')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->string('phone')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->date('birthdate')->nullable(false)->change();
            $table->enum('gender', ['Male', 'Female'])->nullable(false)->change();
            $table->string('phone')->nullable(false)->change();
        });
    }
};