<?php

use Database\Seeders\DivisiKompetensiUserSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Buat akun login untuk tiap Divisi (4) & tiap Kompetensi Keahlian (6)
     * supaya masing-masing bisa login sendiri dengan data ter-scope otomatis.
     * Dijalankan via `php artisan migrate` / migrate.php karena server
     * tidak bisa `php artisan db:seed`.
     */
    public function up(): void
    {
        (new DivisiKompetensiUserSeeder())->run();
    }

    public function down(): void
    {
        // Tidak dihapus otomatis - hapus manual via /admin/users bila perlu.
    }
};
