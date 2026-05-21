<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import PageHeader from '@/Components/UI/PageHeader.vue';
import SectionLabel from '@/Components/UI/SectionLabel.vue';
import Callout from '@/Components/UI/Callout.vue';

defineProps({
    summary:    { type: Array, default: () => [] },
    distribusi: { type: Array, default: () => [] },
    totalRow:   { type: Object, default: () => ({}) },
});
</script>

<template>
    <Head title="Rekap Siswa" />

    <AppLayout>
        <PageHeader
            :breadcrumbs="[
                { label: 'Beranda', href: '/' },
                { label: 'Kesiswaan' },
                { label: 'Rekap Siswa' },
            ]"
            meta="REKAPITULASI · TAHUN PELAJARAN BERJALAN"
            :title="`${summary[0]?.value ?? '—'} siswa, enam kompetensi, satu komunitas.`"
            lead="Data kesiswaan SMK Negeri 2 Cimahi — distribusi siswa berdasarkan program keahlian, jenjang kelas, dan jenis kelamin."
        />

        <!-- Summary cards per kelas -->
        <section class="container-page py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 border-t border-l border-line">
                <div
                    v-for="(s, i) in summary"
                    :key="i"
                    class="bg-white p-7 border-r border-b border-line"
                >
                    <div class="font-mono text-[11px] text-muted tracking-mono-wide uppercase mb-3">
                        {{ s.label }}
                    </div>
                    <div class="text-[44px] font-extrabold text-ink leading-none tracking-tightest mb-2">
                        {{ s.value }}
                    </div>
                    <div class="font-mono text-[11px] text-muted tracking-mono">{{ s.detail }}</div>
                </div>
            </div>
        </section>

        <!-- Distribusi bar chart -->
        <section class="container-page py-8">
            <SectionLabel num="1" title="Distribusi per Kompetensi Keahlian" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
                <h2 class="section-h2">
                    {{ distribusi[0]?.name ?? '—' }} menjadi kompetensi terbesar.
                </h2>
                <p class="section-sub">
                    Distribusi {{ totalRow.total }} siswa di enam program keahlian, diurutkan dari yang terbesar.
                </p>
            </div>

            <div class="space-y-2">
                <div
                    v-for="row in distribusi"
                    :key="row.code"
                    class="grid grid-cols-[1fr_60px_1fr_60px] sm:grid-cols-[240px_60px_1fr_60px] items-center gap-4 py-2 border-b border-line"
                >
                    <div class="text-[14px] font-medium text-ink">{{ row.name }}</div>
                    <div class="font-mono text-[11px] text-accent tracking-mono">{{ row.code }}</div>
                    <div class="relative h-7 bg-bg-alt">
                        <div
                            class="absolute inset-y-0 left-0 bg-ink text-bg flex items-center justify-end px-3 font-mono text-[11px] tracking-mono"
                            :style="{ width: row.bar + '%' }"
                        >
                            {{ row.pct }}%
                        </div>
                    </div>
                    <div class="font-mono text-[13px] font-semibold text-ink text-right">{{ row.total }}</div>
                </div>
            </div>
        </section>

        <!-- Tabel rekap per kompetensi × kelas akan dikembangkan -->
        <section class="container-page pt-8 pb-0">
            <SectionLabel num="2" title="Rekapitulasi per Kompetensi" />
            <div class="mb-10">
                <h2 class="section-h2">Tabel ringkas: rombel, gender, dan total per program.</h2>
            </div>
        </section>

        <div class="container-page pb-8 overflow-x-auto">
            <table class="w-full border-t border-l border-line text-[14px]">
                <thead class="bg-bg-alt font-mono text-[11px] text-muted tracking-mono-wide uppercase">
                    <tr>
                        <th class="border-r border-b border-line px-4 py-3 text-left w-12">No</th>
                        <th class="border-r border-b border-line px-4 py-3 text-left">Kompetensi Keahlian</th>
                        <th class="border-r border-b border-line px-4 py-3 text-right">Rombel</th>
                        <th class="border-r border-b border-line px-4 py-3 text-right">Laki-laki</th>
                        <th class="border-r border-b border-line px-4 py-3 text-right">Perempuan</th>
                        <th class="border-r border-b border-line px-4 py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr v-for="(row, i) in distribusi" :key="row.code">
                        <td class="border-r border-b border-line px-4 py-3 font-mono text-muted">{{ i + 1 }}</td>
                        <td class="border-r border-b border-line px-4 py-3 font-semibold text-ink">{{ row.name }}</td>
                        <td class="border-r border-b border-line px-4 py-3 text-right font-mono">{{ row.rombel }}</td>
                        <td class="border-r border-b border-line px-4 py-3 text-right font-mono">{{ row.L }}</td>
                        <td class="border-r border-b border-line px-4 py-3 text-right font-mono">{{ row.P }}</td>
                        <td class="border-r border-b border-line px-4 py-3 text-right font-mono font-semibold text-ink">{{ row.total }}</td>
                    </tr>
                </tbody>
                <tfoot class="bg-bg-alt font-mono text-[12px] font-bold text-ink tracking-mono">
                    <tr>
                        <td colspan="2" class="border-r border-b border-line px-4 py-3 uppercase">Total</td>
                        <td class="border-r border-b border-line px-4 py-3 text-right">{{ totalRow.rombel }}</td>
                        <td class="border-r border-b border-line px-4 py-3 text-right">{{ totalRow.L }}</td>
                        <td class="border-r border-b border-line px-4 py-3 text-right">{{ totalRow.P }}</td>
                        <td class="border-r border-b border-line px-4 py-3 text-right">{{ totalRow.total }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <Callout
            label="CATATAN DATA"
            title="Data per tahun pelajaran berjalan, diperbarui berkala."
        >
            Untuk informasi lebih detail mengenai rekapitulasi siswa per kelas, silakan menghubungi bagian
            Kesiswaan SMK Negeri 2 Cimahi atau email ke <strong>info@smkn2cmi.sch.id</strong>. Data resmi
            tersedia dalam dokumen rekapitulasi tahunan sekolah.
        </Callout>
    </AppLayout>
</template>
