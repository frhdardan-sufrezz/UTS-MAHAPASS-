<?php

namespace App\Modules\Ticket\Http\Controllers;

use App\Modules\Event\Contracts\EventServiceInterface;
use App\Modules\Ticket\Http\Requests\SimpanTiketRequest;
use App\Modules\Ticket\Services\TiketService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/** CRUD tiket untuk Admin. Event diverifikasi lewat Contract, bukan model Event. */
class TiketController extends Controller
{
    public function __construct(private TiketService $tickets, private EventServiceInterface $events)
    {
    }

    public function index(Request $request, int $eventId)
    {
        $event = $this->events->find($eventId) ?? abort(404, 'Event tidak ditemukan.');
        $tikets = $this->tickets->listByEvent($eventId);

        return $request->expectsJson()
            ? response()->json(['event' => $event, 'tiket' => $tikets])
            : view('ticket::admin.index', compact('event', 'tikets'));
    }

    public function store(SimpanTiketRequest $request, int $eventId)
    {
        abort_unless($this->events->exists($eventId), 404, 'Event tidak ditemukan.');
        $tiket = $this->tickets->create($eventId, $request->validated());

        return $request->expectsJson()
            ? response()->json(['message' => 'Tiket berhasil dibuat.', 'data' => $tiket], 201)
            : redirect()->route('admin.tiket.index', $eventId)->with('success', 'Tiket "'.$tiket['nama'].'" berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $tiket = $this->tickets->find($id) ?? abort(404, 'Tiket tidak ditemukan.');

        return view('ticket::admin.edit', compact('tiket'));
    }

    public function update(SimpanTiketRequest $request, int $id)
    {
        $tiket = $this->tickets->update($id, $request->validated());

        return $request->expectsJson()
            ? response()->json(['message' => 'Tiket berhasil diperbarui.', 'data' => $tiket])
            : redirect()->route('admin.tiket.index', $tiket['event_id'])->with('success', 'Tiket berhasil diperbarui.');
    }

    public function destroy(Request $request, int $id)
    {
        $eventId = $this->tickets->delete($id);

        return $request->expectsJson()
            ? response()->json(['message' => 'Tiket berhasil dihapus.'])
            : redirect()->route('admin.tiket.index', $eventId)->with('success', 'Tiket berhasil dihapus.');
    }
}
