<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PrestasiSiswa extends Model
{
    protected $table = 'prestasi_siswas';

    protected $fillable = [
        'nama_siswa', 'judul_kegiatan', 'bulan_tahun', 'lokasi',
        'peringkat', 'tingkat', 'tahun_ajaran', 'display_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
