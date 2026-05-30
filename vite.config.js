import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
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
    build: {
        // Target browser modern (kurangi polyfill, output lebih kecil)
        target: 'es2020',
        // CSS per chunk → page-specific CSS hanya load saat dibutuhkan
        cssCodeSplit: true,
        // Minify lebih agresif
        minify: 'esbuild',
        // Naikkan limit warning chunk untuk Inertia + Vue (default 500kb)
        chunkSizeWarningLimit: 800,
        rollupOptions: {
            output: {
                // Manual chunking — pisahkan vendor jadi chunk sendiri
                // agar browser bisa cache vendor lebih lama (jarang berubah)
                manualChunks: {
                    'vendor-vue':     ['vue'],
                    'vendor-inertia': ['@inertiajs/vue3'],
                },
            },
        },
    },
});
