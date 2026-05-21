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
        // 1) Buat 3 role utama (idempotent)
        foreach (['super_admin', 'kompetensi', 'divisi'] as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // 2) Convert admin existing ke super_admin (kalau belum)
        User::query()->each(function (User $u) {
            if (! $u->hasAnyRole(['super_admin', 'kompetensi', 'divisi'])) {
                $u->assignRole('super_admin');
            }
        });

        // 3) Seed 4 divisi sekolah: Kurikulum, Kesiswaan, Hubungan Industri, Sarana Prasarana
        $divisiSeed = [
            ['slug' => 'kurikulum',          'name' => 'Kurikulum',          'description' => 'Divisi Kurikulum.',                                  'display_order' => 1],
            ['slug' => 'kesiswaan',          'name' => 'Kesiswaan',          'description' => 'Divisi Kesiswaan.',                                  'display_order' => 2],
            ['slug' => 'hubungan-industri',  'name' => 'Hubungan Industri',  'description' => 'Divisi Hubungan Industri (Hubin), termasuk BKK.',    'display_order' => 3],
            ['slug' => 'sarana-prasarana',   'name' => 'Sarana Prasarana',   'description' => 'Divisi Sarana dan Prasarana sekolah.',               'display_order' => 4],
        ];

        foreach ($divisiSeed as $d) {
            Divisi::firstOrCreate(['slug' => $d['slug']], $d);
        }
    }
}
