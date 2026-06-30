<?php

namespace Database\Seeders;

use App\Models\Rekomendasi;
use App\Models\TingkatStres;
use Illuminate\Database\Seeder;

class RekomendasiSeeder extends Seeder
{
    /**
     * Sumber: BAB V - Rancangan Rekomendasi & Healing per tingkat stres
     * (Analisis Literatur Sistem Pakar Stres Mahasiswa)
     *
     * kategori: 'penanganan' | 'healing'
     */
    public function run(): void
    {
        $rekomendasi = [
            'S00' => [
                'penanganan' => [
                    'Pertahankan rutinitas tidur yang baik (7-8 jam per malam)',
                    'Lanjutkan aktivitas fisik dan olahraga ringan secara teratur',
                    'Jaga pola makan seimbang dan cukup minum air putih',
                    'Rayakan keberhasilan melewati ujian/skripsi bersama orang-orang terdekat',
                    'Mulai rencanakan langkah karir atau studi lanjut dengan pikiran yang jernih',
                ],
                'healing' => [
                    'Self-reward: belikan diri sendiri sesuatu yang selama ini ditunda',
                    'Tidur tanpa alarm selama 1-2 hari sebagai pemulihan',
                    'Reuni dengan teman-teman yang sudah lama tidak ditemui',
                    'Nikmati hobi yang sempat tertunda selama masa ujian',
                    'Bersyukur dan refleksi atas perjalanan akademik yang telah dilalui',
                ],
            ],
            'S01' => [
                'penanganan' => [
                    'Lakukan teknik pernapasan dalam (4-7-8 breathing) selama 10 menit setiap pagi dan malam',
                    'Olahraga ringan 30 menit per hari: jalan kaki, bersepeda, atau yoga ringan',
                    'Tulis jurnal harian selama 5-10 menit untuk mengungkapkan perasaan',
                    'Cerita dan berbagi perasaan kepada teman dekat atau keluarga yang dipercaya',
                    'Batasi konsumsi kafein dan screen time menjelang tidur',
                    'Ciptakan rutinitas tidur yang konsisten (waktu tidur dan bangun yang sama)',
                ],
                'healing' => [
                    'Berjalan-jalan di alam terbuka atau taman kota selama minimal 30 menit',
                    'Menonton film atau serial favorit sambil makan makanan yang disukai',
                    'Menelepon atau video call dengan orang tua, saudara, atau sahabat lama',
                    'Pijat ringan atau mandi air hangat untuk merelaksasi ketegangan otot',
                    'Memasak makanan baru atau mencoba resep yang selama ini ingin dicoba',
                    'Menghabiskan waktu bersama hewan peliharaan (jika ada) - terbukti menurunkan kortisol',
                ],
            ],
            'S02' => [
                'penanganan' => [
                    'Terapkan teknik relaksasi otot progresif (Progressive Muscle Relaxation) 15-20 menit sehari',
                    'Meditasi mindfulness terpandu menggunakan aplikasi seperti Headspace atau Calm selama 10-15 menit',
                    'Batasi konsumsi berita negatif dan media sosial (max 1 jam per hari)',
                    'Buat jadwal harian yang terstruktur namun fleksibel untuk mengembalikan rasa kontrol',
                    'Konsultasikan kondisi kepada konselor kampus atau psikolog untuk sesi 1-2 kali',
                    'Bergabung dengan komunitas atau kelompok dukungan sesama mahasiswa',
                    'Hindari isolasi sosial - pastikan ada interaksi dengan orang lain setiap hari',
                ],
                'healing' => [
                    'Liburan singkat ke tempat baru atau yang memiliki kenangan baik (1-3 hari)',
                    'Art therapy: menggambar, melukis, mewarnai, atau membuat kerajinan tangan',
                    'Journaling reflektif: tuliskan 3 hal yang disyukuri setiap malam sebelum tidur',
                    'Berolahraga dengan intensitas sedang: renang, bersepeda, atau jogging 3-4x seminggu',
                    'Spiritual: berdoa, meditasi, atau ibadah sesuai keyakinan masing-masing',
                    'Bergabung dengan kelas baru: memasak, musik, bahasa asing, atau olahraga bersama',
                ],
            ],
            'S03' => [
                'penanganan' => [
                    'SEGERA konsultasikan ke psikolog atau konselor kesehatan mental profesional',
                    'Hubungi layanan konseling kampus yang tersedia (biasanya gratis untuk mahasiswa)',
                    'Beritahu keluarga atau orang terdekat tentang kondisi yang sedang dialami',
                    'Hindari membuat keputusan besar (pindah kuliah, putuskan pacar, dll) saat sedang dalam kondisi ini',
                    'Jika perlu, minta cuti akademik untuk pemulihan total',
                    'Ikuti terapi kognitif-perilaku (CBT) jika direkomendasikan oleh profesional',
                    'Patuhi jadwal tidur ketat: 22.30 - 06.30, hindari begadang tanpa alasan',
                ],
                'healing' => [
                    'Nature therapy: habiskan waktu di alam (pantai, gunung, hutan) selama 2-3 hari',
                    'Digital detox: jauhkan smartphone selama 24-48 jam penuh',
                    'Terhubung kembali dengan keluarga inti - pulang ke rumah orang tua jika memungkinkan',
                    'Mulai journaling terstruktur dengan panduan terapis atau buku self-help',
                    'Bergabung dengan support group untuk mahasiswa yang mengalami tekanan serupa',
                    'Ekspresikan emosi melalui seni: menulis cerita, melukis, atau bermain musik',
                ],
            ],
            'S04' => [
                'penanganan' => [
                    'PERINGATAN: Jika muncul pikiran untuk menyakiti diri sendiri, segera hubungi bantuan profesional!',
                    'Hubungi segera: Into The Light Indonesia 119 ext 8 (Hotline Kesehatan Jiwa)',
                    'Hubungi Yayasan Pulih: (021) 788-42580',
                    'Datangi IGD Rumah Sakit terdekat atau minta diantar oleh orang terpercaya',
                    'Beritahu orang yang paling dipercaya tentang kondisi ini sekarang',
                    'Jangan sendirian - minta seseorang untuk menemanimu',
                    'Sistem ini bukan pengganti diagnosa dokter atau psikiater. Konsultasi profesional adalah langkah yang paling tepat dan paling penting.',
                ],
                'healing' => [],
            ],
        ];

        foreach ($rekomendasi as $kodeTingkat => $kategoriList) {
            $tingkat = TingkatStres::where('kode', $kodeTingkat)->first();

            if (! $tingkat) {
                continue;
            }

            foreach ($kategoriList as $kategori => $items) {
                foreach ($items as $index => $isi) {
                    Rekomendasi::updateOrCreate(
                        [
                            'tingkat_stres_id' => $tingkat->id,
                            'kategori' => $kategori,
                            'urutan' => $index + 1,
                        ],
                        [
                            'judul' => $isi,
                            'konten' => $isi,
                        ]
                    );
                }
            }
        }
    }
}