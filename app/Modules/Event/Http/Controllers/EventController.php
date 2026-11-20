<?php

namespace App\Modules\Event\Http\Controllers;

use App\Modules\Event\Contracts\EventServiceInterface;
use App\Modules\Event\Http\Requests\FilterEventRequest;
use App\Modules\Event\Http\Requests\SimpanEventRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/** CRUD Event untuk Admin (web = Blade, api = JSON). */
class EventController extends Controller
{
    public function __construct(private EventServiceInterface $events)
    {
    }

    public function index(FilterEventRequest $request)
    {
        $events = $this->events->paginate($request->safe()->only(['q']), 10, false);

        return $request->expectsJson()
            ? response()->json($events)
            : view('event::admin.index', compact('events'));
    }

    public function create()
    {
        return view('event::admin.form', ['event' => null] + $this->options());
    }

    public function store(SimpanEventRequest $request)
    {
        $event = $this->events->create($request->validated());

        return $request->expectsJson()
            ? response()->json(['message' => 'Event berhasil dibuat.', 'data' => $event], 201)
            : redirect()->route('admin.events.index')->with('success', 'Event "'.$event['judul'].'" berhasil dibuat.');
    }

    public function show(int $id)
    {
        return response()->json($this->events->find($id) ?? abort(404, 'Event tidak ditemukan.'));
    }

    public function edit(int $id)
    {
        $event = $this->events->find($id) ?? abort(404, 'Event tidak ditemukan.');

        return view('event::admin.form', ['event' => $event] + $this->options());
    }

    public function update(SimpanEventRequest $request, int $id)
    {
        abort_unless($this->events->exists($id), 404, 'Event tidak ditemukan.');
        $event = $this->events->update($id, $request->validated());

        return $request->expectsJson()
            ? response()->json(['message' => 'Event berhasil diperbarui.', 'data' => $event])
            : redirect()->route('admin.events.index')->with('success', 'Event "'.$event['judul'].'" berhasil diperbarui.');
    }

    public function destroy(Request $request, int $id)
    {
        abort_unless($this->events->exists($id), 404, 'Event tidak ditemukan.');
        $this->events->delete($id);

        return $request->expectsJson()
            ? response()->json(['message' => 'Event berhasil dihapus.'])
            : redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus.');
    }

    private function options(): array
    {
        return [
            'organizers' => $this->events->organizerOptions(),
            'kampusList' => $this->events->kampusOptions(),
            'kategoriList' => $this->events->kategoriOptions(),
        ];
    }
}
