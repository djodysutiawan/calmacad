<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use App\Models\TingkatStres;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalKonsultasi = Konsultasi::count();
        $totalUser       = User::where('role', 'user')->count();
        $totalKritis     = Konsultasi::kritis()->count();
        $konsultasiHariIni = Konsultasi::whereDate('created_at', today())->count();

        $distribusiTingkat = TingkatStres::withCount('konsultasi')
            ->orderBy('urutan')
            ->get();

        $konsultasiTerbaru = Konsultasi::with(['user', 'tingkatStres'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalKonsultasi',
            'totalUser',
            'totalKritis',
            'konsultasiHariIni',
            'distribusiTingkat',
            'konsultasiTerbaru',
        ));
    }

    /**
     * Endpoint AJAX untuk chart dashboard.
     */
    public function statistik(): JsonResponse
    {
        $data = TingkatStres::withCount('konsultasi')
            ->orderBy('urutan')
            ->get(['nama', 'warna_hex'])
            ->map(fn ($t) => [
                'label' => $t->nama,
                'value' => $t->konsultasi_count,
                'color' => $t->warna_hex,
            ]);

        return response()->json($data);
    }
}