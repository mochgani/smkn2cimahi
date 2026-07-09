<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
            'throttle:web',
        ]);

        // Percaya proxy Cloudflare/cPanel di depan aplikasi, agar Laravel
        // membaca scheme (https) & host asli dari header X-Forwarded-*.
        // Tanpa ini, request()->hasValidSignature() gagal untuk signed URL
        // (mis. upload file Livewire) karena scheme yang terdeteksi saat
        // validasi (http) beda dengan saat signed URL dibuat (https, via
        // URL::forceScheme di AppServiceProvider) — signature jadi mismatch.
        $middleware->trustProxies(
            at: '*',
            headers: Request::HEADER_X_FORWARDED_FOR
                | Request::HEADER_X_FORWARDED_HOST
                | Request::HEADER_X_FORWARDED_PORT
                | Request::HEADER_X_FORWARDED_PROTO,
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Custom 404 page (Inertia) — render Vue page Errors/NotFound
        // saat ada NotFoundHttpException (route tidak ada / firstOrFail miss).
        $exceptions->render(function (
            Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e,
            Illuminate\Http\Request $request
        ) {
            if (! $request->expectsJson() && ! config('app.debug')) {
                return Inertia\Inertia::render('Errors/NotFound')
                    ->toResponse($request)
                    ->setStatusCode(404);
            }
        });
    })->create();
