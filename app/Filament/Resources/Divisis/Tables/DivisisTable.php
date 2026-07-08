<?php

namespace App\Filament\Resources\Divisis\Tables;

use App\Filament\Resources\Divisis\DivisiResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DivisisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('display_order')
                    ->label('#')
                    ->sortable()
                    ->width(50),

                TextColumn::make('name')
                    ->label('Nama Divisi')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->toggleable(),

                TextColumn::make('users_count')
                    ->label('Anggota')
                    ->counts('users')
                    ->badge(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->visible(fn ($record) => DivisiResource::canDelete($record)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()?->isSuperAdmin() ?? false),
                ]),
            ])
            ->defaultSort('display_order', 'asc')
            ->reorderable('display_order');
    }
}
