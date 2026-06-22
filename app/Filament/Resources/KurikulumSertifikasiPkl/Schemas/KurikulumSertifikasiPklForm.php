<?php

namespace App\Filament\Resources\KurikulumSertifikasiPkl\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KurikulumSertifikasiPklForm
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
                        ->rows(3),
                ]),

            Section::make('Sertifikasi Kompetensi')
                ->schema([
                    Repeater::make('sertifikasi')
                        ->label('Daftar Sertifikasi')
                        ->schema([
                            TextInput::make('nama')->label('Nama Sertifikasi')->required(),
                            TextInput::make('lembaga')->label('Lembaga Penerbit')->required(),
                            TextInput::make('kompetensi')->label('Program Keahlian')->required(),
                            Textarea::make('deskripsi')->label('Deskripsi')->rows(3),
                        ])
                        ->addActionLabel('Tambah Sertifikasi')
                        ->collapsible(),
                ]),

            Section::make('Praktik Kerja Lapangan (PKL)')
                ->columns(2)
                ->schema([
                    TextInput::make('pkl_durasi')
                        ->label('Durasi PKL')
                        ->placeholder('6 bulan')
                        ->maxLength(50),

                    TextInput::make('pkl_min_nilai')
                        ->label('Nilai Minimum Kelulusan')
                        ->placeholder('75')
                        ->maxLength(10),

                    Textarea::make('pkl_deskripsi')
                        ->label('Deskripsi PKL')
                        ->rows(4)
                        ->columnSpanFull(),
                ]),

            Section::make('Alur PKL')
                ->schema([
                    Repeater::make('alur_pkl')
                        ->label('Tahapan PKL')
                        ->schema([
                            TextInput::make('step')->label('No. Langkah')->required()->placeholder('01'),
                            TextInput::make('judul')->label('Judul Tahap')->required(),
                            Textarea::make('deskripsi')->label('Deskripsi')->rows(3),
                        ])
                        ->addActionLabel('Tambah Tahap')
                        ->collapsible(),
                ]),
        ]);
    }
}
