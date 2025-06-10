<?php

namespace App\Filament\Resources\PendudukResource\Pages;

use App\Filament\Resources\PendudukResource;
use App\Models\Penduduk;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Exports\PendudukExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ListPenduduks extends ListRecords
{
    protected static string $resource = PendudukResource::class;

    protected static ?string $title = 'Data Penduduk';

    protected function getHeaderActions(): array
    {
        return [
                Action::make('export')
                ->label('Export Data')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function (): BinaryFileResponse {
                    Notification::make()
                        ->title('Export sedang diproses...')
                        ->success()
                        ->send();
                    return Excel::download(new PendudukExport, 'data_penduduk.xlsx');
                })
                ->color('success')
                ->requiresConfirmation(),

            CreateAction::make()
                ->label('Tambah Penduduk')
                ->icon('heroicon-o-plus')
                ->createAnother(false),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua')
                ->badge(Penduduk::count())
                ->badgeColor('primary'),

            'hidup' => Tab::make('Hidup')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_nyawa', 'hidup'))
                ->badge(Penduduk::where('status_nyawa', 'hidup')->count())
                ->badgeColor('success'),

            'meninggal' => Tab::make('Meninggal')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_nyawa', 'meninggal'))
                ->badge(Penduduk::where('status_nyawa', 'meninggal')->count())
                ->badgeColor('danger'),

            'laki_laki' => Tab::make('Laki-laki')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('jenis_kelamin', 'L'))
                ->badge(Penduduk::where('jenis_kelamin', 'L')->count())
                ->badgeColor('blue'),

            'perempuan' => Tab::make('Perempuan')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('jenis_kelamin', 'P'))
                ->badge(Penduduk::where('jenis_kelamin', 'P')->count())
                ->badgeColor('pink'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [

        ];
    }
}
