<x-filament-panels::page>
    <div class="space-y-6">
        <div class="fi-section rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Halaman ini menggantikan script <code>migrate.php</code>, <code>deploy.php</code>,
                <code>set-env.php</code>, dan <code>build.php</code> yang sebelumnya diakses publik tanpa login.
                Sekarang semua fungsi itu ada di sini, hanya bisa diakses <strong>super_admin</strong> yang sudah login.
            </p>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                <strong>Deploy</strong> = migration + seeder + extract build.zip + clear cache sekaligus.
                Kalau cuma butuh salah satu, pakai tombol <strong>Build</strong>, <strong>Migrate</strong>,
                atau <strong>Seeder</strong> secara terpisah.
            </p>
        </div>

        @if ($deployOutput)
            <div class="fi-section rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <h3 class="text-sm font-semibold text-gray-950 dark:text-white mb-2">Output: Deploy</h3>
                <pre class="text-xs bg-gray-950 text-green-400 rounded-lg p-4 overflow-x-auto whitespace-pre-wrap">{{ $deployOutput }}</pre>
            </div>
        @endif

        @if ($buildOutput)
            <div class="fi-section rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <h3 class="text-sm font-semibold text-gray-950 dark:text-white mb-2">Output: Build</h3>
                <pre class="text-xs bg-gray-950 text-green-400 rounded-lg p-4 overflow-x-auto whitespace-pre-wrap">{{ $buildOutput }}</pre>
            </div>
        @endif

        @if ($migrateOutput)
            <div class="fi-section rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <h3 class="text-sm font-semibold text-gray-950 dark:text-white mb-2">Output: Migrate</h3>
                <pre class="text-xs bg-gray-950 text-green-400 rounded-lg p-4 overflow-x-auto whitespace-pre-wrap">{{ $migrateOutput }}</pre>
            </div>
        @endif

        @if ($seederOutput)
            <div class="fi-section rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <h3 class="text-sm font-semibold text-gray-950 dark:text-white mb-2">Output: Seeder</h3>
                <pre class="text-xs bg-gray-950 text-green-400 rounded-lg p-4 overflow-x-auto whitespace-pre-wrap">{{ $seederOutput }}</pre>
            </div>
        @endif

        @if ($envOutput)
            <div class="fi-section rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <h3 class="text-sm font-semibold text-gray-950 dark:text-white mb-2">Output: Set Env</h3>
                <pre class="text-xs bg-gray-950 text-green-400 rounded-lg p-4 overflow-x-auto whitespace-pre-wrap">{{ $envOutput }}</pre>
            </div>
        @endif
    </div>
</x-filament-panels::page>
