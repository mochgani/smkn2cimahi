<?php

namespace App\Filament\Resources\SchoolStats\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SchoolStatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Data Statistik')
                ->columns(2)
                ->schema([
                    TextInput::make('key')
                        ->label('Key (unik, slug)')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->helperText('Contoh: guru-staff, laboratorium')
                        ->columnSpanFull(),

                    TextInput::make('label')
                        ->label('Label Tampil')
                        ->required()
                        ->helperText('Contoh: Guru & Staff TU'),

                    TextInput::make('value')
                        ->label('Nilai')
                        ->required()
                        ->helperText('Contoh: 114, 50+, 16K'),

                    TextInput::make('display_order')
                        ->label('Urutan')
                        ->numeric()
                        ->default(0),

                    Toggle::make('is_active')
                        ->label('Aktif (tampil di beranda)')
                        ->default(true),
                ]),
        ]);
    }
}
