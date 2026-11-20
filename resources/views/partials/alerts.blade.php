@if (session('success'))
    <div class="mb-4 rounded-lg border border-green-300 bg-green-50 p-3 text-green-800">{{ session('success') }}</div>
@endif
@if ($errors->any())
    <div class="mb-4 rounded-lg border border-red-300 bg-red-50 p-3 text-red-800">
        <p class="font-semibold">Terjadi kesalahan:</p>
        <ul class="list-disc ml-5 mt-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
