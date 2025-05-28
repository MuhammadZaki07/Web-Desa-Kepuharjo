<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\StatsDashboard;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Beranda';
    protected static ?string $title = 'Beranda';
    protected static string $view = 'filament.pages.dashboard';

    public function getHeaderWidgets(): array
{
    return [
        StatsDashboard::class
    ];
}

}
