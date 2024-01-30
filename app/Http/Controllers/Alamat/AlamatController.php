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

        return view('alamat.hasil-alamat')->with('alamatLengkap', $alamatLengkap);
    }
    public function getKecamatans()
    {

        $kecamatans = kelurahan::all();

        return response()->json($kecamatans);
    }

    public function getKelurahans($kecamatan_id)
    {
        $kelurahans = kelurahan::all();

        return response()->json($kelurahans);
    }

    public function getKelurahan(Request $request)
    {

        // $villageName = $request->input('village_name');


        // $village = DB::table('indonesia_villages')
        //     ->where('code', $villageName)
        //     ->first();

        // if ($village) {

        //     $districtName = DB::table('indonesia_districts')
        //         ->where('code', $village->district_id)
        //         ->value('name_districts');


        //     return response()->json(['district_name' => $districtName]);
        // } else {

        //     return response()->json(['error' => 'Kelurahan not found'], 404);
        // }

         // Ambil data input dari request
        $provinceCode = 32;
        $cityCode = 3273;

        // Cari kelurahan berdasarkan kode provinsi dan kode kota
        $kelurahan = DB::table('indonesia_villages')
                        ->where('code', $provinceCode)
                        ->where('code', $cityCode)
                        ->get();

        return response()->json(['kelurahan' => $kelurahan]);
        }
        public function getDistrictByVillage(Request $request)
    {
        // Ambil nama kelurahan dari permintaan pengguna
        $villageName = $request->input('village_name');

        // Cari kelurahan berdasarkan nama
        $village = DB::table('indonesia_villages')->where('name_village', 'like', '%' . $villageName . '%')->first();

        if ($village) {
            // Ambil kecamatan berdasarkan kelurahan
            $district = DB::table('indonesia_districts')->where('code', $village->district_code)->first();

            if ($district) {
                return response()->json(['district_name' => $district->name_districts]);
            } else {
                return response()->json(['error' => 'District not found for this village'], 404);
            }
        } else {
            return response()->json(['error' => 'Village not found'], 404);
        }
    }

}
