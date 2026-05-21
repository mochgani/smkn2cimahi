<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    protected $fillable = [
        'nama', 'email', 'telepon', 'topik', 'pesan',
        'is_read', 'is_replied', 'ip_address',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_replied' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Pesan $pesan) {
            $pesan->ip_address ??= request()->ip();
        });
    }
}
