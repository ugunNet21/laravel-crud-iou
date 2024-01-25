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

        return view('indoreg.form', compact("provinces", "regencies", "districts", "villages"));
    }
    public function getRegenciesByProvince(Request $request)
    {
        try {
            $provinceId = $request->input('province_id');

            // Log::info('Province ID: ' . $provinceId);
            $regencies = Regency::where('province_id', $provinceId)->get();

            return response()->json($regencies);
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            // Log::error('Error in getRegenciesByProvince: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function getDistrictsByRegency(Request $request)
    {
        $regencyId = $request->input('regency_id');
        $districts = District::where('regency_id', $regencyId)->get();

        return response()->json($districts);
    }

    public function getVillagesByDistrict(Request $request)
    {
        $districtId = $request->input('district_id');
        $villages = Village::where('district_id', $districtId)->get();

        return response()->json($villages);
    }
    public function cekJson()
    {
        $filePath = storage_path('app/IndoregionResponse.json');
        $data = file_get_contents($filePath);
        $data = json_decode($data, true);
        // dd($data);
        // foreach ($data['provinces'] as $province) {
        //     echo $province['id'] . ' - ' . $province['name'] . '<br>';
        // }
        // foreach ($data['regencies'] as $regencies) {
        //     echo $regencies['id'] . ' - ' . $regencies['name'] . '<br>';
        // }
        // foreach ($data['districts'] as $districts) {
        //     echo $districts['id'] . ' - ' . $districts['name'] . '<br>';
        // }
        return view('indoreg.indoreg-json', ['data' => $data]);

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
        $districtId = $request->input('regency_id');
        $request->validate([
            'regency_id' => 'required|integer|exists:regencies,id',
        ]);
        try {
            $districts = Regency::findOrFail($districtId)->districts;
            return response()->json(['districts' => $districts]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data not found.'], 404);
        }

    }
    public function getVillages(Request $request)
    {
        $districtId  = $request->input('district_id');
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

}
