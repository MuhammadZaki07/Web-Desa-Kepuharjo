<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class WelcomeWidget extends Widget
{
    protected static string $view = 'filament.widgets.welcome-widget';

    protected int | string | array $columnSpan = 'full';

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
        $now = now()->setTimezone('Asia/Jakarta');

        return [
            'time' => $now->format('H:i:s'),
            'date' => $now->translatedFormat('l, d F Y'),
            'timezone' => 'WIB',
        ];
    }
}
