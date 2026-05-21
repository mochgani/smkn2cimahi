# Fase 7: Filament v3 Admin Panel

Estimasi: ~2 jam

Tujuan: Setup Filament v3 sebagai admin panel untuk kelola berita, kompetensi, dan pesan kontak.

## 1. Install Filament v3

```bash
composer require filament/filament:"^3.2" -W

php artisan filament:install --panels
```

Saat ditanya nama panel, ketik: **`admin`** (default)

## 2. Buat Admin User

```bash
php artisan make:filament-user
```

Isi:
- **Name**: Admin SMKN 2 Cimahi
- **Email**: admin@smkn2cmi.sch.id
- **Password**: (password kuat)

## 3. Test Admin Panel

```bash
npm run dev
php artisan serve
```

Akses: `http://localhost:8000/admin`

Login dengan email & password tadi. Anda akan melihat dashboard kosong.

## 4. Buat Filament Resources

### Resource: Berita

```bash
php artisan make:filament-resource Berita --generate
```

Edit `app/Filament/Resources/BeritaResource.php`:

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BeritaResource\Pages;
use App\Models\Berita;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BeritaResource extends Resource
{
    protected static ?string $model = Berita::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Berita';
    protected static ?string $pluralModelLabel = 'Berita';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Konten Utama')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Judul')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),

                    Forms\Components\Textarea::make('excerpt')
                        ->label('Ringkasan')
                        ->required()
                        ->rows(3)
                        ->maxLength(500)
                        ->helperText('Ringkasan singkat untuk daftar berita (max 500 karakter)'),

                    Forms\Components\RichEditor::make('content')
                        ->label('Konten Lengkap')
                        ->required()
                        ->columnSpanFull()
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('berita'),
                ])->columns(2),

            Forms\Components\Section::make('Metadata')
                ->schema([
                    Forms\Components\Select::make('author_id')
                        ->label('Penulis')
                        ->relationship('author', 'name')
                        ->searchable()
                        ->preload(),

                    Forms\Components\Select::make('kategoris')
                        ->label('Kategori')
                        ->multiple()
                        ->relationship('kategoris', 'name')
                        ->searchable()
                        ->preload(),

                    Forms\Components\TextInput::make('reading_time_minutes')
                        ->label('Waktu Baca (menit)')
                        ->numeric()
                        ->default(3)
                        ->minValue(1)
                        ->maxValue(60),

                    Forms\Components\TagsInput::make('tags')
                        ->label('Tags')
                        ->placeholder('Tambah tag...'),
                ])->columns(2),

            Forms\Components\Section::make('Cover & Publikasi')
                ->schema([
                    Forms\Components\FileUpload::make('cover_image')
                        ->label('Cover Image')
                        ->image()
                        ->disk('public')
                        ->directory('berita/covers')
                        ->maxSize(2048),

                    Forms\Components\Toggle::make('is_featured')
                        ->label('Featured (tampil di hero beranda)'),

                    Forms\Components\Toggle::make('is_published')
                        ->label('Publish')
                        ->default(false),

                    Forms\Components\DateTimePicker::make('published_at')
                        ->label('Tanggal Publish')
                        ->default(now()),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Cover')
                    ->disk('public')
                    ->square()
                    ->size(50),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->limit(50)
                    ->wrap(),

                Tables\Columns\TextColumn::make('kategoris.name')
                    ->label('Kategori')
                    ->badge()
                    ->separator(','),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategoris')
                    ->relationship('kategoris', 'name')
                    ->multiple(),
                Tables\Filters\TernaryFilter::make('is_published')->label('Status Publikasi'),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Featured'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBeritas::route('/'),
            'create' => Pages\CreateBerita::route('/create'),
            'edit' => Pages\EditBerita::route('/{record}/edit'),
        ];
    }
}
```

### Resource: Kompetensi

```bash
php artisan make:filament-resource Kompetensi --generate
```

Edit `app/Filament/Resources/KompetensiResource.php`:

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KompetensiResource\Pages;
use App\Models\Kompetensi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KompetensiResource extends Resource
{
    protected static ?string $model = Kompetensi::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Kompetensi Keahlian';
    protected static ?string $pluralModelLabel = 'Kompetensi Keahlian';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Dasar')
                ->schema([
                    Forms\Components\TextInput::make('code')
                        ->label('Kode (AN, DKV, RPL, dll)')
                        ->required()
                        ->maxLength(5),

                    Forms\Components\TextInput::make('name')
                        ->label('Nama Kompetensi')
                        ->required(),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true),

                    Forms\Components\TextInput::make('tag')
                        ->label('Tag (Industri Kreatif, dst)')
                        ->required(),

                    Forms\Components\TextInput::make('short_desc')
                        ->label('Deskripsi Singkat')
                        ->columnSpanFull()
                        ->required(),

                    Forms\Components\Textarea::make('lead')
                        ->label('Lead Paragraph')
                        ->rows(3)
                        ->required()
                        ->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Konten Lengkap')
                ->schema([
                    Forms\Components\RichEditor::make('about')
                        ->label('Tentang Program')
                        ->required()
                        ->columnSpanFull(),

                    Forms\Components\Repeater::make('sections')
                        ->label('Sections (Tujuan, Sumber Daya, dll)')
                        ->schema([
                            Forms\Components\TextInput::make('label')
                                ->label('Label Section')
                                ->required(),
                            Forms\Components\TextInput::make('title')
                                ->label('Judul')
                                ->required(),
                            Forms\Components\Textarea::make('sub')
                                ->label('Sub-judul')
                                ->rows(2),
                            Forms\Components\Repeater::make('items')
                                ->schema([
                                    Forms\Components\TextInput::make('0')->label('Nomor')->required(),
                                    Forms\Components\TextInput::make('1')->label('Judul')->required(),
                                    Forms\Components\Textarea::make('2')->label('Deskripsi')->rows(2),
                                ])
                                ->columns(3)
                                ->reorderable()
                                ->collapsible(),
                        ])
                        ->columnSpanFull()
                        ->reorderable()
                        ->collapsible(),
                ]),

            Forms\Components\Section::make('CTA Banner')
                ->schema([
                    Forms\Components\TextInput::make('cta_label')->required(),
                    Forms\Components\TextInput::make('cta_title')->required()->columnSpanFull(),
                    Forms\Components\Textarea::make('cta_text')->required()->columnSpanFull()->rows(4),
                ])->columns(2),

            Forms\Components\Section::make('Pengaturan')
                ->schema([
                    Forms\Components\TextInput::make('display_order')
                        ->label('Urutan Tampil')
                        ->numeric()
                        ->default(0),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    ->badge()
                    ->color('success')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kompetensi')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tag')
                    ->label('Tag')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('display_order')
                    ->label('Urutan')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->defaultSort('display_order', 'asc')
            ->reorderable('display_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKompetensis::route('/'),
            'create' => Pages\CreateKompetensi::route('/create'),
            'edit' => Pages\EditKompetensi::route('/{record}/edit'),
        ];
    }
}
```

### Resource: Pesan (Kontak)

```bash
php artisan make:filament-resource Pesan --generate
```

Edit `app/Filament/Resources/PesanResource.php`:

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesanResource\Pages;
use App\Models\Pesan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PesanResource extends Resource
{
    protected static ?string $model = Pesan::class;
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Inbox';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Pesan Kontak';
    protected static ?string $pluralModelLabel = 'Pesan Kontak';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_read', false)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Detail Pesan')
                ->schema([
                    Forms\Components\TextInput::make('nama')->disabled(),
                    Forms\Components\TextInput::make('email')->disabled(),
                    Forms\Components\TextInput::make('telepon')->disabled(),
                    Forms\Components\TextInput::make('topik')->disabled(),
                    Forms\Components\Textarea::make('pesan')
                        ->disabled()
                        ->columnSpanFull()
                        ->rows(8),
                ])->columns(2),

            Forms\Components\Section::make('Status')
                ->schema([
                    Forms\Components\Toggle::make('is_read')->label('Sudah Dibaca'),
                    Forms\Components\Toggle::make('is_replied')->label('Sudah Dibalas'),
                    Forms\Components\TextInput::make('ip_address')->disabled(),
                ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_read')
                    ->label('Dibaca')
                    ->boolean()
                    ->trueColor('gray')
                    ->falseColor('warning')
                    ->trueIcon('heroicon-o-check')
                    ->falseIcon('heroicon-o-bell'),

                Tables\Columns\TextColumn::make('nama')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('topik')->badge(),

                Tables\Columns\TextColumn::make('pesan')
                    ->limit(80)
                    ->wrap(),

                Tables\Columns\IconColumn::make('is_replied')
                    ->label('Dibalas')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diterima')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read')->label('Status Baca'),
                Tables\Filters\TernaryFilter::make('is_replied')->label('Status Balas'),
                Tables\Filters\SelectFilter::make('topik'),
            ])
            ->actions([
                Tables\Actions\Action::make('mark_read')
                    ->label('Tandai Dibaca')
                    ->icon('heroicon-o-eye')
                    ->visible(fn ($record) => !$record->is_read)
                    ->action(fn ($record) => $record->update(['is_read' => true])),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPesans::route('/'),
            'view' => Pages\ViewPesan::route('/{record}'),
        ];
    }
}
```

## 5. Customize Brand Filament

Edit `app/Providers/Filament/AdminPanelProvider.php`:

```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->default()
        ->id('admin')
        ->path('admin')
        ->login()
        ->brandName('SMKN 2 Cimahi · Admin')
        ->colors([
            'primary' => '#0d6e3f',  // accent hijau sekolah
        ])
        // ... existing config
        ;
}
```

## 6. Test Filament

```bash
php artisan serve
npm run dev
```

Buka `http://localhost:8000/admin`. Login dengan akun admin.

Anda harusnya melihat:
- ✅ Dashboard
- ✅ Menu **Konten** > Berita, Kompetensi Keahlian
- ✅ Menu **Inbox** > Pesan Kontak (dengan badge merah jika ada pesan baru)

Coba:
1. Buat berita baru di admin
2. Refresh `http://localhost:8000/berita` → berita baru muncul
3. Edit kompetensi → refresh `/kompetensi/animasi` → berubah

## ✅ Verifikasi Fase 7

- [ ] Filament v3 terinstall
- [ ] Admin user bisa login
- [ ] 3 Resources berfungsi: Berita, Kompetensi, Pesan
- [ ] Branding sudah custom (warna hijau)
- [ ] Bisa CRUD dari admin panel
- [ ] Perubahan ter-reflect di frontend

## ➡️ Lanjut ke

[`08-form-kontak.md`](./08-form-kontak.md)
