<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use UnitEnum;
use ZipArchive;

class SystemTools extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static ?string $navigationLabel = 'Tools Deploy';

    protected static ?int $navigationSort = 99;

    protected string $view = 'filament.pages.system-tools';

    public ?string $migrateOutput = null;

    public ?string $buildOutput = null;

    public ?string $deployOutput = null;

    public ?string $envOutput = null;

    public static function canAccess(): bool
    {
        return auth()->user()?->isSuperAdmin() ?? false;
    }

    public function getTitle(): string
    {
        return 'Tools Deploy & Maintenance';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('runMigrate')
                ->label('Jalankan Migration')
                ->icon('heroicon-o-circle-stack')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Jalankan Migration')
                ->modalDescription('Menjalankan php artisan migrate --force. Aman dijalankan berkali-kali — migration yang sudah pernah jalan otomatis dilewati.')
                ->action(function () {
                    Artisan::call('migrate', ['--force' => true]);
                    $this->migrateOutput = Artisan::output();

                    Notification::make()
                        ->title('Migration selesai')
                        ->success()
                        ->send();
                }),

            Action::make('extractBuild')
                ->label('Extract build.zip')
                ->icon('heroicon-o-archive-box-arrow-down')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Extract build.zip')
                ->modalDescription('Folder public/build/ yang lama akan DIHAPUS dan diganti isi build.zip yang baru. Pastikan build.zip sudah ter-update (git pull) sebelum menjalankan ini.')
                ->action(function () {
                    $this->buildOutput = $this->doExtractBuild();

                    Notification::make()
                        ->title('Extract build.zip selesai')
                        ->success()
                        ->send();
                }),

            Action::make('deploySetup')
                ->label('Setup Deploy')
                ->icon('heroicon-o-server-stack')
                ->color('gray')
                ->requiresConfirmation()
                ->modalHeading('Setup Deploy')
                ->modalDescription('Membuat folder storage yang dibutuhkan, .htaccess keamanan di public/storage, dan rebuild cache config/route/view.')
                ->action(function () {
                    $this->deployOutput = $this->doDeploySetup();

                    Notification::make()
                        ->title('Setup deploy selesai')
                        ->success()
                        ->send();
                }),

            Action::make('setEnvVar')
                ->label('Set Environment Variable')
                ->icon('heroicon-o-key')
                ->color('info')
                ->schema([
                    TextInput::make('key')
                        ->label('Key')
                        ->placeholder('GOOGLE_CALENDAR_API_KEY')
                        ->required()
                        ->rule('regex:/^[A-Z0-9_]+$/')
                        ->helperText('Huruf besar, angka, underscore saja.'),

                    TextInput::make('value')
                        ->label('Value')
                        ->required(),
                ])
                ->action(function (array $data) {
                    $this->envOutput = $this->doSetEnvVar($data['key'], $data['value']);

                    Notification::make()
                        ->title("Env {$data['key']} berhasil disimpan")
                        ->success()
                        ->send();
                }),
        ];
    }

    private function doExtractBuild(): string
    {
        $zipPath = public_path('build.zip');
        $buildDir = public_path('build');
        $log = [];

        if (! file_exists($zipPath)) {
            return "✗ File build.zip tidak ditemukan di public/build.zip";
        }

        if (File::isDirectory($buildDir)) {
            File::deleteDirectory($buildDir);
            $log[] = "✓ Folder build/ lama dihapus";
        } else {
            $log[] = "· Tidak ada folder build/ lama";
        }

        $zip = new ZipArchive();
        $result = $zip->open($zipPath);

        if ($result !== true) {
            return implode("\n", $log) . "\n✗ Gagal membuka build.zip (kode error: {$result})";
        }

        $fileCount = $zip->numFiles;
        $zip->extractTo(public_path());
        $zip->close();

        $log[] = "✓ Berhasil extract {$fileCount} file/folder ke public/build/";

        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        $log[] = "✓ view:clear & cache:clear";

        return implode("\n", $log);
    }

    private function doDeploySetup(): string
    {
        $log = [];

        $storageDirs = [
            storage_path('app/public'),
            storage_path('app/private'),
            storage_path('framework/cache/data'),
            storage_path('framework/sessions'),
            storage_path('framework/views'),
            storage_path('logs'),
            base_path('bootstrap/cache'),
            public_path('storage'),
        ];

        foreach ($storageDirs as $dir) {
            if (! is_dir($dir)) {
                File::makeDirectory($dir, 0755, true);
                $log[] = "✓ Buat: " . str_replace(base_path(), '', $dir);
            } else {
                $log[] = "· OK: " . str_replace(base_path(), '', $dir);
            }
        }

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

        File::put(public_path('storage/.htaccess'), $htaccessContent);
        $log[] = "✓ public/storage/.htaccess berhasil dibuat";

        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        $log[] = "✓ config/route/view/cache cleared";

        return implode("\n", $log);
    }

    private function doSetEnvVar(string $key, string $value): string
    {
        $envPath = base_path('.env');

        if (! file_exists($envPath) || ! is_writable($envPath)) {
            return "✗ File .env tidak ditemukan atau tidak bisa ditulis.";
        }

        $content = file_get_contents($envPath);
        $needsQuotes = preg_match('/\s|#|"/', $value);
        $formattedValue = $needsQuotes ? '"' . str_replace('"', '\"', $value) . '"' : $value;
        $line = "{$key}={$formattedValue}";

        $pattern = '/^' . preg_quote($key, '/') . '=.*$/m';
        $log = [];

        if (preg_match($pattern, $content)) {
            $content = preg_replace($pattern, $line, $content);
            $log[] = "✓ Update: {$key}";
        } else {
            $content = rtrim($content) . "\n{$line}\n";
            $log[] = "✓ Tambah: {$key}";
        }

        File::put($envPath, $content);

        Artisan::call('config:clear');
        Artisan::call('config:cache');
        $log[] = "✓ config:clear & config:cache";

        return implode("\n", $log);
    }
}
