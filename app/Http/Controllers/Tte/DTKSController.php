<?php

namespace App\Http\Controllers\Tte;

use App\Http\Controllers\Controller;
use App\Models\BSREData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use setasign\Fpdi\Tcpdf\Fpdi;

class CustomPDF extends Fpdi
{

    public function Header()
    {

    }

    public function Footer()
    {

        $this->SetY(-15);

        $this->Image(public_path('assets/img/Visualisasi_TTE_Dinsos/footer_tte_v2.png'), 0, null, 210, null);
    }

}

class DTKSController extends Controller
{
    public function index()
    {
        $getBSRE = BSREData::all();
        return view('tte.index-dtks', compact('getBSRE'));
    }

    public function update(Request $request)
    {
        try {
             // Penambahan kode untuk pengecekan akses ke Basic Authentication
             if (!$this->checkBasicAuthAccess()) {
                return response()->json(['error' => 'Akses ke Basic Authentication ditolak'], 403);
            }

            // Penambahan kode untuk pengecekan akses ke ESIGN_VERIFY_API
            if (!$this->checkESIGNAPIAccess()) {
                return response()->json(['error' => 'Akses ke ESIGN_VERIFY_API ditolak'], 403);
            }
            $files = [
                'file_keterangan_dtks_sudtks',
            ];

            $data = [];

            foreach ($files as $file) {
                if ($request->hasFile($file)) {
                    $path = $request->file($file);
                    if ($path !== null && $path->isValid()) {
                        $randomString = Str::random(10);
                        $extension = $path->getClientOriginalExtension();
                        $filename = $file . '_' . $randomString . '_' . time() . '.' . $extension;
                        $return = Storage::disk('local')->putFileAs('', $path, $filename);
                        if ($return !== false) {
                            $data[$file] = $filename;
                        } else {
                            throw new \Exception('Gagal menyimpan file ' . $filename);
                        }
                    } else {
                        throw new \Exception('File ' . $file . ' tidak valid atau tidak ditemukan');
                    }
                } else {
                    throw new \Exception('File ' . $file . ' tidak ditemukan dalam request');
                }
            }

            // Pengecekan apakah file berhasil di-attach
            if (!isset($data['file_keterangan_dtks_sudtks'])) {
                throw new \Exception('Gagal attach file ke PDF');
            }

            // Pengecekan tampilan 'visible'
            $tampilan = 'visible'; // Ganti dengan nilai yang sesuai jika perlu
            if ($tampilan !== 'visible') {
                throw new \Exception('Tampilan PDF harus visible');
            }

            // Pengecekan linkQR apakah sudah berhasil ditambahkan ke dalam PDF
            $linkQR = env('ESIGN_LINKQR'); // Ganti dengan nilai yang sesuai jika perlu
            if (!$linkQR) {
                throw new \Exception('Link QR belum berhasil ditambahkan ke dalam PDF');
            }

            // Pengecekan width dan height apakah sudah sesuai
            $width = 550; // Ganti dengan nilai yang sesuai jika perlu
            $height = 150; // Ganti dengan nilai yang sesuai jika perlu
            if ($width !== 550 || $height !== 150) {
                throw new \Exception('Width dan Height harus sesuai');
            }

            // Pengecekan apakah 'nik' terdaftar
            if (!env('ESIGN_NIK_KEPALA_BIDANG_DATA_INFORMASI')) {
                throw new \Exception('NIK tidak terdaftar');
            }

            // Pengecekan apakah 'passphrase' terdaftar
            if (!env('ESIGN_PASSPHRASE_KEPALA_BIDANG_DATA_INFORMASI')) {
                throw new \Exception('Passphrase tidak terdaftar');
            }

            // Pengecekan apakah 'tag_koordinat' sudah sesuai
            if (!env('ESIGN_TAG_KOORDINAT')) {
                throw new \Exception('Tag koordinat belum disetel');
            }

            $response = Http::withOptions(['verify' => false])
                ->withBasicAuth(env('ESIGN_USERNAME'), env('ESIGN_PASSWORD'))
                ->attach('file', file_get_contents(storage_path('app/' . $data['file_keterangan_dtks_sudtks'])), 'file_keterangan_dtks_sudtks.pdf')
                ->post(env('ESIGN_VERIFY_API') . '/api/sign/pdf', [
                    'nik' => env('ESIGN_NIK_KEPALA_BIDANG_DATA_INFORMASI'),
                    'passphrase' => env('ESIGN_PASSPHRASE_KEPALA_BIDANG_DATA_INFORMASI'),
                    'tampilan' => 'visible',
                    'linkQR' => env('ESIGN_LINKQR'),
                    'width' => 550,
                    'height' => 150,
                    'tag_koordinat' => env('ESIGN_TAG_KOORDINAT'),
                ]);

            $responseData = $response->json();
            // dd($response);

            if (isset($responseData['error'])) {
                $errorCode = isset($responseData['status_code']) ? $responseData['status_code'] : null;
                switch ($errorCode) {
                    case 2011:
                        $errorMessage = 'User tidak terdaftar';
                        break;
                    case 2031:
                        $errorMessage = 'Passphrase Anda salah';
                        break;
                    default:
                        $errorMessage = $responseData['error'];
                }
                return response()->json(['error' => $errorMessage], 400);
            }

            return response()->json(['message' => 'PDF berhasil ditandatangani'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Metode untuk memeriksa akses ke Basic Authentication
    private function checkBasicAuthAccess()
    {
        // Lakukan pengecekan akses ke Basic Authentication di sini
        // Anda bisa menggunakan alamat IP atau metode lain untuk melakukan pengecekan
        // Misalnya, jika menggunakan alamat IP localhost:8000, Anda bisa mengembalikan true secara default
        // Jika diperlukan, sesuaikan dengan logika pengecekan akses yang sesuai
        return true;
    }

    // Metode untuk memeriksa akses ke ESIGN_VERIFY_API
    private function checkESIGNAPIAccess()
    {
        // Lakukan pengecekan akses ke ESIGN_VERIFY_API di sini
        // Anda bisa menggunakan alamat IP atau metode lain untuk melakukan pengecekan
        // Misalnya, jika menggunakan alamat IP dan port tertentu, Anda bisa mengembalikan true secara default
        // Jika diperlukan, sesuaikan dengan logika pengecekan akses yang sesuai
        return true;
    }

}
