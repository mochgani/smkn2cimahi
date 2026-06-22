<?php

namespace App\Filament\Resources\KurikulumKalender;

use App\Filament\Resources\KurikulumKalender\Pages\EditKurikulumKalender;
use App\Filament\Resources\KurikulumKalender\Schemas\KurikulumKalenderForm;
use App\Models\KurikulumKalender as KurikulumKalenderModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class KurikulumKalenderResource extends Resource
{
    protected static ?string $model = KurikulumKalenderModel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|UnitEnum|null $navigationGroup = 'Kurikulum';

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationLabel = 'Kalender Akademik';

    protected static ?string $modelLabel = 'Kalender Akademik';

    protected static ?string $pluralModelLabel = 'Kalender Akademik';

    protected static ?string $slug = 'kurikulum/kalender';

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return KurikulumKalenderForm::configure($schema);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return $table->columns([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => EditKurikulumKalender::route('/'),
        ];
    }

    public static function canViewAny(): bool { return auth()->user()?->isSuperAdmin() ?? false; }
}
