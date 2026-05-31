<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const kontakSetting = computed(() => page.props.kontakSetting ?? {});
const schoolSetting = computed(() => page.props.schoolSetting ?? {});

const teleponKanal = computed(() => kontakSetting.value.kanal?.find(k => k.label === 'TELEPON'));
const emailKanal = computed(() => kontakSetting.value.kanal?.find(k => k.label === 'EMAIL'));
</script>

<template>
    <div class="topbar">
        <span class="truncate max-w-full">
            <span class="sm:hidden">{{ schoolSetting.school_name?.toUpperCase() ?? 'SMK NEGERI 2 CIMAHI' }}</span>
            <span class="hidden sm:inline">
                {{ schoolSetting.school_name?.toUpperCase() ?? 'SMK NEGERI 2 CIMAHI' }}
                · {{ schoolSetting.tagline?.toUpperCase() ?? 'BMW: BEKERJA · MELANJUTKAN · WIRAUSAHA' }}
            </span>
        </span>
        <span class="hidden sm:inline truncate">
            <template v-if="teleponKanal">{{ teleponKanal.value }}</template>
            <template v-if="teleponKanal && emailKanal"> · </template>
            <template v-if="emailKanal">{{ emailKanal.value }}</template>
        </span>
    </div>
</template>
