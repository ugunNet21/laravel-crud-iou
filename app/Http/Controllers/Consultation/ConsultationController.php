<?php

namespace App\Http\Controllers\Consultation;

use App\Http\Controllers\Controller;
use App\Mail\ConsultationConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ConsultationController extends Controller
{
    public function index()
    {
        $userData = [
            'userName' => 'Nama Pengguna',
            'consultationTime' => 'Waktu Konsultasi',
        ];
        return view('emails.index-consultation', $userData);
    }
    public function create(Request $request)
    {
        // Logika untuk membuat jadwal konsultasi
        $userName = 'ugun';
        $consultationTime = 'pengen kaya';

        // Kirim notifikasi ke email pengguna
        $userEmail = $request->user()->email;
        Mail::to($userEmail)->send(new ConsultationConfirmation($userName, $consultationTime));
        session()->flash('consultationSuccess', 'Jadwal konsultasi berhasil dibuat!');
        return redirect()->route('consultation');
    }
}
