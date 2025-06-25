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
    if (!isset($data['type'])) {
        throw ValidationException::withMessages([
            'type' => 'Jenis organisasi tidak diketahui.',
        ]);
    }

    // Validasi duplikat
    if (Organization::where('type', $data['type'])->exists()) {
        throw ValidationException::withMessages([
            'type' => "Organisasi dengan tipe \"{$data['type']}\" sudah ada.",
        ]);
    }

    Log::info('Data sebelum create (mutated): ' . json_encode($data));
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
