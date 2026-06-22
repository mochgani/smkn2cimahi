<script setup>
import AppLayout from '@/Components/Layout/AppLayout.vue';
import PageHeader from '@/Components/UI/PageHeader.vue';
import SectionLabel from '@/Components/UI/SectionLabel.vue';
import SeoTag from '@/Components/UI/SeoTag.vue';

defineProps({
    struktur: { type: Object, required: true },
});
</script>

<template>
    <SeoTag
        :title="`Struktur Kurikulum — SMK Negeri 2 Cimahi`"
        :description="struktur.lead"
    />

    <AppLayout>
        <PageHeader
            :breadcrumbs="[
                { label: 'Beranda', href: '/' },
                { label: 'Kurikulum', href: '/kurikulum' },
                { label: 'Struktur Kurikulum' },
            ]"
            meta="KURIKULUM · STRUKTUR"
            :title="struktur.title"
            :lead="struktur.lead"
        />

        <!-- Fase E & F -->
        <section v-if="struktur.phases?.length" class="container-page pt-16 pb-0">
            <SectionLabel num="01" title="Fase Kurikulum" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
                <h2 class="section-h2">Pembelajaran bertahap dari fondasi ke keahlian.</h2>
                <p class="section-sub">Kurikulum Merdeka membagi pembelajaran ke dalam dua fase utama yang memastikan siswa siap sebelum mendalami konsentrasi keahlian.</p>
            </div>
        </section>

        <div v-if="struktur.phases?.length" class="container-page pb-10">
            <div class="grid grid-cols-1 md:grid-cols-2 border-t border-l border-line">
                <div
                    v-for="(phase, i) in struktur.phases"
                    :key="i"
                    class="bg-white border-r border-b border-line p-8 relative overflow-hidden"
                >
                    <!-- Nomor fase besar di background -->
                    <div class="absolute top-4 right-6 font-bold text-[80px] leading-none text-line select-none pointer-events-none">
                        {{ phase.step }}
                    </div>
                    <div class="relative">
                        <div class="font-mono text-[10px] text-accent tracking-mono uppercase mb-2">
                            {{ phase.kelas }}
                        </div>
                        <h3 class="text-[22px] font-bold text-ink mb-4">{{ phase.title }}</h3>
                        <p class="text-[14px] text-muted leading-relaxed">{{ phase.desc }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kelompok Mata Pelajaran -->
        <section v-if="struktur.groups?.length" class="container-page pt-12 pb-0">
            <SectionLabel num="02" title="Kelompok Mata Pelajaran" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
                <h2 class="section-h2">Tiga kelompok yang membentuk kurikulum utuh.</h2>
            </div>
        </section>

        <div v-if="struktur.groups?.length" class="container-page pb-10">
            <div class="grid grid-cols-1 sm:grid-cols-3 border-t border-l border-line">
                <div
                    v-for="(group, i) in struktur.groups"
                    :key="i"
                    class="bg-white border-r border-b border-line p-7"
                >
                    <div class="w-1 h-8 bg-accent mb-5"></div>
                    <h3 class="text-[16px] font-bold text-ink mb-2">{{ group.title }}</h3>
                    <p class="text-[13px] text-muted leading-relaxed">{{ group.desc }}</p>
                </div>
            </div>
        </div>

        <!-- Tabel Alokasi Jam -->
        <section v-if="struktur.allocation?.length" class="container-page pt-12 pb-0">
            <SectionLabel num="03" title="Alokasi Jam Pelajaran" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
                <h2 class="section-h2">Distribusi jam per kelompok mata pelajaran.</h2>
            </div>
        </section>

        <div v-if="struktur.allocation?.length" class="container-page pb-16">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-line text-[13px] min-w-[560px]">
                    <thead>
                        <tr class="bg-ink text-bg">
                            <th class="text-left px-5 py-3 font-mono text-[11px] tracking-mono uppercase border-r border-white/10 w-[180px]">
                                Kelompok
                            </th>
                            <th class="text-left px-5 py-3 font-mono text-[11px] tracking-mono uppercase border-r border-white/10">
                                Contoh Mata Pelajaran
                            </th>
                            <th class="text-left px-5 py-3 font-mono text-[11px] tracking-mono uppercase w-[160px]">
                                Alokasi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(row, i) in struktur.allocation"
                            :key="i"
                            class="border-b border-line hover:bg-bg-alt transition-colors"
                        >
                            <td class="px-5 py-3.5 font-medium text-ink border-r border-line">
                                {{ row.kelompok }}
                            </td>
                            <td class="px-5 py-3.5 text-muted border-r border-line">
                                {{ row.mata_pelajaran || '—' }}
                            </td>
                            <td class="px-5 py-3.5 font-mono text-[12px] text-muted">
                                {{ row.alokasi || '—' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
