<?php

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Filament\Resources\OrganizationResource;
use App\Models\Organization;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
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
        Log::info('Data before create:', $data);
        if (Organization::where('type', $data['type'])->exists()) {
            throw ValidationException::withMessages([
                'type' => "Data {$data['type']} sudah ada. Tidak dapat menambah lebih dari satu data untuk setiap jenis organisasi."
            ]);
        }

        if (isset($data['programs'])) {
            $data['programs'] = array_column($data['programs'], 'name');
        }

        if (isset($data['activities'])) {
            $data['activities'] = array_column($data['activities'], 'name');
        }

        unset($data['gallery_photos']);

        Log::info('Data after transformation:', $data);

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        try {
            Log::info('Creating record with data:', $data);
            $record = static::getModel()::create($data);
            Log::info('Record created successfully:', $record->toArray());
            return $record;
        } catch (\Exception $e) {
            Log::error('Error creating record:', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            throw $e;
        }
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Organisasi berhasil ditambahkan';
    }
}
