<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    items: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <nav
        v-if="items.length"
        aria-label="Breadcrumb"
        class="flex items-center gap-2 font-mono text-[11px] text-muted tracking-mono uppercase"
    >
        <template v-for="(crumb, i) in items" :key="i">
            <Link
                v-if="crumb.href"
                :href="crumb.href"
                class="text-muted hover:text-accent"
            >
                {{ crumb.label }}
            </Link>
            <span v-else class="text-accent">{{ crumb.label }}</span>
            <span v-if="i < items.length - 1" class="text-line">/</span>
        </template>
    </nav>
</template>
