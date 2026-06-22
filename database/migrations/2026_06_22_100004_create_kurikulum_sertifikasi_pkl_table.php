<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kurikulum_sertifikasi_pkl', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Sertifikasi & PKL');
            $table->text('lead')->nullable();
            $table->json('sertifikasi')->nullable();
            $table->text('pkl_deskripsi')->nullable();
            $table->string('pkl_durasi')->default('6 bulan');
            $table->string('pkl_min_nilai')->default('75');
            $table->json('alur_pkl')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kurikulum_sertifikasi_pkl');
    }
};
