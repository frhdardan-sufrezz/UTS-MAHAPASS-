<?php

namespace App\Modules\Ticket\Models;

use App\Modules\Ticket\Database\Factories\TiketFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    public const TIPE_UMUM = 'umum';
    public const TIPE_MAHASISWA = 'mahasiswa';

    protected $table = 'tikets';
    protected $fillable = ['event_id', 'nama', 'tipe', 'harga', 'kuota', 'terjual'];

    protected static function newFactory(): TiketFactory
    {
        return TiketFactory::new();
    }

    public function sisa(): int
    {
        return max(0, $this->kuota - $this->terjual);
    }
}
