<?php

namespace Database\Seeders;

use App\Models\TingkatStres;
use Illuminate\Database\Seeder;

class TingkatStresSeeder extends Seeder
{
    /**
     * Sumber: BAB III - Definisi & Aturan Tingkat Stres
     * (Sintesis dari Jurnal 1, 5, 7 - Analisis Literatur Sistem Pakar Stres Mahasiswa)
     */
    public function run(): void
    {
        $data = [
            [
                'kode' => 'S00',
                'nama' => 'Normal / Tidak Stres',
                'definisi' => 'Kondisi psikologis stabil, mampu beradaptasi dengan baik.',
                'ciri_khas' => 'Mampu beristirahat normal, kembali bersemangat setelah ujian selesai.',
                'min_cf' => 0.0000,
                'max_cf' => 0.3000,
                'min_gejala' => 0,
                'max_gejala' => 1,
                'warna_hex' => '#22C55E',
                'icon' => 'mdi-emoticon-happy-outline',
                'urutan' => 1,
            ],
            [
                'kode' => 'S01',
                'nama' => 'Stres Ringan',
                'definisi' => 'Ada tekanan psikologis ringan, masih dapat berfungsi normal dalam kehidupan sehari-hari.',
                'ciri_khas' => 'Sedikit gelisah menunggu hasil, tidur agak terganggu, masih bisa beraktivitas normal.',
                'min_cf' => 0.3000,
                'max_cf' => 0.5500,
                'min_gejala' => 2,
                'max_gejala' => 4,
                'warna_hex' => '#84CC16',
                'icon' => 'mdi-emoticon-neutral-outline',
                'urutan' => 2,
            ],
            [
                'kode' => 'S02',
                'nama' => 'Stres Sedang',
                'definisi' => 'Tekanan psikologis cukup signifikan, mulai mengganggu fungsi sosial dan produktivitas.',
                'ciri_khas' => 'Sulit tidur, konsentrasi menurun, mudah marah, merasa bersalah berlebihan pasca sidang.',
                'min_cf' => 0.5500,
                'max_cf' => 0.8000,
                'min_gejala' => 5,
                'max_gejala' => 8,
                'warna_hex' => '#F59E0B',
                'icon' => 'mdi-emoticon-confused-outline',
                'urutan' => 3,
            ],
            [
                'kode' => 'S03',
                'nama' => 'Stres Berat',
                'definisi' => 'Tekanan psikologis berat, fungsi sosial dan akademik terganggu signifikan, risiko gangguan mental lebih lanjut.',
                'ciri_khas' => 'Tidak bisa keluar kamar, putus asa, pikiran negatif terus-menerus, fungsi sosial terganggu parah.',
                'min_cf' => 0.8000,
                'max_cf' => 1.0000,
                'min_gejala' => 9,
                'max_gejala' => 15,
                'warna_hex' => '#EF4444',
                'icon' => 'mdi-emoticon-sad-outline',
                'urutan' => 4,
            ],
            [
                'kode' => 'S04',
                'nama' => 'KRITIS',
                'definisi' => 'Terindikasi gangguan mental serius yang memerlukan intervensi profesional segera.',
                'ciri_khas' => 'Muncul pikiran tidak ingin hidup, hopelessness ekstrem - RUJUK SEGERA ke profesional.',
                'min_cf' => 0.0000,
                'max_cf' => 1.0000,
                'min_gejala' => 0,
                'max_gejala' => 25,
                'warna_hex' => '#991B1B',
                'icon' => 'mdi-alert-octagon',
                'urutan' => 5,
            ],
        ];

        foreach ($data as $row) {
            TingkatStres::updateOrCreate(['kode' => $row['kode']], $row);
        }
    }
}