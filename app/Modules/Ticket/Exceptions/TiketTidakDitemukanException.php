<?php

namespace App\Modules\Ticket\Exceptions;

use Exception;
use Illuminate\Http\Request;

class TiketTidakDitemukanException extends Exception
{
    public function __construct()
    {
        parent::__construct('Tiket yang Anda pilih tidak ditemukan atau sudah tidak tersedia.');
    }

    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $this->getMessage()], 404);
        }

        return back()->withErrors(['tiket_id' => $this->getMessage()]);
    }
}
