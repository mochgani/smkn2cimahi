<?php
/**
 * Extract public/build.zip ke public/build/ lewat browser — tanpa perlu
 * extract manual via cPanel File Manager.
 *
 * Alur pakai: git pull (bawa build.zip terbaru) -> buka build.php ini ->
 * folder build/ lama dihapus & diganti isi build.zip yang baru.
 *
 * HAPUS file ini setelah selesai dipakai (atau biarkan, aman dipanggil
 * berkali-kali selama build.zip di-update tiap kali ada perubahan frontend).
 *
 * Akses: https://domain.com/build.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(60);

echo "<pre style='font-family:monospace;line-height:1.6;'>";
echo "=== BUILD EXTRACT SCRIPT SMKN 2 CIMAHI ===\n\n";

$zipPath = __DIR__ . '/build.zip';
$buildDir = __DIR__ . '/build';

if (!file_exists($zipPath)) {
    echo "✗ File build.zip tidak ditemukan di: $zipPath\n";
    echo "  Pastikan sudah git pull / upload build.zip terlebih dahulu.\n";
    echo "</pre>";
    exit;
}

if (!class_exists('ZipArchive')) {
    echo "✗ Extension ZipArchive tidak tersedia di server ini. Extract manual via File Manager.\n";
    echo "</pre>";
    exit;
}

// ---------------------------------------------------------------------------
// 1. Hapus folder build/ lama (kalau ada)
// ---------------------------------------------------------------------------
echo "[1/3] Menghapus folder build/ lama...\n";

function rrmdir(string $dir): void
{
    if (!is_dir($dir)) {
        return;
    }
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        $path = $dir . '/' . $item;
        is_dir($path) ? rrmdir($path) : unlink($path);
    }
    rmdir($dir);
}

if (is_dir($buildDir)) {
    rrmdir($buildDir);
    echo "  ✓ Folder build/ lama dihapus\n";
} else {
    echo "  · Tidak ada folder build/ lama\n";
}

// ---------------------------------------------------------------------------
// 2. Extract build.zip
// ---------------------------------------------------------------------------
echo "\n[2/3] Extract build.zip...\n";

$zip = new ZipArchive();
$result = $zip->open($zipPath);

if ($result !== true) {
    echo "  ✗ Gagal membuka build.zip (kode error: $result)\n";
    echo "</pre>";
    exit;
}

$fileCount = $zip->numFiles;
$zip->extractTo(__DIR__);
$zip->close();

echo "  ✓ Berhasil extract $fileCount file/folder ke public/build/\n";

// ---------------------------------------------------------------------------
// 3. Rebuild cache Laravel (view cache bisa mengacu ke asset lama)
// ---------------------------------------------------------------------------
echo "\n[3/3] Rebuild cache...\n";
try {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

    $kernel->call('view:clear');
    echo "  ✓ view:clear\n";

    $kernel->call('cache:clear');
    echo "  ✓ cache:clear\n";
} catch (\Throwable $e) {
    echo "  ✗ Error saat rebuild cache: " . $e->getMessage() . "\n";
}

echo "\n=== SELESAI ===\n";
echo "Asset frontend terbaru sudah aktif.\n";
echo "</pre>";
