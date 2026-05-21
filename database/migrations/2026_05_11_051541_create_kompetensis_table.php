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
        Schema::create('kompetensis', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('code', 5);
            $table->string('name');
            $table->string('tag');
            $table->string('short_desc');
            $table->text('lead');
            $table->longText('about');
            $table->json('sections');
            $table->string('cta_label');
            $table->string('cta_title');
            $table->text('cta_text');
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kompetensis');
    }
};
