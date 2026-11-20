@extends('layouts.app')
@section('title', 'Profil')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
<div class="max-w-md mx-auto bg-white rounded-xl shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Profil Peserta</h1>
    <form method="POST" action="{{ route('profil.update') }}" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium mb-1">Nama</label>
            <input name="nama" value="{{ old('nama', $peserta->nama) }}" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Kampus</label>
            <input name="kampus" value="{{ old('kampus', $peserta->kampus) }}" class="w-full border rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">No. HP</label>
            <input name="no_hp" value="{{ old('no_hp', $peserta->no_hp) }}" class="w-full border rounded-lg px-3 py-2">
        </div>
        <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Simpan</button>
    </form>
</div>
</div>
@endsection
