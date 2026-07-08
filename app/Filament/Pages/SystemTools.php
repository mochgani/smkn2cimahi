<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
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

    public ?string $deployOutput = null;

    public ?string $buildOutput = null;

    public ?string $migrateOutput = null;

    public ?string $seederOutput = null;

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
            Action::make('deploy')
                ->label('Deploy')
                ->icon('heroicon-o-rocket-launch')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Deploy Penuh')
                ->modalDescription('Jalankan migration, seeder (DatabaseSeeder default), extract build.zip, lalu clear semua cache — sekaligus. ⚠️ Seeder bisa menambahkan ulang data sample lama kalau belum pernah dijalankan / datanya sudah dihapus. Pastikan git pull sudah dilakukan sebelum klik ini.')
                ->action(function () {
                    $log = [];
                    $log[] = "=== MIGRATION ===\n" . $this->runMigrations();
                    $log[] = "=== SEEDER ===\n" . $this->runSeeder(null);
                    $log[] = "=== EXTRACT BUILD.ZIP ===\n" . $this->runExtractBuild();
                    $log[] = "=== CLEAR CACHE ===\n" . $this->runClearAllCache();

                    $this->deployOutput = implode("\n\n", $log);

                    Notification::make()
                        ->title('Deploy selesai')
                        ->success()
                        ->send();
                }),

            Action::make('build')
                ->label('Build')
                ->icon('heroicon-o-archive-box-arrow-down')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Extract build.zip')
                ->modalDescription('Folder public/build/ yang lama akan DIHAPUS dan diganti isi build.zip yang baru. Pastikan build.zip sudah ter-update (git pull) sebelum menjalankan ini.')
                ->action(function () {
                    $this->buildOutput = $this->runExtractBuild();

                    Notification::make()
                        ->title('Extract build.zip selesai')
                        ->success()
                        ->send();
                }),

            Action::make('migrate')
                ->label('Migrate')
                ->icon('heroicon-o-circle-stack')
                ->color('info')
                ->requiresConfirmation()
                ->modalHeading('Jalankan Migration')
                ->modalDescription('Menjalankan php artisan migrate --force. Aman dijalankan berkali-kali — migration yang sudah pernah jalan otomatis dilewati.')
                ->action(function () {
                    $this->migrateOutput = $this->runMigrations();

                    Notification::make()
                        ->title('Migration selesai')
                        ->success()
                        ->send();
                }),

            Action::make('seeder')
                ->label('Seeder')
                ->icon('heroicon-o-circle-stack')
                ->color('gray')
                ->schema([
                    TextInput::make('class')
                        ->label('Seeder Class (opsional)')
                        ->placeholder('Database\\Seeders\\PrestasiSiswaSeeder')
                        ->helperText('Kosongkan untuk jalankan DatabaseSeeder default (⚠️ bisa menambahkan ulang data sample lama). Isi nama class lengkap untuk jalankan seeder tertentu saja.'),
                ])
                ->requiresConfirmation()
                ->modalHeading('Jalankan Seeder')
                ->action(function (array $data) {
                    $this->seederOutput = $this->runSeeder($data['class'] ?: null);

                    Notification::make()
                        ->title('Seeder selesai')
                        ->success()
                        ->send();
                }),

            Action::make('setEnv')
                ->label('Set Env')
                ->icon('heroicon-o-key')
                ->color('gray')
                ->schema([
                    Textarea::make('lines')
                        ->label('Baris .env')
                        ->placeholder("GOOGLE_CALENDAR_API_KEY=xxxxx\nCONTOH_KEY_LAIN=nilainya")
                        ->rows(6)
                        ->required()
                        ->helperText('Satu baris satu variabel, format KEY=VALUE. Baris yang key-nya sudah ada di .env akan di-update, yang belum ada akan ditambahkan.'),
                ])
                ->action(function (array $data) {
                    $this->envOutput = $this->mergeEnvLines($data['lines']);

                    Notification::make()
                        ->title('Env berhasil disimpan')
                        ->success()
                        ->send();
                }),
        ];
    }

    private function runMigrations(): string
    {
        Artisan::call('migrate', ['--force' => true]);

        return Artisan::output();
    }

    private function runSeeder(?string $class): string
    {
        $params = ['--force' => true];
        if ($class) {
            $params['--class'] = $class;
        }

        try {
            Artisan::call('db:seed', $params);

            return Artisan::output();
        } catch (\Throwable $e) {
            return "✗ Gagal menjalankan seeder: " . $e->getMessage();
        }
    }

    private function runExtractBuild(): string
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

        return implode("\n", $log);
    }

    private function runClearAllCache(): string
    {
        $log = [];
        foreach (['config:clear', 'route:clear', 'view:clear', 'cache:clear'] as $command) {
            Artisan::call($command);
            $log[] = "✓ {$command}";
        }

        return implode("\n", $log);
    }

    private function mergeEnvLines(string $rawText): string
    {
        $envPath = base_path('.env');

        if (! file_exists($envPath) || ! is_writable($envPath)) {
            return "✗ File .env tidak ditemukan atau tidak bisa ditulis.";
        }

        $content = file_get_contents($envPath);
        $log = [];

        $lines = preg_split('/\r\n|\r|\n/', trim($rawText));

        foreach ($lines as $rawLine) {
            $rawLine = trim($rawLine);
            if ($rawLine === '' || ! str_contains($rawLine, '=')) {
                continue;
            }

            [$key, $value] = explode('=', $rawLine, 2);
            $key = trim($key);
            $value = trim($value);

            if (! preg_match('/^[A-Z0-9_]+$/', $key)) {
                $log[] = "✗ Lewati (key tidak valid): {$key}";
                continue;
            }

            $needsQuotes = preg_match('/\s|#/', $value) && ! (str_starts_with($value, '"') && str_ends_with($value, '"'));
            $formattedValue = $needsQuotes ? '"' . str_replace('"', '\"', $value) . '"' : $value;
            $line = "{$key}={$formattedValue}";

            $pattern = '/^' . preg_quote($key, '/') . '=.*$/m';

            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, $line, $content);
                $log[] = "✓ Update: {$key}";
            } else {
                $content = rtrim($content) . "\n{$line}\n";
                $log[] = "✓ Tambah: {$key}";
            }
        }

        File::put($envPath, $content);

        Artisan::call('config:clear');
        Artisan::call('config:cache');
        $log[] = "✓ config:clear & config:cache";

        return implode("\n", $log);
    }
}
