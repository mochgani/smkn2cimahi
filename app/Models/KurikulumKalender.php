<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KurikulumKalender extends Model
{
    protected $table = 'kurikulum_kalender';

    protected $fillable = [
        'title', 'calendar_id', 'lead', 'embed_url', 'public_url', 'catatan',
    ];

    public static function instance(): static
    {
        return static::firstOrCreate(['id' => 1], [
            'title'  => 'Kalender Akademik',
            'lead'   => 'Jadwal kegiatan akademik, ujian, dan agenda resmi SMKN 2 Cimahi.',
            'catatan' => 'Jadwal dapat berubah sewaktu-waktu. Perubahan akan diumumkan melalui papan pengumuman sekolah dan media resmi SMKN 2 Cimahi.',
        ]);
    }
}
