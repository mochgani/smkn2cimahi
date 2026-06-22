<?php

namespace App\Filament\Resources\KurikulumTentang\Pages;

use App\Filament\Resources\KurikulumTentang\KurikulumTentangResource;
use App\Models\KurikulumTentang;
use Filament\Resources\Pages\EditRecord;

class EditKurikulumTentang extends EditRecord
{
    protected static string $resource = KurikulumTentangResource::class;

    public function mount(int|string|null $record = null): void
    {
        parent::mount(KurikulumTentang::instance()->getKey());
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
