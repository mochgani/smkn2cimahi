<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kurikulum_kalender', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Kalender Akademik');
            $table->text('lead')->nullable();
            $table->string('embed_url')->nullable();
            $table->string('public_url')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kurikulum_kalender');
    }
};
