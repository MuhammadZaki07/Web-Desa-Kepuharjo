<?php

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Filament\Resources\OrganizationResource;
use App\Models\Organization;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class CreateOrganization extends CreateRecord
{
    protected static string $resource = OrganizationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Validation untuk memastikan max 1 data per type
        if (Organization::where('type', $data['type'])->exists()) {
            throw ValidationException::withMessages([
                'type' => "Data {$data['type']} sudah ada. Tidak dapat menambah lebih dari satu data untuk setiap jenis organisasi."
            ]);
        }

        // Transform simple repeater to proper format
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

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Organisasi berhasil ditambahkan';
    }
}
