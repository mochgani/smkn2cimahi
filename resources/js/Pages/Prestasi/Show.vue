<script setup>
import { ref, computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import PageHeader from '@/Components/UI/PageHeader.vue';
import SectionLabel from '@/Components/UI/SectionLabel.vue';
import Callout from '@/Components/UI/Callout.vue';

const props = defineProps({
    prestasi:      { type: Object, required: true },
    featured:      { type: Object, default: null },
    berita:        { type: Object, required: true },
    totalCount:    { type: Number, default: 0 },
    prestasiSiswa: { type: Object, default: null },
});

const tahunAjaranList = props.prestasiSiswa ? Object.keys(props.prestasiSiswa) : [];
const activeTahunAjaran = ref(tahunAjaranList[0] ?? null);
const activeTingkat = ref('Semua');

const tingkatBadgeClass = (tingkat) => ({
    Nasional: 'bg-accent/10 text-accent',
    Provinsi: 'bg-amber-500/10 text-amber-700',
    Kota:     'bg-line/60 text-muted-soft',
}[tingkat] || 'bg-line/60 text-muted-soft');

const activeList = computed(() => {
    if (!props.prestasiSiswa || !activeTahunAjaran.value) return [];
    const items = props.prestasiSiswa[activeTahunAjaran.value] ?? [];
    if (activeTingkat.value === 'Semua') return items;
    return items.filter((item) => item.tingkat === activeTingkat.value);
});

const goToPage = (url) => {
    if (!url) return;
    router.get(url, {}, {
        preserveScroll: true,
        preserveState: true,
        only: ['featured', 'berita', 'totalCount'],
    });
};

const breadcrumbMap = {
    'sekolah': [{ label: 'Prestasi' }, { label: 'Sekolah' }],
    'guru':    [{ label: 'Prestasi' }, { label: 'Guru' }],
    'siswa':   [{ label: 'Prestasi' }, { label: 'Siswa' }],
};

const breadcrumbs = [
    { label: 'Beranda', href: '/' },
    ...(breadcrumbMap[props.prestasi.slug?.replace('prestasi-', '')] || [{ label: props.prestasi.name }]),
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

        <!-- Daftar Prestasi Siswa (data terstruktur) -->
        <section v-if="prestasiSiswa" class="container-page py-8 sm:py-10 lg:py-12">
            <SectionLabel num="1" title="Daftar Prestasi Siswa" />
            <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                <h2 class="section-h2">Rekap kejuaraan &amp; penghargaan siswa.</h2>

                <div class="flex flex-wrap gap-2">
                    <button
                        v-for="tahun in tahunAjaranList"
                        :key="tahun"
                        type="button"
                        @click="activeTahunAjaran = tahun"
                        class="px-3 py-1.5 text-[12px] font-mono tracking-mono border transition-colors"
                        :class="activeTahunAjaran === tahun ? 'bg-ink text-bg border-ink' : 'border-line text-muted-soft hover:border-ink'"
                    >
                        {{ tahun }}
                    </button>
                </div>
            </div>

            <div class="flex flex-wrap gap-2 mb-6">
                <button
                    v-for="tingkat in ['Semua', 'Nasional', 'Provinsi', 'Kota']"
                    :key="tingkat"
                    type="button"
                    @click="activeTingkat = tingkat"
                    class="px-3 py-1 text-[11px] font-mono tracking-mono rounded-full border transition-colors"
                    :class="activeTingkat === tingkat ? 'bg-accent text-bg border-accent' : 'border-line text-muted-soft hover:border-accent'"
                >
                    {{ tingkat }}
                </button>
            </div>

            <div class="overflow-x-auto border border-line">
                <table class="w-full text-left text-[13px] min-w-[640px]">
                    <thead>
                        <tr class="bg-bg-alt border-b border-line font-mono text-[11px] tracking-mono text-muted uppercase">
                            <th class="px-4 py-3">Nama Siswa</th>
                            <th class="px-4 py-3">Kegiatan</th>
                            <th class="px-4 py-3">Waktu</th>
                            <th class="px-4 py-3">Peringkat</th>
                            <th class="px-4 py-3">Tingkat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, i) in activeList"
                            :key="i"
                            class="border-b border-line last:border-b-0 hover:bg-bg-alt/60 transition-colors"
                        >
                            <td class="px-4 py-3 font-medium text-ink">{{ item.nama_siswa }}</td>
                            <td class="px-4 py-3 text-muted-soft">
                                {{ item.judul_kegiatan }}
                                <span v-if="item.lokasi" class="block text-[11px] text-muted mt-0.5">{{ item.lokasi }}</span>
                            </td>
                            <td class="px-4 py-3 text-muted-soft whitespace-nowrap">{{ item.bulan_tahun || '—' }}</td>
                            <td class="px-4 py-3 text-muted-soft">{{ item.peringkat || '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-[11px] font-mono tracking-mono" :class="tingkatBadgeClass(item.tingkat)">
                                    {{ item.tingkat }}
                                </span>
                            </td>
                        </tr>
                        <tr v-if="!activeList.length">
                            <td colspan="5" class="px-4 py-10 text-center text-muted font-mono text-sm">
                                Tidak ada data untuk filter ini.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Featured berita -->
        <section v-if="featured" class="container-page py-8 sm:py-10 lg:py-12">
            <Link
                :href="`/berita/${featured.slug}`"
                class="block bg-white border border-line transition-colors hover:bg-bg-alt"
            >
                <div class="grid grid-cols-1 md:grid-cols-[1.4fr_1fr]">
                    <div class="order-2 md:order-1 p-5 sm:p-8 lg:p-10 xl:p-12">
                        <div class="inline-flex items-center gap-2 bg-bg-alt px-3 py-1 mb-4 sm:mb-6">
                            <span class="w-2 h-2 rounded-full bg-accent animate-pulse"></span>
                            <span class="font-mono text-[10px] sm:text-[11px] text-ink tracking-mono">TERBARU</span>
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
                        <div class="absolute bottom-3 left-3 sm:bottom-6 sm:left-6 bg-white/95 px-3 sm:px-5 py-2 sm:py-3.5 border border-line">
                            <div class="font-mono text-[9px] sm:text-[10px] text-muted tracking-mono-wide mb-1">PRESTASI</div>
                            <div class="font-mono text-[12px] sm:text-sm font-semibold text-ink tracking-mono">
                                {{ prestasi.name.toUpperCase() }}
                            </div>
                        </div>
                    </div>
                </div>
            </Link>
        </section>

        <!-- Grid berita -->
        <section class="container-page py-6 sm:py-8">
            <SectionLabel :num="prestasiSiswa ? '2' : '1'" :title="prestasi.name" />
            <div class="mb-6 sm:mb-10">
                <h2 v-if="berita.data.length || featured" class="section-h2">
                    {{ totalCount }} artikel dipublikasikan.
                </h2>
            </div>

            <div v-if="berita.data.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 border-t border-l border-line">
                <article
                    v-for="(item, i) in berita.data"
                    :key="item.slug"
                    class="bg-white border-r border-b border-line"
                >
                    <Link :href="`/berita/${item.slug}`" class="block p-5 sm:p-7 transition-colors hover:bg-bg-alt h-full">
                        <div class="font-mono text-[11px] text-accent tracking-mono mb-3">
                            [{{ String(i + (featured ? 2 : 1)).padStart(2, '0') }}]
                        </div>
                        <div class="flex items-center gap-2 sm:gap-3 font-mono text-[10px] sm:text-[11px] text-muted tracking-mono mb-3 sm:mb-4 flex-wrap">
                            <span>{{ item.date }}</span>
                            <span class="text-line">·</span>
                            <span>{{ item.categories.join(' · ') }}</span>
                        </div>
                        <h3 class="text-[15px] sm:text-[17px] font-bold text-ink leading-tight tracking-tighter mb-2 sm:mb-3">
                            {{ item.title }}
                        </h3>
                        <p class="text-[13px] text-muted-soft leading-relaxed line-clamp-3 mb-4 sm:mb-6">
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
            label="LIHAT JUGA"
            title="Telusuri semua kabar dari sekolah."
        >
            Untuk berita dari semua divisi & kompetensi, kunjungi
            <Link href="/berita" class="underline hover:text-accent">halaman berita</Link>.
        </Callout>
    </AppLayout>
</template>
