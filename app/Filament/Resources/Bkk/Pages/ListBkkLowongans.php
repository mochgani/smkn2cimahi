<?php

namespace App\Filament\Resources\Bkk\Pages;

use App\Filament\Resources\Bkk\BkkLowonganResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBkkLowongans extends ListRecords
{
    protected static string $resource = BkkLowonganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
