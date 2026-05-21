<?php

namespace App\Filament\Resources\SchoolSettings\Pages;

use App\Filament\Resources\SchoolSettings\SchoolSettingResource;
use App\Models\SchoolSetting;
use Filament\Resources\Pages\EditRecord;

class EditSchoolSetting extends EditRecord
{
    protected static string $resource = SchoolSettingResource::class;

    public function mount(int|string $record = null): void
    {
        parent::mount(SchoolSetting::instance()->getKey());
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
