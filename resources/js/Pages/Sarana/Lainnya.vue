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
        title="Sarana Prasarana Lainnya — SMK Negeri 2 Cimahi"
        :description="sarana.lead"
    />

    <AppLayout>
        <PageHeader
            :breadcrumbs="[
                { label: 'Beranda', href: '/' },
                { label: 'Sarana dan Prasarana' },
                { label: 'Lainnya' },
            ]"
            meta="SARANA PRASARANA · LAINNYA"
            :title="sarana.title"
            :lead="sarana.lead"
        />

        <section v-if="sarana.items?.length" class="container-page pt-16 pb-0">
            <SectionLabel num="01" title="Fasilitas Penunjang" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
                <h2 class="section-h2">Ruang dan area pendukung kegiatan sekolah.</h2>
            </div>
        </section>

        <div v-if="sarana.items?.length" class="container-page pb-16">
            <div class="grid grid-cols-1 md:grid-cols-2 border-t border-l border-line">
                <div
                    v-for="(item, i) in sarana.items"
                    :key="i"
                    class="bg-white border-r border-b border-line p-7"
                >
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-8 h-8 rounded-full bg-accent text-bg text-[12px] font-bold flex items-center justify-center shrink-0">
                            {{ String(i + 1).padStart(2, '0') }}
                        </span>
                        <h3 class="text-[16px] font-bold text-ink">{{ item.nama }}</h3>
                    </div>

                    <ul v-if="item.detail?.length" class="space-y-2 mb-3">
                        <li
                            v-for="(d, j) in item.detail"
                            :key="j"
                            class="flex items-baseline justify-between gap-3 text-[13px] border-b border-line pb-2 last:border-0"
                        >
                            <span class="text-ink">{{ d.nama }}</span>
                            <span v-if="d.lantai" class="font-mono text-[11px] text-muted tracking-mono shrink-0">{{ d.lantai }}</span>
                        </li>
                    </ul>

                    <p v-if="item.catatan" class="text-[12px] text-muted">
                        <span class="font-semibold text-ink">Fasilitas:</span> {{ item.catatan }}
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
