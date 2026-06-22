<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\BkkController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KesiswaanController;
use App\Http\Controllers\KompetensiController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');

// SEO: sitemap dynamic dari DB
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::prefix('profil')->name('profil.')->controller(ProfilController::class)->group(function () {
    Route::get('/sekolah', 'sekolah')->name('sekolah');
    Route::get('/sejarah', 'sejarah')->name('sejarah');
    Route::get('/visi-misi', 'visiMisi')->name('visi-misi');
    Route::get('/kepala-sekolah', 'kepalaSekolah')->name('kepala-sekolah');
    Route::get('/bkk', 'bkk')->name('bkk');
});

Route::prefix('kompetensi')->name('kompetensi.')->controller(KompetensiController::class)->group(function () {
    Route::get('/animasi', 'animasi')->name('animasi');
    Route::get('/dkv', 'dkv')->name('dkv');
    Route::get('/rpl', 'rpl')->name('rpl');
    Route::get('/kimia', 'kimia')->name('kimia');
    Route::get('/mekatronika', 'mekatronika')->name('mekatronika');
    Route::get('/pemesinan', 'pemesinan')->name('pemesinan');
});

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

Route::get('/kontak', [KontakController::class, 'index'])->name('kontak.index');
Route::post('/kontak', [KontakController::class, 'store'])
    ->middleware('throttle:5,60')
    ->name('kontak.store');

/*
 * Placeholder routes — halaman belum diisi konten,
 * akan dipindah ke controller masing-masing ketika kontennya disiapkan.
 */
$placeholder = fn (string $title, string $breadcrumb = '') =>
    fn () => Inertia::render('Placeholder', ['title' => $title, 'breadcrumb' => $breadcrumb ?: $title]);

// Kurikulum
Route::get('/kurikulum',           [KurikulumController::class, 'tentang'])->name('kurikulum.tentang');
Route::get('/kurikulum/struktur',  [KurikulumController::class, 'struktur'])->name('kurikulum.struktur');

// Kesiswaan
Route::get('/kesiswaan/program', fn () => app(DivisiController::class)->show('kesiswaan'))->name('kesiswaan.program');
Route::get('/kesiswaan/rekap-siswa', [KesiswaanController::class, 'rekapSiswa'])->name('kesiswaan.rekap');

// Hubungan Industri — berita dari Divisi Hubungan Industri
Route::get('/hubungan-industri', fn () => app(DivisiController::class)->show('hubungan-industri'))->name('hubin.index');
Route::get('/hubungan-industri/bkk', [BkkController::class, 'index'])->name('hubin.bkk');

// Sarana Prasarana
Route::get('/sarana/non-kejuruan', $placeholder('Sarana Pembelajaran Non Kejuruan', 'Sarana / Non Kejuruan'))->name('sarana.non-kejuruan');
Route::get('/sarana/kejuruan', $placeholder('Sarana Pembelajaran Kejuruan', 'Sarana / Kejuruan'))->name('sarana.kejuruan');

// Prestasi — berita berdasarkan kategori prestasi
Route::get('/prestasi/sekolah', fn () => app(PrestasiController::class)->show('sekolah'))->name('prestasi.sekolah');
Route::get('/prestasi/siswa',   fn () => app(PrestasiController::class)->show('siswa'))->name('prestasi.siswa');
Route::get('/prestasi/guru',    fn () => app(PrestasiController::class)->show('guru'))->name('prestasi.guru');
