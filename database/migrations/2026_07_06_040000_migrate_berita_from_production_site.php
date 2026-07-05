<?php

use App\Models\Berita;
use Database\Seeders\BeritaMigrasiSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Ganti data sample berita (20 artikel demo) dengan 34 artikel asli
     * hasil scrape dari https://smkn2cmi.sch.id/berita/ (2026-07-05).
     * Cover image sengaja kosong — akan diupload manual via admin per artikel.
     * Dijalankan via `php artisan migrate` / migrate.php karena server tidak
     * bisa `php artisan db:seed`.
     */
    public function up(): void
    {
        (new BeritaMigrasiSeeder())->run();
    }

    public function down(): void
    {
        DB::table('berita_kategori')->delete();
        Berita::query()->delete();
    }
};
