<?php

namespace App\Http\Controllers\Tte;

use App\Http\Controllers\Controller;
use App\Models\BSREData;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

class BSREController extends Controller
{
    public function index()
    {
        $getBSRE = BSREData::all();
        return view('tte.index', compact('getBSRE'));
    }
    public function sendDataToBSRE(Request $request)
    {
        // Validasi input
        $request->validate([
            'nik' => 'required|string',
            'passphrase' => 'required|string',
            'tampilan' => 'required|string',
            // 'page' => 'required|integer',
            // 'image' => 'required|boolean',
            'linkQR' => 'required|string',
            // 'xAxis' => 'required|integer',
            // 'yAxis' => 'required|integer',
            'width' => 'required|integer',
            'height' => 'required|integer',
            'file' => 'required|file|mimes:pdf',
            // 'imageTTD' => 'required|image|mimes:jpeg,png',
            'tag_koordinat' => 'nullable|string',
        ]);

        try{
            // Simpan file PDF ke penyimpanan lokal
        $pdfPath = $request->file('file')->store('pdfs');

        // Simpan gambar TTD ke penyimpanan lokal
        // $imageTTDPath = $request->file('imageTTD')->store('images');

        // Buat model BSREData dan simpan data
        $bsreData = BSREData::create([
            'nik' => $request->nik,
            'passphrase' => $request->passphrase,
            'tampilan' => $request->tampilan,
            // 'page' => $request->page,
            // 'image' => $request->image,
            'linkQR' => $request->linkQR,
            // 'xAxis' => $request->xAxis,
            // 'yAxis' => $request->yAxis,
            'width' => $request->width,
            'height' => $request->height,
            'pdf_path' => $pdfPath,
            // 'image_path' => $imageTTDPath,
            'tag_koordinat' => $request->tag_koordinat,
        ]);

        // Buat tanda tangan digital dari data
        $signature = $this->createDigitalSignature($request->all());

        // Kirim permintaan ke API BSRE
        $client = new Client(['verify' => false]);
        $response = $client->request('POST', 'https://esign-dev.layanan.go.id/api/sign/pdf', [
            'auth' => ['esign', 'wrjcgX6526A2dCYSAV6u'],
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => fopen(storage_path('app/' . $pdfPath), 'r'),
                    'filename' => 'document.pdf',
                    'headers' => ['Content-Type' => 'application/pdf'],
                ],
                // [
                //     'name' => 'imageTTD',
                //     'contents' => fopen(storage_path('app/' . $imageTTDPath), 'r'),
                //     'filename' => 'signature_image.jpg',
                //     'headers' => ['Content-Type' => 'image/jpeg'],
                // ],
                [
                    'name' => 'data',
                    'contents' => json_encode($request->all()),
                ],
                [
                    'name' => 'signature',
                    'contents' => $signature,
                ],
            ],
        ]);

        $idDokumen = $response->hasHeader('id_dokumen') ? $response->getHeader('id_dokumen')[0] : null;
        // Tanggapi respons dari API BSRE
        $responseData = json_decode($response->getBody(), true);
        $bsreData->id_dokumen = $idDokumen;
        $bsreData->save();

        // Lakukan sesuatu dengan respons, misalnya:
        return response()->json([
            'id_dokumen' => $idDokumen,
            'response' => $responseData
        ]);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);

        }
    }

    private function createDigitalSignature($data)
    {
        // Implementasikan logika untuk membuat tanda tangan digital sesuai dengan persyaratan BSRE
        // Misalnya, hash dari data menggunakan kunci rahasia
        $secretKey = 'secret_key'; // Ganti dengan kunci rahasia yang valid
        $dataString = json_encode($data);
        $signature = hash_hmac('sha256', $dataString, $secretKey);

        return $signature;
    }
    public function generatePDF($id)
    {
        // Ambil data BSREData berdasarkan ID
        $bsreData = BSREData::findOrFail($id);

        // Pastikan path file PDF dan path gambar tanda tangan digital tidak null
        if (is_null($bsreData->pdf_path) || is_null($bsreData->image_path)) {
            abort(404);
        }

        // Simpan path file PDF dan path gambar tanda tangan digital
        $pdfPath = storage_path('app/' . $bsreData->pdf_path);
        $imageTTDPath = storage_path('app/' . $bsreData->image_path);

        // Pastikan file PDF dan gambar tanda tangan digital tersedia
        if (!Storage::exists($pdfPath) || !Storage::exists($imageTTDPath)) {
            abort(404);
        }

        // Baca konten dari gambar tanda tangan digital
        $imageTTDContent = file_get_contents($imageTTDPath);

        // Gunakan library PDF Laravel untuk membuat dokumen PDF
        $pdf = PDF::loadView('tte.pdf', ['imageTTD' => $imageTTDContent]); // Sesuaikan dengan nama view Anda

        // Tambahkan tanda tangan digital ke dokumen PDF
        $pdf->getDomPDF()->getCanvas()->page_text(10, 10, $imageTTDContent, null, 8, array(0, 0, 0)); // Sesuaikan posisi tanda tangan

        // Simpan atau kirimkan file PDF ke browser
        return $pdf->download('bsre_document.pdf');
    }

}
