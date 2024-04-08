<?php

namespace App\Http\Controllers\Tte;

use App\Http\Controllers\Controller;
use App\Models\BSREData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
                }
            }

            if (isset($data['file_keterangan_dtks_sudtks'])) {
                $filePath = str_replace(url('/'), '', $data['file_keterangan_dtks_sudtks']);
                $fileContent = Storage::disk('local')->get($filePath);
                Storage::disk('local')->put('file_keterangan_dtks_sudtks.pdf', $fileContent);
            }

            $response = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Authorization' => 'Basic ' . base64_encode(env('ESIGN_USERNAME') . ':' . env('ESIGN_PASSWORD')),
                    'Content-Type' => 'application/json',
                ])
                ->post(env('ESIGN_VERIFY_API') . '/api/sign/pdf', [
                    'json' => [
                        'nik' => env('ESIGN_NIK_KEPALA_BIDANG_DATA_INFORMASI'),
                        'passphrase' => env('ESIGN_PASSPHRASE_KEPALA_BIDANG_DATA_INFORMASI'),
                        'tampilan' => 'visible',
                        'linkQR' => env('ESIGN_LINKQR'),
                        'width' => 550,
                        'height' => 150,
                        'tag_koordinat' => env('ESIGN_TAG_KOORDINAT'),
                        'file' => $data['file_keterangan_dtks_sudtks'] ?? null,
                    ],
                ]);

            $responseData = json_decode($response->body(), true);

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

}
