<?php

namespace App\Filament\Resources\Beritas\Pages;

use App\Filament\Resources\Beritas\BeritaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBerita extends CreateRecord
{
    protected static string $resource = BeritaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();

        if (! $user) {
            return $data;
        }

        // Auto-assign scope untuk non-super_admin
        if (! $user->isSuperAdmin()) {
            if ($user->hasRole('kompetensi') && $user->kompetensi_id) {
                $data['kompetensi_id'] = $user->kompetensi_id;
                $data['divisi_id'] = null;
            } elseif ($user->hasRole('divisi') && $user->divisi_id) {
                $data['divisi_id'] = $user->divisi_id;
                $data['kompetensi_id'] = null;
            }
        }

        // Catat siapa yang input berita
        $data['created_by'] = $user->id;

        return $data;
    }
}
