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
                class="px-3 sm:px-5 py-5 sm:py-7 lg:py-8 border-r border-b border-line"
                :class="{
                    'border-r-0': (i + 1) % 2 === 0,
                    'sm:border-r': (i + 1) % 2 === 0 && (i + 1) % 3 !== 0,
                    'sm:border-r-0': (i + 1) % 3 === 0,
                    'lg:border-r': (i + 1) % 3 === 0 && i !== stats.length - 1,
                    'lg:border-b-0': true,
                }"
            >
                <div class="text-[28px] sm:text-[34px] lg:text-[40px] font-extrabold leading-none tracking-tightest text-ink mb-1.5 sm:mb-2">
                    {{ stat.value }}
                </div>
                <div class="font-mono text-[10px] sm:text-[11px] text-muted tracking-mono uppercase">
                    {{ stat.label }}
                </div>
            </div>
        </div>
    </section>
</template>
