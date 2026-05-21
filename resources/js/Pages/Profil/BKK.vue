<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import PageHeader from '@/Components/UI/PageHeader.vue';
import SectionLabel from '@/Components/UI/SectionLabel.vue';
import Callout from '@/Components/UI/Callout.vue';

defineProps({
    tujuan: { type: Array, default: () => [] },
    perusahaan: { type: Array, default: () => [] },
    lowongan: { type: Array, default: () => [] },
});
</script>

<template>
    <Head title="Bursa Kerja Khusus" />

    <AppLayout>
        <PageHeader
            :breadcrumbs="[
                { label: 'Beranda', href: '/' },
                { label: 'Profil' },
                { label: 'Bursa Kerja Khusus' },
            ]"
            meta="BKK · MITRA DINAS TENAGA KERJA"
            title="Jembatan antara lulusan dengan dunia kerja."
            lead="Bursa Kerja Khusus (BKK) SMKN 2 Cimahi adalah unit pelaksana yang memberikan pelayanan dan informasi lowongan kerja, pemasaran, penyaluran, dan penempatan tenaga kerja."
        />

        <section class="prose-section">
            <aside class="prose-aside">[01] Tentang BKK</aside>
            <div class="prose-body">
                <h2>Apa itu Bursa Kerja Khusus?</h2>
                <p>Bursa Kerja Khusus (BKK) adalah sebuah lembaga yang dibentuk di Sekolah Menengah Kejuruan Negeri dan Swasta, sebagai unit pelaksana yang memberikan pelayanan dan informasi lowongan kerja, pelaksana pemasaran, penyaluran, dan penempatan tenaga kerja, merupakan <strong>mitra Dinas Tenaga Kerja dan Transmigrasi</strong>.</p>
                <p>BKK SMK Negeri 2 Cimahi berperan sebagai penghubung antara lulusan dengan industri, memastikan setiap tamatan mendapatkan kesempatan terbaik untuk berkarir di bidang yang sesuai dengan kompetensi mereka.</p>
            </div>
        </section>

        <section class="container-page pt-8 pb-0">
            <SectionLabel num="2" title="Tujuan Pembentukan" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
                <h2 class="section-h2">Empat tujuan utama yang menjadi pilar kerja BKK.</h2>
                <p class="section-sub">Setiap aktivitas BKK dirancang untuk menyiapkan lulusan menghadapi dunia kerja secara profesional.</p>
            </div>
        </section>

        <div class="container-page">
            <div class="grid grid-cols-1 sm:grid-cols-2 border-t border-l border-line">
                <div v-for="t in tujuan" :key="t.num" class="highlight-card">
                    <div class="highlight-num">[{{ t.num }}] / {{ t.tag }}</div>
                    <h3 class="highlight-title">{{ t.title }}</h3>
                    <p class="highlight-desc">{{ t.desc }}</p>
                </div>
            </div>
        </div>

        <section class="container-page pt-16 pb-0">
            <SectionLabel num="3" title="Perusahaan Mitra" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
                <h2 class="section-h2">11 perusahaan industri menjadi mitra strategis BKK.</h2>
                <p class="section-sub">Daftar perusahaan yang bekerja sama dengan SMK Negeri 2 Cimahi dalam penyaluran tenaga kerja lulusan.</p>
            </div>
        </section>

        <div class="container-page">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 border-t border-l border-line">
                <div
                    v-for="(name, i) in perusahaan"
                    :key="i"
                    class="bg-white border-r border-b border-line px-5 py-6 flex items-center gap-4"
                >
                    <span class="font-mono text-[11px] text-accent tracking-mono">{{ String(i + 1).padStart(2, '0') }}</span>
                    <span class="text-[14px] font-medium text-ink">{{ name }}</span>
                </div>
                <div class="bg-bg-alt border-r border-b border-line px-5 py-6 flex items-center gap-4">
                    <span class="font-mono text-[14px] text-accent tracking-mono">+</span>
                    <span class="text-[14px] font-semibold text-accent">Dan terus bertambah</span>
                </div>
            </div>
        </div>

        <section class="container-page pt-16 pb-0">
            <SectionLabel num="4" title="Informasi Lowongan" />
            <div class="flex items-end justify-between mb-10 flex-wrap gap-4">
                <div>
                    <h2 class="section-h2">Lowongan kerja terbaru dari mitra industri.</h2>
                    <p class="section-sub mt-2">Informasi lowongan diperbarui secara berkala oleh tim BKK SMKN 2 Cimahi.</p>
                </div>
                <a href="#" class="font-mono text-[13px] text-ink hover:text-accent">Lihat Semua →</a>
            </div>
        </section>

        <div class="container-page">
            <div class="grid grid-cols-1 md:grid-cols-3 border-t border-l border-line">
                <article
                    v-for="(l, i) in lowongan"
                    :key="i"
                    class="bg-white border-r border-b border-line p-7 transition-colors hover:bg-bg-alt"
                >
                    <div class="flex items-center gap-3 font-mono text-[11px] tracking-mono mb-4">
                        <span class="text-accent">{{ l.status }}</span>
                        <span class="text-line">·</span>
                        <span class="text-muted">{{ l.category }}</span>
                    </div>
                    <h3 class="text-base font-bold text-ink leading-tight tracking-tighter mb-6">{{ l.title }}</h3>
                    <a href="#" class="font-mono text-[11px] text-ink tracking-mono hover:text-accent">Detail →</a>
                </article>
            </div>
        </div>

        <div class="mt-16" />

        <Callout
            label="HUBUNGI BKK"
            title="Tertarik bermitra atau mencari talenta lulusan SMKN 2 Cimahi?"
        >
            Untuk informasi lebih lanjut mengenai kerja sama BKK, peluang lowongan, atau penyaluran lulusan,
            silakan hubungi <strong>+62 896 0520 1376</strong> atau email <strong>info@smkn2cmi.sch.id</strong>.
            Tim BKK siap mendukung kebutuhan rekrutmen perusahaan Anda.
        </Callout>
    </AppLayout>
</template>
