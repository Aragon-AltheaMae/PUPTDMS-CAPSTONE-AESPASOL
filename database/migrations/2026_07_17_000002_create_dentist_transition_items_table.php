<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('dentist_transition_items')) {
            return;
        }

        Schema::create('dentist_transition_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dentist_transition_id')->constrained('dentist_transitions')->cascadeOnDelete();
            $table->string('item_type', 50);
            $table->unsignedBigInteger('record_id');
            $table->foreignId('patient_id')->nullable()->constrained('patients')->nullOnDelete();
            $table->foreignId('original_dentist_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('successor_dentist_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('transfer_status', 40)->default('pending');
            $table->boolean('is_critical')->default(false);
            $table->string('resolution_type', 40)->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('transferred_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('transferred_at')->nullable();
            $table->timestamps();

            $table->unique(['dentist_transition_id', 'item_type', 'record_id'], 'dentist_transition_items_unique_record');
            $table->index(['dentist_transition_id', 'transfer_status'],
                            'dti_transition_status_idx'
                        );
            $table->index(['item_type', 'record_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dentist_transition_items');
    }
};
