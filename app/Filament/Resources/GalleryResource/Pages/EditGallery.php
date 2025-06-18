<?php

namespace App\Filament\Resources\GalleryResource\Pages;

use App\Filament\Resources\GalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditGallery extends EditRecord
{
    protected static string $resource = GalleryResource::class;

    public function getTitle(): string
    {
        return 'Edit Galeri: ' . $this->record->title;
    }

    public function getHeading(): string
    {
        return 'Edit Galeri';
    }

    public function getSubheading(): ?string
    {
        return 'Perbarui informasi dan gambar galeri';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Hapus Galeri')
                ->requiresConfirmation()
                ->modalHeading('Hapus Galeri')
                ->modalDescription('Apakah Anda yakin ingin menghapus galeri ini? Semua gambar akan ikut terhapus.')
                ->modalSubmitActionLabel('Ya, Hapus'),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['title']) && $data['title'] !== $this->record->title) {
            $slug = Str::slug($data['title']);
            $originalSlug = $slug;
            $counter = 1;

            while (static::getResource()::getModel()::where('slug', $slug)
                ->where('id', '!=', $this->record->id)
                ->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $data['slug'] = $slug;
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
