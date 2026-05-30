<?php

namespace App\Models;

use App\Support\HtmlSanitizer;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    /**
     * Auto-sanitize HTML sambutan saat disimpan ke DB.
     */
    protected function sambutan(): Attribute
    {
        return Attribute::set(fn ($value) => HtmlSanitizer::sanitize($value));
    }
}
