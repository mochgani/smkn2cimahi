<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_sejarah', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Sejarah SMK Negeri 2 Cimahi');
            $table->text('lead')->nullable();
            $table->longText('content')->nullable();
            $table->string('image')->nullable();
            $table->string('tahun_berdiri')->nullable();
            $table->string('luas_lahan')->nullable();
            $table->string('video_youtube_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_sejarah');
    }
};
