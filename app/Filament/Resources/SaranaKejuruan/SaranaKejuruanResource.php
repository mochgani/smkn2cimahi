<?php

namespace App\Filament\Resources\SaranaKejuruan;

use App\Filament\Resources\SaranaKejuruan\Pages\EditSaranaKejuruan;
use App\Filament\Resources\SaranaKejuruan\Schemas\SaranaKejuruanForm;
use App\Models\SaranaKejuruan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SaranaKejuruanResource extends Resource
{
    protected static ?string $model = SaranaKejuruan::class;

    protected static ?string $slug = 'sarana/kejuruan';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static string|UnitEnum|null $navigationGroup = 'Sarana Prasarana';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Kejuruan';

    protected static ?string $modelLabel = 'Sarana Kejuruan';

    public static function form(Schema $schema): Schema
    {
        return SaranaKejuruanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => EditSaranaKejuruan::route('/'),
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
