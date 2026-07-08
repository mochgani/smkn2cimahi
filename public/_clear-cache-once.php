<?php
/**
 * SCRIPT SEKALI PAKAI — transisi dari script deploy lama (migrate.php,
 * deploy.php, set-env.php, build.php) ke halaman admin /admin/system-tools.
 *
 * Kalau setelah git pull menu "Tools Deploy" di admin tidak muncul atau
 * halaman /admin/system-tools 404, kemungkinan besar karena route:cache
 * lama masih aktif dan belum tahu route baru ini ada. Jalankan script ini
 * SEKALI untuk clear semua cache, lalu HAPUS file ini dari server.
 *
 * Akses: https://domain.com/_clear-cache-once.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre style='font-family:monospace;line-height:1.6;'>";
echo "=== CLEAR CACHE (SEKALI PAKAI) ===\n\n";

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

foreach (['config:clear', 'route:clear', 'view:clear', 'cache:clear'] as $command) {
    $kernel->call($command);
    echo "  ✓ {$command}\n";
}

echo "\n=== SELESAI ===\n";
echo "Sekarang coba buka /admin/system-tools lagi.\n";
echo "⚠️  HAPUS file _clear-cache-once.php ini setelah selesai!\n";
echo "</pre>";
