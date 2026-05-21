<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilVisiMisi extends Model
{
    protected $table = 'profil_visi_misi';

    protected $fillable = ['visi', 'misi', 'tujuan'];

    protected $casts = [
        'misi'   => 'array',
        'tujuan' => 'array',
    ];

    public static function instance(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
