<?php

namespace App\Filament\Resources\Pesans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PesanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Detail Pesan')
                ->columns(2)
                ->schema([
                    TextInput::make('nama')->disabled(),
                    TextInput::make('email')->disabled(),
                    TextInput::make('telepon')->disabled(),
                    TextInput::make('topik')->disabled(),
                    Textarea::make('pesan')
                        ->disabled()
                        ->rows(8)
                        ->columnSpanFull(),
                ]),

            Section::make('Status')
                ->columns(3)
                ->schema([
                    Toggle::make('is_read')->label('Sudah Dibaca'),
                    Toggle::make('is_replied')->label('Sudah Dibalas'),
                    TextInput::make('ip_address')
                        ->label('IP Address')
                        ->disabled(),
                ]),
        ]);
    }
}
