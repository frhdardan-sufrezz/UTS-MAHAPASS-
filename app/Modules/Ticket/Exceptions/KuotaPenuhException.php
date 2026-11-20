<?php

namespace App\Modules\Ticket\Exceptions;

use Exception;
use Illuminate\Http\Request;

class KuotaPenuhException extends Exception
{
    public function __construct(public readonly int $sisa = 0)
    {
        parent::__construct(
            $sisa > 0
                ? "Kuota tidak mencukupi. Sisa tiket yang tersedia: {$sisa}. Kurangi jumlah pembelian Anda."
                : 'Maaf, tiket sudah habis terjual (kuota penuh). Silakan pilih tipe tiket atau event lain.'
        );
    }

    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $this->getMessage(), 'sisa' => $this->sisa], 409);
        }

        return back()->withInput()->withErrors(['kuota' => $this->getMessage()]);
    }
}
