<?php

namespace App\Filament\Resources\KurikulumSertifikasiPkl;

use App\Filament\Resources\KurikulumSertifikasiPkl\Pages\EditKurikulumSertifikasiPkl;
use App\Filament\Resources\KurikulumSertifikasiPkl\Schemas\KurikulumSertifikasiPklForm;
use App\Models\KurikulumSertifikasiPkl as KurikulumSertifikasiPklModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class KurikulumSertifikasiPklResource extends Resource
{
    protected static ?string $model = KurikulumSertifikasiPklModel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static string|UnitEnum|null $navigationGroup = 'Kurikulum';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationLabel = 'Sertifikasi & PKL';

    protected static ?string $modelLabel = 'Sertifikasi & PKL';

    protected static ?string $pluralModelLabel = 'Sertifikasi & PKL';

    protected static ?string $slug = 'kurikulum/sertifikasi-pkl';

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return KurikulumSertifikasiPklForm::configure($schema);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return $table->columns([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => EditKurikulumSertifikasiPkl::route('/'),
        ];
    }

    public static function canViewAny(): bool { return (auth()->user()?->isSuperAdmin() ?? false) || (auth()->user()?->isDivisi('kurikulum') ?? false); }
}
