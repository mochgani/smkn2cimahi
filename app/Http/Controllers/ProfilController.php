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
                'video_embed_url'   => $this->youtubeEmbed($s->video_youtube_url),
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

    private function youtubeEmbed(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/))([A-Za-z0-9_-]{11})~', $url, $m)) {
            return 'https://www.youtube.com/embed/'.$m[1];
        }

        return null;
    }

    public function sekolah(): Response
    {
        return Inertia::render('Profil/Sekolah', [
            'unggulan' => [
                ['num' => '01', 'tag' => 'KELAS INDUSTRI', 'title' => 'BUMA School', 'desc' => 'Kerja sama dengan PT Bukit Makmur Mandiri Utama (BUMA), perusahaan pertambangan batu bara untuk mempersiapkan lulusan siap kerja di industri tambang.'],
                ['num' => '02', 'tag' => 'KELAS INDUSTRI', 'title' => 'Ayena Studio', 'desc' => 'Kolaborasi dengan studio animasi profesional untuk pengembangan kompetensi siswa di industri animasi dan kreatif.'],
                ['num' => '03', 'tag' => 'KEWIRAUSAHAAN', 'title' => 'Cimahi Markerspace', 'desc' => 'Program kewirausahaan digital di bidang desain yang membentuk siswa menjadi wirausahawan kreatif dan mandiri.'],
                ['num' => '04', 'tag' => 'TEFA', 'title' => 'Teaching Factory', 'desc' => 'Sistem pembelajaran berbasis produksi dan simulasi dunia kerja, memberikan pengalaman langsung kepada siswa layaknya bekerja di industri sungguhan.'],
            ],
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
