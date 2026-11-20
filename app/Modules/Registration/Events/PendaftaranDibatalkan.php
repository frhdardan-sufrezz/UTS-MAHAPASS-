<?php

namespace App\Modules\Registration\Events;

/** Domain Event: modul Ticket mendengarkan ini untuk mengembalikan kuota. */
class PendaftaranDibatalkan
{
    public function __construct(public int $pendaftaranId, public int $tiketId, public int $jumlah)
    {
    }
}
