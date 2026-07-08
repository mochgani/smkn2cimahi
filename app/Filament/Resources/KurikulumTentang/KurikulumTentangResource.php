<?php

namespace App\Filament\Resources\KurikulumTentang;

use App\Filament\Resources\KurikulumTentang\Pages\EditKurikulumTentang;
use App\Filament\Resources\KurikulumTentang\Schemas\KurikulumTentangForm;
use App\Models\KurikulumTentang;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KurikulumTentangResource extends Resource
{
    protected static ?string $model = KurikulumTentang::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static string|UnitEnum|null $navigationGroup = 'Kurikulum';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Tentang Kurikulum';

    protected static ?string $modelLabel = 'Tentang Kurikulum';

    protected static ?string $slug = 'kurikulum/tentang';

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return KurikulumTentangForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => EditKurikulumTentang::route('/'),
        ];
    }

    public static function canViewAny(): bool { return (auth()->user()?->isSuperAdmin() ?? false) || (auth()->user()?->isDivisi('kurikulum') ?? false); }
    public static function canCreate(): bool  { return false; }
}
