<?php

namespace App\Modules\Event\Events;

/** Domain Event: modul Ticket mendengarkan ini untuk menghapus tiket milik event tersebut. */
class EventDihapus
{
    public function __construct(public int $eventId)
    {
    }
}
