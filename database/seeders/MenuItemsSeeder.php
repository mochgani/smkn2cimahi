<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemsSeeder extends Seeder
{
    public function run(): void
    {
        // Struktur menu sesuai keputusan sekolah (sesi 2026-05-11)
        $menuTree = [
            [
                'label' => 'Profil', 'url' => '#', 'type' => 'static', 'display_order' => 1,
                'children' => [
                    ['label' => 'Sejarah',         'url' => '/profil/sejarah',         'display_order' => 1],
                    ['label' => 'Kepala Sekolah',  'url' => '/profil/kepala-sekolah',  'display_order' => 2],
                    ['label' => 'Visi dan Misi',   'url' => '/profil/visi-misi',       'display_order' => 3],
                ],
            ],
            [
                'label' => 'Kurikulum', 'url' => '#', 'type' => 'static', 'display_order' => 2,
                'children' => [
                    ['label' => 'Info Kurikulum', 'url' => '/kurikulum', 'display_order' => 1],
                ],
            ],
            [
                'label' => 'Kesiswaan', 'url' => '#', 'type' => 'static', 'display_order' => 3,
                'children' => [
                    ['label' => 'Program Kesiswaan', 'url' => '/kesiswaan/program',     'display_order' => 1],
                    ['label' => 'Rekap Siswa',       'url' => '/kesiswaan/rekap-siswa', 'display_order' => 2],
                ],
            ],
            [
                'label' => 'Hubungan Industri', 'url' => '#', 'type' => 'static', 'display_order' => 4,
                'children' => [
                    ['label' => 'Info Hubin',          'url' => '/hubungan-industri',     'display_order' => 1],
                    ['label' => 'Bursa Kerja Khusus',  'url' => '/hubungan-industri/bkk', 'display_order' => 2],
                ],
            ],
            [
                'label' => 'Sarana Prasarana', 'url' => '#', 'type' => 'static', 'display_order' => 5,
                'children' => [
                    ['label' => 'Sarana Pembelajaran Non Kejuruan', 'url' => '/sarana/non-kejuruan', 'display_order' => 1],
                    ['label' => 'Sarana Pembelajaran Kejuruan',     'url' => '/sarana/kejuruan',     'display_order' => 2],
                ],
            ],
            // Kompetensi: children auto-generated dari tabel kompetensis
            [
                'label' => 'Kompetensi', 'url' => '#', 'type' => 'kompetensi_list', 'display_order' => 6,
            ],
            [
                'label' => 'Prestasi', 'url' => '#', 'type' => 'static', 'display_order' => 7,
                'children' => [
                    ['label' => 'Sekolah', 'url' => '/prestasi/sekolah', 'display_order' => 1],
                    ['label' => 'Siswa',   'url' => '/prestasi/siswa',   'display_order' => 2],
                    ['label' => 'Guru',    'url' => '/prestasi/guru',    'display_order' => 3],
                ],
            ],
            [
                'label' => 'Berita', 'url' => '/berita', 'type' => 'static', 'display_order' => 8,
            ],
            [
                'label' => 'Kontak', 'url' => '/kontak', 'type' => 'static', 'display_order' => 9,
            ],
        ];

        foreach ($menuTree as $parent) {
            $children = $parent['children'] ?? [];
            unset($parent['children']);

            $parentItem = MenuItem::updateOrCreate(
                ['label' => $parent['label'], 'parent_id' => null],
                array_merge($parent, ['is_active' => true]),
            );

            foreach ($children as $child) {
                MenuItem::updateOrCreate(
                    ['label' => $child['label'], 'parent_id' => $parentItem->id],
                    array_merge($child, [
                        'parent_id'  => $parentItem->id,
                        'type'       => 'static',
                        'is_active'  => true,
                    ]),
                );
            }
        }
    }
}
