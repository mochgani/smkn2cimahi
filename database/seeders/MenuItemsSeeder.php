<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MenuItemsSeeder extends Seeder
{
    /**
     * Struktur menu final — sesi 2026-07-06.
     * Reset penuh: hapus semua menu_items lama lalu buat ulang dari struktur ini.
     *
     * Navbar (menu utama, 2 baris): Profil, Kurikulum (mega menu), Kesiswaan,
     * Hubungan Industri, Sarana Prasarana, Kompetensi Keahlian, Prestasi,
     * Berita & Info.
     *
     * Topbar (baris atas kecil, utility): SPMB, Aplikasi (dropdown SSO),
     * Agenda Kegiatan Sekolah (reuse /kurikulum/kalender), Virtual Tour, Kontak.
     * Kontak dipindah ke topbar (paling akhir) supaya navbar lebih leluasa.
     * Kalender dihapus dari mega menu Kurikulum supaya tidak double dengan topbar.
     */
    public function run(): void
    {
        DB::transaction(function () {
            MenuItem::query()->delete();

            $navbarTree = [
                [
                    'label' => 'Profil', 'url' => '#', 'type' => 'static', 'display_order' => 1,
                    'children' => [
                        ['label' => 'Sejarah',        'url' => '/profil/sejarah',       'display_order' => 1],
                        ['label' => 'Kepala Sekolah', 'url' => '/profil/kepala-sekolah', 'display_order' => 2],
                        ['label' => 'Visi dan Misi',  'url' => '/profil/visi-misi',      'display_order' => 3],
                    ],
                ],
                [
                    'label' => 'Kurikulum', 'url' => '#', 'type' => 'static', 'display_order' => 2,
                    'is_mega_menu' => true,
                    'columns' => [
                        [
                            'label' => 'Kurikulum', 'display_order' => 1,
                            'children' => [
                                ['label' => 'Tentang Kurikulum',  'url' => '/kurikulum',                 'display_order' => 1],
                                ['label' => 'Struktur Kurikulum', 'url' => '/kurikulum/struktur',         'display_order' => 2],
                                ['label' => 'Program Keahlian',   'url' => '/kurikulum/program-keahlian', 'display_order' => 3],
                            ],
                        ],
                        [
                            'label' => 'Kemitraan & Produksi', 'display_order' => 2,
                            'children' => [
                                ['label' => 'Kelas Kerja Sama', 'url' => '/kurikulum/kelas-kerja-sama', 'display_order' => 1],
                                ['label' => 'Teaching Factory', 'url' => '/kurikulum/teaching-factory', 'display_order' => 2],
                            ],
                        ],
                        [
                            'label' => 'Kelulusan', 'display_order' => 3,
                            'children' => [
                                ['label' => 'Sertifikasi & PKL', 'url' => '/kurikulum/sertifikasi-pkl', 'display_order' => 1],
                            ],
                        ],
                    ],
                ],
                [
                    'label' => 'Kesiswaan', 'url' => '#', 'type' => 'static', 'display_order' => 3,
                    'children' => [
                        ['label' => 'Program Kesiswaan', 'url' => '/kesiswaan/program',     'display_order' => 1],
                        ['label' => 'Statistik Siswa',   'url' => '/kesiswaan/rekap-siswa', 'display_order' => 2],
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
                    'label' => 'Sarana dan Prasarana', 'url' => '#', 'type' => 'static', 'display_order' => 5,
                    'children' => [
                        ['label' => 'Sarana Pembelajaran Non Kejuruan', 'url' => '/sarana/non-kejuruan', 'display_order' => 1],
                        ['label' => 'Sarana Pembelajaran Kejuruan',     'url' => '/sarana/kejuruan',     'display_order' => 2],
                    ],
                ],
                // Kompetensi Keahlian: children auto-generated dari tabel kompetensis
                [
                    'label' => 'Kompetensi Keahlian', 'url' => '#', 'type' => 'kompetensi_list', 'display_order' => 6,
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
                    'label' => 'Berita & Info', 'url' => '/berita', 'type' => 'static', 'display_order' => 8,
                ],
            ];

            $topbarTree = [
                [
                    'label' => 'SPMB', 'url' => '#', 'type' => 'static', 'display_order' => 1,
                ],
                [
                    'label' => 'Aplikasi', 'url' => '#', 'type' => 'static', 'display_order' => 2,
                    'children' => [
                        ['label' => 'Dapodik',     'url' => '#', 'display_order' => 1],
                        ['label' => 'Erapor',      'url' => '#', 'display_order' => 2],
                        ['label' => 'LMS',         'url' => '#', 'display_order' => 3],
                        ['label' => 'Agenda Guru', 'url' => '#', 'display_order' => 4],
                    ],
                ],
                [
                    'label' => 'Agenda Kegiatan Sekolah', 'url' => '/kurikulum/kalender', 'type' => 'static', 'display_order' => 3,
                ],
                [
                    'label' => 'Virtual Tour SMKN 2 Cimahi', 'url' => '#', 'type' => 'static', 'display_order' => 4,
                ],
                [
                    'label' => 'Kontak', 'url' => '/kontak', 'type' => 'static', 'display_order' => 5,
                ],
            ];

            $this->createTree($navbarTree, 'navbar');
            $this->createTree($topbarTree, 'topbar');
        });

        Cache::forget('shared.navigation');
    }

    private function createTree(array $tree, string $location): void
    {
        foreach ($tree as $item) {
            $columns = $item['columns'] ?? null;
            $children = $item['children'] ?? [];
            unset($item['columns'], $item['children']);

            $parent = MenuItem::create(array_merge($item, [
                'location'     => $location,
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
                        'location'  => $location,
                        'is_active' => true,
                    ]));

                    foreach ($colChildren as $link) {
                        MenuItem::create(array_merge($link, [
                            'parent_id' => $colItem->id,
                            'type'      => 'static',
                            'location'  => $location,
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
                        'location'  => $location,
                        'is_active' => true,
                    ]));
                }
            }
        }
    }
}
