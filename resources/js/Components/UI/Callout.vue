<script setup>
defineProps({
    label: { type: String, required: true },
    title: { type: String, required: true },
});
</script>

<template>
    <section class="container-page pb-10 sm:pb-12">
        <div class="bg-ink text-bg p-6 sm:p-8 lg:p-12 grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-12 items-start md:items-center">
            <div>
                <div class="font-mono text-[10px] sm:text-[11px] text-accent tracking-mono-wide mb-2 sm:mb-3">{{ label }}</div>
                <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold tracking-tighter leading-tight">
                    {{ title }}
                </h3>
            </div>
            <p class="text-[14px] sm:text-[15px] leading-relaxed text-white/80">
                <slot />
            </p>
        </div>
    </section>
</template>
