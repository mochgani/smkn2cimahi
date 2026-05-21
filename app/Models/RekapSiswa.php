<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekapSiswa extends Model
{
    protected $table = 'rekap_siswa';

    protected $fillable = [
        'kompetensi_id',
        'kelas',
        'rombel',
        'laki_laki',
        'perempuan',
    ];

    protected $casts = [
        'rombel'     => 'integer',
        'laki_laki'  => 'integer',
        'perempuan'  => 'integer',
    ];

    public function kompetensi(): BelongsTo
    {
        return $this->belongsTo(Kompetensi::class);
    }

    public function getTotalAttribute(): int
    {
        return $this->laki_laki + $this->perempuan;
    }
}
