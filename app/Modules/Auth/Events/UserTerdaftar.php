<?php

namespace App\Modules\Auth\Events;

/**
 * Domain Event: dipancarkan setelah user baru dibuat.
 * Modul Registration mendengarkan event ini untuk membuat profil Peserta.
 */
class UserTerdaftar
{
    public function __construct(
        public int $userId,
        public string $nama,
        public ?string $kampus = null,
    ) {
    }
}
