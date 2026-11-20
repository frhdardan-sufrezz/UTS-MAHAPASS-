@extends('layouts.app')
@section('title', 'Tidak ditemukan')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
<div class="max-w-lg mx-auto bg-white rounded-xl shadow p-8 text-center">
    <p class="text-5xl font-bold text-slate-400">404</p>
    <h1 class="text-xl font-semibold mt-2">Halaman tidak ditemukan</h1>
    <p class="text-slate-600 mt-2">{{ $exception->getMessage() ?: 'Data yang Anda cari tidak ada.' }}</p>
    <a href="{{ url('/') }}" class="inline-block mt-6 px-4 py-2 bg-indigo-600 text-white rounded-lg">Kembali ke beranda</a>
</div>
</div>
@endsection
