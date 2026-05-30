<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Divisi;
use App\Models\Kompetensi;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Akun')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->maxLength(120),

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(180),

                    TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->revealable()
                        ->rule(Password::default())
                        ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                        ->dehydrated(fn ($state) => filled($state))
                        ->required(fn (string $operation) => $operation === 'create')
                        ->helperText(fn (string $operation) => $operation === 'edit'
                            ? 'Kosongkan jika tidak ingin mengubah password. Min 8 karakter, gabungan huruf besar+kecil+angka.'
                            : 'Min 8 karakter, gabungan huruf besar+kecil+angka.')
                        ->columnSpanFull(),
                ]),

            Section::make('Role & Scope Akses')
                ->columns(2)
                ->schema([
                    Select::make('role')
                        ->label('Role')
                        ->options(fn () => Role::pluck('name', 'name'))
                        ->required()
                        ->live()
                        ->afterStateHydrated(function ($component, $state, $record) {
                            if ($record) {
                                $component->state($record->roles->first()?->name);
                            }
                        })
                        ->dehydrated(false),

                    Select::make('kompetensi_id')
                        ->label('Kompetensi')
                        ->options(fn () => Kompetensi::pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->visible(fn ($get) => $get('role') === 'kompetensi')
                        ->required(fn ($get) => $get('role') === 'kompetensi')
                        ->helperText('Wajib diisi untuk role Kompetensi.'),

                    Select::make('divisi_id')
                        ->label('Divisi')
                        ->options(fn () => Divisi::pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->visible(fn ($get) => $get('role') === 'divisi')
                        ->required(fn ($get) => $get('role') === 'divisi')
                        ->helperText('Wajib diisi untuk role Divisi.'),
                ]),
        ]);
    }
}
