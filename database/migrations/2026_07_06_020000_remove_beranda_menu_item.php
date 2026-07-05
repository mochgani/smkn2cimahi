<?php

use App\Models\MenuItem;
use Database\Seeders\MenuItemsSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Hapus item menu "Beranda" — logo di header sudah link ke halaman utama,
     * tombol "Beranda" terpisah tidak diperlukan (redundant).
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
