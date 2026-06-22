<template>
  <AppLayout>
    <SeoTag
      :title="`${data.title} – Kurikulum SMKN 2 Cimahi`"
      :description="data.lead"
    />

    <!-- Hero -->
    <section class="bg-ink text-bg py-16 md:py-24">
      <div class="container-page">
        <SectionLabel label="Kurikulum" class="text-accent mb-4" />
        <h1 class="page-title font-bold mb-4">{{ data.title }}</h1>
        <p class="text-bg/70 max-w-2xl text-base md:text-lg leading-relaxed">{{ data.lead }}</p>

        <nav class="mt-6 flex items-center gap-2 text-sm text-bg/50">
          <Link href="/" class="hover:text-bg transition-colors">Beranda</Link>
          <span>/</span>
          <Link href="/kurikulum" class="hover:text-bg transition-colors">Kurikulum</Link>
          <span>/</span>
          <span class="text-bg/80">Sertifikasi & PKL</span>
        </nav>
      </div>
    </section>

    <!-- Sertifikasi -->
    <section v-if="data.sertifikasi.length" class="py-16 md:py-24">
      <div class="container-page">
        <SectionLabel label="Kompetensi Tersertifikasi" class="mb-3" />
        <h2 class="section-h2 font-bold text-ink mb-10">Sertifikasi Kompetensi</h2>

        <div class="grid md:grid-cols-2 gap-6">
          <div
            v-for="(sert, i) in data.sertifikasi"
            :key="i"
            class="p-6 rounded-2xl border border-line bg-bg hover:border-accent/30 hover:shadow-md transition-all"
          >
            <div class="flex items-start justify-between gap-3 mb-4">
              <div class="w-10 h-10 rounded-full bg-accent text-bg font-bold text-sm flex items-center justify-center flex-shrink-0">
                {{ String(i + 1).padStart(2, '0') }}
              </div>
              <span class="text-xs font-semibold uppercase tracking-widest text-accent bg-accent/10 px-3 py-1 rounded-full whitespace-nowrap">
                {{ sert.kompetensi }}
              </span>
            </div>
            <h3 class="font-bold text-ink mb-1">{{ sert.nama }}</h3>
            <p class="text-xs text-accent font-medium mb-3">{{ sert.lembaga }}</p>
            <p class="text-sm text-muted leading-relaxed">{{ sert.deskripsi }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- PKL -->
    <section class="py-16 md:py-24 bg-bg-alt border-y border-line">
      <div class="container-page">
        <SectionLabel label="Pengalaman Industri" class="mb-3" />
        <h2 class="section-h2 font-bold text-ink mb-6">Praktik Kerja Lapangan</h2>

        <!-- Info Cards -->
        <div class="grid grid-cols-2 md:grid-cols-2 gap-4 mb-10 max-w-sm">
          <div class="bg-bg border border-line rounded-xl p-5 text-center">
            <p class="text-3xl font-bold text-accent">{{ data.pkl_durasi }}</p>
            <p class="text-xs text-muted mt-1">Durasi PKL</p>
          </div>
          <div class="bg-bg border border-line rounded-xl p-5 text-center">
            <p class="text-3xl font-bold text-accent">{{ data.pkl_min_nilai }}</p>
            <p class="text-xs text-muted mt-1">Nilai Minimum</p>
          </div>
        </div>

        <p v-if="data.pkl_deskripsi" class="text-muted leading-relaxed max-w-3xl mb-12">
          {{ data.pkl_deskripsi }}
        </p>

        <!-- Alur PKL -->
        <div v-if="data.alur_pkl.length">
          <h3 class="text-lg font-bold text-ink mb-6">Alur Pelaksanaan PKL</h3>
          <div class="relative">
            <!-- Vertical line -->
            <div class="absolute left-5 top-10 bottom-10 w-px bg-line hidden md:block" />

            <div class="space-y-6">
              <div
                v-for="(alur, i) in data.alur_pkl"
                :key="i"
                class="flex gap-5 items-start"
              >
                <div class="w-10 h-10 rounded-full bg-accent text-bg font-bold text-sm flex items-center justify-center flex-shrink-0 relative z-10">
                  {{ alur.step }}
                </div>
                <div class="flex-1 pb-2">
                  <h4 class="font-semibold text-ink mb-1">{{ alur.judul }}</h4>
                  <p class="text-sm text-muted leading-relaxed">{{ alur.deskripsi }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-bg">
      <div class="container-page">
        <Callout
          label="Hubungan Industri"
          title="Informasi PKL & Penempatan Siswa"
          description="Untuk informasi penempatan PKL, jadwal, dan persyaratan, silakan hubungi bagian Hubungan Industri SMKN 2 Cimahi."
          cta-label="Hubungi Kami"
          cta-href="/kontak"
        />
      </div>
    </section>

    <!-- Sub-page Navigation -->
    <section class="py-12 border-t border-line">
      <div class="container-page">
        <p class="text-sm text-muted mb-4 font-medium uppercase tracking-widest">Halaman Kurikulum</p>
        <div class="flex flex-wrap gap-3">
          <Link v-for="link in subLinks" :key="link.href" :href="link.href"
            class="px-4 py-2 text-sm rounded-lg border border-line text-muted hover:border-accent hover:text-accent transition-colors"
            :class="{ 'border-accent text-accent font-semibold': link.active }">
            {{ link.label }}
          </Link>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Components/Layout/AppLayout.vue'
import SeoTag from '@/Components/UI/SeoTag.vue'
import SectionLabel from '@/Components/UI/SectionLabel.vue'
import Callout from '@/Components/UI/Callout.vue'

defineProps({
  data: { type: Object, required: true },
})

const subLinks = [
  { href: '/kurikulum', label: 'Tentang Kurikulum', active: false },
  { href: '/kurikulum/struktur', label: 'Struktur Kurikulum', active: false },
  { href: '/kurikulum/program-keahlian', label: 'Program Keahlian', active: false },
  { href: '/kurikulum/kelas-kerja-sama', label: 'Kelas Kerja Sama', active: false },
  { href: '/kurikulum/teaching-factory', label: 'Teaching Factory', active: false },
  { href: '/kurikulum/sertifikasi-pkl', label: 'Sertifikasi & PKL', active: true },
  { href: '/kurikulum/kalender', label: 'Kalender Akademik', active: false },
]
</script>
