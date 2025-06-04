<?php

namespace App\Filament\Resources\UmkmProductResource\Pages;

use App\Filament\Resources\UmkmProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUmkmProduct extends CreateRecord
{
    protected static string $resource = UmkmProductResource::class;

    public function getTitle(): string
    {
        return 'Tambah Produk UMKM';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Produk UMKM berhasil ditambahkan!';
    }
}
