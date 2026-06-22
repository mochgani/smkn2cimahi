<?php

namespace App\Filament\Resources\KurikulumTeachingFactory\Pages;

use App\Filament\Resources\KurikulumTeachingFactory\KurikulumTeachingFactoryResource;
use App\Models\KurikulumTeachingFactory;
use Filament\Resources\Pages\EditRecord;

class EditKurikulumTeachingFactory extends EditRecord
{
    protected static string $resource = KurikulumTeachingFactoryResource::class;

    public function mount(int|string $record = null): void
    {
        parent::mount(KurikulumTeachingFactory::instance()->getKey());
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
