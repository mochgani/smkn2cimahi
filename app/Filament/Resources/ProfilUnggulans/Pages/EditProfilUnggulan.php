<?php

namespace App\Filament\Resources\ProfilUnggulans\Pages;

use App\Filament\Resources\ProfilUnggulans\ProfilUnggulanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProfilUnggulan extends EditRecord
{
    protected static string $resource = ProfilUnggulanResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
