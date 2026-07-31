<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('dentist_transitions')) {
            return;
        }

        Schema::create('dentist_transitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dentist_id')->constrained('users')->restrictOnDelete();
            $table->string('transition_type', 40);
            $table->foreignId('default_successor_dentist_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('last_working_date');
            $table->timestamp('access_ends_at');
            $table->string('status', 40)->default('draft');
            $table->text('handover_notes')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('initiated_by')->constrained('users')->restrictOnDelete();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();

            $table->index(['dentist_id', 'status']);
            $table->index(['default_successor_dentist_id']);
            $table->index(['transition_type', 'status']);
            $table->index(['access_ends_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dentist_transitions');
    }
};
