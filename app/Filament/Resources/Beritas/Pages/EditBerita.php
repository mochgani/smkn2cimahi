<?php

namespace App\Filament\Resources\Beritas\Pages;

use App\Filament\Resources\Beritas\BeritaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBerita extends EditRecord
{
    protected static string $resource = BeritaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $user = auth()->user();

        if ($user?->isSuperAdmin()) {
            // Super admin publish via form = otomatis approved
            if (! empty($data['is_published'])) {
                $data['approval_status'] = 'approved';
                $data['approved_by']     = $user->id;
                $data['approved_at']     = now();
            } elseif (($data['approval_status'] ?? '') !== 'rejected') {
                $data['approval_status'] = 'draft';
            }
        }

        return $data;
    }
}
