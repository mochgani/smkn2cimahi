<?php

namespace App\Filament\Resources\SaranaKejuruan\Pages;

use App\Filament\Resources\SaranaKejuruan\SaranaKejuruanResource;
use App\Models\SaranaKejuruan;
use Filament\Resources\Pages\EditRecord;

class EditSaranaKejuruan extends EditRecord
{
    protected static string $resource = SaranaKejuruanResource::class;

    public function mount(int|string|null $record = null): void
    {
        parent::mount(SaranaKejuruan::instance()->getKey());
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
