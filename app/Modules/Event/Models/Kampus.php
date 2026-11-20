<?php

namespace App\Modules\Event\Models;

use App\Modules\Event\Database\Factories\KampusFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kampus extends Model
{
    use HasFactory;

    protected $table = 'kampus';
    protected $fillable = ['nama', 'singkatan', 'kota'];

    protected static function newFactory(): KampusFactory
    {
        return KampusFactory::new();
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function organizers(): HasMany
    {
        return $this->hasMany(Organizer::class);
    }
}
