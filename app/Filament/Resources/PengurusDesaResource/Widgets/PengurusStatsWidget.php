<?php

namespace App\Filament\Resources\PengurusDesaResource\Widgets;

use App\Models\PengurusDesa;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Support\Enums\IconPosition;

class PengurusStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalPengurus = PengurusDesa::count();
        $pengurusAktif = PengurusDesa::aktif()->count();
        $pengurusUtama = PengurusDesa::aktif()->utama()->count();
        $pengurusWakil = PengurusDesa::aktif()->wakil()->count();
        $kepalaDesaAktif = PengurusDesa::getKepalaDesaAktif();
        $pengurusTidakAktif = PengurusDesa::where('is_aktif', false)->count();

        return [
            Stat::make('Total Pengurus', $totalPengurus)
                ->description('Seluruh data pengurus desa')
                ->descriptionIcon('heroicon-m-users', IconPosition::Before)
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->extraAttributes(['class' => 'cursor-pointer']),

            Stat::make('Pengurus Aktif', $pengurusAktif)
                ->description($pengurusTidakAktif > 0 ? "{$pengurusTidakAktif} tidak aktif" : 'Semua pengurus aktif')
                ->descriptionIcon('heroicon-m-check-circle', IconPosition::Before)
                ->color('success')
                ->chart([3, 5, 8, 12, 15, 18, $pengurusAktif])
                ->extraAttributes(['class' => 'cursor-pointer']),

            Stat::make('Jabatan Utama', $pengurusUtama)
                ->description('Pengurus dengan jabatan utama')
                ->descriptionIcon('heroicon-m-star', IconPosition::Before)
                ->color('warning')
                ->chart([1, 3, 5, 7, 9, 11, $pengurusUtama]),

            Stat::make('Jabatan Wakil', $pengurusWakil)
                ->description('Pengurus dengan jabatan wakil')
                ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
                ->color('info')
                ->chart([0, 1, 2, 3, 4, 5, $pengurusWakil]),

            Stat::make('Kepala Desa', $kepalaDesaAktif ? 'Aktif' : 'Kosong')
                ->description($kepalaDesaAktif ? $kepalaDesaAktif->user->name : 'Belum ada kepala desa aktif')
                ->descriptionIcon($kepalaDesaAktif ? 'heroicon-m-check-badge' : 'heroicon-m-exclamation-triangle', IconPosition::Before)
                ->color($kepalaDesaAktif ? 'success' : 'danger')
                ->extraAttributes(['class' => 'cursor-pointer']),

            Stat::make('Periode Terlama', $this->getPeriodeTerlama())
                ->description('Pengurus dengan masa jabatan terlama')
                ->descriptionIcon('heroicon-m-clock', IconPosition::Before)
                ->color('gray')
                ->extraAttributes(['class' => 'cursor-pointer']),
        ];
    }

    private function getPeriodeTerlama(): string
    {
        $pengurus = PengurusDesa::aktif()
            ->with('user')
            ->get()
            ->sortBy(function ($item) {
                return $item->mulai_jabatan;
            })
            ->first();

        if (!$pengurus) {
            return 'Tidak ada data';
        }

        $durasi = $pengurus->mulai_jabatan->locale('id')->diffForHumans(null, true);
        return $durasi;
    }

    protected function getColumns(): int
    {
        return 3;
    }

    protected static ?int $sort = 1;

    public function getColumnSpan(): string|array|int
    {
        return 'full';
    }
}
