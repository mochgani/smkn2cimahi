<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontakSetting extends Model
{
    protected $table = 'kontak_settings';

    protected $fillable = [
        'maps_embed_url',
        'maps_address_short',
        'maps_address_full',
        'kanal',
        'bagian',
        'social',
    ];

    protected $casts = [
        'kanal'  => 'array',
        'bagian' => 'array',
        'social' => 'array',
    ];

    public static function instance(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
