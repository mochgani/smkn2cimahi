<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import PageHeader from '@/Components/UI/PageHeader.vue';
import SectionLabel from '@/Components/UI/SectionLabel.vue';
import Callout from '@/Components/UI/Callout.vue';

defineProps({
    unggulan: { type: Array, default: () => [] },
});
</script>

<template>
    <Head title="Profil Sekolah" />

    <AppLayout>
        <PageHeader
            :breadcrumbs="[
                { label: 'Beranda', href: '/' },
                { label: 'Profil' },
                { label: 'Profil Sekolah' },
            ]"
            meta="EST. 2007 · KOTA CIMAHI · JAWA BARAT"
            title="Sekolah kejuruan unggulan, lahir untuk industri."
            lead="SMK Negeri 2 Cimahi adalah sekolah menengah kejuruan negeri di Jawa Barat dengan enam program keahlian unggulan, fokus pada pendidikan vokasi berbasis kebutuhan dunia usaha dan industri (DUDI)."
        />

        <section class="prose-section">
            <aside class="prose-aside">[01] Sejarah</aside>
            <div class="prose-body">
                <h2>Sejarah singkat</h2>
                <p>SMK Negeri 2 Cimahi adalah salah satu SMK terbaik di Cimahi yang berkomitmen mencetak lulusan unggul dan siap kerja. Berlokasi strategis di wilayah utara Kota Cimahi, Jawa Barat, sekolah ini berdiri sejak tahun <strong>2007</strong>. Sejak saat itu, SMK Negeri 2 Cimahi telah berkembang pesat dan menempati lahan seluas <strong>15.609 m²</strong>.</p>
                <p>Sejak awal berdirinya, SMK Negeri 2 Cimahi telah menunjukkan perkembangan signifikan. Dari yang semula hanya membuka dua kompetensi keahlian, seiring berjalannya waktu kini telah berkembang menjadi sekolah kejuruan di Jawa Barat dengan enam program keahlian unggulan.</p>

                <h2>Enam program keahlian</h2>
                <p>Saat ini SMK Negeri 2 Cimahi membuka enam kompetensi keahlian yang sebagian besar merupakan program unggulan dengan kekhasan tersendiri:</p>
                <ul>
                    <li><strong>Teknik Elektronika</strong> — Konsentrasi Teknik Mekatronika</li>
                    <li><strong>Desain Komunikasi Visual (DKV)</strong></li>
                    <li><strong>Pengembangan Perangkat Lunak dan Gim</strong> — Konsentrasi Rekayasa Perangkat Lunak (RPL)</li>
                    <li><strong>Animasi</strong></li>
                    <li><strong>Teknik Kimia Industri</strong></li>
                    <li><strong>Teknik Mesin</strong> — Konsentrasi Teknik Pemesinan</li>
                </ul>

                <h2>Pendidikan vokasi berbasis industri</h2>
                <p>Sebagai SMK Negeri di Jawa Barat yang fokus pada pendidikan vokasi berbasis industri, SMK Negeri 2 Cimahi aktif menjalin kemitraan dengan berbagai perusahaan dan pelaku industri guna menyelaraskan kurikulum dengan kebutuhan Dunia Usaha dan Dunia Industri (DUDI).</p>
                <p>Melalui pendekatan berbasis industri dan inovasi pembelajaran modern, SMK Negeri 2 Cimahi terus bertransformasi menjadi rujukan utama bagi masyarakat yang mencari SMK berkualitas di Cimahi dengan lulusan yang siap bersaing di dunia kerja maupun melanjutkan ke jenjang pendidikan yang lebih tinggi.</p>
            </div>
        </section>

        <section class="container-page pt-6 sm:pt-8 pb-0">
            <SectionLabel num="2" title="Program Unggulan" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-12 mb-6 sm:mb-10">
                <h2 class="section-h2">Daya tarik utama, kemitraan industri yang nyata.</h2>
                <p class="section-sub">Beberapa program unggulan yang membedakan SMKN 2 Cimahi dengan SMK lainnya.</p>
            </div>
        </section>

        <div class="container-page">
            <div class="grid grid-cols-1 sm:grid-cols-2 border-t border-l border-line">
                <div v-for="u in unggulan" :key="u.num" class="highlight-card">
                    <div class="highlight-num">[{{ u.num }}] / {{ u.tag }}</div>
                    <h3 class="highlight-title">{{ u.title }}</h3>
                    <p class="highlight-desc">{{ u.desc }}</p>
                </div>
            </div>
        </div>

        <div class="mt-10 sm:mt-12 lg:mt-16" />

        <Callout
            label="INFORMASI SEKOLAH"
            title="Berlokasi strategis di Cimahi Utara, dengan fasilitas lengkap di lahan 1,6 hektar."
        >
            Jl. Kamarung KM 1.5 No.69, Kelurahan Citeureup, Kecamatan Cimahi Utara, Kota Cimahi 40512.
            Untuk informasi lebih lanjut hubungi <strong>+62 896 0520 1376</strong> atau email <strong>info@smkn2cmi.sch.id</strong>.
        </Callout>
    </AppLayout>
</template>
