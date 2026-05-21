<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kontak_settings', function (Blueprint $table) {
            $table->id();
            $table->text('maps_embed_url')->nullable();
            $table->string('maps_address_short')->nullable();
            $table->text('maps_address_full')->nullable();
            $table->json('kanal')->nullable();
            $table->json('bagian')->nullable();
            $table->json('social')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontak_settings');
    }
};
