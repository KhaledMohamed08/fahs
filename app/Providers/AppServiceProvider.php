<?php

namespace App\Providers;

use App\Models\Assessment;
use App\Models\Result;
use App\Policies\AssessmentPolicy;
use App\Policies\ResultPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('foundation-gate', fn ($user) => $user->hasRole('foundation'));
        Gate::define('participant-gate', fn ($user) => $user->hasRole('participant'));
        // Register policies
        Gate::policies([
            Assessment::class => AssessmentPolicy::class,
            Result::class => ResultPolicy::class,
        ]);
    }
}
