<script setup>
defineProps({
    label: { type: String, required: true },
    title: { type: String, required: true },
});
</script>

<template>
    <section class="container-page pb-12">
        <div class="bg-ink text-bg p-12 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <div class="font-mono text-[11px] text-accent tracking-mono-wide mb-3">{{ label }}</div>
                <h3 class="text-3xl font-bold tracking-tighter leading-tight">
                    {{ title }}
                </h3>
            </div>
            <p class="text-[15px] leading-relaxed text-white/80">
                <slot />
            </p>
        </div>
    </section>
</template>
