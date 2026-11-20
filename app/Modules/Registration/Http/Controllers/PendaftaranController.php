<?php

namespace App\Modules\Registration\Http\Controllers;

use App\Modules\Registration\Http\Requests\BeliTiketRequest;
use App\Modules\Registration\Http\Requests\CariPendaftaranRequest;
use App\Modules\Registration\Services\PendaftaranService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PendaftaranController extends Controller
{
    public function __construct(private PendaftaranService $service)
    {
    }

    public function store(BeliTiketRequest $request)
    {
        $p = $this->service->beli($request->user()->id, (int) $request->tiket_id, (int) $request->jumlah);

        return $request->expectsJson()
            ? response()->json(['message' => 'Pembelian berhasil.', 'data' => $p], 201)
            : redirect()->route('tiket.saya')->with('success', 'Pembelian berhasil! Kode pesanan: '.$p->kode_tiket.' ('.$p->jumlah.' tiket, kode tiap tiket ada di tabel di bawah).');
    }

    public function saya(Request $request)
    {
        $pendaftarans = $this->service->riwayat($request->user()->id);

        return $request->expectsJson()
            ? response()->json($pendaftarans)
            : view('registration::tiket-saya', compact('pendaftarans'));
    }

    public function batal(Request $request, int $id)
    {
        $p = $this->service->batalkan($id, $request->user()->id, $request->user()->isAdmin());

        return $request->expectsJson()
            ? response()->json(['message' => 'Pendaftaran dibatalkan, kuota dikembalikan.', 'data' => $p])
            : back()->with('success', 'Pendaftaran '.$p->kode_tiket.' berhasil dibatalkan. Kuota tiket dikembalikan.');
    }

    public function admin(CariPendaftaranRequest $request)
    {
        $pendaftarans = $this->service->semua($request->validated('q'));

        return $request->expectsJson()
            ? response()->json($pendaftarans)
            : view('registration::admin.index', compact('pendaftarans'));
    }
}
