<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $konsultasiTerakhir = $user->konsultasi()
            ->with('tingkatStres')
            ->latest()
            ->first();

        $totalKonsultasi = $user->konsultasi()->count();

        $notifBelumDibaca = $user->notifications()
            ->whereNull('read_at')
            ->where('status', 'sent')
            ->count();

        return view('user.dashboard', compact(
            'konsultasiTerakhir',
            'totalKonsultasi',
            'notifBelumDibaca',
        ));
    }
}