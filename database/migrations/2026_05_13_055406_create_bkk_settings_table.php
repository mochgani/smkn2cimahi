<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bkk_settings', function (Blueprint $table) {
            $table->id();
            $table->longText('about')->nullable();
            $table->json('tujuan')->nullable();
            $table->json('perusahaan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bkk_settings');
    }
};
