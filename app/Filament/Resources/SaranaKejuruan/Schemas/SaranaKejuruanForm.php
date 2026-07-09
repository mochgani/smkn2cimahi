<?php

namespace App\Filament\Resources\SaranaKejuruan\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SaranaKejuruanForm
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
                        ->rows(3)
                        ->maxLength(500),
                ]),

            Section::make('Laboratorium & Bengkel per Kompetensi')
                ->description('Daftar ruangan praktik untuk tiap kompetensi keahlian.')
                ->schema([
                    Repeater::make('groups')
                        ->label('')
                        ->schema([
                            TextInput::make('kompetensi')
                                ->label('Nama Kompetensi Keahlian')
                                ->required()
                                ->columnSpanFull(),

                            TagsInput::make('ruangan')
                                ->label('Ruangan / Lab / Bengkel')
                                ->placeholder('Tambah nama ruangan lalu Enter')
                                ->columnSpanFull(),
                        ])
                        ->columns(1)
                        ->reorderable()
                        ->addActionLabel('Tambah Kompetensi')
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => $state['kompetensi'] ?? null),
                ]),

        ]);
    }
}
