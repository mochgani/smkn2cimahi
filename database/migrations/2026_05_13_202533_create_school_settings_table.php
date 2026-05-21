<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('school_settings', function (Blueprint $table) {
            $table->id();
            $table->string('school_name')->default('SMK Negeri 2 Cimahi');
            $table->string('tagline')->default('BMW: Bekerja · Melanjutkan · Wirausaha');
            $table->string('logo')->nullable();
            $table->string('tahun_berdiri')->default('2007');
            $table->string('nss')->default('401026802002');
            $table->string('npsn')->default('20224389');
            $table->string('copyright')->default('© 2026 SMK NEGERI 2 CIMAHI');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_settings');
    }
};
