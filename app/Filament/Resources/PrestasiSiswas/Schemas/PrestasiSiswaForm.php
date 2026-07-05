<?php

namespace App\Filament\Resources\PrestasiSiswas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PrestasiSiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Data Prestasi')
                ->columns(2)
                ->schema([
                    TextInput::make('nama_siswa')
                        ->label('Nama Siswa')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    TextInput::make('judul_kegiatan')
                        ->label('Judul Kegiatan / Lomba')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    TextInput::make('bulan_tahun')
                        ->label('Bulan & Tahun')
                        ->placeholder('Juli 2025')
                        ->maxLength(50),

                    TextInput::make('lokasi')
                        ->label('Lokasi')
                        ->maxLength(255),

                    TextInput::make('peringkat')
                        ->label('Peringkat / Penghargaan')
                        ->placeholder('Juara 1')
                        ->maxLength(100),

                    Select::make('tingkat')
                        ->label('Tingkat')
                        ->options([
                            'Nasional' => 'Nasional',
                            'Provinsi' => 'Provinsi',
                            'Kota'     => 'Kota',
                        ])
                        ->required()
                        ->default('Kota'),

                    TextInput::make('tahun_ajaran')
                        ->label('Tahun Ajaran')
                        ->placeholder('2024-2025')
                        ->required()
                        ->maxLength(20),

                    TextInput::make('display_order')
                        ->label('Urutan Tampil')
                        ->numeric()
                        ->default(0),

                    Toggle::make('is_active')
                        ->label('Tampilkan di website')
                        ->default(true),
                ]),
        ]);
    }
}
