<?php

namespace App\Modules\Event\Services;

use App\Modules\Event\Contracts\EventServiceInterface;
use App\Modules\Event\Events\EventDihapus;
use App\Modules\Event\Models\Event;
use App\Modules\Event\Models\Kampus;
use App\Modules\Event\Models\Kategori;
use App\Modules\Event\Models\Organizer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class EventService implements EventServiceInterface
{
    public function paginate(array $filters = [], int $perPage = 9, bool $onlyPublished = true): LengthAwarePaginator
    {
        $query = Event::with(['organizer', 'kampus', 'kategoris'])->orderBy('mulai');

        if ($onlyPublished) {
            $query->where('status', 'published');
        }
        if (! empty($filters['q'])) {
            $query->where('judul', 'like', '%'.$filters['q'].'%');
        }
        if (! empty($filters['kampus_id'])) {
            $query->where('kampus_id', $filters['kampus_id']);
        }
        if (! empty($filters['kategori'])) {
            $query->whereHas('kategoris', fn ($k) => $k->where('kategoris.slug', $filters['kategori']));
        }
        if (! empty($filters['kategori_id'])) {
            $query->whereHas('kategoris', fn ($k) => $k->where('kategoris.id', $filters['kategori_id']));
        }

        return $query->paginate($perPage)->through(fn (Event $e) => $this->toArray($e));
    }

    public function find(int $id): ?array
    {
        $event = Event::with(['organizer', 'kampus', 'kategoris'])->find($id);

        return $event ? $this->toArray($event) : null;
    }

    public function exists(int $id): bool
    {
        return Event::whereKey($id)->exists();
    }

    public function allIds(): array
    {
        return Event::pluck('id')->all();
    }

    public function kategoriOptions(): array
    {
        return Kategori::orderBy('nama')->pluck('nama', 'id')->all();
    }

    public function kampusOptions(): array
    {
        return Kampus::orderBy('singkatan')->pluck('nama', 'id')->all();
    }

    public function organizerOptions(): array
    {
        return Organizer::orderBy('nama')->pluck('nama', 'id')->all();
    }

    public function create(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $event = Event::create(Arr::except($data, 'kategori_ids'));
            $event->kategoris()->sync($data['kategori_ids'] ?? []);

            return $this->find($event->id);
        });
    }

    public function update(int $id, array $data): array
    {
        return DB::transaction(function () use ($id, $data) {
            $event = Event::findOrFail($id);
            $event->update(Arr::except($data, 'kategori_ids'));
            $event->kategoris()->sync($data['kategori_ids'] ?? []);

            return $this->find($id);
        });
    }

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $event = Event::findOrFail($id);
            $event->kategoris()->detach();
            $event->delete();

            // Domain Event: modul lain (Ticket) membersihkan datanya sendiri
            event(new EventDihapus($id));
        });
    }

    private function toArray(Event $e): array
    {
        return [
            'id' => $e->id,
            'judul' => $e->judul,
            'deskripsi' => $e->deskripsi,
            'lokasi' => $e->lokasi,
            'poster_url' => $e->poster_url,
            'mulai' => $e->mulai,
            'selesai' => $e->selesai,
            'status' => $e->status,
            'organizer_id' => $e->organizer_id,
            'kampus_id' => $e->kampus_id,
            'organizer' => ['nama' => $e->organizer?->nama, 'jenis' => $e->organizer?->jenis],
            'kampus' => ['nama' => $e->kampus?->nama, 'singkatan' => $e->kampus?->singkatan],
            'kategori' => $e->kategoris->pluck('nama')->all(),
            'kategori_ids' => $e->kategoris->pluck('id')->all(),
        ];
    }
}
