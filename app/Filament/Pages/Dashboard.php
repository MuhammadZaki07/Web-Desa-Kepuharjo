<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\PendudukChart;
use App\Filament\Widgets\ArticleChart;
use App\Filament\Widgets\CalendarWidget;
use App\Filament\Widgets\UmkmStatsWidget;
use App\Filament\Widgets\RecentActivitiesWidget;
use App\Filament\Widgets\WelcomeWidget;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Beranda';
    protected static ?string $title = 'Dashboard Desa';
    protected static string $view = 'filament.pages.dashboard';


    public function getHeaderWidgets(): array
    {
        return [
            WelcomeWidget::class,
            StatsOverviewWidget::class,
            UmkmStatsWidget::class,
        ];
    }

    public function getFooterWidgets(): array
    {
        return [
            PendudukChart::class,
            ArticleChart::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return 2;
    }

    public function getGreeting(): string
    {
        $hour = now()->format('H');

        if ($hour < 12) {
            return 'Selamat Pagi';
        } elseif ($hour < 15) {
            return 'Selamat Siang';
        } elseif ($hour < 18) {
            return 'Selamat Sore';
        } else {
            return 'Selamat Malam';
        }
    }

    public function getCurrentDateTime(): array
    {
        return [
            'time' => now()->format('H:i:s'),
            'date' => now()->translatedFormat('l, d F Y'),
            'timezone' => 'WIB'
        ];
    }
}
