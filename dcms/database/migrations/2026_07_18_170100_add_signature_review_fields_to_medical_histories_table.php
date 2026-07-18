<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medical_histories', function (Blueprint $table) {
            $table->string('signature_review_status', 30)->default('verified')->after('patient_signature');
            $table->text('signature_review_notes')->nullable()->after('signature_review_status');
            $table->string('signature_ai_provider', 50)->nullable()->after('signature_review_notes');
            $table->decimal('signature_ai_confidence', 5, 4)->nullable()->after('signature_ai_provider');
        });
    }

    public function down(): void
    {
        Schema::table('medical_histories', function (Blueprint $table) {
            $table->dropColumn([
                'signature_review_status',
                'signature_review_notes',
                'signature_ai_provider',
                'signature_ai_confidence',
            ]);
        });
    }
};
