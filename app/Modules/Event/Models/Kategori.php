<?php

namespace App\Modules\Event\Models;

use App\Modules\Event\Database\Factories\KategoriFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';
    protected $fillable = ['nama', 'slug'];

    protected static function newFactory(): KategoriFactory
    {
        return KategoriFactory::new();
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_kategori')->withTimestamps();
    }
}
