<?php

namespace App\Modules\Event\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/** Validasi form pencarian event di halaman Admin (GET). */
class FilterEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'q.max' => 'Kata kunci pencarian maksimal 100 karakter.',
            'page.integer' => 'Nomor halaman harus berupa angka.',
        ];
    }
}
