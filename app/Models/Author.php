<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    protected $fillable = ['name', 'initials', 'bio', 'email'];

    public function beritas(): HasMany
    {
        return $this->hasMany(Berita::class);
    }
}
