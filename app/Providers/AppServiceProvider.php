<?php

namespace App\Providers;

use App\Models\Kompetensi;
use App\Models\KontakSetting;
use App\Models\MenuItem;
use App\Models\SchoolSetting;
use App\Observers\SharedCacheObserver;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        // Force HTTPS untuk shared hosting cPanel yang pakai reverse proxy
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Auto-invalidate cache shared global saat data admin berubah
        KontakSetting::observe(new SharedCacheObserver(['shared.kontak_setting']));
        SchoolSetting::observe(new SharedCacheObserver(['shared.school_setting']));
        MenuItem::observe(new SharedCacheObserver(['shared.navigation']));
        Kompetensi::observe(new SharedCacheObserver(['shared.navigation']));
    }
}
