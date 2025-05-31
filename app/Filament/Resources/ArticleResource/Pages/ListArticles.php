<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Article')
                ->icon('heroicon-o-plus'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Articles')
                ->badge(ArticleResource::getModel()::count()),

            'published' => Tab::make('Published')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'published'))
                ->badge(ArticleResource::getModel()::where('status', 'published')->count())
                ->icon('heroicon-o-eye'),

            'draft' => Tab::make('Draft')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'draft'))
                ->badge(ArticleResource::getModel()::where('status', 'draft')->count())
                ->icon('heroicon-o-pencil-square'),

            'archived' => Tab::make('Archived')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'archived'))
                ->badge(ArticleResource::getModel()::where('status', 'archived')->count())
                ->icon('heroicon-o-archive-box'),

            'my_articles' => Tab::make('My Articles')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', Auth::user()->id))
                ->badge(ArticleResource::getModel()::where('user_id', Auth::user()->id)->count())
                ->icon('heroicon-o-user'),
        ];
    }
}
