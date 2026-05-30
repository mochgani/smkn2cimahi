<script setup>
import AppLayout from '@/Components/Layout/AppLayout.vue';
import PageHeader from '@/Components/UI/PageHeader.vue';
import Callout from '@/Components/UI/Callout.vue';
import SeoTag from '@/Components/UI/SeoTag.vue';

const props = defineProps({
    visi: { type: String, default: '' },
    misi: { type: Array, default: () => [] },
    tujuan: { type: Array, default: () => [] },
});
</script>

<template>
    <SeoTag
        title="Visi & Misi"
        :description="visi || 'Visi, misi, dan tujuan SMK Negeri 2 Cimahi sebagai sekolah unggulan di Cimahi.'"
    />

    <AppLayout>
        <PageHeader
            :breadcrumbs="[
                { label: 'Beranda', href: '/' },
                { label: 'Profil' },
                { label: 'Visi & Misi' },
            ]"
            meta="ARAH STRATEGIS · 2026 — 2029"
            title="Visi, misi, dan tujuan yang menuntun setiap langkah."
            lead="Komitmen SMK Negeri 2 Cimahi dalam mencetak lulusan yang berkompetensi teknologi, mampu berwirausaha, religius, dan berkarakter sesuai budaya bangsa."
        />

        <section class="statement-block">
            <aside>
                <div class="statement-num">01</div>
                <div class="statement-label">VISI · TUJUAN 2029</div>
            </aside>
            <div>
                <p class="statement-text">{{ visi }}</p>
            </div>
        </section>

        <section v-if="misi.length" class="statement-block">
            <aside>
                <div class="statement-num">02</div>
                <div class="statement-label">MISI · {{ misi.length }} PILAR</div>
            </aside>
            <div>
                <ol class="list-decimal list-outside pl-5 space-y-3 text-[16px] leading-relaxed text-ink-soft max-w-[720px]">
                    <li v-for="(item, i) in misi" :key="i">{{ item }}</li>
                </ol>
            </div>
        </section>

        <section v-if="tujuan.length" class="statement-block">
            <aside>
                <div class="statement-num">03</div>
                <div class="statement-label">TUJUAN · TARGET LULUSAN</div>
            </aside>
            <div>
                <ol class="list-decimal list-outside pl-5 space-y-3 text-[16px] leading-relaxed text-ink-soft max-w-[720px]">
                    <li v-for="(item, i) in tujuan" :key="i">{{ item }}</li>
                </ol>
            </div>
        </section>

        <div class="mt-12" />

        <Callout
            label="MOTTO SEKOLAH"
            title="BMW — Bekerja, Melanjutkan, Wirausaha."
        >
            Tiga jalur yang ditawarkan SMKN 2 Cimahi kepada lulusannya: siap memasuki dunia kerja sebagai
            tenaga profesional, melanjutkan pendidikan ke jenjang lebih tinggi, atau memulai usaha sendiri
            sebagai wirausahawan mandiri.
        </Callout>
    </AppLayout>
</template>
