<?php

namespace App\Filament\Resources\Bkk\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BkkLowongansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('display_order')
                    ->label('#')
                    ->sortable()
                    ->width(40),

                TextColumn::make('title')
                    ->label('Judul Lowongan')
                    ->searchable()
                    ->limit(60),

                TextColumn::make('company')
                    ->label('Perusahaan')
                    ->searchable(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'AKTIF'  => 'success',
                        'TUTUP'  => 'danger',
                        'SEGERA' => 'warning',
                        default  => 'gray',
                    }),

                IconColumn::make('is_active')
                    ->label('Tampil')
                    ->boolean(),
            ])
            ->defaultSort('display_order')
            ->reorderable('display_order')
            ->recordActions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
