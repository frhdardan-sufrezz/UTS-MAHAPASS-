<?php

namespace App\Modules\Event\Models;

use App\Modules\Event\Database\Factories\OrganizerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organizer extends Model
{
    use HasFactory;

    public const JENIS = ['UKM', 'Himpunan', 'Komunitas'];

    protected $table = 'organizers';
    protected $fillable = ['nama', 'jenis', 'kampus_id'];

    protected static function newFactory(): OrganizerFactory
    {
        return OrganizerFactory::new();
    }

    public function kampus(): BelongsTo
    {
        return $this->belongsTo(Kampus::class);
    }

    // One-to-Many: satu Organizer punya banyak Event
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
