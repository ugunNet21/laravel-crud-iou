<?php

namespace App\Http\Controllers\Pendaftaran;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function store(Request $request)
    {
        // Validasi formulir
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|numeric',
        ]);

        // Cek apakah terdapat ID dalam permintaan
        $requestData = $request->except('_token'); // Exclude _token from request data

        if (isset($requestData['id'])) {
            $pendaftaran = Pendaftaran::findOrFail($requestData['id']);
            $pendaftaran->update($requestData);
        } else {
            Pendaftaran::updateOrCreate(
                ['nama' => $requestData['nama']], // Kriteria untuk mencocokkan data yang ada
                $requestData
            );
        }

        return redirect()->route('pendaftaran.index');
    }

    public function index()
    {
        $pendaftaran = Pendaftaran::all();
        // dd($pendaftaran);
        return view('pendaftaran.index', compact('pendaftaran'));
    }
}
