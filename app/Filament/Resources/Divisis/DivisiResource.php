<?php

namespace App\Filament\Resources\Divisis;

use App\Filament\Resources\Divisis\Pages\CreateDivisi;
use App\Filament\Resources\Divisis\Pages\EditDivisi;
use App\Filament\Resources\Divisis\Pages\ListDivisis;
use App\Filament\Resources\Divisis\Schemas\DivisiForm;
use App\Filament\Resources\Divisis\Tables\DivisisTable;
use App\Models\Divisi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class DivisiResource extends Resource
{
    protected static ?string $model = Divisi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string|UnitEnum|null $navigationGroup = 'Struktur';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Divisi';

    protected static ?string $pluralModelLabel = 'Divisi';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return DivisiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DivisisTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDivisis::route('/'),
            'create' => CreateDivisi::route('/create'),
            'edit' => EditDivisi::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user?->isSuperAdmin() || $user?->hasRole('divisi');
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

        if ($user->hasRole('divisi') && $user->divisi_id) {
            return $query->where('id', $user->divisi_id);
        }

        return $query->whereRaw('1 = 0');
    }
}
