<?php

namespace App\Modules\Ticket\Contracts;

use App\Modules\Ticket\Exceptions\KuotaPenuhException;
use App\Modules\Ticket\Exceptions\TiketTidakDitemukanException;

/** Pintu masuk resmi modul Ticket bagi modul lain (mis. Registration). */
interface TicketServiceInterface
{
    /** @return array<int,array> daftar tiket sebuah event */
    public function listByEvent(int $eventId): array;

    public function find(int $tiketId): ?array;

    /** @return array<int,int> event_id => harga tiket termurah */
    public function hargaMulai(array $eventIds): array;

    /**
     * Mengurangi kuota secara atomik (lockForUpdate).
     *
     * @throws KuotaPenuhException
     * @throws TiketTidakDitemukanException
     */
    public function reserve(int $tiketId, int $jumlah): array;

    /** Mengembalikan kuota (mis. saat pendaftaran dibatalkan). */
    public function release(int $tiketId, int $jumlah): void;
}
