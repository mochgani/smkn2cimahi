<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilKepalaSekolah extends Model
{
    protected $table = 'profil_kepala_sekolah';

    protected $fillable = ['nama', 'nip', 'jabatan', 'foto', 'sambutan'];

    public static function instance(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'nama'    => 'Kepala Sekolah',
            'jabatan' => 'Kepala Sekolah',
        ]);
    }
}
