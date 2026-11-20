<?php

namespace App\Modules\Ticket\Listeners;

use App\Modules\Event\Events\EventDihapus;
use App\Modules\Ticket\Services\TiketService;

class HapusTiketEvent
{
    public function __construct(private TiketService $tickets)
    {
    }

    public function handle(EventDihapus $event): void
    {
        $this->tickets->hapusByEvent($event->eventId);
    }
}
