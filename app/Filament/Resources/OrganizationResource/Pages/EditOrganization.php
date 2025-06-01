<?php

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Filament\Resources\OrganizationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrganization extends EditRecord
{
    protected static string $resource = OrganizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Transform arrays to repeater format for editing
        if (isset($data['programs']) && is_array($data['programs'])) {
            $data['programs'] = array_map(fn($item) => ['name' => $item], $data['programs']);
        }

        if (isset($data['activities']) && is_array($data['activities'])) {
            $data['activities'] = array_map(fn($item) => ['name' => $item], $data['activities']);
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Transform simple repeater back to array format
        if (isset($data['programs'])) {
            $data['programs'] = array_column($data['programs'], 'name');
        }

        if (isset($data['activities'])) {
            $data['activities'] = array_column($data['activities'], 'name');
        }

        // Remove gallery_photos from data as it's handled in afterStateUpdated
        unset($data['gallery_photos']);

        return $data;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Organisasi berhasil diperbarui';
    }
}
