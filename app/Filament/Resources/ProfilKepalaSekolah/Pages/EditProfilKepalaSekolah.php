<?php

namespace App\Filament\Resources\ProfilKepalaSekolah\Pages;

use App\Filament\Resources\ProfilKepalaSekolah\ProfilKepalaSekolahResource;
use App\Models\ProfilKepalaSekolah;
use Filament\Resources\Pages\EditRecord;

class EditProfilKepalaSekolah extends EditRecord
{
    protected static string $resource = ProfilKepalaSekolahResource::class;

    public function mount(int|string $record = null): void
    {
        parent::mount(ProfilKepalaSekolah::instance()->getKey());
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
