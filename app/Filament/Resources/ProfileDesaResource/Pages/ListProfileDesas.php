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
            Actions\CreateAction::make(),
        ];
    }
}
