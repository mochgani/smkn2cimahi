<script setup>
import AppLayout from '@/Components/Layout/AppLayout.vue';
import PageHeader from '@/Components/UI/PageHeader.vue';
import SeoTag from '@/Components/UI/SeoTag.vue';

defineProps({
    sejarah: { type: Object, required: true },
});
</script>

<template>
    <SeoTag
        :title="sejarah.title"
        :description="sejarah.lead"
        :image="sejarah.image"
    />

    <AppLayout>
        <PageHeader
            :breadcrumbs="[
                { label: 'Beranda', href: '/' },
                { label: 'Profil' },
                { label: 'Sejarah' },
            ]"
            meta="PROFIL · SEJARAH SEKOLAH"
            :title="sejarah.title"
            :lead="sejarah.lead"
        />

        <!-- Info Cards -->
        <section
            v-if="sejarah.tahun_berdiri || sejarah.luas_lahan"
            class="container-page pb-6 sm:pb-8"
        >
            <div class="grid grid-cols-1 sm:grid-cols-2 border-t border-l border-line">
                <div v-if="sejarah.tahun_berdiri" class="border-r border-b border-line p-5 sm:p-7 bg-white">
                    <div class="font-mono text-[11px] text-accent tracking-mono mb-2 sm:mb-3">[01] BERDIRI</div>
                    <div class="font-mono text-[32px] sm:text-[44px] font-semibold text-ink leading-none mb-1.5 sm:mb-2">
                        {{ sejarah.tahun_berdiri }}
                    </div>
                    <div class="text-[12px] sm:text-[13px] text-muted-soft">Tahun pendirian institusi</div>
                </div>
                <div v-if="sejarah.luas_lahan" class="border-r border-b border-line p-5 sm:p-7 bg-white">
                    <div class="font-mono text-[11px] text-accent tracking-mono mb-2 sm:mb-3">[02] LUAS LAHAN</div>
                    <div class="font-mono text-[32px] sm:text-[44px] font-semibold text-ink leading-none mb-1.5 sm:mb-2">
                        {{ sejarah.luas_lahan }}
                    </div>
                    <div class="text-[12px] sm:text-[13px] text-muted-soft">Luas total area sekolah</div>
                </div>
            </div>
        </section>

        <!-- Featured Image -->
        <section v-if="sejarah.image" class="container-page pb-6 sm:pb-8">
            <div class="aspect-[16/9] overflow-hidden bg-line-soft border border-line">
                <img
                    :src="sejarah.image"
                    :alt="sejarah.title"
                    loading="lazy"
                    decoding="async"
                    class="w-full h-full object-cover"
                />
            </div>
        </section>

        <!-- Rich Content -->
        <section class="prose-section">
            <aside class="prose-aside">[03] Sejarah</aside>
            <div class="prose-body">
                <h2>Perjalanan sekolah</h2>
                <div v-html="sejarah.content" />
            </div>
        </section>

        <!-- Video -->
        <section v-if="sejarah.video_embed_url" class="container-page py-10 sm:py-12 lg:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-12 mb-6 sm:mb-10">
                <div>
                    <div class="font-mono text-[11px] text-accent tracking-mono mb-2 sm:mb-3">[04] VIDEO</div>
                    <h2 class="section-h2">Profil dalam video.</h2>
                </div>
                <p class="section-sub">Lihat profil dan keseharian SMK Negeri 2 Cimahi melalui video berikut.</p>
            </div>
            <div class="aspect-video border border-line bg-ink">
                <iframe
                    :src="sejarah.video_embed_url"
                    class="w-full h-full"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                />
            </div>
        </section>
    </AppLayout>
</template>
