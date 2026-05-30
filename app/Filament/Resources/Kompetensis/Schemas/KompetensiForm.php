<?php

namespace App\Filament\Resources\Kompetensis\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class KompetensiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Dasar')
                ->columns(2)
                ->schema([
                    TextInput::make('code')
                        ->label('Kode (AN, DKV, RPL, dll)')
                        ->required()
                        ->maxLength(5),

                    TextInput::make('name')
                        ->label('Nama Kompetensi')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true),

                    TextInput::make('tag')
                        ->label('Tag (Industri Kreatif, dst)')
                        ->required(),

                    TextInput::make('short_desc')
                        ->label('Deskripsi Singkat')
                        ->required()
                        ->columnSpanFull(),

                    Textarea::make('lead')
                        ->label('Lead Paragraph')
                        ->rows(3)
                        ->required()
                        ->columnSpanFull(),
                ]),

            Section::make('Konten Lengkap')
                ->schema([
                    RichEditor::make('about')
                        ->label('Tentang Program')
                        ->required()
                        ->columnSpanFull(),

                    Repeater::make('sections')
                        ->label('Sections (Tujuan, Sumber Daya, dll)')
                        ->columnSpanFull()
                        ->reorderable()
                        ->collapsible()
                        ->collapsed()
                        ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                        ->schema([
                            TextInput::make('label')
                                ->label('Label Section (mis. "Tujuan Program")')
                                ->required(),

                            TextInput::make('title')
                                ->label('Judul')
                                ->required(),

                            Textarea::make('sub')
                                ->label('Sub-judul')
                                ->rows(2),

                            Repeater::make('items')
                                ->label('Item')
                                ->columns(3)
                                ->reorderable()
                                ->collapsible()
                                ->itemLabel(fn (array $state): ?string => isset($state['num'], $state['title']) ? "{$state['num']} — {$state['title']}" : null)
                                ->schema([
                                    TextInput::make('num')
                                        ->label('No')
                                        ->required(),
                                    TextInput::make('title')
                                        ->label('Judul')
                                        ->required(),
                                    Textarea::make('desc')
                                        ->label('Deskripsi')
                                        ->rows(2),
                                ]),
                        ]),
                ]),

            Section::make('Logo & Gallery')
                ->columns(2)
                ->schema([
                    FileUpload::make('logo_image')
                        ->label('Logo Jurusan')
                        ->image()
                        ->disk('public')
                        ->directory('kompetensi/logos')
                        ->maxSize(1024)
                        ->acceptedFileTypes(['image/png', 'image/svg+xml', 'image/webp'])
                        ->helperText('PNG transparan/SVG/WebP, kotak (1:1), maks 1MB.')
                        ->columnSpanFull(),

                    FileUpload::make('gallery')
                        ->label('Gallery Foto Jurusan')
                        ->multiple()
                        ->reorderable()
                        ->image()
                        ->disk('public')
                        ->directory('kompetensi/gallery')
                        ->maxSize(3072)
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->panelLayout('grid')
                        ->helperText('Bisa upload beberapa foto sekaligus. Drag untuk atur urutan. Maks 3MB per foto.')
                        ->columnSpanFull(),
                ]),

            Section::make('CTA Banner')
                ->columns(2)
                ->schema([
                    TextInput::make('cta_label')
                        ->label('Label CTA')
                        ->required(),

                    TextInput::make('cta_title')
                        ->label('Judul CTA')
                        ->required()
                        ->columnSpanFull(),

                    Textarea::make('cta_text')
                        ->label('Teks CTA')
                        ->required()
                        ->rows(4)
                        ->columnSpanFull(),
                ]),

            Section::make('Pengaturan')
                ->columns(2)
                ->schema([
                    TextInput::make('display_order')
                        ->label('Urutan Tampil')
                        ->numeric()
                        ->default(0),

                    Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true),
                ]),
        ]);
    }
}
