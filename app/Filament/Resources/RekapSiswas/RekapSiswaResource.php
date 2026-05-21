<?php

namespace App\Filament\Resources\RekapSiswas;

use App\Filament\Resources\RekapSiswas\Pages\CreateRekapSiswa;
use App\Filament\Resources\RekapSiswas\Pages\EditRekapSiswa;
use App\Filament\Resources\RekapSiswas\Pages\ListRekapSiswas;
use App\Filament\Resources\RekapSiswas\Schemas\RekapSiswaForm;
use App\Filament\Resources\RekapSiswas\Tables\RekapSiswasTable;
use App\Models\RekapSiswa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RekapSiswaResource extends Resource
{
    protected static ?string $model = RekapSiswa::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTableCells;

    protected static string|UnitEnum|null $navigationGroup = 'Kesiswaan';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Rekap Siswa';

    protected static ?string $pluralModelLabel = 'Rekap Siswa';

    protected static ?string $recordTitleAttribute = 'kelas';

    public static function form(Schema $schema): Schema
    {
        return RekapSiswaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RekapSiswasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListRekapSiswas::route('/'),
            'create' => CreateRekapSiswa::route('/create'),
            'edit'   => EditRekapSiswa::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->isSuperAdmin() ?? false;
    }
}
