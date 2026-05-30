<?php

namespace App\Filament\Resources\SchoolSettings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SchoolSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Identitas Sekolah')
                ->columns(2)
                ->schema([
                    TextInput::make('school_name')
                        ->label('Nama Sekolah')
                        ->required()
                        ->columnSpanFull(),

                    TextInput::make('tagline')
                        ->label('Tagline')
                        ->placeholder('BMW: Bekerja · Melanjutkan · Wirausaha')
                        ->columnSpanFull(),

                    TextInput::make('tahun_berdiri')
                        ->label('Tahun Berdiri')
                        ->placeholder('2007'),

                    TextInput::make('copyright')
                        ->label('Teks Copyright')
                        ->placeholder('© 2026 SMK NEGERI 2 CIMAHI'),
                ]),

            Section::make('Logo')
                ->schema([
                    FileUpload::make('logo')
                        ->label('Logo Sekolah')
                        ->image()
                        ->disk('public')
                        ->directory('school')
                        ->maxSize(1024)
                        ->acceptedFileTypes(['image/png', 'image/svg+xml', 'image/webp', 'image/jpeg'])
                        ->helperText('PNG transparan/SVG/WebP/JPG, min. 200×200px. Kosongkan untuk pakai logo default.'),
                ]),

            Section::make('Nomor Identifikasi')
                ->columns(2)
                ->schema([
                    TextInput::make('nss')
                        ->label('NSS (Nomor Statistik Sekolah)')
                        ->placeholder('401026802002'),

                    TextInput::make('npsn')
                        ->label('NPSN (Nomor Pokok Sekolah Nasional)')
                        ->placeholder('20224389'),
                ]),

        ]);
    }
}
