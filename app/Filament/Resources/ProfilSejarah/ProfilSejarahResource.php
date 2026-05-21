<?php

namespace App\Filament\Resources\ProfilSejarah;

use App\Filament\Resources\ProfilSejarah\Pages\EditProfilSejarah;
use App\Filament\Resources\ProfilSejarah\Schemas\ProfilSejarahForm;
use App\Models\ProfilSejarah;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ProfilSejarahResource extends Resource
{
    protected static ?string $model = ProfilSejarah::class;

    protected static ?string $slug = 'profil/sejarah';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static string|UnitEnum|null $navigationGroup = 'Profil Sekolah';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Sejarah';

    protected static ?string $pluralModelLabel = 'Sejarah';

    protected static ?string $navigationLabel = 'Sejarah';

    public static function form(Schema $schema): Schema
    {
        return ProfilSejarahForm::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => EditProfilSejarah::route('/'),
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
