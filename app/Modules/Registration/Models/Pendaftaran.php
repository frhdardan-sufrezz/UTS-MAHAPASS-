<?php

namespace App\Modules\Registration\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pendaftaran extends Model
{
    public const LUNAS = 'lunas';
    public const DIBATALKAN = 'dibatalkan';

    protected $table = 'pendaftarans';
    protected $fillable = [
        'peserta_id', 'event_id', 'tiket_id', 'kode_tiket', 'jumlah', 'harga_satuan', 'total',
        'status', 'event_judul', 'tiket_nama', 'tiket_tipe',
    ];

    public function peserta(): BelongsTo
    {
        return $this->belongsTo(Peserta::class);
    }

    public function kodes(): HasMany
    {
        return $this->hasMany(KodeTiket::class);
    }
}
