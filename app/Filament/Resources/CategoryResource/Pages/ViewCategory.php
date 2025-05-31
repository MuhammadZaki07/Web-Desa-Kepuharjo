<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ColorEntry;

class ViewCategory extends ViewRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make()
                ->requiresConfirmation(),
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

                        TextEntry::make('slug')
                            ->badge()
                            ->color('gray')
                            ->copyable(),

                        TextEntry::make('type')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'blogs' => 'primary',
                                'umkm' => 'success',
                                'wisata' => 'warning',
                                default => 'gray',
                            }),

                        ColorEntry::make('color'),

                        TextEntry::make('description')
                            ->placeholder('No description provided'),

                        TextEntry::make('articles_count')
                            ->label('Total Articles')
                            ->state(fn ($record) => $record->articles()->count())
                            ->badge(),

                        TextEntry::make('published_articles_count')
                            ->label('Published Articles')
                            ->state(fn ($record) => $record->publishedArticles()->count())
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
