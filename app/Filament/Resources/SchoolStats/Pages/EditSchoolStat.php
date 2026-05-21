<?php

namespace App\Filament\Resources\SchoolStats\Pages;

use App\Filament\Resources\SchoolStats\SchoolStatResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSchoolStat extends EditRecord
{
    protected static string $resource = SchoolStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
