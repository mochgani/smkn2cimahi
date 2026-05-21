<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected ?string $assignRole = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->assignRole = $data['role'] ?? null;
        unset($data['role']);

        // Pastikan scope yang tidak relevan dikosongkan
        if ($this->assignRole !== 'kompetensi') {
            $data['kompetensi_id'] = null;
        }
        if ($this->assignRole !== 'divisi') {
            $data['divisi_id'] = null;
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        if ($this->assignRole) {
            $this->record->syncRoles([$this->assignRole]);
        }
    }
}
