<?php

namespace App\Modules\Registration\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:100'],
            'kampus' => ['nullable', 'string', 'max:100'],
            'no_hp' => ['nullable', 'string', 'regex:/^(\+62|0)[0-9]{8,13}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi.',
            'no_hp.regex' => 'Nomor HP harus diawali 08 atau +62 dan berisi 10-15 digit.',
        ];
    }
}
