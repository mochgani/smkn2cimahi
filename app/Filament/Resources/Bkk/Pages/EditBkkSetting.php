<?php

namespace App\Filament\Resources\Bkk\Pages;

use App\Filament\Resources\Bkk\BkkSettingResource;
use App\Models\BkkSetting;
use Filament\Resources\Pages\EditRecord;

class EditBkkSetting extends EditRecord
{
    protected static string $resource = BkkSettingResource::class;

    public function mount(int|string $record = null): void
    {
        parent::mount(BkkSetting::instance()->getKey());
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['perusahaan'] = collect($data['perusahaan'] ?? [])
            ->map(fn ($v) => is_string($v) ? ['name' => $v] : $v)
            ->all();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['perusahaan'] = collect($data['perusahaan'] ?? [])
            ->pluck('name')
            ->filter()
            ->values()
            ->all();

        return $data;
    }
}
