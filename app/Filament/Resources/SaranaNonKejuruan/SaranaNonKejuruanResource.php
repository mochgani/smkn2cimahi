<?php

namespace App\Filament\Resources\SaranaNonKejuruan;

use App\Filament\Resources\SaranaNonKejuruan\Pages\EditSaranaNonKejuruan;
use App\Filament\Resources\SaranaNonKejuruan\Schemas\SaranaNonKejuruanForm;
use App\Models\SaranaNonKejuruan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SaranaNonKejuruanResource extends Resource
{
    protected static ?string $model = SaranaNonKejuruan::class;

    protected static ?string $slug = 'sarana/non-kejuruan';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static string|UnitEnum|null $navigationGroup = 'Sarana Prasarana';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Non Kejuruan';

    protected static ?string $modelLabel = 'Sarana Non Kejuruan';

    public static function form(Schema $schema): Schema
    {
        return SaranaNonKejuruanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => EditSaranaNonKejuruan::route('/'),
        ];
    }

    public static function canViewAny(): bool
    {
        return (auth()->user()?->isSuperAdmin() ?? false) || (auth()->user()?->isDivisi('sarana-prasarana') ?? false);
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
