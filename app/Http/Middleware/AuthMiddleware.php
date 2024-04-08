<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            // Jika tidak, redirect pengguna ke halaman login atau respons dengan pesan kesalahan
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }
        // $request->attributes->add(['prefix' => 'dtks']);
        return $next($request);
    }
}
