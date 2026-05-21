<?php

namespace App\Filament\Resources\ProfilVisiMisi;

use App\Filament\Resources\ProfilVisiMisi\Pages\EditProfilVisiMisi;
use App\Filament\Resources\ProfilVisiMisi\Schemas\ProfilVisiMisiForm;
use App\Models\ProfilVisiMisi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ProfilVisiMisiResource extends Resource
{
    protected static ?string $model = ProfilVisiMisi::class;

    protected static ?string $slug = 'profil/visi-misi';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static string|UnitEnum|null $navigationGroup = 'Profil Sekolah';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Visi & Misi';

    protected static ?string $pluralModelLabel = 'Visi & Misi';

    protected static ?string $navigationLabel = 'Visi & Misi';

    public static function form(Schema $schema): Schema
    {
        return ProfilVisiMisiForm::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => EditProfilVisiMisi::route('/'),
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
