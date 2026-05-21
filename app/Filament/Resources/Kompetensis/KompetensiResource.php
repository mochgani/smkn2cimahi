<?php

namespace App\Filament\Resources\Kompetensis;

use App\Filament\Resources\Kompetensis\Pages\CreateKompetensi;
use App\Filament\Resources\Kompetensis\Pages\EditKompetensi;
use App\Filament\Resources\Kompetensis\Pages\ListKompetensis;
use App\Filament\Resources\Kompetensis\Schemas\KompetensiForm;
use App\Filament\Resources\Kompetensis\Tables\KompetensisTable;
use App\Models\Kompetensi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class KompetensiResource extends Resource
{
    protected static ?string $model = Kompetensi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Kompetensi Keahlian';

    protected static ?string $pluralModelLabel = 'Kompetensi Keahlian';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return KompetensiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KompetensisTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKompetensis::route('/'),
            'create' => CreateKompetensi::route('/create'),
            'edit' => EditKompetensi::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user?->isSuperAdmin() || $user?->hasRole('kompetensi');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->isSuperAdmin() ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->isSuperAdmin() ?? false;
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if (! $user || $user->isSuperAdmin()) {
            return $query;
        }

        if ($user->hasRole('kompetensi') && $user->kompetensi_id) {
            return $query->where('id', $user->kompetensi_id);
        }

        return $query->whereRaw('1 = 0');
    }
}
