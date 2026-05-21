<?php

namespace App\Filament\Resources\Bkk\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BkkSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Tentang BKK')
                ->schema([
                    RichEditor::make('about')
                        ->label('Deskripsi BKK')
                        ->columnSpanFull()
                        ->required(),
                ]),

            Section::make('Tujuan Pembentukan')
                ->schema([
                    Repeater::make('tujuan')
                        ->label('Daftar Tujuan')
                        ->columnSpanFull()
                        ->reorderable()
                        ->collapsible()
                        ->collapsed()
                        ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                        ->schema([
                            TextInput::make('num')
                                ->label('Nomor')
                                ->placeholder('01')
                                ->required(),
                            TextInput::make('tag')
                                ->label('Tag')
                                ->placeholder('WADAH')
                                ->required(),
                            TextInput::make('title')
                                ->label('Judul')
                                ->required()
                                ->columnSpanFull(),
                            Textarea::make('desc')
                                ->label('Deskripsi')
                                ->rows(3)
                                ->required()
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->addActionLabel('Tambah Tujuan'),
                ]),

            Section::make('Perusahaan Mitra')
                ->schema([
                    Repeater::make('perusahaan')
                        ->label('Daftar Perusahaan')
                        ->columnSpanFull()
                        ->reorderable()
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                        ->schema([
                            TextInput::make('name')
                                ->label('Nama Perusahaan')
                                ->required(),
                        ])
                        ->addActionLabel('Tambah Perusahaan'),
                ]),
        ]);
    }
}
