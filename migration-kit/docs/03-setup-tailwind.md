# Fase 3: Setup Tailwind v3 dengan Design Tokens

Estimasi: ~45 menit

Tujuan: Konfigurasi Tailwind dengan **design tokens** dari design system kita (warna, font, spacing) agar bisa pakai class seperti `bg-bg`, `text-ink`, `text-accent`, dll.

## 1. Update `tailwind.config.js`

Replace seluruh isi `tailwind.config.js` dengan:

```js
/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                // Design tokens dari project kita
                bg: {
                    DEFAULT: '#fafaf8',
                    alt: '#f4f2ec',
                },
                ink: {
                    DEFAULT: '#0a0a0a',
                    soft: '#1a1a1a',
                },
                accent: {
                    DEFAULT: '#0d6e3f',
                    dark: '#095530',
                    light: '#fcd34d',
                },
                muted: {
                    DEFAULT: '#6b6b66',
                    soft: '#3a3a36',
                },
                line: {
                    DEFAULT: '#d4d0c5',
                    soft: '#e8e6e0',
                },
            },
            fontFamily: {
                sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                mono: ['"JetBrains Mono"', 'ui-monospace', 'SF Mono', 'monospace'],
            },
            maxWidth: {
                page: '1280px',
            },
            spacing: {
                'page': '56px', // pad-x desktop
            },
            letterSpacing: {
                'tightest': '-0.02em',
                'tighter': '-0.01em',
                'mono': '0.05em',
                'mono-wide': '0.08em',
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
    ],
};
```

## 2. Update `resources/css/app.css`

Replace seluruh isi `resources/css/app.css` dengan:

```css
@tailwind base;
@tailwind components;
@tailwind utilities;

/* ============= BASE STYLES ============= */
@layer base {
    html {
        scroll-behavior: smooth;
    }

    body {
        @apply font-sans bg-bg text-ink antialiased;
        font-size: 16px;
        line-height: 1.6;
    }

    a {
        @apply transition-colors;
    }
}

/* ============= COMPONENTS LAYER ============= */
@layer components {
    /* Container utama */
    .container-page {
        @apply max-w-page mx-auto px-page;
    }

    /* Section label dengan [01], [02], dst */
    .section-label {
        @apply flex items-center gap-3 mb-8;
    }

    .section-label .label-num {
        @apply font-mono text-[11px] text-accent tracking-mono;
    }

    .section-label .label-line {
        @apply flex-none w-[60px] h-px bg-line;
    }

    .section-label .label-title {
        @apply font-mono text-[11px] text-muted tracking-mono-wide uppercase;
    }

    /* Section heading */
    .section-h2 {
        @apply text-[40px] font-bold leading-[1.15] tracking-tightest text-ink;
    }

    .section-sub {
        @apply text-base text-muted-soft max-w-[560px];
    }

    /* Buttons */
    .btn-primary {
        @apply bg-ink text-white px-6 py-3.5 text-sm font-medium 
               inline-flex items-center gap-2 transition-colors hover:bg-accent;
    }

    .btn-secondary {
        @apply text-ink border border-ink px-6 py-3.5 text-sm font-medium 
               transition-all hover:bg-ink hover:text-white;
    }

    .btn-spmb {
        @apply bg-accent text-white px-[18px] py-2.5 font-mono 
               text-xs font-semibold tracking-mono uppercase
               transition-colors hover:bg-accent-dark;
    }

    /* Modular grid card pattern (untuk kompetensi, fasilitas, dll) */
    .grid-bordered {
        @apply grid border-t border-l border-line;
    }

    .grid-bordered > * {
        @apply border-r border-b border-line bg-white;
    }

    /* Card dasar */
    .card {
        @apply bg-white p-7 transition-colors hover:bg-bg-alt;
    }

    /* Mono badge */
    .mono-badge {
        @apply font-mono text-[11px] tracking-mono;
    }

    /* Page header pattern */
    .page-header {
        @apply container-page py-16 border-b border-line;
    }

    .page-title {
        @apply text-[56px] font-extrabold leading-[1.05] 
               tracking-tightest text-ink mb-4 max-w-[900px];
    }

    .page-lead {
        @apply text-lg leading-relaxed text-muted-soft max-w-[720px];
    }

    /* Topbar */
    .topbar {
        @apply bg-ink text-bg flex justify-between items-center 
               px-page py-2 font-mono text-[11px] tracking-mono;
    }
}

/* ============= UTILITIES ============= */
@layer utilities {
    .text-balance {
        text-wrap: balance;
    }
}
```

## 3. Install Tailwind Forms Plugin

```bash
npm install -D @tailwindcss/forms
```

## 4. Update `vite.config.js`

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            ssr: 'resources/js/ssr.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
});
```

## 5. Test Design Tokens

Update `Home.vue` untuk test:

```vue
<script setup>
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Test Tailwind" />
    
    <div class="min-h-screen bg-bg">
        <!-- Topbar -->
        <div class="topbar">
            <span>SMK NEGERI 2 CIMAHI · BMW</span>
            <span>+62 896 0520 1376</span>
        </div>

        <!-- Test cards -->
        <div class="container-page py-16">
            <div class="section-label">
                <span class="label-num">[TEST]</span>
                <span class="label-line"></span>
                <span class="label-title">Design Tokens Test</span>
            </div>

            <h2 class="section-h2 mb-4">
                Tailwind v3 dengan design tokens berhasil setup.
            </h2>
            <p class="section-sub mb-8">
                Semua warna, font, dan spacing sudah sesuai dengan design system.
            </p>

            <div class="grid-bordered grid-cols-3 max-w-3xl">
                <div class="card">
                    <div class="font-mono text-xs text-accent">[01]</div>
                    <h3 class="text-lg font-bold mt-2">Background</h3>
                    <p class="text-sm text-muted mt-1">bg-bg</p>
                </div>
                <div class="card">
                    <div class="font-mono text-xs text-accent">[02]</div>
                    <h3 class="text-lg font-bold mt-2">Accent</h3>
                    <p class="text-sm text-muted mt-1">text-accent</p>
                </div>
                <div class="card">
                    <div class="font-mono text-xs text-accent">[03]</div>
                    <h3 class="text-lg font-bold mt-2">Mono Font</h3>
                    <p class="text-sm font-mono mt-1">JetBrains Mono</p>
                </div>
            </div>

            <div class="flex gap-3 mt-8">
                <button class="btn-primary">Primary Button</button>
                <button class="btn-secondary">Secondary</button>
                <button class="btn-spmb">SPMB 2026 →</button>
            </div>
        </div>
    </div>
</template>
```

## 6. Refresh Browser

Jalan kan kedua server (Laravel + Vite) jika belum, lalu buka `http://localhost:8000`.

Harus muncul:
- ✅ Background warna off-white `#fafaf8`
- ✅ Topbar gelap di atas
- ✅ Section label dengan `[TEST]` warna hijau
- ✅ 3 cards dalam bordered grid
- ✅ 3 buttons dengan style berbeda
- ✅ Font Inter untuk body, JetBrains Mono untuk label

## ✅ Verifikasi Fase 3

- [ ] Tailwind classes `bg-bg`, `text-ink`, `text-accent` bekerja
- [ ] Font Inter dan JetBrains Mono ter-load
- [ ] Components classes (`btn-primary`, `card`, `section-label`) bekerja
- [ ] Tidak ada warning di console
- [ ] Build production berhasil: `npm run build`

## ➡️ Lanjut ke

[`04-routes-controllers.md`](./04-routes-controllers.md)
