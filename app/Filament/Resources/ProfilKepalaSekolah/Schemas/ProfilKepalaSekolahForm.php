<?php

namespace App\Filament\Resources\ProfilKepalaSekolah\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProfilKepalaSekolahForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas')
                ->columns(2)
                ->schema([
                    TextInput::make('nama')
                        ->label('Nama Lengkap')
                        ->required(),

                    TextInput::make('nip')
                        ->label('NIP')
                        ->placeholder('Opsional'),

                    TextInput::make('jabatan')
                        ->label('Jabatan')
                        ->default('Kepala Sekolah')
                        ->columnSpanFull(),

                    FileUpload::make('foto')
                        ->label('Foto Kepala Sekolah')
                        ->image()
                        ->disk('public')
                        ->directory('profil/kepala-sekolah')
                        ->maxSize(2048)
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth('800')
                        ->imageResizeTargetHeight('1066')
                        ->imageResizeUpscale(false)
                        ->imageEditor()
                        ->imageEditorAspectRatios(['3:4', '1:1'])
                        ->helperText('JPG/PNG/WebP, maks 2MB. Auto-resize ke 800×1066 (3:4).')
                        ->columnSpanFull(),
                ]),

            Section::make('Sambutan')
                ->schema([
                    RichEditor::make('sambutan')
                        ->label('Teks Sambutan')
                        ->columnSpanFull()
                        ->required(),
                ]),
        ]);
    }
}
