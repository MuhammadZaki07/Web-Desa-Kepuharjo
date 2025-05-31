<?php

namespace App\Filament\Resources\ProfileDesaResource\Pages;

use App\Filament\Resources\ProfileDesaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfileDesas extends ListRecords
{
    protected static string $resource = ProfileDesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => $this->getResource()::canCreate()),
        ];
    }

    public function getTitle(): string
    {
        return 'Profile Desa';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // Add widgets if needed
        ];
    }
}
