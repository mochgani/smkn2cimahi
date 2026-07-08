<?php
/**
 * Tambah/update satu baris variabel di .env lewat browser, tanpa perlu
 * edit manual via cPanel File Manager (yang sering error untuk sebagian
 * hosting saat menyimpan file .env).
 *
 * HAPUS file ini setelah selesai dipakai!
 *
 * Akses: https://domain.com/set-env.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Variabel yang mau di-set. Edit array ini kalau perlu tambah/ubah key lain.
$varsToSet = [
    'GOOGLE_CALENDAR_API_KEY' => 'AIzaSyBETMKmjnFubpgiCjJrCULcEu3zAe6SnXw',
];

echo "<pre style='font-family:monospace;line-height:1.6;'>";
echo "=== SET ENV SCRIPT SMKN 2 CIMAHI ===\n\n";

$envPath = __DIR__ . '/../.env';

if (!file_exists($envPath)) {
    echo "✗ File .env tidak ditemukan di: $envPath\n";
    echo "</pre>";
    exit;
}

if (!is_writable($envPath)) {
    echo "✗ File .env tidak bisa ditulis (permission denied). Cek permission file .env di server.\n";
    echo "</pre>";
    exit;
}

$content = file_get_contents($envPath);
$updated = 0;
$added = 0;

foreach ($varsToSet as $key => $value) {
    // Escape nilai kalau mengandung spasi/karakter khusus
    $needsQuotes = preg_match('/\s|#|"/', $value);
    $formattedValue = $needsQuotes ? '"' . str_replace('"', '\"', $value) . '"' : $value;
    $line = "{$key}={$formattedValue}";

    $pattern = '/^' . preg_quote($key, '/') . '=.*$/m';

    if (preg_match($pattern, $content)) {
        $content = preg_replace($pattern, $line, $content);
        $updated++;
        echo "  ✓ Update: {$key}\n";
    } else {
        $content = rtrim($content) . "\n{$line}\n";
        $added++;
        echo "  ✓ Tambah: {$key}\n";
    }
}

if (file_put_contents($envPath, $content) === false) {
    echo "\n✗ Gagal menyimpan .env (permission denied saat menulis).\n";
    echo "</pre>";
    exit;
}

echo "\n[1/2] .env berhasil diperbarui ({$updated} update, {$added} baris baru).\n";

// Rebuild cache config supaya perubahan langsung kepakai
echo "\n[2/2] Rebuild cache config...\n";
try {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

    $kernel->call('config:clear');
    echo "  ✓ config:clear\n";

    $kernel->call('config:cache');
    echo "  ✓ config:cache\n";
} catch (\Throwable $e) {
    echo "  ✗ Error saat rebuild cache: " . $e->getMessage() . "\n";
}

echo "\n=== SELESAI ===\n";
echo "⚠️  HAPUS file set-env.php ini sekarang juga — isinya berisi API key rahasia!\n";
echo "</pre>";
