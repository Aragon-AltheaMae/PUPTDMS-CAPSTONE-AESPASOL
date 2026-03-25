<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('backups', function (Blueprint $table) {
            $table->id();
            $table->string('backup_id')->unique();
            $table->enum('type', ['full', 'incremental'])->default('full');
            $table->bigInteger('size_bytes')->default(0);
            $table->string('file_path')->nullable();
            $table->enum('status', ['completed', 'failed', 'in_progress'])->default('completed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backups');
    }
};