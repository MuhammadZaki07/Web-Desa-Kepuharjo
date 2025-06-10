<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Article;
use App\Models\Gallery;
use App\Models\Wisata;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Penduduk', User::where('role', 'penduduk')->count())
                ->description('Warga terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Total Artikel', Article::count())
                ->description('Artikel dipublikasi')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info')
                ->chart([17, 16, 14, 15, 14, 13, 12]),

            Stat::make('Galeri Foto', Gallery::count())
                ->description('Foto kegiatan')
                ->descriptionIcon('heroicon-m-photo')
                ->color('warning')
                ->chart([15, 4, 10, 2, 12, 4, 12]),

            Stat::make('Destinasi Wisata', Wisata::count())
                ->description('Objek wisata')
                ->descriptionIcon('heroicon-m-map-pin')
                ->color('danger')
                ->chart([7, 3, 4, 5, 6, 3, 5]),
        ];
    }
}
