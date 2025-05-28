<?php

namespace App\Filament\Resources\GalleryResource\Pages;

use App\Filament\Resources\GalleryResource;
use App\Models\Gallery;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGallery extends CreateRecord
{
    protected static string $resource = GalleryResource::class;
    protected static ?string $title = 'Tambah Gallery Baru';

    protected function handleRecordCreation(array $data): Gallery
    {
        $records = [];
        foreach ($data['path'] as $path) {
            $records[] = Gallery::create(['path' => $path]);
        }
        return $records[0];
    }
}
