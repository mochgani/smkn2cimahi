<?php

namespace App\Filament\Resources\KurikulumTentang\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KurikulumTentangForm
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

            Section::make('Profil Kurikulum')
                ->description('Data yang tampil di kartu ringkasan kanan hero.')
                ->columns(2)
                ->schema([
                    TextInput::make('kurikulum_nama')
                        ->label('Nama Kurikulum')
                        ->default('Merdeka'),

                    TextInput::make('pendekatan')
                        ->label('Pendekatan')
                        ->default('Link & Match'),

                    TextInput::make('porsi_praktik')
                        ->label('Porsi Praktik')
                        ->default('70%'),

                    TextInput::make('jumlah_mitra')
                        ->label('Jumlah Mitra Industri')
                        ->default('20+'),
                ]),

            Section::make('Statistik Kunci')
                ->description('3 angka besar yang ditampilkan di bawah hero.')
                ->schema([
                    Repeater::make('stats')
                        ->label('')
                        ->schema([
                            TextInput::make('num')
                                ->label('Angka')
                                ->required()
                                ->columnSpan(1),

                            Toggle::make('em')
                                ->label('Highlight angka (warna aksen)')
                                ->default(false)
                                ->columnSpan(1),

                            TextInput::make('satuan')
                                ->label('Satuan (%, +, dll)')
                                ->columnSpan(1),

                            TextInput::make('cap')
                                ->label('Judul Statistik')
                                ->required()
                                ->columnSpan(3),

                            Textarea::make('desc')
                                ->label('Deskripsi')
                                ->rows(2)
                                ->columnSpan(3),
                        ])
                        ->columns(3)
                        ->reorderable()
                        ->addActionLabel('Tambah Statistik')
                        ->maxItems(3),
                ]),

            Section::make('Filosofi / Pilar Pembelajaran')
                ->description('3 kartu yang menjelaskan pendekatan pembelajaran.')
                ->schema([
                    Repeater::make('filosofi')
                        ->label('')
                        ->schema([
                            TextInput::make('num')
                                ->label('Nomor')
                                ->default('01')
                                ->columnSpan(1),

                            TextInput::make('title')
                                ->label('Judul')
                                ->required()
                                ->columnSpan(2),

                            Textarea::make('desc')
                                ->label('Deskripsi')
                                ->rows(2)
                                ->columnSpan(3),
                        ])
                        ->columns(3)
                        ->reorderable()
                        ->addActionLabel('Tambah Filosofi')
                        ->maxItems(3),
                ]),

        ]);
    }
}
