<?php

use App\Models\KurikulumKalender;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        KurikulumKalender::instance()->update([
            'api_key' => 'AIzaSyBETMKmjnFubpgiCjJrCULcEu3zAe6SnXw',
        ]);
    }

    public function down(): void
    {
        KurikulumKalender::instance()->update(['api_key' => null]);
    }
};
