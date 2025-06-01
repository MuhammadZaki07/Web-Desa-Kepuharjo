<?php

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Filament\Resources\OrganizationResource;
use App\Models\Organization;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrganizations extends ListRecords
{
    protected static string $resource = OrganizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Organisasi')
                ->visible(fn () => Organization::count() < 2),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua')
                ->badge(Organization::count()),

            'pkk' => Tab::make('PKK')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'pkk'))
                ->badge(Organization::where('type', 'pkk')->count()),

            'karang_taruna' => Tab::make('Karang Taruna')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'karang_taruna'))
                ->badge(Organization::where('type', 'karang_taruna')->count()),
        ];
    }
}
