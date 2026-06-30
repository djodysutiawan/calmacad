<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestConsultationOnce
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() && session()->has('guest_has_consulted')) {
            return redirect()->route('konsultasi.hasil.guest', [
                'token' => session('guest_token')
            ])->with('info', 'Kamu sudah pernah konsultasi sebagai tamu. Daftar untuk konsultasi lagi.');
        }
        return $next($request);
    }
}