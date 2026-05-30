<?php

namespace App\Filament\Resources\ProfilUnggulans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProfilUnggulansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('num')
                    ->label('No')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('tag')
                    ->label('Kategori')
                    ->badge(),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->limit(60),

                TextColumn::make('display_order')
                    ->label('Urutan')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
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
            ->reorderable('display_order')
            ->defaultSort('display_order');
    }
}
