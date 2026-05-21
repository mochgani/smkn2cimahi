<?php

namespace App\Filament\Resources\RekapSiswas\Schemas;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RekapSiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Data Rekap')
                ->columns(2)
                ->schema([
                    Select::make('kompetensi_id')
                        ->label('Kompetensi Keahlian')
                        ->relationship('kompetensi', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->columnSpanFull(),

                    Radio::make('kelas')
                        ->label('Kelas')
                        ->options([
                            'X'   => 'Kelas X',
                            'XI'  => 'Kelas XI',
                            'XII' => 'Kelas XII',
                        ])
                        ->required()
                        ->inline()
                        ->columnSpanFull(),

                    TextInput::make('rombel')
                        ->label('Jumlah Rombel')
                        ->numeric()
                        ->minValue(0)
                        ->required()
                        ->default(0),

                    TextInput::make('laki_laki')
                        ->label('Laki-laki')
                        ->numeric()
                        ->minValue(0)
                        ->required()
                        ->default(0),

                    TextInput::make('perempuan')
                        ->label('Perempuan')
                        ->numeric()
                        ->minValue(0)
                        ->required()
                        ->default(0),
                ]),
        ]);
    }
}
