<?php

namespace App\Filament\Resources\SaranaNonKejuruan\Pages;

use App\Filament\Resources\SaranaNonKejuruan\SaranaNonKejuruanResource;
use App\Models\SaranaNonKejuruan;
use Filament\Resources\Pages\EditRecord;

class EditSaranaNonKejuruan extends EditRecord
{
    protected static string $resource = SaranaNonKejuruanResource::class;

    public function mount(int|string|null $record = null): void
    {
        parent::mount(SaranaNonKejuruan::instance()->getKey());
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
