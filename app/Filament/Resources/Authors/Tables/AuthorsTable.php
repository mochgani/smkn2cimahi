<?php

namespace App\Filament\Resources\Authors\Tables;

use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AuthorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('initials')
                    ->label('Inisial')
                    ->badge(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('beritas_count')
                    ->label('Berita')
                    ->counts('beritas')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->defaultSort('name');
    }
}
