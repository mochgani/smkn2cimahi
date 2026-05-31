<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

const kontakSetting = computed(() => page.props.kontakSetting ?? {});
const schoolSetting = computed(() => page.props.schoolSetting ?? {});
const logoUrl = computed(() => schoolSetting.value.logo ? `/storage/${schoolSetting.value.logo}` : '/images/logo.png');

const profilLinks = [
    { href: '/profil/sekolah', label: 'Profil Sekolah' },
    { href: '/profil/visi-misi', label: 'Visi & Misi' },
    { href: '/profil/kesiswaan', label: 'Kesiswaan' },
    { href: '/profil/bkk', label: 'Bursa Kerja Khusus' },
];

const alamatKanal = computed(() => kontakSetting.value.kanal?.find(k => k.label === 'ALAMAT'));
const teleponKanal = computed(() => kontakSetting.value.kanal?.find(k => k.label === 'TELEPON'));
const emailKanal = computed(() => kontakSetting.value.kanal?.find(k => k.label === 'EMAIL'));
const socialLinks = computed(() => kontakSetting.value.social ?? []);
</script>

<template>
    <footer class="bg-ink text-bg mt-16 sm:mt-20 lg:mt-24 pt-12 sm:pt-16 lg:pt-20 pb-6 sm:pb-8">
        <div class="container-page grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-10 lg:gap-12 pb-8 sm:pb-12 lg:pb-14 border-b border-white/10">
            <div>
                <img :src="logoUrl" :alt="`Logo ${schoolSetting.school_name ?? 'SMKN 2 Cimahi'}`" loading="lazy" decoding="async" class="w-14 h-14 object-contain brightness-110 mb-4" />
                <div class="text-lg font-bold mb-2">{{ schoolSetting.school_name ?? 'SMK Negeri 2 Cimahi' }}</div>
                <p class="font-mono text-xs text-white/60 tracking-mono mb-4">{{ schoolSetting.tagline ?? 'BMW: Bekerja · Melanjutkan · Wirausaha' }}</p>
                <p class="font-mono text-[11px] text-accent tracking-mono-wide">EST. {{ schoolSetting.tahun_berdiri ?? '2007' }}</p>
            </div>

            <div>
                <div class="font-mono text-[11px] text-white/50 tracking-mono-wide uppercase mb-5">Kontak</div>
                <div v-if="kontakSetting.maps_address_full" class="text-[13px] text-white/85 leading-relaxed mb-4 whitespace-pre-line">
                    {{ kontakSetting.maps_address_full }}
                </div>
                <p class="text-[13px] text-white/85 leading-relaxed">
                    <template v-if="teleponKanal">
                        <a :href="teleponKanal.href" class="hover:text-accent">{{ teleponKanal.value }}</a><br>
                    </template>
                    <template v-if="emailKanal">
                        <a :href="emailKanal.href" class="hover:text-accent">{{ emailKanal.value }}</a>
                    </template>
                </p>
            </div>

            <div>
                <div class="font-mono text-[11px] text-white/50 tracking-mono-wide uppercase mb-5">Profil</div>
                <Link
                    v-for="link in profilLinks"
                    :key="link.href"
                    :href="link.href"
                    class="block text-[13px] text-white/85 hover:text-accent py-1"
                >
                    {{ link.label }}
                </Link>
            </div>

            <div v-if="socialLinks.length">
                <div class="font-mono text-[11px] text-white/50 tracking-mono-wide uppercase mb-5">Sosial Media</div>
                <a
                    v-for="link in socialLinks"
                    :key="link.href"
                    :href="link.href"
                    target="_blank"
                    rel="noopener"
                    class="block text-[13px] text-white/85 hover:text-accent py-1"
                >
                    {{ link.label }}
                </a>
            </div>
        </div>

        <div class="container-page mt-6 sm:mt-8 flex flex-col md:flex-row justify-between md:items-center font-mono text-[10px] sm:text-[11px] text-white/50 tracking-mono gap-2 sm:gap-4">
            <span>{{ schoolSetting.copyright ?? '© 2026 SMK NEGERI 2 CIMAHI' }}</span>
            <span class="hidden md:inline">SEKOLAH MENENGAH KEJURUAN NEGERI</span>
            <span v-if="schoolSetting.nss || schoolSetting.npsn">
                <template v-if="schoolSetting.nss">NSS {{ schoolSetting.nss }}</template>
                <template v-if="schoolSetting.nss && schoolSetting.npsn"> / </template>
                <template v-if="schoolSetting.npsn">NPSN {{ schoolSetting.npsn }}</template>
            </span>
        </div>
    </footer>
</template>
