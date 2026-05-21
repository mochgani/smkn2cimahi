<?php

namespace App\Filament\Resources\Pesans\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PesansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('is_read')
                    ->label('Dibaca')
                    ->boolean()
                    ->trueIcon('heroicon-o-check')
                    ->falseIcon('heroicon-o-bell')
                    ->trueColor('gray')
                    ->falseColor('warning'),

                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->weight(fn ($record) => $record->is_read ? 'normal' : 'bold'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('topik')
                    ->label('Topik')
                    ->badge(),

                TextColumn::make('pesan')
                    ->label('Pesan')
                    ->limit(80)
                    ->wrap(),

                IconColumn::make('is_replied')
                    ->label('Dibalas')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Diterima')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_read')->label('Status Baca'),
                TernaryFilter::make('is_replied')->label('Status Balas'),
                SelectFilter::make('topik')->options([
                    'ppdb' => 'Penerimaan Murid Baru (SPMB)',
                    'bkk' => 'Kerja Sama Industri / BKK',
                    'kemitraan' => 'Kemitraan IDUKA',
                    'alumni' => 'Informasi Alumni',
                    'kunjungan' => 'Kunjungan Sekolah',
                    'lain' => 'Lainnya',
                ]),
            ])
            ->recordActions([
                Action::make('mark_read')
                    ->label('Tandai Dibaca')
                    ->icon('heroicon-o-eye')
                    ->color('warning')
                    ->visible(fn ($record) => ! $record->is_read)
                    ->action(fn ($record) => $record->update(['is_read' => true])),
                EditAction::make()->label('Buka'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
