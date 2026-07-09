<?php

namespace App\Filament\Resources\SaranaLainnya\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SaranaLainnyaForm
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

            Section::make('Fasilitas Penunjang')
                ->description('Daftar ruang/area pendukung kegiatan sekolah lainnya.')
                ->schema([
                    Repeater::make('items')
                        ->label('')
                        ->schema([
                            TextInput::make('nama')
                                ->label('Nama Fasilitas')
                                ->required()
                                ->columnSpanFull(),

                            Repeater::make('detail')
                                ->label('Rincian Ruang (opsional)')
                                ->schema([
                                    TextInput::make('nama')
                                        ->label('Nama Ruang')
                                        ->required(),

                                    TextInput::make('lantai')
                                        ->label('Lantai (opsional)')
                                        ->placeholder('Lt. 2'),
                                ])
                                ->columns(2)
                                ->reorderable()
                                ->addActionLabel('Tambah Ruang')
                                ->columnSpanFull(),

                            TextInput::make('catatan')
                                ->label('Catatan / Fasilitas (opsional)')
                                ->placeholder('AC, Internet, PC')
                                ->columnSpanFull(),
                        ])
                        ->columns(1)
                        ->reorderable()
                        ->addActionLabel('Tambah Fasilitas')
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => $state['nama'] ?? null),
                ]),

        ]);
    }
}
