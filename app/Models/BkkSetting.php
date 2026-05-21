<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BkkSetting extends Model
{
    protected $table = 'bkk_settings';

    protected $fillable = ['about', 'tujuan', 'perusahaan'];

    protected $casts = [
        'tujuan'     => 'array',
        'perusahaan' => 'array',
    ];

    public static function instance(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
