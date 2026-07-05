<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestasi_siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_siswa');
            $table->string('judul_kegiatan');
            $table->string('bulan_tahun')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('peringkat')->nullable();
            $table->enum('tingkat', ['Nasional', 'Provinsi', 'Kota'])->default('Kota');
            $table->string('tahun_ajaran');
            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['tahun_ajaran', 'tingkat']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasi_siswas');
    }
};
