<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kurikulum_teaching_factory', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Teaching Factory');
            $table->text('lead')->nullable();
            $table->string('tagline')->nullable();
            $table->longText('about')->nullable();
            $table->json('produk')->nullable();
            $table->json('fasilitas')->nullable();
            $table->json('stats')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kurikulum_teaching_factory');
    }
};
