<?php

namespace App\Filament\Resources\Pesans\Pages;

use App\Filament\Resources\Pesans\PesanResource;
use Filament\Resources\Pages\ListRecords;

class ListPesans extends ListRecords
{
    protected static string $resource = PesanResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
