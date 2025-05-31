<?php

namespace App\Filament\Resources\ProfileDesaResource\Pages;

use App\Filament\Resources\ProfileDesaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditProfileDesa extends EditRecord
{
    protected static string $resource = ProfileDesaResource::class;

    public function getTitle(): string
    {
        return 'Edit Profile Desa';
    }

    protected function getHeaderActions(): array
    {
      return [];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Profile Desa Berhasil Diperbarui')
            ->body('Perubahan pada profile desa telah berhasil disimpan.');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Process visi misi data
        if (isset($data['visi']) && is_array($data['visi'])) {
            $data['visi'] = array_filter($data['visi'], function ($item) {
                return !empty($item['poin_visi']);
            });
        }

        if (isset($data['misi']) && is_array($data['misi'])) {
            $data['misi'] = array_filter($data['misi'], function ($item) {
                return !empty($item['poin_misi']);
            });
        }

        return $data;
    }

    protected function afterSave(): void
    {
        cache()->forget('profile_desa');
    }
}
