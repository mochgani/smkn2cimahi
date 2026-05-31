<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import Breadcrumb from '@/Components/UI/Breadcrumb.vue';
import SectionLabel from '@/Components/UI/SectionLabel.vue';
import Callout from '@/Components/UI/Callout.vue';
import SeoTag from '@/Components/UI/SeoTag.vue';

const props = defineProps({
    kompetensi: { type: Object, required: true },
    lainnya:    { type: Array, default: () => [] },
    beritas:    { type: Array, default: () => [] },
});

const lightboxOpen = ref(false);
const lightboxIndex = ref(0);

const openLightbox = (i) => {
    lightboxIndex.value = i;
    lightboxOpen.value = true;
};
const closeLightbox = () => { lightboxOpen.value = false; };
const lightboxNext = () => {
    lightboxIndex.value = (lightboxIndex.value + 1) % props.kompetensi.gallery.length;
};
const lightboxPrev = () => {
    lightboxIndex.value = (lightboxIndex.value - 1 + props.kompetensi.gallery.length) % props.kompetensi.gallery.length;
};

// Section numbering: about=01, sections=02..N+1, gallery=N+2, berita=N+3, lainnya=N+4
const sectionCount = computed(() => props.kompetensi.sections?.length ?? 0);
const galleryNum = computed(() => String(sectionCount.value + 2).padStart(2, '0'));
const beritaNum  = computed(() => String(sectionCount.value + 3).padStart(2, '0'));
const lainnyaNum = computed(() => String(sectionCount.value + 4).padStart(2, '0'));
</script>

<template>
    <SeoTag
        :title="`Kompetensi ${kompetensi.name}`"
        :description="kompetensi.lead || kompetensi.short_desc || `Program keahlian ${kompetensi.name} di SMK Negeri 2 Cimahi.`"
        :image="kompetensi.logo_image"
    />

    <AppLayout>
        <section class="page-header">
            <div class="grid grid-cols-1 md:grid-cols-[1fr_auto] gap-6 md:gap-12 items-start">
                <div>
                    <Breadcrumb
                        :items="[
                            { label: 'Beranda', href: '/' },
                            { label: 'Kompetensi' },
                            { label: kompetensi.name },
                        ]"
                        class="mb-4 sm:mb-6"
                    />
                    <div class="inline-flex items-center gap-2 bg-white border border-line px-3 py-1 mb-4 sm:mb-6 flex-wrap">
                        <span class="w-2 h-2 rounded-full bg-accent shrink-0"></span>
                        <span class="font-mono text-[10px] sm:text-[11px] text-ink tracking-mono">
                            {{ kompetensi.tag.toUpperCase() }} · KOMPETENSI KEAHLIAN
                        </span>
                    </div>

                    <!-- Title -->
                    <h1 class="page-title mb-4">{{ kompetensi.name }}</h1>
                    <p class="page-lead">{{ kompetensi.lead }}</p>
                </div>
                <div class="hidden md:block">
                    <img
                        v-if="kompetensi.logo_image"
                        :src="kompetensi.logo_image"
                        :alt="`Logo ${kompetensi.name}`"
                        class="w-32 h-32 lg:w-40 lg:h-40 object-contain"
                    />
                    <div v-else class="font-mono text-[120px] lg:text-[160px] font-semibold text-accent leading-none tracking-tightest opacity-90">
                        {{ kompetensi.code }}
                    </div>
                </div>
            </div>
        </section>

        <section class="prose-section">
            <aside class="prose-aside">[01] Tentang</aside>
            <div class="prose-body">
                <h2>Tentang program keahlian</h2>
                <div v-html="kompetensi.about" />
            </div>
        </section>

        <template v-for="(section, sIdx) in kompetensi.sections" :key="sIdx">
            <section class="container-page pt-16 pb-0">
                <SectionLabel :num="String(sIdx + 2)" :title="section.label" />
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
                    <h2 class="section-h2">{{ section.title }}</h2>
                    <p class="section-sub">{{ section.sub }}</p>
                </div>
            </section>

            <div class="container-page">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 border-t border-l border-line">
                    <div
                        v-for="(item, iIdx) in section.items"
                        :key="iIdx"
                        class="detail-card"
                    >
                        <div class="detail-num">{{ item.num }}</div>
                        <h4 class="detail-title">{{ item.title }}</h4>
                        <p class="detail-desc">{{ item.desc }}</p>
                    </div>
                </div>
            </div>
        </template>

        <!-- Gallery Section -->
        <section v-if="kompetensi.gallery?.length" class="container-page pt-16 pb-0">
            <SectionLabel :num="galleryNum" title="Gallery Jurusan" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
                <h2 class="section-h2">Dokumentasi kegiatan & fasilitas.</h2>
                <p class="section-sub">Suasana belajar, praktikum, dan kegiatan siswa di {{ kompetensi.name }}.</p>
            </div>
        </section>

        <div v-if="kompetensi.gallery?.length" class="container-page pb-8">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                <button
                    v-for="(img, i) in kompetensi.gallery"
                    :key="i"
                    type="button"
                    :aria-label="`Buka foto ${i + 1} dalam galeri`"
                    @click="openLightbox(i)"
                    class="relative aspect-square overflow-hidden bg-line-soft border border-line group"
                >
                    <img
                        :src="img"
                        :alt="`${kompetensi.name} foto ${i + 1}`"
                        loading="lazy"
                        decoding="async"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                    />
                    <div class="absolute inset-0 bg-ink/0 group-hover:bg-ink/20 transition-colors" />
                    <div class="absolute bottom-2 left-2 font-mono text-[10px] text-bg bg-ink/70 px-2 py-0.5 opacity-0 group-hover:opacity-100 transition-opacity">
                        {{ String(i + 1).padStart(2, '0') }}
                    </div>
                </button>
            </div>
        </div>

        <!-- Lightbox -->
        <Teleport to="body">
            <div
                v-if="lightboxOpen"
                class="fixed inset-0 z-[100] bg-ink/95 flex items-center justify-center p-4"
                role="dialog"
                aria-modal="true"
                aria-label="Galeri foto"
                @click.self="closeLightbox"
                @keydown.esc="closeLightbox"
            >
                <button
                    type="button"
                    aria-label="Tutup galeri"
                    @click="closeLightbox"
                    class="absolute top-3 right-3 sm:top-4 sm:right-4 text-bg font-mono text-[12px] sm:text-sm hover:text-accent bg-ink/60 sm:bg-transparent px-3 py-2 sm:p-0"
                >
                    ✕ Tutup
                </button>
                <button
                    v-if="kompetensi.gallery.length > 1"
                    type="button"
                    aria-label="Foto sebelumnya"
                    @click="lightboxPrev"
                    class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 text-bg font-mono text-2xl hover:text-accent px-3 py-2 bg-ink/60 sm:bg-transparent"
                >
                    ←
                </button>
                <img
                    :src="kompetensi.gallery[lightboxIndex]"
                    :alt="`${kompetensi.name} foto ${lightboxIndex + 1}`"
                    class="max-w-full max-h-full object-contain"
                />
                <button
                    v-if="kompetensi.gallery.length > 1"
                    type="button"
                    aria-label="Foto berikutnya"
                    @click="lightboxNext"
                    class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 text-bg font-mono text-2xl hover:text-accent px-3 py-2 bg-ink/60 sm:bg-transparent"
                >
                    →
                </button>
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 text-bg font-mono text-[11px] tracking-mono">
                    {{ lightboxIndex + 1 }} / {{ kompetensi.gallery.length }}
                </div>
            </div>
        </Teleport>

        <!-- CTA Banner -->
        <Callout :label="kompetensi.cta_label" :title="kompetensi.cta_title">
            {{ kompetensi.cta_text }}
        </Callout>

        <!-- Berita Kompetensi -->
        <section v-if="beritas.length" class="container-page py-16">
            <SectionLabel :num="beritaNum" :title="`Berita ${kompetensi.name}`" />
            <div class="flex items-end justify-between mb-10 flex-wrap gap-4">
                <h2 class="section-h2 max-w-xl">Kabar terbaru dari kompetensi.</h2>
                <Link href="/berita" class="font-mono text-[13px] text-ink hover:text-accent">
                    Semua Berita →
                </Link>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 border-t border-l border-line">
                <article
                    v-for="(item, i) in beritas"
                    :key="item.slug"
                    class="bg-white border-r border-b border-line"
                >
                    <Link :href="`/berita/${item.slug}`" class="block p-7 transition-colors hover:bg-bg-alt h-full">
                        <div class="font-mono text-[11px] text-accent tracking-mono mb-3">
                            [{{ String(i + 1).padStart(2, '0') }}]
                        </div>
                        <div class="flex items-center gap-3 font-mono text-[11px] text-muted tracking-mono mb-4">
                            <span>{{ item.date }}</span>
                            <span v-if="item.categories.length" class="text-line">·</span>
                            <span>{{ item.categories.join(' · ') }}</span>
                        </div>
                        <h3 class="text-[17px] font-bold text-ink leading-tight tracking-tighter mb-3">
                            {{ item.title }}
                        </h3>
                        <p class="text-[13px] text-muted-soft leading-relaxed line-clamp-3 mb-6">
                            {{ item.excerpt }}
                        </p>
                        <div class="flex items-center justify-between font-mono text-[11px] tracking-mono">
                            <span class="text-muted">{{ item.reading_time }} baca</span>
                            <span class="text-ink">→</span>
                        </div>
                    </Link>
                </article>
            </div>
        </section>

        <!-- Kompetensi Lainnya -->
        <section v-if="lainnya.length" class="container-page py-16">
            <SectionLabel :num="lainnyaNum" title="Kompetensi Lainnya" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
                <h2 class="section-h2">Lima program keahlian lainnya.</h2>
                <p class="section-sub">Jelajahi kompetensi keahlian lain di SMKN 2 Cimahi.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 border-t border-l border-line">
                <Link
                    v-for="other in lainnya"
                    :key="other.slug"
                    :href="`/kompetensi/${other.slug}`"
                    class="block p-6 border-r border-b border-line bg-white transition-colors hover:bg-bg-alt group"
                >
                    <div class="font-mono text-2xl font-semibold text-accent tracking-tight mb-3">{{ other.code }}</div>
                    <div class="font-mono text-[10px] text-muted tracking-mono-wide uppercase mb-2">{{ other.tag }}</div>
                    <h4 class="text-[15px] font-bold text-ink leading-tight tracking-tighter">{{ other.name }}</h4>
                    <div class="mt-4 font-mono text-[11px] text-ink group-hover:text-accent">→</div>
                </Link>
            </div>
        </section>
    </AppLayout>
</template>
