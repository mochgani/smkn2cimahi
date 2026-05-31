<script setup>
import AppLayout from '@/Components/Layout/AppLayout.vue';
import PageHeader from '@/Components/UI/PageHeader.vue';
import SeoTag from '@/Components/UI/SeoTag.vue';

defineProps({
    kepala: { type: Object, required: true },
});
</script>

<template>
    <SeoTag
        title="Kepala Sekolah"
        :description="`Sambutan dari ${kepala.nama || 'Kepala Sekolah'}, ${kepala.jabatan || 'Kepala Sekolah'} SMK Negeri 2 Cimahi.`"
        :image="kepala.foto"
    />

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

        <section class="container-page py-8 sm:py-12 lg:pb-16">
            <div class="grid grid-cols-1 md:grid-cols-[260px_1fr] lg:grid-cols-[340px_1fr] gap-6 sm:gap-8 md:gap-10 lg:gap-16">
                <!-- Foto + Identitas -->
                <div class="max-w-[240px] sm:max-w-[280px] md:max-w-none mx-auto md:mx-0 w-full">
                    <div class="aspect-[3/4] overflow-hidden bg-line-soft border border-line mb-4 sm:mb-5">
                        <img
                            v-if="kepala.foto"
                            :src="kepala.foto"
                            :alt="`Foto ${kepala.nama}`"
                            loading="lazy"
                            decoding="async"
                            class="w-full h-full object-cover"
                        />
                        <div v-else class="w-full h-full flex items-center justify-center text-muted font-mono text-xs tracking-mono">
                            BELUM ADA FOTO
                        </div>
                    </div>
                    <div class="border-t border-line pt-3 sm:pt-4">
                        <div class="font-mono text-[10px] sm:text-[11px] text-accent tracking-mono mb-2">{{ kepala.jabatan }}</div>
                        <h2 class="text-[18px] sm:text-[20px] font-bold text-ink leading-tight tracking-tighter mb-1">
                            {{ kepala.nama }}
                        </h2>
                        <div v-if="kepala.nip" class="font-mono text-[10px] sm:text-[11px] text-muted tracking-mono">
                            NIP. {{ kepala.nip }}
                        </div>
                    </div>
                </div>

                <!-- Sambutan -->
                <article>
                    <div class="font-mono text-[11px] text-accent tracking-mono mb-2 sm:mb-3">[01] SAMBUTAN</div>
                    <h3 class="section-h2 mb-4 sm:mb-6">Selamat datang di SMK Negeri 2 Cimahi.</h3>
                    <div
                        class="prose prose-neutral max-w-none text-[14px] sm:text-[15px] lg:text-[16px] leading-relaxed text-ink-soft"
                        v-html="kepala.sambutan"
                    />
                </article>
            </div>
        </section>
    </AppLayout>
</template>
