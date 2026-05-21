<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilSejarah extends Model
{
    protected $table = 'profil_sejarah';

    protected $fillable = [
        'title', 'lead', 'content', 'image',
        'tahun_berdiri', 'luas_lahan', 'video_youtube_url',
    ];

    public static function instance(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'title' => 'Sejarah SMK Negeri 2 Cimahi',
        ]);
    }
}
