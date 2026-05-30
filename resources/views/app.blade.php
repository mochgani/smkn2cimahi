<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', 'SMKN 2 Cimahi') }}</title>

        {{-- Default SEO meta (akan di-override per page lewat <SeoTag />) --}}
        <meta name="description" content="Website resmi SMK Negeri 2 Cimahi — Sekolah Menengah Kejuruan Negeri di Kota Cimahi. BMW: Bekerja, Melanjutkan, Wirausaha.">
        <meta name="robots" content="index, follow">
        <meta name="author" content="SMK Negeri 2 Cimahi">
        <meta name="theme-color" content="#0d6e3f">

        {{-- Favicon set --}}
        <link rel="icon" type="image/png" href="/images/logo.png">
        <link rel="apple-touch-icon" href="/images/logo.png">
        <link rel="manifest" href="/manifest.json">

        {{-- Font preconnect (hint browser untuk DNS+TLS early) --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        {{-- Preload font CSS (critical resource) --}}
        <link
            rel="preload"
            as="style"
            href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap"
        >
        <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap"
        >

        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
