<?php

namespace Database\Seeders;

use App\Models\Gejala;
use Illuminate\Database\Seeder;

class GejalaSeeder extends Seeder
{
    /**
     * Sumber: BAB II - 2.1 Tabel Gejala Sistem (Master Gejala)
     * Total 25 gejala hasil sintesis 8 jurnal (Analisis Literatur Sistem Pakar Stres Mahasiswa)
     */
    public function run(): void
    {
        $data = [
            ['kode' => 'G01', 'nama_gejala' => 'Sulit tidur atau insomnia setelah ujian/skripsi', 'kategori' => 'Fisik', 'cf_pakar' => 1.0, 'deskripsi' => 'Sangat kuat - muncul di banyak jurnal (J5, J7, J2)', 'urutan' => 1],
            ['kode' => 'G02', 'nama_gejala' => 'Merasa sangat lelah meskipun tidak banyak beraktivitas', 'kategori' => 'Fisik', 'cf_pakar' => 0.8, 'deskripsi' => 'Kelelahan pasca tekanan akademik (J1, J3, J6)', 'urutan' => 2],
            ['kode' => 'G03', 'nama_gejala' => 'Jantung berdebar-debar saat teringat ujian/sidang', 'kategori' => 'Fisik', 'cf_pakar' => 1.0, 'deskripsi' => 'Respons simpatik terhadap stresor akademik (J7, J5)', 'urutan' => 3],
            ['kode' => 'G04', 'nama_gejala' => 'Otot punggung/leher terasa tegang dan kaku', 'kategori' => 'Fisik', 'cf_pakar' => 0.8, 'deskripsi' => 'Ketegangan muskular akibat stres berkepanjangan (J5, J7)', 'urutan' => 4],
            ['kode' => 'G05', 'nama_gejala' => 'Sakit kepala berulang tanpa sebab fisik yang jelas', 'kategori' => 'Fisik', 'cf_pakar' => 0.8, 'deskripsi' => 'Tension headache akibat stres (J6, J4, J7)', 'urutan' => 5],
            ['kode' => 'G06', 'nama_gejala' => 'Perubahan nafsu makan (menurun drastis atau makan berlebihan)', 'kategori' => 'Fisik', 'cf_pakar' => 0.8, 'deskripsi' => 'Gangguan pola makan akibat stres emosional (J1, J2, J6)', 'urutan' => 6],
            ['kode' => 'G07', 'nama_gejala' => 'Merasakan mual atau tidak nyaman di perut', 'kategori' => 'Fisik', 'cf_pakar' => 0.6, 'deskripsi' => 'Manifestasi fisik stres pada sistem pencernaan (J6, J4)', 'urutan' => 7],
            ['kode' => 'G08', 'nama_gejala' => 'Keringat berlebihan atau tangan/kaki terasa dingin', 'kategori' => 'Fisik', 'cf_pakar' => 0.4, 'deskripsi' => 'Respons otonom ringan terhadap kecemasan (J7, J5)', 'urutan' => 8],
            ['kode' => 'G09', 'nama_gejala' => 'Merasa sedih, murung, atau mudah menangis tanpa alasan jelas', 'kategori' => 'Emosi', 'cf_pakar' => 1.0, 'deskripsi' => 'Afek depresi - gejala utama depresi (J1, J8, J3)', 'urutan' => 9],
            ['kode' => 'G10', 'nama_gejala' => 'Kehilangan minat pada kegiatan yang biasanya disukai', 'kategori' => 'Emosi', 'cf_pakar' => 1.0, 'deskripsi' => 'Anhedonia - tanda klinis depresi (J1, J2, J4)', 'urutan' => 10],
            ['kode' => 'G11', 'nama_gejala' => 'Mudah marah, emosional, atau sensitif berlebihan', 'kategori' => 'Emosi', 'cf_pakar' => 0.8, 'deskripsi' => 'Irritabilitas - gejala stres dan depresi (J1, J7, J8)', 'urutan' => 11],
            ['kode' => 'G12', 'nama_gejala' => 'Merasa cemas, gelisah, atau khawatir berlebihan', 'kategori' => 'Emosi', 'cf_pakar' => 0.6, 'deskripsi' => 'Gejala anxiety disorder (J3, J4, J6)', 'urutan' => 12],
            ['kode' => 'G13', 'nama_gejala' => 'Merasa tidak berharga, bersalah, atau kecewa pada diri sendiri', 'kategori' => 'Emosi', 'cf_pakar' => 0.8, 'deskripsi' => 'Low self-esteem pasca evaluasi akademik (J1, J8, J6)', 'urutan' => 13],
            ['kode' => 'G14', 'nama_gejala' => 'Merasa pesimis atau putus asa terhadap masa depan', 'kategori' => 'Emosi', 'cf_pakar' => 0.8, 'deskripsi' => 'Hopelessness - indikator depresi sedang-berat (J1, J8, J2)', 'urutan' => 14],
            ['kode' => 'G15', 'nama_gejala' => 'Merasa tidak mampu atau takut menghadapi ujian ulang/perbaikan', 'kategori' => 'Emosi', 'cf_pakar' => 0.8, 'deskripsi' => 'Fear of failure spesifik konteks akademik (J5, J7)', 'urutan' => 15],
            ['kode' => 'G16', 'nama_gejala' => 'Sulit berkonsentrasi atau mudah teralih saat belajar/bekerja', 'kategori' => 'Kognitif', 'cf_pakar' => 0.6, 'deskripsi' => 'Gangguan konsentrasi akibat beban pikiran (J1, J7, J5)', 'urutan' => 16],
            ['kode' => 'G17', 'nama_gejala' => 'Daya ingat menurun / mudah lupa hal-hal penting', 'kategori' => 'Kognitif', 'cf_pakar' => 1.0, 'deskripsi' => 'Memory impairment akibat stres berkepanjangan (J7, J3)', 'urutan' => 17],
            ['kode' => 'G18', 'nama_gejala' => 'Sulit mengambil keputusan sederhana', 'kategori' => 'Kognitif', 'cf_pakar' => 0.4, 'deskripsi' => 'Decisional impairment akibat kelelahan mental (J6, J8, J4)', 'urutan' => 18],
            ['kode' => 'G19', 'nama_gejala' => 'Pikiran kacau atau terus memikirkan hasil ujian/sidang', 'kategori' => 'Kognitif', 'cf_pakar' => 0.8, 'deskripsi' => 'Ruminasi kognitif pasca evaluasi akademik (J7, J5)', 'urutan' => 19],
            ['kode' => 'G20', 'nama_gejala' => 'Malas beraktivitas atau ingin mengurung diri sepanjang hari', 'kategori' => 'Perilaku', 'cf_pakar' => 0.8, 'deskripsi' => 'Penarikan diri (withdrawal) sosial (J7, J1)', 'urutan' => 20],
            ['kode' => 'G21', 'nama_gejala' => 'Kualitas dan produktivitas kerja/belajar menurun drastis', 'kategori' => 'Perilaku', 'cf_pakar' => 0.8, 'deskripsi' => 'Penurunan performa pasca tekanan akademik (J7, J5)', 'urutan' => 21],
            ['kode' => 'G22', 'nama_gejala' => 'Sering menunda pekerjaan atau tugas yang seharusnya dikerjakan', 'kategori' => 'Perilaku', 'cf_pakar' => 0.6, 'deskripsi' => 'Prokrastinasi sebagai coping disfungsional (J7, J5)', 'urutan' => 22],
            ['kode' => 'G23', 'nama_gejala' => 'Kesulitan menjalani aktivitas sosial yang biasa dilakukan', 'kategori' => 'Perilaku', 'cf_pakar' => 0.6, 'deskripsi' => 'Gangguan fungsi sosial (J1, J4)', 'urutan' => 23],
            ['kode' => 'G24', 'nama_gejala' => 'Konsumsi kafein, rokok, atau makanan tertentu meningkat sebagai pelarian', 'kategori' => 'Perilaku', 'cf_pakar' => 0.4, 'deskripsi' => 'Maladaptive coping behavior (J7, J4)', 'urutan' => 24],
            ['kode' => 'G25', 'nama_gejala' => 'Muncul pikiran untuk menyakiti diri sendiri atau tidak ingin hidup', 'kategori' => 'Kritis', 'cf_pakar' => 1.0, 'deskripsi' => 'RED FLAG - butuh penanganan segera (J1, J2, J6)', 'urutan' => 25],
        ];

        foreach ($data as $row) {
            $row['is_active'] = true;
            Gejala::updateOrCreate(['kode' => $row['kode']], $row);
        }
    }
}