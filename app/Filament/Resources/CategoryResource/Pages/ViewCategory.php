<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ColorEntry;
use Filament\Notifications\Notification;

class ViewCategory extends ViewRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
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
                ->visible(fn() => CategoryResource::canDeleteCategory($this->record)), // Hide if cannot delete
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Category Details')
                    ->schema([
                        TextEntry::make('name')
                            ->size('lg')
                            ->weight('bold'),

                        ColorEntry::make('color'),

                        TextEntry::make('articles_count')
                            ->label('Total Articles')
                            ->state(fn($record) => $record->articles()->count())
                            ->badge(),

                        TextEntry::make('published_articles_count')
                            ->label('Published Articles')
                            ->state(fn($record) => $record->publishedArticles()->count())
                            ->badge()
                            ->color('success'),

                        TextEntry::make('created_at')
                            ->dateTime(),

                        TextEntry::make('updated_at')
                            ->dateTime(),
                    ])
                    ->columns(2),
            ]);
    }
}
