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
        return 'Admin Management';
    }

    public function getHeading(): string
    {
        return 'Admin Management';
    }

    public function getSubheading(): ?string
    {
        return 'Kelola pengguna admin dan izinnya';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Create New Admin')
                ->icon('heroicon-m-plus')
                ->visible(fn() => Auth::user()->jabatan === 'super_admin'),
        ];
    }
}
