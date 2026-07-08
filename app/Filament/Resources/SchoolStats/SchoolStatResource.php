<?php

namespace App\Filament\Resources\SchoolStats;

use App\Filament\Resources\SchoolStats\Pages\CreateSchoolStat;
use App\Filament\Resources\SchoolStats\Pages\EditSchoolStat;
use App\Filament\Resources\SchoolStats\Pages\ListSchoolStats;
use App\Filament\Resources\SchoolStats\Schemas\SchoolStatForm;
use App\Filament\Resources\SchoolStats\Tables\SchoolStatsTable;
use App\Models\SchoolStat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SchoolStatResource extends Resource
{
    protected static ?string $model = SchoolStat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|UnitEnum|null $navigationGroup = 'Kesiswaan';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Statistik Sekolah';

    protected static ?string $pluralModelLabel = 'Statistik Sekolah';

    protected static ?string $recordTitleAttribute = 'label';

    public static function form(Schema $schema): Schema
    {
        return SchoolStatForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SchoolStatsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListSchoolStats::route('/'),
            'create' => CreateSchoolStat::route('/create'),
            'edit'   => EditSchoolStat::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return (auth()->user()?->isSuperAdmin() ?? false) || (auth()->user()?->isDivisi('kesiswaan') ?? false);
    }
}
