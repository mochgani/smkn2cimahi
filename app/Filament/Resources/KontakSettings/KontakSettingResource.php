<?php

namespace App\Filament\Resources\KontakSettings;

use App\Filament\Resources\KontakSettings\Pages\EditKontakSetting;
use App\Filament\Resources\KontakSettings\Schemas\KontakSettingForm;
use App\Models\KontakSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class KontakSettingResource extends Resource
{
    protected static ?string $model = KontakSetting::class;

    protected static ?string $slug = 'pengaturan/kontak';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhone;

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Pengaturan Kontak';

    protected static ?string $pluralModelLabel = 'Pengaturan Kontak';

    protected static ?string $navigationLabel = 'Halaman Kontak';

    public static function form(Schema $schema): Schema
    {
        return KontakSettingForm::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => EditKontakSetting::route('/'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->isSuperAdmin() ?? false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }
}
