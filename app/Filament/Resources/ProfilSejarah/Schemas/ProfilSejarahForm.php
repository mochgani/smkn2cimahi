<?php

namespace App\Filament\Resources\ProfilSejarah\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProfilSejarahForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Halaman')
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->label('Judul Halaman')
                        ->required()
                        ->columnSpanFull(),

                    Textarea::make('lead')
                        ->label('Paragraf Intro (Lead)')
                        ->rows(3)
                        ->columnSpanFull(),

                    TextInput::make('tahun_berdiri')
                        ->label('Tahun Berdiri'),

                    TextInput::make('luas_lahan')
                        ->label('Luas Lahan')
                        ->placeholder('mis. 15.609 m²'),
                ]),

            Section::make('Konten Sejarah')
                ->schema([
                    RichEditor::make('content')
                        ->label('Isi Sejarah')
                        ->columnSpanFull()
                        ->required(),
                ]),

            Section::make('Media')
                ->columns(2)
                ->schema([
                    FileUpload::make('image')
                        ->label('Foto Sekolah')
                        ->image()
                        ->disk('public')
                        ->directory('profil/sejarah')
                        ->maxSize(3072)
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth('1600')
                        ->imageResizeTargetHeight('900')
                        ->imageResizeUpscale(false)
                        ->imageEditor()
                        ->imageEditorAspectRatios(['16:9'])
                        ->helperText('JPG/PNG/WebP, maks 3MB. Auto-resize ke 1600×900 (16:9).')
                        ->columnSpanFull(),

                    TextInput::make('video_youtube_url')
                        ->label('Link Video YouTube')
                        ->url()
                        ->placeholder('https://www.youtube.com/watch?v=...')
                        ->helperText('Masukkan URL video YouTube (opsional).')
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
