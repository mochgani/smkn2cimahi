<?php

namespace App\Filament\Resources\KontakSettings\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KontakSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Google Maps')
                ->columns(1)
                ->schema([
                    Textarea::make('maps_embed_url')
                        ->label('URL Embed Google Maps')
                        ->rows(3)
                        ->helperText('Salin URL dari Google Maps → Share → Embed a map → salin src="..." saja.')
                        ->required(),

                    TextInput::make('maps_address_short')
                        ->label('Alamat Singkat (tampil di overlay peta)')
                        ->placeholder('Jl. Kamarung KM 1.5 No.69, Citeureup, Cimahi Utara'),

                    Textarea::make('maps_address_full')
                        ->label('Alamat Lengkap')
                        ->rows(4)
                        ->placeholder("Jl. Kamarung KM 1.5 No.69\nCiteureup, Cimahi Utara\nKota Cimahi 40512"),
                ]),

            Section::make('Kanal Kontak')
                ->description('Alamat, Telepon, Email, WhatsApp, dll.')
                ->schema([
                    Repeater::make('kanal')
                        ->label('Kanal')
                        ->columnSpanFull()
                        ->reorderable()
                        ->collapsible()
                        ->collapsed()
                        ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                        ->schema([
                            TextInput::make('num')
                                ->label('No')
                                ->placeholder('01')
                                ->required(),
                            TextInput::make('label')
                                ->label('Label')
                                ->placeholder('TELEPON')
                                ->required(),
                            TextInput::make('value')
                                ->label('Nilai Utama')
                                ->placeholder('+62 896 0520 1376')
                                ->required()
                                ->columnSpanFull(),
                            Textarea::make('detail')
                                ->label('Detail (bisa multiline dengan Enter)')
                                ->rows(3)
                                ->columnSpanFull(),
                            TextInput::make('action')
                                ->label('Teks Tombol')
                                ->placeholder('Telepon Sekarang →'),
                            TextInput::make('href')
                                ->label('Link/URL')
                                ->placeholder('tel:+62896...')
                                ->required(),
                            Toggle::make('external')
                                ->label('Buka di tab baru')
                                ->default(false),
                        ])
                        ->columns(2)
                        ->addActionLabel('Tambah Kanal'),
                ]),

            Section::make('Kontak per Bagian')
                ->description('Daftar unit kerja dengan kontak masing-masing.')
                ->schema([
                    Repeater::make('bagian')
                        ->label('Bagian')
                        ->columnSpanFull()
                        ->reorderable()
                        ->collapsible()
                        ->collapsed()
                        ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                        ->schema([
                            TextInput::make('num')
                                ->label('No')
                                ->placeholder('01')
                                ->required(),
                            TextInput::make('name')
                                ->label('Nama Bagian')
                                ->required()
                                ->columnSpanFull(),
                            Textarea::make('desc')
                                ->label('Deskripsi')
                                ->rows(2)
                                ->columnSpanFull(),
                            Select::make('label')
                                ->label('Tipe Kontak')
                                ->options([
                                    'EMAIL'   => 'Email',
                                    'TELEPON' => 'Telepon',
                                    'WA'      => 'WhatsApp',
                                    'HALAMAN' => 'Link Halaman',
                                ])
                                ->required(),
                            TextInput::make('href')
                                ->label('Link/URL')
                                ->placeholder('mailto:... / tel:... / /halaman/...')
                                ->required(),
                            TextInput::make('value')
                                ->label('Teks yang Ditampilkan')
                                ->placeholder('info@smkn2cmi.sch.id')
                                ->required(),
                        ])
                        ->columns(2)
                        ->addActionLabel('Tambah Bagian'),
                ]),

            Section::make('Sosial Media')
                ->schema([
                    Repeater::make('social')
                        ->label('Akun Sosial Media')
                        ->columnSpanFull()
                        ->reorderable()
                        ->collapsible()
                        ->collapsed()
                        ->itemLabel(fn (array $state): ?string => ($state['label'] ?? '') . ($state['handle'] ? ' — ' . $state['handle'] : ''))
                        ->schema([
                            TextInput::make('num')
                                ->label('No')
                                ->placeholder('01')
                                ->required(),
                            TextInput::make('label')
                                ->label('Platform')
                                ->placeholder('INSTAGRAM')
                                ->required(),
                            TextInput::make('handle')
                                ->label('Handle / Nama Akun')
                                ->placeholder('@smkn2_cimahi')
                                ->required(),
                            TextInput::make('href')
                                ->label('URL Profil')
                                ->url()
                                ->required()
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->addActionLabel('Tambah Akun'),
                ]),
        ]);
    }
}
