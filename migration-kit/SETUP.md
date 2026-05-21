# 🚀 Panduan Migrasi ke Laravel 13 + Vue 3 + Tailwind v3 + Filament

Panduan step-by-step untuk migrasi static HTML ke Laravel 13 dengan Inertia.js + Vue 3, Tailwind v3, dan Filament v3 admin panel.

---

## 📋 Stack Final

| Komponen | Teknologi | Versi |
|---|---|---|
| **Backend** | Laravel | 13.x |
| **Frontend** | Vue 3 + Inertia.js | latest |
| **CSS** | Tailwind CSS | 3.x |
| **Build Tool** | Vite | latest |
| **Admin Panel** | Filament | 3.x |
| **Database** | MySQL / PostgreSQL / SQLite | - |
| **PHP** | 8.3+ | - |

---

## 🎯 Roadmap Migrasi (8 Fase)

```
Fase 1: Setup Laravel Project           (~30 menit)
Fase 2: Setup Inertia + Vue 3           (~30 menit)
Fase 3: Setup Tailwind dengan Design Tokens (~45 menit)
Fase 4: Buat Layout & Components Vue    (~2 jam)
Fase 5: Buat Halaman Static             (~3 jam)
Fase 6: Database & Models               (~1 jam)
Fase 7: Setup Filament Admin Panel      (~2 jam)
Fase 8: Form Kontak & Email             (~1 jam)

Total estimasi: ~10-12 jam
```

---

## 🏗️ Struktur Project Akhir

```
smkn2cimahi/
├── app/
│   ├── Filament/
│   │   └── Resources/         # Filament resources untuk admin
│   │       ├── BeritaResource.php
│   │       ├── KompetensiResource.php
│   │       └── PesanResource.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php
│   │   │   ├── ProfilController.php
│   │   │   ├── KompetensiController.php
│   │   │   ├── BeritaController.php
│   │   │   └── KontakController.php
│   │   └── Requests/
│   │       └── StorePesanRequest.php
│   ├── Mail/
│   │   └── PesanKontakMail.php
│   └── Models/
│       ├── Berita.php
│       ├── Kategori.php
│       ├── Kompetensi.php
│       └── Pesan.php
│
├── database/
│   ├── migrations/
│   │   ├── *_create_kategoris_table.php
│   │   ├── *_create_beritas_table.php
│   │   ├── *_create_kompetensis_table.php
│   │   └── *_create_pesans_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── KategoriSeeder.php
│       ├── BeritaSeeder.php
│       └── KompetensiSeeder.php
│
├── resources/
│   ├── css/
│   │   └── app.css           # Tailwind + design tokens custom
│   ├── js/
│   │   ├── app.js            # Inertia entry
│   │   ├── Components/       # Vue components reusable
│   │   │   ├── Layout/
│   │   │   │   ├── Topbar.vue
│   │   │   │   ├── Header.vue
│   │   │   │   ├── Footer.vue
│   │   │   │   └── AppLayout.vue
│   │   │   ├── UI/
│   │   │   │   ├── PageHeader.vue
│   │   │   │   ├── SectionLabel.vue
│   │   │   │   ├── Callout.vue
│   │   │   │   └── Breadcrumb.vue
│   │   │   └── Sections/
│   │   │       ├── HeroSlider.vue
│   │   │       ├── StatsBar.vue
│   │   │       ├── KompetensiGrid.vue
│   │   │       ├── CtaBanner.vue
│   │   │       └── FacilitiesGrid.vue
│   │   └── Pages/            # Inertia pages (1 file per route)
│   │       ├── Home.vue
│   │       ├── Profil/
│   │       │   ├── Sekolah.vue
│   │       │   ├── VisiMisi.vue
│   │       │   ├── Kesiswaan.vue
│   │       │   └── BKK.vue
│   │       ├── Kompetensi/
│   │       │   ├── Animasi.vue
│   │       │   ├── DKV.vue
│   │       │   ├── RPL.vue
│   │       │   ├── Kimia.vue
│   │       │   ├── Mekatronika.vue
│   │       │   └── Pemesinan.vue
│   │       ├── Berita/
│   │       │   ├── Index.vue
│   │       │   └── Show.vue
│   │       └── Kontak.vue
│
├── routes/
│   └── web.php               # Routing
│
├── public/
│   └── images/
│       └── logo.png
│
├── tailwind.config.js
├── vite.config.js
├── postcss.config.js
├── package.json
└── composer.json
```

---

## ⚡ Quick Start (untuk Claude Code)

Buka Claude Code di terminal, lalu jalankan prompt ini:

```
Buatkan project Laravel 13 dengan stack:
- Laravel 13
- Inertia.js + Vue 3
- Tailwind CSS v3
- Filament v3 untuk admin panel
- MySQL atau SQLite untuk database

Saya punya HTML static yang sudah jadi di folder ini. 
Tolong:
1. Setup Laravel project baru
2. Install semua dependency
3. Konversi semua HTML ke Vue components dengan Inertia
4. Buat database schema untuk berita, kompetensi, pesan kontak
5. Buat Filament admin panel

Detail design system, data, dan code snippets ada di folder migration-kit/
```

---

## 📚 Daftar Dokumen di Migration Kit

| File | Isi |
|---|---|
| **`docs/01-setup-laravel.md`** | Setup project Laravel + dependencies |
| **`docs/02-setup-inertia-vue.md`** | Install Inertia + Vue 3 |
| **`docs/03-setup-tailwind.md`** | Tailwind config + design tokens custom |
| **`docs/04-routes-controllers.md`** | Setup routing dan controllers |
| **`docs/05-vue-components.md`** | Konversi HTML ke Vue components |
| **`docs/06-database-models.md`** | Migration, seeder, models |
| **`docs/07-filament-admin.md`** | Setup Filament admin panel |
| **`docs/08-form-kontak.md`** | Form handler + email |
| **`data/berita.json`** | Data 20 berita siap import |
| **`data/kompetensi.json`** | Data 6 kompetensi keahlian |
| **`code-snippets/`** | Blade + Vue snippets untuk copy-paste |

---

## 🎨 Design Tokens (untuk Tailwind Config)

```js
// tailwind.config.js
colors: {
  bg: {
    DEFAULT: '#fafaf8',
    alt: '#f4f2ec',
  },
  ink: {
    DEFAULT: '#0a0a0a',
    soft: '#1a1a1a',
  },
  accent: {
    DEFAULT: '#0d6e3f',
    dark: '#095530',
  },
  muted: {
    DEFAULT: '#6b6b66',
    soft: '#3a3a36',
  },
  line: {
    DEFAULT: '#d4d0c5',
    soft: '#e8e6e0',
  },
},
fontFamily: {
  sans: ['Inter', 'system-ui', 'sans-serif'],
  mono: ['JetBrains Mono', 'ui-monospace', 'monospace'],
},
maxWidth: {
  page: '1280px',
},
```

---

## ✅ Checklist Migrasi

### Fase 1: Setup
- [ ] Install Laravel 13 baru
- [ ] Install Composer dependencies
- [ ] Setup `.env` dengan database
- [ ] Run `php artisan migrate` (default tables)

### Fase 2: Frontend Stack
- [ ] Install Inertia.js (server + client)
- [ ] Install Vue 3
- [ ] Install Tailwind CSS v3
- [ ] Setup `app.blade.php` untuk Inertia
- [ ] Test "Hello Vue" di route `/`

### Fase 3: Design System
- [ ] Configure Tailwind dengan design tokens
- [ ] Import Inter & JetBrains Mono fonts
- [ ] Setup base styles di `app.css`
- [ ] Test design tokens dengan komponen sederhana

### Fase 4: Components
- [ ] Buat `AppLayout.vue` (header + footer + topbar)
- [ ] Buat `Header.vue` dengan dropdown navigation
- [ ] Buat `Footer.vue` 4-column
- [ ] Buat `PageHeader.vue`, `SectionLabel.vue`, `Callout.vue`
- [ ] Buat section components (HeroSlider, StatsBar, KompetensiGrid)

### Fase 5: Pages (14 halaman)
- [ ] `Home.vue` (Beranda)
- [ ] 4 Profil pages
- [ ] 6 Kompetensi pages
- [ ] Berita Index + Show
- [ ] Kontak page

### Fase 6: Database
- [ ] Buat migration untuk `kategoris`, `beritas`, `kompetensis`, `pesans`
- [ ] Buat models dengan relationships
- [ ] Buat seeders dari data JSON
- [ ] Run migrations + seeders

### Fase 7: Filament
- [ ] Install Filament v3
- [ ] Buat user admin
- [ ] Generate Filament Resources (Berita, Kompetensi, Pesan)
- [ ] Customize tampilan admin

### Fase 8: Final
- [ ] Setup form kontak dengan email
- [ ] Setup SEO meta tags per halaman
- [ ] Setup sitemap.xml & robots.txt
- [ ] Test semua link & form
- [ ] Deploy ke server

---

## 📖 Mulai Migrasi

Buka file dokumen secara berurutan dari `docs/01-setup-laravel.md` dan ikuti instruksinya.

Selamat migrating! 🚀
