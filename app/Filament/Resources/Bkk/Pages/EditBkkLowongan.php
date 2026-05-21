<?php

namespace App\Filament\Resources\Bkk\Pages;

use App\Filament\Resources\Bkk\BkkLowonganResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBkkLowongan extends EditRecord
{
    protected static string $resource = BkkLowonganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
