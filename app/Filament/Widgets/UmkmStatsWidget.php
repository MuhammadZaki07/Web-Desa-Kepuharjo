<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\UmkmProduct;
use App\Models\Pengajuan;
use App\Models\Organization;

class UmkmStatsWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Produk UMKM', UmkmProduct::count())
                ->description('Total produk')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('success'),

            Stat::make('Pengajuan Aktif', Pengajuan::where('status', 'pending')->count())
                ->description('Menunggu proses')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Organisasi', Organization::count())
                ->description('Organisasi desa')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('info'),
        ];
    }
}
