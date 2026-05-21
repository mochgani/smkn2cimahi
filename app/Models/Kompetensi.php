<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Kompetensi extends Model
{
    protected $fillable = [
        'slug', 'code', 'name', 'tag', 'short_desc', 'lead',
        'about', 'sections', 'cta_label', 'cta_title', 'cta_text',
        'logo_image', 'gallery',
        'display_order', 'is_active',
    ];

    protected $casts = [
        'sections'  => 'array',
        'gallery'   => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
