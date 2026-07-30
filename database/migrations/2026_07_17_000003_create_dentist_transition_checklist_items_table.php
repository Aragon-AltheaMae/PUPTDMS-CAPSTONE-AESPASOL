<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('dentist_transition_checklist_items')) {
            return;
        }

        Schema::create('dentist_transition_checklist_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dentist_transition_id')->constrained('dentist_transitions')->cascadeOnDelete();
            $table->string('checklist_key', 80);
            $table->string('label', 160);
            $table->boolean('is_required')->default(true);
            $table->boolean('is_completed')->default(false);
            $table->text('remarks')->nullable();
            $table->foreignId('completed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['dentist_transition_id', 'checklist_key'], 'dentist_transition_checklist_unique_key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dentist_transition_checklist_items');
    }
};
