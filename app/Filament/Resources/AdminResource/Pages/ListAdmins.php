<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListAdmins extends ListRecords
{
    protected static string $resource = AdminResource::class;
    public function getTitle(): string
    {
        return 'Daftar Admin';
    }


    protected function getHeaderActions(): array
    {
        if (Auth::user()->jabatan === 'super_admin') {
            return [
                Actions\CreateAction::make(),
            ];
        }

        return [];
    }
}
