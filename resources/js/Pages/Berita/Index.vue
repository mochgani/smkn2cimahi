<script setup>
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import PageHeader from '@/Components/UI/PageHeader.vue';
import SectionLabel from '@/Components/UI/SectionLabel.vue';
import Callout from '@/Components/UI/Callout.vue';
import SeoTag from '@/Components/UI/SeoTag.vue';

const props = defineProps({
    featured: { type: Object, default: null },
    berita: { type: Object, required: true },
    kategoris: { type: Array, default: () => [] },
    currentKategori: { type: String, default: 'all' },
    totalCount: { type: Number, default: 0 },
});

// Partial reload — hanya re-fetch props berita+featured+currentKategori
// (navigation/setting tetap pakai cache shared di Inertia)
const PARTIAL_KEYS = ['featured', 'berita', 'currentKategori', 'totalCount'];

const filterBy = (kat) => {
    router.get('/berita', kat === 'all' ? {} : { kategori: kat }, {
        preserveScroll: true,
        preserveState: true,
        replace: true,
        only: PARTIAL_KEYS,
    });
};

const goToPage = (url) => {
    if (!url) return;
    router.get(url, {}, {
        preserveScroll: true,
        preserveState: true,
        only: PARTIAL_KEYS,
    });
};
</script>

<template>
    <SeoTag
        title="Berita"
        description="Kabar terbaru, prestasi siswa, kegiatan sekolah, dan informasi resmi dari SMK Negeri 2 Cimahi."
    />

    <AppLayout>
        <PageHeader
            :breadcrumbs="[
                { label: 'Beranda', href: '/' },
                { label: 'Berita' },
            ]"
            :meta="`${totalCount} ARTIKEL · DIPERBARUI BERKALA`"
            title="Kabar dari sekolah."
            lead="Berita, kegiatan, prestasi siswa, dan informasi terbaru dari SMK Negeri 2 Cimahi."
        />

        <section v-if="featured" class="container-page py-8 sm:py-10 lg:py-12">
            <Link
                :href="`/berita/${featured.slug}`"
                class="block bg-white border border-line transition-colors hover:bg-bg-alt"
            >
                <div class="grid grid-cols-1 md:grid-cols-[1.4fr_1fr]">
                    <div class="order-2 md:order-1 p-5 sm:p-8 lg:p-10 xl:p-12">
                        <div class="inline-flex items-center gap-2 bg-bg-alt px-3 py-1 mb-4 sm:mb-6">
                            <span class="w-2 h-2 rounded-full bg-accent animate-pulse"></span>
                            <span class="font-mono text-[10px] sm:text-[11px] text-ink tracking-mono">FEATURED · TERBARU</span>
                        </div>
                        <div class="flex items-center gap-2 sm:gap-3 font-mono text-[10px] sm:text-[11px] text-muted tracking-mono mb-3 sm:mb-4 flex-wrap">
                            <span>{{ featured.date_full }}</span>
                            <span class="text-line">·</span>
                            <span>{{ featured.categories.join(' · ') }}</span>
                        </div>
                        <h2 class="text-[22px] sm:text-[28px] lg:text-3xl xl:text-4xl font-extrabold text-ink leading-tight tracking-tighter mb-4 sm:mb-5">
                            {{ featured.title }}
                        </h2>
                        <p class="text-[14px] sm:text-[15px] text-muted-soft leading-relaxed mb-4 sm:mb-6">{{ featured.excerpt }}</p>
                        <div class="inline-flex items-center gap-2 font-mono text-[12px] sm:text-[13px] text-ink">
                            Baca Selengkapnya <span>→</span>
                        </div>
                    </div>
                    <div class="order-1 md:order-2 relative min-h-[200px] sm:min-h-[280px] md:min-h-[400px] bg-line-soft overflow-hidden">
                        <img
                            v-if="featured.cover_image"
                            :src="featured.cover_image"
                            :alt="featured.title"
                            fetchpriority="high"
                            decoding="async"
                            class="absolute inset-0 w-full h-full object-cover"
                        />
                        <div
                            v-else
                            class="absolute inset-0"
                            style="background-image: repeating-linear-gradient(135deg, #e8e6e0 0 14px, #d4d0c5 14px 28px);"
                        >
                            <div
                                class="absolute inset-0"
                                style="background: radial-gradient(circle at 30% 30%, rgba(13,110,63,0.15) 0%, transparent 50%);"
                            ></div>
                        </div>
                        <div class="absolute bottom-6 left-6 bg-white/95 px-5 py-3.5 border border-line">
                            <div class="font-mono text-[10px] text-muted tracking-mono-wide mb-1">FEATURED</div>
                            <div class="font-mono text-sm font-semibold text-ink tracking-mono">
                                {{ featured.categories.join(' · ').toUpperCase() }}
                            </div>
                        </div>
                    </div>
                </div>
            </Link>
        </section>

        <section class="container-page pt-6 sm:pt-8 pb-4">
            <SectionLabel num="2" title="Filter Kategori" />
            <div class="flex flex-wrap gap-1.5 sm:gap-2">
                <button
                    type="button"
                    @click="filterBy('all')"
                    class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2 border font-mono text-[10px] sm:text-[11px] tracking-mono uppercase transition-colors"
                    :class="currentKategori === 'all'
                        ? 'bg-ink text-bg border-ink'
                        : 'bg-white text-ink border-line hover:border-ink'"
                >
                    <span>Semua</span>
                    <span class="opacity-60">{{ totalCount }}</span>
                </button>
                <button
                    v-for="k in kategoris"
                    :key="k.name"
                    type="button"
                    @click="filterBy(k.name)"
                    class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2 border font-mono text-[10px] sm:text-[11px] tracking-mono uppercase transition-colors"
                    :class="currentKategori === k.name
                        ? 'bg-ink text-bg border-ink'
                        : 'bg-white text-ink border-line hover:border-ink'"
                >
                    <span>{{ k.name }}</span>
                    <span class="opacity-60">{{ k.count }}</span>
                </button>
            </div>
        </section>

        <section class="container-page py-8">
            <div v-if="berita.data.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 border-t border-l border-line">
                <article
                    v-for="(item, i) in berita.data"
                    :key="item.slug"
                    class="bg-white border-r border-b border-line"
                >
                    <Link :href="`/berita/${item.slug}`" class="block transition-colors hover:bg-bg-alt h-full">
                        <div
                            v-if="item.cover_image"
                            class="relative aspect-video overflow-hidden bg-line-soft"
                        >
                            <img :src="item.cover_image" :alt="item.title" loading="lazy" decoding="async" class="w-full h-full object-cover" />
                        </div>
                        <div class="p-7">
                        <div class="font-mono text-[11px] text-accent tracking-mono mb-3">
                            [{{ String(i + 2).padStart(2, '0') }}]
                        </div>
                        <div class="flex items-center gap-3 font-mono text-[11px] text-muted tracking-mono mb-4">
                            <span>{{ item.date }}</span>
                            <span class="text-line">·</span>
                            <span>{{ item.categories.join(' · ') }}</span>
                        </div>
                        <h3 class="text-[17px] font-bold text-ink leading-tight tracking-tighter mb-3">
                            {{ item.title }}
                        </h3>
                        <p class="text-[13px] text-muted-soft leading-relaxed line-clamp-3 mb-6">
                            {{ item.excerpt }}
                        </p>
                        <div class="text-[12px] text-muted mb-4">Oleh {{ item.author?.name ?? 'Tim Penulis' }}</div>
                        <div class="flex items-center justify-between font-mono text-[11px] tracking-mono">
                            <span class="text-muted">{{ item.reading_time }} baca</span>
                            <span class="text-ink">→</span>
                        </div>
                        </div>
                    </Link>
                </article>
            </div>
            <div v-else class="py-20 text-center text-muted font-mono text-sm">
                Belum ada berita di kategori ini.
            </div>

            <div
                v-if="berita.last_page > 1"
                class="flex justify-between items-center mt-8 sm:mt-12 font-mono text-[11px] sm:text-[12px] tracking-mono gap-2 sm:gap-4"
            >
                <button
                    type="button"
                    :disabled="!berita.prev_page_url"
                    @click="goToPage(berita.prev_page_url)"
                    class="px-3 sm:px-4 py-2 border border-line transition-colors shrink-0"
                    :class="berita.prev_page_url ? 'text-ink hover:border-ink' : 'text-muted cursor-not-allowed'"
                >
                    ← <span class="hidden sm:inline">Prev</span>
                </button>
                <div class="flex items-center gap-1 sm:gap-2 overflow-x-auto -mx-1 px-1 max-w-full">
                    <template v-for="(link, i) in berita.links.slice(1, -1)" :key="i">
                        <button
                            v-if="link.url"
                            type="button"
                            @click="goToPage(link.url)"
                            class="w-8 h-8 sm:w-9 sm:h-9 transition-colors shrink-0"
                            :class="link.active ? 'bg-ink text-bg' : 'border border-line text-ink hover:border-ink'"
                            v-html="link.label"
                        />
                        <span v-else class="text-muted px-1 sm:px-2 shrink-0" v-html="link.label" />
                    </template>
                </div>
                <button
                    type="button"
                    :disabled="!berita.next_page_url"
                    @click="goToPage(berita.next_page_url)"
                    class="px-3 sm:px-4 py-2 border border-line transition-colors shrink-0"
                    :class="berita.next_page_url ? 'text-ink hover:border-ink' : 'text-muted cursor-not-allowed'"
                >
                    <span class="hidden sm:inline">Next</span> →
                </button>
            </div>
        </section>

        <Callout
            label="SUBSCRIBE NEWSLETTER"
            title="Dapatkan kabar terbaru langsung di email Anda."
        >
            Berlangganan newsletter SMKN 2 Cimahi untuk update kegiatan, prestasi, dan pengumuman sekolah.
            <form class="flex gap-2 mt-5" @submit.prevent>
                <input
                    type="email"
                    placeholder="email@anda.com"
                    class="flex-1 bg-bg/10 border border-bg/20 text-bg placeholder:text-bg/40 px-4 py-3 text-[13px] focus:outline-none focus:border-accent"
                    required
                />
                <button type="submit" class="bg-accent text-white px-5 py-3 font-mono text-xs font-semibold tracking-mono uppercase hover:bg-accent-dark transition-colors">
                    Subscribe →
                </button>
            </form>
        </Callout>
    </AppLayout>
</template>
