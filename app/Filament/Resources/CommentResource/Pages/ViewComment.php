<?php

namespace App\Filament\Resources\CommentResource\Pages;

use App\Filament\Resources\CommentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewComment extends ViewRecord
{
    protected static string $resource = CommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('visit_page')
                ->label('Lihat Halaman Website')
                ->icon('heroicon-o-external-link')
                ->color('gray')
                ->url(fn (): string => $this->record->page_url)
                ->openUrlInNewTab(),
        ];
    }
}
