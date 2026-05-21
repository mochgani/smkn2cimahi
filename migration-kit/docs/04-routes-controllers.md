# Fase 4: Routes & Controllers

Estimasi: ~30 menit

Tujuan: Setup semua routing untuk 14 halaman dan buat controllers yang mengirim data ke Inertia.

## 1. Generate Controllers

```bash
php artisan make:controller HomeController
php artisan make:controller ProfilController
php artisan make:controller KompetensiController
php artisan make:controller BeritaController
php artisan make:controller KontakController
```

## 2. Setup `routes/web.php`

Replace seluruh isi `routes/web.php`:

```php
<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KompetensiController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

// Beranda
Route::get('/', [HomeController::class, 'index'])->name('home');

// Profil
Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/sekolah', [ProfilController::class, 'sekolah'])->name('sekolah');
    Route::get('/visi-misi', [ProfilController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/kesiswaan', [ProfilController::class, 'kesiswaan'])->name('kesiswaan');
    Route::get('/bkk', [ProfilController::class, 'bkk'])->name('bkk');
});

// Kompetensi Keahlian
Route::prefix('kompetensi')->name('kompetensi.')->group(function () {
    Route::get('/animasi', [KompetensiController::class, 'animasi'])->name('animasi');
    Route::get('/dkv', [KompetensiController::class, 'dkv'])->name('dkv');
    Route::get('/rpl', [KompetensiController::class, 'rpl'])->name('rpl');
    Route::get('/kimia', [KompetensiController::class, 'kimia'])->name('kimia');
    Route::get('/mekatronika', [KompetensiController::class, 'mekatronika'])->name('mekatronika');
    Route::get('/pemesinan', [KompetensiController::class, 'pemesinan'])->name('pemesinan');
});

// Berita
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

// Kontak
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak.index');
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');
```

## 3. Implement Controllers

### `app/Http/Controllers/HomeController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'beritaTerbaru' => Berita::with('kategoris')
                ->latest('published_at')
                ->take(3)
                ->get()
                ->map(fn($b) => [
                    'slug' => $b->slug,
                    'title' => $b->title,
                    'date' => $b->published_at->format('d.m.Y'),
                    'date_full' => $b->published_at->translatedFormat('d F Y'),
                    'excerpt' => $b->excerpt,
                    'categories' => $b->kategoris->pluck('name'),
                ]),
            'stats' => [
                'siswa' => 1576,
                'guru' => 114,
                'lab' => 11,
                'kompetensi' => 6,
                'penghargaan' => '50+',
                'lahan' => '16K',
            ],
        ]);
    }
}
```

### `app/Http/Controllers/ProfilController.php`

```php
<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ProfilController extends Controller
{
    public function sekolah()
    {
        return Inertia::render('Profil/Sekolah');
    }

    public function visiMisi()
    {
        return Inertia::render('Profil/VisiMisi');
    }

    public function kesiswaan()
    {
        // Data kesiswaan (statis untuk sekarang, bisa dipindah ke DB nanti)
        return Inertia::render('Profil/Kesiswaan', [
            'summary' => [
                'total' => 1479,
                'rombel' => 42,
                'kelasX' => ['total' => 546, 'L' => 443, 'P' => 103],
                'kelasXI' => ['total' => 521, 'L' => 419, 'P' => 102],
                'kelasXII' => ['total' => 412, 'L' => 309, 'P' => 103],
            ],
            'distribusi' => [
                ['code' => 'MK', 'name' => 'Teknik Mekatronika', 'rombel' => 16, 'L' => 381, 'P' => 12, 'total' => 393],
                ['code' => 'TKI', 'name' => 'Teknik Kimia Industri', 'rombel' => 6, 'L' => 219, 'P' => 57, 'total' => 276],
                ['code' => 'DKV', 'name' => 'Multimedia / DKV', 'rombel' => 6, 'L' => 175, 'P' => 72, 'total' => 247],
                ['code' => 'RPL', 'name' => 'Rekayasa Perangkat Lunak', 'rombel' => 7, 'L' => 176, 'P' => 53, 'total' => 229],
                ['code' => 'AN', 'name' => 'Animasi', 'rombel' => 5, 'L' => 139, 'P' => 55, 'total' => 194],
                ['code' => 'TP', 'name' => 'Teknik Pemesinan', 'rombel' => 2, 'L' => 138, 'P' => 2, 'total' => 140],
            ],
        ]);
    }

    public function bkk()
    {
        return Inertia::render('Profil/BKK', [
            'perusahaan' => [
                'PT Denso', 'PT Ateja', 'PT Medion', 'PT DMK',
                'PT Alkindo', 'PT Essei Perbama', 'Pusdatin Kemendikbud',
                'PT Patopo', 'PT CGNPM', 'PT BUMA', 'PT Bina Muda',
            ],
        ]);
    }
}
```

### `app/Http/Controllers/KompetensiController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Kompetensi;
use Inertia\Inertia;

class KompetensiController extends Controller
{
    private function render(string $slug, string $component)
    {
        $kompetensi = Kompetensi::where('slug', $slug)->firstOrFail();
        
        $lainnya = Kompetensi::where('slug', '!=', $slug)
            ->orderBy('display_order')
            ->get();

        return Inertia::render("Kompetensi/$component", [
            'kompetensi' => $kompetensi,
            'lainnya' => $lainnya,
        ]);
    }

    public function animasi() { return $this->render('animasi', 'Animasi'); }
    public function dkv() { return $this->render('dkv', 'DKV'); }
    public function rpl() { return $this->render('rpl', 'RPL'); }
    public function kimia() { return $this->render('kimia', 'Kimia'); }
    public function mekatronika() { return $this->render('mekatronika', 'Mekatronika'); }
    public function pemesinan() { return $this->render('pemesinan', 'Pemesinan'); }
}
```

### `app/Http/Controllers/BeritaController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use Inertia\Inertia;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');

        $query = Berita::with('kategoris')->latest('published_at');

        if ($kategori && $kategori !== 'all') {
            $query->whereHas('kategoris', fn($q) => $q->where('slug', $kategori));
        }

        $berita = $query->paginate(12);

        $kategoris = Kategori::withCount('beritas')->get();

        return Inertia::render('Berita/Index', [
            'berita' => $berita,
            'kategoris' => $kategoris,
            'featured' => Berita::with('kategoris')
                ->latest('published_at')
                ->first(),
            'currentKategori' => $kategori,
        ]);
    }

    public function show(string $slug)
    {
        $berita = Berita::with(['kategoris', 'author'])
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Berita::with('kategoris')
            ->where('id', '!=', $berita->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return Inertia::render('Berita/Show', [
            'berita' => $berita,
            'related' => $related,
        ]);
    }
}
```

### `app/Http/Controllers/KontakController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePesanRequest;
use App\Mail\PesanKontakMail;
use App\Models\Pesan;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class KontakController extends Controller
{
    public function index()
    {
        return Inertia::render('Kontak');
    }

    public function store(StorePesanRequest $request)
    {
        $pesan = Pesan::create($request->validated());

        // Kirim email notification ke admin
        try {
            Mail::to(config('mail.from.address'))->send(new PesanKontakMail($pesan));
        } catch (\Exception $e) {
            // Log error, tapi jangan gagalkan request
            \Log::error('Gagal kirim email kontak: ' . $e->getMessage());
        }

        return redirect()
            ->route('kontak.index')
            ->with('success', 'Pesan Anda telah terkirim. Kami akan merespon dalam 1×24 jam.');
    }
}
```

## 4. Test Routes

```bash
# Lihat semua routes
php artisan route:list

# Test akses (akan error karena belum ada views)
curl -I http://localhost:8000/profil/sekolah
# Expect: 200 OK (akan render Inertia kosong dulu)
```

## 5. Buat Vue Pages Placeholder

Agar tidak error, buat placeholder Vue files dulu:

```bash
# Buat folder structure
mkdir -p resources/js/Pages/Profil
mkdir -p resources/js/Pages/Kompetensi
mkdir -p resources/js/Pages/Berita
```

Buat placeholder cepat untuk semua halaman:

```bash
cat > resources/js/Pages/Profil/Sekolah.vue <<'EOF'
<script setup>
import { Head } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Profil Sekolah" />
    <h1>Profil Sekolah (placeholder)</h1>
</template>
EOF
```

Ulangi untuk file-file lain (atau pakai script):

```bash
for page in Profil/VisiMisi Profil/Kesiswaan Profil/BKK \
            Kompetensi/Animasi Kompetensi/DKV Kompetensi/RPL \
            Kompetensi/Kimia Kompetensi/Mekatronika Kompetensi/Pemesinan \
            Berita/Index Berita/Show Kontak; do
    file="resources/js/Pages/${page}.vue"
    cat > "$file" <<EOF
<script setup>
import { Head } from '@inertiajs/vue3';
</script>
<template>
    <Head title="${page}" />
    <h1>${page} (placeholder)</h1>
</template>
EOF
done
```

## ✅ Verifikasi Fase 4

```bash
php artisan route:list --except-vendor
```

Output expected (~17 routes):
- `GET  /` → home
- `GET  /profil/sekolah`, `/profil/visi-misi`, `/profil/kesiswaan`, `/profil/bkk`
- `GET  /kompetensi/animasi`, `/dkv`, `/rpl`, `/kimia`, `/mekatronika`, `/pemesinan`
- `GET  /berita`, `/berita/{slug}`
- `GET/POST /kontak`

Coba akses semua route di browser:
- http://localhost:8000
- http://localhost:8000/profil/sekolah
- http://localhost:8000/kompetensi/animasi
- ... dst

Semua harus tampil placeholder tanpa error.

## ➡️ Lanjut ke

[`05-vue-components.md`](./05-vue-components.md)
