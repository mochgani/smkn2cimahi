<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('kompetensi_id')
                ->nullable()
                ->after('email')
                ->constrained('kompetensis')
                ->nullOnDelete();

            $table->foreignId('divisi_id')
                ->nullable()
                ->after('kompetensi_id')
                ->constrained('divisis')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kompetensi_id']);
            $table->dropForeign(['divisi_id']);
            $table->dropColumn(['kompetensi_id', 'divisi_id']);
        });
    }
};
