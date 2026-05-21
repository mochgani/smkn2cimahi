<?php

namespace App\Filament\Resources\Bkk;

use App\Filament\Resources\Bkk\Pages\EditBkkSetting;
use App\Filament\Resources\Bkk\Schemas\BkkSettingForm;
use App\Models\BkkSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class BkkSettingResource extends Resource
{
    protected static ?string $model = BkkSetting::class;

    protected static ?string $slug = 'bkk/pengaturan';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string|UnitEnum|null $navigationGroup = 'Hubungan Industri';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Pengaturan BKK';

    protected static ?string $pluralModelLabel = 'Pengaturan BKK';

    protected static ?string $navigationLabel = 'Pengaturan BKK';

    public static function form(Schema $schema): Schema
    {
        return BkkSettingForm::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => EditBkkSetting::route('/'),
        ];
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        if (! $user) return false;
        if ($user->isSuperAdmin()) return true;

        return $user->hasRole('divisi') && $user->divisi?->slug === 'hubungan-industri';
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
