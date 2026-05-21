<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected ?string $assignRole = null;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->before(function () {
                    if ($this->record->id === auth()->id()) {
                        $this->halt();
                    }
                }),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->assignRole = $data['role'] ?? null;
        unset($data['role']);

        if ($this->assignRole !== 'kompetensi') {
            $data['kompetensi_id'] = null;
        }
        if ($this->assignRole !== 'divisi') {
            $data['divisi_id'] = null;
        }

        return $data;
    }

    protected function afterSave(): void
    {
        if ($this->assignRole) {
            $this->record->syncRoles([$this->assignRole]);
        }
    }
}
