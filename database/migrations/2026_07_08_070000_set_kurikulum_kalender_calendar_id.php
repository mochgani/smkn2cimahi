<?php

use App\Models\KurikulumKalender;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        KurikulumKalender::instance()->update([
            'calendar_id' => 'c_fed03d15daff6f120c2355b49e8128b4a0a0d93d0d5956113d3d7be68cddf9b0@group.calendar.google.com',
        ]);
    }

    public function down(): void
    {
        KurikulumKalender::instance()->update(['calendar_id' => null]);
    }
};
