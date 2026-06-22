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
                            return MenuItem::active()
                                ->when($record, fn ($q) => $q->where('id', '!=', $record->id))
                                ->orderBy('display_order')
                                ->get()
                                ->mapWithKeys(fn ($item) => [
                                    $item->id => ($item->parent_id ? '↳ ' : '') . $item->label,
                                ]);
                        })
                        ->searchable()
                        ->helperText('Kosongkan untuk top-level. Pilih parent untuk sub-menu (dropdown) atau judul kolom (mega menu).'),

                    TextInput::make('url')
                        ->label('URL / Link')
                        ->required()
                        ->default('#')
                        ->maxLength(255)
                        ->helperText('Contoh: /profil/sejarah · https://dapodik.kemdikbud.go.id · # (tidak ada link)')
                        ->columnSpanFull(),

                    Select::make('type')
                        ->label('Tipe Konten')
                        ->options([
                            'static'          => 'Statis (manual)',
                            'kompetensi_list' => 'Daftar Kompetensi (auto-generated)',
                        ])
                        ->default('static')
                        ->required()
                        ->helperText('"Daftar Kompetensi": children otomatis dari tabel kompetensi aktif.')
                        ->visible(fn ($get) => !$get('parent_id') && $get('location') !== 'topbar'),
                ]),

            Section::make('Pengaturan Tampilan')
                ->columns(2)
                ->schema([
                    Select::make('location')
                        ->label('Lokasi')
                        ->options([
                            'navbar' => 'Navbar (menu utama)',
                            'topbar' => 'Topbar (baris atas)',
                        ])
                        ->default('navbar')
                        ->required()
                        ->helperText('Topbar: link utilitas (aplikasi, virtual tour, kontak). Navbar: menu navigasi utama.')
                        ->visible(fn ($get) => !$get('parent_id')),

                    Toggle::make('is_mega_menu')
                        ->label('Mega Menu')
                        ->helperText('Aktifkan agar sub-menu tampil sebagai panel kolom (mega menu). Children menjadi judul kolom, grandchildren menjadi link.')
                        ->default(false)
                        ->visible(fn ($get) => !$get('parent_id') && $get('location') !== 'topbar'),

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
