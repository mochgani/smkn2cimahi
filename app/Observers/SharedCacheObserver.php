<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Observer untuk auto-invalidate cache shared di middleware
 * setiap kali ada perubahan data dari admin (create/update/delete).
 *
 * Daftarkan observer ini di AppServiceProvider::boot() untuk model:
 * - KontakSetting → flush 'shared.kontak_setting'
 * - SchoolSetting → flush 'shared.school_setting'
 * - MenuItem, Kompetensi → flush 'shared.navigation'
 */
class SharedCacheObserver
{
    public function __construct(private readonly array $cacheKeys)
    {
    }

    public function saved(Model $model): void
    {
        $this->flush();
    }

    public function deleted(Model $model): void
    {
        $this->flush();
    }

    private function flush(): void
    {
        foreach ($this->cacheKeys as $key) {
            Cache::forget($key);
        }
    }
}
