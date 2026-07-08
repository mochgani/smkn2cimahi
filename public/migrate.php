<?php
/**
 * Jalankan migration Laravel tanpa akses terminal (shared hosting cPanel).
 *
 * Jalankan SETIAP KALI setelah git pull yang membawa migration baru.
 * Migration bersifat idempotent — hanya migration yang belum dijalankan
 * (status "Pending") yang akan dieksekusi, aman dipanggil berkali-kali.
 *
 * HAPUS file ini setelah tidak dipakai lagi / setelah selesai deploy!
 *
 * Akses: https://domain.com/migrate.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(120);

echo "<pre style='font-family:monospace;line-height:1.6;'>";
echo "=== MIGRATE SCRIPT SMKN 2 CIMAHI ===\n\n";

try {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

    echo "[1/3] Cek status migration...\n";
    $kernel->call('migrate:status');
    echo $kernel->output();

    echo "\n[2/3] Menjalankan migration (--force)...\n";
    $kernel->call('migrate', ['--force' => true]);
    echo $kernel->output();

    echo "\n[3/3] Rebuild cache...\n";
    $kernel->call('config:clear');
    $kernel->call('route:clear');
    $kernel->call('view:clear');
    $kernel->call('cache:clear');
    $kernel->call('config:cache');
    $kernel->call('route:cache');
    $kernel->call('view:cache');
    echo "  ✓ Cache di-rebuild\n";

    echo "\n=== SELESAI ===\n";
} catch (\Throwable $e) {
    echo "✗ ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}

echo "\n⚠️  Setelah migration sukses, hapus/kosongkan file migrate.php ini agar tidak bisa diakses publik.\n";
echo "</pre>";
