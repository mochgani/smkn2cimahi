<script setup>
import Breadcrumb from './Breadcrumb.vue';

defineProps({
    breadcrumbs: { type: Array, default: () => [] },
    meta: { type: String, default: '' },
    title: { type: String, required: true },
    lead: { type: String, default: '' },
});
</script>

<template>
    <section class="page-header">
        <Breadcrumb v-if="breadcrumbs.length" :items="breadcrumbs" class="mb-6" />

        <div v-if="meta" class="inline-flex items-center gap-2 bg-white border border-line px-3 py-1 mb-6">
            <span class="w-2 h-2 rounded-full bg-accent"></span>
            <span class="font-mono text-[11px] text-ink tracking-mono">{{ meta }}</span>
        </div>

        <h1 class="page-title">{{ title }}</h1>
        <p v-if="lead" class="page-lead">{{ lead }}</p>
    </section>
</template>
