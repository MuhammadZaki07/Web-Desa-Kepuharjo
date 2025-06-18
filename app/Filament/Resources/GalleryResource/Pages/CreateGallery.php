<?php

namespace App\Filament\Resources\GalleryResource\Pages;

use App\Filament\Resources\GalleryResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateGallery extends CreateRecord
{
    protected static string $resource = GalleryResource::class;

    public function getTitle(): string
    {
        return 'Buat Galeri Baru';
    }

    public function getHeading(): string
    {
        return 'Buat Galeri Baru';
    }

    public function getSubheading(): ?string
    {
        return 'Tambahkan galeri foto untuk kegiatan desa';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);

            $originalSlug = $data['slug'];
            $counter = 1;

            while (static::getResource()::getModel()::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
