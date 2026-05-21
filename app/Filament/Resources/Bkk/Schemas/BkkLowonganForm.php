<?php

namespace App\Filament\Resources\Bkk\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BkkLowonganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Detail Lowongan')
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->label('Judul Lowongan')
                        ->required()
                        ->columnSpanFull()
                        ->placeholder('PT Nama Perusahaan — Posisi yang Dibutuhkan'),

                    TextInput::make('company')
                        ->label('Nama Perusahaan')
                        ->placeholder('PT Nama Perusahaan'),

                    TextInput::make('category')
                        ->label('Kategori')
                        ->placeholder('Lowongan / Magang / dll'),

                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'AKTIF'  => 'Aktif',
                            'TUTUP'  => 'Tutup',
                            'SEGERA' => 'Segera Dibuka',
                        ])
                        ->default('AKTIF')
                        ->required(),

                    TextInput::make('link')
                        ->label('Link Detail / Formulir')
                        ->url()
                        ->placeholder('https://...')
                        ->helperText('Opsional — link pendaftaran atau info lebih lanjut'),

                    TextInput::make('display_order')
                        ->label('Urutan Tampil')
                        ->numeric()
                        ->default(0),

                    Toggle::make('is_active')
                        ->label('Tampilkan di Website')
                        ->default(true)
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
