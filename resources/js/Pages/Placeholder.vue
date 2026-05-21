<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import PageHeader from '@/Components/UI/PageHeader.vue';

defineProps({
    title: { type: String, required: true },
    breadcrumb: { type: String, default: '' },
    description: { type: String, default: 'Halaman ini sedang dalam pengembangan. Konten akan segera tersedia.' },
});
</script>

<template>
    <Head :title="title" />

    <AppLayout>
        <PageHeader
            :meta="breadcrumb || title"
            :title="title"
            :lead="description"
        />

        <section class="container-page py-16">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                <div class="md:col-span-8">
                    <div class="border border-line bg-white p-10 text-center">
                        <div class="font-mono text-[11px] text-accent tracking-mono mb-4">
                            [DALAM PENGEMBANGAN]
                        </div>
                        <h2 class="text-2xl font-bold text-ink mb-4">
                            Halaman {{ title }} segera hadir
                        </h2>
                        <p class="text-muted-soft leading-relaxed">
                            {{ description }}
                        </p>
                    </div>
                </div>

                <aside class="md:col-span-4">
                    <div class="border border-line p-6 bg-bg-alt">
                        <div class="font-mono text-[11px] text-accent tracking-mono mb-3">INFORMASI</div>
                        <p class="text-sm text-muted-soft leading-relaxed">
                            Halaman ini akan diisi konten oleh tim sekolah. Untuk pertanyaan, silakan
                            hubungi kami melalui halaman <a href="/kontak" class="text-accent hover:underline">Kontak</a>.
                        </p>
                    </div>
                </aside>
            </div>
        </section>
    </AppLayout>
</template>
