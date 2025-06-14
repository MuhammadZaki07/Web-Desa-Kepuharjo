<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Support\Enums\FontWeight;

class ViewArticle extends ViewRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make()
                ->requiresConfirmation(),
            Actions\Action::make('preview')
                ->label('Preview')
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->url(fn ($record) => route('detail-blog', $record->slug),  true)
                ->visible(fn ($record) => $record->status === 'published'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Article Information')
                    ->schema([
                        ImageEntry::make('featured_image')
                            ->disk('public')
                            ->height(200)
                            ->width('100%')
                            ->extraAttributes(['style' => 'object-fit: cover; border-radius: 8px;'])
                            ->visible(fn ($record) => !empty($record->featured_image)),

                        TextEntry::make('title')
                            ->size('xl')
                            ->weight(FontWeight::Bold),

                        TextEntry::make('slug')
                            ->badge()
                            ->color('gray')
                            ->copyable(),

                        TextEntry::make('excerpt')
                            ->prose()
                            ->placeholder('No excerpt provided'),

                        TextEntry::make('content')
                            ->prose()
                            ->html()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => 2]),

                Section::make('Article Details')
                    ->schema([
                        TextEntry::make('category.name')
                            ->badge()
                            ->color('primary'),

                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'draft' => 'gray',
                                'published' => 'success',
                                'archived' => 'warning',
                                default => 'gray',
                            }),

                        TextEntry::make('author.name')
                            ->icon('heroicon-o-user'),

                        TextEntry::make('viewers')
                            ->badge()
                            ->color('gray')
                            ->icon('heroicon-o-eye'),

                        TextEntry::make('reading_time')
                            ->suffix(' min read')
                            ->icon('heroicon-o-clock'),

                        TextEntry::make('published_at')
                            ->dateTime()
                            ->placeholder('Not published'),

                        TextEntry::make('created_at')
                            ->dateTime(),

                        TextEntry::make('updated_at')
                            ->dateTime(),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }
}
