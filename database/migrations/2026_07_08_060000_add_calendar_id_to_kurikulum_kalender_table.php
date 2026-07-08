<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kurikulum_kalender', function (Blueprint $table) {
            $table->string('calendar_id')->nullable()->after('title');
        });
    }

    public function down(): void
    {
        Schema::table('kurikulum_kalender', function (Blueprint $table) {
            $table->dropColumn('calendar_id');
        });
    }
};
