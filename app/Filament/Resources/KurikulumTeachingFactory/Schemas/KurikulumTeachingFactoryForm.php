<?php

namespace App\Filament\Resources\KurikulumTeachingFactory\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KurikulumTeachingFactoryForm
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

                    TextInput::make('tagline')
                        ->label('Tagline')
                        ->placeholder('Belajar sambil berkarya, berkarya untuk industri.')
                        ->maxLength(255),

                    RichEditor::make('about')
                        ->label('Tentang Teaching Factory')
                        ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList', 'h3', 'link'])
                        ->columnSpanFull(),
                ]),

            Section::make('Statistik')
                ->description('Tampil sebagai angka besar di hero section (maks 3 item).')
                ->schema([
                    Repeater::make('stats')
                        ->label('Statistik')
                        ->schema([
                            TextInput::make('angka')->label('Angka')->required()->placeholder('5'),
                            TextInput::make('label')->label('Label')->required()->placeholder('Unit Produksi Aktif'),
                        ])
                        ->columns(2)
                        ->maxItems(3)
                        ->addActionLabel('Tambah Statistik')
                        ->collapsible(),
                ]),

            Section::make('Produk TEFA')
                ->description('Daftar produk atau layanan yang dihasilkan dari unit produksi.')
                ->schema([
                    Repeater::make('produk')
                        ->label('Produk')
                        ->schema([
                            TextInput::make('nama')->label('Nama Produk')->required(),
                            TextInput::make('kompetensi')->label('Program Keahlian')->required(),
                            Textarea::make('deskripsi')->label('Deskripsi')->rows(3),
                        ])
                        ->addActionLabel('Tambah Produk')
                        ->collapsible(),
                ]),

            Section::make('Fasilitas')
                ->description('Fasilitas penunjang unit produksi Teaching Factory.')
                ->schema([
                    Repeater::make('fasilitas')
                        ->label('Fasilitas')
                        ->schema([
                            TextInput::make('nama')->label('Nama Fasilitas')->required(),
                            Textarea::make('deskripsi')->label('Deskripsi')->rows(2),
                        ])
                        ->addActionLabel('Tambah Fasilitas')
                        ->collapsible(),
                ]),
        ]);
    }
}
