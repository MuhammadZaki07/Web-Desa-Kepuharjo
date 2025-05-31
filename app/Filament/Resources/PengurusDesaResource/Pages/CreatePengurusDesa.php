<?php

namespace App\Filament\Resources\PengurusDesaResource\Pages;

use App\Filament\Resources\PengurusDesaResource;
use App\Models\PengurusDesa;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePengurusDesa extends CreateRecord
{
    protected static string $resource = PengurusDesaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Validate unique position before create
        if (!PengurusDesa::validateJabatanUnik($data['jabatan'], $data['is_wakil'])) {
            Notification::make()
                ->title('Gagal Membuat Pengurus')
                ->body('Jabatan ini sudah diisi oleh pengurus lain yang masih aktif.')
                ->danger()
                ->send();

            $this->halt();
        }

        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Pengurus Berhasil Ditambahkan')
            ->body('Data pengurus desa telah berhasil disimpan.');
    }
}
