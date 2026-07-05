<?php

use App\Models\PrestasiSiswa;
use Database\Seeders\PrestasiSiswaSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Seed data prestasi siswa (73 entri, hasil scrape dari web lama).
     * Dijalankan via `php artisan migrate` / migrate.php karena server
     * tidak bisa `php artisan db:seed`.
     */
    public function up(): void
    {
        (new PrestasiSiswaSeeder())->run();
    }

    public function down(): void
    {
        PrestasiSiswa::query()->delete();
    }
};
