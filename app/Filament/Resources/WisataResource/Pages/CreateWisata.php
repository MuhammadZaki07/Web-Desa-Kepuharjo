<?php

namespace App\Filament\Resources\WisataResource\Pages;

use App\Filament\Resources\WisataResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateWisata extends CreateRecord
{
    protected static string $resource = WisataResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title('Wisata berhasil dibuat')
            ->body('Data wisata telah berhasil disimpan.');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set default values
        $data['views'] = 0;

        return $data;
    }
}
