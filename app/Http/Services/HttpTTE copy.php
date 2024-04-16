<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
class HttpTTE
{
    protected $httpClient;

    public function __construct()
    {
        // Konfigurasi Guzzle untuk meloloskan SSL pada tahap pengembangan
        $guzzleConfig = [
            'verify' => false, // Meloloskan SSL
        ];

        // Membuat instance dari Guzzle Client
        $this->httpClient = new Client($guzzleConfig);
    }

    public function signPDF($postData, $fileContent): string
    {
        try {
            // URL untuk melakukan TTE
            $tteUrl = config('e-sign-bsre.url') . '/api/sign/pdf'; // Menggunakan URL dari konfigurasi

            // Mengirim permintaan HTTP untuk melakukan TTE
            // $response = $this->httpClient->post($tteUrl, [
            //     'json' => $postData,
            //     'body' => $fileContent,
            //     'headers' => [
            //         'Content-Type' => 'application/pdf',
            //         'Authorization' => 'Basic ' . base64_encode(config('e-sign-bsre.username') . ':' . config('e-sign-bsre.password')), // Menggunakan username dan password dari konfigurasi
            //     ],
            // ]);
            $response = Http::withOptions(['verify' => false]) // Matikan verifikasi SSL
                ->withBasicAuth(config('e-sign-bsre.username'), config('e-sign-bsre.password')) // Otentikasi Basic dengan username dan password
                ->post($tteUrl, [
                    'json' => $postData,
                    'body' => $fileContent,
                    'headers' => [
                        'Content-Type' => 'application/pdf',
                    ],
                ]);

            // Mendapatkan respons dari TTE
            $responseData = $response->getBody()->getContents();

            // Mengembalikan respons
            return $responseData;
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return $e->getMessage();
        }
    }
}
