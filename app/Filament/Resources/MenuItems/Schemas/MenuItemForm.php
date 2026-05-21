<?php

namespace App\Filament\Resources\MenuItems\Schemas;

use App\Models\MenuItem;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MenuItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Menu')
                ->columns(2)
                ->schema([
                    TextInput::make('label')
                        ->label('Label')
                        ->required()
                        ->maxLength(100),

                    Select::make('parent_id')
                        ->label('Parent Menu')
                        ->placeholder('— Top Level (tanpa parent) —')
                        ->options(function ($record) {
                            return MenuItem::topLevel()
                                ->when($record, fn ($q) => $q->where('id', '!=', $record->id))
                                ->orderBy('display_order')
                                ->pluck('label', 'id');
                        })
                        ->searchable()
                        ->helperText('Kosongkan untuk menu utama. Pilih parent untuk membuat sub-menu.'),

                    TextInput::make('url')
                        ->label('URL / Link')
                        ->required()
                        ->default('#')
                        ->maxLength(255)
                        ->helperText('Contoh: /profil/sejarah atau /berita atau https://...')
                        ->columnSpanFull(),

                    Select::make('type')
                        ->label('Tipe Menu')
                        ->options([
                            'static' => 'Statis (manual)',
                            'kompetensi_list' => 'Daftar Kompetensi (auto-generated)',
                        ])
                        ->default('static')
                        ->required()
                        ->helperText('Pilih "Daftar Kompetensi" jika children menu ini ingin otomatis diambil dari daftar kompetensi aktif.'),
                ]),

            Section::make('Pengaturan')
                ->columns(2)
                ->schema([
                    TextInput::make('display_order')
                        ->label('Urutan Tampil')
                        ->numeric()
                        ->default(0)
                        ->minValue(0)
                        ->helperText('Angka lebih kecil tampil lebih dulu.'),

                    Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true),
                ]),
        ]);
    }
}
