<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_template_fields', function (Blueprint $table) {
            $table->id();
            $table->string('document_type');
            $table->string('field_key');
            $table->string('label');
            $table->string('sample_value')->nullable();
            $table->string('source_table')->nullable();
            $table->string('source_column')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['document_type', 'field_key']);
            $table->index('document_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_template_fields');
    }
};