<?php

namespace App\Filament\Resources\ProfilKepalaSekolah;

use App\Filament\Resources\ProfilKepalaSekolah\Pages\EditProfilKepalaSekolah;
use App\Filament\Resources\ProfilKepalaSekolah\Schemas\ProfilKepalaSekolahForm;
use App\Models\ProfilKepalaSekolah;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ProfilKepalaSekolahResource extends Resource
{
    protected static ?string $model = ProfilKepalaSekolah::class;

    protected static ?string $slug = 'profil/kepala-sekolah';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static string|UnitEnum|null $navigationGroup = 'Profil Sekolah';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Kepala Sekolah';

    protected static ?string $pluralModelLabel = 'Kepala Sekolah';

    protected static ?string $navigationLabel = 'Kepala Sekolah';

    public static function form(Schema $schema): Schema
    {
        return ProfilKepalaSekolahForm::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => EditProfilKepalaSekolah::route('/'),
        ];
    }

    public static function canViewAny(): bool
    {
        return (auth()->user()?->isSuperAdmin() ?? false) || (auth()->user()?->isKepalaSekolah() ?? false);
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
