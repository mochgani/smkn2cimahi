<?php

use App\Models\KontakSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;

return new class extends Migration
{
    /**
     * Ganti semua nomor telepon/WhatsApp yang tampil di web (kanal Telepon
     * & WhatsApp di halaman Kontak) dengan nomor baru: 082298968928.
     */
    public function up(): void
    {
        $setting = KontakSetting::instance();
        $kanal = collect($setting->kanal)->map(function (array $item) {
            if ($item['label'] === 'TELEPON') {
                $item['value'] = '+62 822 9896 8928';
                $item['href']  = 'tel:+6282298968928';
            }
            if ($item['label'] === 'WHATSAPP') {
                $item['value'] = '+62 822 9896 8928';
                $item['href']  = 'https://wa.me/6282298968928';
            }
            return $item;
        })->all();

        $setting->update(['kanal' => $kanal]);

        Cache::forget('shared.kontak_setting');
    }

    public function down(): void
    {
        // Nomor lama tidak disimpan, tidak ada rollback.
    }
};
