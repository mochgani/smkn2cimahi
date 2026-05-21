<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Kategori extends Model
{
    protected $table = 'kategoris';

    protected $fillable = ['name', 'slug', 'color'];

    protected static function booted(): void
    {
        static::creating(function (Kategori $kategori) {
            $kategori->slug ??= Str::slug($kategori->name);
        });
    }

    public function beritas(): BelongsToMany
    {
        return $this->belongsToMany(Berita::class, 'berita_kategori');
    }
}
