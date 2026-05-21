<?php

namespace App\Filament\Resources\Bkk;

use App\Filament\Resources\Bkk\Pages\CreateBkkLowongan;
use App\Filament\Resources\Bkk\Pages\EditBkkLowongan;
use App\Filament\Resources\Bkk\Pages\ListBkkLowongans;
use App\Filament\Resources\Bkk\Schemas\BkkLowonganForm;
use App\Filament\Resources\Bkk\Tables\BkkLowongansTable;
use App\Models\BkkLowongan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BkkLowonganResource extends Resource
{
    protected static ?string $model = BkkLowongan::class;

    protected static ?string $slug = 'bkk/lowongans';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static string|UnitEnum|null $navigationGroup = 'Hubungan Industri';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Lowongan BKK';

    protected static ?string $pluralModelLabel = 'Lowongan BKK';

    protected static ?string $navigationLabel = 'Lowongan BKK';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return BkkLowonganForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BkkLowongansTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListBkkLowongans::route('/'),
            'create' => CreateBkkLowongan::route('/create'),
            'edit'   => EditBkkLowongan::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        if (! $user) return false;
        if ($user->isSuperAdmin()) return true;

        return $user->hasRole('divisi') && $user->divisi?->slug === 'hubungan-industri';
    }
}
