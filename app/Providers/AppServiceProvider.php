<?php

namespace App\Providers;

use App\Models\Kompetensi;
use App\Models\KontakSetting;
use App\Models\MenuItem;
use App\Models\SchoolSetting;
use App\Observers\SharedCacheObserver;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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

        // Rate limiters
        $this->configureRateLimiters();

        // Default password rules untuk seluruh aplikasi
        Password::defaults(function () {
            $rule = Password::min(8);
            return app()->isProduction()
                ? $rule->mixedCase()->numbers()->uncompromised()
                : $rule;
        });
    }

    /**
     * Konfigurasi rate limiter global.
     */
    private function configureRateLimiters(): void
    {
        // Web — 120 request/menit per IP (longgar untuk normal browsing)
        RateLimiter::for('web', fn (Request $request) =>
            Limit::perMinute(120)->by($request->ip())
        );

        // Login attempt (admin Filament) — 5/menit per email+ip, lalu blokir
        RateLimiter::for('login', fn (Request $request) =>
            Limit::perMinute(5)->by($request->input('email').$request->ip())
        );

        // API/AJAX endpoint — 60/menit per user/ip
        RateLimiter::for('api', fn (Request $request) =>
            Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip())
        );
    }
}
