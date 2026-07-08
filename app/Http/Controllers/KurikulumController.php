<?php

namespace App\Http\Controllers;

use App\Models\KurikulumTentang;
use App\Models\KurikulumStruktur;
use App\Models\KurikulumMitra;
use App\Models\KurikulumTeachingFactory;
use App\Models\KurikulumSertifikasiPkl;
use App\Models\KurikulumKalender;
use App\Models\Kompetensi;
use App\Support\GoogleCalendar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class KurikulumController extends Controller
{
    public function programKeahlian(): Response
    {
        $programs = Kompetensi::active()
            ->orderBy('display_order')
            ->get()
            ->map(fn (Kompetensi $k, int $i) => [
                'slug'       => $k->slug,
                'code'       => $k->code,
                'name'       => $k->name,
                'tag'        => $k->tag,
                'short_desc' => $k->short_desc,
                'lead'       => $k->lead,
                'logo_image' => $k->logo_image ? '/storage/' . $k->logo_image : null,
                'num'        => 'P-' . str_pad($i + 1, 2, '0', STR_PAD_LEFT),
            ])
            ->all();

        return Inertia::render('Kurikulum/ProgramKeahlian', [
            'programs' => $programs,
        ]);
    }

    public function struktur(): Response
    {
        $data = KurikulumStruktur::instance();

        return Inertia::render('Kurikulum/Struktur', [
            'struktur' => [
                'title'      => $data->title,
                'lead'       => $data->lead,
                'phases'     => $data->phases     ?? [],
                'groups'     => $data->groups     ?? [],
                'allocation' => $data->allocation ?? [],
            ],
        ]);
    }

    public function kelasKerjaSama(): Response
    {
        $mitras = KurikulumMitra::active()
            ->orderBy('display_order')
            ->get()
            ->map(fn (KurikulumMitra $m) => [
                'id'    => $m->id,
                'nama'  => $m->nama,
                'field' => $m->field,
                'desc'  => $m->desc,
                'tags'  => $m->tags ?? [],
                'logo'  => $m->logo ? '/storage/' . $m->logo : null,
            ])
            ->all();

        return Inertia::render('Kurikulum/KelasKerjaSama', [
            'mitras' => $mitras,
        ]);
    }

    public function tentang(): Response
    {
        $data = KurikulumTentang::instance();

        return Inertia::render('Kurikulum/Tentang', [
            'kurikulum' => [
                'title'          => $data->title,
                'lead'           => $data->lead,
                'kurikulum_nama' => $data->kurikulum_nama,
                'pendekatan'     => $data->pendekatan,
                'porsi_praktik'  => $data->porsi_praktik,
                'jumlah_mitra'   => $data->jumlah_mitra,
                'jumlah_program' => Kompetensi::active()->count(),
                'stats'          => $data->stats ?? [],
                'filosofi'       => $data->filosofi ?? [],
            ],
        ]);
    }

    public function teachingFactory(): Response
    {
        $data = KurikulumTeachingFactory::instance();

        return Inertia::render('Kurikulum/TeachingFactory', [
            'tefa' => [
                'title'     => $data->title,
                'lead'      => $data->lead,
                'tagline'   => $data->tagline,
                'about'     => $data->about,
                'produk'    => $data->produk    ?? [],
                'fasilitas' => $data->fasilitas ?? [],
                'stats'     => $data->stats     ?? [],
            ],
        ]);
    }

    public function sertifikasiPkl(): Response
    {
        $data = KurikulumSertifikasiPkl::instance();

        return Inertia::render('Kurikulum/SertifikasiPkl', [
            'data' => [
                'title'        => $data->title,
                'lead'         => $data->lead,
                'sertifikasi'  => $data->sertifikasi  ?? [],
                'pkl_deskripsi'=> $data->pkl_deskripsi,
                'pkl_durasi'   => $data->pkl_durasi,
                'pkl_min_nilai'=> $data->pkl_min_nilai,
                'alur_pkl'     => $data->alur_pkl      ?? [],
            ],
        ]);
    }

    public function kalender(Request $request): Response
    {
        $data = KurikulumKalender::instance();

        $year  = (int) $request->integer('year', now('Asia/Jakarta')->year);
        $month = (int) $request->integer('month', now('Asia/Jakarta')->month);

        // Guard supaya tidak bisa dipakai untuk request tanggal ekstrem/invalid
        $current = Carbon::create($year, $month, 1)->startOfMonth();
        $year    = $current->year;
        $month   = $current->month;

        $result = GoogleCalendar::eventsForMonth($data->calendar_id, $data->api_key, $year, $month);

        $prev = $current->clone()->subMonth();
        $next = $current->clone()->addMonth();

        return Inertia::render('Kurikulum/Kalender', [
            'kalender' => [
                'title'      => $data->title,
                'lead'       => $data->lead,
                'embed_url'  => $data->embed_url,
                'public_url' => $data->public_url,
                'catatan'    => $data->catatan,
                'has_source' => (bool) $data->calendar_id || (bool) $data->embed_url,
            ],
            'events'        => $result['events'],
            'eventsByDate'  => $result['byDate'],
            'calendarError' => $result['error'],
            'month'         => [
                'year'      => $year,
                'month'     => $month,
                'label'     => $current->locale('id')->translatedFormat('F Y'),
                'gridStart' => $current->clone()->startOfWeek(Carbon::SUNDAY)->toDateString(),
                'gridEnd'   => $current->clone()->endOfMonth()->endOfWeek(Carbon::SATURDAY)->toDateString(),
                'prevYear'  => $prev->year,
                'prevMonth' => $prev->month,
                'nextYear'  => $next->year,
                'nextMonth' => $next->month,
                'todayYear' => now('Asia/Jakarta')->year,
                'todayMonth'=> now('Asia/Jakarta')->month,
            ],
        ]);
    }
}
