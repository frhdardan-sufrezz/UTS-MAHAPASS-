<?php

namespace App\Modules\Ticket\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimpanTiketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:100'],
            'tipe' => ['required', 'in:umum,mahasiswa'],
            'harga' => ['required', 'integer', 'min:0', 'max:10000000'],
            'kuota' => ['required', 'integer', 'min:1', 'max:100000'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama tiket wajib diisi (contoh: Tiket Umum, Early Bird).',
            'tipe.required' => 'Tipe tiket wajib dipilih.',
            'tipe.in' => 'Tipe tiket harus umum atau mahasiswa.',
            'harga.required' => 'Harga wajib diisi (isi 0 untuk tiket gratis).',
            'harga.integer' => 'Harga harus berupa angka bulat tanpa titik/koma.',
            'harga.min' => 'Harga tidak boleh negatif.',
            'kuota.required' => 'Kuota wajib diisi.',
            'kuota.min' => 'Kuota minimal 1 tiket.',
        ];
    }
}
