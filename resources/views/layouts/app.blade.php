<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Beranda') - {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-slate-800 min-h-screen flex flex-col">

<header class="bg-white border-b sticky top-0 z-30">
    <div class="max-w-7xl mx-auto px-4 py-3 flex flex-wrap items-center gap-3 md:gap-5">
        <a href="{{ route('katalog.index') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="h-9 w-auto">
            <span class="text-xl font-extrabold tracking-wide text-[#12295c]">{{ strtoupper(config('app.name')) }}</span>
        </a>

        <details class="relative">
            <summary class="list-none cursor-pointer font-semibold text-[#12295c] select-none">&#9638; Kategori</summary>
            <div class="absolute mt-3 w-48 bg-white border rounded-xl shadow-lg p-2">
                <a href="{{ route('katalog.index', ['kategori' => 'konser']) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">🎤 Konser</a>
                <a href="{{ route('katalog.index', ['kategori' => 'lomba']) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">🏆 Lomba</a>
            </div>
        </details>

        <form action="{{ route('katalog.index') }}" method="GET" class="order-last md:order-none flex-1 min-w-full md:min-w-0">
            <div class="flex items-center bg-slate-100 rounded-xl px-4 py-2.5">
                <input name="q" value="{{ request('q') }}" placeholder="Cari event, misal: Battle of Bands" class="bg-transparent flex-1 outline-none text-sm">
                <button class="text-slate-500" aria-label="Cari">&#128269;</button>
            </div>
        </form>

        @auth
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('admin.events.index') }}" class="hidden md:block text-sm font-semibold text-[#12295c]">Kelola Event</a>
                <a href="{{ route('admin.pendaftaran.index') }}" class="hidden md:block text-sm font-semibold text-[#12295c]">Pendaftaran</a>
            @endif
        @else
            <a href="{{ route('register') }}" class="hidden md:block text-sm font-semibold text-[#12295c]">Kerjasama dengan Kami</a>
        @endauth

        <details class="relative ml-auto md:ml-0">
            <summary class="list-none cursor-pointer select-none px-5 py-2.5 rounded-full bg-[#12295c] text-white font-semibold text-sm">
                &#9786; {{ auth()->check() ? \Illuminate\Support\Str::limit(auth()->user()->name, 14) : 'Akun' }}
            </summary>
            <div class="absolute right-0 mt-3 w-56 bg-white border rounded-xl shadow-lg p-2 text-sm">
                @auth
                    <p class="px-3 py-2 text-xs text-slate-500">{{ auth()->user()->email }} ({{ auth()->user()->role }})</p>
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.events.index') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">Kelola Event</a>
                        <a href="{{ route('admin.pendaftaran.index') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">Semua Pendaftaran</a>
                    @else
                        <a href="{{ route('tiket.saya') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">Tiket Saya</a>
                        <a href="{{ route('profil.edit') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">Profil</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left px-3 py-2 rounded-lg hover:bg-slate-100 text-red-600">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">Masuk</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">Daftar</a>
                @endauth
            </div>
        </details>
    </div>
</header>

<main class="flex-1 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 pt-4">@include('partials.alerts')</div>
    @yield('content')
</main>

<footer class="bg-[#12295c] text-slate-300 text-sm">
    <div class="max-w-7xl mx-auto px-4 py-6">
        &copy; {{ date('Y') }} {{ config('app.name') }} &mdash; Tiket konser &amp; lomba mahasiswa kampus swasta Yogyakarta.
    </div>
</footer>
</body>
</html>
