<?php

namespace App\Filament\Resources\SaranaNonKejuruan\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SaranaNonKejuruanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Informasi Utama')
                ->schema([
                    TextInput::make('title')
                        ->label('Judul Halaman')
                        ->required()
                        ->maxLength(255),

                    Textarea::make('lead')
                        ->label('Lead / Deskripsi Singkat')
                        ->rows(3)
                        ->maxLength(500),
                ]),

            Section::make('Gedung & Ruang Kelas')
                ->description('Daftar gedung beserta rincian lantai/ruangannya.')
                ->schema([
                    Repeater::make('gedung')
                        ->label('')
                        ->schema([
                            TextInput::make('nama')
                                ->label('Nama Gedung')
                                ->required()
                                ->columnSpanFull(),

                            Repeater::make('lantai')
                                ->label('Rincian Lantai / Ruang')
                                ->schema([
                                    TextInput::make('nama')
                                        ->label('Label Lantai (opsional)')
                                        ->placeholder('Lantai 1'),

                                    TextInput::make('keterangan')
                                        ->label('Keterangan')
                                        ->required()
                                        ->placeholder('4 Ruang Kelas'),
                                ])
                                ->columns(2)
                                ->reorderable()
                                ->addActionLabel('Tambah Baris')
                                ->columnSpanFull(),

                            TextInput::make('fasilitas')
                                ->label('Fasilitas (opsional)')
                                ->placeholder('Internet, CCTV')
                                ->columnSpanFull(),
                        ])
                        ->columns(1)
                        ->reorderable()
                        ->addActionLabel('Tambah Gedung')
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => $state['nama'] ?? null),
                ]),

        ]);
    }
}
