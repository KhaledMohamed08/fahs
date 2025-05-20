<?php

namespace App\Providers;

use App\Models\Result;
use App\Models\Assessment;
use App\Policies\ResultPolicy;
use App\Policies\AssessmentPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

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
        // VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
        //     return (new MailMessage)
        //         ->subject('Verify Email Address')
        //         ->view('mails.verify-email-address', [
        //             'user' => $notifiable,
        //             'url' => $url,
        //         ]);
        // });
        
        Gate::define('foundation-gate', fn($user) => $user->hasRole('foundation'));
        Gate::define('participant-gate', fn($user) => $user->hasRole('participant'));
        // Register policies
        Gate::policies([
            Assessment::class => AssessmentPolicy::class,
            Result::class => ResultPolicy::class,
        ]);
    }
}
