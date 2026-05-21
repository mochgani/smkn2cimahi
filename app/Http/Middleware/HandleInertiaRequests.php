<?php

namespace App\Http\Middleware;

use App\Models\Kompetensi;
use App\Models\KontakSetting;
use App\Models\MenuItem;
use App\Models\SchoolSetting;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
            'navigation' => fn () => $this->buildNavigation(),
            'kontakSetting' => fn () => KontakSetting::instance()->only([
                'maps_address_short',
                'maps_address_full',
                'kanal',
                'social',
            ]),
            'schoolSetting' => fn () => SchoolSetting::instance()->only([
                'school_name',
                'tagline',
                'logo',
                'tahun_berdiri',
                'nss',
                'npsn',
                'copyright',
            ]),
        ];
    }

    private function buildNavigation(): array
    {
        $topLevel = MenuItem::topLevel()
            ->active()
            ->with(['children' => fn ($q) => $q->orderBy('display_order')])
            ->orderBy('display_order')
            ->get();

        $kompetensiList = null;

        return $topLevel->map(function (MenuItem $item) use (&$kompetensiList) {
            $children = [];

            if ($item->type === 'kompetensi_list') {
                $kompetensiList ??= Kompetensi::active()
                    ->orderBy('display_order')
                    ->get()
                    ->map(fn (Kompetensi $k) => [
                        'label' => $k->name,
                        'url'   => '/kompetensi/'.$k->slug,
                    ])
                    ->all();
                $children = $kompetensiList;
            } else {
                $children = $item->children->map(fn (MenuItem $c) => [
                    'label' => $c->label,
                    'url'   => $c->url,
                ])->all();
            }

            return [
                'label'    => $item->label,
                'url'      => $item->url,
                'children' => $children,
            ];
        })->all();
    }
}
