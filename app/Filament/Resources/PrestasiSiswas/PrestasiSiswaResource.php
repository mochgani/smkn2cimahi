<?php

namespace App\Filament\Resources\PrestasiSiswas;

use App\Filament\Resources\PrestasiSiswas\Pages\CreatePrestasiSiswa;
use App\Filament\Resources\PrestasiSiswas\Pages\EditPrestasiSiswa;
use App\Filament\Resources\PrestasiSiswas\Pages\ListPrestasiSiswas;
use App\Filament\Resources\PrestasiSiswas\Schemas\PrestasiSiswaForm;
use App\Filament\Resources\PrestasiSiswas\Tables\PrestasiSiswasTable;
use App\Models\PrestasiSiswa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PrestasiSiswaResource extends Resource
{
    protected static ?string $model = PrestasiSiswa::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTrophy;

    protected static ?string $navigationLabel = 'Prestasi Siswa';

    protected static ?string $modelLabel = 'Prestasi Siswa';

    protected static ?string $pluralModelLabel = 'Prestasi Siswa';

    protected static ?string $recordTitleAttribute = 'judul_kegiatan';

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return PrestasiSiswaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PrestasiSiswasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPrestasiSiswas::route('/'),
            'create' => CreatePrestasiSiswa::route('/create'),
            'edit'   => EditPrestasiSiswa::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool { return auth()->user()?->isSuperAdmin() ?? false; }
}
