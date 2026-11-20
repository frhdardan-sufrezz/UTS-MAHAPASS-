@extends('layouts.app')
@section('title', 'Edit Tiket')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
<div class="max-w-md mx-auto bg-white rounded-xl shadow p-6">
    <h1 class="text-xl font-bold mb-1">Edit Tiket</h1>
    <p class="text-sm text-slate-500 mb-4">Sudah terjual: {{ $tiket['terjual'] }}</p>
    <form method="POST" action="{{ route('admin.tiket.update', $tiket['id']) }}" class="space-y-3">
        @csrf @method('PUT')
        @include('ticket::admin._fields')
        <div class="flex gap-2">
            <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Simpan</button>
            <a href="{{ route('admin.tiket.index', $tiket['event_id']) }}" class="px-4 py-2 rounded-lg bg-slate-200">Batal</a>
        </div>
    </form>
</div>
</div>
@endsection
