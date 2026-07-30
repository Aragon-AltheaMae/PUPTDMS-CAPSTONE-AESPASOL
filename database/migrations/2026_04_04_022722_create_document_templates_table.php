<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_templates', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('code')->unique()->nullable();
            $table->string('document_type');
            $table->string('category')->nullable();

            $table->enum('engine', ['html', 'docx'])->default('html');

            $table->enum('output_format', ['pdf', 'docx', 'html'])->default('pdf');

            // ✅ NEW (header/body/footer separation)
            $table->longText('header_content')->nullable();
            $table->longText('content'); // body
            $table->longText('footer_content')->nullable();

            $table->string('paper_size')->default('A4');
            $table->enum('orientation', ['portrait', 'landscape'])->default('portrait');

            $table->enum('status', ['draft', 'active', 'archived'])->default('draft');
            $table->boolean('is_default')->default(false);
            $table->unsignedInteger('version')->default(1);

            $table->text('notes')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('document_type');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_templates');
    }
};