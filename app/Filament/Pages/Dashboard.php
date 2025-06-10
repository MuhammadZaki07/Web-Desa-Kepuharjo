<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\PendudukChart;
use App\Filament\Widgets\ArticleChart;
use App\Filament\Widgets\UmkmStatsWidget;
use App\Filament\Widgets\RecentActivitiesWidget;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Beranda';
    protected static ?string $title = 'Dashboard Desa';
    protected static string $view = 'filament.pages.dashboard';

    public function getHeaderWidgets(): array
    {
        return [
            StatsOverviewWidget::class,
            UmkmStatsWidget::class,
        ];
    }

    public function getFooterWidgets(): array
    {
        return [
            PendudukChart::class,
            ArticleChart::class,
            RecentActivitiesWidget::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return 2;
    }
}
