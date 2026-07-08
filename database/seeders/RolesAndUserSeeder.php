<?php

namespace Database\Seeders;

use App\Models\Divisi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Buat role utama (idempotent)
        foreach (['super_admin', 'kompetensi', 'divisi', 'manajemen_mutu'] as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // 2) Convert admin existing ke super_admin (kalau belum)
        User::query()->each(function (User $u) {
            if (! $u->hasAnyRole(['super_admin', 'kompetensi', 'divisi', 'manajemen_mutu'])) {
                $u->assignRole('super_admin');
            }
        });

        // 3) Seed divisi sekolah
        $divisiSeed = [
            ['slug' => 'kurikulum',          'name' => 'Kurikulum',          'description' => 'Divisi Kurikulum.',                                  'display_order' => 1],
            ['slug' => 'kesiswaan',          'name' => 'Kesiswaan',          'description' => 'Divisi Kesiswaan.',                                  'display_order' => 2],
            ['slug' => 'hubungan-industri',  'name' => 'Hubungan Industri',  'description' => 'Divisi Hubungan Industri (Hubin), termasuk BKK.',    'display_order' => 3],
            ['slug' => 'sarana-prasarana',   'name' => 'Sarana Prasarana',   'description' => 'Divisi Sarana dan Prasarana sekolah.',               'display_order' => 4],
            ['slug' => 'manajemen-mutu',     'name' => 'Manajemen Mutu',     'description' => 'Divisi Manajemen Mutu — validasi berita/konten dari semua divisi dan kompetensi keahlian.', 'display_order' => 5],
        ];

        foreach ($divisiSeed as $d) {
            Divisi::firstOrCreate(['slug' => $d['slug']], $d);
        }
    }
}
