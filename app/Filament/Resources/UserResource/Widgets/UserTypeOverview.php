<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserTypeOverview extends BaseWidget
{
    protected ?string $heading = 'Users Analytics';

    // protected ?string $description = 'An overview of some analytics.';
    
    protected function getStats(): array
    {
        return [
            Stat::make('All Users', User::query()->count())
                ->icon('heroicon-s-user')
                ->description('number of all users')
                // ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('gray'),
                // ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('Foundations', User::query()->where('type', 'participant')->count())
                ->icon('heroicon-s-user')
                ->description('can create assessments')
                ->color('primary'),
            Stat::make('Participants', User::query()->where('type', 'foundation')->count())
                ->icon('heroicon-s-user')
                ->description('can solve assessment')
                ->color('success'),
        ];
    }
}
