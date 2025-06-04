<?php

namespace App\Filament\Resources\ProfileDesaResource\Pages;

use App\Filament\Resources\ProfileDesaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateProfileDesa extends CreateRecord
{
    protected static string $resource = ProfileDesaResource::class;

    public function getTitle(): string
    {
        return 'Buat Profile Desa';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Profile Desa Berhasil Dibuat')
            ->body('Profile desa telah berhasil dibuat dan dapat dikelola.');
    }

protected function mutateFormDataBeforeCreate(array $data): array
{
    if (isset($data['misi']) && is_array($data['misi'])) {
        $data['misi'] = array_filter($data['misi'], function ($item) {
            return !empty($item['poin_misi']);
        });
    }

    return $data;
}
}
