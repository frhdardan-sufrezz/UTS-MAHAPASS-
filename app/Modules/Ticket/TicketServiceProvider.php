<?php

namespace App\Modules\Ticket;

use App\Modules\Event\Events\EventDihapus;
use App\Modules\Registration\Events\PendaftaranDibatalkan;
use App\Modules\Ticket\Contracts\TicketServiceInterface;
use App\Modules\Ticket\Listeners\HapusTiketEvent;
use App\Modules\Ticket\Listeners\KembalikanKuota;
use App\Modules\Ticket\Services\TiketService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class TicketServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TicketServiceInterface::class, TiketService::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
        $this->loadViewsFrom(__DIR__.'/Views', 'ticket');

        // Domain Event dari modul lain
        Event::listen(PendaftaranDibatalkan::class, KembalikanKuota::class);
        Event::listen(EventDihapus::class, HapusTiketEvent::class);
    }
}
