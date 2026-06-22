<template>
  <AppLayout>
    <SeoTag
      :title="`${tefa.title} – Kurikulum SMKN 2 Cimahi`"
      :description="tefa.lead"
    />

    <!-- Hero -->
    <section class="bg-ink text-bg py-16 md:py-24">
      <div class="container-page">
        <SectionLabel label="Kurikulum" class="text-accent mb-4" />
        <h1 class="page-title font-bold mb-4">{{ tefa.title }}</h1>
        <p class="text-bg/70 max-w-2xl text-base md:text-lg leading-relaxed">{{ tefa.lead }}</p>

        <!-- Stats -->
        <div v-if="tefa.stats.length" class="mt-10 grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-2xl">
          <div v-for="stat in tefa.stats" :key="stat.label" class="text-center">
            <p class="text-3xl md:text-4xl font-bold text-accent">{{ stat.angka }}</p>
            <p class="text-sm text-bg/60 mt-1">{{ stat.label }}</p>
          </div>
        </div>

        <!-- Breadcrumb -->
        <nav class="mt-8 flex items-center gap-2 text-sm text-bg/50">
          <Link href="/" class="hover:text-bg transition-colors">Beranda</Link>
          <span>/</span>
          <Link href="/kurikulum" class="hover:text-bg transition-colors">Kurikulum</Link>
          <span>/</span>
          <span class="text-bg/80">Teaching Factory</span>
        </nav>
      </div>
    </section>

    <!-- Tagline + About -->
    <section class="py-16 md:py-24">
      <div class="container-page max-w-4xl">
        <blockquote v-if="tefa.tagline" class="text-xl md:text-2xl font-semibold text-accent italic border-l-4 border-accent pl-6 mb-10">
          "{{ tefa.tagline }}"
        </blockquote>
        <!-- eslint-disable-next-line vue/no-v-html -->
        <div v-if="tefa.about" class="prose prose-lg max-w-none text-muted leading-relaxed" v-html="tefa.about" />
      </div>
    </section>

    <!-- Produk TEFA -->
    <section v-if="tefa.produk.length" class="py-16 md:py-20 bg-bg-alt">
      <div class="container-page">
        <SectionLabel label="Unit Produksi" class="mb-3" />
        <h2 class="section-h2 font-bold text-ink mb-10">Produk & Layanan</h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="(produk, i) in tefa.produk"
            :key="i"
            class="bg-bg border border-line rounded-2xl p-6 hover:shadow-md hover:border-accent/30 transition-all"
          >
            <div class="flex items-center gap-3 mb-4">
              <span class="w-9 h-9 rounded-full bg-accent text-bg text-sm font-bold flex items-center justify-center flex-shrink-0">
                {{ String(i + 1).padStart(2, '0') }}
              </span>
              <span class="text-xs font-semibold uppercase tracking-widest text-accent bg-accent/10 px-3 py-1 rounded-full">
                {{ produk.kompetensi }}
              </span>
            </div>
            <h3 class="font-bold text-ink mb-2">{{ produk.nama }}</h3>
            <p class="text-sm text-muted leading-relaxed">{{ produk.deskripsi }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Fasilitas -->
    <section v-if="tefa.fasilitas.length" class="py-16 md:py-20">
      <div class="container-page">
        <SectionLabel label="Infrastruktur" class="mb-3" />
        <h2 class="section-h2 font-bold text-ink mb-10">Fasilitas Produksi</h2>

        <div class="grid md:grid-cols-2 gap-5">
          <div
            v-for="(fas, i) in tefa.fasilitas"
            :key="i"
            class="flex gap-4 p-6 rounded-xl border border-line bg-bg hover:border-accent/30 transition-colors"
          >
            <div class="w-10 h-10 rounded-lg bg-accent/10 text-accent flex items-center justify-center flex-shrink-0 mt-0.5">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
              </svg>
            </div>
            <div>
              <h3 class="font-semibold text-ink mb-1">{{ fas.nama }}</h3>
              <p class="text-sm text-muted leading-relaxed">{{ fas.deskripsi }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-bg-alt border-t border-line">
      <div class="container-page">
        <Callout
          label="Kolaborasi TEFA"
          title="Tertarik Bermitra dengan Unit Produksi Kami?"
          description="Hubungi kami untuk informasi lebih lanjut tentang kerja sama produksi, magang, atau pengembangan produk bersama."
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
  tefa: { type: Object, required: true },
})

const subLinks = [
  { href: '/kurikulum', label: 'Tentang Kurikulum', active: false },
  { href: '/kurikulum/struktur', label: 'Struktur Kurikulum', active: false },
  { href: '/kurikulum/program-keahlian', label: 'Program Keahlian', active: false },
  { href: '/kurikulum/kelas-kerja-sama', label: 'Kelas Kerja Sama', active: false },
  { href: '/kurikulum/teaching-factory', label: 'Teaching Factory', active: true },
  { href: '/kurikulum/sertifikasi-pkl', label: 'Sertifikasi & PKL', active: false },
  { href: '/kurikulum/kalender', label: 'Kalender Akademik', active: false },
]
</script>
