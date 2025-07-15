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
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ListPenduduks extends ListRecords
{
    protected static string $resource = PendudukResource::class;

    protected static ?string $title = 'Data Penduduk';

    protected function getHeaderActions(): array
    {
        $user = Auth::user();
        if ($user->role === 'super_admin' || $user->role === "admin") {
            return [
                CreateAction::make()
                    ->label('Tambah Penduduk')
                    ->icon('heroicon-o-plus')
                    ->createAnother(false),
            ];
        }
        return [];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('user', fn($q) => $q->where('role', 'penduduk')))
                ->badge(Penduduk::whereHas('user', fn($q) => $q->where('role', 'penduduk'))->count())
                ->badgeColor('primary'),

            'hidup' => Tab::make('Hidup')
                ->modifyQueryUsing(fn(Builder $query) =>
                $query->where('status_nyawa', 'hidup')
                    ->whereHas('user', fn($q) => $q->where('role', 'penduduk')))
                ->badge(Penduduk::where('status_nyawa', 'hidup')
                    ->whereHas('user', fn($q) => $q->where('role', 'penduduk'))->count())
                ->badgeColor('success'),

            'meninggal' => Tab::make('Meninggal')
                ->modifyQueryUsing(fn(Builder $query) =>
                $query->where('status_nyawa', 'meninggal')
                    ->whereHas('user', fn($q) => $q->where('role', 'penduduk')))
                ->badge(Penduduk::where('status_nyawa', 'meninggal')
                    ->whereHas('user', fn($q) => $q->where('role', 'penduduk'))->count())
                ->badgeColor('danger'),

            'laki_laki' => Tab::make('Laki-laki')
                ->modifyQueryUsing(fn(Builder $query) =>
                $query->where('jenis_kelamin', 'L')
                    ->whereHas('user', fn($q) => $q->where('role', 'penduduk')))
                ->badge(Penduduk::where('jenis_kelamin', 'L')
                    ->whereHas('user', fn($q) => $q->where('role', 'penduduk'))->count())
                ->badgeColor('blue'),

            'perempuan' => Tab::make('Perempuan')
                ->modifyQueryUsing(fn(Builder $query) =>
                $query->where('jenis_kelamin', 'P')
                    ->whereHas('user', fn($q) => $q->where('role', 'penduduk')))
                ->badge(Penduduk::where('jenis_kelamin', 'P')
                    ->whereHas('user', fn($q) => $q->where('role', 'penduduk'))->count())
                ->badgeColor('pink'),
        ];
    }


    protected function getHeaderWidgets(): array
    {
        return [];
    }
}
