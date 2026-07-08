<?php

use App\Models\KurikulumKalender;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Set embed Google Calendar untuk halaman /kurikulum/kalender.
     * Calendar ID dari user (2026-07-08). Kalender harus di-set "Public"
     * di Google Calendar (Settings > Access permissions > Make available
     * to public) supaya iframe ini bisa menampilkan datanya — kalau belum
     * public, embed akan menampilkan pesan error "not shared".
     */
    public function up(): void
    {
        $calendarId = 'c_fed03d15daff6f120c2355b49e8128b4a0a0d93d0d5956113d3d7be68cddf9b0@group.calendar.google.com';
        $encodedId  = rawurlencode($calendarId);

        KurikulumKalender::instance()->update([
            'embed_url'  => "https://calendar.google.com/calendar/embed?src={$encodedId}&ctz=Asia%2FJakarta",
            'public_url' => "https://calendar.google.com/calendar/embed?src={$encodedId}&ctz=Asia%2FJakarta",
        ]);
    }

    public function down(): void
    {
        KurikulumKalender::instance()->update([
            'embed_url'  => null,
            'public_url' => null,
        ]);
    }
};
