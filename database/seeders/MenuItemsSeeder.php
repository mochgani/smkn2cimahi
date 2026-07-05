<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MenuItemsSeeder extends Seeder
{
    /**
     * Struktur menu mega-menu (Opsi A) — sesi 2026-06-22.
     * Reset penuh: hapus semua menu_items lama lalu buat ulang dari struktur ini,
     * supaya tidak ada sisa data lama (mis. Kurikulum yang cuma 1 child).
     */
    public function run(): void
    {
        DB::transaction(function () {
            MenuItem::query()->delete();

            $navbarTree = [
                [
                    'label' => 'Profil', 'url' => '#', 'type' => 'static', 'display_order' => 1,
                    'children' => [
                        ['label' => 'Profil Sekolah', 'url' => '/profil/sekolah',       'display_order' => 1],
                        ['label' => 'Sejarah',        'url' => '/profil/sejarah',       'display_order' => 2],
                        ['label' => 'Visi dan Misi',  'url' => '/profil/visi-misi',     'display_order' => 3],
                        ['label' => 'Kepala Sekolah', 'url' => '/profil/kepala-sekolah', 'display_order' => 4],
                    ],
                ],
                [
                    'label' => 'Kurikulum', 'url' => '#', 'type' => 'static', 'display_order' => 2,
                    'is_mega_menu' => true,
                    'columns' => [
                        [
                            'label' => 'Kurikulum', 'display_order' => 1,
                            'children' => [
                                ['label' => 'Tentang Kurikulum',  'url' => '/kurikulum',                    'display_order' => 1],
                                ['label' => 'Struktur Kurikulum', 'url' => '/kurikulum/struktur',            'display_order' => 2],
                                ['label' => 'Program Keahlian',   'url' => '/kurikulum/program-keahlian',    'display_order' => 3],
                            ],
                        ],
                        [
                            'label' => 'Kemitraan & Produksi', 'display_order' => 2,
                            'children' => [
                                ['label' => 'Kelas Kerja Sama',  'url' => '/kurikulum/kelas-kerja-sama', 'display_order' => 1],
                                ['label' => 'Teaching Factory',  'url' => '/kurikulum/teaching-factory', 'display_order' => 2],
                            ],
                        ],
                        [
                            'label' => 'Kelulusan & Agenda', 'display_order' => 3,
                            'children' => [
                                ['label' => 'Sertifikasi & PKL',    'url' => '/kurikulum/sertifikasi-pkl', 'display_order' => 1],
                                ['label' => 'Kalender Akademik',    'url' => '/kurikulum/kalender',        'display_order' => 2],
                            ],
                        ],
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
                        ['label' => 'Info Hubin',         'url' => '/hubungan-industri',     'display_order' => 1],
                        ['label' => 'Bursa Kerja Khusus', 'url' => '/hubungan-industri/bkk', 'display_order' => 2],
                    ],
                ],
                [
                    'label' => 'Sarana Prasarana', 'url' => '#', 'type' => 'static', 'display_order' => 5,
                    'children' => [
                        ['label' => 'Sarana Pembelajaran Non Kejuruan', 'url' => '/sarana/non-kejuruan', 'display_order' => 1],
                        ['label' => 'Sarana Pembelajaran Kejuruan',     'url' => '/sarana/kejuruan',     'display_order' => 2],
                    ],
                ],
                // Kompetensi: children auto-generated dari tabel kompetensis (lihat HandleInertiaRequests)
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

            foreach ($navbarTree as $item) {
                $columns = $item['columns'] ?? null;
                $children = $item['children'] ?? [];
                unset($item['columns'], $item['children']);

                $parent = MenuItem::create(array_merge($item, [
                    'location'     => 'navbar',
                    'is_mega_menu' => $item['is_mega_menu'] ?? false,
                    'is_active'    => true,
                ]));

                if ($columns) {
                    // Mega menu: level 2 = judul kolom, level 3 = link
                    foreach ($columns as $col) {
                        $colChildren = $col['children'] ?? [];
                        unset($col['children']);

                        $colItem = MenuItem::create(array_merge($col, [
                            'parent_id' => $parent->id,
                            'url'       => '#',
                            'type'      => 'static',
                            'location'  => 'navbar',
                            'is_active' => true,
                        ]));

                        foreach ($colChildren as $link) {
                            MenuItem::create(array_merge($link, [
                                'parent_id' => $colItem->id,
                                'type'      => 'static',
                                'location'  => 'navbar',
                                'is_active' => true,
                            ]));
                        }
                    }
                } else {
                    // Dropdown biasa: level 2 = link langsung
                    foreach ($children as $child) {
                        MenuItem::create(array_merge($child, [
                            'parent_id' => $parent->id,
                            'type'      => 'static',
                            'location'  => 'navbar',
                            'is_active' => true,
                        ]));
                    }
                }
            }
        });

        Cache::forget('shared.navigation');
    }
}
