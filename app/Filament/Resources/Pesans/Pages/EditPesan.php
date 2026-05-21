<?php

namespace App\Filament\Resources\Pesans\Pages;

use App\Filament\Resources\Pesans\PesanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPesan extends EditRecord
{
    protected static string $resource = PesanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
