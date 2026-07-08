<?php
/**
 * Post-deploy script untuk shared hosting cPanel.
 *
 * Jalankan SEKALI setelah deploy/pull dari git untuk:
 * 1. Buat folder storage yang gitignored (framework/cache/data, sessions, views)
 * 2. Setup .htaccess security untuk folder upload (public/storage/)
 * 3. Clear & rebuild cache Laravel (config, route, view)
 *
 * HAPUS file ini setelah selesai!
 *
 * Akses: https://domain.com/deploy.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre style='font-family:monospace;line-height:1.6;'>";
echo "=== POST-DEPLOY SCRIPT SMKN 2 CIMAHI ===\n\n";

// ---------------------------------------------------------------------------
// 1. Buat folder storage Laravel
// ---------------------------------------------------------------------------
echo "[1/3] Memastikan folder storage Laravel ada...\n";
$storageDirs = [
    __DIR__ . '/../storage/app/public',
    __DIR__ . '/../storage/app/private',
    __DIR__ . '/../storage/framework/cache/data',
    __DIR__ . '/../storage/framework/sessions',
    __DIR__ . '/../storage/framework/views',
    __DIR__ . '/../storage/logs',
    __DIR__ . '/../bootstrap/cache',
    __DIR__ . '/storage', // folder upload public (pengganti symlink)
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "  ✓ Buat: " . str_replace(__DIR__, '', $dir) . "\n";
        } else {
            echo "  ✗ GAGAL buat: " . str_replace(__DIR__, '', $dir) . "\n";
        }
    } else {
        echo "  · OK: " . str_replace(__DIR__, '', $dir) . "\n";
    }
}

// ---------------------------------------------------------------------------
// 2. Setup .htaccess di public/storage untuk block PHP execution
// ---------------------------------------------------------------------------
echo "\n[2/3] Setup security .htaccess di folder upload (public/storage)...\n";
$storageHtaccess = __DIR__ . '/storage/.htaccess';
$htaccessContent = <<<HTACCESS
# Block eksekusi script di folder upload
<FilesMatch "\.(php|phtml|php3|php4|php5|php7|phps|phar|inc|sh|cgi|pl|py|asp|aspx)$">
    Require all denied
</FilesMatch>

Options -Indexes -ExecCGI

<FilesMatch "\.(jpg|jpeg|png|gif|webp|avif|svg|pdf|doc|docx|xls|xlsx|zip|mp4|webm|mp3|ogg|woff|woff2|ttf|ico)$">
    Require all granted
</FilesMatch>

<IfModule mod_headers.c>
    <FilesMatch "\.(htm|html|svg)$">
        Header set Content-Disposition "attachment"
    </FilesMatch>
</IfModule>
HTACCESS;

if (file_put_contents($storageHtaccess, $htaccessContent) !== false) {
    echo "  ✓ public/storage/.htaccess berhasil dibuat\n";
} else {
    echo "  ✗ Gagal membuat public/storage/.htaccess (cek permission)\n";
}

// ---------------------------------------------------------------------------
// 3. Rebuild Laravel cache
// ---------------------------------------------------------------------------
echo "\n[3/3] Rebuild Laravel cache...\n";
try {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

    $kernel->call('config:clear');
    echo "  ✓ config:clear\n";

    $kernel->call('route:clear');
    echo "  ✓ route:clear\n";

    $kernel->call('view:clear');
    echo "  ✓ view:clear\n";

    $kernel->call('cache:clear');
    echo "  ✓ cache:clear\n";

    $kernel->call('config:cache');
    echo "  ✓ config:cache\n";

    $kernel->call('route:cache');
    echo "  ✓ route:cache\n";

    $kernel->call('view:cache');
    echo "  ✓ view:cache\n";
} catch (\Throwable $e) {
    echo "  ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== SELESAI ===\n";
echo "⚠️  JANGAN LUPA HAPUS FILE deploy.php INI SETELAH SELESAI!\n";
echo "</pre>";
