<?php

namespace App\Modules\Event;

use App\Modules\Event\Contracts\EventServiceInterface;
use App\Modules\Event\Services\EventService;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Modul lain hanya boleh bergantung pada Contract ini, bukan pada model Event.
        $this->app->bind(EventServiceInterface::class, EventService::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
        $this->loadViewsFrom(__DIR__.'/Views', 'event');
    }
}
