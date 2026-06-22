<?php

namespace App\Http\Middleware;

use App\Models\Kompetensi;
use App\Models\KontakSetting;
use App\Models\MenuItem;
use App\Models\SchoolSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    /**
     * Cache TTL untuk shared global data (1 jam).
     * Cache di-invalidate otomatis via observer saat data diupdate dari admin.
     */
    private const CACHE_TTL = 3600;

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
                'error'   => fn () => $request->session()->get('error'),
            ],
            // Inertia::lazy — props ini hanya dikirim saat full page load.
            // Partial reload (router.get with only: [...]) tidak akan
            // re-evaluate, menghemat query DB dan bandwidth.
            'navigation' => fn () => Cache::remember(
                'shared.navigation',
                self::CACHE_TTL,
                fn () => $this->buildNavigation()
            ),
            'kontakSetting' => fn () => Cache::remember(
                'shared.kontak_setting',
                self::CACHE_TTL,
                fn () => KontakSetting::instance()->only([
                    'maps_address_short',
                    'maps_address_full',
                    'kanal',
                    'social',
                ])
            ),
            'schoolSetting' => fn () => Cache::remember(
                'shared.school_setting',
                self::CACHE_TTL,
                fn () => SchoolSetting::instance()->only([
                    'school_name',
                    'tagline',
                    'logo',
                    'tahun_berdiri',
                    'nss',
                    'npsn',
                    'copyright',
                ])
            ),
        ];
    }

    private function buildNavigation(): array
    {
        $topLevel = MenuItem::topLevel()
            ->active()
            ->with(['children' => fn ($q) => $q
                ->active()
                ->with(['children' => fn ($q2) => $q2->active()->orderBy('display_order')])
                ->orderBy('display_order')
            ])
            ->orderBy('display_order')
            ->get();

        $kompetensiList = null;

        $mapped = $topLevel->map(function (MenuItem $item) use (&$kompetensiList) {
            // Topbar item — hanya label + url + children flat
            if ($item->location === 'topbar') {
                return [
                    'location' => 'topbar',
                    'label'    => $item->label,
                    'url'      => $item->url,
                    'children' => $item->children->map(fn (MenuItem $c) => [
                        'label' => $c->label,
                        'url'   => $c->url,
                    ])->all(),
                ];
            }

            // Mega menu — children adalah judul kolom, grandchildren adalah link
            if ($item->is_mega_menu) {
                return [
                    'location'     => 'navbar',
                    'label'        => $item->label,
                    'url'          => $item->url,
                    'is_mega_menu' => true,
                    'columns'      => $item->children->map(fn (MenuItem $col) => [
                        'title' => $col->label,
                        'links' => $col->children->map(fn (MenuItem $link) => [
                            'label' => $link->label,
                            'url'   => $link->url,
                        ])->all(),
                    ])->all(),
                ];
            }

            // Navbar biasa — dropdown atau kompetensi_list
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
                'location'     => 'navbar',
                'label'        => $item->label,
                'url'          => $item->url,
                'is_mega_menu' => false,
                'children'     => $children,
            ];
        });

        return [
            'topbar' => $mapped->where('location', 'topbar')->values()->all(),
            'navbar' => $mapped->where('location', 'navbar')->values()->all(),
        ];
    }
}
