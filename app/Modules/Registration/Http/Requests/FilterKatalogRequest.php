<?php

namespace App\Modules\Registration\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/** Validasi form pencarian & filter katalog event (GET). */
class FilterKatalogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:100'],
            'kategori' => ['nullable', 'string', 'in:konser,lomba'],
            'kategori_id' => ['nullable', 'integer', 'min:1'],
            'kampus_id' => ['nullable', 'integer', 'min:1'],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'q.max' => 'Kata kunci pencarian maksimal 100 karakter.',
            'kategori.in' => 'Kategori tidak dikenal. Pilih Konser atau Lomba.',
            'kategori_id.integer' => 'Kategori tidak valid.',
            'kampus_id.integer' => 'Kampus tidak valid.',
            'page.integer' => 'Nomor halaman harus berupa angka.',
        ];
    }
}
