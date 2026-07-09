<script setup>
import AppLayout from '@/Components/Layout/AppLayout.vue';
import PageHeader from '@/Components/UI/PageHeader.vue';
import SectionLabel from '@/Components/UI/SectionLabel.vue';
import SeoTag from '@/Components/UI/SeoTag.vue';

defineProps({
    sarana: { type: Object, required: true },
});
</script>

<template>
    <SeoTag
        title="Sarana Pembelajaran Kejuruan — SMK Negeri 2 Cimahi"
        :description="sarana.lead"
    />

    <AppLayout>
        <PageHeader
            :breadcrumbs="[
                { label: 'Beranda', href: '/' },
                { label: 'Sarana dan Prasarana' },
                { label: 'Kejuruan' },
            ]"
            meta="SARANA PRASARANA · KEJURUAN"
            :title="sarana.title"
            :lead="sarana.lead"
        />

        <section v-if="sarana.groups?.length" class="container-page pt-16 pb-0">
            <SectionLabel num="01" title="Laboratorium & Bengkel" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
                <h2 class="section-h2">Fasilitas praktik tiap kompetensi keahlian.</h2>
            </div>
        </section>

        <div v-if="sarana.groups?.length" class="container-page pb-16 space-y-10">
            <div
                v-for="(group, i) in sarana.groups"
                :key="i"
            >
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-1 h-6 bg-accent"></div>
                    <h3 class="text-[17px] font-bold text-ink">{{ group.kompetensi }}</h3>
                </div>

                <div class="flex flex-wrap gap-2">
                    <span
                        v-for="(r, j) in group.ruangan"
                        :key="j"
                        class="px-3.5 py-1.5 border border-line rounded-full text-[13px] text-muted-soft bg-white hover:border-accent hover:text-accent transition-colors"
                    >
                        {{ r }}
                    </span>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
