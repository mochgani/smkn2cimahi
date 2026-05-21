<?php

namespace App\Filament\Resources\HeroBanners\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HeroBannersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('display_order')
                    ->label('#')
                    ->sortable()
                    ->width(50),

                ImageColumn::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->square()
                    ->size(50)
                    ->defaultImageUrl(null),

                TextColumn::make('tag')
                    ->label('Tag')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'PRESTASI'   => 'success',
                        'PENGUMUMAN' => 'warning',
                        'KEGIATAN'   => 'info',
                        'PENERIMAAN' => 'danger',
                        default      => 'gray',
                    }),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->limit(55)
                    ->wrap(),

                TextColumn::make('date_display')
                    ->label('Tanggal')
                    ->sortable(),

                TextColumn::make('badge')
                    ->label('Badge')
                    ->limit(30),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),
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
            ->defaultSort('display_order', 'asc')
            ->reorderable('display_order');
    }
}
