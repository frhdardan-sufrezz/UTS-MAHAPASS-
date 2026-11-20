@extends('layouts.app')
@section('title', 'Konser & Lomba Mahasiswa Jogja')
@section('content')

{{-- HERO --}}
<section class="relative overflow-hidden">
    @php
        // [gradien, poster, judul, teks, query link, tombol]
        $slides = [
            ['from-teal-700 via-cyan-700 to-[#12295c]', 'images/posters/ceremonasi.jpg', 'Konser Kampus Jogja', 'Line-up band terbaik tampil live di UII. 20 Desember 2026.', ['kategori' => 'konser'], 'Lihat Konser'],
            ['from-[#12295c] via-blue-700 to-sky-500', 'images/posters/uiux.jpg', 'UI/UX Design Competition', 'Lomba desain FinTech & kemudahan finansial oleh AMCC AMIKOM. Daftar 20-26 Desember 2026, HTM Rp10.000.', ['q' => 'UI/UX'], 'Lihat Lomba'],
            ['from-blue-700 via-indigo-700 to-fuchsia-600', 'images/posters/mlbb.jpg', 'Pesta Esport MLBB Jogja 2026', 'Kumpulkan timmu dan bertanding di Mobile Legends bersama UTY.', ['q' => 'MLBB'], 'Lihat Event'],
            ['from-yellow-500 via-blue-700 to-[#12295c]', 'images/posters/trailrun.jpg', 'UII Trail Run 2026', 'Run, Edu, Care! Pilih kategori 7K, 15K, 30K, 50K, atau 77K Relay bersama MAPALA Unisi.', ['q' => 'Trail Run'], 'Lihat Lomba'],
        ];
    @endphp
    <div id="hero" class="relative h-64 md:h-80">
        @foreach ($slides as $i => [$grad, $poster, $judul, $teks, $q, $cta])
            <div data-slide class="absolute inset-0 bg-gradient-to-br {{ $grad }} transition-opacity duration-700 {{ $i === 0 ? 'opacity-100' : 'opacity-0 pointer-events-none' }}">
                <div class="max-w-7xl mx-auto px-6 h-full flex items-center justify-between gap-6">
                    <div class="text-white max-w-xl">
                        <h1 class="text-2xl md:text-5xl font-extrabold leading-tight">{{ $judul }}</h1>
                        <p class="mt-3 text-white/90 text-sm md:text-lg hidden sm:block">{{ $teks }}</p>
                        <a href="{{ route('katalog.index', $q) }}" class="inline-block mt-5 px-6 py-3 rounded-full bg-white text-[#12295c] font-bold shadow">{{ $cta }}</a>
                    </div>
                    <img src="{{ asset($poster) }}" alt="Poster {{ $judul }}" class="h-44 md:h-72 w-auto shrink-0 rounded-xl object-cover shadow-2xl ring-4 ring-white/70 rotate-2">
                </div>
            </div>
        @endforeach
        <div class="absolute bottom-3 left-6 flex gap-2">
            @foreach ($slides as $i => $s)
                <button data-dot="{{ $i }}" class="w-2.5 h-2.5 rounded-full bg-white {{ $i === 0 ? '' : 'opacity-50' }}" aria-label="Slide {{ $i + 1 }}"></button>
            @endforeach
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 py-8">
    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-4">📣 Event Seru Untukmu</h2>

    {{-- Filter --}}
    @php $qs = request()->except('kategori', 'page'); @endphp
    <div class="flex flex-wrap items-center gap-2 mb-6">
        <a href="{{ route('katalog.index', $qs) }}" class="px-4 py-2 rounded-full border text-sm font-semibold {{ request('kategori') ? 'bg-white text-slate-600' : 'bg-[#12295c] text-white border-[#12295c]' }}">Semua</a>
        <a href="{{ route('katalog.index', $qs + ['kategori' => 'konser']) }}" class="px-4 py-2 rounded-full border text-sm font-semibold {{ request('kategori') === 'konser' ? 'bg-[#12295c] text-white border-[#12295c]' : 'bg-white text-slate-600' }}">🎤 Konser</a>
        <a href="{{ route('katalog.index', $qs + ['kategori' => 'lomba']) }}" class="px-4 py-2 rounded-full border text-sm font-semibold {{ request('kategori') === 'lomba' ? 'bg-[#12295c] text-white border-[#12295c]' : 'bg-white text-slate-600' }}">🏆 Lomba</a>

        <form method="GET" class="ml-auto flex gap-2">
            @if (request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif
            @if (request('kategori'))<input type="hidden" name="kategori" value="{{ request('kategori') }}">@endif
            <select name="kampus_id" onchange="this.form.submit()" class="border rounded-full px-4 py-2 text-sm bg-white">
                <option value="">Semua kampus</option>
                @foreach ($kampusList as $id => $nama)
                    <option value="{{ $id }}" @selected(request('kampus_id') == $id)>{{ $nama }}</option>
                @endforeach
            </select>
        </form>
    </div>

    @php
        $gradients = [
            'from-indigo-500 to-purple-600', 'from-rose-500 to-orange-500', 'from-emerald-500 to-teal-600',
            'from-sky-500 to-blue-700', 'from-fuchsia-500 to-pink-600',
        ];
    @endphp

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse ($events as $e)
            @php
                $ikon = in_array('Konser', $e['kategori']) ? '🎤' : '🏆';
                $hargaMulai = $harga[$e['id']] ?? null;
            @endphp
            <a href="{{ route('katalog.show', $e['id']) }}" class="group block">
                <div class="relative aspect-[4/5] rounded-xl overflow-hidden shadow-sm group-hover:shadow-lg transition">
                    @if ($e['poster_url'])
                        <img src="{{ $e['poster_url'] }}" alt="{{ $e['judul'] }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br {{ $gradients[$e['id'] % count($gradients)] }} grid place-items-center text-white p-3 text-center">
                            <div>
                                <div class="text-5xl">{{ $ikon }}</div>
                                <div class="mt-1 text-xs font-bold tracking-wider opacity-90">{{ $e['kampus']['singkatan'] }}</div>
                            </div>
                        </div>
                    @endif
                    @if ($hargaMulai === 0)
                        <span class="absolute top-2 left-2 text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-600 text-white">🏷 Gratis</span>
                    @else
                        <span class="absolute top-2 left-2 text-xs font-bold px-2.5 py-1 rounded-full bg-white/90 text-[#12295c]">{{ implode(' & ', $e['kategori']) }}</span>
                    @endif
                </div>
                <p class="mt-3 text-sm text-slate-500">{{ $e['lokasi'] }}</p>
                <h3 class="mt-0.5 font-bold text-lg leading-snug line-clamp-2 text-slate-900">{{ $e['judul'] }}</h3>
                <p class="text-sm text-slate-500 mt-1">Oleh {{ $e['organizer']['nama'] }}</p>
                <p class="text-sm text-slate-500">{{ $e['kampus']['singkatan'] }} &bull; {{ $e['mulai']->format('d M Y') }}</p>
                <p class="mt-1 font-bold text-[#12295c]">
                    @if ($hargaMulai === null) Segera hadir
                    @elseif ($hargaMulai === 0) Gratis
                    @else Mulai Rp {{ number_format($hargaMulai, 0, ',', '.') }}
                    @endif
                </p>
            </a>
        @empty
            <p class="col-span-full text-center text-slate-500 py-16">Belum ada event yang cocok dengan pencarian Anda.</p>
        @endforelse
    </div>

    <div class="mt-8">{{ $events->withQueryString()->links() }}</div>
</div>

<script>
    (function () {
        const slides = document.querySelectorAll('[data-slide]');
        const dots = document.querySelectorAll('[data-dot]');
        let cur = 0, timer;
        function show(i) {
            cur = i;
            slides.forEach((s, n) => {
                s.classList.toggle('opacity-100', n === i);
                s.classList.toggle('opacity-0', n !== i);
                s.classList.toggle('pointer-events-none', n !== i);
            });
            dots.forEach((d, n) => d.classList.toggle('opacity-50', n !== i));
        }
        function start() { timer = setInterval(() => show((cur + 1) % slides.length), 5000); }
        dots.forEach((d, n) => d.addEventListener('click', () => { clearInterval(timer); show(n); start(); }));
        start();
    })();
</script>
@endsection
