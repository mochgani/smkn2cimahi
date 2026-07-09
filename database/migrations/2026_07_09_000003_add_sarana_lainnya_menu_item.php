<?php

use Database\Seeders\MenuItemsSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Tambah sub-menu ke-3 "Sarana Prasarana Lainnya" di bawah menu
     * "Sarana dan Prasarana".
     */
    public function up(): void
    {
        (new MenuItemsSeeder())->run();
    }

    public function down(): void
    {
        // Tidak ada rollback spesifik — jalankan ulang MenuItemsSeeder versi lama bila perlu.
    }
};
