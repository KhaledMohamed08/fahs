<?php

namespace App\Filament\Resources\CategoryResource\Widgets;

use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CategoryOverview extends BaseWidget
{
    protected ?string $heading = 'Categories Analytics';

    protected function getStats(): array
    {
        return [
            Stat::make('All Categories', Category::query()->count())
                ->icon('heroicon-o-rectangle-stack')
                ->description('number of all categories')
                ->color('gray'),
        ];
    }
}
