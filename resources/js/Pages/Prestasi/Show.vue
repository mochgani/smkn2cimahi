<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import PageHeader from '@/Components/UI/PageHeader.vue';
import SectionLabel from '@/Components/UI/SectionLabel.vue';
import Callout from '@/Components/UI/Callout.vue';

const props = defineProps({
    prestasi:   { type: Object, required: true },
    featured:   { type: Object, default: null },
    berita:     { type: Object, required: true },
    totalCount: { type: Number, default: 0 },
});

const goToPage = (url) => {
    if (!url) return;
    router.get(url, {}, { preserveScroll: true, preserveState: true });
};

const breadcrumbMap = {
    'Prestasi Sekolah': [{ label: 'Prestasi', href: null }, { label: 'Sekolah' }],
    'Prestasi Guru':    [{ label: 'Prestasi', href: null }, { label: 'Guru' }],
    'Prestasi Siswa':   [{ label: 'Prestasi', href: null }, { label: 'Siswa' }],
};

const breadcrumbs = [
    { label: 'Beranda', href: '/' },
    ...(breadcrumbMap[props.prestasi.name] ?? [{ label: props.prestasi.name }]),
];
</script>

<template>
    <Head :title="prestasi.name" />

    <AppLayout>
        <PageHeader
            :breadcrumbs="breadcrumbs"
            :meta="`${totalCount} ARTIKEL · ${prestasi.name.toUpperCase()}`"
            :title="`${prestasi.name} SMK Negeri 2 Cimahi.`"
            :lead="prestasi.description"
        />

        <!-- Featured berita -->
        <section v-if="featured" class="container-page py-12">
            <Link
                :href="`/berita/${featured.slug}`"
                class="block bg-white border border-line transition-colors hover:bg-bg-alt"
            >
                <div class="grid grid-cols-1 md:grid-cols-[1.4fr_1fr]">
                    <div class="p-10 lg:p-12">
                        <div class="inline-flex items-center gap-2 bg-bg-alt px-3 py-1 mb-6">
                            <span class="w-2 h-2 rounded-full bg-accent animate-pulse"></span>
                            <span class="font-mono text-[11px] text-ink tracking-mono">TERBARU</span>
                        </div>
                        <div class="flex items-center gap-3 font-mono text-[11px] text-muted tracking-mono mb-4">
                            <span>{{ featured.date_full }}</span>
                            <span class="text-line">·</span>
                            <span>{{ featured.categories.join(' · ') }}</span>
                        </div>
                        <h2 class="text-3xl lg:text-4xl font-extrabold text-ink leading-tight tracking-tighter mb-5">
                            {{ featured.title }}
                        </h2>
                        <p class="text-[15px] text-muted-soft leading-relaxed mb-6">{{ featured.excerpt }}</p>
                        <div class="inline-flex items-center gap-2 font-mono text-[13px] text-ink">
                            Baca Selengkapnya <span>→</span>
                        </div>
                    </div>
                    <div
                        class="relative min-h-[280px] md:min-h-[400px] bg-line-soft"
                        style="background-image: repeating-linear-gradient(135deg, #e8e6e0 0 14px, #d4d0c5 14px 28px);"
                    >
                        <div
                            class="absolute inset-0"
                            style="background: radial-gradient(circle at 30% 30%, rgba(13,110,63,0.15) 0%, transparent 50%);"
                        ></div>
                        <div class="absolute bottom-6 left-6 bg-white/95 px-5 py-3.5 border border-line">
                            <div class="font-mono text-[10px] text-muted tracking-mono-wide mb-1">PRESTASI</div>
                            <div class="font-mono text-sm font-semibold text-ink tracking-mono">
                                {{ prestasi.name.toUpperCase() }}
                            </div>
                        </div>
                    </div>
                </div>
            </Link>
        </section>

        <!-- Grid berita -->
        <section class="container-page py-8">
            <SectionLabel num="1" :title="prestasi.name" />
            <div class="mb-10">
                <h2 v-if="berita.data.length || featured" class="section-h2">
                    {{ totalCount }} artikel dipublikasikan.
                </h2>
            </div>

            <div v-if="berita.data.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 border-t border-l border-line">
                <article
                    v-for="(item, i) in berita.data"
                    :key="item.slug"
                    class="bg-white border-r border-b border-line"
                >
                    <Link :href="`/berita/${item.slug}`" class="block p-7 transition-colors hover:bg-bg-alt h-full">
                        <div class="font-mono text-[11px] text-accent tracking-mono mb-3">
                            [{{ String(i + (featured ? 2 : 1)).padStart(2, '0') }}]
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
                        <div class="flex items-center justify-between font-mono text-[11px] tracking-mono">
                            <span class="text-muted">{{ item.reading_time }} baca</span>
                            <span class="text-ink">→</span>
                        </div>
                    </Link>
                </article>
            </div>

            <div v-else-if="!featured" class="py-20 text-center text-muted font-mono text-sm border border-dashed border-line">
                Belum ada berita kategori {{ prestasi.name }}.
            </div>

            <!-- Pagination -->
            <div
                v-if="berita.last_page > 1"
                class="flex justify-between items-center mt-12 font-mono text-[12px] tracking-mono flex-wrap gap-4"
            >
                <button
                    type="button"
                    :disabled="!berita.prev_page_url"
                    @click="goToPage(berita.prev_page_url)"
                    class="px-4 py-2 border border-line transition-colors"
                    :class="berita.prev_page_url ? 'text-ink hover:border-ink' : 'text-muted cursor-not-allowed'"
                >
                    ← Prev
                </button>
                <div class="flex items-center gap-2">
                    <template v-for="(link, i) in berita.links.slice(1, -1)" :key="i">
                        <button
                            v-if="link.url"
                            type="button"
                            @click="goToPage(link.url)"
                            class="w-9 h-9 transition-colors"
                            :class="link.active ? 'bg-ink text-bg' : 'border border-line text-ink hover:border-ink'"
                            v-html="link.label"
                        />
                        <span v-else class="text-muted px-2" v-html="link.label" />
                    </template>
                </div>
                <button
                    type="button"
                    :disabled="!berita.next_page_url"
                    @click="goToPage(berita.next_page_url)"
                    class="px-4 py-2 border border-line transition-colors"
                    :class="berita.next_page_url ? 'text-ink hover:border-ink' : 'text-muted cursor-not-allowed'"
                >
                    Next →
                </button>
            </div>
        </section>

        <Callout
            label="LIHAT JUGA"
            title="Telusuri semua kabar dari sekolah."
        >
            Untuk berita dari semua divisi & kompetensi, kunjungi
            <Link href="/berita" class="underline hover:text-accent">halaman berita</Link>.
        </Callout>
    </AppLayout>
</template>
