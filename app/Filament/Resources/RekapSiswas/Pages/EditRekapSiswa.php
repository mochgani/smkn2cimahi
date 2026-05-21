<?php

namespace App\Filament\Resources\RekapSiswas\Pages;

use App\Filament\Resources\RekapSiswas\RekapSiswaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRekapSiswa extends EditRecord
{
    protected static string $resource = RekapSiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
