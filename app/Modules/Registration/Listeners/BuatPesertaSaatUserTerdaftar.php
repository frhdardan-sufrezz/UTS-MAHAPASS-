<?php

namespace App\Modules\Registration\Listeners;

use App\Modules\Auth\Events\UserTerdaftar;
use App\Modules\Registration\Models\Peserta;

class BuatPesertaSaatUserTerdaftar
{
    public function handle(UserTerdaftar $event): void
    {
        Peserta::updateOrCreate(
            ['user_id' => $event->userId],
            ['nama' => $event->nama, 'kampus' => $event->kampus],
        );
    }
}
