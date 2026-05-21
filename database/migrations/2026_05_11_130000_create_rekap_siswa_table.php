<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekap_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kompetensi_id')->constrained('kompetensis')->cascadeOnDelete();
            $table->enum('kelas', ['X', 'XI', 'XII']);
            $table->unsignedSmallInteger('rombel')->default(0);
            $table->unsignedSmallInteger('laki_laki')->default(0);
            $table->unsignedSmallInteger('perempuan')->default(0);
            $table->timestamps();

            $table->unique(['kompetensi_id', 'kelas']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekap_siswa');
    }
};
