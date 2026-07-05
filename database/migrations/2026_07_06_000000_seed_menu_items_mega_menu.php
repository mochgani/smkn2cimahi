<?php

use App\Models\MenuItem;
use Database\Seeders\MenuItemsSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Data migration — jalankan seeder menu mega-menu via `php artisan migrate`
     * (dipakai karena `db:seed` tidak bisa dijalankan di server/cPanel).
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
