<?php

namespace App\Filament\Resources\KurikulumKalender\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KurikulumKalenderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Halaman')
                ->schema([
                    TextInput::make('title')
                        ->label('Judul Halaman')
                        ->required()
                        ->maxLength(255),

                    Textarea::make('lead')
                        ->label('Lead / Deskripsi Singkat')
                        ->rows(3),
                ]),

            Section::make('Google Calendar Embed')
                ->description('Dapatkan URL embed dari Google Calendar → Setelan kalender → Bagikan kalender → Embed code. Salin src="..." dari iframe tersebut.')
                ->schema([
                    TextInput::make('embed_url')
                        ->label('URL Embed Google Calendar')
                        ->placeholder('https://calendar.google.com/calendar/embed?src=...')
                        ->url()
                        ->maxLength(1000)
                        ->columnSpanFull()
                        ->helperText('Kosongkan jika kalender Google belum tersedia. Akan menampilkan pesan alternatif.'),

                    TextInput::make('public_url')
                        ->label('URL Publik Google Calendar (opsional)')
                        ->placeholder('https://calendar.google.com/calendar/u/0/r?...')
                        ->url()
                        ->maxLength(1000)
                        ->helperText('Link untuk tombol "Buka di Google Calendar".'),
                ]),

            Section::make('Catatan')
                ->schema([
                    Textarea::make('catatan')
                        ->label('Catatan / Keterangan')
                        ->rows(4)
                        ->helperText('Catatan di bawah kalender, misalnya: "Jadwal dapat berubah sewaktu-waktu."'),
                ]),
        ]);
    }
}
