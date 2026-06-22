<template>
  <AppLayout>
    <SeoTag
      :title="`${kalender.title} – SMKN 2 Cimahi`"
      :description="kalender.lead"
    />

    <!-- Hero -->
    <section class="bg-ink text-bg py-16 md:py-20">
      <div class="container-page">
        <SectionLabel label="Kurikulum" class="text-accent mb-4" />
        <h1 class="page-title font-bold mb-4">{{ kalender.title }}</h1>
        <p class="text-bg/70 max-w-2xl text-base md:text-lg leading-relaxed">{{ kalender.lead }}</p>

        <nav class="mt-6 flex items-center gap-2 text-sm text-bg/50">
          <Link href="/" class="hover:text-bg transition-colors">Beranda</Link>
          <span>/</span>
          <Link href="/kurikulum" class="hover:text-bg transition-colors">Kurikulum</Link>
          <span>/</span>
          <span class="text-bg/80">Kalender Akademik</span>
        </nav>
      </div>
    </section>

    <!-- Calendar Embed -->
    <section class="py-12 md:py-16">
      <div class="container-page">
        <!-- Has embed URL -->
        <div v-if="kalender.embed_url">
          <div class="flex items-center justify-between mb-4 flex-wrap gap-3">
            <h2 class="text-lg font-semibold text-ink">Agenda Sekolah</h2>
            <a
              v-if="kalender.public_url"
              :href="kalender.public_url"
              target="_blank"
              rel="noopener noreferrer"
              class="btn-outline text-sm inline-flex items-center gap-2"
            >
              Buka di Google Calendar
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
              </svg>
            </a>
          </div>

          <div class="rounded-2xl border border-line overflow-hidden shadow-sm">
            <iframe
              :src="kalender.embed_url"
              style="border: 0"
              width="100%"
              height="600"
              frameborder="0"
              scrolling="no"
              title="Kalender Akademik SMKN 2 Cimahi"
              loading="lazy"
            />
          </div>

          <p v-if="kalender.catatan" class="mt-4 text-sm text-muted italic">
            {{ kalender.catatan }}
          </p>
        </div>

        <!-- No embed URL yet -->
        <div v-else class="text-center py-20 max-w-lg mx-auto">
          <div class="w-16 h-16 rounded-2xl bg-accent/10 text-accent flex items-center justify-center mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
            </svg>
          </div>
          <h2 class="text-xl font-bold text-ink mb-3">Kalender belum tersedia</h2>
          <p class="text-muted mb-6">
            Kalender akademik digital sedang dalam persiapan. Untuk informasi jadwal, silakan hubungi bagian Kurikulum SMKN 2 Cimahi.
          </p>
          <p v-if="kalender.catatan" class="text-sm text-muted italic mb-6">{{ kalender.catatan }}</p>
          <Link href="/kontak" class="btn-primary inline-block">Hubungi Kami</Link>
        </div>
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

defineProps({
  kalender: { type: Object, required: true },
})

const subLinks = [
  { href: '/kurikulum', label: 'Tentang Kurikulum', active: false },
  { href: '/kurikulum/struktur', label: 'Struktur Kurikulum', active: false },
  { href: '/kurikulum/program-keahlian', label: 'Program Keahlian', active: false },
  { href: '/kurikulum/kelas-kerja-sama', label: 'Kelas Kerja Sama', active: false },
  { href: '/kurikulum/teaching-factory', label: 'Teaching Factory', active: false },
  { href: '/kurikulum/sertifikasi-pkl', label: 'Sertifikasi & PKL', active: false },
  { href: '/kurikulum/kalender', label: 'Kalender Akademik', active: true },
]
</script>
