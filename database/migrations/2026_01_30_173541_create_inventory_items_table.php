<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            
            $table->enum('category', ['Medicine', 'Supplies']);
            $table->date('date_received');
            $table->string('stock_no')->unique();
            $table->string('name');
            $table->string('unit');
            $table->unsignedInteger('qty');
            $table->unsignedInteger('used')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};

