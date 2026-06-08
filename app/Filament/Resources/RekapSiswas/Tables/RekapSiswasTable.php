<?php

namespace App\Filament\Resources\RekapSiswas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RekapSiswasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kompetensi.name')
                    ->label('Kompetensi')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('kelas')
                    ->label('Kelas')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'X'   => 'success',
                        'XI'  => 'warning',
                        'XII' => 'danger',
                    })
                    ->sortable(),

                TextColumn::make('rombel')
                    ->label('Rombel')
                    ->alignRight()
                    ->sortable(),

                TextColumn::make('laki_laki')
                    ->label('L')
                    ->alignRight()
                    ->sortable(),

                TextColumn::make('perempuan')
                    ->label('P')
                    ->alignRight()
                    ->sortable(),

                TextColumn::make('total')
                    ->label('Total')
                    ->getStateUsing(fn ($record) => $record->laki_laki + $record->perempuan)
                    ->alignRight()
                    ->weight('bold'),
            ])
            ->filters([
                SelectFilter::make('kelas')
                    ->label('Kelas')
                    ->options([
                        'X'   => 'Kelas X',
                        'XI'  => 'Kelas XI',
                        'XII' => 'Kelas XII',
                    ]),

                SelectFilter::make('kompetensi_id')
                    ->label('Kompetensi')
                    ->relationship('kompetensi', 'name')
                    ->preload(),
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
            ->defaultSort('kompetensi_id')
            ->paginated(false);
    }
}
