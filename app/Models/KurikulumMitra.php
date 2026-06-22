<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KurikulumMitra extends Model
{
    protected $table = 'kurikulum_mitras';

    protected $fillable = [
        'logo', 'field', 'nama', 'desc', 'tags',
        'display_order', 'is_active',
    ];

    protected $casts = [
        'tags'      => 'array',
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
