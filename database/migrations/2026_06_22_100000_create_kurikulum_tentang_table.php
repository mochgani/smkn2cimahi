<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kurikulum_tentang', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Kurikulum SMK Negeri 2 Cimahi');
            $table->text('lead')->nullable();
            $table->string('kurikulum_nama')->default('Merdeka');
            $table->string('pendekatan')->default('Link & Match');
            $table->string('porsi_praktik')->default('70%');
            $table->string('jumlah_mitra')->default('20+');
            $table->json('stats')->nullable();     // [{num, em, cap, desc}]
            $table->json('filosofi')->nullable();  // [{num, title, desc}]
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kurikulum_tentang');
    }
};
