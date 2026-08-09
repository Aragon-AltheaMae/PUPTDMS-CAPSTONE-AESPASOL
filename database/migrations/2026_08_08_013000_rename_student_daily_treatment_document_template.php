<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('document_templates')
            ->where('code', 'DTR-DEFAULT')
            ->update([
                'name' => 'Daily Treatment Record - Student',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('document_templates')
            ->where('code', 'DTR-DEFAULT')
            ->update([
                'name' => 'Daily Treatment Record',
                'updated_at' => now(),
            ]);
    }
};
