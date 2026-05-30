<?php

namespace App\Models;

use App\Models\User;
use App\Support\HtmlSanitizer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $fillable = [
        'slug', 'title', 'excerpt', 'content', 'cover_image',
        'tags', 'reading_time_minutes', 'is_featured', 'is_published',
        'published_at', 'author_id', 'created_by', 'kompetensi_id', 'divisi_id',
        'approval_status', 'approved_by', 'approved_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'approved_at'  => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Berita $berita) {
            $berita->slug ??= Str::slug($berita->title);
        });
    }

    /**
     * Auto-sanitize HTML content saat disimpan ke DB.
     * Mencegah XSS dari RichEditor.
     */
    protected function content(): Attribute
    {
        return Attribute::set(fn ($value) => HtmlSanitizer::sanitize($value));
    }

    public function kategoris(): BelongsToMany
    {
        return $this->belongsToMany(Kategori::class, 'berita_kategori');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function kompetensi(): BelongsTo
    {
        return $this->belongsTo(Kompetensi::class);
    }

    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where('published_at', '<=', now())
            ->where('approval_status', 'approved');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }
}
