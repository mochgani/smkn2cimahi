<?php

namespace App\Filament\Resources\ProfilUnggulans;

use App\Filament\Resources\ProfilUnggulans\Pages\CreateProfilUnggulan;
use App\Filament\Resources\ProfilUnggulans\Pages\EditProfilUnggulan;
use App\Filament\Resources\ProfilUnggulans\Pages\ListProfilUnggulans;
use App\Filament\Resources\ProfilUnggulans\Schemas\ProfilUnggulanForm;
use App\Filament\Resources\ProfilUnggulans\Tables\ProfilUnggulansTable;
use App\Models\ProfilUnggulan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ProfilUnggulanResource extends Resource
{
    protected static ?string $model = ProfilUnggulan::class;

    protected static ?string $slug = 'profil/unggulan';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;

    protected static string|UnitEnum|null $navigationGroup = 'Profil Sekolah';

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'Program Unggulan';

    protected static ?string $pluralModelLabel = 'Program Unggulan';

    protected static ?string $navigationLabel = 'Program Unggulan';

    public static function form(Schema $schema): Schema
    {
        return ProfilUnggulanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProfilUnggulansTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListProfilUnggulans::route('/'),
            'create' => CreateProfilUnggulan::route('/create'),
            'edit'   => EditProfilUnggulan::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->isSuperAdmin() ?? false;
    }
}
