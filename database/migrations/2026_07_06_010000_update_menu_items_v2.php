<?php

use App\Models\MenuItem;
use Database\Seeders\MenuItemsSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Data migration — update struktur menu final: tambah Beranda, rename
     * beberapa label, tambah topbar (SPMB, Aplikasi, Agenda Kegiatan Sekolah,
     * Virtual Tour), hapus Kalender dari mega menu Kurikulum (dipindah ke topbar
     * agar tidak double). Dijalankan via `php artisan migrate` / migrate.php
     * karena server tidak bisa `db:seed`.
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
