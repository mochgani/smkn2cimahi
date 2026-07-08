<?php

namespace App\Filament\Resources\KurikulumStruktur;

use App\Filament\Resources\KurikulumStruktur\Pages\EditKurikulumStruktur;
use App\Filament\Resources\KurikulumStruktur\Schemas\KurikulumStrukturForm;
use App\Models\KurikulumStruktur;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KurikulumStrukturResource extends Resource
{
    protected static ?string $model = KurikulumStruktur::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTableCells;

    protected static string|UnitEnum|null $navigationGroup = 'Kurikulum';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Struktur Kurikulum';

    protected static ?string $modelLabel = 'Struktur Kurikulum';

    protected static ?string $slug = 'kurikulum/struktur';

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return KurikulumStrukturForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => EditKurikulumStruktur::route('/'),
        ];
    }

    public static function canViewAny(): bool { return (auth()->user()?->isSuperAdmin() ?? false) || (auth()->user()?->isDivisi('kurikulum') ?? false); }
    public static function canCreate(): bool  { return false; }
}
