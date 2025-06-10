<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Article;
use Carbon\Carbon;

class ArticleChart extends ChartWidget
{
    protected static ?string $heading = 'Artikel Bulanan';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $count = Article::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $data[] = $count;
            $labels[] = $month->format('M Y');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Artikel Diterbitkan',
                    'data' => $data,
                    'backgroundColor' => [
                        '#3B82F6',
                        '#8B5CF6',
                        '#06B6D4',
                        '#10B981',
                        '#F59E0B',
                        '#EF4444',
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
