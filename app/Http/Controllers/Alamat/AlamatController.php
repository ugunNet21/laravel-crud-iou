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
}
