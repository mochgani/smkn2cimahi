<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    items: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <section class="container-page py-10 sm:py-12 lg:py-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 border-t border-l border-line">
            <Link
                v-for="item in items"
                :key="item.slug"
                :href="`/kompetensi/${item.slug}`"
                class="group block p-5 sm:p-7 lg:p-8 border-r border-b border-line bg-white transition-colors hover:bg-bg-alt"
            >
                <div class="mb-4 sm:mb-6">
                    <img
                        v-if="item.logo_image"
                        :src="item.logo_image"
                        :alt="`Logo ${item.name}`"
                        loading="lazy"
                        decoding="async"
                        class="h-12 sm:h-16 object-contain"
                    />
                    <div v-else class="font-mono text-[30px] sm:text-[36px] font-semibold text-accent leading-none tracking-tight">
                        {{ item.code }}
                    </div>
                </div>
                <div class="font-mono text-[10px] text-muted tracking-mono-wide uppercase mb-2">
                    {{ item.tag }}
                </div>
                <h3 class="text-[18px] sm:text-[22px] font-bold text-ink leading-tight tracking-tighter mb-2 sm:mb-3">
                    {{ item.name }}
                </h3>
                <p class="text-[13px] sm:text-sm text-muted-soft leading-relaxed">
                    {{ item.short_desc }}
                </p>
                <div class="mt-4 sm:mt-6 font-mono text-[11px] text-ink tracking-mono inline-flex items-center gap-1 group-hover:text-accent">
                    Lihat detail <span>↗</span>
                </div>
            </Link>
        </div>
    </section>
</template>
