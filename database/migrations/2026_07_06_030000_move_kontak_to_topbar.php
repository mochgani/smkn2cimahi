<?php

use App\Models\MenuItem;
use Database\Seeders\MenuItemsSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Pindahkan "Kontak" dari navbar ke topbar (posisi terakhir) supaya
     * menu utama lebih leluasa.
     */
    public function up(): void
    {
        (new MenuItemsSeeder())->run();
    }

    public function down(): void
    {
        MenuItem::query()->delete();
    }
};
