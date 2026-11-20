@extends('layouts.app')
@section('title', 'Tiket Saya')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
<h1 class="text-2xl font-bold mb-4">Tiket Saya</h1>
<div class="bg-white rounded-xl shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-100 text-left">
            <tr><th class="p-3">Kode Pesanan</th><th class="p-3">Kode Tiket</th><th class="p-3">Event</th><th class="p-3">Tiket</th><th class="p-3">Jml</th><th class="p-3">Total</th><th class="p-3">Status</th><th class="p-3"></th></tr>
        </thead>
        <tbody>
        @forelse ($pendaftarans as $p)
            <tr class="border-t">
                <td class="p-3 font-mono font-semibold">{{ $p->kode_tiket }}</td>
                <td class="p-3 font-mono text-xs space-y-1">
                    @foreach ($p->kodes as $k)
                        <div class="{{ $p->status === 'dibatalkan' ? 'line-through text-slate-400' : '' }}">{{ $k->kode }}</div>
                    @endforeach
                </td>
                <td class="p-3">{{ $p->event_judul }}</td>
                <td class="p-3">{{ $p->tiket_nama }}</td>
                <td class="p-3">{{ $p->jumlah }}</td>
                <td class="p-3">Rp {{ number_format($p->total, 0, ',', '.') }}</td>
                <td class="p-3"><span class="px-2 py-1 rounded text-xs {{ $p->status === 'lunas' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $p->status }}</span></td>
                <td class="p-3">
                    @if ($p->status === 'lunas')
                        <form method="POST" action="{{ route('pendaftaran.batal', $p->id) }}" onsubmit="return confirm('Batalkan pendaftaran ini?')">
                            @csrf <button class="text-red-600">Batalkan</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="p-6 text-center text-slate-500">Anda belum membeli tiket. <a class="text-indigo-600" href="{{ route('katalog.index') }}">Cari event</a></td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $pendaftarans->links() }}</div>
</div>
@endsection
