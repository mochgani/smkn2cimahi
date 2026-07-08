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

            Section::make('Google Calendar')
                ->description('Kalender ditampilkan custom (bukan iframe) menggunakan Google Calendar API. Calendar ID & API Key bisa didapat dari Google Cloud Console dan Setelan Google Calendar — semua diatur di sini, tidak perlu edit file server.')
                ->schema([
                    TextInput::make('calendar_id')
                        ->label('Calendar ID')
                        ->placeholder('xxxxx@group.calendar.google.com')
                        ->maxLength(255)
                        ->columnSpanFull()
                        ->helperText('Google Calendar → Setelan kalender → Integrasikan kalender → Calendar ID. Kalender harus di-set "Public" (Setelan → Izin akses → Available to public) supaya event bisa diambil.'),

                    TextInput::make('api_key')
                        ->label('Google Calendar API Key')
                        ->password()
                        ->revealable()
                        ->maxLength(255)
                        ->columnSpanFull()
                        ->helperText('Dari Google Cloud Console → APIs & Services → Credentials. Pastikan "Google Calendar API" sudah di-enable di project tersebut.'),

                    TextInput::make('public_url')
                        ->label('URL Publik Google Calendar (opsional)')
                        ->placeholder('https://calendar.google.com/calendar/u/0/r?...')
                        ->url()
                        ->maxLength(1000)
                        ->columnSpanFull()
                        ->helperText('Link untuk tombol "Buka di Google Calendar".'),

                    TextInput::make('embed_url')
                        ->label('URL Embed Iframe (fallback lama, opsional)')
                        ->placeholder('https://calendar.google.com/calendar/embed?src=...')
                        ->url()
                        ->maxLength(1000)
                        ->columnSpanFull()
                        ->helperText('Cadangan kalau tampilan custom gagal memuat data. Boleh dikosongkan.'),
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
