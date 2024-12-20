<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use Filament\Actions;
use App\Models\Employee;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\EmployeeResource;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // making custom tabs
    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'This Week' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('date_of_hired', '>=', now()->subWeek()))
            ->badge(Employee::query()->where('date_of_hired', '>=', now()->subWeek())->count()),
            'This Month' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('date_of_hired', '>=', now()->subMonth()))
            ->badge(Employee::query()->where('date_of_hired', '>=', now()->subMonth())->count()),
            'This Year' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('date_of_hired', '>=', now()->subYear()))
            ->badge(Employee::query()->where('date_of_hired', '>=', now()->subYear())->count()),
        ];
    }
}
