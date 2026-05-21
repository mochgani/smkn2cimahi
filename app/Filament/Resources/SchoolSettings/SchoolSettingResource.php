<?php

namespace App\Filament\Resources\SchoolSettings;

use App\Filament\Resources\SchoolSettings\Pages\EditSchoolSetting;
use App\Filament\Resources\SchoolSettings\Schemas\SchoolSettingForm;
use App\Models\SchoolSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class SchoolSettingResource extends Resource
{
    protected static ?string $model = SchoolSetting::class;

    protected static ?string $slug = 'pengaturan/sekolah';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static ?int $navigationSort = 0;

    protected static ?string $modelLabel = 'Pengaturan Sekolah';

    protected static ?string $pluralModelLabel = 'Pengaturan Sekolah';

    protected static ?string $navigationLabel = 'Identitas Sekolah';

    public static function form(Schema $schema): Schema
    {
        return SchoolSettingForm::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => EditSchoolSetting::route('/'),
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
