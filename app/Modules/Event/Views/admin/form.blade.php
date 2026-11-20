@extends('layouts.app')
@section('title', $event ? 'Edit Event' : 'Event Baru')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
@php
    $action = $event ? route('admin.events.update', $event['id']) : route('admin.events.store');
    $fmt = fn ($d) => $d ? $d->format('Y-m-d\TH:i') : '';
    $kategoriDipilih = old('kategori_ids', $event['kategori_ids'] ?? []);
@endphp
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
    <h1 class="text-2xl font-bold mb-4">{{ $event ? 'Edit Event' : 'Event Baru' }}</h1>
    <form method="POST" action="{{ $action }}" class="space-y-4">
        @csrf
        @if ($event) @method('PUT') @endif

        <div>
            <label class="block text-sm font-medium mb-1">Judul</label>
            <input name="judul" value="{{ old('judul', $event['judul'] ?? '') }}" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="4" class="w-full border rounded-lg px-3 py-2" required>{{ old('deskripsi', $event['deskripsi'] ?? '') }}</textarea>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium mb-1">Penyelenggara</label>
                <select name="organizer_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">- pilih -</option>
                    @foreach ($organizers as $id => $nama)
                        <option value="{{ $id }}" @selected(old('organizer_id', $event['organizer_id'] ?? '') == $id)>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Kampus</label>
                <select name="kampus_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">- pilih -</option>
                    @foreach ($kampusList as $id => $nama)
                        <option value="{{ $id }}" @selected(old('kampus_id', $event['kampus_id'] ?? '') == $id)>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Lokasi</label>
            <input name="lokasi" value="{{ old('lokasi', $event['lokasi'] ?? '') }}" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">URL Poster <span class="text-slate-400">(opsional)</span></label>
            <input type="text" name="poster_url" value="{{ old('poster_url', $event['poster_url'] ?? '') }}" placeholder="https://... atau /images/posters/nama.jpg" class="w-full border rounded-lg px-3 py-2">
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium mb-1">Mulai</label>
                <input type="datetime-local" name="mulai" value="{{ old('mulai', $fmt($event['mulai'] ?? null)) }}" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Selesai</label>
                <input type="datetime-local" name="selesai" value="{{ old('selesai', $fmt($event['selesai'] ?? null)) }}" class="w-full border rounded-lg px-3 py-2" required>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Kategori</label>
            <div class="flex flex-wrap gap-4">
                @foreach ($kategoriList as $id => $nama)
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="kategori_ids[]" value="{{ $id }}" @checked(in_array($id, $kategoriDipilih))> {{ $nama }}
                    </label>
                @endforeach
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Status</label>
            <select name="status" class="w-full border rounded-lg px-3 py-2">
                @foreach (['draft', 'published'] as $s)
                    <option value="{{ $s }}" @selected(old('status', $event['status'] ?? 'draft') === $s)>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2">
            <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Simpan</button>
            <a href="{{ route('admin.events.index') }}" class="px-4 py-2 rounded-lg bg-slate-200">Batal</a>
        </div>
    </form>
</div>
</div>
@endsection
