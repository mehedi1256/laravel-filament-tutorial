<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TestStatWidget extends BaseWidget
{
    use InteractsWithPageFilters; // for filtering

    protected static ?int $sort = 1; // for sorting
    
    protected function getStats(): array
    {
        $start = $this->filters['startDate'];
        $end = $this->filters['endDate'];

        return [
            Stat::make(
                'Users',
                User::when(
                    $start,
                    fn($query) => $query->whereDate('created_at', '>', $start)
                )
                    ->when(
                        $end,
                        fn($query) => $query->whereDate('created_at', '<', $end)
                    )
                    ->count()
            )
            
                ->description('Total User')
                ->descriptionIcon('heroicon-s-user-group', IconPosition::Before)
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Bounce rate', '21%'),
            Stat::make('Average time on page', '3:12'),
        ];
    }
}
