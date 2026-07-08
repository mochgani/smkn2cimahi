<x-filament-panels::page>
    <div class="space-y-6">
        <x-filament::actions
            :actions="[
                $this->gitPullAction(),
                $this->deployAction(),
                $this->buildAction(),
                $this->migrateAction(),
                $this->seederAction(),
                $this->setEnvAction(),
            ]"
        />

        @if ($gitPullOutput)
            <div class="fi-section rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <h3 class="text-sm font-semibold text-gray-950 dark:text-white mb-2">Output: Git Pull</h3>
                <pre class="text-xs bg-gray-950 text-green-400 rounded-lg p-4 overflow-x-auto whitespace-pre-wrap">{{ $gitPullOutput }}</pre>
            </div>
        @endif

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
