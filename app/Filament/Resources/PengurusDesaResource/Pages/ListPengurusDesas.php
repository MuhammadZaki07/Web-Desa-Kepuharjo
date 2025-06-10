<?php

namespace App\Filament\Resources\PengurusDesaResource\Pages;

use App\Filament\Resources\PengurusDesaResource;
use App\Models\PengurusDesa;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Exports\PengurusDesaExport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Actions\Action;


class ListPengurusDesas extends ListRecords
{
    protected static string $resource = PengurusDesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Pengurus')
                ->icon('heroicon-o-plus-circle')
                ->color('primary'),

            Action::make('export')
                ->label('Export Data')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    return Excel::download(new PengurusDesaExport, 'pengurus_desa.xlsx');
                })
                ->color('success'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua')
                ->badge(PengurusDesa::count())
                ->icon('heroicon-o-users'),

            'aktif' => Tab::make('Aktif')
                ->modifyQueryUsing(fn(Builder $query) => $query->aktif())
                ->badge(PengurusDesa::aktif()->count())
                ->badgeColor('success')
                ->icon('heroicon-o-check-circle'),

            'tidak_aktif' => Tab::make('Tidak Aktif')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_aktif', false))
                ->badge(PengurusDesa::where('is_aktif', false)->count())
                ->badgeColor('danger')
                ->icon('heroicon-o-x-circle'),

            'utama' => Tab::make('Jabatan Utama')
                ->modifyQueryUsing(fn(Builder $query) => $query->utama()->aktif())
                ->badge(PengurusDesa::utama()->aktif()->count())
                ->badgeColor('primary')
                ->icon('heroicon-o-star'),

            'wakil' => Tab::make('Jabatan Wakil')
                ->modifyQueryUsing(fn(Builder $query) => $query->wakil()->aktif())
                ->badge(PengurusDesa::wakil()->aktif()->count())
                ->badgeColor('warning')
                ->icon('heroicon-o-user-group'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PengurusDesaResource\Widgets\PengurusStatsWidget::class,
        ];
    }
}
