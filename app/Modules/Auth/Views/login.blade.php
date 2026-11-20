@extends('layouts.app')
@section('title', 'Masuk')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
<div class="max-w-md mx-auto bg-white rounded-xl shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Masuk</h1>
    <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded-lg px-3 py-2" required autofocus>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember" value="1"> Ingat saya</label>
        <button class="w-full py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Masuk</button>
    </form>
    <p class="text-sm text-slate-500 mt-4">Belum punya akun? <a class="text-indigo-600" href="{{ route('register') }}">Daftar</a></p>
</div>
</div>
@endsection
