<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\TimeHelper;
use App\Services\ArticleService;
use App\Helpers\ProfileDesa;

class GlobalDataMiddleware
{
    public function handle($request, Closure $next)
    {
        $timeData = TimeHelper::getFormattedTime();
        view()->share([
            'tanggal' => $timeData['tanggal'] ?? 'no data',
            'jam' => $timeData['jam'] ?? 'no data',
            'format' => $timeData['format'] ?? 'no data',
            'headlines' => cache()->remember('headlines', 300, function () {
                return ArticleService::getHeadlines();
            }) ?? [],
            'ProfileDesa' => cache()->remember('profile_desa', 3600, function () {
                return ProfileDesa::GetProfileDesa();
            }) ?? null,
        ]);

        return $next($request);
    }
}
