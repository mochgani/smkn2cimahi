<script setup>
defineProps({
    stats: {
        type: Array,
        default: () => [
            { value: '1576', label: 'Peserta Didik' },
            { value: '114', label: 'Guru & Staff TU' },
            { value: '11', label: 'Laboratorium' },
            { value: '6', label: 'Kompetensi' },
            { value: '50+', label: 'Penghargaan' },
            { value: '16K', label: 'M² Luas Tanah' },
        ],
    },
});
</script>

<template>
    <section class="container-page">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 border-t border-b border-line">
            <div
                v-for="(stat, i) in stats"
                :key="i"
                class="px-5 py-8 lg:border-r border-line last:border-r-0"
                :class="{ 'border-b lg:border-b-0': i < stats.length - (stats.length % 3 || 3) }"
            >
                <div class="text-[40px] font-extrabold leading-none tracking-tightest text-ink mb-2">
                    {{ stat.value }}
                </div>
                <div class="font-mono text-[11px] text-muted tracking-mono uppercase">
                    {{ stat.label }}
                </div>
            </div>
        </div>
    </section>
</template>
