<?php

namespace App\Http\Controllers;

use App\Models\ProfilKepalaSekolah;
use App\Models\ProfilSejarah;
use App\Models\ProfilVisiMisi;
use Inertia\Inertia;
use Inertia\Response;

class ProfilController extends Controller
{
    public function sejarah(): Response
    {
        $s = ProfilSejarah::instance();

        return Inertia::render('Profil/Sejarah', [
            'sejarah' => [
                'title'             => $s->title,
                'lead'              => $s->lead,
                'content'           => $s->content,
                'image'             => $s->image ? '/storage/'.$s->image : null,
                'tahun_berdiri'     => $s->tahun_berdiri,
                'luas_lahan'        => $s->luas_lahan,
                'video_embed_url'   => \App\Support\Youtube::embedUrl($s->video_youtube_url),
                'video_youtube_url' => $s->video_youtube_url,
            ],
        ]);
    }

    public function kepalaSekolah(): Response
    {
        $k = ProfilKepalaSekolah::instance();

        return Inertia::render('Profil/KepalaSekolah', [
            'kepala' => [
                'nama'     => $k->nama,
                'nip'      => $k->nip,
                'jabatan'  => $k->jabatan,
                'foto'     => $k->foto ? '/storage/'.$k->foto : null,
                'sambutan' => $k->sambutan,
            ],
        ]);
    }

    public function sekolah(): Response
    {
        $unggulan = \App\Models\ProfilUnggulan::active()
            ->orderBy('display_order')
            ->get(['num', 'tag', 'title', 'desc'])
            ->toArray();

        return Inertia::render('Profil/Sekolah', [
            'unggulan' => $unggulan,
        ]);
    }

    public function visiMisi(): Response
    {
        $vm = ProfilVisiMisi::instance();

        return Inertia::render('Profil/VisiMisi', [
            'visi'   => $vm->visi,
            'misi'   => $vm->misi ?? [],
            'tujuan' => $vm->tujuan ?? [],
        ]);
    }

    public function bkk(): Response
    {
        return Inertia::render('Profil/BKK', [
            'tujuan' => [
                ['num' => '01', 'tag' => 'WADAH', 'title' => 'Mempertemukan tamatan dengan pencari kerja', 'desc' => 'Sebagai wadah utama yang menjembatani lulusan SMKN 2 Cimahi dengan perusahaan-perusahaan yang membutuhkan tenaga kerja kompeten.'],
                ['num' => '02', 'tag' => 'LAYANAN', 'title' => 'Pelayanan tamatan yang terstruktur', 'desc' => 'Memberikan layanan kepada tamatan sesuai dengan tugas dan fungsi masing-masing seksi yang ada dalam BKK.'],
                ['num' => '03', 'tag' => 'PELATIHAN', 'title' => 'Pelatihan sesuai kebutuhan industri', 'desc' => 'Sebagai wadah pelatihan tamatan yang sesuai dengan permintaan pencari kerja, memastikan kompetensi siap pakai.'],
                ['num' => '04', 'tag' => 'WIRAUSAHA', 'title' => 'Menanamkan jiwa wirausaha', 'desc' => 'Sebagai wadah untuk menanamkan jiwa wirausaha bagi tamatan melalui pelatihan kewirausahaan dan pendampingan.'],
            ],
            'perusahaan' => [
                'PT Denso', 'PT Ateja', 'PT Medion', 'PT DMK',
                'PT Alkindo', 'PT Essei Perbama', 'Pusdatin Kemendikbud',
                'PT Patopo', 'PT CGNPM', 'PT BUMA', 'PT Bina Muda',
            ],
            'lowongan' => [
                ['title' => 'PT Caltesys — Lowongan Operator Produksi', 'status' => 'AKTIF', 'category' => 'Lowongan'],
                ['title' => 'PT Perusahaan Industri Ceres — Operator Mesin Produksi', 'status' => 'AKTIF', 'category' => 'Lowongan'],
                ['title' => 'PT Bukit Makmur Mandiri Utama — Multiple Positions', 'status' => 'AKTIF', 'category' => 'Lowongan'],
            ],
        ]);
    }
}
