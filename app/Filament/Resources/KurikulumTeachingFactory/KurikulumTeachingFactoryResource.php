<?php

namespace App\Filament\Resources\KurikulumTeachingFactory;

use App\Filament\Resources\KurikulumTeachingFactory\Pages\EditKurikulumTeachingFactory;
use App\Filament\Resources\KurikulumTeachingFactory\Schemas\KurikulumTeachingFactoryForm;
use App\Models\KurikulumTeachingFactory as KurikulumTeachingFactoryModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class KurikulumTeachingFactoryResource extends Resource
{
    protected static ?string $model = KurikulumTeachingFactoryModel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static string|UnitEnum|null $navigationGroup = 'Kurikulum';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Teaching Factory';

    protected static ?string $modelLabel = 'Teaching Factory';

    protected static ?string $pluralModelLabel = 'Teaching Factory';

    protected static ?string $slug = 'kurikulum/teaching-factory';

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return KurikulumTeachingFactoryForm::configure($schema);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return $table->columns([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => EditKurikulumTeachingFactory::route('/'),
        ];
    }

    public static function canViewAny(): bool { return auth()->user()?->isSuperAdmin() ?? false; }
}
