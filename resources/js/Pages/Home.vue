<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import SectionLabel from '@/Components/UI/SectionLabel.vue';
import Callout from '@/Components/UI/Callout.vue';
import HeroSlider from '@/Components/Sections/HeroSlider.vue';
import StatsBar from '@/Components/Sections/StatsBar.vue';
import KompetensiGrid from '@/Components/Sections/KompetensiGrid.vue';

defineProps({
    beritaTerbaru: { type: Array, default: () => [] },
    kompetensi: { type: Array, default: () => [] },
    stats: { type: Array, default: () => [] },
    slides: { type: Array, default: () => [] },
});
</script>

<template>
    <Head title="Beranda" />

    <AppLayout>
        <HeroSlider v-if="slides.length" :slides="slides" />

        <StatsBar :stats="stats" />

        <section class="container-page py-16">
            <SectionLabel num="1" title="Kompetensi Keahlian" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-12">
                <h2 class="section-h2">
                    Enam kompetensi keahlian, lulusan siap industri.
                </h2>
                <p class="section-sub">
                    Setiap kompetensi dirancang sesuai kebutuhan industri dengan kurikulum berbasis produksi dan
                    didukung tenaga pendidik profesional serta fasilitas modern.
                </p>
            </div>
        </section>

        <KompetensiGrid :items="kompetensi" />

        <section v-if="beritaTerbaru.length" class="container-page py-16">
            <SectionLabel num="2" title="Berita Terbaru" />
            <div class="flex items-end justify-between mb-12 flex-wrap gap-4">
                <h2 class="section-h2 max-w-xl">Kabar terbaru dari sekolah.</h2>
                <Link href="/berita" class="font-mono text-[13px] text-ink hover:text-accent">
                    Semua Berita →
                </Link>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 border-t border-l border-line">
                <article
                    v-for="(item, i) in beritaTerbaru"
                    :key="item.slug"
                    class="border-r border-b border-line bg-white"
                >
                    <Link :href="`/berita/${item.slug}`" class="block p-7 transition-colors hover:bg-bg-alt">
                        <div class="font-mono text-[11px] text-accent tracking-mono mb-3">
                            [{{ String(i + 1).padStart(2, '0') }}]
                        </div>
                        <div class="flex items-center gap-3 font-mono text-[11px] text-muted tracking-mono mb-4">
                            <span>{{ item.date }}</span>
                            <span class="text-line">·</span>
                            <span>{{ item.categories.join(' · ') }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-ink leading-tight tracking-tighter mb-3">
                            {{ item.title }}
                        </h3>
                        <p class="text-sm text-muted-soft leading-relaxed line-clamp-3">
                            {{ item.excerpt }}
                        </p>
                        <div class="mt-5 font-mono text-[11px] text-ink tracking-mono">
                            Baca →
                        </div>
                    </Link>
                </article>
            </div>
        </section>

        <Callout
            label="SPMB 2026/2027"
            title="Bergabunglah dengan keluarga besar SMK Negeri 2 Cimahi."
        >
            Pendaftaran SPMB 2026/2027 telah dibuka. Pilih satu dari enam kompetensi keahlian
            unggulan, dapatkan pendidikan kejuruan berbasis industri, dan siapkan masa depan
            Anda untuk Bekerja, Melanjutkan, atau Berwirausaha.
        </Callout>
    </AppLayout>
</template>
