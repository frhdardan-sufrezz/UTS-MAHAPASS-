<?php

namespace App\Modules\Event\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimpanEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // akses dijaga middleware auth:sanctum + role:admin
    }

    public function rules(): array
    {
        return [
            'organizer_id' => ['required', 'integer', 'exists:organizers,id'],
            'kampus_id' => ['required', 'integer', 'exists:kampus,id'],
            'judul' => ['required', 'string', 'max:150'],
            'deskripsi' => ['required', 'string', 'min:20'],
            'lokasi' => ['required', 'string', 'max:150'],
            'poster_url' => ['nullable', 'string', 'max:500', 'regex:#^(https?://|/).+#i'],
            'mulai' => ['required', 'date'],
            'selesai' => ['required', 'date', 'after:mulai'],
            'status' => ['required', 'in:draft,published'],
            'kategori_ids' => ['required', 'array', 'min:1'],
            'kategori_ids.*' => ['integer', 'exists:kategoris,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'organizer_id.required' => 'Penyelenggara (UKM/Himpunan/Komunitas) wajib dipilih.',
            'organizer_id.exists' => 'Penyelenggara yang dipilih tidak ditemukan.',
            'kampus_id.required' => 'Kampus wajib dipilih.',
            'kampus_id.exists' => 'Kampus yang dipilih tidak ditemukan.',
            'judul.required' => 'Judul event wajib diisi.',
            'judul.max' => 'Judul event maksimal 150 karakter.',
            'deskripsi.required' => 'Deskripsi event wajib diisi.',
            'deskripsi.min' => 'Deskripsi minimal 20 karakter agar informatif.',
            'lokasi.required' => 'Lokasi event wajib diisi.',
            'poster_url.regex' => 'Poster tidak valid. Gunakan alamat lengkap (https://contoh.com/poster.jpg) atau path lokal (/images/posters/nama.jpg).',
            'mulai.required' => 'Waktu mulai wajib diisi.',
            'mulai.date' => 'Format waktu mulai tidak valid.',
            'selesai.required' => 'Waktu selesai wajib diisi.',
            'selesai.after' => 'Waktu selesai harus setelah waktu mulai.',
            'status.in' => 'Status harus draft atau published.',
            'kategori_ids.required' => 'Pilih minimal satu kategori.',
            'kategori_ids.min' => 'Pilih minimal satu kategori.',
        ];
    }
}
