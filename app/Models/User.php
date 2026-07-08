<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'kompetensi_id', 'divisi_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasAnyRole(['super_admin', 'kompetensi', 'divisi', 'manajemen_mutu', 'kepala_sekolah']);
    }

    public function kompetensi(): BelongsTo
    {
        return $this->belongsTo(Kompetensi::class);
    }

    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    public function isManajemenMutu(): bool
    {
        return $this->hasRole('manajemen_mutu');
    }

    public function isKepalaSekolah(): bool
    {
        return $this->hasRole('kepala_sekolah');
    }

    /**
     * User divisi dengan slug divisi tertentu (mis. 'kurikulum').
     * Dipakai untuk gating resource khusus satu divisi, di luar scope
     * berita biasa (yang sudah otomatis ter-scope via divisi_id).
     */
    public function isDivisi(string $slug): bool
    {
        return $this->hasRole('divisi') && $this->divisi?->slug === $slug;
    }
}
