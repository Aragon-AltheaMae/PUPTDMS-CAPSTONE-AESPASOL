<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinic_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('days_label');                 
            $table->json('days');                         
            $table->enum('status', ['open', 'closed', 'limited'])->default('open');
            $table->time('open_time')->nullable();        
            $table->time('close_time')->nullable();      
            $table->string('break_time')->nullable();      
            $table->unsignedSmallInteger('max_slots')->default(5);
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('blocked_dates', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->string('reason')->default('Other');   
            $table->string('note')->nullable();
            $table->foreignId('created_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blocked_dates');
        Schema::dropIfExists('clinic_schedules');
    }
};