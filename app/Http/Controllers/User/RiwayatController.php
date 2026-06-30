<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RiwayatController extends Controller
{
    public function index(): View
    {
        $riwayat = Auth::user()
            ->konsultasi()
            ->with('tingkatStres')
            ->latest()
            ->paginate(10);

        return view('user.riwayat.index', compact('riwayat'));
    }

    public function show(Konsultasi $konsultasi): View
    {
        abort_unless($konsultasi->user_id === Auth::id(), 403);

        $konsultasi->load([
            'tingkatStres.rekomendasi' => fn ($q) => $q->orderBy('urutan'),
            'tingkatStres.playlist'    => fn ($q) => $q->orderBy('urutan'),
            'detailKonsultasi.gejala',
        ]);

        // Susun gejala yang dipilih lengkap dengan nilai CF user dari detail_konsultasi.
        // Relasi gejala BUKAN many-to-many, jadi tidak ada pivot bawaan — ditempel manual.
        $gejalaTerpilih = $konsultasi->detailKonsultasi
            ->map(function ($detail) {
                $gejala = $detail->gejala;
                $gejala->cf_user_value = $detail->cf_user;
                return $gejala;
            });

        $rekomendasiList = $konsultasi->tingkatStres->rekomendasi;

        return view('user.riwayat.show', compact('konsultasi', 'gejalaTerpilih', 'rekomendasiList'));
    }
}