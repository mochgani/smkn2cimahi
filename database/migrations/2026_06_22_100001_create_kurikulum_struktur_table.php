<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kurikulum_struktur', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Struktur Kurikulum');
            $table->text('lead')->nullable();
            $table->json('phases')->nullable();     // [{step, kelas, title, desc}]
            $table->json('groups')->nullable();     // [{title, desc}]
            $table->json('allocation')->nullable(); // [{kelompok, mata_pelajaran, alokasi}]
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kurikulum_struktur');
    }
};
