<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\TeamInvite;
use App\Mail\TeamInviteMail;
use Illuminate\Support\Facades\Mail;


use App\Observers\TeamInviteObserver;

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
        TeamInvite::observe(TeamInviteObserver::class);
    }
}
