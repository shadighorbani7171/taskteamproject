<?php


namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\TaskUpdated;
use App\Listeners\UpdateTaskActivityLog;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        TaskUpdated::class => [
            UpdateTaskActivityLog::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}