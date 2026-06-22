<?php

namespace App\Filament\Resources\KurikulumMitras;

use App\Filament\Resources\KurikulumMitras\Pages\CreateKurikulumMitra;
use App\Filament\Resources\KurikulumMitras\Pages\EditKurikulumMitra;
use App\Filament\Resources\KurikulumMitras\Pages\ListKurikulumMitras;
use App\Filament\Resources\KurikulumMitras\Schemas\KurikulumMitraForm;
use App\Filament\Resources\KurikulumMitras\Tables\KurikulumMitrasTable;
use App\Models\KurikulumMitra;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KurikulumMitraResource extends Resource
{
    protected static ?string $model = KurikulumMitra::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string|UnitEnum|null $navigationGroup = 'Kurikulum';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Kelas Kerja Sama';

    protected static ?string $modelLabel = 'Mitra';

    protected static ?string $pluralModelLabel = 'Kelas Kerja Sama';

    protected static ?string $recordTitleAttribute = 'nama';

    protected static ?string $slug = 'kurikulum/kelas-kerja-sama';

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return KurikulumMitraForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KurikulumMitrasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListKurikulumMitras::route('/'),
            'create' => CreateKurikulumMitra::route('/create'),
            'edit'   => EditKurikulumMitra::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool { return auth()->user()?->isSuperAdmin() ?? false; }
}
