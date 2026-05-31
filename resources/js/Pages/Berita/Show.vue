<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import Breadcrumb from '@/Components/UI/Breadcrumb.vue';
import SectionLabel from '@/Components/UI/SectionLabel.vue';
import Callout from '@/Components/UI/Callout.vue';
import SeoTag from '@/Components/UI/SeoTag.vue';

const props = defineProps({
    berita: { type: Object, required: true },
    related: { type: Array, default: () => [] },
});

// JSON-LD Article schema
const articleSchema = computed(() => ({
    '@context': 'https://schema.org',
    '@type': 'NewsArticle',
    headline: props.berita.title,
    description: props.berita.excerpt,
    image: props.berita.cover_image
        ? (typeof window !== 'undefined' ? window.location.origin : '') + props.berita.cover_image
        : undefined,
    datePublished: props.berita.date_iso,
    author: {
        '@type': 'Person',
        name: props.berita.author?.name || 'Tim Penulis',
    },
    articleSection: props.berita.categories?.[0] || 'Berita',
}));
</script>

<template>
    <SeoTag
        :title="berita.title"
        :description="berita.excerpt"
        :image="berita.cover_image"
        type="article"
        :published-at="berita.date_iso"
        :author="berita.author?.name || 'Tim Penulis'"
        :section="berita.categories?.[0] || 'Berita'"
        :schema="articleSchema"
    />

    <AppLayout>
        <article class="container-page pt-8 sm:pt-10 lg:pt-12 pb-6 sm:pb-8">
            <header class="max-w-[860px]">
                <Breadcrumb
                    :items="[
                        { label: 'Beranda', href: '/' },
                        { label: 'Berita', href: '/berita' },
                        { label: berita.title.length > 30 ? berita.title.slice(0, 30) + '…' : berita.title },
                    ]"
                    class="mb-4 sm:mb-6"
                />

                <div class="flex items-center gap-2 mb-4 sm:mb-6 flex-wrap">
                    <span
                        v-for="cat in berita.categories"
                        :key="cat"
                        class="inline-block px-2.5 sm:px-3 py-1 bg-bg-alt font-mono text-[10px] sm:text-[11px] text-ink tracking-mono uppercase"
                    >
                        {{ cat }}
                    </span>
                </div>

                <h1 class="text-[26px] sm:text-3xl md:text-4xl lg:text-5xl font-extrabold text-ink leading-[1.1] tracking-tightest mb-6 sm:mb-8">
                    {{ berita.title }}
                </h1>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 pb-6 sm:pb-8 border-b border-line">
                    <div>
                        <div class="font-mono text-[10px] text-muted tracking-mono-wide uppercase mb-1">Ditulis Oleh</div>
                        <div class="text-[13px] sm:text-[14px] font-semibold text-ink">{{ berita.author?.name ?? 'Tim Penulis' }}</div>
                    </div>
                    <div>
                        <div class="font-mono text-[10px] text-muted tracking-mono-wide uppercase mb-1">Tanggal</div>
                        <div class="text-[13px] sm:text-[14px] font-semibold text-ink">{{ berita.date_full }}</div>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <div class="font-mono text-[10px] text-muted tracking-mono-wide uppercase mb-1">Durasi Baca</div>
                        <div class="text-[13px] sm:text-[14px] font-semibold text-ink">{{ berita.reading_time }}</div>
                    </div>
                </div>
            </header>

            <div class="relative min-h-[200px] sm:min-h-[280px] md:min-h-[400px] my-8 sm:my-10 lg:my-12 bg-line-soft overflow-hidden">
                <img
                    v-if="berita.cover_image"
                    :src="berita.cover_image"
                    :alt="berita.title"
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
                        style="background: radial-gradient(circle at 30% 30%, rgba(13,110,63,0.18) 0%, transparent 55%);"
                    ></div>
                </div>
                <div class="absolute bottom-3 left-3 sm:bottom-6 sm:left-6 bg-white/95 px-3 sm:px-5 py-2 sm:py-3.5 border border-line">
                    <div class="font-mono text-[20px] sm:text-[26px] font-bold text-ink tracking-tight leading-none mb-1">
                        {{ new Date(berita.date_iso).getFullYear() }}
                    </div>
                    <div class="font-mono text-[9px] sm:text-[10px] text-muted tracking-mono-wide uppercase">
                        {{ berita.categories[0] || 'BERITA' }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-[200px_1fr] gap-6 lg:gap-12">
                <aside class="lg:sticky lg:top-24 self-start hidden lg:block">
                    <div class="font-mono text-[11px] text-muted tracking-mono-wide uppercase mb-4">Bagikan</div>
                    <div class="flex gap-2">
                        <a href="#" class="w-9 h-9 border border-line flex items-center justify-center font-mono text-[11px] text-ink hover:bg-ink hover:text-bg transition-colors">FB</a>
                        <a href="#" class="w-9 h-9 border border-line flex items-center justify-center font-mono text-[11px] text-ink hover:bg-ink hover:text-bg transition-colors">IG</a>
                        <a href="#" class="w-9 h-9 border border-line flex items-center justify-center font-mono text-[11px] text-ink hover:bg-ink hover:text-bg transition-colors">WA</a>
                        <a href="#" class="w-9 h-9 border border-line flex items-center justify-center font-mono text-[11px] text-ink hover:bg-ink hover:text-bg transition-colors">X</a>
                    </div>
                </aside>

                <div class="prose-body" v-html="berita.content" />
            </div>
        </article>

        <section class="container-page pt-12 pb-0">
            <SectionLabel num="3" title="Berita Terkait" />
            <div class="flex items-end justify-between mb-10 flex-wrap gap-4">
                <div>
                    <h2 class="section-h2">Mungkin Anda juga tertarik.</h2>
                    <p class="section-sub mt-2">Tiga berita lainnya yang baru-baru ini diterbitkan.</p>
                </div>
                <Link href="/berita" class="font-mono text-[13px] text-ink hover:text-accent">Semua Berita →</Link>
            </div>
        </section>

        <div class="container-page">
            <div class="grid grid-cols-1 md:grid-cols-3 border-t border-l border-line">
                <article
                    v-for="(item, i) in related"
                    :key="item.slug"
                    class="bg-white border-r border-b border-line"
                >
                    <Link :href="`/berita/${item.slug}`" class="block p-6 transition-colors hover:bg-bg-alt h-full">
                        <div class="font-mono text-[11px] text-accent tracking-mono mb-3">
                            [{{ String(i + 1).padStart(2, '0') }}]
                        </div>
                        <div class="flex items-center gap-3 font-mono text-[11px] text-muted tracking-mono mb-3">
                            <span>{{ item.date }}</span>
                            <span class="text-line">·</span>
                            <span>{{ item.categories.join(' · ') }}</span>
                        </div>
                        <h3 class="text-[15px] font-bold text-ink leading-tight tracking-tighter mb-4">
                            {{ item.title }}
                        </h3>
                        <div class="text-[12px] text-muted mb-4">Oleh {{ item.author?.name ?? 'Tim Penulis' }}</div>
                        <div class="font-mono text-[11px] text-ink tracking-mono">→</div>
                    </Link>
                </article>
            </div>
        </div>

        <div class="mt-16" />

        <Callout
            label="PUNYA BERITA UNTUK DIBAGIKAN?"
            title="Hubungi tim redaksi SMKN 2 Cimahi."
        >
            Untuk kontribusi berita, kerja sama media, atau press release dari kegiatan sekolah, silakan
            hubungi <strong>info@smkn2cmi.sch.id</strong> atau <strong>+62 896 0520 1376</strong>.
            Tim editorial akan dengan senang hati merespons dalam 1×24 jam kerja.
        </Callout>
    </AppLayout>
</template>
