<?php

namespace App\Filament\Resources\ProfilVisiMisi\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProfilVisiMisiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Visi')
                ->schema([
                    Textarea::make('visi')
                        ->label('Visi Sekolah')
                        ->rows(4)
                        ->required()
                        ->columnSpanFull(),
                ]),

            Section::make('Misi')
                ->schema([
                    Repeater::make('misi')
                        ->label('Daftar Misi')
                        ->columnSpanFull()
                        ->reorderable()
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => $state['text'] ?? null)
                        ->schema([
                            Textarea::make('text')
                                ->label('Poin Misi')
                                ->rows(2)
                                ->required(),
                        ])
                        ->minItems(1)
                        ->addActionLabel('Tambah Poin Misi'),
                ]),

            Section::make('Tujuan')
                ->schema([
                    Repeater::make('tujuan')
                        ->label('Daftar Tujuan')
                        ->columnSpanFull()
                        ->reorderable()
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => $state['text'] ?? null)
                        ->schema([
                            Textarea::make('text')
                                ->label('Poin Tujuan')
                                ->rows(2)
                                ->required(),
                        ])
                        ->addActionLabel('Tambah Poin Tujuan'),
                ]),
        ]);
    }
}
