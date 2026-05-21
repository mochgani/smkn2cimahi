<?php

namespace App\Filament\Resources\ProfilVisiMisi\Pages;

use App\Filament\Resources\ProfilVisiMisi\ProfilVisiMisiResource;
use App\Models\ProfilVisiMisi;
use Filament\Resources\Pages\EditRecord;

class EditProfilVisiMisi extends EditRecord
{
    protected static string $resource = ProfilVisiMisiResource::class;

    public function mount(int|string $record = null): void
    {
        parent::mount(ProfilVisiMisi::instance()->getKey());
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
        $data['misi']   = collect($data['misi'] ?? [])->map(fn ($v) => ['text' => $v])->all();
        $data['tujuan'] = collect($data['tujuan'] ?? [])->map(fn ($v) => ['text' => $v])->all();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['misi']   = collect($data['misi'] ?? [])->pluck('text')->filter()->values()->all();
        $data['tujuan'] = collect($data['tujuan'] ?? [])->pluck('text')->filter()->values()->all();

        return $data;
    }
}
