<template>
  <AppLayout>
    <SeoTag
      title="Kelas Kerja Sama – Kurikulum SMKN 2 Cimahi"
      description="Daftar mitra industri dan perusahaan yang berkolaborasi dalam program Kelas Kerja Sama SMKN 2 Cimahi."
    />

    <!-- Hero -->
    <section class="bg-ink text-bg py-16 md:py-24">
      <div class="container-page">
        <SectionLabel label="Kurikulum" class="text-accent mb-4" />
        <h1 class="page-title font-bold mb-4">Kelas Kerja Sama</h1>
        <p class="text-bg/70 max-w-2xl text-base md:text-lg leading-relaxed">
          Program kolaborasi antara SMKN 2 Cimahi dengan mitra industri untuk menghadirkan pengalaman belajar
          yang relevan, nyata, dan berstandar industri bagi peserta didik.
        </p>

        <!-- Breadcrumb -->
        <nav class="mt-6 flex items-center gap-2 text-sm text-bg/50">
          <Link href="/" class="hover:text-bg transition-colors">Beranda</Link>
          <span>/</span>
          <Link href="/kurikulum" class="hover:text-bg transition-colors">Kurikulum</Link>
          <span>/</span>
          <span class="text-bg/80">Kelas Kerja Sama</span>
        </nav>
      </div>
    </section>

    <!-- Mitra List -->
    <section class="py-16 md:py-24">
      <div class="container-page">
        <div v-if="mitras.length === 0" class="text-center py-20 text-muted">
          <p class="text-lg">Belum ada data mitra kerja sama.</p>
        </div>

        <div v-else class="space-y-12">
          <article
            v-for="(mitra, index) in mitras"
            :key="mitra.id"
            class="group grid md:grid-cols-[200px_1fr] gap-8 items-start p-8 rounded-2xl border border-line bg-bg hover:border-accent/30 hover:shadow-lg transition-all duration-300"
          >
            <!-- Logo -->
            <div class="flex items-center justify-center bg-line/30 rounded-xl p-6 h-32 md:h-40">
              <img
                v-if="mitra.logo"
                :src="mitra.logo"
                :alt="`Logo ${mitra.nama}`"
                class="max-h-full max-w-full object-contain"
                loading="lazy"
                decoding="async"
              />
              <span v-else class="text-3xl font-bold text-muted/50">
                {{ initials(mitra.nama) }}
              </span>
            </div>

            <!-- Info -->
            <div>
              <div class="flex flex-wrap items-start gap-3 mb-3">
                <span class="text-xs font-semibold uppercase tracking-widest text-accent bg-accent/10 px-3 py-1 rounded-full">
                  {{ mitra.field }}
                </span>
                <span class="text-xs text-muted">Mitra {{ String(index + 1).padStart(2, '0') }}</span>
              </div>

              <h2 class="text-xl md:text-2xl font-bold text-ink mb-3">{{ mitra.nama }}</h2>

              <p class="text-muted leading-relaxed mb-5">{{ mitra.desc }}</p>

              <div v-if="mitra.tags.length" class="flex flex-wrap gap-2">
                <span
                  v-for="tag in mitra.tags"
                  :key="tag"
                  class="text-xs px-3 py-1 rounded-full border border-line text-muted bg-bg"
                >
                  {{ tag }}
                </span>
              </div>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-bg-alt border-t border-line">
      <div class="container-page">
        <Callout
          label="Bergabung sebagai Mitra"
          title="Ingin Berkolaborasi dengan SMKN 2 Cimahi?"
          description="Kami terbuka untuk kemitraan baru. Hubungi kami untuk mendiskusikan bentuk kerja sama yang sesuai."
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
          <Link
            v-for="link in subLinks"
            :key="link.href"
            :href="link.href"
            class="px-4 py-2 text-sm rounded-lg border border-line text-muted hover:border-accent hover:text-accent transition-colors"
            :class="{ 'border-accent text-accent font-semibold': link.active }"
          >
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
  mitras: { type: Array, default: () => [] },
})

function initials(name) {
  return name
    .split(' ')
    .slice(0, 2)
    .map(w => w[0])
    .join('')
    .toUpperCase()
}

const subLinks = [
  { href: '/kurikulum', label: 'Tentang Kurikulum', active: false },
  { href: '/kurikulum/struktur', label: 'Struktur Kurikulum', active: false },
  { href: '/kurikulum/program-keahlian', label: 'Program Keahlian', active: false },
  { href: '/kurikulum/kelas-kerja-sama', label: 'Kelas Kerja Sama', active: true },
  { href: '/kurikulum/teaching-factory', label: 'Teaching Factory', active: false },
  { href: '/kurikulum/sertifikasi-pkl', label: 'Sertifikasi & PKL', active: false },
  { href: '/kurikulum/kalender', label: 'Kalender Akademik', active: false },
]
</script>
