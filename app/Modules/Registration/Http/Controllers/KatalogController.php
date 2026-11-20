<?php

namespace App\Modules\Registration\Http\Controllers;

use App\Modules\Event\Contracts\EventServiceInterface;
use App\Modules\Ticket\Contracts\TicketServiceInterface;
use App\Modules\Registration\Http\Requests\FilterKatalogRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/** Katalog publik: data Event & Tiket diambil lewat Contract. */
class KatalogController extends Controller
{
    public function __construct(private EventServiceInterface $events, private TicketServiceInterface $tickets)
    {
    }

    public function index(FilterKatalogRequest $request)
    {
        $events = $this->events->paginate($request->safe()->only(['q', 'kategori', 'kategori_id', 'kampus_id']), 12, true);

        if ($request->expectsJson()) {
            return response()->json($events);
        }

        return view('registration::katalog.index', [
            'events' => $events,
            'kategoriList' => $this->events->kategoriOptions(),
            'kampusList' => $this->events->kampusOptions(),
            'harga' => $this->tickets->hargaMulai(collect($events->items())->pluck('id')->all()),
        ]);
    }

    public function show(Request $request, int $id)
    {
        $event = $this->events->find($id);
        abort_if(! $event || $event['status'] !== 'published', 404, 'Event tidak ditemukan atau belum dipublikasikan.');

        $tikets = $this->tickets->listByEvent($id);

        return $request->expectsJson()
            ? response()->json(['event' => $event, 'tiket' => $tikets])
            : view('registration::katalog.show', compact('event', 'tikets'));
    }
}
