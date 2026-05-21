<?php

namespace App\Filament\Resources\Pesans;

use App\Filament\Resources\Pesans\Pages\EditPesan;
use App\Filament\Resources\Pesans\Pages\ListPesans;
use App\Filament\Resources\Pesans\Schemas\PesanForm;
use App\Filament\Resources\Pesans\Tables\PesansTable;
use App\Models\Pesan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PesanResource extends Resource
{
    protected static ?string $model = Pesan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static string|UnitEnum|null $navigationGroup = 'Inbox';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Pesan Kontak';

    protected static ?string $pluralModelLabel = 'Pesan Kontak';

    protected static ?string $recordTitleAttribute = 'nama';

    public static function getNavigationBadge(): ?string
    {
        $count = Pesan::where('is_read', false)->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return PesanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PesansTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPesans::route('/'),
            'edit' => EditPesan::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->isSuperAdmin() ?? false;
    }
}
