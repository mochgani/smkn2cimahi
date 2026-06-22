<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import Breadcrumb from '@/Components/UI/Breadcrumb.vue';
import SectionLabel from '@/Components/UI/SectionLabel.vue';
import SeoTag from '@/Components/UI/SeoTag.vue';

const props = defineProps({
    kurikulum: { type: Object, required: true },
});
</script>

<template>
    <SeoTag
        :title="`Kurikulum — ${kurikulum.title}`"
        :description="kurikulum.lead"
    />

    <AppLayout>
        <!-- Hero / Page Header -->
        <section class="bg-ink text-bg relative overflow-hidden">
            <div class="container-page py-16 sm:py-20 lg:py-24 grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-10 lg:gap-16 items-start">
                <div>
                    <Breadcrumb
                        :items="[
                            { label: 'Beranda', href: '/' },
                            { label: 'Kurikulum' },
                            { label: 'Tentang' },
                        ]"
                        class="mb-6 [&_*]:text-bg/60 [&_a]:hover:text-bg"
                    />
                    <div class="inline-flex items-center gap-2 border border-bg/20 px-3 py-1 mb-6">
                        <span class="w-2 h-2 rounded-full bg-accent shrink-0"></span>
                        <span class="font-mono text-[10px] sm:text-[11px] text-bg/70 tracking-mono">
                            KURIKULUM · TENTANG
                        </span>
                    </div>
                    <h1 class="page-title text-bg mb-4">{{ kurikulum.title }}</h1>
                    <p class="page-lead text-bg/70 mb-8">{{ kurikulum.lead }}</p>
                    <div class="flex flex-wrap gap-3">
                        <Link href="/kurikulum/program-keahlian" class="btn-primary">
                            Jelajahi 6 Program Keahlian →
                        </Link>
                        <Link href="/kurikulum/struktur" class="inline-flex items-center gap-2 border border-bg/30 text-bg/80 hover:border-bg hover:text-bg transition-colors px-5 py-2.5 text-sm font-medium">
                            Lihat Struktur Kurikulum
                        </Link>
                    </div>
                </div>

                <!-- Spec Card -->
                <div class="bg-bg text-ink border border-line-soft lg:mt-4">
                    <div class="flex items-center justify-between px-5 py-3 border-b border-line">
                        <span class="font-bold text-[14px]">Profil Kurikulum</span>
                        <span class="font-mono text-[10px] text-muted tracking-mono uppercase">Ringkasan</span>
                    </div>
                    <div class="divide-y divide-line">
                        <div class="flex items-center justify-between px-5 py-3">
                            <span class="font-mono text-[11px] text-muted tracking-mono uppercase">Kurikulum</span>
                            <span class="font-semibold text-[14px]">{{ kurikulum.kurikulum_nama }}</span>
                        </div>
                        <div class="flex items-center justify-between px-5 py-3">
                            <span class="font-mono text-[11px] text-muted tracking-mono uppercase">Pendekatan</span>
                            <span class="font-semibold text-[14px]">{{ kurikulum.pendekatan }}</span>
                        </div>
                        <div class="flex items-center justify-between px-5 py-3">
                            <span class="font-mono text-[11px] text-muted tracking-mono uppercase">Program Keahlian</span>
                            <span class="font-bold text-[22px] text-accent leading-none">{{ kurikulum.jumlah_program }}</span>
                        </div>
                        <div class="flex items-center justify-between px-5 py-3">
                            <span class="font-mono text-[11px] text-muted tracking-mono uppercase">Porsi Praktik</span>
                            <span class="font-bold text-[22px] text-accent leading-none">{{ kurikulum.porsi_praktik }}</span>
                        </div>
                        <div class="flex items-center justify-between px-5 py-3">
                            <span class="font-mono text-[11px] text-muted tracking-mono uppercase">Mitra Industri</span>
                            <span class="font-bold text-[22px] text-accent leading-none">{{ kurikulum.jumlah_mitra }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Statistik Kunci -->
        <section v-if="kurikulum.stats?.length" class="container-page pt-16 pb-0">
            <SectionLabel num="01" title="Mengapa SMKN 2 Cimahi" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
                <h2 class="section-h2">Belajar yang relevan dengan dunia kerja.</h2>
                <p class="section-sub">Kami memadukan penguasaan teori, latihan praktik yang intensif, dan penanaman karakter untuk mencetak lulusan yang kompeten dan siap bersaing.</p>
            </div>
        </section>

        <div v-if="kurikulum.stats?.length" class="container-page pb-8">
            <div class="grid grid-cols-1 sm:grid-cols-3 border-t border-l border-line">
                <div
                    v-for="(stat, i) in kurikulum.stats"
                    :key="i"
                    class="bg-white border-r border-b border-line p-7 sm:p-8"
                >
                    <div class="font-mono text-[10px] text-muted tracking-mono mb-4">
                        [{{ String(i + 1).padStart(2, '0') }}]
                    </div>
                    <div class="font-bold leading-none mb-4" style="font-size: clamp(2.5rem, 6vw, 3.5rem)">
                        <span :class="stat.em ? 'text-accent' : 'text-ink'">{{ stat.num }}</span>
                        <span class="text-ink">{{ stat.satuan }}</span>
                    </div>
                    <h3 class="text-[16px] font-bold text-ink mb-2">{{ stat.cap }}</h3>
                    <p class="text-[13px] text-muted leading-relaxed">{{ stat.desc }}</p>
                </div>
            </div>
        </div>

        <!-- Filosofi / Pilar -->
        <section v-if="kurikulum.filosofi?.length" class="container-page pt-16 pb-0">
            <SectionLabel num="02" title="Pendekatan Pembelajaran" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
                <h2 class="section-h2">Tiga pilar yang membentuk lulusan unggul.</h2>
            </div>
        </section>

        <div v-if="kurikulum.filosofi?.length" class="container-page pb-16">
            <div class="grid grid-cols-1 sm:grid-cols-3 border-t border-l border-line">
                <div
                    v-for="(item, i) in kurikulum.filosofi"
                    :key="i"
                    class="bg-white border-r border-b border-line p-7"
                >
                    <div class="font-mono text-[28px] font-semibold text-accent tracking-tight mb-4 leading-none">
                        {{ item.num }}
                    </div>
                    <h3 class="text-[17px] font-bold text-ink mb-3">{{ item.title }}</h3>
                    <p class="text-[13px] text-muted leading-relaxed">{{ item.desc }}</p>
                </div>
            </div>
        </div>

        <!-- Sub-halaman -->
        <section class="container-page py-16 border-t border-line">
            <SectionLabel num="03" title="Jelajahi Lebih Lanjut" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
                <h2 class="section-h2">Semua informasi kurikulum dalam satu tempat.</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 border-t border-l border-line">
                <Link
                    v-for="link in [
                        { href: '/kurikulum/struktur',          label: 'Struktur Kurikulum',   desc: 'Fase E & F, kelompok mata pelajaran, dan alokasi jam.' },
                        { href: '/kurikulum/program-keahlian',  label: 'Program Keahlian',     desc: 'Profil 6 kompetensi keahlian yang tersedia.' },
                        { href: '/kurikulum/kelas-kerja-sama',  label: 'Kelas Kerja Sama',     desc: 'Mitra industri dalam penyelarasan kurikulum.' },
                        { href: '/kurikulum/teaching-factory',  label: 'Teaching Factory',     desc: 'Belajar sambil berproduksi di lingkungan industri.' },
                        { href: '/kurikulum/sertifikasi-pkl',   label: 'Sertifikasi & PKL',    desc: 'Sertifikat kompetensi dan praktik kerja lapangan.' },
                        { href: '/kurikulum/kalender',          label: 'Kalender Akademik',    desc: 'Jadwal dan agenda kegiatan akademik tahunan.' },
                    ]"
                    :key="link.href"
                    :href="link.href"
                    class="block p-7 border-r border-b border-line bg-white hover:bg-bg-alt transition-colors group"
                >
                    <h3 class="text-[15px] font-bold text-ink mb-2 group-hover:text-accent transition-colors">
                        {{ link.label }}
                    </h3>
                    <p class="text-[13px] text-muted leading-relaxed mb-4">{{ link.desc }}</p>
                    <span class="font-mono text-[11px] text-ink group-hover:text-accent">→</span>
                </Link>
            </div>
        </section>
    </AppLayout>
</template>
