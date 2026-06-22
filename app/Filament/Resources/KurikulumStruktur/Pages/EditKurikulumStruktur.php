<?php

namespace App\Filament\Resources\KurikulumStruktur\Pages;

use App\Filament\Resources\KurikulumStruktur\KurikulumStrukturResource;
use App\Models\KurikulumStruktur;
use Filament\Resources\Pages\EditRecord;

class EditKurikulumStruktur extends EditRecord
{
    protected static string $resource = KurikulumStrukturResource::class;

    public function mount(int|string|null $record = null): void
    {
        parent::mount(KurikulumStruktur::instance()->getKey());
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
