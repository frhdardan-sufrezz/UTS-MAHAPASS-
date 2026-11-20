<?php

namespace App\Modules\Registration\Exceptions;

use Exception;
use Illuminate\Http\Request;

/** Pelanggaran aturan tiket mahasiswa: maksimal 1 tiket mahasiswa per transaksi. */
class TiketMahasiswaException extends Exception
{
    public static function maksimalSatu(): self
    {
        return new self('Tiket mahasiswa hanya boleh dibeli 1 buah.');
    }

    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $this->getMessage()], 422);
        }

        return back()->withInput()->withErrors(['tiket_mahasiswa' => $this->getMessage()]);
    }
}
