<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import PageHeader from '@/Components/UI/PageHeader.vue';

defineProps({
    kepala: { type: Object, required: true },
});
</script>

<template>
    <Head title="Kepala Sekolah" />

    <AppLayout>
        <PageHeader
            :breadcrumbs="[
                { label: 'Beranda', href: '/' },
                { label: 'Profil' },
                { label: 'Kepala Sekolah' },
            ]"
            meta="PROFIL · SAMBUTAN KEPALA SEKOLAH"
            title="Sambutan Kepala Sekolah."
            lead="Pesan resmi dari pimpinan SMK Negeri 2 Cimahi untuk seluruh warga sekolah dan pengunjung website."
        />

        <section class="container-page pb-16">
            <div class="grid grid-cols-1 md:grid-cols-[280px_1fr] lg:grid-cols-[340px_1fr] gap-10 lg:gap-16">
                <!-- Foto + Identitas -->
                <div>
                    <div class="aspect-[3/4] overflow-hidden bg-line-soft border border-line mb-5">
                        <img
                            v-if="kepala.foto"
                            :src="kepala.foto"
                            :alt="`Foto ${kepala.nama}`"
                            class="w-full h-full object-cover"
                        />
                        <div v-else class="w-full h-full flex items-center justify-center text-muted font-mono text-xs tracking-mono">
                            BELUM ADA FOTO
                        </div>
                    </div>
                    <div class="border-t border-line pt-4">
                        <div class="font-mono text-[11px] text-accent tracking-mono mb-2">{{ kepala.jabatan }}</div>
                        <h2 class="text-[20px] font-bold text-ink leading-tight tracking-tighter mb-1">
                            {{ kepala.nama }}
                        </h2>
                        <div v-if="kepala.nip" class="font-mono text-[11px] text-muted tracking-mono">
                            NIP. {{ kepala.nip }}
                        </div>
                    </div>
                </div>

                <!-- Sambutan -->
                <article>
                    <div class="font-mono text-[11px] text-accent tracking-mono mb-3">[01] SAMBUTAN</div>
                    <h3 class="section-h2 mb-6">Selamat datang di SMK Negeri 2 Cimahi.</h3>
                    <div
                        class="prose prose-neutral max-w-none text-[16px] leading-relaxed text-ink-soft"
                        v-html="kepala.sambutan"
                    />
                </article>
            </div>
        </section>
    </AppLayout>
</template>
