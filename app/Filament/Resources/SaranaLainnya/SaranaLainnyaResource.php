<?php

namespace App\Filament\Resources\SaranaLainnya;

use App\Filament\Resources\SaranaLainnya\Pages\EditSaranaLainnya;
use App\Filament\Resources\SaranaLainnya\Schemas\SaranaLainnyaForm;
use App\Models\SaranaLainnya;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SaranaLainnyaResource extends Resource
{
    protected static ?string $model = SaranaLainnya::class;

    protected static ?string $slug = 'sarana/lainnya';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static string|UnitEnum|null $navigationGroup = 'Sarana Prasarana';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Lainnya';

    protected static ?string $modelLabel = 'Sarana Lainnya';

    public static function form(Schema $schema): Schema
    {
        return SaranaLainnyaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => EditSaranaLainnya::route('/'),
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
