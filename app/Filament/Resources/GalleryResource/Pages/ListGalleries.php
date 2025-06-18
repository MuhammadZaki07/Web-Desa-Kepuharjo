<?php

namespace App\Filament\Resources\GalleryResource\Pages;

use App\Filament\Resources\GalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGalleries extends ListRecords
{
    protected static string $resource = GalleryResource::class;

    public function getTitle(): string
    {
        return 'Galeri Desa';
    }

    public function getHeading(): string
    {
        return 'Galeri Desa';
    }

    public function getSubheading(): ?string
    {
        return 'Kelola foto dan dokumentasi kegiatan desa';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Galeri')
                ->icon('heroicon-m-plus'),
        ];
    }
}
