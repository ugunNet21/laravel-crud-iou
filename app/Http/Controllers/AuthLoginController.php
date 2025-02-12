<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthLoginController extends Controller
{
    public function showLogin() {
        return view('auth.auth-login');
    }
    public function loginMasuk(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'CaptchaCode' => 'required'
        ]);

        $code = $request->input('CaptchaCode');
        $isHuman = captcha_validate($code);

        if (!$isHuman) {
            return back()->withErrors(['CaptchaCode' => 'Kode captcha tidak valid'])->withInput();
        }

        // Lanjutkan proses login
        if (auth()->attempt($request->only('email', 'password'))) {
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Kredensial tidak valid']);
    }
}
