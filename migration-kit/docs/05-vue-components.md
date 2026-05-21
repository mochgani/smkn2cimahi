# Fase 5: Vue Components & Pages

Estimasi: ~3 jam (paling lama, tapi paling penting)

Tujuan: Konversi HTML static ke Vue 3 components dengan Composition API.

## Strategi

1. **Buat layout dulu** (`AppLayout.vue`) — header, footer, topbar yang dipakai di semua halaman
2. **Extract reusable components** — `PageHeader`, `SectionLabel`, `Callout`
3. **Buat section components** — `HeroSlider`, `StatsBar`, `KompetensiGrid`
4. **Konversi tiap page** — pakai layout + components di atas

## 1. Layout: `AppLayout.vue`

Buat folder `resources/js/Components/Layout/`:

### `resources/js/Components/Layout/Topbar.vue`

```vue
<template>
    <div class="topbar">
        <span>SMK NEGERI 2 CIMAHI · BMW: BEKERJA · MELANJUTKAN · WIRAUSAHA</span>
        <span>+62 896 0520 1376 · INFO@SMKN2CMI.SCH.ID</span>
    </div>
</template>
```

### `resources/js/Components/Layout/Header.vue`

```vue
<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const profilOpen = ref(false);
const kompetensiOpen = ref(false);
</script>

<template>
    <header class="sticky top-0 z-50 bg-bg/90 backdrop-blur border-b border-line">
        <div class="container-page flex items-center justify-between h-[70px] gap-8">
            <!-- Logo -->
            <Link href="/" class="flex items-center gap-3.5">
                <img src="/images/logo.png" alt="Logo SMKN 2 Cimahi" class="w-12 h-12 object-contain">
                <div>
                    <div class="text-sm font-bold text-ink leading-tight">SMKN 2 Cimahi</div>
                    <div class="font-mono text-[10px] text-muted tracking-mono mt-0.5">EST. 2007 / KOTA CIMAHI</div>
                </div>
            </Link>

            <!-- Navigation -->
            <nav class="flex gap-7 items-center">
                <Link 
                    href="/" 
                    class="text-[13px] font-medium text-ink-soft hover:text-accent transition-colors"
                    :class="{ 'text-accent': $page.component === 'Home' }"
                >
                    Beranda
                </Link>

                <!-- Profil Dropdown -->
                <div 
                    class="relative" 
                    @mouseenter="profilOpen = true" 
                    @mouseleave="profilOpen = false"
                >
                    <button class="text-[13px] font-medium text-ink-soft hover:text-accent inline-flex items-center gap-1">
                        Profil 
                        <span class="text-[10px] transition-transform" :class="{ 'rotate-180': profilOpen }">▾</span>
                    </button>
                    <div 
                        v-show="profilOpen"
                        class="absolute top-full -left-4 bg-white border border-line min-w-[220px] py-2 shadow-lg"
                    >
                        <Link href="/profil/sekolah" class="block px-5 py-2.5 text-[13px] text-ink-soft hover:bg-bg-alt hover:text-accent hover:pl-6 transition-all">
                            Profil Sekolah
                        </Link>
                        <Link href="/profil/visi-misi" class="block px-5 py-2.5 text-[13px] text-ink-soft hover:bg-bg-alt hover:text-accent hover:pl-6 transition-all">
                            Visi & Misi
                        </Link>
                        <Link href="/profil/kesiswaan" class="block px-5 py-2.5 text-[13px] text-ink-soft hover:bg-bg-alt hover:text-accent hover:pl-6 transition-all">
                            Kesiswaan
                        </Link>
                        <Link href="/profil/bkk" class="block px-5 py-2.5 text-[13px] text-ink-soft hover:bg-bg-alt hover:text-accent hover:pl-6 transition-all">
                            Bursa Kerja Khusus
                        </Link>
                    </div>
                </div>

                <!-- Kompetensi Dropdown -->
                <div 
                    class="relative"
                    @mouseenter="kompetensiOpen = true" 
                    @mouseleave="kompetensiOpen = false"
                >
                    <button class="text-[13px] font-medium text-ink-soft hover:text-accent inline-flex items-center gap-1">
                        Kompetensi 
                        <span class="text-[10px] transition-transform" :class="{ 'rotate-180': kompetensiOpen }">▾</span>
                    </button>
                    <div 
                        v-show="kompetensiOpen"
                        class="absolute top-full -left-4 bg-white border border-line min-w-[260px] py-2 shadow-lg"
                    >
                        <Link href="/kompetensi/animasi" class="block px-5 py-2.5 text-[13px] text-ink-soft hover:bg-bg-alt hover:text-accent hover:pl-6 transition-all">Animasi</Link>
                        <Link href="/kompetensi/dkv" class="block px-5 py-2.5 text-[13px] text-ink-soft hover:bg-bg-alt hover:text-accent hover:pl-6 transition-all">Desain Komunikasi Visual</Link>
                        <Link href="/kompetensi/rpl" class="block px-5 py-2.5 text-[13px] text-ink-soft hover:bg-bg-alt hover:text-accent hover:pl-6 transition-all">Rekayasa Perangkat Lunak</Link>
                        <Link href="/kompetensi/kimia" class="block px-5 py-2.5 text-[13px] text-ink-soft hover:bg-bg-alt hover:text-accent hover:pl-6 transition-all">Teknik Kimia Industri</Link>
                        <Link href="/kompetensi/mekatronika" class="block px-5 py-2.5 text-[13px] text-ink-soft hover:bg-bg-alt hover:text-accent hover:pl-6 transition-all">Teknik Mekatronika</Link>
                        <Link href="/kompetensi/pemesinan" class="block px-5 py-2.5 text-[13px] text-ink-soft hover:bg-bg-alt hover:text-accent hover:pl-6 transition-all">Teknik Pemesinan</Link>
                    </div>
                </div>

                <Link href="/berita" class="text-[13px] font-medium text-ink-soft hover:text-accent transition-colors">
                    Berita
                </Link>
                <Link href="/kontak" class="text-[13px] font-medium text-ink-soft hover:text-accent transition-colors">
                    Kontak
                </Link>
            </nav>

            <!-- SPMB Button -->
            <a href="#" class="btn-spmb">SPMB 2026 →</a>
        </div>
    </header>
</template>
```

### `resources/js/Components/Layout/Footer.vue`

```vue
<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <footer class="bg-ink text-bg mt-24 pt-20 pb-8 px-page">
        <div class="container-page grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 pb-14 border-b border-white/10">
            <!-- Brand -->
            <div>
                <img src="/images/logo.png" alt="Logo" class="w-14 h-14 object-contain brightness-110 mb-4">
                <div class="text-lg font-bold mb-2">SMK Negeri 2 Cimahi</div>
                <p class="font-mono text-xs text-white/60 tracking-mono mb-4">BMW: Bekerja · Melanjutkan · Wirausaha</p>
                <p class="font-mono text-[11px] text-accent tracking-mono-wide">EST. 2007</p>
            </div>

            <!-- Kontak -->
            <div>
                <div class="font-mono text-[11px] text-white/50 tracking-mono-wide uppercase mb-5">Kontak</div>
                <p class="text-[13px] text-white/85 leading-relaxed mb-4">
                    Jl. Kamarung KM 1.5 No.69<br>
                    Citeureup, Cimahi Utara<br>
                    Kota Cimahi 40512
                </p>
                <p class="text-[13px] text-white/85 leading-relaxed">
                    +62 896 0520 1376<br>
                    info@smkn2cmi.sch.id
                </p>
            </div>

            <!-- Links -->
            <div>
                <div class="font-mono text-[11px] text-white/50 tracking-mono-wide uppercase mb-5">Profil</div>
                <Link href="/profil/sekolah" class="block text-[13px] text-white/85 hover:text-accent py-1">Profil Sekolah</Link>
                <Link href="/profil/visi-misi" class="block text-[13px] text-white/85 hover:text-accent py-1">Visi & Misi</Link>
                <Link href="/profil/kesiswaan" class="block text-[13px] text-white/85 hover:text-accent py-1">Kesiswaan</Link>
                <Link href="/profil/bkk" class="block text-[13px] text-white/85 hover:text-accent py-1">Bursa Kerja Khusus</Link>
            </div>

            <!-- Social -->
            <div>
                <div class="font-mono text-[11px] text-white/50 tracking-mono-wide uppercase mb-5">Sosial Media</div>
                <a href="https://www.instagram.com/smkn2_cimahi/" target="_blank" rel="noopener" class="block text-[13px] text-white/85 hover:text-accent py-1">Instagram</a>
                <a href="https://www.facebook.com/smkn2cmi" target="_blank" rel="noopener" class="block text-[13px] text-white/85 hover:text-accent py-1">Facebook</a>
                <a href="https://www.youtube.com/channel/UCzEQqJgk4F0UulngS94Ql3g" target="_blank" rel="noopener" class="block text-[13px] text-white/85 hover:text-accent py-1">YouTube</a>
                <a href="https://id.linkedin.com/school/smk-negeri-2-cimahi" target="_blank" rel="noopener" class="block text-[13px] text-white/85 hover:text-accent py-1">LinkedIn</a>
            </div>
        </div>

        <div class="container-page mt-8 flex justify-between items-center font-mono text-[11px] text-white/50 tracking-mono flex-wrap gap-4">
            <span>© 2026 SMK NEGERI 2 CIMAHI</span>
            <span>SEKOLAH MENENGAH KEJURUAN NEGERI</span>
            <span>NSS 401026802002 / NPSN 20224389</span>
        </div>
    </footer>
</template>
```

### `resources/js/Components/Layout/AppLayout.vue` (Layout Utama)

```vue
<script setup>
import Topbar from './Topbar.vue';
import Header from './Header.vue';
import Footer from './Footer.vue';
</script>

<template>
    <div class="min-h-screen flex flex-col">
        <Topbar />
        <Header />
        
        <main class="flex-1">
            <slot />
        </main>

        <Footer />
    </div>
</template>
```

## 2. Reusable UI Components

### `resources/js/Components/UI/PageHeader.vue`

```vue
<script setup>
defineProps({
    breadcrumbs: { type: Array, default: () => [] },
    meta: String,
    title: String,
    lead: String,
});
</script>

<template>
    <section class="page-header">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 font-mono text-[11px] text-muted tracking-mono uppercase mb-6">
            <template v-for="(crumb, i) in breadcrumbs" :key="i">
                <a 
                    v-if="crumb.href" 
                    :href="crumb.href" 
                    class="text-muted hover:text-accent"
                >
                    {{ crumb.label }}
                </a>
                <span v-else class="text-accent">{{ crumb.label }}</span>
                <span v-if="i < breadcrumbs.length - 1" class="text-line">/</span>
            </template>
        </div>

        <!-- Meta tag -->
        <div v-if="meta" class="inline-flex items-center gap-2 bg-white border border-line px-3 py-1 mb-6">
            <span class="w-2 h-2 rounded-full bg-accent"></span>
            <span class="font-mono text-[11px] text-ink tracking-mono">{{ meta }}</span>
        </div>

        <h1 class="page-title">{{ title }}</h1>
        <p v-if="lead" class="page-lead">{{ lead }}</p>
    </section>
</template>
```

### `resources/js/Components/UI/SectionLabel.vue`

```vue
<script setup>
defineProps({
    num: { type: [String, Number], required: true },
    title: { type: String, required: true },
});
</script>

<template>
    <div class="section-label">
        <span class="label-num">[{{ String(num).padStart(2, '0') }}]</span>
        <span class="label-line"></span>
        <span class="label-title">{{ title }}</span>
    </div>
</template>
```

### `resources/js/Components/UI/Callout.vue`

```vue
<script setup>
defineProps({
    label: String,
    title: String,
});
</script>

<template>
    <section class="container-page pb-12">
        <div class="bg-ink text-bg p-12 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <div class="font-mono text-[11px] text-accent tracking-mono-wide mb-3">{{ label }}</div>
                <h3 class="text-3xl font-bold tracking-tighter leading-tight">
                    {{ title }}
                </h3>
            </div>
            <p class="text-[15px] leading-relaxed text-white/80">
                <slot />
            </p>
        </div>
    </section>
</template>
```

## 3. Section Component Example: HeroSlider

### `resources/js/Components/Sections/HeroSlider.vue`

```vue
<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const slides = [
    {
        tag: 'KEGIATAN',
        date: '04.03.2026',
        title: 'Pesantren Ekologi: Tiga Tahap Aksi Nyata Peduli Lingkungan',
        desc: 'Program bertahap 23 Februari – 13 Maret 2026, membentuk karakter peserta didik yang peduli terhadap lingkungan sekolah dan sekitar.',
        cta: 'Baca Selengkapnya',
        badge: 'PESANTREN EKOLOGI',
    },
    {
        tag: 'PRESTASI',
        date: '05.12.2025',
        title: 'Vidika, Pivot Muda Raih Juara 3 AAFI 2025',
        desc: 'Siswa kelas X Mekatronika A meraih Juara 3 Nasional Grand Champion AAFI putaran nasional 2025.',
        cta: 'Lihat Prestasi',
        badge: 'JUARA NASIONAL',
    },
    {
        tag: 'PENGUMUMAN',
        date: '01.04.2026',
        title: 'Pendaftaran SPMB 2026/2027 Telah Dibuka',
        desc: 'Bergabunglah dengan SMK Negeri 2 Cimahi. Enam kompetensi keahlian, fasilitas lengkap, dan lulusan siap kerja.',
        cta: 'Daftar Sekarang',
        badge: 'SPMB 2026',
    },
];

const currentSlide = ref(0);
const autoplayInterval = ref(null);

const next = () => {
    currentSlide.value = (currentSlide.value + 1) % slides.length;
};

const prev = () => {
    currentSlide.value = (currentSlide.value - 1 + slides.length) % slides.length;
};

const goTo = (i) => {
    currentSlide.value = i;
};

const startAutoplay = () => {
    autoplayInterval.value = setInterval(next, 6000);
};

const stopAutoplay = () => {
    if (autoplayInterval.value) clearInterval(autoplayInterval.value);
};

onMounted(startAutoplay);
onUnmounted(stopAutoplay);
</script>

<template>
    <section 
        class="container-page py-16 pb-8"
        @mouseenter="stopAutoplay"
        @mouseleave="startAutoplay"
    >
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-stretch min-h-[480px]">
            <!-- Content Left -->
            <div class="flex flex-col justify-center">
                <div class="inline-flex items-center gap-2 bg-white border border-line px-3 py-1 mb-6 w-fit">
                    <span class="w-2 h-2 rounded-full bg-accent"></span>
                    <span class="font-mono text-[11px] text-ink tracking-mono">{{ slides[currentSlide].date }}</span>
                    <span class="font-mono text-[11px] text-ink tracking-mono"> / </span>
                    <span class="font-mono text-[11px] text-ink tracking-mono">{{ slides[currentSlide].tag }}</span>
                </div>

                <h1 class="text-5xl md:text-6xl font-extrabold leading-[1.05] tracking-tightest text-ink mb-6 max-w-xl transition-opacity duration-300">
                    {{ slides[currentSlide].title }}
                </h1>

                <p class="text-base leading-relaxed text-muted-soft max-w-md mb-8 transition-opacity duration-300">
                    {{ slides[currentSlide].desc }}
                </p>

                <div class="flex gap-3 flex-wrap">
                    <button class="btn-primary">
                        {{ slides[currentSlide].cta }} <span class="text-base">↗</span>
                    </button>
                    <a href="/berita" class="btn-secondary">Lihat Semua Berita</a>
                </div>
            </div>

            <!-- Visual Right -->
            <div class="relative overflow-hidden bg-line-soft" 
                 style="background-image: repeating-linear-gradient(135deg, #e8e6e0 0 14px, #d4d0c5 14px 28px);">
                <div class="absolute inset-0" 
                     style="background: radial-gradient(circle at 30% 30%, rgba(13,110,63,0.15) 0%, transparent 50%), radial-gradient(circle at 70% 70%, rgba(13,110,63,0.08) 0%, transparent 50%);">
                </div>
                <div class="absolute bottom-6 left-6 bg-white/95 px-5 py-3.5 border border-line">
                    <span class="block font-mono text-[10px] text-muted tracking-mono-wide">FOKUS BULAN INI</span>
                    <span class="block font-mono text-sm font-semibold text-ink tracking-mono">{{ slides[currentSlide].badge }}</span>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <div class="flex justify-between items-center pt-4 border-t border-line mt-8">
            <div class="flex gap-1">
                <button 
                    v-for="(_, i) in slides" 
                    :key="i"
                    @click="goTo(i)"
                    class="font-mono text-xs py-1.5 px-4 transition-colors"
                    :class="i === currentSlide ? 'text-accent' : 'text-muted hover:text-ink'"
                >
                    [{{ String(i + 1).padStart(2, '0') }}]
                </button>
            </div>
            <div class="flex gap-4">
                <button @click="prev" class="font-mono text-[13px] text-ink hover:text-accent">← Prev</button>
                <button @click="next" class="font-mono text-[13px] text-ink hover:text-accent">Next →</button>
            </div>
        </div>
    </section>
</template>
```

## 4. Pattern untuk Konversi Halaman Lain

Lihat `code-snippets/blade-pages/` di migration kit untuk:
- `Home.vue` lengkap
- `Profil/Sekolah.vue`
- `Profil/VisiMisi.vue`
- `Kompetensi/Animasi.vue` (template untuk 6 kompetensi)
- `Berita/Index.vue`
- `Berita/Show.vue`
- `Kontak.vue`

### Pattern Page

```vue
<script setup>
import AppLayout from '@/Components/Layout/AppLayout.vue';
import PageHeader from '@/Components/UI/PageHeader.vue';
import SectionLabel from '@/Components/UI/SectionLabel.vue';
import Callout from '@/Components/UI/Callout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Profil Sekolah" />
    
    <AppLayout>
        <PageHeader 
            :breadcrumbs="[
                { label: 'Beranda', href: '/' },
                { label: 'Profil' },
                { label: 'Profil Sekolah' }
            ]"
            meta="EST. 2007 · KOTA CIMAHI"
            title="Sekolah kejuruan unggulan, lahir untuk industri."
            lead="SMK Negeri 2 Cimahi adalah sekolah menengah kejuruan negeri di Jawa Barat..."
        />

        <!-- Section content here -->
        <section class="container-page">
            <SectionLabel num="2" title="Program Unggulan" />
            <!-- ... -->
        </section>

        <Callout
            label="INFORMASI SEKOLAH"
            title="Berlokasi strategis di Cimahi Utara, fasilitas lengkap di lahan 1,6 hektar."
        >
            Jl. Kamarung KM 1.5 No.69, Kelurahan Citeureup...
        </Callout>
    </AppLayout>
</template>
```

## ✅ Verifikasi Fase 5

- [ ] `AppLayout.vue` dengan Topbar, Header, Footer bekerja
- [ ] Dropdown Profil & Kompetensi muncul saat hover
- [ ] HeroSlider auto-advance dan pause saat hover
- [ ] Semua 14 halaman sudah ter-konversi (minimal placeholder dengan layout)
- [ ] Tidak ada console error
- [ ] Hot reload masih bekerja

## ➡️ Lanjut ke

[`06-database-models.md`](./06-database-models.md)
