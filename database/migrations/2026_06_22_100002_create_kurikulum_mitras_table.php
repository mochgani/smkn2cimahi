<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kurikulum_mitras', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('field');             // program keahlian terkait
            $table->string('nama');              // nama perusahaan
            $table->text('desc')->nullable();
            $table->json('tags')->nullable();    // ['Penyelarasan kurikulum', 'Guru tamu', ...]
            $table->unsignedSmallInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kurikulum_mitras');
    }
};
