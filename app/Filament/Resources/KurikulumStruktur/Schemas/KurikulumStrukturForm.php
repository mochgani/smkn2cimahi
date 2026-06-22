<?php

namespace App\Filament\Resources\KurikulumStruktur\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KurikulumStrukturForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Informasi Halaman')
                ->schema([
                    TextInput::make('title')
                        ->label('Judul Halaman')
                        ->required()
                        ->maxLength(255),

                    Textarea::make('lead')
                        ->label('Lead / Deskripsi Singkat')
                        ->rows(3),
                ]),

            Section::make('Fase Kurikulum')
                ->description('Kartu dua fase: Fase E (Kelas X) dan Fase F (Kelas XI & XII).')
                ->schema([
                    Repeater::make('phases')
                        ->label('')
                        ->schema([
                            TextInput::make('step')
                                ->label('Label Fase (E / F)')
                                ->required()
                                ->maxLength(5)
                                ->columnSpan(1),

                            TextInput::make('kelas')
                                ->label('Tingkat Kelas')
                                ->required()
                                ->placeholder('Kelas X')
                                ->columnSpan(2),

                            TextInput::make('title')
                                ->label('Judul Fase')
                                ->required()
                                ->placeholder('Fase E')
                                ->columnSpan(3),

                            Textarea::make('desc')
                                ->label('Deskripsi')
                                ->rows(3)
                                ->columnSpan(3),
                        ])
                        ->columns(3)
                        ->reorderable()
                        ->addActionLabel('Tambah Fase')
                        ->maxItems(3),
                ]),

            Section::make('Kelompok Mata Pelajaran')
                ->description('Tiga kelompok mata pelajaran dalam kurikulum.')
                ->schema([
                    Repeater::make('groups')
                        ->label('')
                        ->schema([
                            TextInput::make('title')
                                ->label('Nama Kelompok')
                                ->required()
                                ->columnSpan(2),

                            Textarea::make('desc')
                                ->label('Deskripsi')
                                ->rows(2)
                                ->columnSpan(4),
                        ])
                        ->columns(6)
                        ->reorderable()
                        ->addActionLabel('Tambah Kelompok')
                        ->maxItems(5),
                ]),

            Section::make('Tabel Alokasi Jam')
                ->description('Baris tabel: Kelompok, Contoh Mata Pelajaran, dan Alokasi Jam.')
                ->schema([
                    Repeater::make('allocation')
                        ->label('')
                        ->schema([
                            TextInput::make('kelompok')
                                ->label('Kelompok')
                                ->required()
                                ->columnSpan(1),

                            TextInput::make('mata_pelajaran')
                                ->label('Contoh Mata Pelajaran')
                                ->placeholder('Matematika, Bahasa Indonesia, ...')
                                ->columnSpan(2),

                            TextInput::make('alokasi')
                                ->label('Alokasi Jam')
                                ->placeholder('36 JP / Semester')
                                ->columnSpan(1),
                        ])
                        ->columns(4)
                        ->reorderable()
                        ->addActionLabel('Tambah Baris'),
                ]),

        ]);
    }
}
