<script setup>
defineProps({
    num: { type: [String, Number], required: true },
    title: { type: String, required: true },
});
</script>

<template>
    <div class="section-label">
        <span class="label-num">[{{ String(num).padStart(2, '0') }}]</span>
        <span class="label-line"></span>
        <span class="label-title">{{ title }}</span>
    </div>
</template>
