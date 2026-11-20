<?php

namespace App\Modules\Event\Models;

use App\Modules\Event\Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $fillable = ['organizer_id', 'kampus_id', 'judul', 'deskripsi', 'lokasi', 'poster_url', 'mulai', 'selesai', 'status'];
    protected $casts = ['mulai' => 'datetime', 'selesai' => 'datetime'];

    protected static function newFactory(): EventFactory
    {
        return EventFactory::new();
    }

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(Organizer::class);
    }

    public function kampus(): BelongsTo
    {
        return $this->belongsTo(Kampus::class);
    }

    // Many-to-Many dengan pivot event_kategori
    public function kategoris(): BelongsToMany
    {
        return $this->belongsToMany(Kategori::class, 'event_kategori')->withTimestamps();
    }
}
