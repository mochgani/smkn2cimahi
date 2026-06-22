<?php

namespace App\Filament\Resources\KurikulumKalender\Pages;

use App\Filament\Resources\KurikulumKalender\KurikulumKalenderResource;
use App\Models\KurikulumKalender;
use Filament\Resources\Pages\EditRecord;

class EditKurikulumKalender extends EditRecord
{
    protected static string $resource = KurikulumKalenderResource::class;

    public function mount(int|string $record = null): void
    {
        parent::mount(KurikulumKalender::instance()->getKey());
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
