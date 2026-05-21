<?php

namespace App\Filament\Resources\KontakSettings\Pages;

use App\Filament\Resources\KontakSettings\KontakSettingResource;
use App\Models\KontakSetting;
use Filament\Resources\Pages\EditRecord;

class EditKontakSetting extends EditRecord
{
    protected static string $resource = KontakSettingResource::class;

    public function mount(int|string $record = null): void
    {
        parent::mount(KontakSetting::instance()->getKey());
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
