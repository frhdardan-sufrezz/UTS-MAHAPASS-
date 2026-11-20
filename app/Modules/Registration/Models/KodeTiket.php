<?php

namespace App\Modules\Registration\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Kode unik untuk setiap lembar tiket dalam sebuah pendaftaran. */
class KodeTiket extends Model
{
    protected $table = 'kode_tikets';
    protected $fillable = ['pendaftaran_id', 'kode'];

    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}
