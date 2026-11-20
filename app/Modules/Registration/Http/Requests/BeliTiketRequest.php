<?php

namespace App\Modules\Registration\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BeliTiketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tiket_id' => ['required', 'integer'],
            'jumlah' => ['required', 'integer', 'min:1', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'tiket_id.required' => 'Pilih tiket yang ingin dibeli.',
            'jumlah.required' => 'Jumlah tiket wajib diisi.',
            'jumlah.integer' => 'Jumlah tiket harus berupa angka.',
            'jumlah.min' => 'Jumlah tiket minimal 1.',
            'jumlah.max' => 'Jumlah tiket per transaksi terlalu banyak (maksimal 1000).',
        ];
    }
}
