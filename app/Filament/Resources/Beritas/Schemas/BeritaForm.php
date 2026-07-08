<?php

namespace App\Filament\Resources\Beritas\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BeritaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Konten Utama')
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->label('Judul')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                        ->columnSpanFull(),

                    TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->columnSpanFull(),

                    Textarea::make('excerpt')
                        ->label('Ringkasan')
                        ->required()
                        ->rows(3)
                        ->maxLength(500)
                        ->helperText('Ringkasan singkat untuk daftar berita (maks 500 karakter).')
                        ->columnSpanFull(),

                    RichEditor::make('content')
                        ->label('Konten Lengkap')
                        ->required()
                        ->columnSpanFull()
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('berita'),
                ]),

            Section::make('Metadata')
                ->columns(2)
                ->schema([
                    Select::make('kategoris')
                        ->label('Kategori')
                        ->multiple()
                        ->relationship('kategoris', 'name')
                        ->searchable()
                        ->preload(),

                    TextInput::make('reading_time_minutes')
                        ->label('Waktu Baca (menit)')
                        ->numeric()
                        ->default(3)
                        ->minValue(1)
                        ->maxValue(60),

                    TagsInput::make('tags')
                        ->label('Tags')
                        ->placeholder('Tambah tag...'),
                ]),

            Section::make('Scope Berita (Kompetensi / Divisi)')
                ->description('Hanya bisa diisi salah satu. Untuk user kompetensi/divisi, scope ini akan otomatis terisi dari profil user.')
                ->columns(2)
                ->visible(fn () => auth()->user()?->isSuperAdmin() ?? false)
                ->schema([
                    Select::make('kompetensi_id')
                        ->label('Kompetensi (opsional)')
                        ->relationship('kompetensi', 'name')
                        ->searchable()
                        ->preload()
                        ->placeholder('— Tidak terkait kompetensi —'),

                    Select::make('divisi_id')
                        ->label('Divisi (opsional)')
                        ->relationship('divisi', 'name')
                        ->searchable()
                        ->preload()
                        ->placeholder('— Tidak terkait divisi —'),
                ]),

            Section::make('Cover & Publikasi')
                ->columns(2)
                ->schema([
                    FileUpload::make('cover_image')
                        ->label('Cover Image')
                        ->image()
                        ->disk('public')
                        ->directory('berita/covers')
                        ->maxSize(2048)
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth('1200')
                        ->imageResizeTargetHeight('675')
                        ->imageEditor()
                        ->imageEditorAspectRatios(['16:9', '4:3', '1:1'])
                        ->helperText('JPG/PNG/WebP, maks 2MB. Auto-resize ke 1200×675 (16:9).')
                        ->columnSpanFull(),

                    Toggle::make('is_featured')
                        ->label('Featured (tampil di hero beranda)')
                        ->visible(fn () => auth()->user()?->isSuperAdmin() || auth()->user()?->isKepalaSekolah()),

                    Toggle::make('is_published')
                        ->label('Publish')
                        ->default(false)
                        ->visible(fn () => auth()->user()?->isSuperAdmin() || auth()->user()?->isKepalaSekolah())
                        ->helperText('Hanya super admin & Kepala Sekolah yang bisa mempublish berita langsung.'),

                    DateTimePicker::make('published_at')
                        ->label('Tanggal Publish')
                        ->default(now())
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
