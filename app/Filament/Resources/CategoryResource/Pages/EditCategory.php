<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

   protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Delete Category')
                ->modalDescription('Are you sure you want to delete this category? This action cannot be undone.')
                ->modalSubmitActionLabel('Yes, delete it')
                ->before(function () {
                    if ($this->record->articles()->exists()) {
                        Notification::make()
                            ->title('Cannot Delete Category')
                            ->body('This category is being used by articles and cannot be deleted.')
                            ->danger()
                            ->send();

                        return false;
                    }

                    if ($this->record->umkmProducts()->exists()) {
                        Notification::make()
                            ->title('Cannot Delete Category')
                            ->body('This category is being used by UMKM products and cannot be deleted.')
                            ->danger()
                            ->send();

                        return false;
                    }

                    if ($this->record->wisata()->exists()) {
                        Notification::make()
                            ->title('Cannot Delete Category')
                            ->body('This category is being used by tourism data and cannot be deleted.')
                            ->danger()
                            ->send();

                        return false;
                    }
                })
                ->visible(fn () => CategoryResource::canDeleteCategory($this->record)), // Hide if cannot delete
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Category updated successfully';
    }
}
