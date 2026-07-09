<?php

namespace App\Filament\Resources\SaranaLainnya\Pages;

use App\Filament\Resources\SaranaLainnya\SaranaLainnyaResource;
use App\Models\SaranaLainnya;
use Filament\Resources\Pages\EditRecord;

class EditSaranaLainnya extends EditRecord
{
    protected static string $resource = SaranaLainnyaResource::class;

    public function mount(int|string|null $record = null): void
    {
        parent::mount(SaranaLainnya::instance()->getKey());
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
