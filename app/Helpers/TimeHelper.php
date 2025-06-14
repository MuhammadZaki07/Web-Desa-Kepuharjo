<?php

namespace App\Helpers;

use Carbon\Carbon;

class TimeHelper
{
    public static function getFormattedTime(): array
    {
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        $now = Carbon::now();

        return [
            'tanggal' => $now->translatedFormat('D, d F Y'),
            'jam' => $now->format('H:i'),
            'format' => $now->format('A'),
        ];
    }
}
