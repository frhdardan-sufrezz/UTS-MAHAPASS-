@extends('layouts.app')
@section('title', $event['judul'])
@section('content')
@php
    $ikon = in_array('Konser', $event['kategori']) ? '🎤' : '🏆';
@endphp

<div class="max-w-7xl mx-auto px-4 py-6">
    <a href="{{ route('katalog.index') }}" class="text-sm font-semibold text-[#12295c]">&larr; Semua event</a>

    <div class="mt-3 rounded-2xl overflow-hidden shadow">
        @if ($event['poster_url'])
            <div class="bg-slate-900 p-4 md:p-6">
                <img src="{{ $event['poster_url'] }}" alt="{{ $event['judul'] }}" class="mx-auto w-auto max-h-[32rem] rounded-xl object-contain shadow-2xl">
            </div>
        @else
            <div class="h-52 md:h-64 bg-gradient-to-br from-[#12295c] via-indigo-600 to-fuchsia-500 grid place-items-center text-white text-center p-4">
                <div><div class="text-7xl">{{ $ikon }}</div><div class="mt-2 font-bold tracking-widest">{{ $event['kampus']['nama'] }}</div></div>
            </div>
        @endif
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mt-6">
        <div class="lg:col-span-2 bg-white rounded-2xl shadow p-6">
            <div class="flex flex-wrap gap-2 mb-3">
                @foreach ($event['kategori'] as $k)
                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-indigo-100 text-indigo-700">{{ $k }}</span>
                @endforeach
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900">{{ $event['judul'] }}</h1>

            <div class="mt-4 grid sm:grid-cols-2 gap-3 text-sm">
                <div class="flex gap-3"><span class="text-xl">📅</span><div><p class="font-semibold">{{ $event['mulai']->format('d M Y') }}</p><p class="text-slate-500">{{ $event['mulai']->format('H:i') }} - {{ $event['selesai']->format('H:i') }} WIB</p></div></div>
                <div class="flex gap-3"><span class="text-xl">📍</span><div><p class="font-semibold">{{ $event['lokasi'] }}</p><p class="text-slate-500">{{ $event['kampus']['nama'] }}</p></div></div>
                <div class="flex gap-3"><span class="text-xl">🎓</span><div><p class="font-semibold">{{ $event['organizer']['nama'] }}</p><p class="text-slate-500">Penyelenggara ({{ $event['organizer']['jenis'] }})</p></div></div>
            </div>

            <h2 class="mt-6 font-bold text-lg">Deskripsi</h2>
            <p class="mt-2 whitespace-pre-line text-slate-700">{{ $event['deskripsi'] }}</p>
        </div>

        <aside class="space-y-3 lg:sticky lg:top-24 self-start">
            <h2 class="font-bold text-lg">Pilih Tiket</h2>
            @forelse ($tikets as $t)
                <div class="bg-white rounded-2xl shadow p-4 border-l-4 {{ $t['tipe'] === 'mahasiswa' ? 'border-emerald-500' : 'border-[#12295c]' }}">
                    <div class="flex justify-between items-start gap-2">
                        <div>
                            <p class="font-semibold">{{ $t['nama'] }}</p>
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $t['tipe'] === 'mahasiswa' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ ucfirst($t['tipe']) }}</span>
                        </div>
                        <p class="font-extrabold text-[#12295c]">{{ $t['harga'] > 0 ? 'Rp '.number_format($t['harga'], 0, ',', '.') : 'Gratis' }}</p>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">Sisa kuota: {{ $t['sisa'] }} / {{ $t['kuota'] }}</p>
                    @if ($t['tipe'] === 'mahasiswa')
                        <p class="text-xs text-emerald-700 mt-1">Tiket mahasiswa hanya boleh dibeli 1 buah.</p>
                    @endif

                    @if ($t['sisa'] === 0)
                        <button disabled class="mt-3 w-full py-2.5 rounded-full bg-slate-200 text-slate-500 cursor-not-allowed font-semibold">Habis terjual</button>
                    @elseif (! auth()->check())
                        <a href="{{ route('login') }}" class="mt-3 block text-center py-2.5 rounded-full bg-[#12295c] text-white font-semibold">Masuk untuk membeli</a>
                    @elseif (auth()->user()->role === 'peserta')
                        <form method="POST" action="{{ route('pendaftaran.store') }}" class="mt-3 flex gap-2">
                            @csrf
                            <input type="hidden" name="tiket_id" value="{{ $t['id'] }}">
                            @if ($t['tipe'] === 'mahasiswa')
                                <input type="hidden" name="jumlah" value="1">
                            @else
                                <input type="number" name="jumlah" value="1" min="1" max="{{ $t['sisa'] }}" class="w-20 border rounded-full px-3 py-2 text-center" aria-label="Jumlah tiket"
                                    oninvalid="this.setCustomValidity(this.validity.rangeOverflow ? 'Jumlah tidak boleh lebih dari {{ $t['sisa'] }} (sisa kuota).' : (this.validity.rangeUnderflow ? 'Jumlah minimal 1 tiket.' : 'Isi jumlah tiket dengan angka.'))"
                                    oninput="this.setCustomValidity('')">
                            @endif
                            <button class="flex-1 py-2.5 rounded-full bg-[#12295c] text-white font-semibold hover:bg-indigo-800">Beli Tiket</button>
                        </form>
                    @else
                        <p class="mt-3 text-xs text-slate-500">Masuk sebagai peserta untuk membeli tiket.</p>
                    @endif
                </div>
            @empty
                <p class="text-slate-500">Tiket belum tersedia.</p>
            @endforelse
        </aside>
    </div>
</div>
@endsection
