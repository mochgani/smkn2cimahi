<?php

namespace App\Filament\Resources\KurikulumMitras\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KurikulumMitraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Mitra')
                ->columns(2)
                ->schema([
                    TextInput::make('nama')
                        ->label('Nama Perusahaan / Institusi')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    TextInput::make('field')
                        ->label('Program Keahlian Terkait')
                        ->required()
                        ->placeholder('Teknik Mekatronika')
                        ->maxLength(255),

                    TextInput::make('display_order')
                        ->label('Urutan Tampil')
                        ->numeric()
                        ->default(0),

                    Textarea::make('desc')
                        ->label('Deskripsi Kerja Sama')
                        ->rows(4)
                        ->columnSpanFull(),

                    TagsInput::make('tags')
                        ->label('Tag / Bentuk Kerja Sama')
                        ->placeholder('Tambah tag lalu Enter')
                        ->helperText('Contoh: Penyelarasan kurikulum, Guru tamu, Sertifikasi')
                        ->columnSpanFull(),
                ]),

            Section::make('Logo Mitra')
                ->schema([
                    FileUpload::make('logo')
                        ->label('Logo Perusahaan')
                        ->image()
                        ->disk('public')
                        ->directory('kurikulum/mitras')
                        ->imageResizeMode('contain')
                        ->imageResizeTargetWidth(400)
                        ->imageResizeTargetHeight(200)
                        ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'])
                        ->maxSize(1024)
                        ->helperText('Rekomendasi: format PNG transparan, max 1MB.'),
                ]),

            Section::make('Status')
                ->schema([
                    Toggle::make('is_active')
                        ->label('Tampilkan di website')
                        ->default(true),
                ]),
        ]);
    }
}
