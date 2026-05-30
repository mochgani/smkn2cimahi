<?php

namespace App\Filament\Resources\ProfilUnggulans\Pages;

use App\Filament\Resources\ProfilUnggulans\ProfilUnggulanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProfilUnggulans extends ListRecords
{
    protected static string $resource = ProfilUnggulanResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
