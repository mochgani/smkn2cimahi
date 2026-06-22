<?php

namespace App\Filament\Resources\MenuItems\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MenuItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label')
                    ->label('Label')
                    ->searchable()
                    ->formatStateUsing(function ($state, $record) {
                        if (!$record->parent_id) return '▸ ' . $state;
                        if ($record->parent?->parent_id) return '  ↳↳ ' . $state;
                        return '↳ ' . $state;
                    })
                    ->weight(fn ($record) => $record->parent_id ? null : 'bold'),

                TextColumn::make('location')
                    ->label('Lokasi')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'topbar' => 'Topbar',
                        default  => 'Navbar',
                    })
                    ->color(fn (?string $state) => $state === 'topbar' ? 'warning' : 'info'),

                TextColumn::make('parent.label')
                    ->label('Parent')
                    ->placeholder('—')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('url')
                    ->label('URL')
                    ->limit(35)
                    ->color('gray')
                    ->fontFamily('mono'),

                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'kompetensi_list' => 'Auto',
                        default           => 'Statis',
                    })
                    ->color(fn (string $state) => $state === 'kompetensi_list' ? 'warning' : 'gray'),

                IconColumn::make('is_mega_menu')
                    ->label('Mega')
                    ->boolean(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('location')
                    ->label('Lokasi')
                    ->options([
                        'navbar' => 'Navbar',
                        'topbar' => 'Topbar',
                    ])
                    ->placeholder('Semua'),
                SelectFilter::make('parent_id')
                    ->label('Filter Parent')
                    ->relationship('parent', 'label')
                    ->placeholder('Semua')
                    ->preload(),
                TernaryFilter::make('is_active')->label('Status Aktif'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->leftJoin('menu_items as p', 'menu_items.parent_id', '=', 'p.id')
                ->select('menu_items.*')
                ->orderByRaw('COALESCE(p.display_order, menu_items.display_order)')
                ->orderByRaw('CASE WHEN menu_items.parent_id IS NULL THEN 0 ELSE 1 END')
                ->orderBy('menu_items.display_order')
            )
            ->reorderable('display_order');
    }
}
