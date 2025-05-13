<?php

namespace App\Filament\Widgets;

use App\Models\Assessment;
use App\Models\Category;
use App\Models\Result;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class DashboardOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::query()->count())
                ->icon('heroicon-s-users')
                ->description('number of all users')
                ->color('gray'),
            Stat::make('Categories', Category::query()->count())
                ->icon('heroicon-o-rectangle-stack')
                ->description('number of all categories')
                ->color('gray'),
            Stat::make('Assessments', Assessment::query()->count())
                ->icon('heroicon-s-pencil-square')
                ->description('number of all assessments')
                ->color('gray'),
            Stat::make('Results', Result::query()->count())
                ->icon('heroicon-o-clipboard')
                ->description('number of all results')
                ->color('gray'),
        ];
    }
}
