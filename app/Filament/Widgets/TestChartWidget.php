<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Flowframe\Trend\Trend;
use Illuminate\Support\Carbon;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class TestChartWidget extends ChartWidget
{
    use InteractsWithPageFilters; // for filtering

    protected static ?string $heading = 'Chart';
    
    protected static ?int $sort = 2; // for sorting

    protected function getData(): array
    {
        $start = $this->filters['startDate'];
        $end = $this->filters['endDate'];

        $data = Trend::model(User::class)
            ->between(
                start: $start ? Carbon::parse($start) : now()->subMonth(6),
                end: $end ? Carbon::parse($end) : now(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
