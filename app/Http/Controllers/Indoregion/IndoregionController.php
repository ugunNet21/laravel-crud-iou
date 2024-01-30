<?php

namespace App\Http\Controllers\Indoregion;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;

class IndoregionController extends Controller
{
    public function getAllWilayah()
    {

        $provinces = Province::all();
        $regencies = Regency::all();
        $districts = District::all();
        $villages = Village::all();
        return response()->json([$provinces, $regencies, $districts, $villages]);

        // return view('indoreg.form', compact("provinces", "regencies", "districts", "villages"));
    }

    // by
    public function getDistrictsByVillages(Request $request)
    {
        // $villageId = $request->input('village_id');
        $regencyId = 3273;
        $request->validate([
            'village_id' => 'required|integer|exists:villages,id',
        ]);

        try {
            $districts = Regency::findOrFail($regencyId)->districts;
            return response()->json(['districts' => $districts]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data not found.'], 404);
        }
    }
    public function getVillagesByDistrict(Request $request)
    {
        $districtId = $request->input('district_id');
        $request->validate([
            'district_id' => 'required|integer|exists:districts,id',
        ]);

        try {
            $villages = District::findOrFail($districtId)->villages;
            return response()->json(['villages' => $villages]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data not found.'], 404);
        }
    }
    public function getRegenciesByProvince(Request $request)
    {
        try {
            $provinceId = $request->input('province_id');
            $regencies = Regency::where('province_id', $provinceId)->get();

            return response()->json($regencies);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    // digunakan
    public function cekJson()
    {
        $filePath = storage_path('app/IndoregionResponse.json');
        $data = file_get_contents($filePath);
        $data = json_decode($data, true);
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $data,
        ], 200);

        // return view('indoreg.indoreg-json', ['data' => $data]);

    }
    public function getRegencies(Request $request)
    {
        $provinceId = $request->input('province_id');
        $request->validate([
            'province_id' => 'required|integer|exists:provinces,id',
        ]);

        try {
            $regencies = Province::findOrFail($provinceId)->regencies;
            return response()->json(['regencies' => $regencies]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data not found.'], 404);
        }
    }
    public function getDistricts(Request $request)
    {
        $regencyId = $request->input('regency_id');
        $request->validate([
            'regency_id' => 'required|integer|exists:regencies,id',
        ]);
        try {
            $districts = Regency::findOrFail($regencyId)->districts;
            return response()->json(['districts' => $districts]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data not found.'], 404);
        }

    }
    public function getVillages(Request $request)
    {
        $districtId = $request->input('district_id');
        $request->validate([
            'district_id' => 'required|integer|exists:districts,id',
        ]);
        try {
            $villages = District::findOrFail($districtId)->villages;
            return response()->json(['villages' => $villages]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data not found.'], 404);
        }

    }

    // coba ini bisa json
    public function getDistrictByVillage(Request $request)
    {
        // Validasi inputan kelurahan
        $request->validate([
            'village_name' => 'required|string',
        ]);

        // Cari kelurahan berdasarkan nama
        $village = Village::where('name', $request->village_name)->first();

        if ($village) {
            // Dapatkan kecamatan terkait
            $district = $village->district;

            if ($district) {
                return response()->json([
                    'status' => 200,
                    'message' => 'success',
                    'district' => $district,
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Kecamatan tidak ditemukan untuk kelurahan yang diberikan.',
                ], 404);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Kelurahan tidak ditemukan.',
            ], 404);
        }
    }
    public function getVillage()
    {
        $provinceCode = 32;
        $regencyCode = 3273;

        $villages = Village::whereHas('district.regency', function ($query) use ($provinceCode, $regencyCode) {
            $query->where('province_id', $provinceCode)
                ->where('id', $regencyCode);
        })->orderBy('id')->get(['id', 'name']);
        // parsing ke objek

        // return response()->json([
        //     'status' => 200,
        //     'data' => $villages,
        // ]);
        return view('get_district_by_village', compact('villages'));
    }
    public function getDistrict()
    {
        $regencyCode = 3273;

        $districts = District::where('regency_id', $regencyCode)->orderBy('id')->get(['id', 'name']);

        // return response()->json([
        //     'status' => 200,
        //     'data' => $districts,
        // ]);
        return view('get_district_by_village', compact('districts'));
    }

    // ini bisa manual get kelurahan get kecamatan
    public function showDropdown()
    {
        $provinceCode = 32;
        $regencyCode = 3273;

        $villages = Village::whereHas('district.regency', function ($query) use ($provinceCode, $regencyCode) {
            $query->where('province_id', $provinceCode)
                ->where('id', $regencyCode);
        })->orderBy('id')->get(['id', 'name']);

        $districts = District::where('regency_id', $regencyCode)->orderBy('id')->get(['id', 'name']);

        return view('get_district_by_village', compact('villages', 'districts'));
    }

    // coba ini bisa
    // public function showDropdown(Request $request)
    // {

    //     $provinceCode = 32;
    //     $regencyCode = 3273;

    //     // Ambil kelurahan berdasarkan kode provinsi dan kabupaten
    //     $villages = Village::whereHas('district.regency', function ($query) use ($provinceCode, $regencyCode) {
    //         $query->where('province_id', $provinceCode)
    //             ->where('id', $regencyCode);
    //     })->orderBy('id')->get(['id', 'name']);
    //     // jika data province dan regency sudah ditemukan, cari kecamatan dengan cara menginputkan kelurahan
    //     if (!is_null($request->village_code)) {
    //         $villages = Village::with('district')
    //             ->whereHas('district', function ($query) use ($request) {
    //                 $query->where('id', $request->district_code);
    //             })->orWhere('id', $request->village_code)->get();
    //         foreach ($villages as $village) {
    //             if (!is_null($village->district)) {
    //                 $data[] = [
    //                     "text" => $village->name . " (" . ucwords($village->district->name) . ")",
    //                     "value" => $village->id,
    //                 ];
    //             }
    //         }
    //         return response()->json([
    //             'status' => 200,
    //             'data' => $data ?? [],
    //         ]);
    //     } else {

    //         $datas = [];
    //         foreach ($villages as $village) {
    //             $datas[] = [
    //                 'id' => $village->id,
    //                 'text' => "{$village->id}. {$village->name}",

    //             ];
    //         }
    //         return view('get_district_by_village', compact('datas'));
    //     }

    // }

    // public function showDropdown(Request $request)
    // {
    //     $provinceCode = 32;
    //     $regencyCode = 3273;

    //     // Ambil kecamatan berdasarkan kode provinsi dan kabupaten
    //     $districts = District::where('regency_id', $regencyCode)->get(['id', 'name']);

    //     // Jika tidak ada request village_code, maka tampilkan semua daftar kecamatan di Kabupaten/Kota yang dipilih
    //     if (!isset($request->village_code)) {
    //         // Format data untuk Select2
    //         $datas = [];
    //         foreach ($districts as $district) {
    //             $datas[] = [
    //                 'id' => $district->id,
    //                 'text' => "{$district->id}. {$district->name}",
    //             ];
    //         }

    //         return view('get_district_by_village', compact('datas'));
    //     } else {
    //         // Jika ada request village_code, maka tampilkan kecamatan berdasarkan kelurahan yang dipilih
    //         $villageCode = $request->village_code;
    //         $village = Village::find($villageCode);

    //         if ($village) {
    //             // Ambil kecamatan berdasarkan kelurahan yang dipilih
    //             $district = $village->district;

    //             return response()->json([
    //                 'status' => 200,
    //                 'message' => 'success',
    //                 'data' => [
    //                     'id' => $district->id,
    //                     'name' => $district->name,
    //                 ],
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status' => 404,
    //                 'message' => 'Kelurahan tidak ditemukan',
    //             ], 404);
    //         }
    //     }
    // }
}
