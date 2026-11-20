<?php

namespace App\Modules\Ticket\Listeners;

use App\Modules\Registration\Events\PendaftaranDibatalkan;
use App\Modules\Ticket\Contracts\TicketServiceInterface;

class KembalikanKuota
{
    public function __construct(private TicketServiceInterface $tickets)
    {
    }

    public function handle(PendaftaranDibatalkan $event): void
    {
        $this->tickets->release($event->tiketId, $event->jumlah);
    }
}
