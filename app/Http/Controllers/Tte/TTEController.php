<?php

namespace App\Http\Controllers\Tte;

use App\Http\Controllers\Controller;
use App\Http\Services\HttpTTE;
use App\Models\BSREData;
use Illuminate\Http\Request;

class TTEController extends Controller
{
    public function index()
    {
        $getBSRE = BSREData::all();
        return view('tte.cek-tte', compact('getBSRE'));
    }
    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'file_keterangan_dtks_sudtks' => 'required|file|mimes:pdf|max:2048', // Contoh validasi untuk file PDF maksimum 2MB
        ]);

        // Mendapatkan file PDF dari request
        $file = $request->file('file_keterangan_dtks_sudtks');
        $fileContent = file_get_contents($file->getRealPath());

        // Membuat instance dari class HttpTTE
        $httpTTE = new HttpTTE();

        // Data untuk dikirim ke layanan TTE
        $postData = [
            'file' => $file,
            'nik' => '3273192205690003', // NIK dari Kepala Bidang Data Informasi
            'passphrase' => '2205Edo.', // Passphrase dari Kepala Bidang Data Informasi
            'tampilan' => 'visible',
            'linkQR' => config('e-sign-bsre.url'), // Link QR untuk detail tampilan TTE
            'width' => 200,
            'height' => 150,
            'tag_koordinat' => 'a',
        ];

        // Melakukan proses HTTP ke layanan TTE
        $responseData = $httpTTE->signPDF($postData, $fileContent);

        // Proses respons sesuai kebutuhan Anda, misalnya menyimpan respons ke dalam database atau mengembalikannya sebagai respons HTTP

        return response()->json(['message' => 'TTE berhasil dilakukan', 'response' => $responseData]);
    }
}
