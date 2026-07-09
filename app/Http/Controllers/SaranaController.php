<?php

namespace App\Http\Controllers;

use App\Models\SaranaKejuruan;
use App\Models\SaranaLainnya;
use App\Models\SaranaNonKejuruan;
use Inertia\Inertia;
use Inertia\Response;

class SaranaController extends Controller
{
    public function nonKejuruan(): Response
    {
        $data = SaranaNonKejuruan::instance();

        return Inertia::render('Sarana/NonKejuruan', [
            'sarana' => [
                'title'  => $data->title,
                'lead'   => $data->lead,
                'gedung' => $data->gedung ?? [],
            ],
        ]);
    }

    public function kejuruan(): Response
    {
        $data = SaranaKejuruan::instance();

        return Inertia::render('Sarana/Kejuruan', [
            'sarana' => [
                'title'  => $data->title,
                'lead'   => $data->lead,
                'groups' => $data->groups ?? [],
            ],
        ]);
    }

    public function lainnya(): Response
    {
        $data = SaranaLainnya::instance();

        return Inertia::render('Sarana/Lainnya', [
            'sarana' => [
                'title' => $data->title,
                'lead'  => $data->lead,
                'items' => $data->items ?? [],
            ],
        ]);
    }
}
