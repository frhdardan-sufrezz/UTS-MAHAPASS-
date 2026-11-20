@extends('layouts.app')
@section('title', 'Daftar')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
<div class="max-w-md mx-auto bg-white rounded-xl shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Akun Peserta</h1>
    <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Nama lengkap</label>
            <input name="name" value="{{ old('name') }}" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Ulangi password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded-lg px-3 py-2" required>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Kampus</label>
            <input name="kampus" value="{{ old('kampus') }}" placeholder="AMIKOM Yogyakarta" class="w-full border rounded-lg px-3 py-2">
        </div>
        <button class="w-full py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Daftar</button>
    </form>
</div>
</div>
@endsection
