@extends('layouts.app')
@section('title', 'Tiket - '.$event['judul'])
@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
<a href="{{ route('admin.events.index') }}" class="text-sm text-indigo-600">&larr; Kembali ke daftar event</a>
<h1 class="text-2xl font-bold mt-1">Tiket: {{ $event['judul'] }}</h1>
<p class="text-slate-500 mb-4">{{ $event['kampus']['singkatan'] }} &bull; {{ $event['mulai']->format('d M Y H:i') }}</p>

<div class="grid md:grid-cols-3 gap-6">
    <div class="md:col-span-2 bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-100 text-left">
                <tr><th class="p-3">Nama</th><th class="p-3">Tipe</th><th class="p-3">Harga</th><th class="p-3">Terjual / Kuota</th><th class="p-3">Aksi</th></tr>
            </thead>
            <tbody>
            @forelse ($tikets as $t)
                <tr class="border-t">
                    <td class="p-3 font-medium">{{ $t['nama'] }}</td>
                    <td class="p-3">{{ ucfirst($t['tipe']) }}</td>
                    <td class="p-3">Rp {{ number_format($t['harga'], 0, ',', '.') }}</td>
                    <td class="p-3">{{ $t['terjual'] }} / {{ $t['kuota'] }}
                        @if ($t['sisa'] === 0)<span class="ml-1 text-xs text-red-600">(habis)</span>@endif
                    </td>
                    <td class="p-3 flex gap-2">
                        <a class="text-slate-600" href="{{ route('admin.tiket.edit', $t['id']) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.tiket.destroy', $t['id']) }}" onsubmit="return confirm('Hapus tiket ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="p-6 text-center text-slate-500">Belum ada tiket untuk event ini.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-xl shadow p-4">
        <h2 class="font-semibold mb-3">Tambah Tiket</h2>
        <form method="POST" action="{{ route('admin.tiket.store', $event['id']) }}" class="space-y-3">
            @csrf
            @include('ticket::admin._fields', ['tiket' => null])
            <button class="w-full py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Tambah</button>
        </form>
    </div>
</div>
</div>
@endsection
