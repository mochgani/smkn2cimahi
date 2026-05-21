<?php

namespace App\Filament\Resources\SchoolStats\Pages;

use App\Filament\Resources\SchoolStats\SchoolStatResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSchoolStats extends ListRecords
{
    protected static string $resource = SchoolStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
