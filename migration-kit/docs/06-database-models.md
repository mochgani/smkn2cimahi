# Fase 6: Database, Models, & Seeders

Estimasi: ~1 jam

Tujuan: Setup struktur database untuk konten dinamis (berita, kompetensi, pesan kontak).

## 1. Generate Migrations

```bash
php artisan make:migration create_kategoris_table
php artisan make:migration create_authors_table
php artisan make:migration create_beritas_table
php artisan make:migration create_berita_kategori_table
php artisan make:migration create_kompetensis_table
php artisan make:migration create_pesans_table
```

## 2. Isi Migrations

### `database/migrations/xxx_create_kategoris_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('color')->default('#0d6e3f');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};
```

### `database/migrations/xxx_create_authors_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('initials', 4)->nullable();
            $table->text('bio')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
```

### `database/migrations/xxx_create_beritas_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('excerpt');
            $table->longText('content');
            $table->string('cover_image')->nullable();
            $table->json('tags')->nullable();
            $table->integer('reading_time_minutes')->default(3);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->foreignId('author_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            
            $table->index(['is_published', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
```

### `database/migrations/xxx_create_berita_kategori_table.php` (pivot)

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('berita_kategori', function (Blueprint $table) {
            $table->id();
            $table->foreignId('berita_id')->constrained('beritas')->cascadeOnDelete();
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnDelete();
            $table->unique(['berita_id', 'kategori_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_kategori');
    }
};
```

### `database/migrations/xxx_create_kompetensis_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kompetensis', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('code', 5);  // AN, DKV, RPL, dll
            $table->string('name');
            $table->string('tag');       // 'Industri Kreatif', dst
            $table->string('short_desc');
            $table->text('lead');
            $table->longText('about');   // HTML content
            $table->json('sections');    // [{label, title, sub, items}]
            $table->string('cta_label');
            $table->string('cta_title');
            $table->text('cta_text');
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kompetensis');
    }
};
```

### `database/migrations/xxx_create_pesans_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pesans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('telepon')->nullable();
            $table->string('topik');
            $table->text('pesan');
            $table->boolean('is_read')->default(false);
            $table->boolean('is_replied')->default(false);
            $table->ipAddress('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesans');
    }
};
```

## 3. Run Migrations

```bash
php artisan migrate
```

## 4. Generate Models

```bash
php artisan make:model Kategori
php artisan make:model Author
php artisan make:model Berita
php artisan make:model Kompetensi
php artisan make:model Pesan
```

### `app/Models/Kategori.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Kategori extends Model
{
    protected $table = 'kategoris';
    
    protected $fillable = ['name', 'slug', 'color'];

    protected static function booted(): void
    {
        static::creating(function ($kategori) {
            $kategori->slug ??= Str::slug($kategori->name);
        });
    }

    public function beritas(): BelongsToMany
    {
        return $this->belongsToMany(Berita::class, 'berita_kategori');
    }
}
```

### `app/Models/Author.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    protected $fillable = ['name', 'initials', 'bio', 'email'];

    public function beritas(): HasMany
    {
        return $this->hasMany(Berita::class);
    }
}
```

### `app/Models/Berita.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $fillable = [
        'slug', 'title', 'excerpt', 'content', 'cover_image',
        'tags', 'reading_time_minutes', 'is_featured', 'is_published',
        'published_at', 'author_id',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($berita) {
            $berita->slug ??= Str::slug($berita->title);
        });
    }

    public function kategoris(): BelongsToMany
    {
        return $this->belongsToMany(Kategori::class, 'berita_kategori');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where('published_at', '<=', now());
    }
}
```

### `app/Models/Kompetensi.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kompetensi extends Model
{
    protected $fillable = [
        'slug', 'code', 'name', 'tag', 'short_desc', 'lead',
        'about', 'sections', 'cta_label', 'cta_title', 'cta_text',
        'display_order', 'is_active',
    ];

    protected $casts = [
        'sections' => 'array',
        'is_active' => 'boolean',
    ];
}
```

### `app/Models/Pesan.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    protected $fillable = [
        'nama', 'email', 'telepon', 'topik', 'pesan',
        'is_read', 'is_replied', 'ip_address',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_replied' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function ($pesan) {
            $pesan->ip_address ??= request()->ip();
        });
    }
}
```

## 5. Seeders

### `database/seeders/KategoriSeeder.php`

```bash
php artisan make:seeder KategoriSeeder
```

```php
<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['name' => 'Info', 'color' => '#3b82f6'],
            ['name' => 'Kegiatan', 'color' => '#0d6e3f'],
            ['name' => 'Prestasi', 'color' => '#f59e0b'],
        ];

        foreach ($kategoris as $kat) {
            Kategori::firstOrCreate(['name' => $kat['name']], $kat);
        }
    }
}
```

### `database/seeders/AuthorSeeder.php`

```bash
php artisan make:seeder AuthorSeeder
```

```php
<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        Author::firstOrCreate(
            ['name' => 'TIM Penulis'],
            [
                'initials' => 'TP',
                'bio' => 'Tim editorial SMK Negeri 2 Cimahi yang menyajikan kabar terbaru dari sekolah—dari kegiatan akademik, prestasi siswa, hingga pengumuman penting untuk warga sekolah dan publik.',
                'email' => 'editorial@smkn2cmi.sch.id',
            ]
        );
    }
}
```

### `database/seeders/BeritaSeeder.php`

```bash
php artisan make:seeder BeritaSeeder
```

```php
<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $author = Author::where('name', 'TIM Penulis')->first();

        // Load data dari JSON file (copy dari migration kit)
        $jsonPath = database_path('seeders/data/berita.json');
        $beritaData = json_decode(file_get_contents($jsonPath), true);

        foreach ($beritaData as $data) {
            $berita = Berita::firstOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'excerpt' => $data['excerpt'],
                    'content' => $data['content'] ?? "<p>{$data['excerpt']}</p>",
                    'reading_time_minutes' => (int) filter_var($data['reading_time'] ?? '3 menit', FILTER_SANITIZE_NUMBER_INT),
                    'is_featured' => $data['is_featured'] ?? false,
                    'is_published' => true,
                    'published_at' => $data['date_iso'] ?? now(),
                    'author_id' => $author->id,
                ]
            );

            // Attach kategoris
            $kategoriIds = Kategori::whereIn('name', $data['categories'])->pluck('id');
            $berita->kategoris()->sync($kategoriIds);
        }
    }
}
```

### `database/seeders/KompetensiSeeder.php`

```bash
php artisan make:seeder KompetensiSeeder
```

```php
<?php

namespace Database\Seeders;

use App\Models\Kompetensi;
use Illuminate\Database\Seeder;

class KompetensiSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('seeders/data/kompetensi.json');
        $kompetensiData = json_decode(file_get_contents($jsonPath), true);

        foreach ($kompetensiData as $i => $data) {
            Kompetensi::firstOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, ['display_order' => $i + 1])
            );
        }
    }
}
```

## 6. Update `DatabaseSeeder.php`

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            KategoriSeeder::class,
            AuthorSeeder::class,
            KompetensiSeeder::class,
            BeritaSeeder::class,
        ]);
    }
}
```

## 7. Copy Data Files

Copy data JSON dari migration kit:

```bash
mkdir -p database/seeders/data
cp /path/to/migration-kit/data/berita.json database/seeders/data/
cp /path/to/migration-kit/data/kompetensi.json database/seeders/data/
```

## 8. Run Seeders

```bash
php artisan migrate:fresh --seed
```

## 9. Verifikasi

```bash
# Cek di Tinker
php artisan tinker

>>> App\Models\Kategori::count()
=> 3

>>> App\Models\Berita::count()
=> 20

>>> App\Models\Kompetensi::count()
=> 6

>>> App\Models\Berita::with('kategoris', 'author')->first()
# Harus return berita pertama dengan kategoris dan author

>>> exit
```

## ✅ Verifikasi Fase 6

- [ ] Semua migrations bersih (no errors)
- [ ] 5 tables created: `kategoris`, `authors`, `beritas`, `berita_kategori`, `kompetensis`, `pesans`
- [ ] Seeders berhasil insert data
- [ ] Models punya relationships yang benar
- [ ] Bisa query data lewat Tinker

## ➡️ Lanjut ke

[`07-filament-admin.md`](./07-filament-admin.md)
