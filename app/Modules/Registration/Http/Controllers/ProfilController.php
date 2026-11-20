<?php

namespace App\Modules\Registration\Http\Controllers;

use App\Modules\Registration\Http\Requests\UpdateProfilRequest;
use App\Modules\Registration\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProfilController extends Controller
{
    public function edit(Request $request)
    {
        $peserta = Peserta::where('user_id', $request->user()->id)->firstOrFail();

        return $request->expectsJson()
            ? response()->json($peserta)
            : view('registration::profil', compact('peserta'));
    }

    public function update(UpdateProfilRequest $request)
    {
        $peserta = Peserta::where('user_id', $request->user()->id)->firstOrFail();
        $peserta->update($request->validated());

        return $request->expectsJson()
            ? response()->json(['message' => 'Profil diperbarui.', 'data' => $peserta])
            : redirect()->route('profil.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
