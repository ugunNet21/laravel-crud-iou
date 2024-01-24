<?php

namespace App\Http\Controllers\Alamat;

use App\Http\Controllers\Controller;
use App\Models\Alamat\Kelurahan;
use Illuminate\Http\Request;

class AlamatController extends Controller
{
    public function index()
    {
        $kelurahans = Kelurahan::all();
        return view('alamat.index', compact('kelurahans'));
    }

    public function getKecamatan($kelurahanId)
    {
        $kecamatan = Kelurahan::find($kelurahanId)->kecamatan;
        return response()->json($kecamatan);
    }
    // menggabungkan inputan ke dalam satu field
    public function prosesAlamat(Request $request)
    {
        $alamat_lembaga = $request->input('alamat_lembaga');
        $rt = $request->input('rt');
        $rw = $request->input('rw');
        $kelurahan = $request->input('kelurahan');
        $kecamatan = $request->input('kecamatan');

        $alamatLengkap = "Jl. $alamat_lembaga, Rt/RW: $rt/$rw, Kelurahan: $kelurahan, Kecamatan: $kecamatan";
        // return "Alamat lengkap: $alamatLengkap";
        return view('alamat.hasil-alamat')->with('alamatLengkap', $alamatLengkap);
    }
    public function getKecamatans()
    {
        // Ambil data kecamatans dari database
        $kecamatans = kelurahan::all();

        return response()->json($kecamatans);
    }

    public function getKelurahans($kecamatan_id)
    {
        // Ambil data kelurahans berdasarkan kecamatan_id dari database
        $kelurahans = kelurahan::all();

        return response()->json($kelurahans);
    }
}
