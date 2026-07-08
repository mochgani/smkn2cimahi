<?php

namespace App\Filament\Widgets;

use App\Models\Berita;
use Filament\Widgets\ChartWidget;

class TopBeritaViewsChart extends ChartWidget
{
    protected ?string $heading = 'Berita Paling Banyak Dibaca';

    protected ?string $description = 'Top 10 berita berdasarkan jumlah pembaca (all-time).';

    protected int|string|array $columnSpan = 'full';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $user = auth()->user();

        $query = Berita::query()->where('views', '>', 0);

        if ($user && ! $user->isSuperAdmin() && ! $user->isKepalaSekolah() && ! $user->isManajemenMutu()) {
            if ($user->hasRole('kompetensi') && $user->kompetensi_id) {
                $query->where('kompetensi_id', $user->kompetensi_id);
            } elseif ($user->hasRole('divisi') && $user->divisi_id) {
                $query->where('divisi_id', $user->divisi_id);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        $topBerita = $query->orderByDesc('views')->take(10)->get(['title', 'views']);

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Dibaca',
                    'data' => $topBerita->pluck('views')->all(),
                    'backgroundColor' => '#0d6e3f',
                ],
            ],
            'labels' => $topBerita->map(fn (Berita $b) => \Illuminate\Support\Str::limit($b->title, 40))->all(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'scales' => [
                'x' => [
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
        ];
    }
}
