<?php

namespace App\Filament\Resources\PrestasiSiswas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PrestasiSiswasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_siswa')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('judul_kegiatan')
                    ->label('Kegiatan')
                    ->searchable()
                    ->limit(40),

                TextColumn::make('tingkat')
                    ->label('Tingkat')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'Nasional' => 'success',
                        'Provinsi' => 'warning',
                        default    => 'gray',
                    }),

                TextColumn::make('peringkat')
                    ->label('Peringkat'),

                TextColumn::make('bulan_tahun')
                    ->label('Waktu'),

                TextColumn::make('tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->defaultSort('tahun_ajaran', 'desc')
            ->filters([
                SelectFilter::make('tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->options(fn () => \App\Models\PrestasiSiswa::query()
                        ->distinct()
                        ->orderBy('tahun_ajaran', 'desc')
                        ->pluck('tahun_ajaran', 'tahun_ajaran')
                        ->all()),
                SelectFilter::make('tingkat')
                    ->label('Tingkat')
                    ->options([
                        'Nasional' => 'Nasional',
                        'Provinsi' => 'Provinsi',
                        'Kota'     => 'Kota',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
