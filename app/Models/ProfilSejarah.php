<?php

namespace App\Models;

use App\Support\HtmlSanitizer;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    /**
     * Auto-sanitize HTML content saat disimpan ke DB.
     */
    protected function content(): Attribute
    {
        return Attribute::set(fn ($value) => HtmlSanitizer::sanitize($value));
    }
}
