<?php

namespace App\Filament\Resources\UmkmProductResource\Pages;

use App\Filament\Resources\UmkmProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUmkmProduct extends EditRecord
{
    protected static string $resource = UmkmProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->color('info'),
            Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Edit Produk UMKM';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Produk UMKM berhasil diperbarui!';
    }
}

