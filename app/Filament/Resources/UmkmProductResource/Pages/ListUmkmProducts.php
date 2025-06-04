<?php

namespace App\Filament\Resources\UmkmProductResource\Pages;

use App\Filament\Resources\UmkmProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Concerns\ExposesTableToWidgets;

class ListUmkmProducts extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = UmkmProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Produk')
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return UmkmProductResource::getWidgets();
    }

    public function getTitle(): string
    {
        return 'Produk UMKM';
    }
}
