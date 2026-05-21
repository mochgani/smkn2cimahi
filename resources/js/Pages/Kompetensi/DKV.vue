<script setup>
import KompetensiDetail from '@/Components/Sections/KompetensiDetail.vue';

defineProps({
    kompetensi: { type: Object, required: true },
    lainnya:    { type: Array, default: () => [] },
    beritas:    { type: Array, default: () => [] },
});
</script>

<template>
    <KompetensiDetail :kompetensi="kompetensi" :lainnya="lainnya" :beritas="beritas" />
</template>
