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

    <!-- Calendar -->
    <section class="py-12 md:py-16">
      <div class="container-page">
        <div v-if="kalender.has_source">
          <!-- Toolbar -->
          <div class="flex items-center justify-between flex-wrap gap-4 mb-6">
            <div class="flex items-center gap-3">
              <Link
                :href="monthUrl(month.prevYear, month.prevMonth)"
                class="w-9 h-9 flex items-center justify-center rounded-lg border border-line hover:border-accent hover:text-accent transition-colors"
                aria-label="Bulan sebelumnya"
              >‹</Link>
              <h2 class="text-lg md:text-xl font-bold text-ink w-40 md:w-48 text-center">{{ month.label }}</h2>
              <Link
                :href="monthUrl(month.nextYear, month.nextMonth)"
                class="w-9 h-9 flex items-center justify-center rounded-lg border border-line hover:border-accent hover:text-accent transition-colors"
                aria-label="Bulan berikutnya"
              >›</Link>
              <Link
                :href="monthUrl(month.todayYear, month.todayMonth)"
                class="ml-2 px-3 py-1.5 text-xs font-mono tracking-mono rounded-lg border border-line text-muted-soft hover:border-accent hover:text-accent transition-colors"
              >Hari Ini</Link>
            </div>

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

          <p v-if="calendarError" class="mb-4 text-sm bg-amber-50 text-amber-700 border border-amber-200 rounded-lg px-4 py-3">
            {{ calendarError }}
          </p>

          <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-6">
            <!-- Grid -->
            <div class="border border-line rounded-2xl overflow-hidden">
              <div class="grid grid-cols-7 bg-bg-alt border-b border-line">
                <div
                  v-for="d in dayLabels"
                  :key="d"
                  class="py-2 text-center font-mono text-[11px] tracking-mono text-muted uppercase"
                >{{ d }}</div>
              </div>

              <div class="grid grid-cols-7">
                <button
                  v-for="day in gridDays"
                  :key="day.date"
                  type="button"
                  @click="selectedDate = day.date"
                  class="min-h-[84px] sm:min-h-[100px] border-b border-r border-line last:border-r-0 p-2 text-left align-top transition-colors"
                  :class="[
                    day.isCurrentMonth ? 'bg-bg' : 'bg-bg-alt/40 text-muted/50',
                    selectedDate === day.date ? 'ring-2 ring-accent ring-inset' : 'hover:bg-bg-alt/60',
                  ]"
                >
                  <span
                    class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-mono"
                    :class="day.isToday ? 'bg-accent text-bg font-bold' : (day.isCurrentMonth ? 'text-ink' : 'text-muted/60')"
                  >{{ day.dayNumber }}</span>

                  <div class="mt-1 space-y-0.5">
                    <div
                      v-for="ev in (eventsByDate[day.date] || []).slice(0, 2)"
                      :key="ev.id"
                      class="text-[10px] leading-tight px-1.5 py-0.5 rounded bg-accent/10 text-accent truncate"
                    >{{ ev.title }}</div>
                    <div
                      v-if="(eventsByDate[day.date] || []).length > 2"
                      class="text-[10px] text-muted font-mono"
                    >+{{ (eventsByDate[day.date] || []).length - 2 }} lainnya</div>
                  </div>
                </button>
              </div>
            </div>

            <!-- Agenda panel -->
            <div class="border border-line rounded-2xl p-5">
              <h3 class="font-mono text-[11px] tracking-mono uppercase text-muted mb-1">Agenda</h3>
              <p class="font-bold text-ink mb-4">{{ selectedDateLabel }}</p>

              <div v-if="selectedEvents.length" class="space-y-4">
                <div v-for="ev in selectedEvents" :key="ev.id" class="pb-4 border-b border-line last:border-0 last:pb-0">
                  <p class="font-semibold text-ink text-sm mb-1">{{ ev.title }}</p>
                  <p class="text-xs text-muted font-mono tracking-mono mb-1">
                    {{ ev.all_day ? 'Sepanjang hari' : formatTimeRange(ev) }}
                  </p>
                  <p v-if="ev.location" class="text-xs text-muted-soft">📍 {{ ev.location }}</p>
                  <p v-if="ev.description" class="text-xs text-muted-soft mt-1 line-clamp-3">{{ ev.description }}</p>
                </div>
              </div>
              <p v-else class="text-sm text-muted italic">Tidak ada agenda pada tanggal ini.</p>
            </div>
          </div>

          <p v-if="kalender.catatan" class="mt-6 text-sm text-muted italic">
            {{ kalender.catatan }}
          </p>
        </div>

        <!-- No calendar configured yet -->
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
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Components/Layout/AppLayout.vue'
import SeoTag from '@/Components/UI/SeoTag.vue'
import SectionLabel from '@/Components/UI/SectionLabel.vue'

const props = defineProps({
  kalender: { type: Object, required: true },
  events: { type: Array, default: () => [] },
  eventsByDate: { type: Object, default: () => ({}) },
  calendarError: { type: String, default: null },
  month: { type: Object, required: true },
})

const dayLabels = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab']

function toDateStr(d) {
  return d.toISOString().slice(0, 10)
}

const todayStr = (() => {
  const now = new Date()
  return `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}-${String(now.getDate()).padStart(2, '0')}`
})()

const gridDays = computed(() => {
  const days = []
  const start = new Date(props.month.gridStart + 'T00:00:00')
  const end = new Date(props.month.gridEnd + 'T00:00:00')
  const cursor = new Date(start)

  while (cursor <= end) {
    const dateStr = toDateStr(cursor)
    days.push({
      date: dateStr,
      dayNumber: cursor.getDate(),
      isCurrentMonth: (cursor.getMonth() + 1) === props.month.month,
      isToday: dateStr === todayStr,
    })
    cursor.setDate(cursor.getDate() + 1)
  }

  return days
})

const defaultSelected = computed(() => {
  const inGrid = gridDays.value.find(d => d.date === todayStr && d.isCurrentMonth)
  if (inGrid) return inGrid.date
  const firstWithEvent = gridDays.value.find(d => d.isCurrentMonth && (props.eventsByDate[d.date] || []).length)
  if (firstWithEvent) return firstWithEvent.date
  const firstOfMonth = gridDays.value.find(d => d.isCurrentMonth)
  return firstOfMonth ? firstOfMonth.date : null
})

const selectedDate = ref(defaultSelected.value)

const selectedEvents = computed(() => props.eventsByDate[selectedDate.value] || [])

const selectedDateLabel = computed(() => {
  if (!selectedDate.value) return '—'
  const d = new Date(selectedDate.value + 'T00:00:00')
  return d.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })
})

function formatTimeRange(ev) {
  const start = new Date(ev.start)
  const end = new Date(ev.end)
  const opts = { hour: '2-digit', minute: '2-digit' }
  return `${start.toLocaleTimeString('id-ID', opts)} – ${end.toLocaleTimeString('id-ID', opts)}`
}

function monthUrl(year, month) {
  return `/kurikulum/kalender?year=${year}&month=${month}`
}

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
