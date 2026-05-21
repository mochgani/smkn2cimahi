<?php

namespace App\Filament\Resources\RekapSiswas\Pages;

use App\Filament\Resources\RekapSiswas\RekapSiswaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRekapSiswas extends ListRecords
{
    protected static string $resource = RekapSiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
