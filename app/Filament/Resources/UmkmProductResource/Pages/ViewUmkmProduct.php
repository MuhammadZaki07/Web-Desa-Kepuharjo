<?php

namespace App\Filament\Resources\UmkmProductResource\Pages;

use App\Filament\Resources\UmkmProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUmkmProduct extends ViewRecord
{
    protected static string $resource = UmkmProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->color('warning'),
            Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Detail Produk UMKM';
    }
}
