<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolSetting extends Model
{
    protected $fillable = [
        'school_name',
        'tagline',
        'logo',
        'tahun_berdiri',
        'nss',
        'npsn',
        'copyright',
    ];

    public static function instance(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'school_name'   => 'SMK Negeri 2 Cimahi',
            'tagline'       => 'BMW: Bekerja · Melanjutkan · Wirausaha',
            'logo'          => null,
            'tahun_berdiri' => '2007',
            'nss'           => '401026802002',
            'npsn'          => '20224389',
            'copyright'     => '© 2026 SMK NEGERI 2 CIMAHI',
        ]);
    }
}
