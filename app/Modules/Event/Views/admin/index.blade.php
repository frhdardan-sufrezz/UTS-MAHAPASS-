@extends('layouts.app')
@section('title', 'Kelola Event')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold">Kelola Event</h1>
    <a href="{{ route('admin.events.create') }}" class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">+ Event Baru</a>
</div>

<form method="GET" class="mb-4 flex gap-2">
    <input name="q" value="{{ request('q') }}" placeholder="Cari judul event..." class="border rounded-lg px-3 py-2 w-64">
    <button class="px-4 py-2 rounded-lg bg-slate-200">Cari</button>
</form>

<div class="bg-white rounded-xl shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-100 text-left">
            <tr><th class="p-3">Judul</th><th class="p-3">Kampus</th><th class="p-3">Penyelenggara</th><th class="p-3">Mulai</th><th class="p-3">Status</th><th class="p-3">Aksi</th></tr>
        </thead>
        <tbody>
        @forelse ($events as $e)
            <tr class="border-t">
                <td class="p-3 font-medium">{{ $e['judul'] }}<div class="text-xs text-slate-500">{{ implode(', ', $e['kategori']) }}</div></td>
                <td class="p-3">{{ $e['kampus']['singkatan'] }}</td>
                <td class="p-3">{{ $e['organizer']['nama'] }}</td>
                <td class="p-3">{{ $e['mulai']->format('d M Y H:i') }}</td>
                <td class="p-3"><span class="px-2 py-1 rounded text-xs {{ $e['status'] === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $e['status'] }}</span></td>
                <td class="p-3 flex gap-2">
                    <a class="text-indigo-600" href="{{ route('admin.tiket.index', $e['id']) }}">Tiket</a>
                    <a class="text-slate-600" href="{{ route('admin.events.edit', $e['id']) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.events.destroy', $e['id']) }}" onsubmit="return confirm('Hapus event ini beserta tiketnya?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="p-6 text-center text-slate-500">Belum ada event.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $events->withQueryString()->links() }}</div>
</div>
@endsection
