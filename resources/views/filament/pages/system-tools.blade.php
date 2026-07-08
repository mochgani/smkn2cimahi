<x-filament-panels::page>
    <div class="space-y-6">
        <div class="fi-section rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Halaman ini menggantikan script <code>migrate.php</code>, <code>deploy.php</code>,
                <code>set-env.php</code>, dan <code>build.php</code> yang sebelumnya diakses publik tanpa login.
                Sekarang semua fungsi itu ada di sini, hanya bisa diakses <strong>super_admin</strong> yang sudah login.
            </p>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Klik tombol di kanan atas untuk menjalankan masing-masing fungsi. Setelah update kode dari
                <code>git pull</code>, urutan yang biasa dipakai: <strong>Extract build.zip</strong> (kalau ada
                perubahan frontend) → <strong>Jalankan Migration</strong> (kalau ada perubahan database).
            </p>
        </div>

        @if ($migrateOutput)
            <div class="fi-section rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <h3 class="text-sm font-semibold text-gray-950 dark:text-white mb-2">Output: Migration</h3>
                <pre class="text-xs bg-gray-950 text-green-400 rounded-lg p-4 overflow-x-auto whitespace-pre-wrap">{{ $migrateOutput }}</pre>
            </div>
        @endif

        @if ($buildOutput)
            <div class="fi-section rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <h3 class="text-sm font-semibold text-gray-950 dark:text-white mb-2">Output: Extract build.zip</h3>
                <pre class="text-xs bg-gray-950 text-green-400 rounded-lg p-4 overflow-x-auto whitespace-pre-wrap">{{ $buildOutput }}</pre>
            </div>
        @endif

        @if ($deployOutput)
            <div class="fi-section rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <h3 class="text-sm font-semibold text-gray-950 dark:text-white mb-2">Output: Setup Deploy</h3>
                <pre class="text-xs bg-gray-950 text-green-400 rounded-lg p-4 overflow-x-auto whitespace-pre-wrap">{{ $deployOutput }}</pre>
            </div>
        @endif

        @if ($envOutput)
            <div class="fi-section rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <h3 class="text-sm font-semibold text-gray-950 dark:text-white mb-2">Output: Set Environment Variable</h3>
                <pre class="text-xs bg-gray-950 text-green-400 rounded-lg p-4 overflow-x-auto whitespace-pre-wrap">{{ $envOutput }}</pre>
            </div>
        @endif
    </div>
</x-filament-panels::page>
