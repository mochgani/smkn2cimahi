# Fase 2: Setup Inertia.js + Vue 3

Estimasi: ~30 menit

## 1. Install Laravel Breeze dengan Inertia + Vue (Termudah)

Cara paling cepat: pakai Laravel Breeze yang sudah include Inertia + Vue 3:

```bash
composer require laravel/breeze --dev
php artisan breeze:install vue
```

Saat ditanya, pilih:
- **Stack**: Vue
- **Dark mode**: No (kita pakai light mode)
- **Test framework**: PHPUnit
- **TypeScript**: No (atau Yes jika mau)
- **SSR**: No (untuk simple, bisa diaktifkan nanti)

Breeze akan otomatis install:
- ✅ Inertia.js (server + client)
- ✅ Vue 3
- ✅ Tailwind CSS v3 (kita akan customize)
- ✅ Vite
- ✅ Login/Register pages (akan kita hapus)

## 2. Hapus Auth yang Tidak Diperlukan

Karena kita pakai Filament untuk admin, hapus auth Breeze:

```bash
# Hapus file auth views
rm -rf resources/js/Pages/Auth
rm -rf resources/js/Pages/Profile
rm -rf resources/js/Pages/Dashboard.vue
rm -rf resources/js/Pages/Welcome.vue
rm -rf resources/js/Components

# Hapus controllers auth (Filament akan handle login admin)
rm -rf app/Http/Controllers/Auth
rm -rf app/Http/Controllers/ProfileController.php

# Reset routes/web.php (kita akan bikin baru)
echo "<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});
" > routes/web.php

# Hapus routes/auth.php
rm routes/auth.php
```

## 3. Install Dependencies NPM

```bash
npm install
```

## 4. Verifikasi Konfigurasi Inertia

### `resources/js/app.js`

Pastikan isinya seperti ini:

```js
import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

createInertiaApp({
    title: (title) => `${title} — SMKN 2 Cimahi`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue')
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
    progress: {
        color: '#0d6e3f', // accent color sekolah
    },
});
```

### `resources/views/app.blade.php`

```blade
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', 'SMKN 2 Cimahi') }}</title>

        <link rel="icon" type="image/png" href="/images/logo.png">
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
```

## 5. Buat Halaman "Hello" untuk Test

### `resources/js/Pages/Home.vue`

```vue
<script setup>
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Beranda" />
    
    <div class="min-h-screen flex items-center justify-center bg-bg">
        <div class="text-center">
            <h1 class="text-5xl font-bold text-ink mb-4">
                SMKN 2 Cimahi
            </h1>
            <p class="text-muted text-lg">
                Inertia + Vue 3 + Tailwind v3 — Ready! 🚀
            </p>
        </div>
    </div>
</template>
```

## 6. Run Development Server

Jalankan **2 terminal**:

**Terminal 1 — Laravel:**
```bash
php artisan serve
```

**Terminal 2 — Vite:**
```bash
npm run dev
```

Buka `http://localhost:8000`. Harus muncul "SMKN 2 Cimahi - Inertia + Vue 3 + Tailwind v3 — Ready!"

> Note: Tailwind classes `bg-bg`, `text-ink`, `text-muted` belum ada — itu wajar, akan kita setup di Fase 3.

## ✅ Verifikasi Fase 2

- [ ] `npm run dev` jalan tanpa error
- [ ] `Home.vue` ter-render dengan benar
- [ ] Hot reload bekerja (edit file, browser auto refresh)
- [ ] No console errors di browser

## ➡️ Lanjut ke

[`03-setup-tailwind.md`](./03-setup-tailwind.md)
