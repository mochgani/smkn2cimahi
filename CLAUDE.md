# CLAUDE.md — Panduan AI untuk Project smkn2cimahi

> File ini dibaca otomatis oleh Claude Code di setiap sesi baru.
> Berisi konteks penuh project, preferensi kolaborasi, dan riwayat perubahan.
> **Update file ini setiap ada keputusan arsitektur atau perubahan besar.**

---

## Tentang Project

Website resmi **SMK Negeri 2 Cimahi** — hasil migrasi dari static HTML ke Laravel 13 + Inertia.js + Vue 3 + Filament v4 admin panel.

Migrasi selesai 8 fase penuh (selesai sesi 2026-05-10).

---

## Cara Berkolaborasi (WAJIB DIBACA)

1. **Diskusi dulu untuk fitur besar.** Untuk permintaan yang kompleks atau mengubah banyak file, tawarkan implementation plan dan tunggu persetujuan.
2. **Jangan run/eksekusi server tanpa diminta.** Boleh `php artisan` untuk non-destructive commands (route:list, tinker, dll).
3. **Konsistensi Filament v4.** Perhatikan struktur v4 berbeda dari v3 — lihat bagian "Arsitektur Filament v4" di bawah.
4. **Bahasa komunikasi: Bahasa Indonesia.**

---

## Stack Teknologi

| Komponen | Detail |
|---|---|
| Backend | PHP 8.5.2 + Laravel 13.8.0 |
| Frontend | Vue 3 + Inertia.js v2 |
| Build Tool | Vite 8 + laravel-vite-plugin |
| CSS | Tailwind CSS v3.2.1 + design tokens custom |
| Admin Panel | **Filament v4** (bukan v3!) |
| Database | MySQL (`smkn2cimahi`) via MAMP port 3306 |
| Email | Laravel Mail (konfigurasi via `.env`) |

**Cara menjalankan:**
```bash
cd /Users/tamu/Downloads/smkn2cimahi
php artisan serve
# Frontend dev (terminal terpisah):
npm run dev
```

**Route admin Filament:**
```
http://localhost:8000/admin
```

---

## Struktur File Utama

```
smkn2cimahi/
├── app/
│   ├── Filament/Resources/
│   │   ├── Beritas/
│   │   │   ├── BeritaResource.php
│   │   │   ├── Pages/{Create,Edit,List}Berita.php
│   │   │   ├── Schemas/BeritaForm.php
│   │   │   └── Tables/BeritasTable.php
│   │   ├── Kompetensis/
│   │   │   ├── KompetensiResource.php
│   │   │   ├── Pages/{Create,Edit,List}Kompetensi.php
│   │   │   ├── Schemas/KompetensiForm.php
│   │   │   └── Tables/KompetensisTable.php
│   │   └── Pesans/
│   │       ├── PesanResource.php
│   │       ├── Pages/{List}Pesan.php
│   │       ├── Schemas/PesanForm.php (read-only)
│   │       └── Tables/PesansTable.php
│   ├── Http/Controllers/
│   │   ├── HomeController.php       # Stats & berita terbaru (sebagian masih inline)
│   │   ├── ProfilController.php     # SEMUA DATA MASIH HARDCODED (inline arrays)
│   │   ├── KompetensiController.php # Sudah dari DB via Model Kompetensi
│   │   ├── BeritaController.php     # Sudah dari DB via Model Berita
│   │   └── KontakController.php    # Simpan ke DB + kirim email
│   ├── Models/
│   │   ├── Berita.php     # fillable: slug,title,excerpt,content,cover_image,tags,is_featured,is_published,published_at,author_id
│   │   ├── Kategori.php   # fillable: name,slug,color
│   │   ├── Author.php     # fillable: name,initials,bio,email
│   │   ├── Kompetensi.php # fillable: slug,code,name,tag,short_desc,lead,about,sections,cta_*,display_order,is_active
│   │   └── Pesan.php      # fillable: nama,email,telepon,topik,pesan,is_read,is_replied,ip_address
│   └── Mail/
│       └── PesanKontakMail.php
├── database/
│   ├── migrations/         # 6 tabel: kategoris, authors, beritas, berita_kategori, kompetensis, pesans
│   ├── seeders/
│   └── data/
│       ├── berita.json     # 20 berita sample (sudah di-seed)
│       └── kompetensi.json # 6 kompetensi (sudah di-seed)
├── resources/
│   ├── css/app.css         # Tailwind layers + custom utility classes
│   └── js/
│       ├── app.js          # Inertia entry point
│       ├── Components/
│       │   ├── Layout/     # Topbar, Header, Footer, AppLayout
│       │   ├── UI/         # PageHeader, SectionLabel, Callout, Breadcrumb
│       │   └── Sections/   # HeroSlider, StatsBar, KompetensiGrid, KompetensiDetail
│       └── Pages/
│           ├── Home.vue
│           ├── Profil/     # Sekolah, VisiMisi, Kesiswaan, BKK
│           ├── Kompetensi/ # Animasi, DKV, RPL, Kimia, Mekatronika, Pemesinan
│           ├── Berita/     # Index, Show
│           └── Kontak.vue
├── routes/web.php
├── migration-kit/          # Docs fase migrasi (referensi saja, jangan dihapus)
└── CLAUDE.md               # File ini
```

---

## Database — Tabel

| Tabel | Deskripsi |
|---|---|
| `kategoris` | Kategori berita (`name`, `slug`, `color`) |
| `authors` | Penulis berita (`name`, `initials`, `bio`, `email`) |
| `beritas` | Artikel berita (full-featured: slug, content longText, tags json, is_featured, is_published) |
| `berita_kategori` | Pivot many-to-many berita ↔ kategori |
| `kompetensis` | 6 kompetensi keahlian (slug, code, sections json, is_active, display_order, **logo_image, gallery json**) |
| `pesans` | Pesan kontak masuk (is_read, is_replied) |
| `hero_banners` | Slide hero beranda (tag, date_display, title, desc, cta_label, cta_href, badge, image nullable, display_order, is_active) |
| `divisis` | Divisi sekolah (slug, name, description, display_order, is_active) — seed: Kurikulum, Kesiswaan, Hubungan Industri, Sarana Prasarana |
| `menu_items` | Menu navigasi (parent_id self-ref, label, url, type ['static' / 'kompetensi_list'], display_order, is_active) |
| `rekap_siswa` | Rekap siswa per kompetensi × kelas (kompetensi_id FK, kelas enum X/XI/XII, rombel, laki_laki, perempuan). UNIQUE(kompetensi_id, kelas). 18 rows (6×3). |
| `school_stats` | Angka statistik manual untuk StatsBar beranda (key unique, label, value string, display_order, is_active). Seed: Guru, Lab, Penghargaan, M². |
| `profil_sejarah` | Singleton (1 row, id=1) — title, lead, content (richtext), image, tahun_berdiri, luas_lahan, video_youtube_url |
| `profil_visi_misi` | Singleton (1 row, id=1) — visi (text), misi (json array), tujuan (json array) |
| `profil_kepala_sekolah` | Singleton (1 row, id=1) — nama, nip, jabatan, foto, sambutan (richtext) |
| `roles`, `permissions`, `model_has_*`, `role_has_permissions` | Tabel spatie/laravel-permission |
| `users` (extended) | + kolom `kompetensi_id`, `divisi_id` (nullable FK) untuk scoping |
| `beritas` (extended) | + kolom `kompetensi_id`, `divisi_id` (nullable FK) untuk scoping |

---

## Arsitektur & Business Logic

### 1. Data Dinamis (dari DB — bisa diatur via Filament Admin)

| Halaman | Data Dinamis |
|---|---|
| `/berita` + `/berita/{slug}` | Semua field berita (title, content, tags, cover, published_at, author, kategori) |
| `/kompetensi/{slug}` | Semua field kompetensi (nama, deskripsi, sections, CTA, urutan, aktif/non-aktif) + **logo, gallery foto (lightbox), list berita scoped kompetensi** di akhir page |
| `/admin` inbox | Pesan kontak (baca, tandai replied) |
| `/kesiswaan/rekap-siswa` | Distribusi siswa per kompetensi + ringkasan per kelas. Data dari `rekap_siswa` via `KesiswaanController`. |
| `/kurikulum`, `/kesiswaan/program`, `/hubungan-industri` | List berita scoped per divisi (Kurikulum/Kesiswaan/Hubin), via `DivisiController::show($slug)`. Featured card + grid + pagination. Empty state jika belum ada berita. |
| `/prestasi/sekolah`, `/prestasi/guru`, `/prestasi/siswa` | List berita berdasarkan **kategori**: `prestasi-sekolah`, `prestasi-guru`, `prestasi-siswa`. Via `PrestasiController::show($type)`. Same layout as Divisi. Tambah berita dengan pilih kategori sesuai di BeritaResource admin. |
| `/kontak` | Semua data dinamis dari `kontak_settings` singleton: kanal (alamat/telepon/email/WA), kontak per bagian, sosial media, Google Maps embed. Bidang studi otomatis dari DB kompetensi. Admin: `/admin/pengaturan/kontak` (super_admin only). |
| `/hubungan-industri/bkk` | Halaman BKK dinamis dari `bkk_settings` (singleton: about, tujuan json, perusahaan json) + `bkk_lowongans` (tabel). Admin: `/admin/bkk/pengaturan` dan `/admin/bkk/lowongans`. Akses: super_admin + divisi Hubungan Industri. |
| `/` (Home) Hero Slider | Slides dari **dua sumber** di-merge berdasarkan tanggal terbaru: (1) `HeroBanner` aktif dari `/admin/hero-banners`, (2) `Berita` yang `is_featured=true` + `is_published=true`. Auto-slide tiap 10 detik. Section di-hide jika kedua sumber kosong. |
| `/profil/sejarah` | Halaman sejarah dari `profil_sejarah` (singleton). Lead, info card (tahun berdiri + luas lahan), foto sekolah, rich content, embed video YouTube. Admin: `/admin/profil/sejarah`. |
| `/profil/visi-misi` | Visi + list misi + list tujuan dari `profil_visi_misi` (singleton). Section tujuan di-hide jika kosong. Admin: `/admin/profil/visi-misi`. |
| `/profil/kepala-sekolah` | Foto + identitas + sambutan kepala sekolah dari `profil_kepala_sekolah` (singleton). Admin: `/admin/profil/kepala-sekolah`. |

### 2. Data HARDCODED (belum bisa diubah dari admin)

Semua ada di `ProfilController.php` dan `HomeController.php` sebagai inline arrays:

| Halaman | Data yang Hardcoded |
|---|---|
| `/profil/sekolah` | Daftar unggulan/kelas industri (BUMA, Ayena, dll) |
| ~~`/profil/visi-misi`~~ | Sudah DINAMIS via `profil_visi_misi` singleton |
| `/profil/kesiswaan` | Statistik siswa per kelas & per kompetensi |
| ~~`/profil/bkk`~~ | BKK sudah pindah ke `/hubungan-industri/bkk`, route lama tetap ada tapi hardcoded |
| ~~`/` (Home) Stats bar~~ | Sudah DINAMIS: Peserta Didik (auto rekap_siswa), Kompetensi (auto count), 4 lainnya dari school_stats |

**Next step yang mungkin:** Buat model `ProfilSekolah`, `Kesiswaan`, `BKK` + Filament resource untuk data di atas — atau gunakan package `spatie/laravel-settings` untuk data semi-statis.

### 3. Arsitektur Filament v4 (PENTING!)

Filament v4 terinstall (docs mereferensikan v3, tapi v3 tidak kompatibel dengan Laravel 13).

Struktur file per Resource:
```
app/Filament/Resources/{Nama}s/
├── {Nama}Resource.php        # navigasi, label, model
├── Pages/
│   ├── Create{Nama}.php
│   ├── Edit{Nama}.php
│   └── List{Nama}s.php
├── Schemas/
│   └── {Nama}Form.php        # form schema (Filament\Schemas\...)
└── Tables/
    └── {Nama}sTable.php      # table + filters + actions
```

Namespace penting Filament v4:
- `Section` → `Filament\Schemas\Components\Section`
- Actions → `Filament\Actions\*`
- `recordActions()` menggantikan `actions()` dari v3

### 4. Design Tokens (Tailwind)

```js
colors: {
    bg:     { DEFAULT: '#fafaf8', alt: '#f4f2ec' },
    ink:    { DEFAULT: '#0a0a0a', soft: '#1a1a1a' },
    accent: { DEFAULT: '#0d6e3f', dark: '#095530' },
    muted:  { DEFAULT: '#6b6b66', soft: '#3a3a36' },
    line:   { DEFAULT: '#d4d0c5', soft: '#e8e6e0' },
},
fontFamily: {
    sans: ['Inter', 'system-ui', 'sans-serif'],
    mono: ['JetBrains Mono', 'ui-monospace', 'monospace'],
},
maxWidth: { page: '1280px' },
```

### 5. Form Kontak

- Validasi via `StorePesanRequest.php` (Indonesian error messages)
- Simpan ke tabel `pesans`
- Kirim email notifikasi ke admin via `PesanKontakMail.php`
- Subject format: `[Kontak Web] {topik} — {nama}`
- Reply-To = email pengirim (admin bisa langsung reply)

---

## Riwayat Perubahan

### Sesi 2026-05-10 (Claude Code — session "Migrate static website to Laravel with Inertia")

Migrasi penuh dari static HTML ke Laravel 13 + Inertia.js + Vue 3 + Filament v4:

**Fase 1** — Setup Laravel 13.8.0 di folder `smkn2cimahi/`, PHP 8.5.2, MySQL `smkn2cimahi`
**Fase 2** — Inertia.js + Vue 3 via Breeze 2.4.1, axios manual install (Laravel 13 hapus default)
**Fase 3** — Tailwind v3.2.1 + design tokens (5 color families, Inter/JetBrains Mono fonts)
**Fase 4** — 11 Vue components: Layout (Topbar, Header, Footer, AppLayout) + UI + Sections
**Fase 5** — 5 Controllers + 17 Routes + 14 halaman Vue (konten dari reference HTML + JSON)
**Fase 6** — 6 migration tables, Models (Berita, Kategori, Author, Kompetensi, Pesan), Seeders dari JSON
**Fase 7** — **Filament v4** admin panel (BeritaResource, KompetensiResource, PesanResource)
**Fase 8** — Form kontak: StorePesanRequest, PesanKontakMail, throttle 5x/60 menit

> **Catatan Fase 7:** Filament v3 dari docs tidak kompatibel dengan Laravel 13. Diinstall Filament v4 sebagai gantinya. Struktur file dan namespace berbeda dari docs/07-filament-admin.md.

### Sesi 2026-05-11 (Claude Code — Menu Navigasi Dinamis)

**Sistem menu dinamis** dikelola dari Filament admin (`/admin/menu-items`):
- Tabel `menu_items` self-referencing (parent_id) — support 2 level
- Kolom `type`: `static` (children dari menu_items) atau `kompetensi_list` (children auto-generated dari Kompetensi aktif)
- Drag-and-drop reorder via `display_order` (Filament `reorderable()`)
- Shared global via `HandleInertiaRequests` ke semua halaman (prop `navigation`)
- `Header.vue` render dropdown 2-level dinamis dari `navigation` prop
- Tombol "Beranda" dihapus — logo saja yang link ke `/`

**Penyesuaian Divisi:**
- BKK dihapus dari `divisis` (sekarang halaman biasa di bawah menu Hubungan Industri)
- Divisi resmi: **Kurikulum, Kesiswaan, Hubungan Industri, Sarana Prasarana**

**Placeholder pages baru** (Vue page generic `Placeholder.vue` + closure routes):
- `/profil/sejarah`, `/profil/kepala-sekolah`
- `/kurikulum`, `/kesiswaan/program`, `/kesiswaan/rekap-siswa`
- `/hubungan-industri`, `/hubungan-industri/bkk`
- `/sarana/non-kejuruan`, `/sarana/kejuruan`
- `/prestasi/sekolah`, `/prestasi/siswa`, `/prestasi/guru`

**Files baru:**
- `Models/MenuItem.php` (relasi parent/children, scope topLevel + active)
- `Filament/Resources/MenuItems/` (Resource + Form + Table + Pages)
- `Pages/Placeholder.vue` (generic placeholder, terima props `title`, `breadcrumb`, `description`)
- `Database/Seeders/MenuItemsSeeder.php`
- `Http/Middleware/HandleInertiaRequests.php` (updated, share `navigation` global)

**Route admin baru:** `/admin/menu-items`

### Sesi 2026-05-11 (Claude Code — Manajemen User, Role, & Divisi)

**Sistem RBAC (Role-Based Access Control)** dengan 3 role:
- `super_admin` — akses semua resource (Berita, Kompetensi, Divisi, HeroBanner, Pesan, User)
- `kompetensi` — hanya bisa edit kompetensi miliknya + buat/edit berita yang ber-tag kompetensi-nya. Tidak bisa create/delete kompetensi baru.
- `divisi` — hanya bisa edit divisi miliknya + buat/edit berita yang ber-tag divisi-nya. Tidak bisa create/delete divisi baru.

**Stack:**
- `spatie/laravel-permission` v7.4 — package roles & permissions
- Auth gating via `FilamentUser::canAccessPanel()` (cek role)
- Scoping via `getEloquentQuery()` di setiap Resource

**Files baru:**
- `Models/Divisi.php`
- `Models/User.php` — implement `FilamentUser`, trait `HasRoles`, relasi `kompetensi()` & `divisi()`, helper `isSuperAdmin()`
- Filament Resources baru: `Divisis/`, `Users/`
- `Models/Berita.php` — relasi `kompetensi()` & `divisi()` + fillable extended
- Seeder `RolesAndUserSeeder` — buat 3 role, convert admin existing ke super_admin, seed Kesiswaan + BKK

**Auto-assign Scope Berita:**
- User `kompetensi` create berita → otomatis `kompetensi_id` = user.kompetensi_id, `divisi_id` = null
- User `divisi` create berita → otomatis `divisi_id` = user.divisi_id, `kompetensi_id` = null
- User `super_admin` — bisa pilih manual lewat form (section "Scope Berita")

**Visibility resource per role:**
- UserResource & HeroBannerResource & PesanResource → hanya super_admin
- KompetensiResource → super_admin + kompetensi
- DivisiResource → super_admin + divisi
- BeritaResource → semua role (dengan filter scope)

**Route admin baru:**
- `/admin/users`
- `/admin/divisis`

### Sesi 2026-05-11 (Claude Code — Perbaikan menu admin & header)

**Perbaikan admin tabel Menu Items** (`app/Filament/Resources/MenuItems/Tables/MenuItemsTable.php`):
- Hapus `->defaultGroup('parent.label')` yang menyebabkan item terpencar & drag-and-drop rusak
- Ganti dengan `->modifyQueryUsing()` + LEFT JOIN ke tabel `menu_items as p` (self-join)
- ORDER BY: `COALESCE(p.display_order, item.display_order)` → `CASE parent_id IS NULL` → `item.display_order`
- Hasil: item parent dan child-nya tampil berdekatan (berurutan) tanpa grouping Filament
- Kolom "#" display_order dihapus, kolom label pakai prefix `▸` (parent) dan `↳` (child)
- `->reorderable('display_order')` kini berfungsi karena tidak ada conflict dengan grouping

**Frontend header** (`resources/js/Components/Layout/Header.vue`):
- Hapus tombol SPMB 2026 — menu jadi 1 baris di semua resolusi

---

### Sesi 2026-05-11 (Claude Code — fitur Hero Banner dinamis)

**Hero Banner Dinamis** — Slide hero beranda `/` sekarang dikelola dari database:
- Migration baru: `hero_banners` (tag, date_display, title, desc, cta_label, cta_href, badge, image nullable, display_order, is_active)
- Model `HeroBanner` dengan scope `active()`
- Filament v4 Resource `HeroBanners/` (CRUD lengkap: form, table dengan reorder dan image preview, badge warna per tag)
- `HomeController` diupdate: ambil dari DB, return array kosong jika tidak ada slide aktif
- `Home.vue` hide `HeroSlider` section jika `slides.length === 0`
- `HeroSlider.vue` tampil gambar jika ada (aspect-ratio 4:3 landscape), fallback ke CSS pattern jika kosong
- Tombol CTA dinamis per slide (tidak ada "Lihat Semua Berita" statis)
- Route admin: `/admin/hero-banners`
- Upload gambar: disk `public`, directory `hero-banners/`, maks 3MB, recommended 800×600px atau landscape
- Fix CORS: `APP_URL` di `.env` → `http://127.0.0.1:8000` (konsisten dengan akses dev)

### Sesi 2026-05-12 (Claude Code — Logo, Gallery & Berita di Halaman Kompetensi)

**Field baru di `kompetensis`:**
- `logo_image` (string nullable) — single logo PNG/transparan, upload via Filament FileUpload, disk `public/kompetensi/logos/`
- `gallery` (JSON nullable) — array path gambar, upload via Filament FileUpload multiple+reorderable, disk `public/kompetensi/gallery/`

**Frontend `/kompetensi/{slug}` (`KompetensiDetail.vue`):**
- Logo tampil di header di samping judul (jika ada)
- **Section Gallery** — grid 2/3/4 kolom (aspect-square), lightbox modal (Teleport ke body) untuk preview full-size dengan nav prev/next
- **Section Berita Kompetensi** — 6 berita terbaru ber-`kompetensi_id` sesuai, card layout sama dengan halaman /berita
- Auto-numbering section: about=01 → sections=02..N+1 → gallery=N+2 → berita=N+3 → lainnya=N+4

**Filament `/admin/kompetensis`** — section "Logo & Gallery" baru di form (visible untuk role super_admin & kompetensi)

**Files diubah:**
- `Models/Kompetensi.php` — fillable + cast `gallery => array`
- `Filament/Resources/Kompetensis/Schemas/KompetensiForm.php` — section Logo & Gallery
- `Http/Controllers/KompetensiController.php` — load berita kompetensi + transform path image ke `/storage/...`
- `Pages/Kompetensi/*.vue` (6 file) — prop `beritas` ditambahkan
- `Components/Sections/KompetensiDetail.vue` — header logo, gallery section + lightbox, berita section

---

### Sesi 2026-05-12 (Claude Code — Halaman Divisi)

**3 halaman divisi dinamis** — menampilkan berita yang di-input oleh user divisi terkait:
- `/kurikulum` — Info Kurikulum (Divisi Kurikulum)
- `/kesiswaan/program` — Program Kesiswaan (Divisi Kesiswaan)
- `/hubungan-industri` — Info Hubin (Divisi Hubungan Industri)

**Stack:**
- `DivisiController::show($slug)` — query `Berita::published()->where('divisi_id', ...)`, featured + paginated list
- `Pages/Divisi/Show.vue` — generic page: PageHeader (breadcrumb + lead dari `divisi.description`), featured card, grid 3 kolom, pagination, empty state
- Routes update: 3 placeholder route diganti closure ke `DivisiController::show()`
- Berita auto-scoped via RBAC (user divisi create berita → `divisi_id` otomatis sesuai user)

---

### Sesi 2026-05-12 (Claude Code — Reposisi Logo Kompetensi)

**Logo kini menggantikan kode di header halaman detail & homepage:**
- **`KompetensiDetail.vue`** — Logo dipindah dari samping kiri judul ke samping kanan (menggantikan kode "AN", "DKV", dll)
  - Logo ditampilkan dengan size `w-32 h-32 lg:w-40 lg:h-40 object-contain` (responsive)
  - Fallback ke kode text jika tidak ada logo (tetap besar `text-[120px] lg:text-[160px]`)
  - Header grid: `grid-cols-1 md:grid-cols-[1fr_auto]` — title/breadcrumb di kiri, logo/code di kanan
- **`KompetensiGrid.vue`** (homepage) — Kode "AN", "DKV" diganti dengan logo (height 16, object-contain)
  - Fallback ke kode text jika tidak ada logo
- **`HomeController.php`** — Map `logo_image` ke props kompetensi (format `/storage/{path}`)

**Dampak:**
- Branding kompetensi lebih visual di homepage & halaman detail
- Responsive design tetap terjaga (mobile/tablet/desktop)

---

### Sesi 2026-05-11 (Claude Code — Modul Rekap Siswa + School Stats)

**Rekap Siswa Dinamis** — halaman `/kesiswaan/rekap-siswa` sekarang dari DB:
- Tabel `rekap_siswa`: matriks 6 kompetensi × 3 kelas (X/XI/XII), kolom rombel/laki_laki/perempuan
- Tabel `school_stats`: 4 angka manual beranda (Guru, Lab, Penghargaan, M²)
- `KesiswaanController::rekapSiswa()` — aggregate per kelas + per kompetensi, hitung pct+bar otomatis
- Vue page: `Pages/Kesiswaan/RekapSiswa.vue` (pindah dari Profil/Kesiswaan.vue)
- Filament `/admin/rekap-siswas` — edit 18 row (filter by kelas/kompetensi), group nav "Kesiswaan"
- Filament `/admin/school-stats` — CRUD 4 angka manual, reorderable, group nav "Kesiswaan"

**StatsBar Beranda Dinamis:**
- Peserta Didik: auto `SUM(laki_laki+perempuan)` dari rekap_siswa
- Kompetensi: auto `count()` dari kompetensis active
- 4 lainnya: dari school_stats by display_order

**Cleanup:**
- Hapus route `/profil/kesiswaan` + method `ProfilController::kesiswaan()` + file `Profil/Kesiswaan.vue`
- Seed: 18 row rekap (data current dibagi rata 3 kelas), 4 school_stats

---

## Hal yang Perlu Diingat

- **PHP path:** Gunakan `/opt/homebrew/opt/php/bin/php` jika `php` di PATH masih 8.2
- **npm/vite:** Jalankan `npm run dev` untuk hot-reload saat development
- **Filament:** Jika ada error class not found, jalankan `php artisan optimize:clear`
- **Session CWD:** Buka Claude Code langsung dari folder `/Users/tamu/Downloads/smkn2cimahi/` agar primary working directory benar
- **Data seed:** Sudah ada 20 berita + 6 kompetensi di DB dari seeders

---

### Sesi 2026-05-13 (Claude Code — Admin Profil Sejarah, Visi-Misi, Kepala Sekolah)

**3 halaman profil dinamis** baru via Filament admin (pattern singleton — 1 row per tabel):

**Sejarah (`/profil/sejarah`):**
- Tabel `profil_sejarah`: title, lead, content (richtext), image, tahun_berdiri, luas_lahan, video_youtube_url
- Model `ProfilSejarah` + static `instance()` helper
- Filament `/admin/profil/sejarah` — RichEditor, FileUpload foto, TextInput YouTube URL
- Vue `Profil/Sejarah.vue`: info card tahun berdiri + luas lahan, foto, rich content, embed YouTube iframe
- Helper `youtubeEmbed()` di ProfilController: convert URL YouTube ke embed URL

**Visi-Misi (`/profil/visi-misi`):**
- Tabel `profil_visi_misi`: visi (text), misi (json), tujuan (json)
- Model `ProfilVisiMisi` + static `instance()`
- Filament `/admin/profil/visi-misi` — Textarea visi, Repeater misi, Repeater tujuan
- Filament `mutateFormDataBeforeFill/Save`: konversi flat string array ↔ Repeater format `[{text: '...'}]`
- Vue `VisiMisi.vue` diupdate: tampilkan `visi` dari DB, section misi/tujuan ber-`v-if` untuk empty guard

**Kepala Sekolah (`/profil/kepala-sekolah`):**
- Tabel `profil_kepala_sekolah`: nama, nip, jabatan, foto, sambutan (richtext)
- Model `ProfilKepalaSekolah` + static `instance()`
- Filament `/admin/profil/kepala-sekolah` — FileUpload foto, TextInput identitas, RichEditor sambutan
- Vue `Profil/KepalaSekolah.vue` baru: layout 2-kolom (foto+identitas kiri, sambutan kanan)

**Arsitektur Singleton Filament v4:**
- `getPages()` hanya punya `'index' => EditPage::route('/')`
- EditPage override `mount()`: `parent::mount(ModelClass::instance()->getKey())`
- `getRedirectUrl()` kembali ke `'index'` setelah save
- Custom `$slug` → URL bersih: `/admin/profil/sejarah`, `/admin/profil/visi-misi`, `/admin/profil/kepala-sekolah`
- Grup navigasi Filament: **"Profil Sekolah"** (sort 1/2/3)
- Akses: hanya `super_admin`

**Files baru:**
- `database/migrations/2026_05_13_*_create_profil_sejarah_table.php` (+ visi_misi, kepala_sekolah)
- `app/Models/ProfilSejarah.php`, `ProfilVisiMisi.php`, `ProfilKepalaSekolah.php`
- `database/seeders/ProfilSeeder.php`
- `app/Filament/Resources/ProfilSejarah/` (Resource + Pages + Schemas)
- `app/Filament/Resources/ProfilVisiMisi/` (Resource + Pages + Schemas)
- `app/Filament/Resources/ProfilKepalaSekolah/` (Resource + Pages + Schemas)
- `resources/js/Pages/Profil/Sejarah.vue` (baru)
- `resources/js/Pages/Profil/KepalaSekolah.vue` (baru)

**Files diubah:**
- `app/Http/Controllers/ProfilController.php` — tambah method `sejarah()`, `kepalaSekolah()`, update `visiMisi()` ke DB
- `routes/web.php` — tambah routes sejarah + kepala-sekolah, hapus 2 placeholder
- `resources/js/Pages/Profil/VisiMisi.vue` — tambah prop `visi`, render dinamis

---

## Yang Belum Dikerjakan / Roadmap

- [x] Dinamis-kan data Kesiswaan — Rekap Siswa via Filament (selesai 2026-05-11)
- [x] Dinamis-kan Sejarah, Visi-Misi, Kepala Sekolah via Filament (selesai 2026-05-13)
- [x] Dinamis-kan data Profil Sekolah (unggulan: BUMA, Ayena, dll) via Filament — selesai Phase 4
- [x] Dinamis-kan Hero Slider di halaman Home (selesai 2026-05-11)
- [x] Dinamis-kan Stats Bar di halaman Home (selesai 2026-05-11)
- [x] Upload gambar berita (cover_image) via Filament — auto-resize 1200×675 (Phase 2)
- [x] SEO meta tags per halaman — `SeoTag` component (Phase 4)
- [x] Sitemap.xml & robots.txt — dynamic `/sitemap.xml` (Phase 4)
- [x] Deploy ke server produksi (staging: staging.smkn2cmi.sch.id)

---

## Optimasi Production — Performance, Security, Testing

> Roadmap untuk hardening production. Dikerjakan bertahap per phase.
> Konfirmasi user diperlukan sebelum lanjut ke phase berikutnya.

### Phase 1 — Quick Wins (impact besar, effort rendah) ✅ SELESAI

**Performance:**
- [x] 1.1 Query caching untuk `KontakSetting`, `SchoolSetting`, `MenuItem` di middleware (TTL 1 jam, auto-flush via Observer)
- [x] 1.7 Lazy load images — `loading="lazy"` + `decoding="async"` di semua `<img>`; LCP candidate pakai `fetchpriority="high"`
- [ ] 1.12 Aktifkan OPcache di cPanel PHP Selector (perlu dilakukan manual di server)
- [x] 1.13 GZIP/Brotli compression via `.htaccess` (mod_deflate + mod_brotli)
- [x] 1.14 Browser cache headers via `.htaccess` (1 tahun untuk asset Vite ber-hash, 6 bulan untuk image)

**Security:**
- [x] 2.5 File upload validation ketat — `acceptedFileTypes()` MIME whitelist + `maxSize` di semua FileUpload
- [x] 2.7 Block PHP execution di `public/storage/` via `.htaccess` (auto-generate via `deploy.php`)
- [x] 2.8 Security header: `X-Frame-Options: SAMEORIGIN`
- [x] 2.9 Security header: `X-Content-Type-Options: nosniff`
- [x] 2.10 Security header: `Referrer-Policy: strict-origin-when-cross-origin`
- [x] 2.11 Security header: `Strict-Transport-Security` (HSTS, 1 tahun + includeSubDomains)
- [x] **Bonus:** `Permissions-Policy` (disable geo/mic/camera/payment), hapus `X-Powered-By`, block akses `.env`/`.git`/`composer.json`

---

### Phase 2 — Medium Effort (3-5 jam, impact tinggi) ✅ SELESAI

**Performance:**
- [x] 1.2 Eager loading audit — controllers sudah pakai `with()`, fix bug minor `cover_image` di DivisiController & PrestasiController formatBerita
- [x] 1.3 Image optimization Filament — built-in `imageResize` + `imageEditor`: cover berita (1200×675), hero (1600×1200), profil sejarah (1600×900), foto kepsek (800×1066), gallery (1400×1400)
- [x] 1.4 DB indexing — migration `add_indexes_for_performance` (8 index composite)
- [x] 1.9 Font optimization — hapus weight Inter & Mono yang tidak dipakai (dari 9 ke 4 weight), tambah `<link rel="preload">`
- [x] 1.10 Verifikasi Tailwind purge — JIT mode aktif, content[] sudah benar (cover blade+vue+js)

**Security:**
- [x] 2.2 Rate limiting — 3 limiter di AppServiceProvider (`web` 120/min, `login` 5/min per email+IP, `api` 60/min)
- [x] 2.4 HTML sanitization — `App\Support\HtmlSanitizer` wrapper Symfony HtmlSanitizer (sudah tersedia di Laravel 13). Auto-sanitize di `Berita::content`, `ProfilSejarah::content`, `ProfilKepalaSekolah::sambutan` via Attribute mutator
- [x] 2.13 Password policy — `Password::defaults()` production: min 8 + mixedCase + numbers + uncompromised (HaveIBeenPwned)

**Testing — Setup & Critical Tests:**
- [~] 3.1 ~~Convert ke Pest~~ — skip, tetap pakai PHPUnit 12 untuk avoid composer dep baru saat deploy
- [x] 3.3 Factory: `BeritaFactory` (+ states: draft/pending/rejected/featured), `KompetensiFactory`, `KategoriFactory`, `AuthorFactory`, `DivisiFactory`
- [x] 3.4 `PublicRoutesTest` — 10 test: homepage, berita index/show, 2 kompetensi, kontak, 3 profil, 404
- [x] 3.5 `KontakFormTest` — 5 test: submit valid (DB + Mail::fake), validation errors, email invalid, subjek whitelist
- [x] 3.6 `BeritaScopeTest` — 4 test: scope published filter approval/future_date/pending/rejected, scope featured
- [x] 3.7 `ApprovalWorkflowTest` — 5 test: pending hidden, approved visible, rejected hidden, state transition approve/reject
- [x] 3.8 + 3.10 `RbacTest` — 7 test: 3 role akses panel, user tanpa role ditolak, scope kompetensi/divisi, guest redirect

---

### Phase 3 — Optional Enhancements ✅ SELESAI

**Performance:**
- [~] 1.5 ~~simplePaginate~~ — skip, UI butuh `last_page` & `links` (full pagination)
- [x] 1.6 Inertia partial reload `only: [...]` di Berita/Index, Divisi/Show, Prestasi/Show — shared cache navigation/setting tidak re-evaluate
- [x] 1.8 Code splitting Vite — `manualChunks` vendor-vue & vendor-inertia, `cssCodeSplit: true`, target `es2020`
- [~] 1.11 ~~Defer non-critical JS~~ — skip, Vite + Inertia sudah auto code-split per page
- [ ] 1.15 Setup Cloudflare CDN — **manual user action** (perlu akses DNS domain)

**Security:**
- [x] 2.12 Content-Security-Policy — restrictive policy via `.htaccess` (whitelist Google Fonts, YouTube, Google Maps)
- [~] 2.14 ~~2FA Filament~~ — skip, butuh composer require baru (deploy lebih kompleks)
- [~] 2.15 ~~Audit log~~ — skip, butuh composer require baru
- [x] 2.16 Session timeout — `.env.example` SESSION_LIFETIME=120 + SESSION_HTTP_ONLY + SESSION_SAME_SITE + SESSION_SECURE_COOKIE
- [x] 2.17 Tidak ada Telescope/Debugbar di project (verified)
- [x] 2.18 `composer audit` — fix 13 CVE (symfony/html-sanitizer, http-foundation, http-kernel, mailer, routing) → 0 vulnerabilities

**Testing — Extended:**
- [x] 3.2 SQLite in-memory verified di `phpunit.xml` (DB_CONNECTION=sqlite, DB_DATABASE=:memory:)
- [x] 3.9 `AutoAssignCreatorTest` (3 test): created_by terisi dari user login, relasi creator, null handling
- [x] 3.11 `SingletonModelsTest` (8 test): KontakSetting, SchoolSetting, ProfilSejarah, ProfilVisiMisi, ProfilKepalaSekolah, BkkSetting singleton + default values
- [x] 3.12 `YoutubeTest` (8 test): null input, watch URL, youtu.be, embed, shorts, query params, invalid URL, short ID
- [x] 3.13 `SlugGenerationTest` (4 test): Berita & Kategori slug auto-generate + explicit slug override
- [x] 3.14 GitHub Actions CI — `.github/workflows/tests.yml` (PHP 8.4, composer cache, npm build, PHPUnit parallel)

**Refactor:**
- Move `youtubeEmbed()` dari ProfilController ke `App\Support\Youtube` (testable, reusable)

---

### Catatan Phase Tracking

- ✅ **Selesai phase X** = update checklist di atas + commit dengan message `Phase X: ...`
- ⏸️ **Konfirmasi user** sebelum mulai phase berikutnya
- 📝 Setiap item yang selesai, tambah catatan di "Riwayat Perubahan" dengan tanggal & detail singkat

---

### Phase 4 — SEO & Discoverability ✅ SELESAI

**A. Dynamic SEO Meta Tags:**
- [x] 4.1 `<SeoTag />` component Vue (title, description, canonical, OG, Twitter Card, JSON-LD)
- [x] 4.2 Open Graph + Twitter Card (preview di WA/FB/X)
- [x] 4.3 Per page meta: Home, Berita Index/Show, Kontak, Profil (Sejarah/VisiMisi/KepalaSekolah), Kompetensi
- [x] 4.4 JSON-LD Schema.org: `EducationalOrganization` (default) + `NewsArticle` (berita)

**B. Sitemap & Robots:**
- [x] 4.5 `SitemapController` — generate `/sitemap.xml` dynamic (static + berita published + kompetensi active) dengan `lastmod` dari `updated_at`, cache 1 jam
- [x] 4.6 `robots.txt` lengkap — allow public + disallow admin/deploy/build + block bot scraper agresif (Ahrefs, Semrush, MJ12) + sitemap reference

**C. Favicon & Manifest:**
- [x] 4.7 `<link rel="icon">` + `apple-touch-icon` di app.blade.php + theme-color #0d6e3f
- [x] 4.8 `manifest.json` — PWA-lite (nama, color, icon, lang id-ID)

**D. Accessibility:**
- [x] 4.9 `alt` attribute audit — semua `<img>` sudah punya alt yang descriptive
- [x] 4.10 `aria-label` di button icon-only (lightbox close/prev/next, dropdown menu, gallery thumbnails)
- [x] 4.11 Skip-to-content link (`.skip-link`) di AppLayout + `id="main-content"` di `<main>`
- [x] 4.12 `:focus-visible` ring-2 ring-accent + `prefers-reduced-motion` support

**E. Error Page:**
- [x] 4.13 `Errors/NotFound.vue` custom + register handler `NotFoundHttpException` di `bootstrap/app.php`

**F. Dinamis Profil Sekolah:**
- [x] 4.14 Migration `profil_unggulan` + Model + Filament Resource — group "Profil Sekolah" sort 4. Seeded 4 default (BUMA, Ayena, Markerspace, TEFA). `ProfilController::sekolah()` query dari DB.

**Testing:**
- [x] `SitemapTest` (7 test): sitemap dapat diakses, valid XML, include homepage/berita published/kompetensi active, exclude berita draft/kompetensi inactive

---

### Sesi 2026-05-31 (Claude Code — Fitur & Fixes Post-Deploy)

**Perbaikan Berita & Penulis:**
- `BeritaController::format()` — tambah `cover_image`, `author` (dari relasi `creator` bukan `author`)
- Tambah kolom `created_by` (FK users) di tabel `beritas` via migration
- `CreateBerita::mutateFormDataBeforeCreate()` — auto-assign `created_by = auth()->id()`
- Frontend (Index/Show) — tampilkan nama penulis dari `berita.author.name`

**Dinamis-kan Kontak, Footer, Header, Topbar:**
- `KontakSetting` — shared ke semua halaman via `HandleInertiaRequests` (key `kontakSetting`)
- `SchoolSetting` — shared ke semua halaman (key `schoolSetting`)
- `Footer.vue` — alamat, telepon, email, sosmed dari DB
- `Topbar.vue` — nama sekolah + tagline dari DB, hide detail di mobile
- `Header.vue` — nama sekolah, logo, EST dari DB

**School Settings Admin:**
- Tabel `school_settings` (singleton): school_name, tagline, logo, tahun_berdiri, nss, npsn, copyright
- Filament `/admin/pengaturan/sekolah` — group Pengaturan, sort 0

**Fitur Approval Berita:**
- Kolom `approval_status` enum(draft/pending/approved/rejected), `approved_by`, `approved_at`
- Non-super_admin create berita → otomatis `pending`, `is_published=false`
- Super admin: tombol Approve/Reject langsung dari tabel admin
- Approve → `is_published=true`, Reject → tidak tayang
- `Berita::scopePublished()` tambah kondisi `approval_status=approved`
- Toggle Publish/Featured disembunyikan dari form non-super_admin

**Deploy ke cPanel:**
- Struktur: `/public_html/` (isi folder `public/`) + `laravel_app/` (seluruh Laravel)
- `index.php` di-edit untuk point ke `laravel_app/`
- `public/storage/.htaccess` block PHP execution (auto via `deploy.php`)
- `config/filesystems.php` disk `public` → `public_path('storage')` (no symlink)
- `APP_URL` + `ASSET_URL` = https, `URL::forceScheme('https')` di AppServiceProvider
- `deploy.php` — script post-deploy (buat folder storage + .htaccess + rebuild cache)

**Phase 5 — Mobile Responsive:**

Overhaul lengkap 24 file untuk mobile-friendly di semua breakpoint.

- **Header**: Hamburger button + mobile drawer accordion, body scroll lock, auto-close on navigate
- **Topbar**: Stack vertical < sm, hide telepon/email < sm
- **Footer**: 1→2→4 cols, copyright stack vertical
- **app.css**: `container-page` padding responsive 16/24/32/56px, typography scale (page-title 36/44/56, section-h2 26/32/40), `.form-input` text-base (anti iOS zoom), btn responsive, section-label responsive
- **Hero slider**: Image order-1 (atas) di mobile, dots scroll horizontal
- **Featured berita card**: Image di atas, text di bawah, padding scale
- **Grid cards**: 1→2→3 cols dengan padding/font responsive
- **StatsBar**: 2→3→6 cols
- **KompetensiGrid**: Logo responsive, padding 5/7/8
- **Berita/Divisi/Prestasi pagination**: Icon-only Prev/Next < sm, nomor scrollable
- **Kontak**: Map height 300/400/480px, form border-top, submit full-width
- **RekapSiswa**: Table min-width 640px + horizontal scroll
- **KepalaSekolah**: Foto centered max-w-240 di mobile
- **NotFound**: Heading 44/64/96px
- **Lightbox**: Button bg semi-transparent di mobile, position 2/4px
- **Vite config**: `manualChunks` via function (Rolldown/Vite 8 compatible)

**Files diubah (mobile):** `app.css`, `Header.vue`, `Topbar.vue`, `Footer.vue`, `HeroSlider.vue`, `KompetensiDetail.vue`, `KompetensiGrid.vue`, `StatsBar.vue`, `Breadcrumb.vue`, `Callout.vue`, `Berita/Index.vue`, `Berita/Show.vue`, `Divisi/Show.vue`, `Prestasi/Show.vue`, `Home.vue`, `Bkk.vue`, `RekapSiswa.vue`, `Kontak.vue`, `KepalaSekolah.vue`, `Sejarah.vue`, `Sekolah.vue`, `VisiMisi.vue`, `Errors/NotFound.vue`, `vite.config.js`
