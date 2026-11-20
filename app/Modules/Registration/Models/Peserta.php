<?php

namespace App\Modules\Registration\Models;

use App\Modules\Registration\Database\Factories\PesertaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'pesertas';
    protected $fillable = ['user_id', 'nama', 'kampus', 'no_hp'];

    protected static function newFactory(): PesertaFactory
    {
        return PesertaFactory::new();
    }

    // One-to-Many: satu Peserta punya banyak Pendaftaran
    public function pendaftarans(): HasMany
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
