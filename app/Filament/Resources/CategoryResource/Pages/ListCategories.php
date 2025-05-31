<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Category')
                ->icon('heroicon-o-plus'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Categories')
                ->badge(CategoryResource::getModel()::count()),

            'blogs' => Tab::make('Blogs')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'blogs'))
                ->badge(CategoryResource::getModel()::where('type', 'blogs')->count()),

            'umkm' => Tab::make('UMKM')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'umkm'))
                ->badge(CategoryResource::getModel()::where('type', 'umkm')->count()),

            'wisata' => Tab::make('Wisata')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'wisata'))
                ->badge(CategoryResource::getModel()::where('type', 'wisata')->count()),
        ];
    }
}
