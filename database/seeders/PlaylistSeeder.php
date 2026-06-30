<?php

namespace Database\Seeders;

use App\Models\Playlist;
use App\Models\TingkatStres;
use Illuminate\Database\Seeder;

class PlaylistSeeder extends Seeder
{
    /**
     * Sumber: BAB V - Playlist Lagu per tingkat stres
     * (Analisis Literatur Sistem Pakar Stres Mahasiswa)
     */
    public function run(): void
    {
        $playlist = [
            'S00' => [
                ['judul_lagu' => 'Bahagia', 'artis' => 'Andmesh Kamaleng', 'keterangan_terapeutik' => 'Lagu kebahagiaan sederhana yang membumi, cocok merayakan momen lulus'],
                ['judul_lagu' => 'Senyum', 'artis' => 'Sheila on 7', 'keterangan_terapeutik' => 'Energi positif dan ceria, membangkitkan rasa syukur'],
                ['judul_lagu' => 'Indah Pada Waktunya', 'artis' => 'Dewi Sandra', 'keterangan_terapeutik' => 'Mengingatkan bahwa setiap perjuangan ada hasilnya'],
                ['judul_lagu' => 'Happy', 'artis' => 'Pharrell Williams', 'keterangan_terapeutik' => 'Lagu internasional ikonik untuk merayakan kebahagiaan'],
                ['judul_lagu' => 'Good as Hell', 'artis' => 'Lizzo', 'keterangan_terapeutik' => 'Pesan self-love dan kepercayaan diri yang kuat'],
                ['judul_lagu' => 'Kamu Yang Ku Tunggu', 'artis' => 'The Overtunes', 'keterangan_terapeutik' => 'Mood positif dan ringan untuk memulai babak baru hidup'],
                ['judul_lagu' => 'Beautiful Day', 'artis' => 'U2', 'keterangan_terapeutik' => 'Anthem semangat dan optimisme yang membangkitkan energi'],
            ],
            'S01' => [
                ['judul_lagu' => 'Ruang Sendiri', 'artis' => 'Kunto Aji', 'keterangan_terapeutik' => 'Mengajak untuk jujur dengan perasaan dan memberi ruang pada diri sendiri'],
                ['judul_lagu' => 'Rehat', 'artis' => 'Kunto Aji', 'keterangan_terapeutik' => 'Izin untuk berhenti sejenak dan beristirahat - relevan pasca tekanan akademik'],
                ['judul_lagu' => 'Pulang', 'artis' => 'Pamungkas', 'keterangan_terapeutik' => 'Tenang dan reflektif, membawa ketenangan batin'],
                ['judul_lagu' => 'Nanti Kita Cerita', 'artis' => 'Fiersa Besari', 'keterangan_terapeutik' => 'Meyakinkan bahwa setiap perjuangan akan jadi cerita indah'],
                ['judul_lagu' => 'Weightless', 'artis' => 'Marconi Union', 'keterangan_terapeutik' => 'Terbukti secara ilmiah menurunkan kecemasan hingga 65%'],
                ['judul_lagu' => 'Better Together', 'artis' => 'Jack Johnson', 'keterangan_terapeutik' => 'Ringan dan menenangkan, cocok untuk relaksasi sore hari'],
                ['judul_lagu' => 'Here Comes the Sun', 'artis' => 'The Beatles', 'keterangan_terapeutik' => 'Lagu klasik yang memberi harapan bahwa masa sulit akan berlalu'],
                ['judul_lagu' => 'Satu Langkah', 'artis' => 'Yura Yunita', 'keterangan_terapeutik' => 'Motivasi untuk melangkah satu per satu tanpa terbebani'],
            ],
            'S02' => [
                ['judul_lagu' => 'Selamat Tinggal', 'artis' => 'Pamungkas', 'keterangan_terapeutik' => 'Pelepasan emosi secara sehat, katarsis melalui musik'],
                ['judul_lagu' => 'Tentang Rindu', 'artis' => 'Yovie Widianto', 'keterangan_terapeutik' => 'Validasi perasaan rindu dan lelah yang dipendam'],
                ['judul_lagu' => 'Kita Tidak Apa-Apa', 'artis' => 'Souqy', 'keterangan_terapeutik' => 'Meyakinkan bahwa merasa tidak baik-baik saja itu normal'],
                ['judul_lagu' => 'Berlayar', 'artis' => "Maliq & D'Essentials", 'keterangan_terapeutik' => 'Mendorong keberanian untuk terus maju meski berat'],
                ['judul_lagu' => 'Let Her Go', 'artis' => 'Passenger', 'keterangan_terapeutik' => 'Memproses rasa kehilangan dan penyesalan dengan bijak'],
                ['judul_lagu' => 'The Night Will Always Win', 'artis' => 'James Bay', 'keterangan_terapeutik' => 'Validasi bahwa perasaan berat itu nyata dan manusiawi'],
                ['judul_lagu' => 'Slow Down', 'artis' => 'Brandy', 'keterangan_terapeutik' => 'Pengingat untuk tidak terburu-buru dalam memulihkan diri'],
                ['judul_lagu' => 'Hujan dalam Komposisi', 'artis' => 'Efek Rumah Kaca', 'keterangan_terapeutik' => 'Musik meditatif Indonesia yang menenangkan pikiran'],
                ['judul_lagu' => 'Fix You', 'artis' => 'Coldplay', 'keterangan_terapeutik' => 'Harapan dan dukungan emosional melalui melodi yang mengalir'],
            ],
            'S03' => [
                ['judul_lagu' => 'Hanya Rindu', 'artis' => 'Andmesh Kamaleng', 'keterangan_terapeutik' => 'Memberi ruang untuk merindukan rasa nyaman dan aman dari masa kecil'],
                ['judul_lagu' => 'Tak Lagi Sama', 'artis' => 'Tulus', 'keterangan_terapeutik' => 'Validasi bahwa perubahan itu sulit dan perasaan kehilangan itu nyata'],
                ['judul_lagu' => 'Bertaut', 'artis' => 'Nadin Amizah', 'keterangan_terapeutik' => 'Eksplorasi emosi mendalam dengan lirik puitis yang terapeutik'],
                ['judul_lagu' => 'Lagu Untuk Jiwa', 'artis' => 'Mocca', 'keterangan_terapeutik' => 'Kelembutan dan kehangatan untuk jiwa yang sedang kelelahan'],
                ['judul_lagu' => 'Someone Like You', 'artis' => 'Adele', 'keterangan_terapeutik' => 'Katarsis emosional melalui suara yang kuat - melepas emosi terpendam'],
                ['judul_lagu' => 'The Sound of Silence', 'artis' => 'Simon & Garfunkel', 'keterangan_terapeutik' => 'Keheningan yang bermakna, validasi rasa kesepian yang mendalam'],
                ['judul_lagu' => 'Breathe (2 AM)', 'artis' => 'Anna Nalick', 'keterangan_terapeutik' => 'Pengingat sederhana namun kuat untuk bernapas dan bertahan'],
                ['judul_lagu' => 'Rise Up', 'artis' => 'Andra Day', 'keterangan_terapeutik' => 'Anthem kebangkitan dan kekuatan - untuk membangun harapan kembali'],
                ['judul_lagu' => 'You Are Not Alone', 'artis' => 'Michael Jackson', 'keterangan_terapeutik' => 'Pesan bahwa kamu tidak sendirian dalam perjuangan ini'],
                ['judul_lagu' => 'Miracle', 'artis' => 'Carole King', 'keterangan_terapeutik' => 'Harapan bahwa keajaiban dan kebaikan masih bisa datang'],
            ],
            // S04 (KRITIS) sengaja tidak diberi playlist - fokus pada hotline & rujukan darurat.
        ];

        foreach ($playlist as $kodeTingkat => $lagu) {
            $tingkat = TingkatStres::where('kode', $kodeTingkat)->first();

            if (! $tingkat) {
                continue;
            }

            foreach ($lagu as $index => $item) {
                Playlist::updateOrCreate(
                    [
                        'tingkat_stres_id' => $tingkat->id,
                        'judul_lagu' => $item['judul_lagu'],
                        'artis' => $item['artis'],
                    ],
                    [
                        'keterangan_terapeutik' => $item['keterangan_terapeutik'],
                        'spotify_url' => null,
                        'youtube_url' => null,
                        'cover_url' => null,
                        'urutan' => $index + 1,
                    ]
                );
            }
        }
    }
}