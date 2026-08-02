<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DailyViewsChart extends ChartWidget
{
    protected ?string $heading = 'Daily Views (Last 30 Days)';
    
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 1;

    protected string $color = 'info';

    protected function getData(): array
    {
        $days = collect(range(29, 0))->map(function ($day) {
            return now()->subDays($day)->format('Y-m-d');
        });

        $views = PageView::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->pluck('count', 'date');

        $data = $days->map(fn ($day) => $views->get($day, 0));

        return [
            'datasets' => [
                [
                    'label' => 'Total Views',
                    'data' => $data->toArray(),
                    'fill' => 'start',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $days->map(fn ($day) => Carbon::parse($day)->format('M d'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
