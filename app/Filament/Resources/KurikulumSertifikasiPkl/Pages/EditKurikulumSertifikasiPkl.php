<?php

namespace App\Filament\Resources\KurikulumSertifikasiPkl\Pages;

use App\Filament\Resources\KurikulumSertifikasiPkl\KurikulumSertifikasiPklResource;
use App\Models\KurikulumSertifikasiPkl;
use Filament\Resources\Pages\EditRecord;

class EditKurikulumSertifikasiPkl extends EditRecord
{
    protected static string $resource = KurikulumSertifikasiPklResource::class;

    public function mount(int|string $record = null): void
    {
        parent::mount(KurikulumSertifikasiPkl::instance()->getKey());
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
