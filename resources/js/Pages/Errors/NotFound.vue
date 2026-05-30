<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import SeoTag from '@/Components/UI/SeoTag.vue';
</script>

<template>
    <SeoTag
        title="Halaman Tidak Ditemukan"
        description="Halaman yang Anda cari tidak tersedia. Kembali ke beranda SMK Negeri 2 Cimahi."
    />

    <AppLayout>
        <section class="container-page py-24 lg:py-32">
            <div class="max-w-[640px]">
                <div class="font-mono text-[11px] text-accent tracking-mono-wide uppercase mb-6">
                    ERROR 404
                </div>

                <h1 class="text-[64px] lg:text-[96px] font-extrabold text-ink leading-[1] tracking-tightest mb-6">
                    Halaman tidak ditemukan.
                </h1>

                <p class="text-lg text-muted-soft leading-relaxed mb-10 max-w-[560px]">
                    Halaman yang Anda cari mungkin sudah dipindah, dihapus,
                    atau URL yang Anda masukkan tidak benar. Mari kembali ke jalur yang benar.
                </p>

                <div class="flex flex-wrap gap-4 mb-16">
                    <Link href="/" class="btn-primary">
                        Kembali ke Beranda <span aria-hidden="true">→</span>
                    </Link>
                    <Link href="/berita" class="btn-secondary">
                        Lihat Berita Terbaru
                    </Link>
                </div>

                <!-- Quick links -->
                <div class="border-t border-line pt-10">
                    <div class="font-mono text-[10px] text-muted tracking-mono-wide uppercase mb-5">
                        Cari yang lain?
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <Link
                            v-for="link in [
                                { href: '/profil/sejarah',    label: '/profil/sejarah',    desc: 'Sejarah sekolah' },
                                { href: '/profil/visi-misi',  label: '/profil/visi-misi',  desc: 'Visi & Misi' },
                                { href: '/kompetensi/animasi', label: '/kompetensi/...',   desc: 'Kompetensi Keahlian' },
                                { href: '/kontak',            label: '/kontak',            desc: 'Hubungi kami' },
                            ]"
                            :key="link.href"
                            :href="link.href"
                            class="block p-4 border border-line bg-white hover:bg-bg-alt transition-colors group"
                        >
                            <div class="font-mono text-[11px] text-accent tracking-mono mb-1 group-hover:underline">
                                {{ link.label }}
                            </div>
                            <div class="text-[13px] text-ink">{{ link.desc }}</div>
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
