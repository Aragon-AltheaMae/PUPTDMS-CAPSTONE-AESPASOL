<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_service_logs', function (Blueprint $table) {
            $table->id();
            $table->string('feature', 50);
            $table->string('provider', 50)->nullable();
            $table->string('status', 20);
            $table->string('mode', 20)->nullable();
            $table->text('message')->nullable();
            $table->json('context')->nullable();
            $table->timestamp('happened_at');

            $table->index(['feature', 'status']);
            $table->index('happened_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_service_logs');
    }
};
