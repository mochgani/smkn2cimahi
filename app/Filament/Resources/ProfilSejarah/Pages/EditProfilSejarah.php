<?php

namespace App\Filament\Resources\ProfilSejarah\Pages;

use App\Filament\Resources\ProfilSejarah\ProfilSejarahResource;
use App\Models\ProfilSejarah;
use Filament\Resources\Pages\EditRecord;

class EditProfilSejarah extends EditRecord
{
    protected static string $resource = ProfilSejarahResource::class;

    public function mount(int|string $record = null): void
    {
        parent::mount(ProfilSejarah::instance()->getKey());
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
