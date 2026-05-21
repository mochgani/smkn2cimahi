<?php

namespace App\Filament\Resources\Kompetensis\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KompetensisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Kode')
                    ->badge()
                    ->color('success')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama Kompetensi')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tag')
                    ->label('Tag')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('display_order')
                    ->label('Urutan')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->defaultSort('display_order', 'asc')
            ->reorderable('display_order');
    }
}
