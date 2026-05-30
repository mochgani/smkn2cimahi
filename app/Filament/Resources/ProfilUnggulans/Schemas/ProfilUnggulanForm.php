<?php

namespace App\Filament\Resources\ProfilUnggulans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProfilUnggulanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Konten')
                ->columns(2)
                ->schema([
                    TextInput::make('num')
                        ->label('Nomor')
                        ->placeholder('01')
                        ->maxLength(4)
                        ->required(),

                    Select::make('tag')
                        ->label('Kategori Tag')
                        ->options([
                            'KELAS INDUSTRI' => 'Kelas Industri',
                            'KEWIRAUSAHAAN'  => 'Kewirausahaan',
                            'TEFA'           => 'Teaching Factory (TEFA)',
                            'KEMITRAAN'      => 'Kemitraan',
                            'PRESTASI'       => 'Prestasi',
                            'PROGRAM'        => 'Program Khusus',
                        ])
                        ->required(),

                    TextInput::make('title')
                        ->label('Judul Program')
                        ->placeholder('BUMA School')
                        ->required()
                        ->maxLength(120)
                        ->columnSpanFull(),

                    Textarea::make('desc')
                        ->label('Deskripsi')
                        ->rows(4)
                        ->required()
                        ->maxLength(800)
                        ->columnSpanFull(),
                ]),

            Section::make('Pengaturan')
                ->columns(2)
                ->schema([
                    TextInput::make('display_order')
                        ->label('Urutan Tampil')
                        ->numeric()
                        ->default(0)
                        ->minValue(0),

                    Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true),
                ]),
        ]);
    }
}
