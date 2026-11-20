<div>
    <label class="block text-sm font-medium mb-1">Nama tiket</label>
    <input name="nama" value="{{ old('nama', $tiket['nama'] ?? '') }}" class="w-full border rounded-lg px-3 py-2" required>
</div>
<div>
    <label class="block text-sm font-medium mb-1">Tipe</label>
    <select name="tipe" class="w-full border rounded-lg px-3 py-2">
        @foreach (['umum' => 'Umum', 'mahasiswa' => 'Mahasiswa'] as $val => $label)
            <option value="{{ $val }}" @selected(old('tipe', $tiket['tipe'] ?? 'umum') === $val)>{{ $label }}</option>
        @endforeach
    </select>
</div>
<div class="grid grid-cols-2 gap-3">
    <div>
        <label class="block text-sm font-medium mb-1">Harga (Rp)</label>
        <input type="number" min="0" name="harga" value="{{ old('harga', $tiket['harga'] ?? 0) }}" class="w-full border rounded-lg px-3 py-2" required>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Kuota</label>
        <input type="number" min="1" name="kuota" value="{{ old('kuota', $tiket['kuota'] ?? 50) }}" class="w-full border rounded-lg px-3 py-2" required>
    </div>
</div>
