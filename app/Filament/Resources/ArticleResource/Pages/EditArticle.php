<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->requiresConfirmation(),
            Actions\Action::make('preview')
                ->label('Preview')
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->url(fn ($record) => route('articles.show', $record->slug), shouldOpenInNewTab: true)
                ->visible(fn ($record) => $record->status === 'published'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Article updated successfully';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Auto-set published_at if status changes to published and no date is set
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        // Clear published_at if status is not published
        if ($data['status'] !== 'published') {
            $data['published_at'] = null;
        }

        return $data;
    }
}
