<?php

namespace Database\Seeders;

use App\Models\Divisi;
use App\Models\Kompetensi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DivisiKompetensiUserSeeder extends Seeder
{
    /**
     * Buat 1 akun per Divisi (4) dan per Kompetensi Keahlian (6) — total 10
     * akun — supaya masing-masing penanggung jawab bisa login sendiri dan
     * berita/data yang mereka input otomatis ter-scope sesuai role.
     * Password wajib diganti oleh pemilik akun setelah login pertama.
     */
    public function run(): void
    {
        $divisiUsers = [
            'kesiswaan'          => ['name' => 'Divisi Kesiswaan',          'email' => 'kesiswaan@smkn2cmi.sch.id',   'password' => 'Kesiswaan49!BE'],
            'kurikulum'          => ['name' => 'Divisi Kurikulum',          'email' => 'kurikulum@smkn2cmi.sch.id',   'password' => 'Kurikulum27!AX'],
            'hubungan-industri'  => ['name' => 'Divisi Hubungan Industri',  'email' => 'hubin@smkn2cmi.sch.id',       'password' => 'Hubin39!TG'],
            'sarana-prasarana'   => ['name' => 'Divisi Sarana Prasarana',   'email' => 'sarpras@smkn2cmi.sch.id',     'password' => 'Sarpras64!UR'],
        ];

        foreach ($divisiUsers as $slug => $data) {
            $divisi = Divisi::where('slug', $slug)->first();
            if (!$divisi) {
                continue;
            }

            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'      => $data['name'],
                    'password'  => Hash::make($data['password']),
                    'divisi_id' => $divisi->id,
                ]
            );
            $user->syncRoles(['divisi']);
        }

        $kompetensiUsers = [
            'animasi'     => ['name' => 'Kompetensi Animasi',                'email' => 'animasi@smkn2cmi.sch.id',     'password' => 'Animasi82!BJ'],
            'dkv'         => ['name' => 'Kompetensi Desain Komunikasi Visual', 'email' => 'dkv@smkn2cmi.sch.id',       'password' => 'Dkv65!BL'],
            'rpl'         => ['name' => 'Kompetensi Rekayasa Perangkat Lunak', 'email' => 'rpl@smkn2cmi.sch.id',       'password' => 'Rpl67!KS'],
            'kimia'       => ['name' => 'Kompetensi Teknik Kimia Industri',  'email' => 'kimia@smkn2cmi.sch.id',       'password' => 'Kimia62!LJ'],
            'mekatronika' => ['name' => 'Kompetensi Teknik Mekatronika',     'email' => 'mekatronika@smkn2cmi.sch.id', 'password' => 'Mekatronika46!UD'],
            'pemesinan'   => ['name' => 'Kompetensi Teknik Pemesinan',       'email' => 'pemesinan@smkn2cmi.sch.id',   'password' => 'Pemesinan27!GD'],
        ];

        foreach ($kompetensiUsers as $slug => $data) {
            $kompetensi = Kompetensi::where('slug', $slug)->first();
            if (!$kompetensi) {
                continue;
            }

            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'          => $data['name'],
                    'password'      => Hash::make($data['password']),
                    'kompetensi_id' => $kompetensi->id,
                ]
            );
            $user->syncRoles(['kompetensi']);
        }
    }
}
