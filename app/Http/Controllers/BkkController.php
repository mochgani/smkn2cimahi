<?php

namespace App\Http\Controllers;

use App\Models\BkkLowongan;
use App\Models\BkkSetting;
use Inertia\Inertia;
use Inertia\Response;

class BkkController extends Controller
{
    public function index(): Response
    {
        $setting = BkkSetting::instance();

        return Inertia::render('HubunganIndustri/Bkk', [
            'about'      => $setting->about,
            'tujuan'     => $setting->tujuan ?? [],
            'perusahaan' => $setting->perusahaan ?? [],
            'lowongan'   => BkkLowongan::active()
                ->orderBy('display_order')
                ->get(['title', 'company', 'status', 'category', 'link'])
                ->all(),
        ]);
    }
}
