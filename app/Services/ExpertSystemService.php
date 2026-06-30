<?php

namespace App\Services;

use App\Models\Gejala;
use App\Models\Konsultasi;
use App\Models\TingkatStres;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExpertSystemService
{
    /**
     * CF Tunggal per gejala: CF[H,E] = CF_pakar x CF_user
     */
    public function hitungCFTunggal(float $cfPakar, float $cfUser): float
    {
        return round($cfPakar * $cfUser, 6);
    }

    /**
     * CF Combine iteratif untuk gabungan seluruh gejala:
     * CF_new = CF_old + CFn x (1 - CF_old)
     */
    public function hitungCFCombine(array $cfList): float
    {
        $cfList = array_values(array_filter($cfList, fn ($v) => $v > 0));

        if (empty($cfList)) {
            return 0;
        }

        $cfCombine = array_shift($cfList);

        foreach ($cfList as $cf) {
            $cfCombine = $cfCombine + $cf * (1 - $cfCombine);
        }

        return round($cfCombine, 6);
    }

    /**
     * Tentukan tingkat stres berdasarkan rentang CF dan jumlah gejala aktif.
     */
    public function tentukanTingkat(float $cfCombine, int $jumlahGejala, bool $isKritis = false): TingkatStres
    {
        if ($isKritis) {
            return TingkatStres::where('kode', 'S04')->firstOrFail();
        }

        $tingkat = TingkatStres::where('min_cf', '<=', $cfCombine)
            ->where('max_cf', '>=', $cfCombine)
            ->orderByDesc('min_cf')
            ->first();

        // Fallback safety net: kalau karena suatu sebab tidak ada tier yang cocok
        // (mis. data CF di luar 0-1), ambil tier dengan rentang CF terdekat.
        if (! $tingkat) {
            $tingkat = $cfCombine >= 0.5
                ? TingkatStres::orderByDesc('min_cf')->first()
                : TingkatStres::orderBy('min_cf')->first();
        }

        return $tingkat;
    }

    /**
     * Proses satu sesi konsultasi penuh: hitung CF, tentukan tingkat, simpan ke DB.
     *
     * @param  array  $jawaban  [gejala_id => cf_user]
     * @param  int|null  $userId  null jika guest
     * @param  array  $info  ['nama', 'jenis_kelamin', 'status_akademik']
     */
    public function proses(array $jawaban, ?int $userId = null, array $info = []): Konsultasi
    {
        $gejalaList = Gejala::active()->get()->keyBy('id');

        $cfHasilList = [];
        $detailData  = [];
        $isKritis    = false;

        foreach ($jawaban as $gejalaId => $cfUser) {
            $gejala = $gejalaList[$gejalaId] ?? null;

            if (! $gejala) {
                continue;
            }

            if ($gejala->isKritis() && (float) $cfUser > 0) {
                $isKritis = true;
            }

            $cfHasil = $this->hitungCFTunggal((float) $gejala->cf_pakar, (float) $cfUser);

            $cfHasilList[] = $cfHasil;
            $detailData[]  = [
                'gejala_id' => $gejalaId,
                'cf_user'   => $cfUser,
                'cf_hasil'  => $cfHasil,
            ];
        }

        $cfCombine   = $this->hitungCFCombine($cfHasilList);
        $cfPersen    = round($cfCombine * 100, 2);
        $jumlahAktif = count(array_filter($cfHasilList, fn ($v) => $v > 0));

        $tingkat = $this->tentukanTingkat($cfCombine, $jumlahAktif, $isKritis);

        $konsultasi = DB::transaction(function () use (
            $userId, $info, $cfCombine, $cfPersen, $tingkat, $isKritis, $detailData,
        ) {
            $k = Konsultasi::create([
                'user_id'          => $userId,
                'guest_token'      => $userId ? null : Str::random(40),
                'nama_responden'   => $info['nama'] ?? 'Anonim',
                'jenis_kelamin'    => $info['jenis_kelamin'] ?? 'L',
                'status_akademik'  => $info['status_akademik'] ?? null,
                'cf_combine'       => $cfCombine,
                'cf_persen'        => $cfPersen,
                'tingkat_stres_id' => $tingkat->id,
                'is_kritis'        => $isKritis,
                'ip_address'       => request()->ip(),
            ]);

            foreach ($detailData as $d) {
                $k->detailKonsultasi()->create($d);
            }

            return $k;
        });

        return $konsultasi->load('tingkatStres');
    }
}