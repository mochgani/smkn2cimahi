<?php

namespace App\Filament\Resources\HeroBanners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HeroBannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Konten Slide')
                ->columns(2)
                ->schema([
                    Select::make('tag')
                        ->label('Kategori Tag')
                        ->options([
                            'KEGIATAN'     => 'Kegiatan',
                            'PRESTASI'     => 'Prestasi',
                            'PENGUMUMAN'   => 'Pengumuman',
                            'INFORMASI'    => 'Informasi',
                            'PENERIMAAN'   => 'Penerimaan',
                        ])
                        ->required(),

                    TextInput::make('date_display')
                        ->label('Tanggal Tampil')
                        ->placeholder('dd.mm.yyyy — contoh: 04.03.2026')
                        ->required()
                        ->maxLength(20),

                    TextInput::make('title')
                        ->label('Judul')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Textarea::make('desc')
                        ->label('Deskripsi')
                        ->required()
                        ->rows(3)
                        ->maxLength(500)
                        ->columnSpanFull(),
                ]),

            Section::make('Gambar Banner')
                ->schema([
                    FileUpload::make('image')
                        ->label('Gambar')
                        ->image()
                        ->disk('public')
                        ->directory('hero-banners')
                        ->maxSize(3072)
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth('1600')
                        ->imageResizeTargetHeight('1200')
                        ->imageResizeUpscale(false)
                        ->imageEditor()
                        ->imageEditorAspectRatios(['4:3', '16:9'])
                        ->helperText('Opsional. JPG/PNG/WebP. Auto-resize ke 1600×1200, maks 3MB.'),
                ]),

            Section::make('CTA & Badge')
                ->columns(2)
                ->schema([
                    TextInput::make('cta_label')
                        ->label('Label Tombol')
                        ->required()
                        ->default('Baca Selengkapnya')
                        ->maxLength(60),

                    TextInput::make('cta_href')
                        ->label('Link Tombol')
                        ->required()
                        ->default('#')
                        ->maxLength(255)
                        ->url(),

                    TextInput::make('badge')
                        ->label('Teks Badge')
                        ->required()
                        ->maxLength(60)
                        ->helperText('Badge yang muncul di kotak kanan bawah slide.')
                        ->columnSpanFull(),
                ]),

            Section::make('Pengaturan')
                ->columns(2)
                ->schema([
                    TextInput::make('display_order')
                        ->label('Urutan Tampil')
                        ->numeric()
                        ->default(0)
                        ->minValue(0)
                        ->helperText('Angka lebih kecil tampil lebih dulu.'),

                    Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true),
                ]),
        ]);
    }
}
