# 🤖 Prompt Template untuk Claude Code

Copy-paste prompt di bawah ini ke Claude Code untuk memulai migrasi.

---

## 📋 Master Prompt (Mulai dari sini)

```
Saya ingin migrasi website static SMK Negeri 2 Cimahi ke Laravel 13 dengan stack:
- Laravel 13 + Inertia.js + Vue 3
- Tailwind CSS v3 (dengan design tokens custom)
- Filament v3 untuk admin panel
- MySQL atau SQLite

Saya sudah punya:
- Migration kit lengkap di folder ini
- HTML static snapshot di reference/html-snapshot/
- CSS original di reference/original-styles.css
- Data JSON di data/berita.json dan data/kompetensi.json
- Tutorial step-by-step di docs/01-setup-laravel.md sampai 08-form-kontak.md
- Logo di assets/logo.png

Tolong baca SETUP.md dulu untuk overview, lalu mulai dari docs/01-setup-laravel.md.

Setiap fase, ikuti tutorial dengan teliti, lalu konfirmasi setelah selesai sebelum lanjut ke fase berikutnya.

Kerjakan satu fase dulu: Fase 1 — Setup Laravel Project.
```

---

## 📋 Prompt per Fase (jika ingin lanjut bertahap)

### Setelah Fase 1 selesai:
```
Fase 1 selesai. Lanjut ke Fase 2: Setup Inertia + Vue 3.
Ikuti docs/02-setup-inertia-vue.md
```

### Setelah Fase 2 selesai:
```
Fase 2 selesai. Lanjut ke Fase 3: Setup Tailwind dengan Design Tokens.
Ikuti docs/03-setup-tailwind.md
```

### Setelah Fase 3 selesai:
```
Fase 3 selesai. Lanjut ke Fase 4: Routes & Controllers.
Ikuti docs/04-routes-controllers.md
```

### Setelah Fase 4 selesai:
```
Fase 4 selesai. Lanjut ke Fase 5: Buat Vue Components dan konversi 14 halaman.

Untuk konversi tiap halaman, gunakan reference HTML di reference/html-snapshot/ 
sebagai panduan struktur dan konten. Konversi ke Vue components dengan Tailwind classes.

Ikuti docs/05-vue-components.md
```

### Setelah Fase 5 selesai:
```
Fase 5 selesai. Lanjut ke Fase 6: Database, Models, Seeders.

Data berita (20 entries) sudah ada di data/berita.json
Data kompetensi (6 entries) sudah ada di data/kompetensi.json

Copy file JSON tersebut ke database/seeders/data/ untuk dipakai seeder.

Ikuti docs/06-database-models.md
```

### Setelah Fase 6 selesai:
```
Fase 6 selesai. Lanjut ke Fase 7: Setup Filament v3 Admin Panel.
Ikuti docs/07-filament-admin.md
```

### Setelah Fase 7 selesai:
```
Fase 7 selesai. Lanjut ke Fase 8 (terakhir): Form Kontak dengan Email.
Ikuti docs/08-form-kontak.md
```

---

## 🚀 Quick Reference

### Files yang harus dipakai:

| File | Fungsi |
|---|---|
| `SETUP.md` | Overview & roadmap migrasi |
| `docs/01-setup-laravel.md` | Setup Laravel project |
| `docs/02-setup-inertia-vue.md` | Install Inertia + Vue 3 |
| `docs/03-setup-tailwind.md` | Tailwind config + design tokens |
| `docs/04-routes-controllers.md` | Routes & controllers |
| `docs/05-vue-components.md` | Konversi HTML → Vue |
| `docs/06-database-models.md` | DB schema + models + seeders |
| `docs/07-filament-admin.md` | Admin panel Filament |
| `docs/08-form-kontak.md` | Form kontak + email |
| `data/berita.json` | Data 20 berita siap import |
| `data/kompetensi.json` | Data 6 kompetensi siap import |
| `reference/html-snapshot/` | HTML asli sebagai panduan visual |
| `reference/original-styles.css` | CSS original (~58KB) sebagai referensi |
| `assets/logo.png` | Logo sekolah |

### Design Tokens (Tailwind):

```js
colors: {
    bg: { DEFAULT: '#fafaf8', alt: '#f4f2ec' },
    ink: { DEFAULT: '#0a0a0a', soft: '#1a1a1a' },
    accent: { DEFAULT: '#0d6e3f', dark: '#095530' },
    muted: { DEFAULT: '#6b6b66', soft: '#3a3a36' },
    line: { DEFAULT: '#d4d0c5', soft: '#e8e6e0' },
},
fontFamily: {
    sans: ['Inter', ...],
    mono: ['JetBrains Mono', ...],
},
maxWidth: { page: '1280px' },
```

### URL Map:

| Route | Halaman |
|---|---|
| `/` | Beranda |
| `/profil/sekolah` | Profil Sekolah |
| `/profil/visi-misi` | Visi & Misi |
| `/profil/kesiswaan` | Kesiswaan |
| `/profil/bkk` | Bursa Kerja Khusus |
| `/kompetensi/animasi` | Animasi |
| `/kompetensi/dkv` | Desain Komunikasi Visual |
| `/kompetensi/rpl` | Rekayasa Perangkat Lunak |
| `/kompetensi/kimia` | Teknik Kimia Industri |
| `/kompetensi/mekatronika` | Teknik Mekatronika |
| `/kompetensi/pemesinan` | Teknik Pemesinan |
| `/berita` | Listing berita |
| `/berita/{slug}` | Detail berita |
| `/kontak` | Kontak |
| `/admin` | Filament admin panel |

---

## ⚠️ Tips Penting

1. **Jangan skip baca dokumen** — tiap fase ada langkah-langkah yang penting
2. **Test setelah tiap fase** — pastikan tidak ada error sebelum lanjut
3. **Backup database** sebelum run `php artisan migrate:fresh`
4. **Keep `reference/html-snapshot/`** untuk visual reference saat konversi Vue
5. **Pakai Vue Devtools** browser extension untuk debug Vue components
6. **Pakai Inertia.js docs**: https://inertiajs.com untuk reference

---

## 🆘 Troubleshooting

### Error: "vite manifest not found"
```bash
npm run build
# atau saat development:
npm run dev
```

### Error: "419 Page Expired" saat submit form
Pastikan ada `<meta name="csrf-token">` di `app.blade.php`.

### Filament admin panel tidak muncul
```bash
php artisan optimize:clear
php artisan filament:upgrade
```

### Vue component tidak update setelah edit
Pastikan `npm run dev` masih jalan. Cek terminal untuk error.

---

🎓 **Selamat migrating!** Estimated total time: 10-12 jam untuk full migration.
