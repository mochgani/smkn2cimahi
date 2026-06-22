<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import PageHeader from '@/Components/UI/PageHeader.vue';
import SectionLabel from '@/Components/UI/SectionLabel.vue';
import SeoTag from '@/Components/UI/SeoTag.vue';

defineProps({
    programs: { type: Array, default: () => [] },
});
</script>

<template>
    <SeoTag
        title="Program Keahlian — SMK Negeri 2 Cimahi"
        description="Enam program keahlian unggulan SMK Negeri 2 Cimahi yang memadukan teori, praktik, dan pengalaman industri."
    />

    <AppLayout>
        <PageHeader
            :breadcrumbs="[
                { label: 'Beranda', href: '/' },
                { label: 'Kurikulum', href: '/kurikulum' },
                { label: 'Program Keahlian' },
            ]"
            meta="KURIKULUM · PROGRAM KEAHLIAN"
            title="Enam Program Keahlian Unggulan"
            lead="Setiap program memadukan teori, praktik intensif, dan pengalaman langsung di dunia kerja. Pilih program sesuai minat dan bakat."
        />

        <section class="container-page pt-16 pb-0">
            <SectionLabel num="01" title="Semua Program" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
                <h2 class="section-h2">{{ programs.length }} kompetensi keahlian yang siap membentuk karir.</h2>
                <p class="section-sub">Dari teknik mesin hingga animasi digital, setiap program dirancang bersama mitra industri untuk memastikan relevansi dan kualitas lulusan.</p>
            </div>
        </section>

        <div class="container-page pb-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 border-t border-l border-line">
                <article
                    v-for="program in programs"
                    :key="program.slug"
                    class="bg-white border-r border-b border-line flex flex-col transition-colors hover:bg-bg-alt group"
                >
                    <!-- Header kartu -->
                    <div class="bg-ink px-6 py-4 flex items-center justify-between">
                        <span class="font-mono font-semibold text-accent tracking-mono text-[13px]">
                            {{ program.code }}
                        </span>
                        <span class="font-mono text-[11px] text-bg/40 tracking-mono">
                            {{ program.num }}
                        </span>
                    </div>

                    <!-- Body -->
                    <div class="p-6 flex flex-col flex-1">
                        <!-- Logo atau code besar -->
                        <div class="mb-4">
                            <img
                                v-if="program.logo_image"
                                :src="program.logo_image"
                                :alt="`Logo ${program.name}`"
                                class="h-12 object-contain"
                                loading="lazy"
                                decoding="async"
                            />
                            <div v-else class="font-mono text-[36px] font-bold text-accent/20 leading-none">
                                {{ program.code }}
                            </div>
                        </div>

                        <h3 class="text-[17px] font-bold text-ink leading-tight tracking-tighter mb-2">
                            {{ program.name }}
                        </h3>

                        <p class="text-[13px] text-muted leading-relaxed mb-4 flex-1">
                            {{ program.short_desc || program.lead }}
                        </p>

                        <!-- Tag -->
                        <div class="border-t border-line pt-4 mb-4">
                            <div class="flex gap-2 font-mono text-[11px] tracking-mono">
                                <span class="text-muted uppercase">Bidang</span>
                                <span class="text-ink">{{ program.tag?.toUpperCase() }}</span>
                            </div>
                        </div>

                        <!-- CTA -->
                        <Link
                            :href="`/kompetensi/${program.slug}`"
                            class="inline-flex items-center gap-2 font-mono text-[12px] text-ink group-hover:text-accent transition-colors"
                        >
                            Lihat profil lengkap
                            <span class="transition-transform group-hover:translate-x-1">→</span>
                        </Link>
                    </div>
                </article>
            </div>

            <!-- Empty state -->
            <div v-if="!programs.length" class="py-20 text-center border border-dashed border-line">
                <p class="text-muted font-mono text-sm">Belum ada program keahlian aktif.</p>
            </div>
        </div>
    </AppLayout>
</template>
