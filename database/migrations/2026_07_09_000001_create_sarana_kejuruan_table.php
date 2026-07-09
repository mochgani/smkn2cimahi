<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sarana_kejuruan', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Sarana Pembelajaran Kejuruan');
            $table->text('lead')->nullable();
            $table->json('groups')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sarana_kejuruan');
    }
};
