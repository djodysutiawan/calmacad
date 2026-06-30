<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use App\Models\Konsultasi;
use App\Services\ExpertSystemService;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ConsultationController extends Controller
{
    public function __construct(
        private ExpertSystemService $expertSystem,
        private NotificationService $notificationService,
    ) {}

    /**
     * Tampilkan form konsultasi (25 gejala aktif).
     * Guest yang sudah konsultasi 1x langsung diarahkan ke hasil mereka.
     */
    public function index(): RedirectResponse|View
    {
        if (!Auth::check() && session('guest_has_consulted')) {
            return redirect()->route('konsultasi.hasil.guest', session('guest_token'))
                ->with('info', 'Kamu sudah menggunakan jatah cek gratis.');
        }

        $gejala = Gejala::active()->ordered()->get();

        return view('consultation.index', compact('gejala'));
    }

    /**
     * Proses jawaban 25 gejala, hitung CF, simpan hasil.
     */
    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama'              => ['required', 'string', 'max:100'],
            'jenis_kelamin'     => ['required', 'in:L,P'],
            'status_akademik'   => ['nullable', 'string', 'max:100'],
            'jawaban'           => ['required', 'array'],
            'jawaban.*'         => ['required', 'numeric', 'in:0,0.4,0.6,0.8,1'],
        ]);

        $konsultasi = $this->expertSystem->proses(
            jawaban: $validated['jawaban'],
            userId: Auth::id(),
            info: [
                'nama'            => $validated['nama'],
                'jenis_kelamin'   => $validated['jenis_kelamin'],
                'status_akademik' => $validated['status_akademik'] ?? null,
            ],
        );

        // ── User login: jadwalkan reminder & cek kritis ──
        if (Auth::check()) {
            $this->notificationService->scheduleReminder(Auth::id(), $konsultasi->id);

            if ($konsultasi->is_kritis) {
                $this->notificationService->sendKritisAlert($konsultasi->id);
            }

            return redirect()
                ->route('user.riwayat.show', $konsultasi)
                ->with('success', 'Konsultasi berhasil disimpan.');
        }

        // ── Guest: tandai sudah konsultasi 1x, simpan token di session ──
        session([
            'guest_has_consulted' => true,
            'guest_token'         => $konsultasi->guest_token,
        ]);

        return redirect()->route('konsultasi.hasil.guest', $konsultasi->guest_token);
    }

    /**
     * Hasil untuk guest — diagnosa saja, tanpa rekomendasi.
     */
    public function hasilGuest(string $token): View
    {
        $konsultasi = Konsultasi::where('guest_token', $token)
            ->whereNull('user_id')
            ->with('tingkatStres')
            ->firstOrFail();

        return view('consultation.result-guest', compact('konsultasi'));
    }
}